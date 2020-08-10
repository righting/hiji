<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_index/home_index.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/tab_resource/slick/slick.css" rel="stylesheet" type="text/css">
<style>
    .list-tab li.current a{ color: #9737DF;}
</style>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>
<script src="<?php echo SHOP_TEMPLATES_URL; ?>/tab_resource/slick/slick.js"></script>
<!-- HomeFocusLayout Begin-->

<!-- HomeFocusLayout Begin-->
<?php echo $output['new_html_arr'][101]['web_html']; ?>
<!--HomeFocusLayout End-->
<div class="inmain">
<?php echo $output['new_html_arr'][617]['web_html']; ?>
<?php echo $output['new_html_arr'][620]['web_html']; ?>
<?php echo $output['new_html_arr'][625]['web_html']; ?>
<?php echo $output['new_html_arr'][626]['web_html']; ?>
<?php echo $output['new_html_arr'][627]['web_html']; ?>
<?php echo $output['new_html_arr'][628]['web_html']; ?>
<?php echo $output['new_html_arr'][629]['web_html']; ?>
<?php echo $output['new_html_arr'][630]['web_html']; ?>
<?php echo $output['new_html_arr'][631]['web_html']; ?>
<?php echo $output['new_html_arr'][632]['web_html']; ?>
<?php echo $output['new_html_arr'][633]['web_html']; ?>
        <div class="guess1">
            <div class="gg">
                <a href="<?php echo $output['home_bottom_banner']['img_link']; ?>">
                    <img src="<?php echo $output['home_bottom_banner']['img_url']; ?>">
                </a>
            </div>
        </div>
</div>
<!-- 弹窗广告 Begin-->
<?php echo $output['new_html_arr'][611]['web_html']; ?>
<!-- 弹窗广告 End-->
<!--<div class="end">END</div>-->
<!--<script src="--><?php //echo SHOP_TEMPLATES_URL; ?><!--/ht_resource/js/tab.js"></script>-->
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