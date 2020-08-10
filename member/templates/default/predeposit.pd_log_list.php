<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<link  href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_personal.css" rel="stylesheet" type="text/css"/>
<link  href="<?php echo SHOP_TEMPLATES_URL;?>/layer/theme/default/layer.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layer/layer.js"></script>

<div class="personal-setting">
    <div class="personal-assets-top">
        <div class="personal-assets-person">
            <div class="assets-person-top">
                <div class="outer">
                    <img style="height: 65px;width: 65px; border-radius:32px;" src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
                </div>
                <div class="login-details">
                    <span><?php echo $output['member_info']['member_nickname'];?></span>
                    <p>上次登录时间:</p>
                    <em><?php echo date('Y年m月d日',$output['member_info']['member_old_login_time']);?></em>
                </div>
            </div>
            <ul class="vip-level">
                <li>
                    <div>
                        <img style="width:32px;" src="<?php echo MEMBER_TEMPLATES_URL;?>/images/user_level_<?php echo $output['member_info']['level_id']?>.png">
                        <span><?php echo $output['member_info']['level_name'] ?></span>
                    </div>
                    <div class="vip-level-top">
                        <p>升级时间：<?php echo @date('Y-m-d H:i:s', $output['userLevelInfo'][0]['create_time']); ?></p>

                        <?php if(!empty($output['userLevelInfo'])){?>

                        <div class="vip-top-details">
                            <ul>
                                <?php foreach($output['userLevelInfo'] as $v){?>
                                    <li>您于<?php echo @date('Y-m-d H:i:s', $v['create_time']); ?>  <?php echo ($v['des'][1].'】'.$v['des'][2].'】') ?> </li>
                                <?php }?>
                            </ul>
                        </div>

                        <?php }?>
                    </div>
                </li>
                <?php if($output['member_info']['positions_id']<8){?>
                <li>
                    <div>
                        <img style="width:32px;" src="<?php echo MEMBER_TEMPLATES_URL;?>/images/user_position_<?php echo $output['member_info']['positions_id']?>.png">
                        <span><?php echo $output['userPositions']['title'] ?></span>
                    </div>
                    <div class="vip-level-bottom">
                        <p>升级时间：<?php echo @date('Y-m-d H:i:s', $output['userPositionsInfo'][0]['create_time']); ?></p>

                        <?php if(!empty($output['userPositionsInfo'])){?>
                        <div class="vip-bottom-details">
                            <ul>
                                <?php foreach($output['userPositionsInfo'] as $v){?>
                                    <li>您于<?php echo @date('Y-m-d H:i:s', $v['create_time']); ?>  <?php echo ($v['des'][1].'】'.$v['des'][2].'】') ?> </li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php }?>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class="personal-secure">
            <div class="personal-secure-top">
                <ul>
                    <li>账户安全</li>
                    <li>支付方式</li>
                    <li>我的卡包</li>
                </ul>
            </div>
            <div class="personal-secure-bottom">
                <ul class="password">
                    <li class="password-login"><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_pwd'));?>"><em></em><span>修改密码</span></a></li>
                    <li class="password-pay"><a href="<?php echo urlMember('member_security', 'setPayPassword', array('type' => 'modify_paypwd'));?>"><em></em><span>支付密码</span></a></li>
                </ul>
                <ul class="payment">
                    <table>
                        <tr>
                            <td class="fast"><em></em><span>快捷支付</span></td>
                            <td class="weixin"><em></em><span>微信</span></td>
                        </tr>
                        <tr>
                            <td class="zhifubao"><em></em><span>支付宝</span></td>
                            <td class="caifutong"><em></em><span>财付通支付</span></td>
                        </tr>
                    </table>
                </ul>


                <ul class="card">
                    <?php if(!empty($output['defaultBank'])){?>
                    <a href="javascript:bankList();">
                        <li class="bank"><em></em><span><?php echo $output['defaultBank']['bank_name']?></span></li>
                        <li><a class="set" href="javascript:bankList();"><span>默认提现卡</span></a></li>
                    </a>
                    <?php }?>
                    <li class="new-card">
                        <a href="javascript:addBank();"><em></em><span>添加新的银行卡</span></a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="personal-assets-banner">
        <img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/assets-banner_01.jpg">
    </div>
    <div class="personal-balance">
        <div class="title">账户余额</div>
        <div class="balance-details">
            <ul>
                <li><p>可用余额</p><em>￥<?php echo $output['member_info']['available_predeposit']; ?></em><?php echo $lang['currency_zh']; ?></li>
                <li><p>冻结金额</p><em>￥<?php echo $output['member_info']['freeze_predeposit']; ?></em><?php echo $lang['currency_zh']; ?></li>
                <li><p>总金额</p><em>￥<?php echo $output['member_info']['available_predeposit']+$output['member_info']['freeze_predeposit']; ?></em><?php echo $lang['currency_zh']; ?></li>
            </ul>
        </div>
    </div>
    <div class="personal-bill">
        <div class="title">我的账单</div>
        <div>
            <div style="position: relative;">
                <ul class="personal-bill-tabs">
                    <a href="/member/index.php?controller=predeposit&action=pd_log_list&type=1"><li <?php if($output['type']==1){ echo "class='cur'";}?> >全部</li></a>
                    <a href="/member/index.php?controller=predeposit&action=pd_log_list&type=2"><li <?php if($output['type']==2){ echo "class='cur'";}?>>购物</li></a>
                    <a href="/member/index.php?controller=predeposit&action=pd_log_list&type=3"><li <?php if($output['type']==3){ echo "class='cur'";}?>>奖金</li></a>
                    <a href="/member/index.php?controller=predeposit&action=pd_log_list&type=4"><li <?php if($output['type']==4){ echo "class='cur'";}?>>充值</li></a>
                    <a href="/member/index.php?controller=predeposit&action=pd_log_list&type=5"><li <?php if($output['type']==5){ echo "class='cur'";}?>>提现</li></a>
                </ul>

            </div>
            <ul class="personal-bill-details">
                <p>
                    <span>收入/支出</span>
                    <span>日期</span>
                    <span>金额</span>
                    <span style="width:42%;">详情</span>
                </p>
                <li class="personal-bill-all">
                    <?php if (count($output['list']) > 0) { ?>
                    <ul>
                        <?php foreach ($output['list'] as $v) { ?>
                            <?php if($v['lg_av_amount'] < 0){?>
                                <li class="bill-expend">
                                <span><i></i>支出</span>
                            <?php }else{?>
                                <li class="bill-income">
                                <span><i></i>收入</span>
                            <?php }?>
                                <span><?php echo @date('Y-m-d H:i:s', $v['lg_add_time']); ?></span>
                                <span><em>
                                        <?php if($v['lg_av_amount']!=0){
                                            if($v['lg_av_amount']>0){ echo '+'.$v['lg_av_amount']; }else{ echo $v['lg_av_amount']; }?>
                                        <?php }else{ echo '+'.$v['lg_freeze_amount']; }?>
                                    </em></span>


                                <span style="<?php if(strlen($v['lg_desc'])>79){ echo 'line-height:normal;'; } ?>padding-left:5px;font-size:10px;width:42%;text-align:left;"><?php echo $v['lg_desc']; ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php } else { ?>
                        <tr>
                            <td colspan="20" class="norecord">
                                <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
                            </td>
                        </tr>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
    <?php if (count($output['list']) > 0) { ?>
        <div class="pagination"> <?php echo $output['show_page']; ?></div>
    <?php } ?>
</div>





<script>

    function bankList(){
        layer.open({
            type:2,
            area:['800px','500px'],
            title:'银行卡列表',
            shade:[0.3,'#ccc'],
            shadeClose:true,
            content:'<?php echo urlMember('bank','userBankList');?>'
        })
    }


    function addBank(){
        layer.open({
            type:2,
            area:['400px','400px'],
            title:'添加新的银行卡',
            shade:[0.3,'#ccc'],
            shadeClose:true,
            content:'<?php echo urlMember('bank','userEditBank');?>'
        })
    }
</script>