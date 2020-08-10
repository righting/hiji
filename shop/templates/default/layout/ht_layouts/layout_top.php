<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/layout_top/layout_top.css" rel="stylesheet" type="text/css">
<!--ByCCYNet海吉壹佰-->
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<?php if ($output['hidden_nctoolbar'] != 1) { ?>
    <div id="ncToolbar" class="nc-appbar">
        <div class="nc-appbar-tabs" id="appBarTabs">
            <div class="content-box" id="content-compare">
                <div id="comparelist"></div>
            </div>
            <div class="content-box" id="content-cart">
                <div id="rtoolbar_cartlist"></div>
            </div>
        </div>
    </div>


    <div class="fixedtool">
        <ul>
            <li>
                <a href="javascript:;" class="icon8" id="chat_show_user">在线咨询</a>
            </li>

            <li>
                <a href="javascript:;" class="icon9" id="rtoolbar_cart">购物车</a>
            </li>

            <li>
                <a href="javascript:;" class="icon10" id="compare">商品对比</a>
            </li>

            <li>
                <a href="javascript:;" class="icon11" id="gotop">回到顶部</a>
            </li>

        </ul>
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
        $('#gotop').click(function () {
            $('html , body').animate({scrollTop: 0},'slow');
        });


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
                    $("#content-compare").animate({right: '0'});
                } else {
                    $(".close").click();
                    $(".chat-list").css("display", 'none');
                }
            });
            $("#rtoolbar_cart").click(function () {
                if ($("#content-cart").css('right') == '-210px') {
                    $('#content-compare').animate({'right': '-210px'});
                    $("#content-cart").animate({right: '0'});
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
           title="<?php echo $output['setting_config']['ccynet_top_banner_name']; ?>">
            <img border="0" src="<?php echo get_oss_image_url($output['setting_config']['ccynet_top_banner_pic'],1200); ?>" alt="">
        </a>
    </div>
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
    </script>
</div>
<?php } ?>
<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry">
            <?php if ($_SESSION['is_login'] == '1') { ?>
                <?php echo $lang['nc_hello']; ?> <span> <a
                            href="<?php echo urlShop('member', 'home'); ?>"><?php echo $_SESSION['member_nickname']; ?></a>
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
                            href="<?php echo urlLogin('login','index'); ?>"><?php echo $lang['nc_login']; ?></a>]</span> <span>[<a
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
                        <li><a href="<?php echo urlShop('dealers', 'index'); ?>" title="经销商申请">经销商申请</a></li>
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
<!--                            <a href="--><?php //echo SHOP_SITE_URL; ?><!--/index.php?controller=member_favorite_store&action=fslist">店铺收藏</a>-->
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>
                    <a target="_blank" href="/member/index.php?controller=page&action=show&page_key=service_centre">服务中心</a>
                    <!--<i></i>-->
                </dt>
              <!--  <dt><em class="ico_service"></em>客户服务<i></i></dt>-->
                <!--<dd>
                    <ul>
                        <li><a href="<?php /*echo urlMember('help', 'help'); */?>">帮助中心</a></li>
                        <li><a href="<?php /*echo urlMember('article', 'article', array('ac_id' => 5)); */?>">售后服务</a></li>
                        <li><a href="<?php /*echo urlMember('article', 'article', array('ac_id' => 6)); */?>">客服中心</a></li>
                    </ul>
                </dd>-->
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
