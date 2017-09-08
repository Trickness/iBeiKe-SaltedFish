<?php
require_once "./users.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
require_once "./goods.php";
global $db_host;
global $db_pass;
global $db_name;
global $db_user;
global $db_users_table;
global $db_goods_table;
session_start();
if (isset($_GET['action'])) {
	if ($_GET['action']=="self") {
		$session = session_id();
		echo json_encode(fetch_self_info($session));
	}elseif ($_GET['action']=="new") {
		$goods_list = array();
		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$sel_sql = "SELECT goods_id FROM $db_goods_table ORDER BY goods_id DESC LIMIT 0,4";
		$sel_query = mysqli_query($link,$sel_sql);
		mysqli_close($link);
		while ($res = mysqli_fetch_assoc($sel_query)) {$goods_list[] = fetch_goods_info($res['goods_id'],session_id());}
		$goods_list = json_encode($goods_list);
		echo $goods_list;
	}elseif ($_GET['action']=="update") {
		if (isset($_GET['user_info'])) {
			echo update_user_info($_GET['user_info'],session_id());
		}else{
			echo false;
		}
	}elseif ($_GET['action']=="one_col") {
		$student_info = fetch_self_info(session_id());
		if (isset($_GET['col'])) {
			$col = $_GET['col'];
			$col = explode(",",$col);
			if ($student_info) {
				$info = [];
				foreach ($col as $value) {
					$info[$value] = $student_info[$value];
				}
				$info = json_encode($info);
				echo $info;
			}else{
				echo false;
			}
		}else echo false;
		// echo $student_info;
	}elseif ($_GET['action']=="my_goods") {
		$goodsTpl = '<tr>
					<td><img src="../main/cover.png" alt="封面" ><div>%s</div> </td>
					<td>￥%s</td>
					<td>%s</td>
					<td>%s</td>
					<td><button class="btn btn-success">更改</button></td>
				</tr>';
		$goods_list = "";
		if($student_id = get_student_id_from_session_key(session_id())){
			$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			$sql = "SELECT goods_id FROM $db_goods_table WHERE submitter = '$student_id' ORDER BY submit_date DESC";
			$query = mysqli_query($link,$sql);
			while ($res = mysqli_fetch_array($query)) {
				$goods_info = json_decode(fetch_goods_info($res['goods_id'],session_id()),true);
				$good = sprintf($goodsTpl,$goods_info['goods_title'],$goods_info['price'],$goods_info['status'],$goods_info['type']);
				$goods_list .= $good;
			}
			echo $goods_list;
		}
	}
}
?>
