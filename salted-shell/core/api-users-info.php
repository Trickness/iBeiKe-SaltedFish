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
		if (isset($_GET['session'])) {
			$session = $_GET['session'];
			echo fetch_self_info($session);
			// var_dump(json_decode(fetch_self_info($session),true));
		}else{
			echo fetch_self_info("123");
		}
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
	}
}
?>