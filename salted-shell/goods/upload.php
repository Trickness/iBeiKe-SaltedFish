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
<input id="price" type="text" name="price">
<br/>


数量
<input id="count" type="text" name="count">
<br/> 

状态
<select id="status" type="text" name="status">
<option value="available">available</option>
<option value="unavailable">unavailable</option>
</select>
<br/>

类型
<select id="type" type="text" name="type">
<option value="rent">rent</option>
<option value="sale">sale</option>
</select>
<br/>

标签(tags， 用英文分号分割)
<input id="tags" type="text" name="tags">
<br/> 

<div style="text-align:center;display:block;" class="editor">
    <script id="editor" type="text/plain" style="width:1024px;height:600px;"></script>
</div>
<input id="submit" type="submit" value="submit"  style="margin-top:230px;"/>
<script type="text/javascript">
    var ue = UE.getEditor('editor');

    $("#submit").click(function(){
        var jsonData = {};
        jsonData.goods_title=$("#title").val();
        jsonData.price=$("#price").val();
        jsonData.status=$("#status").val();
        jsonData.type=$("#type").val();
        jsonData.content=UE.getEditor('editor').getContent();
        var t = JSON.stringify(jsonData);
        console.log(t);
        
        $.post("../core/api-v1.php?action=submit_goods",{
            goods_info:t
        },function(data){
            var status = data.status;
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