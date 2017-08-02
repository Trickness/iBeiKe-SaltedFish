<?php
session_start();
require_once "./users.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
require_once "./goods.php";
// function show_goods($rank,$amount){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    global $db_order_table;
    if (isset($_GET['rank'],$_GET['amount'])) {
    	$rank = $_GET['rank'];
    	$amount = $_GET['amount'];
    	// $rank = "new";
	    $goodsTpl = '<a href="%s"><div class="goods">
						<img src="%s">
						<h2>￥%s</h2>
						<p style="font-size:14px;">%s</p>
						<p>%s</p>
					</div></a>';

		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		if ($rank == "new") {
			$sql = "SELECT goods_id FROM $db_goods_table ORDER BY submit_date DESC LIMIT 0,$amount";
		}elseif ($rank == "hot") {
			$sql = "SELECT goods_id FROM $db_goods_table LIMIT 0,$amount";
		}
		$query = mysqli_query($link,$sql);
		$goods = "";
		while ($res = mysqli_fetch_array($query)) {
			// $list[] = $res['goods_id'];
			$good = json_decode(fetch_goods_info($res['goods_id'],session_id()),true);
			$goods = $goods.sprintf($goodsTpl,"#","./adv.png",$good['price'],$good['goods_title'],$good['submitter']);
		}
		mysqli_close($link);
		echo $goods;
	}elseif (isset($_GET['orders'])) {
		if ($_GET['orders']=="cart") {
			$storeTpl = '<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
										<div style="width: inherit;height: 27px;">
											
											<p class="st-name">%s</p>
											<div class="edit"><a href="%s">编辑</a>|<a href="%s">删除</a></div>
										</div>
										%s
									</div>
									 ';
			 $cartTpl = '<a href="%s"><div class="cart">
										<input type="checkbox" style="margin-top:30px;" name="choose">
										<img src="%s">
										<p class="name">%s</p>
										<p class="price"><b>￥%s</b><b class="amount">X%s</b></p>
									</div></a>';

			$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			$session_key = session_id();
			$student_id = get_student_id_from_session_key($session_key);
			if ($student_id) {
				$sql = "SELECT * FROM $db_order_table WHERE user_id = '$student_id' ORDER BY submit_time DESC LIMIT 0,4";
				$query = mysqli_query($link,$sql);
				$orders = "";
				while ($res = mysqli_fetch_array($query)) {
					$good = json_decode(fetch_goods_info($res['goods_id'],$session_key),true);
					// $cost = $res['price_per_goodse']*$res['goods_count']+$res['deliver_fee'];

					$cart_item = sprintf($cartTpl,"#","./adv.png",$good['goods_title'],$res['price_per_goods'],$res['goods_count']);
					$store = sprintf($storeTpl,$good['submitter'],"#","#",$cart_item);
					echo $store;
				}
			}else{
				echo false;
			}
			mysqli_close($link);
		}
	}
?>