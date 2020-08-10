<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="<?php echo urlMember('member_hi','bonusExchangeHi') ?>" id="address_form" target="_parent">
            <input type="hidden" name="form_submit" value="ok"/>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['member_id'] ?>"/>
            <dl>
                <dt>分红余额：</dt>
                <dd>
                    <input type="hidden" id="available_predeposit" name="available_predeposit" value="<?php echo $output['available_predeposit']; ?>" />
                    <span class="text w150" ><?php echo $output['available_predeposit']; ?></span>
                </dd>
            </dl>
            <dl>
                <dt><i class="required">*</i>转入Hi值：</dt>
                <dd>
                    <input type="text" class="text w200" name="exchange_hi" value=""/>
                </dd>
            </dl>
            <div class="bottom">
                <label class="submit-border">
                    <input type="submit" class="submit" value="提交" />
                </label>
                <a class="ncbtn ml5" href="javascript:DialogManager.close('my_address_edit');">取消</a> </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
    $(document).ready(function(){

        $('#address_form').validate({
            submitHandler:function(form){
                ajaxpost('address_form', '', '', 'onerror');
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
                exchange_hi : {
                    required : true
                },

            },
            messages : {
                exchange_hi : {
                    required : '请输入HI值'
                },

            },

        });

    });

</script>