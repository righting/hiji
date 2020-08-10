<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>积分订单管理</h3>
        <h5>商城所有积分订单索引及管理</h5>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>

  <div id="flexigrid"></div>

</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=jforder&action=get_xml&type=<?php echo $output['type'];?>',
        colModel : [
            {display: '操作', name : 'operation', width : 60, sortable : false, align: 'center', className: 'handle'},
            {display: '订单编号', name : 'orderNo', width : 180, sortable : true, align: 'center'},
            {display: '订单总金额', name : 'order_money', width :140, sortable : true, align: 'center'},
            {display: '订单所需总积分', name : 'order_point', width :140, sortable : true, align: 'center'},
            {display: '订单所需总海吉币', name : 'order_hjb', width :140, sortable : false, align: 'center'},
            {display: '支付状态', name : 'order_status', width :150, sortable : true, align: 'center'},
            {display: '创建时间', name : 'create_time', width : 200, sortable : true, align: 'center'},
            {display: '支付时间', name : 'pay_time', width : 200, sortable : true, align: 'center'},
            ],
        sortname: "goods_commonid",
        sortorder: "desc",
        title: '积分订单列表'
    });

});


function fg_csv(ids) {
    id = ids.join(',');
    window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&action=export_csv&type=<?php echo $output['type'];?>&id=' + id;
}



//订单详情
function fg_lonkup(ids) {
    _uri = "index.php?controller=jforder&action=detals&id=" + ids;
    CUR_DIALOG = ajax_form('goods_lockup', '违规下架理由', _uri, 640);
}

//查看订单详情
function orderDetails(id){
    layer.open({
        title:'积分订单详情',
        type:2,
        shadeClose:true,
        anim:0,
        area:['600px','700px'],
        content:'index.php?controller=jforder&action=detals&order_id='+id
    })
}

</script>
