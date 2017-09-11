<div id="edit_app" class = "bg-model" style="position:absolute;top:0%;left:0%;display:none;background:rgba(0,0,0,0.3);width:100%;height:100%;position:fixed;z-index:9999">
    <div class = 'content' style="position: absolute;left: 35%;top: 25%;border-radius: 8px;width: 460px;height: 303px;background-color: #fff;padding:20px;" >
        <button id="cancel-change" style="float:right;"><span class="ui-icon ui-icon-closethick"></span></button>
        <div>名称:<input type="text" v-model="goods_info.goods_title" /></div>
        <div>价格:<input type="text" id="price" v-model="goods_info.single_cost" /></div>
        <div>数量:<input type="text" id="remain" v-model="goods_info.remain" /></div>
        <div>运费:<input type="text" id="delivery_fee" v-model="goods_info.delivery_fee" /></div>
        <div>状态:<input type="text" id="goods_status" v-model="goods_info.goods_status" /></div>
        <div>类型:<input type="text" id="goods_type" v-model="goods_info.goods_type" /></div>
        <div>一级分类:<input type="text" id="cl_lv_1" v-model="goods_info.cl_lv_1" /></div>
        <div>二级分类:<input type="text" id="cl_lv_2" v-model="goods_info.cl_lv_2" /></div>
        <div>三级分类:<input type="text" id="cl_lv_3" v-model="goods_info.cl_lv_3" /></div>
        <div>tags:<input type="text" id="tags" v-model="goods_info.tags" /></div>
        <div style="text-align:center;"><button @click="submit_editing" name="button">提交修改</button></div>
    </div>
</div>
<script>
    var edit_app = new Vue({
        el:'#edit_app',
        data:{
            goods_info:{},
            result:''
        },
        methods:{
            update_goods_info:function(new_info){
                this.goods_info = new_info;
            },
            submit_editing:function(){
                console.log(this.goods_info);
            }
        }
    });
</script>
