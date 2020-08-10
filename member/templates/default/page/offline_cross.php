<?php include template('layout/page_top'); ?>
    <link rel="stylesheet" href="/member/templates/default/css/offline_brand.css" type="text/css" />
    <link rel="stylesheet" href="/member/templates/default/css/green_develop.css" type="text/css" />
    <script>
        $(window).scroll(function() {
            if ( $(window).scrollTop()>0 ) {
                $('#fixed-box').addClass('header_fixed');
                $('#gotop').css("opacity",1);
            } else {
                $('#fixed-box').removeClass('header_fixed');
                $('#gotop').css("opacity",0.5);
            }
        });
    </script>
    <link rel="stylesheet" href="/member/templates/default/css/banner.css" type="text/css" />
<?php
$banner_model  = Model('banner');
$banner_lsit = $banner_model->where(array('c_id'=>16))->select();

?>
<?php if($banner_lsit && count($banner_lsit)==1){ ?>
    <div class="lsfz-banner" style="max-height:480px;">
        <a target="_blank" href="<?php if(!empty($banner_lsit[0]['img_link'])){echo $banner_lsit[0]['img_link'];}else{echo 'javascript:;';}?>">
            <img style="width:100%;max-height:480px; " src="<?php echo $banner_lsit[0]['img_url']?>" />
        </a>
    </div>
<?php } ?>

<?php if($banner_lsit && count($banner_lsit)>1){ ?>
    <div class="lsfz-banner" style="position: relative;">
        <ul id="fullScreenSlides" class="full-screen-slides">
            <?php foreach ($banner_lsit as $bk => $bv) {?>
                <li style="background: url('<?php echo $bv['img_url']?>') center top no-repeat;">
                    <a target="_blank" href="<?php if(!empty($bv['img_link'])){echo $bv['img_link'];}else{echo 'javascript:;';}?>" title=""></a>
                </li>
            <?php } ?>
        </ul>

    </div>
<?php } ?>
    <script>
        (function ($) {
            // 首页满屏背景广告切换
            $.fn.fullScreen = function(settings) {//首页焦点区满屏背景广告切换
                var defaults = {
                    time: 5000,
                    css: 'full-screen-slides-pagination'
                };
                var settings = $.extend(defaults, settings);
                return this.each(function(){

                    var $this = $(this);
                    var size = $this.find("li").size();
                    var now = 0;
                    var enter = 0;
                    var speed = settings.time;
                    $this.find("li:gt(0)").hide();
                    var btn = '<ul class="' + settings.css + '">';
                    for (var i = 0; i < size; i++) {
                        btn += '<li>' + '<a href="javascript:void(0)">' + (i + 1) + '</a>' + '</li>';
                    }
                    btn += "</ul>";
                    $this.parent().append(btn);
                    var $pagination = $this.next();

                    $pagination.find("li").first().addClass('current');
                    $pagination.find("li").click(function() {
                        var change = $(this).index();
                        $(this).addClass('current').siblings('li').removeClass('current');
                        $this.find("li").eq(change).css('z-index', '800').show();
                        $this.find("li").eq(now).css('z-index', '900').fadeOut(400,
                            function() {
                                $this.find("li").eq(change).fadeIn(500);
                            });
                        now = change;
                    }).mouseenter(function() {
                        enter = 1;
                    }).mouseleave(function() {
                        enter = 0;
                    });
                    function slide() {
                        var change = now + 1;
                        if (enter == 0){
                            if (change == size) {
                                change = 0;
                            }
                            $pagination.find("li").eq(change).trigger("click");
                        }
                        setTimeout(slide, speed);
                    }
                    setTimeout(slide, speed);
                });
            }

        })(jQuery);
        $(function() {
            $('.full-screen-slides').fullScreen();
        })
    </script>

    <style>
        .content img{
            max-width:960px;
        }
    </style>
    <div class='content' style="width:960px;margin:0 auto;padding-top:20px;">
        <?php echo html_entity_decode($output['page'][0]['page_content']);?>
    </div>


<?php include template('layout/page_footer'); ?>