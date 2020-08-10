<link href="<?php echo NGYP_TEMPLATES_URL; ?>/css/ncgy_base.css" rel="stylesheet" type="text/css">
<link href="<?php echo NGYP_TEMPLATES_URL; ?>/css/ncgy.css" rel="stylesheet" type="text/css">
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
<?php
$model = Model('page');
$pageWhere['page_key'] = 'nzgy';
$pageWhere['page_show'] = 1;
$info=$model->getPageList($pageWhere);

?>


<?php echo html_entity_decode($info[0]['page_content']);?>

<?php echo html_entity_decode($info[1]['page_content']);?>

<?php foreach($output['top_banner'] as $k=>$v){?>
<div class="ncgy-part3">
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
</div>
<?php }?>

<?php echo html_entity_decode($info[2]['page_content']);?>



