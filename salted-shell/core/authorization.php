<?php
/*require_once "../config.php";
require_once "./utils.php";*/


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
    global $db_host;
    global $db_user;
    global $db_pass;
    global $db_name;
    global $db_session_table;
    $session_key = filter_session_key($session_key);
    if(!$session_key)   return false;
    $mysqli = new mysqli($db_host,$db_user,$db_pass,$db_name) or die("Cannot connect to database");
    $result = $mysqli->query("SELECT student_id from $db_session_table WHERE session_key = '$session_key'");
    $res = mysqli_fetch_assoc($result);
    return $res['student_id'];
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
 *      - student_info      (@Object)  学生信息，失败返回 false
 *
 **/
function confirm_student($student_id, $student_pw){
    $login_url = "http://seam.ustb.edu.cn:8080/jwgl/Login";
    $cookie = tempnam('.','~teach');
    $fields_post = array(
        'username'=> $student_id,
        'password'=> $student_pw,
        'usertype'=>"student",
        'btnlogon.x'=>"95",
        'btnlogon.y'=>"13",
    );
    $headers_login = array(
        'Referer'   =>  'http://seam.ustb.edu.cn:8080/jwgl/'
    );
    curlPost($login_url,$fields_post,$headers_login,$cookie,true);
    $url = "http://seam.ustb.edu.cn:8080/jwgl/stuinfo.jsp";
    $contents = curlGet($url,null,$cookie);
    $ct = array();
    $dom = new DOMDocument();
    @$dom->loadHTML($contents);
    if(strpos($dom->textContent,"请选择正确的身份")){
        return false;
    }
    $xpath = new DOMXPath($dom);
    $test = $dom->getElementsByTagName("tbody");
    $result = $xpath->query("//table/tr/td");
    $base_count = 6;
    $item_pre_row = 4;
    $n_row = 3;
    $data = array();
    for($i = $base_count; $i < $base_count+$item_pre_row*$n_row*2; $i++){
        $data[$result->item($i)->textContent] = $result->item($i+$item_pre_row)->textContent;
        if(($i+1-$base_count)%$item_pre_row == 0)
            $i += $item_pre_row;
    }
    $ret = array();
    unlink($cookie);
    $ret['student_id'] = array(
        "access"=>  "protected",
        "value" =>  $student_id
    );
    $ret['name'] = array(
        "access"=>  "public",
        "value" =>  $data["姓名"]
    );
    $ret['gender'] = array(
        "access"    => "public",
        "value"     => $data["性别"]
    );
    $ret['birthday'] = array(
        "access"    => "private",
        "value"     => $data["出生日期"]
    );
    $ret['type']    = array(
        "access"    => "private",
        "value"     => $data["学生类别"]
    );
    $ret['nationality'] = array(
        "access"    => "private",
        "value"     => $data["民族"]
    );
    $ret['nickname']    = "'?\/";
    $ret['header']      = "";
    $ret['class_info']  = array(
        "access"    =>  "protected",
        "department"=> array(
            "access"    => "protected",
            "value"     => ""
        ),
        "enrollment"=> array(
            "access"    => "public",
            "value"     => $data["入学年级"]
        ),
        "class_no"  => array(
            "access"    => "private",
            "value"     => $data["班级"]
        )
    );
    $ret['dormitory'] = array(
        "access"    => "protected",
        "dormitory_id"  => array(
            "access"        => "protected",
            "value"         => ""
        ),
        "room_no"       => array(
            "access"        => "private",
            "value"         => ""
        ) 
    );
    $ret['phone_number'] = array(
        "access"    => "private",
        "value"     => ""
    );
    return $ret;
}



/**
 * 
 * 验证源论坛身份(尚未完成)
 * 
 * @param
 *      - $bbs_id           (@STRING) 源BBS账号
 *      - $bbs_pw           (@STRING) 源BBS密码
 * 
 * @return
 *      - bbs_info          (@Object) BBS论坛信息
 *
 **/
function confirm_bbs($bbs_id,$bbs_pw){
    return true;
}

?>