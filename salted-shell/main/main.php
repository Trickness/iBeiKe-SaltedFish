<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>贝壳商城-让你的闲置动起来(O(∩_∩)O)</title>
	<style>
		.bk{ 
		  background: linear-gradient(to bottom, rgba(255,204,102,1), rgba(255,153,0,1));
		  width: 100%;
		  height: 50px;
		  padding-left: 10%;
		}
		.bk1{
			background: linear-gradient(to bottom, rgba(255,204,102,1), rgba(255,153,0,1));
		}
		.classify{
			border: 1px solid #CCCCCC;
			width: 100%;
			height: 50px;
			padding: 15px;
		}
		.classify:hover{
			border-left: 5px solid #FFCC00;
		}
		.nv li{
			font-size: 15px;
			border-radius: 5px;
		}
		.nv li:hover{
			background-color: #FF9900;
		}
	</style>
</head>
<body>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>

	<div class="container">
		<div class="col-md-3">
			<img src="../pic/beikelogo.png" style="width: 60px;height: 60px;margin-left: -50px">
			<img src="../pic/beikeshop.png" style="height: 60px;">
		</div>
		<div class="col-md-offset-7 col-md-2">
			<a href="#">登陆</a>
			<a href="#" style="margin-left: 30px;">注册</a>
		</div>
	</div>
	
	<nav class="navbar navbar-default bk">
		<div class="container-fluid">
			<ul class="nav navbar-nav nv">
				<li><a href="#">首页</a></li>
				<li><a href="#">新品抢鲜</a></li>
				<li><a href="#">优选市场</a></li>
				<li><a href="#">推荐店家</a></li>
			</ul>
    	</div>
    </nav>
	
	<div class="container" style="width: 100%">
		<div class="row">
			<div class="col-md-2 col-md-offset-1">
				<h4>优选市场</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-1">
				<div class="classify">
					<a href="#">办公用品</a>
				</div>
				<div class="classify">
					<a href="#">电子产品</a>
				</div>
				<div class="classify">
					<a href="#">数码产品</a>
				</div>
				<div class="classify">
					<a href="#">食品</a>
				</div>
				<div class="classify">
					<a href="#">生活日用</a>
				</div>
			</div>
			<div class="col-md-6">
				<div id="myCarousel" class="carousel slide">
				<!-- 轮播（Carousel）指标 -->
					<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
					</ol>   
				<!-- 轮播（Carousel）项目 -->
					<div class="carousel-inner" style="height: 250px">
						<div class="item active">
							<img src="../pic/backgroundimg.PNG" style="height: 250px;width: 500px;" alt="First slide">
						</div>
						<div class="item"><center>
							<img src="../pic/bk4.png" style="height: 250px;width: 300px;" alt="Second slide">
						</center></div>
						<div class="item">
							<img src="../pic/dom.PNG" style="height: 250px;width: 500px;" alt="Third slide">
						</div>
					</div>
				<!-- 轮播（Carousel）导航 -->
					<a class="carousel-control left" href="#myCarousel" 
	 					data-slide="prev"><div style="width:50px;height:50px;border:2px solid white;border-radius:25px;margin-top:100px;margin-left:10px;font-size:30px;">&lsaquo;</div></a>
					<a class="carousel-control right" href="#myCarousel" 
						data-slide="next"><div style="width:50px;height:50px;border:2px solid white;border-radius:25px;margin-top:100px;font-size:30px;">&rsaquo;</div></a>
					<script>
						$(function () {
							$("#myCarousel").carousel({
								interval:1500
							});
						});	
					</script> 
				</div>
			</div>

			<style>
				.rt{
					background: linear-gradient(to bottom, rgba(255,204,102,1), rgba(255,153,0,1));
					width: 100%;height: 50px;
					margin-top: 10px;margin-bottom:10px;
					font-size: 20px;text-align: center;padding-top: 10px;
				}
				.rt:hover{
					background: #FF9900;
				}
			</style>
			<div class="col-md-2" style="background-color: #EEEEEE;">
				<div class="rt">
					<a href="#">发布闲置</a>
				</div>
				<div class="rt">
					<a href="#">新手教程</a>
				</div>
			</div>
			<div class="col-md-2" style="background-color: #EEEEEE;margin-top: 20px;padding: 20px;height: 100px;">
				<p>收录商品数量：</p>
				<p>总交易量：</p>
			</div>
		</div>


		<div class="row"  style="margin-top: 20px;">
				<div class="col-xs-offset-1 col-xs-7">
					<ul class="nav nav-tabs">
  						<li id="home" role="presentation" class="active"><a href="#abc">Home</a></li>
  						<li id="pro" role="presentation"><a href="#">Profile</a></li>
  						<li id="mes" role="presentation"><a href="#">Messages</a></li>
					</ul>
				</div>
		</div>
		<div class="row">
			<div class="col-xs-8 col-xs-offset-1">
				<div class="row" style="margin-top: 20px;width: 90%;">
					<div id="abc1" style="background-color: #EEEEEE;width: 100%;height: 500px;display: block;"></div>
					<div id="abc2" style="background-color: #FFCC66;width: 100%;height: 500px;display: none;"></div>
					<div id="abc3" style="background-color: #FFCCFF;width: 100%;height: 500px;display: none;"></div>
				</div>
			</div>
			<div class="col-xs-2" style="height: 500px;background-color: #EEEEEE;margin-top: 20px"></div>
		</div>

		<script>
			$("#home").click(function(){
				$("#abc1").css('display','block');
				$("#abc2").css('display','none');
				$("#abc3").css('display','none');
				$(".nav li").removeClass("active");
				$(this).addClass("active");
			});
			$("#pro").click(function(){
				$("#abc1").css('display','none');
				$("#abc2").css('display','block');
				$("#abc3").css('display','none');
				$(".nav li").removeClass("active");	
				$(this).addClass("active");	
			});
			$("#mes").click(function(){
				$("#abc1").css('display','none');
				$("#abc2").css('display','none');
				$("#abc3").css('display','block');
				$(".nav li").removeClass("active");
				$(this).addClass("active");
			});
		</script>

	</div>

</body>
</html>