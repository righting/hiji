<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<link href="<?php echo DISTRIBUTE_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
<script>
    //sidebar-menu
    $(document).ready(function() {
        $.each($(".side-menu > a"), function() {
            $(this).click(function() {
                var ulNode = $(this).next("ul");
                if (ulNode.css('display') == 'block') {
                    $.cookie(COOKIE_PRE+'Mmenu_'+$(this).attr('key'),1);
                } else {
                    $.cookie(COOKIE_PRE+'Mmenu_'+$(this).attr('key'),null);
                }
                ulNode.slideToggle();
                if ($(this).hasClass('shrink')) {
                    $(this).removeClass('shrink');
                } else {
                    $(this).addClass('shrink');
                }
            });
        });
        $.each($(".side-menu-quick > a"), function() {
            $(this).click(function() {
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
    $(function() {
        //展开关闭常用菜单设置
        $('.set-btn').bind("click",
            function() {
                $(".set-container-arrow").show("fast");
                $(".set-container").show("fast");
            });
        $('[nctype="closeCommonOperations"]').bind("click",
            function() {
                $(".set-container-arrow").hide("fast");
                $(".set-container").hide("fast");
            });

        $('dl[nctype="checkcCommonOperations"]').find('input').click(function(){
            var _this = $(this);
            var _dd = _this.parents('dd:first');
            var _type = _this.is(':checked') ? 'add' : 'del';
            var _value = _this.attr('name');
            var _operations = $('[nctype="commonOperations"]');

            // 最多添加5个
            if (_operations.find('li').length >= 5 && _type == 'add') {
                showError('最多只能添加5个常用选项。');
                return false;
            }
            $.getJSON('<?php echo urlShop('member', 'common_operations')?>', {type : _type, value : _value}, function(data){
                if (data) {
                    if (_type == 'add') {
                        _dd.addClass('checked');
                        if (_operations.find('li').length == 0) {
                            _operations.fadeIn('slow');
                        }
                        _operations.find('ul').append('<li style="display : none;" nctype="' + _value + '"><a href="' + _this.attr('data-value') + '">' + _this.attr('data-name') + '</a></li>');
                        _operations.find('li[style]').fadeIn('slow');
                    } else {
                        _dd.removeClass('checked');
                        _operations.find('li[nctype="' + _value + '"]').fadeOut('slow', function(){
                            $(this).remove();
                            if (_operations.find('li').length == 0) {
                                _operations.fadeOut('slow');
                            }
                        });
                    }
                }
            });
        });
    });

</script>
<div class="ncm-container">
    <div class="ncm-header">
        <div class="ncm-header-top">
            <div class="ncm-member-info">
                <div class="avatar"><a href="<?php echo urlMember('member_information', 'avatar');?>" title="修改头像"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>">
                        <div class="frame"></div>
                    </a>
                    <?php if (intval($output['message_num']) > 0){ ?>
                        <a href="<?php echo DISTRIBUTE_SITE_URL?>index.php?controller=member_message&action=message" class="new-message" title="新消息"><?php echo intval($output['message_num']); ?></a>
                    <?php }?>
                </div>
                <dl>
                    <dt><a href="<?php echo urlMember('member_information', 'member');?>" title="修改资料"><?php echo $output['member_info']['member_nickname'];?></a></dt>
                    <dd>会员等级：
                        <?php if ($output['member_info']['level_name']){ ?>
                            <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?>会员</div>
                        <?php } ?>
                    </dd>
                    <dd>上次登录：<?php echo date('Y年m月d日 H:i:s',$output['member_info']['member_old_login_time']);?> </dd>
                    <dd>登录绑定：
                        <div class="user-account">
                            <ul>
                                <li id="qq"><a href="<?php echo urlMember('member_bind', 'qqbind');?>" title="登录绑定QQ账号" <?php if (!empty($output['member_info']['member_qqopenid'])){?>class="have"<?php }?>> <span class="icon"></span> </a> </li>
                                <li id="weichat"><a href="<?php echo urlMember('member_bind', 'weixinbind');?>" title="登录绑定微信账号" <?php if (!empty($output['member_info']['weixin_unionid'])){?>class="have"<?php }?>> <span class="icon"></span></a> </li>
                                <li id="weibo"><a href="<?php echo urlMember('member_bind', 'sinabind');?>" title="登录绑定微博账号" <?php if (!empty($output['member_info']['member_sinaopenid'])){?>class="have"<?php }?>> <span class="icon"></span></a> </li>
                            </ul>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="ncm-set-menu">
                <dl class="zhaq">
                    <dt>账户安全</dt>
                    <dd>
                        <ul>
                            <li><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_pwd'));?>"><span class="zhaq01"></span><sub></sub>
                                    <h5>修改密码</h5>
                                </a> </li>
                            <li <?php if($output['member_info']['member_email_bind'] == '1') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_email'));?>"><span class="zhaq02"></span><sub></sub>
                                    <h5>邮箱绑定</h5>
                                </a> </li>
                            <li <?php if($output['member_info']['member_mobile_bind'] == '1') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_mobile'));?>"><span class="zhaq03"></span><sub></sub>
                                    <h5>手机绑定</h5>
                                </a> </li>
                            <li <?php if($output['member_info']['member_paypwd'] != '') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_paypwd'));?>"><span class="zhaq04"></span><sub></sub>
                                    <h5>支付密码</h5>
                                </a> </li>
                        </ul>
                    </dd>
                </dl>
                <dl class="zhcc">
                    <dt>账户财产</dt>
                    <dd>
                        <ul>
                            <li><a href="<?php echo urlMember('predeposit', 'recharge_add');?>"> <span class="zhcc01"></span>
                                    <h5>在线充值</h5>
                                </a> </li>
                            <li><a href="<?php echo urlMember('predeposit', 'rechargecard_add');?>"> <span class="zhcc02"></span>
                                    <h5>充值卡充值</h5>
                                </a> </li>
                            <li><a href="<?php echo urlMember('member_voucher', 'voucher_binding')?>"><span class="zhcc03"></span>
                                    <h5>领取代金券</h5>
                                </a> </li>
                            <li><a href="<?php echo urlMember('member_redpacket', 'rp_binding');?>"> <span class="zhcc04"></span>
                                    <h5>领取红包</h5>
                                </a> </li>
                        </ul>
                    </dd>
                </dl>
                <dl class="xgsz">
                    <dt>相关设置</dt>
                    <dd>
                        <ul class="trade-function-03">
                            <li><a href="<?php echo urlMember('member_address', 'address');?>"><span class="xgsz01"></span>
                                    <h5>收货地址</h5>
                                </a> </li>
                            <li><a href="<?php echo urlMember('member_message', 'setting');?>"><span class="xgsz02"></span>
                                    <h5>消息接收</h5>
                                </a> </li>

                        </ul>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="ncm-header-nav">

            <ul class="nav-menu">
                <!--                <li><a href="--><?php //echo urlShop('member', 'home'); ?><!--" class="current">个人中心</a></li>-->
                <!--                <li><a href="--><?php //echo urlMember('predeposit', 'pd_log_list'); ?><!--" class="current">我的资产</a></li>-->
                <!--                <li><a href="--><?php //echo urlShop('member', 'home'); ?><!--" class="current">我的特权</a></li>-->
                <!--                <li><a href="--><?php //echo urlShop('member', 'home'); ?><!--" class="current">我的商城</a></li>-->

                <?php foreach ($output['right'] as $right_key=>$right_value){ ?>
                    <?php if ($right_key == $output['member_sign']) { ?>
                        <li><a href="<?php echo urlDistribute('member', 'home'); ?>" class="current"><?php echo $right_value['name']; ?></a></li>
                    <?php } else { ?>
                        <li class="set">
                            <a href="<?php echo urlShop('member', 'home'); ?>"><?php echo $right_value['name']; ?><i></i></a>
                            <div class="sub-menu">

                                <?php foreach ($right_value['child'] as $right_c_k=>$right_c_v){ ?>
                                    <dl>
                                        <dt><a href="<?php /*echo urlMember('member_information', 'member') */?>" style="color: #EA746B"><?php echo $right_c_k; ?></a></dt>
                                        <?php if (!empty($right_c_v)) { ?>
                                            <?php foreach ($right_c_v as $right_t_k=>$right_t_v){ ?>
                                                <dd><a href="<?php /*echo urlMember('member_address', 'address'); */?>"><?php echo $right_t_v['name']; ?></a></dd>
                                            <?php }?>
                                        <?php }?>
                                    </dl>
                                <?php }?>

                            </div>
                        </li>
                    <?php }?>
                <?php }?>

                <!--<li class="set">
                    <a href="<?php /*echo urlMember('member', 'home'); */?>">用户设置<i></i></a>
                    <div class="sub-menu">
                        <dl>
                            <dt><a href="<?php /*echo urlMember('member_security', 'index'); */?>" style="color: #3AAC8A;">安全设置</a>
                            </dt>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_pwd')); */?>">修改登录密码</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_mobile')); */?>">手机绑定</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_email')); */?>">邮件绑定</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_paypwd')); */?>">支付密码</a>
                            </dd>
                        </dl>
                        <dl>
                            <dt><a href="<?php /*echo urlMember('member_information', 'member') */?>"
                                   style="color: #EA746B">个人资料</a></dt>
                            <dd><a href="<?php /*echo urlMember('member_address', 'address'); */?>">收货地址</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_information', 'avatar') */?>">修改头像</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_message', 'setting'); */?>">消息接受设置</a></dd>
                        </dl>
                        <dl>
                            <dt><a href="<?php /*echo urlMember('predeposit', 'pd_log_list') */?>" style="color: #FF7F00">账户财产</a>
                            </dt>
                            <dd><a href="<?php /*echo urlMember('predeposit', 'recharge_add'); */?>">余额充值</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_voucher', 'voucher_binding') */?>">领取代金券</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_redpacket', 'rp_binding'); */?>">领取红包</a></dd>
                        </dl>
                        <dl>
                            <dt><a href="<?php /*echo urlMember('member_bind', 'qqbind') */?>"
                                   style="color: #398EE8">账号绑定</a></dt>
                            <dd><a href="<?php /*echo urlMember('member_bind', 'qqbind'); */?>">QQ绑定</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_bind', 'sinabind') */?>">微博绑定</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_bind', 'weixinbind'); */?>">微信绑定</a></dd>
                            <dd><a href="<?php /*echo urlMember('member_sharemanage', 'index'); */?>">分享绑定</a></dd>
                        </dl>
                    </div>
                </li>-->
                <!--<li class="set">
                    <a href="<?php /*echo urlDistribute('member', 'home'); */?>">分销中心<i></i></a>
                    <div class="sub-menu">
                        <dl>
                            <dt><a href="<?php /*echo urlMember('member_security', 'index'); */?>" style="color: #3AAC8A;">分销商品</a>
                            </dt>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_pwd')); */?>">修改登录密码</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_mobile')); */?>">手机绑定</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_email')); */?>">邮件绑定</a>
                            </dd>
                            <dd>
                                <a href="<?php /*echo urlMember('member_security', 'auth', array('type' => 'modify_paypwd')); */?>">支付密码</a>
                            </dd>
                        </dl>

                    </div>
                </li>-->
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
        <?php require_once($tpl_file);?>
    </div>
    <div class="clear"></div>
</div>
<?php require_once template('layout/footer');?>
</body></html>