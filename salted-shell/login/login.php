<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>注册</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <style>
        body
        {
            margin: 0;
            background-image: url(../pic/backgroundimg.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }
        .header
        {
            width: 100%;
            height: 70px;
            background: #FFFFFF;
            border-bottom-style: solid;
            border-bottom-color:#95989A;
            border-bottom-width: 1px;
        }
        .logo
        {
            position: absolute;
            width: 50px;
            height: 50px;
            top: 11px;
            left: 31px;
        }
        .shangcheng
        {
            position: absolute;
            width: 144px;
            height: 48px;
            top: 12px;
            left: 82px;
        }
        .a
        {
            color: #FF621C;
            line-height: 48px;
            padding-bottom: 8px;
            transition-duration: 0.4s;
        }
        .a:hover
        {   
            font-size: 38px;
            color: #ff0066;
            border-bottom-color: #ff0066;
            border-bottom-width: 3px;
            border-bottom-style: solid;
        }
        input{
            border:0px;
        }
        p{
            color:white;
            font-size:165%;
        }
        p.input_hint{
            float:left;
            line-height:0px;
            text-align:right;
            width:110px;
        }

        .lgn-box{
            width: 500px;height: 550px;position: relative;top: -445px;
        }
        .lgn-box-below{
            width: 500px;height: 550px;position: relative;top: 75px;
            background-color: #FF4E00;
            opacity: 0.5;
            border-radius: 5px;
        }
        .input{
            width: 360px;
            height: 40px;
            border-radius: 5px;
            font-size: 20px;
            margin-bottom: 35px;
            padding-left: 15px;
        }
        #lgn label{
            font-size: 20px;
            color: white;
        }
        .Submit
        {
            width: 445px;
            height: 50px;
            border-width: 1px;
            border-color: coral;
            border-radius: 5px;
            background: #FF621C;
            font-family: Helvetica Neue;
            font-size: 30px;
            text-align: center;
            color: #FFFFFF;
            transition-duration: 0.4s;
            bottom:  71px;
        }
        .Submit:hover
        {
            background-color: white;
            color: #FF621C;
        }
        #motto{
            color: white;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <?php
        // require_once "../config.php";
        // require_once "utils.php";
        // require_once "users.php";
        // require_once "authorization.php";
        session_start();
    ?>
    <div class= "header">
        <img src="../pic/beikelogo.png" class="logo">
        <img src="../pic/beikeshop.png" class = "shangcheng">
        <div style="float: right;margin-top: 13px;margin-right: 38px;font-family: Helvetica Neue;font-size: 20px;">
            <a class="a" herf="#">注册</a>
            <a class="a" herf="#">登陆</a>
        </div> 
    </div>
    <center>
            <div class="lgn-box-below"></div>
            <div class="lgn-box">
                <div id="motto">
                    <h1>贝壳商城</h1>
                    <p>
                        让你的宝贝动起来
                    </p>
                </div>
                <div id="status" style="display: none;color: yellow;">登陆失败！</div>
                <div id="lgn" style="margin-top: 35px;">
                    <label>学号：</label><input class="input" type="text" id="username" placeholder="  请输入你的学号" /><br>
                    <label>密码：</label><input class="input" type="password" id="password" placeholder="  请输入你的密码" /><br>
                    <input id="login" type="submit" name="sub" value="登陆" class="Submit" />
                </div>
            </div>
    </center>
    <script>
    $("#login").click(function(){
        $.post("../core/api-v1.php?action=login",{
            username:$("#username").val(),
            password:$("#password").val()
        },function(data){
            if (!data) {
                // console.log("failed");
                $("#status").css("display","block");
            }else{
                // console.log(data);
                window.location="../users/index.php?id="+data;
            }
        });
    });
    </script>
</body>
</html>