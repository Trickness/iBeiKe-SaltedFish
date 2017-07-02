<?php
// $val = "李%";
// header("Content-Type:text/html;charset=utf-8");
// $data = array();

$data = "";
if (isset($_GET['val'])) {
	if (($val = "%".trim($_GET['val'])."%")!="%%") {
		$link = mysqli_connect("123.206.51.185","any","f20101001","my_db");
		$sql = "SELECT 姓名 FROM students WHERE 姓名 LIKE '$val'";
		$query = mysqli_query($link,$sql);
		// $data = array();
		while ($res = mysqli_fetch_array($query)) {
			// $data[] = $res['姓名'];
			$data = $data."+".$res['姓名'];
			// $data = $data."<p id='".$res['姓名']."' class='item'><a href='./tip.html?search={$res['姓名']}'>".$res['姓名']."</a></p>";
		}
		mysqli_close($link);
	}
}
// $data = json_encode($data);
// var_dump($data);
echo $data;
?>