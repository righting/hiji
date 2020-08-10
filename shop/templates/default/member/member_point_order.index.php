<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"/>
<link type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layui/css/layui.css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layer/layer.js"></script>

<div class="essential">

    <div class="essential-nav">
        <?php include template('layout/submenu'); ?>
    </div>


    <table class="ncm-default-table order">
        <thead>
        <tr>
            <th class="w10"></th>
            <th colspan="2">商品</th>
            <th class="w90">单价（元）</th>
            <th class="w90">积分</th>
            <th class="w90">海吉币</th>
            <th class="w50">数量</th>
            <th class="w130">订单状态</th>
        </tr>
        </thead>

        <?php foreach($output['orderInfo'] as $k=>$v){?>
            <tbody>
            <tr>
                <td colspan="19" class="sep-row"></td>
            </tr>
            <tr>
                <th colspan="19">
                <span class="ml10" style="margin-right:25px;font-size:13px;">
                      订单号：<?php echo $v['orderNo'];?>
                </span>
                <span style="margin-right:25px;font-size:13px;">
                    下单时间：<?php echo $v['create_time'];?>
                </span>

                    <span style="margin-right:25px;color:rgb(74,178,255);">
                    订单金额(总)：￥<?php echo $v["order_money"]?>
                    </span>
                    <span style="margin-right:25px;color:rgb(74,178,255);">
                    积分(总)：<?php echo $v["order_point"]?>
                    </span>
                    <span style="margin-right:25px;">
                    海吉币(总)：<?php echo $v["order_hjb"]?>
                    </span>
                </th>
            </tr>

            <!-- S 商品列表 -->
            <tr>
                <td class="bdl"></td>
                <td class="w70">
                    <div class="ncm-goods-thumb">
                        <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goodsInfo']['goodsId']));?>" target="_blank">
                            <img src="<?php echo $v['goodsInfo']['goods_image']?>" onmouseover="toolTip('<img src=<?php echo $v["goodsInfo"]["goods_image"]?> >')" onmouseout="toolTip()">
                        </a>
                    </div>
                </td>
                <td class="tl">
                    <dl class="goods-name">
                        <dt>
                            <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goodsInfo']['goodsId']));?>" target="_blank"><?php echo $v["goodsInfo"]["goods_name"]?></a>
                        </dt>
                    </dl>
                </td>
                <td>￥<?php echo $v['goodsInfo']['goods_price']?><p class="green"></p></td>
                <td><?php echo $v["goodsInfo"]["goods_point"]?></td>
                <td><?php echo $v["goodsInfo"]["goods_hjb"]?></td>
                <td><?php echo $v["goodsInfo"]["number"]?></td>
                <td>
                    <?php if($v["order_status"]==0){ ?>
                        <a href="<?php echo  urlJf('orders','orderPay',array('orderId'=>$v['id'],'orderNo'=>$v['orderNo']));?>"  target="_blank" class="layui-btn layui-btn-warm  layui-btn-sm">订单支付</a><br/>
                        <a href="javascript:;" onclick='closeOrder(<?php echo $v['id'];?> , "<?php echo $v['orderNo']?>")' class="layui-btn layui-btn-danger  layui-btn-sm" style="margin-top:5px;">取消订单</a>
                    <?php }else{?>
                        <span style="color:rgb(74,178,255);">已支付</span>
                    <?php }?>

                    </td>
            </tr>
            </tbody>
        <?php }?>

        <tfoot>
        <tr>
            <td colspan="19"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
        </tr>
        </tfoot>

    </table>

</div>
<script charset="utf-8" type="text/javascript"
        src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/sns.js"></script>
<script type="text/javascript">
    $(function () {
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });


    /*取消订单*/
    function closeOrder(id,orderNo){
        layer.confirm('', {
            title:'订单号：'+orderNo,
            content:'<div>您确定要取消该订单吗?取消后将会自动删除该订单</div>'
        }, function(){
           layer.load();
            $.ajax({
                url: '<?php echo urlShop('member_point_order','closeOrder')?>',
                data:{orderId:id},
                type:'post',
                dataType: 'json',
                success:function(data){
                    layer.closeAll();
                    if(data.status==1){
                        layer.msg(data.msg,{icon:1});
                        setTimeout(function(){
                            window.location.reload();
                        },1000)
                    }else{
                        layer.msg(data.msg)
                    }
                }
            });
        });
    }

</script> 
