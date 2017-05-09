<?php
require "../config.php";
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
    var_dump($res);
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
if(isset($argv)){
    //if($debug_mod)  var_dump($argv);
    if($argc < 2){
        echo "请指定参数\n";
        echo "  例如 ".argv[0]." ?invoke=fetch_class_score&student_id=xxxx&id_pass=xxxx\n";
        exit();
    }

    $t = convertCliParams($argv[1]);
    if($debug_mod)  var_dump($t);

    if($t['invoke'] == "fetch_class_score"){
        $student_id = $t['student_id'];
        $id_pass = $t['id_pass'];
        $ret = fetch_class_score($student_id,$id_pass);
        var_dump($ret);
    }
    exit();
}
if(isset($_GET)){
    if(sizeof($_GET) < 2){
        echo "请指定参数\n";
        echo "  例如 ?invoke=fetch_class_score&student_id=xxxx&id_pass=xxxx\n";
        exit();
    }

    if($debug_mod)  var_dump($_GET);

    if($_GET['invoke'] == "fetch_class_score"){
        $student_id = $_GET['student_id'];
        $id_pass = $_GET['id_pass'];
        $ret = fetch_class_score($student_id,$id_pass);
        var_dump($ret);
    }
    exit();
}

?>