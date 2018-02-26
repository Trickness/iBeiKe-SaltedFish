<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>商品发布</title>
        <style>
            body{margin:0;}
            .up_file{
                padding-top: 8px;
                width: 120px;
                height: 35px;
                border: none;
                border-radius: 5px;
                background-color: antiquewhite;
                color: #FD9860;
                transition-duration: 0.4s;
            }
            .up_file:hover{
                background-color:#FF3333;
                color:white;
            }
            .up_file input{
                margin-left: -5px;
                height: 35px;
                width: 118px;
            }
            .goods_commit{
                background-color:antiquewhite;width:150px;height:40px;color:#FD9860;border:none;border-radius:5px;transition-duration:0.4s;
            }
            .goods_commit:hover{
                background-color:#FF3333;
                color:white;
            }
            .plus{
                background-image:url('../pic/plus.png');
                background-repeat:no-repeat;
                background-size:cover;
                background-position:center;
                border-radius:10px;
                margin-bottom:20px;
                transition-duration:0.4s;
                border:1px solid #cccccc;
            }
            .plus:hover{
                border:none;
                background-image:url('../pic/plus2.png');
            }
            .form-group label{
                margin-bottom:15px;
            }
        </style>
    </head>
    <body style="background-color:#F0F0F0;">
        <?php include "../frame/head_user.php"; ?>        
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>

        <div class="container" id="upload_goods" style="margin-top:70px;margin-bottom:70px;width:900px;padding:0 40px 20px 40px;background-color:white;box-shadow:0 1px 3px rgba(0,0,0,.1);border-radius:2px;">
            <div class="row">
                <div style="border-bottom:2px solid #FD9860;color:#FD9860;">
                    <h3>请上传你的商品</h3>                
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-xs-12">
                    <div class="row"><h4>商品名称</h4></div>
                    <div class="row form-group">
                        <input type="text" v-model="goods_info.goods_title" class="form-control input-lg" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row"><div class="col-xs-12"><h4>商品美图</h4></div></div>
                <div class="row">
                    <div class="col-xs-2" v-for="img in imgs"><div class="col-xs-12 preview" :style="img_style(img)"></div></div>
                    <div class="col-xs-2">
                        <button class="col-xs-12 preview plus">
                            <form id="add_pic" action="../addons/ueditor/php/controller.php?action=uploadimage" method="post" enctype="multipart/form-data">
                                <input type="file" name="upfile" id="upfile"  onchange="add_pic()" style="margin-left: -16px;width: 115px;height: 114px;opacity: 0;" />
                            </form>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 form-group">
                        <label>价格</label>
                        <div class="input-group">
                            <div class="input-group-addon">￥</div>
                            <input type="number" class="form-control" min="0" v-model="goods_info.single_cost" />
                        </div>
                    </div>
                    <div class="col-xs-3 form-group">
                        <label>运费</label>
                        <div class="input-group">
                            <div class="input-group-addon">￥</div>
                            <input type="number" class="form-control" min="0" v-model="goods_info.delivery_fee" />                        
                        </div>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>数量</label>
                        <input type="number" class="form-control" min="0" v-model="goods_info.remain" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 form-group">
                        <label>商品状态</label>
                        <select class="form-control" v-model="goods_info.goods_status" disabled>
                            <option value="available" selected>在售</option>
                        </select>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>交易方式</label>
                        <select class="form-control" v-model="goods_info.goods_type">
                            <option value="sale">出售</option>
                            <option value="rent">租赁</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 form-group">
                        <label>一级分类</label>
                        <select id="cl1" v-model="goods_info.cl_lv_1" class="form-control">
                            <option v-for="lv1 in goods_cl" :value="lv1[0]" v-cloak>{{lv1[0]}}</option>
                        </select>
                    </div>
                    <div class="col-xs-2 form-group">
                        <label>二级分类</label>
                        <select v-model="goods_info.cl_lv_2" class="form-control sel">
                            <option v-for="lv2 in lv_2" :value="lv2[0]" v-cloak>{{lv2[0]}}</option>
                        </select>
                    </div>
                    <div class="col-xs-2 form-group">
                        <label>三级分类</label>
                        <select v-model="goods_info.cl_lv_3" class="form-control sel">
                            <option v-for="lv3 in lv_3" :value="lv3" v-cloak>{{lv3}}</option>
                        </select>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>标签（用空格分隔）</label>
                        <input type="text" class="form-control" v-model="goods_info.tags" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label>图文详情</label>
                        <textarea id="editor" type="text/plain" style="height:500px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="text-align:center;margin-top:15px;">
                <button class="goods_commit" data-toggle="modal" data-target="#mywin">发布商品</button>
            </div>

            <div class="modal fade" id="mywin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" style="width:800px;z-index:1;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                            <h4 class="modal-title" id="myModalLabel">信息确认</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead><th>商品名称</th><th>交易方式</th><th>商品状态</th><th>数量</th><th>单价</th><th>运费</th><th>一级分类</th><th>二级分类</th><th>三级分类</th></thead>
                                <tbody><tr>
                                    <td v-cloak>{{goods_info.goods_title}}</td>
                                    <td v-cloak>{{convert_info.goods_type}}</td>
                                    <td v-cloak>{{convert_info.goods_status}}</td>
                                    <td v-cloak>{{goods_info.remain}}</td>
                                    <td v-cloak>{{goods_info.single_cost}}</td>
                                    <td v-cloak>{{goods_info.delivery_fee}}</td>
                                    <td v-cloak>{{goods_info.cl_lv_1}}</td>
                                    <td v-cloak>{{goods_info.cl_lv_2}}</td>
                                    <td v-cloak>{{goods_info.cl_lv_3}}</td>
                                </tr></tbody>
                            </table>
                        </div>
                        <div v-if="status == 'success'" class="modal-footer" style="text-align:center;"><h3>成功发布,3秒后转到商品页面</h3></div>
                        <div v-if="status == 'failed'" class="modal-footer" style="text-align:center;">
                            <div><h4 v-cloak>{{error}}</h4></div>
                            <div style="text-align:center;"><button type="button" class="btn btn-default" data-dismiss="modal" @click="status = 'editing'">返回编辑</button></div>
                        </div>
                        <div v-if="status == 'editing'" class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-success" @click="submit_goods">确定发布</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <script>
            function add_pic(){
                var formdata = new FormData($("#add_pic")[0]);
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
                            $("#preview").attr("src_URL",data.url);
                            $("#preview").attr("src",data.url);
                        }
                        upload_goods.insertImage(data.url);
                        $("#add_pic :input").not(":button, :submit, :reset, :hidden").val("")
                    },
                    error:function(){
                        console.log("def");
                    }
                });
            }
            var upload_goods = null;
            $(document).ready(function () {
                $(".sel").css('min-width',$("#cl1").css('width'));
                $(".preview").css("height",$(".preview").css("width"));
                var editor = UE.getEditor('editor',{toolbars: [
                                    ['source','undo', 'redo', 'bold','italic','underline','strikethrough','subscript','formatmatch','simpleupload','insertimage',
                                        'justifyleft','justifycenter','justifyright','justifyjustify','forecolor']
                                ],
                                autoHeightEnabled: false,
                                autoFloatEnabled: false,
                                zIndex:1,
                            });
                editor.addListener('contentChange',function () {
                    var info = this.getContent();
                    var reg = /src=[\'\"]?([^\'\"]*).(jpg|png|jpeg|img)[\'\"]?/gi;
                    var imgs = [];
                    imgs = (info).match(reg);
                    if (imgs != null) for (var index = 0; index < imgs.length; index++) {imgs[index] = imgs[index].replace(/src="|"/gi,"");}
                    upload_goods.imgs = imgs;
                    if (imgs)
                        upload_goods.goods_info.goods_img = imgs[0];
                    console.log(imgs);
                });
                var goods_cl = [
                    ['实体商品',[
                        ['开学季',['军训物资','二手教材书','学霸笔记','被子','电话卡','其他']],
                        ['电子产品',['手机配件','电脑配件','其他']],
                        ['吃喝',['零食','特产','饮品','其他']],
                        ['乐器',['吉他','小提琴','尤克里里','口琴','其他']],
                        ['生活用品',['床上用品','学习用品','洗漱用品','日常用品','其他']],
                        ['体育用品',['球类','竞技类','有氧类','健身类','其他']],
                        ['书类',['教材','课外书','杂志订阅','GRE','雅思托福','学霸笔记','复习材料','其他']],
                        ['服饰',['男装','女装','鞋','帽','围巾','手套','其他']],
                        ['服装定制',[]],
                    ]],
                    ['非实体商品',[
                        ['轰趴聚会'],
                        ['北京周边游'],
                        ['摄影'],
                        ['设计'],
                        ['视频'],
                        ['乐器培训'],
                        ['PPT'],
                    ]],
                ];
                upload_goods = new Vue({
                    el:'#upload_goods',
                    data:{
                        goods_cl:goods_cl,
                        goods_info:{
                            goods_title:'',
                            single_cost:'',
                            goods_status:'available',
                            remain:'',
                            tags:'',
                            goods_type:'',
                            delivery_fee:0,
                            cl_lv_1:'',
                            cl_lv_2:'',
                            cl_lv_3:'',
                            goods_img:'',
                            content:'',
                        },
                        cl_lv2:[],
                        cl_lv3:[],
                        imgs:[],
                        status:'editing',
                        error:'',
                    },
                    computed:{
                        lv_2:function(){
                            var cl = [];
                            for (var i = 0; i < this.goods_cl.length; i++) {if (this.goods_info.cl_lv_1 == this.goods_cl[i][0]) cl = this.goods_cl[i][1];}
                            return cl;
                        },
                        lv_3:function(){
                            var cl = [];
                            for (var i = 0; i < this.lv_2.length; i++) {if (this.goods_info.cl_lv_2 == this.lv_2[i][0]) cl = this.lv_2[i][1];}
                            console.log(cl);
                            return cl;
                        },
                        convert_info:function(){
                            var info = {
                                goods_status:'',
                                goods_type:'',
                            };
                            if (this.goods_info.goods_status == "available") info.goods_status = '在售';
                                else info.goods_status = '下架';
                            if (this.goods_info.goods_type == "sale") info.goods_type = '出售';
                                else info.goods_type = '租赁';
                            return info;
                        },
                    },
                    methods:{
                        show:function(){
                            this.goods_info.content = editor.getContent();
                        },
                        img_style:function (img) {
                            var style = {
                                backgroundImage:'url('+img+')',
                                backgroundSize:'cover',
                                backgroundPosition:'center',
                                backgroundRepeat:'no-repeat',
                                marginBottom:'20px',
                                borderRadius:'10px',
                                border:'1px solid #cccccc',
                            };
                            return style;
                        },
                        insertImage:function(url) {
                            editor.execCommand('insertimage', {
                                src:url,
                                width:'100',
                                height:'100',
                            });
                        },
                        submit_goods:function(){
                            this.goods_info.content = editor.getContent();
                            this.goods_info.tags = (this.goods_info.tags+"").split(' ');
                            
                            $.post("../core/api-v1.php?action=submit_goods",{
                                goods_info:JSON.stringify(upload_goods.goods_info),
                            },function(data){
                                // data = JSON.parse(data);
                                upload_goods.status = data.status;
                                console.log(upload_goods.status);
                                if(upload_goods.status === "success"){
                                    setTimeout(function(){window.location="show.php?goods_id="+data.goods_id;},3000);
                                }else{
                                    upload_goods.error = upload_goods.error_analyze(data.error);
                                }
                            });
                            console.log(this.goods_info);
                        },
                        error_analyze:function(error){
                            var error_info = '';
                            switch (error) {
                                case 'syntax error, no title specified':error_info = '商品名称'; break;
                                case 'syntax error, no single cost specified':error_info = '价格'; break;
                                case 'syntax error, no goods status specified':error_info = '商品状态'; break;
                                case 'syntax error, no goods type specified':error_info = '交易方式'; break;
                                case 'syntax error, no remain specified':error_info = '商品数量'; break;
                                default:break;
                            }
                            var error_info = (error=='Not logged in')? '您尚未登陆' : '发布失败，'+error_info+'必须填写';
                            return error_info;
                        },
                    },
                });
            });
        </script>
    </body>
</html>