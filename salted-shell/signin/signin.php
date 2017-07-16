<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>注册</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        var session_key=0;
        $(document).ready(function()
            {
            $("#bt1").click(function(){
                $("#switch1").css("display","none");
                 $("#switch2").fadeIn("slow");
            });
            $("#bt2").click(function()
            {
                $("#switch2").css("display","none");
                 $("#switch1").fadeIn("slow");
            });
            $("#bt3").click(function()
            {
                var phone = $("#phone_number").val();
                var reg = /^1[3|4|5|7|8][0-9]{9}$/; //验证规则
                var flag = reg.test(phone);
                if (phone=="")
                    {
                        $("#phmb").css("color","red");
                        $("#phmb").html("*手机号码不能为空！");
                    }
                else if(!flag)
                    {
                        $("#phmb").css("color","red");
                        $("#phmb").html("*手机号码格式不正确！");
                    }
                else{
                        $("#switch2").css("display","none");
                        $("#switch3").fadeIn("slow");
                        $("#phmd").html("");
                    }
               
            });
             $("#bt4").click(function()
            {
                $("#switch3").css("display","none");
                 $("#switch2").fadeIn("slow");
            });
            $("#rpassword").bind('input propertychange',function() //判断新密码是否一致
            {
                var ps= $("#password").val();
                var rps= $("#rpassword").val();
                if (rps!=ps)
                    {
                    $("#rpswd").css("color","red");
                    $("#rpswd").html("*请检查您的密码！");
                    }
                else if(rps==ps&&ps!="")
                    {
                    $("#rpswd").css("color","green");
                    $("#rpswd").html("密码一致");
                    }
            });
            $("#password").bind('input propertychange',function()  //密码强度
            {
                var psw = $("#password").val();
                var psstrenth = 0;
                if(psw.length<6)
                    {   
                        $("#pswd").css("color","red");
                        $("#pswd").html("*密码长度不可小于6位！");
                        return;
                    }
                else if(psw.length>=6)
                   {
                       for (var i=0;i<psw.length;i++)
                        {
                         if(psw.search(/[a-zA-Z]/)!=-1)
                            psstrenth++;
                         else if(psw.search(/[-]/)!=-1)
                            psstrenth++;
                         else if(psw.search(/[\~\`\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]|{\}\;\'\:\"\,\.\/\<\>\?]/)!=-1)
                            psstrenth+=2;
                        }
                   }
                
               if (psstrenth<8)
                    {
                        $("#pswd").css("color","red");
                        $("#pswd").html("*密码强度：弱");
                    }
                else if(psstrenth<12&&psstrenth>8)
                    {
                        $("#pswd").css("color","yellow");
                        $("#pswd").html("*密码强度：中");
                    }
                else if(psstrenth>=12)
                    {
                        $("#pswd").css("color","green");
                        $("#pswd").html("*密码强度：高");
                    }
            });
            $("#scnmbox").bind('input propertychange',function() //判断本科教学网内学号是否为空
            {
                var nm= $("#scnmbox").val();
                if (nm=="")
                    {
                    $("#scnmck").css("color","red");
                    $("#scnmck").html("*请输入您的学号！");
                    }
                else
                    {
                    $("#scnmck").html("");
                    }
            });
            $("#scpsbox").bind('input propertychange',function() //判断本科教学网内密码是否为空
            {
                var ps= $("#scpsbox").val();
                if (ps=="")
                    {
                    $("#scpsck").css("color","red");
                    $("#scpsck").html("*请输入您的密码！");
                    }
                else
                    {
                    $("#scpsck").html("");
                    }
            });
            $("#checkid").click(function()
            {
                var nm= $("#scnmbox").val();
                var ps= $("#scpsbox").val();
                if (nm==""||ps=="")
                        alert("请输入正确的学号和密码！");
                else
                {$.getJSON("../core/api-v1.php",{action: "check", id:nm ,psw:ps},function(data){
                    if (data==false)
                        alert("请输入正确的学号和密码！");
                    else{
                        $("#name").val(data["name"]["value"]);
                        $("#class_no").val(data["class_info"]["class_no"]["value"]);
                        $("#enroolment").val(data["class_info"]["enrollment"]["value"]);
                        $("#type").val(data["type"]["value"]);
                        $("#switch0").css("display","none");
                        $("#switch1").fadeIn();
                        //$.get("../core/api-v1.php",{action: "signin", id:nm ,psw:ps},function(result){session_key=result;});
                        };
                        }
                    )};
            });
           $("#signinbutton").click(function()
            {
                //if ($("#phmd").val()==""&&$("#pswd").val()!="*密码长度不可小于6位！"&&$("#pswd").val!="*密码强度：弱"&&$("#rpswd").val=="密码一致")
                  //  {
                        var student_id = $("#scnmbox").val();
                        var name = $("#name").val();
                        var nickname = $("#nickname").val();
                        var header = "URl"; //这是啥
                        var department = "CT"; //这是啥
                        var enroolment = $("#enroolment").val();
                        var class_no = $("#class_no").val();
                        var dormitory_id = $("#dormitory_id").val();
                        var room_no = $("#room_no").val();
                        var phone_number = $("#phone_number").val();
                        $.get("../core/api-v1.php",{action:"change",student_id:student_id,name:name,nickname:nickname,header:header,department:department,enroolment:enroolment,class_no:class_no,dormitory_id:dormitory_id,room_no:room_no,phone_number:phone_number,session_key:session_key},function(result){
                        if (result=="1")
                            {
                                 $("#switch3").css("display","none");
                                $("#switch4").fadeIn("slow");
                            }
                        else if(result!="1")
                            {
                                alert("注册失败！");
                            }});
                        
                    //}
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
            height: 600px;
        }
        .header
        {
            width: 100%;    /**/
            height: 70px;
            background: #FFFFFF;
            border-bottom-style: solid;
            border-bottom-color: #95989A;
            border-bottom-width: 1px;
        }
        .logo
        {
            /*position: absolute;
            width: 74px;
            height: 90px;
            top: 11px;
            left: 31px;*/

            position: absolute;     /**/
            width: 50px;
            height: 50px;
            top: 11px;
            left: 31px;
        }
        .shangcheng
        {
            /*position: absolute;
            width: 144px;
            height: 48px;
            top: 30px;
            left: 124px;*/

            position: absolute;     /**/
            width: 144px;
            height: 48px;
            top: 10px;
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
        .signbbox
        {
            /*position: absolute;
            left: -moz-calc(50% - 692px/2);
            left: -webkit-calc(50% - 692px/2);
            left: calc(50% - 692px/2);
            top: 253px;
            width: 692px;
            height: 680px;
            border-radius: 5px;*/

            position: relative;     /**/
            left: -moz-calc(50% - 692px/2);
            left: -webkit-calc(50% - 692px/2);
            left: calc(50% - 500px/2);
            top: 75px;
            width: 500px;
            height: 515px;
            border-radius: 5px;
        }
        .textbox
        {
            /*width:543px;
            height:50px;
            background-color:#FFFFFF;
            font-family: Helvetica Neue;
            font-size: 20px;
            padding-left: 25px;
            color: #95989A;
            border-radius: 3px;*/

            width: 335px;   /**/
            height: 40px;
            background-color: #FFFFFF;
            font-family: Helvetica Neue;
            font-size: 20px;
            padding-left: 25px;
            color: #95989A;
            border-radius: 3px;
        }
        .Submit
        {
            /*width: 550px;
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
            bottom:  71px;*/

            width: 445px;   /**/
            height: 50px;
            border-width: 1px;
            border-color: coral;
            border-radius: 5px;
            background: #FF621C;
            font-family: Helvetica Neue;
            font-size: 28px;
            text-align: center;
            color: #FFFFFF;
            transition-duration: 0.4s;
            bottom: 71px;
        }
        .Submit:hover
        {
            background-color: white;
            color: #FF621C;
        }
        .sign-0
        {
          
        }
        .sign-1
        {
             display: none; 
        }
        .sign-2
        {
            display: none; 
        }
        .sign-3
        {
            display: none; 
        }
        .sign-4
        {
            display: none; 
        }
        .switch
        {
            margin-top: 27px;
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

        .check
        {
            /*font-size: 20px;
            color: #FFFFFF;
            margin-left: 25px;
            height: 40px;
            line-height: 40px;
            margin-top: 0px;
            margin-bottom: 0px;*/

            font-size: 165%;    /**/
            color: #FFFFFF;
            margin-left: 25px;
            height: 30px;
            line-height: 40px;
            margin-top: 0px;
            margin-bottom: 0px;
        }
        input{
            border:0px;
        }
        p{
            color:white;
            font-size:165%;
        }
        p.input_hint{
            /*float:left;
            line-height:0px;
            text-align:right;
            width:110px;*/
            
            font-size: 20px;
            float: left;    /**/
            line-height: 0px;
            text-align: right;
            margin-left: 35px;
        }
	</style>
</head>
<body>
    <div class= "header">
        <img src="../pic/beikelogo.png" class="logo">
        <img src="../pic/beikeshop.png" class = "shangcheng">
        <div style="float: right;margin-top: 13px;margin-right: 38px;font-family: Helvetica Neue;font-size: 20px;">
            <a class="a" href="../signin/signin.php">注册</a>
            <a class="a" href="../login/login.php">登陆</a>
        </div>
    </div>
    <div class = "signbbox" style="background: #FF4E00;
                                    opacity:0.5; "></div>
    <div class = "signbbox" style="text-align:center;top: -445px;">
        <div style="position: absolute;width: 500px;height: inherit;">
            <div class="sign-0" id="switch0">
                <p style="margin-top: 60px;font-size: 2em;font-family: Helvetica Neue;color: #FFFFFF;">贝壳商城</p>
                <p style="font-size: 28px;font-family: Helvetica Neue;color: #FFFFFF;">让你的宝贝动起来！</p>
                <div style="overflow: hidden;margin-top: 25px;">
                    <p class="input_hint">学号：</p>
                    <input type="text" placeholder="请输入您的学号" class="textbox" id="scnmbox" style="float:left;"/>
                </div>
                <p class="check" id="scnmck"></p>
                <div style="overflow:hidden">
                    <p class="input_hint">密码：</p>
                    <input type="password"placeholder="请输入您的本科教学网密码" class="textbox" id="scpsbox" style="float:left;"/>
                </div>
                <p class="check" id="scpsck"></p>
                <button class="Submit" id="checkid" style="margin-top:10px;">验证您身份</button>
            </div>
            
            <div class="sign-1" id="switch1">
                <p style="margin-top: 40px;font-size: 165%;font-family: Helvetica Neue;color: #FFFFFF;">验证成功</p>
                <p style="font-size: 20px;font-family: Helvetica Neue;color: #FFFFFF;">请确认你的基本信息</p>
                <div style="overflow:hidden;">
                    <p class="input_hint">姓名：</p>
                    <input type="text" class = "textbox" disabled="true" id="name" style="float:left;"/>
                </div>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">班级：</p>
                    <input type="text" class = "textbox" disabled="true" id="class_no" style="float:left;"/>
                </div>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">学年：</p>
                    <input type="text" class = "textbox" disabled="true" id="enroolment" style="float:left;" />
                </div>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">类别：</p>
                    <input type="text" class = "textbox" disabled="true" id="type" style="float:left;" />
                </div>
                
                <button class="switch" id="bt1">下</button>
            </div>
            
            <div class="sign-2" id="switch2">
                <button class="switch" id="bt2" type="button" style="margin-top:60px">上</button>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">斋号：</p>
                    <input type="text" placeholder="请输入您的宿舍楼号" class = "textbox" style="float:left;margin-left:20px;" id="dormitory_id"/>
                </div>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">房号：</p>
                    <input type="text" placeholder="请输入您的宿舍编号" class = "textbox" style="float:left;margin-left:20px;" id="room_no"/>                    
                </div> 
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">手机号：</p>
                    <input type="text" placeholder="请输入您的手机号码" class = "textbox" style="float:left;" id="phone_number"/>
                </div>
                <p class="check" id="phmb"></p>
                <button class="switch" id="bt3" style="margin-top:0px;">下</button>
            </div>
            
            <div class="sign-3" id="switch3">
                <button class="switch" id="bt4">上</button>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">昵称：</p>
                    <input type="text" placeholder="请输入您的昵称" class = "textbox" style="float:left;margin-left: 20px;" id="nickname"/>
                </div>
                <div style="overflow:hidden;margin-top:20px;">
                    <p class="input_hint">新密码：</p>
                    <div style="float:left;">
                        <input type="password" placeholder="请输入您的新密码" class = "textbox" style="width:100%;" id="password"/>
                        <p class="check" id="pswd"></p>
                        <input type="password" placeholder="请再输入一遍您的新密码" class = "textbox" id="rpassword" style="width:100%;"/>
                        <p class="check" id="rpswd"></p>
                    </div>
                </div>
                
                <script>
                    $(document).ready(function(){
                        $.get("./captcha/sample/make.php",{action:"getcap"},function(data){
                            $("#captcha").attr("src",data);
                        });
                        $("#captcha").click(function(data){
                            $.get("./captcha/sample/make.php",{action:"getcap"},function(data){
                                $("#captcha").attr("src",data);
                            });
                        });
                        $("#pha").change(function(){
                            $.get("./captcha/sample/make.php",{
                                action:"check",
                                phr:$("#pha").val()
                            },function(data){
                                if (data==true) {
                                    $("#check-result").text("验证码正确");
                                }else{
                                    $("#check-result").text("验证码错误");
                                }
                            })
                        });
                    });
                </script>

                <img id="captcha" src="#" alt="验证码图片" style="float: left;width: 136px;height: 40px;margin-left: 30px;" />
                <input type="text" id="pha" placeholder="请输入图片中的验证码" style="width:255px;" class = "textbox" id="identifycode"/>
                <div style="float: left;margin-left: 30px;margin-top: 15px;color: white;font-size: 14px;">
                    <div id="captcha-tips" style="float: left;">点击图片，可更换验证码</div>
                    <div id="check-result" style="float: left;margin-left: 30px;color: yellow;"></div>
                </div>
                <button class="Submit" id="signinbutton" style="margin-top:20px;">注册</button>
            </div>
            <div class="sign-4" id="switch4">
                <p style="
                    margin-top:200px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">注册成功！</p>
                <p style="
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">即将自动登陆...</p>
            </div>
        </div>
    </div>
</body>
</html>