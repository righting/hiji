<?php include template('layout/page_top'); ?>
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
    $banner_lsit = $banner_model->where(array('c_id'=>6))->select();

 ?>
<?php if($banner_lsit && count($banner_lsit)==1){ ?>

<div class="lsfz-banner">
    <img src="<?php echo $banner_lsit[0]['img_url']?>" />
</div>
<?php } ?>

<?php if($banner_lsit && count($banner_lsit)>1){ ?>

<div class="lsfz-banner" style="position: relative;">
    <ul id="fullScreenSlides" class="full-screen-slides">
        <?php foreach ($banner_lsit as $bk => $bv) {?>
        <li style="background: url('<?php echo $bv['img_url']?>') center top no-repeat;">
            <a href="" title=""></a>
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
<div class="lsfz-main">
    <div class="lsfz-aside">
        <div class="lsfz-aside-nav">
            <h5>
                绿色发展项目
            </h5>
            <ul>
                <li>
                    <a href="#lsfz-part1"> <i></i>中绿生态康养园</a>
                </li>
                <li>
                    <a href="#lsfz-part2"> <i></i>中绿农耕文化园</a>
                </li>
                <li>
                    <a href="#lsfz-part3"> <i></i>中绿三品一标贸促会</a>
                </li>
            </ul>
        </div>
        <div class="lsfz-aside-1 aside-banner-1">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_01.jpg" /></a>
        </div>
        <div class="lsfz-aside-2 aside-banner-1">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_02.jpg" /></a>
        </div>
        <div class="lsfz-aside-3 aside-banner-1">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_03.jpg" /></a>
        </div>
        <div class="lsfz-aside-4 aside-banner-1">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_04.jpg" /></a>
        </div>
        <div class="lsfz-aside-5 aside-banner-2">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_05.jpg" /></a>
        </div>
        <div class="lsfz-aside-6 aside-banner-2">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_06.jpg" /></a>
        </div>
        <div class="lsfz-aside-7 aside-banner-2">
            <a href=""><img src="./fixation/images/lsfz/lsfz-aside_07.jpg" /></a>
        </div>
        <div class="lsfz-aside-8 aside-banner-2">
            <h1>
                国家品牌
            </h1>
        </div>
        <div class="lsfz-last-nav">
            <a href="#lsfz-part4">
            <h3>
                众筹定制
            </h3>
            <h4>
                预售消费众扶模式
            </h4>
</a>
        </div>
    </div>
    <div class="lsfz-layout">
        <div id="lsfz-part1">
            <div class="lsfz-title">
                <img src="./fixation/images/lsfz/lsfz_title_01.jpg" />
            </div>
            <?php echo html_entity_decode($output['page'][0]['page_content']);?>
            <div class="lsfz-news">
                <div class="news-title">
                    <h1>
                        项目资讯与动态
                    </h1>
<a class="news-more" href="member/index.php?controller=article&action=article&ac_id=29">&gt;&gt;更多</a>
                </div>
                <ul class="news-list">
                    <?php foreach ($output['article1'] as $ak => $av) {?>
                        <li>
                        <a href="member/index.php?controller=article&action=show&article_id=<?php echo $av['article_id'];?>"><?php echo $av['article_title'];?></a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
        <div id="lsfz-part2">
            <div class="lsfz-title">
                <img src="./fixation/images/lsfz/lsfz_title_02.jpg" />
            </div>
            <?php echo html_entity_decode($output['page'][1]['page_content']);?>
            <div class="lsfz-news">
                <div class="news-title">
                    <h1>
                        项目资讯与动态
                    </h1>
<a class="news-more" href="member/index.php?controller=article&action=article&ac_id=30">&gt;&gt;更多</a>
                </div>
                <ul class="news-list">
                    <?php foreach ($output['article2'] as $ak => $av) {?>
                        <li>
                        <a href=""><?php echo $av['article_title'];?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div id="lsfz-part3">
            <div class="lsfz-title">
                <img src="./fixation/images/lsfz/lsfz_title_03.jpg" />
            </div>
        <?php echo html_entity_decode($output['page'][2]['page_content']);?>
            <div class="lsfz-news">
                <div class="news-title">
                    <h1>
                        项目资讯与动态
                    </h1>
<a class="news-more" href="member/index.php?controller=article&action=article&ac_id=31">&gt;&gt;更多</a>
                </div>
                <ul class="news-list">
                    <?php foreach ($output['article3'] as $ak => $av) {?>
                        <li>
                        <a href=""><?php echo $av['article_title'];?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div id="lsfz-part4">
            <div class="lsfz-title">
                <img src="./fixation/images/lsfz/lsfz_title_04.jpg" />
            </div>
            <div class="zc-title">
                <h2>
                    推动生活性服务业融合发展，鼓励发展针对个性化需求的定制服务。——十三五规划
                </h2>
                <h2>
                    发展公众众扶、分享众扶和互助众扶。——十三五规划
                </h2>
            </div>
            <?php echo html_entity_decode($output['page'][3]['page_content']);?>
        </div>
    </div>

</div>
<?php include template('layout/page_footer'); ?>