<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<!doctype html>
<html lang="zh">
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
        body { _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
        }
    </style>
    <link href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_home_header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
    <![endif]-->
    <script>
        var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var LOGIN_SITE_URL = '<?php echo LOGIN_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
    </script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/new_index/PicLeft.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
    <script type="text/javascript">
        var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
        $(function(){
            //首页左侧分类菜单
            $(".category ul.menu").find("li").each(
                function() {
                    $(this).hover(
                        function() {
                            var cat_id = $(this).attr("cat_id");
                            var menu = $(this).find("div[cat_menu_id='"+cat_id+"']");
                            menu.show();
                            $(this).addClass("hover");
                            var menu_height = menu.height();
                            if (menu_height < 60) menu.height(80);
                            menu_height = menu.height();
                            var li_top = $(this).position().top;
                            $(menu).css("top",-li_top + 47);
                        },
                        function() {
                            $(this).removeClass("hover");
                            var cat_id = $(this).attr("cat_id");
                            $(this).find("div[cat_menu_id='"+cat_id+"']").hide();
                        }
                    );
                }
            );
            $(".mod_minicart").hover(function() {
                    $("#nofollow,#minicart_list").addClass("on");
                },
                function() {
                    $("#nofollow,#minicart_list").removeClass("on");
                });
            $('.mod_minicart').mouseover(function(){// 运行加载购物车
                load_cart_information();
                $(this).unbind('mouseover');
            });
            <?php if (C('fullindexer.open')) { ?>
            // input ajax tips
            $('#keyword').focus(function(){
                if ($(this).val() == $(this).attr('title')) {
                    $(this).val('').removeClass('tips');
                }
            }).blur(function(){
                if ($(this).val() == '' || $(this).val() == $(this).attr('title')) {
                    $(this).addClass('tips').val($(this).attr('title'));
                }
            }).blur().autocomplete({
                source: function (request, response) {
                    $.getJSON('<?php echo SHOP_SITE_URL;?>/index.php?controller=search&action=auto_complete', request, function (data, status, xhr) {
                        $('#top_search_box > ul').unwrap();
                        response(data);
                        if (status == 'success') {
                            $('body > ul:last').wrap("<div id='top_search_box'></div>").css({'zIndex':'1000','width':'362px'});
                        }
                    });
                },
                select: function(ev,ui) {
                    $('#keyword').val(ui.item.label);
                    $('#top_search_form').submit();
                }
            });
            <?php } ?>

            $('#button').click(function(){
                if ($('#keyword').val() == '') {
                    if ($('#keyword').attr('data-value') == '') {
                        return false
                    } else {
                        window.location.href="<?php echo SHOP_SITE_URL?>/index.php?controller=search&action=index&keyword="+$('#keyword').attr('data-value');
                        return false;
                    }
                }
            });
            $(".head-search-bar").hover(null,
                function() {
                    $('#search-tip').hide();
                });
            // input ajax tips
            $('#keyword').focus(function(){$('#search-tip').show()}).autocomplete({
                //minLength:0,
                source: function (request, response) {
                    $.getJSON('<?php echo SHOP_SITE_URL;?>/index.php?controller=search&action=auto_complete', request, function (data, status, xhr) {
                        $('#top_search_box > ul').unwrap();
                        response(data);
                        if (status == 'success') {
                            $('#search-tip').hide();
                            $(".head-search-bar").unbind('mouseover');
                            $('body > ul:last').wrap("<div id='top_search_box'></div>").css({'zIndex':'1000','width':'362px'});
                        }
                    });
                },
                select: function(ev,ui) {
                    $('#keyword').val(ui.item.label);
                    $('#top_search_form').submit();
                }
            });
            $('#search-his-del').on('click',function(){$.cookie('<?php echo C('cookie_pre')?>his_sh',null,{path:'/'});$('#search-his-list').empty();});
        });
    </script>
</head>

