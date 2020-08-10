<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'].$output['webTitle'];?></title>
<meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
<meta name="description" content="<?php echo $output['seo_description']; ?>" />
<meta name="author" content="CCYNet">
<meta name="copyright" content="CCYNet Inc. All Rights Reserved">
<style type="text/css">
body {
_behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
}
.nc-appbar-tabs a.compare { display: none !important;}
</style>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<link href="<?php echo RESOURCE_SITE_URL;?>/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />



    <link href="<?php echo jf_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/header.css" rel="stylesheet" type="text/css">





    <!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
Number.prototype.toFixed = function(d)
{
    var s=this+"";if(!d)d=0;
    if(s.indexOf(".")==-1)s+=".";s+=new Array(d+1).join("0");
    if (new RegExp("^(-|\\+)?(\\d+(\\.\\d{0,"+ (d+1) +"})?)\\d*$").test(s))
    {
        var s="0"+ RegExp.$2, pm=RegExp.$1, a=RegExp.$3.length, b=true;
        if (a==d+2){a=s.match(/\d/g); if (parseInt(a[a.length-1])>4)
        {
            for(var i=a.length-2; i>=0; i--) {a[i] = parseInt(a[i])+1;
            if(a[i]==10){a[i]=0; b=i!=1;} else break;}
        }
        s=a.join("").replace(new RegExp("(\\d+)(\\d{"+d+"})\\d$"),"$1.$2");
    }if(b)s=s.substr(1);return (pm+s).replace(/\.$/, "");} return this+"";
};
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<?php if ($_GET['controller'] != 'buy_virtual') {?>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/goods_cart.js"></script>
<?php } else { ?>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/buy_virtual.js"></script>
<?php } ?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->


    <script>
        $(function(){
            $(".head-user-menu dl").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });
        })
    </script>
</head>
<body>
<?php require_once template('layout/car_layout_top');?>

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
                <?php echo $_SESSION['member_nickname']?></a>         <a href="<?php echo urlShop('pointgrade', 'index'); ?>"><span class="user-class"><?php echo $output['levelInfo']['level_name']?><?php }?></span></a>，欢迎来到      <a href="/" title="首页" alt="首页">海吉壹佰</a>
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
        <h1 class="site-logo"><a href="/" target="_blank"><img src="<?php echo jf_TEMPLATES_URL;?>/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a><a href="/shop/index.php?controller=member&action=home"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/user_logo.png" /></a>
        <div class="wrap">
            <div class="marquee-wrap">
            <div>
                <ul class="marquee-icon">
                <li>购分红，购赚钱</li>
                <li>拼实惠，赚红利</li>
                <li>不只是好产品</li>
                </ul>
            </div>
            </div>
        </div></h1>
        <div class="head-search-bar" style="overflow: visible;">
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
</div>

<header class="ncc-head-layout">
    <?php if ($_GET['action'] != 'pd_pay' && $_POST['payment_code'] != 'wxpay') { ?>
    <ul class="ncc-flow" style="float:none; width:1200px;">
      <li class="<?php echo $output['buy_step'] == 'step1' ? 'current' : '';?>"><i class="step1"></i>
        <p><?php echo $lang['cart_index_ensure_order'];?></p>
        <sub></sub>
        <div class="hr"></div>
      </li>
      <li class="<?php echo $output['buy_step'] == 'step2' ? 'current' : '';?>"><i class="step2"></i>
        <p><?php echo $lang['cart_index_ensure_info'];?></p>
        <sub></sub>
        <div class="hr"></div>
      </li>
      <li class="<?php echo $output['buy_step'] == 'step3' ? 'current' : '';?>"><i class="step3"></i>
        <p><?php echo $lang['cart_index_payment'];?></p>
        <sub></sub>
        <div class="hr"></div>
      </li>
      <li class="<?php echo $output['buy_step'] == 'step4' ? 'current' : '';?>"><i class="step4"></i>
        <p><?php echo $lang['cart_index_buy_finish'];?></p>
        <sub></sub>
        <div class="hr"></div>
      </li>
    </ul>
    <?php } ?>
  </header>
<div class="ncc-wrapper">

  <?php require_once($tpl_file);?>

</div><?php require_once template('footer');?>
<script>
//提示信息
$('.tip').poshytip({
	className: 'tip-yellowsimple',
	showOn: 'hover',
	alignTo: 'target',
	alignX: 'center',
	alignY: 'top',
	offsetX: 0,
	offsetY: 5,
	allowTipHover: false
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
</body>
</html>
