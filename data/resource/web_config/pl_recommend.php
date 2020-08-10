<?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {?>
<?php foreach ($output['code_recommend_list']['code_info'] as $val): ?>
<div class="hot-min">
    <p><?=$val['recommend']['name']?></p>
    <div class="pro-switch">
        <div class="flexslider">
            <ul class="slides">
                <?php $sum = count($val['goods_list']);
                while (!empty($val['goods_list'])){
                    $data = array_slice($val['goods_list'],0,4);
                    ?>
                    <li>
                        <?php foreach ($data as $item):?>
                            <a style="padding: 0px;margin-left: 3px" href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                                <div class="hot-min-img"><img src="<?php echo $item['goods_pic']; ?>" alt="<?php echo $item['goods_name']; ?>"></div>
                                <div class="hot-title" title="<?php echo $item['goods_name']; ?>"><?php echo $item['goods_name']; ?></div>
                                <div class="hot-price"><span>¥</span><em><?php echo $item['goods_price']; ?></em></div>
                            </a>
                        <?php endforeach; ?>
                    </li>
                    <?php array_splice($val['goods_list'],0,4); } ?>
            </ul>
            <script type="text/javascript">
                $(function() {
                    $('.flexslider').flexslider({
                        animation: "slide",
                        start: function(slider) {
                            $('body').removeClass('loading');
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
<?php endforeach; } ?>