<body>
<!-- PublicTopLayout Begin -->
<!--ByCCYNet海吉壹佰-->
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<?php if ($output['hidden_nctoolbar'] != 1) { ?>
    <div id="ncToolbar" class="nc-appbar">
        <div class="nc-appbar-tabs" id="appBarTabs">
            <div class="ever">
                <?php if (!$output['hidden_rtoolbar_cart']) { ?>
                    <div class="cart"><a href="javascript:void(0);" id="rtoolbar_cart"><span class="icon"></span> <span
                                    class="name">购物车</span><i id="rtoobar_cart_count" class="new_msg"
                                                              style="display:none;"></i></a></div>
                <?php } ?>
                <?php if (!$output['hidden_rtoolbar_compare']) { ?>
                    <div class="compare"><a href="javascript:void(0);" id="compare"><span class="icon"></span><span
                                    class="tit">商品对比</span></a></div>
                <?php } ?>
            </div>
            <div class="variation">
                <div class="middle">
                    <?php if ($_SESSION['is_login']) { ?>
                        <div class="user" nctype="a-barUserInfo">
                            <a href="javascript:void(0);">
                                <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']); ?>"/>
                                </div>
                                <span class="tit">我的账户</span>
                            </a></div>
                        <div class="user-info" nctype="barUserInfo" style="display:none;"><i class="arrow"></i>
                            <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']); ?>"/>
                                <div class="frame"></div>
                            </div>
                            <dl>
                                <dt>Hi, <?php echo $_SESSION['member_name']; ?></dt>
                                <dd>当前等级：<strong
                                            nctype="barMemberGrade"><?php echo $output['member_info']['level_name']; ?></strong>
                                </dd>
                                <dd>当前经验值：<strong
                                            nctype="barMemberExp"><?php echo $output['member_info']['member_exppoints']; ?></strong>
                                </dd>
                            </dl>
                        </div>
                    <?php } else { ?>
                        <div class="user" nctype="a-barLoginBox">
                            <a href="javascript:void(0);">
                                <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']); ?>"/>
                                </div>
                                <span class="tit">会员登录</span>
                            </a>
                        </div>
                        <div class="user-login-box" nctype="barLoginBox" style="display:none;"><i class="arrow"></i> <a
                                    href="javascript:void(0);" class="close-a" nctype="close-barLoginBox"
                                    title="关闭">X</a>
                            <form id="login_form" method="post" action="<?php echo urlLogin('login', 'login'); ?>"
                                  onsubmit="ajaxpost('login_form', '', '', 'onerror')">
                                <?php Security::getToken(); ?> <input type="hidden" name="form_submit" value="ok"/>
                                <input name="nchash" type="hidden" value="<?php echo getNchash('login', 'index'); ?>">
                                <dl>
                                    <dt><strong>登录名</strong></dt>
                                    <dd>
                                        <input type="text" class="text" autocomplete="off" name="user_name" autofocus>
                                        <label></label>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><strong>登录密码</strong><a
                                                href="<?php echo urlLogin('login', 'forget_password'); ?>"
                                                target="_blank">忘记登录密码？</a></dt>
                                    <dd>
                                        <input type="password" class="text" name="password" autocomplete="off">
                                        <label></label>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><strong>验证码</strong><a href="javascript:void(0)" class="ml5"
                                                               onclick="javascript:document.getElementById('codeimage').src='index.php?controller=seccode&amp;op=makecode&amp;nchash=<?php echo getNchash('login', 'index'); ?>&amp;t=' + Math.random();">更换验证码</a>
                                    </dt>
                                    <dd>
                                        <input type="text" name="captcha" autocomplete="off" class="text w130"
                                               id="captcha" maxlength="4" size="10">
                                        <img src="" name="codeimage" border="0" id="codeimage" class="vt">
                                        <label></label>
                                    </dd>
                                </dl>
                                <div class="bottom">
                                    <input type="submit" class="submit" value="确认">
                                    <input type="hidden" value="" name="ref_url">
                                    <a href="<?php echo urlLogin('login', 'register', array('ref_url' => $_GET['ref_url'])); ?>"
                                       target="_blank">注册新用户</a>
                                    <?php if (C('qq_isuse') == 1 || C('sina_isuse') == 1 || C('weixin_isuse') == 1) { ?>
                                        <h4><?php echo $lang['nc_otherlogintip']; ?></h4>
                                        <?php if (C('weixin_isuse') == 1) { ?>
                                        <a href="javascript:void(0);"
                                           onclick="ajax_form('weixin_form', '微信账号登录', '<?php echo urlLogin('connect_wx', 'index'); ?>', 360);"
                                           title="微信账号登录" class="mr20">微信</a><?php } ?>
                                        <?php if (C('sina_isuse') == 1) { ?>
                                        <a href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=tosina" title="新浪微博账号登录"
                                           class="mr20">新浪微博</a><?php } ?>
                                        <?php if (C('qq_isuse') == 1) { ?><a
                                            href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=toqq" title="QQ账号登录"
                                            class="mr20">QQ账号</a><?php } ?><?php } ?>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                    <div class="prech">&nbsp;</div>
                    <?php if (C('node_chat')) { ?>
                        <div class="chat">
                            <a href="javascript:void(0);" id="chat_show_user">
                                <span class="icon"></span>
                                <i id="new_msg" class="new_msg" style="display:none;"></i>
                                <span class="tit">在线联系</span>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="gotop"><a href="javascript:void(0);" id="gotop"><span class="icon"></span><span class="tit">返回顶部</span></a>
                </div>
            </div>
            <div class="content-box" id="content-compare">
                <div class="top">
                    <h3>商品对比</h3>
                    <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
                <div id="comparelist"></div>
            </div>
            <div class="content-box" id="content-cart">
                <div class="top">
                    <h3>我的购物车</h3>
                    <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
                <div id="rtoolbar_cartlist"></div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        //登录开关状态
        var connect_qq = "<?php echo C('qq_isuse')?>";
        var connect_sn = "<?php echo C('sina_isuse')?>";
        var connect_wx = "<?php echo C('weixin_isuse')?>";
        $(function () {
            $(".l_qrcode a").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });

        });
        //返回顶部
        backTop = function (btnId) {
            var btn = document.getElementById(btnId);
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            window.onscroll = set;
            btn.onclick = function () {
                btn.style.opacity = "0.5";
                window.onscroll = null;
                this.timer = setInterval(function () {
                    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                    scrollTop -= Math.ceil(scrollTop * 0.1);
                    if (scrollTop == 0) clearInterval(btn.timer, window.onscroll = set);
                    if (document.documentElement.scrollTop > 0) document.documentElement.scrollTop = scrollTop;
                    if (document.body.scrollTop > 0) document.body.scrollTop = scrollTop;
                }, 10);
            };

            function set () {
                scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                btn.style.opacity = scrollTop ? '1' : "0.5";
            }
        };
        backTop('gotop');

        //动画显示边条内容区域
        $(function () {
            ncToolbar();
            $(window).resize(function () {
                ncToolbar();
            });

            function ncToolbar() {
                if ($(window).width() >= 1240) {
                    $('#appBarTabs >.variation').show();
                } else {
                    $('#appBarTabs >.variation').hide();
                }
            }

            $('#appBarTabs').hover(
                function () {
                    $('#appBarTabs >.variation').show();
                },
                function () {
                    ncToolbar();
                }
            );
            $("#compare").click(function () {
                if ($("#content-compare").css('right') == '-210px') {
                    loadCompare(false);
                    $('#content-cart').animate({'right': '-210px'});
                    $("#content-compare").animate({right: '35px'});
                } else {
                    $(".close").click();
                    $(".chat-list").css("display", 'none');
                }
            });
            $("#rtoolbar_cart").click(function () {
                if ($("#content-cart").css('right') == '-210px') {
                    $('#content-compare').animate({'right': '-210px'});
                    $("#content-cart").animate({right: '35px'});
                    if (!$("#rtoolbar_cartlist").html()) {
                        $("#rtoolbar_cartlist").load('index.php?controller=cart&action=ajax_load&type=html');
                    }
                } else {
                    $(".close").click();
                    $(".chat-list").css("display", 'none');
                }
            });
            $(".close").click(function () {
                $(".content-box").animate({right: '-210px'});
            });

            $(".quick-menu dl").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });
            $(".links_a").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });

            // 右侧bar用户信息
            $('div[nctype="a-barUserInfo"]').click(function () {
                $('div[nctype="barUserInfo"]').toggle();
            });
            // 右侧bar登录
            $('div[nctype="a-barLoginBox"]').click(function () {
                $('div[nctype="barLoginBox"]').toggle();
                document.getElementById('codeimage').src = 'index.php?controller=seccode&action=makecode&nchash=<?php echo getNchash('login', 'index');?>&t=' + Math.random();
            });
            $('a[nctype="close-barLoginBox"]').click(function () {
                $('div[nctype="barLoginBox"]').toggle();
            });
            <?php if ($output['cart_goods_num'] > 0) { ?>
            $('#rtoobar_cart_count').html(<?php echo $output['cart_goods_num'];?>).show();
            <?php } ?>
        });
    </script>
