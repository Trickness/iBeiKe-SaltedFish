<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="../addons/ueditor/ueditor.all.js"> </script>
    <script type="text/javascript" charset="utf-8" src="../addons/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />

    <style type="text/css">
        div{
            width:100%;
        }
    </style>
</head>
<body style="min-width:1024px;text-align:center;">
标题
<input id="title" type="text" name="title">
<br/> 


价格
<input id="single_cost" type="text" name="single_cost">
<br/>


数量
<input id="remain" type="text" name="remain">
<br/> 

运费
<input id="d_fee" type="text" name="d_fee">
<br/> 

状态
<select id="goods_status" type="text" name="goods_status">
<option value="available">available</option>
<option value="unavailable">unavailable</option>
</select>
<br/>

类型
<select id="goods_type" type="text" name="goods_type">
<option value="rent">rent</option>
<option value="sale">sale</option>
</select>
<br/>

一级分类
<select id="cl_lv_1" type="text" name="cl_lv_1" onchange="lv_1_change(this.value)">
<option value="实体商品">实体商品</option>
<option value="非实体商品">非实体商品</option>
</select>
<br/>

二级分类
<select id="cl_lv_2" type="text" name="cl_lv_2" onchange="lv_2_change(this.value)">
</select>
<br/>

三级分类
<select id="cl_lv_3" type="text" name="cl_lv_3">
</select>
<br/>

标签(tags， 用空格分割)
<input id="tags" type="text" name="tags">
<br/> 

<div style="text-align:center;display:block;" class="editor">
    <script id="editor" type="text/plain" style="width:1024px;height:600px;"></script>
</div>
<input id="submit" type="submit" value="submit"  style="margin-top:230px;"/>
<script type="text/javascript">
    var ue = UE.getEditor('editor');

    var add_option = function(doc_id, keys){
        keys = keys.split(" ");
        for(var i = 0; i < keys.length; i++)
            $(doc_id).append('<option value="'+ keys[i] +'">' + keys[i] + '</option>');
    }

    var lv_1_change = function(value){
        $("#cl_lv_2").empty();
        $("#cl_lv_3").empty();
        if(value === "实体商品"){
            $("#cl_lv_2").append('<option value="全部">全部</option>');
            $("#cl_lv_2").append('<option value="开学季">开学季</option>');
            $("#cl_lv_2").append('<option value="吃喝">吃喝</option>');
            $("#cl_lv_2").append('<option value="生活用品">生活用品</option>');
            $("#cl_lv_2").append('<option value="电子产品">电子产品</option>');
            $("#cl_lv_2").append('<option value="体育用品">体育用品</option>');
            $("#cl_lv_2").append('<option value="服饰">服饰</option>');
            $("#cl_lv_2").append('<option value="书籍">书籍</option>');
            $("#cl_lv_2").append('<option value="乐器">乐器</option>');
            $("#cl_lv_2").append('<option value="服装">服装</option>');
            $("#cl_lv_2").append('<option value="其他">其他</option>');
        }else{
            $("#cl_lv_2").append('<option value="全部">全部</option>');
            $("#cl_lv_2").append('<option value="轰趴聚会">轰趴聚会</option>');
            $("#cl_lv_2").append('<option value="北京周边游">北京周边游</option>');
            $("#cl_lv_2").append('<option value="教学">教学</option>')
            $("#cl_lv_2").append('<option value="其他">其他</option>');
        }
    }
    var lv_2_change = function(value){
        $("#cl_lv_3").empty();
        if(value === "开学季"){
            $("#cl_lv_3").append('<option value="全部">全部</option>');
            $("#cl_lv_3").append('<option value="电话卡">电话卡</option>');
            $("#cl_lv_3").append('<option value="二手教材">二手教材</option>');
            $("#cl_lv_3").append('<option value="床上用品">床上用品</option>');
            $("#cl_lv_3").append('<option value="军训用品">军训用品</option>');
            $("#cl_lv_3").append('<option value="其他">其他</option>');
        }else if(value === "吃喝"){
            $("#cl_lv_3").append('<option value="全部">全部</option>');
            $("#cl_lv_3").append('<option value="零食">零食</option>');
            $("#cl_lv_3").append('<option value="特产">特产</option>');
            $("#cl_lv_3").append('<option value="饮品">饮品</option>');
            $("#cl_lv_3").append('<option value="其他">其他</option>');
        }else if(value === "生活用品"){
            add_option("#cl_lv_3","全部 床上用品 学习用品 洗漱用品 日常用品 其他");
        }else if(value === "电子产品"){
            add_option("#cl_lv_3","全部 电脑配件 手机配件 其他");
        }else if(value === "体育用品"){
            add_option("#cl_lv_3","全部 球类 竞技类 有氧类 健身类 其他");
        }else if(value === "服饰"){
            add_option("#cl_lv_3","全部 男装 女装 鞋 帽 围巾 手套 其他");
        }else if(value === "书类"){
            add_option("#cl_lv_3","全部 教材 课外书 杂志 GRE 雅思托福 学霸笔记 复习材料 其他");
        }else if(value === "乐器"){
            add_option("#cl_lv_3","全部 吉他 小提琴 尤克里里 口琴 其他");
        }
    }
    lv_1_change("实体商品");
    $("#submit").click(function(){
        var jsonData = {};
        jsonData.goods_title=$("#title").val();
        jsonData.single_cost=$("#single_cost").val();
        jsonData.goods_status=$("#goods_status").val();
        jsonData.remain=$("#remain").val();
        jsonData.tags=$("#tags").val().split(" ");
        jsonData.goods_type=$("#goods_type").val();
        jsonData.delivery_fee=$("#d_fee").val();
        jsonData.cl_lv_1=$("#cl_lv_1").val();
        jsonData.cl_lv_2=$("#cl_lv_2").val();
        jsonData.cl_lv_3=$("#cl_lv_3").val();
        jsonData.content=UE.getEditor('editor').getContent();
        var t = JSON.stringify(jsonData);
        console.log(t);
        
        $.post("../core/api-v1.php?action=submit_goods",{
            goods_info:t
        },function(data){
            var status = data.status;
            console.log(data);
            switch(status){
                case "success":
                    console.log(status);
                    break;
                case "failed":
                    console.log(status);
                    console.log(data.error);
                    break;
                default:
                    console.log(status);
                    break;
            }
                
        });
    });
</script>
</body>
</html>