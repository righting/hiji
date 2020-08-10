<!DOCTYPE html>
<html lang="zh">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
    <title><?php echo $output['html_title'].$output['webTitle']; ?></title>
    <meta name="keywords" content="<?php echo $output['seo_keywords']; ?>"/>
    <meta name="description" content="<?php echo $output['seo_description']; ?>"/>
    <meta name="author" content="CCYNet">
    <meta name="copyright" content="CCYNet Inc. All Rights Reserved">
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <?php echo html_entity_decode($output['setting_config']['qq_appcode'], ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['sina_appcode'], ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_qqzone_appcode'], ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_sinaweibo_appcode'], ENT_QUOTES); ?>
    <style type="text/css">
        body {
            _behavior: url(<?php echo SHOP_TEMPLATES_URL;?>/css/csshover.htc);
        }
        .fixed-box {
            display: block;
            position: fixed;
            z-index: 999;
        }
    </style>
    <link rel="stylesheet" href="/shop/templates/default/css/new_base.css" type="text/css"/>

    <link rel="stylesheet" href="/shop/templates/default/css/font-awesome.css" type="text/css"/>
    <link rel="stylesheet" href="/shop/templates/default/css/personal.css" type="text/css"/>

    <link href="/jf/templates/default/css/base.css" rel="stylesheet" type="text/css">
    <link href="/jf/templates/default/css/header.css" rel="stylesheet" type="text/css">
    <link href="/shop/templates/default/css/css/personal.css" rel="stylesheet" type="text/css">
    <link href="/shop/templates/default/css/css/service_self.css" rel="stylesheet" type="text/css">
    <link href="/member/templates/default/css/new_service.css" rel="stylesheet" type="text/css">

    <script>
        var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';
        var _CHARSET = '<?php echo strtolower(CHARSET);?>';
        var LOGIN_SITE_URL = '<?php echo LOGIN_SITE_URL;?>';
        var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';
        var SITEURL = '<?php echo SHOP_SITE_URL;?>';
        var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';
        var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';
        var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';
        var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
    </script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/common.js" charset="utf-8"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/jquery.ui.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.validation.min.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
    <script>
        $(function () {

            $(".head-user-menu dl").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });

            $(".quick-menu dl").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });
            $(".site-menu .links_a").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });

            $(".site-menu .links_a").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });

        })
    </script>

</head>
<body>


<style>

    .keyword ul {
        width: 416px;
        white-space: nowrap;
    }

    .user-entry .user-class {
        font: 12px/16px Georgia, Arial;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, .25);
        vertical-align: middle;
        display: inline-block;
        height: 16px;
        padding: 1px 3px;
        border-radius: 2px;
        color: #9737df;
        text-align: center;
        border: 1px solid #9737df;
    }

    .user-entry em {
        display: inline-block;
        vertical-align: middle;
    }

    .head-user-menu dl dd .incart-goods ul {
        font-size: 0;
        padding: 0 12px;
    }

    .head-user-menu dl dd .incart-goods li {
        display: inline-block;
        font-size: 12px;
        width: 90px;
        margin: 0 9px 9px 9px;
        text-align: center;
    }

    .head-user-menu dl dd .incart-goods .goods-title {
        width: 90px;
        height: 18px;
        line-height: 18px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;

    }

    .head-user-menu dl dd .incart-goods .goods-price {
        font-size: 12px;
        height: 16px;
        line-height: 16px;
        color: #ff6700;
    }

    .head-user-menu dl dd .browse-history li {
        text-align: center;
        display: inline-block;
        width: 90px;
        font-size: 12px;
    }

    .head-user-menu dl dd .browse-history .goods-title {
        width: 90px;
        height: 20px;
        line-height: 20px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;

    }

    .head-user-menu dl dd .browse-history .goods-price {
        font-size: 14px;
        color: #ff6700;
    }

    .head-user-menu dl dd .browse-history a:hover,
    .head-user-menu dl dd .incart-goods a:hover {
        text-decoration: none;
    }

    .clearfix {
        display: block;
    }

    /* .head-search-bar .search-form {
        background-color: #4FB602;
        height: 36px;
        padding: 1px;
    } */
