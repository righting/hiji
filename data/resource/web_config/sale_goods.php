<?php if (!empty($output['code_sale_list']['code_info']) && is_array($output['code_sale_list']['code_info'])) { ?>
<?php $i=1; foreach ($output['code_sale_list']['code_info'] as $k=>$val ):?>
        <div class="floor">
            <div class="floor-top">
                <span><?php echo $i+2 ?>F</span>
                <em title="<?php echo $val['recommend']['name']; ?>"><?php echo $val['recommend']['name']; ?></em>
                <a href="<?php echo  $val['recommend']['url']?>" target="_blank">查看更多</a>
            </div>
         <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) {?>
            <div class="floor-bottom <?php if ($i%2==0) echo 'on'?>">
                <div class="floor-left">
                    <img src="<?php echo  $val['recommend']['pic']?>" alt="<?php echo  $val['recommend']['title']?>">
                    <div class="floor-grab ys<?=$i?>">
                        <span title="<?php echo  $val['recommend']['title']?>"><?php echo  $val['recommend']['title']?></span>
                        <em><?php echo  $val['recommend']['subhead1']?></em>
                        <a href="<?php echo  $val['recommend']['url']?>"><?php echo  $val['recommend']['subhead2']?></a>
                    </div>
                </div>
                <div class="floor-right">
                    <ul>
                     <?php foreach ($val['goods_list'] as $k => $v) :?>
                        <li>
                            <a href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $v['goods_id'] ?>">
                                <div class="floor-img"><img src="<?php echo $v['goods_pic'];?>" alt="<?php echo $v['goods_name'] ?>"></div>
                                <div class="hot-title" title="<?php echo $v['goods_name'] ?>"><?php echo $v['goods_name'] ?></div>
                                <div class="hot-price"><span>￥</span><em><?php echo intval($v['goods_price']); ?></em></div>
                            </a>
                        </li>
                     <?php endforeach; ?>
                    </ul>
                </div>
            </div>
         <?php } ?>
        </div>
    <?php $i++; endforeach;?>
<?php } ?>