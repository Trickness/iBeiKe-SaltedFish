<?php 
require_once "../config.php";
require_once "utils.php";
require_once "users.php";
require_once "goods.php";
require_once "authorization.php";
require_once "orders.php";

// Users main
/*session_start();
if(isset($_GET['action'])){     // 有操作
    $action = $_GET['action'];
    if(get_student_id_from_session_key(session_id())){
        if($action == "logout"){    // 处理登出操作
            user_logout(session_id());
            session_unset();
            session_destroy();
        }else if($action = "fetch_self_info"){
            $result = fetch_self_info(session_id());
            var_dump(json_decode(base64_decode($result)));
        }
        if($debug_mod)
            echo "<br/><a href='api-v1.php'>返回</a>";
    }else{  // 未登陆
        if($action == "login"){     // 处理登陆操作
            if(isset($_POST['username']) && isset($_POST['password'])){
                $session_key = user_login($_POST['username'],$_POST['password']);
                if($session_key){
                    session_unset();
                    session_destroy();
                    session_id($session_key);
                    session_start();
                    if($debug_mod)
                        echo "<p>登陆成功</p>";
                }else{
                    if($debug_mod)
                        echo "<p>登陆失败</p>";
                    // 返回错误
                }
                if($debug_mod){
                    echo "<a href='api-v1.php'>返回</p>";
                }
            }
        }else{
            // TODOs: 改改改
            echo "未登录"; 
        }
    }
}else{      // 无操作时
    echo "<p>Session : ".session_id()."</p>";
    if(!get_student_id_from_session_key(session_id())){      // 如果没有session_id
        echo '<form action="api-v1.php?action=login"  method="post">
                用户ID：
                <input type="text" name="username" /><br/><br/>
                密码：
                <input type="password" name="password" /><br/><br />
                <input name="submit" type="submit" value="登陆">
                </form>';
    }
    if(get_student_id_from_session_key(session_id())){
        echo "<p>已登陆</p>";
        echo "<a href='api-v1.php?action=logout'>           登出</a><br/>";
        echo "<a href='api-v1.php?action=fetch_self_info'>  获取自己信息</a><br/>";
    }else{
        echo "<p>未登录</p>";
    }
}*/
/*
session_start();
if (isset($_GET['action']))
{
    $action =$_GET['action'];
    if ($action=="check")
    {
        if (isset($_GET['id'],$_GET['psw'])) {
            $usrname = $_GET['id'];
            $usrpsw  = $_GET['psw'];
            echo json_encode(confirm_student($usrname,$usrpsw));
        }else{
            echo false;
        }
    }
    elseif ($action=="signin")
    {
        if (isset($_GET['id'],$_GET['psw'])) {
            $usrname = $_GET['id'];
            $usrpsw  = $_GET['psw'];
            echo json_encode(user_bind(0,0,$usrname,$usrpsw));
        }else{
            echo false;
        }
    }
    elseif ($action=="change")
    {
        if (isset($_GET['student_id'],
                  $_GET['name'],
                  $_GET['nickname'],
                  $_GET['header'],
                  $_GET['department'],
                  $_GET['enroolment'],
                  $_GET['class_no'],
                  $_GET['dormitory_id'],
                  $_GET['room_no'],
                  $_GET['phone_number'],
                  $_GET['session_key']
            )) {
                $student_id = $_GET['student_id'];
                $name = $_GET['name'];
                $nickname=$_GET['nickname'];
                $header=$_GET['header'];
                $department=$_GET['department'];
                $enroolment=$_GET['enroolment'];
                $class_no=$_GET['class_no'];
                $dormitory_id=$_GET['dormitory_id'];
                $room_no=$_GET['room_no'];
                $phone_number=$_GET['phone_number'];
                $session_key=$_GET['session_key'];
                $ret = array();
                $ret['student_id'] = array(
                    "access"=>  "protected",
                    "value" =>  $student_id
                );
                $ret['name'] = array(
                    "access"=>  "public",
                    "value" =>  $name
                );
                $ret['nickname']    = $nickname;
                $ret['header']      = $header;
                $ret['class_info']  = array(
                    "access"    =>  "protected",
                    "department"=> array(
                        "access"    => "protected",
                        "value"     => $department
                    ),
                    "enrollment"=> array(
                        "access"    => "public",
                        "value"     => $enroolment
                    ),
                    "class_no"  => array(
                        "access"    => "private",
                        "value"     => $class_no
                    )
                );
                $ret['dormitory'] = array(
                    "access"    => "protected",
                    "dormitory_id"  => array(
                        "access"        => "protected",
                        "value"         => $dormitory_id
                    ),
                    "room_no"       => array(
                        "access"        => "private",
                        "value"         => $room_no
                    ) 
                );
                $ret['phone_number'] = array(
                    "access"    => "private",
                    "value"     => $phone_number
                );
                $ret = json_encode($ret);
                echo update_self_info($ret,$session_key);
        }
    }elseif ($action == "login") {
        if (isset($_POST['username'])&&isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            if (user_login($username,$password)) {
                $session_key = user_login($username,$password);
                session_unset();
                session_destroy();
                session_id($session_key);
                session_start();
                $student_id = get_student_id_from_session_key($session_key);
                $_SESSION['student_id'] = $student_id;
                echo $session_key;
            }else echo false;
        }else{
            echo false;
        }
    }elseif ($action == "logout") {
        session_unset();
        session_destroy();
    }elseif ($action == "new_order"){
        $session = session_id();
        if(get_student_id_from_session_key($session)){  // logined in
            if(!isset(
                    $_GET['goods_id'],
                    $_GET['deliver_fee'],
                    $_GET['goods_count'],
                    $_GET['price_per_goods']
                )){die("Please check code for usage");}
            $goods_id = $_GET['goods_id'];
            $deliver_fee = $_GET['deliver_fee'];
            $goods_count = $_GET['goods_count'];
            $price_per_goods = $_GET['price_per_goods'];
            $order_id = create_order($session, $goods_id, $deliver_fee, $goods_count, $price_per_goods);
            if($order_id){
                $result = array(
                    "status" => "success",
                    "order_id" => $order_id
                );
                echo json_encode($result);
            }else{
                $result = array(
                    "status" => "failed"
                );
                echo json_encode($result);
            }

        }else{
            die("Access diend");
        }
    }
}
//$usrname = $_GET['id'];
//$usrpsw  = $_GET['psw'];
//var_dump(confirm_student("41603510","314159"));*/

session_start();
if(!isset($_GET['action'])) die('{"status":"failed","error":"Please check doc for usage"}');
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
            var_dump($info);
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
    }elseif($action == "new_order"){
        if(!isset(
                $_GET['goods_id'],
                $_GET['deliver_fee'],
                $_GET['goods_count'],
                $_GET['price_per_goods']
            )){die("Please check code for usage");}
        $goods_id = $_GET['goods_id'];
        $deliver_fee = $_GET['deliver_fee'];
        $goods_count = $_GET['goods_count'];
        $price_per_goods = $_GET['price_per_goods'];
        $order_id = create_order_from_user($student_id, $goods_id, $deliver_fee, $goods_count, $price_per_goods);
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
    }elseif($action == "cancel_order"){
        if(!isset($_GET['order_id']))
            die(generate_error_report("Please check doc for usage"));
        $order_id = cancel_order_from_user($student_id, $_GET['order_id']);
        echo json_encode(array(
            "status" =>"success",
            "order_id" => $order_id
        ));
    }else{
        die(generate_error_report("Please check doc for usage"));
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
    }else{
        die(generate_error_report("Cannot handle your action(Try to login for more actions?)"));
    }

}
?>