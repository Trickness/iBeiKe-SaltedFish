<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>注册</title>
</head>
<body style="background-color:#f0f0f0;">
    <?php include "../frame/head_user.php";?>
    <script src="../js/swal.min.js"></script>
    <link href="../css/swal.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet" type="text/css">
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
            <transition enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft">
                <div v-show="sign_0" class="login">
                    <div style="color:#fd9860;"><h2>免费注册</h2></div>
                    <div style="margin-top:30px;"><input type="text" class="form-control input-lg" placeholder="请输入您的学号" v-model="student_id" /></div>
                    <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="请输入本科教学网密码" v-model="password" /></div>
                    <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="confirm">验证你的信息</button></div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft">
                <div v-show="sign_1" class="login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><label>姓名</label><input type="text" class="form-control" v-model="info.name.value" disabled /></div>
                        <div style="margin-top:20px;"><label>班级</label><input type="text" class="form-control" v-model="info.class_info.class_no.value" disabled /></div>
                        <div style="margin-top:20px;"><label>学年</label><input type="text" class="form-control" v-model="info.class_info.enrollment.value" disabled /></div>
                        <div style="margin-top:20px;"><label>性别</label><input type="text" class="form-control" v-model="info.gender.value" disabled /></div>
                       
                        <!-- <table class="table table-hover">
                            <tr><td>姓名</td><td>{{info.name.value}}</td></tr>
                            <tr><td>班级</td><td>{{info.class_info.class_no.value}}</td></tr>
                            <tr><td>学年</td><td>{{info.class_info.enrollment.value}}</td></tr>
                            <tr><td>性别</td><td>{{info.gender.value}}</td></tr>
                        </table> -->

                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(10)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(1)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft">
                <div v-show="sign_2" class="login">
                    <div style="color:#fd9860;"><h2>验证你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="number" class="form-control" placeholder="请输入斋号" v-model="info.dormitory.dormitory_id.value" /></div>
                        <div style="margin-top:20px;"><input type="number" class="form-control" placeholder="请输入房号" v-model="info.dormitory.room_no.value" /></div>
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入手机号" v-model="info.phone_number.value" /></div>
                        <!-- <div style="margin-top:20px;overflow:hidden;">
                            <div class="col-xs-8" style="padding-left:0;"><input disabled="disabled" type="text" class="form-control" placeholder="短信验证码" v-model="check_phone.user_cap" /></div>
                            <div class="col-xs-4" style="padding-right:0;">
                                <button v-if="check_phone.status" style="width:100%;" disabled="disabled"  class="btn btn-warning" @click="fetch_captcha">获取</button>
                                <button v-if="!check_phone.status" style="width:100%;" disabled="disabled"  class="btn" disabled v-cloak>获取({{check_phone.count_down}})</button>
                            </div>
                        </div>
                        <div v-if="!check_captcha" class="col-xs-8" style="padding-left:0;"><p style="color:red;">验证码不正确</p></div> -->
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(11)">上一页</button></div>
                        <div style="margin-top:20px;"><button class="btn btn-warning btn-lg" style="width:100%;" @click="pagi(2)">下一页</button></div>
                    </div>
                </div>
            </transition>
            <transition enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutLeft">
                <div v-show="sign_3" class="login">
                    <div style="color:#fd9860;"><h2>修改你的信息</h2></div>
                    <div style="text-align:left;">
                        <div style="margin-top:20px;"><input type="text" class="form-control" placeholder="请输入昵称" v-model="info.nickname" /></div>
                        <div style="margin-top:20px;"><input type="password" class="form-control" placeholder="请输入你的新密码" v-model="new_password" /></div>
                        <div style="margin-top:20px;"><input type="password" class="form-control" placeholder="再次输入你的新密码" v-model="confirm_password" /></div>
                        <div v-if="!check_password" style="margin-top:20px;"><p style="color:red;">验证密码不一致！</p></div>
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
            var signin =new Vue({
                el:'#signin',
                data:{
                    sign_0:true,
                    sign_1:false,
                    sign_2:false,
                    sign_3:false,
                    sign_4:false,
                    info:{
                        student_id:{
                            access:'protected',
                            value:'',
                        },
                        name:{value:''},
                        class_info:{
                            class_no:{value:''},
                            enrollment:{value:''},
                        },
                        gender:{value:''},
                        birthday:{
                            access:'protected',
                            value:'',
                        },
                        dormitory:{
                            dormitory_id:{value:''},
                            room_no:{value:''},
                        },
                        nickname:'',
                        type:{
                            access:'protected',
                            value:'',
                        },
                        nationality:{
                            access:'protected',
                            value:'',
                        },
                        header:'',
                        phone_number:{
                            access:'public',
                            value:'',
                        },
                    },
                    student_id:'',
                    password:'',
                    new_password:'',
                    confirm_password:'',
                    check_phone:{
                        user_cap:'',
                        captcha:'',
                        status:true,
                        count_down:60,
                    },
                },
                computed:{
                    check_password:function(){
                        if (this.new_password == this.confirm_password) return true;
                            else return false;
                    },
                    check_captcha:function(){
                        if(this.check_phone.user_cap == this.check_phone.captcha) return true;
                            else return false;
                    },
                    count_password:function(){
                        if(this.new_password.length < 8) return false;
                            else return true;
                    }
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
                    fetch_captcha:function () {
                        var phone = this.info.phone_number.value;
                        if (phone.Trim() == '') {
                            swal('','手机号码不能为空','error');
                        }else{
                            $.getJSON('../core/api-v1.php?action=fetch_phone_captcha',{
                                phone_number:phone,
                            },function(data) {
                                console.log(data);
                                if (data.status == 'success') {
                                    signin.check_phone.captcha = ""+data.captcha;
                                    signin.check_phone.status = false;
                                    var total_count = signin.check_phone.count_down;
                                    var count = setInterval(function(){
                                        signin.check_phone.count_down--;
                                        if (signin.check_phone.count_down == 0) {
                                            signin.check_phone.count_down = total_count;
                                            signin.check_phone.status = true;
                                            count = window.clearInterval(count);
                                        }
                                    },1000);
                                    setTimeout(function() {
                                        signin.check_phone.captcha = '';
                                    }, 300000);
                                }else if(data.status == 'failed'){
                                    swal('',data.msg,'error');
                                }
                            });
                        }
                    },
                    confirm:function(){
                        var t = this;
                        if ((t.student_id).Trim() == '' || (t.password).Trim() == '') {
                            swal('','学号或密码不能为空','error');
                        }else{
                            $.post('../core/api-v1.php?action=check',{
                                student_id:t.student_id,
                                password:t.password,
                            },function(data){
                                data = JSON.parse(data);
                                if (!data) {
                                    swal('','学号或密码错误','error');
                                }else if (data.status == 'failed') {
                                    if (data.error == 'you have logged in') {
                                        swal('','已登陆状态，无法注册，请先行注销','error');                                        
                                    }else if(data.error == 'Wrong username or password'){
                                        swal('','学号或密码错误','error');                                        
                                    }
                                }else if(data.status == 'success'){
                                    signin.info = data.student_info;
                                    console.log(signin.info);
                                    t.pagi(0);
                                }
                            });
                        }
                    },
                    signup:function(){
                        var t = this;
                        console.log(t.info);
                        if(t.check_password == false){
                            swal('','验证密码不一致','error');
                        }else if((t.new_password).Trim() == ''){
                            swal('','新密码不能为空','error');                            
                        //}else if(( (t.info.phone_number.value).Trim() == '') || t.check_captcha == false){
                         //   swal('','手机验证失败','error')
                        }else{
                            $.post('../core/api-v1.php?action=signup',{
                                student_id:t.student_id,
                                password:t.password,
                                student_info:t.info,
                                new_password:t.new_password,
                            },function(data){
                                data = JSON.parse(data);
                                console.log(data);
                                if (data.status == 'success') {
                                    swal('注册成功！','3秒后跳转','success');
                                    setTimeout(function() {
                                        window.location = '../index.php';
                                    }, 3000);
                                }else{
                                    if (data.error == 'Wrong username or password') {
                                        swal('','您已注册过本站，不能重复注册','error');
                                    }
                                }
                            });
                        }
                    }
                },
            });
        });
    </script>
</body>
</html>