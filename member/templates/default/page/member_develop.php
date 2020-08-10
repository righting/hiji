<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/member_develop.css" type="text/css" />
<?php
$banner_model  = Model('banner');
$banner_lsit = $banner_model->where(array('c_id'=>32))->select();

?>
<?php if($banner_lsit && count($banner_lsit)==1){ ?>

    <div class="lsfz-banner" style="width:100%;height: 480px">
        <img src="<?php echo $banner_lsit[0]['img_url']?>" style="width: 100%;height: 100%"/>
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
    <div class="members-main">
        <div class="members-left">
            <div class="banner-container">
                <ul class="banner-pic">
                    <?php foreach($output['bannerInfo'] as $k=>$v){?>
                        <li>
                            <a target="_blank" href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else{echo 'javascript:;';}?>">
                                <img src="<?php echo $v['img_url']?>" />
                                <p><?php echo $v['title'];?></p>
                            </a>
                        </li>
                    <?php }?>
                </ul>
                <ul class="img-thumb">
                    <?php foreach($output['bannerInfo'] as $k=>$v){?>
                        <li <?php if($k==0){echo ' class="cur"';}?> >
                            <a href="javascript:;"> <img src="<?php echo $v['img_url']?>" /></a>
                        </li>
                    <?php }?>
                </ul>
            </div>


            <div class="hot-spots">
                <?php if(!empty($output['article1'][0])){?>
                    <div class="hot-title">
                        <h1>
                            中心热点
                        </h1>
                    </div>

                    <div class="hot-header">
                        <a target="_blank" href="<?php if(!empty($output['article1'][0]['article_url'])){echo $output['article1'][0]['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $output['article1'][0]['article_id']));}?>">
                            <div class="hot-header-item">
                                <div class="hot-header-img">
                                    <img src="/member/fixation/images/member_02.jpg" />
                                </div>
                                <?php echo $output['article1'][0]['article_title']?>
                            </div>
                        </a>
                        <?php if(!empty($output['article1'][1])){?>
                            <a target="_blank" href="<?php if(!empty($output['article1'][1]['article_url'])){echo $output['article1'][1]['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $output['article1'][1]['article_id']));}?>">
                            <div class="hot-header-item">
                                <div class="hot-header-img">
                                    <img src="/member/fixation/images/member_03.jpg" />
                                </div>
                                <?php echo $output['article1'][1]['article_title']?>
                            </div>
                            </a>
                        <?php }?>
                    </div>

                <?php }?>
                <?php if(is_array($output['article2']) && !empty($output['article2'])){?>
                <div class="vip-menu">
                    <div class="vip-title">
                        <h3>
                            全球发展
                        </h3>
                        <h2>
                            品牌会员中心名录
                        </h2>
                    </div>
                    <div class="vip-lists">
                        <ul>
                            <?php foreach($output['article2'] as $k=>$v){?>
                                <li>
                                    <a target="_blank" href="<?php if(!empty($v['article_url'])){echo $v['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $v['article_id']));}?>">
                                        <?php echo $v['article_title'];?>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="aside-banner">
                <img src="/member/fixation/images/member_04.jpg" />
            </div>
        </div>
        <div class="members-right">

            <?php echo htmlspecialchars_decode($output['info'][0]['page_content']);?>

            <div class="members-submit clearfix">
                <div class="hotline">
                    <h2>
                        不要
                    </h2>
                    <h2>
                        让机会
                    </h2>
                    <div class="hotline-box">
                        <span></span>
                        <h1>
                            400-013-6839
                        </h1>
                    </div>
                    <h2>
                        死在
                    </h2>
                    <h2>
                        别人的嘴里
                    </h2>
                </div>
                <div class="message-submit">
                    <div>
                        <label for="name">姓名：</label>
                        <input id="name"  type="text" />
                        <label for="phone">手机：</label>
                        <input id="phone" type="text" />
                        <label for="weixin">微信：</label>
                        <input id="weixin" type="text" />
                        <label for="area">区域：</label>
                        <input id="area" type="text" />
                        <button onclick="toSubmit()">提交</button>
                    </div>
                </div>
                <div class="members-message">
                    <h2>
                        我要留言：
                    </h2>
                    <textarea name="" id="message"></textarea>
                </div>

            </div>
        </div>
    </div>
    <script src="/member/resource/js/vip.js"></script>

<script>
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