<link href="<?php echo NGYP_TEMPLATES_URL;?>/css/spyb.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/swiper-3.4.2.min.css">
<style type="text/css">
    .category {
        display: block !important;
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

    .guanggao {
        overflow: hidden;
        margin: 0 auto;
        width: 1200px;
        margin-top: 10px;
    }

    .guanggao {
        width: 1200px;
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
<!--焦点图 End-->
<div class="guanggao">
    <?php foreach($output['ad_h'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
    <?php }?>
</div>


<!--StandardLayout Begin-->

<div class="clear"></div>

<!---第一部分-->
<div class="home-standard-layout wrapper style-gray">
    <h2 title="有机米粮">
        <div class="title">有机农产品</div>
        <div class="en_titile">ORGANIC PRODUCE</div>
    </h2>
    <div class="left-sidebar">

        <div class="left-ads">
            <?php foreach($output['ad_a'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>

    </div>
    <div class="middle-layout">


        <div class="tabs-panel middle-goods-list">
            <ul>
                <?php foreach ($output['randGoods'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                <span class="original">￥<?php echo $v['goods_marketprice']?></span></dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <a href="" class="more">换一批</a>

</div>


<div class="x_banner">
    <div class='wrapper'>
        <div class='mt10'>
            <?php foreach($output['ad_b'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>
    </div>
</div>


<div class="box_o_2">
    <div class="imginner">
        <img src="<?php echo NGYP_TEMPLATES_URL;?>/images/img3.jpg" usemap="#Map"/>
        <map name="Map">
            <area shape="rect" coords="4,164,278,357">
            <area shape="rect" coords="312,161,583,357">
            <area shape="rect" coords="617,162,891,356">
            <area shape="rect" coords="920,159,1199,354">
        </map>
    </div>
</div>


<div class="box_o_3">
    <div class="imginner">
        <?php foreach($output['ad_i'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?>
    </div>
</div>


<!---第二部分-->
<div class="home-standard-layout wrapper style-gray">
    <h2 title="有机米粮">
        <div class="title">绿色食品</div>
        <div class="en_titile">GREEN FOOD</div>
    </h2>
    <div class="left-sidebar">

        <div class="left-ads">
            <?php foreach($output['ad_c'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>

    </div>
    <div class="middle-layout">


        <div class="tabs-panel middle-goods-list">
            <ul>
                <?php foreach ($output['randGoods1'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                <span class="original">￥<?php echo $v['goods_marketprice']?></span></dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <a href="" class="more">换一批</a>

</div>


<div class="box_o_4">
    <div class="imginner">
        <?php foreach($output['ad_d'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?>
    </div>
</div>


<!---第三部分-->
<div class="home-standard-layout wrapper style-gray">
    <h2 title="有机米粮">
        <div class="title">无公害农产品</div>
        <div class="en_titile">POLLUTION-FREE AGRICULTURAL PRODUCTS</div>
    </h2>
    <div class="left-sidebar">

        <div class="left-ads">
            <?php foreach($output['ad_e'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>

    </div>
    <div class="middle-layout">


        <div class="tabs-panel middle-goods-list">
            <ul>
                <?php foreach ($output['randGoods2'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                <span class="original">￥<?php echo $v['goods_marketprice']?></span></dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <a href="" class="more">换一批</a>

</div>


<div class="box_o_4">
    <div class="imginner">
        <?php foreach($output['ad_f'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?>
    </div>
</div>

<!---第四部分-->
<div class="home-standard-layout wrapper style-gray">
    <h2 title="有机米粮">
        <div class="title">农产品地理标志</div>
        <div class="en_titile"></div>
    </h2>
    <div class="left-sidebar">

        <div class="left-ads">
            <?php foreach($output['ad_g'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>

    </div>
    <div class="middle-layout">


        <div class="tabs-panel middle-goods-list">
            <ul>
                <?php foreach ($output['randGoods3'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price"><em>￥<?php echo $v['goods_price']?></em>
                                <span class="original">￥<?php echo $v['goods_marketprice']?></span></dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <a href="" class="more">更多</a>

</div>


<div class="box_o_4">
    <div class="imginner">

        <img src="<?php echo NGYP_TEMPLATES_URL;?>/images/img10.jpg" usemap="#Map2"/>
        <map name="Map2">
            <area shape="rect" coords="5,16,403,176">
            <area shape="rect" coords="415,4,849,182" href="#">
            <area shape="rect" coords="864,5,1199,181">
        </map>

    </div>
</div>


<div class="box_o_5">
    <div class="imginner">

        <img src="<?php echo NGYP_TEMPLATES_URL;?>/images/img11.jpg" usemap="#Map3"/>
        <map name="Map3">
            <area shape="rect" coords="172,111,375,166" href="">
            <area shape="rect" coords="491,108,698,168" href="">
            <area shape="rect" coords="810,107,1019,169" href="">
            <area shape="rect" coords="810,241,1020,297" href="">
            <area shape="rect" coords="812,371,1019,428" href="">
            <area shape="rect" coords="489,370,700,429" href="">
            <area shape="rect" coords="174,370,380,430" href="">
            <area shape="rect" coords="172,239,378,298" href="">
            <area shape="rect" coords="491,241,699,297" href="">
        </map>


    </div>
</div>


<!--StandardLayout End-->


<div class="wrapper">
    <div class="rz mt20"><img src="<?php echo NGYP_TEMPLATES_URL;?>/images/rz.jpg" alt="认证"/></div>
</div>

<script src="<?php echo NGYP_TEMPLATES_URL;?>/js/swiper.min.js"></script>
<script>
    //轮播图
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