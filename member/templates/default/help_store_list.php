<!DOCTYPE html>
<html lang="zh">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
    <title><?php echo $output['html_title']; ?></title>
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
    <link rel="stylesheet" href="/member/templates/default/css/new_service.css">
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

        <div class="quick-menu">
            <dl>
                <dt><a target="_blank"
                       href="<?php echo urlShop('show_joinin', 'index'); ?>"><span>商家中心</span></a><i></i></dt>
                <dd>
                    <ul>
                        <li><a target="_blank" href="<?php echo urlShop('show_joinin', 'index'); ?>"
                               title="招商入驻">招商入驻</a></li>
                        <li><a target="_blank" href="<?php echo urlMember('help_store', 'help'); ?>"
                               title="商家服务">商家服务</a></li>
                        <li><a target="_blank" href="<?php echo urlShop('dealers', 'index'); ?>" title="经销商申请">经销商申请</a>
                        </li>
                        <li><a target="_blank" href="<?php echo urlShop('seller_login', 'show_login'); ?>"
                               title="登录商家管理中心">商家登录</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a target="_blank"
                       href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order">我的订单</a><i></i></dt>
                <dd>
                    <ul>
                        <li>
                            <a target="_blank"
                               href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_new">待付款订单</a>
                        </li>
                        <li><a target="_blank"
                               href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_send">待确认收货</a>
                        </li>
                        <li><a target="_blank"
                               href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_noeval">待评价交易</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a target="_blank"
                       href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist">我的收藏</a><i></i>
                </dt>
                <dd>
                    <ul>
                        <li>
                            <a target="_blank"
                               href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist">商品收藏</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a target="_blank"
                       href="<?php echo urlMember('page', 'show', array('page_key' => 'service_centre')); ?>">服务中心</a><i></i>
                </dt>
            </dl>
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
        font: 12px/20px "Hiragino Sans GB", "Microsoft Yahei", arial, 宋体, "Helvetica Neue", Helvetica, STHeiTi, sans-serif;
        color: #333;
        background: #FFF none repeat scroll 0 0;
        min-width: 1200px
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

    /* 公用 */
    .hd-nav {
        width: 100%;
        height: 40px;
        line-height: 40px;
        background: #9737df;
    }

    .hd-nav-layout {
        width: 1200px;
        margin: 0 auto;
        overflow: hidden;
        zoom: 1;
    }

    .hd-nav-layout > li {
        float: left;
        position: relative;
    }

    .hd-nav-layout > li > a {
        display: block;
        padding: 0 25px;
        color: #fff;
        font-size: 16px;
    }

    .hd-nav-layout > li > a:hover {
        color: #e6c6ff;
    }

    .hd-nav-layout > li > a:hover::after {
        position: absolute;
        left: 50%;
        bottom: 0;
        content: "";
        margin-left: -8px;
        border: 8px solid transparent;
        border-bottom: 8px solid #fff;
    }

    .banner01 {
        width: 100%;
        height: 360px;
        overflow: hidden;
    }

    .banner01 img {
        width: 100%;
        height: 100%;
    }

    .business-container {
        background: #f5f5f5;
    }

    .business-wrap {
        width: 1200px;
        margin: 0 auto;
        padding: 20px 0;
        overflow: hidden;
    }

    .business-service {
        float: left;
        width: 991px;
    }

    .service-wrap {
        height: 150px;
        margin-bottom: 10px;
        border-radius: 15px 15px 15px 0;
        background: #fff;
    }

    .service-icon {
        float: left;
        width: 140px;
        line-height: 150px;
        border-right: 1px dashed #ddd;
        text-align: center;
    }

    .service-icon img {
        vertical-align: middle;
    }

    .service-tips,
    .service-problem {
        margin-left: 141px;
        font-family: "方正黑体简体";
    }

    .service-tips h1,
    .service-problem h1 {
        height: 30px;
        padding-top: 15px;
        line-height: 30px;
        font-size: 24px;
        color: #9737df;
        text-align: center;
    }

    .service-problem ul {
        overflow: hidden;
        max-height: 100px;
    }

    .service-problem li {
        box-sizing: border-box;
        float: left;
        width: 45%;
        height: 25px;
        line-height: 25px;
        padding: 0 20px;
        font-size: 15px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .service-problem li a:hover {
        color: #333;
        text-decoration: underline;
    }

    .service-tips h2 {
        font-size: 18px;
        height: 33px;
        line-height: 33px;
        text-align: center;
    }

    .service-tips em {
        display: block;
        margin-left: 20px;
        font-size: 14px;
        color: #999;
    }

    .service-tips .xiaomi {
        display: inline-block;
        height: 26px;
        padding: 0 10px;
        border: 1px solid #9737df;
        border-radius: 5px;
        margin-left: 20px;
        line-height: 26px;
        font-size: 14px;
    }

    .service-tips .tools {
        display: flex;
        padding-top: 15px;
        justify-content: space-evenly;
    }

    .service-tips li a {
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .service-tips .tools li {
        width: 68px;
        height: 68px;
        background: url(./fixation/images/tools.png) no-repeat;
    }

    .service-tips .tools li span {
        font-size: 18px;
        color: #9737df;
    }

    .service-tips li span {
        color: #333;
    }

    .service-tips .circle,
    .service-tips .news {
        display: flex;
        padding-top: 10px;
        justify-content: space-evenly;
    }

    .service-tips li {
        width: 81px;
        height: 78px;
    }

    .service-tips .circle li {
        background: url(./fixation/images/circle.png) no-repeat;
    }

    .service-tips .news li {
        background: url(./fixation/images/news.png) no-repeat;
    }

    .service-tips li span {
        font-size: 18px;
    }

    /* 订单信息管理 */
    .service-detail {
        float: left;
        width: 790px;
        height: 815px;
        margin-top: 20px;
        background: url(./fixation/images/detail_bg.png) no-repeat;
        overflow: hidden;
    }

    .service-detail form {
        position: relative;
    }

    .service-search {
        width: 440px;
        height: 42px;
        margin: 52px 0 20px 125px;
    }

    .service-search input {
        width: 366px;
        height: 38px;
        border: none;
        box-shadow: inset 0 0 2px 2px rgba(131, 122, 115, .8);
        border-radius: 10px;
        padding: 0 50px 0 20px;
        line-height: 38px;
        font-size: 16px;
        color: #999;
    }

    .service-search button {
        position: absolute;
        top: 0;
        right: 0;
        width: 50px;
        height: 38px;
        padding: 0;
        cursor: pointer;
        border: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        outline: 0;
        background: url(./fixation/images/search.png) center center no-repeat;
        background-size: 22px 22px;
    }

    .service-answer h2 {
        height: 38px;
        margin: 10px 40px;
        border-bottom: 1px solid #ddd;
        line-height: 38px;
        font-size: 16px;
        color: #333;
    }

    .service-answer span {
        margin: 0 3px;
    }

    .service-answer ul {
        padding: 0 20px;
        overflow: hidden;
    }

    .service-answer li {
        box-sizing: border-box;
        float: left;
        /*width: 375px;*/
        height: 190px;
        margin-bottom: 20px;
        padding: 20px 40px 0 40px;
    }

    .service-answer li:nth-child(2n+1) {
        border-right: 2px solid rgba(151, 55, 223, .2);
    }

    .service-answer li:nth-child(2),
    .service-answer li:nth-child(3),
    .service-answer li:nth-child(6) {
        border-bottom: 2px solid rgba(151, 55, 223, .2)
    }

    .service-answer h3 {
        position: relative;
        padding-left: 60px;
        font-size: 16px;
        color: #9737df;
    }

    .service-answer h3 i {
        position: absolute;
        left: 2px;
        top: -6px;
        width: 60px;
        height: 83px;
        font-size: 38px;
        color: #9737df;
        background: url(./fixation/images/answer_bg.png) no-repeat;
    }

    .service-answer li p {
        max-height: 108px;
        margin-top: 20px;
        padding-left: 25px;
        padding-right: 20px;
        text-indent: 1.5em;
        font-size: 14px;
        overflow: hidden;
    }


</style>
<!-- <div class="hd-nav">
    <ul class="hd-nav-layout">
        <li><a href="">首页</a></li>
        <li><a href="">生产者服务中心</a></li>
        <li><a href="">商家服务</a></li>
    </ul>
</div> -->
<link href="/shop/templates/default/css/service_index.css" rel="stylesheet" type="text/css">
<div class="banner01">
    <!--<img src="./fixation/images/banner-01-index.png">-->
    <?php foreach($output['banner_b'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
    <?php }?>
</div>
<div class="business-container">
    <div class="business-wrap">
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
                            <a href="<?php echo urlMember('help_store', 'show_list', array('ac_id' => $sv['ac_id'])); ?>"><?php echo $sv['ac_name']; ?></a>
                            <b class="icon02"></b>
                        </dt>
                        <dd class="subside-cnt">
                            <ul class="subside-list">
                                <?php foreach ($sv['sub'] as $kk => $vv) { ?>
                                    <li class="list-item">
                                        <a href="<?php echo urlMember('help_store', 'show_list', array('ac_id' => $vv['ac_id'])); ?>"><?php echo $vv['ac_name']; ?></a>
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
                <?php foreach($output['ad_b'] as $k=>$v){?>
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                <?php }?>
            </div>
        </div>
        <?php /*echo html_entity_decode($output['default_page']['page_content']); */?>
        <div class="business-service">
            <div class="service-wrap clearfix">
                <div class="service-icon">
                    <a href="">
                        <img src="/member/templates/default/images/service_05.png">
                    </a>
                </div>
                <div class="service-problem">
                    <h1>常见问题</h1>
                    <ul>
                        <?php foreach ($output['article_common'] as $sk => $sv) { ?>
                            <li>
                                <a href="<?php echo urlMember('help_store', 'show', array('article_id' => $sv['article_id'])); ?>"><?php echo $sv['article_title']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="service-wrap clearfix">
                <div class="service-icon">
                    <a href="">
                        <img src="/member/templates/default/images/service_01.png">
                    </a>
                </div>
                <div class="service-tips">
                    <h1>海吉小蜜</h1>
                    <h2>智能客服助理</h2>
                    <em>智能助理·小蜜</em>
                    <p class="xiaomi">亲爱滴，我是
                        <a href="">【智能客服】</a>助理小蜜，非常开心能为您服务~</p>
                </div>

            </div>
            <div class="service-wrap clearfix">
                <div class="service-icon">
                    <a href="">
                        <img src="/member/templates/default/images/service_02.png">
                    </a>
                </div>
                <div class="service-tips">
                    <h1>自助工具</h1>
                    <ul class="tools">
                        <li>
                            <a href="">
                                <span>账户</span>
                                <span>专区</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>入驻</span>
                                <span>专区</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>消保</span>
                                <span>专区</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>规则</span>
                                <span>处罚</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="service-wrap clearfix">
                <div class="service-icon">
                    <a href="">
                        <img src="/member/templates/default/images/service_03.png">
                    </a>
                </div>
                <div class="service-tips">
                    <h1>海吉商圈</h1>
                    <ul class="circle">
                        <li>
                            <a href="">
                                <span>三者</span>
                                <span>同盟会</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>商圈</span>
                                <span>APP</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>入驻</span>
                                <span>商圈</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="service-wrap clearfix">
                <div class="service-icon">
                    <a href="">
                        <img src="/member/templates/default/images/service_04.png">
                    </a>
                </div>
                <div class="service-tips">
                    <h1>最新公告</h1>
                    <ul class="news">
                        <li>
                            <a href="">
                                <span>最新</span>
                                <span>公告</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span>商圈</span>
                                <span>论坛</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".subside-mod .icon02").click(
            function () {
                $(this).parent(".subside-mod").toggleClass("on")
            })
    });
</script>
<script>
    window.onload = function () {
        $('.ke-toolbar').remove();

    }
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