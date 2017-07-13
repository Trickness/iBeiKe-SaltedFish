<?php
// $val = "李%";
// header("Content-Type:text/html;charset=utf-8");
// $data = array();
require_once "../core/users.php";
require_once "../core/utils.php";
require_once "../core/authorization.php";
require_once "../config.php";
require_once "../core/goods.php";
global $db_host;
global $db_pass;
global $db_name;
global $db_user;
global $db_goods_table;
$data = "";
if (isset($_GET['val'])) {
	if (($val = "%".trim($_GET['val'])."%")!="%%") {
		$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		$sql = "SELECT goods_title FROM $db_goods_table WHERE goods_title LIKE '$val'";
		$query = mysqli_query($link,$sql);
		// $data = array();
		while ($res = mysqli_fetch_array($query)) {
			// $data[] = $res['姓名'];
			$data = $data."+".$res['goods_title'];
			// $data = $data."<p id='".$res['姓名']."' class='item'><a href='./tip.html?search={$res['姓名']}'>".$res['姓名']."</a></p>";
		}
		mysqli_close($link);
	}
}
// $data = json_encode($data);
// var_dump($data);
echo $data;
?>