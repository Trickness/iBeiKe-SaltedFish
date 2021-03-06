<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>个人信息编辑</title>
    </head>

    <body style="background-color:#F0F0F0;">
        <?php include "../frame/head_user.php"; ?>
        <style>
            body{
                margin:0;
            }
            p{
                font-size:86%;
                line-height: 142%;
                margin-bottom: -2px;
                margin-top: 12px;
            }
            input{
                width:246px;
                padding-top: 4px;
                padding-bottom: 4px;
                padding-left: 8px;
                padding-right: 8px;
            }
            input.button{
                width:100px;
                height:30px;
                margin:0px;
                text-align: center;
                line-height: 30px;
                color:white;
                border: 0px;
            }
            input.yes-button{
                background-color:#FF9933;
            }
            input.yes-button:hover{
                background-color: #FFAA55;
            }
            input.yes-button:active{
                background-color: #000000;
            }
            input.cancel-button{
                background-color: #B6B6B6;
            }
            input.cancel-button:hover{
                background-color: #D8D8D8;
            }
            input.cancel-button:active{
                background-color: #000000;
                border: 0px;
            }
            input.button:focus{
                border : 0px;
            }
        </style>
        <style>
            .item label{margin-bottom:15px;margin-top:15px;}
            .plus{
                margin-bottom:20px;
                transition-duration:0.4s;
                border:none;
                border-radius:5px;
                width:100%;
                background-size:cover;
                background-position:center;
            }
            .goods_commit{
                background-color:antiquewhite;width:160px;height:40px;color:#FD9860;border:none;border-radius:5px;transition-duration:0.4s;
            }
            .goods_commit:hover{
                background-color:#FF3333;
                color:white;
            }
        </style>
        <div id="edit_profile" class="container" style="margin-top: 70px;margin-bottom: 70px;width: 800px;padding: 0px 40px 20px 25px;background-color: white;box-shadow:0 1px 3px rgba(0,0,0,.1);border-radius: 2px;">
            <div class="row">
                <div class="col-xs-12">
                    <div style="border-bottom:2px solid #FD9860;color:#FD9860;">
                        <h3>编辑你的信息</h3>                
                    </div>
                </div>
            </div>
            <div class="row item" style="margin-top:15px;">
                <div class="col-xs-3">
                    <div class="col-xs-12">
                        <div style="width:100%;" :style="img_style(profile.header)" class="preview"></div>
                    </div>
                    <div class="col-xs-12">
                        <button class="goods_commit" style="width:100%;height:35px;">
                            <label style="margin:7px;font-size: 100%;">上传头像</label>
                            <form id="add_pic" action="../addons/ueditor/php/controller.php?action=uploadimage" method="post" enctype="multipart/form-data" style="margin-top:-34px;">
                                <input type="file" name="upfile" id="upfile"  onchange="add_pic()" style="width: 100%;opacity:0;" />
                            </form>
                        </button>
                    </div>
                </div>
                <div class="col-xs-offset-3 col-xs-6">
                    <div class="col-xs-10" style="text-align:center;">
                        <div class="btn-group" role="group">
                            <button class="btn btn-default" @click="state = true" :class="{active:state}">编辑信息</button>
                            <button class="btn btn-default" @click="state = false" :class="{active:!state}">隐私设置</button>
                        </div>
                    </div>
                    <div class="col-xs-12 form-inline" style="margin-top:15px;">
                        <label>姓名</label>
                        <input v-if="state" type="text" class="form-control" v-model="profile.name.value" disabled />
                        <select v-if="!state" class="form-control" v-model="profile.name.access">
                            <option value="public">公开</option>
                            <option value="protected">登陆可见</option>
                        </select>
                    </div>
                    <div class="col-xs-12 form-inline">
                        <label>学号</label>
                        <input v-if="state" type="text" class="form-control" v-model="profile.student_id.value" disabled />
                        <select v-if="!state" class="form-control" v-model="profile.student_id.access">
                            <option value="public">公开</option>
                            <option value="protected">登陆可见</option>
                        </select>
                    </div>
                    <div class="col-xs-12 form-inline">
                        <label>性别</label>
                        <input v-if="state" type="text" class="form-control" v-model="profile.gender.value" disabled />
                        <select v-if="!state" class="form-control" v-model="profile.gender.access">
                            <option value="public">公开</option>
                            <option value="protected">登陆可见</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row item">
                <div class="col-xs-12">
                            <label>昵称</label>
                            <input type="text" class="form-control input-lg" v-model="profile.nickname" />
                            <!-- <info-edit index="nickname" :state="state" @trans="get" /> -->
                </div>
                <div class="col-xs-6"></div>                
            </div>

            <div class="row item">
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>学院</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.class_info.department.value" />
                            <select v-if="!state" class="form-control" v-model="profile.class_info.department.access">
                                <option value="public">公开</option>
                                <option value="protected">登陆可见</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>班级</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.class_info.class_no.value" disabled/>
                            <select v-if="!state" class="form-control" v-model="profile.class_info.class_no.access">
                                <option value="public">公开</option>
                                <option value="protected">登陆可见</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row item">
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>宿舍（斋）</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.dormitory.dormitory_id.value" />
                            <select v-if="!state" class="form-control" v-model="profile.dormitory.dormitory_id.access">
                                <option value="public">公开</option>
                                <option value="protected">登陆可见</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>寝室</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.dormitory.room_no.value" />
                            <select v-if="!state" class="form-control" v-model="profile.dormitory.room_no.access">
                                <option value="public">公开</option>
                                <option value="protected">登陆可见</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row item">
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>生日</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.birthday.value" disabled/>
                            <select v-if="!state" class="form-control" v-model="profile.birthday.access">
                                <option value="public">公开</option>
                                <option value="protected">登陆可见</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-xs-12">
                            <label>手机号码</label>
                            <input v-if="state" type="text" class="form-control" v-model="profile.phone_number.value" />
                            <select v-if="!state" class="form-control" v-model="profile.phone_number.access" disabled>
                                <option value="public">公开</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row item" style="text-align:center;margin-top:25px;">
                <button class="goods_commit" data-toggle="modal" data-target="#myModal">提交修改</button>
            </div>  

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width:800px;margin-top:150px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">信息确认</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th>学号</th>
                                    <th>昵称</th>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>学院</th>
                                    <th>班级</th>
                                    <th>宿舍</th>
                                    <th>生日</th>
                                    <th>手机号码</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td v-cloak>{{profile.student_id.value}}</td>
                                        <td v-cloak>{{profile.nickname}}</td>
                                        <td v-cloak>{{profile.name.value}}</td>
                                        <td v-cloak>{{profile.gender.value}}</td>
                                        <td v-cloak>{{profile.class_info.department.value}}</td>
                                        <td v-cloak>{{profile.class_info.class_no.value}}</td>
                                        <td v-cloak>{{profile.dormitory.dormitory_id.value + '斋' + profile.dormitory.room_no.value}}</td>
                                        <td v-cloak>{{profile.birthday.value}}</td>
                                        <td v-cloak>{{profile.phone_number.value}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="status == 'editing'" class="modal-footer">
                            <button type="button" class="btn btn-success" @click="submit_edit">确定修改</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                        <div v-if="status == 'success'" class="modal-footer" style="text-align:center;">
                            <h3>修改成功，3秒后跳转</h3>
                        </div>
                    </div>
                </div>
            </div>       
        </div>

        <script>
            function add_pic(){
                var formdata=new FormData($("#add_pic")[0]);
                $.ajax({
                    type : 'post',
                    url : "../addons/ueditor/php/controller.php?action=uploadimage",
                    data : formdata,
                    cache : false,
                    processData : false,
                    contentType : false,
                    success : function(data){
                        data = JSON.parse(data);
                        if(data.state === "SUCCESS"){
                            edit_profile.profile.header = data.url;
                            console.log(edit_profile.profile.header);
                        }
                    },
                    error:function(){
                        console.log("def");
                    }
                });
            }
            var edit_profile = null;
            $(document).ready(function(){
                $(".preview").css("height",$(".preview").css("width"));
                edit_profile = new Vue({
                    el:'#edit_profile',
                    data:{
                        profile:{},
                        state:true,
                        status:'editing',
                    },
                    computed:{
                        thumb:function(){
                            var style = {
                                backgroundImage:"url('"+this.profile.header+"')",
                            };
                            return style;
                        },
                    },
                    methods:{
                        submit_edit:function(){
                            $.post('../core/api-v1.php?action=update_self_info',{info:JSON.stringify(edit_profile.profile)},function(data){
                                console.log(data);
                                if (data.status == 'success') {
                                    edit_profile.status = 'success';
                                    setTimeout(function() {
                                        window.location = './index.php';
                                    }, 3000);
                                }
                            });
                            console.log(this.profile);
                        },
                        img_style:function (img) {
                            var style = {
                                backgroundImage:'url('+img+')',
                                backgroundSize:'cover',
                                backgroundPosition:'center',
                                backgroundRepeat:'no-repeat',
                                marginBottom:'20px',
                                borderRadius:'10px',
                                border:'none',
                            };
                            return style;
                        },
                    },
                    created:function(){
                        $.getJSON('../core/api-v1.php?action=fetch_self_info',function(data){
                            if (data.status == "success") {
                                edit_profile.profile = data.self_info;
                                console.log(edit_profile.profile);
                            }else{
                                alert("你尚未登陆，请登录后尝试")
                                window.location = "../login/login.php"
                            }
                        });
                    },
                });
            });
        </script>
    </body>
</html>