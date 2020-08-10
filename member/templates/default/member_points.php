<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/style.css" rel="stylesheet" type="text/css">

<div class="personal-setting">
    <div class="personal-points-top">
        <div class="personal-points-person">
            <h2>尊敬的<?php echo $output['member_info']['level_name'] ?>：</h2>
            <div class="personal-image-outer"><img src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>"></div>
            <div class="personal-points-progress">
                <div class="progress-outer">
                    <div class="progress-inner" <?php if($output['member_info']['level_id']!=6){ ?> style="width:<?php echo bcmul(bcdiv($output['member_info']['member_points'],$output['member_info']['upgrade_point'],2),100).'%'?>;"   <?php } ?>></div>
                </div>
                <div style="text-align: right;float:right;margin-top:-2px;">
                    <em><?php echo $output['member_info']['member_points']?></em>
                    <i></i>
                </div>
            </div>
            <div class="personal-points-text">
                    <?php if ($output['member_info']['less_exppoints'] > 0){?>
                        还差<em style="font-size:13px;color:red;"><?php echo $output['member_info']['less_exppoints'];?></em>Hs积分即可成为<em style="font-size:13px;color:red;"><?php echo $output['member_info']['upgrade_name'];?></em>
                    <?php } elseif ($output['member_info']['less_exppoints'] == 'none'){?>
                        继续加油保持这份荣誉哦！
                    <?php } elseif ($output['member_info']['level'] == 0){?>
                        绑定团队即可升级为免费会员
                    <?php }else{?>
                        积分已经可以升级了
                    <?php }?>
            </div>
        </div>
        <div class="personal-points-rules">
            <p><span class="title">积分获得规则：</span></p>

            <p class="text" style="font-size:13px;text-indent: 1em;letter-spacing:1px;">海吉积分，为会员消费金额的等比积分，计量单位用H或Hs表示, 即：1元 = 1海吉积分=1H=1Hs。在海豚主场专页里消费商品所得海吉积分的计量单位是Hs，其他的海吉积分计量单位是H。海吉积分，可以累积，可以在平台规定的积分商城里按活动说明兑换/兑购商品,但不可以转赠或买卖或兑现。会员在平台消费产生订单并完成支付后，就会自动得到等比例的海吉积分；若会员有退单或退货的情况产生，平台在会员中心后台将扣除因退单或退货相对应已产生的海吉积分。会员升级所需的海吉积分必须要在平台海豚主场专页里消费产生<?php if (C('points_ordermax')) {?>（最高限额不超过<?php echo C('points_ordermax');?>）<?php }?>积分。</p><br/>
                <p style="color:red;">如订单发生退款、退货等问题时，积分将不予退还。</p>
        </div>
    </div>
    <div class="personal-points-mid">
        <div class="points-upgrade">
            <ul>
                <li>
                    <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/points_07.png"></img>
                    <span>可用升级积分</span>
                    <em><?php echo $output['member_info']['member_points']?></em>
                </li>
                <li>
                    <span>冻结升级积分</span>
                    <em>0</em>
                </li>
                <li>
                    <?php if($output['member_info']['level_id']<6){?>
                        <a href="/shop/index.php?controller=pointshop&action=buy_grade">去升级！</a>
                    <?php }?>
                </li>
            </ul>
        </div>
        <div class="points-normal">
            <ul>
                <li>
                    <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/points_10.png">
                    <span>可用普通积分</span>
                    <em><?php echo $output['member_info']['member_h_points']?></em>
                </li>
                <li>
                    <span>冻结普通积分</span>
                    <em>0</em>
                </li>
                <li>
                    <a href="/shop/index.php?controller=pointprod&action=plist">兑换商品</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="personal-points-bottom">
        <div class="personal-points-tab">
            <form action="index.php" method="get" id="points-type">
                <input type="hidden" name="controller" value="member_points" />
                <input type="hidden" id="types" name="types" value="1">
            </form>
            <p>积分明细</p>
            <ul>
                <a href="javascript:point_submit(1);"><li <?php if($output['types']==1){ echo "class='personal-points-selected'";} ?> >全部积分</li></a>
                <a href="javascript:point_submit(2);"><li <?php if($output['types']==2){ echo "class='personal-points-selected'";} ?> >积分收入</li></a>
                <a href="javascript:point_submit(3);"><li <?php if($output['types']==3){ echo "class='personal-points-selected'";} ?> >积分支出</li></a>
              <!--  <a href="javascript:point_submit(4);"><li <?php /*if($output['types']==4){ echo "class='personal-points-selected'";} */?> >冻结积分</li></a>-->
            </ul>
        </div>
        <ul class="tab-box">
            <li class="points-details">
                <div class="points-details-title">
                    <ul class="clearfix">
                        <li>来源/用途</li>
                        <li>积分种类</li>
                        <li>积分变更</li>
                        <li>日期</li>
                        <li>描述</li>
                    </ul>
                </div>
                <?php  if (count($output['list_log'])>0) { ?>
                    <?php foreach($output['list_log'] as $val) { ?>
                    <div class="details">
                        <div class="details-top">
                            <ul class="clearfix">
                                <li>
                                            <?php
                                            switch ($val['pl_stage']){
                                                case 'regist':
                                                    echo $lang['points_stage_regist'];
                                                    break;
                                                case 'login':
                                                    echo $lang['points_stage_login'];
                                                    break;
                                                case 'comments':
                                                    echo $lang['points_stage_comments'];
                                                    break;
                                                case 'order':
                                                    echo $lang['points_stage_order'];
                                                    break;
                                                case 'order_for_other':
                                                    echo $lang['points_stage_order'];
                                                    break;
                                                case 'system':
                                                    echo $lang['points_stage_system'];
                                                    break;
                                                case 'pointorder':
                                                    echo $lang['points_stage_pointorder'];
                                                    break;
                                                case 'app':
                                                    echo $lang['points_stage_app'];
                                                    break;
                                                case 'pointorder_other':
                                                    echo '非海豚主场积分';
												case 'prize':
                                                    echo '抽奖';
                                                case 'pointmember';
                                                    echo  $lang['points_stage_pointmember'];
                                            }
                                            ?>
                                </li>
                                <li><?php if(strstr($val['pl_desc'],'非')){ echo '普通积分'; ?><?php }else{ echo '升级积分'; ?><?php } ?></li>
                                <li><?php echo ($val['pl_points'] > 0 ? '+' : '').$val['pl_points']; ?></li>
                                <li><?php echo @date('Y-m-d',$val['pl_addtime']);?></li>
                                <li>
                                    <?php if(strlen($val['pl_desc'])>40){?>
                                    <span>
                                        <?php echo $val['pl_desc'];?>
                                    </span>
                                    <?php }else{?>
                                        <?php echo $val['pl_desc'];?>
                                    <?php }?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
                <?php } ?>

            </li>
            <li style="display: none;"></li>
            <li style="display: none;"></li>
            <li style="display: none;"></li>
        </ul>
    </div>

    <div class="personal-pagination">
        <?php  if (count($output['list_log'])>0) { ?>
            <div class="pagination"><?php echo $output['show_page']; ?></div>
        <?php } ?>
    </div>
</div>
<script>
    function point_submit(type){
        $('#types').val(type);
        $('#points-type').submit();
    }
</script>