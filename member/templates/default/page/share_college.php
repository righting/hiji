<?php include template('layout/page_top'); ?>
    <link rel="stylesheet" href="/member/templates/default/css/new_bases.css" type="text/css" />
    <link rel="stylesheet" href="/member/templates/default/css/school.css" type="text/css" />
    <link rel="stylesheet" href="/member/templates/default/css/video-js.css" type="text/css" />


<?php if(!empty($output['bannerInfo'])){?>
    <div class="business-banner01">
        <img src="<?php echo $output['bannerInfo'][0]['img_url']?>">
    </div>
<?php }?>


    <div class="business-main main">
        <div class="aside-nav">
            <ul>
                <li class="cur"><a href="/member/index.php?controller=page&action=show&page_key=share_college">全部课程</a></li>
                <li><a href="/member/index.php?controller=page&action=show&page_key=share_college_sq">海吉商圈</a></li>
                <li><a href="javascript:;">行业领地</a></li>
                <li><a href="javascript:;">实力商家</a></li>
                <li><a href="javascript:;">精品直播</a></li>
                <li><a href="javascript:;">内容品质</a></li>
                <li><a href="javascript:;">图文商说</a></li>
                <li><a href="javascript:;">成为讲师</a></li>
                <li><a href="javascript:;">经营管理</a></li>
                <li><a href="javascript:;">公信力建设</a></li>
            </ul>
        </div>
        <div class="business-video">


            <?php if(count($output['glInfo']) >= 1 ){?>
            <div class="business-wrap">
                <div class="business-header">
                    <h1>经营管理</h1>
                    <a href="javascript:;">更多&gt;&gt;</a>
                </div>
                <div class="school-video">
                    <?php foreach($output['glInfo'] as $k=>$v){?>
                        <a href="javascript:void(0);" data-img="/data/upload/shop<?php echo $v['video_img']?>" data-title="<?php echo $v['video_title']?>" data-src="<?php echo $v['video_url']?>">
                            <div class="video-poster">
                                <img src="/data/upload/shop<?php echo $v['video_img']?>">
                            </div>
                            <div class="video-play"></div>
                            <div class="video-title">
                                <h2><?php echo $v['video_title']?></h2>
                                <!--<div class="teacher">
                                    <span>讲师：<em>XXX</em></span>
                                    <p>打赏：<em>X个</em><i></i></p>
                                </div>-->
                            </div>
                        </a>
                    <?php }?>
                </div>
            </div>
            <?php }?>



            <?php if(count($output['gxlInfo']) >= 1 ){?>
                <div class="business-wrap">
                    <div class="business-header">
                        <h1>公信力建设</h1>
                        <a href="javascript:;">更多&gt;&gt;</a>
                    </div>
                    <div class="school-video">
                        <?php foreach($output['gxlInfo'] as $k=>$v){?>
                            <a href="javascript:void(0);" data-img="/data/upload/shop<?php echo $v['video_img']?>" data-title="<?php echo $v['video_title']?>" data-src="<?php echo $v['video_url']?>">
                                <div class="video-poster">
                                    <img src="/data/upload/shop<?php echo $v['video_img']?>">
                                </div>
                                <div class="video-play"></div>
                                <div class="video-title">
                                    <h2><?php echo $v['video_title']?></h2>
                                    <!--<div class="teacher">
                                        <span>讲师：<em>XXX</em></span>
                                        <p>打赏：<em>X个</em><i></i></p>
                                    </div>-->
                                </div>
                            </a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>




            <?php if(count($output['hjsqInfo']) >= 1 ){?>
                <div class="business-wrap">
                    <div class="business-header">
                        <h1>海吉商圈</h1>
                        <a href="javascript:;">更多&gt;&gt;</a>
                    </div>
                    <div class="school-video">
                        <?php foreach($output['hjsqInfo'] as $k=>$v){?>
                            <a href="javascript:void(0);" data-img="/data/upload/shop<?php echo $v['video_img']?>" data-title="<?php echo $v['video_title']?>" data-src="<?php echo $v['video_url']?>">
                                <div class="video-poster">
                                    <img src="/data/upload/shop<?php echo $v['video_img']?>">
                                </div>
                                <div class="video-play"></div>
                                <div class="video-title">
                                    <h2><?php echo $v['video_title']?></h2>
                                    <!--<div class="teacher">
                                        <span>讲师：<em>XXX</em></span>
                                        <p>打赏：<em>X个</em><i></i></p>
                                    </div>-->
                                </div>
                            </a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>


        <?php if(!empty($output['bannerInfoBottom'])){?>
            <div class="business-bottom">
                <div class="business-bottom-wrap business-bottom-left" style="height:150px;">
                    <a target="_blank" href="<?php if(!empty($output['bannerInfoBottom'][0]['img_link'])){ echo $output['bannerInfoBottom'][0]['img_link'];}else{ echo 'javascript:;';}?>">
                        <img style="width:100%;height:100%;" src="<?php echo $output['bannerInfoBottom'][0]['img_url']?>" />
                    </a>
                </div>
                <div class="business-bottom-wrap business-bottom-right" style="height:150px;">
                    <a target="_blank" href="<?php if(!empty($output['bannerInfoBottom'][1]['img_link'])){ echo $output['bannerInfoBottom'][1]['img_link'];}else{ echo 'javascript:;';}?>">
                    <img style="width:100%;height:100%;" src="<?php echo $output['bannerInfoBottom'][1]['img_url']?>" />
                    </a>
                </div>
            </div>
        <?php }?>

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
    <script src="/member/templates/default/js/video.min.js"></script>
    <script>
        $(function() {
            /*if(!$('.school-video a img').src) {
                $('.school-video a img').attr('src','/member/templates/default/images/school/video-poster.png');
            }*/
          /*  $.getJSON('http://hiji100.com/ngyp/index.php?controller=index&action=indexajax',function(data) {
                console.log(data);
                $('.school-video a').each(function(i) {
                    $(this).find('img').attr('src',data.msg[i].video_img);
                    console.log(data.msg[i].video_img);

                    $(this).find('h2').html(data.msg[i].video_title);
                    $(this).attr('data-src',data.msg[i].video_url);
                    $(this).attr('data-img',data.msg[i].video_img);
                    $(this).attr('data-title',data.msg[i].video_title);
                })
            })*/
        })

        $(".bg").height($(window).height());
        $(".bg").width($(window).width());
        $(".school-video a").click(function() {
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

    </script>

<?php include template('layout/page_footer'); ?>