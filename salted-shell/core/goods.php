<?php
//error_reporting(0); 
/**
 * 
 * 提交一个新的闲置物品
 * 
 * @param:
 *      - $goods_info    (@JSONStr)物品的信息
 *      - $session_key  (@STRING)会话密钥
 * 
 * @return:
 *      - $status       (@JSONStr) 状态，例如"{error:""}"表成功，"{error:"Permission denied"}"表示没有提交物品的权限，后面的同理
 *        错误类型报告
 *        缺少关键字assert失败         "{error:"Missing keywords"}"
 *        登陆失败sessionkey错误       "{error:"Not logged in"}"
 *        成功过                      "{error:"success"}"
 **/
function submit_goods($goods_info, $session_key)
{
    global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    $submiter = get_student_id_from_session_key($session_key);
    if ($submiter){
        submit_goods_from_id($goods_info,$submiter);
    }
    else  return generate_error_report("Not logged in");
};
function submit_goods_from_id($goods_info,$submitter){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
	$goods_info = json_decode($goods_info,true);

	$goods_title 	= urlencode(__JSON($goods_info,"goods_title") 	or 	die(generate_error_report("syntax error1")));
	$goods_price 	= urlencode(__JSON($goods_info,"price") 		or 	die(generate_error_report("syntax error2")));
	//$goods_summary 	= urlencode(__JSON($goods_info,"summary") 	or 	die(generate_error_report("syntax error")));
	//$goods_images = urlencode(__JSON($goods_info,"images") 		or 	die(generate_error_report("syntax error")));
	$goods_status 	= __JSON($goods_info,"status") 					or 	die(generate_error_report("syntax error3")) ;
	$goods_type 	= __JSON($goods_info,"type") 					or 	die(generate_error_report("syntax error4")) ;
	$goods_tags 	= __JSON($goods_info,"tags") 					or 	die(generate_error_report("syntax error7")) ;

	//if(!check_images_list($goods_images)) 							die(generate_error_report("syntax error")) ;
	$goods_summary  = mb_substr(__JSON($goods_info,"content"),0,100,"utf-8");
	var_dump($goods_type);
	if(($goods_type != "rent") 	    and($goods_status != "sale"))		die(generate_error_report("syntax error5")) ;
	if(($goods_status!="available") and($goods_status != "withdrawal"))	die(generate_error_report("syntax error6")) ;
	$submit_date 	= date("Y/m/d");
	//$goods_images = json_encode($goods_images);

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "INSERT INTO $db_goods_table
			(goods_title,	status,			type,		  price,		 submitter,	 submit_date,	 edit_date,		summary) 
			VALUES 
			('$goods_title','$goods_status','$goods_type','$goods_price','$submitter','$submit_date','$submit_date','$goods_summary')";
	var_dump($sql);
	$link->query($sql);
	$link->commit();
	$link->close();
	return json_encode(array(
		"status" => "success"
	));
}

/**
 *
 * 评论物品
 * 
 * @param
 *      - $goods_id      (@INT) goods_info的第一个字段
 *      - $comment      (@STRING)评论
 *      - $session_key  (@STRING)会话密钥 
 * 
 * @return
 *      - $status       (@JSONStr)
 *		  错误类型报告
 *        登陆失败sessionkey错误       "{error:"Not logged in"}"
 *        成功过                      "{error:"success"}" 	"{error:""the first success""}"
 **/
function comment_goods($goods_id, $comment, $session_key)
{
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    $commenter = get_student_id_from_session_key($session_key) or die(generate_error_report("access denied"));
	if ($commenter) {
		$comment_ele = array(
			'commenter'=>$commenter,
			'comment_date'=> Date("Y-m-d"),
			'comment' => $comment
		);
		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$select = "SELECT * FROM $db_goods_table where goods_id='$goods_id'";
		$res = $link->query($select);
		$res = mysqli_fetch_assoc($res) or die("No such goods");
		if (isset($res['comments']))
		{	
			$old_comment = json_decode($res['comments'],true);
			array_unshift($old_comment,$comment_ele);
			$updated_comment = json_encode($old_comment);
			$update = "UPDATE $db_goods_table SET comments = '$updated_comment' WHERE goods_id = '$goods_id';";
			$link->query($update);
			$link->commit();
			$link->close();
			return json_encode(array(
				"status" => "success"
			));
		}
		else
		{
			$updated_comment = "[".json_encode($comment_ele)."]";
			$update = "UPDATE $db_goods_table SET comments = '$updated_comment' WHERE goods_id = '$goods_id';";
			$link->query($update);
			$link->commit();
			$link->close();
			return json_encode(array(
				"status" => "success"
			));
		}
	}else{
		return json_encode(array(
			"status" => "no comment"
		));
	}
}
/**
 * 
 * 获得商品信息
 *      从 goods_id, submitter, submit_date, goods_info, comments
 *      中获取信息，构建JSON，并返回
 *    根据不同的 session_key 返回经过修改或删减的信息
 * 
 * @param
 *      - (@INT)        goods_id        // 唯一ID     
 *      - (@STRING)     session_key     // 为空时认为是 guest，private 和 public ACCESS 的字段不予返回
 * 
 * @return
 * 		- (@jsonstr)    goods_info
 * 
 **/
 function fetch_goods_info($goods_id, $session_key)
 {
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
	$goods_info = array();
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$select = "SELECT * FROM $db_goods_table where goods_id='$goods_id'";
	$res = $link->query($select);
	$res = mysqli_fetch_assoc($res) or die("No such goods");
	$goods_info['goods_id'] 	= $res['goods_id'];
	$goods_info['goods_title'] 	= urldecode($res['goods_title']);
	$goods_info['submit_date'] 	= $res['submit_date'];
	$goods_info['edit_date'] 	= $res['edit_date'];
	$goods_info['status'] 		= $res['status'];
	$goods_info['type'] 		= $res['type'];
	$goods_info['price'] 		= urldecode($res['price']);
	$goods_info['summary'] 		= urldecode($res['summary']);
	// $goods_info['comments'] 	= json_decode($res['comments'],true);
	$goods_info['comments'] 	= $res['comments'];
	$goods_info['submitter'] 	= $res['submitter'];
	if (!get_student_id_from_session_key($session_key))	//来宾用户，未登录
	{
		// $goods_info['submitter'] = $goods_info['submitter'].substr(4)."****";
		$goods_info['submitter'] = substr(trim($goods_info['submitter']),0,4)."****";
		// 
		$goods_info = json_encode($goods_info);
		mysqli_close($link);
		return $goods_info;
	}
	else
	{	
		$goods_info = json_encode($goods_info);
		mysqli_close($link);
		return $goods_info;
	}
 }
