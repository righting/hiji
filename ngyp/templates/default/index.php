<link href="<?php echo NGYP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
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


</style>

<!--焦点轮播-->
<div class="carousel">
    <div class="carousel-stm swiper-container ">
        <ul  class="swiper-wrapper frequency">
            <?php foreach($output['top_banner'] as $k=>$v){?>
            <li class="swiper-slide">
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>""><img src="<?php echo $v['img_url'];?>" class="banner"></a>
            </li>
            <?php }?>
        </ul>
        <div class="swiper-pagination"></div>
    </div>
</div>


<!--bodyer-->

<!--Video-->
<!-- <div class="video wrapper" style="margin:0 auto">
    <img src="<?php echo NGYP_TEMPLATES_URL;?>/images/video.jpg" usemap="#Map"/>
    <map name="Map">
        <area shape="rect" coords="14,56,449,314">
        <area shape="rect" coords="489,58,710,184">
        <area shape="rect" coords="719,58,931,183">
        <area shape="rect" coords="950,57,1169,180">
        <area shape="rect" coords="1099,21,1169,47">
        <area shape="rect" coords="486,278,710,400">
        <area shape="rect" coords="717,278,936,400">
        <area shape="rect" coords="947,276,1168,402">
        <area shape="rect" coords="16,372,149,397">
        <area shape="rect" coords="175,371,304,400">
        <area shape="rect" coords="326,373,457,400">
        <area shape="rect" coords="321,421,459,447">
        <area shape="rect" coords="172,420,308,450">
        <area shape="rect" coords="19,418,154,448">
    </map>
</div> -->

<?php
    $model = Model('video');
    $newVideo=$model->getVideoList(['video_type'=>2,'limit'=>1,'order'=>'time desc']);

    $randVideo=$model->getVideoList(['video_type'=>2,'limit'=>6,'order'=>' rand() ']);
?>
<div class="video wrapper">
    <div class="video-live">
        <div>
            <h1 class="live-title">食品安全曝光台·现场直播</h1>
            <div class="live-layout">
                <a data-src="<?php echo $newVideo[0]['video_url']?>" data-title="" href="javascript:void(0)" >
                    <img src="/data/upload/shop<?php echo $newVideo[0]['video_img'];?>">
                    <span class="play">
                        <i class="video-play"></i>
                    </span>
                    <p style="display:none;"><?php echo $newVideo[0]['video_title']?></p>
                </a>
            </div>
        </div>
        <div>
            <h2 class="preview-title">直播预告</h2>
            <ul class="preview-layout">
                <li><a href="javascript:void(0)">第一期视频</a></li>
                <li><a href="javascript:void(0)">第二期视频</a></li>
                <li><a href="javascript:void(0)">第三期视频</a></li>
                <li><a href="javascript:void(0)">第四期视频</a></li>
                <li><a href="javascript:void(0)">第五期视频</a></li>
                <li><a href="javascript:void(0)">第六期视频</a></li>
            </ul>
        </div>
    </div>
    <div class="video-review">
        <div class="review-title">
            <h1>精彩回顾</h1>
            <a class="other" href="javascript:;">
                <span></span>
                <em>换一换</em>
            </a>
        </div>
        <ul class="review-layout">
            <?php foreach($randVideo as $k=>$v){?>
                <li>
                    <a href="javascript:void(0)" data-src="<?php echo $v['video_url']?>">
                        <div class="img-wrap">
                            <img src="/data/upload/shop<?php echo $v['video_img'];?>">
                            <span class="play">
                                <i class="video-play"></i>
                            </span>
                        </div>
                        <p><?php echo $v['video_title']?></p>
                    </a>
                </li>
            <?php }?>
        </ul>
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
        </video>
    </div>
