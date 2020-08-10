<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>签到设置</h3>
        <h5>商城会员签到功能设置选项</h5>
      </div>
    </div>
  </div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="site_email">会员每日签到赠送海吉币</label>
        </dt>
        <dd class="opt">
          <input id="sign_in_number" name="sign_in_number" style="width:50px;text-align:center;" value="<?php echo $output['list_setting']['sign_in_number'];?>" type="number" />
          <span class="err"></span>
          <p class="notic">会员每日签到赠送海吉币数量</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>
<script type="text/javascript">
</script>
