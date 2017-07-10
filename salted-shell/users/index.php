<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>个人主页</title>
    <?php
    session_start();
    ?>
    <style>
        body {
            margin : 0;
            min-width: 1500px;
            height: 100%;
        }
        div.head_wrapper{
            height: 155px;
            width: 100%;
            background-color: #ffcf79;
            color: white;
            font-size: 22px;
        }
        div.head_left_nav{
            height: 100%;
            width: 500px;
            float: left;
        }
        div.head_right_nav{
            height: 100%;
            width: 500px;
            float: right;
        }
        div.right_nav_content{
            float: right;
            margin-right: 100px;
            margin-top: 52px;
        }
        div.head_img{
            width: 125px;
            height: 125px;
            border-radius: 125px;
            background-color: white;
            margin-left: 75px;
            margin-top: 15px;
            float: left;
        }
        div.id_container{
            margin-top: 45px;;
            margin-left: 38px;
            max-width: 260px;
            float: left;
        }
        div.left_nav{
            width: 330px;
            height: 100%;
            background-color: #eeeeee;
            min-height: 700px;
            padding-top: 18px;
            float: left;
            /*calc(%100)*/
        }
        div.left_nav_item{
            width: 210px;
            height: 60px;
            background-color: #f8bb37; 
            margin-top: 27px;
            margin-left: 75px;
            float: left;
        }
        div.center_content_wrapper{
            width: 1080px;
            float: left;
        }
        div.swiper-container{
            padding-top: 60px;
            margin-right: 60px;
            margin-left: 60px;
            height: 360px;
            width: 900px;
        }
        div.swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            background-color: yellow;
        }
        div.right_nav_wrapper{
            width: 350px;
            background-color: #d1dcf5;
            float: right;
            padding-left: 50px;
            padding-right: 50px;
            margin-top: 35px;
            padding-top: 24px;
            margin-right: 21px;
            padding-bottom: 24px;
        }
        img.right_nav_recommendation_item_img{
            width:250px;
            height:180px;
            margin-bottom: 15px;
            background-color: #eeeeee;
        }
        div.recent_wrapper{
            margin-top: 38px;
            margin-left: 20px;
            min-width: 1080px;
            margin-top: 50px;
            font-size: 24px;
            float: left;
        }
        div.recent_item{
            width: 280px;
            height: 280px;
            float: left;
            margin-left: 25px;
            margin-right: 25px;
            margin-top: 25px;
            background-color: #d2d2d2;
        }
    </style>

    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>
    <script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <?php 
        require_once "../core/users.php";
        require_once "../core/utils.php";
        require_once "../core/authorization.php";
        require_once "../config.php";
        
        $session = session_id();
        $student_id = get_student_id_from_session_key($session);
        // $student_id = $_GET['id'];

    ?>
</head>
<body>
    <div class="head_wrapper">
        <div class="head_left_nav">
            <div class="head_img"></div>
            <div class="id_container">
                <?php
                    echo "<p>ID: ".$student_id."</p>";
                    $name = json_decode(fetch_user_info_from_id($student_id),true)["name"]["value"];
                    echo "<p>".$name."</p>";
                ?>
            </div>
        </div>
        <div class="head_right_nav">
            <div class="right_nav_content">
                购物车 | 收藏夹 | 网站导航
            </div>
        </div>
    </div>
    <div id="content_wrapper">
        <div class="left_nav">
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
            <div class="left_nav_item"></div>
        </div>
        <div class="center_content_wrapper">
            <div class="swiper-container swiper-container-horizontal swiper-wp8-horizontal">
                <div class="swiper-wrapper" style="transform: translate3d(-3270px, 0px, 0px); transition-duration: 0ms;">
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 1</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 2</div>
                    <div class="swiper-slide swiper-slide-prev" style="width: 1060px; margin-right: 30px;">Slide 3</div>
                    <div class="swiper-slide swiper-slide-active" style="width: 1060px; margin-right: 30px;">Slide 4</div>
                    <div class="swiper-slide swiper-slide-next" style="width: 1060px; margin-right: 30px;">Slide 5</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 6</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 7</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 8</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 9</div>
                    <div class="swiper-slide" style="width: 1060px; margin-right: 30px;">Slide 10</div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="recent_wrapper">
                <p style="width:120px;float:left;">最近逛逛</p>
                <img src="../pic/split.png" alt="" style="width:800px;height:2px;float:left;margin-top:18px;">
                <div style="width:100%;height:50px;"></div>
               <div class="recent_item"></div> 
               <div class="recent_item"></div> 
               <div class="recent_item"></div> 
               <div class="recent_item"></div> 
               <div class="recent_item"></div> 
               <div class="recent_item"></div> 
            </div>
        </div>
        <div class="right_nav_wrapper">
            <div class="right_nav_recommendation_item">
                <p style="text-align:center;font-size:24px;font-weight:bold;margin-bottom:15px;">最新上线</p>
                <div>
                    <p style="font-size:21px">XXXXXXX</p>
                    <img class="right_nav_recommendation_item_img" src="" alt="">
                </div>
                <div>
                    <p style="font-size:21px">XXXXXXX</p>
                    <img class="right_nav_recommendation_item_img" src="" alt="">
                </div>
                <div>
                    <p style="font-size:21px">XXXXXXX</p>
                    <img class="right_nav_recommendation_item_img" src="" alt="">
                </div>
                <div>
                    <p style="font-size:21px">XXXXXXX</p>
                    <img class="right_nav_recommendation_item_img" src="" alt="">
                </div>
                <div>
                    <p style="font-size:21px">XXXXXXX</p>
                    <img class="right_nav_recommendation_item_img" src="" alt="">
                </div>
            </div>
        </div>
    </div>
    <script>
            var swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                paginationClickable: '.swiper-pagination',
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 30
            });
        </script>
</body>
</html>