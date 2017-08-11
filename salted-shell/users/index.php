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
		#info{width: 160px;height: 240px;padding-left: 20px;}

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

	<link href="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>

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
			<img src="../main/adv.png" style="width: 120px;height: 120px;border-radius: 60px;margin:35px;margin-bottom:10px;margin-top:0;">

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
				</div>
			</div>
			<div id="info-bottom" style="padding-left: 30px;">
				<!-- <button id="change-info" class="button button-action button-rounded button-highlight button-small" >
					修改信息</button>
				<button id="upload-goods" class="button button-action button-rounded button-highlight button-small">发布商品</button>
				<button id="upload-info" class="button button-action button-rounded button-highlight button-small">发布信息</button> -->

				<!-- <button id="update-info" style="display: none;margin-bottom: 5px;" class="button button-action button-rounded 
					button-highlight button-tiny button-longshadow-left">提交</button>
				<button id="update-cancel" style="display: none;" class="button button-action button-rounded button-highlight button-tiny 
					button-longshadow-left">取消</button> -->
			</div>
			<span class="button-dropdown button-dropdown-primary" data-buttons="dropdown" style="margin-left:15px;">
    					<button class="button button-primary button-large" style="font-size:15px;">
      						<i class="fa fa-bars"></i>骚操作
    					</button>
 
    				<ul class="button-dropdown-list is-below">
      					<li><a href="http://www.bootcss.com/"><i class="fa fa-heart-o"></i>个人信息修改</a></li>
      					<li class="button-dropdown-divider"><a href="../goods/upload.php">上传商品</a></li>
						<li class="button-dropdown-divider"><a href="../users/orders.php">我的订单</a></li>
      					<li><a href="#">发布信息</a></li>
    				</ul>
  			</span>

			<script>
				var self_info = "";
				$(document).ready(function(){
					function change_info(data){
						$("#student_id").html(data.student_id.value);
						$("#nickname").html(data.nickname);
						$("#name").html(data.name.value);
						$("#type").html(data.type.value);
						$("#gender").html(data.gender.value);
						$("#birthday").html(data.birthday.value);
						$("#dormitory").html(data.dormitory.value);
					}

					$.getJSON("../core/api-users-info.php?action=self",function(data){
						self_info = data;
						// self_info.nickname.value = data.nickname;
						self_info.dormitory.value = self_info.dormitory.dormitory_id.value+"#"+self_info.dormitory.room_no.value;
						change_info(self_info);
					});
					
					// $("#change-info").click(function(){
					// 	$(".info-item").each(function(){
					// 		$(this).css("float","right");
					// 		$(this).html("<input type='text' class='item' name='"+$(this).attr("id")+"' style='width:85px;margin:0;' value='"+self_info[$(this).attr("id")]['value']+"' />");
					// 	});
					// 	$(this).css('display','none');
					// 	$("#update-info").css("display","block");
					// 	$("#update-cancel").css("display","block");
					// 	$("#info-bottom").css("padding-left","70px");
					// });
					// $("#update-cancel").click(function(){
					// 	change_info(self_info);
					// 	$(".info-item").css("float","left");
					// 	$(this).css('display','none');
					// 	$("#update-info").css("display","none");
					// 	$("#change-info").css("display","block");
					// 	$("#info-bottom").css("padding-left","30px");
					// });
					// $("#update-info").click(function(){
					// 	var new_info = self_info;
					// 	$(".item").each(function(){
					// 		if ($(this).attr('name')=="dormitory") {
					// 			var dom_info =  $(this).val().split("#");
					// 			dom_info = {dormitory_id:dom_info[0],room_no:dom_info[1]};
					// 			new_info[$(this).attr('name')] = dom_info;
					// 		}else{
					// 			new_info[$(this).attr('name')] = $(this).val();
					// 		}
					// 	});
					// 	$.get("../core/api-users-info.php?action=update",{user_info:JSON.stringify(new_info)},function(data){
					// 		if (data!=false) {
					// 			new_info.dormitory = new_info.dormitory.dormitory_id+"#"+new_info.dormitory.room_no;
					// 			change_info(new_info);
					// 			$(".info-item").css("float","left");
					// 			$("#update-cancel").css('display','none');
					// 			$("#update-info").css("display","none");
					// 			$("#change-info").css("display","block");
					// 			$("#info-bottom").css("padding-left","30px");
					// 		}
					// 	});
					// 	$.getJSON("../core/api-users-info.php?action=self",{session:"<?php echo $session;?>"},function(data){
					// 		console.log(data);
					// 		$("#head-info").html("ID:"+data.student_id.value+"<br>"+"昵称:"+data.nickname);
					// 		$("#basic-info").html("姓名:"+data.name.value+"<br>"+
					// 						  "学生类别:"+data.type.value+"<br>"+
					// 						  "性别:"+data.gender.value+"<br>"+
					// 						  "生日:"+data.birthday.value+"<br>"+
					// 						  "宿舍:"+data.dormitory.dormitory_id+"#"+data.dormitory.room_no+"<br>"
					// 		);
					// 	});
					// });
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
			.new-item{width: 220px;height: 280px;margin: 10px;transition-duration: 0.4s;border-radius:10px;border: 1px solid #CCCCCC;background-color: #e8e8e8;}
			.new-tl{padding-left: 10px;}
			.new-dec{padding-left: 10px;font-size: 12px;}
			.new-item:hover{box-shadow:5px 5px 5px #CCCCCC;}
			.new-item img{width: 220px;height: 220px;border-radius:10px;}
		</style>
		<div id="new-tl">最新内容</div>
		<div id="new-content">
			<a href="#"><div class="new-item">
				<img src="../main/goods.jpg">
				<div class="new-tl">商品名称</div>
				<div class="new-dec">文字描述XXXXXXX</div>
			</div></a>
			<a href="#"><div class="new-item">
				<img src="../main/goods.jpg">
				<div class="new-tl">商品名称</div>
				<div class="new-dec">文字描述XXXXXXX</div>
			</div></a>
			<a href="#"><div class="new-item">
				<img src="../main/goods.jpg">
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
		.recent-order{border: 0.7mm dashed #CCCCCC;height: 115px;width: 718px;margin-left: 25px;border-radius: 10px;margin-bottom:20px;}
		.recent-order:hover{border: 0.7mm solid #e8e8e8;}
		.recent-order td{text-align:center;height:70px;font-size:14px;border-left:1px solid #CCCCCC}
		.recent-tl{background-color:#e8e8e8;width:inherit;height:40px;border-radius: 10px;}
		.recent-tl div{float:left;margin-top:7px;margin-left:10px;}
	</style>
	<div id="recent">
		<!--此处为带滚动条效果的div的样式表  -->
		<!-- <style>
		    #scroll-div {
        		width:750px;
    		    height:400px;
    		    overflow:auto;
				margin-left:15px;
				border-radius:10px;
    		}  
			#scroll-div::-webkit-scrollbar {
    		    width:12px;
    		    height:10px;
    		}
    		#scroll-div::-webkit-scrollbar-button    {
    		    background-color: #FF7677;
    			border-radius: 10px;
    		}
    		#scroll-div::-webkit-scrollbar-track     {}
    		#scroll-div::-webkit-scrollbar-track-piece {}
    		#scroll-div::-webkit-scrollbar-thumb{
    		    background:#FFA711;
    		    border-radius:4px;
    		}
    		#scroll-div::-webkit-scrollbar-corner {
    		    background:#82AFFF;
    		}
    		#scroll-div::-webkit-scrollbar-resizer  {
    		    background:#FF0BEE;
    		}
		</style> -->
		<!--此处为，带滚动条效果的div  -->
		<!-- <div id='scroll-div'>
        	
			<div class="recent-order">
				<div class="recent-tl">
					<div>下单时间：<span name="submit_time">2017-06-06</span></div>			
				</div>
				<div>
					<table>
						<tr>
							<td style="width:240px;text-align:left;padding-left:10px;">
								<img src="../main/goods.jpg" alt="商品" style="width:55px;height:55px;float:left">
								<p style="float:left;margin-left:5px;">正版魔法指南</p>
							</td>
							<td style="width:80px;"><span style="font-size:12px;">￥</span>65.00</td>
							<td style="width:40px;"><span style="font-size:12px;">X</span>2</td>
							<td>=</td>
							<td style="width:85px;"><span style="font-size:12px;">￥</span>130.00</td>
							<td style="width:120px;">买家已下单<br>等待卖家接单</td>
							<td style="width:120px;">编辑<br>删除<br>追加评论</td>
						</tr>
					</table>		
				</div>
			</div>

    	</div> -->

		<!--此处仅为示例用的js，实际应用时需删除  -->
		<!-- <script>
			$(document).ready(function(){
				var scroll = $("#scroll-div").html();
				for (var i = 0; i < 3; i++) {
					scroll+=scroll;
					
				}
				$("#scroll-div").html(scroll);

				
			});
		</script> -->
		<!--示例js  -->
		<div id="order-sort" style="width:720px;height:35px;margin-left:25px;">
			<label for="status-sort">订单状态</label>
			<select id="status-sort" style="margin:5px;">
				<option value="all" selected>全部</option>
				<option value="waiting">等待卖家接单</option>
				<option value="accepted">卖家已接单</option>
				<option value="completed">已确认收货</option>
				<option value="finished">订单已完成</option>
			</select>
			<label for="page-sort">页码</label><input type="text" id="page-sort" value="1" />
			<button id="sort-submit">筛选</button>
		</div>
		<div id="recent-content">

			
		
		</div>

			<div class="recent-order" style="display:none;" id="order-sam">
					<div class="recent-tl">
						<div>下单时间：<span name="submit_time">2017-06-06</span></div>			
					</div>
					<div>
						<table>
							<tr>
								<td style="width:190px;text-align:left;padding-left:10px;">
									<img src="../main/goods.jpg" alt="商品" style="width:55px;height:55px;float:left">
									<p style="float:left;margin-left:5px;" name="goods_title">正版魔法指南</p>
								</td>
								<td style="width:80px;">
									<span style="font-size:12px;">￥</span>
									<span name="price_per_goods">65.00</span>
								</td>
								<td style="width:50px;">
									<span name="goods_count">2</span>
								</td>
								<td style="width:70px;">
									<span style="font-size:12px;">￥</span>
									<span name="deliver_fee">15.00</span>
								</td>
								<td style="width:85px;">
									<span style="font-size:12px;">￥</span>
									<span name="total_cost">130.00</span>
								</td>
								<td style="width:100px;" name="status">
									买家已下单<br>
									等待卖家接单
								</td>
								<td style="width:100px;">
									<a href="#">编辑</a><br>
									<a href="#">删除</a><br>
									<a href="#">追加评论</a>
								</td>
							</tr>
						</table>		
					</div>
			</div>
	
	</div>

	<script>

		$(document).ready(function(){
			var order_sam = $("#order-sam").html();
			
			function show_orders(data){
				var recent = "";
				for (var i = 0; i < data.length; i++) {
					console.log(data[i]);
					recent += '<div class="recent-order" id="'+data[i].order_id+'">'+order_sam+'</div>';
				}
				$("#recent-content").html(recent);
				for (var i = 0; i < data.length; i++) {
					$("#"+data[i].order_id+' [name="submit_time"]').html(data[i].submit_time.split(".")[0]);
					$("#"+data[i].order_id+' [name="price_per_goods"]').html(data[i].price_per_goods);
					$("#"+data[i].order_id+' [name="goods_count"]').html(data[i].goods_count);
					$("#"+data[i].order_id+' [name="deliver_fee"]').html(data[i].deliver_fee);
					var total_cost = parseFloat(data[i].price_per_goods) * parseFloat(data[i].goods_count) + parseFloat(data[i].deliver_fee);
					$("#"+data[i].order_id+' [name="total_cost"]').html(total_cost);
					var status = "";
					switch (data[i].status) {
						case "waiting":
							status = "等待卖家接单";
							break;
						case "accepted":
							status = "卖家已接单";
							break;
						case "completed":
							status = "商品已送到";
							break;
						case "finished":
							status = "订单已完成";
							break;
						default:
							break;
					}
					$("#"+data[i].order_id+' [name="status"]').html(status);
				}
			}

			$.getJSON("../core/api-v1.php",{action: "list_orders"},function(data){show_orders(data);});
			$("#sort-submit").click(function(){
				var status = $("#status-sort").val();
				var page = $("#page-sort").val();
				var sort = {action:"list_orders",status:status,page:page};
				if (status=="all") sort = {action:"list_orders",page:page};
				console.log(sort);
				$.getJSON("../core/api-v1.php",sort,function(data){show_orders(data);});
			});
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
	</script>
</body>
</html>