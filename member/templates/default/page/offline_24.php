<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/smart-store.css" type="text/css" />
<link rel="stylesheet" href="/member/templates/default/css/video-js.css" type="text/css" />
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
    $banner_lsit = $banner_model->where(array('c_id'=>14))->select();
    $bannerCenter = $banner_model->where(array('c_id'=>26))->limit(4)->select();
    $bannerCenterThree = $banner_model->where(array('c_id'=>27))->find();

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

    <?php echo html_entity_decode($output['page'][0]['page_content']);?>

    <div class="smart-part2 wrapper">

        <a class="smart-video" href="javascript:void(0)" data-src="<?php echo $output['videoInfo'][0]['video_url']?>" data-img="/data/upload/shop<?php echo $output['videoInfo'][0]['video_img']?>" data-title="<?php echo $output['videoInfo'][0]['video_title']?>">
            <div class="smart-video-poster">
                <img src="/data/upload/shop<?php echo $output['videoInfo'][0]['video_img']?>">
            </div>
            <div class="smart-video-play"></div>
            <div class="smart-video-title">
                <h2>智能便利店·宣传片</h2></div>
        </a>

        <div class="smart-carousel">
            <ul class="smart-slider">
                <?php foreach($bannerCenter as $k=>$v){?>
                    <li style="background: url('<?php echo $v['img_url']?>') center top no-repeat;">
                        <a target="_blank" href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else{echo 'javascript:;';}?>">
                    </li>
                <?php }?>
            </ul>
        </div>

        <?php echo html_entity_decode($output['page'][1]['page_content']);?>

    </div>

    <?php if(!empty($bannerCenterThree)){?>
    <div class="smart-part3">
        <a target="_blank" href="<?php if(!empty($bannerCenterThree['img_link'])){echo $bannerCenterThree['img_link'];}else{echo 'javascript:;';}?>">
        <img src="<?php echo $bannerCenterThree['img_url']?>">
        </a>
    </div>
    <?php }?>


    <?php echo html_entity_decode($output['page'][2]['page_content']);?>

    <?php echo html_entity_decode($output['page'][3]['page_content']);?>

    <div class="smart-message wrapper">
        <div class="hotline">
            <h2>领先一步 步步领先</h2>
            <div class="hotline-box">
                <span></span>
                <h1>400-013-6839</h1>
            </div>
            <h2>主动出击 抢占先机</h2>
        </div>
        <div class="message-submit">
            <div action="">
                <div>
                    <label for="name">姓名：</label>
                    <input type="text" id="name" value="" style="color:white;">
                    <span>* 您的真实姓名</span>
                </div>
                <div>
                    <label for="phone">手机：</label>
                    <input type="text" id="phone" value="" style="color:white;">
                    <span>* 回访核实</span>
                </div>
                <div>
                    <label for="weixin">微信：</label>
                    <input type="text" id="weixin" value="" style="color:white;">
                    <span>&nbsp;&nbsp;&nbsp;您的微信号</span>
                </div>
                <div>
                    <label for="area">区域：</label>
                    <input type="text" id="area" value="" style="color:white;">
                    <span>&nbsp;&nbsp;&nbsp;要求加盟地区地址</span>
                </div>

                <button onclick="toSubmit()">提交</button>
            </div>
        </div>
        <div class="members-message">
            <h2>我要留言：</h2>
            <textarea name="" id="message"></textarea>
        </div>
    </div>

    <div class="bg">
        <div class="sharemodule-video">
            <div class="sharemodule-video-guan">
                <span class="sharemodule-video-guan-a"></span>
                <a href="javascript:void(0);">
                    <span class="sharemodule-video-guan-b"></span>
                </a>
            </div>

            <video id="my-video" class="video-js" controls preload="auto">
            </video>
        </div>
    </div>

    <script src="/member/templates/default/js/jquery.min.js"></script>
    <script src="/member/templates/default/js/carousel.js"></script>
    <script src="/member/templates/default/js/video.min.js"></script>
    <script>
        $(function() {
            $('.smart-slider').fullScreen({css:'smart-page'});
        });
       /* $(function() {
            $.getJSON('http://hiji100.com/ngyp/index.php?controller=index&action=indexajax',function(data) {
                $('.smart-video').find('img').attr('src',data.msg[0].video_img);
                $('.smart-video').find('h2').html(data.msg[0].video_title);
                $('.smart-video').attr('data-src',data.msg[0].video_url);
                $('.smart-video').attr('data-img',data.msg[0].video_img);
                $('.smart-video').attr('data-title',data.msg[0].video_title);
            })
        })*/
        $(".bg").height($(window).height());
        $(".bg").width($(window).width());
        $(".smart-video").click(function() {
            $(".bg").show();
            // var myPlayer = videojs('my-video');
            var videoUrl = $(this).data("src");
            var videoTitle = $(this).data("title");
            var videoImg = $(this).data("img");
            videojs("my-video", {}, function() {
                window.myPlayer = this;
                console.log(myPlayer);
                var sourceDom = $("<source src=\""+ videoUrl +"\">");
                $(".sharemodule-video video").append(sourceDom);
                $(".sharemodule-video video").attr('poster',videoImg);
                $(".sharemodule-video .sharemodule-video-guan-a").html(videoTitle);
                myPlayer.src(videoUrl);
                myPlayer.load(videoUrl);
                myPlayer.pause();
            });
        });
        $(".sharemodule-video-guan-b").click (function () {
            videojs("my-video").ready(function(){
                $(".sharemodule-video video").children().remove()
                $(".bg").hide();
                var myPlayer = this;
                myPlayer.pause();;
            });

        })



        function toSubmit(){
            var name = $('#name').val();
            var phone = $('#phone').val();
            var weixin = $('#weixin').val();
            var area  = $('#area').val();
            var message = $('#message').val();
            if(name==''){
                alert('请输入你的联系名字');
                return;
            }
            if(phone==''){
                alert('请输入您的联系号码');
                return;
            }
            if(message==''){
                alert('请填写留言内容');
                return;
            }
            $.ajax({
                url: '/member/index.php?controller=page&action=message',
                data:{name:name,phone:phone,weixin:weixin,area:area,message:message},
                type:'post',
                dataType: 'json',
                success:function(data){
                    alert('留言成功');
                    window.location.reload();
                }
            });


        }

    </script>




<?php include template('layout/page_footer'); ?>