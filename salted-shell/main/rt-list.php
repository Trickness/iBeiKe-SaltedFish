<?php
require_once "../core/users.php";
require_once "../core/utils.php";
require_once "../core/authorization.php";
require_once "../config.php";
require_once "../core/goods.php";
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if (!isset($_GET['page'])) $page_now = 1; elseif (isset($_GET['page'])) {
				$url = explode("&page=", $url)[0];
				$page_now = trim($_GET['page']);
			}

function get_goods($page){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;
    global $db_order_table;

    $start_num = ($page-1)*12;
    $goodsTpl = '<div class="goods">
    	<div style="width: inherit;height: 20px;">ID：%s</div>
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
	$query = mysqli_query($link,$sql);
	while ($res = mysqli_fetch_array($query)) {
		$good_info = json_decode(fetch_goods_info($res['goods_id'],"2tf8acott323vkwes50pe6b1okafw9qt"),true);

		// echo fetch_goods_info($res['goods_id'],"2tf8acott323vkwes50pe6b1okafw9qt")."<br>";

		$good = sprintf($goodsTpl,$res['goods_id'],$good_info['price'],$good_info['goods_title'],$good_info['submitter'],$good_info['status']);
		$goods_list = $goods_list.$good;
	}
	mysqli_close($link);
	return $goods_list;
}

echo get_goods($page_now);
// $tpl = '<a href="#"><div class="goods">
// 							<img src="./cover.png">
// 							<h2>￥21</h2>
// 							<p>商品名称12345687897894613fsdfweaf</p>
// 							<p>卖家名称</p>
// 						</div></a>';
// for ($i=0; $i < 12; $i++) { 
// 	echo $tpl;
// }
?>
<style>
.page-btn{
	margin-right: 10px;
}
</style>		
<div style="width: inherit;height: 60px;float: left;text-align: center;padding-top: 25px;">
		
		<!-- <a href="#" class="button button-glow button-highlight button-small button-box">1</a>
		<a href="#" class="button button-glow button-highlight button-small button-box">2</a>
		<a href="#" class="button button-glow button-highlight button-small button-box">3</a>
		<a href="#" class="button button-glow button-highlight button-small button-box">4</a> -->
		<?php
		

			function total_pages($goods_num,$count_sql){
				global $db_host;
    			global $db_pass;
    			global $db_name;
    			global $db_user;
    			global $db_goods_table;
				$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
				// $count_sql = ;
				$count_query = mysqli_query($link,$count_sql);
				$total_pages = (int)((mysqli_fetch_assoc($count_query)['total_pages'])/$goods_num)+1;
				mysqli_close($link);
				return $total_pages;
			}

			

			
			$turnTpl = '<a href="%s" class="button button-glow button-highlight button-small button-rounded page-btn">%s</a>';
			$pageTpl = '<a href="%s" class="button button-glow button-highlight button-small button-box page-btn">%s</a>';
			
			$total_pages = total_pages(12,"SELECT COUNT(*) AS total_pages FROM $db_goods_table");

			
			if ($page_now != 1) {
				$page_prev = sprintf($turnTpl,$url,"首页").sprintf($turnTpl,($url."&page=".((int)$page_now-1)),"上一页");
				echo $page_prev;
			}

			if ($page_now+3>=$total_pages) $end_page = $total_pages;	else $end_page = $page_now+3;
			$page_num = $page_now;
			while ($page_num <= $end_page) {
				echo sprintf($pageTpl,($url."&page=".$page_num),$page_num);
				$page_num++;
			}
			if ($page_now != $total_pages) {
				$page_next = sprintf($turnTpl,($url."&page=".((int)$page_now+1)),"下一页").sprintf($turnTpl,($url."&page=".$total_pages),"尾页");
				echo $page_next;
			}
		?>
		<!-- <a href="#" class="button button-glow button-highlight button-small button-rounded">下一页</a> -->
</div>