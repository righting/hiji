<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/consumption_accumulation.css" type="text/css" />
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
    $banner_lsit = $banner_model->where(array('c_id'=>8))->select();

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
<div class="main">
    <div class="consumption">
        <div class="consumption-left">
            <div class="consumption-left-a">
                消费资本
            </div>
            <div class="consumption-left-b">
                <p class="consumption-left-b1">
                    钱生钱的余利
                </p>
                <p class="consumption-left-b2">
                    消费公积金
                </p>
            </div>
            <div class="consumption-left-c">
                <p class="consumption-left-c1">
                    点石成金
                </p>
                <p class="consumption-left-c2">
                    <span>自愿申请</span> <span>消费公积金账号</span>
                </p>
            </div>
            <div class="consumption-left-d">
                <p class="consumption-left-d1">
                    手中有粮心中不慌
                </p>
                <p class="consumption-left-d2">
                    <span>消费公积金等级额度</span> <span>充值留存</span>
                </p>
            </div>
        </div>

        <?php echo html_entity_decode($output['page'][0]['page_content']);?>

    </div>
</div>
<?php include template('layout/page_footer'); ?>