<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>登陆</title>
</head>
<body>
    <?php include "../frame/head_user.php"; ?>

    <style>
        html,
        body {
        margin: 0;
        padding: 0;
        }

        .background {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        z-index: -1;
        }
        @media(min-width:768px){
            .login{background-color:white;opacity:0.8;padding:20px 20px 40px 20px;position:absolute;left:1000px;top:200px;width:350px;border:1px solid #cccccc;border-radius:5px;}
        }
    </style>
    <div class="container" style="margin-top:180px;">
        <div id="login" class="col-sm-4 col-sm-offset-4" style="background-color:white;opacity:0.9;border-radius:5px;border:1px solid #cccccc;padding:20px 40px 40px 40px;">
            <div style="text-align:center;color:#fd9860;">
                <h2>贝壳商城</h2>
            </div>
            <div>
                <div style="margin-top:20px;"><input type="text" class="form-control input-lg" placeholder="请输入您的用户名" v-model="username" /></div>
                <div style="margin-top:30px;"><input type="password" class="form-control input-lg" placeholder="请输入您的密码" v-model="password" /></div>
                <div style="margin-top:30px;"><button class="btn btn-lg btn-warning" style="width:100%;" @click="login">登陆</button></div>
            </div>
        </div>
    </div>
    <canvas class="background">
    </canvas>
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
        $(document).ready(function() {
            var login = new Vue({
                el:'#login',
                data:{
                    username:'',
                    password:'',
                },
                methods:{
                    login:function(){
                        var t = this;
                        $.getJSON('../core/api-v1.php?action=login',{username:t.username,password:t.password},function(data){
                            var status = data.status;
                            switch(status){
                                case "success":
                                    localStorage.session = document.cookie;
                                    window.location="../users/index.php";
                                    break;
                                case "failed":
                                    console.log(status);
                                    console.log(data.error);
                                    $("#status").css("display","block");
                                    break;
                                default:
                                    console.log(status);
                                    $("#status").css("display","block");
                                    break;
                            }
                        });
                    },
                },
            });
        })
    </script>
</body>
</html>