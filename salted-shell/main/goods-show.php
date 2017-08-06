<div id="goods-show" style="z-index: 1;top:740px;">
		<script>
		function jud(){
			if ($("#tabs-1").css("display")=="block") {
    			$("#tabs1").css("background-color","#FD9850");
    			$("#tabs2").css("background-color","white");
    		}else{
    			$("#tabs2").css("background-color","#FD9850");
    			$("#tabs1").css("background-color","white");
    		}
		}
  		$(document).ready(function() {
  			jud();
    		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" ).click(function(){
    			jud();
    		});

    		var mySwiper = new Swiper ('.swiper-container', {
    			onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
    				swiperAnimateCache(swiper); //隐藏动画元素 
    				swiperAnimate(swiper); //初始化完成开始动画
  				}, 
  				onSlideChangeEnd: function(swiper){ 
    				swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
  				},
    			loop: true,
    
    			// 如果需要分页器
    			pagination: '.swiper-pagination',
    
    			// 如果需要前进后退按钮
    			nextButton: '.swiper-button-next',
    			prevButton: '.swiper-button-prev',
    
    			// 如果需要滚动条
    			scrollbar: '.swiper-scrollbar', 
    			autoplay: 3000,
  			});     
		});
  		</script>
  		<style>
		
		
		#goods-selector{width: inherit;height: 50px;margin-top: 10px;border-bottom: 2px solid #FD9850;padding-left: 10px;}
		#goods-selector .panel{width: inherit;height:40px;border-bottom: 1px solid #CCCCCC;padding-left: 40px;}
		#goods-selector .panel a{margin-right:50px;}
		#goods-selector .panel div{float: left;width: 100px;margin-top: 9px;}    #goods-selector .panel div:hover{color:#FD9850;}
		#goods-selector .panel img{width: 32px;height: 32px;margin-right:5px;float: left;}
		#goods-selector select{height: 35px;width: 130px;border-radius: 5px;font-size: 15px;margin-right: 5px;padding-left: 10px;}
  		</style>
  		<div style="width: 1228px;">
			<div id="tabs" style="width:960px;border:none;float: left;">
  				<ul>
    				<li id="tabs1"><a href="#tabs-1" >最新</a></li>
    				<li id="tabs2"><a href="#tabs-2">最热</a></li>
  				</ul>
  				<div id="tabs-1" style="height: 1200px;padding: 0;">
  					<!-- <div id="goods-selector"> -->
						<!-- <div class="panel">
							<a href="#"><img src="../pic/bag.png"></img><div>实体商品</div></a>
							<a href="#"><img src="../pic/cyber.png"></img><div>非实体商品</div></a>
							<a href="#"><img src="../pic/wave.png"></img><div>贝壳信息</div></a>
						</div>
						<div class="panel">
							<div class="pl-tab" name="rea">
								<a href="#"><div>开学季</div></a>
								<a href="#"><div>吃喝</div></a>
								<a href="#"><div>电子产品</div></a>
								<a href="#"><div>体育用品</div></a>
								<a href="#"><div>生活用品</div></a>
							</div>
						</div>
						<div class="panel">
							
						</div> -->
							<!-- <select name="fir-cat" id="fir-cat">
      							<option selected="selected" value="reality">实体商品</option>
      							<option value="virtual">非实体商品</option>
    						</select>
    						<select name="sec-cat" id="sec-cat">
      							<option selected="selected" value="start">开学季</option>
      							<option value="electronic">电子产品</option>
      							<option value="sports">体育用品</option>
      							<option value="daily">日常用品</option>
      							<option value="food">吃喝</option>
      							<option value="book">书类</option>
      							<option value="cloths">服饰</option>
      							<option value="dress">服装定制</option>
      							<option value="instrument">乐器</option>
      							<option value="others">其他</option>
      						</select>
      							<option selected="selected" value="party">轰趴聚会</option><option value="travel">北京周边游</option><option value="photographer">摄影</option><option value="design">设计</option><option value="video">视频</option><option value="ppt">PPT</option><option value="instrument">乐器培训</option>
    						</select> -->
    						<!-- <input type="submit" name="search-catagory" class="button button-glow button-highlight button-small" value="搜索"> -->
  					<!-- </div> -->
					
					<script>
					$(document).ready(function(){
						$("#fir-cat").change(function(){
							var value = $(this).val();
							switch (value){
								case "reality":
									$("#sec-cat").html('<option selected="selected" value="start">开学季</option><option value="electronic">电子产品</option><option value="sports">体育用品</option><option value="daily">日常用品</option><option value="food">吃喝</option><option value="book">书类</option><option value="cloths">服饰</option><option value="dress">服装定制</option><option value="instrument">乐器</option><option value="others">其他</option>');
									break;
								case "virtual":
									$("#sec-cat").html('<option selected="selected" value="party">轰趴聚会</option><option value="travel">北京周边游</option><option value="photographer">摄影</option><option value="design">设计</option><option value="video">视频</option><option value="ppt">PPT</option><option value="mus-edu">乐器培训</option><option value="others">其他</option>');
									break;
								default:
									break;
							}
						});
					});
					</script>

  					<div id="tabs1-show">
						<a href="#"><div class="goods">
							<img src="./goods.jpg">
							<h2><span style="font-size:15px;">￥</span>%s</h2>
							<p style="font-size:14px;">%s</p>
							<p>%s</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./goods.jpg">
							<h2>￥%s</h2>
							<p style="font-size:14px;">%s</p>
							<p>%s</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./goods.jpg">
							<h2>￥%s</h2>
							<p style="font-size:14px;">%s</p>
							<p>%s</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./goods.jpg">
							<h2>￥%s</h2>
							<p style="font-size:14px;">%s</p>
							<p>%s</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./goods.jpg">
							<h2>￥%s</h2>
							<p style="font-size:14px;">%s</p>
							<p>%s</p>
						</div></a>
						<!-- <a href="#"><div class="goods">
							<img src="./cover.png">
							<h2>￥21</h2>
							<p>商品名称12345687897894613fsdfweaf</p>
							<p>卖家名称</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./cover.png">
							<h2>￥21</h2>
							<p>商品名称</p>
							<p>卖家名称</p>
						</div></a>
						<a href="#"><div class="goods">
							<img src="./cover.png">
							<h2>￥21</h2>
							<p>商品名称</p>
							<p>卖家名称</p>
						</div></a> -->
						<?php
							// $goodsTpl = '<a href=" %s "><div class="goods">
							// 				<img src=" %s ">
							// 				<h3>%s</h3>
							// 				<p id="des">%s</p>
							// 			</div></a>';
							// $goods = sprintf($goodsTpl,"#","./adv.png","abc","这是一段文字");
							// for ($i=0; $i < 6; $i++) { 
							// 	echo $goods;
							// }
						?>
					</div>
  				</div>
  				<div id="tabs-2" style="height: 500px;padding: 0;">
					最热
  				</div>

				<script>
					$(document).ready(function(){
						$.get("../core/api-main-goods.php",{
							rank:"new",
							amount:12
						},function(data){
							$("#tabs1-show").html(data);
						})
					});					
				</script>

			</div>
		</div>
	</div>