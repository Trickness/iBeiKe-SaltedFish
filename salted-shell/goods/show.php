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
                $.getJSON("../core/api-show-goods.php",{type:"show",goods_id:goods_id},function(data){
                    console.log(data);
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
        <button>立即购买</button>
        <div id="summary" style="border:1px solid black;"></div>
        <div id="comment"></div>
    </body>
</html>