<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="<?php echo urlMember('member_hi','hiExchangeBonus') ?>" id="hitobonus_form" target="_parent">
            <input type="hidden" name="form_submit" value="ok"/>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['member_id'] ?>"/>
            <dl>
                <dt>月初分红总HI值：</dt>
                <dd>
                    <input type="hidden"  name="allow_hi_to_bonus" value="<?php echo $output['hi_info']['allow_hi_to_bonus']; ?>" />
                    <span class="text w150" ><?php echo $output['hi_info']['allow_hi_to_bonus']; ?></span>
                </dd>
            </dl>
            <dl>
                <dt>分红转HI值比例：</dt>
                <dd>
                    <input type="hidden"  name="pre" value="<?php echo $output['hi_info']['pre']; ?>" />
                    <span class="text w150" ><?php echo $output['hi_info']['pre']*100; ?>%</span>
                </dd>
            </dl>
            <dl>
                <dt>本月已转总HI值：</dt>
                <dd>
                    <input type="hidden"  name="exchangeComplete_month" value="<?php echo $output['hi_info']['exchangeComplete_month']; ?>" />
                    <span class="text w150" ><?php echo $output['hi_info']['exchangeComplete_month']; ?></span>
                </dd>
            </dl>
            <dl>
                <dt>当前可转出HI值：</dt>
                <dd>
                    <input type="hidden" name="enable_hi" value="<?php echo $output['hi_info']['enable_hi']?>" />
                    <span class="text w150" ><?php echo $output['hi_info']['enable_hi']?></span>
                </dd>
            </dl>
            <dl>
                <dt><i class="required">*</i>转至分红：</dt>
                <dd>
                    <input type="text" class="text w200" name="exchange_bonus" value=""/>HI
                </dd>
            </dl>
            <div class="bottom">
                <label class="submit-border">
                    <input type="submit" class="submit" value="提交" />
                </label>
                <a class="ncbtn ml5" href="javascript:DialogManager.close('hitobonus');">取消</a> </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
    $(document).ready(function(){
        $('#hitobonus_form').validate({
            submitHandler:function(form){
                ajaxpost('hitobonus_form', '', '', 'onerror');
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
                exchange_bonus : {
                    required : true
                },

            },
            messages : {
                exchange_bonus : {
                    required : '<?php echo $lang['member_address_input_receiver'];?>'
                },

            },

        });

    });

</script>