<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/theme/default/layer.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layer/layer.js"></script>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>广告管理</h3>
                <h5>广告列表索引和管理</h5>
            </div>
            <ul class="tab-base nc-row">
                <li>
                    <select class="category">
                        <option value ="0" <?php if($output['type']==0){ echo 'selected';}?>>所有</option>
                        <?php foreach ($output['banner_category'] as $key=>$v){ ?>
                            <option value ="<?php echo $v['id'];?>" <?php if($output['type']==$v['id']){ echo 'selected';}?>><?php echo $v['cate_name']; ?></option>
                        <?php } ?>
                    </select>
                </li>
            </ul>
        </div>
    </div>
    <div>
        <div id="flexigrid"></div>
    </div>

</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
    	url: 'index.php?controller=banner_list&action=get_xml&type=<?php echo $output['type'];?>',
    	colModel : [
    		{display: '操作', name : 'operation', width : 200, sortable : false, align: 'center', className: 'handle'},
            {display: '排序', name : 'sort', width : 60, sortable : true, align: 'center'},
            {display: '所属分组', name : 'cate_name', width : 120, sortable : true, align: 'center'},
            {display: '标题', name : 'title', width : 200, sortable : true, align: 'center'},
            {display: '广告图', name : 'img_url', width : 100, sortable : true, align: 'center'},
            {display: '图片链接', name : 'img_link', width : 300, sortable : true, align: 'center'},
    		{display: '开始时间', name : 'sort', width : 180, sortable : true, align: 'center'},
    		{display: '结束时间', name : 'sort', width : 180, sortable : true, align: 'center'},
			{display: '是否显示', name : 'status', width: 180, sortable : true, align : 'center'}
    		],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operate }
        ],
    	title: '广告列表'
    });

    $('.category').on('change',function(){
        type = $.trim($(this).children('option:selected').val());
        window.location.href = 'index.php?controller=banner_list&action=index&type='+type;
    });

    function fg_operate(name, bDiv) {
        window.location.href = 'index.php?controller=banner_list&action=banner_list_add';
    }

});

function fg_delete(id) {
    if(confirm('删除后将不能恢复，确认删除这条数据吗？')){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "index.php?controller=banner_list&action=delete",
            data: "del_id="+id,
            success: function(data){
                if (data.state){
                    $("#flexigrid").flexReload();
                } else {
                    alert(data.msg);
                }
            }
        });
    } else {
        return false;
    }
}


function imgShow(imgUrl){
    var img = new Image();
    img.src = imgUrl;
    img.onload = function(){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: ["'"+img.width+"px'", "'"+img.height+"px'"],
            shadeClose: true,
            content: "<img style='margin:0;padding:0;' src='"+imgUrl+"'/>"
        });
    }
}


</script> 
