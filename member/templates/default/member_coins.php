<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_coins.css" rel="stylesheet" type="text/css">

<div class="personal-setting">
    <div class="per-hj-cur">
        <div class="outer">
            <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
        </div>
        <div class="per-message">
            <h5><span><?php echo $output['member_info']['member_nickname'] ?></span>欢迎您！</h5>
            <p>我的海吉币：<em><?php echo $output['member_info']['sign_in_money'] ?></em><i></i></p>
        </div>
    </div>

    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="hj-report"></i>
            <span>我的海吉币报表</span>
        </h3>
        <?php if(!empty($output['info']) && is_array($output['info'])){?>
        <table class="hj-report-details">
            <tr class="tr1">
                <td>时间</td>
                <td>获取记录</td>
                <td>使用记录</td>
                <td>币数</td>
                <td class="note">备注</td>
            </tr>
            <?php foreach($output['info'] as $k=>$v){?>
                <?php switch($k){
                    case 0:echo ' <tr class="tr2">';break;
                    case 1:echo ' <tr class="tr3">';break;
                    case 2:echo ' <tr class="tr4">';break;
                    case 3:echo ' <tr class="tr5">';break;
                    case 4:echo ' <tr class="tr6">';break;
                    case 5:echo ' <tr class="tr7">';break;
                } ?>
                        <td><?php echo $v['sign_in_time']?></td>
                        <td><?php echo $v['source']?></td>
                        <td><?php echo $v['use_info']?></td>
                        <td><?php echo $v['number']?></td>
                        <td><?php echo $v['content']?></td>
                    </tr>
            <?php } ?>
        </table>

        <?php }else{?>
            <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
        <?php }?>

            <?php if (count($output['info'])>0){?>
            <div class="personal-pagination">
                <ul class="pagination"><?php echo $output['show_page']; ?> </ul>
            </div>
            <?php } ?>
    </div>
    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="hj-act"></i>
            <span>海吉币活动资讯</span>
        </h3>
        <div class="hj-act-details">
            <div class="act-pre">
                <h5>预告</h5>
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/hj_act_01.png">
                <p>
                    10月17日国际扶贫日“消费扶贫献爱”活动
                </p>
                <a href="javascript:;">获消费扶贫券</a>
                <a href="javascript:;">马上去抽奖</a>
            </div>
            <div class="act-processing">
                <h5>进行中</h5>
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/hj_act_02.png">
                <div class="join">
                    <h6>不忘初心</h6>
                    <h6 style="padding-left: 100px">牢记使命</h6>
                    <p>庆祝中国共产党建党97年“感恩党、回馈会员”活动进行中...</p>
                    <a href="">快快加入</a>
                </div>
            </div>
        </div>
    </div>
</div>