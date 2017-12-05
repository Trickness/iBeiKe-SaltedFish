<?php
require_once "../config.php";
require_once "utils.php";
require_once "users.php";
require_once "goods.php";
require_once "authorization.php";
require_once 'sms.php';
require_once "orders.php";

// TODO: intval($goods_id)

session_start();
if(!isset($_GET['action'])) die(generate_error_report("No action! Please check document for usage"));
$action = $_GET["action"];
$student_id = "";
if($student_id = get_student_id_from_session_key(session_id())){    // 已登录
    if($action == "logout"){
        user_logout(session_id());
        die(json_encode(array(
            "status" => "success"
        )));
    }elseif($action == "update_self_info"){
        if(isset($_POST['info'])){
            $info = fetch_info_from_user($student_id);
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
            }
            if(isset($data['class_info']) and isset($data['class_info']['department'])){
                if(isset($data['class_info']['department']['access'])) $info['class_info']['department']['access'] = $data['class_info']['department']['access'];
                if(isset($data['class_info']['department']['value']))  $info['class_info']['department']['value'] = $data['class_info']['department']['value'];
                if(isset($data['class_info']['enrollment']) and isset($data['class_info']['enrollment']['access'])) $info['class_info']['enrollment']['access'] = $data['class_info']['enrollment']['access'];
                if(isset($data['class_info']['class_no']) and isset($data['class_info']['class_no']['access'])) $info['class_info']['class_no']['access'] = $data['class_info']['class_no']['access'];

            }
            if(isset($data['student_id']) and isset($data['student_id']['access'])) $info['student_id']['access'] = $data['student_id']['access'];
            if(isset($data['name']) and isset($data['name']['access']))  $info['name']['access'] = $data['name']['access'];
            if(isset($data['gender']) and isset($data['gender']['access'])) $info['gender']['access'] = $data['gender']['access'];
            if(isset($data['birthday']) and isset($data['birthday']['access'])) $info['birthday']['access'] = $data['birthday']['access'];
            if(isset($data['header']))  $info['header'] = urlencode($data['header']);
            // 合法性检测
            $info_hash = update_user_info(json_encode($info),$student_id);
            die(json_encode(array(
                "status" => "success",
                "info_hash" => $info_hash
            )));
        }else{
            die(generate_error_report("Please check doc for usage"));
        }
    }elseif($action == "cancel_order"){
        if(!isset($_GET['order_id']))
            die(generate_error_report("Please check doc for usage"));
        die(cancel_order_from_user($student_id, $_GET['order_id']));
    }elseif($action == "login") {
        die(json_encode(array(
            "status" => "success",
            "session" => session_id()
        )));
    }elseif($action == "change_password"){
        if(isset($_POST['original_pass']) && isset($_POST['new_pass'])){
            $original_pass = filter_password($_POST['original_pass']);
            $new_pass = filter_password($_POST['new_pass']);
            if(check_pass($student_id,$original_pass)){
                if(change_password($student_id,$new_pass)){
                    die(json_encode(array(
                        "status" => "success"
                    )));
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
            )){die(generate_error_report("Please check code for usage"));}
        $goods_id = $_GET['goods_id'];
        $order_type = $_GET['order_type'];
        if($order_type == 'rent'){
            if(!isset($_GET['rent_duration']))  die(generate_error_report("No duration specified!"));
            $rent_duration = intval($_GET['rent_duration']);
        }else{
            $rent_duration = 0;
        }
        $delivery_fee = floatval($_GET['delivery_fee']);
        $purchase_amount = intval($_GET['purchase_amount']);
        $single_cost = floatval($_GET['single_cost']);
        $offer = floatval($_GET['offer']);
        $order_id = create_order_from_user($student_id, $order_type, $rent_duration, $goods_id, $delivery_fee, $purchase_amount, $single_cost, $offer);
        if($order_id){
            // $sms = new OrderSms;    $sms_status = $sms->create_order($order_id);
            die(json_encode(array(
                "status" => "success",
                "order_id" => $order_id,
            )));
        }else{
            die(json_encode(array(
                "status" => "failed"
            )));
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
        if(isset($_GET['order_submitter'])){
            if ($_GET['order_submitter'] == 'self'){
                $filter['order_submitter'] = $student_id;
            }else if($_GET['order_submitter'] == 'other'){
                $filter['goods_owner'] = $student_id;
            }else if($_GET['order_submitter'] == 'both'){
                $filter['goods_owner'] = "$student_id' or goods_owner='$student_id";
            }else{
                die(generate_error_report("Please specify order submitter [self or other]"));
            }
        }else{
            die(generate_error_report("Please specify order submitter [self or other]"));
        }
        $results = list_orders_from_user($student_id, $filter, $page, $limit);
        $count = count($results);
        die(json_encode(array(
            "status" => "success",
            "orders" => $results,
            "count" => $count,
            'total' => fetch_orders_total_pages($student_id, $filter,$limit),
        )));
    }elseif($action == "fetch_self_info"){
        $return_var = fetch_info_from_user($student_id);
        if($return_var){
            die(json_encode(array(
                "status" => "success",
                "self_info" => $return_var
            )));
        }else{
            die(generate_error_report("Access denied or no such user"));
        }
    }elseif($action == "fetch_user_info"){
        if(!isset($_GET['user_id']))
            die(generate_error_report("Please specify user id as user_id=xxx in url"));
        $return_var = fetch_info_from_user($student_id);
        $return_var = recursion_remove_sensitive_info($return_var,"protected");
        if($return_var){
            die(json_encode(array(
                "status" => "success",
                "user_info" => $return_var
            )));
        }else{
            die(generate_error_report("Unknown error in fetch user info"));
        }
    }elseif($action == "revoke_goods"){
        if(!isset($_GET['goods_id'])){
            die(generate_error_report("Please specify goods_id"));
        }
        if(revoke_goods(intval($_GET['goods_id']),$student_id)){
            die(json_encode(array(
                "status" => "success"
            )));
        }
    }elseif($action == "edit_goods"){
        
    }elseif($action == "fetch_user_goods") {
        $user_id = $student_id;    $page = 1;  $amount=8;   $goods = null;
        if (isset($_GET['page'])) $page = $_GET['page'];
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            $goods = fetch_goods_for_sale_from_user($user_id,$page,$amount);
        }else{
            $goods = fetch_all_goods_from_user($user_id,$page,$amount);
        }
        die(json_encode(array(
            'status'    =>  'success',
            'goods'     =>  $goods,
            'total'     =>  fetch_total_pages($student_id,$amount),
        )));
    }elseif($action == "update_goods_info"){
        if(isset($_POST['goods_info'])){
            die(update_goods_info($_POST['goods_info'],$student_id));
        }
    }elseif ($action == 'check') {
        die(json_encode(array(
            'status'    =>  'failed',
            'error'     =>  'you have logged in',
        )));
    }
}else{                                              // 未登录
    if($action == "login"){                             // 登陆操作
        $session_key = false;
        if(isset($_POST['username']) and isset($_POST['password']))
            $session_key = user_login($_POST['username'],$_POST['password']);
        if($session_key){
            session_unset();
            session_destroy();
            session_id($session_key);
            session_start();
            die(json_encode(array(
                "status" => "success",
                "session" => $session_key
            )));
        }else{
            die(generate_error_report("Wrong username or password"));
        }
    }elseif($action == "check"){                     // 检查用户是否为学生 TODO:检验
        if(isset($_POST["student_id"]) and isset($_POST["password"])){
            $info = confirm_student($_POST["student_id"],$_POST["password"]);
            if ($info == false) {
                die(json_encode(array(
                    'status'        =>  'failed',
                    'error'         =>  'Wrong username or password',
                )));
            }else{
                die(json_encode(array(
                    'status'        =>  'success',
                    'student_info'  =>  $info,
                )));
            }
        }else die(generate_error_report("Please specify student id and password"));
    }elseif($action == "signup"){
        if(isset($_POST['student_id']) and isset($_POST['password']) and isset($_POST['student_info']) and isset($_POST['new_password'])){
            $session_key = user_bind($_POST['student_id'],$_POST['password']);
            if($session_key){
                session_unset();
                session_destroy();
                session_id($session_key);
                session_start();
                $info_hash = update_user_info(json_encode($_POST['student_info']),$_POST['student_id']);
                $change_result = change_password($_POST['student_id'],$_POST['new_password']);
                if ($change_result == true) {
                    die(json_encode(array(
                        "status" => "success",
                        "session" => $session_key,
                        'info_hash'=>$info_hash,
                    )));
                }else {
                    die(json_encode(array(
                        "status" => "failed",
                        'error'  => 'failed to reset password',
                        "session" => $session_key,
                        'info_hash'=>$info_hash,
                    )));
                }
            }else{
                die(generate_error_report("Wrong username or password"));
            }
        }else{
            die(generate_error_report("Please specify id and password"));
        }
    }elseif($action == "reset"){
        if(isset($_POST['id']) and isset($_POST['password'])){
            if(confirm_student(strval($_GET['id']),strval($_POST['password']))){
                if(change_password(strval($_GET['id']),strval($_POST['password']))){
                    die(json_encode(array(
                        "status" => "success"
                    )));
                }
            }
        }
    }elseif($action == 'fetch_phone_captcha'){
        if (isset($_GET['phone_number'])) {
            $sms = new Captcha;
            die(json_encode($sms->phone_captcha($_GET['phone_number'])));
        }else {
            die(json_encode(array(
                'status'   =>  'failed',
                'error'    =>  'no phone_number',
            )));
        }
    }elseif ($action == 'forget_password') {
        if(isset($_POST['student_id']) and isset($_POST['password']) and isset($_POST['new_password'])){
            if(confirm_student(strval($_POST['student_id']),strval($_POST['password']))){
                if(change_password(strval($_POST['student_id']),strval($_POST['new_password']))){
                    die(json_encode(array(
                        "status" => "success",
                    )));
                }
            }
        }
    }
}
// 这个名字是不是有点太随意了？
if($action == "fetch_user_total_info"){
    $current_id = get_student_id_from_session_key(session_id());    
    $user_id = 0;
    if(!isset($_GET['user_id'])){
        if(!$current_id)
            die(generate_error_report("No user id specified!"));
        else
            $user_id = $current_id;
    }else{
        $user_id = intval($_GET['user_id']);        
    }
    
    $goods = fetch_goods_for_sale_from_user($user_id);
    $filter = array(
        'order_submitter' => $user_id
    );
    $orders = list_orders_from_user($user_id);
    $info = fetch_user_info_from_id($user_id);
    $flag = "public";
    if($current_id){
        if($current_id == $user_id)
            $flag = "private";
        else
            $flag = "protected";
    }else{
        $flag = "public";
    }
    $info = recursion_remove_sensitive_info($info,$flag);

    die(json_encode(array(
        "target_id" => $user_id,
        "status" => "success",
        "goods" => $goods,
        "orders" => $orders,
        "info" => $info
    )));
}elseif ($action == 'search_goods_by_title') {
    if (isset($_GET['goods_title'])) {
        $page = 1;  $amount = 12;
        if (isset($_GET['page'])) $page = $_GET['page'];
        die(search_goods_by_title($_GET['goods_title'],$page,$amount));
    }
}elseif ($action == 'search_goods_by_category') {
    if (isset($_GET['category'],$_GET['level'])) {
        $page = 1;  $amount = 12;
        if (isset($_GET['page'])) $page = $_GET['page'];
        die(search_goods_by_category($_GET['category'],$_GET['level'],$page,$amount));
    }
}
?>
