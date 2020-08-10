<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_point.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/associator.css" rel="stylesheet" type="text/css">

<div class="ncp-container">
    <div class="ncp-base-layout">
        <div class="ncp-member-left">
            <?php include_once BASE_TPL_PATH . '/home/pointshop.minfo.php'; ?>
        </div>
        <form action="<?php echo urlShop('pointshop', 'buy_grade') ?>" method="post" id="buygrade">
            <input type="hidden" name="form_submit" value="ok"/>
            <input type="hidden" name="grade" id="grade" value=""/>
            <div class="associator">
                <?php if (count($output['member_grade']) > 0) { ?>
                    <?php foreach ($output['member_grade'] as $key => $val) { ?>
                        <div class="associator-<?php echo $val["level"]; ?> <?php echo (($val['canbuy'] === true)) ? "associator-same" : 'associator-same associator-active' ?>">
                            <a href="<?php echo (($val['canbuy'] === true)) ? "javascript:level(" . ($val["level"]) . ")" : "javascript:;" ?>">立即升级</a>
                        </div>
                    <?php } ?>
                    <?php foreach ($output['member_grade'] as $kk => $vv) { ?>
                        <div class="associator-person-<?php echo count($output['member_grade']) - $kk + 2;  ?> <?php echo (count($output['member_grade']) - $kk + 2) == $vv['now_level'] ? "person-same" : ''; ?> <?php echo count($output['member_grade']) + 1?>"></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </form>
    </div>
</div>
<input type="hidden" id="setSubmit" value="0"/>
<script type="text/javascript">
    function level(val) {
        if ($("#setSubmit").val() == 0) {
            $("#setSubmit").val(1);
            document.getElementById("grade").value = val;
            ajaxpost("buygrade");
        }
    }
</script>