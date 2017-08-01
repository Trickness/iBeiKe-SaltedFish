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
		echo fetch_self_info($session);
	}elseif ($_GET['action']=="new") {
		$goods_list = "";
		$newTpl = '<a href="%s"><div class="new-item">
						<img src="%s">
						<div class="new-tl">%s</div>
						<div class="new-dec">%s</div>
					</div></a>';
		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$sel_sql = "SELECT goods_id FROM $db_goods_table ORDER BY goods_id DESC LIMIT 0,4";
		$sel_query = mysqli_query($link,$sel_sql);
		while ($res = mysqli_fetch_array($sel_query)) {
			$goods_info = json_decode(fetch_goods_info($res['goods_id'],session_id()),true);
			$good = sprintf($newTpl,"#","../main/cover.png",$goods_info['goods_title'],$goods_info['summary']);
			$goods_list = $goods_list.$good;
		}
		echo $goods_list;
		mysqli_close($link);
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
			if ($student_info) {
				$student_info = json_decode($student_info,true);
				echo $student_info[$col];
			}else{
				echo false;
			}
		}else echo false;
		// echo $student_info;
	}
}
?>