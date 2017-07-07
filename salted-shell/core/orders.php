<?php


function create_order_from_user($submit_user,$goods_id,$deliver_fee,$goods_count,$price_per_goods){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $SQL = "INSERT INTO $db_order_table (goods_id, user_id, deliver_fee, goods_count, price_per_goods) VALUE ('$goods_id','$submit_user','$deliver_fee','$goods_count','$price_per_goods');";
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
    if($student_id = get_student_from_session_key($session_key)){
        return create_order($student_id,$goods_id,$deliver_fee,$goods_count,$price_per_goods);
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

    if($result) return true;
    else        return false;
}
function cancel_order($session_key,$order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $current = get_student_from_session_key($session_key);
    if(!$current){
        return false;
    }
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, user_id from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    if($result){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['user_id'];
        if($current == $user_id || $current == fetch_goods_submitter($goods_id)){
            cancel_order_($order_id);
            return true;
        }else{
            die ("Access dined");
        }
    }
}

function complete_order_($order_id){

}
function complete_order($session_key, $order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $current = get_student_from_session_key($session_key);
    if(!$current){
        return false;
    }
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, user_id from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    if($result){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['user_id'];
        if($current == $user_id || $current == fetch_goods_submitter($goods_id)){
            complete_order_($order_id);
            return true;
        }else{
            die ("Access dined");
        }
    }
}
?>