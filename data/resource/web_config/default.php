<div class="floor-layout style-<?php echo $output['style_name']; ?>" id="<?php echo $output['style_name']; ?>">
    <div class="floor-left wrapper">
        <div class="title">
            <?php if ($output['code_tit']['code_info']['type'] == 'txt') { ?>
                <div class="txt-type">

                    <?php if (!empty($output['code_tit']['code_info']['floor'])) { ?>
                        <span><?php echo $output['code_tit']['code_info']['floor']; ?></span>
                    <?php } ?>
                    <h2 title="<?php echo $output['code_tit']['code_info']['title']; ?>">

                        <?php echo $output['code_tit']['code_info']['title']; ?>
                    </h2>
                </div>
            <?php } else { ?>

            <?php } ?>
        </div>
        <div class="recommend-classes">
            <ul>
                <?php if (is_array($output['code_category_list']['code_info']['goods_class']) && !empty($output['code_category_list']['code_info']['goods_class'])) {$i = 0 ?>
                    <?php foreach ($output['code_category_list']['code_info']['goods_class'] as $k => $v) {$i++ ?>
                        <li>
                            <a href="<?php echo urlShop('search', 'index', array('cate_id' => $v['gc_id'])); ?>" title="<?php echo $v['gc_name']; ?>" target="_blank" <?php if ($i == '1' || $i == '4' || $i == '7') { ?> class="on"<?php } ?>><?php echo $v['gc_name']; ?></a>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
        <div class="right-side-focus">
            <ul style="left: -200px; width: 1000px;">

                <?php if (is_array($output['code_adv']['code_info']) && !empty($output['code_adv']['code_info'])) { ?>
                    <?php foreach ($output['code_adv']['code_info'] as $key => $val) { ?>
                        <?php if (is_array($val) && !empty($val)) { ?>
                            <li>
                                <a href="<?php echo $val['pic_url']; ?>" title="<?php echo $val['pic_name']; ?>" target="_blank">
                                    <img src="<?php echo $val['pic_img']; ?>" alt="<?php echo $val['pic_name']; ?>">
                                </a>
                            </li>
                        <?php }
                    }
                } ?>
            </ul>
        </div>
    </div>
    <div class="floor-right">
        <div class="title">
            <ul>
                <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
                    $i = 0; ?>
                    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
                        $i++; ?>
                        <li class="tab-item <?php echo $i == 1 ? 'tabs-selected' : ''; ?>"><a href="javascript:;"><?php echo $val['recommend']['name']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>



        <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
            $i = 0; ?>
            <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
                $i++; ?>
                <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>

                    <div class="floor-style03 tabs"  style="display: <?php echo $i == 1 ? 'block' : 'none'; ?>;">
                        <div class="goods">
                            <ul>
                                <?php foreach ($val['goods_list'] as $k => $v) { ?>
                                    <li>
                                        <dl>
                                            <dt class="goods-name">
                                                <a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>" title="<?php echo $v['goods_name']; ?>">
                                                    <?php echo $v['goods_name']; ?>
                                                </a>
                                            </dt>
                                            <dd class="goods-thumb">
                                                <a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>">
                                                    <img src="<?php echo $v['goods_pic']; ?>" alt="<?php echo $v['goods_name']; ?>">
                                                </a>
                                            </dd>
                                            <dd class="goods-price"><em><?php echo ncPriceFormatForList($v['goods_price']); ?></em>
                                                <span class="original"><?php echo ncPriceFormatForList($v['market_price']); ?></span></dd>
                                        </dl>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                    <div class="floor-style02 tabs"  style="display: <?php echo $i == 1 ? 'block' : 'none'; ?>;">

                        <div class="img-goods">
                            <ul>
                                <?php foreach ($val['pic_list'] as $pic_k => $pic_v) { ?>
                                    <li class="li01">
                                        <a href="javascript:void(0)" title="">
                                            <img src="<?php echo $pic_v['pic_img']; ?>" alt="<?php echo $pic_v['pic_name']; ?>">
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div>
                <?php }
            }
        } ?>

    </div>
    <?php if (!empty($output['code_brand_list']['code_info']) && is_array($output['code_brand_list']['code_info'])) {
        $k = 0; ?>
        <div class="brands">
            <ul>

                <?php foreach ($output['code_brand_list']['code_info'] as $key => $val) {
                    $k++; ?>
                    <?php if ($k < 11) { ?>
                        <li>
                            <a href="<?php echo urlShop('brand', 'list', array('brand' => $val['brand_id'])); ?>" title="<?php echo $val['brand_name']; ?>" target="_blank">
                                <img src="<?php echo $val['brand_pic']; ?>" alt="<?php echo $val['brand_name']; ?>"></a>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
    <?php } ?>
</div>