<?php } ?>
<?php if ($output['setting_config']['ccynet_top_banner_status'] > 0) { ?>
<div style=" background:<?php echo $output['setting_config']['ccynet_top_banner_color']; ?>;">
    <div class="wrapper" id="t-sp" style="display: none;">
        <a href="javascript:void(0);" class="close" title="关闭"></a>
        <a href="<?php echo $output['setting_config']['ccynet_top_banner_url']; ?>"
           title="<?php echo $output['setting_config']['ccynet_top_banner_name']; ?>"><img border="0"
                                                                                           src="<?php echo get_oss_image_url($output['setting_config']['ccynet_top_banner_pic'],1200); ?>"
                                                                                           alt=""></a></div>
    <script type="text/javascript">
        $(function () {
            //search
            var skey = getCookie('top_s');
            if (skey) {
                $("#t-sp").hide();
            } else {
                $("#t-sp").slideDown(800);
            }
            $("#t-sp .close").click(function () {
                setCookie('top_s', 'yes', 1);
                $("#t-sp").hide();
            });
        });
    </script></div><?php } ?>
<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry">
            <?php if ($_SESSION['is_login'] == '1') { ?>
                <?php echo $lang['nc_hello']; ?> <span> <a
                            href="<?php echo urlShop('member', 'home'); ?>"><?php echo $_SESSION['member_name']; ?></a>
                    <?php if ($output['member_info']['level_name']) { ?>
                        <div class="nc-grade-mini" style="cursor:pointer;"
                             onclick="javascript:go('<?php echo urlShop('pointgrade', 'index'); ?>');"><?php echo $output['member_info']['level_name']; ?></div>
                    <?php } ?>
      </span> <?php echo $lang['nc_comma'], $lang['welcome_to_site']; ?> <a href="<?php echo SHOP_SITE_URL; ?>"
                                                                            title="<?php echo $lang['homepage']; ?>"
                                                                            alt="<?php echo $lang['homepage']; ?>"><span><?php echo $output['setting_config']['site_name']; ?></span></a>
                <span>[<a href="<?php echo urlLogin('login', 'logout'); ?>"><?php echo $lang['nc_logout']; ?></a>] </span>
            <?php } else { ?>
                <?php echo $lang['nc_hello'] . $lang['nc_comma'] . $lang['welcome_to_site']; ?> <a
                href="<?php echo SHOP_SITE_URL; ?>" title="<?php echo $lang['homepage']; ?>"
                alt="<?php echo $lang['homepage']; ?>"><?php echo $output['setting_config']['site_name']; ?></a><?php if (C('qq_isuse') == 1 || C('sina_isuse') == 1 || C('weixin_isuse') == 1) { ?>
                    <span class="other">
      <?php if (C('qq_isuse') == 1) { ?>
          <a href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=toqq" title="QQ账号登录" class="qq"><i></i></a>
      <?php } ?>
                        <?php if (C('sina_isuse') == 1) { ?>
                            <a href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=tosina"
                               title="<?php echo $lang['nc_otherlogintip_sina']; ?>" class="sina"><i></i></a>
                        <?php } ?>
                        <?php if (C('weixin_isuse') == 1) { ?>
                        <a href="javascript:void(0);"
                           onclick="ajax_form('weixin_form', '微信账号登录', '<?php echo urlLogin('connect_wx', 'index'); ?>', 360);"
                           title="微信账号登录" class="wx"><i></i></a><?php } ?>
      </span>
                <?php } ?> <span>[<a
                            href="<?php echo urlMember('login'); ?>"><?php echo $lang['nc_login']; ?></a>]</span> <span>[<a
                            href="<?php echo urlLogin('login', 'register'); ?>"><?php echo $lang['nc_register']; ?></a>]</span>
            <?php } ?>
        </div>
        <div class="quick-menu">
            <dl>
                <dt>
                    <a href="<?php echo urlShop('member', 'home'); ?>" title="个人中心">个人中心</a>
                </dt>
            </dl>
            <dl>
                <dt><em class="ico_shop"></em><a href="<?php echo urlShop('show_joinin', 'index'); ?>"
                                                 title="商家管理">商家管理</a><i></i></dt>
                <dd>
                    <ul>
                        <li><a href="<?php echo urlShop('show_joinin', 'index'); ?>" title="招商入驻">招商入驻</a></li>
                        <li><a href="<?php echo urlShop('seller_login', 'show_login'); ?>" target="_blank"
                               title="登录商家管理中心">商家登录</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_order"></em><a
                            href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order">我的订单</a><i></i></dt>
                <dd>
                    <ul>
                        <li>
                            <a href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_new">待付款订单</a>
                        </li>
                        <li><a href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_send">待确认收货</a>
                        </li>
                        <li><a href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_order&state_type=state_noeval">待评价交易</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_store"></em><a
                            href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist"><?php echo $lang['nc_favorites']; ?></a><i></i>
                </dt>
                <dd>
                    <ul>
                        <li>
                            <a href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_goods&action=fglist">商品收藏</a>
                        </li>
                        <li>
                            <a href="<?php echo SHOP_SITE_URL; ?>/index.php?controller=member_favorite_store&action=fslist">店铺收藏</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_service"></em>客户服务<i></i></dt>
                <dd>
                    <ul>
                        <li><a href="<?php echo urlMember('help', 'help'); ?>">帮助中心</a></li>
                        <li><a href="<?php echo urlMember('article', 'article', array('ac_id' => 5)); ?>">售后服务</a></li>
                        <li><a href="<?php echo urlMember('article', 'article', array('ac_id' => 6)); ?>">客服中心</a></li>
                    </ul>
                </dd>
            </dl>
            <?php
            if (!empty($output['nav_list']) && is_array($output['nav_list'])) {
                foreach ($output['nav_list'] as $nav) {
                    if ($nav['nav_location'] < 1) {
                        $output['nav_list_top'][] = $nav;
                    }
                }
            }
            if (!empty($output['nav_list_top']) && is_array($output['nav_list_top'])) {
                ?>
                <dl>
                    <dt>站点导航<i></i></dt>
                    <dd>
                        <ul>
                            <?php foreach ($output['nav_list_top'] as $nav) { ?>
                                <li><a
                                        <?php
                                        if ($nav['nav_new_open']) {
                                            echo ' target="_blank"';
                                        }
                                        echo ' href="';
                                        switch ($nav['nav_type']) {
                                            case '0':
                                                echo $nav['nav_url'];
                                                break;
                                            case '1':
                                                echo urlShop('search', 'index', array('cate_id' => $nav['item_id']));
                                                break;
                                            case '2':
                                                echo urlMember('article', 'article', array('ac_id' => $nav['item_id']));
                                                break;
                                            case '3':
                                                echo urlShop('activity', 'index', array('activity_id' => $nav['item_id']));
                                                break;
                                        }
                                        echo '"';
                                        ?>><?php echo $nav['nav_title']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </dd>
                </dl>
            <?php } ?>
            <?php if (C('mobile_wx')) { ?>
                <dl class="weixin">
                    <dt>关注我们<i></i></dt>
                    <dd>
                        <h4>扫描二维码<br/>
                            关注商城微信号</h4>
                        <img src="<?php echo UPLOAD_SITE_URL . DS . ATTACH_MOBILE . DS . C('mobile_wx'); ?>"></dd>
                </dl>
            <?php } ?>
        </div>
    </div>
</div>

<!-- PublicHeadLayout Begin -->
<div class="header-wrap">
    <header class="public-head-layout wrapper">
        <h1 class="site-logo"><a href="http://haijiyibai.ccynet.cn/"><img src="/data/upload/shop/common/05601109233006971.png" class="pngFix"></a>
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
        <!--<div class="logo-test">共创、共联、共享、共商</div>-->

        <div class="head-search-layout">
            <div class="head-search-bar" id="head-search-bar">
                <div class="hd_serach_tab" id="hdSearchTab">
                    <ul>
                        <li act="search" class="current"><span>商品</span><i class="arrow"></i></li>
                        <li act="store_list"><span>店铺</span></li>
                    </ul>
                    <i></i>
                </div>

                <form action="http://haijiyibai.ccynet.cn/shop" method="get" class="search-form" id="top_search_form">
                    <input name="controller" id="search_act" value="search" type="hidden">
                    <input name="keyword" id="keyword" type="text" class="input-text ui-autocomplete-input" value="" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" placeholder="瑞士机械表" data-value="%E6%89%8B%E8%A1%A8" x-webkit-grammar="builtin:search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                    <input type="submit" id="button" value="搜索" class="input-submit">
                </form>
                <div class="search-tip" id="search-tip">
                    <div class="search-history">
                        <div class="title">历史纪录
                            <a href="javascript:void(0);" id="search-his-del">清除</a>
                        </div>
                        <ul id="search-his-list">
                        </ul>
                    </div>
                    <div class="search-hot">
                        <div class="title">热门搜索...</div>
                        <ul>
                            <li>
                                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;keyword=%E6%89%8B%E8%A1%A8">手表</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="keyword">
                <ul>
                    <li>
                        <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;keyword=%E6%90%9C%E7%B4%A2%E9%BB%98%E8%AE%A4%E8%AF%8D1">搜索默认词1</a>
                    </li>
                    <li>
                        <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;keyword=%E6%90%9C%E7%B4%A2%E9%BB%98%E8%AE%A4%E8%AF%8D2">搜索默认词2</a>
                    </li>
                    <li>
                        <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;keyword=%E6%90%9C%E7%B4%A2%E9%BB%98%E8%AE%A4%E8%AF%8D3">搜索默认词3</a>
                    </li>
                    <li>
                        <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;keyword=%E6%90%9C%E7%B4%A2%E9%BB%98%E8%AE%A4%E8%AF%8D4">搜索默认词4</a>
                    </li>
                </ul>
            </div>
        </div>

    </header>
</div>
<!-- PublicHeadLayout End -->

<!-- publicNavLayout Begin -->
<nav class="public-nav-layout ">
    <div class="wrapper">
        <div class="all-category">
            <?php require template('layout/home_goods_class');?>
        </div>
        <ul class="site-menu">
            <li>
                <a href="http://haijiyibai.ccynet.cn/" class="current"><span>首页</span></a>
            </li>
            <!--   后台编辑的其他频道------开始     -->
            <li>
                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1068"> <span>海豚主场</span></a>
            </li>
            <li class="links_a">
                <a><span>&nbsp;</span>全球跨境<i></i></a>

                <ul class="links_b">

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1058">品牌轻奢 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1059">母婴用品 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1060">美妆洗护 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1061">生活日用 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1062">营养保健 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1063">酒水饮料 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1064">休闲零食 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=cate&amp;action=index&amp;cate_id=1065">生鲜果菜 </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=brand&amp;action=index"> <span>炫酷品牌</span></a>
            </li>
            <li>
                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;yx=1"> <span>精选尖货</span></a>
            </li>
            <li>
                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=search&amp;action=index&amp;new=1"> <span>新品上市</span></a>
            </li>
            <li class="links_a">
                <a><span>&nbsp;</span>积分商城<i></i></a>

                <ul class="links_b">

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=pointshop&amp;action=index">积分特权 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=pointprod&amp;action=plist">我能兑换 </a>
                    </li>

                    <li>
                        <a target="_blank" href="javascript:;">商家榜单 </a>
                    </li>
                </ul>
            </li>
            <li class="links_a">
                <a><span>&nbsp;</span>消费资本<i></i></a>

                <ul class="links_b">

                    <li>
                        <a target="_blank" href="javascript:;">海吉币 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=member_points&amp;action=index">海吉积分 </a>
                    </li>

                    <li>
                        <a target="_blank" href="javascript:;">消费公积金 </a>
                    </li>

                    <li>
                        <a target="_blank" href="javascript:;">消费养老保险 </a>
                    </li>

                    <li>
                        <a target="_blank" href="javascript:;">车房梦想基金 </a>
                    </li>

                    <li>
                        <a target="_blank" href="javascript:;">海吉慈善基金 </a>
                    </li>
                </ul>
            </li>
            <li class="links_a">
                <a><span>&nbsp;</span>线下加盟<i></i></a>

                <ul class="links_b">

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">品牌托管 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">24 h 便利店 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">智能售货机 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">跨境购体验店 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">养老康乐院 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">消费养老保险卡服务中心 </a>
                    </li>
                </ul>
            </li>
            <li class="links_a">
                <a><span>&nbsp;</span>分享阵地<i></i></a>

                <ul class="links_b">

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&amp;action=article&amp;ac_id=8">关于我们 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&amp;action=article&amp;ac_id=9">分享模块 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&amp;action=article&amp;ac_id=10">海吉商学院 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&amp;action=article&amp;ac_id=11">招贤纳士 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/shop/index.php?controller=join&amp;action=developing">HISR 服务中心 </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://haijiyibai.ccynet.cn/member/index.php?controller=member_sharemanage">分享绑定 </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="http://haijiyibai.ccynet.cn/shop/index.php?controller=member&amp;action=home"> <span>会员中心</span></a>
            </li>
            <!--   后台编辑的其他频道------结束     -->

        </ul>
    </div>
</nav>
<div class="nch-breadcrumb-layout">
</div>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/home_index.js" charset="utf-8"></script>

<!--<style type="text/css">.category {
        display: block !important;
    }</style>-->
<div class="clear"></div>
<!-- HomeFocusLayout Begin-->

<!-- HomeFocusLayout Begin-->
<div class="home-focus-layout">

    <ul id="fullScreenSlides" class="full-screen-slides">
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-1.jpg?936&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="冬季名品-大牌季节日ss">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-5.jpg?370&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="全套茶具专场-年终盛典">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-2.jpg?906&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="女人再忙也要留一天为自己疯抢">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-3.jpg?954&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="http://www.baidu.com/" target="_blank" title="全年爆款-年底清仓">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-4.jpg?203&quot;) center top no-repeat; z-index: 800; display: list-item;">
            <a href="javascript:void(0)" title="清仓年末特优-满99元包邮">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-6.jpg?792&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="冬季名品-大牌季节日">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-10.jpg?489&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="全套茶具专场-年终盛典">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-7.jpg?256&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="女人再忙也要留一天为自己疯抢">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-8.jpg?887&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="http://www.baidu.com/" target="_blank" title="全年爆款-年底清仓">&nbsp;</a>
        </li>
        <li style="background: url(&quot;http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-101-101-9.jpg?841&quot;) center top no-repeat; z-index: 900; display: none;">
            <a href="javascript:void(0)" title="111清仓年末特优-满99元包邮">&nbsp;</a>
        </li>
    </ul>
    <ul class="full-screen-slides-pagination">
        <li class="">
            <a href="javascript:void(0)">1</a>
        </li>
        <li class="">
            <a href="javascript:void(0)">2</a>
        </li>
        <li class="">
            <a href="javascript:void(0)">3</a>
        </li>
        <li class="">
            <a href="javascript:void(0)">4</a>
        </li>
        <li class="current">
            <a href="javascript:void(0)">5</a>
        </li>
        <li>
            <a href="javascript:void(0)">6</a>
        </li>
        <li>
            <a href="javascript:void(0)">7</a>
        </li>
        <li>
            <a href="javascript:void(0)">8</a>
        </li>
        <li>
            <a href="javascript:void(0)">9</a>
        </li>
        <li>
            <a href="javascript:void(0)">10</a>
        </li>
    </ul>

    <!--<div class="jfocus-trigeminy">
        <ul style="left: 0px; width: 1552px;">
                                                <li>
                                                                                    <a href="" target="_blank" title="" style="opacity: 1;">
                                    <img src="" alt="">
                                </a>
                                                                                        <a href="" target="_blank" title="" style="opacity: 1;">
                                    <img src="" alt="">
                                </a>

                                                </li>


        </ul>
        <div class="pagination"><span style="opacity: 1;"></span><span style="opacity: 0.4;"></span></div>
        <div class="arrow pre" style="opacity: 0;"></div>
        <div class="arrow next" style="opacity: 0;"></div>
    </div>-->

    <script type="text/javascript">
        update_screen_focus();
    </script>

