<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>我的订单</title>
    </head>
    <body style="background-color:#F0F0F0;">
        <?php include "../frame/head_user.php"; ?>
        <style>
            a{color:#95989A;text-decoration:none;transition-duration:0.4s;}
            a:hover{color:#FD9860;}
            .content{background-color: white;border-radius: 4px;min-height: 573px;box-shadow: 0 0 4px grey;margin-bottom:20px;}            
            .my-order{
                border:1px solid #E6E5E5;
                margin-bottom:20px;
            }
            .my-order .header{
                padding-top:5px;
                min-height:30px;
                background-color:#E6E5E5;
                color:#95989A;
            }
            .my-order .text{
                padding-top:10px;padding-bottom:10px;word-wrap:break-word;
            }
            .pin.affix{
                top:65px;
            }
            .rt{padding-top:30px;}
            .offer{padding-top:10px;}  
            .btn-theme{background-color:#FD9860;color:white;}          
            .btn-theme:hover{color:white;}          
            @media(min-width:1300px){
                .name-tag{padding-left:0;}
                .rt{border-right:1px solid #E6E5E5;}
                .item{border-left:1px solid #E6E5E5;border-right:1px solid #E6E5E5;line-height:70px;}
                .bt{line-height:70px;}
                .hd{height:70px;}
            }
            @media(max-width:768px){
                .hd,.md{border-bottom:1px solid #E6E5E5;}
                .item{border-right:1px solid #E6E5E5;line-height:30px;border-top:1px solid #E6E5E5;}
                .md{padding:0;}
                .rt{border-bottom:1px solid #E6E5E5;}
                .bt{line-height:50px;}
            }
        </style>
        <div id="show_orders" style="margin-top:70px;">
            <div class="container" style="margin-bottom:15px;">
                <div class="col-xs-12" style="background-color: white;border-radius: 4px;box-shadow: 0 0 4px grey;padding-top: 10px;">
                    <div class="col-xs-12">
                        <p style="color:#FD9860;font-size:25px;padding-left:5px;">我的订单</p>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 15px;margin-bottom:20px;">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="content" style="padding: 25px 35px 15px 35px;">
                            <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #FD9860;margin-bottom:10px;">
                                <li class="active"><a href="#user-buy" data-toggle="tab">我买的</a></li>
                                <li><a href="#user-sale" data-toggle="tab">我卖的</a></li>
                            </ul>
                            <div class="tab-content" style="overflow:hidden;">
                                <div id="user-buy" class="tab-pane active">
                                    <div class="row"><div class="col-xs-12"><my-order v-for="order in orders_buy" :key="order.order_id" :order="order" type="buy" /></div></div>
                                </div>
                                <div id="user-sale" class="tab-pane">
                                    <div class="row"><div class="col-xs-12"><my-order v-for="order in orders_sale" :key="order.order_id" :order="order" type="sale" /></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 name-tag hidden-xs">
                        <div class="pin" data-spy="affix" data-offset-top="90">
                            <div class="tag-content">
                                <name-tag :info="self_info" />
                            </div>
                            <div class="tag-content" style="margin-top:15px;">
                                <new-goods :goods="new_goods" />                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $(".preview").css("height",$(".preview").css("width"));
                var name_tag = $(".pin").css('width');
                $(".tag-content").css('width',name_tag);
                var orders_init = function(self_id){
                    $.getJSON("../core/api-v1.php?action=list_orders",function(data){
                        if(data.status == "success"){
                            data.orders.forEach(function(element) {
                                if (element.order_submitter == self_id) {show_orders.orders_buy.push(element);}
                                if (element.goods_owner == self_id) {show_orders.orders_sale.push(element);}
                            });
                        }
                    });
                };
                
                var Order = {
                    props:['order','type'],
                    template:'<div class="col-xs-12 my-order">\
                            <div class="row header">\
                                <div class="col-xs-5">{{convert_info.ordering_date}}</div>\
                                <div class="col-xs-4">订单ID：{{order.order_id}}</div>\
                                <div class="col-xs-3">卖家：<a :href="convert_info.goods_owner">{{order.goods_owner}}</a></div>\
                            </div>\
                            <div class="row hd" style="background-color:white;">\
                                <div class="col-sm-4" style="padding-top:10px;padding-bottom:10px;overflow:hidden;">\
                                    <div class="col-xs-3" style="padding:0;">\
                                        <div style="width:50px;height:50px;" :style="bg"></div>\
                                    </div>\
                                    <div class="col-xs-7"><a :href="convert_info.goods_title">{{order.goods_title}}</a></div>\
                                    <div class="col-xs-2">x{{order.purchase_amount}}</div>\
                                </div>\
                                <div class="col-sm-5 md" style="overflow:hidden;text-align:center;">\
                                    <div class="col-xs-7 item">总额<span style="color:#FD9860;">￥{{order.offer}}</span></div>\
                                    <div class="col-xs-5 item">运费<span style="color:#FD9860;">￥{{order.delivery_fee}}</span></div>\
                                </div>\
                                <div v-if="type == \'buy\'" class="col-sm-3 bt" style="overflow:hidden;text-align:center;">\
                                    <div v-if="order.order_status == \'waiting\' " class="btn-group"><button class="btn btn-theme" disabled>等待受理</button><button class="btn btn-default">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'accepted\' " class="btn-group"><button class="btn btn-success" disabled>已经受理</button><button class="btn btn-default" disabled>等待配送</button></div>\
                                    <div v-else-if="order.order_status == \'completed\' " class="btn-group"><button class="btn btn-primary">确认收货</button><button class="btn btn-default">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'finished\' " class="btn-group"><button class="btn btn-theme" disabled>订单完成</button></div>\
                                </div>\
                                <div v-else-if="type == \'sale\'" class="col-sm-3 bt" style="overflow:hidden;text-align:center;">\
                                    <div v-if="order.order_status == \'waiting\' " class="btn-group"><button class="btn btn-success">接受订单</button><button class="btn btn-default">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'accepted\' " class="btn-group"><button class="btn btn-theme">确认送达</button><button class="btn btn-default">撤销订单</button></div>\
                                    <div v-else-if="order.order_status == \'completed\' " class="btn-group"><button class="btn btn-primary" disabled>货物送达</button><button class="btn btn-default" diabled>等待确认</button></div>\
                                    <div v-else-if="order.order_status == \'finished\' " class="btn-group"><button class="btn btn-theme" disabled>订单完成</button></div>\
                                </div>\
                            </div>\
                        </div>',
                    computed:{
                        convert_info:function(){
                            // console.log(this.sam);
                            var ordering_date = (this.order.ordering_date+"").substring(0,19);
                            var goods_owner = "../users/users.php?user_id="+this.order.goods_owner;
                            var goods_title = "../goods/show.php?goods_id="+this.order.goods_id;
                            var order_status = '';
                            switch (this.order.order_status) {
                                case "waiting":
                                    order_status = '等待受理';
                                    break;
                                case "accepted":
                                    order_status = '已经受理';                                    
                                    break;
                                case "completed":
                                    order_status = '等待送货';                                    
                                    break;
                                case "finished":
                                    order_status = '订单完成';                                    
                                    break;
                                default:
                                    break;
                            }
                            return{
                                ordering_date:ordering_date,
                                goods_owner:goods_owner,
                                order_status:order_status,
                                goods_title:goods_title,
                            };
                        },
                        bg:function(){
                            return bg_ch(this.order.goods_img);
                        },
                        hg_sync:function(){
                            return {
                                height:$('.preview').css('width'),
                            };
                        },
                        gravity:function(){
                            return {lineHeight:$('.hd').css('height'),};
                        },
                        is_show:function(){
                            var sh = 'block';
                            if (this.type=="none") {
                                sh = 'none';
                            }
                            return {
                                display:sh,
                            };
                        },
                    },
                    created:function(){
                        $(".preview").css("height",$(".preview").css("width"));
                    },
                };

                var Name = {
                    props:['info'],
                    template:'<div :style="my_style">\
                            <div class="col-xs-12" style="margin-top:15px;">\
                                <div style="overflow:hidden;padding-bottom:10px;border-bottom:2px solid #FD9860;">\
                                    <div class="col-xs-2" style="padding:0;width:fit-content;"><div style="width:60px;height:60px;border-radius:5px;" :style="bg"></div></div>\
                                    <div class="col-xs-9" style="line-height:60px;font-size:20px;"><a href="./index.php">{{info.nickname}}</a></div>\
                                </div>\
                            </div>\
                            <div class="col-xs-12" style="text-align:center;font-size:15px;margin-top:10px;">\
                                <div class="col-xs-4">ID</div>\
                                <div class="col-xs-4">姓名</div>\
                                <div class="col-xs-4">班级</div>\
                            </div>\
                            <div class="col-xs-12" style="text-align:center;margin-top:10px;">\
                                <div class="col-xs-4">{{info.student_id.value}}</div>\
                                <div class="col-xs-4">{{info.name.value}}</div>\
                                <div class="col-xs-4" style="font-size:12px;">{{info.class_info.class_no.value}}</div>\
                            </div>\
                        </div>\
                    ',
                    data:function(){
                        return {
                            my_style:{
                                width:'100%',
                                overflow:'hidden',
                                paddingBottom:'10px',
                                background:'white',
                                borderRadius:'5px',
                                boxShadow:'0 0 4px grey',
                            },
                        };
                    },
                    computed:{
                        bg:function(){
                            return bg_ch(this.info.header);
                        },
                    },
                };

                var New = {
                    props:['goods'],
                    template:'<div :style="my_style" style="min-height:400px;">\
                            <div class="col-xs-12" style="margin-top:10px;">\
                                <div style="padding-bottom:5px;border-bottom:2px solid #FD9860;font-size:18px;">新品推荐</div>\
                            </div>\
                            <div v-for="go in goods" class="col-xs-12" style="margin-top:8px;">\
                                <div style="padding-bottom:8px;border-bottom:1px solid #E6E5E5;overflow:hidden;">\
                                    <div class="col-xs-3" style="padding:0;">\
                                        <div style="width:70px;height:70px;border-radius:5px;" :style="img(go.goods_img)"></div>\
                                    </div>\
                                    <div class="col-xs-6">\
                                        <div style="word-wrap:break-word;"><a :href="show_goods(go.goods_id)">{{go.goods_title}}</a></div>\
                                    </div>\
                                    <div class="col-xs-1" style="color:#FD9860;padding:0;">￥{{go.single_cost}}</div>\
                                </div>\
                            </div>\
                        </div>',
                    methods:{
                        img:function(url){
                            console.log(this.info);
                            return {
                                backgroundImage:'url("'+url+'")',
                                backgroundSize:'cover',
                                backgroundPosition:'center',
                                backgroundRepeat:'no-repeat',
                            };
                        },
                        show_goods:function(goods_id){
                            return "../goods/show.php?goods_id="+goods_id;
                        },
                    },
                    data:function(){
                        return {
                            my_style:{
                                width:'100%',
                                overflow:'hidden',
                                paddingBottom:'10px',
                                background:'white',
                                borderRadius:'5px',
                                boxShadow:'0 0 4px grey',
                            },
                        };
                    },
                };

                var show_orders = new Vue({
                    el:'#show_orders',
                    data:{
                        self_info:{},
                        orders_buy:[],
                        orders_sale:[],
                        new_goods:[],
                    },
                    computed:{
                        sam:function(){return this.orders_buy[0];}
                    },
                    created:function(){
                        $.getJSON("../core/api-v1.php?action=fetch_self_info",function(data){
                            if(data.status == "success"){
                                show_orders.self_info = data.self_info;
                                orders_init(data.self_info.student_id.value);
                            }
                        });
                        $.getJSON('../core/api-users-info.php?action=new',function(data){
                            if (data.status=="success") {
                                show_orders.new_goods = data.goods;
                            }
                            console.log(show_orders.new_goods);
                        });
                    },
                    components:{
                        'my-order':Order,
                        'name-tag':Name,
                        'new-goods':New,
                    }
                });
            });
        </script>
    </body>
</html>