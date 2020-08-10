<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>运营设置</h3>
        <h5>各个运营模块的相关设置</h5>
      </div>
    </div>
  </div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">消费者保障服务</dt>
        <dd class="opt">
          <div class="onoff">
            <label for="contract_allow_1" class="cb-enable <?php if($output['list_setting']['contract_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="contract_allow_0" class="cb-disable <?php if($output['list_setting']['contract_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="contract_allow_1" name="contract_allow" <?php if($output['list_setting']['contract_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="contract_allow_0" name="contract_allow" <?php if($output['list_setting']['contract_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic">消费者保障服务开启后，店铺可以申请加入保障服务，为消费者提供商品筛选依据</p>
        </dd>
      </dl>
      <!-- 促销开启 -->




      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script>
$(function(){$("#submitBtn").click(function(){
    if($("#settingForm").valid()){
      $("#settingForm").submit();
	}
	});
});
</script>