</div>

<!--HomeFocusLayout End-->

<div class="wrapper">
    <div class="mt10">
        <div class="mt10">
            <a title="物流自提服务站广告" target="_blank" href="javascript:;"> <img border="0" alt="物流自提服务站广告" src="/data/upload/shop/adv/05561319076203865.jpg" style="width:1200px;height:100px"> </a>
        </div>
    </div>
</div>
<!--StandardLayout Begin-->
<div class="first">
    <div class="first-top">
        <span>1F</span>
        <b>热销产品推荐/</b>
        <em>Hot product recommendation</em>
    </div>
    <div class="first-left">
        <ul>
            <li><a href="">
                    <span class="icon1"></span>
                    <em>手机</em></a>
            </li>
            <li><a href="">
                    <span class="icon2"></span>
                    <em>电视</em></a>
            </li>
            <li><a href="">
                    <span class="icon3"></span>
                    <em>化妆品</em></a>
            </li>
            <li><a href="">
                    <span class="icon4"></span>
                    <em>日用品</em></a>
            </li>
            <li><a href="">
                    <span class="icon5"></span>
                    <em>鞋包</em></a>
            </li>
            <li><a href="">
                    <span class="icon5"></span>
                    <em>衣服</em></a>
            </li>
        </ul>
    </div>
    <div class="first-right">
        <ul id="first-list">
            <li><a href="" target="_blank">
                    <div class="first-right-img"><span>1</span><img src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/1_05590616492488118.jpg?x-oss-process=image/resize,m_pad,h_240,w_240,color_FFFFFF"></div>
                    <div class="first-right-text">The Saem/得鲜香吻按压哑光口红唇膏 滋润唇膏持久最火姨妈色</div>
                    <div class="first-right-price">￥2600</div></a>
            </li>
            <li><a href="" target="_blank">
                    <div class="first-right-img"><span>2</span><img src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/1_05590616492488118.jpg?x-oss-process=image/resize,m_pad,h_240,w_240,color_FFFFFF"></div>
                    <div class="first-right-text">The Saem/得鲜香吻按压哑光口红唇膏 滋润唇膏持久最火姨妈色</div>
                    <div class="first-right-price">￥2600</div></a>
            </li>
            <li><a href="" target="_blank">
                    <div class="first-right-img"><span>3</span><img src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/1_05590616492488118.jpg?x-oss-process=image/resize,m_pad,h_240,w_240,color_FFFFFF"></div>
                    <div class="first-right-text">The Saem/得鲜香吻按压哑光口红唇膏 滋润唇膏持久最火姨妈色</div>
                    <div class="first-right-price">￥2600</div></a>
            </li>
            <li><a href="" target="_blank">
                    <div class="first-right-img"><span>4</span><img src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/1_05590616492488118.jpg?x-oss-process=image/resize,m_pad,h_240,w_240,color_FFFFFF"></div>
                    <div class="first-right-text">The Saem/得鲜香吻按压哑光口红唇膏 滋润唇膏持久最火姨妈色</div>
                    <div class="first-right-price">￥2600</div></a>
            </li>
        </ul>

        <script language="javascript" type="text/javascript">

            var scrollPic_02 = new ScrollPicleft();
            scrollPic_02.scrollContId = "first-list"; // 内容容器ID""
            scrollPic_02.arrLeftId = "Left_ding2nihao"; //左箭头ID
            scrollPic_02.arrRightId = "Right_ding2nihao"; //右箭头ID

            scrollPic_02.frameWidth = 964; //显示框宽度

            scrollPic_02.pageWidth = 1; //翻页宽度

            scrollPic_02.speed = 5; //移动速度(单位毫秒，越小越快)
            scrollPic_02.space = 3; //每次移动像素(单位px，越大越快)
            scrollPic_02.autoPlay = true; //自动播放
            scrollPic_02.autoPlayTime = 0.03; //自动播放间隔时间(秒)

            scrollPic_02.initialize(); //初始化

        </script>
    </div>

    <div class="first-bottom">
        <ul>
            <li><a href="">
                    <div class="first-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <span>ysl圣罗兰包包</span>
                    <b>小包容量耐用单肩包</b>
                    <em>美国直邮311790</em></a>
            </li>
            <li><a href="">
                    <div class="first-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <span>ysl圣罗兰包包</span>
                    <b>小包容量耐用单肩包</b>
                    <em>美国直邮311790</em></a>
            </li>
            <li><a href="">
                    <div class="first-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <span>ysl圣罗兰包包</span>
                    <b>小包容量耐用单肩包</b>
                    <em>美国直邮311790</em></a>
            </li>
            <li><a href="">
                    <div class="first-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <span>ysl圣罗兰包包</span>
                    <b>小包容量耐用单肩包</b>
                    <em>美国直邮311790</em></a>
            </li>
        </ul>
    </div>
