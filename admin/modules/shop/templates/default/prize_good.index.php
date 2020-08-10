<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>商品管理</h3>
        <h5>商城积分(海吉币)商品管理</h5>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div id="flexigrid"></div>

</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=prize_good&action=get_xml&type=<?php echo $output['type'];?>',
        colModel : [
            {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
            {display: '编号', name : 'id', width : 100, sortable : true, align: 'center'},
            {display: '奖品名称', name : 'prize_name', width : 200, sortable : false, align: 'left'},
            {display: '奖品图片', name : 'prize_image', width : 60, sortable : true, align: 'center'},
            {display: '中奖时间', name : 'add_time', width : 130, sortable : true, align: 'center'},
            {display: '联系人', name : 'name', width : 130, sortable : true, align: 'center'},
			{display: '收货地址', name : 'addres', width : 130, sortable : true, align: 'center'},
			{display: '联系人电话', name : 'mobile', width : 130, sortable : true, align: 'center'},
			{display: '状态', name : 'dispose', width : 130, sortable : true, align: 'center'},
			{display: '处理时间', name : 'dispose_time', width : 130, sortable : true, align: 'center'},
            ],
        sortname: "prize_sort",
        sortorder: "desc",
        title: '奖品列表'
    });


    // 高级搜索提交
    $('#ncsubmit').click(function(){
        $("#flexigrid").flexOptions({url: 'index.php?controller=goods&action=get_xml&'+$("#formSearch").serialize(),query:'',qtype:''}).flexReload();
    });

    // 高级搜索重置
    $('#ncreset').click(function(){
        $("#flexigrid").flexOptions({url: 'index.php?controller=goods&action=get_xml'}).flexReload();
        $("#formSearch")[0].reset();
    });
});

function fg_operation(name, bDiv) {
    if (name == 'csv') {
        if ($('.trSelected', bDiv).length == 0) {
            if (!confirm('您确定要下载全部数据吗？')) {
                return false;
            }
        }
        var itemids = new Array();
        $('.trSelected', bDiv).each(function(i){
            itemids[i] = $(this).attr('data-id');
        });
        fg_csv(itemids);
    }
}

function fg_csv(ids) {
    id = ids.join(',');
    window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&action=export_csv&type=<?php echo $output['type'];?>&id=' + id;
}


//商品下架
function fg_lonkup(ids) {
    _uri = "index.php?controller=jfgoods_online&action=goods_lockup&id=" + ids;
    CUR_DIALOG = ajax_form('goods_lockup', '违规下架理由', _uri, 640);
}

function fg_sku(commonid) {
    CUR_DIALOG = ajax_form('login','商品"' + commonid +'"的SKU列表','<?php echo urlAdminShop('goods', 'get_goods_sku_list');?>&commonid=' + commonid, 480);
}

// 设置精选尖货
function fg_set_yx(id) {
    $.post('index.php?controller=goods&action=goods_set_yx',{goods_id:id},function (data) {
        if (data.state == 1) {
            $("#flexigrid").flexReload();
        } else {
            showError(data.msg)
        }
    },'json');
}

// 删除
function fg_del(id) {
    if(confirm('删除后将不能恢复，确认删除这项吗？')){
        $.getJSON('index.php?controller=goods&action=goods_del', {id:id}, function(data){
            if (data.state) {
                $("#flexigrid").flexReload();
            } else {
                showError(data.msg)
            }
        });
    }
}
// 商品审核
function fg_verify(ids) {
    _uri = "index.php?controller=goods&action=goods_verify&id=" + ids;
    CUR_DIALOG = ajax_form('goods_verify', '审核商品', _uri, 640);
}
</script>
