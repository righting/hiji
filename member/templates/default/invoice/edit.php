<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style>
    /*.eject_con dl dt, .eject_con dl dd {
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
    }*/
</style>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="<?php echo urlMember('invoice','save');?>" id="invoice_info_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
        <dl>
            <dt><i class="required">*</i>发票类型：</dt>
            <dd>
                <input type="radio" class="radio type-radio" name="type" value="2" />企业增值税普通发票
                <input type="radio" class="radio type-radio" name="type" value="1" checked />个人增值税普通发票
            </dd>
        </dl>
        <dl>
            <dt><i class="required">*</i>发票抬头：</dt>
            <dd>
                <input class="text w100" type="text" name="title" value="<?php echo $output['invoice_info']['title'];?>"/>
            </dd>
        </dl>

        <dl id="type-for-two" style="display: none">
            <dt><i class="required">*</i>纳税人识别号：</dt>
            <dd>
                <select name="sbh_type">
                    <option value="1">社会统一信用代码</option>
                    <option value="2">税务登记证号码</option>
                </select>
                <input type="text" class="text w200" name="number" value="<?php echo $output['invoice_info']['number'];?>"/>
            </dd>
        </dl>

      <div class="bottom">
          <label class="submit-border">
              <input type="submit" class="submit" value="提交" />
          </label>
          <a class="ncbtn ml5" href='javascript:DialogManager.close("<?php echo $output['close_type'];?>");'>取消</a>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
    $('.type-radio').change(function(){
       var _type = $(this).val();
       if(_type == 2){
           $('#type-for-two').show();
       }else{
           $('#type-for-two').hide();
       }
    });
$(document).ready(function(){
	$('#invoice_info_form').validate({
    	submitHandler:function(form){
    		ajaxpost('invoice_info_form', '', '', 'onerror');
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
            type : {
                required : true
            },
            title : {
                required : true
            }
        },
        messages : {
            type : {
                required : '请选择发票类型'
            },
            title : {
                required : '发票抬头不能为空'
            }
        }
    });
});
</script>