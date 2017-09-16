<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商品展示</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="../js/jquery-latest.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/vue.js" />
        <link href="https://cdn.bootcss.com/unslider/2.0.3/css/unslider.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/unslider/2.0.3/js/unslider-min.js"></script>
        <script src="../js/pin.js"></script>
        <style>
            @font-face {
    			font-family: msyh;
    			src: url('../fonts/msyh.ttf');
    		}
            body{margin: 0;font-family: msyh;}
            /*.row div{border: 1px solid black;}*/
            a{text-decoration: none;transition-duration: 0.4s;color: black;}
            a:hover{color: #FD9860;}
            #goods_info .row{margin-bottom: 20px;}
            #new_order{height:45px;border:none;border-radius:5px;transition-duration: 0.4s;background-color: #FFE1C9;color: #FD9860;}
            #new_order:hover{background-color: #CC3333;color: white;}
            #add_to_cart{height:45px;background-color:#FD9860;color:white;border:none;border-radius:5px;transition-duration: 0.4s;}
            #add_to_cart:hover{background-color: #FFCC66;}
            #contect{border:none;border-radius:5px;transition-duration: 0.4s;background-color: #FFE1C9;color: #FD9860;height:40px;width:100px;}
            #contect:hover{background-color: #CC3333;color: white;}
            .name-card{transition: 0.4s;}
            .name-card:hover{box-shadow:0 0 10px gray;}
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
        <div id="show_goods" class="container" style="margin-top:100px;">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="row"><img alt="商品大图" src="../main/goods.jpg" class="goods_header" style="width:100%;" /></div>
                        <div class="row" style="margin-top:10px;height:fit-content;">
                            <div v-for="i in 4" class="col-xs-3"><div class="preview" style="border:1px solid black;"></div></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="goods_info">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>{{goods_info.goods_title}}</h2>
                        </div>
                    </div>
                    <div class="row" style="border-top:1px dashed #cccccc;"><div class="col-xs-12">
                        <div v-html="convert_info.goods_info" style="height:70px;border-radius:5px;margin-top:10px;"></div>
                    </div></div>
                    <div class="row" style="border-top:1px dashed #cccccc;"><div class="col-xs-12">
                        <div style="background-color:#FFE1C9;padding:10px 0 10px 15px;border-radius:5px;margin-top:30px;">
                            <span>价格&nbsp;&nbsp;</span>
                            <span style="color:#FD9860;font-size:25px;">￥<span v-html="goods_info.single_cost"></span></span>
                        </div>
                    </div></div>
                    <div class="row" style="border-top:1px dashed #cccccc;padding-top:10px;">
                        <div class="col-xs-6">商品状态：{{convert_info.goods_status}}</div>
                        <div class="col-xs-6">交易方式：{{convert_info.goods_type}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <h4 style="float:left">数量：</h4>
                        </div>
                        <div class="form-group col-xs-4">
                            <input type="number" class="form-control" min="0" :max="goods_info.remain" v-model="order_info.purchase_amount">
                        </div>
                        <div class="col-xs-4">
                            <h5>（库存：{{goods_info.remain}}）</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="col-xs-4" @click="new_order" id="new_order">立即购买</button>
                            <button class="col-xs-4 col-xs-offset-1" id="add_to_cart">加入购物车</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <div style="margin-top:20px;">
                            <ul class="name-card" style="list-style-type:none;line-height:30px;padding:35px;border-radius:5px;" data-spy="affix" data-offset-top="100">
                                <li style="text-align:center;"><img class="owner_header" src="../main/adv.png" style="width:120px;height:120px;border-radius:60px;" :alt="goods_owner.header" /></li>
                                <li style="text-align:center;font-size:20px;">{{goods_owner.nickname}}</li>
                                <li>学号：{{goods_info.goods_owner_info.student_id}}</li>
                                <li>姓名：{{goods_info.goods_owner_info.name}}</li>
                                <li>电话：{{goods_info.goods_owner_info.phone_number}}</li>
                                <li style="text-align:center;"><a :href="convert_info.goods_owner_info"><button id="contect">联系卖家</button></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height:800px;">

            </div>
        </div>

        <script>
            $(document).ready(function(){
                $(".goods_header").css("height",$(".goods_header").css("width"));
                $(".preview").css("height",$(".preview").css("width"));

                var show_goods = new Vue({
                    el:'#show_goods',
                    data:{
                        goods_info:{
                            goods_owner_info:{}
                        },
                        order_info:{
                            goods_id:'',
                            order_type:'',
                            delivery_fee:0,
                            purchase_amount:1,
                            single_cost:0,
                            offer:0,
                        },
                        goods_owner:{},
                    },
                    computed:{
                        convert_info:function(){
                            var info = {
                                goods_info:(this.goods_info.goods_info+'').replace(/<img[^>]+>/ig,"").substring(0,30),
                                goods_owner_info:'../users/others.php?user_id='+this.goods_info.goods_owner,
                                goods_status:'',
                                goods_type:'',
                            };
                            if (this.goods_info.goods_status == "available") info.goods_status = '在售';
                                else info.goods_status = '下架';
                            if (this.goods_info.goods_type == "sale") info.goods_type = '出售';
                                else info.goods_type = '租赁';
                            return info;
                        },
                    },
                    methods:{
                        new_order:function(){
                            this.order_info.offer = this.order_info.single_cost * this.order_info.purchase_amount + this.order_info.delivery_fee;
                            console.log(this.order_info);
                        },
                    },
                    created:function(){
                        $.getJSON('../core/api-show-goods.php',{action:'show',goods_id:goods_id},function(data){
                            show_goods.goods_info = data;
                            show_goods.order_info.goods_id = show_goods.goods_info.goods_id;
                            show_goods.order_info.order_type = show_goods.goods_info.goods_type;
                            show_goods.order_info.delivery_fee = parseFloat(data.delivery_fee);
                            show_goods.order_info.single_cost = parseFloat(data.single_cost);
                            $.getJSON('../core/api-v1.php',{action:'fetch_user_info',user_id:data.goods_owner},function(result){
                                if (result.status == "success") {
                                    show_goods.goods_owner = result.user_info;
                                }
                            });
                        });
                    }
                });
            });
        </script>
    </body>
</html>
