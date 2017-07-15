<!DOCTYPE html>
<html>
<head>
	<?php session_start(); ?>
	<meta charset="utf-8">
	<title>个人中心</title>
	<style>
		body{margin:0;min-width: 1203px;}
		a{text-decoration: none;color: black;}
		a:hover{color: #FD9850;}
		#head-row{position: absolute;top: 130px;height: 400px;width: 965px;}
		#user-info{float: left;width: 165px;height: inherit;}
		#info{width: 180px;height: 265px;padding-left: 20px;}

		#cen-row{float: left;height: inherit;width: 780px;}
		#cen-bottom{float: left;border-bottom: 2px solid #FD9850;width: 750px;margin-top: 10px;margin-left: 20px;}
		#bottom-tl{font-size: 22px;float: left;margin-bottom: 5px;}
		#rt-new{width: 250px;height: inherit;position: absolute;top: 130px;height: 1000px;}
		#new-tl{border-bottom: 2px solid #FD9850;font-size: 22px;padding-bottom: 10px;width: inherit;}

		#recent{position: absolute;top: 530px;width: 780px;height: 600px;}
	</style>
</head>
<body>
	<?php
		require_once "../core/users.php";
        require_once "../core/utils.php";
        require_once "../core/authorization.php";
        require_once "../config.php";
        
        $session = session_id();
        // $self_info = fetch_self_info($session);
	?>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css">
	<script src="../js/swiper.animate1.0.2.min.js"></script>

	<script>
	$(document).ready(function(){
		var wth = parseInt($("body").css('width').split("px")[0]);
		var head_wth = parseInt($("#head-row").css('width').split("px")[0]);
		var info_wth = parseInt($("#user-info").css('width').split("px")[0]);
		console.log((wth-1203)/2);
		$("#head-row").css("left",(wth-1203)/2);
		$("#rt-new").css("left",(wth-1203)/2+head_wth);
		$("#recent").css("left",(wth-1203)/2+170);
		$("#users-tl").addClass("active");
	});
	</script>
	<?php include '../frame/head_user.php'; ?>
	<div id="head-row">
		<div id="user-info">
			<img src="../main/adv.png" style="width: 120px;height: 120px;border-radius: 60px;margin:35px;margin-bottom:10px;margin-top:0;border:1px solid black;">

			<style>
				#head-info,#basic-info{line-height: 25px;}
				#basic-tl{color:#FD9850;font-size: 18px;margin-top: 10px;margin-bottom: 10px;}
			</style>
			<div id="info">
				<div id="head-info">
					ID:<br>
					昵称:<br>
				</div>
				<div id="basic-tl"><b>基本信息</b></div>
				<div id="basic-info">
					姓名:<br>
					学生类别:<br>
					性别:<br>
					生日:<br>
					宿舍:<br>
					手机号:
				</div>
			</div>

			<script>
				$(document).ready(function(){
					$.getJSON("../core/api-users-info.php?action=self",{session:"<?php echo $session;?>"},function(data){
						$("#head-info").html("ID:"+data.student_id+"<br>"+"昵称:"+data.nickname);
						$("#basic-info").html("姓名:"+data.name+"<br>"+
											  "学生类别:"+data.type+"<br>"+
											  "性别:"+data.gender+"<br>"+
											  "生日:"+data.birthday+"<br>"+
											  "宿舍:"+data.dormitory.dormitory_id+"#"+data.dormitory.room_no+"<br>"+
											  "手机号:"+data.phone_number
							);
					});
				});
			</script>
		</div>
		<div id="cen-row">
			<div id="cen-swiper" class="swiper-container" style="height: 330px;margin-left: 30px;float: left;width: 750px;">
	    				<div class="swiper-wrapper">
	    	   				<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../main/slider1.jpg" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInUp" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../main/slider2.jpg" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="0.5s" 
	    	   					swiper-animate-delay="0.3s" src="../main/slider3.jpg" style="height: 300px;width: 740px;"></div>
	    				</div>
	    				<!-- 如果需要分页器 -->
	    				<div class="swiper-pagination"></div>
	    
	    				<!-- 如果需要导航按钮 -->
	    				<div class="swiper-button-prev swiper-button-white"></div>
	    				<div class="swiper-button-next swiper-button-white"></div>
	    	
	    				<!-- 如果需要滚动条 -->
	    				<div class="swiper-scrollbar"></div>
			</div>
			<div id="cen-bottom">
				<div id="bottom-tl">最近逛逛</div>
			</div>
		</div>
	</div>

	<div id="rt-new">
		<style>
			.new-item{width: 228px;height: 210px;border: 1px solid #CCCCCC;margin: 10px;transition-duration: 0.4s;}
			.new-tl{padding-left: 10px;}
			.new-dec{padding-left: 10px;font-size: 12px;}
			.new-item:hover{background-color: #e8e8e8;}
			.new-item img{width: 228px;height: 151px;}
		</style>
		<div id="new-tl">最新内容</div>
		<div id="new-content">
			<a href="#"><div class="new-item">
				<img src="../main/cover.png">
				<div class="new-tl">商品名称</div>
				<div class="new-dec">文字描述XXXXXXX</div>
			</div></a>
			<a href="#"><div class="new-item">
				<img src="../main/cover.png">
				<div class="new-tl">商品名称</div>
				<div class="new-dec">文字描述XXXXXXX</div>
			</div></a>
			<a href="#"><div class="new-item">
				<img src="../main/cover.png">
				<div class="new-tl">商品名称</div>
				<div class="new-dec">文字描述XXXXXXX</div>
			</div></a>
		</div>
	</div>

	<script>
	$(document).ready(function(){
		$.get("../core/api-users-info.php?action=new",function(data){
			$("#new-content").html(data);
		});
	});
	</script>

	<style>
		.recent-item{width: 228px;height: 210px;border: 1px solid #CCCCCC;margin-left: 25px;margin-bottom: 10px;transition-duration: 0.4s;float: left;}
		.recent-tl{padding-left: 10px;}
		.recent-dec{padding-left: 10px;font-size: 12px;}
		.recent-item:hover{background-color: #e8e8e8;}
		.recent-item img{width: 228px;height: 151px;}
	</style>
	<div id="recent">
		<a href="#"><div class="recent-item">
				<img src="../main/cover.png">
				<div class="recent-tl">商品名称</div>
				<div class="recent-dec">文字描述XXXXXXX</div>
		</div></a>
		<a href="#"><div class="recent-item">
				<img src="../main/cover.png">
				<div class="recent-tl">商品名称</div>
				<div class="recent-dec">文字描述XXXXXXX</div>
		</div></a>
		<a href="#"><div class="recent-item">
				<img src="../main/cover.png">
				<div class="recent-tl">商品名称</div>
				<div class="recent-dec">文字描述XXXXXXX</div>
		</div></a>
		<a href="#"><div class="recent-item">
				<img src="../main/cover.png">
				<div class="recent-tl">商品名称</div>
				<div class="recent-dec">文字描述XXXXXXX</div>
		</div></a>
	</div>

	<script>
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
	</script>
</body>
</html>