<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="ncap-form-default">
    <dl class="row">
        <dt class="tit">分红类型</dt>
        <dd class="opt" style="width: 30%">分红金额</dd>
        <dd class="opt" style="width: 30%">受益用户名</dd>
    </dl>
    <?php foreach ($output['bonus_list']  as $val): ?>
    <dl class="row">
        <dt class="tit">
            <label><?php echo $output['bonusType'][$val['type']]; ?></label>
        </dt>
        <dd class="opt" style="width: 30%"> <?php echo $val['money']; ?> </dd>
        <dd class="opt" style="width: 30%"> <?php echo $output['userInfo'][$val['user_id']]; ?> </dd>
    </dl>
    <?php endforeach; ?>
    <?php foreach ($output['bonus_log_team'] as $val): ?>
        <dl class="row">
            <dt class="tit" >
                <label><?php echo $output['bonusType'][$val['type']]; ?></label>
            </dt>
            <dd class="opt" style="width: 30%"> <?php echo $val['money']; ?> </dd>
            <dd class="opt" style="width: 30%"> <?php echo $output['userInfo'][$val['to_user_id']]; ?> </dd>
        </dl>
    <?php endforeach; ?>
</div>