</div>
<script src="<?php echo NGYP_TEMPLATES_URL;?>/js/video.min.js"></script>
<script>
    $(function() {
      $.getJSON('/ngyp/index.php?controller=index&action=indexajax&type=1',function(data) {
          console.log(data);
        $('.live-layout a').find('img').attr('src',data.msg[0].video_img);
        $('.live-layout a').attr('data-src',data.msg[0].video_url);
        $('.review-layout a').each(function(i) {
            console.log(data.msg[0].video_url);
          $(this).find('img').attr('src',data.msg[i].video_img);
          $(this).attr('data-src',data.msg[i].video_url);
          $(this).find('p').html(data.msg[i].video_title);
        })

      })
    })

    $(".bg").height($(window).height());
    $(".bg").width($(window).width());
    $(".live-layout a,.review-layout a").click(function() {
        $(".bg").show();
        // var myPlayer = videojs('my-video');
        var videoUrl = $(this).data("src");
        var videoImg = $(this).find('img').attr("src");
        var videoTitle = $(this).find('p').html();
        videojs("my-video", {}, function() {
            window.myPlayer = this;
            console.log(myPlayer);
            var sourceDom = $("<source src=\""+ videoUrl +"\">");
            $(".sharemodule-video video").append(sourceDom);
            $(".sharemodule-video video").attr('poster',videoImg);
            $(".sharemodule-video .sharemodule-video-guan-a").html(videoTitle);
            myPlayer.src(videoUrl);
            myPlayer.load(videoUrl);
            $('')
            myPlayer.pause();
        });
    });
    $(".sharemodule-video-guan-b").click (function () {
        videojs("my-video").ready(function(){
            $(".bg").hide();
            var myPlayer = this;
            myPlayer.pause();;
        });

    })

</script>



