<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_goods.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/ccy-main.css" rel="stylesheet" type="text/css">

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layer.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>

<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL; ?>/js/mz-packed.js" charset="utf-8"></script>

<div class="ccy-container">
    <div class="wrapper pr">

        <div class="ncs-detail">
            <!-- 焦点图 -->
            <div id="ncs-goods-picture" class="ncs-goods-picture">
                <div class="gallery_wrap">
                    <div class="gallery">
                        <img title="鼠标滚轮向上或向下滚动，能放大或缩小图片哦~" src="<?php echo $output["goods"]["goods_image"] ?>" class="cloudzoom" data-cloudzoom="zoomImage: '<?php echo $output['goods']["goods_image"] ?>'">
                    </div>
                </div>
                <div class="controller_wrap">
                    <div class="controller">
                        <ul>
                            <?php foreach ($output["goods_image"] as $key => $value) { ?>
                                <li><img title="鼠标滚轮向上或向下滚动，能放大或缩小图片哦~" class='cloudzoom-gallery'
                                         src="<?php echo $value ?>"
                                         data-cloudzoom="useZoom: '.cloudzoom', image: '<?php echo $value ?>', zoomImage: '<?php echo $value ?>' "
                                         width="60" height="60"></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- //焦点图 -->

            <!-- S 商品基本信息 -->
            <div class="ncs-goods-summary">
                <div class="name">
                    <h1><?php echo $output['goods']['goods_name']; ?></h1>
                    <strong><?php echo str_replace("\n", "<br>", $output['goods']['goods_jingle']); ?></strong>
                </div>
                <!-- S 商品发布价格 -->
                <div class="ncs-meta">
                    <dl>
                        <dt>商品价格：</dt>
                        <dd class="cost-price">
                            <span style="color:rgb(23,84,4);font-size:18px;font-weight:600; ">¥<?php echo $output['goods']['goods_price']?></span>
                            <?php if($output['goods']['goods_integral'] > 0){?>
                                <span style="color:red;font-size:14px;font-weight:600;"> + <?php echo $output['goods']['goods_integral']?>积分</span>
                            <?php }?>

                            <?php if($output['goods']['goods_hjb'] > 0){?>
                                <span style="color:red;font-size:14px;font-weight:600; "> + <?php echo $output['goods']['goods_hjb']?>海吉币</span>
                            <?php }?>

                        </dd>
                    </dl>
                    <dl>
                        <dt>商品库存：</dt>
                        <dd class="cost-price">
                            <span style="font-weight:600;"> <?php echo $output['goods']['goods_storage']?> </span>
                        </dd>
                    </dl>
                </div>
                <!-- E 商品发布价格 -->

                <!-- S 购买数量及库存 -->
                    <div class="ncs-buy" style="padding:20px 0 20px 5px;">
                        <div style="float:left;height:45px;line-height:45px;font-size:20px;font-weight:600 ">购买数量：</div>
                            <div class="ncs-figure-input" style="float:left;">
                               <input type="text" name="" id="quantity" value="1" size="3" maxlength="6" class="input-text"
                                       <?php if ($output['goods']['is_fcode'] == 1) { ?>readonly<?php } ?>>
                                <a href="javascript:void(0)" class="increase"
                                   <?php if ($output['goods']['is_fcode'] != 1) { ?>nctype="increase"<?php } ?>>&nbsp;</a>
                                <a href="javascript:void(0)" class="decrease"
                                        <?php if ($output['goods']['is_fcode'] != 1) { ?>nctype="decrease"<?php } ?>>&nbsp;</a>
                            </div>
                        <!-- E 提示已选规格及库存不足无法购买 -->
                        <!-- S 购买按钮 -->
                        <div style="clear: both;"></div>
                            <div class="ncs-btn" style="margin:50px;float:right;">
                                    <!-- 立即购买-->
                                    <a href="javascript:void(0);" id="submitButton" class="buynow" title="立即购买">立即购买</a>
                            </div>
                        <!-- E 购买按钮 -->
                    </div>
                <!-- E 购买数量及库存 -->

                <!--E 商品信息 -->
            </div>
            <div class="clear"></div>
        </div>


        <div class="ncs-promotion" id="nc-bundling" style="display:none;"></div>
        <!-- E 优惠套装 -->
        <div id="content" class="ncs-goods-layout expanded">
            <div class="ncs-goods-main" id="main-nav-holder">
                <div class="tabbar pngFix" id="main-nav">
                    <div class="ncs-goods-title-nav">
                        <ul id="categorymenu">
                            <li class="current"><a href="javascript:;">商品详情</a></li>
                        </ul>
                        <div class="switch-bar"><a href="javascript:void(0)" id="fold">&nbsp;</a></div>
                    </div>
                </div>
                <div class="ncs-intro"></div>

                <div class="ncs-consult">
                    <div class="ncs-goods-info-content bd">
                        <!-- 详情内容部分 -->
                        <div class="default" style="margin-top:5px;">
                            <?php echo htmlspecialchars_decode($output['goods']['goods_body'])?>
                        </div>
                    </div>
                </div>
                <!-- ccynet-->
                <!--youce-->

            </div>
            <div class="ncs-sidebar">
                <div class="ncs-sidebar-container ncs-top-bar">
                    <div class="title">
                        <h4>热销排行</h4>
                    </div>
                    <div class="content">
                        <div id="hot_sales_list" class="ncs-top-panel">
                            <ol>
                                <?php foreach($output['salenumInfo'] as $k=>$v){?>
                                    <li>
                                        <dl>
                                            <dt>
                                                <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goods_id']));?>"><?php echo $v['goods_name'];?></a>
                                            </dt>
                                            <dd class="goods-pic">
                                                <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goods_id']));?>">
                                                    <span class="thumb size60">
                                                        <i></i>
                                                        <img src="<?php echo $v['goods_image']?>" onload="javascript:DrawImage(this,60,60);" width="60" height="60">
                                                    </span>
                                                </a>
                                                <p><span class="thumb size100">
                                                        <i></i>
                                                        <img src="<?php echo $v['goods_image']?>" onload="javascript:DrawImage(this,100,100);" title="<?php echo $v['goods_name'];?>" width="100" height="100">
                                                        <big></big>
                                                        <small></small>
                                                    </span>
                                                </p>
                                            </dd>
                                            <dd class="price pngFix"><?php echo $v['goods_price']?></dd>
                                        </dl>
                                    </li>
                                <?php }?>

                            </ol>
                        </div>
                    </div>
                </div>

                    <!-- 随机推荐 -->
                    <div class="ncs-sidebar-container ncs-top-bar">
                        <div class="title">
                            <h4>随机推荐</h4>
                        </div>
                        <div class="content">
                            <div id="hot_sales_list" class="ncs-top-panel">
                                <ol>

                                    <?php foreach($output['randInfo'] as $k=>$v){?>
                                        <li>
                                            <dl>
                                                <dt>
                                                    <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goods_id']));?>"><?php echo $v['goods_name'];?></a>
                                                </dt>
                                                <dd class="goods-pic">
                                                    <a href="<?php echo  urlJf('goods','index',array('id'=>$v['goods_id']));?>">
                                                    <span class="thumb size60">
                                                        <i></i>
                                                        <img src="<?php echo $v['goods_image']?>" onload="javascript:DrawImage(this,60,60);" width="60" height="60">
                                                    </span>
                                                    </a>
                                                    <p><span class="thumb size100">
                                                        <i></i>
                                                        <img src="<?php echo $v['goods_image']?>" onload="javascript:DrawImage(this,100,100);" title="<?php echo $v['goods_name'];?>" width="100" height="100">
                                                        <big></big>
                                                        <small></small>
                                                    </span>
                                                    </p>
                                                </dd>
                                                <dd class="price pngFix"><?php echo $v['goods_price']?></dd>
                                            </dl>
                                        </li>
                                    <?php }?>

                                </ol>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>

<form method="post" id="confirm_form" name="confirm_form" action="index.php">
    <input type="hidden" name="controller" value="goods"/>
    <input type="hidden" name="action" value="confirmGoodsInfo"/>
    <input type="hidden" id="number" name="number" value="1"/>
    <input type="hidden" id="goodsId" name="goodsId" value="<?php echo $output['goods']['goods_id']?>"/>
</form>


<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.charCount.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/sns.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.F_slider.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.nyroModal/custom.min.js"
        charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css"
      id="cssfile2"/>
<script type="text/javascript" id="bdshare_js" data="type=tools&uid=6478904" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<script type="text/javascript">
    /** 辅助浏览 **/
    //产品图片
    jQuery(function ($) {
        // 放大镜效果 产品图片
        CloudZoom.quickStart();
        // 图片切换效果
        $(".controller li").first().addClass('current');
        $('.controller').find('li').mouseover(function () {
            $(this).first().addClass("current").siblings().removeClass("current");
        });
    });


    // 增加
    $('a[nctype="increase"]').click(function () {
        num = parseInt($('#quantity').val());
        $('#quantity').val(num + 1);
    });

    //减少
    $('a[nctype="decrease"]').click(function () {
        num = parseInt($('#quantity').val());
        if (num > 1) {
            $('#quantity').val(num - 1);
        }
    });



    $('#submitButton').on('click',function(){
        <?php if (empty($_SESSION['member_id'])){?>
            window.location.href='/member/index.php?controller=login&action=index';
            return;
        <?php } ?>

        var number = $('#quantity').val(); //购买数量
        $('#number').val(number);

        layer.load();
        //查询库存
        $.getJSON('/jf/index.php?controller=goods&action=checkStock',{id:'<?php echo $output['goods']['goods_id']?>',number:number},function(data){
            if(data.status==1){
                $('#confirm_form').submit();
            }else{
                layer.closeAll();
                layer.msg('商品库存不足',{icon:5});
            }
        });

    });



    $(function () {
        /** goods.php **/
        // 商品内容部分折叠收起侧边栏控制
        $('#fold').click(function () {
            $('.ncs-goods-layout').toggleClass('expanded');
        });

        // 商品详情默认情况下显示全部
        $('#tabGoodsIntro').click(function () {
            $('.bd').css('display', '');
            $('.hd').css('display', '');
        });


        //触及显示缩略图
        $('.goods-pic > .thumb').hover(
            function () {
                $(this).next().css('display', 'block');
            },
            function () {
                $(this).next().css('display', 'none');
            }
        );
        $('.ncs-buy').bind({
            mouseover: function () {
                $(".ncs-point").show();
            },
            mouseout: function () {
                $(".ncs-point").hide();
            }
        });

    });

</script>
