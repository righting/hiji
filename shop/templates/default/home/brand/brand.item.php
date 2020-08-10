<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<style>
    .brand-box{
        width: 1200px;
        height: auto;
        display: block;
        margin: auto;
    }
    .brand-list{
        width: 1200px;
        height: auto;
        display: block;

        background-color: #0A8CD2;
        margin: auto;
        float: left;
    }
    .brand-list li{
        width: 590px;
        height: 275px;
        display: block;
        background-color: red;
        float: left;
        margin: 5px;
    }
</style>
<div class="brand-box">
    <ul class="brand-list">
<?php foreach ($output['brand_list'] as $key => $brand_r) {?>
        <li>
            <a class="brandImgLink f-fl" href="<?php echo urlShop('brand', 'list', array('brand' => $brand_r['brand_id'])); ?>" target="_blank">
                <img class="brandImg img-lazyload" ccynet-url="<?php echo brandImage($brand_r['brand_pic']); ?>" rel='lazy' src="<?php echo SHOP_SITE_URL; ?>/img/loading.gif" title="<?php echo $brand_r['brand_name']; ?>" alt="<?php echo $brand_r['brand_name']; ?>" width="590" height="275">
            </a>
        </li>
<?php } ?>
    </ul>
</div>