<?php
require_once "../config.php";
require_once "./utils.php";
require_once "./authorization.php";

function msg_count($student_id){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_message_table;
    global $db_users_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT * from $db_message_table WHERE recver_id='$student_id' and has_read='0'";
    $results = $link->query($sql);

    if ($results){
        $result_arr = array();
        while($result = mysqli_fetch_assoc($results)){
            $sender_id = $result['sender_id'];
            if(!isset($result_arr[$sender_id])){
                $result_arr[$sender_id] = array();
                $result_arr[$sender_id]['msg_list'] = array();

                $select_1 = "SELECT * from $db_users_table WHERE student_id = '$sender_id'";
                $result_1 = $link->query($select_1);
                if(!$result_1)  die(generate_error_report("Unknown error at fetch_user_info [").$link->error);
                $res_1 = mysqli_fetch_assoc($result_1) or die(generate_error_report("No such user"));
                $student_info = json_decode(urldecode($res_1['student_info']),true);

                $result_arr[$sender_id]['peer_nickname'] = $student_info['nickname'];
                $result_arr[$sender_id]['peer_header'] = urldecode($student_info['header']);
            }
            $item = array();
            
            $item['msg_content'] = base64_decode($result['msg_content']);
            $item['sender'] = urldecode($result['sender_id']);
            $item['datetime'] = urldecode($result['msg_datetime']);

            $result_arr[$sender_id]['msg_list'][] = $item;
            $result_arr[$sender_id]['count'] = sizeof($result_arr[$sender_id]['msg_list']);
        }
        return $result_arr;
    }else{
        $link->close();
        die(generate_error_report($link->error));
    }
}

function new_msg($sender, $recver, $content){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_message_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "INSERT INTO $db_message_table (msg_content,sender_id, recver_id) VALUE ('$content', '$sender', '$recver')";
//    $sql = "SELECT * FROM $db_message_table";
    $result = $link->query($sql);

    $insert_id = $link->insert_id;

    $link->commit();
    if ($result){
        $link->close();
        return true;
    }else{
        $link->close();
        die(generate_error_report($link->error));
    }

}

function fetch_msg($peer_id, $recver_id, $limit=30){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_message_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT * FROM $db_message_table WHERE sender_id IN ('$peer_id','$recver_id') and recver_id IN ('$peer_id','$recver_id');";
    $results = $link->query($sql);
    $link->commit();

    if ($results){
        $result_arr = array();
        while($result = mysqli_fetch_assoc($results)){
            $item['msg_content'] = utf8_encode(base64_decode($result['msg_content']));
            $item['sender'] = urldecode($result['sender_id']);
            $item['datetime'] = urldecode($result['msg_datetime']);

            //  设置成已读
            if($result['has_read'] == 0 && $result['recver_id'] == $recver_id){
                $msg_id = $result['msg_id'];
                $sql = "UPDATE $db_message_table SET has_read='1' WHERE msg_id='$msg_id'";
                $link->query($sql);
                $link->commit();
            }

            $result_arr[] = $item;        // append a new array at the end of this array
        }
        $return_var = array();
        $return_var['count'] = sizeof($result_arr);
        $return_var['msg'] = $result_arr;
        $return_var['peer_id'] = $peer_id;
        $return_var['status'] = "success";
        $link->close();
        return $return_var;
    }else{
        $link->close();
        die(generate_error_report($link->error));
    }
}

?>