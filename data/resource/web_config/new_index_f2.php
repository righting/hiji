<div class="stride">
    <div class="stride-top">
        <span><?php echo $output['code_tit']['code_info']['floor']; ?></span>
        <em><?php echo $output['code_tit']['code_info']['title']; ?></em>
        <a href="/shop/index.php?controller=cate&action=index&cate_id=1057">查看更多</a>
    </div>
    <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
    $i = 0; ?>
    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
    $i++; ?>
    <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
    <ul>
       <?php foreach ($val['goods_list'] as $k => $v) :?>
        <li>
            <a href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo  $v['goods_id']; ?>">
                <div class="stride-img"><img src="<?php echo $v['goods_pic'] ?>"></div>
                <div class="hot-title" title="<?php echo $v['goods_name'] ?>"><?php echo $v['goods_name'] ?></div>
                <div class="hot-price"><span></span><em><?php echo ncPriceFormatForList($v['goods_price']); ?></em></div>
            </a>
        </li>
       <?php endforeach;?>
    </ul>
   <?php }}}?>
</div>