<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/consumption_integral.css" type="text/css" />
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
    $banner_lsit = $banner_model->where(array('c_id'=>7))->select();

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
    <div class="hijiintegral-a">
        <span>购分红 购赚钱</span> <span>推荐好友入会购物</span> <span>永久消费积分红利</span>
    </div>
    <div class="hijiintegral">
        <div class="hijiintegral-left">
            <div class="hijiintegral-b">
                <div class="hijiintegral-left-a">
                    <p>
                        用花掉的钱赚钱
                    </p>
                </div>
<a href="#">
                <div class="hijiintegral-left-b">
                    点我！分享给小伙伴们
                </div>
</a>
            </div>
            <div class="hijiintegral-c">
                <div class="hijiintegral-left-c">
                    <img src="./fixation/images/hijiintegral3.png" />
                </div>
                <p>
                    海吉积分  普惠民生
                </p>
            </div>
            <div class="hijiintegral-d">
                <div class="hijiintegral-left-d">
                    <p>
                        1海吉积分=1元人民币
                    </p>
                    <p>
                        海吉积分计量单位：
                    </p>
                    <p>
                        海豚主场·HS
                    </p>
                    <p>
                        非海豚主场消费·H
                    </p>
                </div>
            </div>
        </div>
        <?php echo html_entity_decode($output['page'][0]['page_content']);?>
        <div class="hijiintegral-bottom">
            <span>海吉积分 · </span> <span>用处利好</span>
        </div>
        <div class="hijiintegral-explain">
            <div class="hijiintegral-explain-a">
                <img src="./fixation/images/hijiintegral10.png" />
            </div>
            <div class="hijiintegral-explain-b">
                <div class="hijiintegral-right-a">
                    <p class="hijiintegral-right-a1">
                        海吉积分有什么用途？
                    </p>
                </div>
                <ul>
                    <li>
                        <p>
                            兑换商品
                        </p>
                        <p>
                            海量商品任您兑换
                        </p>
                    </li>
                    <li>
                        <p>
                            晋级晋升
                        </p>
                        <p>
                            累计积分晋升身份等级
                        </p>
                    </li>
                    <li>
                        <p>
                            积分通兑
                        </p>
                        <p>
                            与各大积分通兑通用
                        </p>
                    </li>
                    <li>
                        <p>
                            积分抽奖
                        </p>
                        <p>
                            积分可用来参与抽奖
                        </p>
                    </li>
                </ul>
            </div>
            <div class="provide-right-b">
                <br />
            </div>
        </div>
    </div>
</div>
<?php include template('layout/page_footer'); ?>