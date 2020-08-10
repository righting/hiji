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
            _behavior: url(<?php echo SHOP_TEMPLATES_URL;?>/css/csshover.htc);
        }

        .fixed-box {
            display: block;
            position: fixed;
            z-index: 999;
        }
    </style>
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/new_base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/new_index.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_RESOURCE_SITE_URL; ?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

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
    <script src="<?php echo RESOURCE_SITE_URL; ?>/layer/layer.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/kefu-tool.js"></script>
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
                            $(menu).css("top", -li_top + 38);
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
        }
    </style>
    <style>
        .wico .qq:hover {
            background-position: 0px -36px;
        }

        .wico .qq {
            background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/ws_ico.png) no-repeat 0 0px;
            display: block;
            float: left;
            height: 35px;
            overflow: hidden;
            width: 35px;
            cursor: pointer;
        }

        .wico .weixin:hover {
            background-position: -73px -36px;
        }

        .wico .weixin {
            background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/ws_ico.png) no-repeat -73px 0px;
            display: block;
            float: left;
            height: 35px;
            overflow: hidden;
            width: 35px;
            cursor: pointer;
        }

        .wico .mobile:hover {
            background-position: -36px -36px;
        }

        .wico .mobile {
            background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/ws_ico.png) no-repeat -36px 0px;
            display: block;
            float: left;
            height: 35px;
            overflow: hidden;
            width: 35px;
            cursor: pointer;
        }
    </style>
</head>
<body>


<!-- PublicTopLayout Begin -->
<?php require_once template('layout/layout_top'); ?>


<span id="fixed-box">
<!-- PublicHeadLayout Begin -->
<div class="header-wrap">
    <header class="public-head-layout wrapper">
        <h1 class="site-logo"><a href="<?php echo BASE_SITE_URL; ?>"><img
                        src="<?php echo UPLOAD_SITE_URL . DS . ATTACH_COMMON . DS . $output['setting_config']['site_logo']; ?>"
                        class="pngFix"></a>
                        <div class="marquee-wrap">
                            <div class="marquee-pad">
                                <div class="marquee-con">
                                    <ul class="marquee-icon">
                                        <li>购分红，购赚钱</li>
                                        <li>拼实惠，赚红利</li>
                                        <li>不只是好产品</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </h1>
