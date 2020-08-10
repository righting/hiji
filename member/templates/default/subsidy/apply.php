<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style>
    .eject_con dl dt, .eject_con dl dd {
        font-size: 12px;
        line-height: 32px;
        vertical-align: top;
        letter-spacing: normal;
        word-spacing: normal;
        text-align: right;
        display: inline-block;
        width: 45%;
        padding: 10px 1% 0 0;
        margin: 0;}
    .eject_con dl dd {
        text-align: left;
        width: 50%;
        padding: 10px 0 0 0;
    }
</style>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="<?php echo urlMember('subsidy','apply');?>" id="subsidy_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="type_id" value="<?php echo $output['type'];?>" />
        <dl>
            <dt style="width: 40%"><i class="required">*</i>请选择转入比例：</dt>
            <dd style="width: 55%">
                <input type="radio" class="radio" name="proportion" value="0" <?php if($output['proportion']==0){echo 'checked';}?>/>0 %
                <input type="radio" class="radio" name="proportion" value="10" <?php if((!in_array($output['proportion'],[0, 10, 20, 30, 40, 50]))||$output['proportion']==10){echo 'checked';}?>/>10 %
                <input type="radio" class="radio" name="proportion" value="20" <?php if($output['proportion']==20){echo 'checked';}?>/>20 %
                <input type="radio" class="radio" name="proportion" value="30" <?php if($output['proportion']==30){echo 'checked';}?>/>30 %
                <input type="radio" class="radio" name="proportion" value="40" <?php if($output['proportion']==40){echo 'checked';}?>/>40 %
                <input type="radio" class="radio" name="proportion" value="50" <?php if($output['proportion']==50){echo 'checked';}?>/>50 %
            </dd>
        </dl>

      <div class="bottom">
        <label class="submit-border">
          <input type="submit" class="submit" value="提交" />
        </label>
        <a class="ncbtn ml5" href='javascript:DialogManager.close("<?php echo $output['close_type'];?>");'>取消</a> </div>
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#subsidy_form').validate({
    	submitHandler:function(form){
    		ajaxpost('subsidy_form', '', '', 'onerror');
    	},
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            true_name : {
                required : true
            },
            address : {
                required : true
            },
            region : {
            	checklast: true
            }
        },
        messages : {
            true_name : {
                required : '<?php echo $lang['member_address_input_receiver'];?>'
            },
            address : {
                required : '<?php echo $lang['member_address_input_address'];?>'
            },
            tel_phone : {
                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
                minlength: '<?php echo $lang['member_address_phone_rule'];?>',
				maxlength: '<?php echo $lang['member_address_phone_rule'];?>'
            },
            mob_phone : {
                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
                minlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
				maxlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
                digits : '<?php echo $lang['member_address_wrong_mobile'];?>'
            }
        },
        groups : {
            phone:'tel_phone mob_phone'
        }
    });
});
</script>