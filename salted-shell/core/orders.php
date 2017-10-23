<?php


function create_order_from_user($order_submitter,$order_type,$goods_id,$delivery_fee,$purchase_amount,$single_cost,$offer){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    global $db_goods_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_status,remain FROM $db_goods_table WHERE goods_id='$goods_id'";
    $result = $link->query($sql);
    if($result){
        $info = mysqli_fetch_assoc($result);
        if($info['remain'] < $purchase_amount){
            die(generate_error_report("No enough goods"));
        }else if($info['goods_status'] != "available"){
            die(generate_error_report("This goods is not available"));
        }
    }else{
        die(generate_error_report("No such goods"));
    }
    $sql = "INSERT INTO $db_order_table (goods_id, order_type,order_submitter, delivery_fee, purchase_amount, single_cost, offer, order_status) 
            VALUE 
            ('$goods_id','$order_type','$order_submitter','$delivery_fee','$purchase_amount','$single_cost','$offer','waiting')";
    $result = $link->query($sql);
    $insert_id = $link->insert_id;
    $link->commit();
    if ($result){
        $link->close();
        return $insert_id;
    }else{
        die(generate_error_report($link->error));
    }
}
function create_order($session_key,$order_type,$goods_id,$delivery_fee,$purchase_amount,$single_cost,$offer){
    if($student_id = get_student_id_from_session_key($session_key)){
        $result = create_order_from_user($student_id,$order_type,$goods_id,$delivery_fee,$purchase_amount,$single_cost,$offer);
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
    $sql = "SELECT goods_id, order_submitter,purchase_amount,order_status from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['order_submitter'];
        $purchase_amount = $result['purchase_amount'];
        $order_status = $result['order_status'];
        if(($current == $user_id || $current == fetch_goods_owner($goods_id)) and $order_status!= 'finished'){
            $sql = "DELETE FROM $db_order_table WHERE order_id = '$order_id'";
            $result = $link->query($sql);
            $link->commit();
            $link->close();
            if($result){
                if ($order_status != 'waiting'){
                    increase_goods_remain($goods_id, $purchase_amount);
                }
                post_cancel_order();
                return json_encode(array(
                    "status" => "success"
                ));
            }else{
                return generate_error_report("Unknown database error at cancel_order_from_user");
            }
        }else{
            return generate_error_report("Access dined");
        }
    }else{
        return generate_error_report("No such order");
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
    $sql = "SELECT goods_id,purchase_amount,order_status FROM $db_order_table WHERE order_id='$order_id'";
    $result = $link->query($sql);
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        if($result['order_status']!="waiting")  die(generate_error_report("You cannot accept this order[Status = ".$result['order_status']."]"));
        $goods_id = $result['goods_id'];
        $purchase_amount = $result['purchase_amount'];
        $sql = "SELECT goods_owner,remain FROM $db_goods_table WHERE goods_id='$goods_id'";
        $result = $link->query($sql);
        if($result && $result->num_rows != 0){
            $result = mysqli_fetch_assoc($result);
            if("".$result['goods_owner'] == "".$user_id){
                if($result['remain'] < $purchase_amount){
                    $link->close();
                    die(generate_error_report("Not enouge goods"));
                }
                $sql = "UPDATE $db_order_table SET order_status='accepted' WHERE order_id='$order_id'";
                $result = $link->query($sql);
                $link->commit();
                if(!$result){
                    var_dump($link->error);
                    $link->close();
                    die(generate_error_report("Unknonw error"));
                }
                decrease_goods_remain($goods_id,$purchase_amount);
                $link->close();
                post_accept_order();
                $sms = new OrderSms;    $sms_status = $sms->accept_order($order_id);
                die(json_encode(array(
                    "status" => "success",
                    "order_id" => $order_id,
                    "order_status" => "accepted",
                    'sms_status'   => $sms_status,
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

function complete_order_from_user($student_id, $order_id){      // 卖方完成义务
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, order_status from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        if(fetch_goods_owner($goods_id) != $student_id){
            die(generate_error_report("This order is not yours"));
        }elseif($result['order_status'] == "waiting"){
            die(generate_error_report("You haven't accepted this order"));
        }elseif($result['order_status'] == "completed" || $result['order_status'] == "finished"){
            die(generate_error_report("This order had been completed already"));
        }elseif($result['order_status'] != "accepted"){
            die(generate_error_report("Bad status"));
        }
        $status = change_order_status($order_id, "completed");
        if(!$status)
            die(generate_error_report("Unknown error with database"));
        post_complete_order();
        $sms = new OrderSms;    $sms_status = $sms->complete_order($order_id);        
        return json_encode(array(
            "status" => "success",
            "order_id" => "$order_id",
            "order_status" => "completed",
            'sms_status'    =>  $sms_status,
        ));
    }else{
        die(generate_error_report("Unknown error as complete_order_from_use"));
    }
}

function finish_order_from_user($student_id, $order_id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT order_submitter,order_status from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result){
        $result = mysqli_fetch_assoc($result);
        $user_id  = $result['order_submitter'];
        if($user_id != $student_id){
            die(generate_error_report("This order is not yours"));
        }elseif($result['order_status'] == "waiting" || $result['order_status'] == "accepted"){
            die(generate_error_report("Seller haven't completed this order yet!"));
        }elseif($result['order_status'] == "finished") {
            die(generate_error_report("This order had been finished already"));
        }
        $status = change_order_status($order_id, "finished");
        if(!$status)
            die(generate_error_report("Unknown error with database at finish_order_from_user"));
        post_complete_order();
        $sms = new OrderSms;    $sms_status = $sms->finish_order($order_id);        
        return json_encode(array(
            "status" => "success",
            "order_id" => "$order_id",
            "order_status" => "finished",
            'sms_status'    =>  $sms_status,
        ));
    }else{
        die(generate_error_report("Database error at finish_order_from_user"));
    }
}

function change_order_status($order_id, $status){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "UPDATE  $db_order_table SET order_status='$status' WHERE order_id='$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result)
        return true;
    else
        return false;
}

function list_orders_from_user($user_id, $filters=array(),$page=1, $limit=10){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    global $db_goods_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT * from $db_goods_table RIGHT OUTER JOIN $db_order_table on $db_order_table"."."."goods_id=$db_goods_table"."."."goods_id";
    $filter_str = "";
    foreach($filters as $key=>$value){
        if($filter_str == "")
            $filter_str = " WHERE";
        else
            $filter_str." AND ";
        $filter_str = $filter_str." ".$key."='".$value."'";
    }
    $base = ($page-1)*$limit;
    $sql = $sql.$filter_str." ORDER BY order_id DESC";
    $sql = $sql." LIMIT $base, $limit";   
    $results = $link->query($sql);
    $return_var = array();
    $link->close();
    if($results){
        while($result = mysqli_fetch_assoc($results)){
            $result['goods_title'] = urldecode($result['goods_title']);
            $result['goods_img'] = urldecode($result['goods_img']);
            $result['goods_info'] = urldecode($result['goods_info']);
            $return_var[] = $result;        // append a new array at the end of this array
        }
        return $return_var;
    }else{
        var_dump($sql);
        die(generate_error_report("Database Error as list_order_from_user()"));
    }
}

function post_create_order(){

}
function post_cancel_order(){

}
function post_complete_order(){

}
function post_accept_order(){

}

function fetch_orders_total_pages($user_id, $filters=array(),$limit){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    global $db_goods_table;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT count(*) AS num from $db_goods_table RIGHT OUTER JOIN $db_order_table on $db_order_table"."."."goods_id=$db_goods_table"."."."goods_id";
    $filter_str = "";
    foreach($filters as $key=>$value){
        if($filter_str == "")
            $filter_str = " WHERE";
        else
            $filter_str." AND ";
        $filter_str = $filter_str." ".$key."='".$value."'";
    }
    $sql = $sql.$filter_str;
    $results = $link->query($sql);
    $count_res = mysqli_fetch_assoc($results);
    $count_res = $count_res['num'];

    $cal = ($count_res/$limit);
	$total = ((int)$cal < $cal) ? (int)$cal+1 : $cal;
    $link->close();
    return $total;
}
?>