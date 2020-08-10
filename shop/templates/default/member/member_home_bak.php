<link href="/shop/templates/default/css/new_member_home.css" rel="stylesheet" type="text/css">
<link href="/layer/theme/default/layer.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/data/resource/js/TY_banner1.js"></script>
<script type="text/javascript" src="/layer/layer.js"></script>
<script type="text/javascript" src="/layui/css/layui.css"></script>
<!--个人中心首页-->
<div class="homepage">

    <table lay-even lay-skin="line" lay-size="lg">
        <colgroup>
            <col width="200">
            <col width="180">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th style="text-align: center;font-size:13px;">当前分红期数：<span style="color:blue;">第【<?php echo $output['stagesInfo']['id']?>】期</span></th>
            <th style="text-align: center;font-size:13px;">当前分红周：<span style="color:blue;">第【<?php echo $output['stagesInfo']['week']?>】周</span></th>
            <th style="text-align: center;font-size:13px;">当前周天数：<span style="color:blue;">第【<?php echo $output['stagesInfo']['days']?>】天</span></th>
            <th style="text-align: center;font-size:13px;">当前期数开始/结束时间：<span style="color:blue;">【<?php echo date('Y-m-d',strtotime($output['stagesInfo']['start_time']))?> / <?php echo date('Y-m-d',strtotime($output['stagesInfo']['end_time']))?>】</span></th>
        </tr>
        </thead>
    </table>
    <div class="homepage-details">


        <div class="homepage-details-a">
            <div class="supplemented">
                <ul>
                    <li>
                        <a href="#">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/supplemented_1.png" width="44px" height="42px"  style="margin-top: 14px" ;>
                            <h2>源头产品</h2>
                        </a>
                        </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/supplemented_2.png" width="50px" height="50px"  style="margin-top: 9px" ;>
                            <h2>正品验厂</h2>
                        </a>
                        </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/supplemented_3.png" width="50px" height="50px"  style="margin-top: 9px" ;>
                            <h2>七天退换</h2>
                        </a>
                        </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/supplemented_4.png" width="44px" height="44px"  style="margin-top: 9px" ;>
                            <h2>消费保护</h2>
                        </a>
                        </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/supplemented_5.png" width="51px" height="39px"  style="margin-top: 14px" ;>
                            <h2>权威公信</h2>
                        </a>
                        </li>
                </ul>
            </div>

            <div class="homepage-details-a1">
                <div class="homepage-details-a2">
                    <div class="homepage-details-a2-a">
                        <div class="homepage-details-a2-a1">
                            <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
                        </div>
                        <div class="homepage-details-a2-a2">
                            <h3>亲爱的<?php echo $output['member_info']['member_nickname'] ?>，<?php
                                $h=date("H");
                                if($h<11) echo "早上好!";
                                else if($h<13) echo "中午好！";
                                else if($h<18) echo "下午好！";
                                else echo "晚上好！";
                                ?></h3>
                            <?php if($output['member_info']['level_id'] != 7){ ?>
                            <p>ID:<?php echo $output['member_info']['member_number'] ?></p>
                            <?php } ?>
                            <div class="homepage-hui">
                                <?php
                                $tplImgUrl = SHOP_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                                echo "<i class='homepage-tian' style='background:url($tplImgUrl) 0 0 no-repeat; background-size:contain;'></i>";
                                ?>
                                <span><?php echo $output['member_info']['level_name'] ?></span>
                                <?php if($output['member_info']['positions_id']<8){?>

                                    <?php
                                    $tplImgUrl = SHOP_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                                    echo "<i class='homepage-zun' style='background:url($tplImgUrl) 0 0 no-repeat; background-size:contain;'></i>";
                                    ?>
                                <span><?php echo $output['member_info']['position_name'] ?></span>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="homepage-gun">
                        <div class="homepage-bar" style="width:100%" ></div>
                    </div>
                    <div class="homepage-zi">
                        <?php if ($output['member_info']['is_no_bind']==1) {?>
                            <?php if ($output['member_info']['grade_up']) {?>
                                <div class="homepage-zi1" style="width:100px;">
                                    &nbsp;积分可升级
                                </div>
                        <a  href="<?php echo urlShop('pointshop','buy_grade') ?>" title="使用积分兑换等级">
                                <div class="homepage-an">
                                    立即升级
                                </div>
                        </a>
                            <?php }?>
                        <?php } ?>
                    </div>

                </div>
                <div class="xian"></div>
                <div class="homepage-details-a3">

                    <div class="homepage-wanzheng">
                        <div class="homepage-wanzheng-a">会员资料完整度:</div>
                        <div class="homepage-gun-a">
                            <div class="homepage-bar-a"  style="width: 40%;">
                            </div>
                        </div>
                        <div class="homepage-wanzheng-b">
                            <span>低</span><!--<a href="#"><span class="homepage-wanzheng-b1">去完善></span></a>-->
                        </div>
                    </div>


                    <div class="homepage-wanzheng">
                        <div class="homepage-wanzheng-a">会员账户安全等级:</div>
                        <?php if ($output['member_info']['security_level'] <= 1) { ?>
                            <div class="homepage-gun-a">
                                <div class="homepage-bar-a"  style="width: 33%;">
                                </div>
                            </div>
                            <div class="homepage-wanzheng-b">
                                <span>低</span>
                            </div>
                        <?php } elseif ($output['member_info']['security_level'] == 2) { ?>
                            <div class="homepage-gun-a">
                                <div class="homepage-bar-a"  style="width: 66%;">
                                </div>
                            </div>
                            <div class="homepage-wanzheng-b">
                                <span>中</span>
                            </div>
                        <?php } else { ?>
                            <div class="homepage-gun-a">
                                <div class="homepage-bar-a"  style="width: 100%;">
                                </div>
                            </div>
                            <div class="homepage-wanzheng-b">
                                <span>高</span>
                            </div>
                        <?php } ?>


                    </div>
                    <?php if($output['member_info']['level_id'] != 7){ ?>
                        <div class="homepage-dianzi">
                            <span>我的电子会员卡:</span>
                            <a href="<?php echo urlMember('help', 'member_card',array('member_id'=>hj_encrypt($_SESSION['member_id']))); ?>" title="我的电子会员卡" target="_blank"><i></i></a>
                        </div>
                    <?php } ?>
                    <div class="homepage-dianzi-a">
                        <span>我的微店地址:</span>
                        <a id="mywd" data-url="<?php echo $output['member_info']['wdUrl'] ?> " href="JavaScript:;"><i></i></a>
                    </div>
                    <div class="homepage-dianzi-b">
                        <span>新人推荐链接:</span>
                        <a href="javascript:show_dialog1('copyUrl','<?php echo urlMember('login','register',['rec'=>hj_encrypt($_SESSION['member_id'])]) ?>');"><i></i></a>
                    </div>
                </div>
                <div class="homepage-calendar">
                    <div class="homepage-calendar-a">
                        <p class="homepage-calendar-a1">
                            日历
                        </p>
                        <p class="homepage-calendar-a2">
                            <?php echo date('Y年m月');?>
                        </p>
                        <p class="homepage-calendar-a3">
                            <span> <?php echo date('d');?></span>日
                        </p>
                        <p class="homepage-calendar-a4">
                            <?php
                                $date = date('w');
                                switch ($date){
                                    case 1:echo '星期一';break;
                                    case 2:echo '星期二';break;
                                    case 3:echo '星期三';break;
                                    case 4:echo '星期四';break;
                                    case 5:echo '星期五';break;
                                    case 6:echo '星期六';break;
                                    case 0:echo '星期日';break;
                                }
                            ?>
                        </p>
                    </div>

                    <?php if($output['isSignIn']==1){ ?>
                        <div class="homepage-calendar-b">
                            <a href="javascript:;" onclick="sign()" style="color:white;">签到</a>
                        </div>
                    <?php }else{ ?>
                        <div class="homepage-calendar-b" style="font-size:11px;">
                            今日已签到
                        </div>
                    <?php }?>
                    <!--<div class="homepage-calendar-c">
                        每日一签有福利，连签大礼送不停
                    </div>-->
                </div>

            </div>
            <div class="homepage-details-b">
                <ul>
                    <li class="homepage-details-b1">海吉积分(H): <span><?php echo $output['member_info']['member_h_points']?></span></li>
                    <li class="homepage-details-b1">海吉积分(HS): <span><?php echo $output['member_info']['member_points']?></span></li>
                    <li class="homepage-details-b2">账户余额: <span>￥<?php echo ($output['member_info']['available_predeposit']+$output['member_info']['freeze_predeposit']);?></span>
                        <a href="<?php echo urlMember('member_security', 'auth',array('type'=>'pd_cash')); ?>"><i>提现</i></a>
                        <a href="<?php echo urlMember('predeposit', 'recharge_add'); ?>"><i>充值</i></a>
                    </li>
                </ul>
            </div>

            <div class="homepage-details-c">
                <ul>
                    <li class="homepage-details-b1">我的Hi值: <?php echo $output['user_hi'] ?></li>
                    <li class="homepage-details-b1">我的贡献值: <?php echo $output['member_info']['member_contribution']?></li>
                    <li class="homepage-details-b2">我的海吉币: <?php echo $output['member_info']['sign_in_money'] ?></li>
                </ul>
            </div>
        </div>

        <div class="personal-center-message-bottom-a">
            <div class="personal-attention-a">
                <a href="#">关注中<i></i></a>
                <ul>
                    <li><a href="<?php echo urlShop('member_favorite_goods', 'index'); ?>">商品</a></li>
                    <li><a href="<?php echo urlShop('member_goodsbrowse', 'list'); ?>">足迹</a></li>
                </ul>
            </div>

            <div class="personal-stay-a">
                <ul>
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_pay')); ?>">待发货<em><?php echo $output['order_tip']['order_nosend_count'] ?></em></a></li>
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_send')); ?>">待收货<em><?php echo $output['order_tip']['order_noreceipt_count'] ?></em></a></li>
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_notakes')); ?>">待自提<em><?php echo $output['order_tip']['order_notakes_count'] ?></em></a></li>
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_noeval')); ?>">待评价<em><?php echo $output['order_tip']['order_noeval_count'] ?></em></a></li>
                </ul>
            </div>

            <div class="personal-after-a">
                <ul>
                    <li><a href="<?php echo urlShop('member_refund', 'index'); ?>">退款</a></li>
                    <li><a href="<?php echo urlShop('member_return', 'index'); ?>">退货</a></li>
                    <li><a href="<?php echo urlShop('member_complain', 'index', array('select_complain_state' => '1')); ?>">投诉</a></li>
                </ul>
            </div>
        </div>

    </div>
    <div class="homepage-bill">
        <div class="homepage-bill-a">
            <div class="homepage-bill-a1">
                <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/homepage_8.png">
            </div>
            <p class="homepage-bill-a2">订单详情</p>
            <a href="<?php echo urlShop('member_order', 'index'); ?>"><p class="homepage-bill-a3">查看全部订单></p></a>
        </div>
        <div class="homepage-bill-b">
            <?php if(!empty($output['orderInfo']) && is_array($output['orderInfo'])){?>
            <?php foreach($output['orderInfo'] as $k=>$v){?>
                <div class="homepage-bill-b1">
                    <ul>
                        <li class="homepage-bill-b1-a">
                            <div class="homepage-bill-b2">
                                <img src="<?php echo $v['goodsInfo']['goods_image']; ?>">
                            </div>
                            <div class="homepage-bill-b5">
                                <p class="homepage-bill-b3"><?php echo $v['goodsInfo']['goods_name']?></p>
                                <p class="homepage-bill-b4">订单号：<?php echo $v['order_sn'];?></p>
                                <p class="homepage-bill-b4"><?php echo date('Y-m-d H:i:s',$v['add_time']);?></p>
                            </div>
                        </li>
                        <li class="homepage-bill-b1-c">
                            ￥<?php echo $v['order_amount'];?>
                        </li>
                        <li class="homepage-bill-b1-c">
                            <?php if($v['refund_state']==0){
                                switch ($v['order_state']){
                                    case 0:echo '已取消';break;
                                    case 10:echo '待付款';break;
                                    case 20:echo '待发货';break;
                                    case 30:echo '待收货';break;
                                    case 40:echo '已完成';break;
                                }
                            }else{
                                if($v['refundState']['refund_state']!=3){
                                    echo '退款中..';
                                }else{
                                    echo '已退款';
                                }
                            }?>
                        </li>
                        <li class="homepage-bill-b1-c">
                            <a href="<?php echo urlShop('member_order', 'show_order',array('order_id'=>$v['order_id'])); ?>">查看详情</a>
                        </li>
                    </ul>
                </div>

            <?php }?>
        <?php }else{?>
                <div style="height:100px;line-height:100px;text-align: center;color:#ccc;font-size:14px;">
                    暂无订单数据
                </div>
        <?php }?>
        </div>

    </div>
    <div class="homepage-bill">
        <div class="homepage-bill-a">
            <div class="homepage-bill-a1">
                <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/homepage_9.png">
            </div>
            <p class="homepage-bill-a2">公告资讯</p>
        </div>
        <ul class="homepage-announcement">
            <?php foreach ($output['article_lists'] as $key=>$article){?>
                <li>
                    <div class="homepage-announcement-a">
                        <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/news.png">
                    </div>
                    <h3><a style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden;" href="<?php echo urlMember('article', 'show', array('article_id'=>$article['article_id']))?>"><?php echo $article['article_title'] ?></a></h3>
                    <p class="homepage-announcement-b">
                        <?php echo  mb_substr(strip_tags($article['article_content'] ),0,70,'utf-8') ?>
                    </p>
                    <p class="homepage-announcement-c"><?php echo date('Y年m月h日',$article['article_time']) ?></p>
                    <a href="#">
                        <div class="homepage-announcement-d">
                            点击阅读
                        </div>
                    </a>
                </li>
            <?php }?>
        </ul>
        <a href="<?php echo urlMember('member_message', 'ggmsg');?>">
            <div class="homepage-announcement-chakan">
                查看更多>
            </div>
        </a>
    </div>
    <div class="homepage-bill">
        <div class="homepage-bill-a">
            <div class="homepage-bill-a1">
                <img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/homepage_10.png">
            </div>
            <p class="homepage-bill-a2">猜你喜欢</p>
        </div>
        <div class="pro-switch-a">
            <div class="flexslider-a">


                <ul class="slides-a">
                    <?php $sum = count($output['likeGoods']);
                    while (!empty($output['likeGoods'])){
                        $data = array_slice($output['likeGoods'],0,4);
                        ?>
                        <li>
                            <?php foreach ($data as $item):?>
                                <a style="padding: 0px;margin-left: 3px" href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                                    <div class="hot-min-img-a"><img src="<?php echo $item['goods_image']; ?>" alt="<?php echo $item['goods_name']; ?>"></div>
                                    <div class="hot-title-a" title="<?php echo $item['goods_name']; ?>"><?php echo $item['goods_name']; ?></div>
                                    <div class="hot-price-a"><span>¥</span><em><?php echo $item['goods_price']; ?></em></div>
                                </a>
                            <?php endforeach; ?>
                        </li>
                        <?php array_splice($output['likeGoods'],0,4); } ?>
                </ul>
                <script type="text/javascript">
                    $(function() {
                        $('.flexslider').flexslider({
                            animation: "slide",
                            start: function(slider) {
                                $('body').removeClass('loading');
                            }
                        });
                    });
                </script>
            </div>

        </div>
    </div>
</div>

<div id="copyUrl_dialog" class="copyUrl_dialog" style="display:none;">
    <div class="s-tips"><i class="fa fa-lightbulb-o"></i><?php echo '小提示：如果浏览器不支持请手动选中按CTRL+C进行复制。'; ?></div>
    <textarea id="twitter" rows="3" cols="55">http</textarea>
    <button style=" margin:5px 170px;width: 50px" data-copytarget="#twitter">复制</button>
</div>
<div id="vipcard_dialog" style="display:none;">
    <p style="background: url(<?=SHOP_TEMPLATES_URL?>/images/vipcard_bg.png) no-repeat left center;padding: 300px 200px 60px 200px;font-size: 25px;color: #cd0a0a">ID：<?=$output['member_info']['member_number'] ?></p>
</div>

<script src="<?=SHOP_TEMPLATES_URL.'/js/home_index.js' ?>"></script>
<script>
    (function() {
        //平台推荐商品
        $('#pl_recommend').load('<?=urlShop('search','get_plrecmmend')?>',function(){
            $(this).show();
        });

        'use strict';
        // click events
        document.body.addEventListener('click', copy, true);
        $('#mywd').live('click',function(){//弹出复制框
            var url=$(this).data('url');
            show_dialog1('copyUrl',url);
        });
        // event handler
        function copy(e) {
            // find target element
            var
                t = e.target,
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
            // is element selectable?
            if (inp && inp.select) {
                // select text
                inp.select();
                try {
                    // copy text
                    document.execCommand('copy');
                    inp.blur();
                    // copied animation
                    t.classList.add('copied');//增加成功提示
                    setTimeout(function() { t.classList.remove('copied'); }, 1500);//移除成功提示
                    // location.reload();//重新加载网页
                }
                catch (err) {
                    alert('please press Ctrl/Cmd+C to copy');
                }
            }
        }
    })();

    function show_dialog2(id) {//弹出框
        var d = DialogManager.create(id);//不存在时初始化(执行一次)
        var dialog_html = $("#" + id + "_dialog").html();

        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(708);
        d.show('center', 1);
    }

    function show_dialog1(id,url) {//弹出框
        var d = DialogManager.create(id);//不存在时初始化(执行一次)
        var dialog_html = $("#" + id + "_dialog").html();

        var txt = $("#twitter").html().trim();
        dialog_html = dialog_html.replace(txt,url);
        var dialog_html_out=$("#" + id + "_dialog").detach();
        $("#" + id + "_dialog").remove();
        d.setTitle("复制链接地址");
        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(400);
        d.show('center', 1);
        $('body').append(dialog_html_out);
        $("#twitter").select();
    }

    /**
     * 签到
     */
    function sign(){
        layer.load();
        $.getJSON('<?php echo  urlShop('sign','ajaxSign');?>','',function(data){
            layer.closeAll();
            if(data.status==1){
                layer.msg(data.msg,{icon: 1});
                setTimeout(function(){
                    window.location.reload();
                },1000)
            }else{
                layer.msg(data.msg,{icon:5});
            }
        })
    }
</script>
