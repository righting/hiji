<link href="<?php echo NGYP_TEMPLATES_URL; ?>/css/zcdz.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo NGYP_TEMPLATES_URL;?>/css/swiper-3.4.2.min.css">
<style>
    .clearfix{
        display:block;
    }

    .carousel {
        width: 100%;
        height: 480px;
        overflow: hidden;
    }

    .carousel-stm {
        width: 100%;
        height: 100%;
    }

    .carousel-stm>.frequency>li>a{
        display: block;
    }

    .frequency li {
        width: 100%;
        height: 480px;
        overflow: hidden;
    }

    .banner{
        width: 100%;
        height: 480px;

    }

    .swiper-pagination-bullet{
        width: 15px;
        height: 15px;
    }

    .swiper-pagination-bullet-active{
        background-color: #52d04c !important;
    }

    .swiper-pagination{
        background: none!important;
    }

</style>

<!-- 焦点图 Begin-->
<div class="carousel">
    <div class="carousel-stm swiper-container ">
        <ul  class="swiper-wrapper frequency">
            <?php foreach($output['top_banner'] as $k=>$v){?>
                <li class="swiper-slide">
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
                </li>
            <?php }?>
        </ul>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script src="<?php echo NGYP_TEMPLATES_URL;?>/js/swiper.min.js"></script>
<script>
    //轮播图
    //轮播图
    var swiper = new Swiper('.carousel-stm', {
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },

    });

</script>



<!-- 焦点图 End-->

<!-- 投资金额统计 Begin -->
<ul class="invest wrapper clearfix" style="display: block">
    <li>投资总金额<em>141845202.00</em>元</li>
    <li>累计赚取<em>5498123.64</em>元</li>
    <li>投资总人数<em>51521</em>人</li>
    <li>完成项目数<em>2016</em>个</li>
</ul>
<!-- 投资金额 End -->

<div class="divider"></div>

