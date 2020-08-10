<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/tab_resource/slick/slick.css" rel="stylesheet" type="text/css">
<?php echo $output['index_html']['web_html']; ?>
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/tab_resource/slick/slick.js"></script>
<script type="text/javascript">
    $(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            start: function(slider) {
                $('body').removeClass('loading');
            }
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

        $('.slider_2').slick({
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

        $('.slider_3').slick({
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

        $('.slider_4').slick({
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
        $('.slider_5').slick({
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