<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['ccynet_set'];?></h3>
        <h5><?php echo $lang['ccynet_set_subhead'];?></h5>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>在这里可以设置海吉壹佰开发的一些基本功能。</li>
    </ul>
  </div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="ccynet_stitle"><?php echo $lang['ccynet_stitle'];?></label>
        </dt>
        <dd class="opt">
          <input id="ccynet_stitle" name="ccynet_stitle" value="<?php echo $output['list_setting']['ccynet_stitle'];?>" class="input-txt" type="text" />
          <p class="notic"><?php echo $lang['ccynet_stitle_notice'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ccynet_phone"><?php echo $lang['ccynet_phone'];?></label>
        </dt>
        <dd class="opt">
          <input id="ccynet_phone" name="ccynet_phone" value="<?php echo $output['list_setting']['ccynet_phone'];?>" class="input-txt" type="text" />
          <p class="notic"><?php echo $lang['ccynet_phone_notice'];?></p>
        </dd>
      </dl>
            <dl class="row">
        <dt class="tit">
          <label for="ccynet_time"><?php echo $lang['ccynet_time'];?></label>
        </dt>
        <dd class="opt">
          <input id="ccynet_time" name="ccynet_time" value="<?php echo $output['list_setting']['ccynet_time'];?>" class="input-txt" type="text" />
          <p class="notic"><?php echo $lang['ccynet_time_notice'];?></p>
        </dd>
      </dl>
      <!-- <dl class="row">
        <dt class="tit">
          <label for="ccynet_invite2">二级佣金比</label>
        </dt>
        <dd class="opt">
          <input id="ccynet_invite2" name="ccynet_invite2" value="<?php /*echo $output['list_setting']['ccynet_invite2'];*/?>" class="w60" type="text" /><i>%</i>
          <p class="notic">二级佣金=1级佣金*二级佣金比</p>
        </dd>
      </dl>
             <dl class="row">
        <dt class="tit">
          <label for="ccynet_invite3">三级佣金比</label>
        </dt>
        <dd class="opt">
          <input id="ccynet_invite3" name="ccynet_invite3" value="<?php /*echo $output['list_setting']['ccynet_invite3'];*/?>" class="w60" type="text" /><i>%</i>
          <p class="notic">三级佣金=1级佣金*三级佣金比</p>
        </dd>
      </dl>-->
       
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>