</style>

<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry" style="font-size:12px;">
            您好<?php if($_SESSION['is_login']==1){?>
            <a href="<?php echo urlShop('member', 'home'); ?>">
                <?php echo $_SESSION['member_nickname']?></a>        <a href="<?php echo urlShop('pointgrade', 'index'); ?>"><span class="user-class"><?php echo $output['levelInfo']['level_name']?><?php }?></span></a>，欢迎来到      <a href="/" title="首页" alt="首页">海吉壹佰</a>
            <?php if ($_SESSION['is_login'] == '1') { ?>
                <span>[<a href="<?php echo urlLogin('login', 'logout'); ?>">退出</a>]</span>
            <?php }else{?>
                <span>[<a href="/member/index.php?controller=login&action=index">登录</a>]</span>
                <span>[<a href="/member/index.php?controller=login&action=register">注册</a>]</span>
            <?php }?>
            <span>[<a href="/" target="_blank">返回平台首页</a>]</span>
        </div>

        <?php
        $nav = Model()->table('navigation')->where(['nav_location'=>0,'nav_pid'=>0])->order('nav_sort asc')->select();
        if(!empty($nav)){
            foreach($nav as $k=>$v){
                $nav[$k]['info'] = Model()->table('navigation')->where(['nav_location'=>0,'nav_pid'=>$v['nav_id']])->order('nav_sort asc')->select();
            }
        }

        ?>
        <div class="quick-menu">

            <?php foreach($nav as $k=>$v){?>
                <dl>
                    <dt><a target="_blank" href="<?php if(!empty($v['nav_url'])){ echo $v['nav_url'];}else{ echo 'javascript:;';}?>"><?php echo $v['nav_title']?></a><i></i></dt>
                    <?php if(!empty($v['info']) && is_array($v['info'])){?>
                        <dd>
                            <ul>
                                <?php foreach($v['info'] as $key=>$val){?>
                                    <li><a target="_blank" href="<?php if(!empty($val['nav_url'])){ echo $val['nav_url'];}else{ echo 'javascript:;';}?>" title="招商入驻"><?php echo $val['nav_title']?></a></li>
                                <?php }?>
                            </ul>
                        </dd>
                    <?php }?>
                </dl>
            <?php }?>

        </div>


    </div>
</div>


