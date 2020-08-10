<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>会员职务</h3>
        <h5>商城注册会员的职务设定</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a href="<?php echo urlAdminShop('member_exp','index') ?>" >经验值明细</a></li>
        <li><a href="<?php echo urlAdminShop('member_exp','expsetting') ?>">规则设置</a></li>
        <li><a href="<?php echo urlAdminShop('member_exp','member_grade') ?>" >等级设定</a></li>
        <li><a href="JavaScript:void(0);" class="current">职务设定</a></li>
      </ul>
    </div>
  </div>
  
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>“会员职务设置”提交后，设置立即生效</li>
    </ul>
  </div>
  <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default" id="mg_tbody">
      <div class="title">
        <h3>会员职务升级条件设置：</h3>
      </div>
        <?php foreach ($output['pos_info'] as $k=>$v): if ($v['level']==0)continue;?>
            <dl class="row" id="row_<?php echo $k ?>">
                <dt class="tit"><strong><?php echo $v['title'] ?></strong></dt>
                <dd class="opt" style="width: 150px">
                    简称 <input type="text" name="pos[<?php echo $v['id']  ?>][abbreviation]" value="<?php echo $v['abbreviation'];?>" class="w60" />
                </dd>
                <dd class="opt" style="width: 180px">
                    自身等级
                    <select name="pos[<?php echo $v['id']  ?>][own_level]" class="w80">
                        <option value="">请选择</option>
                        <?php foreach ($output['user_level'] as $val): ?>
                            <option value="<?php echo $val['level'] ?>" <?php if ($val['level']==$v['own_level'] )echo 'selected=selected'; ?> ><?php echo $val['level_name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </dd>
                <?php for($i=1;$i<=6;$i++){if ($v['m_'.$i]>0)break;} ?>
                <dd class="opt" style="width: 280px">
                    直推会员等级 <select name="pos[<?php echo $v['id']  ?>][m_]" class="w80">
                        <option value="">请选择</option>
                        <?php foreach ($output['user_level'] as $val):?>
                            <option value="<?php echo $val['level'] ?>" <?php if ($val['level']==$i )echo 'selected=selected'; ?> ><?php echo $val['level_name'] ?></option>
                        <?php endforeach;?>
                    </select>
                    <input type="text" name="pos[<?php echo $v['id']  ?>][m_sum]" value="<?php echo $v['m_'.$i];?>" class="w30" /> 位
                </dd>
                <?php for($j=1;$j<=7;$j++){if ($v['p_'.$j]>0)break;} ?>
                <dd class="opt" style="width: 280px">
                    直推会员职务
                    <select name="pos[<?php echo $v['id'] ?>][p_]">
                        <option value="">请选择</option>
                        <?php foreach ($output['pos_info'] as $v_p): if ($v_p['level']>$v['level'])break;?>
                            <option value="<?php echo $v_p['id'] ?>" <?php if ($v_p['level']==$j )echo 'selected=selected'; ?> ><?php echo $v_p['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="pos[<?php echo $v['id']  ?>][p_sum]" value="<?php echo $v['p_'.$j];?>" class="w30" /> 位
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