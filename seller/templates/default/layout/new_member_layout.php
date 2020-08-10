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
        <div class="personal-head-logo"><img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/logo.png" /></div>
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

<div class="personal-main">
    <div class="personal-left">
        <h3><a href="<?php echo urlShop('member', 'home'); ?>" title="个人中心">个人中心</a></h3>
        <?php if (!empty($output['left'])) { ?>
            <?php foreach ($output['left'] as $left_f_k=>$left_f_v) { ?>
                <dl>
                    <dt><?php echo $left_f_v['name']; ?><i class="fa fa-caret-down"></i></dt>
                    <?php if (!empty($left_f_v['child'])) { ?>
                        <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                            <dd>
                                <a href="<?php echo $left_c_v['url']; ?>"><?php echo $left_c_v['name'];?></a>
                            </dd>
                        <?php } ?>
                    <?php } ?>
                </dl>
            <?php } ?>
        <?php } ?>
    </div>
    <?php require_once($tpl_file);?>
</div>
<?php require_once template('layout/footer'); ?>
</body>
</html>