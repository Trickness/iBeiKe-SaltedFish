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
  					<div id="tabs1-show"></div>
  				</div>
  				<div id="tabs-2" style="height: 500px;padding: 0;">
					最热
  				</div>

				<script>
					$(document).ready(function(){
						var goodsTpl = '<a href="../goods/show.php?goods_id={goods_id}"><div class="goods">\
										<img src="./goods.jpg">\
										<h2><span style="font-size:15px;">￥</span>{single_cost}</h2>\
										<p style="font-size:15px;"><b>{goods_title}</b></p>\
										{search_summary}\
										<p style="color:gray">{goods_owner}</p>\
									</div></a>';
						var goodsList = "";
						$.getJSON("../core/api-main-goods.php",{
							action:"show_goods_in_main",
							rank:"new",
							amount:12
						},function(data){
							for (var i = 0; i < data.length; i++) {
								data[i] = JSON.parse(data[i]);
								data[i].search_summary = (data[i].search_summary.split(";"))[0].substring(0,30);
								goodsList += goodsTpl.format(data[i]);
							}
							console.log(data);
							$("#tabs1-show").html(goodsList);
						})
					});
				</script>

			</div>
		</div>
	</div>
