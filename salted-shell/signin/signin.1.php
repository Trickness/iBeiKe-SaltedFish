<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>注册</title>
</head>
<body style="background-color:#f0f0f0;">
    <?php include "../frame/head_user.php";?>
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <style>
        html,body{
            margin: 0;
            padding: 0;
        }
        a{color:#fd9860;}   a:hover{color:red;}
        .background {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .login{height:580px;}
        @media(max-width:768px){
            .win{margin-top:80px;}
            .login{text-align:center;transition-duration:0.4s;background-color:white;opacity:0.8;border-radius:2px;border-top:2px solid #fd9860;padding:20px 40px 40px 40px;box-shadow:0 1px 3px rgba(0,0,0,.1);}
        }
        @media(min-width:768px){
            .win{margin-top:100px;}
            /* .login{background-color:white;opacity:0.8;padding:20px 20px 40px 20px;position:absolute;left:1000px;top:200px;width:350px;border:1px solid #cccccc;border-radius:5px;} */
            .login{text-align:center;transition-duration:0.4s;background-color:white;opacity:0.8;border-radius:2px;border-top:2px solid #fd9860;padding:20px 40px 40px 40px;box-shadow:0 1px 3px rgba(0,0,0,.1);}
        }
        .login:hover{opacity:1;}
    </style>
    <div id="signin" class="container win">
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_0" class="col-sm-4 col-sm-offset-4 login">
                    <div style="color:#fd9860;"><h2>免费注册贝壳商城</h2></div>
                    <div style="margin-top:30px;"><input type="text" class="form-control input-lg" placeholder="请输入您的学号" /></div>
                    <div style="margin-top:20px;"><input type="text" class="form-control input-lg" placeholder="请输入您的密码" /></div>
                    <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(0)">验证你的信息</button></div>
                </div>                    
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_1" class="col-sm-4 col-sm-offset-4 login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><label>姓名</label><input type="text" class="form-control" /></div>
                        <div style="margin-top:20px;"><label>年级</label><input type="text" class="form-control" /></div>
                        <div style="margin-top:20px;"><label>学年</label><input type="text" class="form-control" /></div>
                        <div style="margin-top:20px;"><label>性别</label><input type="text" class="form-control" /></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(0)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(1)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_2" class="col-sm-4 col-sm-offset-4 login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入斋号" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入房号" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入手机号" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="短信验证码" /></div>
                        <div style="margin-top:20px;overflow:hidden;">
                            <div class="col-xs-8" style="padding-left:0;"><input type="text" class="form-control" placeholder="短信验证码" /></div>
                            <div class="col-xs-4" style="padding-right:0;"><button style="width:100%;" class="btn btn-warning">获取</button></div>
                        </div>

                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(1)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(2)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_3" class="col-sm-4 col-sm-offset-4 login">
                    <div style="color:#fd9860;"><h2>修改你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入昵称" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入你的新密码" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="再次输入你的新密码" /></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(2)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-danger btn-lg" style="width:100%;">注册</button></div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
    <canvas class="background"></canvas>
    <script src="../js/pt/dist/particles.min.js"></script>
    <script>
        window.onload = function() {
            var num = 0;
            if (window.innerWidth > 768) {
                num = 250;
            }else{
                num = 80;
            }
            Particles.init({
                selector: '.background',
                maxParticles:num,
                connectParticles:true,
                color:'#fd9860',
            });
        };
        $(document).ready(function(){
            var signin =new Vue({
                el:'#signin',
                data:{
                    // show:[true,false,false,false,false],
                    // show:true,
                    sign_0:true,
                    sign_1:false,
                    sign_2:false,
                    sign_3:false,
                    sign_4:false,
                },
                methods:{
                    pagi:function(page){
                        switch (page) {
                            case 0:
                                this.sign_0 = !this.sign_0;
                                this.sign_1 = !this.sign_1;
                                break;
                            case 1:
                                this.sign_1 = !this.sign_1;
                                this.sign_2 = !this.sign_2;
                                break;
                            case 2:
                                this.sign_2 = !this.sign_2;
                                this.sign_3 = !this.sign_3;
                                break;
                        
                            default:
                                break;
                        }
                    },
                },
            });
        });
    </script>
</body>
</html>