<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<div class="wrap_nav">
    <div class="ification_top">
        <h2><?php echo $output['code_tit']['code_info']['title'] ?></h2>
        <ul class="list-tab">
            <?php foreach ($output['code_recommend_list']['code_info'] as $key=>$value){ ?>
                <li><a href="javascript:;"><?php echo $value['recommend']['name'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="ification_content">
        <dl>
            <dt>
                <a href="<?php echo $output['code_adv']['code_info'][1]['pic_url'] ?>" class="hover_origin">
                    <img src="<?php echo $output['code_adv']['code_info'][1]['pic_img'] ?>" width="220" height="570">
                    <div class="hover_top"></div>
                </a>
            </dt>

            <span class="slider_1">
                <?php foreach ($output['code_recommend_list']['code_info'] as $value){ ?>
                    <span>
                        <?php foreach ($value['goods_list'] as $goods_info){ ?>
                            <dd>
                            <a href="<?php echo urlShop('goods','index',array('goods_id'=> $goods_info['goods_id'])); ?>" class="hover_origin">
                                <img src="<?php echo $goods_info['goods_pic']; ?>" width="225" height="220">
                                <p><?php echo $goods_info['goods_name']; ?></p>
                                <p><span>¥<?php echo $goods_info['goods_price']; ?></span></p>
                                <div class="hover_top"></div>
                            </a>
                        </dd>
                        <?php } ?>
                    </span>
                <?php } ?>
            </span>
        </dl>
    </div>
</div>