<div class="home-sale-layout wrapper" style="display:block">
    <div class="left-layout">

        <ul class="tabs-nav">
            <li class="tabs-selected"><i class="arrow"></i>
                <h3>有机食品</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>热卖商品</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>新品上架</h3></li>
        </ul>
        <div class="tabs-panel sale-goods-list ">
            <ul>
                <?php foreach ($output['randGoods'] as $k=>$v){?>
                    <?php if($k<5){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price">商城价1：<em>￥<?php echo $v['goods_price']?></em></dd>
                        </dl>
                    </li>
                <?php }?>
                <?php }?>
            </ul>
        </div>
        <div class="tabs-panel sale-goods-list" style="display: none;">
            <ul>

                <?php foreach ($output['fieryGoods'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a  target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"  title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a  target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price">商城价：<em>￥<?php echo $v['goods_price']?></em></dd>
                        </dl>
                    </li>
                <?php }?>

            </ul>
        </div>
        <div class="tabs-panel sale-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['newGoods'] as $k=>$v){?>
                    <li>
                        <dl>
                            <dt class="goods-name"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>">
                                    <?php echo $v['goods_name']?></a></dt>
                            <dd class="goods-thumb">
                                <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>">
                                    <img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"/>
                                </a></dd>
                            <dd class="goods-price">商城价：<em>￥<?php echo $v['goods_price']?></em></dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>


<div class="home-adv-layout wrapper">
    <div class="center-layout">
        <div class="jfocus-trigeminy2">
            <ul>
                <li>
                    <?php foreach($output['ad_a'] as $k=>$v){?>
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                <?php }?>
                </li>
                <li>
                    <?php foreach($output['ad_b'] as $k=>$v){?>
                        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
                    <?php }?>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="home-standard-layout wrapper">
    <div class="center-layout">
        <div class="jfocus-trigeminy3">
            <ul>
                <li class="a1">
                    <?php foreach ($output['centerGoods'] as $k=>$v){?>
                        <?php if($k<3){?>
                            <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" class="b<?php echo $k+1?>"><img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"></a>
                        <?php }?>
                    <?php }?>
                </li>
                <li class="a2">
                    <?php foreach ($output['centerGoods'] as $k=>$v){?>
                        <?php if($k>=3 && $k<6){?>
                            <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" class="b<?php echo $k+1?>"><img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"></a>
                        <?php }?>
                    <?php }?>
                </li>
                <li class="a3">
                    <?php foreach ($output['centerGoods'] as $k=>$v){?>
                        <?php if($k>5){?>
                            <a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" class="b<?php echo $k+1?>"><img src="<?php echo $v['goods_image']?>" alt="<?php echo $v['goods_name']?>"></a>
                        <?php }?>
                    <?php }?>
                </li>
            </ul>
        </div>
    </div>
</div>

<!--StandardLayout Begin-->


<!---第一部分-->
<div class="home-standard-layout wrapper style-gray">
    <div class="left-sidebar">
        <div class="title">
            <div class="txt-type">
                <span id="1F">1F</span>
                <h2 title="有机米粮">有机食品</h2>
            </div>
        </div>
        <div class="left-ads">
            <?php foreach($output['ad_c'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>
        <div class="recommend-classes">
            <ul>
                <!--<li><a href="http://www.lvtaishop.com/shop/cate-1070-0-0-0-0-0-0-0.html" title="饮料">饮料</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1057-0-0-0-0-0-0-0.html" title="大米">大米</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1058-0-0-0-0-0-0-0.html" title="杂粮">杂粮</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1096-0-0-0-0-0-0-0.html" title="花生油">花生油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1097-0-0-0-0-0-0-0.html" title="橄榄油">橄榄油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1098-0-0-0-0-0-0-0.html" title="山茶油">山茶油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1099-0-0-0-0-0-0-0.html" title="大豆油">大豆油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1100-0-0-0-0-0-0-0.html" title="菜子油">菜子油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1062-0-0-0-0-0-0-0.html" title="肉类">肉类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1063-0-0-0-0-0-0-0.html" title="禽类">禽类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1064-0-0-0-0-0-0-0.html" title="蛋类">蛋类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1065-0-0-0-0-0-0-0.html" title="奶类">奶类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1060-0-0-0-0-0-0-0.html" title="蔬菜">蔬菜</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1061-0-0-0-0-0-0-0.html" title="水果">水果</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1102-0-0-0-0-0-0-0.html" title="进口食用油">进口食用油</a></li>-->
            </ul>
        </div>
    </div>
    <div class="middle-layout">
        <ul class="tabs-nav">
            <li class="tabs-selected"><i class="arrow"></i>
                <h3>推荐</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机大米</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机杂粮</h3></li>
            <a href="#" class="still-more">更多>></a>
        </ul>
        <div class="tabs-panel middle-goods-list ">
            <ul>
                <?php foreach ($output['organic_food_recommend'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['organic_food_dami'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['organic_food_zaliang'] as $k=>$v){?>
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
</div>
<div class='wrapper'>
    <div class='mt10'><?php foreach($output['ad_d'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?></div>
</div>


<div class="home-standard-layout wrapper style-gray">
    <div class="left-sidebar">
        <div class="title">
            <div class="txt-type">
                <span id="1F">2F</span>
                <h2 title="有机米粮">地道特产</h2>
            </div>
        </div>
        <div class="left-ads">
            <?php foreach($output['ad_e'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>
        <div class="recommend-classes">
            <ul>
              <!--  <li><a href="http://www.lvtaishop.com/shop/cate-1070-0-0-0-0-0-0-0.html" title="饮料">饮料</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1057-0-0-0-0-0-0-0.html" title="大米">大米</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1058-0-0-0-0-0-0-0.html" title="杂粮">杂粮</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1096-0-0-0-0-0-0-0.html" title="花生油">花生油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1097-0-0-0-0-0-0-0.html" title="橄榄油">橄榄油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1098-0-0-0-0-0-0-0.html" title="山茶油">山茶油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1099-0-0-0-0-0-0-0.html" title="大豆油">大豆油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1100-0-0-0-0-0-0-0.html" title="菜子油">菜子油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1062-0-0-0-0-0-0-0.html" title="肉类">肉类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1063-0-0-0-0-0-0-0.html" title="禽类">禽类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1064-0-0-0-0-0-0-0.html" title="蛋类">蛋类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1065-0-0-0-0-0-0-0.html" title="奶类">奶类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1060-0-0-0-0-0-0-0.html" title="蔬菜">蔬菜</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1061-0-0-0-0-0-0-0.html" title="水果">水果</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1102-0-0-0-0-0-0-0.html" title="进口食用油">进口食用油</a></li>-->
            </ul>
        </div>
    </div>
    <div class="middle-layout">
        <ul class="tabs-nav">
            <li class="tabs-selected"><i class="arrow"></i>
                <h3>推荐</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机大米</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机杂粮</h3></li>
            <a href="#" class="still-more">更多>></a>
        </ul>
        <div class="tabs-panel middle-goods-list ">
            <ul>
                <?php foreach ($output['techan_recommend'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['techan_dami'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['techan_zaliang'] as $k=>$v){?>
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
</div>
<div class='wrapper'>
    <div class='mt10'><?php foreach($output['ad_f'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?></div>
</div>


<div class="home-standard-layout wrapper style-gray">
    <div class="left-sidebar">
        <div class="title">
            <div class="txt-type">
                <span id="1F">3F</span>
                <h2 title="有机米粮">季节优品</h2>
            </div>
        </div>
        <div class="left-ads">
            <?php foreach($output['ad_g'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>
        <div class="recommend-classes">
            <ul>
               <!-- <li><a href="http://www.lvtaishop.com/shop/cate-1070-0-0-0-0-0-0-0.html" title="饮料">饮料</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1057-0-0-0-0-0-0-0.html" title="大米">大米</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1058-0-0-0-0-0-0-0.html" title="杂粮">杂粮</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1096-0-0-0-0-0-0-0.html" title="花生油">花生油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1097-0-0-0-0-0-0-0.html" title="橄榄油">橄榄油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1098-0-0-0-0-0-0-0.html" title="山茶油">山茶油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1099-0-0-0-0-0-0-0.html" title="大豆油">大豆油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1100-0-0-0-0-0-0-0.html" title="菜子油">菜子油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1062-0-0-0-0-0-0-0.html" title="肉类">肉类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1063-0-0-0-0-0-0-0.html" title="禽类">禽类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1064-0-0-0-0-0-0-0.html" title="蛋类">蛋类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1065-0-0-0-0-0-0-0.html" title="奶类">奶类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1060-0-0-0-0-0-0-0.html" title="蔬菜">蔬菜</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1061-0-0-0-0-0-0-0.html" title="水果">水果</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1102-0-0-0-0-0-0-0.html" title="进口食用油">进口食用油</a></li>-->
            </ul>
        </div>
    </div>
    <div class="middle-layout">
        <ul class="tabs-nav">
            <li class="tabs-selected"><i class="arrow"></i>
                <h3>推荐</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机大米</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机杂粮</h3></li>
            <a href="#" class="still-more">更多>></a>
        </ul>
        <div class="tabs-panel middle-goods-list ">
            <ul>
                <?php foreach ($output['jijie_recommend'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['jijie_dami'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['jijie_zaliang'] as $k=>$v){?>
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

</div>
<div class='wrapper'>
    <div class='mt10'><?php foreach($output['ad_h'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?></div>
</div>


<div class="home-standard-layout wrapper style-gray">
    <div class="left-sidebar">
        <div class="title">
            <div class="txt-type">
                <span id="1F">4F</span>
                <h2 title="有机米粮">人气热卖</h2>
            </div>
        </div>
        <div class="left-ads">
            <?php foreach($output['ad_i'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
            <?php }?>
        </div>
        <div class="recommend-classes">
            <ul>
               <!-- <li><a href="http://www.lvtaishop.com/shop/cate-1070-0-0-0-0-0-0-0.html" title="饮料">饮料</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1057-0-0-0-0-0-0-0.html" title="大米">大米</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1058-0-0-0-0-0-0-0.html" title="杂粮">杂粮</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1096-0-0-0-0-0-0-0.html" title="花生油">花生油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1097-0-0-0-0-0-0-0.html" title="橄榄油">橄榄油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1098-0-0-0-0-0-0-0.html" title="山茶油">山茶油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1099-0-0-0-0-0-0-0.html" title="大豆油">大豆油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1100-0-0-0-0-0-0-0.html" title="菜子油">菜子油</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1062-0-0-0-0-0-0-0.html" title="肉类">肉类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1063-0-0-0-0-0-0-0.html" title="禽类">禽类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1064-0-0-0-0-0-0-0.html" title="蛋类">蛋类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1065-0-0-0-0-0-0-0.html" title="奶类">奶类</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1060-0-0-0-0-0-0-0.html" title="蔬菜">蔬菜</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1061-0-0-0-0-0-0-0.html" title="水果">水果</a></li>
                <li><a href="http://www.lvtaishop.com/shop/cate-1102-0-0-0-0-0-0-0.html" title="进口食用油">进口食用油</a></li>-->
            </ul>
        </div>
    </div>
    <div class="middle-layout">
        <ul class="tabs-nav">
            <li class="tabs-selected"><i class="arrow"></i>
                <h3>推荐</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机大米</h3></li>
            <li class=""><i class="arrow"></i>
                <h3>有机杂粮</h3></li>
            <a href="#" class="still-more">更多>></a>
        </ul>
        <div class="tabs-panel middle-goods-list ">
            <ul>
                <?php foreach ($output['hot_sale_recommend'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['hot_sale_dami'] as $k=>$v){?>
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
        <div class="tabs-panel middle-goods-list" style="display: none;">
            <ul>
                <?php foreach ($output['hot_sale_zaliang'] as $k=>$v){?>
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

</div>
<div class='wrapper'>
    <div class='mt10'><?php foreach($output['ad_j'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?></div>
</div>


<!--StandardLayout End-->
<div class="wrapper">
    <div class="mt10"><a href='' target='_blank'><img style='width:1200px;height:80px' border='0'
                                                      src='<?php echo NGYP_TEMPLATES_URL;?>/images/04855181317479675.jpg' alt='首页通栏'/></a></div>
</div>

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

    $(document).ready(function(){
            $(".tabs-nav li").on("click",function(even){
                $(this).addClass("tabs-selected").siblings().removeClass("tabs-selected");
                $(this).parents(".tabs-nav").siblings().hide().eq($(this).index()).show()
            })
    });
</script>


