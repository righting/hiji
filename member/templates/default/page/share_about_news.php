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


    <div class="main clearfix">
        <div class="aside-nav">
            <li><a href="/member/index.php?controller=page&action=show&page_key=share_about">关于我们</a></li>
            <li>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=1">资质荣誉</a>
            </li>
            <li <?php if($_GET['type']==35){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=35">知识产权</a>
            </li>
            <li <?php if($_GET['type']==36){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=36">媒体报道</a>
            </li>
            <li <?php if($_GET['type']==37){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=37">战略合伙</a>
            </li>
            <li <?php if($_GET['type']==38){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=38">代理加盟</a>
            </li>
            <li <?php if($_GET['type']==39){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=39">咨询通告</a>
            </li>
            <li <?php if($_GET['type']==40){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=40">联系我们</a>
            </li>
            <li <?php if($_GET['type']==41){ echo ' class="cur" ';}?>>
                <a href="/member/index.php?controller=page&action=show&page_key=share_about&type=41">地图导航</a>
            </li>
            <div class="advertisement">
                <img src="/data/upload/shop/article/05848264422944146.jpg">
            </div>
        </div>
        <div class="about-mid">
            <h1 class="title">
                <a href="">关于我们</a><span>&gt;</span><a href=""><?php echo $output['top_title']?></a>
            </h1>
            <style>
                .about-mid h3 {
                    padding-left: 20px;
                    margin-bottom: 10px;
                    font-size: 13px;
                    font-weight: 600;
                    letter-spacing: 2px;
                    float:left;
                }
                .about-mid h4 {
                    font-size: 13px;
                    font-weight: 600;
                    float:right;
                    margin-right:20px;
                }
            </style>
            <div class="certificate" style="min-height:565px;">

                <?php if($output['type'] <40 ){?>
                    <?php foreach($output['article'] as $k=>$v){?>
                        <a target="_blank" href="<?php if(!empty($v['article_url'])){echo $v['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $v['article_id']));}?>">
                            <h3><?php echo $v['article_title']?></h3>
                            <h4><?php echo date('Y-m-d H:i:s',$v['article_time'])?></h4>
                        </a>
                        <div style="clear: both;"></div>
                    <?php }?>
                <?php }else{?>
                    <style>
                        .certificate{
                            height:auto;
                            padding:10px 20px;
                        }
                        .certificate img{
                            width:100%;
                        }
                    </style>

                    <?php echo htmlspecialchars_decode($output['article'][0]['article_content']);?>
                <?php }?>
            </div>
        </div>


    </div>
<?php include template('layout/page_footer'); ?>