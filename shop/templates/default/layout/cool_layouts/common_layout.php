<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<!doctype html>
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
            _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
        }

        .fixed-box {
            display: block;
            position: fixed;
            z-index: 999;
        }
    </style>
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/new_base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/brand/new_index.css" rel="stylesheet" type="text/css">
    <!--    <link href="--><?php //echo SHOP_TEMPLATES_URL; ?><!--/css/style.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo SHOP_RESOURCE_SITE_URL; ?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/brand/cool.css" rel="stylesheet" type="text/css">

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
        <h1 class="site-logo-xpss"><a href="/shop/index.php?controller=brand&action=index"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/brand/cool_logo.png" class=""></a>
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
<form action="<?php echo SHOP_SITE_URL; ?>" method="get" class="search-form" id="top_search_form">
        <div class="header-search">
<!--            <input type="text" id="header-search-input" placeholder="请输入您要找的物品">-->
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
            <input type="button" id="button" class="header-search-button">
        </div>
</form>
    </header>
</div>
<!-- PublicHeadLayout End -->

<!-- publicNavLayout Begin -->
<nav class="public-nav-layout <?php if ($output['channel']) {
    echo 'channel-' . $output['channel']['channel_style'] . ' channel-' . $output['channel']['channel_id'];
} ?>">
    <div class="wrapper">
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

