<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="UTF-8">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <title id="tl">正在与 {{nickname}} 的聊天中</title>
</head>
<body style="height: calc(100% - 80px);">
<?php
    include '../frame/head_user.php';
    if(isset($_GET['user_id'])) echo "<script>var peer_id='".$_GET['user_id']."';</script>";
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
    #scrolldiv::-webkit-scrollbar{
        width: 10px;
        background-color: #cccccc;
        box-shadow: 0 0 5px black;
    }
    #scrolldiv::-webkit-scrollbar-thumb{
        background-color: #fd9860;
        border-radius: 5px;
    }
    .gradient{
        background: linear-gradient(#e8e8e8,#cccccc);
    }
    body{
        background-color: #f0f0f0;
    }
</style>

<div id="chat" style="margin-top: 70px;height: 100%;">
<!--    <div>{{peer_id}}</div>-->
    <div class="container" style="height: 100%;max-width: 850px;background-color: white;border-radius: 3px;box-shadow: 0 0 2px #cccccc;padding-top: 15px">
        <div style="height: 70px;background-color: #d6d6d6;text-align: center;padding: 5px;border-radius: 3px;" class="gradient"><h4>正在与 {{user_info.nickname}} 的聊天中</h4></div>
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
        <div style="height: 40px;width: 40px;background-position: center;background-size: cover;" :style="header"></div>
        <div style="min-height: 40px;width: fit-content;border-radius: 4px;padding: 10px;" :style="sty" v-html="content"></div>
    </div>
</script>

<script>
    $(document).ready(function () {
        var chat;
        var Msg = {
            props:['msg','subject'],
            template: '#msg',
            computed:{
                sty:function () {
                    if (this.msg.sender == this.subject){
                        return {
                            float: 'right',
                            backgroundColor: '#00c822',
                            color: 'white',
                            boxShadow: '0 0 2px #cccccc',
                        }
                    }else {
                        return {
                            float:'left',
                            backgroundColor: 'white',
                            boxShadow: '0 0 2px #cccccc',
                        }
                    }
                },
                content:function () {
                    return decodeURI(this.msg.msg_content);
                },
                header:function () {
                    var vm = this;
                    if (vm.msg.sender == vm.subject){
                        return {
                            float: 'right',
                            backgroundImage: 'url("'+chat.self_info.header+'")',
                            marginLeft: '20px',
                        }
                    }else {
                        return {
                            float: 'left',
                            backgroundImage: 'url("'+chat.user_info.header+'")',
                            marginRight: '20px',
                        }
                    }
                }
            }
        }

        chat = new Vue({
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
                            tl.nickname = vm.user_info.nickname;
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
                    console.log(vm.peer_id);
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
        });
        var tl = new Vue({
            el:'#tl',
            data:{
                nickname:'',
            }
        })
    })
</script>

</body>
</html>