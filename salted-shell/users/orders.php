<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>我的订单</title>
    </head>
    <body style="background-color:#F0F0F0;">
        <?php
            include "../frame/head_user.php";
            // if(isset($_GET['page'])) echo "<script>var now_page=".$_GET['page'].";</script>";
            //     else echo "<script>var now_page=1;</script>";
            $request = array(
                'page'  =>  1,
                'target'=>  'buy',
            );
            if(isset($_GET['page'])) $request['page'] = $_GET['page'];
            if(isset($_GET['target'])) $request['target'] = $_GET['target'];
            echo "<script>var request = ".json_encode($request).";</script>";
        ?>
        <script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
        <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
        <style>
            a{color:#95989A;text-decoration:none;transition-duration:0.4s;}
            a:hover{color:#FD9860;}
            .content{background-color: white;border-radius: 2px;min-height: 573px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px;}            
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
                top:55px;
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
                .od-list{padding-right:10px;}
            }
            @media(max-width:768px){
                .hd,.md{border-bottom:1px solid #E6E5E5;}
                .item{border-right:1px solid #E6E5E5;line-height:30px;border-top:1px solid #E6E5E5;}
                .md{padding:0;}
                .rt{border-bottom:1px solid #E6E5E5;}
                .bt{line-height:50px;}
            }
        </style>
        <div id="show_orders" style="margin-top:60px;">
            <div class="container" style="margin-bottom:10px;">
                <div class="col-xs-12" style="background-color: white;border-radius: 2px;box-shadow:0 1px 3px rgba(0,0,0,.1);padding-top: 10px;">
                    <div class="col-xs-12">
                        <p style="color:#FD9860;font-size:25px;padding-left:5px;">我的订单</p>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-bottom:20px;">
                <div class="row">
                    <div class="col-sm-9 od-list">
                        <div class="content" style="padding: 25px 35px 15px 35px;">
                            <ul class="nav nav-tabs" style="border-bottom:2px solid #FD9860;margin-bottom:10px;">
                                <li :class="{active:(request.target=='buy')}"><a :href="jump('buy')">我买的</a></li>
                                <li :class="{active:(request.target=='sale')}"><a :href="jump('sale')">我卖的</a></li>
                            </ul>
                            <div style="overflow:hidden;">
                                <div>
                                    <div v-if="request.target == 'buy' " class="row"><div class="col-xs-12"><my-order v-for="order in orders" :key="order.order_id" :order="order" type="buy" /></div></div>
                                    <div v-if="request.target == 'sale' " class="row"><div class="col-xs-12"><my-order v-for="order in orders" :key="order.order_id" :order="order" type="sale" /></div></div>
                                    <!-- <div v-if="request.target == 'both' " class="row"><div class="col-xs-12"><my-order v-for="order in orders" :key="order.order_id" :order="order" type="sale" /></div></div> -->
                                </div>
                                <div>
                                    <pagi :total="total_pages"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 name-tag hidden-xs">
                        <div class="pin" data-spy="affix" data-offset-top="80">
                            <div class="tag-content">
                                <name-tag :info="self_info" />
                            </div>
                            <div class="tag-content" style="margin-top:9px;">
                                <new-goods :goods="new_goods" />                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <script type="text/x-template" id="pagi">
                <div v-if="total > 0">
                    <div class="col-xs-12" style="text-align:center">
                        <ul v-if="total < 10" class="pagination pagination-sm">
                            <li v-if="(now_page!=1)"><a :href="jump(now_page != 1? now_page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li v-for="pg in total" :class="{active:(pg==now_page)}"><a :href="jump(pg)">{{pg}}</a></li>
                            <li v-if="(now_page!=total)"><a :href="jump(now_page != total? parseInt(now_page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else-if="total >= 10 && now_page < 5" class="pagination pagination-sm">
                            <li v-if="(now_page!=1)"><a :href="jump(now_page != 1? now_page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li v-for="pg in 5" :class="{active:(pg==now_page)}"><a :href="jump(pg)">{{pg}}</a></li>
                            <li class="disabled"><a>...</a></li>                            
                            <li><a :href="jump(total)">{{total}}</a></li>
                            <li v-if="(now_page!=5)"><a :href="jump(now_page != total? parseInt(now_page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else-if="total > 6 && now_page > total-5" class="pagination pagination-sm">
                            <li><a :href="jump(now_page != 1? now_page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li><a :href="jump(1)">1</a></li>
                            <li class="disabled"><a>...</a></li>
                            <li v-for="pg in 5" :class="{active:((pg+total-5)==now_page)}"><a :href="jump(pg+total-5)">{{pg+total-5}}</a></li>
                            <li v-if="(now_page!=total)"><a :href="jump(now_page != total? parseInt(now_page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else class="pagination pagination-sm">
                            <li><a :href="jump(now_page != 1? now_page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li><a :href="jump(1)">1</a></li>
                            <li class="disabled"><a>...</a></li>
                            <li v-for="pg in 5" :class="{active:((pg+parseInt(now_page)-3)==now_page)}"><a :href="jump(pg+parseInt(now_page)-3)">{{pg+parseInt(now_page)-3}}</a></li>
                            <li class="disabled"><a>...</a></li>                            
                            <li><a :href="jump(total)">{{total}}</a></li>
                            <li><a :href="jump(now_page != total? parseInt(now_page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                    </div>
                </div>
            </script>
        </div>

        <script>
            $(document).ready(function(){
                $(".preview").css("height",$(".preview").css("width"));
                var name_tag = $(".pin").css('width');
                $(".tag-content").css('width',name_tag);
                var orders_init = function(self_id){
                    // var order_submitter = (request.target == 'buy') ? 'self' : 'other';
                    var order_submitter = '';
                    switch (request.target) {
                        case 'buy':
                            order_submitter = 'self';
                            break;
                        case 'sale':
                            order_submitter = 'other';
                            break;
                        case 'both':
                            order_submitter = 'both';
                            break;
                        default:
                            break;
                    }
                    $.getJSON("../core/api-v1.php?action=list_orders",{page:request.page,order_submitter:order_submitter},function(data){
                        if(data.status == "success"){
                            show_orders.orders = data.orders;
                            show_orders.total_pages = data.total;
                            console.log(data);
                        }
                    });
                };

                var Pagi = {
                    props:['total'],
                    template:'#pagi',
                    methods:{
                        jump:function(page){
                            return "./orders.php?target="+request.target+"&page="+page;
                        }
                    },
                    computed:{
                        now_page:function(){return request.page;}
                    },
                }
                
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
                                    <div v-if="order.order_status == \'waiting\' " class="btn-group"><button class="btn btn-theme" disabled>等待受理</button><button class="btn btn-default" @click="edit_order(\'cancel_order\')">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'accepted\' " class="btn-group"><button class="btn btn-success" disabled>已经受理</button><button class="btn btn-default" disabled>等待配送</button></div>\
                                    <div v-else-if="order.order_status == \'completed\' " class="btn-group"><button class="btn btn-primary" @click="edit_order(\'finish_order\')">确认收货</button><button class="btn btn-default" @click="edit_order(\'cancel_order\')">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'finished\' " class="btn-group"><button class="btn btn-theme" disabled>订单完成</button></div>\
                                </div>\
                                <div v-else-if="type == \'sale\'" class="col-sm-3 bt" style="overflow:hidden;text-align:center;">\
                                    <div v-if="order.order_status == \'waiting\' " class="btn-group"><button class="btn btn-success" data-loading-text="接单中..." @click="edit_order(\'accept_order\')">接受订单</button><button class="btn btn-default" data-loading-text="撤销中..." @click="cancel_order">取消订单</button></div>\
                                    <div v-else-if="order.order_status == \'accepted\' " class="btn-group"><button class="btn btn-theme" @click="edit_order(\'complete_order\')">确认送达</button><button class="btn btn-default" data-loading-text="撤销中..." @click="edit_order(\'cancel_order\')">撤销订单</button></div>\
                                    <div v-else-if="order.order_status == \'completed\' " class="btn-group"><button class="btn btn-primary" disabled>货物送达</button><button class="btn btn-default" disabled>等待确认</button></div>\
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
                    methods:{
                        edit_order:function(action){
                            var t = this;
                            var title = '';
                            switch (action) {
                                case 'accept_order':title = '是否确认接单？';break;
                                case 'cancel_order':title = '是否取消订单？';break;
                                case 'complete_order':title = '确认送达';break;
                                case 'finish_order':title = '确认收货';break;
                                default:break;
                            }
                            swal({
                                title:title,
                                imageUrl:'../pic/funny.jpg',
                                showCancelButton: true,
                                confirmButtonColor: "#FD9860",
                                confirmButtonText: "确定",
                                cancelButtonText: "取消",
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                },
                                function(isConfirm){
                                    if (isConfirm) {
                                        t.edit_result(action);
                                    }
                            });
                        },
                        edit_result:function(action){
                            var order = this.order;
                            $.getJSON('../core/api-v1.php',{action:action,order_id:order.order_id},function(data){
                                if (data.status == 'success') {
                                    switch (action) {
                                        case 'accept_order':swal('接单成功！','您已接手了该订单（订单ID：'+order.order_id+'），请记得及时送达商品哦！','success');break;
                                        case 'cancel_order':swal('撤销成功','您已撤销了该订单','warning');break;
                                        case 'complete_order':swal('确认送达','您已将该订单下的商品送达，请等待买家确认','success');break;
                                        case 'finish_order':swal('确认收货','您已确认收到该订单下的货物，订单完成','success');break;
                                        default:break;
                                    }
                                    orders_init(self_info.info.student_id.value);
                                }else if (data.status == 'failed') {
                                    var title = '';
                                    var error = ''
                                    switch (data.error) {
                                        case 'No such order':title='订单不存在';error='该订单已被用户撤回';break;
                                        case 'Access dined':title='权限不足';error='非登陆状态，没有操作订单的权限';break;
                                        case ('You have no access to accept this order'||"This order is not yours"):title='权限不足';error='您不是该商品卖家，没有操作订单的权限';break;
                                        case "There's order but no goods??":title='粗问题了！！！';error='该订单下的商品不存在';break;
                                        case "You haven't accepted this order":title='权限不足';error='非登陆状态，没有操作订单的权限';break;
                                        case "There's order but no goods??":title='粗问题了！！！';error='该订单下的商品不存在';break;
                                        case "Bad status":title='粗问题了！！！';error='订单状态出错';break;
                                        case "This order had been completed already":title='操作有误';error='卖家已确认送货';break;
                                        case "Seller haven't completed this order yet!":title='操作有误';error='卖家尚未送货';break;
                                        case "This order had been finished already":title='操作有误';error='买家已确认收货';break;
                                        default:break;
                                    }
                                    swal(title,error,'error');
                                    orders_init(self_info.info.student_id.value);
                                }
                            });
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
                                    <div class="col-xs-2" style="padding:0;width:fit-content;"><div style="width:60px;height:60px;border-radius:2px;" :style="bg"></div></div>\
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
                                borderRadius:'2px',
                                boxShadow:'0 1px 3px rgba(0,0,0,.1)',
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
                                        <div style="width:70px;height:70px;border-radius:2px;" :style="img(go.goods_img)"></div>\
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
                                borderRadius:'2px',
                                boxShadow:'0 1px 3px rgba(0,0,0,.1)',
                            },
                        };
                    },
                };

                var show_orders = new Vue({
                    el:'#show_orders',
                    data:{
                        request:request,
                        self_info:{},
                        orders:[],
                        new_goods:[],
                        total_pages:0,
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
                    methods:{
                        jump:function(type){
                            return './orders.php?target='+type;
                        },
                    },
                    components:{
                        'my-order':Order,
                        'name-tag':Name,
                        'new-goods':New,
                        'pagi':Pagi,
                    }
                });
            });
        </script>
    </body>
</html>