</div>

<div class="tower">
    <div class="tower-top">
        <span>2F</span>
        <b>跨境产品/</b>
        <em>Cross-border products</em>
    </div>
    <div class="tower-bottom">
        <ul>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>

            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>
            <li><a href="">
                    <div class="tower-bottom-img"><img src="/data/upload/shop/editor/web-2-25-1-8.jpg?380"></div>
                    <div class="tower-bottom-title">婴儿枕0-1-5岁枕头宝宝定型枕幼儿枕</div>
                    <div class="tower-bottom-text">
                        <div class="tower-bottom-price">
                            <span>￥</span>80
                        </div>
                        <div class="tower-bottom-lr">
                            <span>￥230.00</span>
                            <em>已售出10004件</em>
                        </div>
                    </div></a>
            </li>


        </ul>
        <a href="" class="tower-button">查看更多</a>
    </div>
</div>

<div class="footer">
    <div class="footer-top">
        <dl>
            <dt>新手指南</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=39">积分细则</a></dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=40">积分兑换说明</a></dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=7">如何搜索</a></dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=8">忘记密码</a></dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=9">我要买</a></dd>
        </dl>
        <dl>
            <dt>商家中心</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=11">如何管理店铺</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=12">查看售出商品</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=13">如何发货</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=14">尚诚商品推荐</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=15">如何申请开店</dd>
        </dl>
        <dl>
            <dt>支付方式</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=28">分期付款</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=30">公司转账</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=29"> 邮局汇款 </dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=16">如何注册支付宝</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=17">在线支付</dd>
        </dl>
        <dl>
            <dt>售后服务</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=31">退换货政策</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=32">退换货流程</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=33">返修/退换货</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=34">退款申请</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=26">联系卖家</dd>
        </dl>
        <dl>
            <dt>购物指南</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=18">会员修改密码</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=19">会员修改个人资料</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=20">商品发布</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=21">修改收货地址</dd>
        </dl>
        <dl>
            <dt>分享阵地</dt>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=45">海吉商学院文章</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=44">分享模块文章</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=43">关于我们的标题</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=25">合作和洽谈</dd>
            <dd><a href="http://haijiyibai.ccynet.cn/member/index.php?controller=article&action=show&article_id=24">招聘英才</a></dd>
        </dl>
    </div>
    <div class="footer-bottom">CopyRight © 2007-2016 海吉壹佰 NewPower Co. 版权所有</div>
