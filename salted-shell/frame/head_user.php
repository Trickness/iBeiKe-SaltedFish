<style>
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
		#sign-tl{float: right;height: 50px;margin-top: 12px;margin-right: 30px;min-width: 110px;}
		#sign-info{float: left;color: white;margin: 10px;}
		#sign-tl img{height: 50px;width: 50px;border-radius: 25px;float: left;transition-duration: 0.4s;}
		#sign-info a{float: left;color: white;font-size: 20px;transition-duration: 0.4s;}
		#sign-info a:hover{margin: -5px; font-size: 30px;}
		/*#sign-tl img:hover{height: 60px;width: 60px;border-radius: 30px;margin-left: -5px;margin-top:-5px;}*/
</style>
	<div id="topbanner">
		<img id="logo" src="../pic/beikelogo.png">
		<a href="../main/main.php"><div id="title">贝壳商城</div></a>
		<a href="../main/main.php"><div id="market-tl" class="top-tl" style="left: 250px;">商城</div></a>
		<a href="../users/index.php"><div id="users-tl" class="top-tl" style="left: 340px;">个人中心</div></a>
		<a href="../info/info.php"><div id="info-tl" class="top-tl" style="left: 465px;">信息中心</div></a>
		<div id="sign-tl">
			<img src="../main/cover.png">
			<div id="sign-info"></div>
		</div>

		<script>
			$(document).ready(function(){
				$.get("../core/api-users-info.php?action=one_col",{col:"nickname"},function(data){
					if (data=='{"status":"failed","error":"Access denied"}') {
						$("#sign-info").html('<a href="../login/login.php">登陆</a>'+'<a style="margin-left:20px;" href="../signin/signin.php">免费注册</a>');
					}else{
						$("#sign-info").html('<a href="../users/index.php">'+data+'</a>');
					}
					console.log(data);
				})
			});
		</script>
	</div>