<?php 
require_once "../config.php";
require_once "utils.php";
require_once "users.php";
require_once "goods.php";
require_once "authorization.php";
require_once "orders.php";

session_start();
if(!isset($_GET['action'])) die(generate_error_report("No action! Please check document for usage"));
$action = $_GET["action"];
if($student_id = get_student_id_from_session_key(session_id())){    // 已登录
    if($action == "logout"){
        user_logout(session_id());
        echo json_encode(array(
            "status" => "success"
        ));
    }elseif($action == "update_self_info"){
        if(isset($_POST['info'])){
            $info = json_decode(fetch_info_from_user($student_id),true);
            $data = json_decode(urldecode($_POST['info']),true);
            if(isset($data['nickname'])){
                $info['nickname'] = $data['nickname'];
            }
            if(isset($data['dormitory'])){
                if(isset($data['dormitory']['access'])) $info['dormitory']['access'] = $data['dormitory']['access'];
                if(isset($data['dormitory']['dormitory_id'])){
                    if(isset($data['dormitory']['dormitory_id']['access'])) $info['dormitory']['dormitory_id']['access'] = $data['dormitory']['dormitory_id']['access'];
                    if(isset($data['dormitory']['dormitory_id']['value']))  $info['dormitory']['dormitory_id']['value']  = $data['dormitory']['dormitory_id']['value'] ;
                }
                if(isset($data['dormitory']['room_no'])){
                    if(isset($data['dormitory']['room_no']['access'])) $info['dormitory']['room_no']['access'] = $data['dormitory']['room_no']['access'];
                    if(isset($data['dormitory']['room_no']['value']))  $info['dormitory']['room_no']['value']  = $data['dormitory']['room_no']['value'] ;
                }
                if(isset($data['phone_number'])){
                    if(isset($data['phone_number']['access']))          $info['phone_number']['access'] = $data['phone_number']['access'];
                    if(isset($data['phone_number']['value']))           $info['phone_number']['value']  = $data['phone_number']['value'];
                }
                $info_hash = update_user_info(json_encode($info),$student_id);
                echo json_encode(array(
                    "status" => "success",
                    "info_hash" => $info_hash
                ));
            }
        }else{
            die(generate_error_report("Please check doc for usage"));
        }
    }elseif($action == "cancel_order"){
        if(!isset($_GET['order_id']))
            die(generate_error_report("Please check doc for usage"));
        die(cancel_order_from_user($student_id, $_GET['order_id']));
    }elseif($action == "login") {
        echo json_encode(array(
            "status" => "success",
            "session" => session_id()
        ));
    }elseif($action == "change_password"){
        if(isset($_GET['original_pass']) && isset($_GET['new_pass'])){
            $original_pass = filter_password($_GET['original_pass']);
            $new_pass = filter_password($_GET['new_pass']);
            if(check_pass($student_id,$original_pass)){
                if(change_password($student_id,$new_pass)){
                    echo json_encode(array(
                        "status" => "success"
                    ));
                    // todos: remove all session connected to this account
                }else{
                    die("Error occured?");
                }
            }else{
                die("Wrong password");
            }
        }else{
            die(generate_error_report("Please use GET to specify original_pass and new_pass"));
        }
    }elseif($action == "submit_goods"){     // Todo: 输入检查注意
        $json_data = $_POST['goods_info'];
        die(submit_goods_from_id($json_data, $student_id));
    }elseif($action == "new_order"){
        if(!isset(
                $_GET['goods_id'],
                $_GET['order_type'],
                $_GET['delivery_fee'],
                $_GET['purchase_amount'],
                $_GET['single_cost'],
                $_GET['offer']
            )){die("Please check code for usage");}
        $goods_id = $_GET['goods_id'];
        $order_type = $_GET['order_type'];
        $delivery_fee = $_GET['delivery_fee'];
        $purchase_amount = $_GET['purchase_amount'];
        $single_cost = $_GET['single_cost'];
        $offer = $_GET['offer'];
        $order_id = create_order_from_user($student_id, $order_type, $goods_id, $delivery_fee, $purchase_amount, $single_cost, $offer);
        if($order_id){
            echo json_encode(array(
                "status" => "success",
                "order_id" => $order_id
            ));
        }else{
            echo json_encode(array(
                "status" => "failed"
            ));
        }
    }elseif($action == "accept_order"){
        if(!isset($_GET['order_id'])){
            die(generate_error_report("Please check doc for usage"));
        }
        accept_order_from_user($student_id, intval($_GET['order_id']));
    }elseif($action == "complete_order"){
        if(!isset($_GET['order_id'])){
            die(generate_error_report("Please check doc for usage"));
        }
        die(complete_order_from_user($student_id, intval($_GET['order_id'])));
    }elseif($action == "finish_order"){
        if(!isset($_GET['order_id'])){
            die(generate_error_report("Please check doc for usage"));
        }
        die(finish_order_from_user($student_id, intval($_GET['order_id'])));
    }elseif($action == "list_orders"){
        $filter = array();
        $limit = 10;
        $page = 1;
        if(isset($_GET['order_status']))
            $filter['order_status'] = urlencode($_GET['order_status']);        // Todo: 输入检查注意
        if(isset($_GET['limit']))
            $limit = intval($_GET['limit']);
        if(isset($_GET['page']))
            $page = intval($_GET['page']);
        die(list_orders_from_user($student_id, $filter, $page, $limit));
    }elseif($action == "fetch_self_info"){
        $return_var = fetch_info_from_user($student_id);
        if($return_var){
            die(json_encode(array(
                "status" => "success",
                "self_info" => json_decode($return_var)
            )));
        }else{
            die(generate_error_report("Unknown error in fetch_info_from_user"));
        }
    }elseif($action == "fetch_user_info"){
        if(!isset($_GET['user_id']))
            die(generate_error_report("Please specify user id as user_id=xxx in url"));
        $return_var = fetch_info_from_user($student_id);
        if($return_var){
            die(json_encode(array(
                "status" => "success",
                "user_info" => json_decode($return_var)
            )));
        }else{
            die(generate_error_report("Unknown error in fetch user info"));
        }
    }
}else{                                              // 未登录
    if($action == "login"){                             // 登陆操作
        $session_key = false;
        if(isset($_GET['username']) and isset($_GET['password']))
            $session_key = user_login($_GET['username'],$_GET['password']);
        elseif(isset($_POST['username']) and isset($_POST['password']))
            $session_key = user_login($_GET['username'],$_GET['password']);
        if($session_key){
            session_unset();
            session_destroy();
            session_id($session_key);
            session_start();
            echo json_encode(array(
                "status" => "success",
                "session" => $session_key
            ));
        }else{
            echo generate_error_report("Wrong username or password");
        }
    }elseif($action == "check"){                     // 检查用户是否为学生 TODO:检验
        if(isset($_GET["student_id"]) and isset($_GET["password"]))
            echo json_encode(confirm_student($_GET["student_id"],$_GET["password"]));
        else
            die(generate_error_report("Please specify student id and password"));
    }elseif($action == "signup"){
        if(isset($_GET['student_id']) and isset($_GET['password'])){
            $session = user_bind($_GET['student_id'],$_GET['password']);
            if($session_key){
                session_unset();
                session_destroy();
                session_id($session_key);
                session_start();
                echo json_encode(array(
                    "status" => "success",
                    "session" => $session_key
                ));
            }else{
                echo generate_error_report("Wrong username or password");
            }
        }else{
            die(generate_error_report("Please specify id and password"));
        }
    }else{
        die(generate_error_report("Cannot handle your action(Try to login for more actions?)"));
    }
}
?>