<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">

  <div style="margin-top:-50px;">
      <div id="flexigrid"></div>
  </div>

</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
    	url: 'index.php?controller=banner_category&action=get_xml',
    	colModel : [
            {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center'},
            {display: 'ID', name : 'id', width : 50, sortable : false, align: 'center'},
            {display: '分组名称', name : 'cate_name', width : 200, sortable : true, align: 'center'},
    		{display: '排序', name : 'sort', width : 200, sortable : true, align: 'center'},
			{display: '是否显示', name : 'status', width: 200, sortable : true, align : 'center'},
			{display: '添加时间', name : 'create_time', width: 200, sortable : true, align : 'center'}
    		],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增分组', name : 'add', bclass : 'add', title : '新增分组', onpress : fg_operate }
        ],
    	title: '广告分组列表'
    });

});

function fg_operate(name, bDiv) {
    window.location.href = 'index.php?controller=banner_category&action=banner_category_add';
}


function fg_delete(id) {
    if(confirm('删除后将不能恢复，确认删除这条数据吗？')){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "index.php?controller=banner_category&action=delete",
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


</script> 
