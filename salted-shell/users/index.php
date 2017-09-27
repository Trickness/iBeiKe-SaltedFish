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

		#recent{position: absolute;top: 530px;width: 780px;min-height: 600px;}
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
	<script src="../js/vue.js"></script>
	<script src="../js/jquery-latest.js"></script>
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
			<img id="header-img" src="../main/adv.png" style="width: 120px;height: 120px;border-radius: 60px;margin:35px;margin-bottom:10px;margin-top:0;">

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
			<div id="info-bottom" style="padding-left: 30px;"></div>
			<span class="button-dropdown button-dropdown-primary" data-buttons="dropdown" style="margin-left:15px;">
    					<button class="button button-primary button-large" style="font-size:15px;">
      						<i class="fa fa-bars"></i>骚操作
    					</button>

    				<ul class="button-dropdown-list is-below">
      					<li><a href="edit-profile.php"><i class="fa fa-heart-o"></i>个人信息修改</a></li>
      					<li class="button-dropdown-divider"><a href="../goods/upload.php">上传商品</a></li>
						<li class="button-dropdown-divider"><a href="../users/orders.php">我的订单</a></li>
      					<li><a href="#">发布信息</a></li>
    				</ul>
  			</span>
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
			.new-item{width: 220px;height: 280px;margin: 10px;transition-duration: 0.4s;border-radius:10px;background-color: #e8e8e8;overflow:hidden;}
			.new-tl{padding-left: 10px;}
			.new-dec{padding-left: 10px;font-size: 12px;}
			.new-item:hover{box-shadow:0 0 10px #CCCCCC;}
			.new-item .img{width: 220px;height: 220px;border-radius:10px;background-size:cover;background-position:center;background-repeat:no-repeat;}
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
				<div class="new-dec">文字描述XXXXXXXXXXXXXXXXXXXX</div>
			</div></a>
		</div>
	</div>

	<script>
	$(document).ready(function(){
		var newGoodsTpl = '<a href="../goods/show.php?goods_id={href}"><div class="new-item">\
						<div class="img" style="background-image:url(\'{goods_img}\');" />\
						<div class="new-tl">{goods_title}</div>\
						<div class="new-dec">{goods_info}</div>\
					</div></a>';
		var goods_list = "";
		// 渲染
		$.getJSON("../core/api-users-info.php?action=new",function(data){
			console.log(data);
			for (var i = 0; i < data['goods'].length; i++) {
				//data[i] = JSON.parse(data[i]);
				//data[i].goods_info = (data[i].goods_info+"").replace(/<img[^>]+>/ig,"");
				//data[i].goods_info = data[i].length>27? data[i].goods_info.substring(0,27)+"..." : data[i].goods_info;
				data['goods'][i].goods_info = data['goods'][i].goods_info.substring(0,27)+"...";
				if(data['goods'][i].goods_img == null || data['goods'][i].goods_img == "")
					data['goods'][i].goods_img = "../main/goods.img";
				goods_list += newGoodsTpl.format(data['goods'][i]);
			}
			console.log(goods_list);
			$("#new-content").html(goods_list);
		});
	});
	</script>

	<style>
		.recent-order{border: 0.7mm dashed #CCCCCC;height: 115px;width: 718px;margin-left: 25px;border-radius: 10px;margin-bottom:20px;}
		.recent-order:hover{border: 0.7mm solid #e8e8e8;}
		.recent-order td{text-align:center;height:70px;font-size:14px;border-left:1px solid #CCCCCC}
		.recent-tl{background-color:#e8e8e8;width:inherit;height:40px;border-radius: 10px;}
		.recent-tl div{float:left;margin-top:7px;margin-left:10px;}

		.ibk_table{width: 100%;background-color: white;}
		.ibk_table th{height: 35px;border: 1px solid #e8e8e8;border-bottom: 2px solid gray;}
		.ibk_table td{border-bottom: 2px solid #e8e8e8;height: 40px;}
		.ibk_table tr{transition-duration: 0.4s;}
		.ibk_table tr:hover{background-color: #e8e8e8;}
	</style>
	<div id="recent">
		<ul>
			<li><a href="#my_orders">我的订单</a></li>
			<li><a href="#my_goods">我的商品</a></li>
		</ul>
		<div id="my_orders" style="padding:20px 0 0 0;">
			<div id="order-sort" style="width:720px;height:35px;margin-left:25px;">
				<label for="order_status-sort">订单状态</label>
				<select id="order_status-sort" style="margin:5px;">
					<option value="all" selected>全部</option>
					<option value="waiting">等待卖家接单</option>
					<option value="accepted">卖家已接单</option>
					<option value="completed">已确认收货</option>
					<option value="finished">订单已完成</option>
				</select>
				<label for="page-sort">页码</label><input type="text" id="page-sort" value="1" />
				<button id="sort-submit">筛选</button>
			</div>

			<div id="order-head" style="width:720px;height:35px;margin-left:25px;">
				<style>#order-head div{float:left;text-align:center;border-bottom:2px solid #FD9860;font-size:14px;}</style>
				<div style="width:210px;">宝贝</div>
				<div style="width:85px;">单价</div>
				<div style="width:50px;">数量</div>
				<div style="width:78px;">运费</div>
				<div style="width:90px;">总计</div>
				<div style="width:100px;">状态</div>
				<div style="width:100px;">操作</div>
			</div>
			<div id="recent-content"></div>
		</div>
		<div id="my_goods">
			<div>
				<table class='ibk_table'>
					<thead><th>商品名</th><th>状态</th><th>数量</th><th>交易方式</th><th>价格</th><th></th></thead>
					<tbody id="user_goods"></tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- 引入商品编辑弹窗 -->
	<?php include './edit-goods.php'; ?>
	<!-- 商品编辑弹窗 -->

	<script>
		var user_info = null;	//个人总体信息
		var edit_goods = null;
		(function(){
		// 信息渲染模板
			var goodsTpl = "<tr>\
						<td><a href='../goods/show.php?goods_id={goods_id}'>{goods_title}</td>\
						<td>{goods_status}</td>\
						<td>{remain}</td>\
						<td>{goods_type}</td>\
						<td>{single_cost}</td>\
						<td style='text-align:center;'><button class='button button-small button-border button-rounded button-highlight' onclick='edit_goods({goods_id})'>修改</button></td>\
					</tr>";
			var newGoodsTpl = '<a href="../goods/show.php?goods_id={href}"><div class="new-item">\
							<img src="../main/goods.jpg" v-bind:src="{goods_img}">\
							<div class="new-tl">{goods_title}</div>\
							<div class="new-dec">{goods_info}</div>\
						</div></a>';

			var ordersTpl = '<div class="recent-order">\
				<div class="recent-tl">\
					<div><span style="margin-right:50px;">下单时间：{ordering_date}</span>卖家：<a name="goods_owner" href="./others.php?user_id={goods_owner}">{goods_owner}</a></div>\
				</div>\
				<div>\
					<table>\
						<tr>\
							<td style="width:190px;text-align:left;padding-left:10px;">\
								<a href="../goods/show.php?goods_id={goods_id}">\
									<img src="{goods_img}" alt="商品" style="width:55px;height:55px;float:left">\
									<p style="float:left;margin-left:5px;">{goods_title}</p>\
								</a>\
							</td>\
							<td style="width:80px;">\
								<span style="font-size:12px;">￥</span>{single_cost}\
							</td>\
							<td style="width:50px;">{purchase_amount}</td>\
							<td style="width:70px;">\
								<span style="font-size:12px;">￥</span>{delivery_fee}\
							</td>\
							<td style="width:85px;">\
								<span style="font-size:12px;">￥</span>{offer}\
							</td>\
							<td style="width:100px;">{order_status}</td>\
							<td style="width:100px;">\
								<a href="#">编辑</a><br>\
								<a href="#">删除</a><br>\
								<a href="#">追加评论</a>\
							</td>\
						</tr>\
					</table>\
				</div>\
				</div>';
		// end

		// 设置订单、商品展示板块 “分页” 栏样式
			$("#recent").tabs();
		// end

		// 获取、渲染个人全部信息
			$.getJSON('../core/api-v1.php',{action:"fetch_user_total_info"},function(data){
				user_info = data;	//获取个人全部信息
				show_info(user_info.info);	// 渲染个人身份信息
				show_goods(user_info.goods);
			})
		// end

		// 个人订单信息渲染
			$.getJSON("../core/api-v1.php",{action: "list_orders",page:"1"},function(data){show_orders(data.orders);});
			$("#sort-submit").click(function(){
				var order_status = $("#order_status-sort").val();
				var page = $("#page-sort").val();
				var sort = {action:"list_orders",order_status:order_status,page:page};
				if (order_status=="all") sort = {action:"list_orders",page:page};
				console.log(sort);
				$.getJSON("../core/api-v1.php",sort,function(data){show_orders(data.orders);});
			});
		// end

		// 渲染个人身份信息函数
			function show_info(data){
				$("#student_id").html(data.student_id.value);
				$("#nickname").html(data.nickname);
				$("#name").html(data.name.value);
				$("#type").html(data.type.value);
				$("#gender").html(data.gender.value);
				$("#birthday").html(data.birthday.value);
				$("#dormitory").html(data.dormitory.value);
				if(data.header){
					$("#header-img").attr("src",data.header);
					$("#top-header").attr("src",data.header);
				}
			}
		// end

		// 渲染个人商品信息函数
			function show_goods(data){
				var goods_list = '';
				for (var i = 0; i < data.length; i++) {
					goods_list += goodsTpl.format(data[i]);
				}
				$("#user_goods").html(goods_list);
			}
		// end

		// 渲染个人订单信息函数
			function show_orders(data){
				var order_list = "";
				for (var i = 0; i < data.length; i++) {
					data[i].ordering_date = data[i].ordering_date.split(".")[0];
					switch (data[i].order_status) {
						case "waiting":data[i].order_status="等待受理"; break;
						case "accepted":data[i].order_status="已经受理"; break;
						case "completed":data[i].order_status="等待确认收货"; break;
						case "finished":data[i].order_status="订单完成"; break;
					}
					if(data[i].goods_img == null || data[i].goods_img == "")
						data[i].goods_img = "../main/goods.jpg";
					order_list += ordersTpl.format(data[i]);
				}
				$("#recent-content").html(order_list);
			}
		// end

		// 修改商品信息函数(将函数传递到全局)
			edit_goods = function(id){
				edited_info = user_info.goods.find(function(abc){return abc.goods_id == id});
				$(".bg-model").fadeTo(300,1)
				$("body").css({ "overflow": "hidden" });	//隐藏窗体的滚动条
				edit_app.update_goods_info(edited_info);
			};
		// end
	}());

		// 弹窗消失操作
			$("#cancel-change").click(function () {
				$(".bg-model").hide();
				//显示窗体的滚动条
				$("body").css({ "overflow": "visible" });
			});
		// end

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
