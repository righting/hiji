<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>海豚主场</title>
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/new_base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/home_header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/new_index.css" rel="stylesheet" type="text/css">
    <!--主场样式-->
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/dolphin_home.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/css/swiper.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>

</head>
<body>
<!--------------------------------------------最顶部导航栏开始------------------------------------------>
<div class="public-top-layout w">
    <div class="topbar wrapper">
        <div class="user-entry">
            您好 <span> <a
                        href="http://server.hiji.lan/shop/index.php?controller=member&action=home">还好</a>
                                            <div class="nc-grade-mini" style="cursor:pointer;"
                                                 onclick="javascript:go('http://server.hiji.lan/shop/index.php?controller=pointgrade&action=index');">帝尊会员</div>
                          </span> ，欢迎来到 <a href="http://server.hiji.lan/shop"
                                           title="首页"
                                           alt="首页"><span>海吉壹佰</span></a>
            <span>[<a href="http://server.hiji.lan/member/index.php?controller=login&action=logout">退出</a>] </span>
        </div>
        <div class="quick-menu">
            <dl>
                <dt>
                    <a href="http://server.hiji.lan/shop/index.php?controller=member&action=home" title="个人中心">个人中心</a>
                </dt>
            </dl>
            <dl>
                <dt><em class="ico_shop"></em><a
                            href="http://server.hiji.lan/shop/index.php?controller=show_joinin&action=index"
                            title="商家管理">商家管理</a><i></i></dt>
                <dd>
                    <ul>
                        <li><a href="http://server.hiji.lan/shop/index.php?controller=show_joinin&action=index"
                               title="招商入驻">招商入驻</a></li>
                        <li><a href="http://server.hiji.lan/shop/index.php?controller=dealers&action=index"
                               title="经销商申请">经销商申请</a></li>
                        <li><a href="http://server.hiji.lan/shop/index.php?controller=seller_login&action=show_login"
                               target="_blank"
                               title="登录商家管理中心">商家登录</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_order"></em><a
                            href="http://server.hiji.lan/shop/index.php?controller=member_order">我的订单</a><i></i></dt>
                <dd>
                    <ul>
                        <li>
                            <a href="http://server.hiji.lan/shop/index.php?controller=member_order&state_type=state_new">待付款订单</a>
                        </li>
                        <li>
                            <a href="http://server.hiji.lan/shop/index.php?controller=member_order&state_type=state_send">待确认收货</a>
                        </li>
                        <li>
                            <a href="http://server.hiji.lan/shop/index.php?controller=member_order&state_type=state_noeval">待评价交易</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_store"></em><a
                            href="http://server.hiji.lan/shop/index.php?controller=member_favorite_goods&action=fglist">我的收藏</a><i></i>
                </dt>
                <dd>
                    <ul>
                        <li>
                            <a href="http://server.hiji.lan/shop/index.php?controller=member_favorite_goods&action=fglist">商品收藏</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><em class="ico_service"></em>客户服务<i></i></dt>
                <dd>
                    <ul>
                        <li><a href="http://server.hiji.lan/member/index.php?controller=article&action=article&ac_id=2">帮助中心</a>
                        </li>
                        <li><a href="http://server.hiji.lan/member/index.php?controller=article&action=article&ac_id=5">售后服务</a>
                        </li>
                        <li><a href="http://server.hiji.lan/member/index.php?controller=article&action=article&ac_id=6">客服中心</a>
                        </li>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>
</div>
<!--------------------------------------------最顶部导航栏结束------------------------------------------>



<div class="w">
    <div class="wrap_nav">
        <div class="nav_logo">
            <a href=""></a>
        </div>
        <div class="nav_search">
            <input type="text" name="" id="" value="" placeholder="请输入您要找的品牌"/>
            <button class="icon"></button>
        </div>
    </div>
</div>

<div class="clear"></div>

<header class="wrap_color">
    <nav class="public-nav-layout ">
        <div class="wrapper">

            <ul class="site-menu">
                <li>
                    <a href="http://server.hiji.lan" class="current"><span>首页</span></a>
                </li>
                <!--   后台编辑的其他频道------开始     -->


                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>女装</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>男装</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>内衣</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>运动</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>女鞋</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>男鞋</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>童装</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>潮流女包</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>时尚男包</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>功能箱包</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>礼品</span></a></li>
                <li><a target="_blank" href="/shop/index.php?controller=cate&amp;action=ht"> <span>奢侈品</span></a></li>
                <li class="links_a"><a target="_blank"><span>&nbsp;</span>更多<i></i></a>

                    <ul class="links_b">

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2137">品牌轻奢                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2148">母婴用品                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2141">美妆洗护                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2193">生活日用                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2236">营养保健                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2235">酒水饮料                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2232">休闲零食                                                    </a>
                        </li>

                        <li>
                            <a target="_blank" href="/shop/index.php?controller=cate&amp;action=index&amp;cate_id=2239">生鲜果菜                                                    </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
