<?php
session_start();
require_once "./users.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
require_once "./goods.php";
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    global $db_order_table;
	if (isset($_GET['action'])) {
		if ($_GET['action']=="show_goods_in_main" &&
			isset($_GET['rank'],$_GET['amount'])) {
	    	$rank = $_GET['rank'];
	    	$amount = $_GET['amount'];
			$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			if ($rank == "new") {
				$sql = "SELECT goods_id FROM $db_goods_table ORDER BY ttm DESC LIMIT 0,$amount";
			}elseif ($rank == "hot") {
				$sql = "SELECT goods_id FROM $db_goods_table LIMIT 0,$amount";
			}
			$query = mysqli_query($link,$sql);
			$goods = array();
			while ($res = mysqli_fetch_assoc($query)) {
				$goods[] = fetch_goods_info($res['goods_id'],session_id());
			}
			mysqli_close($link);
			echo json_encode($goods);
		}
	}
?>
