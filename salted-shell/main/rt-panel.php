
				<div id="cen-show" style="width: 745px;float: left;">

					<style>
						#adv-con img{height: 130px;width: 177px;margin-right: 6px;float: left;transition-duration: 0.4s;}
						#adv-con img:hover{opacity: 0.5;}
	
						.cart{height: 65px;width: inherit;background-color: white;border-top: 1px solid #CCCCCC;border-bottom: 1px solid #CCCCCC;}
						.cart:hover{color: #FD9850;text-decoration: underline;}
						.cart img{width: 55px;height: 50px;float: left;margin: 8px;margin-left: 5px;}
						.cart b{width: 30px; float: left;}
						/*.cart input[type='checkbox']{float: left;margin-top: 30px;margin-left: 10px;}
						.cart input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 20px;width: 20px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.cart input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -3px -1px;}*/
						.store{margin-bottom:8px;border: 1px solid #e8e8e8;}
						.store:hover{box-shadow: 2px 2px 2px #e8e8e8;}
						.store input[type='checkbox']{float: left;margin-left: 10px;}
						.store input[type='checkbox']:before{content: '';position: relative;top:-5px;left: -5px;right: 0;bottom: 0;border-radius: 10px;height: 18px;width: 18px;background-color:white;float: left;z-index: 1;border:1px solid #cccccc;}
						.store input[type='checkbox']:checked:before{background-image: url("../pic/hook.png");background-size: 25px 25px;background-position: -4px -3px;}

						.store .st-name{margin:0;float: left;margin-left:5px;font-size: 14px;margin-top: 3px;}
						.store .name{width: 120px;float: left;margin: 0;margin-top: 10px;font-size: 12px;text-align: left;}
						.store .price{width: 130px;color: #FD9850;font-size: 12px;float: left;margin:0;text-align: left;}
						.store .des{color: #CCCCCC;font-size: 10px;float: left;margin:0;width: 130px;text-align: left;}
						.store .amount{color: #CCCCCC;font-size: 10px;float: left;margin:0;margin-top: 2px;text-align: right;}
						.store .edit{float:right;font-size: 13px;color: gray;margin-top: 3px;}
						.store .edit a{font-size: 12px;}
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
	    				<div class="swiper-button-prev swiper-button-white"></div>
	    				<div class="swiper-button-next swiper-button-white"></div>
	    	
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

				<div id="shop-cart" style="float: right;width: 250px;height: 450px;">
					<div id="cart-hd" style="width: inherit;;height: 40px;border-bottom:2px solid #FD9850;color: #FD9850;">
						<h3 style="float:left;margin-bottom:10px;margin-top: 10px;">我的购物车</h3>
					</div>
					<div id="cart" style="width: inherit;height: 400px;margin-top: 8px;">
						
						<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;">
								<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
								<p class="st-name">商店1</p>
								<div class="edit"><a href="#">编辑</a>|<a href="#">删除</a></div>
							</div>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
						</div>
						
						
						<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
							<div style="width: inherit;height: 27px;">
								<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
								<p class="st-name">商店1</p>
							</div>
							<a href="#"><div class="cart">
								<input type="checkbox" id="abcd" style="margin-top:30px;" name="choose">
								<img src="./cover.png">
								<p class="name">爆款</p>
								<p class="des">这是描述</p>
								<p class="price">￥21</p>
							</div></a>
						</div>


						<?php
						// $storeTpl = '<div class="store" style="width: inherit;border-top:1px solid #CCCCCC;">
						// 				<div style="width: inherit;height: 27px;">
						// 					<input type="checkbox" id="abcd" style="margin-top: 8px;" name="choose">
						// 					<p class="st-name">%s</p>
						// 					<div class="edit"><a href="%s">编辑</a>|<a href="%s">删除</a></div>
						// 				</div>
						// 				%s
						// 			</div>
						// 			 ';
						// $cartTpl = '<a href="%s"><div class="cart">
						// 				<input type="checkbox" style="margin-top:30px;" name="choose">
						// 				<img src="%s">
						// 				<p class="name">%s</p>
						// 				<p class="des">%s</p>
						// 				<p class="price">￥%s</p>
						// 				<p class="amount">X%s</p>
						// 			</div></a>';
						// $cart = sprintf($cartTpl,"#","./adv.png","2016期末试题","描述示范","11","2");
						// $store = sprintf($storeTpl,"商店示范","#","#",$cart);
						// echo $store;
						?>
					</div>
				</div>

				<script>
				$(document).ready(function(){
						$.get("../core/api-main-goods.php",{orders:"cart"},function(data){
							$("#cart").html(data);
						})
					});
				</script>

				<div id="rep-rank" style="float: right;width: 250px;height: 50px;margin-top:20px;color: #FD9850;border-bottom: 2px solid #FD9850;">
					<h3 style="float: left;">信誉排行</h3>
				</div>