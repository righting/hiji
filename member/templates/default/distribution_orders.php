<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="essential">
    <form method="get" action="upgrade/index.php" target="_self">
        <table class="ncm-default-table order" style="display: none">
            <input type="hidden" name="controller" value="member_order" />
            <input type="hidden" name= "recycle" value="<?php echo $_GET['recycle'];?>" />
            <tr>
                <td>&nbsp;</td>
                <th><?php echo $lang['member_order_state'];?></th>
                <td class="w100"><select name="state_type">
                        <option value="" <?php echo $_GET['state_type']==''?'selected':''; ?>><?php echo $lang['member_order_all'];?></option>
                        <option value="state_new" <?php echo $_GET['state_type']=='state_new'?'selected':''; ?>>待付款</option>
                        <option value="state_pay" <?php echo $_GET['state_type']=='state_pay'?'selected':''; ?>>待发货</option>
                        <option value="state_send" <?php echo $_GET['state_type']=='state_send'?'selected':''; ?>>待收货</option>
                        <option value="state_success" <?php echo $_GET['state_type']=='state_success'?'selected':''; ?>>已完成</option>
                        <option value="state_noeval" <?php echo $_GET['state_type']=='state_noeval'?'selected':''; ?>>待评价</option>
                        <option value="state_notakes" <?php echo $_GET['state_type']=='state_notakes'?'selected':''; ?>>待自提</option>
                        <option value="state_cancel" <?php echo $_GET['state_type']=='state_cancel'?'selected':''; ?>>已取消</option>
                    </select></td>
                <th><?php echo $lang['member_order_time'];?></th>
                <td class="w240"><input type="text" class="text w70" name="query_start_date" id="query_start_date" value="<?php echo $_GET['query_start_date']; ?>"/><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input type="text" class="text w70" name="query_end_date" id="query_end_date" value="<?php echo $_GET['query_end_date']; ?>"/><label class="add-on"><i class="icon-calendar"></i></label></td>
                <th><?php echo $lang['member_order_sn'];?></th>
                <td class="w160"><input type="text" class="text w150" name="order_sn" value="<?php echo $_GET['order_sn']; ?>"></td>
                <td class="w70 tc"><label class="submit-border">
                        <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>"/>
                    </label></td>
            </tr>
        </table>
    </form>
    <table class="ncm-default-table order">
        <thead>
        <tr>
            <th class="w10"></th>
            <th colspan="2">商品</th>
            <th class="w90">单价（元）</th>
            <th class="w40">数量</th>
            <th class="w90">优惠活动</th>
            <th class="w110">订单金额</th>
            <th class="w90">顾客信息</th>
            <th class="w120">交易状态</th>
        </tr>
        </thead>
        <?php foreach ($output['orders'] as $order): ?>
        <tbody>
        <tr>
            <td colspan="19" class="sep-row"></td>
        </tr>
        <tr>
            <th colspan="19"> <span class="ml10">
          <!-- order_sn -->
          订单号：<?php echo $order['order_sn'] ?>                    </span>
                <!-- order_time -->
                <span>下单时间：<?php echo date('Y-m-d H:i:s',$order['add_time'])  ?> </span>

                <span member_id="1">
            </th>
        </tr>

        <!-- S 商品列表 -->
        <?php foreach ($output['order_goods'] as $goods):if ($goods['order_id']!=$order['order_id'])continue; ?>
        <tr>
            <td class="bdl"></td>
            <td class="w70"><div class="ncm-goods-thumb"><a href="<?php urlShop('goods','index',['goods_id'=>$goods['goods_id']]) ?>" target="_blank"><img src="<?php echo $goods['goods_image'] ?>"></a></div></td>
            <td class="tl"><dl class="goods-name">
                    <dt><a href="<?php urlShop('goods','index',['goods_id'=>$goods['goods_id']]) ?>" target="_blank"><?php echo $goods['goods_name'] ?></a><span class="rec"></span></dt>
                    <!-- 消费者保障服务 -->
                </dl></td>
            <td><?php echo $goods['goods_price'] ?>         <p class="green">
                </p></td>
            <td><?php echo  $goods['goods_num']  ?> </td>
            <td></td>
            <!-- S 合并TD -->
            <td class="bdl" rowspan="2"><p class=""><strong><?php echo $order['order_amount'] ?></strong></p>

            <td class="bdl" rowspan="2"><p> </p>

                <p class="goods-freight">
                    购买用户:   <?php echo $order['buyer_name'] ?>         </p>
                <p title="购买用户电话："><?php echo $order['buyer_phone'] ?> </p></td>

            </td>
            <td class="bdl bdr" rowspan="2"><!-- 永久删除 -->

                <p><?php
                        switch ($order['order_state']){
                            case ORDER_STATE_CANCEL;$state = '已取消';break;
                            case ORDER_STATE_NEW;$state = '待支付';break;
                            case ORDER_STATE_PAY;$state = '已支付';break;
                            case ORDER_STATE_SEND;$state = '已发货';break;
                            case ORDER_STATE_SUCCESS;$state = '已收货，完成';break;
                        }
                        echo $state;
                    ?>
                </p>

            </td>
            <!-- E 合并TD -->
        </tr>
        <?php endforeach;?>
        </tbody>
        <?php endforeach;?>
        <tfoot>
        <?php if (count($output['orders'])>0){ ?>
        <tr>
            <td colspan="19"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
        </tr>
        <?php }?>
        </tfoot>
    </table>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script>
<script type="text/javascript">
    $(function(){
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
