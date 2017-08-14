<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php 
		session_start();
	?>
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
		input[name='submit_search']{
			height: 36px;width: 120px;background-color: #FD9850;color: white;border:none;float: left;
			transition-duration: 0.4s;
		}
		input[name='submit_search']:hover{
			background-color: #FFCC66;
		}
		#main-show,#goods-show{
			position: absolute;
			left:calc(50% - 614px);
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
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css">
	<script src="../js/swiper.animate1.0.2.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>

	<div id="go-back"><a href="#main-show">回到顶端</a></div>

	<?php  include "../frame/head_user.php"; ?>
	
	<script>
	$(document).ready(function(){
		// var wth = parseInt($("body").css('width').split("px")[0]);
		// console.log((wth-1228)/2);
		// $("#main-show").css("left",(wth-1228)/2);
		// $("#goods-show").css("left",(wth-1228)/2);
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
			<div id="lt-attr" style="width: 215px;height: 520px;background-color: #FD9850;float: left;border-radius: 5px;margin-right: 5px;">
				<h3 style="float: left;margin-left: 27px;color: white;margin-bottom: 12px;">商品类目(待议)</h3>
				<div id="attr-list" style="width: inherit;height: 400px;/*border:1px solid black;*/margin-top:60px;">
					<div class="list-item" name="reality">
						<img src="../pic/bag.png">
						<a href="?catagory=实体商品&tgt=cl_lv_1">实体商品</a>
					</div>
					<div class="list-item" name="virtual">
						<img src="../pic/cyber.png">
						<a href="?catagory=非实体商品&tgt=cl_lv_1" id="virtual">非实体商品</a>
					</div>
					<div class="list-item" name="beikeinfo">
						<img src="../pic/wave.png">
						<a href="../info/info.php" id="beikeinfo">贝壳信息</a>
					</div>
				</div>
			</div>
			
			<script>
			$(document).ready(function(){
				$("[name='reality']").click(function(){
					console.log("reality");
				});
				$("[name='virtual']").click(function(){
					console.log("virtual");
				});
				$("[name='beikeinfo']").click(function(){
					console.log("beikeinfo");
				});
				$("[name='party']").click(function(){
					console.log("party");
				});
			});
			</script>

			<div id="rt-panel" style="float: left;width: 1008px;min-height: 520px;">
			<?php
				if (!isset($_GET['catagory']) && !isset($_GET['search'])) {
					include "./rt-panel.php";
				}elseif (isset($_GET['catagory']) || isset($_GET['search'])) {
					include "./rt-list.php";
				}
			?>
			</div>

			<style>
				.attr-show{width: 800px;height: 370px;background-color: white;float: left;z-index: 1;position: relative;left: 213px;top:-480px;display: none;border:4px solid #FD9850;border-radius: 5px;}
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

			<script>
			$(document).ready(function(){
				$(".attr-show").css("top","-"+($("#rt-panel").css("height")));
				// $(".cat-tl").click(function(){
				// 	$(".cat-tl").each(function(){
				// 		$(this).click(function(){
				// 			console.log($(this).attr("name"));
				// 			window.location="../login/login.php";
				// 			return false;
				// 		});
				// 	});
				// });
			});
			</script>

			<div class="attr-show" id="vir-show" name="virtual+">
				<div class="sec-cat">
					<div class="cat-tl" name="party">
						<img src="../pic/party.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=轰趴聚会&tgt=cl_lv_2" style="font-size: 17px;">轰趴聚会</a>
					</div>
					<div class="second-cat" name="party" style="margin-bottom: 70px;">
						<a href="?catagory=轰趴聚会&tgt=cl_lv_2"><img src="../pic/image1/party.png" ></a>
					</div>

					<div class="cat-tl" name="video">
						<img src="../pic/video.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=视频&tgt=cl_lv_2" style="font-size: 17px;">视频</a>
					</div>
					<div class="second-cat" name="video" style="margin-bottom: 70px;">
						<a href="?catagory=视频&cl=cl_lv_2" style="font-size: 17px;"><img src="../pic/image1/camera.png" ></a>
					</div>
				</div>
				<div class="sec-cat">
					<div class="cat-tl" name="travel">
						<img src="../pic/travel.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=北京周边游&tgt=cl_lv_2" style="font-size: 17px;">北京周边游</a>
					</div>
					<div class="second-cat" name="travel" style="margin-bottom: 70px;">
						<a  href="?catagory=北京周边游&tgt=cl_lv_2" style="font-size: 17px;"><img src="../pic/image1/beijing.png" ></a>
					</div>

					<div class="cat-tl" name="PPT">
						<img src="../pic/ppt.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a  href="?catagory=PPT&cl=lv_2" style="font-size: 17px;">PPT</a>
					</div>
					<div class="second-cat" name="PPT" style="margin-bottom: 70px;">
						<a href="?catagory=PPT&cl=lv_2" style="font-size: 17px;"><img src="../pic/image1/ppt.png" ></a>
					</div>
				</div>
				<div class="sec-cat">
					<div class="cat-tl" name="photo">
						<img src="../pic/camera.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=photo&cl=lv_2" style="font-size: 17px;">摄影</a>
					</div>
					<div class="second-cat" name="photo" style="margin-bottom: 70px;">
						<a href="?catagory=photo&cl=lv_2" style="font-size: 17px;"><img src="../pic/image1/camera1.png" ></a>
					</div>

					<div class="cat-tl">
						<img src="../pic/guitar.png" name="music-edu" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=music-edu&cl=lv_2" style="font-size: 17px;">乐器培训</a>
					</div>
					<div class="second-cat" name="music-edu" style="margin-bottom: 70px;">
						<a href="?catagory=music-edu&cl=lv_2" style="font-size: 17px;"><img src="../pic/image1/instrument.png" ></a>
					</div>
				</div>
				<div class="sec-cat">
					<div class="cat-tl" name="design">
						<img src="../pic/pen.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=design" style="font-size: 17px;">设计</a>
					</div>
					<div class="second-cat" name="design" style="margin-bottom: 70px;">
						<a href="?catagory=design" style="font-size: 17px;"><img src="../pic/image1/design.png" ></a>
					</div>

					<div class="cat-tl" name="vir-others">
						<img src="../pic/magnifier.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=vir-others" style="font-size: 17px;">其他</a>
					</div>
				</div>
			</div>

			<div class="attr-show" id="inf-show" name="beikeinfo+" style="height: 0;width: 0;"></div>

			<div class="attr-show" id="rea-show" name="reality+">
				<div style="width: 220px;height: inherit;margin-left: 40px;float: left;">
					<div class="cat-tl" name="begin">
						<img src="../pic/pen.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=开学季&tgt=cl_lv_2" style="font-size: 17px;">开学季</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=开学季&tgt=cl_lv_2">全部</a>
						<a href="?catagory=二手教材书&tgt=cl_lv_3">二手教材书</a>
						<a href="?catagory=军训用品&tgt=cl_lv_3">军训用品</a>
						<a href="?catagory=被子&tgt=cl_lv_3">被子</a>
						<a href="?catagory=电话卡&tgt=cl_lv_3">电话卡</a>
						<a href="?catagory=其他&tgt=cl_lv_3">其他</a>
					</div>

					<div class="cat-tl" >
						<img src="../pic/electronic.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=电子产品&tgt=cl_lv_2" style="font-size: 17px;">电子产品</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=电子产品&tgt=cl_lv_2">全部</a>
						<a href="?catagory=手机配件&tgt=cl_lv_3">手机配件</a>
						<a href="?catagory=电脑配件&tgt=cl_lv_3">电脑配件</a>
						<a href="?catagory=其他&tgt=cl_lv_3">其他</a>
					</div>
					<div class="cat-tl" >
						<img src="../pic/book.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=书类&tgt=cl_lv_2" style="font-size: 17px;">书类</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=书类&tgt=cl_lv_2">全部</a>
						<a href="?catagory=教材&tgt=cl_lv_3">教材</a>
						<a href="?catagory=课外书&tgt=cl_lv_3">课外书</a>
						<a href="?catagory=杂志订阅&tgt=cl_lv_3">杂志订阅</a>
						<a href="?catagory=GRE&tgt=cl_lv_3">GRE</a>
						<a href="?catagory=雅思托福&tgt=cl_lv_3">雅思托福</a>
						<a href="?catagory=学霸笔记&tgt=cl_lv_3">学霸笔记</a>
						<a href="?catagory=复习资料&tgt=cl_lv_3">复习材料</a>
						<a href="?catagory=其他&tgt=cl_lv_3">其他</a>
					</div>
				</div>
				<div style="width: 220px;height: inherit;margin-left: 40px;float: left;">
					<div class="cat-tl" name="food">
						<img src="../pic/food.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=吃喝" style="font-size: 17px;">吃喝</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=food">全部</a>
						<a href="?catagory=snacks">零食</a>
						<a href="?catagory=specialty">特产</a>
						<a href="?catagory=drink">饮品</a>
						<a href="?catagory=food-others">其他</a>
					</div>
					<div class="cat-tl" name="life">
						<img src="../pic/daily.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=life" style="font-size: 17px;">生活用品</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=life">全部</a>
						<a href="?catagory=bed">床上用品</a>
						<a href="?catagory=stationary">学习用品</a>
						<a href="?catagory=wash">洗漱用品</a>
						<a href="?catagory=daily">日常用品</a>
						<a href="?catagory=life-others">其他</a>
					</div>
					<div class="cat-tl" name="cloths">
						<img src="../pic/cloths.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=cloths" style="font-size: 17px;">服饰</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=cloths">全部</a>
						<a href="?catagory=men-clo">男装</a>
						<a href="?catagory=wmn-clo">女装</a>
						<a href="?catagory=shoes">鞋</a>
						<a href="?catagory=hat">帽</a>
						<a href="?catagory=scarf">围巾</a>
						<a href="?catagory=glove">手套</a>
						<a href="?catagory=cloths-others">其他</a>
					</div>
				</div>
				<div style="width: 220px;height: inherit;margin-left: 40px;float: left;">
					<div class="cat-tl" name="instrument">
						<img src="../pic/music.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=instrument" style="font-size: 17px;">乐器</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=instrument">全部</a>
						<a href="?catagory=guitar">吉他</a>
						<a href="?catagory=violin">小提琴</a>
						<a href="?catagory=ukulele">尤克里里</a>
						<a href="?catagory=">口琴</a>
						<a >其他</a>
					</div>
					<div class="cat-tl" name="sports">
						<img src="../pic/sports.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=sports" style="font-size: 17px;">体育用品</a>
					</div>
					<div class="second-cat">
						<a href="?catagory=sports">全部</a>
						<a href="?catagory=ball">球类</a>
						<a href="?catagory=competition">竞技类</a>
						<a href="?catagory=aerobic">有氧类</a>
						<a href="?catagory=fitness">健身类</a>
						<a href="?catagory=sports-others">其他</a>
					</div>
					<div class="cat-tl" name="clo-custom">
						<img src="../pic/dress.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=clo-custom" style="font-size: 17px;">服装定制</a>
					</div>
					<div class="second-cat" style="height: 10px;"></div>
					<div class="cat-tl" name="others">
						<img src="../pic/magnifier.png" style="width: 25px;height: 25px;margin-left:15px;" />
						<a href="?catagory=others" style="font-size: 17px;">其他</a>
					</div>
					<div class="second-cat" style="height: 10px;"><div>
				</div>
			</div>
			
			
			<script>
				$(document).mousemove(function(){
					$(".list-item").each(function(){
						var name = $(this).attr("name");
						if ($(this).is(":hover")|| $("div[name='"+name+"+']").is(":hover")){
							$(".attr-show").css("display","none");
							$("div[name='"+name+"+']").css("display","block");
							return false;
						}else{
							$("div[name='"+name+"+']").css("display","none");
						}
					});
				});
			</script>

		<!-- </div> -->
	</div></div></div>


	<?php
		if (!isset($_GET['catagory']) && !isset($_GET['search'])) {
			include "./goods-show.php";
		}
	?>
</body>
</html>