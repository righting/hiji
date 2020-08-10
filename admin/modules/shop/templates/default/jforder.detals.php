<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>

<div style="padding:10px 10px;">
    <blockquote class="layui-elem-quote layui-quote-nm">
        <div style="float:left;">订单号：<?php echo $output['orderInfo']['orderNo']?></div>
        <div style="float:right;">
        订单状态：
        <?php
        switch ($output['orderInfo']['order_status']){
            case '-1':echo "<span style='color:red;'>已取消</span>";break;
            case '0':echo "<span style='color:red;'>未支付</span>";break;
            case '1':echo "<span style='color:blue;'>已支付</span>";break;
            default:echo "<span style='color:red;'>未支付</span>";break;
        }
        ?>
        </div>
        <div style="clear: both;"></div>

        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="100">
                <col width="150">
                <col width="100">
                <col width="150">
            </colgroup>
            <thead>
            <tr>
                <th>支付方式：</th>
                <th colspan="3">
                    <?php
                    switch ($output['orderInfo']['order_type']){
                        case '0':echo '余额支付';break;
                        case '1':echo '支付宝支付';break;
                    }
                    ?>
                </th>
            </tr>
            <tr>
                <th>下单时间：</th>
                <th colspan="3"><?php echo $output['orderInfo']['create_time']?></th>
            </tr>
            <?php if($output['orderInfo']['order_status']==1){?>
            <tr>
                <th>支付时间：</th>
                <th colspan="3"><?php echo $output['orderInfo']['pay_time']?></th>
            </tr>
            <?php }?>
            </thead>
        </table>

    </blockquote>

    <blockquote class="layui-elem-quote layui-quote-nm">收货信息：
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="100">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>收货人：</th>
                <th><?php echo $output['orderInfo']['address_name']?></th>
            </tr>
            <tr>
                <th>联系号码：</th>
                <th><?php echo $output['orderInfo']['address_phone']?></th>
            </tr>
            <tr>
                <th>详细地址：</th>
                <th><?php echo $output['orderInfo']['address']?></th>
            </tr>
            </thead>
        </table>
    </blockquote>

    <blockquote class="layui-elem-quote layui-quote-nm">商品信息：
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="100">
                <col width="150">
                <col width="100">
                <col width="150">
            </colgroup>
            <thead>
            <tr>
                <th>
                    <img style="width:80px;height:80px;" src="<?php echo $output['orderInfo']['goodsInfo']['goods_image']?>"/>
                </th>
                <th colspan="3"><?php echo $output['orderInfo']['goodsInfo']['goods_name']?></th>
            </tr>
            <tr>
                <th>商品单价：</th>
                <th><?php echo $output['orderInfo']['goodsInfo']['goods_price']?></th>
                <th>积分(单)：</th>
                <th><?php echo $output['orderInfo']['goodsInfo']['goods_point']?></th>
            </tr>
            <tr>
                <th>海吉币(单)：</th>
                <th><?php echo $output['orderInfo']['goodsInfo']['goods_hjb']?></th>
                <th>购买数量：</th>
                <th><?php echo $output['orderInfo']['goodsInfo']['number']?></th>
            </tr>
            </thead>
        </table>
    </blockquote>

</div>