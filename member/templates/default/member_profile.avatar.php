<div class="essential">
    <div class="essential-nav">
        <?php include template('layout/submenu');?>
    </div>

    <div class="essential-detail">
        <div class="binding">
            <ul>
                <li>
                    <label class="personal16"></label>
                    <span>手机绑定</span>
                    <em>绑定手机后，您即可享受海吉壹佰丰富的手机服务，如找回密码等。</em>
                    <a href="<?php echo urlMember('member_security','auth',['type'=>modify_email]) ?> " class="<?php echo $output['member_info']['member_mobile_bind'] == 1 ? 'on' : '';?>">
                        <?php echo $output['member_info']['member_mobile_bind'] == 1?'已绑定/修改手机':'未绑定/绑定手机';?>
                    </a>
                </li>

                <li>
                    <label class="personal17"></label>
                    <span>邮箱绑定</span>
                    <em>绑定邮箱后，您即可享受海吉壹佰丰富的邮箱服务，如找提示您的异常登入等。</em>
                    <a href="<?php echo urlMember('member_security','auth',['type'=>modify_mobile]) ?>" class="<?php echo $output['member_info']['member_email_bind'] == 1 ? 'on' : '';?>">
                        <?php echo $output['member_info']['member_email_bind'] == 1?'已绑定/修改邮箱':'未绑定/绑定邮箱';?>
                    </a>
                </li>

                <li>
                    <label class="personal18"></label>
                    <span>支付宝绑定</span>
                    <em>绑定支付宝后，您即可享受更多的支付方式，海吉壹 佰将为您提供方便快捷购物体验。</em>
                    <a href="<?php echo urlShop('member','developing') ?>">未绑定/去绑定</a>
                </li>

                <li>
                    <label class="personal19"></label>
                    <span>微博绑定</span>
                    <em>微博是我们重要的联系分享工具，绑定之后，您的朋友即可分享到您购物的喜悦心情。</em>
                    <a href="<?php echo urlShop('member','developing') ?>" class="on">已绑定/查看</a>
                </li>

                <li>
                    <label class="personal20"></label>
                    <span>分享绑定</span>
                    <em>用于把您买到的特别喜爱，特别优惠的东西分享给您的朋友们。</em>
                    <a href="<?php echo urlShop('member','developing') ?>" class="on">已绑定/查看</a>
                </li>
            </ul>
        </div>
    </div>
</div>
