<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>订单设置</h3>
        <h5>商城订单功能设置选项</h5>
      </div>
    </div>
  </div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="site_email">系统订单自动确认收货时间</label>
        </dt>
        <dd class="opt">
          <input id="order_time" name="order_time" value="<?php echo $output['list_setting']['order_time'];?>" class="input-txt" type="text" />
          <span class="err"></span>
          <p class="notic">订单已发货配送开始系统自动确认收货时间 不填写默认为7天</p>
        </dd>
      </dl>
        <dl class="row">
            <dt class="tit">
                <label for="site_email">系统订单确认收货后解冻时间</label>
            </dt>
            <dd class="opt">
                <input id="order_thaw_time" name="order_thaw_time" value="<?php echo $output['list_setting']['order_thaw_time'];?>" class="input-txt" type="text" />
                <span class="err"></span>
                <p class="notic">订单已确认收货开始系统自动解冻时间、解冻后进入分红结算、不填写默认为7天</p>
            </dd>
        </dl>

        <dl class="row">
            <dt class="tit">
                <label for="site_email">会员申请订单延迟时间</label>
            </dt>
            <dd class="opt">
                <input id="order_delay_time" name="order_delay_time" value="<?php echo $output['list_setting']['order_delay_time'];?>" class="input-txt" type="text" />
                <span class="err"></span>
                <p class="notic">会员申请订单延迟时间 不填写默认为7天</p>
            </dd>
        </dl>

      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>
<script type="text/javascript">
</script>
