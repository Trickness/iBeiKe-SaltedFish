<!DOCTYPE html>
<html>
<head>
	<?php session_start(); ?>
	<meta charset="utf-8">
	<title>订单列表</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        window.onload = function(){
            $.getJSON("../core/api-v1.php?action=list_orders",function(data){
                if(data.status === "success"){
                    $.each(data.orders,function(index, value, array){
                        console.log(value);
                    });
                }else{
                    console.log(data);
                }
                
            });
        }
    </script>
</head>
<body>
	<?php
		require_once "../core/users.php";
        require_once "../core/utils.php";
        require_once "../core/authorization.php";
        require_once "../config.php";
        
        $session = session_id();
	?>
</body>
</html>