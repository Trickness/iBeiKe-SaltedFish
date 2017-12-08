<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商品展示</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="background-color:#F0F0F0;">
        <?php
            include "../frame/head_user.php";
            if (isset($_GET['goods_id'])) {
                $goods_id = $_GET['goods_id'];
                echo "<script>var goods_id = {$goods_id};</script>";
            }
        ?>
        <script src="../js/goods-utils.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>
        <link href="../css/default.css" rel="stylesheet" />
        
        <div id="show_goods" class="container" style="overflow:hidden;margin-top:70px;background-color:white;border-radius:2px;padding-top:40px;margin-bottom:70px;box-shadow:0 1px 3px rgba(0,0,0,.1);padding-bottom:70px;">
            <div v-if="have_goods == 'yes'">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="col-sm-offset-1 col-sm-10">
                            <!-- <div class="row"><a :href="goods_info.goods_img"><img id="shown_img" alt="商品大图" src="../main/goods.jpg" :src="goods_info.goods_img" class="goods_header" style="width:100%;" /></a></div> -->
                            <div class="row">
                                <div class="goods_header" :style="img_style(goods_thumb)"></div>
                            </div>
                            
                            <div class="row" style="margin-top:10px;height:fit-content;">
                                <div v-for="img in imgs" class="col-xs-3">
                                    <div class="preview" :style="img_style(img)" @mouseover="change_thumb(img)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="goods_info">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 v-cloak>{{goods_info.goods_title}}</h2>
                            </div>
                        </div>
                        <div class="row" style="border-top:1px dashed #cccccc;margin-bottom:10px;"><div class="col-xs-12">
                            <div v-html="convert_info.goods_info" style="overflow-y:auto;height:80px;border-radius:5px;margin-top:10px;"></div>
                        </div></div>
                        <div class="row" style="border-top:1px dashed #cccccc;"><div class="col-xs-12">
                            <div style="background-color:#FFE1C9;padding:10px 0 10px 15px;border-radius:5px;margin-top:30px;">
                                <span>定价&nbsp;&nbsp;</span>
                                <span style="color:#FD9860;font-size:25px;">￥<span v-html="goods_info.single_cost"></span><span v-if="goods_info.goods_type == 'rent'">/天</span></span>
                            </div>
                        </div></div>
                        <div class="row" style="border-top:1px dashed #cccccc;padding-top:10px;">
                            <div class="col-xs-6" v-cloak>商品状态：{{convert_info.goods_status}}</div>
                            <div class="col-xs-6" v-cloak>交易方式：{{convert_info.goods_type}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <h4 style="float:left">数量：</h4>
                            </div>
                            <div class="form-group col-xs-4">
                                <input type="number" class="form-control" min="0" :max="goods_info.remain" v-model="order_info.purchase_amount">
                            </div>
                            <div class="col-xs-4">
                                <h5 v-cloak>（库存：{{goods_info.remain}}）</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <h4 style="float:left">议价：</h4>
                            </div>
                            <div class="form-group col-xs-4">
                                <input type="number" class="form-control" min="0" max="999999" v-model="order_info.single_cost">
                            </div>
                            <div class="col-xs-4">
                                <h5 v-cloak v-if="goods_info.goods_type == 'sale'">（元/个）</h5>
                                <h5 v-cloak v-else-if="goods_info.goods_type == 'rent'">（元/(个*天)）</h5>
                            </div>
                        </div>
                        <div class="row" v-if="goods_info.goods_type == 'rent'">
                            <div class="col-xs-3">
                                <h4 style="float:left">租期：</h4>
                            </div>
                            <div class="form-group col-xs-4">
                                <input type="number" class="form-control" min="1" :max="999" v-model="order_info.rent_duration">
                            </div>
                            <div class="col-xs-4">
                                <h5 v-cloak>（天）</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <h4 style="float:left">递送：</h4>
                            </div>
                            <div class="form-group col-xs-4">
                                <select class="form-control" v-model="order_info.delivery_fee">  
                                    <option v-for="option in delivery_options" v-bind:value="option.value">  
                                        {{ option.text }}  
                                    </option>  
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button v-if="goods_info.buyer_info!=undefined && islogin == true && goods_info.goods_type == 'sale'" class="col-xs-4 col-xs-offset-4 new_order" data-toggle="modal" data-target="#myModal">立即购买</button>
                                <button v-else-if="goods_info.buyer_info!=undefined && islogin == true && goods_info.goods_type == 'rent'" class="col-xs-4 col-xs-offset-4 new_order" data-toggle="modal" data-target="#myModal">申请租赁</button>
                                <button v-else-if="goods_info.buyer_info!=undefined && islogin == false" disabled="true" class="col-xs-4 col-xs-offset-4 banned_order" data-toggle="modal" data-target="#myModal">您尚未登陆</button>
                                <button v-else disabled="true" class="col-xs-4 col-xs-offset-4 banned_order" data-toggle="modal" data-target="#myModal">立即购买</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <div style="margin-top:20px;">
                                <ul class="name-card hidden-xs" style="background-color:white;list-style-type:none;line-height:30px;padding:35px;border-radius:5px;" data-spy="affix">
                                    <li style="text-align:center;"><img class="owner_header" :src="goods_info.goods_owner_info.header" style="width:120px;height:120px;border-radius:60px;" /></li>
                                    <li style="text-align:center;font-size:20px;" v-cloak>{{goods_info.goods_owner_info.nickname}}</li>
                                    <li v-cloak>学号：{{goods_info.goods_owner_info.student_id}}</li>
                                    <li v-cloak>姓名：{{goods_info.goods_owner_info.name}}</li>
                                    <li v-cloak>电话：{{goods_info.goods_owner_info.phone_number}}</li>
                                    <li style="text-align:center;">
					<a v-if="islogin" :href="convert_info.goods_owner_info"><button id="contect">联系卖家</button></a>
					<button disabled v-else class="banned_order">您尚未登陆</button>
				    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height:800px;">
                    <div class="col-xs-12">
                        <div class="col-sm-10">
                            <ul id="comment_tab" class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #FD9860;">
                                <li><a href="#info" data-toggle="tab">商品详情</a></li>
                                <li class="active"><a href="#comments" data-toggle="tab">留言板</a></li>
                                <li><a href="#editor" data-toggle="tab">我要留言</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="comments" class="tab-pane active">
                                    <comments-tab :comments="goods_info.comments">
                                </div>
                                <div id="info" class="tab-pane" v-html="goods_info.goods_info" style="word-wrap:break-word;padding:20px;overflow-x:auto;"></div>
                                <div id="editor" class="tab-pane">
                                    <div class="row">
                                        <div class="col-xs-10 col-xs-offset-1" style="padding-top:20px;">
                                            <script type="text/plain" id="ueditor" style="height:300px;"></script>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top:20px;text-align:center;">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#mywin">提交评论</button>
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
                                                <tr><td><b>卖家</b></td><td v-cloak>{{goods_info.goods_owner_info.student_id}}</td><td v-cloak>{{goods_info.goods_owner_info.name}}</td><td v-cloak>{{goods_info.goods_owner_info.phone_number}}</td></tr>
                                                <tr><td><b>买家</b></td><td v-cloak>{{goods_info.buyer_info.student_id}}</td><td v-cloak>{{goods_info.buyer_info.name}}</td><td v-cloak>{{goods_info.buyer_info.phone_number}}</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div></div>
                                <div class="row"><div class="col-xs-10 col-xs-offset-1">
                                    <table class="table table-bordered">
                                        <thead><th>商品ID</th><th>商品名称</th><th>交易方式</th><th>单价</th><th>购买数量</th><th>运费</th><th>总计</th></thead>
                                        <tbody>
                                            <tr>
                                                <td v-cloak>{{order_info.goods_id}}</td>
                                                <td v-cloak>{{goods_info.goods_title}}</td>
                                                <td v-cloak>{{convert_info.goods_type}}</td>
                                                <td v-cloak>{{order_info.single_cost}}<span v-if="goods_info.goods_type == 'rent'">/天</span></td>
                                                <td v-cloak>{{order_info.purchase_amount}} 个<span v-if="goods_info.goods_type == 'rent'"> x {{order_info.rent_duration}} 天</td>
                                                <td v-cloak>{{order_info.delivery_fee}}</td>
                                                <td v-cloak>{{offer_cal}}</td></tr></tbody>
                                    </table>
                                </div></div>
                            </div>

                            <div class="modal-footer">
                                <transition name="bounce">
                                    <div v-if="status=='editing'">
                                            <button type="button" @click="new_order" class="btn btn-primary">确认申请</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    </div>
                                </transition>
                                <transition name="bounce">
                                    <div v-if="status=='success'">
                                        <div style="text-align:center">
                                            <div class="row"><h4>恭喜，下单成功！本页面将在3秒后跳转。</h4></div>
                                            <!-- <div class="row"><button class="btn btn-default" @click="jump()" data-dismiss="modal">继续购物</button></div> -->
                                        </div>
                                    </div>
                                    <div v-if="status == 'error'">
                                        <div style="text-align:center;">
                                            <div class="row"><h4 v-cloak>{{error}}</h3></div>
                                            <div class="row"><button class="btn btn-default" @click="status = 'editing'" data-dismiss="modal">继续购物</button></div>
                                        </div>
                                    </div>
                                </transition>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            
                <div class="modal fade" id="mywin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                                <h4 class="modal-title" id="myModalLabel">通知</h4>
                            </div>
                            <div class="modal-body">
                                是否要提交评论？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-success" @click="comment_submit">确定提交</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="have_goods == 'no'" style="height:500px;">
                <div class="col-xs-12" style="text-align:center;color:#fd9860;margin-top:200px;">
                    <h3>非常抱歉，该商品不存在。。。</h3>
                </div>
            </div>
        </div>

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
                                            <div class="row"><a :href="message.commenter_info.user_url"><img src="../main/adv.png" :src="message.commenter_info.header" style="width:40px;height:40px;border-radius:20px;" /></a></div>\
                                            <div class="row" style="margin-top:5px;" v-cloak>{{message.commenter}}</div>\
                                        </div>\
                                        <div class="col-xs-10" style="word-wrap:break-word;" v-html="message.comment"></div>\
                                    </div>\
                                    <div class="col-xs-offset-1 col-xs-11" style="margin-top:15px;color:#cccccc;" v-cloak>{{message.comment_date}}</div>\
                                </div>\
                            </div>\
                        </div>',
                });

                var Win = {
                    props:['winid'],
                    template:'#win',
                };

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
                            rent_duration:1,
                        },

                        status:'editing',
                        error:null,
                        have_goods:'waiting',

                        // 图片试验
                        // imgs:[],
                        goods_thumb:'',
                        // delivery type
                        delivery_options : [
                            {
                                text : "送达宿舍",
                                value : 0
                            },{
                                text : "买家自取",
                                value : 0
                            }
                        ]
                    },
                    computed:{
                        islogin:function(){
                            return self_info.is_login;
                        },
                        convert_info:function(){
                            var info = {
                                goods_info:(this.goods_info.goods_info+'').replace(/<img[^>]+>/ig,""),
                                goods_owner_info:'../users/users.php?user_id='+this.goods_info.goods_owner,
                                goods_status:'',
                                goods_type:'',
                            };
                            if (this.goods_info.goods_status == "available") info.goods_status = '在售';
                                else info.goods_status = '下架';
                            if (this.goods_info.goods_type == "sale") info.goods_type = '出售';
                                else info.goods_type = '租赁';
                            return info;
                        },
                        offer_cal:function(){
                            if (this.goods_info.goods_type == 'sale')
                                this.order_info.offer = this.order_info.single_cost * this.order_info.purchase_amount + this.order_info.delivery_fee;
                            else 
                                this.order_info.offer = this.order_info.single_cost * this.order_info.purchase_amount * this.order_info.rent_duration + this.order_info.delivery_fee;
                            return this.order_info.offer;
                        },
                        imgs:function(){
                            var reg = /src=[\'\"]?([^\'\"]*).(jpg|png|jpeg|img)[\'\"]?/gi;
                            var imgs = [];
                            if (this.goods_info.goods_info != undefined) {
                                imgs = (this.goods_info.goods_info+"").match(reg);
                                imgs.forEach(function(val,index,arr) {imgs[index] = imgs[index].replace(/src="|"/gi,"");});
                                if(this.goods_thumb == "") this.goods_thumb = imgs[0];
                            }
                            return imgs.slice(0,4);
                        },
                    },
                    methods:{
                        new_order:function(){
                            $.getJSON('../core/api-v1.php?action=new_order',this.order_info,function(data){
                                console.log(data);
                                if (data.status=="success") {
                                    show_goods.status = 'success';
                                    setTimeout(function() {
                                        window.location = "../users/orders.php";
                                    }, 3000);
                                }else if(data.status == 'failed'){
                                    show_goods.status = 'error';
                                    switch (data.error) {
                                        case 'This goods is not available':
                                            show_goods.error = '非常抱歉，该商品暂时下架，无法下单购买。';                                            
                                            break;
                                        case 'No enough goods':
                                            show_goods.error = '非常抱歉，您的选购数量超过了商品库存,无法下单。';                                            
                                            break;
                                        case 'No such goods':
                                            show_goods.error = '非常抱歉，由于某种神秘力量，商品消失了。';                                            
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            });
                        },
                        comment_submit:function(){
                            var comment = ue.getContent();
                            $.getJSON("../core/api-show-goods.php",{goods_id:goods_id,action:"comment",comment:comment},function(data){
                                if (data.status=="success") {
                                    window.location = "./show.php?goods_id="+goods_id;
                                }
                            })
                        },

                        jump:function(){
                            window.location = "../users/orders.php";
                        },

                        // 图片测试
                        img_style:function(img){
                            var style = {
                                width:'100%',
                                backgroundImage:"url("+img+")",
                                backgroundSize:'cover',
                                backgroundPosition:'center',
                                backgroundRepeat:'no-repeat',
                                boxShadow:'0 0 5px #cccccc',
                            };
                            return style;
                        },
                        change_thumb(img){
                            this.goods_thumb = img;
                        }
                    },
                    created:function(){
                        $.get('../core/api-show-goods.php',{action:'show',goods_id:goods_id},function(data){
                            if (data!='No such goods') {
                                data = JSON.parse(data);
                                if(data.comments != null){
                                    data.comments.forEach(function(val,index,arr){
                                        arr[index].commenter_info.user_url = "../users/users.php?user_id=" + val.commenter;
                                    });
                                }
                                document.title = "商品详情 "+data.goods_title;
                                show_goods.goods_info = data;
                                show_goods.order_info.goods_id = show_goods.goods_info.goods_id;
                                // delivery fee
                                show_goods.delivery_options[0].value = data.delivery_fee;
                                show_goods.delivery_options[0].text = "送达宿舍（"+data.delivery_fee+"元）";
                                show_goods.delivery_options[1].value = 0;
                                show_goods.delivery_options[1].text = "买家自提（0元）";

                                // rent duration

                                show_goods.order_info.order_type = show_goods.goods_info.goods_type;
                                show_goods.order_info.delivery_fee = parseFloat(data.delivery_fee);
                                show_goods.order_info.single_cost = parseFloat(data.single_cost);
                                show_goods.have_goods = 'yes';
                            }else{
                                show_goods.have_goods = 'no';
                            }
                            console.log(data);
                        });
                    },
                });

            });
        </script>
    </body>
</html>
