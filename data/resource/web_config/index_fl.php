<?php if (!empty($output['code_adv'])){?>
<!-- 弹窗广告 Begin-->
<script src="/shop/templates/default/js/alert_adv/layer.js"></script>
<link href="/shop/templates/default/css/home_index/alert_adv/alert.css" type="text/css" rel="stylesheet">

<div class="alert_adv_layer">
    <div class="alert_adv_layer_cont" style="display:none;">
        <div class="alert_adv_layer_close">Close</div>

        <div class="alert_adv_layer_btn">
            <ul>
                <div class="king_logo"><img src="/shop/templates/default/images/home_index/xlogo.png"></div>
                <?php if (is_array($output['code_adv']['code_info'])){
                    foreach ($output['code_adv']['code_info'] as $item):?>
                        <li><a href="<?php echo $item['pic_url'] ; ?>"><?php echo $item['pic_name'] ; ?></a></li>
                    <?php endforeach; } ?>
            </ul>
        </div>
        <div class="alert_adv_layer_content">
            <ul>
                <?php if (is_array($output['code_adv']['code_info'])){
                    foreach ($output['code_adv']['code_info'] as $item):?>
                        <li><a href="<?php echo $item['pic_url'] ; ?>" target="_blank"><img src="<?php echo $item['pic_img'] ; ?>" /></a></li>
                    <?php endforeach; } ?>
            </ul>
        </div>
    </div>
</div>
<script src="/shop/templates/default/js/alert_adv/index.js"></script>
    <!-- 弹窗广告 End-->
<?php } ?>
