<link href="/shop/templates/default/css/seller_center.css" rel="stylesheet" type="text/css">
<div class="eject_con">
    <div id="warning" class="alert alert-error"></div>
    <form method="post" target="_parent" action="index.php?controller=store_supplier&action=sup_save" id="apply_form">
        <input type="hidden" name="form_submit" value="ok"/>
        <input type="hidden" name="sup_id" value="55555"/>
        <dl>
            <dt><i class="required">*</i>佣金比例：</dt>
            <dd>
                <span class="text w150" >44444</span>
            </dd>
        </dl>
        <dl>
            <dt>佣金：</dt>
            <dd>
                <span class="text w150" >44444</span>
            </dd>
        </dl>
        <dl>
            <dt>分销类型：</dt>
            <dd>
                <span class="text w150" >44444</span>
            </dd>
        </dl>

        <div class="bottom">
            <label class="submit-border"><input type="submit" class="submit" value="提交"/></label>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('#apply_form').validate({
            errorLabelContainer: $('#warning'),
            invalidHandler: function (form, validator) {
                $('#warning').show();
            },
            submitHandler: function (form) {
                ajaxpost('apply_form')
            },
            rules: {
                sup_name: {
                    required: true,
                    rangelength: [0, 100]
                }
            },
            messages: {
                sup_name: {
                    required: '<i class="icon-exclamation-sign"></i>供货商名称不能为空'
                }
            }
        });
    });

</script> 