/**
 *
 * 撤回物品（物品下线）
 * 
 * @param
 *      - $goods_id      (@INT) good_info的第一个字段
 *      - $session_key  (@STRING)会话密钥 
 * 
 * @return
 *      - $status       (@JSONStr)
 *
 **/
function revoke_goods($goods_id, $session_key){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_users_table;
	global $db_goods_table;
	
	$student_id = get_student_id_from_session_key($session_key);
	if ($student_id==0) die(generate_error_report("access denied"));
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query) or die("No such goods");
	if ($res['submitter']!=$student_id){
		mysqli_close($link);
		die(generate_error_report("access denied"));
	}else{
		$update = "update $db_goods_table set status='unavailable' where goods_id='$goods_id'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return generate_error_report('Not submitter');
	}
}
/**
 *
 * 修改物品信息
 *      用户提交JSON，从中分离出不同的字段，分别更新数据库的
 *    各个字段
 * 
 * 
 * @param
 *      - $goods_info   (@JSONStr) 新的物品介绍
 *      - $session_key  (@STRING)会话密钥 
 * 
 * @return
 *      - $status       (@JSONStr)
 *
 **/
function update_goods($goods_info, $session_key){
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	global $db_goods_table;

	$goods_info 	= json_decode($goods_info,true);

	$goods_id  		= __JSON($goods_info,"goods_id")				or 	die(generate_error_report("syntax error")) ;
	$goods_title 	= urlencode(__JSON($goods_info,"goods_title") 	or 	die(generate_error_report("syntax error")));
	$goods_price 	= urlencode(__JSON($goods_info,"price") 		or 	die(generate_error_report("syntax error")));
	$goods_summary 	= urlencode(__JSON($goods_info,"summary") 		or 	die(generate_error_report("syntax error")));
	//$goods_images = urlencode(__JSON($goods_info,"images") 		or 	die(generate_error_report("syntax error")));
	$goods_status 	= __JSON($goods_info,"status") 					or 	die(generate_error_report("syntax error")) ;
	$goods_type 	= __JSON($goods_info,"type") 					or 	die(generate_error_report("syntax error")) ;
	//if(!check_images_list($goods_images)) 							die(generate_error_report("syntax error")) ;
	if(($goods_type != "rent") 		or ($goods_status != "sale"))		die(generate_error_report("syntax error")) ;
	if(($goods_status!="available") or ($goods_status != "withdrawal"))	die(generate_error_report("syntax error")) ;
	$edit_date 		= date("Y/m/d");


	// check authorities
	$student_id = get_student_id_from_session_key($session_key) 	or die(generate_error_report("access denied")) ;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query) or die("No such goods");
	if ($res['submitter']!=$student_id){
		mysqli_close($link);
		die(generate_error_report("access denied"));
	}else{
		$update = "update $db_goods_table set goods_title 	= '$goods_title',
											  status 		= '$goods_status',
											  type 			= '$goods_type',
											  price 		= '$goods_price',
											  edit_date 	= '$edit_date',
											  summary 		= '$goods_summary',
											  goods_info 	= '$goods_info'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return generate_error_report('success');
	}
}


function fetch_goods_submitter($goods_id){
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	global $db_goods_table;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "select * from $db_goods_table where goods_id='$goods_id'";
	$result = $link->query($sql);
	if($result){
		$result = mysqli_fetch_assoc($result);
		return $result['submitter'];
	}else{
		return false;
	}

}
?>