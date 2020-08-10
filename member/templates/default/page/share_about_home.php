<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/about.css" type="text/css" />
<link rel="stylesheet" href="/member/templates/default/css/about_base.css" type="text/css" />
<link rel="stylesheet" href="/member/templates/default/css/banner.css" type="text/css" />

    <?php if(count($output['bannerInfo'])==1){?>
        <div class="banner">
            <a target="_blank" href="<?php if(!empty($output['bannerInfo'][0]['img_link'])){echo $output['bannerInfo'][0]['img_link'];}else{echo 'javascript:;';}?>">
                <img src="<?php echo $output['bannerInfo'][0]['img_url']?>" />
            </a>
        </div>
    <?php }?>

    <?php if(count($output['bannerInfo'])>1){?>
        <div class="lsfz-banner" style="height:480px;position: relative;">
            <ul id="fullScreenSlides" class="full-screen-slides">
                <?php foreach ($output['bannerInfo'] as $bk => $bv) {?>
                    <li style="background: url('<?php echo $bv['img_url']?>') center top no-repeat;">
                        <a href="<?php if(!empty($bv['img_link'])){echo $bv['img_link'];}else{echo 'javascript:;';}?>" title=""></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php }?>

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

    <div class="main">
        <ul class="aside-nav">
            <li class="cur"><a href="/member/index.php?controller=page&action=show&page_key=share_about">关于我们</a></li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=1">资质荣誉</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=35">知识产权</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=36">媒体报道</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=37">战略合伙</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=38">代理加盟</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=39">咨询通告</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=40">联系我们</a>
            </li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=41">地图导航</a>
            </li>
            <div class="advertisement">
                <img src="/data/upload/shop/article/05848264422944146.jpg">
            </div>
        </ul>


        <?php echo html_entity_decode($output['info'][2]['page_content']);?>


    </div>




<?php include template('layout/page_footer'); ?>