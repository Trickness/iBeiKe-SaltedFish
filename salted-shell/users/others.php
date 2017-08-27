<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>个人空间</title>
    </head>
    <body>
        <style media="screen">
            body{margin: 0;}
            .goods{
                color: black;
                width: 220px;
                margin:6px;
                height:335px;
                border: 1px solid white;
                float: left;
                border-radius: 5px;
                transition-duration: 0.4s;
                text-align: center;
            }
            .goods:hover{
                background-color: #e8e8e8;
                color: #FD9850;
                border: 1px solid #CCCCCC;
                box-shadow:2px 2px 2px #CCCCCC;
            }
            .goods img{
                width: 220px;
                height: 220px;
                border-radius: 5px;
                /* margin: 2px;  */
            }
            .goods h2{margin: 0;margin-left: 15px;color: #FD9850;text-align: left;width: 200px;}
            .goods p{margin: 0;font-size: 12px;text-align: left;color: #404040;width: 170px;height: 25px;margin-left: 15px;}
        </style>
        <?php
            include "../frame/head_user.php";
            if (isset($_GET['user_id'])) {
                echo "<script>var user_id = '".$_GET['user_id']."';</script>";
            }else {
                echo "<script>var user_id = '********';</script>";
            }
        ?>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <div id="user-info" style="margin-top:100px;">
            <label for="id">ID：</label><span id="id"></span><br>
            <label for="nickname">昵称：</label><span id="nickname"></span><br>
            <label for="name" />姓名：</label><span id="name"></span><br>
            <label for="type" />学生类别：</label><span id="type"></span><br>
            <label for="gender" />性别：</label><span id="gender"></span><br>
            <label for="dormitory" />宿舍：</label><span id="dormitory"></span>
        </div>
        <div id="user-goods" style="border:1px solid black;">
            <div><h3>他的商品</h3></div>
            <div id="goods-list" style="overflow:hidden;"></div>
        </div>
        <div id="user-orders" style="border:1px solid black;">
            <div><h3>他的订单</h3></div>
            <div id="orders-list" style="overflow:hidden;"></div>
        </div>
        <script>
            $(document).ready(function(){
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

                function show_info(data){
                    $("#nickname").html(data.nickname);
                    $("#name").html(data.name.value);
                    $("#type").html(data.type.value);
                    $("#gender").html(data.gender.value);
                    $("#dormitory").html(data.dormitory.dormitory_id.value+"#"+data.dormitory.room_no.value);
                }

                function show_goods(goods){
                    console.log(goods);
                    var goodsTpl = '<a href="{href}"><div class="goods">\
            						<img src="../main/goods.jpg">\
            						<h2><span style="font-size:15px;">￥</span>{single_cost}</h2>\
            						<p style="font-size:16px;">{goods_title}</p>\
            						<p style="color:gray">{id}</p>\
            					</div></a>';
                    var goods_list = "";
                    for (var i = 0; i < goods.length; i++) {
                        goods_list += goodsTpl.format({
                            href:"../goods/show.php?goods_id="+goods[i].goods_id,
                            single_cost:goods[i].single_cost,
                            goods_title:goods[i].goods_title,
                            id:goods[i].goods_owner
                        });
                    }
                    $("#goods-list").html(goods_list);
                }
                $.getJSON("../core/api-v1.php",{action:"fetch_user_total_info",user_id:user_id},function(data){
                    if (data.status=="success") {
                        $("#id").html(data.target_id);
                        show_info(data.info);
                        show_goods(data.goods);
                    }
                });
            });
        </script>
    </body>
</html>
