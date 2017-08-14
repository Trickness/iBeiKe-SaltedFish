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
function submit_goods_from_id($goods_info,$goods_owner){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
	$goods_info = json_decode($goods_info,true);

	$goods_title 	= __JSON($goods_info,"goods_title") 	or 	die(generate_error_report("syntax error, no title specified"));
	$single_cost 	= __JSON($goods_info,"single_cost") 	or 	die(generate_error_report("syntax error, no single cost specified"));
	//$goods_search_summary 	= urlencode(__JSON($goods_info,"search_summary") 	or 	die(generate_error_report("syntax error")));
	//$goods_images = urlencode(__JSON($goods_info,"images") 		or 	die(generate_error_report("syntax error")));
	$goods_status 	= __JSON($goods_info,"goods_status") 	or 	die(generate_error_report("syntax error, no goods status specified")) ;
	$goods_type 	= __JSON($goods_info,"goods_type") 		or 	die(generate_error_report("syntax error, no goods type specified")) ;
	$goods_remain 	= __JSON($goods_info,"remain")			or 	die(generate_error_report("syntax error, no remain specified")) ;
	$goods_tags 	= __JSON($goods_info,"tags",'[]');
	$delivery_fee 	= __JSON($goods_info,"delivery_fee",'0');
	$lv1 			= __JSON($goods_info,"cl_lv_1","");
	$lv2 			= __JSON($goods_info,"cl_lv_2","");
	$lv3 			= __JSON($goods_info,"cl_lv_3","");
	$goods_tags_str = "";
	foreach($goods_tags as $tag){
		$tag = urlencode($tag);
		$goods_tags_str = $goods_tags_str." ".$tag;
	}

	//if(!check_images_list($goods_images)) 							die(generate_error_report("syntax error")) ;
	$content = __JSON($goods_info,"content");
	$goods_search_summary  = urlencode(mb_substr($content,0,100,"utf-8").";".$goods_type.";".$goods_title.";".$lv1.";".$lv2.";".$lv3.";".$goods_tags_str);
	if(($goods_type != "rent") 	    and($goods_type != "sale"))			die(generate_error_report("syntax error5")) ;
	if(($goods_status!="available") and($goods_status != "withdrawal"))	die(generate_error_report("syntax error6")) ;
	$ttm 	= date("Y/m/d");
	//$goods_images = json_encode($goods_images);

	$goods_title = urlencode($goods_title);
	$single_cost = urlencode($single_cost);

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "INSERT INTO $db_goods_table
			(goods_title,	goods_status,			goods_type,		  single_cost,		 goods_owner,	 ttm,	 last_modified,		search_summary,	remain, tags, cl_lv_1, cl_lv_2, cl_lv_3, delivery_fee,goods_info) 
			VALUES 
			('$goods_title','$goods_status','$goods_type','$single_cost','$goods_owner','$ttm','$ttm','$goods_search_summary','$goods_remain','$goods_tags_str','$lv1','$lv2','$lv3', '$delivery_fee','$content')";
	$status = $link->query($sql);
	if(!$status){
		die(generate_error_report("Database error in submit_goods_from_user [".$link->error));
	}
	$insert_id = $link->insert_id;
	$link->commit();
	$link->close();
	return json_encode(array(
		"status" => "success",
		"goods_id" => $insert_id
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
			'comment' => urlencode($comment)
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
 *      从 goods_id, goods_owner, ttm, goods_info, comments
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
	$goods_info['single_cost'] 	= urldecode($res['single_cost']);
	$goods_info['remain'] 		= $res['remain'];
	$goods_info['ttm'] 			= $res['ttm'];
	$goods_info['last_modified'] 	= $res['last_modified'];
	$goods_info['goods_status'] 		= $res['goods_status'];
	$goods_info['goods_type'] 		= $res['goods_type'];
	$goods_info['search_summary'] 		= urldecode($res['search_summary']);
	$goods_info['comments'] 	= json_decode($res['comments'],true);
	$goods_info['delivery_fee'] = $res['delivery_fee'];
	// $goods_info['tags'] 		= $res['tags'].split(" ");
	$goods_info['tags'] 		= explode(" ",$res['tags']);

	//$goods_info['comments'] 	= $res['comments'];
	$goods_info['goods_owner'] 	= $res['goods_owner'];

	// $index = 0;
	// foreach($goods_info['comments'] as  $value){
    //     $goods_info['comments'][$index]['comment'] = urldecode($goods_info['comments'][$index]['comment']);
	// 	// $goods_info['comments'][$index]['comment'] = urldecode($value['comment']);
	// 	$index++;
	// }
	for ($i=0; $i <sizeof($goods_info['comments']) ; $i++) { 
		 $goods_info['comments'][$i]['comment'] = urldecode($goods_info['comments'][$i]['comment']);
	}
	if (!get_student_id_from_session_key($session_key)){	//来宾用户，未登录
		$goods_info['goods_owner'] = substr(trim($goods_info['goods_owner']),0,4)."****";
		$goods_info = json_encode($goods_info);
		mysqli_close($link);
		return $goods_info;
	}else{	
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
	if ($res['goods_owner']!=$student_id){
		mysqli_close($link);
		die(generate_error_report("access denied"));
	}else{
		$update = "update $db_goods_table set goods_status='unavailable' where goods_id='$goods_id'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return generate_error_report('Not owner');
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
 *      - $goods_status       (@JSONStr)
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
	$goods_single_cost 	= urlencode(__JSON($goods_info,"single_cost") 		or 	die(generate_error_report("syntax error")));
	$goods_search_summary 	= urlencode(__JSON($goods_info,"search_summary") 		or 	die(generate_error_report("syntax error")));
	//$goods_images = urlencode(__JSON($goods_info,"images") 		or 	die(generate_error_report("syntax error")));
	$goods_status 	= __JSON($goods_info,"goods_status") 					or 	die(generate_error_report("syntax error")) ;
	$goods_type 	= __JSON($goods_info,"goods_type") 					or 	die(generate_error_report("syntax error")) ;
	//if(!check_images_list($goods_images)) 							die(generate_error_report("syntax error")) ;
	if(($goods_type != "rent") 		or ($goods_status != "sale"))		die(generate_error_report("syntax error")) ;
	if(($goods_status!="available") or ($goods_status != "withdrawal"))	die(generate_error_report("syntax error")) ;
	$last_modified 		= date("Y/m/d");


	// check authorities
	$student_id = get_student_id_from_session_key($session_key) 	or die(generate_error_report("access denied")) ;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query) or die("No such goods");
	if ($res['goods_owner']!=$student_id){
		mysqli_close($link);
		die(generate_error_report("access denied"));
	}else{
		$update = "update $db_goods_table set goods_title 	= '$goods_title',
											  goods_status 		= '$goods_status',
											  goods_type 			= '$goods_type',
											  single_cost 		= '$goods_single_cost',
											  last_modified 	= '$last_modified',
											  search_summary 		= '$goods_search_summary',
											  goods_info 	= '$goods_info'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return generate_error_report('success');
	}
}


function fetch_goods_owner($goods_id){
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
		return $result['goods_owner'];
	}else{
		return false;
	}

}

function decrease_goods_remain($goods_id, $num){
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	global $db_goods_table;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "UPDATE $db_goods_table SET remain=remain-$num WHERE goods_id='$goods_id'";
	$result = $link->query($sql);
	$link->commit();
	$link->close();
	return true;
}

function increase_goods_remain($goods_id, $num){
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	global $db_goods_table;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$sql = "UPDATE $db_goods_table SET remain=remain+$num WHERE goods_id='$goods_id'";
	$result = $link->query($sql);
	$link->commit();
	$link->close();
	return true;
}
?>