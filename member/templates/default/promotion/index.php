<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_promotion.css" rel="stylesheet" type="text/css">
<!--职级晋升-->
<div class="promote">
    <div class="promote-details">
        <div class="promote-sculpture">
            <div class="promote-sculpture-a">
                <img src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
            </div>
            <div class="promote-sculpture-b">
                <p><?php echo $output['member_info']['member_nickname'] ?></p>
                <p class="promote-sculpture-b1">ID:<?php echo $output['member_info']['member_number'] ?></p>
            </div>
        </div>
        <div class="promote-thread"></div>
        <div class="promote-sculpture-c">
            <div class="promote-sculpture-c1">
                <p>会员等级</p>
                <p>团队职级</p>
            </div>
            <div class="promote-sculpture-d">
                <div class="promote-sculpture-d3">
                    <div class="promote-sculpture-d1">
                        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/user_level_<?php echo $output['member_info']['level_id'];?>.png">
                    </div>
                    <div class="promote-sculpture-d2" >
                        <?php if($output['member_info']['positions_id']<8){?>
                        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/user_position_<?php echo $output['member_info']['positions_id'];?>.png">
                        <?php }?>
                    </div>
                </div>
                <div class="promote-sculpture-e">
                    <p class="promote-sculpture-p1">
                        <?php echo $output['member_info']['level_name']?>
                    </p>
                    <p class="promote-sculpture-p2">
                        <?php echo $output['member_info']['position_name']?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="promote-a">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/grateful.gif">
    </div>

    <div class="promote-b">
        <div class="promote-b1">
            <div class="promote-b1-a">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/marking%20_1.png">
            </div>
            <p class="promote-b1-b">团队职级晋升</p>
        </div>
        <div class="promote-b2">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/route_1.gif">
        </div>
    </div>

    <div class="promote-c">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/route_2.jpg">
    </div>

    <div class="promote-d">
        <div class="promote-b1">
            <div class="promote-b1-a">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/marking%20_1.png">
            </div>
            <p class="promote-b1-b">晋升规则与权益</p>
        </div>

        <div class="promote-d1">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/route_3.png">
        </div>

        <div class="promote-d2">
            团队职级类
        </div>

        <div class="promote-d3">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/rout_4.gif">
        </div>
    </div>

    <div class="promote-c">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/rotue_5.png">
    </div>

  <!--  <div class="promote-e">
        <div class="promote-b1">
            <div class="promote-b1-a">
                <img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/true.png">
            </div>
            <p class="promote-b1-b">优秀供应商队商品</p>
        </div>

        <ul>
            <li><img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/true.png"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
            <li><img src="imges"></li>
        </ul>
    </div>-->
</div>