<link href="<?php echo NGYP_TEMPLATES_URL;?>/css/xffp.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/swiper-3.4.2.min.css">
<style>
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


<script src="<?php echo NGYP_TEMPLATES_URL;?>/js/swiper.min.js"></script>
<script>
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

<!-- 焦点图 End-->

<div class="section1 wrapper">
    <div class="section1-header clearfix">
        <h1>扶贫助农</h1>
     <!--   <ul class="section1-nav claerfix">
            <li><a href="">全部</a></li>
            <li><a href="">国产水果</a></li>
            <li><a href="">宅配套餐</a></li>
            <li><a href="">进口生鲜</a></li>
            <li><a href="">农家初生蛋</a></li>
        </ul>-->
    </div>
    <div class="fp-goods clearfix">
        <div class="fp-goods-left">
            <div class="act-img">
                <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_04.jpg"></a>-->
                <?php foreach($output['adv_a'] as $k=>$v){?>
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                <?php }?>
            </div>
            <!--<div class="recommend-wrap">
                <div class="hot-sold">
                    <h1>热销商品</h1>
                    <ul class="claerfix">
                        <li><a href="">灵芝猪猪肉</a></li>
                        <li><a href="">铁棍山药</a></li>
                        <li><a href="">百香果</a></li>
                        <li><a href="">野味</a></li>
                        <li><a href="">澳洲牛排</a></li>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="recommend">
                    <h1>精品推荐</h1>
                    <ul class="claerfix">
                        <li><a href="">新鲜水果</a></li>
                        <li><a href="">白蕉海鲈鱼</a></li>
                        <li><a href="">板栗红薯</a></li>
                        <li><a href="">越南紫番薯</a></li>
                    </ul>
                </div>

            </div>-->
        </div>
        <?php
            $goodsModel = Model('goods');
            $where['gc_id']=5427;
            $where['goods_verify']=1;
            $oneGoodsInfo=$goodsModel->where($where)->limit(8)->select();
            $where['gc_id']=5428;
            $twoGoodsInfo=$goodsModel->where($where)->limit(8)->select();
            $where['gc_id']=5429;
            $threeGoodsInfo=$goodsModel->where($where)->limit(10)->select();
        ?>
        <div class="fp-goods-right">
            <div class="middle-goods-list">
                <ul>
                    <?php foreach($oneGoodsInfo as $k=>$v){?>
                        <?php if($k>=0){?>
                            <li>
                                <dl>
                                    <dt class="goods-name">
                                        <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']))?>"><?php echo $v['goods_name']?></a></dt>
                                    <dd class="goods-thumb">
                                        <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']))?>">
                                            <img title="<?php echo $v['goods_name']?>" alt="<?php echo $v['goods_name']?>" src="<?php echo $v['goods_image']; ?>">
                                        </a>
                                    </dd>
                                    <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                        <span class="original">￥<?php echo $v['goods_marketprice']?></span>
                                    </dd>
                                </dl>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="section2 wrapper">
    <h1 class="section2-title">- - 贫困户土特产 - -</h1>
    <div class="fp-goods clearfix">
        <div class="fp-goods-left">
            <div class="act-img">
                <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_04.jpg"></a>-->
                <?php foreach($output['adv_b'] as $k=>$v){?>
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                <?php }?>
            </div>
        </div>
        <div class="fp-goods-right">
            <div class="middle-goods-list">
                <ul>
                    <?php foreach($twoGoodsInfo as $k=>$v){?>
                        <?php if($k>=0){?>
                            <li>
                                <dl>
                                    <dt class="goods-name">
                                        <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']))?>"><?php echo $v['goods_name']?></a></dt>
                                    <dd class="goods-thumb">
                                        <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']))?>">
                                            <img title="<?php echo $v['goods_name']?>" alt="<?php echo $v['goods_name']?>" src="<?php echo $v['goods_image']; ?>">
                                        </a>
                                    </dd>
                                    <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                        <span class="original">￥<?php echo $v['goods_marketprice']?></span>
                                    </dd>
                                </dl>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div>

    </div>
</div>

<div class="section3">
    <div class="section3-left act-img">
        <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_05.jpg"></a>-->
        <?php foreach($output['adv_c'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?>
    </div>
    <div class="section3-right">
        <ul class="hnzn-goods-top clearfix">

            <?php foreach($threeGoodsInfo as $k=>$v){?>
                <li class="act-img">
                    <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']))?>">
                        <img title="<?php echo $v['goods_name']?>" alt="<?php echo $v['goods_name']?>" src="<?php echo $v['goods_image']; ?>">
                    </a>
                </li>
            <?php }?>

        </ul>
        <ul class="hnzn-goods-bottom claerfix">
            <?php foreach($output['adv_d'] as $k=>$v){?>
            <li class="act-img" style="margin-top:-10px;"><a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a></li>
            <?php }?>
            <!--<li class="act-img" style="margin-top:-10px;">
                <a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_07.jpg"></a>
            </li>
            <li class="act-img" style="margin-top:-10px;">
                <a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_08.jpg"></a>
            </li>
            <li class="act-img" style="margin-top:-10px;">
                <a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/xffp/xffp_goods_09.jpg"></a>
            </li>-->
        </ul>
    </div>
</div>

<ul class="section4 claerfix">
    <li class="hnfp">
        <div class="act-img">
            <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/xffp/xffp_goods_10.jpg"></a>
        </div>
        <ul class="hnfp-form">
            <li>四川眉山县</li>
            <li>张三</li>
            <li>王武</li>
            <li>20件</li>
            <li>2017.5月</li>
            <li><a href="">点击查看</a></li>
            <li>暂无数据</li>
        </ul>
    </li>
    <li class="hnfp">
        <div class="act-img">
            <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/xffp/xffp_goods_11.jpg"></a>
        </div>
        <ul class="hnfp-form">
            <li>四川眉山县</li>
            <li>张三</li>
            <li>王武</li>
            <li>20件</li>
            <li>2017.5月</li>
            <li><a href="">点击查看</a></li>
            <li>暂无数据</li>
        </ul>
    </li>
    <li class="hnfp">
        <div class="act-img">
            <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/xffp/xffp_goods_12.jpg"></a>
        </div>
        <ul class="hnfp-form">
            <li>四川眉山县</li>
            <li>张三</li>
            <li>王武</li>
            <li>20件</li>
            <li>2017.5月</li>
            <li><a href="">点击查看</a></li>
            <li>暂无数据</li>
        </ul>
    </li>
</ul>

<div class="section5 claerfix">
    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/xffp/xffp_12.jpg">
    <!-- <div class="poverty">
        <h1><a href="">国家级贫困县总览表</a></h1>
        <div class="poverty-map">
            <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/xffp/xffp_map.jpg">
        </div>
        <div class="poverty-text">
            <p>国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县国家级贫困县<a href="">【了解更多】</a></p>
        </div>
    </div>
    <div class="country-service">
        <h1><a href="">村级农家电商·服务点建设</a></h1>
        <ul>
            <li class="claerfix">
                <div class="country-news-time">
                    <h2>2015年</h2>
                    <span>09-14</span>
                </div>
                <div class="country-news">
                    <h3>全国类微信和地方微信当前的盈利状况</h3>
                    <p>世界变化很快，微信大环境变化更快，现在虽然还是2015年，世界变化很快，微信大环境变化更快，现在虽然还是2015年<a href="">【详情】</a></p>
                </div>
            </li>
        </ul>
    </div> -->
</div>


<!--StandardLayout End-->

