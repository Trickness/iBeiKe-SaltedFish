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
</style>
<script>
	$("#logout-tl").click(function(){
		$.getJSON("../core/api-v1.php?action=logout",{}
		,function(data){
            var status = data.status;
            switch(status){
                case "success":
                    console.log(status);
                    window.location="../login/login.php";
                    break;
                case "failed":
                    console.log(status);
                    console.log(data.error);
                    break;
                default:
                    console.log(status);
                    break;
            }
		})
	});
</script>
<?php
		// $main_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		// $main_url = explode("?",$main_url)[0];
		require_once '../config.php';
		require_once '../core/authorization.php';
		require_once '../core/utils.php';
		if(!session_id())
			session_start();

		if(!get_student_id_from_session_key(session_id()))
			die(generate_error_report("You haven't logined!"));
	?>

	<div id="topbanner">
		<img id="logo" src="../pic/beikelogo.png">
		<a href="../main/main.php"><div id="title">贝壳商城</div></a>
		<a href="../main/main.php"><div id="market-tl" class="top-tl" style="left: 250px;">商城</div></a>
		<a href="../users/index.php"><div id="users-tl" class="top-tl" style="left: 340px;">个人中心</div></a>
		<a id="logout-tl" href="../core/api-v1.php?action=logout"><div class="top-tl" style="left: 480px;align:right;">注销</div></a>
	</div>