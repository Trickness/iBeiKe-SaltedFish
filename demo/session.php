<?php
// session_id(login(user,pass));        // 设置当前会话的session
session_start();
var_dump(session_id());
if(isset($_GET['out'])){
    session_unset();
    session_destroy();
    session_id("");
}

if(isset($_POST['name'])&&isset($_POST['password'])){
    $_SESSION['id']=$_POST['name'];
    $_SESSION['pass']=$_POST['password'];
    
}

if(isset($_SESSION['id'])&&isset($_SESSION['pass'])){
    echo "登录成功！<br/>用户ID：".$_SESSION['id']."<br />用户密码：".$_SESSION['pass'];
    echo "<br />";
    echo "<a href='session.php?out=out'>注销session</a>";
}


?>
<form action="session.php"  method="post">
用户ID：
<input type="text" name="name" /><br/><br/>
密码：
<input type="password" name="password" /><br/><br />
<input type="submit" name="submit">
</form>