</div>


<style>
    .sidebar {
        position: fixed;
        top: 10px;
        left: 10px;
    }

    .sidebar li {
        height: 26px;
        line-height: 26px;
        text-align: center;
        cursor: pointer;
        width: 50px;
    }

    .sidebar li a {
        display: block;
        padding: 0 6px;
        color: #999;
        border-bottom: 1px dotted #c2c2c2;
    }

    .sidebar li p {
        display: none;
        color: #34af7c;
    }

    .sidebar li.active p,
    .sidebar li.on p {
        display: block;
    }

    .sidebar li.active a,
    .sidebar li.on a {
        display: none;
    }

    ol,
    ul {
        list-style: none;
    }
</style>

<script>
    // 获取页面中的所有floor-layout的个数
    $(function() {
        var _floor_length = $('.floor-layout').length;
        var _floor_name = '';
        var _floor_id = '';
        if(_floor_length > 0) {
            var _str = '<div class="sidebar" style="display: block; top: 367px; left: 9.5px;"><ul>';
            $(".floor-layout").each(function() {
                _floor_name = $(this).find('.floor-left .txt-type span').text();
                _floor_id = $(this).attr('id');
                _str += '<li><a href="#' + _floor_id + '">' + _floor_name + '</a></li>';
            });
            _str += '</ul></div>';
        }
        $('body').append(_str);
    });
</script>
<script language="javascript">
    function fade() {
        $("img[rel='lazy']").each(function() {
            var $scroTop = $(this).offset();
            if($scroTop.top <= $(window).scrollTop() + $(window).height()) {
                $(this).hide();
                $(this).attr("src", $(this).attr("ccynet-url"));
                $(this).removeAttr("rel");
                $(this).removeAttr("name");
                $(this).fadeIn(500);
            }
        });
    }

    if($("img[rel='lazy']").length > 0) {
        $(window).scroll(function() {
            fade();
        });
    };
    fade();
</script>

<div class="sidebar" style="display: block; top: 367px; left: 9.5px;">
    <ul>
        <li>
            <a href="http://haijiyibai.ccynet.cn/#pink">1F</a>
        </li>
        <li>
            <a href="http://haijiyibai.ccynet.cn/#orange">2F</a>
        </li>
    </ul>
</div>

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
</body>

</html>