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
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>
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
            .new_order{height:45px;border:none;border-radius:5px;transition-duration: 0.4s;background-color: #FFE1C9;color: #FD9860;}
            .new_order:hover{background-color: #CC3333;color: white;}
            .banned_order{height:45px;border:none;border-radius:5px;background-color: #cccccc;color: gray;}
            #add_to_cart{height:45px;background-color:#FD9860;color:white;border:none;border-radius:5px;transition-duration: 0.4s;}
            #add_to_cart:hover{background-color: #FFCC66;}
            #contect{border:none;border-radius:5px;transition-duration: 0.4s;background-color: #FFE1C9;color: #FD9860;height:40px;width:100px;}
            #contect:hover{background-color: #CC3333;color: white;}
            .name-card{transition: 0.4s;}
            .name-card:hover{box-shadow:0 0 10px gray;}

            .bounce-enter-active {
              animation: bounce-in .5s;
            }
            .bounce-leave-active {
              animation: bounce-in .5s reverse;
            }
            @keyframes bounce-in {
              0% {
                transform: scale(0);
              }
              50% {
                transform: scale(1.5);
              }
              100% {
                transform: scale(1);
              }
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
                            <button v-if="goods_info.buyer_info!=undefined" class="col-xs-4 col-xs-offset-4 new_order" data-toggle="modal" data-target="#myModal">立即购买</button>
                            <button v-else disabled="true" class="col-xs-4 col-xs-offset-4 banned_order" data-toggle="modal" data-target="#myModal">立即购买</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <div style="margin-top:20px;">
                            <ul class="name-card" style="background-color:white;list-style-type:none;line-height:30px;padding:35px;border-radius:5px;" data-spy="affix">
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
                <div class="row">
                    <div class="col-sm-10">
                        <ul id="comment_tab" class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #FD9860;">
                            <li class="active"><a href="#comments" data-toggle="tab">留言板</a></li>
                            <li><a href="#info" data-toggle="tab">商品详情</a></li>
                            <li><a href="#editor" data-toggle="tab">我要留言</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="comments" class="tab-pane active">
                                <comments-tab :comments="goods_info.comments">
                            </div>
                            <div id="info" class="tab-pane" v-html="goods_info.goods_info" style="word-wrap:break-word;padding:20px;"></div>
                            <div id="editor" class="tab-pane">
                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1" style="padding-top:20px;">
                                        <script type="text/plain" id="ueditor" style="height:300px;"></script>
                                    </div>
                                </div>
                                <div class="row" style="padding-top:20px;text-align:center;">
                                    <button class="btn btn-primary" @click="comment_submit">提交评论</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                订单信息确认
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row"><div class="col-xs-10 col-xs-offset-1">
                                <div v-if="goods_info.buyer_info!=undefined">
                                    <table class="table table-hover">
                                        <thead><th>身份</th><th>学号</th><th>姓名</th><th>联系电话</th></thead>
                                        <tbody>
                                            <tr><td><b>卖家</b></td><td>{{goods_info.goods_owner_info.student_id}}</td><td>{{goods_info.goods_owner_info.name}}</td><td>{{goods_info.goods_owner_info.phone_number}}</td></tr>
                                            <tr><td><b>买家</b></td><td>{{goods_info.buyer_info.student_id}}</td><td>{{goods_info.buyer_info.name}}</td><td>{{goods_info.buyer_info.phone_number}}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div></div>
                            <div class="row"><div class="col-xs-10 col-xs-offset-1">
                                <table class="table table-bordered">
                                    <thead><th>商品ID</th><th>商品名称</th><th>交易方式</th><th>单价</th><th>购买数量</th><th>运费</th><th>总计</th></thead>
                                    <tbody><tr><td>{{order_info.goods_id}}</td><td>{{goods_info.goods_title}}</td><td>{{convert_info.goods_type}}</td><td>{{order_info.single_cost}}</td><td>{{order_info.purchase_amount}}</td><td>{{order_info.delivery_fee}}</td><td>{{offer_cal}}</td></tr></tbody>
                                </table>
                            </div></div>
                        </div>

                        <div class="modal-footer">
                            <transition name="bounce">
                                <div v-if="is_successful==false">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        <button type="button" @click="new_order" class="btn btn-primary">确认结算</button>
                                </div>
                            </transition>
                            <transition name="bounce">
                                <div v-if="is_successful==true">
                                    <div style="text-align:center">
                                        <div class="row"><h4>恭喜，下单成功！请耐心等待卖家接单。</h4></div>
                                        <div class="row"><button class="btn btn-default" @click="is_successful=false" data-dismiss="modal">继续购物</button></div>
                                    </div>
                                </div>
                            </transition>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>

        <!-- <div>\
                <div class="col-xs-12" style="border-bottom:1px dashed #cccccc;padding-top:15px;" v-for="message in comments">\
                    <div class="col-xs-1" style="text-align:center;">\
                        <div class="row"><img src="../main/adv.png" style="width:40px;height:40px;border-radius:20px;" /></div>\
                        <div class="row" style="margin-top:5px;">{{message.commenter}}</div>\
                    </div>\
                    <div class="col-xs-11">\
                        <div class="col-xs-12" style="min-height:30px;" v-html="message.comment"></div>\
                        <div class="col-xs-12" style="margin-top:15px;color:#cccccc;">{{message.comment_date}}</div>\
                    </div>\
                </div>\
            </div> -->

        <script>
            $(document).ready(function(){
                $(".goods_header").css("height",$(".goods_header").css("width"));
                $(".preview").css("height",$(".preview").css("width"));
                $("#comment_tab li:eq(0) a").tab('show');

                var ue = UE.getEditor('ueditor',{
                    toolbars: [
                        ['emotion','undo', 'redo', 'bold','italic','underline','strikethrough','subscript','formatmatch','simpleupload','insertimage',
                            'justifyleft','justifycenter','justifyright','justifyjustify','forecolor']
                    ],
                    autoHeightEnabled: false,
                    autoFloatEnabled: false,
                    zIndex:1,
                });

                Vue.component('comments-tab',{
                    props:['comments'],
                    template:'<div>\
                            <div class="col-xs-12" style="border-bottom:1px dashed #cccccc;padding-top:15px;" v-for="message in comments">\
                                <div class="row">\
                                    <div class="col-xs-12" style="min-height:30px;">\
                                        <div class="col-xs-1" style="text-align:center">\
                                            <div class="row"><img src="../main/adv.png" style="width:40px;height:40px;border-radius:20px;" /></div>\
                                            <div class="row" style="margin-top:5px;">{{message.commenter}}</div>\
                                        </div>\
                                        <div class="col-xs-10" style="word-wrap:break-word;" v-html="message.comment"></div>\
                                    </div>\
                                    <div class="col-xs-offset-1 col-xs-11" style="margin-top:15px;color:#cccccc;">{{message.comment_date}}</div>\
                                </div>\
                            </div>\
                        </div>',
                });
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
                        is_successful:false,
                    },
                    computed:{
                        convert_info:function(){
                            var info = {
                                goods_info:(this.goods_info.goods_info+'').replace(/<img[^>]+>/ig,"").substring(0,30),
                                goods_owner_info:'../users/others.php?user_id='+this.goods_info.goods_owner,
                                goods_status:'',
                                goods_type:'',
                            };
                            console.log(this.goods_info);
                            if (this.goods_info.goods_status == "available") info.goods_status = '在售';
                                else info.goods_status = '下架';
                            if (this.goods_info.goods_type == "sale") info.goods_type = '出售';
                                else info.goods_type = '租赁';
                            return info;
                        },
                        offer_cal:function(){
                            this.order_info.offer = this.order_info.single_cost * this.order_info.purchase_amount + this.order_info.delivery_fee;
                            return this.order_info.offer;
                        }
                    },
                    methods:{
                        new_order:function(){
                            console.log(this.order_info);
                            $.getJSON('../core/api-v1.php?action=new_order',this.order_info,function(data){
                                console.log(data);
                                if (data.status=="success") show_goods.is_successful = true;
                            });
                        },
                        comment_submit:function(){
                            var comment = ue.getContent();
                            $.getJSON("../core/api-show-goods.php",{goods_id:goods_id,action:"comment",comment:comment},function(data){
                                console.log(data);
                            });
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
                                if (result.status == "success") show_goods.goods_owner = result.user_info;
                            });
                        });
                    }
                });

            });
        </script>
    </body>
</html>
