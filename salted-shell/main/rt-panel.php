
				<div id="cen-show" style="width: 745px;float: left;">

					<style>
						#adv-con img{height: 130px;width: 177px;margin-right: 6px;float: left;transition-duration: 0.4s;}
						#adv-con img:hover{opacity: 0.5;}

						.cart{height: 65px;width: inherit;background-color: white;border-top: 1px solid #CCCCCC;border-radius:10px;}
						.cart:hover{color: #FD9850;text-decoration: underline;}
						.cart img{width: 55px;height: 50px;float: left;margin: 8px;margin-left: 5px;}
						.cart b{width: 30px; float: left;}

						.store img{float: left;border-radius: 10px;width: 55px;height: 50px;float: left;margin: 8px;margin-left: 5px;}
						.store th{font-size: 10px;}
						/*.cart input[type='checkbox']{float: left;margin-top: 30px;margin-left: 10px;}
						.cart input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 20px;width: 20px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.cart input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -3px -1px;}*/

						.store{margin-bottom:8px;border: 1px solid #CCCCCC;border-radius:10px;transition:0.4s;}
						.store:hover{box-shadow: 5px 5px 5px #CCCCCC;}
						.store input[type='checkbox']{float: left;margin-left: 10px;}
						.store input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 18px;width: 18px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.store input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -4px -3px;}

						.store .st-name{margin:0;float: left;margin-left:10px;font-size: 14px;margin-top: 3px;}
						.store .name{width: 120px;float: left;margin: 0;margin-top: 10px;font-size: 12px;text-align: left;}
						.store .price{width: 130px;color: #FD9850;font-size: 12px;float: left;margin:0;text-align: left;}
						.store .des{color: #CCCCCC;font-size: 10px;float: left;margin:0;width: 130px;text-align: left;}
						.store .amount{color: #CCCCCC;font-size: 10px;float: left;margin:0;margin-top: 2px;text-align: right;}
						.store .edit{float:right;font-size: 13px;color: gray;margin-top: 3px;margin-right:10px;}
						.store .edit a{font-size: 12px;}

						.swiper-container img{border-radius:10px;}
					</style>
					<div class="swiper-container" style="height: 330px;margin-left: 10px;float: left;width: inherit;">
	    				<div class="swiper-wrapper">
	    	   				<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="0.5s"
	    	   					swiper-animate-delay="0.3s" src="./slider1.jpg" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInUp" swiper-animate-duration="0.5s"
	    	   					swiper-animate-delay="0.3s" src="./slider2.jpg" style="height: 300px;width: 740px;"></div>
	    	    			<div class="swiper-slide"><img class="ani" swiper-animate-effect="bounceInLeft" swiper-animate-duration="0.5s"
	    	   					swiper-animate-delay="0.3s" src="./slider3.jpg" style="height: 300px;width: 740px;"></div>
	    				</div>
	    				<!-- 如果需要分页器 -->
	    				<div class="swiper-pagination"></div>

	    				<!-- 如果需要导航按钮 -->
	    				<div class="swiper-button-prev swiper-button-white" style="top:43%"></div>
	    				<div class="swiper-button-next swiper-button-white" style="top:43%"></div>

	    				<!-- 如果需要滚动条 -->
	    				<div class="swiper-scrollbar"></div>
					</div>

					<div id="bot-adv" style="height: 180px;margin-left: 10px;margin-top: 10px;float: left;">
						<div id="adv-tl" style="width: inherit;height: 40px;border-bottom:2px solid #FD9850;">
							<p style="font-size: 20px;color: #FD9850;float: left;margin: 0;margin-top: 10px;">热门店铺</p>
							<p style="font-size: 14px;color: #666666;float: left;margin: 0;margin-top: 15px;margin-left: 10px;">
								畅销商品，天天上贝壳！</p>
						</div>
						<div id="adv-con" style="width: inherit;height: 130px;margin-top: 8px;">
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
							<a href="#"><img src="./adv.png"></a>
						</div>
					</div>
				</div>

				<div id="shop-cart" style="float: right;width: 250px;height: 450px;position: relative;top:-16px;">
					<div id="cart-hd" style="width: inherit;;height: 40px;border-bottom:2px solid #FD9850;color: #FD9850;">
						<h3 style="float:left;margin-bottom:10px;margin-top: 10px;">我的购物车</h3>
					</div>
					<div id="cart" style="width: inherit;height: 400px;margin-top: 8px;">
						<!-- <div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;">
								<p class="st-name">商店1</p>
							</div>
							<a href="#"><div class="cart">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
						</div> -->
						<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;border-bottom:1px solid #CCCCCC;border-radius:10px;">
								<p class="st-name">商店1</p>
							</div>
							<table>
								<tr>
									<td>
										<img src="./cover.png">
										<span style="float: left;font-size: 13px;margin-top: 25px;">正版魔法指南</span>
									</td>
									<td style="color:#FD9860;">
										<span style="font-size:12px;margin-left:10px;">￥</span>45
									</td>
								</tr>
							</table>
						</div>




					</div>
				</div>

				<script>
				$(document).ready(function(){
					var ordersTpl = '<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">\
						<div style="width: inherit;height: 27px;border-bottom:1px solid #CCCCCC;border-radius:10px;">\
							<p class="st-name"><a href="../users/others.php?user_id={goods_owner}">{goods_owner}</a></p>\
						</div>\
						<table>\
							<tr>\
								<td>\
									<a href="../goods/show.php?goods_id={goods_id}">\
										<img src="./goods.jpg">\
										<span style="float: left;font-size: 13px;margin-top: 25px;">{goods_title}</span>\
									</a>\
								</td>\
								<td style="color:#FD9860;">\
									<span style="font-size:12px;margin-left:35px;">￥</span>{offer}\
								</td>\
							</tr>\
						</table>\
					</div>';
					var ordersList = "";
					$.getJSON("../core/api-v1.php",{action:"list_orders",page:"1",limit:"4"},function(data){
						console.log(data);
						for (var i = 0; i < data.orders.length; i++) {
							ordersList += ordersTpl.format(data.orders[i]);
						}
						$("#cart").html(ordersList);
					})
				});
				</script>

				<div id="rep-rank" style="float: right;width: 250px;height: 50px;margin-top:20px;color: #FD9850;border-bottom: 2px solid #FD9850;">
					<h3 style="float: left;">信誉排行</h3>
				</div>
