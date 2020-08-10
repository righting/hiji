
<!DOCTYPE html>
<html  lang="zh">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
    <title><?php echo $output['html_title'];?></title>
    <meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
    <meta name="description" content="<?php echo $output['seo_description']; ?>" />
    <meta name="author" content="CCYNet">
    <meta name="copyright" content="CCYNet Inc. All Rights Reserved">
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <?php echo html_entity_decode($output['setting_config']['qq_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['sina_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_qqzone_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_sinaweibo_appcode'],ENT_QUOTES); ?>
    <style type="text/css">
        body {
            _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
        }

        .fixed-box {
            display: block;
            position: fixed;
            z-index: 999;
        }
        </style>
<link rel="stylesheet" href="/shop/templates/default/css/new_base.css" type="text/css" />

<link rel="stylesheet" href="/shop/templates/default/css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="/shop/templates/default/css/personal.css" type="text/css" />

<link href="/jf/templates/default/css/base.css" rel="stylesheet" type="text/css">
<link href="/jf/templates/default/css/header.css" rel="stylesheet" type="text/css">
<link href="/shop/templates/default/css/css/personal.css" rel="stylesheet" type="text/css">
<link href="/member/templates/default/css/new_service.css" rel="stylesheet" type="text/css">

<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var LOGIN_SITE_URL = '<?php echo LOGIN_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script>
        $(function(){

            $(".head-user-menu dl").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });

            $(".quick-menu dl").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });
            $(".site-menu .links_a").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });

            $(".site-menu .links_a").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
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
            <a href="/"><img src="/ngyp/templates/default/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a>
            <a href="/">
            <?php if($output['page']['page_type']==1){?>
                <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/ngyp_logo.jpg" class="pngFix">
            <?php }else if($output['page']['page_type']==2){?>
                <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/consumption_logo.png" class="pngFix">
            <?php }else if($output['page']['page_type']==3){?>
                <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/offline_logo.png" class="pngFix">
            <?php }else if($output['page']['page_type']==4){?>
                <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/share_logo.png" class="pngFix">
            <?php }else if($output['page']['page_type']==5){?>
                <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/memb_logo.png" class="pngFix">
            <?php }else {?>

            <?php }?>
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
                <input name="keyword" id="keyword" type="text" class="input-text" value="" maxlength="60" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入商品关键词" x-webkit-grammar="builtin:search" />
                <input type="submit" id="button" value="搜索" class="input-submit">
            </form>

                <div class="keyword">热门搜索：
                    <ul>
                        <?php foreach($output['setInfo'] as $k=>$v){?>
                            <li><a target="_blank" href="/shop/index.php?controller=search&action=index&keyword=<?php echo $v;?>"><?php echo $v;?></a></li>
                        <?php }?>
                    </ul>
                </div>

        </div>
        <div class="head-user-menu">
            <dl class="my-mall">
                <dt><span class="ico"></span>我的商城<i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4></h4>
                        <a target="_blank" href="/shop/index.php?controller=member&action=home" class="arrow">我的用户中心<i></i></a></div>
                    <div class="user-centent-menu">
                        <ul>
                            <li><a target="_blank" href="/member/index.php?controller=member_message&action=message">站内消息</a></li>
                            <li><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order" class="arrow">我的订单<i></i></a></li>
                            <!-- <li><a href="">咨询回复(<span id="member_consult">0</span>)</a></li>-->
                            <li><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist" class="arrow">我的收藏<i></i></a></li>
                            <!--<li><a href="">代金券(<span id="member_voucher">0</span>)</a></li>-->
                            <li><a  target="_blank" href="/member/index.php?controller=member_points&action=index" class="arrow">我的积分<i></i></a></li>
                        </ul>
                    </div>
                    <?php if(!empty($output['goodsBrowseInfo']) && is_array($output['goodsBrowseInfo'])){?>
                        <div class="browse-history">
                            <div class="part-title">
                                <h4>最近浏览的商品</h4>
                            </div>
                            <ul>
                                <?php foreach($output['goodsBrowseInfo'] as $k=>$v){?>
                                    <li>
                                        <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                            <img style="width: auto;height: auto;max-width: 100%;max-height: 100%;" src="<?php echo $v['goods_image']?>">
                                            <p class="goods-title"><?php echo $v['goods_name'];?></p>
                                            <span class="goods-price">￥<?php echo $v['goods_price'];?></span>
                                        </a>
                                    </li>
                                <?php }?>
                                <!--<li class="no-goods"><img class="loading" src="<?php /*echo jf_TEMPLATES_URL;*/?>/images/loading.gif" /></li>-->
                            </ul>
                        </div>
                    <?php }?>
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
                            <?php foreach($output['cartInfo'] as $k=>$v){?>
                                <li>
                                    <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                        <img style="width: auto;height: auto;max-width: 100%;max-height: 100%;" src="<?php echo $v['goods_image'];?>">
                                        <p class="goods-title"><?php echo $v['goods_name'];?></p>
                                        <span class="goods-price">￥<?php echo $v['goods_price'];?></span></a>
                                </li>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="checkout"> <!--<span class="total-price">共<i>0</i>种商品</span>--><a target="_blank" href="/shop/index.php?controller=cart&action=index" class="btn-cart">结算购物车中的商品</a> </div>
                </dd>
            </dl>
        </div>
    </header>

</div>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if($output['type']=='consumption_capital'){ echo ' class="current"'; }?>  href="javascript:void(0);">服务中心</a></li>
            <li><a <?php if($output['type']=='member'){ echo ' class="current"'; }?>  href="/member/index.php?controller=help&action=help">消费者服务</a></li>
            <li><a <?php if($output['type']=='store'){ echo ' class="current"'; }?>  href="/member/index.php?controller=help_store&action=help">商家服务</a></li>

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

*html .clearfix {
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
    width: 1200px;
    margin: 0 auto;
    padding: 20px 0 40px;
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
    margin-left: 205px;
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

.business-service {
    float: right;
    overflow: hidden;
}

.service-detail {
    float: right;
    width: 990px;
    height: 795px;
    background: url(./fixation/images/backdrop.png) no-repeat;
    overflow: hidden;
}

.service-detail form {
    position: relative;
}

.service-search {
        width: 440px;
        height: 42px;
        margin: 67px 0 19px 483px;
}

.service-search input {
    width: 366px;
    height: 38px;
    border: none;
    box-shadow: inset 0 0 2px 2px rgba(131,122,115,.8);
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

.service-answer {
    margin-left: 32px;
    width: 900px;
    overflow: hidden;
}


.service-answer ul {
    width: 850px;
    margin: 0 auto;
    overflow: hidden;
    margin-top: 10px;
}

.service-answer li>a {
    display:block;
    width:90%;
    float:left;
}

.service-answer li>span {
    display:block;
    width:10%;
    font-size:12px;
    float:right;
    color:#999;
}

.service-answer li p {
    /*max-height: 108px;*/
    margin-top: 20px;
    padding-left: 25px;
    padding-right: 20px;
    text-indent: 1.5em;
    font-size: 14px;
    overflow: hidden;
}

.service-a {
    width: 850px;
    height: 38px;
    line-height: 38px;
    font-size: 14px;
    color: #000;
    margin: 0 auto;
    font-weight: bold;
}

.service-answer h3 {
    text-align: center;
    position: relative;
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

.service-answer li {
    box-sizing: border-box;
    float: left;
    margin-bottom: 20px;
    padding: 20px 0px 0 27px;
    overflow-y: scroll;
    height: 549px;
    width: 100%;
}

.service-answer li p {
    /*max-height: 108px;*/
    margin-top: 20px;
    /* padding-left: 25px; */
    padding-right: 20px;
    text-indent: 1.5em;
    font-size: 14px;
    overflow: hidden;
}

</style>
<div class="service-self-banner" style="background: url(<?php foreach($output['banner_a'] as $k=>$v){?><?php echo $v['img_url'];?><?php }?>)">
        <div class="xiaomi">
            <a class="smart" href=""></a>
            <a class="contact" href=""></a>
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
            <div class="subside-in">
                <h3 class="h3-title self-tool">自助工具</h3>
                <?php foreach ($output['sub_class_list_a'][0]['sub'] as $sk => $sv) { ?>
                    <dl class="subside-mod">
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
        </div>
        <!-- <div class="aside-nav">
            <div class="service-sort-nav">
                <h1 class="title"><em></em><span>服务分类</span></h1>
                <ul>
                    <li><a href="">消费者权益保护</a></li>
                    <li><a href="">投诉卖家行为</a></li>
                    <li><a href="">投诉商品问题</a></li>
                    <li><a href="">投诉会员违规</a></li>
                    <li><a href="">提请建议方案</a></li>
                    <li><a href="">社交消费专区</a></li>
                </ul>
            </div>
            <div class="service-self-nav">
                <h1 class="title"><em></em><span>自助工具</span></h1>
                <ul>
                    <li><a href="">换绑支付</a></li>
                    <li><a href="">修改账号绑定</a></li>
                </ul>
            </div>
        </div> -->
        <!-- <div class="service-main">
            <div class="problem service-layout">
                <h3><?php echo $output['article']['article_title'];?></h3>
                <p><?php echo $output['article']['article_content'];?></p>
            </div>
             <div class="concern service-layout">
                <h1 class="title"><em></em>重大关切</h1>
                <ul>
                    <li><a href="">如何申请退款？</a></li>
                    <li><a href="">付款不成功，怎么办？</a></li>
                    <li><a href="">交易成功后，我的钱还可以退回来吗？</a></li>
                    <li><a href="">退款或售后成功，为什么没有收到退款？</a></li>
                    <li><a href="">为什么银行已扣款，但交易仍显示等待付款？</a></li>
                    <li><a href="">卖家让我修改退款原因，怎么办？</a></li>
                </ul>
            </div> -->
            <!-- <div class="resolve">
                <h1 class="title"><em></em>问题索解</h1>
                <ul>
                    <li>
                        <a href="">
                            <dl>
                                <dt>账号与安全</dt>
                                <dd>账号注册、账号安全、忘记密码、手机/邮箱/个人资料修改、账号无法登陆、提现、会员体系</dd>
                            </dl>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <dl>
                                <dt>购买指南</dt>
                                <dd>商品挑选/购买、订单管理、确认收货、会员购买提醒、退货运费险、商品评价</dd>
                            </dl>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <dl>
                                <dt>发货物流</dt>
                                <dd>物流查询、物流服务、卖家发货、物件损坏与丢失、验货与签收、问题商品反馈</dd>
                            </dl>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <dl>
                                <dt>付款与退款</dt>
                                <dd>付款方式、付款不成功、极速退款、退款去向、发票凭证</dd>
                            </dl>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <dl>
                                <dt>售后服务</dt>
                                <dd>没有收到商品、收到商品有问题、退/换/修、消费维权、投诉</dd>
                            </dl>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <dl>
                                <dt>会员身份等级</dt>
                                <dd>会员个人身份等级、升级与消费、个人团队身份等级、职级晋升、身份等级与消费分红</dd>
                            </dl>
                        </a>
                    </li>
                </ul>
            </div>
        </div> -->
        <div class="business-service">
            <div class="service-detail">
                <div class="service-search">
                    <form action="member/index.php?controller=help_store&action=show_list">
                        <input type="text" name='keyword' placeholder="请用一句话描述您的问题，如：如何入驻平台？">
                        <button></button>
                    </form>
                </div>

                <div class="service-answer">
                    <!--<p class="service-a">
                        <span>全部</span>&gt;<span>常见问题</span>&gt;<span><?php /*echo $output['article']['article_title'];*/?></span>
                    </p>-->
                    <p class="service-a">
                        <span>全部</span>&gt;<span>服务分类</span>
                        <?php if(!empty($output['_ac_parent_name'])){?>
                            &gt;<span><?php echo $output['_ac_parent_name'];?></span>
                        <?php }?>
                        <?php if(!empty($output['_ac_name'])){?>
                            &gt;<span><?php echo $output['_ac_name'];?></span>
                        <?php }?>
                        <?php if(!empty($output['article']['article_title'])){?>
                            &gt;<span><?php echo $output['article']['article_title'];?></span>
                        <?php }?>
                    </p>
                    <div style="height:1px;background-color:#9999994d;"></div>

                    <ul>

                        <li>
                            <h3><?php echo $output['article']['article_title'];?></h3>
                            <p><?php echo $output['article']['article_content'];?></p>
                        </li>

                    </ul>


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