<article>


    <div class="home-focus-layout">


        <ul id="fullScreenSlides" class="full-screen-slides">
            <li style="background: url('<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/banner.png') center top no-repeat; z-index: 900;">
                <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
            </li>
            <li style="background: url('<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/banner.png') center top no-repeat; z-index: 900;">
                <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
            </li>
            <li style="background: url('<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/banner.png') center top no-repeat; z-index: 900;">
                <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
            </li>
            <li style="background: url('<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/banner.png') center top no-repeat; z-index: 900;">
                <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
            </li>
            <li style="background: url('<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/banner.png') center top no-repeat; z-index: 900;">
                <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
            </li>
        </ul>

        <script type="text/javascript">
            update_screen_focus();

        </script>

    </div>






    <div class="clear"></div>
    <div class="wrap_nav">
        <a href="" class="wrap_h hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img1.png"><div class="hover_top"></div></a>
        <div class="advert-menu">
            <ul>
                <li><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img2.png"><div class="hover_top"></div></a></li>
                <li><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img3.png"><div class="hover_top"></div></a></li>
                <li><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img4.png"><div class="hover_top"></div></a></li>
                <li><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img5.png"><div class="hover_top"></div></a></li>
                <li><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/img6.png"><div class="hover_top"></div></a></li>
            </ul>
        </div>
    </div>

    <div class="wrap_nav">
        <ul class="tab" id="tab">
            <li class="active">今日疯抢</li>
            <li>明日预告</li>
        </ul>
        <div class="box">
            <ul>
                <li>
                    <a href="">
                        <div class="origin">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/icon1.png"/>
                            <div class="mengcen">满1件打6折,满2件打五折</div>
                        </div>
                        <div class="pic">
                            <span class="pic_span">2.2</span>折起<em>&nbsp;&nbsp;</em>衣品天成EPTISON年未精选<span class="pic_icon">剩5天</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="origin">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/icon2.png"/>
                            <div class="mengcen">满1件打6折,满2件打五折</div>
                        </div>
                        <div class="pic">
                            <span class="pic_span">2.2</span>折起<em>&nbsp;&nbsp;</em>衣品天成EPTISON年未精选<span class="pic_icon">剩5天</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="box" style="display: none;">
            <ul>
                <li>
                    <a href="">
                        <div class="origin">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/icon2.png"/>
                            <div class="mengcen">满1件打6折,满2件打五折</div>
                        </div>
                        <div class="pic">
                            <span class="pic_span">2.2</span>折起<em>&nbsp;&nbsp;</em>衣品天成EPTISON年未精选<span class="pic_icon">剩5天</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="origin">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/icon1.png"/>
                            <div class="mengcen">满1件打6折,满2件打五折</div>
                        </div>
                        <div class="pic">
                            <span class="pic_span">2.2</span>折起<em>&nbsp;&nbsp;</em>衣品天成EPTISON年未精选<span class="pic_icon">剩5天</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="wrap_nav">
        <div class="activity">
            <dl>
                <dt><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic1.png"><div class="hover_top"></div></a></dt>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic11.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic12.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic13.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic14.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic15.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic16.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
            </dl>
        </div>
        <div class="activity">
            <dl>
                <dt><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic2.png"><div class="hover_top"></div></a></dt>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic11.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic12.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic13.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic14.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic15.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pic16.png"><p>sadsd</p><div class="hover_top"></div></a></dd>
            </dl>
        </div>
        <div class="pics">
            <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pics_1.png"></a>
            <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pics_2.png"></a>
            <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/pics_3.png"></a>
        </div>
    </div>

    <div class="wrap_nav">
        <div class="naice_top">
            <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_1.png"></a>
            <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_2.png"></a>
        </div>
        <div class="naice_top">
            <div class="naice_left">
                <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_3.png"></a>
                <div class="naice_top">
                    <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_4.png"></a>
                    <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_5.png"></a>
                </div>
            </div>

            <div class="naice_cont">
                <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_6.png"></a>
            </div>

            <div class="naice_right">
                <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_7.png"></a>
                <div class="naice_top">
                    <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_8.png"></a>
                    <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_9.png"></a>
                    <a href=""><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/naice_10.png"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap_nav">
        <div class="ification_top">
            <h2>热门分类</h2>
            <ul>
                <li><a href="">女装</a></li>
                <li><a href="">零食</a></li>
                <li><a href="">牛奶</a></li>
                <li><a href="">居家装饰</a></li>
                <li><a href="">保温杯</a></li>
                <li><a href="">常用药</a></li>
                <li><a href="">热门图书</a></li>
                <li><a href="">洗发水</a></li>
                <li><a href="">卫生纸</a></li>
                <li><a href="">男装</a></li>
            </ul>
        </div>
        <div class="ification_content">
            <dl>
                <dt><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_1.png"><div class="hover_top"></div></a></dt>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsssssssssssssssd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_3.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_3.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
                <dd><a href="" class="hover_origin"><img src="<?php echo SHOP_TEMPLATES_URL; ?>/ht_resource/images/cen_2.png"><p>sadsd</p><p><span>¥190</span></p><div class="hover_top"></div></a></dd>
            </dl>
        </div>
    </div>
