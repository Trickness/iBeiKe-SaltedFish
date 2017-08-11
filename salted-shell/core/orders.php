<?php


function create_order_from_user($submit_user,$goods_id,$deliver_fee,$goods_count,$price_per_goods){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    global $db_goods_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT count FROM $db_goods_table WHERE goods_id='$goods_id'";
    $result = $link->query($sql);
    if($result){
        if(mysqli_fetch_assoc($result)['count'] < $goods_count){
            die(generate_error_report("No enough goods"));
        }
    }else{
        die(generate_error_report("No such goods"));
    }
    $sql = "INSERT INTO $db_order_table (goods_id, submit_user, deliver_fee, goods_count, price_per_goods, status) VALUE ('$goods_id','$submit_user','$deliver_fee','$goods_count','$price_per_goods','waiting')";
    $result = $link->query($sql);
    $insert_id = $link->insert_id;
    $link->commit();
    $link->close();
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
    $sql = "SELECT goods_id, submit_user,goods_count from $db_order_table where order_id = '$order_id'";
    var_dump($sql);
    $result = $link->query($sql);
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $user_id  = $result['user_id'];
        $goods_count = $result['goods_count'];
        if($current == $user_id || $current == fetch_goods_submitter($goods_id)){
            $sql = "DELETE FROM $db_order_table WHERE order_id = '$order_id'";
            $result = $link->query($sql);
            $link->commit();
            $link->close();
            if($result){
                increase_goods_count($goods_id, $goods_count);
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
    $sql = "SELECT goods_id,goods_count FROM $db_order_table WHERE order_id='$order_id'";
    $result = $link->query($sql);
    if($result && $result->num_rows != 0){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        $goods_count = $result['goods_count'];
        $sql = "SELECT submitter,count FROM $db_goods_table WHERE goods_id='$goods_id'";
        $result = $link->query($sql);
        if($result && $result->num_rows != 0){
            $result = mysqli_fetch_assoc($result);
            if("".$result['submitter'] == "".$user_id){
                if($result['count'] < $goods_count){
                    $link->close();
                    die(generate_error_report("Not enouge goods"));
                }
                $sql = "UPDATE $db_order_table SET status='accepted' WHERE order_id='$order_id'";
                $result = $link->query($sql);
                $link->commit();
                if(!$result){
                    var_dump($link->error);
                    $link->close();
                    die(generate_error_report("Unknonw error"));
                }
                decrease_goods_count($goods_id,$goods_count);
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

function complete_order_from_user($student_id, $order_id){      // 卖方完成义务
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;
    
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT goods_id, status from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result){
        $result = mysqli_fetch_assoc($result);
        $goods_id = $result['goods_id'];
        if(fetch_goods_submitter($goods_id) != $student_id){
            die(generate_error_report("This order is not yours"));
        }elseif($result['status'] == "waiting"){
            die(generate_error_report("You haven't accepted this order"));
        }elseif($result['status'] == "completed" || $result['status'] == "finished"){
            die(generate_error_report("This order had been completed already"));
        }
        $status = change_order_staus($order_id, "completed");
        if(!$status)
            die(generate_error_report("Unknown error with database"));
        post_complete_order();
        return json_encode(array(
            "status" => "success",
            "order_id" => "$order_id",
            "order_status" => "completed"
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
    $sql = "SELECT submit_user,status from $db_order_table where order_id = '$order_id'";
    $result = $link->query($sql);
    $link->close();
    if($result){
        $result = mysqli_fetch_assoc($result);
        $user_id  = $result['submit_user'];
        if($user_id != $student_id){
            die(generate_error_report("This order is not yours"));
        }elseif($result['status'] == "waiting" || $result['status'] == "accepted"){
            die(generate_error_report("Seller haven't completed this order yet!"));
        }elseif($result['status'] == "finished") {
            die(generate_error_report("This order had been finished already"));
        }
        $status = change_order_staus($order_id, "finished");
        if(!$status)
            die(generate_error_report("Unknown error with database"));
        post_complete_order();
        return json_encode(array(
            "status" => "success",
            "order_id" => "$order_id",
            "order_status" => "finished"
        ));
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

function list_orders_from_user($user_id, $filters=[],$page=1, $limit=10){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_order_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT * from $db_order_table";
    $filter_str = "";
    foreach($filters as $key=>$value){
        if($filter_str == "")
            $filter_str = " WHERE";
        else
            $filter_str." AND ";
        $filter_str = $filter_str." ".$key."='".$value."'";
    }
    $filter_str = $filter_str." AND";
    if($filter_str == "")
        $filter_str = " WHERE";
    $base = ($page-1)*$limit;
    $sql = $sql.$filter_str;
    $sql = $sql." submit_user='$user_id'";
    $sql = $sql." LIMIT $base, $limit";   
    $results = $link->query($sql);
    $return_var = array(
        "status" => "success",
        "orders" => array()
    );
    $link->close();
    if($results){
        while($result = mysqli_fetch_assoc($results))
            $return_var["orders"][] = $result;        // append a new array at the end of this array
        $return_var['count'] = count($return_var['orders']);
        return json_encode($return_var);
    }else{
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
?>