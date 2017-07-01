<?php 
require_once "../config.php";
require_once "utils.php";
require_once "users.php";
require_once "authorization.php";

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
if (isset($_GET['action']))
{
    $action =$_GET['action'];
    if ($action=="check")
    {
        $usrname = $_GET['id'];
        $usrpsw  = $_GET['psw'];
        echo json_encode(confirm_student($usrname,$usrpsw));
    }
    else if ($action=="signin")
    {
        $usrname = $_GET['id'];
        $usrpsw  = $_GET['psw'];
        echo json_encode(user_bind(0,0,$usrname,$usrpsw));
    }
    else if ($action=="change")
    {
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
}
//$usrname = $_GET['id'];
//$usrpsw  = $_GET['psw'];
//var_dump(confirm_student("41603510","314159"));
?>