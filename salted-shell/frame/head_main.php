<link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css">
<script src="./js/jquery-latest.js"></script>
<script src="./js/bootstrap/bootstrap.min.js"></script>
<script src="./js/vue.js"></script>
<style>
	@font-face {
		font-family: msyh;
		src: url('./fonts/msyh.ttf');
	}
	body{font-family: msyh;}
	#logo{height: 50px;margin-top: -15px;width: 40px;}
	.lb{float:left;color:white;}
	.act{background-color:#FF6633;}
	#navi-item a:hover{opacity:0.5;color:white;}
	#navi-item a{color:white;transition-duration:0.3s;}
</style>
<nav id="topbanner" class="navbar" role="navigation" style="width:100%;background-color:#FD9860;border-radius:0;border:none;color:white;position:fixed;top:0;left:0;z-index:10;">
	<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target="#navi-item" style="border:1px solid white;opacity:0.7;">
			<span style="color:white;" class="sr-only">切换导航</span>
			<span style="color:white;">More</span>
		</button>
		<a class="navbar-brand" style="overflow:hidden;" href="#">
			<div class="row">
				<div class="col-xs-4"><img id="logo" src="./pic/beikelogo.png"></div>
				<div class="col-xs-8" style="padding:0 0 0 10px;"><span class="lb">贝壳商城</span></div>
			</div>
		</a>
	</div>
	<div class="collapse navbar-collapse" id="navi-item">
		<ul class="nav navbar-nav">
			<li><a href="./index.php">商城</a></li>
			<li v-if="is_login"><a href="./users/index.php">个人中心</a></li>
			<li v-if="is_login"><a @click="logout">注销</a></li>
		</ul>
		<ul v-if="!is_login" class="nav navbar-nav navbar-right">
			<li><a href="./login/login.php">登陆</a></li>
			<li><a href="./signin/signin.php">注册</a></li>
		</ul>
		<ul v-else-if="is_login" class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:5px;overflow:hidden;">
					<div style="width:40px;height:40px;border-radius:20px;float:left;margin-left:15px;" :style="bg"></div>
					<span class="lb" style="line-height:40px;margin-left:10px;margin-right:15px;">{{info.nickname}}<b class="caret" style="margin-left:5px;"></b></span>
				</a>
				<ul class="dropdown-menu" style="background-color:#FF6633;">
                    <li><a href="./users/edit-profile.php">个人信息编辑</a></li>
                    <li><a href="./goods/upload.php">上传商品</a></li>
                    <li><a href="./users/orders.php">我的订单</a></li>
                </ul>
			</li>
		</ul>
	</div>
	</div>
</nav>

<script>
	var bg_ch = function(url){
		return {
			backgroundImage:'url("'+url+'")',
			backgroundSize:'cover',
			backgroundPosition:'center',
			backgroundRepeat:'no-repeat',
		};
	};
	var is_login = false;
	var self_info = new Vue({
		el:'#topbanner',
		data:{
			info:{},
			is_login:false,
		},
		computed:{
			bg:function(){return bg_ch(this.info.header);},
		},
		methods:{
			logout:function(){
				$.getJSON('./core/api-v1.php?action=logout',function(data){
					console.log(data);
					if (data.status == 'success') {
						window.location = './index.php';
					}
				});
			},
		},
		created:function(){
			$.getJSON("./core/api-v1.php?action=fetch_self_info",function(data){
				if(data.status == "success"){
					console.log(data.self_info);
					self_info.info = data.self_info;
					self_info.is_login = true;
					is_login = true;
				}else{
					self_info.is_login = false;
					is_login = false;
				}
			});
		},
	});
</script>