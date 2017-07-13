<?php 
require_once "../config.php";
require_once "./utils.php";
require_once "./users.php";
require_once "./authorization.php";

// Users main
session_start();
if(isset($_GET['action'])){     // 有操作
    $action = $_GET['action'];
    if(get_student_id_from_session_key(session_id())){
        if($action == "logout"){    // 处理登出操作
            user_logout(session_id());
            session_unset();
            session_destroy();
        }else if($action = "fetch_self_info"){
            $result = fetch_self_info(session_id());
            echo json_decode(base64_decode($result));
        }
        if($debug_mod)
            echo "<br/><a href='api-v1.php'>返回</a>";
    }else{  // 未登陆
        if($action == "login"){     // 处理登陆操作
            if(isset($_POST['username']) && isset($_POST['password'])){
                $session_key = user_login($_POST['username'],$_POST['password']);
                echo $session_key;
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
}

?>