<?php
require_once "../config.php";
require_once "./utils.php";
require_once "./authorization.php";
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
	
	var_dump($student_id);

	if ($student_id==0) return false;

	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query);
	
	if ($res['submitter']!=$student_id){
		mysqli_close($link);
		return false;
	}else{
		$goods_info = json_decode($res['goods_info'],true);
		$goods_info['status']="unavailable";
		$json = json_encode($goods_info);
		$update = "update $db_goods_table set status='unavailable', goods_info='$json' where goods_id='$goods_id'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return $json;
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
	$jsonArray = json_decode($goods_info,true);
		$goods_id = $jsonArray['goods_id'];
		$goods_title = $jsonArray['goods_title'];
		$status = $jsonArray['status'];
		$submitter = $jsonArray['submitter'];
		$comments = $jsonArray['comments'];


	$student_id = get_student_id_from_session_key($session_key);
	if ($student_id==0) return false;
	
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query);
	if ($res['submitter']!=$student_id){
		mysqli_close($link);
		return false;
	}else{
		$update = "update $db_goods_table set goods_id = $goods_id,
											  goods_title = '$goods_title',
											  status = '$status',
											  submitter = '$submitter',
											  comments = '$comments',
											  goods_info = '$goods_info'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return $goods_info;
	}
}
?>