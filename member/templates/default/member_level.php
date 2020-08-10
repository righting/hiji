<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_level.css" rel="stylesheet" type="text/css">

<div class="personal-setting">

    <div class="vip-level-header">
        <div class="per-message-left">
            <div class="outer">
                <img src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
            </div>
            <div class="per-vip-level">
                <span><?php echo $output['member_info']['member_nickname'] ?></span>
                <p>ID:<?php echo $output['member_info']['member_number'] ?></p>
                <div class="per-experience">
                    <span>会员等级经验：</span>

                    <div class="progress" >
                        <div class="progress-inner"　 <?php if($output['member_info']['level_id']!=6){ ?> style="max-width:100%;width:<?php echo bcmul(bcdiv($output['member_info']['member_points'],$output['member_info']['upgrade_point'],2),100).'%'?>;"   <?php } ?>></div>
                    </div>
                    <?php if ($output['member_info']['less_exppoints'] > 0){?>
                        还差<em style="font-size:13px;color:red;"><?php echo $output['member_info']['less_exppoints'];?></em>Hs积分即可成为<em style="font-size:13px;color:red;"><?php echo $output['member_info']['upgrade_name'];?></em>
                    <?php } elseif ($output['member_info']['level'] == 0){?>
                        绑定团队即可升级为免费会员
                    <?php }elseif ($output['member_info']['level'] < 6){?>
                        <a href="/shop/index.php?controller=pointshop&action=buy_grade">去升级</a>
                    <?php }?>
                </div>
                <div class="per-exp-details">
                  <!--  <a href="">我的成长经验</a>-->
                    <a href="/member/index.php?controller=member_points&action=index">积分明细</a>
                </div>
            </div>
        </div>
        <div class="per-grade-message">
            <ul>
                <li class="vip-level">
                    <span>会员等级</span>
                    <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                    echo "<img src='$tplImgUrl'/>";
                    ?>
                    <em><?php echo $output['member_info']['level_name']?></em>
                </li>
                <li class="group-level">
                    <span>团队职级</span>
                    <?php if($output['member_info']['positions_id']<8){?>
                    <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                    echo "<img src='$tplImgUrl'/>";
                    ?>
                    <em><?php echo $output['member_info']['position_name']?></em>
                    <?php }else{?>
                        <em style="margin-left:90px;">无职级</em>
                    <?php }?>
                </li>
            </ul>
        </div>
    </div>


    <div class="vip-banner1">
        <img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/vip-banner1.png">
    </div>



    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="vip-icon-01"></i><span>会员身份等级</span>
        </h3>
        <div class="vip-grade-details">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/vip-grade1.png">
        </div>
    </div>


    <div class="vip-banner2">
        <img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/vip-banner2.png">
    </div>


    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="vip-icon-02"></i>
            <span>规则与权益</span>
        </h3>
        <div class="vip-grade-details">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/vip-rule01.png">
        </div>
    </div>


</div>