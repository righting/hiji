<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>抽奖设置</h3>
        <h5>商城会员抽奖功能设置选项</h5>
      </div>
    </div>
  </div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="site_email">是否开启抽奖</label>
        </dt>
        <dd class="opt">
          
			<select name="prize_open">
			  <option value ="0" <?php if($output['list_setting']['prize_open']!=1){ ?>selected = "selected"<?php } ?>>不开启</option>
			  <option value ="1" <?php if($output['list_setting']['prize_open']==1){ ?>selected = "selected"<?php } ?>>开启</option>
			</select>
          <p class="notic">是否开启抽奖</p>
        </dd>
		
		<dt class="tit">
          <label for="site_email">每日免费抽奖次数</label>
        </dt>
        <dd class="opt">
          <input  name="prize_free_num" style="width:50px;text-align:center;" value="<?php echo $output['list_setting']['prize_free_num'];?>" type="number" />
          <p class="notic">免费抽奖次数</p>
        </dd>
		
		<dt class="tit">
          <label for="site_email">每日使用积分抽奖次数</label>
        </dt>
        <dd class="opt">
          <input  name="prize_jf_num" style="width:50px;text-align:center;" value="<?php echo $output['list_setting']['prize_jf_num'];?>" type="number" />
          <p class="notic">使用积分抽奖次数</p>
        </dd>
		
		<dt class="tit">
          <label for="site_email">多少积分抽一次</label>
        </dt>
        <dd class="opt">
          <input  name="prize_jf_money" style="width:50px;text-align:center;" value="<?php echo $output['list_setting']['prize_jf_money'];?>" type="number" />
          <p class="notic">多少积分抽一次</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>
<script type="text/javascript">
</script>