<div class="wrapper zc-main">
    <div class="broadcast">
        <i></i><span>关于“汽融众筹”2016七夕活动公告及庆祝平台注册用户过万活动</span>
    </div>
    <div class="zc-banner-01">
        <?php foreach($output['ad_a'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>"></a>
        <?php }?>
    </div>
    <div class="zc-part1 clearfix">
        <div class="zc-tool">
            <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-tool-bg.png" usemap="#Map">
            <map name="Map">
                <area shape="rect" coords="35,40,165,220" href="">
                <area shape="rect" coords="224,39,391,222" href="">
                <area shape="rect" coords="444,42,625,219" href="">
                <area shape="rect" coords="681,38,796,212" href="">
            </map>
        </div>
        <div class="zc-rank">
            <ul class="zc-rank-title clearfix">
                <li>排名</li>
                <li>用户名</li>
                <li>投资金额</li>
            </ul>
            <ul class="zc-rank-sub">
                <li>
                    <i></i>
                    <em>u***dn</em>
                    <span>￥1,215,611</span>
                </li>
                <li>
                    <i><strong>2</strong></i>
                    <em>jy***jy</em>
                    <span>￥215,611</span>
                </li>
                <li>
                    <i><strong>3</strong></i>
                    <em>c**er</em>
                    <span>￥15,611</span>
                </li>
                <li>
                    <i><strong>4</strong></i>
                    <em>**er</em>
                    <span>￥5,611</span>
                </li>
                <li>
                    <i><strong>5</strong></i>
                    <em>u***dn</em>
                    <span>￥61</span>
                </li>

            </ul>
        </div>
    </div>
    <div class="zc-part2 clearfix" style="display: block">
        <div class="prev-wrap">
            <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-prev.jpg">
        </div>
        <div class="prev-detail">
            <h1>12.3英寸轻薄二合一平板电脑</h1>
            <span>众筹定制第三十二期项目-笔记本电脑</span>
            <div class="prev-divider"></div>
            <p class="zc-target">众筹目标：<em>254.80</em><i>万元</i></p>
            <p class="zc-start">距离项目开始时间：<span>10小时53分钟47秒</span></p>
            <a class="link-detail" href="">查看详情</a>
        </div>
    </div>
    <div class="zc-container">
        <div class="zc-title clearfix">
            <h1>所有项目</h1>
            <span>财富增值 智慧之选!</span>
            <a href="">查看更多&gt;&gt;</a>
        </div>
        <div class="zc-title-divider"></div>
        <ul class="zc-all-wrap">
            <li class="clearfix" style="display: block">
                <div class="zc-processing fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-01.jpg">
                </div>
                <div class="zc-project-all fl">
                    <h1>卡帝乐鳄鱼 CARTELO 休闲鞋男士定制潮款（第8期）</h1>
                    <ul class="clearfix">
                        <li>
                            <p><em>34.45</em>万元</p>
                            <span>众筹目标</span>
                        </li>
                        <li>
                            <p><em>1</em>个月</p>
                            <span>剩余时间</span>
                        </li>
                        <li>
                            <p><em>2</em>笔</p>
                            <span>认筹笔数</span>
                        </li>
                        <li class="progress-wrap">
                            <div class="progress">
                                <div class="progress-striped">
                                    <div class="progress-bar-striped" style="width: 64%;"></div>
                                </div>
                                <label>64%</label>
                            </div>
                            <div>溢价回购期限： <i>40天</i></div>
                        </li>
                        <li>
                            <a class="confirm-btn" href="">我要认筹</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-processing fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-01.jpg">
                </div>
                <div class="zc-project-all fl">
                    <h1>卡帝乐鳄鱼 CARTELO 休闲鞋男士定制潮款（第8期）</h1>
                    <ul class="clearfix">
                        <li>
                            <p><em>34.45</em>万元</p>
                            <span>众筹目标</span>
                        </li>
                        <li>
                            <p><em>1</em>个月</p>
                            <span>剩余时间</span>
                        </li>
                        <li>
                            <p><em>2</em>笔</p>
                            <span>认筹笔数</span>
                        </li>
                        <li class="progress-wrap">
                            <div class="progress">
                                <div class="progress-striped">
                                    <div class="progress-bar-striped" style="width: 80%;"></div>
                                </div>
                                <label>80%</label>
                            </div>
                            <div>溢价回购期限： <i>40天</i></div>
                            <div>发布商： <i>xx科技有限公司</i></div>
                        </li>
                        <li>
                            <a class="confirm-btn" href="">我要认筹</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-processing fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-01.jpg">
                </div>
                <div class="zc-project-all fl">
                    <h1>卡帝乐鳄鱼 CARTELO 休闲鞋男士定制潮款（第8期）</h1>
                    <ul class="clearfix">
                        <li>
                            <p><em>34.45</em>万元</p>
                            <span>众筹目标</span>
                        </li>
                        <li>
                            <p><em>1</em>个月</p>
                            <span>剩余时间</span>
                        </li>
                        <li>
                            <p><em>2</em>笔</p>
                            <span>认筹笔数</span>
                        </li>
                        <li class="progress-wrap">
                            <div class="progress">
                                <div class="progress-striped">
                                    <div class="progress-bar-striped" style="width: 10%;"></div>
                                </div>
                                <label>10%</label>
                            </div>
                            <div>溢价回购期限： <i>40天</i></div>
                            <div>发布商： <i>xx科技有限公司</i></div>
                        </li>
                        <li>
                            <a class="confirm-btn" href="">我要认筹</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-processing fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-01.jpg">
                </div>
                <div class="zc-project-all fl">
                    <h1>卡帝乐鳄鱼 CARTELO 休闲鞋男士定制潮款（第8期）</h1>
                    <ul class="clearfix">
                        <li>
                            <p><em>34.45</em>万元</p>
                            <span>众筹目标</span>
                        </li>
                        <li>
                            <p><em>1</em>个月</p>
                            <span>剩余时间</span>
                        </li>
                        <li>
                            <p><em>2</em>笔</p>
                            <span>认筹笔数</span>
                        </li>
                        <li class="progress-wrap">
                            <div class="progress">
                                <div class="progress-striped">
                                    <div class="progress-bar-striped" style="width: 77%;"></div>
                                </div>
                                <label>77%</label>
                            </div>
                            <div>溢价回购期限： <i>40天</i></div>
                            <div>发布商： <i>xx科技有限公司</i></div>
                        </li>
                        <li>
                            <a class="confirm-btn" href="">我要认筹</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-processed fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-01.jpg">
                </div>
                <div class="zc-project-all fl">
                    <h1>卡帝乐鳄鱼 CARTELO 休闲鞋男士定制潮款（第8期）</h1>
                    <ul class="clearfix">
                        <li>
                            <p><em>34.45</em>万元</p>
                            <span>众筹目标</span>
                        </li>
                        <li>
                            <p><em>1</em>个月</p>
                            <span>剩余时间</span>
                        </li>
                        <li>
                            <p><em>2</em>笔</p>
                            <span>认筹笔数</span>
                        </li>
                        <li class="progress-wrap">
                            <div class="progress">
                                <div class="progress-striped">
                                    <div class="progress-bar-striped" style="width: 100%;"></div>
                                </div>
                                <label>100%</label>
                            </div>
                            <div>溢价回购期限： <i>40天</i></div>
                            <div>发布商： <i>xx科技有限公司</i></div>
                        </li>
                        <li>
                            <a class="sellout-btn" href="javacript:void()">已售出</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="zc-container">
        <div class="zc-title clearfix">
            <h1>成功案例</h1>
            <span>安心理财 坐享收益</span>
            <a href="">查看更多&gt;&gt;</a>
        </div>
        <div class="zc-title-divider"></div>
        <ul class="zc-success clearfix">
            <li>
                <div class="success-wrap">
                    <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-prev.jpg"></a>
                    <div class="success-mask"></div>
                    <div class="success-text">第五十期项目：云雾 - 绿茶</div>
                </div>
                <ul class="success-detail">
                    <li>众筹目标：<em>281.33</em><span>万元</span></li>
                    <li>万元收益：<em>323.41</em><span>元</span></li>
                    <li>认筹笔数：<em>8</em><span>笔</span></li>
                </ul>
            </li>
            <li>
                <div class="success-wrap">
                    <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-prev.jpg"></a>
                    <div class="success-mask"></div>
                    <div class="success-text">第五十期项目：云雾 - 绿茶</div>
                </div>
                <ul class="success-detail">
                    <li>众筹目标：<em>281.33</em><span>万元</span></li>
                    <li>万元收益：<em>323.41</em><span>元</span></li>
                    <li>认筹笔数：<em>8</em><span>笔</span></li>
                </ul>
            </li>
            <li>
                <div class="success-wrap">
                    <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-prev.jpg"></a>
                    <div class="success-mask"></div>
                    <div class="success-text">第五十期项目：云雾 - 绿茶</div>
                </div>
                <ul class="success-detail">
                    <li>众筹目标：<em>281.33</em><span>万元</span></li>
                    <li>万元收益：<em>323.41</em><span>元</span></li>
                    <li>认筹笔数：<em>8</em><span>笔</span></li>
                </ul>
            </li>
            <li>
                <div class="success-wrap">
                    <a href=""><img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-prev.jpg"></a>
                    <div class="success-mask"></div>
                    <div class="success-text">第五十期项目：云雾 - 绿茶</div>
                </div>
                <ul class="success-detail">
                    <li>众筹目标：<em>281.33</em><span>万元</span></li>
                    <li>万元收益：<em>323.41</em><span>元</span></li>
                    <li>认筹笔数：<em>8</em><span>笔</span></li>
                </ul>
            </li>

        </ul>
    </div>
    <div class="zc-container">
        <div class="zc-title clearfix">
            <h1>消费定制</h1>
            <span>买买买</span>
            <a href="">查看更多&gt;&gt;</a>
        </div>
        <div class="zc-title-divider"></div>
        <ul class="zc-customize-wrap">
            <li class="clearfix" style="display: block">
                <div class="zc-customize fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-02.jpg">
                </div>
                <div class="zc-customize-detail fl">
                    <h1>床上四件套全棉纯棉</h1>
                    <ul class="clearfix">
                        <li>
                            <p>起订量：<em>1000件</em></p>
                            <p>起订价：<em>20元/件</em></p>
                        </li>
                        <li class="customize-form clearfix">
                            <h3 class="fl">优惠搭配</h3>
                            <ul class="fl">
                                <li>
                                    <span>起订量</span>
                                    <i>1000</i>
                                    <i>2000</i>
                                    <i>3000</i>
                                </li>
                                <li>
                                    <span>单&nbsp;&nbsp;&nbsp;价</span>
                                    <i>20</i>
                                    <i>15</i>
                                    <i>12</i>
                                </li>

                            </ul>
                        </li>
                        <li class="customize-time">
                            <div class="customize-deadline">剩余时间：<i>26天12小时</i></div>
                            <a class="confirm-btn" href="">个性需求</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-customize fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-02.jpg">
                </div>
                <div class="zc-customize-detail fl">
                    <h1>床上四件套全棉纯棉</h1>
                    <ul class="clearfix">
                        <li>
                            <p>起订量：<em>1000件</em></p>
                            <p>起订价：<em>20元/件</em></p>
                        </li>
                        <li class="customize-form clearfix">
                            <h3 class="fl">优惠搭配</h3>
                            <ul class="fl">
                                <li>
                                    <span>起订量</span>
                                    <i>1000</i>
                                    <i>2000</i>
                                    <i>3000</i>
                                </li>
                                <li>
                                    <span>单&nbsp;&nbsp;&nbsp;价</span>
                                    <i>20</i>
                                    <i>15</i>
                                    <i>12</i>
                                </li>

                            </ul>
                        </li>
                        <li class="customize-time">
                            <div class="customize-deadline">剩余时间：<i>26天12小时</i></div>
                            <a class="confirm-btn" href="">个性需求</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-finished fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-02.jpg">
                </div>
                <div class="zc-customize-detail fl">
                    <h1>床上四件套全棉纯棉</h1>
                    <ul class="clearfix">
                        <li>
                            <p>起订量：<em>1000件</em></p>
                            <p>起订价：<em>20元/件</em></p>
                        </li>
                        <li class="customize-form clearfix">
                            <h3 class="fl">优惠搭配</h3>
                            <ul class="fl">
                                <li>
                                    <span>起订量</span>
                                    <i>1000</i>
                                    <i>2000</i>
                                    <i>3000</i>
                                </li>
                                <li>
                                    <span>单&nbsp;&nbsp;&nbsp;价</span>
                                    <i>20</i>
                                    <i>15</i>
                                    <i>12</i>
                                </li>

                            </ul>
                        </li>
                        <li class="customize-time">
                            <div class="customize-deadline">剩余时间：<i>26天12小时</i></div>
                            <a class="confirm-btn" href="">个性需求</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="clearfix" style="display: block">
                <div class="zc-customize fl">
                    <img src="<?php echo NGYP_TEMPLATES_URL; ?>/images/zcdz/zc-product-02.jpg">
                </div>
                <div class="zc-customize-detail fl">
                    <h1>床上四件套全棉纯棉</h1>
                    <ul class="clearfix">
                        <li>
                            <p>起订量：<em>1000件</em></p>
                            <p>起订价：<em>20元/件</em></p>
                        </li>
                        <li class="customize-form clearfix">
                            <h3 class="fl">优惠搭配</h3>
                            <ul class="fl">
                                <li>
                                    <span>起订量</span>
                                    <i>1000</i>
                                    <i>2000</i>
                                    <i>3000</i>
                                </li>
                                <li>
                                    <span>单&nbsp;&nbsp;&nbsp;价</span>
                                    <i>20</i>
                                    <i>15</i>
                                    <i>12</i>
                                </li>

                            </ul>
                        </li>
                        <li class="customize-time">
                            <div class="customize-deadline">剩余时间：<i>26天12小时</i></div>
                            <a class="confirm-btn" href="">个性需求</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="zc-container">
        <div class="zc-title clearfix">
            <h1>最新消息</h1>
        </div>
        <div class="zc-title-divider"></div>
        <div class="news-wrap">
            <div class="news-sort">
                <div class="news-title clearfix">
                    <h1>企业动态</h1>
                    <a href="">更多&gt;</a>
                </div>
                <ul class="news-detail">
                    <li>
                        <a href="">金鸡贺岁————祝您新春大吉...</a>
                        <span>2016-02-03</span>
                    </li>
                    <li>
                        <a href="">脚踏实地，一路挺你！</a>
                        <span>2016-12-31</span>
                    </li>
                    <li>
                        <a href="">坚持的力量：回顾2015将车网...</a>
                        <span>2016-12-09</span>
                    </li>
                    <li>
                        <a href="">史上最强！凯诺之后将车网再迎E和...</a>
                        <span>2016-11-06</span>
                    </li>
                    <li>
                        <a href="">重磅！！！汽融众筹携手凯诺倾力<打...</a>
                        <span>2016-11-06</span>
                    </li>
                </ul>

            </div>
            <div class="news-sort">
                <div class="news-title clearfix">
                    <h1>工作报告</h1>
                    <a href="">更多&gt;</a>
                </div>
                <ul class="news-detail">
                    <li>
                        <a href="">金鸡贺岁————祝您新春大吉...</a>
                        <span>2016-02-03</span>
                    </li>
                    <li>
                        <a href="">脚踏实地，一路挺你！</a>
                        <span>2016-12-31</span>
                    </li>
                    <li>
                        <a href="">坚持的力量：回顾2015将车网...</a>
                        <span>2016-12-09</span>
                    </li>
                    <li>
                        <a href="">史上最强！凯诺之后将车网再迎E和...</a>
                        <span>2016-11-06</span>
                    </li>
                    <li>
                        <a href="">重磅！！！汽融众筹携手凯诺倾力<打...</a>
                        <span>2016-11-06</span>
                    </li>
                </ul>

            </div>
            <div class="news-sort">
                <div class="news-title clearfix">
                    <h1>行业新闻</h1>
                    <a href="">更多&gt;</a>
                </div>
                <ul class="news-detail">
                    <li>
                        <a href="">金鸡贺岁————祝您新春大吉...</a>
                        <span>2016-02-03</span>
                    </li>
                    <li>
                        <a href="">脚踏实地，一路挺你！</a>
                        <span>2016-12-31</span>
                    </li>
                    <li>
                        <a href="">坚持的力量：回顾2015将车网...</a>
                        <span>2016-12-09</span>
                    </li>
                    <li>
                        <a href="">史上最强！凯诺之后将车网再迎E和...</a>
                        <span>2016-11-06</span>
                    </li>
                    <li>
                        <a href="">重磅！！！汽融众筹携手凯诺倾力<打...</a>
                        <span>2016-11-06</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>


<!--StandardLayout End-->

