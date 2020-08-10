<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_index/home_index.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/tab_resource/slick/slick.css" rel="stylesheet" type="text/css">
<style>
    .list-tab li.current a{ color: #9737DF;}
</style>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/tab_resource/slick/slick.js"></script>


<!-- HomeFocusLayout Begin-->
<?php echo $output['new_html_arr'][101]['web_html']; ?>
<!--HomeFocusLayout End-->


<div class="inmain">

    <?php echo $output['new_html_arr'][617]['web_html']; ?>
    <?php echo $output['new_html_arr'][620]['web_html']; ?>
    <?php echo $output['new_html_arr'][625]['web_html']; ?>
    <?php echo $output['new_html_arr'][626]['web_html']; ?>


    <?php if(empty($output['recommend_list']) && !is_array($output['recommend_list'])){ echo $output['new_html_arr'][624]['web_html']; }?>


    <?php if (!empty($output['recommend_list']) && is_array($output['recommend_list'])) {?>
        <?php foreach ($output['recommend_list'] as $k => $val) :?>
            <?php if (empty($val['goods_list'])) continue;?>
                <div class="ification_top">
                    <h2><?php echo $val['recommend']['name'] ?></h2>
                </div>
        <div class="line-lb">
            <ul>
                <?php while (!empty($val['goods_list'])){
                    $data = array_slice($val['goods_list'],0,10); ?>

                    <?php for($i=0;$i<5;$i++){
                        $data1 = array_slice($data,$i*2,2);
                        ?>
                        <?php foreach ($data1 as $item):?>
                            <li>
                                <a href="<?php echo urlShop('goods','index',['goods_id'=>$item['goods_id']])?>">
                                    <div class="line-lb-img"><img src="<?php echo $item['goods_pic'] ?>"></div>
                                    <div class="line-lb-text"><?php echo $item['goods_name'] ?></div>
                                    <div class="line-lb-price">¥<?php echo $item['goods_price'] ?></div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php } ?>
                    <?php array_splice($val['goods_list'],0,10); } ?>
            </ul>
        </div>
        <?php endforeach;?>
    <?php }?>


</div>


<script>
    // 获取页面中的所有floor-layout的个数
    $(function(){
        var _floor_length = $('.floor-layout').length;
        var _floor_name = '';
        var _floor_id = '';
        if(_floor_length > 0){
            var _str = '<div class="sidebar" style="display: block; top: 367px; left: 9.5px;"><ul>';
            $(".floor-layout").each(function(){
                _floor_name = $(this).find('.floor-left .txt-type span').text();
                _floor_id = $(this).attr('id');
                _str += '<li><a href="#'+_floor_id+'">'+_floor_name+'</a></li>';
            });
            _str += '</ul></div>';
        }
        $('body').append(_str);
    });
</script>
<script type="text/javascript">
    $(function() {
        $('.flexslidera').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

        $('.flexsliderb').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

        $('.flexsliderc').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

        $('.slider_1').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

        $('.slider_1').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            var current_li = $(this).closest('.wrap_nav').find('.ification_top>.list-tab li').eq(nextSlide);
            current_li.siblings().removeClass('current');
            current_li.addClass('current');
        });
    });
</script>