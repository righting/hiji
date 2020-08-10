<link href="<?php echo NGYP_TEMPLATES_URL;?>/css/nznj.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/swiper-3.4.2.min.css">

<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>

<style>
    .clearfix{
        display:block;
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

    <div class="nz-main-wrap">
        <div class="nz-main">
            <div class="nz-part1 clearfix" style="display: block">
                <div class="nz-part1-left">
                    <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/nznj/nznj_part1_left.jpg"></a>-->
                    <?php foreach($output['ad_a'] as $k=>$v){?>
                        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                    <?php }?>
                </div>
                <div class="nz-part1-right">
                    <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/nznj/nznj_part1_right.jpg"></a>-->
                    <?php foreach($output['ad_b'] as $k=>$v){?>
                        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                    <?php }?>
                </div>
            </div>
            <div class="nz-floor nz-1f">
                <div class="nz-row-first">
                    <div class="nz-left-ads">
                        <h1>1F</h1>
                        <ul class="nz-left-nav clearfix">
                            <?php foreach($output['category'] as $k=>$v){?>
                                <?php if($k<3){?>
                                    <li><a style="color:white;" target="_blank" href="<?php echo urlShop('cate','index',array('cate_id'=>$v['gc_id']));?>"><?php echo $v['gc_name'];?></a></li>
                                <?php }?>
                            <?php }?>
                        </ul>
                        <div class="nz-divider"></div>
                        <div class="nz-left-banner">
                            <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/nznj/left-ads-01.jpg"></a>-->
                            <?php foreach($output['ad_c'] as $k=>$v){?>
                                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                            <?php }?>
                        </div>
                    </div>
                    <ul class="nz-product clearfix">
                        <?php foreach($output['oneGoodsInfo'] as $k=>$v){?>
                            <?php if($k<4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
                <div class="nz-row-second">
                    <ul class="nz-product clearfix">
                        <?php foreach($output['oneGoodsInfo'] as $k=>$v){?>
                            <?php if($k>=4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="nz-floor nz-2f">
                <div class="nz-row-first">
                    <div class="nz-left-ads">
                        <h1>2F</h1>
                        <ul class="nz-left-nav clearfix">
                            <?php foreach($output['category'] as $k=>$v){?>
                                <?php if($k>2 && $k< 6){?>
                                    <li><a style="color:white;" target="_blank" href="<?php echo urlShop('cate','index',array('cate_id'=>$v['gc_id']));?>"><?php echo $v['gc_name'];?></a></li>
                                <?php }?>
                            <?php }?>
                        </ul>
                        <div class="nz-divider"></div>
                        <div class="nz-left-banner">
                            <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/nznj/left-ads-02.jpg"></a>-->
                            <?php foreach($output['ad_d'] as $k=>$v){?>
                                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                            <?php }?>
                        </div>
                    </div>
                    <ul class="nz-product clearfix">
                        <?php foreach($output['twoGoodsInfo'] as $k=>$v){?>
                            <?php if($k<4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
                <div class="nz-row-second">
                    <ul class="nz-product clearfix">
                        <?php foreach($output['twoGoodsInfo'] as $k=>$v){?>
                            <?php if($k>=4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="nz-floor nz-3f">
                <div class="nz-row-first">
                    <div class="nz-left-ads">
                        <h1>3F</h1>
                        <ul class="nz-left-nav clearfix">
                            <?php foreach($output['category'] as $k=>$v){?>
                                <?php if($k> 5){?>
                                    <li><a style="color:white;" target="_blank" href="<?php echo urlShop('cate','index',array('cate_id'=>$v['gc_id']));?>"><?php echo $v['gc_name'];?></a></li>
                                <?php }?>
                            <?php }?>
                        </ul>
                        <div class="nz-divider"></div>
                        <div class="nz-left-banner">
                            <!--<a href=""><img src="<?php /*echo NGYP_TEMPLATES_URL; */?>/images/nznj/left-ads-03.jpg"></a>-->
                            <?php foreach($output['ad_e'] as $k=>$v){?>
                                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                            <?php }?>
                        </div>
                    </div>
                    <ul class="nz-product clearfix">
                        <?php foreach($output['threeGoodsInfo'] as $k=>$v){?>
                            <?php if($k<4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
                <div class="nz-row-second">
                    <ul class="nz-product clearfix">
                        <?php foreach($output['threeGoodsInfo'] as $k=>$v){?>
                            <?php if($k>=4){?>
                                <li>
                                    <div class="act-img">
                                        <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img src="<?php echo $v['goods_image']?>"></a>
                                    </div>
                                    <p><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><?php echo $v['goods_name']?></a></p>
                                    <h2>￥<?php echo $v['goods_price']?>元</h2>
                                    <a href="javascript:;" onclick="addCart(<?php echo $v['goods_id']?>);">加入购物车</a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>

    </div>



    <!--StandardLayout End-->

<script>

    function addCart(id){
        <?php if($_SESSION['is_login']!=1){?>
            layer.msg('请先登录！',{icon:5});
            return;
        <?php }?>

        layer.load();
        var url = '/shop/index.php?controller=cart&action=add';
        $.getJSON(url, {'goods_id':id, 'quantity':1}, function(data) {
            layer.closeAll();
            console.log(data);
            if(data.state=='true'){
                layer.msg('加入购物车成功',{icon:1});
            }else{
                layer.msg('加入失败了！',{icon:2});
            }
        });


    }

</script>