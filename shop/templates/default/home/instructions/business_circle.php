<link href="<?php echo SHOP_TEMPLATES_URL?>/css/new_school_of_business.css" rel="stylesheet" type="text/css">
<section class="shortcut">
    <header class="head">
        <nav class="w pt">
            <div class="logo fl"><a href="/"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/instructions_resource/capital/logo.png"> </a></div>
            <ul class="fr capital-nav">
                <li>
                    <a href="/">首页</a>
                </li>
                <?php foreach ($output['top_nav_arr'] as $value){ ?>
                <li class="tap">
                    <a>
                        <span><?php echo $value['ac_name'] ?></span>
                        <span class="btn-after"></span>
                    </a>
                    <div class="dorpdown">
                        <ul>
                            <?php if (isset($value['child']) && !empty($value['child'])){ ?>
                                <?php foreach ($value['child'] as $child_value){ ?>
                                <li><a href="<?php echo urlShop('instructions','index',['f'=>$value['ac_id'],'s'=>$child_value['ac_id']]) ?>"><?php echo $child_value['ac_name'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </header>
</section>



<div class="business-banner01">
    <img src="<?php echo SHOP_TEMPLATES_URL?>/images/business_1.jpg">
</div>
<div class="business-main">
    <div class="aside-nav">
        <ul>
            <li><a href="<?php echo urlShop('instructions','schoolOfBusiness')?>">全部课程</a></li>
            <li><a href="<?php echo urlShop('instructions','businessCircle')?>">海吉商圈</a></li>
            <li><a href="">行业领地</a></li>
            <li><a href="">实力商家</a></li>
            <li><a href="">精品直播</a></li>
            <li><a href="">内容品质</a></li>
            <li><a href="">图文商说</a></li>
            <li><a href="">成为讲师</a></li>
            <li><a href="">经营管理</a></li>
            <li><a href="">公信力建设</a></li>
        </ul>
        <div class="business-loser">
            <img src="<?php echo SHOP_TEMPLATES_URL?>/images/business_2.jpg">
        </div>
    </div>
    <div class="business-video">
        <img src="<?php echo SHOP_TEMPLATES_URL?>/images/business_3.jpg">
    </div>
</div>


  <!--  <div class="business-banner01">
        <img src="<?php /*echo SHOP_TEMPLATES_URL*/?>/images/business_banner_01.jpg">
    </div>
    <div class="business-main">
        <div class="aside-nav">
            <ul>
                <li><a href="">全部课程</a></li>
                <li><a href="">海吉商圈</a></li>
                <li><a href="">行业领地</a></li>
                <li><a href="">实力商家</a></li>
                <li><a href="">精品直播</a></li>
                <li><a href="">内容品质</a></li>
                <li><a href="">图文商说</a></li>
                <li><a href="">成为讲师</a></li>
                <li><a href="">经营管理</a></li>
                <li><a href="">公信力建设</a></li>
            </ul>
        </div>
        <div class="business-video">
            <img src="<?php /*echo SHOP_TEMPLATES_URL*/?>/images/business_01.jpg">
        </div>
    </div>
-->


