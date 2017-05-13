<?php
require "../config.php";
require "./utils.php";

/**
 *
 * 将论坛账号与学生信息绑定在一起：
 *      - 通过利用学生账号密码登陆本科教学网，获得基本信息来绑定
 *      - 验证成功即绑定
 *
 * @param
 *      - (@String) original_un     源论坛用户名 
 *      - (@String) original_pw     源论坛密码
 *      - (@String) student_id      学号
 *      - (@String) student_pw      学号绑定的密码
 *
 * @return
 *      - (@String) session_key     会话密钥，作为后面所有操作的唯一凭证
 *
 **/
function user_bind($original_un,$original_pw,$students_id,$student_pw){

}



/**
 * 
 * 创建用户
 * 
 * 
 * 
 * @return
 *      -> true/false
 * 
 * 
 **/

function user_create($student_id,$password,$student_info){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
	$pass_salt = getRandom(8);
	$student_id = (int)$student_id;
	$password = md5(md5($password).$pass_salt);
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
<<<<<<< HEAD
	$sql = "INSERT INTO salted_fish_user(student_id,student_pass,pass_salt,student_info) VALUES ('$student_id','$password','$pass_salt','$student_info')";
	//var_dump($sql);
	//$link->query($sql);
    //var_dump($link->error);
	//$link->commit();
    if (mysqli_query($link,$sql))
    {
    var_dump($link->error);
    return true;
    }
    else return false;
=======
	$sql = "INSERT INTO salted_fish_user(student_id,student_pass,pass_salt) VALUES ('$student_id','$password','$pass_salt')";
	$link->query($sql);
	$link->commit();
>>>>>>> origin/master
}
/**
 * 
 * 登陆到咸鱼站
 *
 * @param
 *      - 账号和密码（待定)
 * 
 * @return
 *      - (@String) session_key 是咸鱼站操作的唯一 key  用于用户的各种操作时的认证
 *                                  十天后自动失效
 *
 **/
function user_login($username,$password){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    $username = (int)$username;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $select = "SELECT * from $db_users_table WHERE student_id = '$username'";
    $query = mysqli_query($link,$select);
    $res = mysqli_fetch_assoc($query);
    $pass_salt = $res['pass_salt'];
    $password = md5(md5($password).$pass_salt);
    if ($password==$res['student_pass']) {
        $session_key = getRandom(32);
        $insert = "insert into sessions values ('$session_key','$username')";
        $link->query($insert);
        $link->commit();
        return $session_key;
    }
}

/**
 * 
 * 用户登出
 * 
 * @param
 *      - (@String) session_key
 * 
 **/
function user_logout($session_key){

}


/**
 * 
 * 获得自己的信息
 * 
 * @param
 *      - (@String) session_key
 *
 * @return
 *      - (@JSONStr) user_info
 * 
 **/
function fetch_self_info($session_key){

}


/**
 * 
 * 获得他人的信息
 * 
 * @param
 *      - (@String) session_key
 *      - (@String) student_id
 *
 * @return
 *      - (@JSONStr) user_info
 * 
 **/
function fetch_user_info($session_id,$student_id){

}



/**
 * 
 * 更新自己的信息
 * 
 * @param
 *      - (@String) session_key
 * 
 * @return
 *      - (@JSONStr) updated_user_info
 *
 **/
function update_self_info($session_key){
    
}


?>
