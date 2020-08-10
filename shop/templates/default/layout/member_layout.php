<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<?php include template('layout/common_layout'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/member.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/grzx.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ToolTip.js"></script>
<script>
    //sidebar-menu
    $(document).ready(function () {
        $.each($(".side-menu > a"), function () {
            $(this).click(function () {
                var ulNode = $(this).next("ul");
                if (ulNode.css('display') == 'block') {
                    $.cookie(COOKIE_PRE + 'Mmenu_' + $(this).attr('key'), 1);
                } else {
                    $.cookie(COOKIE_PRE + 'Mmenu_' + $(this).attr('key'), null);
                }
                ulNode.slideToggle();
                if ($(this).hasClass('shrink')) {
                    $(this).removeClass('shrink');
                } else {
                    $(this).addClass('shrink');
                }
            });
        });
        $.each($(".side-menu-quick > a"), function () {
            $(this).click(function () {
                var ulNode = $(this).next("ul");
                ulNode.slideToggle();
                if ($(this).hasClass('shrink')) {
                    $(this).removeClass('shrink');
                } else {
                    $(this).addClass('shrink');
                }
            });
        });
    });

</script>

<div class="ncm-container">
    <div class="ncm-header">
        <div class="ncm-header-top">
            <div class="ncm-member-info">
                <div class="avatar"><a href="<?php echo urlMember('member_information', 'avatar'); ?>" title="修改头像"><img
                                src="<?php echo getMemberAvatar($output['member_info']['member_avatar']); ?>">
                        <div class="frame"></div>
                    </a>
                    <?php if (intval($output['message_num']) > 0) { ?>
                        <a href="<?php echo MEMBER_SITE_URL ?>/index.php?controller=member_message&action=message"
                           class="new-message" title="新消息"><?php echo intval($output['message_num']); ?></a>
                    <?php } ?>
                </div>
                <dl>
                    <dt><a href="<?php echo urlMember('member_information', 'member'); ?>"
                           title="修改资料"><?php echo $output['member_info']['member_nickname']; ?></a></dt>
                    <dd>会员等级：
                        <?php if ($output['member_info']['level_name']) { ?>
                            <div class="nc-grade-mini" style="cursor:pointer;"
                                 onclick="javascript:go('<?php echo urlShop('pointgrade', 'index'); ?>');"><?php echo $output['member_info']['level_name']; ?>
                            </div>
                        <?php } ?>
                    </dd>
                    <dd>账户安全：
                        <div class="SAM"><a href="<?php echo urlMember('member_security', 'index'); ?>" title="安全设置">
                                <?php if ($output['member_info']['security_level'] <= 1) { ?>
                                    <div id="low" class="SAM-info"><span><em></em></span><strong>低</strong></div>
                                <?php } elseif ($output['member_info']['security_level'] == 2) { ?>
                                    <div id="normal" class="SAM-info"><span><em></em></span><strong>中</strong></div>
                                <?php } else { ?>
                                    <div id="high" class="SAM-info"><span><em></em></span><strong>高</strong></div>
                                <?php } ?>
                            </a></div>
                    </dd>
                    <dd>用户财产：
                        <div class="user-account">
                            <ul>
                                <li id="pre-deposit"><a href="<?php echo urlMember('predeposit', 'pd_log_list'); ?>"
                                                        title="我的余额：￥<?php echo $output['member_info']['available_predeposit']; ?>">
                                        <span class="icon"></span> </a></li>
                                <li id="points"><a href="<?php echo urlMember('member_points', 'index'); ?>"
                                                   title="我的积分：<?php echo $output['member_info']['member_points']; ?>分">
                                        <span class="icon"></span></a></li>
                            </ul>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="ncm-trade-menu">
                <div class="line-bg"></div>
                <dl class="trade-step-01">
                    <dt>关注中</dt>
                    <dd></dd>
                </dl>
                <ul class="trade-function-01">
                    <li><a href="<?php echo urlShop('member_favorite_goods', 'index'); ?>"><span class="tf01"></span>
                            <h5>商品</h5>
                        </a></li>
                    <li><a href="<?php echo urlShop('member_favorite_store', 'index'); ?>"><span class="tf02"></span>
                            <h5>店铺</h5>
                        </a></li>
                    <li><a href="<?php echo urlShop('member_goodsbrowse', 'list'); ?>"><span class="tf03"></span>
                            <h5>足迹</h5>
                        </a></li>
                </ul>
                <dl class="trade-step-02">
                    <dt>交易进行</dt>
                    <dd></dd>
                </dl>
                <ul class="trade-function-02">
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_new')); ?>">
                            <?php if ($output['order_tip']['order_nopay_count'] > 0) { ?>
                                <sup><?php echo $output['order_tip']['order_nopay_count'] ?></sup>
                            <?php } ?>
                            <span class="tf04"></span>
                            <h5>待付款</h5>
                        </a></li>
                    <li><a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_send')); ?>">
                            <?php if ($output['order_tip']['order_noreceipt_count'] > 0) { ?>
                                <sup><?php echo $output['order_tip']['order_noreceipt_count'] ?></sup>
                            <?php } ?>
                            <span class="tf05"></span>
                            <h5>待收货</h5>
                        </a></li>
                    <li>
                        <a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_notakes')); ?>">
                            <?php if ($output['order_tip']['order_notakes_count'] > 0) { ?>
                                <sup><?php echo $output['order_tip']['order_notakes_count'] ?></sup>
                            <?php } ?>
                            <span class="tf06"></span>
                            <h5>待自提</h5>
                        </a></li>
                    <li>
                        <a href="<?php echo urlShop('member_order', 'index', array('state_type' => 'state_noeval')); ?>">
                            <?php if ($output['order_tip']['order_noeval_count'] > 0) { ?>
                                <sup><?php echo $output['order_tip']['order_noeval_count'] ?></sup>
                            <?php } ?>
                            <span class="tf07"></span>
                            <h5>待评价</h5>
                        </a></li>
                </ul>
                <dl class="trade-step-03">
                    <dt>售后服务</dt>
                    <dd></dd>
                </dl>
                <ul class="trade-function-03">
                    <li><a href="<?php echo urlShop('member_refund', 'index'); ?>"><span class="tf08"></span>
                            <h5>退款</h5>
                        </a></li>
                    <li><a href="<?php echo urlShop('member_return', 'index'); ?>"><span class="tf09"></span>
                            <h5>退货</h5>
                        </a></li>
                    <li>
                        <a href="<?php echo urlShop('member_complain', 'index', array('select_complain_state' => '1')); ?>"><span
                                    class="tf10"></span>
                            <h5>投诉</h5>
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="ncm-header-nav">

            <ul class="nav-menu">

                <?php foreach ($output['right'] as $right_key=>$right_value){ ?>
                    <?php if ($right_key == $output['member_sign']) { ?>
                        <li><a class="current"><?php echo $right_value['name']; ?></a></li>
                    <?php } else { ?>
                        <li class="set">
                            <a href="<?php echo $right_value['url']; ?>">
                                <?php echo $right_value['name']; ?>
                                <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?><i></i><?php }?>
                            </a>
                        <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?>
                            <div class="sub-menu">
                                <?php foreach ($right_value['child'] as $right_c_k=>$right_c_v){ ?>
                                <dl>
                                    <dt><a href="javascript:;" style="color: #EA746B"><?php echo $right_c_k; ?></a></dt>
                                    <?php if (!empty($right_c_v)) { ?>
                                        <?php foreach ($right_c_v as $right_t_k=>$right_t_v){ ?>
                                            <dd><a href="<?php echo $right_t_v['url']; ?>"><?php echo $right_t_v['name']; ?></a></dd>
                                        <?php }?>
                                    <?php }?>
                                </dl>
                                <?php }?>
                            </div>
                        <?php }?>


                        </li>
                    <?php }?>
                <?php }?>

            </ul>

            <div class="notice">
                <ul class="line">
                    <?php if (is_array($output['system_notice']) && !empty($output['system_notice'])) { ?>
                        <?php foreach ($output['system_notice'] as $v) { ?>
                            <li><a <?php if ($v['article_url'] != ''){ ?>target="_blank"<?php } ?>
                                   href="<?php if ($v['article_url'] != '') echo $v['article_url']; else echo urlMember('article', 'show', array('article_id' => $v['article_id'])); ?>"><?php echo $v['article_title'] ?>
                                    <time>(<?php echo date('Y-m-d', $v['article_time']); ?>)</time>
                                </a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <script>
                $(function () {
                    var _wrap = $('ul.line');
                    var _interval = 2000;
                    var _moving;
                    _wrap.hover(function () {
                            clearInterval(_moving);
                        },
                        function () {
                            _moving = setInterval(function () {
                                    var _field = _wrap.find('li:first');
                                    var _h = _field.height();
                                    _field.animate({
                                            marginTop: -_h + 'px'
                                        },
                                        600,
                                        function () {
                                            _field.css('marginTop', 0).appendTo(_wrap);
                                        })
                                },
                                _interval)
                        }).trigger('mouseleave');
                });
            </script>
        </div>
    </div>
    <div class="left-layout">
        <ul id="sidebarMenu" class="ncm-sidebar">
            <?php if (!empty($output['left'])) { ?>



                <?php foreach ($output['left'] as $left_f_k=>$left_f_v) { ?>
                    <li class="side-menu">
                        <a href="javascript:void(0)" key="<?php echo $left_f_k; ?>" <?php if (cookie('Mmenu_' . $key) == 1) echo 'class="shrink"'; ?>>
                            <h3><?php echo $left_f_v['name']; ?></h3>
                        </a>
                        <?php if (!empty($left_f_v['child'])) { ?>
                            <ul <?php if (cookie('Mmenu_' . $key) == 1) echo 'style="display:none"'; ?>>
                                <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                                    <li <?php if ($key == $output['controller']) { ?>class="selected"<?php } ?>>
                                        <a href="<?php echo $left_c_v['url']; ?>"><?php echo $left_c_v['name'];; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>





            <?php } ?>
        </ul>
    </div>
    <div class="right-layout">
        <?php require_once($tpl_file); ?>
    </div>
    <div class="clear"></div>
</div>
<?php require_once template('footer'); ?>
</body></html>