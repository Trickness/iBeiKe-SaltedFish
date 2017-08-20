<?php
//require_once "../config.php";
function __JSON($array,$key,$default=false){
    if(array_key_exists($key,$array))   return $array[$key];
    else if(is_callable($default))
        return call_user_func($default);
    return $default;
};

function curlPost($url,$data,$httpheader,$cookie,$header=false){
	$fields_string = '';
	foreach($data as $key => $value)
	{
		$fields_string .= $key . '=' . $value . '&';
	}
	$fields_string = rtrim($fields_string , '&');
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//关闭连接时，将服务器端返回的cookie保存在以下文件中
	//curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	if($header){
		curl_setopt($ch, CURLOPT_HEADER, true);//只输出响应头
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
	$content= curl_exec($ch);
	curl_close($ch);
	return $content;
}
function curlGet($url,$httpheader,$cookie){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
	//curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	if($httpheader){
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	}
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}


/**
 *
 * 获取所有课程学分、学时和成绩
 * 
 * @param
 *      (@STRING)   student_id(学号)
 *      (@STRING)   id_pass(本科教学网的密码)
 *
 * @return
 *      (@JSONStr)  你所有课程的学分，学时和成绩
 *
 **/
function fetch_class_score($student_id,$id_pass){
    $res = array();
    $login_url = "http://seam.ustb.edu.cn:8080/jwgl/Login";
    $cookie = tempnam('.','~teach');

    $fields_post = array(
            'username'=> $student_id,
            'password'=> $id_pass,
            'usertype'=>"student",
            'btnlogon.x'=>"95",
            'btnlogon.y'=>"13",
            );
    $headers_login = array(
            'Referer'           => 'http://seam.ustb.edu.cn:8080/jwgl/'
    );
    curlPost($login_url,$fields_post,$headers_login,$cookie,true);
    $url = 'http://seam.ustb.edu.cn:8080/jwgl/score.jsp?stu='.$student_id;
    $fields_post = array(
        'XNXQ'=> 'all',
        'Submit'=> '%B2%E9%D1%AF',
    );
    $headers_login = array(
        'Referer'           => 'http://seam.ustb.edu.cn/jwgl/score.jsp'
    );
    $contents = curlPost($url,$fields_post,$headers_login,$cookie);
    $dom = new DOMDocument();
    @$dom->loadHTML($contents);
    $xpath = new DOMXPath($dom);
    $number = $xpath->query("id('maincontent')/table/tr/td[1]/table/tr");
    $length = $number->length;
    if($length==0){
        unlink($cookie);
        exit('[]');
    }
    for($i=2; $i<$length; $i++){
        $td = $xpath->query('td', $number->item($i));
        $res['courseScore'][] = array(
            'number'=>$td->item(0)->textContent,
            'name'=>$td->item(1)->textContent,
            'xuefen'=>$td->item(2)->textContent,
            'xueshi'=>$td->item(3)->textContent,
            'score'=>$td->item(4)->textContent,
            'type'=>$td->item(5)->textContent,'time'=>$td->item(6)->textContent,
        );
    }

    $url ="http://seam.ustb.edu.cn:8080/jwgl/score.jsp";//创新学分
    $contents = curlGet($url,$headers_login,$cookie);
    @$dom->loadHTML($contents);
    $xpath = new DOMXPath($dom);
    $table = $xpath->query("id('maincontent')/table/tr/td[1]/table");

    $number = $xpath->query('tr[4]/td/table/tr',$table->item(0));
    $length = $number->length;
    if($length>2){
        for($i=2; $i<$length; $i++){
            $td = $xpath->query('td', $number->item($i));
            $res['techScore'][] = array(
                'name'=>$td->item(0)->textContent,
                'score'=>$td->item(1)->textContent,
                'time'=>$td->item(2)->textContent);
        }
    }

    $number = $xpath->query('tr[5]/td/table/tr',$table->item(0));
    $length = $number->length;
    for($i=2; $i<$length; $i++){
        $td = $xpath->query('td', $number->item($i));
        $res['innoScore'][] = array(
            'headline'=>$td->item(0)->textContent,
            'reporter'=>$td->item(1)->textContent,
            'date'=>$td->item(2)->textContent,
            'charge'=>$td->item(3)->textContent
        );
    }
    return $ret;
}

/**
 * 解析命令行输入的参数
 *
 * @param     string    query
 * @return    array    params
 */
function convertCliParams($query){
    $queryParts = explode('&',$query);
    $params = array();
    foreach ($queryParts as $param){
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

function getRandom($param){
    $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $key = "";
    for($i=0;$i<$param;$i++){
        $key .= $str{mt_rand(0,32)};    //生成php随机数
    }
    return $key;
}


/**
 * 
 * 过滤session_key中的非法字符 
 * 
 * @param
 *      -(@STRING)  session_key
 * 
 * @return
 *      -(@STRING)  filtered session_key
 *
 **/
function filter_session_key($session_key){
    preg_match_all("/[a-zA-Z0-9]/", $session_key, $x);      //  正则表达式
    if(count($x[0]) < 32)   return false;
    $x[0] = implode("",$x[0]);
    return $x[0];
}

function filter_password($password){
    return $password;   // TODOS
}
/**
 * 
 * 错误报告 
 * 
 * @param
 *      -(@STRING)  error
 * 
 * @return
 *      -(@jsonstr) json error
 *
 **/
function generate_error_report($err)
{
    $arr = array();
    $arr["status"] = "failed";
    $arr["error"] = $err;
    $jsonerr = json_encode($arr);
    return $jsonerr; 
}


/**
 * 
 * 检查images list是否合法，相关文件是否已经存储在服务器上
 * 
 * @param
 *      -(@ARRAY)   images list
 * 
 * @return
 *      -(@BOOLEAN) true/false
 * 
**/ 
function check_images_list($list){
    return true;
}




// 检查上传数据是否为图像数据，是返回true，否则返回false
function is_img($data){
    return true;
}


?>