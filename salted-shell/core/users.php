<?php
//require_once "../config.php";
/*require_once "./utils.php";
require_once "./authorization.php";*/

/**
 *
 * 将论坛账号与学生信息绑定在一起：
 *      - 通过利用学生账号密码登陆本科教学网，获得基本信息来绑定
 *      - 验证成功即注册绑定
 *
 * @param
 *      - (@String) original_un     源论坛用户名  (未使用)
 *      - (@String) original_pw     源论坛密码   （未使用）
 *      - (@String) student_id      学号
 *      - (@String) student_pw      学号绑定的密码
 *
 * @return
 *      - (@String) session_key     会话密钥，作为后面所有操作的唯一凭证
 *
 **/
function user_bind($student_id,$student_pw,$original_un='',$original_pw=''){
    $student_info = confirm_student($student_id,$student_pw);
    if($student_info == false)
        return false;
    // $bbs_info = confirm_bbs($original_un, $original_pw);
    // if($bbs_info == false)
    //     return false;
    $result = user_create($student_id,$student_pw,json_encode($student_info));
    if(!$result)
        return false;
    $session_key = user_login($student_id,$student_pw);
    return $session_key;
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
    global $db_users_table;
	$pass_salt = getRandom(8);
	$student_id = (int)$student_id;
	$password = md5(md5($password).$pass_salt);
    $student_info = urlencode($student_info);
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "INSERT INTO $db_users_table(student_id,student_pass,pass_salt,student_info) VALUES ('$student_id','$password','$pass_salt','$student_info')";
    $query = mysqli_query($link,$sql);
    $link->close();
    if ($query)
    {
        return true;
    }else{
        return false;
    }
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
function check_pass($username,$password){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    $username = (int)$username;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $select = "SELECT * from $db_users_table WHERE student_id = '$username'";
    $query = mysqli_query($link,$select);
    $res = mysqli_fetch_assoc($query) or die(generate_error_report("No such user"));
    $pass_salt = $res['pass_salt'];
    $password = md5(md5($password).$pass_salt);
    if($password == $res['student_pass']){
        return true;
    }else{
        return false;
    }
}
function user_login($username,$password){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    global $db_session_table;
    $username = (int)$username;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $select = "SELECT * from $db_users_table WHERE student_id = '$username'";
    $query = mysqli_query($link,$select);
    $res = mysqli_fetch_assoc($query) or die(generate_error_report("No such user"));
    $pass_salt = $res['pass_salt'];
    $password = md5(md5($password).$pass_salt);
    if ($password==$res['student_pass']) {
        $session_key = getRandom(32);
        $insert = "insert into $db_session_table (session_key, student_id)values ('$session_key','$username')";
        $link->query($insert);
        $link->commit();
        $link->close();
        return $session_key;
    }
    $link->close();
    return false;
}
/**
 * 
 * 用户登出
 * 
 * @param
 *      - (@String) session_key
 * 
 **/
function user_logout($session_key)
{
    filter_session_key($session_key);
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_session_table;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $delete = "DELETE from $db_session_table WHERE session_key = '$session_key'";
    $link->query($delete);
    $link->commit();
    $link->close();
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
 function fetch_info_from_user($id){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $select = "SELECT student_info from $db_users_table WHERE student_id = '$id'";
    $result = $link->query($select);
    $res = mysqli_fetch_assoc($result) or die("Cannot fetch info for userid=".$id);
    $student_info = json_decode(urldecode($res['student_info']),true);
    if(isset($student_info['header']))  $student_info['header'] = urldecode($student_info['header']);
    $link->close();
    return $student_info;
 }
function fetch_self_info($session_key){
    if($student_id = get_student_id_from_session_key($session_key)){
        return fetch_info_from_user($student_id);
    }else{
        return null;
    }
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
 *      - (@JSONStr) user_info / false  若session_key不存在则返回false
 * 
 **/
function fetch_user_info($session_key,$target_id)
{
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    $flag = "public";
    if ($student_id = get_student_id_from_session_key($session_key)){
        if($student_id == $target_id )
            $falg = "private";
        else
            $flag = "protected";
    }
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $select_1 = "SELECT * from $db_users_table WHERE student_id = '$target_id'";
    $result_1 = $link->query($select_1);
    if(!$result_1)  die(generate_error_report("Unknown error at fetch_user_info [").$link->error);
    $res_1 = mysqli_fetch_assoc($result_1) or die(generate_error_report("No such user"));
    $student_info = json_decode(urldecode($res_1['student_info']),true);
    $student_info['header'] = urldecode($student_info['header']);
    $student_info = recursion_remove_sensitive_info($student_info,$flag);
    $link->close();
    return $student_info;
}

// private test function
// Todo: delete?
function fetch_user_info_from_id($student_id)
{
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
    if ($student_id){
        $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
        $select_1 = "SELECT * from $db_users_table WHERE student_id = '$student_id'";
        $result_1 = $link->query($select_1);
        $res_1 = mysqli_fetch_assoc($result_1) or die(generate_error_report("No such user"));
        $student_info = json_decode(urldecode($res_1['student_info']),true);
        $student_info['header'] = urldecode($student_info['header']);        
        $link->close();
        return $student_info;
    }   
    else return false;
}
/**
 * 
 * 更新自己的信息
 * 
 * @param
 *      - (@JSONStr)    updated_user_info
 * 
 * @return
 *         -> true/false
 *
 **/
function update_user_info($updated_user_info,$student_id)
{
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $info_hash = md5($updated_user_info);
    $updated_user_info = urlencode($updated_user_info); 
    $update = "UPDATE $db_users_table SET student_info='$updated_user_info',info_hash='$info_hash' WHERE student_id = '$student_id';";
    $result = $link->query($update);
    if(!$result){
        die(generate_error_report("Database error at update user info [".$link->error));
    }
    $link->commit();
    $link->close();
    return $info_hash;
}

function change_password($student_id, $new_password){
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $sql = "SELECT pass_salt FROM $db_users_table WHERE student_id='$student_id'";
    $result = $link->query($sql);
    $salt = (mysqli_fetch_assoc($result));
    $salt = $salt['pass_salt'];
    $new_pass = md5(md5($new_password).$salt);
    $sql = "UPDATE $db_users_table SET student_pass='$new_pass' WHERE student_id='$student_id'";
    $link->query($sql);
    $link->commit();
    return true;
} 

function recursion_remove_sensitive_info($dic,$flag){
    foreach($dic as $key => $value){
        if(is_array($value))    $dic[$key] = recursion_remove_sensitive_info($value,$flag);
        if($key == "access" and isset($dic['value'])){
            if($flag == "public"    and $dic['access'] != 'public')     $dic['value'] = "********";
            if($flag == "protected" and $dic['access'] == "private")    $dic['value'] = "********";
        }
    }
    return $dic;
}


?>
