<div class="tower">
    <div class="tower-top">
        <span><?php echo $output['code_tit']['code_info']['floor']; ?></span>
        <b> <?php $arrs = explode('/',$output['code_tit']['code_info']['title']); echo $arrs[0] ; ?>/</b>
        <em><?php echo $arrs[1] ?></em>
    </div>

    <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
    $i = 0; ?>
    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
    $i++; ?>
    <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
    <div class="tower-bottom">
        <ul>
            <?php foreach ($val['goods_list'] as $k => $v) :?>
                <li><a href="">
                        <div class="tower-bottom-img"><img src="<?php echo $v['goods_pic'] ?>"></div>
                        <div class="tower-bottom-title"><?php echo $v['goods_name'] ?></div>
                        <div class="tower-bottom-text">
                            <div class="tower-bottom-price">
                                <span>￥</span><?php echo $v['goods_price']?>
                            </div>
                            <div class="tower-bottom-lr">
                                <span>￥<?php echo $v['market_price']?></span>
                                <em>已售出<?php echo $v['goods_salenum'] ?>件</em>
                            </div>
                        </div></a>
                </li>
            <?php endforeach;?>
        </ul>
        <a href="" class="tower-button">查看更多</a>
    </div>
    <?php }}}?>
</div>