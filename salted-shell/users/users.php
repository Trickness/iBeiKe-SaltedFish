<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>个人空间</title>
    </head>
    <body style="background-color:#F3F3F3;">
        <?php
            include "../frame/head_user.1.php";
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                echo "<script>var user_id = '".$user_id."';</script>";
            }
        ?>

        <style>
            .panel{max-width: 927px;background-color: white;border-radius: 4px;box-shadow: 0 0 4px #cccccc;}
            .info-item{line-height:20px;height:20px;}   .info-item img{width:18px;height:20px;}     .info-item span{margin-left:15px;}
            .header{width:160px;height:160px;margin-top:-50px;border:4px solid white;border-radius:10px;}
            .rank{height:40px;border-radius:7px;background-color:antiquewhite;margin-bottom:15px;}     .rank-item{float:left;padding:0 10px 0 10px;}
            .rank-act{border-bottom: 2px solid rgb(253, 152, 96);padding-bottom: 2px;color:#FD9860;}
            .goods-title{margin-top:5px;height:30px;}
            .single-cost{font-size:12px;}
            .goods{transition-duration:0.3s;}       .goods:hover{background-color:#F3F3F3;box-shadow:0 0 4px #cccccc;}
            a{color:black;}
            .user-info{margin-top:125px;min-height:130px;margin-bottom:12px;}
            @media(max-width:768px){
                .user-info{margin-top:100px;}
                .single-cost{font-size:10px;}                
                .header{width:140px;height:140px;margin-top:-25px;border:4px solid white;border-radius:10px;}
                .info-item{padding:0;}
                .info-item span{margin: 0;margin-left: 6px;font-size: 11px;}          
                .goods-title{font-size:10px;margin-top:2px;height:15px;}
            }
        </style>

        <div id="info_show">
            <div class="container panel user-info">
                <div class="row"><user-info :info="info" :user="user" /></div>
            </div>

            <div class="container panel" style="min-height:400px;">
                <goods-info :goods="goods" />
            </div>
        </div>

        <script>
            $(document).ready(function(){
                var Goods = {
                    props:['go'],
                    template:'<a :href="jump"><div class="col-xs-3" style="margin-bottom:10px;">\
                            <div class="goods">\
                                <div class="preview" ><div style="width:100%;border-radius:4px;" :style="bg"></div></div>\
                                <div style="padding:5px;">\
                                    <div class="row">\
                                        <div class="col-xs-12 goods-title" style="word-wrap:break-word;overflow:hidden;line-height:15px;">{{go.goods_title}}</div>\
                                    </div>\
                                    <div class="row">\
                                        <div class="col-sm-6" style="height:12px;line-height:12px;overflow:hidden;font-size:10px;">{{go.goods_owner}}</div>\
                                        <div class="col-sm-6 single-cost" style="height:12px;line-height:12px;overflow:hidden;color:#FD9860;text-align:right;"><b>￥{{go.single_cost}}</b></div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div></a>',
                    computed:{
                        bg:function(){
                            console.log(this.go);
                            var st = bg_ch(this.go.goods_img);
                            st.height = $(".preview").css("width");
                            return st;
                        },
                        jump:function(){
                            return "../goods/show.php?goods_id="+this.go.goods_id;
                        },
                    },
                }

                var UserInfo = {
                    props:['info','user'],
                    template:'<div class="col-xs-12">\
                            <div style="float:left">\
                                <p class="header" :style="bg(info.header)"></p>\
                            </div>\
                            <div class="col-xs-7" style="padding-top:10px;">\
                                <div class="row">\
                                    <div class="col-xs-12" style="font-size:25px;padding-bottom:10px;">{{info.nickname}}</div>\
                                </div>\
                                <div class="row info-con" style="height:30px;">\
                                    <div class="col-xs-4 info-item"><img src="../pic/users/id.png" /><span>{{user}}</span></div>\
                                    <div class="col-xs-4 info-item"><img src="../pic/users/name.png" /><span>{{info.name.value}}</span></div>\
                                    <div class="col-xs-4 info-item"><img src="../pic/users/dorm.png" /><span>{{dorm}}</span></div>\
                                </div>\
                                <div class="row info-con" style="height:30px;">\
                                    <div class="col-xs-4 info-item"><img src="../pic/users/type.png" /><span>{{info.type.value}}</span></div>\
                                    <div class="col-xs-4 info-item"><img style="width: 25px;height: 30px;margin-left: -3px;margin-top: -5px;" :src="gender" /></div>\
                                </div>\
                            </div>\
                        </div>',
                    methods:{
                        bg:function(url){
                            return bg_ch(url);
                        },
                    },
                    computed:{
                        gender:function(){
                            var src = "";
                            if (this.info.gender.value =="男") src = "../pic/users/male.png";
                                else src = "../pic/users/female.png";
                            return src;
                        },
                        dorm:function(){
                            return this.info.dormitory.dormitory_id.value + "斋" + this.info.dormitory.room_no.value;
                        }
                    },
                };

                var GoodsInfo = {
                    props:['goods'],
                    template:'<div class="col-xs-12" style="margin-bottom:30px;">\
                            <div class="row" style="padding: 10px 10px 0 10px;"><h4>TA的宝贝</h4></div>\
                            <div class="row" style="padding:0 10px 0 10px;">\
                                <div class="col-xs-12 rank">\
                                    <div class="rank-item" style="line-height:40px;"><span class="rank-act">新品抢鲜</span></div>\
                                    <div class="rank-item" style="line-height:40px;">人气排行</div>\
                                </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-xs-12"><div class="col-xs-3"><div class="preview"></div></div></div>\
                                <div class="col-xs-12">\
                                    <goods v-for="go in goods" :go="go" />\
                                </div>\
                            </div>\
                        </div>',
                    components:{
                        'goods':Goods
                    },
                };

                var info_show = new Vue({
                    el:'#info_show',
                    data:{
                        info:{},
                        goods:[],
                        user:'',
                    },
                    created:function(){
                        console.log(user_id);
                        $.getJSON("../core/api-v1.php",{action:"fetch_user_total_info",user_id:user_id},function(data){
                            if (data.status=="success") {
                                info_show.info = data.info;
                                info_show.goods = data.goods;
                                info_show.user = data.target_id;
                            }
                            console.log(info_show.goods);
                        });
                    },
                    components:{
                        'user-info':UserInfo,
                        'goods-info':GoodsInfo,
                    },
                });
            });
        </script>
    </body>
</html>