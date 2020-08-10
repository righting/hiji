<link href="/shop/templates/default/css/new_member_card.css" rel="stylesheet" type="text/css">
<div class="business">
        <div class="business-a">
            <p class="business-a1">
                <span class="business-a1-a"><?php echo $output['member_info']['member_nickname'];?></span>
                <span class="business-a1-b"><?php echo $output['member_info']['level_name']; ?></span>
            </p>

            <p class="business-b">
               手机 ：<?php if($output['member_info']['member_mobile']){echo $output['member_info']['member_mobile'];}else{ echo '未绑定手机';}?>
            </p>

            <p class="business-b">
                会员职级 : <?php echo $output['member_info']['position_name']?>
            </p>

            <p class="business-b">
                我的ID : <?php echo $output['member_info']['member_number'];?>
            </p>

            <p class="business-c">
                <span>我的微店：</span>
                <span class="business-c1">
                    <a href="<?php echo $output['member_info']['wdUrl'] ?>">查看微店</a>
                </span>
            </p>

            <p class="business-c">
                <span>加入团队：</span>
                <span class="business-c1">
                    <a href="<?php echo urlMember('login','register',['rec'=>hj_encrypt($output['member_info']['member_id'])]) ?>">点击加入</a>
                </span>
            </p>
        </div>
    </div>
