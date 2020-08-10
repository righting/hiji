<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<!doctype html>
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
            _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
        }

        .fixed-box {
            display: block;
            position: fixed;
            z-index: 999;
        }
    </style>
    <!--<link href="<?php /*echo SHOP_TEMPLATES_URL; */?>/ht_resource/css/new_base.css" rel="stylesheet" type="text/css">-->
<!--    <link href="<?php /*echo SHOP_TEMPLATES_URL; */?>/ht_resource/css/home_header.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/new_index.css" rel="stylesheet" type="text/css">
    <!--内容页样式-->
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/instructions_resource/css/capital.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_RESOURCE_SITE_URL; ?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>


    <link href="<?php echo jf_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/header.css" rel="stylesheet" type="text/css">



    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
    <![endif]-->
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
    <script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>
    <script type="text/javascript">
        var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
        $(function () {


            //首页左侧分类菜单
            $(".category ul.menu").find("li").each(
                function () {
                    $(this).hover(
                        function () {
                            var cat_id = $(this).attr("cat_id");
                            var menu = $(this).find("div[cat_menu_id='" + cat_id + "']");
                            menu.show();
                            $(this).addClass("hover");
                            var menu_height = menu.height();
                            if (menu_height < 60) menu.height(80);
                            menu_height = menu.height();
                            var li_top = $(this).position().top;
                            $(menu).css("top", -li_top + 47);
                        },
                        function () {
                            $(this).removeClass("hover");
                            var cat_id = $(this).attr("cat_id");
                            $(this).find("div[cat_menu_id='" + cat_id + "']").hide();
                        }
                    );
                }
            );
            $(".mod_minicart").hover(function () {
                    $("#nofollow,#minicart_list").addClass("on");
                },
                function () {
                    $("#nofollow,#minicart_list").removeClass("on");
                });
            $('.mod_minicart').mouseover(function () {// 运行加载购物车
                load_cart_information();
                $(this).unbind('mouseover');
            });
            <?php if (C('fullindexer.open')) { ?>
            // input ajax tips
            $('#keyword').focus(function () {
                if ($(this).val() == $(this).attr('title')) {
                    $(this).val('').removeClass('tips');
                }
            }).blur(function () {
                if ($(this).val() == '' || $(this).val() == $(this).attr('title')) {
                    $(this).addClass('tips').val($(this).attr('title'));
                }
            }).blur().autocomplete({
                source: function (request, response) {
                    $.getJSON('<?php echo SHOP_SITE_URL;?>/index.php?controller=search&action=auto_complete', request, function (data, status, xhr) {
                        $('#top_search_box > ul').unwrap();
                        response(data);
                        if (status == 'success') {
                            $('body > ul:last').wrap("<div id='top_search_box'></div>").css({
                                'zIndex': '1000',
                                'width': '362px'
                            });
                        }
                    });
                },
                select: function (ev, ui) {
                    $('#keyword').val(ui.item.label);
                    $('#top_search_form').submit();
                }
            });
            <?php } ?>

            $('#button').click(function () {
                if ($('#keyword').val() == '') {
                    if ($('#keyword').attr('data-value') == '') {
                        return false
                    } else {
                        window.location.href = "<?php echo SHOP_SITE_URL?>/index.php?controller=search&action=index&keyword=" + $('#keyword').attr('data-value');
                        return false;
                    }
                }else {
                    window.location.href = "<?php echo SHOP_SITE_URL?>/index.php?controller=search&action=index&keyword=" + $("#keyword").val();
                    return false;
                }
            });
            $(".head-search-bar").hover(null,
                function () {
                    $('#search-tip').hide();
                });
            // input ajax tips
            $('#keyword').focus(function () {
                $('#search-tip').show()
            }).autocomplete({
                //minLength:0,
                source: function (request, response) {
                    $.getJSON('<?php echo SHOP_SITE_URL;?>/index.php?controller=search&action=auto_complete', request, function (data, status, xhr) {
                        $('#top_search_box > ul').unwrap();
                        response(data);
                        if (status == 'success') {
                            $('#search-tip').hide();
                            $(".head-search-bar").unbind('mouseover');
                            $('body > ul:last').wrap("<div id='top_search_box'></div>").css({
                                'zIndex': '1000',
                                'width': '362px'
                            });
                        }
                    });
                },
                select: function (ev, ui) {
                    $('#keyword').val(ui.item.label);
                    $('#top_search_form').submit();
                }
            });
            $('#search-his-del').on('click', function () {
                $.cookie('<?php echo C('cookie_pre')?>his_sh', null, {path: '/'});
                $('#search-his-list').empty();
            });


            $(".head-user-menu dl").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });

        });
    </script>
    <style>
        body{
            padding: 0;
            margin: 0;
        }

        #fixed-box{
            display: block;
            width: 100%;
        }
        .header_fixed {
            position: fixed;
            top: 0;
            z-index: 295;
            background-color: #FFF
        }
    </style>
