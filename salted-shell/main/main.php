<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		session_start();
	?>
	<title>贝壳商城-让你的闲置动起来(O(∩_∩)O)</title>
	<style>
		@font-face {
			font-family: msyh;
			src: url('../fonts/msyh.ttf');
		}
		body{
			margin:0;
			min-width: 1228px;
			font-family: msyh;
			/*background-color: #e8e8e8;*/
		}
		#topbanner{
			background-color: rgb(253,152,80);
			height: 75px;
			position: fixed;
			width: 100%;
			z-index: 10;
		}
		#topbanner a{
			text-decoration: none;
		}
		#logo{
			margin-left: 18px;
			height: 70px;
			width: 60px;
		}
		 /*Microsoft YaHei*/
		#title{
			font-family: msyh;
			height: 36px;
    		width: 150px;
    		color: white;
    		font-size: 25px;
    		position: fixed;
    		top: 19px;
    		left: 95px;
		}
		.top-tl{
			z-index: 1;
			font-size: 20px;
			color: white;
			padding:2px;
			position: fixed;
			top: 22px;
		}
		.top-tl:after{
			content: '';position: absolute;
			top: 0;left: 0;right: 0;bottom: 0;
			border-radius: 2px;
			z-index: -1;
			transition-duration: 0.4s;
		}
		.top-tl:hover:after{
			background-color: white;
			opacity: 0.8;
		}
		.active:after{
			content: '';
			position: absolute;
			top: 0;left: 0;right: 0;bottom: 0;
			background-color: white;
			opacity: 0.5;
			border-radius: 2px;
			z-index: -1;
		}
		a{
			text-decoration: none;font-size: 14px;color: black;
		}
		a:hover{
			text-decoration: underline;
		}
		input[name='submit_search']{
			height: 36px;width: 120px;background-color: #FD9850;color: white;border:none;float: left;
			transition-duration: 0.4s;
		}
		input[name='submit_search']:hover{
			background-color: #FFCC66;
		}
		#main-show,#goods-show{
			position: absolute;
			/*left:calc(50% - 614px);*/
		}
		#go-back{
			width: 100px;
			height: 50px;
			border:1px solid #FD9850;
			position: fixed;
			left: 1400px;
			top:600px;
		}
		.goods{
			color: black;
			width: 220px;
			margin:6px;
			height:335px;
			border: 1px solid white;
			float: left;
			border-radius: 5px;
			transition-duration: 0.4s;
			text-align: center;
		}
		.goods:hover{
			 background-color: #e8e8e8;
			color: #FD9850;
			border: 1px solid #CCCCCC;
			box-shadow:2px 2px 2px #CCCCCC;
		}
		.goods img{
			width: 220px;
			height: 220px;
			border-radius: 5px;
			 /* margin: 2px;  */
		}
		.goods h2{margin: 0;margin-left: 15px;color: #FD9850;text-align: left;width: 200px;}
		.goods p{margin: 0;font-size: 12px;text-align: left;color: #404040;width: 170px;height: 25px;margin-left: 15px;}
	</style>
</head>
<body>
	<script src="../js/jquery-latest.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css">
	<script src="../js/swiper.animate1.0.2.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>
	<script src="../js/vue.js"></script>

	<div id="go-back"><a href="#main-show">回到顶端</a></div>

	<?php  include "../frame/head_user.php"; ?>

	<script>
	String.prototype.format = function(args) {
		var result = this;
		if (arguments.length > 0) {
			if (arguments.length == 1 && typeof (args) == "object") {
				for (var key in args) {
					if(args[key]!=undefined){
						var reg = new RegExp("({" + key + "})", "g");
						result = result.replace(reg, args[key]);
					}
				}
			}
			else {
				for (var i = 0; i < arguments.length; i++) {
					if (arguments[i] != undefined) {
						var reg= new RegExp("({)" + i + "(})", "g");
						result = result.replace(reg, arguments[i]);
					}
				}
			}
		}
		return result;
	}
	$(document).ready(function(){
		var wth = parseInt($("body").css('width').split("px")[0]);
		console.log((wth-1228)/2);
		$("#main-show").css("left",(wth-1228)/2);
		$("#goods-show").css("left",(wth-1228)/2);
		$("#market-tl").addClass("active");
	});
	</script>
	<div id="main-show" style="height: 620px;top:100px;z-index: 1;">
		<div id="head-row" style="width:1228px;height: 20px;">
			<a href="../login/login.php" style="color: #FD9850;float: left;">请登录</a>
			<a href="../signin/signin.php" style="margin-left: 5px;float: left;">免费注册</a>
			<a href="#" style="margin-left: 20px;float: left;">手机逛商城</a>
			<a href="#" style="float: right;">新手须知</a>
			<a href="#" style="margin-right: 15px;float: right;">联系客服</a>
			<a href="#" style="margin-right: 15px;float: right;">卖家中心</a>
		</div>
		<div id="neck-row" style="width: 1228px;margin-top: 20px;height: 40px;">
			<form method="get">
				<input type="text" name="search" class="search" placeholder="选你所爱" style="width: 580px;height: 28px;border:3px solid #FD9850;float: left;padding-left: 5px;outline: 0;" autocomplete="off">
				<input type="submit" name="submit_search" style="" value="搜索">
			</form>

			<script>
			// 自动搜索
 				$(document).ready(function() {
 					var availableTags = [];
 					$("input[name='sch']").keyup(function(){
 						var value = $(this).val();

 						$.get("./sch-goods.php",{val:value},function(data){
 							// availableTags = data;
 							console.log(data);
 							data = data.split("+");
 							data.splice(0,1);
 							availableTags = data;
 							$( ".search" ).autocomplete({
    							source: availableTags
    						});
 						});
 					});
  				});
  			</script>

			<div style="float: left;margin-top: 8px;margin-left: 20px;">
				<a href="#" style="color: #FD9850;margin-left: 12px;">实体商品</a>
				<a href="#" style="color: #FD9850;margin-left: 12px;">非实体商品</a>
				<a href="#" style="color: #FD9850;margin-left: 12px;margin-right: 12px;">贝城信息</a>|
				<a href="#" style="margin-left: 12px;">学习</a>
				<a href="#" style="margin-left: 12px;">生活</a>
				<a href="#" style="margin-left: 12px;">电子</a>
				<a href="#" style="margin-left: 12px;">娱乐</a>
				<a href="#" style="margin-left: 12px;">旅行</a>
			</div>
		</div>

		<style>
			.list-item{
				/*width: 220px;
				background-color: #FF6666;
				margin-left:-5px;
				border-radius: 5px;*/

				height: 60px;
				transition-duration: 0.4s;
				/*margin-bottom: 2px;*/
				/*border:1px solid green;*/
			}
			.list-item a{
				float: left;
				color: white;
				font-size:20px;
				margin:15px;
			}
			.list-item img{
				float: left;margin-left: 25px;margin-top: 10px;width: 32px;height: 32px;
			}
			.list-item:hover{
				background-color: #FFCC33;
			}
		</style>

		<div id="chest-row" style="width: 1228px;/*height: 520px;*/margin-top: 20px;"></div>
			<?php include "./left-panel.html"; ?>
			<div id="rt-panel" style="float: left;width: 1008px;min-height: 520px;z-index:-1;">
			<?php
				if (!isset($_GET['catagory']) && !isset($_GET['search'])) {
					include "./rt-panel.php";
				}elseif (isset($_GET['catagory']) || isset($_GET['search'])) {
					include "./rt-list.php";
				}
			?>
			</div>

			<style>
				.attr-show{width: 800px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-522px;display: none;border:4px solid #FD9850;border-radius: 5px;}
				.second-cat{
					width: inherit;height: 65px;
				}
				.cat-tl{
					width: inherit;height: 30px;border-bottom: 1px solid #FD9850;margin-top: 15px;
				}
				.second-cat a{
					float: left;width: 70px;font-size: 12px;text-align: center;margin-top: 10px;
				}
				[name='virtual+'] .second-cat a{width: 180px;height: 100px;margin:0;}
				[name='beikeinfo+'] .second-cat a{width: 180px;height: 100px;margin:0;}
				.second-cat img{width: inherit;height: 100px;margin-top: 10px;border-radius: 10px;transition-duration: 0.4s;}
				.second-cat img:hover{width: 185px;height: 110px;}
				.attr-show a:hover{color: #FD9850;}
				.sec-cat{width: 180px;height: inherit;margin-left: 12px;float: left;/*border:1px solid green;*/}
			</style>

		<!-- </div> -->
	</div></div></div>


	<?php
		if (!isset($_GET['catagory']) && !isset($_GET['search'])) {
			include "./goods-show.php";
		}
	?>
</body>
</html>
