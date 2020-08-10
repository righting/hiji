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

        <h1 class="site-logo" style="font-size:0">
            <a href="/"><img src="/ngyp/templates/default/images/H_logo.jpg" class="pngFix" style="margin-right:8px;"></a>
            <?php if(in_array("30", $output['page_type'])){?>
            <a href="/"> 12<img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/ngyp_logo.jpg" class="pngFix">         </a>
            <?php }else if(in_array("32", $output['page_type'])){?>
                <a href="/hjb/"><img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/consumption_logo.png" class="pngFix">         </a>
            <?php }else if(in_array("33", $output['page_type'])){?>
                <a href="/member/index.php?controller=page&action=show&page_key=offline_brand"><img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/offline_logo.png" class="pngFix">         </a>
            <?php }else if(in_array("34", $output['page_type'])){?>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about"><img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/share_logo.png" class="pngFix">         </a>
            <?php }else if(in_array("35", $output['page_type'])){?>
                <a href="/">    23432  <img style="max-width:374px;max-height:65px; " src="/member/templates/default/new_images/memb_logo.png" class="pngFix">         </a>
            <?php }else {?>

            <?php }?>

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

<?php if(in_array("30", $output['page_type'])){?>
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
            <li><a <?php if($_GET['page_key']=='nzgy'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=nzgy">农村公益</a></li>
        </ul>
    </div>


</nav>
<?php }else if(in_array("32", $output['page_type'])){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
    <?php $old_nav_list = rkcache('nav', true);
    $tree_model = new Tree();
    $nav_list = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

    $mid_nav = array();
    foreach ($old_nav_list as $key=>$value){
        if($value['nav_modue']==5){
            $mid_nav[] = $value;
        }
    }
    ?>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <!-- 消费资本 -->
            <?php $page_key = $_GET['page_key'] ?>
            <?php if (is_array($mid_nav) && !empty($mid_nav)) { ?>
                <?php foreach ($mid_nav as $k => $nav) { ?><?php if (!empty($nav)) { ?>
                    <li><a href="<?php echo $nav['nav_url']; ?>" <?php if($output['current_type']==($k+1)){ echo ' class="current"'; }?> <?php if($k==0){ echo ' style="display:none;"'; }?> ><?php echo $nav['nav_title']; ?></a></li>
                <?php }
                } ?>
            <?php }?>

        </ul>
    </div>
</nav>
<?php }else if(in_array("33", $output['page_type'])){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
    <?php $old_nav_list = rkcache('nav', true);
    $tree_model = new Tree();
    $nav_list = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

    $mid_nav = array();
    foreach ($old_nav_list as $key=>$value){
        if($value['nav_modue']==6){
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
                        <li><a href="<?php echo $nav['nav_url']; ?>" <?php if($output['current_type']==($k+1)){ echo ' class="current"'; }?> <?php if($k==0){ echo ' style="display:none;"'; }?>><?php echo $nav['nav_title'];?></a></li>
                    <?php }
                    } ?>
                <?php }?>

            </ul>
        </div>
    </nav>
<?php }else if(in_array("34", $output['page_type'])){?>
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
                        <li><a href="<?php echo $nav['nav_url']; ?>"  <?php if($output['current_type']==($k+1)){ echo ' class="current"'; }?> <?php if($k==0){ echo ' style="display:none;"'; }?> ><?php echo $nav['nav_title']; ?></a></li>
                    <?php }
                    } ?>
                <?php }?>

            </ul>
        </div>
    </nav>

<?php }else if(in_array("35", $output['page_type'])){?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
            <!--<li><a <?php /*if($_GET['page_key']=='member_center'){ echo ' class="current"'; }*/?>  href="javascript:void(0);">会员中心</a></li>-->
            <li><a <?php if($_GET['page_key']=='member_develop'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=member_develop">会员发展中心</a></li>
        </ul>
    </div>
</nav>
<?php }elseif($_GET['page_key']=='service_centre'){?>
    <nav class="public-nav-layout">
        <div class="wrapper">
            <ul class="site-menu">
                <li><a class="current" href="javascript:void(0);">服务中心</a></li>
                <li><a <?php if($output['type']=='member'){ echo ' class="current"'; }?>  href="/member/index.php?controller=help&action=help">消费者服务</a></li>
                <li><a <?php if($output['type']=='store'){ echo ' class="current"'; }?>  href="/member/index.php?controller=help_store&action=help">商家服务</a></li>
            </ul>
        </div>
    </nav>
<?php }else{?>
<style>
.public-nav-layout{background: linear-gradient(to right,#b229aa,#6b42e0);}
</style>
<nav class="public-nav-layout">
    <div class="wrapper">
        <ul class="site-menu">
           <!-- <li><a <?php /*if($_GET['page_key']=='offline_franchised'){ echo ' class="current"'; }*/?>  href="javascript:void(0);">线下加盟</a></li>-->
            <li><a <?php if($_GET['page_key']=='offline_brand'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_brand">品牌托管</a></li>
            <li><a <?php if($_GET['page_key']=='offline_24'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_24">24 h 便利店</a></li>
            <li><a <?php if($_GET['page_key']=='offline_capacity'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_capacity">智能售货机</a></li>
            <li><a <?php if($_GET['page_key']=='offline_cross'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_cross">跨境购体验店</a></li>
            <li><a <?php if($_GET['page_key']=='offline_provide'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_provide">养老康乐院</a></li>
            <li><a <?php if($_GET['page_key']=='offline_consumption'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=offline_consumption">消费养老保险卡服务中心</a></li>
            <li><a <?php if($_GET['page_key']=='green_develop'){ echo ' class="current"'; }?>  href="/member/index.php?controller=page&action=show&page_key=green_develop">绿色发展</a></li>
        </ul>
    </div>
</nav>
<?php }?>


<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" ></script>
<?php if($_GET['page_key']=='consumption_dream'){?>
<script src="/member/resource/js/slick.js" ></script>
<script>
    $(function() {

        $('.slider').slick({
            dots: true,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

        $('.slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            var current_li = $(this).closest('.wrap_nav').find('.ification_top>.list-tab li').eq(nextSlide);
            current_li.siblings().removeClass('current');
            current_li.addClass('current');
        });
    })
    </script>
<?php }?>

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