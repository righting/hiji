<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_goods.css" rel="stylesheet" type="text/css">
<div class="essential">
    <div class="essential-nav">
        <?php include template('layout/submenu'); if ($output['member_info']['is_distribution'] == 2){?>
        <a class="ncbtn ncbtn-mint" href="index.php?controller=distribution&action=put_off" style="right: 107px;"><i
                    class="icon-money"></i><?php echo $lang['distribution_apply_putoff']?></a>
        <?php } ?>
    </div>
    <?php if ($_SESSION['isauth'] != 1){?>
        <div class="alert"><span class="mr30"><?php echo $lang['distribution_tips'] ?>：
            <strong class="mr5 red" style="font-size: 18px;">你还未完成实名认证，点击<a href="<?php echo urlMember('member_information','detail') ?>">立即认证</a>完成</strong>
        </div>
    <?php } else{?>

    <!--年费抵扣专项商品  -->
        <form action="<?php echo urlMember('distribution','apply') ?>" id="apply" method="post" onsubmit="ajaxpost('apply', '', '', 'onerror')" >
            <input type="hidden" name="form_submit" value="ok" />
            <dl class="bottom">
                <dt>&nbsp;</dt>
                <dd>
                    <label class="submit-border">
                        <input type="submit" class="submit" value="立即开通微店" />
                    </label>
                </dd>
            </dl>
        </form>
    </div>

<!--    <script type="text/javascript">-->
<!--        $(function(){-->
<!--            $('#apply input').on('click', function() {-->
<!--                ajaxpost('apply', '', '', 'onerror');-->
<!--            });-->
<!---->
<!--        });-->
<!--    </script>-->
    <?php } ?>
</div>
