<?php
		require_once "../core/users.php";
		require_once "../core/utils.php";
		require_once "../core/authorization.php";
		require_once "../config.php";
		require_once "../core/goods.php";

	function get_goods($page){
		global $db_host;
    	global $db_pass;
    	global $db_name;
    	global $db_user;
    	global $db_goods_table;
    	global $db_order_table;

    	$start_num = ($page-1)*12;
    	$goodsTpl = '<div class="goods">
				<div style="width: inherit;height: 20px;">价格：%s</div>
				<div style="width: inherit;height: 20px;">名称：%s</div>
				<div style="width: inherit;height: 20px;">卖家：%s</div>
				<div style="width: inherit;height: 20px;">状态：%s</div>
			</div>';
		$pageTpl = '';

		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$goods_list = "";
		if (isset($_GET['first_cat'])) {
			// echo $_GET['first_cat'];
			if (isset($_GET['second_cat'])) {
				// echo $_GET['second_cat'];
			}
		}else{		
			$sql = "SELECT goods_id FROM $db_goods_table ORDER BY goods_id DESC LIMIT $start_num,12";
		}
		var_dump($query = mysqli_query($link,$sql));
		while ($res = mysqli_fetch_array($query)) {
			$good_info = json_decode(fetch_goods_info($res['goods_id'],"2tf8acott323vkwes50pe6b1okafw9qt"),true);

			// echo fetch_goods_info($res['goods_id'],"2tf8acott323vkwes50pe6b1okafw9qt")."<br>";

			$good = sprintf($goodsTpl,$good_info['price'],$good_info['goods_title'],$good_info['submitter'],$good_info['status']);
			$goods_list = $goods_list.$good;
		}
		mysqli_close($link);
		return $goods_list;
	}
	var_dump(get_goods(2));
	?>