<!--        <div class="top-ht"><img src="/data/upload/shop/common/top_ht.png"></div>-->
        <div class="head-search-layout">
            <div class="head-search-bar" id="head-search-bar">
                <div class="hd_serach_tab" id="hdSearchTab">
                    <ul>
                        <li act="search" class="current"><span>商品</span><i class="arrow"></i></li>
                    </ul>
                    <i></i>

                </div>

                <form action="<?php echo SHOP_SITE_URL; ?>" method="get" class="search-form" id="top_search_form">
                    <input name="controller" id="search_act" value="search" type="hidden">
                    <?php
                    if ($_GET['keyword']) {
                        $keyword = stripslashes($_GET['keyword']);
                    } elseif ($output['rec_search_list']) {
                        $_stmp = $output['rec_search_list'][array_rand($output['rec_search_list'])];
                        $keyword_name = $_stmp['name'];
                        $keyword_value = $_stmp['value'];
                    } else {
                        $keyword = '';
                    }
                    ?>
                    <input name="keyword" id="keyword" type="text" class="input-text" value="<?php echo $keyword; ?>"
                           maxlength="60" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()"
                           placeholder="<?php echo $keyword_name ? $keyword_name : '请输入您要搜索的商品关键字'; ?>"
                           data-value="<?php echo rawurlencode($keyword_value); ?>" x-webkit-grammar="builtin:search"
                           autocomplete="off"/>
                    <input type="submit" id="button" value="<?php echo $lang['nc_common_search']; ?>"
                           class="input-submit">
                </form>
                <div class="search-tip" id="search-tip">
                    <div class="search-history">
                        <div class="title">历史纪录<a href="javascript:void(0);" id="search-his-del">清除</a></div>
                        <ul id="search-his-list">
                            <?php if (is_array($output['his_search_list']) && !empty($output['his_search_list'])) { ?>
                                <?php foreach ($output['his_search_list'] as $v) { ?>
                                    <li>
                                        <a href="<?php echo urlShop('search', 'index', array('keyword' => $v)); ?>"><?php echo $v ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="search-hot">
                        <div class="title">热门搜索...</div>
                        <ul>
                            <?php if (is_array($output['rec_search_list']) && !empty($output['rec_search_list'])) { ?>
                                <?php foreach ($output['rec_search_list'] as $v) { ?>
                                    <li>
                                        <a href="<?php echo urlShop('search', 'index', array('keyword' => $v['value'])); ?>"><?php echo $v['value'] ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="keyword">
                <ul>
                    <?php if (is_array($output['hot_search']) && !empty($output['hot_search'])) {
                        foreach ($output['hot_search'] as $val) { ?>
                            <li>
                                <a href="<?php echo urlShop('search', 'index', array('keyword' => $val)); ?>"><?php echo $val; ?></a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="mod_minicart" style="display: none">
            <a id="nofollow" target="_self" href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=cart"
               class="mini_cart_btn">
                <i class="cart_icon"></i>
                <em class="cart_num"><?php echo $output['cart_goods_num']; ?></em>
                <span>购物车</span>
            </a>
            <div id="minicart_list" class="minicart_list">
                <div class="spacer"></div>
                <div class="list_detail">
                    <!--购物车有商品时begin-->
                    <ul><img class="loading" src="<?php echo SHOP_TEMPLATES_URL; ?>/images/loading.gif"/></ul>
                    <div class="checkout_box">
                        <p class="fl">共<em class="tNum"><?php echo $output['cart_goods_num']; ?></em>件商品,合计：<em
                                    class="tSum">0</em></p>
                        <a rel="nofollow" class="checkout_btn"
                           href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=cart" target="_self"> 去结算 </a>
                    </div>
                    <div style="" class="none_tips">
                        <i> </i>
                        <p>购物车中没有商品，赶紧去选购！</p>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($output['w_user']) { ?>
            <div class="wico" style="width: 178px; position: relative;float: right;margin-top: 25px">
                <div style="border-radius: 45px ;height: 60px;width: 60px;float: left">
                    <img style="border-radius: 45px ;width: 100%"
                         src="<?php echo empty($output['w_user']['member_avatar']) ? '/data/upload/shop/common/default_user_portrait.gif' : $output['w_user']['member_avatar'] ?>">
                </div>
                <div style="float: right;margin-left: 5px">
                    <p style="width: 110px;font:italic bold 14px/20px arial,sans-serif;color: #9737df"><?php echo $output['w_user']['wd_name'] ? $output['w_user']['wd_name'] : $output['w_user']['member_name']; ?>
                        的小店</p>
                    <div>
                        <a class="qq"
                           onclick="javascript:showDialog('请加QQ号:<?php echo $output['w_user']['member_qq'] ?>', 'succ', '', '', '', '', '', '', '', '', 0);;"></a>
                        <a class="mobile"
                           onclick="javascript:showDialog('请拨打手机号:<?php echo $output['w_user']['member_mobile'] ?>', 'succ', '', '', '', '', '', '', '', '', 0);;"></a>
                        <a class="weixin"
                           onclick="javascript:showDialog('请加WeiXin号:<?php echo $output['w_user']['member_weixin'] ?>', 'succ', '', '', '', '', '', '', '', '', 0);;"></a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </header>
</div>
<!-- PublicHeadLayout End -->

<!-- publicNavLayout Begin -->
    <?php $ht_style = "style=background:url(".SHOP_TEMPLATES_URL."/images/nav_bg.png)" ?>
<nav class="public-nav-layout <?php if ($output['channel']) {
    echo 'channel-' . $output['channel']['channel_style'] . ' channel-' . $output['channel']['channel_id'];
} ?>" <?php if($output['action'] == 'ht') {echo $ht_style;}?>>
    <div class="wrapper">
        <div class="all-category" <?php if($output['action'] == 'ht') {echo "style=background:none";}?>>
            <?php require template('layout/home_goods_class'); ?>
        </div>
        <ul class="site-menu">
            <li>
                <a href="<?php echo BASE_SITE_URL; ?>" <?php if ($output['index_sign'] == 'index' && $output['index_sign'] != '0') {
                    echo 'class="current"';
                } ?>><span><?php echo $lang['nc_index']; ?></span></a>
            </li>
            <!--   后台编辑的其他频道------开始     -->
            <?php if (!empty($output['nav_list']) && is_array($output['nav_list'])) { ?>

                <?php foreach ($output['nav_list'] as $nav_first) { ?>
                    <?php if ($nav_first['nav_location'] == 1 && $nav_first['nav_pid']==0) { ?>

                        <?php if (!empty($nav_first['_child'])) { ?>
                            <li class="links_a"><a href="<?php echo $nav_first['nav_url'];?>"
                                        target="<?php echo $nav_first['nav_new_open'] == 1 ? '_blank' : 'self' ?>"
                                    <?php if (($output['index_sign'] == $nav_first['nav_id'] || $output['index_sign'] == $nav_first['nav_pid']) && $output['index_sign'] != '0') {
                                        echo 'class="current"';
                                    } ?>
                                ><span>&nbsp;</span><?php echo $nav_first['nav_title']; ?><i></i></a>

                                <ul class="links_b">
                                    <?php if (!empty($nav_first['_child'])) { ?>
                                        <?php foreach ($nav_first['_child'] as $nav) { ?>

                                            <?php if ($nav['nav_location'] == '1') { ?>
                                                <li>
                                                    <a
                                                        <?php
                                                        if ($nav['nav_new_open']) {
                                                            echo ' target="_blank"';
                                                        }
                                                        switch ($nav['nav_type']) {
                                                            case '0':
                                                                echo ' href="' . $nav['nav_url'] . '"';
                                                                break;
                                                            case '1':
                                                                echo ' href="' . urlShop('search', 'index', array('cate_id' => $nav['item_id'])) . '"';
                                                                if (isset($_GET['cate_id']) && $_GET['cate_id'] == $nav['item_id']) {
                                                                    echo ' class="current"';
                                                                }
                                                                break;
                                                            case '2':
                                                                echo ' href="' . urlMember('article', 'article', array('ac_id' => $nav['item_id'])) . '"';
                                                                if (isset($_GET['ac_id']) && $_GET['ac_id'] == $nav['item_id']) {
                                                                    echo ' class="current"';
                                                                }
                                                                break;
                                                            case '3':
                                                                echo ' href="' . urlShop('activity', 'index', array('activity_id' => $nav['item_id'])) . '"';
                                                                if (isset($_GET['activity_id']) && $_GET['activity_id'] == $nav['item_id']) {
                                                                    echo ' class="current"';
                                                                }
                                                                break;
                                                        }
                                                        ?>><?php echo $nav['nav_title']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li><a target="<?php echo $nav_first['nav_new_open'] == 1 ? '_blank' : '_self' ?>"
                                   href="<?php echo $nav_first['nav_url']; ?>" <?php if (($output['index_sign'] == $nav_first['nav_id'] || $output['index_sign'] == $nav_first['nav_pid']) && $output['index_sign'] != '0') {
                                    echo 'class="current"';
                                } ?>> <span><?php echo $nav_first['nav_title']; ?></span></a></li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <!--   后台编辑的其他频道------结束     -->

        </ul>
    </div>
</nav>
</span>

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

