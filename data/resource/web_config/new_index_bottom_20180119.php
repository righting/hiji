<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
    <div class="guess1">
        <div class="gg">
            <a href="<?php echo $output['lists'][16]['code_info_arr']['url'] ?>">
                <img src="<?php echo $output['lists'][16]['code_info_arr']['pic'] ?>">
            </a>
        </div>
    </div>
    <div class="line-lb">
        <ul>
            <?php if(!empty($output['goods_list'])){ ?>
                <?php foreach($output['goods_list'] as $goods_info){ ?>
                    <li>
                        <a href="<?php echo urlShop('goods','index',['goods_id'=>$goods_info['goods_id']]);?>">
                            <div class="line-lb-img"><img src="<?php echo $goods_info['goods_image'];?>">
                            </div>
                            <div class="line-lb-text"><?php echo $goods_info['goods_name'];?></div>
                            <div class="line-lb-price">¥<?php echo $goods_info['goods_price'];?></div>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
