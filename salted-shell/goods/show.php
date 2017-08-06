<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8" >
        <title>商品展示</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>
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
            var goods_info = null;
            var order_info = {};
            $(document).ready(function(){  
                $.getJSON("../core/api-show-goods.php",{action:"show",goods_id:goods_id},function(data){
                    goods_info = data;
                    console.log(goods_info);
                    $("#goods_title").html(data.goods_title);
                    $("#submitter").html(data.submitter);
                    $("#status").html(data.status);
                    // $("#count").html(data.count);
                    $("#type").html(data.type);
                    $("#price").html(data.price);
                    $("#summary_content").html(data.summary);

                    $("#buyer_id").html(data.buyer_info.student_id);
                    $("#buyer_name").html(data.buyer_info.name);
                    $("#buyer_phone").html(data.buyer_info.phone_number);

                    $("#submitter_id").html(data.submitter_info.student_id);
                    $("#submitter_name").html(data.submitter_info.name);
                    $("#submitter_phone").html(data.submitter_info.phone_number);

                    var total_comment = "";
                    for(var i=0;i<data.comments.length;i++){
                        total_comment += '<div style="border:1px solid black;"><div>'+data.comments[i].commenter+'</div><div>'+data.comments[i].comment_date+'</div><div>'+data.comments[i].comment+'</div></div>';
                    }
                    $("#comment_content").html(total_comment);
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

                $("#comment_submit").click(function(){
                    var comment = ue.getContent();
                    $.getJSON("../core/api-show-goods.php",{goods_id:goods_id,action:"comment",comment:comment},function(data){
                        console.log(data);
                    })
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
        
        <div id="summary" style="border:1px solid black;">
            <div>商品简介</div>
            <div id="summary_content"></div>
        </div>
        <div id="comment" style="border:1px solid black;">
            <div>留言</div>
            <div id="comment_content"></div>
            <form>
                <div style="display:block;margin-left:150px;">
                    <script id="editor" type="text/plain" style="width:600px;height:200px;"></script>
                </div>
            </form>
            <button id="comment_submit">提交留言</button>
            <script>
                var ue = UE.getEditor('editor',{
                    toolbars: [
                        ['emotion','undo', 'redo', 'bold','italic','underline','strikethrough','subscript','formatmatch','simpleupload','insertimage',
                            'justifyleft','justifycenter','justifyright','justifyjustify','forecolor']
                    ],
                    autoHeightEnabled: false,
                    autoFloatEnabled: false,
                    zIndex:1
                });
            </script>   
        </div>

        <div class = "bg-model" style="position:absolute;top:0%;left:0%;display:none;background:rgba(0,0,0,0.3);width:100%;height:100%;position:fixed;z-index:9999">
		    <div class = 'content' style="position: absolute;left: 35%;top: 25%;border-radius: 8px;width: 460px;height: 303px;background-color: #fff;padding:20px;" >
		    	
                <div id="check_info" style="border: 1px solid black;margin-bottom: 40px;">
                    <div id="buyer_tl">双方信息确认</div>
                    <div id="buyer_info">
                        <table>
                            <thead>
                                <th>买家学号</th>
                                <th>买家姓名</th>
                                <th>联系电话</th>
                            </thead>
                            <tbody>
                                <td id="buyer_id"></td>
                                <td id="buyer_name"></td>
                                <td id="buyer_phone"></td>
                            </tbody>
                            <thead>
                                <th>卖家学号</th>
                                <th>卖家姓名</th>
                                <th>联系电话</th>
                            </thead>
                            <tbody>
                                <td id="submitter_id"></td>
                                <td id="submitter_name"></td>
                                <td id="submitter_phone"></td>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="new_order" style="border: 1px solid black;margin-bottom: 40px;">
                    <div id="order_head">确认订单信息</div>
                    <div id="order_content">
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
                                <td id="order_count"><input type="number" name="count" value="1" style="width:60px;text-align:center;" /></td>
                                <td id="order_deliver_fee">0</td>
                                <td id="order_total">0</td>
                            </tbody>
                        </table>
                        <button id="order_commit">提交订单</button><button id="cancel-change">取消</button>
                    </div>
                </div>
		    </div>
	    </div>

	    <script>
	    	$(document).ready(function(){

	    		$("#make_order").click(function () {
	    			$(".bg-model").fadeTo(300,1)
	    			//隐藏窗体的滚动条
	    			$("body").css({ "overflow": "hidden" });

                    if (goods_info!=null) {
                        $("#order_tl").html(goods_info.goods_title);
                        $("#order_price").html(goods_info.price);
                        $("#order_deliver_fee").html("15");
                        var total = goods_info.price * $('input[name="count"]').val()+parseInt($('#order_deliver_fee').html());
                        $("#order_total").html(total);
                        $("#order_content").css("display","block");
                    }
	    		});

	    		//模态框OK按钮点击事件
	    		$("#cancel-change").click(function () {
	    			$(".bg-model").hide();
	    			//显示窗体的滚动条
	    			$("body").css({ "overflow": "visible" });
	    		});
	    	});
	    </script>	
    </body>
</html>