<div class="eject_con"><!-- onsubmit="ajaxpost('confirm_order_form','','','onerror')" -->
  <div id="warning"></div>
  <?php if ($output['order_info']) {?>
  <form action="index.php?controller=member_order&action=change_state&state_type=order_thaw&order_id=<?php echo $output['order_info']['order_id']; ?>" method="post" id="confirm_order_form" onsubmit="ajaxpost('confirm_order_form','','','onerror')" >
    <input type="hidden" name="form_submit" value="ok" />
    <h3 class="orange">您确定要解冻订单吗?</h3>
    <dl>
      <dt><?php echo $lang['member_change_order_no'].$lang['nc_colon'];?></dt>
      <dd><?php echo trim($_GET['order_sn']); ?>
        <p class="hint">订单解冻后该订单将已关闭不能进行退货退款并订单将会进入分红结算</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" id="confirm_yes" value="<?php echo $lang['nc_ok'];?>" />
      </label>
      <a class="ncbtn ml5" href="javascript:DialogManager.close('buyer_order_confirm_order');">取消</a> </div>
  </form>
  <?php } else { ?>
  <p style="line-height:80px;text-align:center">该订单并不存在，请检查参数是否正确!</p>
  <?php } ?>
</div>
