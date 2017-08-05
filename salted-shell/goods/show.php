<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8" >
        <title>商品展示</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <style>
            body{
                margin:0;
                height:1000px;
            }
        </style>
    </head>
    <body>
        <?php
            include "../frame/head_user.php";
            if (isset($_GET['goods_id'])) {
                $goods_id = $_GET['goods_id'];
                echo "<script>var goods_id = {$goods_id};</script>";
            }
        ?> 

        <script>
            $(document).ready(function(){
                var goods_info = null;
                var order_info = {};
                $.getJSON("../core/api-show-goods.php",{action:"show",goods_id:goods_id},function(data){
                    goods_info = data;
                    console.log(goods_info);
                    $("#goods_title").html(data.goods_title);
                    $("#submitter").html(data.submitter);
                    $("#status").html(data.status);
                    // $("#count").html(data.count);
                    $("#type").html(data.type);
                    $("#price").html(data.price);
                    $("#summary").html(data.summary);

                    var total_comment = "";
                    for(var i=0;i<data.comments.length;i++){
                        total_comment += '<div style="border:1px solid black;"><div>'+data.comments[i].commenter+'</div><div>'+data.comments[i].comment_date+'</div><div>'+data.comments[i].comment+'</div></div>';
                    }
                    $("#comment").html(total_comment);
                });

                $("#make_order").click(function(){
                    if (goods_info!=null) {
                        $("#order_tl").html(goods_info.goods_title);
                        $("#order_price").html(goods_info.price);
                        $("#order_deliver_fee").html("15");
                        var total = goods_info.price * $('input[name="count"]').val()+parseInt($('#order_deliver_fee').html());
                        $("#order_total").html(total);
                        $("#order_content").css("display","block");
                    }
                });

                $('input[name="count"]').change(function(){
                    if (goods_info!= null) {
                        var total = goods_info.price * $('input[name="count"]').val()+parseInt($('#order_deliver_fee').html());
                        $("#order_total").html(total);
                    }
                });

                $("#order_commit").click(function(){
                    if (goods_info!=null) {
                        order_info.goods_id = goods_id;
                        order_info.deliver_fee = $('#order_deliver_fee').html();
                        order_info.goods_count =  $('input[name="count"]').val();
                        order_info.price_per_goods = goods_info.price; 
                        order_info = JSON.stringify(order_info);
                        $.get("../core/api-show-goods.php",{goods_id:goods_id,action:"new_order",order_info:order_info},function(data){
                            console.log(data);
                        });
                    }
                });
            });
        </script>  
        <div style="margin-top:90px;">
            <div><label for="goods_title">商品名称：</label><label id="goods_title"></label></div>
            <div><label for="submitter">卖家：</label><label id="submitter"></label></div>
            <div><label for="status">状态：</label><label id="status"></label></div>
            <!-- <div><label for="count">数量：</label><label id="count">0</label></div> -->
            <div><label for="type">交易方式：</label><label id="type"></label></div>
            <div><label for="price">价格：</label><label id="price"></label></div>
        </div>   
        <button id="make_order">立即下单</button>
        <div id="new_order" style="border:1px solid black;padding:20px;">
            <div id="order_head"><h4>确认订单信息</h4></div>
            <div id="order_content" style="display:none;">
                <table>
                    <thead>
                        <th>商品名称</th>
                        <th>单价</th>
                        <th>数量</th>
                        <th>运费</th>
                        <th>总计</th>
                    </thead>
                    <tbody>
                        <td id="order_tl"></td>
                        <td id="order_price">0</td>
                        <td id="order_count"><input type="number" name="count" value="1" /></td>
                        <td id="order_deliver_fee">0</td>
                        <td id="order_total">0</td>
                    </tbody>
                </table>
                <button id="order_commit">提交订单</button>
            </div>
        </div>


        <div id="summary" style="border:1px solid black;"></div>
        <div id="comment"></div>
    </body>
</html>