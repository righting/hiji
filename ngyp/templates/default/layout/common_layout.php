<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<!doctype html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>农耕优品-<?php echo $output['web_info']['name']?></title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content="Saingo">
    <meta name="copyright" content="Saingo Inc. All Rights Reserved">
    <link rel="shortcut icon" href=""/>
    <!--[if IE 6]>
    <link rel="shortcut icon" href="<?php echo NGYP_TEMPLATES_URL;?>/../favicon.ico" type="image/x-icon">
    <![endif]-->
    <style type="text/css">
        body {
            _behavior: url(<?php echo NGYP_TEMPLATES_URL;?>/css/csshover.htc);
        }
    </style>
    <link href="<?php echo NGYP_TEMPLATES_URL; ?>/css/common.css" rel="stylesheet" type="text/css">
    <link href="<?php echo NGYP_TEMPLATES_URL;?>/css/header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo NGYP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo NGYP_TEMPLATES_URL;?>/css/font-awesome.min.css" rel="stylesheet"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo NGYP_TEMPLATES_URL;?>/js/html5shiv.js"></script>
    <script src="<?php echo NGYP_TEMPLATES_URL;?>/js/respond.min.js"></script>
    <![endif]-->
    <!--[if IE 6]>
    <script src="<?php echo NGYP_TEMPLATES_URL;?>/js/IE6_PNG.js"></script>
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
    <script src="<?php echo NGYP_TEMPLATES_URL;?>/js/jquery.js"></script>
    <script src="<?php echo NGYP_TEMPLATES_URL;?>/js/common.js" charset="utf-8"></script>
    <script type="text/javascript">
        var PRICE_FORMAT = '&yen;%s';
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
                            if (menu.attr("hover") > 0) return;
                            menu.masonry({itemSelector: 'dl'});
                            var menu_height = menu.height();
                            if (menu_height < 60) menu.height(80);
                            menu_height = menu.height();
                            var li_top = $(this).position().top;
                            if ((li_top > 60) && (menu_height >= li_top)) $(menu).css("top", -li_top + 50);
                            if ((li_top > 150) && (menu_height >= li_top)) $(menu).css("top", -li_top + 90);
                            if ((li_top > 240) && (li_top > menu_height)) $(menu).css("top", menu_height - li_top + 90);
                            if (li_top > 300 && (li_top > menu_height)) $(menu).css("top", 60 - menu_height);
                            if ((li_top > 40) && (menu_height <= 120)) $(menu).css("top", -5);
                            menu.attr("hover", 1);
                        },
                        function () {
                            $(this).removeClass("hover");
                            var cat_id = $(this).attr("cat_id");
                            $(this).find("div[cat_menu_id='" + cat_id + "']").hide();
                        }
                    );
                }
            );
            $(".head-user-menu dl").hover(function () {
                    $(this).addClass("hover");
                },
                function () {
                    $(this).removeClass("hover");
                });
            $('.head-user-menu .my-mall').mouseover(function () {// 最近浏览的商品
                load_history_information();
                $(this).unbind('mouseover');
            });
            $('.head-user-menu .my-cart').mouseover(function () {// 运行加载购物车
                load_cart_information();
                $(this).unbind('mouseover');
            });
            $('#button').click(function () {
                if ($('#keyword').val() == '') {
                    return false;
                }
            });
           /* $('a').click(function () {
                if ($(this).attr('href') == '') {
                    showTips('功能模块正在建设中,感谢您的光临！', 200, 5)
                    return false;
                }
            })*/
            $(function () {
                $(".quick-menu dl").hover(function () {
                        $(this).addClass("hover");
                    },
                    function () {
                        $(this).removeClass("hover");
                    });

            });
        });
    </script>

    <style>
        <!--
        .category {
            display: block;
        }

        -->
    </style>


</head>
<body>


<!--header-->
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
        <h1 class="site-logo">
            <a href="/"><img src="<?php echo NGYP_TEMPLATES_URL;?>/images/H_logo.jpg" class="pngFix"
                                                                    style="margin-right:8px;"></a><a href="/ngyp/"><img
                        src="<?php echo NGYP_TEMPLATES_URL;?>/images/N_logo.jpg" class="pngFix"></a>
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


<!--分类及导航菜单-->
<nav class="public-nav-layout">
    <div class="wrapper">
        <div class="all-category">

            <div class="title">
                <h3><a href="">农耕优品分类</a></h3>
                <i class="arrow"></i></div>
            <div class="category">
                <ul class="menu">
                    <?php foreach($output['goods_category_info'] as $k=>$v){?>
                        <li cat_id="<?php echo $v['gc_id']?>" class="odd">
                            <div class="class">
                                <span class="ico"><img src="<?php echo NGYP_TEMPLATES_URL;?>/images/category-pic-<?php echo $k+1;?>.jpg"></span>
                                <h4><a href="<?php echo urlShop('cate','index',array('cate_id'=>$v['gc_id']));?>" target="_blank"><?php echo $v['gc_name']?></a></h4>
                                <span class="arrow"></span></div>
                                <div class="sub-class" cat_menu_id="<?php echo $v['gc_id']?>">
                                    <dl>
                                        <?php foreach($v['cateInfo'] as $k2=>$v2){?>
                                        <dt>
                                        <h3><a href="<?php echo urlShop('cate','index',array('cate_id'=>$v2['gc_id']));?>" target="_blank"><?php echo $v2['gc_name']?></a></h3>
                                        </dt>
                                            <dd class="goods-class">
                                                <?php foreach($v2['cateInfo'] as $k3=>$v3){?>
                                                <a href="<?php echo urlShop('cate','index',array('cate_id'=>$v3['gc_id']));?>" target="_blank"><?php echo $v3['gc_name']?></a>
                                            <?php }?>
                                            </dd>
                                        <?php }?>
                                    </dl>
                                </div>

                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>


        <ul class="site-menu">
            <
            <li><a href="/ngyp/index.php?controller=index&action=index" <?php if($output['web_info']['type']==1){ echo ' class="current"'; }?> >首页</a></li>
            <li><a <?php if($output['web_info']['type']==2){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=spyb&action=index">三品一标</a></li>
            <li><a <?php if($output['web_info']['type']=='3'){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=zcdz&action=index">众筹定制</a></li>
            <li><a <?php if($output['web_info']['type']=='4'){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=nznj&action=index">农资农具</a></li>
            <li><a <?php if($output['web_info']['type']=='5'){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=nlms&action=index">农旅民宿</a></li>
            <li><a <?php if($output['web_info']['type']=='6'){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=xffp&action=index">消费扶贫</a></li>
            <li><a <?php if($output['web_info']['type']=='7'){ echo ' class="current"'; }?>  href="/ngyp/index.php?controller=ncgy&action=index">农村公益</a></li>
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
