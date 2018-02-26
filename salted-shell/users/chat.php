<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="UTF-8">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <title>与。。。的会话</title>
</head>
<body style="height: calc(100% - 80px);">
<?php
    include '../frame/head_user.php';
    if(isset($_GET['user_id'])) echo "<script>var peer_id=".$_GET['user_id'].";</script>";
        else echo "<script>var peer_id = null;</script>";
?>
<script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>

<style>
    #scrolldiv{
        height: calc(100% - 350px);
        background-color: #e6e6e6;
        overflow-y: scroll;
    }
</style>

<div id="chat" style="margin-top: 70px;height: 100%;">
<!--    <div>{{peer_id}}</div>-->
    <div class="container" style="height: 100%;max-width: 900px">
        <div style="height: 70px;background-color: #d6d6d6;text-align: center;padding: 25px;">{{user_info.nickname}}</div>
        <div id="scrolldiv">
            <msg v-for="msg in chat_info.msg" :msg="msg" :subject="self_info.student_id.value"></msg>
        </div>
        <div>
            <textarea type="text/plain" id="ueditor" style="height:300px;"></textarea>
        </div>
        <div style="padding: 10px;"><button class="col-sm-2 col-sm-offset-5 btn btn-success" @click="send_msg">发送</button></div>
    </div>
</div>

<script type="text/x-template" id="msg">
    <div style="padding: 5px;overflow: hidden;">
        <div style="min-height: 40px;width: fit-content;border: 1px solid black;padding: 6px;" :style="sty" v-html="content"></div>
    </div>
</script>

<script>
    $(document).ready(function () {
        var Msg = {
            props:['msg','subject'],
            template: '#msg',
            computed:{
                sty:function () {
                    if (this.msg.sender == this.subject){
                        return {
                            float:'left'
                        }
                    }else {
                        return {
                            float:'right'
                        }
                    }
                },
                content:function () {
                    return decodeURI(this.msg.msg_content);
                }
            }
        }

        var chat = new Vue({
            el:'#chat',
            data:{
                peer_id:peer_id,
                self_info:{},
                user_info:{},
                chat_info:{},
                editor:{},
                scrolldiv:{},
                msg_polling:null,
                msg_count:0,
            },
            methods:{
                fetch_user_info:function () {
                    var vm = this;
                    $.getJSON('../core/api-v1.php?action=fetch_user_info',{user_id:vm.peer_id},function (data) {
                        if (data.status == 'success'){
                            vm.user_info = data.user_info;
                        }else {

                        }
                        console.log(vm.user_info);
                    })
                },
                editor_init:function () {
                    this.editor = UE.getEditor('ueditor',{
                        toolbars: [
                            ['emotion','undo', 'redo', 'bold','italic','underline','strikethrough','subscript','formatmatch','simpleupload','insertimage',
                                'justifyleft','justifycenter','justifyright','justifyjustify','forecolor']
                        ],
                        autoHeightEnabled: false,
                        autoFloatEnabled: false,
                        zIndex:1,
                    });
                    this.editor.ready(function () {
                        this.setHeight(150);
                    })
                },
                scrolldiv_init:function () {
                    this.scrolldiv = document.getElementById('scrolldiv');
                    this.scrolldiv.scrollTop = this.scrolldiv.scrollHeight;
                },
                self_info_init:function () {
                    var vm = this;
                    $.getJSON("../core/api-v1.php?action=fetch_self_info",function(data){
                        if(data.status == "success"){vm.self_info = data.self_info;}
                    });
                },
                chat_info_init:function () {
                    var vm = this;
                    $.getJSON('../core/api-v1.php',{action:'fetch_msg',peer_id:vm.peer_id},function (data) {
                        if (data.status == 'success'){
                            vm.chat_info = data;
                        }else {

                        }
                    })
                },
                start_msg_polling:function () {
                    var vm = this;
                    vm.msg_poll = setInterval(function () {
                        vm.chat_info_init();
                    },3000);
                    this.scrolldiv.scrollTop = this.scrolldiv.scrollHeight;
                },
                send_msg:function () {
                    var vm = this;
                    var content = vm.editor.getContent().replace(/^\s+|\s+$/gm,'');
                    if (content != ''){
                        var msg = {
                            msg_content: content,
                            peer_id: vm.peer_id
                        }
                        $.getJSON('../core/api-v1.php?action=msg_send',msg,function (data) {
                            console.log(data);
                            vm.chat_info_init();
                            vm.editor.setContent("");
                        });
                    }
                },
            },
            mounted:function () {
                this.fetch_user_info();
                this.editor_init();
                this.scrolldiv_init();
                this.self_info_init();
                this.chat_info_init();
                this.start_msg_polling();
            },
            updated:function () {
                var vm = this;
                if (vm.msg_count != vm.chat_info.count){
                    vm.scrolldiv.scrollTop = vm.scrolldiv.scrollHeight;
                    vm.msg_count = vm.chat_info.count;
                }
            },
            components:{
                'msg': Msg,
            }
        })
    })
</script>

</body>
</html>