
<!doctype html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>海吉壹佰</title>
    <meta name="keywords" content="海吉壹佰" />
    <meta name="description" content="海吉壹佰" />
    <meta name="author" content="CCYNet">
    <meta name="copyright" content="CCYNet Inc. All Rights Reserved">
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <script src="/data/resource/js/jquery.js"></script>
    <style>
        .test-box{border: 1px solid red;width: 1200px;height: auto;display: block;margin: auto;}
        .test-table{width: 100%;border: 1px solid red;display: block;float: left}
        .test-button{width: 90%;height: 30px;border:1px solid red;display: block;float: left}
        .test-button .test-submit-btn{margin: auto;display: block}
    </style>
</head>
<body>

<div class="test-box">
    <form method="post" action="<?php echo urlShop('test','addBonusInfo') ?>">
        <ul>
            <li>平台上个月总利润<input type="text" name="last_month_total_money" value="1000000"></li>
            <li>平台上周总利润<input type="text" name="last_weekly_total_money" value="100000"></li>
            <li>平台昨天的总利润<input type="text" name="yesterday_total_money" value="10000"></li>

        </ul>

        <table class="test-table">
            <thead>
            <tr>
                <th  align="center"></th>
                <th  align="center">用户id</th>
                <th  align="center">用户账号</th>
                <th  align="center">等级id</th>
                <th  align="center">职级id</th>
                <th  align="center">消费额</th>
                <th  align="center">销售额</th>
                <th  align="center">积分</th>
                <th  align="center">HI值</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($output['member_list'] as $user_info){?>
                <tr class="hover">
                    <td align="center"><input type="hidden" name="user_id" value="<?php echo $user_info['member_id'] ?>" ></td>
                    <td align="center"><?php echo $user_info['member_id'] ?></td>
                    <td align="center"><?php echo $user_info['member_name'] ?></td>
                    <td align="center"><?php echo $user_info['level_id'] ?>（<?php echo $output['user_level_info'][$user_info['level_id']] ?>）</td>
                    <td align="center"><?php echo $user_info['positions_id'] ?>（<?php echo isset($output['positions_info'][$user_info['positions_id']]) ? $output['positions_info'][$user_info['positions_id']] : '无' ?>）</td>
                    <td align="center"><input type="text" name="consumption[<?php echo $user_info['member_id'] ?>]" value="10000"></td>
                    <td align="center"><input type="text" name="sales_volume[<?php echo $user_info['member_id'] ?>]" value="10000"></td>
                    <td align="center"><input type="text" name="point[<?php echo $user_info['member_id'] ?>]" value="10000"></td>
                    <td align="center"><input type="text" name="hi_value[<?php echo $user_info['member_id'] ?>]" value="10000"></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <span>选择获取新人鼓励基金的用户</span>
        <ul>
            <?php foreach ($output['member_list'] as $user_info){?>
                <li><input type="checkbox" name="user_new_sales_incentive_fund[]" value="<?php echo $user_info['member_id'] ?>"><?php echo $user_info['member_name'] ?></li>
            <?php } ?>

        </ul>
        <div class="test-button"><input type="submit" class="test-submit-btn" value="提交"></div>
    </form>
    <div class="test-button">
        <a href="<?php echo urlShop('test','wipeData') ?>">清空数据</a>
        <a href="/crontab">开始分红</a>
        <a target="_blank" href="<?php echo urlMember('predeposit','pd_log_list') ?>">查看分红明细</a>
    </div>
</div>
</body>
</html>