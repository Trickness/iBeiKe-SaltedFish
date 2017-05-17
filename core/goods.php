<?php
require_once "../config.php";
require_once "./utils.php";
require_once "./authorization.php";
error_reporting(0); 
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
    if ($submiter)
    {
        $goods_info = json_decode($goods_info,true);
        if (assert($goods_info['goods_title'])&&assert($goods_info['status'])&&assert($goods_info['submitter'])&&assert($goods_info['submit_date']))
            {
                $goods_title = $goods_info['goods_title'];
                $goods_status = $goods_info['status'];
                $goods_submitter = $goods_info['submitter'];
                $goods_submit_date = $goods_info['submit_date'];
            }
        else  return error_report("Missing keywords");
        $arr = array();
        if (assert($goods_info['price']))
        {$arr['price'] = $goods_info['price'];}
        if (assert($goods_info['type']))
        {$arr['type']= $goods_info['type'];}
        if (assert($goods_info['summary']))
        {$arr['goods_summary'] = $goods_info['summary'];}
        $goods_info_inline = json_encode($arr);
        $goods_info_inline = urlencode($goods_info_inline);
        $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
        $sql = "INSERT INTO $db_goods_table(goods_title,submitter,status,submit_date,goods_info) VALUES ('$goods_title','$goods_submitter','$goods_status','$goods_submit_date','$goods_info_inline')";
        $link->query($sql);
        $link->commit();
        $link->close();
        return error_report("success");
    }
    else  return error_report("Not logged in");
};
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
    $submiter = get_student_id_from_session_key($session_key);
    if ($submiter)
    {
		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$select = "SELECT * FROM $db_goods_table where goods_id='$goods_id'";
		$res = $link->query($select);
		$res = mysqli_fetch_assoc($res);
		$old_comment = json_decode($res['comments']);
		if (assert($old_comment->comment))
		{
			$comment = json_decode($comment);
			array_push($old_comment->comment,$comment->comment[0]);
			$updated_comment = json_encode($old_comment);
			$update = "UPDATE $db_goods_table SET comments = '$updated_comment' WHERE goods_id = '$goods_id';";
       	 	$link->query($update);
        	$link->commit();
        	$link->close();
			return error_report("success");
		}
		else
		{
			$updated_comment = $comment;
			$update = "UPDATE $db_goods_table SET comments = '$updated_comment' WHERE goods_id = '$goods_id';";
			$link->query($update);
			$link->commit();
			$link->close();
			return error_report("the first success");
		}
    }
    else  return error_report("Not logged in");
};
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
	$res = mysqli_fetch_assoc($res);
	$goods_info['goods_id'] = $res['goods_id'];
	$goods_info['goods_title'] = $res['goods_title'];
	$goods_info['status'] = $res['status'];
	$goods_info['goods_info'] = json_decode(urldecode($res['goods_info']));
	$goods_info['comments'] = json_decode($res['comments'])->comment;
	if (!get_student_id_from_session_key($session_key))	//来宾用户，未登录
	{
		$goods_info = json_encode($goods_info);
		return $goods_info;
	}
	else
	{
		$goods_info['submitter'] = $res['submitter'];
		$goods_info['submit_date'] = $res['goods_title'];
		$goods_info = json_encode($goods_info);
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
	if ($student_id==0) return error_report('Not logged in');
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query);
	if (assert($res['status']) && ( assert($res['submitter']) && $res['submitter']==$student_id) ){
		$update = "update $db_goods_table set status='unavailable' where goods_id='$goods_id'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return error_report('success');
	}else{
		mysqli_close($link);
		return error_report('Not submitter');
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
	$json_array = json_decode($goods_info,true);
	$edited_info = array();
		$goods_id = $json_array['goods_id'];
		$goods_title = $json_array['goods_title'];
		$status = $json_array['status'];
		$submitter = $json_array['submitter'];
		$edited_info['type'] = $json_array['type'];
		$edited_info['price'] = $json_array['price'];
		$edited_info['summary'] = $json_array['summary'];
		$edited_info = urlencode(json_encode($edited_info));
	$student_id = get_student_id_from_session_key($session_key);
	if ($student_id==0) return error_report('Not logged in');
	$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	$iden = "select * from $db_goods_table where goods_id='$goods_id'";
	$query = mysqli_query($link,$iden);
	$res = mysqli_fetch_assoc($query);
	if (assert($res['submitter']) && $res['submitter']==$student_id){
		$update = "update $db_goods_table set goods_title = '$goods_title',
											  status = '$status',
											  submitter = '$submitter',
											  goods_info = '$edited_info'
						where goods_id='$goods_id'";
		$query_1 = mysqli_query($link,$update);
		mysqli_close($link);
		return error_report('success');
	}else{
		mysqli_close($link);
		return error_report('Not submitter');
	}
}
?>