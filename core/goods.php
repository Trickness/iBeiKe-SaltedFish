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
        {$arr['goods_price'] = $goods_info['price'];}
        if (assert($goods_info['type']))
        {$arr['goods_type']= $goods_info['type'];}
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
/*$goods_info = array();
$goods_info['goods_title'] = "asdasd";
$goods_info['submitter'] = "123456";
$goods_info['submit_date'] = "19980101";
$goods_info['status'] = "online";
$goods_info['price'] = "300";
$goods_info['type'] = "sell";
$goods_info = json_encode($goods_info);
var_dump(submit_goods($goods_info,"4pagocwl3b3sjl6592o22kgqiw8pb5gn"));*/
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
 *
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
		//return $old_comment->comment[0];
		if (assert($old_comment->comment))
		{
			$comment = json_decode($comment);
			array_push($old_comment->comment,$comment->comment);
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
/*$com = array();
$com['comment'][0]['commenter'] = "12345";
$com['comment'][0]['comment_date'] = "19980101";
$com['comment'][0]['comment'] = "asdasd";
$com = json_encode($com);
//var_dump($com['comment']['comment']);
var_dump(comment_goods("9",$com,"4pagocwl3b3sjl6592o22kgqiw8pb5gn"));*/


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