<!DOCTYPE html>
<html>
<head>
	<?php session_start(); ?>
	<meta charset="utf-8">
	<title>订单列表</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        window.onload = function(){
            var self_id = "";
            $.getJSON("../core/api-v1.php?action=fetch_self_info",function(data){
                if(data.status === "success"){
                    self_id = data.self_info.student_id.value;
                    console.log(self_id);
                }
            });
            $.getJSON("../core/api-v1.php?action=list_orders",function(data){
                if(data.status === "success"){
                    $.each(data.orders,function(index, item, array){
                        var action = "";
                        if(item.order_submitter === self_id){
                            if(item.order_status === "waiting"){
                                action = "等待受理 | <a href='../core/api-v1.php?action=cancel_order&order_id=" + item.order_id +"'>取消订单</a>";
                            }else if(item.order_status === "accepted"){
                                action = "已经受理 | 等待配送"
                            }else if(item.order_status === "completed"){
                                action = "<a href='../core/api-v1.php?action=finish_order&order_id=" + item.order_id +"'>确认收货</a>";
                                action = action + " | <a href='../core/api-v1.php?action=cancel_order&order_id=" + item.order_id + "'>取消订单</a>"
                            }else if(item.order_status === "finished"){
                                action = "订单完成 | 申请退货";
                            }
                            $("#list_1 tr:last").after("<tr><td>" + item.order_id + "</td>\
                                                            <td><a href='../goods/show.php?goods_id=" + item.goods_id + "'>"+ decodeURIComponent(item.goods_title) +"</a></td>\
                                                            <td>" + item.goods_owner + "</td>\
                                                            <td>" + item.single_cost + "</td>\
                                                            <td>" + item.purchase_amount + "</td>\
                                                            <td>" + item.delivery_fee + "</td>\
                                                            <td>" + item.ordering_date + "</td>\
                                                            <td>" + item.offer + "</td>\
                                                            <td>" + item.order_status + "</td>\
                                                            <td>" + action + "</td></tr>"
                            )
                        }
                        if(item.goods_owner === self_id){
                            if(item.order_status === "waiting"){
                                action = "<a href='../core/api-v1.php?action=accept_order&order_id=" + item.order_id +"'>接受订单</a>";
                                action = action + " | <a href='../core/api-v1.php?action=cancel_order&order_id=" + item.order_id +"'>取消订单</a>";
                            }else if(item.order_status === "accepted"){
                                action = "<a href='../core/api-v1.php?action=complete_order&order_id=" + item.order_id +"'>确认送达</a>";
                                action = action + " | <a href='../core/api-v1.php?action=cancel_order&order_id=" + item.order_id +"'>撤销订单</a>";
                            }else if(item.order_status === "completed"){
                                action = "等待确认 | 申请中介";
                            }else if(item.order_status === "finished"){
                                action = "订单完成";
                            }
                            $("#list_2 tr:last").after("<tr><td>" + item.order_id + "</td>\
                                                            <td><a href='../goods/show.php?goods_id=" + item.goods_id + "'>"+ decodeURIComponent(item.goods_title) +"</a></td>\
                                                            <td>" + item.goods_owner + "</td>\
                                                            <td>" + item.single_cost + "</td>\
                                                            <td>" + item.purchase_amount + "</td>\
                                                            <td>" + item.delivery_fee + "</td>\
                                                            <td>" + item.ordering_date + "</td>\
                                                            <td>" + item.offer + "</td>\
                                                            <td>" + item.order_status + "</td>\
                                                            <td>" + action + "</td></tr>"
                            )
                        }

                    })
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
    <div>
        <p>我发起的</p>
            <table border="1" id="list_1">
                <tr>
                    <td>订单ID</td>
                    <td>商品名称</td>
                    <td>卖方</td>
                    <td>单价</td>
                    <td>购买量</td>
                    <td>运费</td>
                    <td>订单提交时间</td>
                    <td>总价</td>
                    <td>订单状态</td>
                    <td>操作</td>
                </tr>
            </table>
        </div>
        <p>我要处理的</p>
        <div>
            <table border="1" id="list_2">
                <tr>
                    <td>订单ID</td>
                    <td>商品名称</td>
                    <td>买方</td>
                    <td>单价</td>
                    <td>购买量</td>
                    <td>运费</td>
                    <td>订单提交时间</td>
                    <td>总价</td>
                    <td>状态</td>
                    <td>操作</td>
                </tr>
            </table>
        </div>
</body>
</html>