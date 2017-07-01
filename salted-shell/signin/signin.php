<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>注册</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#bt1").click(function(){
                $("#switch1").css("display","none");
                 $("#switch2").fadeIn("slow");
            });
            $("#bt2").click(function(){
                $("#switch2").css("display","none");
                 $("#switch1").fadeIn("slow");
            });
            $("#male1").click(function()
            {
                $("#male1").css("color","red");
                $("#male1").css("font-size","38px");
                $("#fmale1").css("color","#FFFFFF");
                $("#fmale1").css("font-size","36px");
            });
            $("#fmale1").click(function()
            {
                $("#male1").css("font-size","36px");
                $("#fmale1").css("font-size","38px");
                $("#male1").css("color","#FFFFFF");
                $("#fmale1").css("color","red");
            });
        });
        
    </script>
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
            height: 115px;
            background: #FFFFFF;
            border-bottom-style: solid;
            border-bottom-color:#95989A;
            border-bottom-width: 1px;
        }
        .logo
        {
            position: absolute;
            width: 74px;
            height: 90px;
            top: 11px;
            left: 31px;
        }
        .shangcheng
        {
            position: absolute;
            width: 144px;
            height: 48px;
            top: 30px;
            left: 124px;
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
        .signbbox
        {
            position: absolute;
            left: -moz-calc(50% - 692px/2);
            left: -webkit-calc(50% - 692px/2);
            left: calc(50% - 692px/2);
            top: 253px;
            width: 692px;
            height: 680px;
            border-radius: 5px;
        }
        .textbox
        {
            width:543px;
            height:50px;
            background-color:#FFFFFF;
            font-family: Helvetica Neue;
            font-size: 20px;
            padding-left: 25px;
            color: #95989A;
            border-radius: 3px;
        }
        .Submit
        {
            position: absolute;
            width: 568px;
            height: 69px;
            border-width: 1px;
            border-color: coral;
            border-radius: 5px;
            background: #FF621C;
            font-family: Helvetica Neue;
            font-size: 30px;
            text-align: center;
            color: #FFFFFF;
            transition-duration: 0.4s;
            margin-top: 109px;
        }
        .Submit:hover
        {
            background-color: white;
            color: #FF621C;
        }
        .sign-1
        {
            
        }
        .sign-2
        {
            display: none;
        }
        .switch
        {
            margin-left: 229px;
            margin-top: 50px;
            width: 100px;
            height: 100px;
            border-radius: 100px;
            background-color: #FFFFFF;
            font-size: 40px;
            font-family: Helvetica Neue;
            transition-duration: 0.4s;
            color:  #FF621C;
        }
        .switch:hover
        {
            background-color:#FF621C;
            color: #FFFFFF;
        }
        .sexs
        {
            font-size: 36px;
            display: inline-block;
            color: #FFFFFF;
            line-height: 40px;
        }
        .sexs:hover
        {
            color: red;
            font-size: 38px;
        }
        .sex
        {
            margin-top: 27px;
            margin-left: 100px;
        }
	</style>
</head>
<body>
    <div class= "header">
        <img src="../pic/beikelogo.png" class="logo">
        <img src="../pic/beikeshop.png" class = "shangcheng">
        <div style="float:right;
                    margin-top:30px;
                    margin-right:113px;
                    font-family: Helvetica Neue;
                    font-size: 36px;">
            <a class="a" herf="#">注册</a>
            <a class="a" herf="#" style="margin-left:51px;">登陆</a>
        </div>
    </div>
    <div class = "signbbox" style="background: #FF4E00;
                                    opacity:0.5; "></div>
    <div class = "signbbox">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="position: absolute;
                                                                                left: 62px;
                                                                                width:568px;
                                                                               height:inherit;">
            <div class="sign-1" id="switch1">
                <p style="
                    margin-top:60px;
                    margin-left:217px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">贝壳商城</p>
                <p style="
                    margin-left:122px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">让你的宝贝动起来！</p>
                <input type="text" name="username" placeholder="请输入您的学号" class = "textbox"/>
                <input type="password" name="password" placeholder="请输入您的密码" class = "textbox" style="margin-top:40px;"/>
                <input type="password" name="password" placeholder="请再次输入您的密码" class = "textbox" style="margin-top:40px;"/>
                <button class="switch" id="bt1" type="button">下</button>
            </div>
            <div class="sign-2" id="switch2">
                <button class="switch" id="bt2" type="button">上</button>
                <div class="sex">
                    <input type="radio" name="gender" value="男" id="male" style="display:none">
                        <label for="male" class="sexs" id="male1">♂我是汉子</label>
                    <input type="radio" name="gender" value="女" id="fmale" style="display:none">
                        <label for="fmale" class="sexs" id="fmale1">♀我是妹子</label>
                </div>
                 <input type="text" name="major" placeholder="请输入您所在的专业" class = "textbox"style="margin-top:27px;"/>
                <input type="text" name="identifyingcode" placeholder="请输入您的验证码" class = "textbox"style="margin-top:27px;"/>
                <input type="submit" name="submit" class="Submit" value="注册">
            </div>
        </form>
    </div>
</body>
</html>