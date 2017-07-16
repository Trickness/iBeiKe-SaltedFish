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
		#info{width: 160px;height: 265px;padding-left: 20px;}

		#cen-row{float: left;height: inherit;width: 780px;}
		#cen-bottom{float: left;border-bottom: 2px solid #FD9850;width: 750px;margin-top: 10px;margin-left: 20px;}
		#bottom-tl{font-size: 22px;float: left;margin-bottom: 5px;color: #FD9850;}
		#rt-new{width: 250px;height: inherit;position: absolute;top: 120px;height: 1000px;}
		#new-tl{border-bottom: 2px solid #FD9850;font-size: 22px;padding-bottom: 10px;width: inherit;color: #FD9850;}

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
	?>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
	<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css">
	<script src="../js/swiper.animate1.0.2.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>

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
				#info label{float: left;}
				.info-item{height: 22px;}
			</style>
			<div id="info">
				<div id="head-info">
					<div><label>ID:</label><span id="student_id" class="info-item"></span><br></div>
					<div><label>昵称:</label><span id="nickname" class="info-item"></span><br></div>
				</div>
				<div id="basic-tl"><b>基本信息</b></div>
				<div id="basic-info">
					<div><label>姓名:</label><span id="name" class="info-item"></span><br></div>
					<div><label>学生类别:</label><span id="type" class="info-item"></span><br></div>
					<div><label>性别:</label><span id="gender" class="info-item"></span><br></div>
					<div><label>生日:</label><span id="birthday" class="info-item"></span><br></div>
					<div><label>宿舍:</label><span id="dormitory" class="info-item"></span><br></div>
					<div><label>手机号:</label><span id="phone_number" class="info-item"></span></div>
				</div>
			</div>
			<div id="info-bottom" style="padding-left: 30px;">
				<button id="change-info" class="button button-action button-rounded button-highlight button-small button-longshadow-left" >
					修改信息</button>
				<button id="update-info" style="display: none;margin-bottom: 5px;" class="button button-action button-rounded 
					button-highlight button-tiny button-longshadow-left">提交</button>
				<button id="update-cancel" style="display: none;" class="button button-action button-rounded button-highlight button-tiny 
					button-longshadow-left">取消</button>
			</div>

			<script>
				var self_info = "";
				$(document).ready(function(){
					function change_info(data){
						$("#student_id").html(data.student_id);
						$("#nickname").html(data.nickname);
						$("#name").html(data.name);
						$("#type").html(data.type);
						$("#gender").html(data.gender);
						$("#birthday").html(data.birthday);
						$("#dormitory").html(data.dormitory);
						$("#phone_number").html(data.phone_number);
					}

					$.getJSON("../core/api-users-info.php?action=self",function(data){
						self_info = data;
						self_info.dormitory = self_info.dormitory.dormitory_id+"#"+self_info.dormitory.room_no;
						change_info(self_info);
					});
					$("#change-info").click(function(){
						$(".info-item").each(function(){
							$(this).css("float","right");
							$(this).html("<input type='text' class='item' name='"+$(this).attr("id")+"' style='width:85px;margin:0;' value='"+self_info[$(this).attr("id")]+"' />");
						});
						$(this).css('display','none');
						$("#update-info").css("display","block");
						$("#update-cancel").css("display","block");
						$("#info-bottom").css("padding-left","70px");
					});
					$("#update-cancel").click(function(){
						change_info(self_info);
						$(".info-item").css("float","left");
						$(this).css('display','none');
						$("#update-info").css("display","none");
						$("#change-info").css("display","block");
						$("#info-bottom").css("padding-left","30px");
					});
					$("#update-info").click(function(){
						var new_info = self_info;
						$(".item").each(function(){
							if ($(this).attr('name')=="dormitory") {
								var dom_info =  $(this).val().split("#");
								dom_info = {dormitory_id:dom_info[0],room_no:dom_info[1]};
								new_info[$(this).attr('name')] = dom_info;
							}else{
								new_info[$(this).attr('name')] = $(this).val();
							}
						});
						$.get("../core/api-users-info.php?action=update",{user_info:JSON.stringify(new_info)},function(data){
							if (data!=false) {
								new_info.dormitory = new_info.dormitory.dormitory_id+"#"+new_info.dormitory.room_no;
								change_info(new_info);
								$(".info-item").css("float","left");
								$("#update-cancel").css('display','none');
								$("#update-info").css("display","none");
								$("#change-info").css("display","block");
								$("#info-bottom").css("padding-left","30px");
							}
						});
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