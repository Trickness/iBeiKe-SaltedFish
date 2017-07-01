<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登陆</title>
	<style>
		body{
			margin: 0;
			background-image: url("../pic/bk4.png");
			background-repeat: no-repeat;
			background-size: 100% 110%;
		}
	</style>
</head>
<body>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>
	<?php
		include "../frame/head.php";
	?>
	<div class="container" style="width: 900px;height: 600px;margin-top: 50px;">
		<div class="row" style="text-align: center;color: white;">
			<p style="font-size: 70px;opacity: 0.7;">让你的闲置动起来</p>
			<center><p style="font-size: 35px;margin-top: 60px;width: 600px;">iBeiKe商城可以帮助你进行旧货交易、二手交易，充分发挥你的闲置</p></center>
		</div>
		<div class="row" style="margin-top: 50px;">
			<div class="col-xs-6">
				<a href="#" class="button button-3d" style="color: #FF9933;float: right;">注册</a>
			</div>
			<div class="col-xs-6">
				<a class="button button-3d button-caution" style="color: white;"
					data-toggle="modal" data-target="#win-lgi">登陆</a>
			</div>
		</div>
	</div>

	<div id="win-lgi" class="modal fade" tabindex="-1" role="dialog" 
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center;">
						登陆
					</h4>
				</div>
				<form method="post" action="../../core/api-v1.php?action=login">
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="form-group col-xs-3 col-xs-offset-1">
								<label for="win-usn">用户名:</label>
								<input type="text" id="win-usn" name="username" class="form-control"/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-3 col-xs-offset-1">
								<label for="win-pwd">密码:</label>
								<input type="password" id="win-pwd" name="password" class="form-control"/>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" id="btn-lgi" class="btn btn-primary" value="登陆" />
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
		</div>
	</div>

	<!-- <script>
	$(document).ready(function(){
		$("#btn-lgi").click(function(){
			$.post("../../../core/api-v1.php?action=login",{
				username:$("#win-usn").val(),
				password:$("#win-pwd").val()
			},function(data){
				console.log(data);
			});
		});
	});
	</script> -->
</body>
</html>