<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>登陆</title>
</head>
<body style="background-color:#f0f0f0;">
    <?php include "../frame/head_user.php"; ?>
    <link rel="stylesheet" href="../css/swal.min.css">
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
        @media(max-width:768px){
            .win{margin-top:130px;}
            .login{transition-duration:0.4s;background-color:white;opacity:0.8;border-radius:2px;border-top:2px solid #fd9860;padding:20px 40px 40px 40px;box-shadow:0 1px 3px rgba(0,0,0,.1);}
        }
        @media(min-width:768px){
            .win{margin-top:100px;}
            .login{height:580px;background-color:white;opacity:0.8;border-radius:2px;border-top:2px solid #fd9860;padding:20px 40px 40px 40px;box-shadow:0 1px 3px rgba(0,0,0,.1);}
        }
    </style>
    <div class="container win">
        <!-- <div class="col-sm-8 hidden-xs" style="height:580px;">
        </div> -->
        <div id="login" class="col-sm-offset-4 col-sm-4 login">
            <div style="text-align:center;color:#fd9860;">
                <h2>贝壳商城</h2>
            </div>
            <div style="border-bottom:1px solid #cccccc;padding-bottom:10px;">
                <div style="margin-top:30px;"><input type="text" class="form-control input-lg" placeholder="请输入您的用户名" v-model="username" /></div>
                <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="请输入您的密码" v-model="password" /></div>
                <div style="margin-top:20px;"><button class="btn btn-lg btn-warning" style="width:100%;" @click="login">登陆</button></div>
                <div style="margin-top:20px;text-align:right;color:#fd9860;"><a href="./forget.php">忘记密码</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../signin/signin.php">免费注册</a></div>
            </div>
        </div>
    </div>
    <canvas class="background"></canvas>
    <script src="../js/pt/dist/particles.min.js"></script>
    <script src="../js/swal.min.js"></script>
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
                        $.post('../core/api-v1.php?action=login',{username:t.username,password:t.password},function(data){
                            // data = JSON.parse(data);
                            var status = data.status;
                            switch(status){
                                case "success":
                                    localStorage.session = document.cookie;
                                    window.location="../users/index.php";
                                    break;
                                case "failed":
                                    if (data.error) {
                                        swal('','账号或密码不正确','error');
                                    }
                                    break;
                                default:break;
                            }
                        });
                    },
                },
            });
        })
    </script>
</body>
</html>
