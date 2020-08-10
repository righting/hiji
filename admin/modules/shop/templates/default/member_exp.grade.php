<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>会员级别</h3>
        <h5>商城注册会员的级别设定</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a href="<?php echo urlAdminShop('member_exp','index') ?>" >经验值明细</a></li>
        <li><a href="<?php echo urlAdminShop('member_exp','expsetting') ?>">规则设置</a></li>
        <li><a href="JavaScript:void(0);" class="current">等级设定</a></li>
        <li><a href="<?php echo urlAdminShop('member_exp','member_position') ?>" >职务设定</a></li>
      </ul>
    </div>
  </div>
  
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>“会员级别设置”提交后，设置立即生效</li>
    </ul>
  </div>
  <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default" id="mg_tbody">
      <div class="title">
        <h3>会员级别设置：</h3>
      </div>
<!--        --><?php //foreach ($output['level_group'] as $level_key=>$level_value){ ?>
<!--            <dl class="row" id="row_--><?php //echo $level_key ?><!--">-->
<!--                <dt class="tit"><strong>--><?php //echo $level_value ?><!--</strong></dt>-->
<!--                <dd class="opt">-->
<!--                    晋级需 <input type="text" name="mg[--><?php //echo $level_key ?><!--][exppoints]" value="--><?php //echo $output['list_setting']['member_grade'][$level_key]['exppoints'];?><!--" class="w60" --><?php //if($level_key == 0){  ?><!--readonly--><?php //}else{ ?><!--nc_type="verify" data-param='{"name":"经验值","type":"exppoints"}'--><?php //} ?><!--/> 经验值-->
<!--                </dd>-->
<!--            </dl>-->
<!--        --><?php //} ?>
        <?php foreach ($output['user_level'] as $k=>$v): if ($v['level']==0)continue;?>
            <dl class="row" id="row_<?php echo $k ?>">
                <dt class="tit"><strong><?php echo $v['level_name'] ?></strong></dt>
                <dd class="opt" style="width: 180px">
                    兑换需 <input type="text" name="user[<?php echo $v['id']  ?>][point]" value="<?php echo $v['point'];?>" class="w60" /> 积分
                </dd>
                <dd class="opt" style="width: 180px">
                    赠送HI值 <input type="text" name="user[<?php echo $v['id']  ?>][give_hi]" value="<?php echo $v['give_hi'];?>" class="w60" /> HI
                </dd>
                <dd class="opt" style="width: 200px">
                    分红HI值赠送 <input type="text" name="user[<?php echo $v['id']  ?>][hi_term]" value="<?php echo $v['hi_term'];?>" class="w30" /> (月)
                </dd>
            </dl>
        <?php endforeach;?>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
	$('#submitBtn').click(function(){
		var result = true;
		var error = new Array();
		$("#mg_tbody").find("[nc_type='verify']").each(function(){
			if(result){
				data = $(this).val();
				if(!data){
					result = false;
					//error.push('请将信息填写完整');
					error = '请将信息填写完整';
				}
				//验证类型
				if(result){
					var data_str = $(this).attr('data-param');
				    if(data_str){
				    	eval( "data_str = "+data_str);
				    	switch(data_str.type){
				    	   case 'exppoints':
				    		   result = (data = parseInt(data)) > 0?true:false;
				    		   error = (result == false)?(data_str.name + '应为整数'):'';
                               break;
                           //case 'orderdiscount':
                           //    result = (parseFloat(data) >= 0 && parseInt(data) <= 100)?true:false;
                           //   error = (result == false)?(data_str.name + '应为0~100之间的数字'):'';
                           //    break;
				    	}
				    }
				}
			}
		});
		if(result){
			$('#mg_form').submit();
		} else {
			showDialog(error);
		}
    });
})
</script>