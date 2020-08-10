<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_contribution.css" rel="stylesheet" type="text/css">
<!--我的贡献值-->
<div class="contribute">
    <div class="contribute-particulars">
        <div class="contribute-particulars-a">
            <ul>
                <li>
                    <p class="contribute-particulars-p1">我的会员等级</p>
                    <div class="contribute-particulars-a1">
                        <?php
                        $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                        echo "<img src='$tplImgUrl'>";
                        ?>
                    </div>
                    <p class="contribute-particulars-p2"><?php echo $output['member_info']['level_name']?></p>
                </li>
                <?php if($output['member_info']['positions_id']<8){?>
                    <li>
                        <p class="contribute-particulars-p1">我的团队职级</p>
                        <div class="contribute-particulars-a2">
                            <?php
                            $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                            echo "<img src='$tplImgUrl'>";
                            ?>
                        </div>
                    </li>
                <?php }?>
                <li>
                    <p class="contribute-particulars-p1">我的贡献值</p>
                    <div class="contribute-particulars-a3">
                        <?php echo $output['total']?$output['total']:0?>
                    </div>
                </li>
            </ul>
        </div>
        <div class="contribute-hen"></div>
        <div class="contribute-particulars-b">
            <p class="contribute-particulars-b1">
                获得贡献值：<?php echo $output['total']?$output['total']:0?>
            </p>
            <ul>
                <li>
                    <p class="contribute-particulars-b2" >通过销量获得</p>
                    <p class="contribute-particulars-b3">
                        <?php echo ($output['info'][2]['contribution']?$output['info'][2]['contribution']:0);?>
                    </p>
                </li>
                <li>
                    <p class="contribute-particulars-b2" >通过推荐获得</p>
                    <p class="contribute-particulars-b3">
                        <?php echo ($output['info'][0]['contribution']?$output['info'][0]['contribution']:0);?>
                    </p>
                </li>
                <li>
                    <p class="contribute-particulars-b2" >通过晋升获得</p>
                    <p class="contribute-particulars-b3">
                        <?php echo ($output['info'][1]['contribution']?$output['info'][1]['contribution']:0);?>
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="contribute-quan">
        <a href="#"><img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/banner.png"></a>
    </div>
    <div class="contribute-rule">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/contribute_5.jpg">

    </div>
    <div class="contribute-detail ">
        <div class="contribute-detail-a">
            <i><img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/contribute_6.png"></i>
            <span>我的贡献值明细</span>
        </div>
        <table>
            <?php if ( !empty($output['log_list']) && is_array($output['log_list'])){ ?>
                <tr class="contribute-detail-tr">
                    <th class="contribute-th3">来源</th>
                    <th class="contribute-th3">获得贡献值</th>
                    <th class="contribute-th">获得日期</th>
                    <th class="contribute-th1">备注</th>
                </tr>
                <?php foreach ($output['log_list'] as $val) : ?>
                    <tr>
                        <th class="contribute-th3">
                            <?php
                            switch($val['type']){
                                case 1:echo '直推会员升级';break;
                                case 2:echo '直推会员升职';break;
                                case 3:echo '个人销售奖励';break;
                            }
                            ?>
                        </th>
                        <th class="contribute-th3 contribute-yan"><?php echo ($val['operate']==1?'+':'-').$val['contribution'] ?></th>
                        <th class="contribute-th"><?php echo date('Y-m-d H:i:s',$val['create_time']) ?></th>
                        <th class="contribute-th1"><?php echo $val['des'] ?></th>
                    </tr>
                <?php endforeach;?>
            <?php }else{?>
                <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
            <?php }?>
        </table>
    </div>
    <?php if (count($output['log_list']) > 0) { ?>
        <div class="pagination"> <?php echo $output['show_page']; ?></div>
    <?php } ?>
</div>
