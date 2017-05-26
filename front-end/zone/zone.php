<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>个人中心</title>
	<style>
		body{
			margin:0;
			background-repeat: no-repeat;
   			-moz-background-size:100% 100%;
   			background-size:100% 100%;
		}
		.header{
			background-color: #00BFFF;			
			height: 50px;
			width: 100%;
			box-shadow: 0 5px 5px black;
			position: fixed;
			z-index: 1;
		}
		.title{
			font-size: 35px;
    		color: white;
    		position: relative;
    		top: 0px;
    		left: 7px;
    		float: left;
    		width: 10%;
		}
		.left{
			position: fixed;
			width: 200px;
		}
		.left-nav{
			float: left;
    		height: 400px;
    		width: inherit;
    		margin-left: 0;
    		position: relative;
    		top: 20px;
		}
		.left-pl{
			position: fixed;
			border-radius: 20px;
			left: 0;
            top: 50px;
            width: 200px;
            height: 700px;
            z-index: -1;
		}
		.left-nav-item{
			height: 60px;
			width: inherit;
			background:rgba(0,0,0,.3);
			color: white;
			border-bottom: 2px solid white; 
			padding-top: 10px;
			box-sizing: border-box;
			border-radius: 10px; 
		}
		.left-nav-item:hover{
			background-color: white;
			color: black;
		}
		.left-nav-item:active{
			background-color: gray;
			color: black;
		}
		.left-nav-item a,a:hover{
			text-decoration: none;
			color: white;
		}

		.right-pl{
			background-color: white;
			position: absolute;
			
			border-radius: 30px;
			border: 10px solid #00BFFF;
			z-index: -1;
		}

		.cha{
			font-size: 25px;
			text-align: center;
			margin: 0;
		}

		.event{
			position: relative;
			top: 10px;
			margin:20px;
			padding:10px;
			border: 1px solid gray;
			border-radius: 15px;
			box-shadow: 2px 2px 2px gray;
			color: black;
		}
		.event:hover{background-color: #F5F5F5}
		.event:active{background-color: #C0C0C0}
		.ev-ti{margin-bottom: -21px;margin-left: 15px;
    		font-size: 25px;}
    	.ev-co{margin-top: -15px;
    		margin-left: 10px;}
		
		.glass{
            box-shadow: 1px 1px 5px black;
		}
		.glass::after{
			filter: blur(6px);
			overflow: hidden;
			content: '';
    		position: absolute; top: 0; left: 0;  right: 0;  bottom: 0;
    		background:url("./book.jpg");
    		background-attachment: fixed;
    		background-size: 1536px 759px;
    		background-position: 0px 0px;
    		z-index: -1;
		}
		#info{
			margin-top: 10px;
			margin-left: 20px;
			text-align: left;
			color: white;
		}
		#info p{
			margin:0;
		}
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<script>
		$(document).ready(function(){
			var bg_image = "url('./book.jpg')";
			$("body").css({"background-image":bg_image,"background-attachment":"fixed"});
			$("#right-rt").css({"height":$("#right-ce").css("height")});			
		});

		// 此处注释的为测试用的代码。localStorage在本地编程好像用不了，但放到云上就可以，所以我本地测试时是用这段注释代码来直接测试的
		// $.getJSON("../../core/zone-fetch.php",{session_key:"4pagocwl3b3sjl6592o22kgqiw8pb5gn"},function(data){
		var s_key = localStorage.getItem("session_key");
		$.getJSON("../../core/zone-fetch.php",{session_key:s_key},function(data){
				$("#nickname").html(data.nickname+"<span style='font-size:20px'>的空间</span>");
				$("#student_id").text("学号："+data.student_id);
				$("#name").text("姓名："+data.name);
				$("#type").text("身份："+data.type);
				$("#birthday").text("生日："+data.birthday);
				$("#nationality").text("民族："+data.nationality);
				$("#gender").text("性别："+data.gender);
		});
	</script>

	<div id="header" class="container header" style="width:100%">
		<p id="title" class="title">SaltedShell</p>
		<form method="post" class="form-inline" style="position: fixed;left: 225px; top: 6px">
			<input type="text" name="search" class="form-control" style="font-size: 20px;width: 350px">
			<input type="submit" class="form-control" name="search" value="搜索">
		</form>
	</div>

	<div id="center-wrapper" style="width: 100%;z-index: 0;position: absolute;top: 65px">
		<div id="left" class="glass left-pl">
			<div class="left-head" style="position: relative;top: 20px;text-align: center;">
				<img src="./six.PNG" style="width: 100px;height: 100px;border-radius: 50px;">
				<div id="info">
					<p id="student_id">学号：</p>
					<p id="name">姓名：</p>
					<p id="type">身份：</p>
					<p id="birthday">生日：</p>
					<p id="gender">性别：</p>
					<p id="nationality">民族：</p>
				</div>
			</div>

			<div id="left-nav" class="left-nav">
				<div class="left-nav-item">
					<a href="#"><p class="cha">主页</p></a>
				</div>
				<div class="left-nav-item">
					<a href="#"><p class="cha">商品</p></a>
				</div>
				<div class="left-nav-item">
					<a href="#"><p class="cha">我的</p></a>
				</div>
				<div class="left-nav-item">
					<a href="#"><p class="cha">设置</p></a>
				</div>
			</div>
		</div> <!-- left -->

		<div id="right" style="width: 1100px;position: absolute;top: 10px;left: 15px;">
			<div id="zone-title" class="glass" style="width:inherit;min-height: 50px; position: relative;left: 210px;padding: 5px;padding-left: 25px;margin-bottom: 20px;border-radius: 10px;color: white;">
				<p id="nickname" style="font-size: 40px;margin:0;"></p>
			</div>
			
			<div id="right-ce" class="container right-pl" style="left: 210px;width: 1000px;min-height: 623px;">
				<ul class="nav nav-pills" style="position: relative;top: 10px;">
  					<li role="presentation" class="active"><a href="#">全部动态</a></li>
  					<li role="presentation"><a href="#">讨论</a></li>
  					<li role="presentation"><a href="#">交易</a></li>
				</ul>

				<div class="event">
					<a href="#"><p class="ev-ti">Title</p>
					<hr>
					<p class="ev-co">这是一个动态的记录</p></a>
				</div>
				<div class="event">
					<a href="#"><p class="ev-ti">Title</p>
					<hr>
					<p class="ev-co">这是一个动态的记录</p></a>
				</div>
				<div class="event">
					<a href="#"><p class="ev-ti">Title</p>
					<hr>
					<p class="ev-co">这是一个动态的记录</p></a>
				</div>
				<div class="event">
					<a href="#"><p class="ev-ti">Title</p>
					<hr>
					<p class="ev-co">这是一个动态的记录</p></a>
				</div>
				<div class="event">
					<a href="#"><p class="ev-ti">Title</p>
					<hr>
					<p class="ev-co">这是一个动态的记录</p></a>
				</div>	
			</div>

			<div id="right-rt" class="container right-pl" style="left: 1225px; width: 270px;min-height: 623px;">
				<div class="btn-group" style="margin-top:20px;margin-left: 20%;margin-right: 20%">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" 
						aria-expanded="	false">
						<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
						<label style="font-size: 20px">我的收藏</label>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
    					<li><a href="#">Action</a></li>
    					<li><a href="#">Another action</a></li>
    					<li><a href="#">Something else here</a></li>
    					<li role="separator" class="divider"></li>
   						<li><a href="#">Separated link</a></li>
  					</ul>
				</div>

				<hr>
			</div>

		</div>
	</div>
</body>
</html>