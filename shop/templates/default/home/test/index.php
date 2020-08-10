<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/js/index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>

<style type="text/css">.category {
        display: block !important;
    }</style>
<div class="clear"></div><!-- HomeFocusLayout Begin-->

<!-- HomeFocusLayout Begin-->
<?php echo $output['web_html']['index_pic']; ?>
<!--HomeFocusLayout End-->





<div class="wrapper">
    <div class="mt10">
        <div class="mt10"><a title="物流自提服务站广告" target="_blank" href="javascript:;"> <img
                        border="0" alt="物流自提服务站广告" src="/data/upload/shop/adv/05561319076203865.jpg"
                        style="width:1200px;height:100px"> </a></div>
    </div>
</div>
<!--StandardLayout Begin-->
<?php echo $output['web_html']['index']; ?>
<!--StandardLayout End-->

<div class="wrapper">
    <div class="mt10">
        <?php echo loadadv(9, 'html'); ?>
    </div>
</div>
