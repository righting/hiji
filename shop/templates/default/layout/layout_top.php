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
                <div class="close" style="position: fixed;top:50%;cursor: pointer;display:block;background:url('/shop/templates/default/images/home_index/icon7.png') no-repeat center;width:29px;height:50px;">  </div>
            </div>
            <div class="content-box" id="content-cart">
                <div id="rtoolbar_cartlist"></div>

                <!--新增 关闭购物车按钮弹框按钮 2018/04/10 start-->
                <div class="close" style="position: fixed;top:50%;cursor: pointer;display:block;background:url('/shop/templates/default/images/home_index/icon7.png') no-repeat center;width:29px;height:50px;">  </div>
                <!--新增 关闭购物车按钮弹框按钮 2018/04/10 end-->

            </div>
        </div>
    </div>


<style>
    .user-level-bottom .user-level-progress:before,
    .user-level-bottom .user-level-progress:after {
        height: inherit;
        position: absolute;
        background-color: #3F51B5;
        top: 0;
        left: 0;
        right: 0;
        border-radius: 5px;
        content: "";
        opacity: 1;
        width: <?php echo $output['member_info']['exppoints_rate'];?>%;
    }
</style>
    <div class="fixedtool">
        <ul>
            <?php if($output['index_sign'] == 50){ ?>
                <?php if ($_SESSION['is_login']) {?>
                <li>
                    <a href="javascript:;" class="icon12 top-active" id="show_user_info">会员信息</a>
                </li>
                <?php } ?>
            <?php } ?>
            <li>
                <a href="javascript:;" class="icon8" id="chat_show_user">在线咨询</a>
            </li>

            <?php if ($_SESSION['is_login']) {
            if(count($output['kefu_group_list'])>0){
                foreach($output['kefu_group_list'] as $val){?>
                <li class="service">
                    <a href="javascript:;" class="icon12" data-id="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a>
                </li>
                <?php }}} ?>

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
        <?php if($output['index_sign'] == 50){ ?>
            <?php if ($_SESSION['is_login']) {?>
                <div class="user-info-box" id="user-info-box">
                    <div class="user-info-close-btn">
                    </div>
                    <div class="user-info">
                        <div class="user-info-top">
                            <div class="user-info-cover">
                                <div class="user-cover-img">
                                    <img src="<?php echo getMemberAvatarForID($_SESSION['member_id']);?>" width="65" height="65" />
                                </div>
                            </div>
                            <div class="user-info-other">
                                <div class="user-info-name">
                                    <span class="user-info-name-span">Hi, <?php echo $_SESSION['member_name'];?></span>
                                </div>
                                <div class="user-info-level-name">
                                    <span class="user-info-level-name-span"><?php echo $output['member_info']['level_name'];?></span>
                                </div>
                            </div>
                        </div>
                        <div class="user-info-bottom">
                            <div class="user-info-level">
                                <div class="user-level-top">
                                    <span class="level-name-left" title="<?php echo $output['member_info']['downgrade_name'];?>需积分<?php echo $output['member_info']['downgrade_point'];?>"><?php echo $output['member_info']['downgrade_name'];?></span>
                                    <span class="level-name-right" title="<?php echo $output['member_info']['upgrade_name'];?>需积分<?php echo $output['member_info']['upgrade_point'];?>"><?php echo $output['member_info']['upgrade_name'];?></span>
                                </div>
                                <div class="user-level-bottom">
                                    <span class="user-level-progress" title="<?php echo $output['member_info']['exppoints_rate'];?>%"></span>
                                </div>
                            </div>
                            <div class="user-info-btn">
                                <?php if($output['member_info']['exppoints_rate'] == 100){ ?>
                                    <span class="user-info-level-span"><a style="cursor:pointer;" href="<?php echo urlShop('pointshop','buy_grade'); ?>">立即升级</a></span>
                                <?php }else{ ?>
                                    <span class="user-info-level-span"><a style="cursor:pointer;" href="<?php echo urlShop('cate','index',['cate_id'=>1068]); ?>">我要升级</a></span>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>


<?php if ($_SESSION['is_login']) {?>
        <script type="text/javascript">
            $(function() {
                var ws = new fotaisKeFu();
                $("li.service a").click(function(){
                    var group = $(this).attr('data-id');
                    ws.init({
                        id: "<?php echo $_SESSION['member_id'];?>",
                        name: "<?php echo $_SESSION['member_name'];?>",
                        avatar: "<?php echo $_SESSION['avatar'];?>",
                        group: group
                    });
                });
            });
        </script>
    <?php } ?>

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
                    // $('#content-cart').animate({'right': '-171px'});
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
<div class="public-top-layout w" id="testsss">
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
            <?php if(strstr($_SERVER['REQUEST_URI'],'global')){?>
                <dl>
                    <dt><a target="_blank" href="javascript:;">语言管理</a><i></i></dt>
                        <dd>
                            <ul>
                                    <li><a href="">中文</a></li>
                                    <li><a href="">英文</a></li>
                            </ul>
                        </dd>
                </dl>
            <?php }?>
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
<script>
    function showTips( tips, height, time ){
    var windowWidth = document.documentElement.clientWidth;
    var tipsDiv = '<div class="tipsClass">' + tips + '</div>';

    $( 'body' ).append( tipsDiv );
    $( 'div.tipsClass' ).css({
        'top' : '45%',
        'left' : ( windowWidth / 2 ) - ( tips.length * 13 / 2 ) + 'px',
        'position' : 'fixed',
        'padding' : '20px 50px',
        'background': '#EAF2FB',
        'font-size' : 14 + 'px',
        'margin' : '0 auto',
        'text-align': 'center',
        'width' : 'auto',
        'color' : '#333',
        'border' : 'solid 1px #A8CAED',
        'opacity' : '0.90',
        'z-index' : '9999'
    }).show();
    setTimeout( function(){$( 'div.tipsClass' ).fadeOut().remove();}, ( time * 1000 ) );
}

    var lan = $('.quick-menu dl:first li a');
    lan.click(function() {
        if ($(this).attr('href') == '') {
            showTips('功能模块正在建设中！', 200, 2)
            return false;
        }
    })
</script>
