<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>贝壳商城-让你的闲置动起来(O(∩_∩)O)</title>
	<style>
		body{
			margin:0;
			min-width: 1228px;
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
		#title{
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
		input[name='search']{
			height: 36px;width: 120px;background-color: #FD9850;color: white;border:none;float: left;
			transition-duration: 0.4s;
		}
		input[name='search']:hover{
			background-color: #FFCC66;
		}
		#main-show,#goods-show{
			position: absolute;
		}
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


	<div id="topbanner">
		<img id="logo" src="../pic/beikelogo.png">
		<div id="title">贝壳商城</div>
		<div id="market-tl" class="top-tl active" style="left: 250px;">商城</div>
		<a href="../users/index.php"><div id="users-tl" class="top-tl" style="left: 340px;">个人中心</div></a>
	</div>
	
	<script>
	$(document).ready(function(){
		var wth = parseInt($("body").css('width').split("px")[0]);
		console.log((wth-1228)/2);
		$("#main-show").css("left",(wth-1228)/2);
		$("#goods-show").css("left",(wth-1228)/2);
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
				<input type="text" name="sch" class="search" placeholder="选你所爱" style="width: 580px;height: 28px;border:3px solid #FD9850;float: left;padding-left: 5px;outline: 0;" autocomplete="off">
				<input type="submit" name="search" style="" value="搜索">
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

				height: 40px;
				transition-duration: 0.4s;
				margin-bottom: 2px;
				/*border:1px solid green;*/
			}
			.list-item a{
				float: left;
				color: white;
				font-size:15px;
				margin:9px; 
			}
			.list-item img{
				float: left;margin-left: 25px;margin-top: 5px;
			}
			.list-item:hover{
				background-color: #FFCC33;
			}
		</style>

		<div id="chest-row" style="width: 1228px;height: 520px;margin-top: 20px;">
			<div id="lt-attr" style="width: 215px;height: 520px;background-color: #FD9850;
			     float: left;border-radius: 5px;margin-right: 5px;">
				<h3 style="float: left;margin-left: 27px;color: white;margin-bottom: 12px;">优选市场</h3>
				<div id="attr-list" style="width: inherit;height: 400px;/*border:1px solid black;*/margin-top:60px;">
					<div class="list-item" id="office">
						<img src="../pic/office.png">
						<a href="#">办公用品</a>
					</div>
					<div class="list-item" id="electronic">
						<img src="../pic/electronic.png">
						<a href="#">电子产品</a>
					</div>
					<div class="list-item" id="sports">
						<img src="../pic/sports.png">
						<a href="#">体育用品</a>
					</div>
					<div class="list-item" id="food">
						<img src="../pic/food.png">
						<a href="#">食物</a>
					</div>
					<div class="list-item" id="daily">
						<img src="../pic/daily.png">
						<a href="#">日常用品</a>
					</div>
				</div>
			</div>
			<div id="rt-panel" style="float: left;width: 1008px;">
				<div id="cen-show" style="width: 745px;float: left;">

					<style>
						#adv-con img{height: 130px;width: 177px;margin-right: 6px;float: left;transition-duration: 0.4s;}
						#adv-con img:hover{opacity: 0.5;}
	
						.cart{height: 65px;width: inherit;background-color: white;border-top: 1px solid #CCCCCC;border-bottom: 1px solid #CCCCCC;}
						.cart:hover{color: #FD9850;text-decoration: underline;}
						.cart img{width: 55px;height: 50px;float: left;margin: 8px;margin-left: 5px;}
						.cart b{width: 30px; float: left;}
						/*.cart input[type='checkbox']{float: left;margin-top: 30px;margin-left: 10px;}
						.cart input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 20px;width: 20px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.cart input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -3px -1px;}*/
						.store{margin-bottom:8px;border: 1px solid #e8e8e8;}
						.store:hover{box-shadow: 2px 2px 2px #e8e8e8;}
						.store input[type='checkbox']{float: left;margin-left: 10px;}
						.store input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 18px;width: 18px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.store input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -4px -3px;}

						.store .st-name{margin:0;float: left;margin-left:5px;font-size: 14px;margin-top: 3px;}
						.store .name{width: 120px;float: left;margin: 0;margin-top: 10px;font-size: 12px;text-align: left;}
						.store .price{width: 130px;color: #FD9850;font-size: 12px;float: left;margin:0;text-align: left;}
						.store .des{color: #CCCCCC;font-size: 10px;float: left;margin:0;width: 130px;text-align: left;}
						.store .amount{color: #CCCCCC;font-size: 10px;float: left;margin:0;margin-top: 2px;text-align: right;}
						.store .edit{float:right;font-size: 13px;color: gray;margin-top: 3px;}
						.store .edit a{font-size: 12px;}
					</style>
					<div class="swiper-container" style="height: 330px;margin-left: 10px;float: left;width: inherit;">
	    				<div class="swiper-wrapper">
	    	   				<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../pic/bk4.png" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInUp" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../pic/beikelogo.png" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../pic/beikeshop.png" style="height: 300px;width: 740px;"></div>
	    				</div>
	    				<!-- 如果需要分页器 -->
	    				<div class="swiper-pagination"></div>
	    
	    				<!-- 如果需要导航按钮 -->
	    				<div class="swiper-button-prev swiper-button-white"></div>
	    				<div class="swiper-button-next swiper-button-white"></div>
	    	
	    				<!-- 如果需要滚动条 -->
	    				<div class="swiper-scrollbar"></div>
					</div>
				
					<div id="bot-adv" style="height: 180px;margin-left: 10px;margin-top: 10px;float: left;">
						<div id="adv-tl" style="width: inherit;height: 40px;border-bottom:2px solid #FD9850;">
							<p style="font-size: 20px;color: #FD9850;float: left;margin: 0;margin-top: 10px;">热门店铺</p>
							<p style="font-size: 14px;color: #666666;float: left;margin: 0;margin-top: 15px;margin-left: 10px;">
								畅销商品，天天上贝壳！</p>
						</div>
						<div id="adv-con" style="width: inherit;height: 130px;margin-top: 8px;">
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
						</div>
					</div>
				</div>

				<div id="shop-cart" style="float: right;width: 250px;height: 450px;">
					<div id="cart-hd" style="width: inherit;;height: 40px;border-bottom:2px solid #FD9850;color: #FD9850;">
						<h3 style="float:left;margin-bottom:10px;margin-top: 10px;">我的购物车</h3>
					</div>
					<div id="cart" style="width: inherit;height: 400px;margin-top: 8px;">
						
						<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;">
								<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
								<p class="st-name">商店1</p>
								<div class="edit"><a href="#">编辑</a>|<a href="#">删除</a></div>
							</div>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
						</div>
						
						
						<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;">
								<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
								<p class="st-name">商店1</p>
							</div>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
						</div>


						<?php
						// $storeTpl = '<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
						// 				<div style="width: inherit;height: 27px;">
						// 					<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
						// 					<p class="st-name">%s</p>
						// 					<div class="edit"><a href="%s">编辑</a>|<a href="%s">删除</a></div>
						// 				</div>
						// 				%s
						// 			</div>
						// 			 ';
						// $cartTpl = '<a href="%s"><div class="cart">
						// 				<input type="checkbox" style="margin-top:30px;" name="choose">
						// 				<img src="%s">
						// 				<p class="name">%s</p>
						// 				<p class="des">%s</p>
						// 				<p class="price">￥%s</p>
						// 				<p class="amount">X%s</p>
						// 			</div></a>';
						// $cart = sprintf($cartTpl,"#","./adv.png","2016期末试题","描述示范","11","2");
						// $store = sprintf($storeTpl,"商店示范","#","#",$cart);
						// echo $store;
						?>
					</div>
				</div>

				<script>
				$(document).ready(function(){
						$.get("../core/api-main-goods.php",{orders:"cart"},function(data){
							$("#cart").html(data);
						})
					});
				</script>

				<div id="rep-rank" style="float: right;width: 250px;height: 50px;margin-top:20px;color: #FD9850;border-bottom: 2px solid #FD9850;">
					<h3 style="float: left;">信誉排行</h3>
				</div>
			</div>

			<div class="attr-show" id="ofi-show" style="width: 700px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-520px;display: none;border:2px solid #FD9850;border-radius: 5px;">办公用品</div>

			<div class="attr-show" id="ele-show" style="width: 700px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-520px;display: none;border:2px solid #FD9850;border-radius: 5px;">电子产品</div>
			<div class="attr-show" id="spo-show" style="width: 700px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-520px;display: none;border:2px solid #FD9850;border-radius: 5px;">体育用品</div>
			<div class="attr-show" id="foo-show" style="width: 700px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-520px;display: none;border:2px solid #FD9850;border-radius: 5px;">食品</div>
			<div class="attr-show" id="dai-show" style="width: 700px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-520px;display: none;border:2px solid #FD9850;border-radius: 5px;">日常用品</div>
			<script>
				$(document).mousemove(function(){
					if ($("#office").is(":hover") || $("#ofi-show").is(":hover")) {
						$("#ofi-show").css("display","block");
						// $("#goods-show").css("top","20px");
					}else{
						$("#ofi-show").css("display","none");
					}
					if ($("#electronic").is(":hover") || $("#ele-show").is(":hover")) {
						$("#ele-show").css("display","block");
					}else{
						$("#ele-show").css("display","none");
					}
					if ($("#sports").is(":hover") || $("#spo-show").is(":hover")) {
						$("#spo-show").css("display","block");
					}else{
						$("#spo-show").css("display","none");
					}
					if ($("#food").is(":hover") || $("#foo-show").is(":hover")) {
						$("#foo-show").css("display","block");
					}else{
						$("#foo-show").css("display","none");
					}
					if ($("#daily").is(":hover") || $("#dai-show").is(":hover")) {
						$("#dai-show").css("display","block");
					}else{
						$("#dai-show").css("display","none");
					}
				});
			</script>

		</div>
	</div>
	<div id="goods-show" style="z-index: 1;top:740px;">
		<script>
		function jud(){
			if ($("#tabs-1").css("display")=="block") {
    			$("#tabs1").css("background-color","#FD9850");
    			$("#tabs2").css("background-color","white");
    		}else{
    			$("#tabs2").css("background-color","#FD9850");
    			$("#tabs1").css("background-color","white");
    		}
		}
  		$(document).ready(function() {
  			jud();
    		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" ).click(function(){
    			jud();
    		});

    		var mySwiper = new Swiper ('.swiper-container', {
    			onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
    				swiperAnimateCache(swiper); //隐藏动画元素 
    				swiperAnimate(swiper); //初始化完成开始动画
  				}, 
  				onSlideChangeEnd: function(swiper){ 
    				swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
  				},
    			loop: true,
    
    			// 如果需要分页器
    			pagination: '.swiper-pagination',
    
    			// 如果需要前进后退按钮
    			nextButton: '.swiper-button-next',
    			prevButton: '.swiper-button-prev',
    
    			// 如果需要滚动条
    			scrollbar: '.swiper-scrollbar', 
    			autoplay: 3000,
  			});     
		});
  		</script>
  		<style>
		.goods{
			color: black;
			width: 225px;
			margin:6px;
			height:250px;
			border:1px solid #CCCCCC;
			float: left;
			border-radius: 5px;
			transition-duration: 0.4s;
			text-align: center;
		}
		.goods:hover{
			background-color: #e8e8e8;
			color: #FD9850;
		}
		.goods img{
			width: 180px;
			height: 120px;
			margin-top: 20px;
		}
		.goods h2{margin: 0;margin-left: 15px;color: #FD9850;text-align: left;width: 200px;}
		.goods p{margin: 0;font-size: 12px;text-align: left;color: #404040;width: 170px;height: 40px;margin-left: 25px;}
  		</style>
  		<div style="width: 1228px;">
			<div id="tabs" style="width:960px;border:none;float: left;">
  				<ul>
    				<li id="tabs1"><a href="#tabs-1" >最新</a></li>
    				<li id="tabs2"><a href="#tabs-2">最热</a></li>
  				</ul>
  				<div id="tabs-1" style="height: 500px;padding: 0;">
					<a href="#"><div class="goods">
						<img src="./cover.png">
						<h2>￥21</h2>
						<p>商品名称12345687897894613fsdfweaf</p>
						<p>卖家名称</p>
					</div></a>
					<a href="#"><div class="goods">
						<img src="./cover.png">
						<h2>￥21</h2>
						<p>商品名称</p>
						<p>卖家名称</p>
					</div></a>
					<a href="#"><div class="goods">
						<img src="./cover.png">
						<h2>￥21</h2>
						<p>商品名称</p>
						<p>卖家名称</p>
					</div></a>
					<?php
						// $goodsTpl = '<a href=" %s "><div class="goods">
						// 				<img src=" %s ">
						// 				<h3>%s</h3>
						// 				<p id="des">%s</p>
						// 			</div></a>';
						// $goods = sprintf($goodsTpl,"#","./adv.png","abc","这是一段文字");
						// for ($i=0; $i < 6; $i++) { 
						// 	echo $goods;
						// }
					?>
  				</div>
  				<div id="tabs-2" style="height: 500px;padding: 0;">
					最热
  				</div>

				<script>
					$(document).ready(function(){
						$.get("../core/api-main-goods.php",{
							rank:"new",
							amount:20
						},function(data){
							$("#tabs-1").html(data);
						})
					});					
				</script>

			</div>
		</div>
	</div>

	<!-- <div id="attr-show" style="width: 600px;height: 600px;background-color: green;float: left;z-index: 1;position: absolute;left: 0;height: 0;"></div> -->
</body>
</html>