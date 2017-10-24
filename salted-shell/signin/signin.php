<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>注册</title>
</head>
<body style="background-color:#f0f0f0;">
    <?php include "../frame/head_user.php";?>
    <script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
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
            .login{text-align:center;transition-duration:0.4s;background-color:white;opacity:0.8;border-radius:2px;border-top:2px solid #fd9860;padding:20px 40px 40px 40px;box-shadow:0 1px 3px rgba(0,0,0,.1);}
        }
    </style>
    <div id="signin" class="container win">
        <div class="col-sm-4 col-sm-offset-4">
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_0" class="login">
                    <div style="color:#fd9860;"><h2>免费注册</h2></div>
                    <div style="margin-top:30px;"><input type="text" class="form-control input-lg" placeholder="请输入您的学号" v-model="student_id" /></div>
                    <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="请输入您的密码" v-model="password" /></div>
                    <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="confirm">验证你的信息</button></div>
                </div>                    
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_1" class="login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><label>姓名</label><input type="text" class="form-control" v-model="info.name.value" /></div>
                        <div style="margin-top:20px;"><label>年级</label><input type="text" class="form-control" v-model="info.class_info.class_no.value" /></div>
                        <div style="margin-top:20px;"><label>学年</label><input type="text" class="form-control" v-model="info.class_info.enrollment.value" /></div>
                        <div style="margin-top:20px;"><label>性别</label><input type="text" class="form-control" v-model="info.gender.value" /></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(10)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(1)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_2" class="login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入斋号" v-model="info.dormitory.dormitory_id.value" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入房号" v-model="info.dormitory.room_no.value" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入手机号" /></div>
                        <div style="margin-top:20px;overflow:hidden;">
                            <div class="col-xs-8" style="padding-left:0;"><input type="text" class="form-control" placeholder="短信验证码" /></div>
                            <div class="col-xs-4" style="padding-right:0;"><button style="width:100%;" class="btn btn-warning">获取</button></div>
                        </div>

                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(11)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(2)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                <div v-show="sign_3" class="login">
                    <div style="color:#fd9860;"><h2>修改你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入昵称" v-model="info.nickname" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入你的新密码" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="再次输入你的新密码" /></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(12)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-danger btn-lg" style="width:100%;" @click="signup">注册</button></div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
    <canvas class="background"></canvas>
    <script src="../js/pt/dist/particles.min.js"></script>
    <script>
        String.prototype.Trim = function(){ 
            return this.replace(/(^\s*)|(\s*$)/g, ""); 
        } 
        window.onload = function() {
            var num = 0;
            if(window.innerWidth > 1536){
                num = 320;
            }else if (window.innerWidth > 768) {
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
            var info = {
                student_id:{
                    access:'protected',
                    value:'',
                },
                name:{
                    access:'public',
                    value:'',
                },
                gender:{
                    access:'public',
                    value:'',
                },
                birthday:{
                    access:'protected',
                    value:'',
                },
                type:{
                    access:'protected',
                    value:'',
                },
                nationality:{
                    access:'protected',
                    value:'',
                },
                nickname:'',
                header:'',
                class_info:{
                    access:'protected',
                    department:{
                        access:'protected',
                        value:'',
                    },
                    erollment:{
                        access:'protected',
                        value:'',
                    },
                    class_no:{
                        access:'protected',
                        value:'',
                    },
                },
                dormitory:{
                    access:'protected',
                    dormitory_id:{
                        access:'protected',
                        value:'',
                    },
                    room_no:{
                        access:'protected',
                        value:'',
                    },
                },
                phone_number:{
                    access:'public',
                    value:'',
                },
            };

            var signin =new Vue({
                el:'#signin',
                data:{
                    sign_0:true,
                    sign_1:false,
                    sign_2:false,
                    sign_3:false,
                    sign_4:false,
                    info:{
                        name:{value:''},
                        class_info:{
                            class_no:{value:''},
                            enrollment:{value:''},
                        },
                        gender:{value:''},
                        dormitory:{
                            dormitory_id:{value:''},
                            room_no:{value:''},
                        },
                        nickname:'',
                    },
                    student_id:'',
                    password:'',
                },
                methods:{
                    pagi:function(page){
                        switch (page) {
                            case 0:this.sign_0 = !this.sign_0;setTimeout(function() {signin.sign_1 = !signin.sign_1;}, 800);break;
                            case 1:this.sign_1 = !this.sign_1;setTimeout(function() {signin.sign_2 = !signin.sign_2;}, 800);break;
                            case 2:this.sign_2 = !this.sign_2;setTimeout(function() {signin.sign_3 = !signin.sign_3;}, 800);break;
                            case 10:this.sign_1 = !this.sign_1;setTimeout(function() {signin.sign_0 = !signin.sign_0;}, 800);break;
                            case 11:this.sign_2 = !this.sign_2;setTimeout(function() {signin.sign_1 = !signin.sign_1;}, 800);break;
                            case 12:this.sign_3 = !this.sign_3;setTimeout(function() {signin.sign_2 = !signin.sign_2;}, 800);break;
                            default:break;
                        }
                    },
                    confirm:function(){
                        var t = this;
                        if ((t.student_id).Trim() == '' || (t.password).Trim() == '') {
                            swal('','学号或密码不能为空','error');
                        }else{
                            $.getJSON('../core/api-v1.php?action=check',{
                                student_id:t.student_id,
                                password:t.password,
                            },function(data){
                                if (!data) {
                                    swal('','学号或密码错误','error');
                                }else{
                                    signin.info = data;
                                    console.log(signin.info);
                                    t.pagi(0);
                                }
                            });
                        }
                    },
                    signup:function(){
                        var t = this;
                        $.getJSON('../core/api-v1.php?action=signup',{
                            student_id:t.student_id,
                            password:t.password,
                        },function(data){
                            console.log(data);
                            if (data.status == 'success') {
                                swal('注册成功！','3秒后跳转','success');
                                setTimeout(function() {
                                    window.location = '../index.php';
                                }, 3000);
                            }
                        })
                    }
                },
            });
        });
    </script>
</body>
</html>