<div class="header-wrap">
    <header class="public-head-layout wrapper">

        <h1 class="site-logo" style="width:390px">
            <a href="/"><img src="/ngyp/templates/default/images/H_logo.jpg" class="pngFix"
                             style="margin-right:8px;"></a>
            <a href="/">
                <?php if ($output['page']['page_type'] == 1) { ?>
                    <img style="max-width:374px;max-height:65px; "
                         src="/member/templates/default/new_images/ngyp_logo.jpg" class="pngFix">
                <?php } else if ($output['page']['page_type'] == 2) { ?>
                    <img style="max-width:374px;max-height:65px; "
                         src="/member/templates/default/new_images/consumption_logo.png" class="pngFix">
                <?php } else if ($output['page']['page_type'] == 3) { ?>
                    <img style="max-width:374px;max-height:65px; "
                         src="/member/templates/default/new_images/offline_logo.png" class="pngFix">
                <?php } else if ($output['page']['page_type'] == 4) { ?>
                    <img style="max-width:374px;max-height:65px; "
                         src="/member/templates/default/new_images/share_logo.png" class="pngFix">
                <?php } else if ($output['page']['page_type'] == 5) { ?>
                    <img style="max-width:374px;max-height:65px; "
                         src="/member/templates/default/new_images/memb_logo.png" class="pngFix">
                <?php } else { ?>

                <?php } ?>
            </a>
            <div class="marquee-wrap">
                <div>
                    <ul class="marquee-icon">
                        <li>购分红，购赚钱</li>
                        <li>拼实惠，赚红利</li>
                        <li>不只是好产品</li>
                    </ul>
                </div>
            </div>

        </h1>
        <div class="head-search-bar" style="overflow: visible;">
            <form action="<?php echo SHOP_SITE_URL; ?>" method="get" class="search-form" target="_blank">
                <input name="controller" id="search_act" value="search" type="hidden">
                <input name="keyword" id="keyword" type="text" class="input-text" value="" maxlength="60"
                       x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入商品关键词"
                       x-webkit-grammar="builtin:search"/>
                <input type="submit" id="button" value="搜索" class="input-submit">
            </form>

            <div class="keyword">热门搜索：
                <ul>
                    <?php foreach ($output['setInfo'] as $k => $v) { ?>
                        <li><a target="_blank"
                               href="/shop/index.php?controller=search&action=index&keyword=<?php echo $v; ?>"><?php echo $v; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
        <div class="head-user-menu">
            <dl class="my-mall">
                <dt><span class="ico"></span>我的商城<i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4></h4>
                        <a target="_blank" href="/shop/index.php?controller=member&action=home"
                           class="arrow">我的用户中心<i></i></a></div>
                    <div class="user-centent-menu">
                        <ul>
                            <li><a target="_blank" href="/member/index.php?controller=member_message&action=message">站内消息</a>
                            </li>
                            <li><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order"
                                   class="arrow">我的订单<i></i></a></li>
                            <!-- <li><a href="">咨询回复(<span id="member_consult">0</span>)</a></li>-->
                            <li><a target="_blank"
                                   href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist"
                                   class="arrow">我的收藏<i></i></a></li>
                            <!--<li><a href="">代金券(<span id="member_voucher">0</span>)</a></li>-->
                            <li><a target="_blank" href="/member/index.php?controller=member_points&action=index"
                                   class="arrow">我的积分<i></i></a></li>
                        </ul>
                    </div>
                    <?php if (!empty($output['goodsBrowseInfo']) && is_array($output['goodsBrowseInfo'])) { ?>
                        <div class="browse-history">
                            <div class="part-title">
                                <h4>最近浏览的商品</h4>
                            </div>
                            <ul>
                                <?php foreach ($output['goodsBrowseInfo'] as $k => $v) { ?>
                                    <li>
                                        <a target="_blank"
                                           href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>">
                                            <img style="width: auto;height: auto;max-width: 100%;max-height: 100%;"
                                                 src="<?php echo $v['goods_image'] ?>">
                                            <p class="goods-title"><?php echo $v['goods_name']; ?></p>
                                            <span class="goods-price">￥<?php echo $v['goods_price']; ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <!--<li class="no-goods"><img class="loading" src="<?php /*echo jf_TEMPLATES_URL;*/ ?>/images/loading.gif" /></li>-->
                            </ul>
                        </div>
                    <?php } ?>
                </dd>
            </dl>
            <dl class="my-cart">
                <dt><span class="ico"></span>购物车结算<i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4>最新加入的商品</h4>
                    </div>
                    <div class="incart-goods-box">
                        <div class="incart-goods">
                            <?php foreach ($output['cartInfo'] as $k => $v) { ?>
                                <li>
                                    <a target="_blank"
                                       href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>">
                                        <img style="width: auto;height: auto;max-width: 100%;max-height: 100%;"
                                             src="<?php echo $v['goods_image']; ?>">
                                        <p class="goods-title"><?php echo $v['goods_name']; ?></p>
                                        <span class="goods-price">￥<?php echo $v['goods_price']; ?></span></a>
                                </li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="checkout"> <!--<span class="total-price">共<i>0</i>种商品</span>--><a target="_blank"
                                                                                                  href="/shop/index.php?controller=cart&action=index"
                                                                                                  class="btn-cart">结算购物车中的商品</a>
                    </div>
                </dd>
            </dl>
        </div>
    </header>

</div>
<style>
    .public-nav-layout {
        background: linear-gradient(to right, #b229aa, #6b42e0);
    }
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if ($output['type'] == 'consumption_capital') {
                    echo ' class="current"';
                } ?> href="javascript:void(0);">服务中心</a></li>
            <li><a <?php if ($output['type'] == 'member') {
                    echo ' class="current"';
                } ?> href="/member/index.php?controller=help&action=help">消费者服务</a></li>
            <li><a <?php if ($output['type'] == 'store') {
                    echo ' class="current"';
                } ?> href="/member/index.php?controller=help_store&action=help">商家服务</a></li>

        </ul>
    </div>
</nav>

<style>
    blockquote,
    body,
    dd,
    div,
    dl,
    dt,
    fieldset,
    form,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    html,
    input,
    li,
    ol,
    p,
    pre,
    ul {
        padding: 0;
        margin: 0
    }

    address,
    caption,
    cite,
    code,
    em,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    pre,
    strong,
    table,
    td,
    th {
        font-size: 1em;
        font-style: normal;
        font-weight: 400
    }

    strong {
        font-weight: 700
    }

    ol,
    ul {
        list-style: none outside none
    }

    fieldset,
    img {
        border: medium none;
        vertical-align: middle
    }

    caption,
    th {
        text-align: left
    }

    table {
        border-collapse: collapse;
        border-spacing: 0
    }

    body {
        padding: 0px;
        font-size: 12px;
        line-height: 1.5em;
        font-family: tahoma, "Microsoft YaHei", Simsun, Mingliu, Arial, Helvetica;
        color: #333;
        background: #f6f6f6;
        width: 100%;
        min-width: 1200px;
    }

    input,
    select,
    textarea {
        font: 12px/20px Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif
    }

    cite,
    em,
    i {
        font-style: normal
    }

    button,
    input,
    select,
    textarea {
        outline: 0
    }

    html {
        min-height: 101%
    }

    a {
        color: #333;
        text-decoration: none;
        outline: medium none;
        transition: color .3s ease;
        -webkit-transition: color .3s ease;
        -moz-transition: color .3s ease;
        -ms-transition: color .3s ease;
        -o-transition: color .3s ease;
    }

    a:active,
    a:link,
    a:visited {
        text-decoration: none
    }

    a:hover {
        color: #C81623;
        text-decoration: none
    }

    .over_hidden {
        display: block;
        overflow-x: hidden;
        overflow-y: hidden;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .clearfix:after {
        clear: both;
        content: ".";
        display: block;
        height: 0;
        line-height: 0;
        visibility: hidden
    }

    html[xmlns] .clearfix {
        display: block
    }

    * html .clearfix {
        height: 1%
    }

    time {
        color: #777
    }

    article,
    aside,
    dialog,
    figure,
    footer,
    header,
    menu,
    nav,
    section {
        display: block
    }

    .banner {
        width: 100%;
        height: 480px;
        overflow: hidden;
    }

    .banner img {
        width: 100%;
        height: 100%;
    }

    .main {
        width: 1160px;
        margin: 0 auto;
        padding: 20px 20px 40px;
        overflow: hidden;
        zoom: 1;
    }

    .service-self-banner {
        width: 100%;
        height: 480px;
        background: url(./fixation/images/service_self/banner.png) no-repeat;
    }

    .service-self-banner::before {
        content: "";
        display: table;
    }

    .xiaomi {
        margin-top: 15px;
        margin-left: 80%;
    }

    .xiaomi a {
        display: inline-block;
        width: 93px;
        height: 35px;
        background-image: url(./fixation/images/service_self/xiaomi.png);
    }

    .xiaomi a:hover {
        background-position-y: -35px;
    }

    .smart {
        margin-left: 15px;
        background-position: 0 0;
    }

    .contact {
        background-position: -93px 0;
    }

    .service-self-nav .title em {
        display: inline-block;
        width: 31px;
        height: 28px;
        margin: 0 9px 3px 30px;
        vertical-align: middle;
        background: url(./fixation/images/service_self/service_self.png) no-repeat;
    }

    .service-self-nav {
        margin-top: 25px;
        height: 290px;
    }

    .service-self-nav .title {
        height: 55px;
        margin-bottom: 6px;
        line-height: 42px;
        font-size: 18px;
        letter-spacing: 1px;
        color: #fff;
        background: url(./fixation/images/service_self/aside_nav_01.png) no-repeat;
    }

    .self-tool {
        margin-top: 10px;
    }

    .service-self-nav li {
        height: 50px;
        margin-bottom: 3px;
        font-size: 17px;
        text-align: center;
        line-height: 50px;
        letter-spacing: 1px;
        background: url(./fixation/images/service_self/aside_nav_02.png) no-repeat;

    }

    .service-main {
        margin-left: 210px;
        background: #fff;
    }

    .service-layout {
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
    }

    .service-layout .title {
        height: 32px;
        margin-bottom: 15px;
        color: #9737df;
        font-size: 16px;
        line-height: 32px;
        font-weight: 700;
    }

    .service-layout .title em {
        display: inline-block;
        vertical-align: middle;
    }

    .problem .title em {
        margin-bottom: 3px;
        margin-right: 10px;
        width: 28px;
        height: 28px;
        background: url(./fixation/images/service_self/question.png) no-repeat;
    }

    .concern .title em {
        margin-right: 14px;
        margin-bottom: 8px;
        width: 24px;
        height: 21px;
        background: url(./fixation/images/service_self/concern.png) no-repeat;
    }

    .resolve .title em {
        display: inline-block;
        vertical-align: middle;
        margin-right: 17px;
        margin-bottom: 3px;
        width: 21px;
        height: 32px;
        background: url(./fixation/images/service_self/resolve.png) no-repeat;
    }

    .service-layout li {
        position: relative;
        float: left;
        width: 345px;
        height: 24px;
        padding-left: 10px;
        line-height: 24px;
        font-size: 14px;
    }

    .service-layout li a {
        color: #000;
    }

    .service-layout li a:hover {
        color: #9737df;
        text-decoration: underline;
    }

    .problem ul,
    .concern ul {
        padding-left: 38px;
        overflow: hidden;
    }

    .resolve ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .resolve {
        padding: 15px 20px;
    }

    .resolve .title {
        height: 32px;
        margin-bottom: 15px;
        color: #9737df;
        font-size: 16px;
        line-height: 32px;
        font-weight: 700;
    }

    .service-layout li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: #000;
    }

    .resolve li {
        width: 280px;
        height: 110px;
        margin-bottom: 10px;
        padding-left: 10px;
        padding-top: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .resolve li dt {
        height: 31px;
        line-height: 31px;
        padding-left: 40px;
        font-size: 16px;
        color: #000;
        background: url(./fixation/images/service_self/safe.png) no-repeat;
    }

    .resolve li dd {
        padding: 10px 40px;
    }

    .resolve a {
        color: #666;
    }


</style>
<div class="service-self-banner" style="background: url(<?php foreach($output['banner_a'] as $k=>$v){?><?php echo $v['img_url'];?><?php }?>)">
    <div class="xiaomi">
        <a class="smart" href=""></a>
        <a href="javascript:;" class="contact" id="chat_show_user"></a>
    </div>
</div>
<div class="main">
    <div class="aside-nav">
        <div class="subside-in">
                    <h3 class="h3-title">服务分类</h3>
                    <?php foreach ($output['sub_class_list'][0]['sub'] as $sk => $sv) { ?>
                        <dl class="subside-mod <?php if ($output['pid'] != 0) {
                            if ($output['pid'] == $sv['ac_id']) {
                                echo 'on';
                            }

                        } else {
                            if ($sk == 0) {
                                echo 'on';
                            }
                        } ?>">
                            <dt class="title">
                                <?php /*echo $sv['ac_name']; */?>
                                <a href="<?php echo urlMember('help', 'show_list', array('ac_id' => $sv['ac_id'])); ?>"><?php echo $sv['ac_name']; ?></a>
                                <b class="icon02"></b>
                            </dt>
                            <dd class="subside-cnt">
                                <ul class="subside-list">
                                    <?php foreach ($sv['sub'] as $kk => $vv) { ?>
                                        <li class="list-item">
                                            <a href="<?php echo urlMember('help', 'show_list', array('ac_id' => $vv['ac_id'])); ?>"><?php echo $vv['ac_name']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </dd>
                        </dl>
                    <?php } ?>
                </div>
                <div class="aside-banner">
                    <!--<a href=""><img src="./fixation/images/right_banner.png"></a>
                    <img src="./fixation/images/right_banner.png">-->
                    <?php foreach($output['ad_a'] as $k=>$v){?>
                        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                    <?php }?>
                </div>
        <div class="subside-in self-tool">
                    <h3 class="h3-title self-tool">自助工具</h3>
                    <?php foreach ($output['sub_class_list_a'][0]['sub'] as $sk => $sv) { ?>
                        <dl class="subside-mod">
                            <dt class="title">
                                <a href="<?php echo urlMember('help', 'show_list', array('ac_id' => $sv['ac_id'])); ?>"><?php echo $sv['ac_name']; ?></a>
                                <b class="icon02"></b>
                            </dt>
                            <dd class="subside-cnt">
                                <ul class="subside-list">
                                    <?php foreach ($sv['sub'] as $kk => $vv) { ?>
                                        <li class="list-item">
                                            <a href="<?php echo urlMember('help', 'show_list', array('ac_id' => $vv['ac_id'])); ?>"><?php echo $vv['ac_name']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </dd>
                        </dl>
                    <?php } ?>
                </div>
        <!-- <div class="service-self-nav" style="height:auto;">
            <h1 class="title"><em></em><span>自助工具</span></h1>
            <ul>
                <?php foreach($output['serverCates'] as $k=>$v){?>
                    <li><a href="/member/index.php?controller=help&action=show_list&ac_id=<?php echo $v['ac_id'];?>"><?php echo $v['ac_name']?></a></li>
                <?php }?>
            </ul>
        </div> -->
    </div>
    <div class="service-main">
        <div class="problem service-layout">
            <h1 class="title"><em></em>常见问题</h1>
            <ul>
                <?php foreach($output['cjwt'] as $k=>$v){?>
                    <li><a href="/member/index.php?controller=help&action=show&article_id=<?php echo $v['article_id'];?>"><?php echo $v['article_title']?></a></li>
                <?php }?>
            </ul>
        </div>
        <div class="concern service-layout">
            <h1 class="title"><em></em>重大关切</h1>
            <ul>
                <?php foreach($output['zdgq'] as $k=>$v){?>
                    <li><a href="/member/index.php?controller=help&action=show&article_id=<?php echo $v['article_id'];?>"><?php echo $v['article_title']?></a></li>
                <?php }?>
            </ul>
        </div>
        <div class="resolve">
            <h1 class="title"><em></em>问题索解</h1>
            <ul>
                <?php foreach($output['wtsj'] as $k=>$v){?>
                    <li>
                        <a href="/member/index.php?controller=help&action=show&article_id=<?php echo $v['article_id'];?>">
                            <dl>
                                <dt><?php echo $v['article_title']?></dt>
                                <dd><?php echo $v['article_content']?></dd>
                            </dl>
                        </a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".subside-mod .title").click(
            function () {
                $(this).parent(".subside-mod").toggleClass("on")
            })
    });
</script>
<div style="clear: both;"></div>
<div id="web_chat_dialog" style="display: none;float:right;">
</div>
<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>
<div class="wrapper" style="display:none">
    <div class="rg"></div>
</div>
<?php include template('layout/page_footer'); ?>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?62b53fc309b8cd01c3e66ca2715f7aac";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();


    $(function(){
        $(document).on("click","#chat_show_user",function(){
            chart.show();
        });
    });

</script>

<script>
     $(function() {
    var index = 0;
     $('.marquee-wrap ul li').first().clone().appendTo('.marquee-wrap ul');
    var toTop = 0;
    function marqueeIcon() {
      index++;
      if(index == 4) {
        index = 1;
        $(".marquee-wrap ul").css({top: '0'});
      }
      $(".marquee-wrap ul").stop().animate({top:-25*index+'px'},500);
    }
    var timer = setInterval(marqueeIcon,2000);
  })
</script>