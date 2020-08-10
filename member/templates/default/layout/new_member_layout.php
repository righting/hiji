<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
    <title><?php echo $output['html_title'];?></title>
    <meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
    <meta name="description" content="<?php echo $output['seo_description']; ?>" />
    <meta name="author" content="CCYNet">
    <meta name="copyright" content="CCYNet Inc. All Rights Reserved">
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <?php echo html_entity_decode($output['setting_config']['qq_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['sina_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_qqzone_appcode'],ENT_QUOTES); ?><?php echo html_entity_decode($output['setting_config']['share_sinaweibo_appcode'],ENT_QUOTES); ?>
    <link rel="stylesheet" href="<?php echo MEMBER_TEMPLATES_URL;?>/css/member.css" />
    <link rel="stylesheet" href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_base.css" />
    <link rel="stylesheet" href="<?php echo MEMBER_TEMPLATES_URL;?>/css/home_header.css" />
    <link rel="stylesheet" href="<?php echo MEMBER_TEMPLATES_URL;?>/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo MEMBER_TEMPLATES_URL;?>/css/personal.css" />

    <script>
        var SITEURL = "<?php echo SHOP_SITE_URL;?>";
    </script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
    <script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
</head>
<body>
<?php include template('layout/layout_top'); ?>
<div class="personal-head">
    <div class="personal-head-center">
        <div class="personal-head-logo"><a href="<?php echo urlShop('index') ?>"><img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/logo.png" /></a></div>
        <div class="personal-head-nav">
            <ul>
                <?php foreach ($output['right'] as $right_key=>$right_value){ ?>
                <?php if ($right_key == $output['member_sign']) { ?>
                    <li><a href="<?php echo $right_value['url']; ?>" class="current"><?php echo $right_value['name']; ?></a></li>
                <?php } else { ?>
                <li>
                    <a href="<?php echo $right_value['url']; ?>"><?php echo $right_value['name']; ?><?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?><i class="fa fa-angle-down"><?php }?></i></a>
                    <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?>
                    <div class="xnav">
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
        </div>
        <div class="personal-head-search">
            <form action="<?php echo SHOP_SITE_URL;?>" method="get" class="search-form" id="top_search_form">
                <input name="controller" id="search_act" value="search" type="hidden">
                <?php
                if ($_GET['keyword']) {
                    $keyword = stripslashes($_GET['keyword']);
                } elseif ($output['rec_search_list']) {
                    $_stmp = $output['rec_search_list'][array_rand($output['rec_search_list'])];
                    $keyword_name = $_stmp['name'];
                    $keyword_value = $_stmp['value'];
                } else {
                    $keyword = '';
                }
                ?>
                <input name="keyword" id="keyword" type="text" class="input-text" value="<?php echo $keyword;?>" maxlength="60" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" placeholder="<?php echo $keyword_name ? $keyword_name : '请输入您要搜索的商品关键字';?>" data-value="<?php echo rawurlencode($keyword_value);?>" x-webkit-grammar="builtin:search" autocomplete="off" />
                <input style="width: 80px;background: #e2e2e2;color: #5a5a5a;" type="submit" value="<?php echo $lang['nc_common_search'];?>" >
            </form>
        </div>
    </div>
</div>

<style>
    .personal-left .personal-left-active{
        background: #9737DF;
        display: block;
        border: 1px solid #9737df;
        border-radius: 2px;
    }

    .personal-left .personal-left-active a{
        text-align: center;
        color: #fff;
    }
    .personal-left .personal-left-active a:hover{
        color: #c4c4c4;
    }
</style>
<div class="personal-main">
    <div class="personal-left">
        <h3><a href="<?php echo urlShop('member', 'home'); ?>" style="color: #9737df" title="个人中心">个人中心</a></h3>
        <?php if (!empty($output['left'])) { ?>
            <?php foreach ($output['left'] as $left_f_k=>$left_f_v) { ?>
                <dl>
                    <dt><?php echo $left_f_v['name']; ?><i class="fa fa-caret-down"></i></dt>
                    <?php if (!empty($left_f_v['child'])) { ?>
                        <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                            <dd <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?> class="personal-left-active" <?php } ?>>
                                <span style="display:block;float:left;width: 18px;height: 25px;line-height:25px;">
                                    <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/white/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php }else{ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/gray/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php } ?>

                                </span>
                                <a href="<?php echo $left_c_v['url']; ?>" style="float: left;margin-left: 5px;: "><?php echo $left_c_v['name'];?></a>
                            </dd>
                        <?php } ?>
                    <?php } ?>
                </dl>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="essential">
        <div class="partic-secure">
            <div class="partic-secure-top">
                <ul>
                    <li>账户安全</li>
                    <li>财产安全</li>
                    <li>相关设置</li>
                </ul>
            </div>
            <div class="partic-secure-bottom">
                <ul>
                    <li>
                        <a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_pwd'));?>">
                            <span class="personal8"></span>
                            <em>修改密码</em>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_email'));?>">
                            <span class="personal9"></span>
                            <em>邮箱绑定</em>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_mobile'));?>">
                            <span class="personal10"></span>
                            <em>手机绑定</em>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo urlMember('member_security', 'setPayPassword', array('type' => 'modify_paypwd'));?>">
                            <span class="personal11"></span>
                            <em>支付密码</em>
                        </a>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="<?php echo urlMember('predeposit', 'recharge_add');?>">
                            <span class="personal12"></span>
                            <em>在线充值</em>
                        </a>
                    </li>

                </ul>

                <ul>
                    <li>
                        <a href="<?php echo urlMember('member_address', 'address');?>">
                            <span class="personal14"></span>
                            <em>收货地址</em>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo urlMember('member_message', 'setting');?>">
                            <span class="personal15"></span>
                            <em>消息接收</em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="partic-message">
            <div class="partic-message-top">
                <label><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>"></label>
                <span>
                   <?php echo $output['member_info']['member_nickname'];?>

<!--                    <em>--><?php //echo $output['member_info']['level_name'];?><!--</em>-->

                </span>
                <b>上次登入：<?php echo date('Y年m月d日',$output['member_info']['member_old_login_time']);?> </b>
            </div>
            <div class="partic-message-text">
                <p>店铺等级: <?php echo $output['member_info']['level_name'] ?></p>
                <p>当前职称: <?php echo $output['member_info']['position_name'] ?></p>
                <p>加盟时间: <?php echo date('Y-m-d H:i:s',$output['member_info']['member_time']) ?></p>
            </div>
        </div>
    </div>
    <?php require_once($tpl_file);?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<?php require_once template('layout/footer'); ?>
</body>
</html>