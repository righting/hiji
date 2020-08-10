<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_bonus.css" rel="stylesheet" type="text/css">
<div class="personal-setting">
    <div class="personal-bonus-head">
        <div class="personal-message-left">
            <div class="outer">
                <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
            </div>
            <div class="personal-message-id">
                <span><?php echo $output['member_info']['member_nickname'] ?></span>
                <p style="font-size:12px;">ID：<?php echo $output['member_info']['member_number'] ?></p>
            </div>
        </div>
        <ul class="personal-message-right">
            <li class="personal-bonus-grade">
                <span>我的等级</span>
                <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                    echo "<i style='background:url($tplImgUrl) 0 0 no-repeat'></i>";
                ?>
            </li>
            <?php if($output['member_info']['positions_id']<8){?>
                <li class="personal-bonus-rank">
                    <span>我的职级</span>
                    <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                    echo "<i style='background:url($tplImgUrl) 0 0 no-repeat'></i>";
                    ?>
                </li>
            <?php }?>
            <li>
                <span style="margin-bottom: 35px;">本月消费金额</span>
                <em>￥<?php echo $output['thisMonthMoney']['totalMoney']?></em>
            </li>
        </ul>
    </div>
    <div class="bonus-current-month">
        <div class="bonus-top">
            <h5><i></i>本月分红</h5>
        </div>
        <div class="bonus-withdraw">
            <span>￥<?php echo array_sum($output['count'])?></span>
            <a href="/member/index.php?controller=member_security&action=auth&type=pd_cash">立即提现</a>
        </div>
        <ul class="bonus-details">
            <li class="bonus-date">
                <h1><b></b>日分红</h1>
                <ul class="bonus-details-list">
                    <li><i></i>消费普惠分红<em>￥<?php echo $output['count']['17'] ?></em></li>
                    <li><i></i>团队消费共享分红<em>￥<?php echo $output['count']['18'] ?></em></li>
                    <li><i></i>微店消费共享分红<em>￥<?php echo $output['count']['19'] ?></em></li>
                    <li><i></i>消费日分红<em>￥<?php echo $output['count']['1'] ?></em></li>
                    <li><i></i>消费明星日分红<em>￥<?php echo $output['count']['2'] ?></em></li>
                    <li><i></i>共享日分红<em>￥<?php echo $output['count']['10'] ?></em></li>
                </ul>
                <p class="bonus-total">总计<em>￥<?php echo $output['count']['1']+$output['count']['10']+$output['count']['2']+$output['count']['17']+$output['count']['18']+$output['count']['19'] ?></em></p>
            </li>
            <li class="bonus-week">
                <h1><b></b>周分红</h1>
                <ul class="bonus-details-list">
                    <li><i></i>管理普惠周分红<em>￥<?php echo $output['count']['11'] ?></em></li>
                    <li><i></i>中层管理周分红<em>￥<?php echo $output['count']['5'] ?></em></li>
                </ul>
                <p class="bonus-total">总计<em>￥<?php echo $output['count']['11']+$output['count']['5'] ?></em></p>
            </li>
            <li class="bonus-month">
                <h1><b></b>月分红</h1>
                <ul class="bonus-details-list">
                    <li><i></i>新人普惠分红<em>￥<?php echo $output['count']['9'] ?></em></li>
                    <li><i></i>商家推荐分红<em>￥<?php echo $output['count']['12'] ?></em></li>
                    <li><i></i>至尊消费月分红<em>￥<?php echo $output['count']['6'] ?></em></li>
                    <li><i></i>消费精英月分红<em>￥<?php echo $output['count']['7'] ?></em></li>
                    <li><i></i>高层消费月分红<em>￥<?php echo $output['count']['8'] ?></em></li>
                </ul>
                <p class="bonus-total">总计<em>￥<?php echo $output['count']['12']+$output['count']['6']+$output['count']['7']+$output['count']['8']+$output['count']['12']+$output['count']['9'] ?></em></p>
            </li>
        </ul>
    </div>
    <div class="personal-bonus-banner">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/member-bonus-banner_01.jpg">
    </div>
    <div class="personal-bonus-history">
        <div class="bonus-top">
            <h5><i></i>历史分红</h5>
            <a href="<?php echo urlMember('member_bonus','bonusDetails') ?>" title="查看历史分红明细">查看历史分红明细</a>
        </div>
        <div class="bonus-history-details">
            <h2>
                <b>日期</b>
                <span>日分红</span>
                <span>周分红</span>
                <span>月分红</span>
                <span>总计</span>
            </h2>
            <ul>
                <?php foreach($output['news'] as $k => $v){?>
                <li>
                    <b><i></i><?php echo $v['time']?></b>
                    <span><?php echo $v['info'][1]+$v['info'][2]+$v['info'][10]+$v['info'][17]+$v['info'][18]+$v['info'][19]?></span>
                    <span><?php echo $v['info'][11]+$v['info'][5]?></span>
                    <span><?php echo $v['info'][12]+$v['info'][6]+$v['info'][7]+$v['info'][8]+$v['info'][9]?></span>
                    <span><?php echo array_sum($v['info'])?></span>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>