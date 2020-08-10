<link rel="stylesheet" href="<?php echo jf_TEMPLATES_URL;?>/css/integral.css" />

<!-- 焦点图 Begin-->
<div class="bodyer">
    <img src="<?php echo jf_TEMPLATES_URL;?>/images/jfdh-BANNER.jpg"/>
</div>

<style>
    .integral a{
        text-decoration:none;
    }
</style>

<div class="integral">
    <div class="integral-a">
        <h1>大家都在换</h1>
        <ul>
            <?php foreach($output['salenumInfo'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-a1">
                            <img src="<?php echo $v['goods_image'];?>">
                        </div>
                        <p class="integral-a2"><?php echo $v['goods_name'];?></p>
                        <div class="integral-a3">立即兑换</div>
                        <p class="integral-a4">
                            <span>￥<?php echo $v['goods_price'];?></span>
                            <span>+<?php echo $v['goods_integral'];?>积分</span>
                            <?php if($v['goods_hjb'] > 0){?>
                                <span>+<?php echo $v['goods_hjb'];?>海吉币</span>
                            <?php }?>
                        </p>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>

    <div class="integral-c">
        <h1><span>现金 + </span><span>积分少也能换</span></h1>
        <div class="integral-c1">
            <img src="<?php echo jf_TEMPLATES_URL;?>/images/integral.jpg">
        </div>
        <ul>
            <?php foreach($output['moneyDesc'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-c2">
                            <img src="<?php echo $v['goods_image'];?>">
                        </div>
                        <p class="integral-c4"><?php echo $v['goods_name'];?></p>
                        <p class="integral-c3"><?php echo $v['goods_jingle'];?></p>
                        <div class="integral-c5">
                            <p class="integral-c5-a">
                                ￥<?php echo $v['goods_price'];?>  +
                                <?php echo $v['goods_integral'];?> 积分
                            </p>
                            <p class="integral-c5-b">
                                已兑换：<?php echo $v['goods_salenum']?>  剩余：<?php echo $v['goods_storage']?>
                            </p>
                        </div>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>

    <div class="integral-d">
        <h1><span>积分多 </span><span>更划算</span></h1>
        <ul>
            <?php foreach($output['integralDesc'] as $k=>$v){?>
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
                                <span>￥<?php echo $v['goods_price'];?>+</span>
                                <span><?php echo $v['goods_integral'];?> 积分</span>
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

    <div class="integral-d">
        <h1><span>试试 </span><span>其他的</span></h1>
        <div class="integral-e">
            <div class="integral-g">
                <ul>
                    <?php foreach($output['randGoods'] as $k=>$v){?>
                        <?php if($k<2){?>
                        <li>
                            <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                                <div class="integral-e1">
                                    <p class="integral-e1-a"><?php echo $v['goods_name'];?></p>
                                    <p class="integral-e1-b"><?php echo $v['goods_jingle'];?></p>
                                    <p class="integral-e1-c">
                                        <img src="<?php echo jf_TEMPLATES_URL;?>/images/integral2.png">
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
                <?php foreach($output['randGoods'] as $k=>$v){?>
                   <?php if($k>1){?>
                        <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                            <div class="integral-f">
                                <div class="integral-f-a">
                                    <p class="integral-f1">
                                        <?php echo $v['goods_name'];?>
                                    </p>
                                    <p class="integral-f2">
                                        <img src="<?php echo jf_TEMPLATES_URL;?>/images/integral2.png">
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
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/integral3.jpg">
            </div>
        </div>

    </div>

</div>




