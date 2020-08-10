<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<!doctype html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $output['webTitle'];?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="Saingo">
    <meta name="copyright" content="Saingo Inc. All Rights Reserved">
    <link rel="shortcut icon" href="" />
    <!--[if IE 6]>
    <link rel="shortcut icon" href="<?php echo jf_TEMPLATES_URL;?>/favicon.ico" type="image/x-icon">
    <![endif]-->
    <style type="text/css">
        body {
            _behavior: url(<?php echo jf_TEMPLATES_URL;?>/css/csshover.htc);
        }
    </style>
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/new_header.css" rel="stylesheet" type="text/css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo jf_TEMPLATES_URL;?>/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo jf_TEMPLATES_URL;?>/js/html5shiv.js"></script>
    <script src="<?php echo jf_TEMPLATES_URL;?>/js/respond.min.js"></script>
    <![endif]-->
    <!--[if IE 6]>
    <script src="<?php echo jf_TEMPLATES_URL;?>/js/IE6_PNG.js"></script>
    <script>
        DD_belatedPNG.fix('.pngFix');
    </script>
    <script>
        // <![CDATA[
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand))
try{
document.execCommand("BackgroundImageCache", false, true);
   }
catch(e){}
// ]]>
</script>
<![endif]-->
    <script src="<?php echo jf_TEMPLATES_URL;?>/js/jquery.js"></script>
    <script src="<?php echo jf_TEMPLATES_URL;?>/js/common.js" charset="utf-8"></script>
    <script type="text/javascript">
        var PRICE_FORMAT = '&yen;%s';
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
                            if(menu.attr("hover")>0) return;
                            menu.masonry({itemSelector: 'dl'});
                            var menu_height = menu.height();
                            if (menu_height < 60) menu.height(80);
                            menu_height = menu.height();
                            var li_top = $(this).position().top;
                            if ((li_top > 60) && (menu_height >= li_top)) $(menu).css("top",-li_top+50);
                            if ((li_top > 150) && (menu_height >= li_top)) $(menu).css("top",-li_top+90);
                            if ((li_top > 240) && (li_top > menu_height)) $(menu).css("top",menu_height-li_top+90);
                            if (li_top > 300 && (li_top > menu_height)) $(menu).css("top",60-menu_height);
                            if ((li_top > 40) && (menu_height <= 120)) $(menu).css("top",-5);
                            menu.attr("hover",1);
                        },
                        function() {
                            $(this).removeClass("hover");
                            var cat_id = $(this).attr("cat_id");
                            $(this).find("div[cat_menu_id='"+cat_id+"']").hide();
                        }
                    );
                }
            );
            $(".head-user-menu dl").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });
            $('.head-user-menu .my-mall').mouseover(function(){// 最近浏览的商品
                load_history_information();
                $(this).unbind('mouseover');
            });
            $('.head-user-menu .my-cart').mouseover(function(){// 运行加载购物车
                load_cart_information();
                $(this).unbind('mouseover');
            });
            $('#button').click(function(){
                if ($('#keyword').val() == '') {
                    return false;
                }
            });
            /*$('a').click(function(){
                if($(this).attr('href')=='')
                {
                    showTips('功能模块正在建设中,感谢您的光临！', 200, 5)
                    return false;
                }
            })*/
            $(function(){
                $(".quick-menu dl").hover(function() {
                        $(this).addClass("hover");
                    },
                    function() {
                        $(this).removeClass("hover");
                    });

            });
        });
    </script>



    <style type="text/css">
        <!--
        .STYLE1 {
            color: #FF0000;
            font-weight: bold;
            font-size: 24px;
        }
        -->
    </style>

</head>
<body>

<!--header-->
<style>
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
        <h1 class="site-logo"><a href="/" target="_blank"><img src="<?php echo jf_TEMPLATES_URL;?>/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a><a href="/jf/"><img src="<?php echo jf_TEMPLATES_URL;?>/images/Jf_logo.jpg" /></a>
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

    </header>

</div>


<!--分类及导航菜单-->
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <span class="hot"></span>
            <?php if (is_array($output['mid_nav']) && !empty($output['mid_nav'])) { ?>
                <?php foreach ($output['mid_nav'] as $k => $nav) { ?><?php if (!empty($nav)) { ?>
                    <li><a href="<?php echo $nav['nav_url']; ?>" <?php if($output['current_type']==$k+1){ echo 'class="current"';}?>><?php echo $nav['nav_title']; ?></a></li>
                <?php }
                } ?>
            <?php }?>
        </ul>
    </div>
</nav>

<!--分类及导航菜单 END-->

<!--header END-->
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