
<div class="ncp-member-top">
    <link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_point.css" rel="stylesheet" type="text/css"><style type="text/css">
    <link href="<?php echo SHOP_TEMPLATES_URL;?>/css/ccy-main.css" rel="stylesheet" type="text/css"><style type="text/css">.public-nav-layout,.classtab a.curr,.head-search-bar .search-form,.public-nav-layout .category .hover .class{background: #eb0a00;}.public-head-layout .logo-test{ color:#eb0a00}.public-nav-layout .category .sub-class{ border-color: #eb0a00;}</style>
    <div class="ncp-member-info">
        <div class="avatar"><img src="<?php echo getMemberAvatarForID($_SESSION['member_id']);?>">
            <div class="frame"></div>
        </div>
        <dl>
            <dt>Hi, <?php echo $_SESSION['member_name'];?></dt>
            <dd>当前等级：<strong><?php echo $output['member_info']['level_name'];?></strong></dd>
               <dd>当前职务：<strong><?php echo $output['posit_info']['title'] ?></strong></dd>
        </dl>
    </div>
    <div class="ncp-member-grade">
        <div class="progress-bar"><em title=""><?php echo $output['posit_info']['title'] ?></em><span title="100"><i style="width:100%;"></i></span><em title=""><?php echo $output['posit_info']['nextgradename'] ?></em></div>
        <div class="progress">
            继续努力冲击下一等级
        </div>
    </div>
    <div class="ncp-member-point">
        <dl style="border-left: none 0;">
            <a href="index.php?controller=member_team&action=first_team" target="_blank">
                <dt><strong><?php echo $output['posit_info']['detail']['m_total']?$output['posit_info']['detail']['m_total']:'0' ?></strong>位</dt>
                <dd>直推会员数</dd>
            </a>
        </dl>
        <dl>
            <a href="index.php?controller=member_team&action=first_team" target="_blank">
                <dt><strong><?php echo $output['posit_info']['detail']['p_total']?$output['posit_info']['detail']['p_total']:'0'  ?></strong>位</dt>
                <dd>有职务人数</dd>
            </a>
        </dl>

    </div>
</div>