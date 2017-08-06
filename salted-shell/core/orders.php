<?php


function create_order_from_user($submit_user,$goods_id,$deliver_fee,$goods_count,$price_per_goods){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $SQL = "INSERT INTO $db_order_table (goods_id, user_id, deliver_fee, goods_count, price_per_goods, statys) VALUE ('$goods_id','$submit_user','$deliver_fee','$goods_count','$price_per_goods','waiting');";
    $result = $link->query($SQL);
    $insert_id = $link->insert_id;
    $link->commit();
    if ($result){
        return $insert_id;
    }else{
        return false;
    }
}
function create_order($session_key,$goods_id,$deliver_fee,$goods_count,$price_per_goods){
    if($student_id = get_student_id_from_session_key($session_key)){
        $result = create_order_from_user($student_id,$goods_id,$deliver_fee,$goods_count,$price_per_goods);
        if($result){
            post_create_order();
            return $result;
        }else{
            return false;
        }
    }else{
        return false;
    }
}


function cancel_order_($order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "DELETE FROM $db_order_table WHERE order_id = '$order_id'";
    $result = $link->query($sql);
    $link->commit();

    if($result) return $order_id;
    else        return false;
}
function cancel_order_from_user($current, $order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, user_id from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['user_id'];
        if($current == $user_id || $current == fetch_goods_submitter($goods_id)){
            $result = cancel_order_($order_id);
            post_cancel_order();
            return $result;
        }else{
            die (generate_error_report("Access dined"));
        }
    }else{
        die(generate_error_report("No such order"));
    }
}

function cancel_order($session_key,$order_id){
    $current = get_student_id_from_session_key($session_key);
    if(!$current){
        return false;
    }
    return cancel_order_from_user($current, $order_id);
}

function accept_order_from_user($user_id, $order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id FROm $db_order_table WHERE order_id='$order_id'";
    $result = $link->query($sql);
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $sql = "SELECT submitter FROM $db_goods_table WHERE goods_id='$'";
        $result = $link->query($sql);
        if($result && $result->num_rows != 0){
            if("".$result['submitter'] == "".$user_id){
                $sql = "UPDATE $db_order_table SET status='accepted' WHERE order_id='$order_id'";
                $result = $link->query($sql);
                $link->commit();
                if(!$result){
                    var_dump($link->error);
                    $link->close();
                    die(generate_error_report("Unknonw error"));
                }
                $link->close();
                post_accept_order();
                die(json_encode(array(
                    "status" => "success",
                    "order_id" => $order_id,
                    "order_status" => "accepted"
                )));
            }else{
                $link->close();
                die(generate_error_report("You have no access to accept this order"));
            }
        }else{
            die(generate_error_report("There's order but no goods??"));
        }
    }else{
        $link->close();
        die(generate_error_report("No such order"));
    }
}

function complete_order($session_key, $order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $current = get_student_id_from_session_key($session_key);
    if(!$current){
        return false;
    }
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, user_id from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['user_id'];
        if($current == $user_id || $current == fetch_goods_submitter($goods_id)){
            //complete_order_($order_id);
            $status = change_order_staus($order_id, "completed");
            if(!$status)
                die(generate_error_report("Unknown error with database"));
            post_complete_order();
            return true;
        }else{
            die (generate_error_report("Access dined"));
        }
    }
}

function change_order_staus($order_id, $status){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "UPDATE  $db_order_table SET status='$status' WHERE order_id='$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result)
        return true;
    else
        return false;
}

function post_create_order(){

}
function post_cancel_order(){

}
function post_complete_order(){

}
function post_accept_order(){

}
?>