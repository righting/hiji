<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
    <title><?php echo $output['html_title'].$output['webTitle'];?></title>
    <meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
    <meta name="description" content="<?php echo $output['seo_description']; ?>" />
    <meta name="author" content="CCYNet">
    <meta name="copyright" content="CCYNet Inc. All Rights Reserved">
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <?php echo html_entity_decode($output['setting_config']['qq_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['sina_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_qqzone_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_sinaweibo_appcode'],ENT_QUOTES); ?>
    <link rel="stylesheet" href="<?php echo SHOP_TEMPLATES_URL;?>/css/member.css" />
    <link rel="stylesheet" href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_base.css" />
    <link rel="stylesheet" href="<?php echo SHOP_TEMPLATES_URL;?>/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo SHOP_TEMPLATES_URL;?>/css/personal.css" />

    <link href="<?php echo jf_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo jf_TEMPLATES_URL;?>/css/font-awesome.min.css" rel="stylesheet" />


    <script>
        var SITEURL = "<?php echo SHOP_SITE_URL;?>";
    </script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/layer/layer.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL; ?>/js/kefu-tool.js"></script>

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
        <h1 class="site-logo"><a href="/" target="_blank"><img src="<?php echo jf_TEMPLATES_URL;?>/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a><a href="/shop/index.php?controller=member&action=home"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/user_logo.png" /></a>
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






<div class="personal-head">
    <div class="personal-head-center" style="height:50px;">
        <!--<div class="personal-head-logo" style="height:40px;margin-top:4px;">
            <a href="<?php /*echo urlShop('index') */?>">
                <img style="height:40px;" src="/member/templates/default/images/logo.png" />
            </a>
        </div>-->
        <div class="personal-head-nav">
            <ul>
                <?php foreach ($output['right'] as $right_key=>$right_value){ ?>
                <?php if ($right_key == $output['member_sign']) { ?>
                    <li style="line-height:50px; "><a href="<?php echo $right_value['url']; ?>" class="current"><?php echo $right_value['name']; ?></a></li>
                <?php } else { ?>
                <li style="line-height:50px; ">
                    <a href="<?php echo $right_value['url']; ?>"><?php echo $right_value['name']; ?><?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?><i class="fa fa-angle-down"><?php }?></i></a>
                    <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?>
                    <div class="xnav">
                        <?php foreach ($right_value['child'] as $right_c_k=>$right_c_v){ ?>
                        <dl>
                            <dt><a href="javascript:;" style="color: #EA746B"><?php echo $right_c_k; ?></a></dt>
                            <?php if (!empty($right_c_v)) { ?>
                                <?php foreach ($right_c_v as $right_t_k=>$right_t_v){ ?>
                                    <dd><a href="<?php echo $right_t_v['url']; ?>"><?php echo $right_t_v['name']; ?></a></dd>
                                <?php }?>
                            <?php }?>
                        </dl>
                        <?php }?>
                    </div>
                        <?php }?>
                </li>
                    <?php }?>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<style>
    .personal-left .personal-left-active{
        background: #9737DF;
        display: block;
        border: 1px solid #9737df;
        border-radius: 2px;
    }

    .personal-left .personal-left-active a{
        text-align: center;
        color: #fff;
    }
    .personal-left .personal-left-active a:hover{
        color: #c4c4c4;
    }
</style>
<div class="personal-main">
    <div class="personal-left">
        <h3><a href="<?php echo urlShop('member', 'home'); ?>" style="color: #9737df" title="个人中心">个人中心</a></h3>
        <?php if (!empty($output['left'])) { ?>
            <?php foreach ($output['left'] as $left_f_k=>$left_f_v) { ?>
                <dl>
                    <dt><?php echo $left_f_v['name']; ?><i class="fa fa-caret-down"></i></dt>
                    <?php if (!empty($left_f_v['child'])) { ?>
                        <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                            <dd <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?> class="personal-left-active" <?php } ?>>
                                <span style="display:block;float:left;width: 18px;height: 25px;line-height:25px;">
                                    <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/white/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php }else{ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/gray/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php } ?>

                                </span>
                                <a href="<?php echo $left_c_v['url']; ?>" style="float: left;margin-left: 5px;: "><?php echo $left_c_v['name'];?></a>
                            </dd>
                        <?php } ?>
                    <?php } ?>
                </dl>
            <?php } ?>
        <?php } ?>
    </div>
    <?php require_once($tpl_file);?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
<?php require_once template('layout/member_layout/footer'); ?>
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