<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<div class="essential">
    <div class="essential-nav">
        <?php include template('layout/submenu'); ?>
    </div>
    <div class="alert"><span class="mr30">申请进度：
            <strong class="mr5 red" style="font-size: 18px;"><?php echo $output['proc_state']?></strong>
    </div>
</div>
