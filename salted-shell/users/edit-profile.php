<html>
    <head>
        <script src="../js/jquery-latest.js"></script>
        <meta charset="utf-8">
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
        <script>
            window.onload=function(){
                var student_id = "";
                if(!$.getJSON("../core/api-v1.php?action=fetch_self_info",function(data){
                    student_id = data.self_info.student_id;
                    console.log(data.self_info);

                    $("#preview").attr("src",data.self_info.header);

                    $("#nickname-input").val(data.self_info.nickname);

                    $("#id-input").val(data.self_info.student_id.value);
                    $("#id-privacy").val(data.self_info.student_id.access);

                    $("#name-input").val(data.self_info.name.value);
                    $("#name-privacy").val(data.self_info.name.access);

                    $("#gender-input").val(data.self_info.gender.value);
                    $("#gender-privacy").val(data.self_info.gender.access);

                    $("#birthday-input").val(data.self_info.birthday.value);
                    $("#birthday-privacy").val(data.self_info.birthday.access);

                    $("#department-input").val(data.self_info.class_info.department.value);
                    $("#department-privacy").val(data.self_info.class_info.department.access);

                    $("#enroll-input").val(data.self_info.class_info.enrollment.value);
                    $("#enroll-privacy").val(data.self_info.class_info.enrollment.access);

                    $("#class-input").val(data.self_info.class_info.class_no.value);
                    $("#class-privacy").val(data.self_info.class_info.class_no.access);

                    $("#dormitory-input").val(data.self_info.dormitory.dormitory_id.value);
                    $("#dormitory-privacy").val(data.self_info.dormitory.dormitory_id.access);

                    $("#room-input").val(data.self_info.dormitory.room_no.value);
                    $("#room-privacy").val(data.self_info.dormitory.room_no.access);

                    $("#phone-input").val(data.self_info.phone_number.value);
                    $("#phone-privacy").val(data.self_info.phone_number.access);
                })){
                    alert("Failed to fetch self info");
                }

                $("#save-button").click(function(){
                    var new_data = Object();
                    new_data.nickname = $("#nickname-input").val();
                    new_data.dormitory = new Object();
                    new_data.dormitory.dormitory_id = new Object();
                    new_data.dormitory.dormitory_id.value = $("#dormitory-input").val();
                    new_data.dormitory.dormitory_id.access = $("#dormitory-privacy").val();
                    new_data.dormitory.room_no = new Object();
                    new_data.dormitory.room_no.value = $("#room-input").val();
                    new_data.dormitory.room_no.access = $("#room-privacy").val();
                    new_data.phone_number = new Object();
                    new_data.phone_number.value = $("#phone-input").val();
                    new_data.phone_number.access = $("#phone-privacy").val();
                    new_data.class_info = new Object();
                    new_data.class_info.department = new Object();
                    new_data.class_info.department.access = $("#department-privacy").val();
                    new_data.class_info.department.value = $("#department-input").val();
                    new_data.class_info.class_no = new Object();
                    new_data.class_info.class_no.access = $("#class-privacy").val();
                    new_data.class_info.enrollment = new Object();
                    new_data.class_info.enrollment.access = $("#enroll-privacy").val();
                    new_data.gender = new Object();
                    new_data.gender.access = $("#gender-privacy").val();
                    new_data.birthday = new Object();
                    new_data.birthday.access = $("#birthday-privacy").val();
                    new_data.name = new Object();
                    new_data.name.access = $("#name-privacy").val();
                    new_data.student_id = new Object();
                    new_data.student_id.access = $("#id-privacy").val();
                    new_data.header = $("#preview")[0].src_URL;
                    console.log(new_data);
                    $.post("../core/api-v1.php?action=update_self_info",{
                        info : JSON.stringify(new_data)
                    },function(data,status,jqXHR){
                        console.log(data);
                    });
                });
            }
        </script>
    </head>

    <body>
        <?php include "../frame/head_user.php"; ?>
        <div id='warpper' style="margin-left:30px;margin-top:100px;">
            <p>头像</p>
            <style>
                .input-file {
                    width: 120px;
                    height: 30px;
                    overflow:hidden;
                    position:relative;
                }
                .input-file input{
                    opacity:0;
                    filter:alpha(opacity=0);
                    font-size:100px;
                    position:absolute;
                    top:0;
                    right:0;
                }
            </style>
            <div style="text-align:center;width:200px;">
                <img id="preview" src="../main/cover.png" style="height:120px;width:120px;border-radius:25px;" alt="请上传您的头像"><br><br>
                <form id="header-submit-form" action="../addons/ueditor/php/controller.php?action=uploadimage" method="post" enctype="multipart/form-data">
                    <label for="file">Filename:</label>
                    <input type="file" name="upfile" id="upfile"  onchange="showPreview(this)" />
                </form>
                <button id="submit-button" style="width:100px;height:30px;" onclick="upload_img();">Upload</button>

            </div>
            
            <p>昵称</p>
            <input type="text" id="nickname-input">

            <p>学号</p>
            <input type="text" id="id-input" disabled="disabled">
            <select name="id-privacy" id="id-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
            </select>

            <p>姓名</p>
            <input type="text" id="name-input" disabled="disabled">
            <select name="name-privacy" id="name-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>性别</p>
            <input type="text" id="gender-input" disabled="disabled">
            <select name="gender-privacy" id="gender-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>生日</p>
            <input type="text" id="birthday-input">
            <select name="birthday-privacy" id="birthday-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>学院</p>
            <input type="text" id="department-input">
            <select name="department-privacy" id="department-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>入学年份</p>
            <input type="text" id="enroll-input" disabled="disabled">
            <select name="enroll-privacy" id="enroll-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>班级</p>
            <input type="text" id="class-input" disabled="disabled">
            <select name="class-privacy" id="class-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>宿舍（斋）</p>
            <input type="text" id="dormitory-input">
            <select name="dormitory-privacy" id="dormitory-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>寝室</p>
            <input type="text" id="room-input">
            <select name="room-privacy" id="room-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>

            <p>手机号码</p>
            <input type="text" id="phone-input">
            <select name="phone-privacy" id="phone-privacy">
                <option value="public">公开</option>
                <option value="protected">登录可见</option>
                <option value="private">保密</option>
            </select>
            <p style="height:30px;"></p>
            <input class="button yes-button" type="submit" value="Save" id="save-button"></input>
            <input class="button cancel-button" type="submit" value="Cancel" id="cancel-button"></input>
        </div>

        <script>
            $("#preview").src_url = "../main/cover.png";
            function showPreview(source) {
                var file = source.files[0];
                if (window.FileReader) {            // 如果浏览器支持 FileReader
                    var fr = new FileReader();      // 新建 FileReader 对象
                    fr.onloadend = function (e) {   // 当img设置
                        document.getElementById("preview").src = e.target.result;
                    };
                    fr.readAsDataURL(file);         // 读取 img 到 fr 中
                    console.log(fr);                // 控制台打印 fr 结构
                }
            }
            function upload_img(){
                if($("#upfile").val() === ""){
                    alert("请选择图片后再上传");
                    return;
                }
                var formdata=new FormData($("#header-submit-form")[0]);
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
                            $("preview").src_URL = data.url;
                        }
                        console.log(data);
                    },
                    error:function(){
                        console.log("def");
                    }
                });
                console.log(formdata);
            }
        </script>
    </body>
</html>
