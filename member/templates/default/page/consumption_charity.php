<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/consumption_charity.css" type="text/css" />
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
    $banner_lsit = $banner_model->where(array('c_id'=>11))->select();

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
<div class="banner-bottom-text">
    <h1>
        您的善心，可以改变这些孩子。一份爱，一片情
    </h1>
</div>
<div class="main">
    <div class="csjj-detail">
        <div class="csjj-left">
            <h1>
                为什么要成立海吉慈善基金会？
            </h1>
            <p>
                海吉慈善基金，是由海吉壹佰自组建立的，属企业类非公募慈善基金会，是企业和会员个人自发自愿地无偿为弱势群体如贫困儿童、残疾人等通过捐赠到户、领助一对一、开发式扶助、参与式公益、自发救助等方式募捐或义工或公益的企业慈善机构。
            </p>
            <p>
                海吉慈善基金会，不忘初心、牢记使命，奉献着大爱公心和微薄之力，一如既往的赋能社会、赋能会员、赋能下一代。虽然我们的彩丽、屋里、人力、能力有限，但我们的大爱无限、情义无限，我们的社会责任大爱无疆。
            </p>
        </div>
        <div class="csjj-mid">
            <h1>
                任重道远
            </h1>
            <div class="csjj-min-banner">
                <img src="./fixation/images/csjj/csjj_03.jpg" />
            </div>
        </div>
        <div class="csjj-right">
            <h1>
                我们需要您的<span>持续支持</span>
            </h1>
            <ul class="csjj-news">
                <li>
                    仍有困境儿童需要别人帮助;
                </li>
                <li>
                    需要多一份关注，盖子焖才过的上正常生活;
                </li>
                <li>
                    孩子们需要关爱才能得到更多的健康治疗;
                </li>
                <li>
                    回到学校的孩子仍旧会因多种原因再次辍学;
                </li>
                <li>
                    孤儿们可能会因病而无法医治;
                </li>
            </ul>
<span>......</span>
            <div class="support-btn">
                <a class="support-once" href="">一次性支持</a> <a class="support-month" href="">每月支持</a>
            </div>
        </div>
    </div>
</div>
<?php include template('layout/page_footer'); ?>