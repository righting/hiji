<?php include template('layout/page_top'); ?>
    <link rel="stylesheet" href="/member/templates/default/css/business.css" type="text/css" />
    <link rel="stylesheet" href="/member/templates/default/css/video-js.css" type="text/css" />


<?php if(!empty($output['bannerInfo'])){?>
    <div class="business-banner01">
        <img src="<?php echo $output['bannerInfo'][0]['img_url']?>">
    </div>
<?php }?>

    <div class="business-main">
        <div class="aside-nav">
            <ul>
                <li><a href="/member/index.php?controller=page&action=show&page_key=share_college">全部课程</a></li>
                <li  class="cur"><a href="/member/index.php?controller=page&action=show&page_key=share_college_sq">海吉商圈</a></li>
                <li><a href="javascript:;">行业领地</a></li>
                <li><a href="javascript:;">实力商家</a></li>
                <li><a href="javascript:;">精品直播</a></li>
                <li><a href="javascript:;">内容品质</a></li>
                <li><a href="javascript:;">图文商说</a></li>
                <li><a href="javascript:;">成为讲师</a></li>
                <li><a href="javascript:;">经营管理</a></li>
                <li><a href="javascript:;">公信力建设</a></li>
            </ul>
            <div class="business-loser">
                <div class="business-loser-b">
                    <div class="business-loser-a">
                        <div class="business-loser-a1">海吉商圈</div>
                    </div>

                    <a href="javascript:;">
                        <div class="business-loser-c">
                            申请加入
                        </div>
                    </a>
                </div>

                <div class="business-loser-d">
                    <p class="business-loser-d1">圈公告</p>
                    <p class="business-loser-d2">
                        海吉壹佰海吉商圈APP以“以商会友、一圈汇人”手机客户端唯一官方交流讨论社群圈、提供最新推荐、
                        活动通知、获奖结果等公告，收集用户意见和需求，管理APP各应用工具中的服务和处理事项。
                    </p>
                </div>

            </div>
        </div>
        <div class="business-right">
            <div class="business-right-a">
                <div class="business-right-a1">
                    <span class="business-right-a2"></span>
                    <span class="business-right-a3">
                    全部课程>海吉商圈
                </span>
                </div>

                <div class="business-right-b">
                    <div class="business-right-b1">
                        <div class="business-video">
                            <video id="my-video" class="video-js" controls preload="auto" poster="/data/upload/shop<?php echo $output['hjsqInfo'][0]['video_img']?>">
                                <source src="<?php echo $output['hjsqInfo'][0]['video_url']?>" type="video/mp4"  >
                            </video>
                        </div>

                        <div class="business-right-b1-a">
                            <p><?php echo $output['hjsqInfo'][0]['video_title']?></p>
                        </div>
                    </div>
                <?php
                    $article_model  = Model('article');
                    $where['ac_id'] = 51;
                    $where['limit'] = 9;
                    $article = $article_model->getArticleList($where);
                ?>
                    <div class="business-right-b2">
                        <ul class="business-right-b2-a">
                            <a target="_blank" href="<?php if(!empty($article[0]['article_url'])){echo $article[0]['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $article[0]['article_id']));}?>">
                                <li>
                                    <img src="<?php echo $article[0]['article_image'];?>">
                                </li>
                            </a>
                            <li>
                                <?php foreach($article as $k=>$v){?>
                                    <?php if($k>0){?>
                                        <a target="_blank" href="<?php if(!empty($v['article_url'])){echo $v['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $v['article_id']));}?>">
                                            <p>·<?php echo $v['article_title'];?></p></a>
                                    <?php }?>
                                <?php }?>
                            </li>
                        </ul>
                        <a target="_blank" href="<?php if(!empty($article[0]['article_url'])){echo $article[0]['article_url'];}else{echo urlMember('article', 'show', array('article_id' => $article[0]['article_id']));}?>">
                            <p class="business-right-b2-c">
                                标题：<?php echo $article[0]['article_title'];?>
                            </p>
                            <p class="business-right-b2-c2">
                                简介：<?php echo $article[0]['article_content'];?>
                            </p>
                        </a>
                    </div>
                </div>

            </div>

            <div class="business-right-c">
                <img src="/member/templates/default/images/business6.png">
            </div>

            <?php echo html_entity_decode($output['page'][0]['page_content']);?>

            <?php echo html_entity_decode($output['page'][1]['page_content']);?>

            <?php echo html_entity_decode($output['page'][2]['page_content']);?>


        </div>
    </div>
    <script src="/member/resource/js/jquery.min.js"></script>
    <script src="/member/resource/js/video.min.js"></script>
    <script src="/member/resource/js/zh-CN.js"></script>
    <script>
        $(".business-video").click(function () {
            $(".business-right-b1-a").hide();
        });

        //控制播放暂停
        var myPlayer = videojs('my-video');
        videojs("my-video").ready(function(){
            var myPlayer = this;
            myPlayer.pause();

        });
    </script>
<?php include template('layout/page_footer'); ?>