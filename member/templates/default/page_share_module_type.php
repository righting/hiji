<!DOCTYPE html>
<html  lang="zh">

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
<link rel="stylesheet" href="/shop/templates/default/css/new_base.css" type="text/css" />

<link rel="stylesheet" href="/shop/templates/default/css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="/shop/templates/default/css/personal.css" type="text/css" />

<link href="/jf/templates/default/css/base.css" rel="stylesheet" type="text/css">
<link href="/jf/templates/default/css/header.css" rel="stylesheet" type="text/css">
<link href="/shop/templates/default/css/css/personal.css" rel="stylesheet" type="text/css">

<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var LOGIN_SITE_URL = '<?php echo LOGIN_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
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
            $(".site-menu .links_a").hover(function() {
                    $(this).addClass("hover");
                },
                function() {
                    $(this).removeClass("hover");
                });

            $(".site-menu .links_a").hover(function() {
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
    .clearfix {
        display: block;
    }
    /* .head-search-bar .search-form {
        background-color: #4FB602;
        height: 36px;
        padding: 1px;
    } */
</style>


<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry" style="font-size:12px;">
            您好<?php if($_SESSION['is_login']==1){?> <?php echo $_SESSION['member_nickname']?> <span class="user-class"><?php echo $output['levelInfo']['level_name']?><?php }?></span>，欢迎来到      <a href="/" title="首页" alt="首页">海吉壹佰</a>
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

        <h1 class="site-logo" style="width:390px">
            <a href="/"><img src="/ngyp/templates/default/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a>
            <a href="/member/index.php?controller=page&action=show&page_key=share_about"><img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/share_logo.png"/>
            </a>
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

                <div class="keyword">热门搜索：
                    <ul>
                        <?php foreach($output['setInfo'] as $k=>$v){?>
                            <li><a target="_blank" href="/shop/index.php?controller=search&action=index&keyword=<?php echo $v;?>"><?php echo $v;?></a></li>
                        <?php }?>
                    </ul>
                </div>

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

<?php if($output['page']['page_type']==1){?>
<style>
    .public-nav-layout{
        background: linear-gradient(to right,#ffffff,#ffffff);
    }
    .public-nav-layout .site-menu li a.current {
        color: #4fb702;
        background: url(./fixation/images/m_h.jpg) no-repeat center bottom;
    }
    .public-nav-layout .site-menu li a {
        font-size: 15px;
        font-family: "microsoft yahei";
        font-weight: 600;
        line-height: 40px;
        color: #000;
        height: 40px;
        padding: 0 20px;
        display: inline-block;
        zoom: 1;
    }
    .public-nav-layout .site-menu li a:hover {
        text-decoration: none;
        color: #4fb702!important;
    }

</style>
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
                                <span class="ico"><img src="/ngyp/templates/default//images/category-pic-<?php echo $k+1;?>.jpg"></span>
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
            <li><a <?php if($_GET['page_key']=='zcdz'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=zcdz">众筹定制</a></li>
            <li><a <?php if($_GET['page_key']=='nznj'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=nznj">农资农具</a></li>
            <li><a <?php if($_GET['page_key']=='nlms'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=nlms">农旅民宿</a></li>
            <li><a <?php if($_GET['page_key']=='xffp'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=xffp">消费扶贫</a></li>
        </ul>
    </div>


</nav>
<?php }else if($output['page']['page_type']==2){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if($_GET['page_key']=='consumption_capital'){ echo ' class="current"'; }?>  href="javascript:void(0);">消费资本</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_hjb'){ echo ' class="current"'; }?>  href="/hjb/gl.html">海吉币</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_integral'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=consumption_integral">海吉积分</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_accumulation'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=consumption_accumulation">消费公积金</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_provide'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=consumption_provide">消费养老保险</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_dream'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=consumption_dream">车房梦想基金</a></li>
            <li><a <?php if($_GET['page_key']=='consumption_charity'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=consumption_charity">海吉慈善基金</a></li>

        </ul>
    </div>
</nav>
<?php }else if($output['page']['page_type']==3){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if($_GET['page_key']=='offline_franchised'){ echo ' class="current"'; }?>  href="javascript:void(0);">线下加盟</a></li>
            <li><a <?php if($_GET['page_key']=='offline_brand'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_brand">品牌托管</a></li>
            <li><a <?php if($_GET['page_key']=='offline_24'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_24">24 h 便利店</a></li>
            <li><a <?php if($_GET['page_key']=='offline_capacity'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_capacity">智能售货机</a></li>
            <li><a <?php if($_GET['page_key']=='offline_cross'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_cross">跨境购体验店</a></li>
            <li><a <?php if($_GET['page_key']=='offline_provide'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_provide">养老康乐院</a></li>
            <li><a <?php if($_GET['page_key']=='offline_consumption'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_consumption">消费养老保险卡服务中心</a></li>
        </ul>
    </div>
</nav>
<?php }else if($output['page']['page_type']==4){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if($_GET['page_key']=='share_position'){ echo ' class="current"'; }?>  href="javascript:void(0);">分享阵地</a></li>
            <li><a <?php if($_GET['page_key']=='share_about'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_about">关于我们</a></li>
            <li><a <?php if($_GET['page_key']=='share_module'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_module">分享模块</a></li>
            <li><a <?php if($_GET['page_key']=='share_celebrated'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_celebrated">招贤纳士</a></li>
            <li><a <?php if($_GET['page_key']=='share_college'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_college">海吉商学院</a></li>
            <li><a <?php if($_GET['page_key']=='share_service_centre'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_service_centre">海吉服务中心</a></li>
            <li><a <?php if($_GET['page_key']=='xx'){ echo ' class="current"'; }?>  href="/member/index.php?controller=member_sharemanage">分享绑定</a></li>
            <li><a <?php if($_GET['page_key']=='share_cooperation'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=share_cooperation">合作共赢</a></li>
        </ul>
    </div>
</nav>

<?php }else if($output['page']['page_type']==5){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <li><a <?php if($_GET['page_key']=='member_center'){ echo ' class="current"'; }?>  href="javascript:void(0);">会员中心</a></li>
            <li><a <?php if($_GET['page_key']=='member_develop'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=member_develop">会员发展中心</a></li>
        </ul>
    </div>
</nav>
<?php }else{?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
    <?php $old_nav_list = rkcache('nav', true);
    $tree_model = new Tree();
    $nav_list = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

    $mid_nav = array();
    foreach ($old_nav_list as $key=>$value){
        if($value['nav_modue']==7){
            $mid_nav[] = $value;
        }
    }
    ?>
    <nav class="public-nav-layout">
        <div class="wrapper">
            <ul class="site-menu">
                <?php $page_key = $_GET['page_key'] ?>
                <?php if (is_array($mid_nav) && !empty($mid_nav)) { ?>
                    <?php foreach ($mid_nav as $k => $nav) { ?><?php if (!empty($nav)) { ?>
                        <li><a href="<?php echo $nav['nav_url']; ?>" <?php if($output['current_type']==($k+1)){ echo ' class="current"'; }?> ><?php echo $nav['nav_title']; ?></a></li>
                    <?php }
                    } ?>
                <?php }?>

            </ul>
        </div>
    </nav>
<?php }?>
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



<style>
.video-js .vjs-big-play-button .vjs-icon-placeholder:before,.video-js .vjs-modal-dialog,.vjs-button>.vjs-icon-placeholder:before,.vjs-modal-dialog .vjs-modal-dialog-content{position:absolute;top:0;left:0;width:100%;height:100%}.video-js .vjs-big-play-button .vjs-icon-placeholder:before,.vjs-button>.vjs-icon-placeholder:before{text-align:center}@font-face{font-family:VideoJS;src:url(../font/2.0.0/VideoJS.eot?#iefix) format("eot")}@font-face{font-family:VideoJS;src:url(data:application/font-woff;charset=utf-8;base64,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) format("woff"),url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAAKAIAAAwAgT1MvMlGRXgUAAAEoAAAAVmNtYXDiMBC2AAAB/AAAAUpnbHlmW/HoBwAAA4gAAA9QaGVhZAyD6V8AAADQAAAANmhoZWEOogcgAAAArAAAACRobXR42QAAAAAAAYAAAAB8bG9jYTDINOoAAANIAAAAQG1heHABMAB5AAABCAAAACBuYW1l1cf1oAAAEtgAAAIKcG9zdGZEjeMAABTkAAABgQABAAAHAAAAAKEHAAAAAAAHAAABAAAAAAAAAAAAAAAAAAAAHwABAAAAAQAAwdxheF8PPPUACwcAAAAAANMyzzEAAAAA0zLPMQAAAAAHAAcAAAAACAACAAAAAAAAAAEAAAAfAG0ABwAAAAAAAgAAAAoACgAAAP8AAAAAAAAAAQcAAZAABQAIBHEE5gAAAPoEcQTmAAADXABXAc4AAAIABQMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUGZFZABA8QHxHgcAAAAAoQcAAAAAAAABAAAAAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAcAAAAHAAAABwAAAAAAAAMAAAADAAAAHAABAAAAAABEAAMAAQAAABwABAAoAAAABgAEAAEAAgAA8R7//wAAAADxAf//AAAPAAABAAAAAAAAAAABBgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOAFAAZgCyAMYA5gEeAUgBdAGcAfICLgKOAroDCgOOA7AD6gQ4BHwEuAToBQwFogXoBjYGbAbaB3IHqAABAAAAAAWLBYsAAgAAAREBAlUDNgWL++oCCwAAAwAAAAAGawZrAAIADgAaAAAJAhMEAAMSAAUkABMCAAEmACc2ADcWABcGAALrAcD+QJX+w/5aCAgBpgE9AT0BpggI/lr+w/3+rgYGAVL9/QFSBgb+rgIwAVABUAGbCP5a/sP+w/5aCAgBpgE9AT0BpvrIBgFS/f0BUgYG/q79/f6uAAAAAgAAAAAFQAWLAAMABwAAASERKQERIREBwAEr/tUCVQErAXUEFvvqBBYAAAAEAAAAAAYgBiAABgATACQAJwAAAS4BJxUXNjcGBxc+ATUmACcVFhIBBwEhESEBEQEGBxU+ATcXNwEHFwTQAWVVuAO7AidxJSgF/t/lpc77t18BYf6fASsBdQE+TF1OijuZX/1gnJwDgGSeK6W4GBhqW3FGnFT0AWM4mjT+9AHrX/6f/kD+iwH2/sI7HZoSRDGYXwSWnJwAAAEAAAAABKsF1gAFAAABESEBEQECCwEqAXb+igRg/kD+iwSq/osAAAACAAAAAAVmBdYABgAMAAABLgEnET4BAREhAREBBWUBZVRUZfwRASsBdf6LA4Bkniv9piueAUT+QP6LBKr+iwAAAwAAAAAGIAYPAAUADAAaAAATESEBEQEFLgEnET4BAxUWEhcGAgcVNgA3JgDgASsBdf6LAsUBZVVVZbqlzgMDzqXlASEFBf7fBGD+QP6LBKr+i+Bkniv9piueAvOaNP70tbX+9DSaOAFi9fUBYgAAAAQAAAAABYsFiwAFAAsAEQAXAAABIxEhNSMDMzUzNSEBIxUhESMDFTMVMxECC5YBduCWluD+igOA4AF2luDglgLr/oqWAgrglvyAlgF2AqCW4AF2AAQAAAAABYsFiwAFAAsAEQAXAAABMxUzESETIxUhESMBMzUzNSETNSMRITUBdeCW/org4AF2lgHAluD+ipaWAXYCVeABdgHAlgF2++rglgHA4P6KlgAAAAACAAAAAAXWBdYADwATAAABIQ4BBxEeARchPgE3ES4BAyERIQVA/IA/VQEBVT8DgD9VAQFVP/yAA4AF1QFVP/yAP1UBAVU/A4A/VfvsA4AAAAYAAAAABmsGawAHAAwAEwAbACAAKAAACQEmJw4BBwElLgEnAQUhATYSNyYFAQYCBxYXIQUeARcBMwEWFz4BNwECvgFkTlSH8GEBEgOONemh/u4C5f3QAXpcaAEB/BP+3VxoAQEOAjD95DXpoQESeP7dTlSH8GH+7gPwAmgSAQFYUP4nd6X2Pv4nS/1zZAEBk01NAfhk/v+TTUhLpfY+Adn+CBIBAVhQAdkAAAAFAAAAAAZrBdYADwATABcAGwAfAAABIQ4BBxEeARchPgE3ES4BASEVIQEhNSEFITUhNSE1IQXV+1ZAVAICVEAEqkBUAgJU+xYBKv7WAur9FgLqAcD+1gEq/RYC6gXVAVU//IA/VQEBVT8DgD9V/ayV/tWVlZWWlQADAAAAAAYgBdYADwAnAD8AAAEhDgEHER4BFyE+ATcRLgEBIzUjFTM1MxUUBgcjLgEnET4BNzMeARUFIzUjFTM1MxUOAQcjLgE1ETQ2NzMeARcFi/vqP1QCAlQ/BBY/VAICVP1rcJWVcCog4CAqAQEqIOAgKgILcJWVcAEqIOAgKiog4CAqAQXVAVU//IA/VQEBVT8DgD9V/fcl4CVKICoBASogASogKgEBKiBKJeAlSiAqAQEqIAEqICoBASogAAAGAAAAAAYgBPYAAwAHAAsADwATABcAABMzNSMRMzUjETM1IwEhNSERITUhERUhNeCVlZWVlZUBKwQV++sEFfvrBBUDNZb+QJUBwJX+QJb+QJUCVZWVAAAAAQAAAAAGIAZsAC4AAAEiBgcBNjQnAR4BMz4BNy4BJw4BBxQXAS4BIw4BBx4BFzI2NwEGBx4BFz4BNy4BBUArSh797AcHAg8eTixffwICf19ffwIH/fEeTixffwICf18sTh4CFAUBA3tcXHsDA3sCTx8bATcZNhkBNB0gAn9fX38CAn9fGxn+zRwgAn9fX38CIBz+yhcaXHsCAntcXXsAAAIAAAAABlkGawBDAE8AAAE2NCc3PgEnAy4BDwEmLwEuASchDgEPAQYHJyYGBwMGFh8BBhQXBw4BFxMeAT8BFh8BHgEXIT4BPwE2NxcWNjcTNiYnBS4BJz4BNx4BFw4BBasFBZ4KBgeWBxkNujpEHAMUD/7WDxQCHEU5ug0aB5UHBQudBQWdCwUHlQcaDbo5RRwCFA8BKg8UAhxFOboNGgeVBwUL/ThvlAIClG9vlAIClAM3JEokewkaDQEDDAkFSy0cxg4RAQERDsYcLUsFCQz+/QwbCXskSiR7CRoN/v0MCQVLLRzGDhEBAREOxhwtSwUJDAEDDBsJQQKUb2+UAgKUb2+UAAAAAAEAAAAABmsGawALAAATEgAFJAATAgAlBACVCAGmAT0BPQGmCAj+Wv7D/sP+WgOA/sP+WggIAaYBPQE9AaYICP5aAAAAAgAAAAAGawZrAAsAFwAAAQQAAxIABSQAEwIAASYAJzYANxYAFwYAA4D+w/5aCAgBpgE9AT0BpggI/lr+w/3+rgYGAVL9/QFSBgb+rgZrCP5a/sP+w/5aCAgBpgE9AT0BpvrIBgFS/f0BUgYG/q79/f6uAAADAAAAAAZrBmsACwAXACMAAAEEAAMSAAUkABMCAAEmACc2ADcWABcGAAMOAQcuASc+ATceAQOA/sP+WggIAaYBPQE9AaYICP5a/sP9/q4GBgFS/f0BUgYG/q4dAn9fX38CAn9fX38Gawj+Wv7D/sP+WggIAaYBPQE9Aab6yAYBUv39AVIGBv6u/f3+rgJPX38CAn9fX38CAn8AAAAEAAAAAAYgBiAADwAbACUAKQAAASEOAQcRHgEXIT4BNxEuAQEjNSMVIxEzFTM1OwEhHgEXEQ4BByE3MzUjBYv76j9UAgJUPwQWP1QCAlT9a3CVcHCVcJYBKiAqAQEqIP7WcJWVBiACVD/76j9UAgJUPwQWP1T8gpWVAcC7uwEqIP7WICoBcOAAAgAAAAAGawZrAAsAFwAAAQQAAxIABSQAEwIAEwcJAScJATcJARcBA4D+w/5aCAgBpgE9AT0BpggI/lo4af70/vRpAQv+9WkBDAEMaf71BmsI/lr+w/7D/loICAGmAT0BPQGm/BFpAQv+9WkBDAEMaf71AQtp/vQAAQAAAAAF1ga2ABYAAAERCQERHgEXDgEHLgEnIxYAFzYANyYAA4D+iwF1vv0FBf2+vv0FlQYBUf7+AVEGBv6vBYsBKv6L/osBKgT9v779BQX9vv7+rwYGAVH+/gFRAAAAAQAAAAAFPwcAABQAAAERIyIGHQEhAyMRIREjETM1NDYzMgU/nVY8ASUn/v7O///QrZMG9P74SEi9/tj9CQL3ASjaus0AAAAABAAAAAAGjgcAADAARQBgAGwAAAEUHgMVFAcGBCMiJicmNTQ2NzYlLgE1NDcGIyImNTQ2Nz4BMyEHIx4BFRQOAycyNjc2NTQuAiMiBgcGFRQeAxMyPgI1NC4BLwEmLwImIyIOAxUUHgIBMxUjFSM1IzUzNTMDH0BbWkAwSP7qn4TlOSVZSoMBESAfFS4WlMtIP03TcAGiioNKTDFFRjGSJlAaNSI/akAqURkvFCs9WTY6a1s3Dg8THgocJU4QIDVob1M2RnF9A2vV1WnU1GkD5CRFQ1CATlpTenNTYDxHUYouUhIqQCkkMQTBlFKaNkJAWD+MWkhzRztAPiEbOWY6hn1SJyE7ZS5nZ1I0/JcaNF4+GTAkGCMLFx04Ag4kOF07Rms7HQNsbNvbbNkAAwAAAAAGgAZsAAMADgAqAAABESERARYGKwEiJjQ2MhYBESERNCYjIgYHBhURIRIQLwEhFSM+AzMyFgHd/rYBXwFnVAJSZGemZASP/rdRVj9VFQv+twIBAQFJAhQqR2c/q9AEj/whA98BMkliYpNhYfzd/cgCEml3RTMeM/3XAY8B8DAwkCAwOB/jAAABAAAAAAaUBgAAMQAAAQYHFhUUAg4BBCMgJxYzMjcuAScWMzI3LgE9ARYXLgE1NDcWBBcmNTQ2MzIXNjcGBzYGlENfAUyb1v7SrP7x4SMr4bBpph8hHCsqcJNETkJOLHkBW8YIvYaMYG1gJWldBWhiRQ4cgv797rdtkQSKAn1hBQsXsXUEJgMsjlNYS5WzCiYkhr1mFTlzPwoAAAABAAAAAAWABwAAIgAAARcOAQcGLgM1ESM1PgQ3PgE7AREhFSERFB4CNzYFMFAXsFlorXBOIahIckQwFAUBBwT0AU3+sg0gQzBOAc/tIz4BAjhceHg6AiDXGlddb1ctBQf+WPz9+h40NR4BAgABAAAAAAaABoAASgAAARQCBCMiJzY/AR4BMzI+ATU0LgEjIg4DFRQWFxY/ATY3NicmNTQ2MzIWFRQGIyImNz4CNTQmIyIGFRQXAwYXJgI1NBIkIAQSBoDO/p/Rb2s7EzYUaj15vmh34o5ptn9bK1BNHggIBgIGETPRqZepiWs9Sg4IJRc2Mj5WGWMRBM7+zgFhAaIBYc4DgNH+n84gXUfTJzmJ8JZyyH46YH2GQ2ieIAwgHxgGFxQ9WpfZpIOq7lc9I3VZHzJCclVJMf5eRmtbAXzp0QFhzs7+nwAABwAAAAAHAATPAA4AFwAqAD0AUABaAF0AAAERNh4CBw4BBwYmIycmNxY2NzYmBxEUBRY2Nz4BNy4BJyMGHwEeARcOARcWNjc+ATcuAScjBh8BHgEXFAYXFjY3PgE3LgEnIwYfAR4BFw4BBTM/ARUzESMGAyUVJwMchM2UWwgNq4JHrQgBAapUaAoJcWMBfiIhDiMrAQJLMB0BBAokNAIBPmMiIQ4iLAECSzAeAQUKJDQBP2MiIQ4iLAECSzAeAQUKJDQBAT75g+5B4arNLNIBJ44ByQL9BQ9mvYCKwA8FBQMDwwJVTGdzBf6VB8IHNR08lld9uT4LCRA/qGNxvUwHNR08lld9uT4LCRA/qGNxvUwHNR08lld9uT4LCRA/qGNxvVJkAWUDDEf+tYP5AQAAAAEAAAAABiAGtgAbAAABBAADER4BFzMRITU2ADcWABcVIREzPgE3EQIAA4D+4v6FBwJ/X+D+1QYBJ97eAScG/tXgX38CB/6FBrUH/oX+4v32X38CAlWV3gEnBgb+2d6V/asCf18CCgEeAXsAAAAAEADGAAEAAAAAAAEABwAAAAEAAAAAAAIABwAHAAEAAAAAAAMABwAOAAEAAAAAAAQABwAVAAEAAAAAAAUACwAcAAEAAAAAAAYABwAnAAEAAAAAAAoAKwAuAAEAAAAAAAsAEwBZAAMAAQQJAAEADgBsAAMAAQQJAAIADgB6AAMAAQQJAAMADgCIAAMAAQQJAAQADgCWAAMAAQQJAAUAFgCkAAMAAQQJAAYADgC6AAMAAQQJAAoAVgDIAAMAAQQJAAsAJgEeVmlkZW9KU1JlZ3VsYXJWaWRlb0pTVmlkZW9KU1ZlcnNpb24gMS4wVmlkZW9KU0dlbmVyYXRlZCBieSBzdmcydHRmIGZyb20gRm9udGVsbG8gcHJvamVjdC5odHRwOi8vZm9udGVsbG8uY29tAFYAaQBkAGUAbwBKAFMAUgBlAGcAdQBsAGEAcgBWAGkAZABlAG8ASgBTAFYAaQBkAGUAbwBKAFMAVgBlAHIAcwBpAG8AbgAgADEALgAwAFYAaQBkAGUAbwBKAFMARwBlAG4AZQByAGEAdABlAGQAIABiAHkAIABzAHYAZwAyAHQAdABmACAAZgByAG8AbQAgAEYAbwBuAHQAZQBsAGwAbwAgAHAAcgBvAGoAZQBjAHQALgBoAHQAdABwADoALwAvAGYAbwBuAHQAZQBsAGwAbwAuAGMAbwBtAAAAAgAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAfAAABAgEDAQQBBQEGAQcBCAEJAQoBCwEMAQ0BDgEPARABEQESARMBFAEVARYBFwEYARkBGgEbARwBHQEeAR8EcGxheQtwbGF5LWNpcmNsZQVwYXVzZQt2b2x1bWUtbXV0ZQp2b2x1bWUtbG93CnZvbHVtZS1taWQLdm9sdW1lLWhpZ2gQZnVsbHNjcmVlbi1lbnRlcg9mdWxsc2NyZWVuLWV4aXQGc3F1YXJlB3NwaW5uZXIJc3VidGl0bGVzCGNhcHRpb25zCGNoYXB0ZXJzBXNoYXJlA2NvZwZjaXJjbGUOY2lyY2xlLW91dGxpbmUTY2lyY2xlLWlubmVyLWNpcmNsZQJoZAZjYW5jZWwGcmVwbGF5CGZhY2Vib29rBWdwbHVzCGxpbmtlZGluB3R3aXR0ZXIGdHVtYmxyCXBpbnRlcmVzdBFhdWRpby1kZXNjcmlwdGlvbgVhdWRpbwAAAAAA) format("truetype");font-weight:400;font-style:normal}.video-js .vjs-big-play-button .vjs-icon-placeholder:before,.video-js .vjs-play-control .vjs-icon-placeholder,.vjs-icon-play{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-big-play-button .vjs-icon-placeholder:before,.video-js .vjs-play-control .vjs-icon-placeholder:before,.vjs-icon-play:before{content:"\f101"}.vjs-icon-play-circle{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-play-circle:before{content:"\f102"}.video-js .vjs-play-control.vjs-playing .vjs-icon-placeholder,.vjs-icon-pause{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-play-control.vjs-playing .vjs-icon-placeholder:before,.vjs-icon-pause:before{content:"\f103"}.video-js .vjs-mute-control.vjs-vol-0 .vjs-icon-placeholder,.vjs-icon-volume-mute{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-mute-control.vjs-vol-0 .vjs-icon-placeholder:before,.vjs-icon-volume-mute:before{content:"\f104"}.video-js .vjs-mute-control.vjs-vol-1 .vjs-icon-placeholder,.vjs-icon-volume-low{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-mute-control.vjs-vol-1 .vjs-icon-placeholder:before,.vjs-icon-volume-low:before{content:"\f105"}.video-js .vjs-mute-control.vjs-vol-2 .vjs-icon-placeholder,.vjs-icon-volume-mid{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-mute-control.vjs-vol-2 .vjs-icon-placeholder:before,.vjs-icon-volume-mid:before{content:"\f106"}.video-js .vjs-mute-control .vjs-icon-placeholder,.vjs-icon-volume-high{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-mute-control .vjs-icon-placeholder:before,.vjs-icon-volume-high:before{content:"\f107"}.video-js .vjs-fullscreen-control .vjs-icon-placeholder,.vjs-icon-fullscreen-enter{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-fullscreen-control .vjs-icon-placeholder:before,.vjs-icon-fullscreen-enter:before{content:"\f108"}.video-js.vjs-fullscreen .vjs-fullscreen-control .vjs-icon-placeholder,.vjs-icon-fullscreen-exit{font-family:VideoJS;font-weight:400;font-style:normal}.video-js.vjs-fullscreen .vjs-fullscreen-control .vjs-icon-placeholder:before,.vjs-icon-fullscreen-exit:before{content:"\f109"}.vjs-icon-square{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-square:before{content:"\f10a"}.vjs-icon-spinner{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-spinner:before{content:"\f10b"}.video-js .vjs-subs-caps-button .vjs-icon-placeholder,.video-js .vjs-subtitles-button .vjs-icon-placeholder,.video-js.video-js:lang(en-AU) .vjs-subs-caps-button .vjs-icon-placeholder,.video-js.video-js:lang(en-GB) .vjs-subs-caps-button .vjs-icon-placeholder,.video-js.video-js:lang(en-IE) .vjs-subs-caps-button .vjs-icon-placeholder,.video-js.video-js:lang(en-NZ) .vjs-subs-caps-button .vjs-icon-placeholder,.vjs-icon-subtitles{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-subs-caps-button .vjs-icon-placeholder:before,.video-js .vjs-subtitles-button .vjs-icon-placeholder:before,.video-js.video-js:lang(en-AU) .vjs-subs-caps-button .vjs-icon-placeholder:before,.video-js.video-js:lang(en-GB) .vjs-subs-caps-button .vjs-icon-placeholder:before,.video-js.video-js:lang(en-IE) .vjs-subs-caps-button .vjs-icon-placeholder:before,.video-js.video-js:lang(en-NZ) .vjs-subs-caps-button .vjs-icon-placeholder:before,.vjs-icon-subtitles:before{content:"\f10c"}.video-js .vjs-captions-button .vjs-icon-placeholder,.video-js:lang(en) .vjs-subs-caps-button .vjs-icon-placeholder,.video-js:lang(fr-CA) .vjs-subs-caps-button .vjs-icon-placeholder,.vjs-icon-captions{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-captions-button .vjs-icon-placeholder:before,.video-js:lang(en) .vjs-subs-caps-button .vjs-icon-placeholder:before,.video-js:lang(fr-CA) .vjs-subs-caps-button .vjs-icon-placeholder:before,.vjs-icon-captions:before{content:"\f10d"}.video-js .vjs-chapters-button .vjs-icon-placeholder,.vjs-icon-chapters{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-chapters-button .vjs-icon-placeholder:before,.vjs-icon-chapters:before{content:"\f10e"}.vjs-icon-share{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-share:before{content:"\f10f"}.vjs-icon-cog{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-cog:before{content:"\f110"}.video-js .vjs-play-progress,.video-js .vjs-volume-level,.vjs-icon-circle{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-play-progress:before,.video-js .vjs-volume-level:before,.vjs-icon-circle:before{content:"\f111"}.vjs-icon-circle-outline{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-circle-outline:before{content:"\f112"}.vjs-icon-circle-inner-circle{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-circle-inner-circle:before{content:"\f113"}.vjs-icon-hd{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-hd:before{content:"\f114"}.video-js .vjs-control.vjs-close-button .vjs-icon-placeholder,.vjs-icon-cancel{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-control.vjs-close-button .vjs-icon-placeholder:before,.vjs-icon-cancel:before{content:"\f115"}.video-js .vjs-play-control.vjs-ended .vjs-icon-placeholder,.vjs-icon-replay{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-play-control.vjs-ended .vjs-icon-placeholder:before,.vjs-icon-replay:before{content:"\f116"}.vjs-icon-facebook{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-facebook:before{content:"\f117"}.vjs-icon-gplus{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-gplus:before{content:"\f118"}.vjs-icon-linkedin{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-linkedin:before{content:"\f119"}.vjs-icon-twitter{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-twitter:before{content:"\f11a"}.vjs-icon-tumblr{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-tumblr:before{content:"\f11b"}.vjs-icon-pinterest{font-family:VideoJS;font-weight:400;font-style:normal}.vjs-icon-pinterest:before{content:"\f11c"}.video-js .vjs-descriptions-button .vjs-icon-placeholder,.vjs-icon-audio-description{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-descriptions-button .vjs-icon-placeholder:before,.vjs-icon-audio-description:before{content:"\f11d"}.video-js .vjs-audio-button .vjs-icon-placeholder,.vjs-icon-audio{font-family:VideoJS;font-weight:400;font-style:normal}.video-js .vjs-audio-button .vjs-icon-placeholder:before,.vjs-icon-audio:before{content:"\f11e"}.video-js{display:block;vertical-align:top;box-sizing:border-box;color:#fff;background-color:#000;position:relative;padding:0;font-size:10px;line-height:1;font-weight:400;font-style:normal;font-family:Arial,Helvetica,sans-serif}.video-js:-moz-full-screen{position:absolute}.video-js:-webkit-full-screen{width:100%!important;height:100%!important}.video-js[tabindex="-1"]{outline:0}.video-js *,.video-js :after,.video-js :before{box-sizing:inherit}.video-js ul{font-family:inherit;font-size:inherit;line-height:inherit;list-style-position:outside;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0}.video-js.vjs-16-9,.video-js.vjs-4-3,.video-js.vjs-fluid{width:100%;max-width:100%;height:0}.video-js.vjs-16-9{padding-top:56.25%}.video-js.vjs-4-3{padding-top:75%}.video-js.vjs-fill{width:100%;height:100%}.video-js .vjs-tech{position:absolute;top:0;left:0;width:100%;height:100%}body.vjs-full-window{padding:0;margin:0;height:100%;overflow-y:auto}.vjs-full-window .video-js.vjs-fullscreen{position:fixed;overflow:hidden;z-index:1000;left:0;top:0;bottom:0;right:0}.video-js.vjs-fullscreen{width:100%!important;height:100%!important;padding-top:0!important}.video-js.vjs-fullscreen.vjs-user-inactive{cursor:none}.vjs-hidden{display:none!important}.vjs-disabled{opacity:.5;cursor:default}.video-js .vjs-offscreen{height:1px;left:-9999px;position:absolute;top:0;width:1px}.vjs-lock-showing{display:block!important;opacity:1;visibility:visible}.vjs-no-js{padding:20px;color:#fff;background-color:#000;font-size:18px;font-family:Arial,Helvetica,sans-serif;text-align:center;width:300px;height:150px;margin:0 auto}.vjs-no-js a,.vjs-no-js a:visited{color:#66a8cc}.video-js .vjs-big-play-button{font-size:3em;line-height:1.5em;height:1.5em;width:3em;display:block;position:absolute;top:10px;left:10px;padding:0;cursor:pointer;opacity:1;border:.06666em solid #fff;background-color:#2b333f;background-color:rgba(43,51,63,.7);-webkit-border-radius:.3em;-moz-border-radius:.3em;border-radius:.3em;-webkit-transition:all .4s;-moz-transition:all .4s;-ms-transition:all .4s;-o-transition:all .4s;transition:all .4s}.vjs-big-play-centered .vjs-big-play-button{top:50%;left:50%;margin-top:-.75em;margin-left:-1.5em}.video-js .vjs-big-play-button:focus,.video-js:hover .vjs-big-play-button{border-color:#fff;background-color:#73859f;background-color:rgba(115,133,159,.5);-webkit-transition:all 0s;-moz-transition:all 0s;-ms-transition:all 0s;-o-transition:all 0s;transition:all 0s}.vjs-controls-disabled .vjs-big-play-button,.vjs-error .vjs-big-play-button,.vjs-has-started .vjs-big-play-button,.vjs-using-native-controls .vjs-big-play-button{display:none}.vjs-has-started.vjs-paused.vjs-show-big-play-button-on-pause .vjs-big-play-button{display:block}.video-js button{background:0 0;border:none;color:inherit;display:inline-block;overflow:visible;font-size:inherit;line-height:inherit;text-transform:none;text-decoration:none;transition:none;-webkit-appearance:none;-moz-appearance:none;appearance:none}.video-js .vjs-control.vjs-close-button{cursor:pointer;height:3em;position:absolute;right:0;top:.5em;z-index:2}.video-js .vjs-modal-dialog{background:rgba(0,0,0,.8);background:-webkit-linear-gradient(-90deg,rgba(0,0,0,.8),rgba(255,255,255,0));background:linear-gradient(180deg,rgba(0,0,0,.8),rgba(255,255,255,0));overflow:auto;box-sizing:content-box}.video-js .vjs-modal-dialog>*{box-sizing:border-box}.vjs-modal-dialog .vjs-modal-dialog-content{font-size:1.2em;line-height:1.5;padding:20px 24px;z-index:1}.vjs-menu-button{cursor:pointer}.vjs-menu-button.vjs-disabled{cursor:default}.vjs-workinghover .vjs-menu-button.vjs-disabled:hover .vjs-menu{display:none}.vjs-menu .vjs-menu-content{display:block;padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;overflow:auto;box-sizing:content-box}.vjs-menu .vjs-menu-content>*{box-sizing:border-box}.vjs-scrubbing .vjs-menu-button:hover .vjs-menu{display:none}.vjs-menu li{list-style:none;margin:0;padding:.2em 0;line-height:1.4em;font-size:1.2em;text-align:center;text-transform:lowercase}.vjs-menu li.vjs-menu-item:focus,.vjs-menu li.vjs-menu-item:hover{background-color:#73859f;background-color:rgba(115,133,159,.5)}.vjs-menu li.vjs-selected,.vjs-menu li.vjs-selected:focus,.vjs-menu li.vjs-selected:hover{background-color:#fff;color:#2b333f}.vjs-menu li.vjs-menu-title{text-align:center;text-transform:uppercase;font-size:1em;line-height:2em;padding:0;margin:0 0 .3em 0;font-weight:700;cursor:default}.vjs-menu-button-popup .vjs-menu{display:none;position:absolute;bottom:0;width:10em;left:-3em;height:0;margin-bottom:1.5em;border-top-color:rgba(43,51,63,.7)}.vjs-menu-button-popup .vjs-menu .vjs-menu-content{background-color:#2b333f;background-color:rgba(43,51,63,.7);position:absolute;width:100%;bottom:1.5em;max-height:15em}.vjs-menu-button-popup .vjs-menu.vjs-lock-showing,.vjs-workinghover .vjs-menu-button-popup:hover .vjs-menu{display:block}.video-js .vjs-menu-button-inline{-webkit-transition:all .4s;-moz-transition:all .4s;-ms-transition:all .4s;-o-transition:all .4s;transition:all .4s;overflow:hidden}.video-js .vjs-menu-button-inline:before{width:2.222222222em}.video-js .vjs-menu-button-inline.vjs-slider-active,.video-js .vjs-menu-button-inline:focus,.video-js .vjs-menu-button-inline:hover,.video-js.vjs-no-flex .vjs-menu-button-inline{width:12em}.vjs-menu-button-inline .vjs-menu{opacity:0;height:100%;width:auto;position:absolute;left:4em;top:0;padding:0;margin:0;-webkit-transition:all .4s;-moz-transition:all .4s;-ms-transition:all .4s;-o-transition:all .4s;transition:all .4s}.vjs-menu-button-inline.vjs-slider-active .vjs-menu,.vjs-menu-button-inline:focus .vjs-menu,.vjs-menu-button-inline:hover .vjs-menu{display:block;opacity:1}.vjs-no-flex .vjs-menu-button-inline .vjs-menu{display:block;opacity:1;position:relative;width:auto}.vjs-no-flex .vjs-menu-button-inline.vjs-slider-active .vjs-menu,.vjs-no-flex .vjs-menu-button-inline:focus .vjs-menu,.vjs-no-flex .vjs-menu-button-inline:hover .vjs-menu{width:auto}.vjs-menu-button-inline .vjs-menu-content{width:auto;height:100%;margin:0;overflow:hidden}.video-js .vjs-control-bar{display:none;width:100%;position:absolute;bottom:0;left:0;right:0;height:3em;background-color:#2b333f;background-color:rgba(43,51,63,.7)}.vjs-has-started .vjs-control-bar{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;visibility:visible;opacity:1;-webkit-transition:visibility .1s,opacity .1s;-moz-transition:visibility .1s,opacity .1s;-ms-transition:visibility .1s,opacity .1s;-o-transition:visibility .1s,opacity .1s;transition:visibility .1s,opacity .1s}.vjs-has-started.vjs-user-inactive.vjs-playing .vjs-control-bar{visibility:visible;opacity:0;-webkit-transition:visibility 1s,opacity 1s;-moz-transition:visibility 1s,opacity 1s;-ms-transition:visibility 1s,opacity 1s;-o-transition:visibility 1s,opacity 1s;transition:visibility 1s,opacity 1s}.vjs-controls-disabled .vjs-control-bar,.vjs-error .vjs-control-bar,.vjs-using-native-controls .vjs-control-bar{display:none!important}.vjs-audio.vjs-has-started.vjs-user-inactive.vjs-playing .vjs-control-bar{opacity:1;visibility:visible}.vjs-has-started.vjs-no-flex .vjs-control-bar{display:table}.video-js .vjs-control{position:relative;text-align:center;margin:0;padding:0;height:100%;width:4em;-webkit-box-flex:none;-moz-box-flex:none;-webkit-flex:none;-ms-flex:none;flex:none}.vjs-button>.vjs-icon-placeholder:before{font-size:1.8em;line-height:1.67}.video-js .vjs-control:focus,.video-js .vjs-control:focus:before,.video-js .vjs-control:hover:before{text-shadow:0 0 1em #fff}.video-js .vjs-control-text{border:0;clip:rect(0 0 0 0);height:1px;overflow:hidden;padding:0;position:absolute;width:1px}.vjs-no-flex .vjs-control{display:table-cell;vertical-align:middle}.video-js .vjs-custom-control-spacer{display:none}.video-js .vjs-progress-control{cursor:pointer;-webkit-box-flex:auto;-moz-box-flex:auto;-webkit-flex:auto;-ms-flex:auto;flex:auto;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;min-width:4em}.vjs-live .vjs-progress-control{display:none}.vjs-no-flex .vjs-progress-control{width:auto}.video-js .vjs-progress-holder{-webkit-box-flex:auto;-moz-box-flex:auto;-webkit-flex:auto;-ms-flex:auto;flex:auto;-webkit-transition:all .2s;-moz-transition:all .2s;-ms-transition:all .2s;-o-transition:all .2s;transition:all .2s;height:.3em}.video-js .vjs-progress-control .vjs-progress-holder{margin:0 10px}.video-js .vjs-progress-control:hover .vjs-progress-holder{font-size:1.666666666666666666em}.video-js .vjs-progress-holder .vjs-load-progress,.video-js .vjs-progress-holder .vjs-load-progress div,.video-js .vjs-progress-holder .vjs-play-progress{position:absolute;display:block;height:100%;margin:0;padding:0;width:0;left:0;top:0}.video-js .vjs-play-progress{background-color:#fff}.video-js .vjs-play-progress:before{font-size:.9em;position:absolute;right:-.5em;top:-.333333333333333em;z-index:1}.video-js .vjs-load-progress{background:#bfc7d3;background:rgba(115,133,159,.5)}.video-js .vjs-load-progress div{background:#fff;background:rgba(115,133,159,.75)}.video-js .vjs-time-tooltip{background-color:#fff;background-color:rgba(255,255,255,.8);-webkit-border-radius:.3em;-moz-border-radius:.3em;border-radius:.3em;color:#000;float:right;font-family:Arial,Helvetica,sans-serif;font-size:1em;padding:6px 8px 8px 8px;pointer-events:none;position:relative;top:-3.4em;visibility:hidden;z-index:1}.video-js .vjs-progress-holder:focus .vjs-time-tooltip{display:none}.video-js .vjs-progress-control:hover .vjs-progress-holder:focus .vjs-time-tooltip,.video-js .vjs-progress-control:hover .vjs-time-tooltip{display:block;font-size:.6em;visibility:visible}.video-js .vjs-progress-control .vjs-mouse-display{display:none;position:absolute;width:1px;height:100%;background-color:#000;z-index:1}.vjs-no-flex .vjs-progress-control .vjs-mouse-display{z-index:0}.video-js .vjs-progress-control:hover .vjs-mouse-display{display:block}.video-js.vjs-user-inactive .vjs-progress-control .vjs-mouse-display{visibility:hidden;opacity:0;-webkit-transition:visibility 1s,opacity 1s;-moz-transition:visibility 1s,opacity 1s;-ms-transition:visibility 1s,opacity 1s;-o-transition:visibility 1s,opacity 1s;transition:visibility 1s,opacity 1s}.video-js.vjs-user-inactive.vjs-no-flex .vjs-progress-control .vjs-mouse-display{display:none}.vjs-mouse-display .vjs-time-tooltip{color:#fff;background-color:#000;background-color:rgba(0,0,0,.8)}.video-js .vjs-slider{position:relative;cursor:pointer;padding:0;margin:0 .45em 0 .45em;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:#73859f;background-color:rgba(115,133,159,.5)}.video-js .vjs-slider:focus{text-shadow:0 0 1em #fff;-webkit-box-shadow:0 0 1em #fff;-moz-box-shadow:0 0 1em #fff;box-shadow:0 0 1em #fff}.video-js .vjs-mute-control{cursor:pointer;-webkit-box-flex:none;-moz-box-flex:none;-webkit-flex:none;-ms-flex:none;flex:none;padding-left:2em;padding-right:2em;padding-bottom:3em}.video-js .vjs-volume-control{cursor:pointer;margin-right:1em;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex}.video-js .vjs-volume-control.vjs-volume-horizontal{width:5em}.video-js .vjs-volume-panel .vjs-volume-control{visibility:visible;opacity:0;width:1px;height:1px;margin-left:-1px}.video-js .vjs-volume-panel{-webkit-transition:width 1s;-moz-transition:width 1s;-ms-transition:width 1s;-o-transition:width 1s;transition:width 1s}.video-js .vjs-volume-panel .vjs-mute-control:active~.vjs-volume-control,.video-js .vjs-volume-panel .vjs-mute-control:focus~.vjs-volume-control,.video-js .vjs-volume-panel .vjs-mute-control:hover~.vjs-volume-control,.video-js .vjs-volume-panel .vjs-volume-control.vjs-slider-active,.video-js .vjs-volume-panel .vjs-volume-control:active,.video-js .vjs-volume-panel .vjs-volume-control:focus,.video-js .vjs-volume-panel .vjs-volume-control:hover,.video-js .vjs-volume-panel:active .vjs-volume-control,.video-js .vjs-volume-panel:focus .vjs-volume-control,.video-js .vjs-volume-panel:hover .vjs-volume-control{visibility:visible;opacity:1;position:relative;-webkit-transition:visibility .1s,opacity .1s,height .1s,width .1s,left 0s,top 0s;-moz-transition:visibility .1s,opacity .1s,height .1s,width .1s,left 0s,top 0s;-ms-transition:visibility .1s,opacity .1s,height .1s,width .1s,left 0s,top 0s;-o-transition:visibility .1s,opacity .1s,height .1s,width .1s,left 0s,top 0s;transition:visibility .1s,opacity .1s,height .1s,width .1s,left 0s,top 0s}.video-js .vjs-volume-panel .vjs-mute-control:active~.vjs-volume-control.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-mute-control:focus~.vjs-volume-control.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-mute-control:hover~.vjs-volume-control.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-volume-control.vjs-slider-active.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-volume-control:active.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-volume-control:focus.vjs-volume-horizontal,.video-js .vjs-volume-panel .vjs-volume-control:hover.vjs-volume-horizontal,.video-js .vjs-volume-panel:active .vjs-volume-control.vjs-volume-horizontal,.video-js .vjs-volume-panel:focus .vjs-volume-control.vjs-volume-horizontal,.video-js .vjs-volume-panel:hover .vjs-volume-control.vjs-volume-horizontal{width:5em;height:3em}.video-js .vjs-volume-panel.vjs-volume-panel-horizontal.vjs-slider-active,.video-js .vjs-volume-panel.vjs-volume-panel-horizontal:active,.video-js .vjs-volume-panel.vjs-volume-panel-horizontal:focus,.video-js .vjs-volume-panel.vjs-volume-panel-horizontal:hover{width:9em;-webkit-transition:width .1s;-moz-transition:width .1s;-ms-transition:width .1s;-o-transition:width .1s;transition:width .1s}.video-js .vjs-volume-panel .vjs-volume-control.vjs-volume-vertical{height:8em;width:3em;left:-3.5em;-webkit-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s 1s,left 1s 1s,top 1s 1s;-moz-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s 1s,left 1s 1s,top 1s 1s;-ms-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s 1s,left 1s 1s,top 1s 1s;-o-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s 1s,left 1s 1s,top 1s 1s;transition:visibility 1s,opacity 1s,height 1s 1s,width 1s 1s,left 1s 1s,top 1s 1s}.video-js .vjs-volume-panel .vjs-volume-control.vjs-volume-horizontal{-webkit-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s,left 1s 1s,top 1s 1s;-moz-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s,left 1s 1s,top 1s 1s;-ms-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s,left 1s 1s,top 1s 1s;-o-transition:visibility 1s,opacity 1s,height 1s 1s,width 1s,left 1s 1s,top 1s 1s;transition:visibility 1s,opacity 1s,height 1s 1s,width 1s,left 1s 1s,top 1s 1s}.video-js.vjs-no-flex .vjs-volume-panel .vjs-volume-control.vjs-volume-horizontal{width:5em;height:3em;visibility:visible;opacity:1;position:relative;-webkit-transition:none;-moz-transition:none;-ms-transition:none;-o-transition:none;transition:none}.video-js.vjs-no-flex .vjs-volume-control.vjs-volume-vertical,.video-js.vjs-no-flex .vjs-volume-panel .vjs-volume-control.vjs-volume-vertical{position:absolute;bottom:3em;left:.5em}.video-js .vjs-volume-panel{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex}.video-js .vjs-volume-bar{margin:1.35em .45em}.vjs-volume-bar.vjs-slider-horizontal{width:5em;height:.3em}.vjs-volume-bar.vjs-slider-vertical{width:.3em;height:5em;margin:1.35em auto}.video-js .vjs-volume-level{position:absolute;bottom:0;left:0;background-color:#fff}.video-js .vjs-volume-level:before{position:absolute;font-size:.9em}.vjs-slider-vertical .vjs-volume-level{width:.3em}.vjs-slider-vertical .vjs-volume-level:before{top:-.5em;left:-.3em}.vjs-slider-horizontal .vjs-volume-level{height:.3em}.vjs-slider-horizontal .vjs-volume-level:before{top:-.3em;right:-.5em}.video-js .vjs-volume-panel.vjs-volume-panel-vertical{width:4em}.vjs-volume-bar.vjs-slider-vertical .vjs-volume-level{height:100%}.vjs-volume-bar.vjs-slider-horizontal .vjs-volume-level{width:100%}.video-js .vjs-volume-vertical{width:3em;height:8em;bottom:8em;background-color:#2b333f;background-color:rgba(43,51,63,.7)}.video-js .vjs-volume-horizontal .vjs-menu{left:-2em}.vjs-poster{display:inline-block;vertical-align:middle;background-repeat:no-repeat;background-position:50% 50%;background-size:contain;background-color:#000;cursor:pointer;margin:0;padding:0;position:absolute;top:0;right:0;bottom:0;left:0;height:100%}.vjs-poster img{display:block;vertical-align:middle;margin:0 auto;max-height:100%;padding:0;width:100%}.vjs-has-started .vjs-poster{display:none}.vjs-audio.vjs-has-started .vjs-poster{display:block}.vjs-using-native-controls .vjs-poster{display:none}.video-js .vjs-live-control{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:flex-start;-webkit-align-items:flex-start;-ms-flex-align:flex-start;align-items:flex-start;-webkit-box-flex:auto;-moz-box-flex:auto;-webkit-flex:auto;-ms-flex:auto;flex:auto;font-size:1em;line-height:3em}.vjs-no-flex .vjs-live-control{display:table-cell;width:auto;text-align:left}.video-js .vjs-time-control{-webkit-box-flex:none;-moz-box-flex:none;-webkit-flex:none;-ms-flex:none;flex:none;font-size:1em;line-height:3em;min-width:2em;width:auto;padding-left:1em;padding-right:1em}.vjs-live .vjs-time-control{display:none}.video-js .vjs-current-time,.vjs-no-flex .vjs-current-time{display:none}.vjs-no-flex .vjs-remaining-time.vjs-time-control.vjs-control{width:0!important;white-space:nowrap}.video-js .vjs-duration,.vjs-no-flex .vjs-duration{display:none}.vjs-time-divider{display:none;line-height:3em}.vjs-live .vjs-time-divider{display:none}.video-js .vjs-play-control .vjs-icon-placeholder{cursor:pointer;-webkit-box-flex:none;-moz-box-flex:none;-webkit-flex:none;-ms-flex:none;flex:none}.vjs-text-track-display{position:absolute;bottom:3em;left:0;right:0;top:0;pointer-events:none}.video-js.vjs-user-inactive.vjs-playing .vjs-text-track-display{bottom:1em}.video-js .vjs-text-track{font-size:1.4em;text-align:center;margin-bottom:.1em;background-color:#000;background-color:rgba(0,0,0,.5)}.vjs-subtitles{color:#fff}.vjs-captions{color:#fc6}.vjs-tt-cue{display:block}video::-webkit-media-text-track-display{-moz-transform:translateY(-3em);-ms-transform:translateY(-3em);-o-transform:translateY(-3em);-webkit-transform:translateY(-3em);transform:translateY(-3em)}.video-js.vjs-user-inactive.vjs-playing video::-webkit-media-text-track-display{-moz-transform:translateY(-1.5em);-ms-transform:translateY(-1.5em);-o-transform:translateY(-1.5em);-webkit-transform:translateY(-1.5em);transform:translateY(-1.5em)}.video-js .vjs-fullscreen-control{cursor:pointer;-webkit-box-flex:none;-moz-box-flex:none;-webkit-flex:none;-ms-flex:none;flex:none}.vjs-playback-rate .vjs-playback-rate-value,.vjs-playback-rate>.vjs-menu-button{position:absolute;top:0;left:0;width:100%;height:100%}.vjs-playback-rate .vjs-playback-rate-value{pointer-events:none;font-size:1.5em;line-height:2;text-align:center}.vjs-playback-rate .vjs-menu{width:4em;left:0}.vjs-error .vjs-error-display .vjs-modal-dialog-content{font-size:1.4em;text-align:center}.vjs-error .vjs-error-display:before{color:#fff;content:'X';font-family:Arial,Helvetica,sans-serif;font-size:4em;left:0;line-height:1;margin-top:-.5em;position:absolute;text-shadow:.05em .05em .1em #000;text-align:center;top:50%;vertical-align:middle;width:100%}.vjs-loading-spinner{display:none;position:absolute;top:50%;left:50%;margin:-25px 0 0 -25px;opacity:.85;text-align:left;border:6px solid rgba(43,51,63,.7);box-sizing:border-box;background-clip:padding-box;width:50px;height:50px;border-radius:25px}.vjs-seeking .vjs-loading-spinner,.vjs-waiting .vjs-loading-spinner{display:block}.vjs-loading-spinner:after,.vjs-loading-spinner:before{content:"";position:absolute;margin:-6px;box-sizing:inherit;width:inherit;height:inherit;border-radius:inherit;opacity:1;border:inherit;border-color:transparent;border-top-color:#fff}.vjs-seeking .vjs-loading-spinner:after,.vjs-seeking .vjs-loading-spinner:before,.vjs-waiting .vjs-loading-spinner:after,.vjs-waiting .vjs-loading-spinner:before{-webkit-animation:vjs-spinner-spin 1.1s cubic-bezier(.6,.2,0,.8) infinite,vjs-spinner-fade 1.1s linear infinite;animation:vjs-spinner-spin 1.1s cubic-bezier(.6,.2,0,.8) infinite,vjs-spinner-fade 1.1s linear infinite}.vjs-seeking .vjs-loading-spinner:before,.vjs-waiting .vjs-loading-spinner:before{border-top-color:#fff}.vjs-seeking .vjs-loading-spinner:after,.vjs-waiting .vjs-loading-spinner:after{border-top-color:#fff;-webkit-animation-delay:.44s;animation-delay:.44s}@keyframes vjs-spinner-spin{100%{transform:rotate(360deg)}}@-webkit-keyframes vjs-spinner-spin{100%{-webkit-transform:rotate(360deg)}}@keyframes vjs-spinner-fade{0%{border-top-color:#73859f}20%{border-top-color:#73859f}35%{border-top-color:#fff}60%{border-top-color:#73859f}100%{border-top-color:#73859f}}@-webkit-keyframes vjs-spinner-fade{0%{border-top-color:#73859f}20%{border-top-color:#73859f}35%{border-top-color:#fff}60%{border-top-color:#73859f}100%{border-top-color:#73859f}}.vjs-chapters-button .vjs-menu ul{width:24em}.video-js .vjs-subs-caps-button+.vjs-menu .vjs-captions-menu-item .vjs-menu-item-text .vjs-icon-placeholder{position:absolute}.video-js .vjs-subs-caps-button+.vjs-menu .vjs-captions-menu-item .vjs-menu-item-text .vjs-icon-placeholder:before{font-family:VideoJS;content:"\f10d";font-size:1.5em;line-height:inherit}.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-custom-control-spacer{-webkit-box-flex:auto;-moz-box-flex:auto;-webkit-flex:auto;-ms-flex:auto;flex:auto}.video-js.vjs-layout-tiny:not(.vjs-fullscreen).vjs-no-flex .vjs-custom-control-spacer{width:auto}.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-audio-button,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-captions-button,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-chapters-button,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-current-time,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-descriptions-button,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-duration,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-mute-control,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-playback-rate,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-progress-control,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-remaining-time,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-subtitles-button,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-time-divider,.video-js.vjs-layout-tiny:not(.vjs-fullscreen) .vjs-volume-control{display:none}.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-audio-button,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-captions-button,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-chapters-button,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-current-time,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-descriptions-button,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-duration,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-mute-control,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-playback-rate,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-remaining-time,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-subtitles-button,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-time-divider,.video-js.vjs-layout-x-small:not(.vjs-fullscreen) .vjs-volume-control{display:none}.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-captions-button,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-chapters-button,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-current-time,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-descriptions-button,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-duration,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-mute-control,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-playback-rate,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-remaining-time,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-subtitles-button .vjs-audio-button,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-time-divider,.video-js.vjs-layout-small:not(.vjs-fullscreen) .vjs-volume-control{display:none}.vjs-modal-dialog.vjs-text-track-settings{background-color:#2b333f;background-color:rgba(43,51,63,.75);color:#fff;height:70%}.vjs-text-track-settings .vjs-modal-dialog-content{display:table}.vjs-text-track-settings .vjs-track-settings-colors,.vjs-text-track-settings .vjs-track-settings-controls,.vjs-text-track-settings .vjs-track-settings-font{display:table-cell}.vjs-text-track-settings .vjs-track-settings-controls{text-align:right;vertical-align:bottom}.vjs-text-track-settings fieldset{margin:5px;padding:3px;border:none}.vjs-text-track-settings fieldset span{display:inline-block;margin-left:5px}.vjs-text-track-settings legend{color:#fff;margin:0 0 5px 0}.vjs-text-track-settings .vjs-label{position:absolute;clip:rect(1px 1px 1px 1px);clip:rect(1px,1px,1px,1px);display:block;margin:0 0 5px 0;padding:0;border:0;height:1px;width:1px;overflow:hidden}.vjs-track-settings-controls button:active,.vjs-track-settings-controls button:focus{outline-style:solid;outline-width:medium;background-image:linear-gradient(0deg,#fff 88%,#73859f 100%)}.vjs-track-settings-controls button:hover{color:rgba(43,51,63,.75)}.vjs-track-settings-controls button{background-color:#fff;background-image:linear-gradient(-180deg,#fff 88%,#73859f 100%);color:#2b333f;cursor:pointer;border-radius:2px}.vjs-track-settings-controls .vjs-default-button{margin-right:1em}@media print{.video-js>:not(.vjs-tech):not(.vjs-poster){visibility:hidden}}@media \0screen{.vjs-user-inactive.vjs-playing .vjs-control-bar :before{content:""}}@media \0screen{.vjs-has-started.vjs-user-inactive.vjs-playing .vjs-control-bar{visibility:hidden}}






blockquote,
body,
dd,
div,
dl,
dt,
fieldset,
form,
h1,
h2,
h3,
h4,
h5,
h6,
html,
input,
li,
ol,
p,
pre,
ul {
    padding: 0;
    margin: 0
}

address,
caption,
cite,
code,
em,
h1,
h2,
h3,
h4,
h5,
h6,
pre,
strong,
table,
td,
th {
    font-size: 1em;
    font-style: normal;
    font-weight: 400
}

strong {
    font-weight: 700
}

ol,
ul {
    list-style: none outside none
}

fieldset,
img {
    border: medium none;
    vertical-align: middle
}

caption,
th {
    text-align: left
}

table {
    border-collapse: collapse;
    border-spacing: 0
}

body {
    font: 12px/20px "Hiragino Sans GB", "Microsoft Yahei", arial, 宋体, "Helvetica Neue", Helvetica, STHeiTi, sans-serif;
    color: #333;
    background: #FFF none repeat scroll 0 0;
    min-width: 1200px
}

input,
select,
textarea {
    font: 12px/20px Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif
}

cite,
em,
i {
    font-style: normal
}

button,
input,
select,
textarea {
    outline: 0
}

html {
    min-height: 101%
}

a {
    color: #333;
    text-decoration: none;
    outline: medium none;
    -webkit-transition-property: color;
    -webkit-transition-duration: .3s;
    -webkit-transition-timing-function: ease
}

a:active,
a:link,
a:visited {
    text-decoration: none
}

a:hover {
    color: #C81623;
    text-decoration: none
}

.over_hidden {
    display: block;
    overflow-x: hidden;
    overflow-y: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
}


.clearfix:after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    line-height: 0;
    visibility: hidden
}

html[xmlns] .clearfix {
    display: block
}

*html .clearfix {
    height: 1%
}

time {
    color: #777
}

article,
aside,
dialog,
figure,
footer,
header,
menu,
nav,
section {
    display: block
}

.banner {
    width: 100%;
    height: 480px;
    overflow: hidden;
}

.banner img {
    width: 100%;
    height: 100%;
}

.main {
    width: 100%;
    background: #f3f3f3;
    font-family: "方正黑体简体";
}





.headline {
    width: 100%;
    height: 80px;
    line-height: 80px;
    color: #803fd7;
    font-size: 30px;
    text-align: center;
    min-width: 1200px;
    border-bottom: 1px solid #e8e8e8;
}

.sharemodule {
    width: 1200px;
    margin: 0 auto;
    overflow: hidden;
    background-color: #FFFFFF;
}

.sharemodule-left {
    float: left;
    width: 200px;
    margin-top: 10px;
}

.sharemodule-left a {
    margin-top: 10px;
    display: block;
    width: 187px;
    height: 52px;
    background: url(./templates/default/images/about/navigation.png)0 0 no-repeat;
    overflow: hidden;
}

.sharemodule-left a>p {
    margin: 0 auto;
    display: block;
    font-size: 18px;
    letter-spacing: 3px;
    text-indent: 3px;
    text-align: center;
    width: 175px;
    height: 42px;
    line-height: 42px;
    margin-top: 4px;
}


.sharemodule-left a>p:hover {
    background: #9737df;
    color: #fff;
    border-radius: 0!important;
}

.sharemodule-bei {
    background: #9737df;
    color: #fff!important;
    border-radius: 0!important;
}

.sharemodule-right {
    float: left;
    margin-top: 10px;
    margin-left: 4px;
    width: 765px;
    border: 1px solid #e8e8e8;
    margin-bottom: 50px;
    padding-bottom: 20px;
}

.sharemodule-right-a ul {
    margin-top: 12px;
    margin-left: 12px;
    width: 740px;
    height: 235px;
    overflow: hidden;
}

.sharemodule-right-li1 {
    float: left;
    width: 368px;
    height: 100%;
}

.sharemodule-right-li2 {
    float: left;
    width: 352px;
    height: 100%;
    overflow: hidden;
    margin-left: 20px;
    font-size: 20px;
}

.sharemodule-right-a1 {
    height: 207px;
    width: 100%;
}

.sharemodule-right-a1 img {
    width: 100%;
    height: 100%;
}

.sharemodule-right-a2 {
    height: 28px;
    line-height: 28px;
}

.sharemodule-right-a2 span {

    vertical-align: middle;
    font-size: 14px;
    overflow: hidden;
}

.fenxiang-a{
    display: inline-block;
    width: 240px;
    color: #333333;
}


.fenxiang{
    display: inline-block;
    width: 16px;
    height: 18px;
    background: url("./fixation/images/sharemodule2.png");
    background-size: contain;
    margin-left: 95px;
}

.fenxiang2 {
    display: none;
    width: 16px;
    height: 18px;
    background: url("./fixation/images/sharemodule2.png");
    background-size: contain;
    margin-left: 95px;
}

.sharemodule-right-b {
    width: 100%;
    height: 40px;
    background-color: #966dbc;
    color: #FFFFFF;
    padding-left: 10px;
    line-height: 40px;
}

.sharemodule-right-c {
    width: 350px;
    height: 194px;
    border-left: 1px solid #e8e8e8;
    border-bottom: 1px solid #e8e8e8;
    border-right: 1px solid #e8e8e8;
}

.sharemodule-right-c p {
    height: 37px;
    line-height: 37px;
    overflow: hidden;
    width: 100%;
}

.sharemodule-right-d {
    width: 100%;
    overflow: hidden;
    margin-top: 30px;
}

.sharemodule-right-d  ul{
    overflow: hidden;
    margin-left: -39px;

}

.sharemodule-right-d ul>li {
    float: left;
    height: 218px;
    width: 230px;
    border: 1px solid #e8e8e8;
    margin-top: 5px;
    margin-left: 36px;
}

.sharemodule-right-d1 {
    margin: 0 auto;
    width: 210px;
    height: 135px;
    margin-top: 8px;
}

.sharemodule-right-d1 img {
    width: 100%;
    height: 100%;
}

.sharemodule-right-d ul>li p {
    width: 210px;
    height: 40px;
    margin: 0 auto;
    font-size: 14px;
    color: #333333;
    overflow: hidden;
    margin-top: 8px;
}

.sharemodule-right-d2 {
     width: 16px;
     height: 18px;
     margin-left: 200px;
     margin-top: 2px;
 }

.sharemodule-right-d2 img {
    width: 100%;
    height: 100%;
}

.sharemodule-right-d3 {
    display: none;
    width: 16px;
    height: 18px;
    margin-left: 200px;
    margin-top: 2px;
}

.sharemodule-right-d3 img {
    width: 100%;
    height: 100%;
}

.sharemodule-guang {
    width: 210px;
    overflow: hidden;
    padding-left: 19px;
}

.sharemodule-guang-a {
    width: 208px;
    overflow: hidden;
    border: 1px solid #e8e8e8;
    border-radius: 5px;
    margin-top: 10px;
}

.sharemodule-guang-a1 {
    width: 100%;
    font-size: 25px;
    line-height: 40px;
    text-align: center;
    background-color: #803fd7;
    color: #FFFFFF;
}

.sharemodule-guang-a2 {
    font-size: 14px;
    color: #333333;
    width: 200px;
    margin: 0 auto;
}

.sharemodule-guang-a3 {
    padding-top: 10px;
    padding-bottom: 20px;
}

.sharemodule-guang-b {
    width: 208px;
    border-radius: 5px;
    color: #333333;
    border: 1px solid #e8e8e8;
}

.sharemodule-guang-b1 {
    width: 100%;
    font-size: 18px;
    line-height: 40px;
    text-align: center;
    border-bottom: 1px solid #e8e8e8;
}

.sharemodule-guang-b2 {
    width: 200px;
    margin: 0 auto;
    font-size: 14px;
}

.sharemodule-guang-b2 p:first-child {
    padding-top: 10px;
}

.sharemodule-guang-b2 p:last-child {
    text-align: center;
    padding-bottom: 20px;
}

.sharemodule-video {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -250px;
    margin-top: -200px;
    overflow: hidden;
}

.layermbtn span:first-child {
    width: 100%;
}

.video-js {
    width: 500px!important;
    height: 400px!important;
}

.bg{
    position: fixed;
    background: rgba(0,0,0,0.3);
    top:0px;
    left: 0px;
    display: none;
    z-index: 999;
}

.video-js .vjs-big-play-button {
    margin-left: 202px;
    margin-top: 163px;
}

.sharemodule-video-guan {
    height: 40px;
    width: 500px;
    background-color: #FFFFFF;
    line-height: 40px;
    font-size: 15px;
}

.sharemodule-video-guan span{
    display: inline-block;
    vertical-align: middle;
}

.sharemodule-video-guan-a {
    width: 400px;
    height: 100%;
    overflow: hidden;
    text-indent: 8px;
}

.sharemodule-video-guan-b {
    width: 16px;
    height: 16px;
    background: url("./fixation/images/sharemodule5.png");
    background-size: contain;
    margin-left: 50px;
}

.denxiang-weixing-a {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -23px;
    margin-left: 227px;
    background: url(./fixation/images/social.png) no-repeat -73px -87px;
}

.denxiang-weibo-a {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -23px;
    margin-left: 276px;
    background: url(./fixation/images/social.png) no-repeat -130px -87px;
}

.denxiang-qq-a {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -23px;
    margin-left: 320px;
    background: url(./fixation/images/social.png) no-repeat -73px -20px;
}





.denxiang-weixing {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -29px;
    margin-left: 379px;
    background: url(./fixation/images/social.png) no-repeat -73px -87px;
}

.denxiang-weibo {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -29px;
    margin-left: 429px;
    background: url(./fixation/images/social.png) no-repeat -130px -87px;
}

.denxiang-qq {
    position: absolute;
    width: 32px;
    height: 32px;
    margin-top: -29px;
    margin-left: 479px;
    background: url(./fixation/images/social.png) no-repeat -73px -20px;
}

.gong {
    display: none;
}
</style>

<?php
    $bannerModel = Model('banner');
    $bannerInfo=$bannerModel->where(['c_id'=>28])->find();
?>

<?php if(!empty($bannerInfo)){?>
<div class="banner">
    <a target="_blank" href="<?php if(!empty($bannerInfo['img_link'])){echo $bannerInfo['img_link'];}else{echo 'javascript:;';}?>">
        <img src="<?php echo $bannerInfo['img_url']?>"></a>
</div>
<?php }?>
<div class="headline">
    可怕的是，比你优秀的人比你还努力! !
</div>

<?php
$article_model  = Model('article');
$article=Model()->table('article')->where(['ac_id'=>$_GET['type']])->limit(9)->order('article_id desc')->select();

$where['ac_id'] =  array('in','42,43,44,45');
$fireArticle=Model()->table('article')->where($where)->limit(5)->order(' article_time desc')->select();

?>


<div class="main">
    <div class="sharemodule">
        <div class="sharemodule-left">
            <a href="/member/index.php?controller=page&action=show&page_key=share_module&type=42">
                <p <?php if($_GET['page_key']=='share_module' && $_GET['type']==42){echo 'class="sharemodule-bei"';}?>>软文分享</p>
            </a>
            <a href="/member/index.php?controller=page&action=show&page_key=share_module">
                <p>视频分享</p>
            </a>
            <a href="/member/index.php?controller=page&action=show&page_key=share_module&type=43">
                <p <?php if($_GET['page_key']=='share_module' && $_GET['type']==43){echo 'class="sharemodule-bei"';}?>>音频分享</p>
            </a>
            <a href="/member/index.php?controller=page&action=show&page_key=share_module&type=44">
                <p <?php if($_GET['page_key']=='share_module' && $_GET['type']==44){echo 'class="sharemodule-bei"';}?>>图片分享</p>
            </a>
            <a href="/member/index.php?controller=page&action=show&page_key=share_module&type=45">
                <p <?php if($_GET['page_key']=='share_module' && $_GET['type']==45){echo 'class="sharemodule-bei"';}?>>H5分享</p>
            </a>
        </div>

        <div class="sharemodule-right">
            <div class="sharemodule-right-d">
                <ul class="sharemodule-vison">
                    <script id="vision-age3" type="text/template">
                    <?php foreach($article as $k=>$v){?>
                        <li>
                            <a target="_blank" href="<?php echo urlMember('article','show',array('article_id'=>$v['article_id'])); ?>">
                                <div class="sharemodule-right-d1">
                                    <img src="<?php echo $v['article_image']?>">
                                </div>
                                <p><?php echo $v['article_title']?></p>
                            </a>
                        </li>
                    <?php }?>
                    </script>
                </ul>
            </div>
        </div>

        <div class="sharemodule-guang">

            <div class="sharemodule-guang-a">
                <p class="sharemodule-guang-a1" style="font-size:16px;">
                    热门分享
                </p>
                <div class="sharemodule-guang-a3">
                    <?php foreach($fireArticle as $k=>$v){?>
                        <a target="_blank" href="<?php echo urlMember('article','show',array('article_id'=>$v['article_id'])); ?>">   <p style="margin:5px auto;width:100%;overflow: hidden;" class="sharemodule-guang-a2">·  <?php echo $v['article_title']?></p></a>
                    <?php }?>
                </div>

            </div>

            <div class="sharemodule-guang-a3">
                <div class="sharemodule-guang-b">
                    <p class="sharemodule-guang-b1">
                        原创有奖·欢迎投稿
                    </p>
                    <div class="sharemodule-guang-b2">
                        <p>投稿邮箱: </p>
                        <p>LS@hiji100.com</p>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="bg">
            <div class="sharemodule-video">
                <div class="sharemodule-video-guan">
                    <span class="sharemodule-video-guan-a"></span>
                    <a href="javascript:void(0);">
                        <span class="sharemodule-video-guan-b"></span>
                    </a>
                </div>

                <video id="my-video" class="video-js" controls preload="auto">
                    <source src="http://jq22com.qiniudn.com/jq22-sp.mp4" type="video/mp4"  >
                </video>
            </div>
    </div>



</div>

<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" ></script>

<script src="/member/resource/js/template.js"></script>

<script src="/member/resource/js/jquery.min.js"></script>

<script src="/member/resource/js/share.js"></script>
<script src="/member/resource/js/video.min.js"></script>
<script src="/member/resource/js/zh-CN.js"></script>

<script>
    //获取当前浏览器宽高
    $(".bg").height($(window).height());
    $(".bg").width($(window).width());

    $.getJSON('/ngyp/index.php?controller=index&action=indexajax&type=2',{},function (data) {

        var list = data.msg;
        //模板加载数据
        $(".sharemodule-right-li1").html(template("vision-age2",list[0]));

        $(".sharemodule-vison").html(template("vision-age3",data));

        //视频数据传输
        $(".sharemodule-right-a1").click(function () {
            $(this).parent().parent().parent().parent().parent().parent().siblings(".bg").show();
            $("source").attr("src",$(this).attr("data-src"));
            $(".vjs-tech").attr("poster",$(this).find("img").attr("src"));
            $("video").attr("src",$(this).attr("data-src"));
            $(".sharemodule-video-guan-a").html($(this).siblings(".sharemodule-right-a2").find("span").text());

        });

    });





    //分享
    /*    $(".fenxiang").click(function () {
     $(this).parent().parent().siblings('.gong').show();
     $(".fenxiang").hide();
     $(".fenxiang2").css("display","inline-block");
     });

     $(".fenxiang2").click(function () {
     $(this).parent().parent().siblings(".gong").hide();
     $(".fenxiang").show();
     $(".fenxiang2").hide();

     });

     $(".sharemodule-right-d2").click(function () {
     $(this).parent().siblings('.gong').show();
     $(".sharemodule-right-d2").hide();
     $(".sharemodule-right-d3").show();
     //分享设置
     $(this).parent().siblings('.gong').on("click",function(){
     $(this).socialShare("weixinShare",{
     url:'h211w2w',
     content:'qq1212',
     title:''
     });
     });

     $(this).parent().siblings('.gong').on("click",function(){
     $(this).socialShare("sinaWeibo",{
     url:'',
     content:'assws',
     title:''
     });
     });

     $(this).parent().siblings('.gong').on("click",function(){
     $(this).socialShare("qZone",{
     url:'',
     content:'13dd',
     title:''
     });
     })
     });

     $(".sharemodule-right-d3").click(function () {
     $(this).parent().siblings('.gong').hide();
     $(".sharemodule-right-d2").show();
     $(".sharemodule-right-d3").hide();


     });*/

    /* $(function() {
     //分享设置
     $(".denxiang-weixing").on("click",function(){
     $(this).socialShare("weixinShare",{
     url:'h211w2w',
     content:'122',
     title:''
     });
     });

     $(".denxiang-weibo").on("click",function(){
     $(this).socialShare("sinaWeibo",{
     url:'',
     content:'322',
     title:''
     });
     });

     $(".denxiang-qq").on("click",function(){
     $(this).socialShare("qZone",{
     url:'',
     content:'2343',
     title:''
     });
     })

     });*/






</script>


<script>
    window.onload = function(){
      $('.ke-toolbar').remove();

    }
</script>


<div style="clear: both;"></div>
<div id="web_chat_dialog" style="display: none;float:right;">
</div>
<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>
<div class="wrapper" style="display:none">
    <div class="rg"></div>
</div>
<div id="faq" style="border-top:1px solid #9e0a06;">
    <div class="wrapper">
        <ul>
            <?php if (is_array($output['article_list']) && !empty($output['article_list'])) { ?>
               <?php foreach ($output['article_list'] as $k => $article_class) { ?><?php if (!empty($article_class)) { ?>
                    <li>
                    <dl class="s<?php echo '' . $k + 1; ?>">
                        <dt><?php if (is_array($article_class['class'])) echo $article_class['class']['ac_name']; ?></dt><?php if (is_array($article_class['list']) && !empty($article_class['list'])) { ?><?php foreach ($article_class['list'] as $article) { ?>
                            <dd>
                            <a href="<?php if ($article['article_url'] != '') echo $article['article_url']; else echo urlMember('article', 'show', array('article_id' => $article['article_id'])); ?>"
                               title="<?php echo $article['article_title']; ?>"> <?php echo $article['article_title']; ?> </a>
                            </dd><?php }
                        } ?></dl></li><?php }
                } ?>
                <?php } ?>


            <li style="width:34%;">
                <dl class="s6">
                    <dt>官方微信</dt>
                    <dd><?php echo $output['index_adv']['index_qr']?></dd>
                </dl>
            </li>

        </ul>
    </div>
</div>

<div id="f_rz" class="wrapper">
    <ul>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_01.jpg" /></a></li>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_02.jpg" /></a></li>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_03.jpg" /></a></li>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_04.jpg" /></a></li>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_05.jpg" /></a></li>
        <li><a href=""><img src="/jf/templates/default/images/f_rz-4_06.jpg" /></a></li>
    </ul>
</div>

<?php if(!empty($output['linkInfo'])){?>
<div id="flink" class="wrapper">
    <div style="border:1px solid #fff; margin:10px auto; padding:10px; text-align:center;">
        <h3 style=" margin:0 0 10px 0;border-bottom:1px solid #fff;">友情链接</h3>
        <?php foreach($output['linkInfo'] as $k=>$v){?>
            <?php if($k==0){?>
                <a href="<?php echo $v['link_url'];?>" target="_blank"><?php echo $v['link_title'];?></a>
            <?php }else{?>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="<?php echo $v['link_url'];?>" target="_blank"><?php echo $v['link_title'];?></a>
            <?php }?>
        <?php }?>
    </div>
</div>
<?php }?>



<script type="text/javascript">
    $(document).ready(function(){

        $("#leftsead a").hover(function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").show();
            }else{
                $(this).children("img.hides").show();
                $(this).children("img.shows").hide();
                $(this).children("img.hides").animate({marginRight:'0px'},'slow');
            }
        },function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").hide('slow');
            }else{
                $(this).children("img.hides").animate({marginRight:'-143px'},'slow',function(){$(this).hide();$(this).next("img.shows").show();});
            }
        });

        $("#top_btn").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});

    });
</script>

<script type="text/javascript" src="/jf/templates/default/js/scroll.js" charset="utf-8"></script>
<script type="text/javascript" src="/jf/templates/default/js/home_spyb.js" charset="utf-8"></script>

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