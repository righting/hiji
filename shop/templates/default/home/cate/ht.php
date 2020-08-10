<link href="<?php echo SHOP_TEMPLATES_URL;?>/tab_resource/slick/slick.css" rel="stylesheet" type="text/css">
<style>
    .list-tab li.current a{ color: #9737DF;}
</style>
<?php echo $output['web_html']['index_ht']; ?>
<?php echo $output['index_adv_html']['web_html']; ?>

<!--<div class="end">END</div>-->
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/js/tab.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/tab_resource/slick/slick.js"></script>
<script>
    $(document).ready(function () {
        $('#tab').find('li').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $('.box').hide();
            $('.box').eq($(this).index()).show();
        });
    });

    $('.flexslider_a').slick({
        dots: false,
        infinite: true,
        accessibility:false,
        arrows:false,
        speed: 500,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000
    });

    $('.flexslider_b').slick({
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

    $('.flexslider_c').slick({
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
    $('.flexslider_d').slick({
        dots: false,
        infinite: true,
        accessibility:false,
        arrows:false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        vertical:true,
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
</script>