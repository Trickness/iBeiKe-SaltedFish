<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<title>个人中心</title>
</head>
<body>
	<?php 
		include '../frame/head_user.php';
		if(isset($_GET['page'])) echo "<script>var now_page=".$_GET['page'].";</script>";
			else echo "<script>var now_page=1;</script>";
	?>
	<style>
		a{color:black;text-decoration:none;}    a:hover{text-decoration:none;color:#FD9860;}
		.header{width:120px;height:120px;border-radius:60px;}
		.ul-wd{width:fit-content;}
		.carousel{height:310px;background-color:#f3f3f3;border-radius:2px;}    .carousel .item{height:310px;line-height:310px;text-align:center;}   .carousel-control.right,.carousel-control.left{top:130px;}
		.goods{transition-duration:0.3s;}       .goods:hover{background-color:#F3F3F3;box-shadow:0 0 4px #cccccc;}      .goods-title{margin-top:5px;height:30px;}   .single-cost{font-size:12px;}
		@media(max-width:768px){
			.header{width:120px;height:120px;border-radius:60px;}
			.ul-wd{width:100%;}
			.carousel{height:200px;background-color:#f3f3f3;border-radius:2px;}    .carousel .item{height:200px;line-height:200px;text-align:center;}   .carousel-control.right,.carousel-control.left{top:90px;}
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

	<div id="show_info" style="padding-bottom:50px;">
		<div class="container" style="margin-top:80px;width:1170px;">
			<div class="col-xs-9">
				<div class="row">
					<div class="col-xs-3">
						<name-tag :info="self_info" />
					</div>
					<div class="col-xs-9">
						<ct-gallery :pic="pic" />
					</div>
				</div>
				<div class="row" style="margin-top:20px;">
					<div class="col-xs-12" style="padding-left:55px;"><div style="font-size:20px;color:#FD9860;padding-bottom:5px;border-bottom:2px solid #FD9860;">我的商品</div></div>
					<div class="col-xs-12" style="padding-left:55px;padding-top:10px;">
						<my-goods v-for="go in self_goods" :key="go.goods_id" :goods="go"  />
					</div>
					<div class="col-xs-12" style="padding-left:55px;padding-top:10px;">
						<pagi :total="total_pages" />
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="col-xs-12"><div style="width:100%;border-bottom:2px solid #FD9860;color:#FD9860;font-size:20px;padding-bottom:2px;margin-bottom:10px;" class="preview">
					新品推荐
				</div></div>
				<goods v-for="go in new_goods" :key="go.goods_id" :go="go" />
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document" style="margin-top:150px;">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">信息确认</h4>
					</div>
					<div class="modal-body">
						是否确定要撤回商品？（ID：{{revoke.id}}）
					</div>
					<div v-if="revoke.status == false" class="modal-footer">
						<button type="button" class="btn btn-success" @click="revoke_goods">确定撤回</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
					<div v-if="revoke.status == true" class="modal-footer" style="text-align:center;">
						<h3>成功撤回该商品，3秒后刷新</h3>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div>
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
			</div></div>
		</script>

		<script type="text/x-template" id="name-tag">
			<div>
				<div>
					<ul style="list-style-type:none;line-height:25px;" class="ul-wd">
						<li style="text-align:center;height:120px;">
							<div class="header" :style="bg(info.header)"></div>
						</li>
						<li style="text-align:center;font-size:20px;">{{info.nickname}}</li>
						<li>学号：{{info.student_id.value}}</li>
						<li>姓名：{{info.name.value}}</li>
						<li>生日：{{info.birthday.value}}</li>
						<li>宿舍：{{dorm}}</li>
						<li>身份：{{info.type.value}}</li>
						<li>性别：{{info.gender.value}}</li>
					</ul>
				</div>
				<div style="text-align:center;">
					<div class="dropdown">
						<button class="btn btn-success" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							骚操作<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dLabel">
							<li><a href="./edit-profile.php">编辑名片</a></li>
							<li><a href="../goods/upload.php">上传商品</a></li>
							<li><a href="./orders.php">我的订单</a></li>
						</ul>
					</div>
				</div>
			</div>
		</script>

		<script type="text/x-template" id="my-goods">
			<div class="col-xs-12" style="margin-bottom:15px;"><div class="row">
				<div style="border:1px solid #cccccc;overflow:hidden;">
					<div class="col-xs-12" style="padding:0;line-height:30px;background-color:#f3f3f3;color:grey;">
						<div class="col-xs-3">商品ID：{{goods.goods_id}}</div>
						<div class="col-xs-3">交易方式：{{convert_info.goods_type}}</div>
						<div class="col-xs-3">商品状态：<span style="color:#FD9860;">{{convert_info.goods_status}}</span></div>
					</div>
					<div class="col-xs-12" style="padding:0;">
						<div class="col-xs-5" style="padding:10px;border-right:1px solid #cccccc;height:90px;">
							<div style="margin-right:5px;height:70px;width:70px;float:left;" :style="bg(goods.goods_img)"></div>
							<div style="margin-right:5px;float:left;width:170px;word-wrap:break-word;"><a :href="jump(goods.goods_id)">{{goods.goods_title}}</a></div>
							<div style="float:left;">x{{goods.remain}}</div>
						</div>
						<div class="col-xs-2" style="padding:0;border-right:1px solid #cccccc;">
							<div style="line-height:45px;text-align:center;border-bottom:1px solid #cccccc;">单价<span style="color:#FD9860;">￥{{goods.single_cost}}</span></div>
							<div style="line-height:45px;text-align:center;">运费<span style="color:#FD9860;">￥{{goods.delivery_fee}}</span></div>
						</div>
						<div class="col-xs-3" style="padding:10px;border-right:1px solid #cccccc;height:90px;word-wrap:break-word;">
							标签：{{convert_info.tags}}
						</div>
						<div class="col-xs-2">
							<div class="col-xs-12" style="line-height:45px;"><a :href="edit" role="button" class="btn btn-primary">编辑商品</a></div>
							<div class="col-xs-12" style="line-height:45px;"><button class="btn btn-default" data-toggle="modal" data-target="#myModal" @click="pre_revoke">撤回商品</button></div>
						</div>
					</div>
				</div>
			</div></div>
		</script>

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
			var Goods = {
				props:['go'],
				template:'<a :href="jump"><div class="col-xs-12" style="margin-bottom:10px;">\
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
						// console.log(this.go);
						var st = bg_ch(this.go.goods_img);
						st.height = $(".preview").css("width");
						return st;
					},
					jump:function(){
						return "../goods/show.php?goods_id="+this.go.goods_id;
					},
				},
			};

			var MyGoods = {
				props:['goods'],
				template:'#my-goods',
				computed:{
					convert_info:function(){
						var info = {
							tags:'',
							goods_status:'',
							goods_type:'',
						};
						if (this.goods.goods_status == "available") info.goods_status = '在售';
							else info.goods_status = '下架';
						if (this.goods.goods_type == "sale") info.goods_type = '出售';
							else info.goods_type = '租赁';
						// info.tags = JSON.parse(this.goods.tags[0]).join(' ');
						info.tags = this.goods.tags.join(' ');
						return info;
					},
					edit:function(){
						return '../goods/edit-goods.php?goods_id='+this.goods.goods_id;
					},
				},
				methods:{
					bg:function(url){
						return bg_ch(url);
					},
					jump:function(goods_id){
						return "../goods/show.php?goods_id="+goods_id;
					},
					pre_revoke:function(){
						show_info.revoke.id = this.goods.goods_id;
					}
				},
			}

			var NameTag = {
				props:['info'],
				template:'#name-tag',
				methods:{
					bg:function(url){
						var bg_style = bg_ch(url);
						return bg_style;
					},
				},
				computed:{
					dorm:function(){
						return this.info.dormitory.dormitory_id.value + "斋" + this.info.dormitory.room_no.value;
					},
				},
			}
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

			var Pagi = {
				props:['total'],
				template:'#pagi',
				methods:{
					jump:function(page){
						return "./index.php?page="+page;
					}
				},
				computed:{
					now_page:function(){return now_page;}
				},
			};

			var show_info = new Vue({
				el:'#show_info',
				data:{
					pic:[
						'../pic/image1/ustb.png',
						'../pic/image1/北京周边游.png',
						'../pic/image1/摄影.png',
					],
					self_goods:[],
					new_goods:[],
					total_pages:0,
					revoke:{
						id:'',
						status:false,
					},
				},
				computed:{
					self_info:function(){
						return self_info.info;
					},
				},
				methods:{
					revoke_goods:function(id){
						// this.revoke_goods = id;
						console.log(this.revoke);
						var revoke_id = this.revoke.id;
						$.getJSON('../core/api-v1.php?action=revoke_goods',{goods_id:revoke_id},function(data){
							console.log(data);
							if(data.status == 'success'){
								console.log(data.status);
								show_info.revoke.status = true;
								setTimeout(function() {
									window.location = './index.php?page='+now_page;
								}, 3000);
							}
						});
					},
				},
				created:function(){
					$.getJSON('../core/api-users-info.php?action=new',function(data){
						if (data.status=="success") {
							show_info.new_goods = data.goods;
						}
						// console.log(show_info.new_goods);
					});
					$.getJSON('../core/api-v1.php?action=fetch_user_goods',{page:now_page},function(data){
						if (data.status=="success") {
							show_info.self_goods = data.goods;
							show_info.total_pages = data.total;
						}
						console.log(data);
					});
				},
				components:{
					'name-tag':NameTag,
					'ct-gallery':Gallery,
					'goods':Goods,
					'my-goods':MyGoods,
					'pagi':Pagi,
				},
			});
		});
	</script>
</body>
</html>
