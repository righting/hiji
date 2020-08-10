<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>

<!-- 公司信息 -->

<div id="apply_company_info" class="apply-company-info">
    <div class="alert">
        <h4>温馨提示：</h4>
        申请提交后客服将会尽快与您取得联系，请如实填写您的加盟信息
    </div>
    <form id="form_apply_info" action="<?php echo urlShop('dealers', 'save') ?>" method="post">
        <table border="0" cellpadding="0" cellspacing="0" class="all">
            <thead>
                <tr>
                    <th colspan="2">经销商加盟申请</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><i>*</i>联系人姓名：</th>
                    <td>
                        <input name="name" type="text" class="w200"/>
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <th><i>*</i>职称：</th>
                    <td>
                        <input name="title" type="text" class="w200"/>
                        <span></span>
                    </td>
                </tr>

                <tr>
                    <th><i>*</i>手机号：</th>
                    <td>
                        <input name="mobile" type="text" class="w200"/>
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <th><i>*</i>加盟地区：</th>
                    <td><input id="address" name="address" type="hidden" value=""/>
                        <input type="hidden" value="" name="province_id" id="province_id">
                        <span></span></td>
                </tr>
                <tr>
                    <th><i>*</i>加盟说明：</th>
                    <td><textarea name="affiliate_note" rows="3" class="w200"></textarea>
                        <span></span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="20">&nbsp;</td>
                </tr>
            </tfoot>
        </table>

    </form>
    <div class="bottom"><a id="submit" href="javascript:;" class="btn">提交</a></div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('#address').nc_region();


    $('#form_apply_info').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        submitHandler:function(form){
            ajaxpost('form_apply_info', '', '', 'onerror');
        },
        rules : {
            name:{
                required: true,
                maxlength: 16
            },
            title: {
                required: true,
                maxlength: 50
            },
            mobile:{
                required: true,
                maxlength: 11
            },
            address: {
                required: true,
                maxlength: 50
            },
            affiliate_note: {
                required: true,
                maxlength: 500
            }
        },
        messages : {
            name:{
                required: '请输入联系人姓名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            title: {
                required: '请输入职称',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            mobile:{
                required: '请输入手机号码',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            address: {
                required: '请选择区域地址',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            affiliate_note: {
                required: '请填写加盟说明',
                maxlength: jQuery.validator.format("最多{0}个字")
            }
        }
    });

    $('#submit').on('click', function() {
           $('#form_apply_info').submit();
            //ajaxpost('form_company_info', '', '', 'onerror');
    });
});
</script>