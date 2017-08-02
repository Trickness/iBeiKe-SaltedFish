<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>贝壳资讯</title>
	<style>
		body{margin: 0;}
		#container{width: 854px;position: absolute;left: calc(50% - 854px/2);/*border: 1px solid black*/;height: 1000px;top:100px;}
		.top-row{width: 100%;/*border: 1px solid black*/;}
		#head-row{height: 250px;}
		#head-row img{width: 100%;height: 100%;}
		#neck-row{height: 270px;margin-top: 10px;}
		#chest-row{height: 480px;}
		a{text-decoration: none;color: black;}
		a:hover{color: #FD9850;}
	</style>
</head>
<body>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css">
	<script src="../js/swiper.animate1.0.2.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>

	<?php include "../frame/head_user.php"; ?>
	<script>
		$(document).ready(function(){
			$("#info-tl").addClass("active");
		});
	</script>

	<div id="container">
		<div id="head-row" class="top-row">
			<img src="../main/slider1.jpg">
		</div>
		<div id="neck-row" class="top-row">
				<style>
					.icon{width: 50px;height: 30px;background-color: #FD9850;float: left;color: white;font-size:20px;text-align:center;padding-top: 2px;}
					.element-tl{height: 40px;}
					.element-content{height: 230px;}
					.icon-tl{color: #FD9850;float: left;}
					.icon-tl p{margin: 0;font-size: 10px;margin-left:12px;}
					.element-bottom{border-bottom: 2px solid #FD9850;height: 26px;float: left;width: 700px;margin-left: 10px;}
					.note-item{float: left;width: 420px;height: 70px;/*border: 1px solid black*/;}
					.item-img{float: left;width: 90px;height:55px;background: url(../pic/note-bg.PNG);background-size: 93px 65px;background-repeat:no-repeat;text-align: center;padding-top: 11px;} 	.item-img p{margin:0;}
					.item-tl{width: 300px;height: 22px;float: left;margin-top: 9px;/*border: 1px solid black*/;margin-left: 12px;}
					.item-locate{width: 300px;height: 18px;float: left;/*border: 1px solid black*/;margin-left: 12px;font-size: 12px;
						padding-top: 5px;border-bottom: 1px dashed #CCCCCC;}
				</style>
			<div class="element-tl">
				<div class="icon">R</div>
				<div class="icon-tl">
					<p style="font-size: 13px;">消息先知</p>
					<p>ECENT NEWS</p>
				</div>
				<div class="element-bottom"></div>
			</div>
			<div id="note-content" style="/*border: 1px solid black*/;">
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
				<div class="note-item">
					<div class="item-img"><p>今日</p><p>7月15日</p></div>
					<a href="#"><div class="item-tl">iBeiKe招新</div></a>
					<div class="item-locate">镭目报告厅</div>
				</div>
			</div>
		</div>

		<style>
			.cat-tl{background-color:#FFDF8A;width:100px;height:23px;font-size:14px;padding-top:3px;text-align:center;float: left;}
			.cat-content{float: left;margin-left: 15px;margin-top: 2px;}
			#info-content{margin-top: 10px;}
			.info-catagory{width: 840px;height: 50px;}
		</style>

		<div id="chest-row" class="top-row">
			<div class="element-tl">
				<div class="icon">V</div>
				<div class="icon-tl">
					<p style="font-size: 13px;">各类消息</p>
					<p>ARIOUS NEWS</p>
				</div>
				<div class="element-bottom"></div>
			</div>
			<div id="info-content">
				<div id="part-time" class="info-catagory">
					<div class="cat-tl">兼职招聘</div>
					<a href="#"><div class="cat-content">XXXXXXX兼职招聘，XXXXXXXXXXXXXXXXXXXXXXXXX</div></a>
				</div>
				<div class="info-catagory">
					<div class="cat-tl">兼职招聘</div>
					<a href="#"><div class="cat-content">XXXXXXX兼职招聘，XXXXXXXXXXXXXXXXXXXXXXXXX</div></a>
				</div>
				<div class="info-catagory">
					<div class="cat-tl">兼职招聘</div>
					<a href="#"><div class="cat-content">XXXXXXX兼职招聘，XXXXXXXXXXXXXXXXXXXXXXXXX</div></a>
				</div>
				<div class="info-catagory">
					<div class="cat-tl">兼职招聘</div>
					<a href="#"><div class="cat-content">XXXXXXX兼职招聘，XXXXXXXXXXXXXXXXXXXXXXXXX</div></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>