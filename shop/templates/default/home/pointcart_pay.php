<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
}
</style>
<div class="wrapper pr">
  <div class="ncc-title">
    <h3>支付提交</h3>
    <h5>订单详情内容可通过查看<a href="<?php echo urlMember('member_pointorder','orderlist') ?>" target="_blank">兑换记录</a>进行核对处理。</h5>
  </div>
  <form action="" method="POST" id="buy_form">
    <input type="hidden" name="pay_sn" value="<?php echo $output['pay_info']['pay_sn'];?>">
    <input type="hidden" id="payment_code" name="payment_code" value="">
    <input type="hidden" value="" name="password_callback" id="password_callback">
    <div class="ncc-receipt-info">
      <div class="ncc-receipt-info-title">
        <h3>
        <?php echo $output['pay']['order_remind'];?>
        <?php echo $output['pay']['pay_amount_online'] > 0 ? "应付金额：<strong>".ncPriceFormat($output['pay_info']['pay_amount_online'])."</strong>元" : null;?>
        </h3>
      </div>
      <table class="ncc-table-style">
        <thead>
          <tr>
            <th class="w50"></th>
            <th class="w200 tl">订单号</th>
            <th class="tl w150">支付方式</th>
            <th class="tl">金额(元)</th>
          </tr>
        </thead>
        <tbody>        
          <?php foreach ($output['order_list'] as $key => $order_info) { ?>
          <tr>
            <td></td>
            <td class="tl"><?php echo $order_info['point_ordersn']; ?></td>
            <td class="tl"><?php echo '在线支付';?></td>
            <td class="tl"><?php echo number_format( $order_info['point_service_charge']+$order_info['point_shipping_fee'],2);?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      
     
    </div>
          <div class="ncc-receipt-info">
          <div class="ncc-receipt-info-title">
            <h3>选择在线支付</h3>
          </div>
          <ul class="ncc-payment-list">
            <?php foreach($output['payment_list'] as $val) { ?>
            <li payment_code="<?php echo $val['payment_code']; ?>">
              <label for="pay_<?php echo $val['payment_code']; ?>">
              <i></i>
              <div class="logo" for="pay_<?php echo $val['payment_id']; ?>"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/payment/<?php echo $val['payment_code']; ?>_logo.gif" /> </div>
              </label>
            </li>
            <?php } ?>
          </ul>
        </div>

    <div class="ncc-bottom"><a href="javascript:void(0);" id="next_button" class="pay-btn"><i class="icon-shield"></i>确认支付</a></div>

  </form>
</div>
<script type="text/javascript">

$(function(){
    $('.ncc-payment-list > li').on('click',function(){
    	$('.ncc-payment-list > li').removeClass('using');
    	if ($('#payment_code').val() != $(this).attr('payment_code')) {
    		$('#payment_code').val($(this).attr('payment_code'));
    		$(this).addClass('using');
        } else {
            $('#payment_code').val('');
        }
    });
    $('#next_button').on('click',function(){
        if ($('#payment_code').val() == '' ) {
        	showDialog('请选择一种在线支付方式', 'error','','','','','','','',2);
        	return;
        }
        $('#buy_form').submit();
    });
});
</script>