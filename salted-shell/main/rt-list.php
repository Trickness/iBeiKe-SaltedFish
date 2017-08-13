<?php
require_once "../core/users.php";
require_once "../core/utils.php";
require_once "../core/authorization.php";
require_once "../config.php";
require_once "../core/goods.php";
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

function get_goods($list,$page = 1,$target = "goods_title",$goods_num = 12){
	global $db_host;
    global $db_pass;
    global $db_name;
    global $db_user;
    global $db_goods_table;

    $goods_list = array(
    	"list" => "",
    	"total_pages" => ""
    );
    $start_num = ($page-1)*($goods_num);
    // $goodsTpl = '<a href="%s"><div class="goods">
    // 	<div style="width: inherit;height: 20px;">ID：%s</div>
	// 	<div style="width: inherit;height: 20px;">价格：%s</div>
	// 	<div style="width: inherit;height: 20px;">名称：%s</div>
	// 	<div style="width: inherit;height: 20px;">卖家：%s</div>
	// 	<div style="width: inherit;height: 20px;">状态：%s</div>
	// </div>';

	$goodsTpl = '<a href="%s"><div class="goods">
						<img src="%s">
						<h2><span style="font-size:15px;">￥</span>%s</h2>
						<p style="font-size:16px;">%s</p>
						<p style="color:gray">%s</p>
					</div></a>';

	$list = urlencode($list);
    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    $id_sel = "SELECT goods_id FROM $db_goods_table WHERE $target LIKE '%$list%' LIMIT $start_num,$goods_num";
    $id_query = mysqli_query($link,$id_sel);
    while ($res = mysqli_fetch_array($id_query)) {
    	// var_dump($res['goods_id']);
    	$good_info = json_decode(fetch_goods_info($res['goods_id'],session_id()),true);
		$good = sprintf($goodsTpl,"../goods/show.php?goods_id=".$res['goods_id'],"./goods.jpg",$good_info['single_cost'],$good_info['goods_title'],$good_info['goods_owner']);
		$goods_list['list'] = $goods_list['list'].$good;
    }
    $count_sql = "SELECT COUNT(*) AS total_pages FROM $db_goods_table WHERE $target LIKE '%$list%'";
	$count_query = mysqli_query($link,$count_sql);
	$total_goods = mysqli_fetch_assoc($count_query)['total_pages'];
	$goods_list['total_pages'] = (int)($total_goods/$goods_num)+1;
    mysqli_close($link);
    return $goods_list;
}

if (isset($_GET['catagory'])) {
	if (isset($_GET['page'])) {
		$page_now = $_GET['page'];
		$url = explode("&page=", $url)[0];
		$goods_info = get_goods($_GET['catagory'],$_GET['page']);
	}else{
		$page_now = 1;
		$goods_info = get_goods($_GET['catagory']);
	}
	$goods_list = $goods_info['list'];
	$total_pages = $goods_info['total_pages'];
	echo $goods_list;
}elseif (isset($_GET['search'])) {
	if (isset($_GET['page'])) {
		$page_now = $_GET['page'];
		$url = explode("&page=", $url)[0];
		$goods_info = get_goods($_GET['search'],$_GET['page'],"goods_title");
	}else{
		$page_now = 1;
		$goods_info = get_goods($_GET['search'],$page_now,"goods_title");
	}
	$goods_list = $goods_info['list'];
	$total_pages = $goods_info['total_pages'];
	echo $goods_list;
}
?>

<style>
.page-btn{
	margin-right: 10px;
}
</style>		
<div style="width: inherit;height: 60px;float: left;text-align: center;padding-top: 25px;">
		<?php
			$turnTpl = '<a href="%s" class="button button-glow button-highlight button-small button-rounded page-btn">%s</a>';
			$pageTpl = '<a href="%s" class="button button-glow button-highlight button-small button-box page-btn">%s</a>';
			
			// $total_pages = total_pages($_GET['catagory']);

			if ($page_now != 1) {
				$page_prev = sprintf($turnTpl,$url."&page=1","首页").sprintf($turnTpl,$url."&page=".((int)$page_now-1),"上一页");
				echo $page_prev;
			}

			if ($page_now+3>=$total_pages) $end_page = $total_pages;	else $end_page = $page_now+3;
			$page_num = $page_now;
			while ($page_num <= $end_page) {
				echo sprintf($pageTpl,($url."&page=".$page_num),$page_num);
				$page_num++;
			}
			if ($page_now != $total_pages) {
				$page_next = sprintf($turnTpl,$url."&page=".((int)$page_now+1),"下一页").sprintf($turnTpl,$url."&page=".$total_pages,"尾页");
				echo $page_next;
			}
		?>
</div>