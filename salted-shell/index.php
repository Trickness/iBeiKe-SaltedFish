<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>贝壳商城-让你的闲置动起来(O(∩_∩)O)</title>
    </head>
    <body>
        <?php 
            include "./frame/head_main.php";
            if(isset($_GET['search'])){
                $target = array(
                    'type'      =>  'search',
                    'search'    =>  $_GET['search'],
                    'page'      =>  1,
                );
                if (isset($_GET['page']))  $target['page'] = $_GET['page'];
                echo "<script>var target = ".json_encode($target).";</script>";
            }elseif (isset($_GET['category'],$_GET['level'])) {
                $target = array(
                    'type'      =>  'category',
                    'category'  =>  $_GET['category'],
                    'level'     =>  $_GET['level'],
                    'page'      =>  1,
                );
                if (isset($_GET['page']))  $target['page'] = $_GET['page'];
                echo "<script>
                        var target = ".json_encode($target).";
                    </script>";
            }else{
                echo "<script>var target = null;</script>";
            }
        ?>
        <style>
            a{color:black;text-decoration:none;}    a:hover{text-decoration:none;color:#FD9860;}
            .test{border:1px solid black;height:500px;}
            .search-tips input[type="text"]{padding:0 10px 0 10px;width:75%;border:3px solid #FD9860;height:35px;}      .search-tips input[type="text"]:focus{text-decoration:none;}
            .search-tips input[type="submit"]{transition-duration:0.3s;background-color: #FD9860;border: none;height: 35px;width: 20%;margin-left: -4px;color: white;}  .search-tips input[type="submit"]:hover{opacity:0.6;}
            .lt-pn{height:450px;background-color:#FD9860;border-radius:2px;}
            .cl1:hover{background-color:#FFCC33;}   .cl1 a{color:white;}
            .reco-lt,.reco-rt{padding:0;overflow:hidden;}
            .order{height:90px;border:1px solid #e6e5e5;margin-bottom:18px;transition-duration:0.3s;}    .order:hover{box-shadow:0 0 6px grey;}
            .order-info{height:25px;background-color:#E6E5E5;line-height:25px;font-size:11px;}
            .rt-float.affix{top:70px;}
            .goods{transition-duration:0.3s;}       .goods:hover{background-color:#F3F3F3;box-shadow:0 0 4px #cccccc;}      .goods-title{margin-top:5px;height:30px;}   .single-cost{font-size:12px;}
            .hov{transition-duration:0.3s;}     .hov:hover{opacity:0.6;box-shadow:0 0 6px grey;}
            @media(min-width:768px){
                .or-con{width:112px;}
                .carousel{height:310px;background-color:#f3f3f3;border-radius:2px;}    .carousel .item{height:310px;line-height:310px;text-align:center;}   .carousel-control.right,.carousel-control.left{top:130px;}
                .lt-tl{color:white;font-size:20px;padding:10px 0 10px 15px;}
                .neckrow{padding:0;}
                .rt{float:right;}
                .bd-rt{border-right:1px solid #cccccc;}
                .cl1{transition-duration:0.3s;padding: 15px;font-size: 20px;color: white;}
                .ct-rt{padding-right:0;}
                .ct-goods{height:97px;}
            }
            @media(max-width:768px){
                .ct-rt{padding:0;}
                .ct-goods{height:45px;}
                .or-con{width:220px;}
                .order{margin-bottom:5px;}
                .reco-lt{margin-bottom:10px;}
                .carousel{height:200px;background-color:#f3f3f3;border-radius:2px;}    .carousel .item{height:200px;line-height:200px;text-align:center;}   .carousel-control.right,.carousel-control.left{top:90px;}
                .lt-tl{color:white;padding:5px;}
                .cl1{font-size: 10px;color: white;}
                .ct{text-align:center;}
                .search-tips{text-align:center;}
                .lt-pn{height:200px;}
                .order-rt{padding:10px 45px 10px 45px;}
            }
            .carousel-control.left {
                background-image:none;
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);
            }
            .carousel-control.right {
                left: auto;
                right: 0;
                background-image:none;
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);
            }
        </style>

        <div id="main_page" style="padding-bottom:50px;">
            <div class="container" style="margin-top:70px;">
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-xs-4 ct"><a href="./login/login.php" style="color:#FD9860;">快速登录</a></div>
                            <div class="col-xs-4 ct"><a href="./signin/signin.php">免费注册</a></div>
                            <div class="col-xs-4 ct" style="padding-right:0;">手机逛商城</div>
                        </div>
                    </div>
                    <div class="col-md-3 rt">
                        <div class="row">
                            <div class="col-xs-4 col-sm-offset-4 ct">联系客服</div>
                            <div class="col-xs-4 ct">新手须知</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7"><search-goods /></div>
                    <div class="col-sm-5" style="line-height:36px;margin-bottom:20px;">
                        <div class="col-sm-5"><div class="row">
                            <div class="col-xs-6 neckrow ct"><a href="./index.php?category=实体商品&level=1" style="color:#FD9860;">实体商品</a></div>
                            <div class="col-xs-6 neckrow ct bd-rt"><a href="./index.php?category=非实体商品&level=1" style="color:#FD9860;">非实体商品</a></div>
                        </div></div>
                        <div class="col-sm-7">
                            <div class="col-xs-4 neckrow ct"><a href="./index.php?category=电子产品&level=2">电子产品</a></div>
                            <div class="col-xs-4 neckrow ct"><a href="./index.php?category=生活用品&level=2">生活用品</a></div>
                            <div class="col-xs-4 neckrow ct"><a href="index.php?category=书类&level=2">书类</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="container">
                    <div class="row"><div class="col-xs-12 ct-rt">
                        <div class="col-sm-2 hidden-xs" style="padding:0;">
                            <div class="col-xs-12 lt-pn"><left-pane :goods="goods_cl" /></div>
                        </div>
                        <div v-if="target == null">
                            <div class="col-sm-8" style="padding:0;">
                                <div class="col-xs-12 ct-pn">
                                    <ct-gallery :list="goods_list" :pic="pic" />
                                </div>                   
                            </div>
                            <div class="col-sm-2 order-rt hidden-xs" style="padding-right:0;">
                                <list-orders :list="orders_list" :islogin="is_login" />
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-sm-10">
                                <div class="row">
                                    <search-show :list="sch_res" />
                                </div>
                                <div class="row">
                                    <pagi :total="total_pages" :target="target" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div></div>

                <div v-if="target == null" class="container" style="margin-top:15px;">
                    <div class="row"><div class="col-sm-10" style="word-wrap:break-word;">
                        <goods-show :list="goods_list" />
                    </div></div>
                </div>
            </div>
        </div>
        <div class="footer" style="width: 100%;height: 50px;background-color: red;"></div>
        <div>
            <script type="text/x-template" id="search-goods">
                <form action="./index.php" method="get" class="search-tips">
                    <input type="text" name="search" />
                    <input type="submit" />
                </form>
            </script>

            <script type="text/x-template" id="left-pane">
                <div class="left-pane">
                    <div>
                        <div class="row lt-tl">商品类目</div>
                        <a v-for="cl1 in goods">
                            <div class="row cl1" @mouseover="show(cl1)" @mouseout="hide">
                                <a :href="nav_head(cl1[0],false,1)"><img style="width:30px;height:30px;margin-right:2px;" :src="nav_head(cl1[0],true,1)" />{{cl1[0]}}</a>
                            </div>
                        </a>
                    </div>
                    <div :style="cat" @mouseover="show" @mouseout="hide">
                        <div class="row"><div class="col-xs-12">
                            <div v-for="cl2 in cl[1]" class="col-xs-4" style="min-height:85px;margin-bottom:5px;">
                                <div class="row" style="margin: 0 -8px 0 -8px;border-bottom: 1px solid #FD9860;line-height:25px;">
                                    <a :href="nav_head(cl2[0],false,2)"><img :src="nav_head(cl2[0],true,2)" style="height:25px;width:25px;margin-right:2px;">{{cl2[0]}}</a>
                                </div>
                                <div v-if="cl2[1] != null" class="row">
                                    <div v-for="cl3 in cl2[1]" class="col-xs-4" style="padding:0;text-align:center;font-size:12px;"><a :href="nav_head(cl3,false,3)">{{cl3}}</a></div>
                                </div>
                                <div v-else class="row"><div class="col-xs-12">
                                    <a :href="nav_head(cl2[0],false,2)"><img :src="nav_head(cl2[0],true,2,true)" class="hov" style="width:100%;height:80px;margin-top:5px;margin-bottom:5px;"/></a>
                                </div></div>
                            </div>
                        </div></div>
                    </div>
                </div>
            </script>

            <script type="text/x-template" id="gallery">
                    <div class="row"><div class="col-xs-12">
                        <div class="row"><div class="col-xs-12">
                            <div id="myCarousel" class="carousel slide" style="z-index:0;">
                                <!-- <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0"></li>
                                    <li v-for="i in pic.length-1" data-target="#myCarousel" :data-slide-to="i"></li>
                                </ol> -->
                                <div class="carousel-inner">
                                    <div class="item active" :style="bg(pic[0])"></div>
                                    <div v-for="url in pic.slice(1)" class="item" :style="bg(url)"></div>
                                </div>
                                <a class="carousel-control left" href="#myCarousel" 
                                data-slide="prev">&lsaquo;</a>
                                <a class="carousel-control right" href="#myCarousel" 
                                data-slide="next">&rsaquo;</a>
                            </div>
                        </div></div>
                        
                        <div class="row"><div class="col-xs-12"><div style="border-bottom:2px solid #FD9860;margin-top:10px;">
                            <span style="color:#FD9860;font-size:18px;">推荐商品</span>
                            <span style="color:#cccccc;font-size:12px;">畅销商品，天天上贝壳！</span>
                        </div></div></div>
                        <div class="row" style="margin-top:5px;">
                            <div v-for="go in list.slice(0,4)" class="col-xs-3">
                                <a :href="jump(go.goods_id)">
                                    <div style="width:100%;" class="ct-goods hov" :style="bg(go.goods_img)"></div>
                                </a>
                            </div>
                        </div>
                    </div></div>
            </script>

            <script type="text/x-template" id="list-orders">
                <div class="rt-float" data-spy="affix" data-offset-top="95" style="width:fit-content;">
                    <div class="row" style="border-bottom:2px solid #FD9860;margin-bottom:5px;">
                        <span style="font-size:18px;color:#FD9860;">我的购物车</span>
                    </div>
                    <div>
                        <div v-for="or in list" class="row order">
                            <div class="order-info" style="color:grey">
                                <div class="col-xs-5">ID:{{or.order_id}}</div>
                                <div class="col-xs-7">卖家：<a :href="jump(or.goods_owner,'user')">{{or.goods_owner}}</a></div>
                            </div>
                            <div>
                                <div style="float:left;"><div style="width:50px;height:50px;margin:6px;" :style="bg(or.goods_img)"></div></div>
                                <div style="float:left;margin:5px;height:50px;" class="or-con">
                                    <div style="height:30px;width:100%;font-size:12px;line-height:15px;overflow:hidden;"><a href="jump(or.goods_id,'goods')">{{or.goods_title}}</a></div>
                                    <div style="height:20px;width:100%;font-size:12px;color:#FD9860;text-align:right;">￥{{or.offer}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </script>

            <script type="text/x-template" id="goods-show">
                <div>
                    <div class="row"><div class="col-xs-12">
                            <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #FD9860;margin-bottom:10px;">
                                <li class="active"><a href="#new-goods" data-toggle="tab">新品抢先</a></li>
                                <!-- <li><a href="#hot-goods" data-toggle="tab">热评商品</a></li> -->
                            </ul>
                    </div></div>
                    <div class="row"><div class="col-xs-12"><div class="col-sm-3"><div class="preview" style="height:0;"></div></div></div></div>
                    <div class="row tab-content" style="overflow:hidden;">
                        <div id="new-goods" class="col-xs-12 tab-pane active">
                            <goods v-for="goods in list" :key="goods.goods_id" :go="goods" />
                        </div>
                        <!-- <div id="hot-goods" class="col-xs-12 tab-pane">{{list}}</div> -->
                    </div>
                </div>
            </script>

            <script type="text/x-template" id="search-show">
                <div>
                    <div class="col-xs-12"><div class="col-sm-3"><div class="preview" style="height:0;"></div></div></div>
                    <div class="col-xs-12">
                        <goods v-for="go in list" :key="go.goods_id" :go="go" />
                    </div>
                </div>
            </script>

            <script type="text/x-template" id="pagi">
                <div v-if="total > 0">
                    <div class="col-xs-12" style="text-align:center">
                        <ul v-if="total < 10" class="pagination pagination-sm">
                            <li v-if="(target.page!=1)"><a :href="jump(target.page != 1? target.page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li v-for="pg in total" :class="{active:(pg==target.page)}"><a :href="jump(pg)">{{pg}}</a></li>
                            <li v-if="(target.page!=total)"><a :href="jump(target.page != total? parseInt(target.page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else-if="total >= 10 && target.page < 5" class="pagination pagination-sm">
                            <li v-if="(target.page!=1)"><a :href="jump(target.page != 1? target.page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li v-for="pg in 5" :class="{active:(pg==target.page)}"><a :href="jump(pg)">{{pg}}</a></li>
                            <li class="disabled"><a>...</a></li>                            
                            <li><a :href="jump(total)">{{total}}</a></li>
                            <li v-if="(target.page!=5)"><a :href="jump(target.page != total? parseInt(target.page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else-if="total > 6 && target.page > total-5" class="pagination pagination-sm">
                            <li><a :href="jump(target.page != 1? target.page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li><a :href="jump(1)">1</a></li>
                            <li class="disabled"><a>...</a></li>
                            <li v-for="pg in 5" :class="{active:((pg+total-5)==target.page)}"><a :href="jump(pg+total-5)">{{pg+total-5}}</a></li>
                            <li v-if="(target.page!=total)"><a :href="jump(target.page != total? parseInt(target.page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                        <ul v-else class="pagination pagination-sm">
                            <li><a :href="jump(target.page != 1? target.page-1 : 1)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li><a :href="jump(1)">1</a></li>
                            <li class="disabled"><a>...</a></li>
                            <li v-for="pg in 5" :class="{active:((pg+parseInt(target.page)-3)==target.page)}"><a :href="jump(pg+parseInt(target.page)-3)">{{pg+parseInt(target.page)-3}}</a></li>
                            <li class="disabled"><a>...</a></li>                            
                            <li><a :href="jump(total)">{{total}}</a></li>
                            <li><a :href="jump(target.page != total? parseInt(target.page)+1 : total)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                    </div>
                </div>
            </script>
        </div>

        <script>
            $(document).ready(function(){
                console.log(target);
                var goods_cl = [
                    ['实体商品',[
                        ['开学季',['军训物资','二手教材书','学霸笔记','被子','电话卡','其他']],
                        ['电子产品',['手机配件','电脑配件','其他']],
                        ['吃喝',['零食','特产','饮品','其他']],
                        ['乐器',['吉他','小提琴','尤克里里','口琴','其他']],
                        ['生活用品',['床上用品','学习用品','洗漱用品','日常用品','其他']],
                        ['体育用品',['球类','竞技类','有氧类','健身类','其他']],
                        ['书类',['教材','课外书','杂志订阅','GRE','雅思托福','学霸笔记','复习材料','其他']],
                        ['服饰',['男装','女装','鞋','帽','围巾','手套','其他']],
                        ['服装定制',[]],
                    ]],
                    ['非实体商品',[
                        ['轰趴聚会'],
                        ['北京周边游'],
                        ['摄影'],
                        ['设计'],
                        ['视频'],
                        ['乐器培训'],
                        ['PPT'],
                    ]],
                ];

                var fetch_goods = function(){
                    $.getJSON('./core/api-main-goods.php',{
                        action:"show_goods_in_main",
                        rank:'new',
                        amount:12,
                    },function(data){
                        for (var i = 0; i < data.length; i++) {data[i] = JSON.parse(data[i]);}
                        main_page.goods_list = data;
                        console.log(main_page.goods_list);
                    });
                };

                var fetch_orders = function(){
                    $.getJSON("./core/api-v1.php",{action:"list_orders",page:"1",limit:"4"},function(data){
                        if(data.status == 'success'){
                            main_page.orders_list = data.orders;
                        }
					})
                };

                var search_goods = function(target){
                    if(target.type=="search"){
                        $.getJSON('./core/api-v1.php',{action:'search_goods_by_title',goods_title:target.search,page:target.page},function(data){
                            if(data.status == 'success'){
                                main_page.sch_res = data.goods;
                                main_page.total_pages = data.total;
                            }
                        });
                    }else if(target.type=="category"){
                        $.getJSON('./core/api-v1.php',{action:'search_goods_by_category',category:target.category,level:target.level,page:target.page},function(data){
                            if(data.status == 'success'){
                                main_page.sch_res = data.goods;
                                main_page.total_pages = data.total;
                            }
                        });
                    }
                };

                var Goods = {
                    props:['go'],
                    template:'<a :href="jump"><div class="col-sm-3" style="margin-bottom:10px;">\
                            <div class="goods">\
                                <div class="preview" ><div style="width:100%;border-radius:4px;" :style="bg"></div></div>\
                                <div style="padding:5px;">\
                                    <div class="row">\
                                        <div class="col-xs-12 goods-title" style="word-wrap:break-word;overflow:hidden;line-height:15px;">{{go.goods_title}}</div>\
                                    </div>\
                                    <div class="row">\
                                        <div class="col-sm-6" style="height:12px;line-height:12px;overflow:hidden;font-size:10px;">{{go.goods_owner}}</div>\
                                        <div class="col-sm-6 single-cost" style="height:12px;line-height:12px;overflow:hidden;color:#FD9860;text-align:right;font-size:15px;"><b>￥{{go.single_cost}}</b></div>\
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
                            return "./goods/show.php?goods_id="+this.go.goods_id;
                        },
                    },
                };

                var SearchShow = {
                    props:['list'],
                    template:'#search-show',
                    components:{
                        'goods':Goods,
                    },
                };

                var Pagi = {
                    props:['total','target'],
                    template:'#pagi',
                    methods:{
                        jump:function(page){
                            if (this.target.type=="search") {
                                return "./index.php?search="+this.target.search+"&page="+page;
                            }else{
                                return "./index.php?category="+this.target.category+"&level="+this.target.level+"&page="+page;
                            }
                        }
                    },
                };

                var LeftPane = {
                    props:['goods'],
                    template:'#left-pane',
                    methods:{
                        nav_head(name,isIcon,lv,isImg = false){
                            if (isIcon==true && isImg == false) return './pic/'+ name +'.png';
                                else if(isIcon==true && isImg == true) return './pic/image1/'+ name +'.png';
                                else return '?category='+ name + '&level=' + lv;
                        },
                        show(cl1){
                            if(cl1.length == 2){this.cl = cl1;}
                            this.cat.display = 'block';
                        },
                        hide(){
                            this.cat.display = 'none';
                        },
                    },
                    data(){
                        return{
                            cat:{
                                width:'410%',
                                minHeight:'310px',
                                backgroundColor:'white',
                                border:'3px solid #FD9860',
                                zIndex:'5',
                                position:'relative',
                                left:'107%',
                                top:'-171px',
                                display:'none',
                                borderRadius:'2px',
                                padding:'15px',
                            },
                            cl:[],
                        };
                    },
                };

                var Gallery = {
                    props:['list','pic'],
                    template:'#gallery',
                    methods:{
                        bg(url){
                            return bg_ch(url);
                        },
                        jump:function(id){
                            console.log("./goods/show.php?goods_id="+id);
                            return "./goods/show.php?goods_id="+id;
                        },
                    },
                };

                var SearchGoods = {
                    data:function(){return{
                        value:'',
                    }},
                    template:'#search-goods',
                    methods:{
                        search:function(){
                            // var val = this.value;
                            // $.get("./main/api-search.php",{val:val},function(data){
                            //     console.log(data);
                            //     data = data.split("+");
                            //     data.splice(0,1);
                            //     availableTags = data;
                            //     $( ".search" ).autocomplete({
                            //         source: availableTags
                            //     });
                            // });
                        },
                    }
                };

                var ListOrders = {
                    props:['list','islogin'],
                    template:'#list-orders',
                    methods:{
                        bg:function(url){
                            return bg_ch(url);
                        },
                        jump:function(id,type){
                            var url = '';
                            switch (type) {
                                case 'goods':
                                    url = './goods/show.php?goods_id='+id;
                                    break;
                                case 'user':
                                    url = './users/users.php?user_id='+id;
                                    break;
                                default:
                                    break;
                            }
                            return url;
                        }
                    }
                };

                var GoodsShow = {
                    props:['list'],
                    template:'#goods-show',
                    components:{
                        'goods':Goods,
                    }
                };

                var main_page = new Vue({
                    el:'#main_page',
                    data:{
                        target:target,
                        ct_img:[],
                        goods_cl:goods_cl,
                        goods_list:[],
                        orders_list:[],
                        pic:[
                            './pic/image1/ustb.png',
                            './pic/image1/北京周边游.png',
                            './pic/image1/摄影.png',
                        ],
                        sch_res:null,
                        total_pages:0,
                        is_login:is_login,
                    },
                    components:{
                        'search-goods':SearchGoods,
                        'left-pane':LeftPane,
                        'ct-gallery':Gallery,
                        'list-orders':ListOrders,
                        'goods-show':GoodsShow,
                        'search-show':SearchShow,
                        'pagi':Pagi,
                    },
                    created:function(){
                        if (target!=null) {
                            search_goods(target);
                        }else{
                            fetch_goods();
                            fetch_orders();
                        }
                    },
                });
            });
        </script>
    </body>
</html>