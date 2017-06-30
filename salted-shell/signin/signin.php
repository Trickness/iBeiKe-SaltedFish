<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>注册</title>
	<style>
		body
        {
            margin: 0;
            background-image: url(../pic/%E8%83%8C%E6%99%AF.png);
            background-repeat: no-repeat;
            background-size: 1915px 1080px;
        }
        .header
        {
            width: 1915px;
            height: 115px;
            background:#FFFFFF;
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
        }
        .a:hover
        {
			text-decoration: underline;
			color: #FF9933;
		}
        .signbbox
        {
            position: absolute;
            left: 614px;
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
        .submit
        {
            position: absolute;
            left: 62px;
            top: 580px;
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
        }
        .submit:hover
        {
            background-color: white;
            color: #FF621C;
        }
	</style>
</head>
<body>
    <div class= "header">
        <img src="../pic/%E8%B4%9D%E5%A3%B3%E5%95%86%E5%9F%8Elogo2.0.png" class="logo">
        <img src="../pic/%E8%B4%9D%E5%A3%B3%E5%95%86%E5%9F%8E.png" class = "shangcheng">
        <div style="position:absolute;
                    top:30px;
                    left:1613px;
                    font-family: Helvetica Neue;
                    font-size: 36px;">
            <a class="a" herf="#"><span>注册</span></a>
            <a class="a" herf="#" style="margin-left:51px;">登陆</a>
        </div>
    </div>
    <div class = "signbbox" style="background: #FF4E00;
                                    opacity:0.5; "></div>
    <div class = "signbbox">
        <p style="position: absolute;
                  left: 274px;
                  top: 43px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">贝壳商城</p>
        <p style="position: absolute;
                  left: 184px;
                  top: 111px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">让你的宝贝动起来！</p>
        <form action="" method="post" style="position: absolute;
                                            left: 62px;
                                            top: 240px;
                                            width:568px;
                                            height:222px;">
            <input type="text" name="username" value="请输入您的学号" class = "textbox"/>
            <input type="text" name="password" value="请输入您的密码" class = "textbox" style="
                                                                                            margin-top:27px;"/>
            <input type="text" name="identifyingcode" value="请输入您的验证码" class = "textbox"style="
                                                                                            margin-top:27px;"/>
        </form>
        <div style="position: absolute;
                    left: 62px;
                    top: 480px;
                    width:138px;
                    height:60px;
                    background:#FFFFFF;">
        </div>
        <button type="submit" class="submit">注册</button>
    </div>
</body>
</html>