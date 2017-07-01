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
                {$.get("../core/api-v1.php",{action: "check", id:nm ,psw:ps},function(result){
                    var data = JSON.parse(result);
                    if (data==false)
                        alert("请输入正确的学号和密码！");
                    else{
                        $("#name").val(data["name"]["value"]);
                        $("#class_no").val(data["class_info"]["class_no"]["value"]);
                        $("#enroolment").val(data["class_info"]["enrollment"]["value"]);
                        $("#type").val(data["type"]["value"]);
                        $("#switch0").css("display","none");
                        $("#switch1").fadeIn();
                        $.get("../core/api-v1.php",{action: "signin", id:nm ,psw:ps},function(result){session_key=result;});
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
            bottom:  71px;
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
            margin-left: 229px;
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
            font-size: 20px;
            color: #FFFFFF;
            margin-left: 25px;
            height: 40px;
            line-height: 40px;
            margin-top: 0px;
            margin-bottom: 0px;
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
        <div style="position: absolute;left: 62px; width:568px;height:inherit;">
            <div class="sign-0" id="switch0">
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
                <input type="text"placeholder="请输入您的学号"class="textbox" id="scnmbox"/>
                <p class="check" id="scnmck"></p>
                <input type="password"placeholder="请输入您的本科教学网密码" class="textbox" id="scpsbox"/>
                <p class="check" id="scpsck"></p>
                <button class="Submit"id="checkid">验证您身份</button>
            </div>
            
            <div class="sign-1" id="switch1">
                <p style="
                    margin-top:60px;
                    margin-left:210px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">验证成功!</p>
                <p style="
                    margin-left:60px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">您可以修改您的非基本信息</p>
                <input type="text" class = "textbox" disabled="true" id="name"/>
                <input type="text" class = "textbox" disabled="true" id="class_no" style="margin-top:27px;"/>
                <input type="text" class = "textbox" disabled="true" id="enroolment" style="margin-top:27px;" />
                
                <button class="switch" id="bt1" style="margin-top:40px">下</button>
            </div>
            
            <div class="sign-2" id="switch2">
                <button class="switch" id="bt2" type="button" style="margin-top:60px">上</button>
                <input type="text" class = "textbox" disabled="true" id="type" style="margin-top:27px;" />
                <input type="text" placeholder="请输入您的宿舍楼号" class = "textbox" style="margin-top:27px;" id="dormitory_id"/>
                <input type="text" placeholder="请输入您的宿舍编号" class = "textbox" style="margin-top:27px;" id="room_no"/>
                <input type="text" placeholder="请输入您的手机号码" class = "textbox" style="margin-top:27px;" id="phone_number"/>
                <p class="check" id="phmb"></p>
                <button class="switch" id="bt3" style="margin-top:0px;">下</button>
            </div>
            
            <div class="sign-3" id="switch3">
                <button class="switch" id="bt4" style="margin-top:50px;">上</button>
                <input type="text" placeholder="请输入您的昵称" class = "textbox" style="margin-top:27px;" id="nickname"/>
                <input type="password" placeholder="请输入您的新密码" class = "textbox" style="margin-top:27px;" id="password"/>
                <p class="check" id="pswd"></p>
                <input type="password" placeholder="请再输入一遍您的新密码" class = "textbox"id="rpassword"/>
                <p class="check" id="rpswd"></p>
                <input type="text" placeholder="请输入图片中的验证码" class = "textbox" id="identifycode"/>
                <button class="Submit" id="signinbutton">注册</button>
            </div>
            <div class="sign-4" id="switch4">
                <p style="
                    margin-top:200px;
                    margin-left:197px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">注册成功！</p>
                <p style="
                    margin-left:167px;
                  font-size:36px;
                  font-familt:Helvetica Neue;
                  color:#FFFFFF;">即将自动登陆...</p>
            </div>
        </div>
    </div>
</body>
</html>