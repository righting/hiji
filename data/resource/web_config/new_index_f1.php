<link href="/shop/templates/default/css/banner.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/data/resource/js/TY_banner1.js"></script>
<div class="hot">
    <div class="hot-top">
        <span><?php echo $output['code_tit']['code_info']['floor']; ?></span>
        <em><?php echo $output['code_tit']['code_info']['title']?></em>
        <a href="/shop/index.php?controller=category&action=index">查看更多</a>
    </div>
    <div class="hot-bottom">
        <div class="hot-bottom-nav">
            <ul>
                <?php if (is_array($output['code_category_list']['code_info']['goods_class']) && !empty($output['code_category_list']['code_info']['goods_class'])) {$i = 0 ?>
                <?php foreach ($output['code_category_list']['code_info']['goods_class'] as $k => $v) {$i++ ?>
                    <li class="icon<?php echo $i ?>" >
                        <a href="/shop/index.php?controller=cate&action=index&cate_id=<?php echo $v['gc_id'] ?>" ><?php echo $v['gc_name']  ?></a>
                    </li>
                <?php }}?>
            </ul>
        </div>
        <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
        $i = 0; ?>
        <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
        $i++; ?>
        <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
        <div class="hot-min">
            <div class="pro-switch">
                <div class="flexslider">
                    <ul class="slides">
                        <?php $sum = count($val['goods_list']);
                        while (!empty($val['goods_list'])){
                           $data = array_slice($val['goods_list'],0,4);
                        ?>
                        <li>
                            <?php foreach ($data as $item):?>
                            <a href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                                <div class="hot-min-img"><img src="<?php echo $item['goods_pic']; ?>" alt="<?php echo $item['goods_name']; ?>"></div>
                                <div class="hot-title" title="<?php echo $item['goods_name']; ?>"><?php echo $item['goods_name']; ?></div>
                                <div class="hot-price"><span>¥</span><em><?php echo $item['market_price']; ?></em></div>
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
        <?php }elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
        <div class="hot-max">
            <ul>
               <?php foreach ($val['pic_list'] as $pic_k => $pic_v) : ?>
                <li>
                    <a href="<?php echo $pic_v['pic_url'] ?>">
                        <div class="hot-max-img"><img src="<?php echo  $pic_v['pic_img']; ?>" alt="<?php echo $pic_v['pic_name']; ?>"></div>
                        <div class="hot-title" title="<?php echo  $pic_v['pic_sname']; ?>"><?php echo  $pic_v['pic_sname']; ?></div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
            <?php }
        }
    } ?>
    </div>
</div>