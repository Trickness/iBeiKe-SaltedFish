<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>重置密码</title>
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
        <div id="reset" class="col-sm-4 col-sm-offset-4 login">
            <div style="text-align:center;color:#fd9860;">
                <h2>重置您的密码</h2>
            </div>
            <div style="padding-bottom:10px;">
                <div style="margin-top:30px;"><input type="text" class="form-control input-lg" placeholder="学号" v-model="student_id" /></div>
                <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="教务信息管理系统密码" v-model="password" /></div>
                <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="新密码" v-model="new_password" /></div>
                <div style="margin-top:20px;"><input type="password" class="form-control input-lg" placeholder="再次确认新密码" v-model="confirm_password" /></div>
                <div v-if="!check_password" style="margin-top:20px;"><p style="color:red;">新密码不一致！</p></div>
                <div style="margin-top:20px;"><button class="btn btn-lg btn-warning" style="width:100%;" @click="reset">重置密码</button></div>
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
            String.prototype.Trim = function(){
                return this.replace(/(^\s*)|(\s*$)/g, "");
            }
            var reset = new Vue({
                el:'#reset',
                data:{
                    student_id:'',
                    password:'',
                    new_password:'',
                    confirm_password:'',
                },
                computed:{
                    check_blank:function(){
                        if (this.student_id.Trim()          ==  '' ||
                            this.password.Trim()            ==  '' ||
                            this.new_password.Trim()        ==  '' ||
                            this.confirm_password.Trim()    ==  '') {
                            return false;
                        }else return true;
                    },
                    check_password:function(){
                        if (this.new_password == this.confirm_password) return true;
                            else return false;
                    },
                },
                methods:{
                    reset:function(){
                        var t = this;
                        if (t.check_blank == false) {
                            swal('','任何信息项都不能为空！','error');
                        }else if(t.check_password == false){
                            swal('','新密码不一致！','error');
                        }else{
                            $.post('../core/api-v1.php?action=forget_password',{
                                student_id:t.student_id,
                                password:t.password,
                                new_password:t.new_password
                            },function(data){
                                if (!data) {
                                    swal('重置失败','登录状态下，无法通过“忘记密码”方式重置密码','error');
                                }else{
                                    var status = data.status;
                                    switch(status){
                                        case "success":
                                            localStorage.session = document.cookie;
                                            swal('重置成功!','本页面将在3秒后跳转','success')
                                            setTimeout(function() {
                                                window.location="../login/login.php";
                                            }, 3000);
                                            break;
                                        case "failed":
                                            if (data.error == 'Wrong username or password') {
                                                swal('','重置失败','error');
                                            }else if(data.error == 'Please use GET to specify original_pass and new_pass'){
                                                swal('重置失败','您的学号或教务管理系统密码不正确','error');
                                            }
                                            break;
                                        default:break;
                                    }
                                }
                            });
                        }
                    },
                },
                created:function(){
                    console.log(self_info.is_login);                    
                }
            });
        })
    </script>
</body>
</html>