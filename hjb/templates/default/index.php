<link rel="stylesheet" href="<?php echo HJB_TEMPLATES_URL;?>/css/conversion.css" />

<!-- 焦点图 Begin-->
<div class="banner">
    <?php foreach($output['top_banner'] as $k=>$v){?>
            <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>

<div class="integral">
    <div class="conversion-a">
        <div class="conversion-a-b">
            <a href="#">
                <p class="conversion-a1">海吉币攒吧</p>
            </a>
            <a href="#">
                <p class="conversion-a2">海吉币攒吧</p>
            </a>
            <a target="_blank" href="/member/index.php?controller=member&action=userCoins">
                <p class="conversion-a3">我的海吉币</p>
            </a>
        </div>
    </div>

    <div class="integral-a">
        <h1>大家都在换</h1>
        <ul>
            <?php foreach($output['salesInfo'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-a1">
                            <img src="<?php echo $v['goods_image'];?>">
                        </div>
                        <p class="integral-a2"><?php echo $v['goods_name'];?></p>
                        <div class="integral-a3">立即抢购</div>
                        <p class="integral-a4"><span>￥<?php echo $v['goods_price'];?></span><span> + <img src="<?php echo HJB_TEMPLATES_URL;?>/images/conversion2.png"> <?php echo $v['goods_hjb'];?></span></p>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>

<div class="conversion-b">
    <?php foreach($output['one_f_bg_ad'] as $k=>$v){?>
    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>



<div class="integral">
    <div class="integral-c" style="margin-top:10px;">

        <div class="integral-c1">
            <?php foreach($output['one_f_left_ad'] as $k=>$v){?>
                <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
            <?php }?>
        </div>
        <ul>
            <?php foreach($output['hjbExChange'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-c2">
                            <img src="<?php echo $v['goods_image'];?>">
                        </div>
                        <p class="integral-c4"><?php echo $v['goods_name'];?></p>
                        <p class="integral-c3"><?php echo $v['goods_jingle'];?></p>
                        <div class="integral-c5">
                            <p class="integral-c5-a"><?php echo $v['goods_hjb'];?> <img src="<?php echo HJB_TEMPLATES_URL;?>/images/conversion2.png" class="jinbi"></p>
                            <p class="integral-c5-b">
                                已兑换：<?php echo $v['goods_salenum']?>  剩余：<?php echo $v['goods_storage']?>
                            </p>
                        </div>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>




<div class="conversion-c">
    <?php foreach($output['two_f_bg_ad'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>


<div class="integral">
    <div class="integral-d">
        <ul>
            <?php foreach($output['randGoods'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-d1">
                            <div>
                                <img src="<?php echo $v['goods_image'];?>">
                            </div>
                            <p><?php echo $v['goods_name'];?></p>
                        </div>
                        <div class="integral-d2">
                            <p class="integral-d2-a">
                            <span class="integral-d2-a1">
                                <span>￥<?php echo $v['goods_price'];?> +</span>
                                <span><?php echo $v['goods_hjb'];?> <img src="<?php echo HJB_TEMPLATES_URL;?>/images/conversion2.png" class="jinbi"></span>
                            </span>
                            <span class="integral-d2-a2">
                                <span>
                                    <?php
                                    $number = $v['goods_salenum']/($v['goods_storage']+$v['goods_salenum']);
                                    echo '已售 '.number_format($number, 2, '.', '')*100 . '%';
                                    ?>
                                </span>
                                <span class="integral-gun">
                                   <span class="integral-bar" style="width:<?php $number = $v['goods_salenum']/($v['goods_storage']+$v['goods_salenum']);echo number_format($number, 2, '.', '')*100 . '%';?>;">
                                   </span>
                                </span>
                            </span>
                            </p>
                            <p class="integral-d2-b">立即兑换</p>
                        </div>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>

<div class="conversion-c">
    <?php foreach($output['three_f_bg_ad'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>




<div class="integral">
    <div class="integral-d">
        <div class="integral-e">
            <div class="integral-g">
                <ul>
                    <?php foreach($output['randGoodsThree'] as $k=>$v){?>
                    <?php if($k<2){?>
                            <li>
                                <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                                    <div class="integral-e1">
                                        <p class="integral-e1-a"><?php echo $v['goods_name'];?></p>
                                        <p class="integral-e1-b"><?php echo $v['goods_jingle'];?></p>
                                        <p class="integral-e1-c">
                                            <img src="<?php echo HJB_TEMPLATES_URL;?>/images/integral2.png">
                                        </p>
                                    </div>
                                    <div class="integral-e2">
                                        <div class="integral-e2-a">
                                            <img src="<?php echo $v['goods_image'];?>">
                                        </div>
                                        <p><?php echo $v['goods_name'];?></p>
                                    </div>
                                </a>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>

                <?php foreach($output['randGoodsThree'] as $k=>$v){?>
                <?php if($k>1){?>
                        <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                            <div class="integral-f">
                                <div class="integral-f-a">
                                    <p class="integral-f1">
                                        <?php echo $v['goods_name'];?>
                                    </p>
                                    <p class="integral-f2">
                                        <img src="<?php echo HJB_TEMPLATES_URL;?>/images/integral2.png">
                                    </p>
                                </div>

                                <div class="integral-f-b">
                                    <img src="<?php echo $v['goods_image'];?>">
                                </div>
                            </div>
                        </a>
                    <?php }?>
                <?php }?>

            </div>
            <div class="integral-t">
                <?php foreach($output['three_f_right_ad'] as $k=>$v){?>
                    <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
                <?php }?>
            </div>
        </div>

    </div>
</div>



<div class="conversion-c">
    <?php foreach($output['four_f_bg_ad'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>



<div class="integral">
    <div class="conversion-d">
        <ul>
        <?php foreach($output['randGoodsSix'] as $k=>$v){?>
            <li>
                <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                    <div class="conversion-d1">
                        <img src="<?php echo $v['goods_image'];?>">
                    </div>
                    <p class="conversion-d2"><?php echo $v['goods_name'];?></p>
                    <p class="conversion-d3">
                        <img src="<?php echo HJB_TEMPLATES_URL;?>/images/conversion3.png">
                    </p>
                </a>
            </li>
         <?php }?>
        </ul>
    </div>
</div>
<div class="clearfix"></div>







