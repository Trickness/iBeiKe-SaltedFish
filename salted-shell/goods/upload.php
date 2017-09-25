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
        </style>
    </head>
    <body>
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
        <script src="../js/jquery-latest.js"></script>
        <script src="../js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>
        <script src="../js/vue.js"></script>
        
        <?php include "../frame/head_user.php"; ?>
        <div class="container" id="upload_goods" style="margin-top:100px;height:596.8px;">
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <div style="text-align:center;width:100%;margin-top:15px;margin-botton:15px;">
                            <img id="preview" src="../pic/image1/乐器培训.png" style="height:130px;width:130px;border-radius:15px;" alt="请上传商品图像"><br>
                            <div class="row"><label for="file">Filename:</label></div>
                            <div class="row">
                                <button class="up_file">
                                    <label style="z-index:-1;">点击上传文件</label>
                                    <form id="header-submit-form" method="post" enctype="multipart/form-data" style="margin-top:-31px;opacity:0;">
                                        <input type="file" name="upfile" id="upfile"  onchange="showPreview(this);" />
                                    </form>
                                </button>
                            </div>
                                
                        </div>
                    </div>
                    <div class="row">
                        <form class="form-inline">
                            <div class="row" style="margin-top:15px;"><div class="form-group col-xs-12">
                                    <label>价格</label>
                                    <input type="number" class="form-control" style="width:160px;" v-model="goods_info.single_cost" />
                            </div></div>
                            <div class="row" style="margin-top:18px;"><div class="form-group col-xs-12">
                                    <label>数量</label>
                                    <input type="number" class="form-control" style="width:160px;" v-model="goods_info.remain" />
                            </div></div>
                            <div class="row" style="margin-top:18px;"><div class="form-group col-xs-12">
                                    <label>运费</label>
                                    <input type="number" class="form-control" style="width:160px;" v-model="goods_info.delivery_fee" />
                            </div></div>
                            <div class="row" style="margin-top:18px;"><div class="form-group col-xs-12">
                                    <label>状态</label>
                                    <select class="form-control" style="width:160px;" v-model="goods_info.goods_status">
                                        <option value="available">在售</option>
                                        <option value="unavailable">下架</option>
                                    </select>
                            </div></div>
                            <div class="row" style="margin-top:10px;"><div class="form-group col-xs-12">
                                    <label>交易方式</label>
                                    <select class="form-control" style="width:160px;margin-left:31px;" v-model="goods_info.goods_type">
                                        <option value="sale">出售</option>
                                        <option value="rent">租赁</option>
                                    </select>
                            </div></div>
                            <div class="row" style="margin-top:10px;"><div class="form-group col-xs-12">
                                    <label>标签(用空格分隔)</label>
                                    <input type="text" class="form-control" style="width:160px;margin-left:31px;" v-model="goods_info.tags" />
                            </div></div>
                        </form>
                    </div>
                </div>

                <div class="col-md-7" style="height:596.8px;">
                    <div class="row"><div class="col-xs-12 form-group">
                        <h2 style="margin-top:25px;">商品名称</h2>
                        <input type="text" class="form-control" v-model="goods_info.goods_title" />
                    </div></div>
                    <div class="row" style="margin-top:10px;">
                        <div class="form-inline form-group col-xs-4">
                            <label>一级分类</label>
                            <select id="cl1" v-model="goods_info.cl_lv_1" class="form-control">
                                <option v-for="lv1 in goods_cl" :value="lv1[0]">{{lv1[0]}}</option>
                            </select>
                        </div>
                        <div class="form-inline form-group col-xs-4">
                            <label>二级分类</label>
                            <select v-model="goods_info.cl_lv_2" class="form-control sel">
                                <option v-for="lv2 in lv_2" :value="lv2[0]">{{lv2[0]}}</option>
                            </select>
                        </div>
                        <div class="form-inline form-group col-xs-4">
                            <label>三级分类</label>
                            <select v-model="goods_info.cl_lv_3" class="form-control sel">
                                <option v-for="lv3 in lv_3" :value="lv3">{{lv3}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12"><div style="font-size:24px;height:45px;">商品详情</div></div>
                        <div class="col-xs-12">
                            <script id="editor" type="text/plain" style="height:270px;"></script>
                        </div>
                    </div>
                    <div class="row" style="text-align:center;margin-top:15px;">
                        <button class="goods_commit" @click="submit_goods">发布商品</button>
                    </div>
                </div>

                <div class="col-md-3" style="height: 596.8px;">
                    <div class="row" style="height:480px;margin-top:66.4px;overflow-y:auto;">
                            <div v-for="img in imgs" class="col-xs-6">
                                <div class="col-xs-12 preview" :style="img_style(img)"></div>
                            </div>
                            <div class="col-xs-6">
                                <button class="col-xs-12 preview plus">
                                    <form id="add_pic" action="../addons/ueditor/php/controller.php?action=uploadimage" method="post" enctype="multipart/form-data">
                                        <input type="file" name="upfile" id="upfile"  onchange="add_pic()" style="margin-left: -16px;width: 115px;height: 114px;opacity: 0;" />
                                    </form>
                                </button>
                            </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function showPreview(source) {
                console.log("PREVIEW");
                var file = source.files[0];
                if (window.FileReader) {            // 如果浏览器支持 FileReader
                    var fr = new FileReader();      // 新建 FileReader 对象
                    fr.onloadend = function (e) {   // 当img设置
                        document.getElementById("preview").src = e.target.result;
                    };
                    fr.readAsDataURL(file);         // 读取 img 到 fr 中
                    console.log(fr);                // 控制台打印 fr 结构
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
                                $("#preview").attr("src_URL",data.url);
                                $("#preview").attr("src",data.url);
                            }
                            upload_goods.goods_info.goods_img = data.url;
                            console.log(upload_goods.goods_info);
                        },
                        error:function(){
                            console.log("def");
                        }
                    });
                }
            }
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
                            $("#preview").attr("src_URL",data.url);
                            $("#preview").attr("src",data.url);
                        }
                        upload_goods.insertImage(data.url);
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
                    console.log(imgs);
                });
                var goods_cl = [
                    ['实体商品',[
                        ['开学季',['全部','军训物资','二手教材书','学霸笔记','被子','电话卡','其他']],
                        ['电子产品',['全部','手机配件','电脑配件','其他']],
                        ['吃喝',['全部','零食','特产','饮品','其他']],
                        ['乐器',['全部','吉他','小提琴','尤克里里','口琴','其他']],
                        ['生活用品',['全部','床上用品','学习用品','洗漱用品','日常用品','其他']],
                        ['体育用品',['全部','球类','竞技类','有氧类','健身类','其他']],
                        ['书类',['全部','教材','课外书','杂志订阅','GRE','雅思托福','学霸笔记','复习材料','其他']],
                        ['服饰',['全部','男装','女装','鞋','帽','围巾','手套','其他']],
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
                            goods_status:'',
                            remain:'',
                            tags:'',
                            goods_type:'',
                            delivery_fee:'',
                            cl_lv_1:'',
                            cl_lv_2:'',
                            cl_lv_3:'',
                            goods_img:'',
                            content:'',
                        },
                        cl_lv2:[],
                        cl_lv3:[],
                        imgs:[],
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
                                height:'100'
                            });
                        },
                        submit_goods:function(){
                            this.goods_info.content = editor.getContent();
                            this.goods_info.tags = (this.goods_info.tags+"").split(' ');
                            
                            $.post("../core/api-v1.php?action=submit_goods",{
                                goods_info:JSON.stringify(upload_goods.goods_info),
                            },function(data){
                                data = JSON.parse(data);
                                var status = data.status;
                                if(status === "success"){
                                    alert("成功发布");
                                    //window.location="show.php?goods_id="+data.goods_id;
                                }else if(status === "failed"){
                                    console.log(status);
                                    console.log(data.error);
                                }else{
                                    console.log(data);
                                }

                            });
                            console.log(this.goods_info);
                        }
                    },
                });
            });
        </script>
    </body>
</html>