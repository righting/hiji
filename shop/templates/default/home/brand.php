<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/tab_resource/slick/slick.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/brand/brand_list.css" rel="stylesheet" type="text/css">
<?php echo $output['index_html']['web_html']; ?>
<?php require template('home/brand/brand.item'); ?>
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/tab_resource/slick/slick.js"></script>
<script>
    $(document).ready(function () {
        $('.flexslider_1').slick({
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

        $('.flexslider_2').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            vertical:true,
            autoplaySpeed: 2000
        });

        $('.flexslider_3').slick({
            dots: false,
            infinite: true,
            accessibility:false,
            arrows:false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            vertical:true,
            autoplaySpeed: 2000
        });
        $('.flexslider_4').slick({
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
        $('.flexslider_5').slick({
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
        $('.flexslider_6').slick({
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
        $('.flexslider_7').slick({
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
        $('.flexslider_8').slick({
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
        $('.flexslider_9').slick({
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
    });


</script>