</head>
<body>


<!-- PublicTopLayout Begin -->
<?php require_once template('layout/new_layout_top'); ?>







<style>

    .keyword ul {
        width: 436px;
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
</style>

<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry">
            您好<?php if($_SESSION['is_login']==1){?> <?php echo $_SESSION['member_nickname']?> <span class="user-class"><?php echo $output['levelInfo']['level_name']?><?php }?></span>，欢迎来到      <a href="/" title="首页" alt="首页">海吉壹佰</a>
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
                <dt><a target="_blank" href="<?php echo urlShop('show_joinin', 'index'); ?>"><span class="orange">商家中心</span></a><i></i></dt>
                <dd>
                    <ul>
                        <li><a target="_blank" href="<?php echo urlShop('show_joinin', 'index'); ?>" title="招商入驻">招商入驻</a></li>
                        <li><a target="_blank" href="<?php echo urlMember('help_store', 'help'); ?>" title="商家服务">商家服务</a></li>
                        <li><a target="_blank" href="<?php echo urlShop('dealers', 'index'); ?>" title="经销商申请">经销商申请</a></li>
                        <li><a target="_blank" href="<?php echo urlShop('seller_login', 'show_login'); ?>"  title="登录商家管理中心">商家登录</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order">我的订单</a><i></i></dt>
                <dd>
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_new">待付款订单</a>
                        </li>
                        <li><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_send">待确认收货</a>
                        </li>
                        <li><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_noeval">待评价交易</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist">我的收藏</a><i></i></dt>
                <dd>
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist">商品收藏</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a target="_blank" href="/member/member/index.php?controller=page&action=show&page_key=service_store">服务中心</a>
                    <!--<i></i>-->
                </dt>
               <!-- <dt>客户服务<i></i></dt>
                <dd>
                    <ul>
                        <li><a target="_blank" href="<?php /*echo urlMember('help', 'help'); */?>">帮助中心</a></li>
                        <li><a target="_blank" href="<?php /*echo urlMember('article', 'article', array('ac_id' => 5)); */?>">售后服务</a></li>
                        <li><a target="_blank" href="<?php /*echo urlMember('article', 'article', array('ac_id' => 6)); */?>">客服中心</a></li>
                    </ul>
                </dd>-->
            </dl>
            <!-- <dl>
                 <dt>站点导航<i></i></dt>
                 <dd>
                     <ul>
                         <li><a href="">网站地图</a></li>
                     </ul>
                 </dd>
             </dl>-->
        </div>
    </div>
</div>


<div class="header-wrap">
    <header class="public-head-layout wrapper">
        <h1 class="site-logo">
            <a href="/" target="_blank">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a>
        </h1>
        <div class="head-search-bar">
            <form action="<?php echo SHOP_SITE_URL; ?>" method="get" class="search-form" target="_blank">
                <input name="controller" id="search_act" value="search" type="hidden">
                <input name="keyword" id="keyword" type="text" class="input-text" value="" maxlength="60" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入商品关键词" x-webkit-grammar="builtin:search" />
                <input type="submit" id="button" value="搜索" class="input-submit">
            </form>
            <?php if(!empty($output['setInfo'])){?>
                <div class="keyword">热门搜索：
                    <ul>
                        <?php foreach($output['setInfo'] as $k=>$v){?>
                            <li><a target="_blank" href="/shop/index.php?controller=search&action=index&keyword=<?php echo $v;?>"><?php echo $v;?></a></li>
                        <?php }?>
                    </ul>
                </div>
            <?php }?>
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

        <!--<div id="hotConAd">
            <div class="conbox">
                <ul id="conlist">
                    <?php /*if (is_array($output['show_article']) && !empty($output['show_article'])) { */?>
                        <?php /*foreach ($output['show_article'] as $k => $article_class) { */?>
                            <?php /*if (!empty($article_class)) { */?>
                                <?php /*foreach ($article_class['list'] as $article) { */?>
                                    <li><i></i>
                                        <a href="<?php /*if ($article['article_url'] != '') echo $article['article_url']; else echo urlMember('article', 'show', array('article_id' => $article['article_id'])); */?>" title="<?php /*echo $article['article_title']; */?>"> <?php /*echo $article['article_title']; */?> </a>
                                    </li>
                                <?php /*}
                            } */?>
                        <?php /*}
                    } */?>
                </ul>
                <ul id="conscroll"></ul>
            </div>
        </div>-->

    </header>

</div>











<script>
    $(window).scroll(function() {
        if ( $(window).scrollTop()>0 ) {
            $('#fixed-box').addClass('header_fixed');
            $('#gotop').css("opacity",1);
        } else {
            $('#fixed-box').removeClass('header_fixed');
            $('#gotop').css("opacity",0.5);
        }
    });
</script>

