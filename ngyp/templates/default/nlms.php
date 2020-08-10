<link href="<?php echo NGYP_TEMPLATES_URL; ?>/css/nlms.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/swiper-3.4.2.min.css">
<style>
    .clearfix {
        display: block;
    }
    .carousel {
        width: 100%;
        height: 480px;
        overflow: hidden;
    }

    .carousel-stm {
        width: 100%;
        height: 100%;
    }

    .carousel-stm>.frequency>li>a{
        display: block;
    }

    .frequency li {
        width: 100%;
        height: 480px;
        overflow: hidden;
    }

    .banner{
        width: 100%;
        height: 480px;

    }

    .swiper-pagination-bullet{
        width: 15px;
        height: 15px;
    }

    .swiper-pagination-bullet-active{
        background-color: #52d04c !important;
    }

    .swiper-pagination{
        background: none!important;
    }
</style>


<div class="ms-container">
    <!-- 头部轮播加导航 Begin -->
    <div class="ms-nav-wrap clearfix" style="display: block;">


        <!-- 侧边栏导航 End -->
        <!-- 焦点图 Begin-->
        <div class="carousel">
            <div class="carousel-stm swiper-container ">
                <ul  class="swiper-wrapper frequency">
                    <?php foreach($output['top_banner'] as $k=>$v){?>
                        <li class="swiper-slide">
                            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
                        </li>
                    <?php }?>
                </ul>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- 侧边栏导航 Begin -->
        <div class="aside-nav-div">
            <ul class="aside-nav">
                <?php foreach ($output['nlmsCateInfo'] as $k => $v) { ?>
                    <li>
                        <div class="beauty clearfix">
                            <span class="ms-icon"></span>
                            <h1><a target="_blank"
                                   href="<?php echo urlShop('cate', 'index', array('cate_id' => $v['gc_id'])); ?>"><?php echo $v['gc_name'] ?></a>
                            </h1>
                            <i class="right-arrow"></i>
                        </div>
                        <p>
                            <?php foreach ($v['info'] as $key => $val) { ?>
                                <a target="_blank"
                                   href="<?php echo urlShop('cate', 'index', array('cate_id' => $val['gc_id'])); ?>"><?php echo $val['gc_name'] ?></a>
                            <?php } ?>
                        </p>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- 焦点图 End-->
    </div>
    <!-- 头部轮播加导航 End -->

    <div class="recommend">
        <div class="recommend-title">
            <i></i>
            <h1>时令热推</h1>
        </div>
        <div class="recommend-wrap">
            <!--<div class="ms-tabs-header clearfix">
                <ul class="ms-tabs-nav fl clearfix">
                    <li>桂林</li>
                    <li>张家界</li>
                    <li>东江湖</li>
                    <li>贵州</li>
                    <li>厦门</li>
                    <li>重庆</li>
                    <li>云南</li>
                    <li>越南</li>
                    <li>铁路专列</li>
                </ul>
                 <a class="fr" href="">更多<span>桂林</span>&gt;</a>
            </div>-->
            <?php
            $goodsModel = Model('goods');
            $where['gc_id_1'] = 5422;
            $where['goods_verify'] = 1;
            $randGoodsInfo = $goodsModel->where($where)->limit(8)->order(' rand() ')->select();
            $nlmsGoodsInfo = $goodsModel->where($where)->limit(8)->order(' rand() ')->select();
            $where['gc_id_2'] = 5437;
            $ddywGoodsInfo = $goodsModel->where($where)->limit(5)->order(' rand() ')->select();
            $where['gc_id_2'] = 5438;
            $zjjhGoodsInfo = $goodsModel->where($where)->limit(12)->order(' rand() ')->select();

            /**获取文章**/
            $articleModel = Model('article');
            $where['ac_id'] = 53;
            $where['limit'] = 4;
            //最新资讯
            $newNews = $articleModel->getArticleList($where);
            //公司旅游
            $where['ac_id'] = 54;
            $newOne = $articleModel->getArticleList($where);
            //出国旅游
            $where['ac_id'] = 55;
            $newsTwo = $articleModel->getArticleList($where);
            //旅游指南
            $where['ac_id'] = 56;
            $newsThree = $articleModel->getArticleList($where);

            //随机推荐
            $randArticleInfo = $articleModel->table('article')->where(['ac_id' => ['in', '53,54,55,56']])->limit(10)->order(' rand() ')->select();
            ?>

            <div class="ma-tabs-panel clearfix">
                <div class="ms-left-ads act-img fl">
                    <a href=""><img src="<?php echo NGYP_TEMPLATES_URL ?>/images/nlms/ms-goods-01.jpg"></a>
                </div>

                <ul class="ms-recom-goods clearfix">
                    <?php foreach ($randGoodsInfo as $k => $v) { ?>
                        <li>
                            <div class="recom-img-wrap act-img">
                                <a target="_blank"
                                   href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><img
                                            src="<?php echo $v['goods_image'] ?>"></a>
                            </div>
                            <p class="recom-goods-title">
                                <a target="_blank"
                                   href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><?php echo $v['goods_name'] ?></a>
                            </p>
                            <h3 class="recom-goods-price">￥<span><?php echo $v['goods_price'] ?></span>起</h3>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </div>

    <div class="part-nlms clearfix" style="display: block;">
        <div class="part-nlms-left">
            <div class="part-nlms-title">
                <i></i>
                <h1>农旅名宿</h1>
            </div>
            <div class="nlms-img-wrap">
                <img src="<?php echo NGYP_TEMPLATES_URL ?>/images/nlms/ms_01.jpg">
            </div>
        </div>
        <div class="part-nlms-right fl">
            <div class="part-nlms-nav clearfix" style="display:block;">
                <ul class="nlms-nav-tab clearfix">
                    <?php foreach ($output['nlmsCateInfo'] as $k => $v) { ?>
                        <li><a target="_blank"
                               href="<?php echo urlShop('cate', 'index', array('cate_id' => $v['gc_id'])); ?>"><?php echo $v['gc_name'] ?></a>
                        </li>
                    <?php } ?>
                </ul>

            </div>
            <ul class="nlms-nav-item clearfix" style="display:block;">
                <?php foreach ($nlmsGoodsInfo as $k => $v) { ?>
                    <li>
                        <div class="nlms-goods-wrap act-img">
                            <a target="_blank"
                               href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><img
                                        src="<?php echo $v['goods_image'] ?>"></a>
                        </div>
                        <p class="ms-goods-title">
                            <a style="display:block;" target="_blank"
                               href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><?php echo $v['goods_name'] ?></a>
                        </p>
                        <div class="ms-goods-price clearfix">
                            <h3>￥<em><?php echo $v['goods_price'] ?></em>起</h3>
                            <span>省￥<?php echo $v['goods_marketprice'] - $v['goods_price'] ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="ms-part-4 clearfix" style="display: block">
        <div class="wrapper clearfix" style="display: block">
            <div class="company-group fl">
                <a href=""><img src="<?php echo NGYP_TEMPLATES_URL ?>/images/nlms/ms_04.jpg"></a>
            </div>
            <div class="customize fl">
                <a href=""><img src="<?php echo NGYP_TEMPLATES_URL ?>/images/nlms/ms_05.jpg"></a>
            </div>
        </div>

    </div>

    <div class="part-fun clearfix" style="display: block">
        <div class="part-fun-title clearfix" style="display: block">
            <h1>当地玩乐</h1>
        </div>
        <div class="fun-left">
            <ul class="fun-left-top clearfix" style="display: block">
                <?php foreach ($ddywGoodsInfo as $k => $v) { ?>
                    <?php if ($k < 3) { ?>
                        <li>
                            <div class="fun-img-wrap act-img">
                                <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><img src="<?php echo $v['goods_image'] ?>"></a>
                            </div>
                            <p class="fun-title"><a href=""><?php echo $v['goods_name'] ?></a></p>
                            <h1 class="fun-price">￥<?php echo $v['goods_price'] ?>起</h1>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>

            <div class="fun-left-bottom clearfix" style="display: block">
                <?php foreach ($ddywGoodsInfo as $k => $v) { ?>
                    <?php if ($k == 3) { ?>
                        <div class="fun-img-wrap act-img fr">
                            <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>">
                                <img src="<?php echo $v['goods_image']; ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="fun-right">
            <?php foreach ($ddywGoodsInfo as $k => $v) { ?>
                <?php if ($k == 4) { ?>
                    <div class="fun-img-wrap act-img">
                        <a target="_blank"
                           href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><img
                                    src="<?php echo $v['goods_image'] ?>"></a>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>


    </div>

    <div class="plans-wrap">
        <div class="wrapper">
            <div class="plans-title clearfix" style="display: block">
                <h1>自驾计划 Plans</h1>
                <!-- <a class="plans-more" href="">MORE<i></i></a> -->
            </div>
            <ul class="plans-detail clearfix">
                <?php foreach ($zjjhGoodsInfo as $k => $v) { ?>
                    <li class="act-img">
                        <a title="<?php echo $v['goods_name'] ?>" target="_blank"
                           href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"><img
                                    src="<?php echo $v['goods_image'] ?>"></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="ms-news">
        <div class="ms-news-title">
            <h1><span>新闻</span>News</h1>
            <div class="ms-news-subtitle">
                <h3>旅游那些事、关注生活...</h3>
                <h3>Recently to ...</h3>
            </div>
        </div>
        <!-- <ul class="news-header-nav clearfix">
            <li>公司旅游</li>
            <li>农旅特色</li>
            <li>旅游资讯</li>
        </ul> -->
        <div class="news-main">
            <div class="news-wrap clearfix" style="display: block">
                <div class="news-left">
                    <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL */?>/images/nlms/ms-goods-10.jpg"></a>-->
                    <?php foreach($output['ad_a'] as $k=>$v){?>
                        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                    <?php }?>
                </div>
                <div class="news-mid">
                    <ul class="news-nav clearfix">
                        <li class="cur">最新资讯</li>
                        <li>公司旅游</li>
                        <li>出国旅游</li>
                        <li>旅游指南</li>
                    </ul>
                    <div class="news-nav-wrap">

                        <ul class="news-nav-item">
                            <?php foreach ($newNews as $k => $v) { ?>
                                <li class="clearfix">
                                    <div class="news-date">
                                        <h2><?php echo date('d', $v['article_time']) ?></h2>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                    <div class="news-content">
                                        <h1><a target="_blank"
                                               href="<?php echo urlMember('article', 'show', array('article_id' => $v['article_id'])) ?>"><?php echo $v['article_title'] ?></a>
                                        </h1>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>


                        <ul class="news-nav-item">
                            <?php foreach ($newOne as $k => $v) { ?>
                                <li class="clearfix">
                                    <div class="news-date">
                                        <h2><?php echo date('d', $v['article_time']) ?></h2>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                    <div class="news-content">
                                        <h1><a target="_blank"
                                               href="<?php echo urlMember('article', 'show', array('article_id' => $v['article_id'])) ?>"><?php echo $v['article_title'] ?></a>
                                        </h1>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>


                        <ul class="news-nav-item">
                            <?php foreach ($newsTwo as $k => $v) { ?>
                                <li class="clearfix">
                                    <div class="news-date">
                                        <h2><?php echo date('d', $v['article_time']) ?></h2>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                    <div class="news-content">
                                        <h1><a target="_blank"
                                               href="<?php echo urlMember('article', 'show', array('article_id' => $v['article_id'])) ?>"><?php echo $v['article_title'] ?></a>
                                        </h1>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>


                        <ul class="news-nav-item">
                            <?php foreach ($newsThree as $k => $v) { ?>
                                <li class="clearfix">
                                    <div class="news-date">
                                        <h2><?php echo date('d', $v['article_time']) ?></h2>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                    <div class="news-content">
                                        <h1><a target="_blank"
                                               href="<?php echo urlMember('article', 'show', array('article_id' => $v['article_id'])) ?>"><?php echo $v['article_title'] ?></a>
                                        </h1>
                                        <p><?php echo date('Y-m-d', $v['article_time']) ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>

                </div>
                <div class="news-right">
                    <div class="visa">
                        <h1 class="visa-title">随机推荐</h1>
                    </div>
                    <ul class="tourism-tips">
                        <?php foreach ($randArticleInfo as $k => $v) { ?>
                            <li>
                                <a target="_blank"
                                   href="<?php echo urlMember('article', 'show', array('article_id' => $v['article_id'])) ?>"><?php echo $v['article_title'] ?>
                                    <?php echo $v['article_title'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <ul class="ms-bottom-banner">
        <li>
            <i></i>
            <div class="ms-bottom-text">
                <h2>价格保证</h2>
                <h3>同类产品，保证低价</h3>
            </div>

        </li>
        <li>
            <i></i>
            <div class="ms-bottom-text">
                <h2>退订保障</h2>
                <h3>因特殊情况影响出行，保证退订</h3>
            </div>

        </li>
        <li>
            <i></i>
            <div class="ms-bottom-text">
                <h2>救援保障</h2>
                <h3>旅途中遇意外情况，保证援助</h3>
            </div>
        </li>
        <li>
            <i></i>
            <div class="ms-bottom-text">
                <h2>7*24小时服务</h2>
                <h3>快速响应，全年无休</h3>
            </div>
        </li>
    </ul>

</div>

<script type="text/javascript" src="<?php echo NGYP_TEMPLATES_URL ?>/js/scroll.js" charset="utf-8"></script>
<script src="<?php echo NGYP_TEMPLATES_URL;?>/js/swiper.min.js"></script>

<script>
    $('.news-nav-wrap .news-nav-item').eq(0).show();
    $('.news-nav li').click(function () {
        $(this).addClass('cur').siblings().removeClass('cur');
        var i = $(this).index();
        $('.news-nav-wrap .news-nav-item').eq(i).show().siblings().hide();
    })

    //轮播图
    var swiper = new Swiper('.carousel-stm', {
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },

    });
</script>