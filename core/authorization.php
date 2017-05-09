<?php
require "../config.php";
require "./utils.php";


/**
 * 
 * 获取学生的id（单独列出来是因为这个函数会非常常用）
 * 
 * @param
 *      - $session_key
 * 
 * @return
 *      - student_id        (@STRING) 学号
 *
 **/
function get_student_id_from_session_key($session_key){
    
}



/**
 * 
 * 刷新某个session_key的Time to vaild
 * 
 * @param
 *      - $session_key
 * 
 * @return
 *      - true/false
 *
 **/
function refresh_session_key($session_key){

}


/**
 * 
 * 验证学生
 * 
 * @param
 *      - $student_id       (@STRING) 学号
 *      - $student_pw       (@STRING) 密码（看哪儿有学生信息的）
 * 
 * @return
 *      - student_info      (@JSONSTR)  学生信息，失败返回error
 *
 **/
function confirm_student($student_id, $student_pw){

}



/**
 * 
 * 验证源论坛身份
 * 
 * @param
 *      - $bbs_id           (@STRING) 源BBS账号
 *      - $bbs_pw           (@STRING) 源BBS密码
 * 
 * @return
 *      - student_id        (@STRING) 学号
 *
 **/
function confirm_bbs($bbs_id,$bbs_pw){

}

?>