</article>

<!--<div class="end">END</div>-->

<div class="fixedtool">
    <a href="javascript:void(0)" class="close"></a>
    <ul>
        <li>
            <a href="javascript:void(0)" class="icon8">在线咨询</a>
        </li>

        <li>
            <a href="javascript:void(0)" class="icon9">购物车</a>
        </li>

        <li>
            <a href="javascript:void(0)" class="icon10">商品对比</a>
        </li>

        <li>
            <a href="javascript:void(0)" class="icon11">回到顶部</a>
        </li>

    </ul>
</div>
<!--------------------------------------------底部开始------------------------------------------>
<div class="footer">
    <div class="footer-top">
        <ul>
            <li>
                <dl class="s1">
                    <dt>新手指南</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=39"
                           title="积分细则"> 积分细则 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=40"
                           title="积分兑换说明"> 积分兑换说明 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=7"
                           title="如何搜索"> 如何搜索 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=8"
                           title="忘记密码"> 忘记密码 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=9"
                           title="我要买"> 我要买 </a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl class="s2">
                    <dt>商家中心</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=11"
                           title="如何管理店铺"> 如何管理店铺 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=12"
                           title="查看售出商品"> 查看售出商品 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=13"
                           title="如何发货"> 如何发货 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=14"
                           title="商城商品推荐"> 商城商品推荐 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=15"
                           title="如何申请开店"> 如何申请开店 </a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl class="s3">
                    <dt>支付方式</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=28"
                           title="分期付款"> 分期付款 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=30"
                           title="公司转账"> 公司转账 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=29"
                           title="邮局汇款"> 邮局汇款 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=16"
                           title="如何注册支付宝"> 如何注册支付宝 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=17"
                           title="在线支付"> 在线支付 </a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl class="s4">
                    <dt>售后服务</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=31"
                           title="退换货政策"> 退换货政策 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=32"
                           title="退换货流程"> 退换货流程 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=33"
                           title="返修/退换货"> 返修/退换货 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=34"
                           title="退款申请"> 退款申请 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=26"
                           title="联系卖家"> 联系卖家 </a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl class="s5">
                    <dt>购物指南</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=18"
                           title="会员修改密码"> 会员修改密码 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=19"
                           title="会员修改个人资料"> 会员修改个人资料 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=20"
                           title="商品发布"> 商品发布 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=21"
                           title="修改收货地址"> 修改收货地址 </a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl class="s6">
                    <dt>分享阵地</dt>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=45"
                           title="海吉商学院文章"> 海吉商学院文章 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=44"
                           title="分享模块文章"> 分享模块文章 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=43"
                           title="关于我们的标题"> 关于我们的标题 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=25"
                           title="合作及洽谈"> 合作及洽谈 </a>
                    </dd>
                    <dd>
                        <a href="http://server.hiji.lan/member/index.php?controller=article&action=show&article_id=24"
                           title="招聘英才"> 招聘英才 </a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>
<!--------------------------------------------底部结束------------------------------------------>


<!--------------------------------------------底部版权开始------------------------------------------>
<div class="footer-bottom" style="height: 100px">
    CopyRight © 2007-2018 海吉壹佰 <a href="http://www.miibeian.gov.cn/" target="_blank" mxf="sqde" style="color:#666">粤ICP备00000001</a>NewPower
    Co. 版权所有
    <img style="height: 100px" src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-612-621-2.png?440"/>
    <img style="height: 100px" src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-612-621-1.png?224"/>
</div>
<!--------------------------------------------底部版权结束------------------------------------------>
<!--------------------------------------------底部版权开始------------------------------------------>
<div class="footer-bottom">
    <a href="" target="_blank" rel="nofollow"><img
                src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-613-622-2.png?800"></a>
    <a href="" target="_blank" rel="nofollow"><img
                src="http://haijishop.oss-cn-shenzhen.aliyuncs.com/web-613-622-1.png?443"></a>
</div>
<!--------------------------------------------底部版权结束------------------------------------------>

<script>


    $(document).ready(function () {
        $('#tab').find('li').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $('.box').hide();
            $('.box').eq($(this).index()).show();
        })
        $(window).scroll(function () {
            var $currentWindow = $(window);
            //当前窗口的高度
            var windowHeight = $currentWindow.height();
//            console.log('windowHeight'+windowHeight);
            //当前滚动条从上往下滚动的距离
            var scrollTop = $currentWindow.scrollTop();
//            console.log(scrollTop);
            if (scrollTop + windowHeight >= 1175) {
                $('.fixedtool').fadeIn(300);
            }else{
                $('.fixedtool').fadeOut(300);
            }
        });
    });
</script>
</body>
</html>