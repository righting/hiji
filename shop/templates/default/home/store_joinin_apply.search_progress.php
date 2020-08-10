<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<!-- 公司信息 -->

<div id="apply_company_info" class="apply-company-info">
    <div class="alert">
        <h4>注意事项：</h4>
        以下所需要上传的电子版资质文件仅支持JPG\GIF\PNG格式图片，大小请控制在1M之内。</div>
    <form id="form_company_info" action="<?php echo urlShop('store_joinin','search_progress') ?>" method="post">
        <table border="0" cellpadding="0" cellspacing="0" class="all">
            <thead>
            <tr>
                <th colspan="2">入驻信息查询</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th><i>*</i>绑定手机号：</th>
                <td>
                    <input name="mobile" type="text" class="w200"/>
                    <span></span>
                </td>
            </tr>
            <tr>
                <th><i>*</i>邀请人 ID：</th>
                <td>
                    <input name="invite_id" type="text" class="w200"/>
                    <span></span>
                </td>
            </tr>

            </tbody>



        </table>

    </form>
    <div class="bottom"><a id="btn_apply_company_next" href="javascript:;" class="btn">提交</a></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#btn_apply_company_next').on('click', function() {
            if($('#form_company_info').valid()){
                $('#form_company_info').submit();
            }
        });
    });
</script>
