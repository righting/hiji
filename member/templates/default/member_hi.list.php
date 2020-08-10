<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<div class="essential">
    <div class="essential-nav">
        <?php include template('layout/submenu'); ?>
        <a style="display:none" class="ncbtn ncbtn-bittersweet" title="在线充值" href="upgrade/index.php"
           style="right: 207px;"><i class="icon-shield"></i>在线充值</a>
        <a class="ncbtn ncbtn-mint" href="upgrade/index.php" style="right: 107px;"><i
                class="icon-money"></i>申请提现</a>
    </div>

    <table class="ncm-default-table">
        <thead>
        <tr>
            <th class="w150 ">HI值</th>
            <th class="w150 ">类型</th>
            <th class="w150 ">增/减</th>
            <th class="w150 ">有效期</th>
            <th class="w150 ">生成时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($output['log_list']) > 0) { ?>
            <?php foreach ($output['log_list'] as $v) { ?>
                <tr class="bd-line">
                    <td><?php echo $v['hi_value'] ?></td>
                    <td><?php echo $v['hi_type'] ?></td>
                    <td><?php echo $v['get_type'] ?></td>
                    <td><?php echo $v['expiration_at'] ?></td>
                    <td class="w160 tc"><?php echo $v['created_at'] ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="20" class="norecord">
                    <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <?php if (count($output['list']) > 0) { ?>
            <tr>
                <td colspan="20">
                    <div class="pagination"> <?php echo $output['show_page']; ?></div>
                </td>
            </tr>
        <?php } ?>
        </tfoot>
    </table>
</div>
