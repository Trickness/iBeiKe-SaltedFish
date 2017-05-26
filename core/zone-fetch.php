<?php
	// {
 //    	"student_id":"00000001",
 //    	"name":"周杰伦",
 //    	"gender":"男",
 //    	"birthday":"19961230",
 //    	"type":"本科",
 //    	"nationality":"汉族",
 //    	"nickname":"black"
	// }

	require_once "./users.php";
	// $student_info = json_decode(fetch_self_info("4pagocwl3b3sjl6592o22kgqiw8pb5gn"),true);
	// $name = $student_info['name'];
	// // $name ="abc";
	// $value = $_GET['login'];
	// if ($value=="true") {
	// 	$data = $name;
	// }else{
	// 	$data = "Not login";
	// }
	// echo $data;
		$session_key = $_GET['session_key'];
		$student_info = fetch_self_info($session_key);
		if (!$student_info) {
			$data = "Not login";
		}else{
			$data = $student_info;
		}
		echo $data;	
?>