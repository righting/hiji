<link rel="stylesheet" href="<?php echo jf_TEMPLATES_URL;?>/css/integral.css" />



<!-- 焦点图 Begin-->
<div class="banner">
    <img src="<?php echo HJB_TEMPLATES_URL;?>/images/hjb_dh_01.jpg">
</div>

<style>
    .integral a{
        text-decoration:none;
    }

    .integral-a ul {
        overflow: hidden;
        margin-left: -3px;
    }

    .integral-a {
        width: 100%;
        margin-bottom: 20px;
        margin-top: 10px;
        overflow: hidden;
    }

    .integral-a ul>li {
        float: left;
        width: 235px;
        height: 294px;
        border: 1px solid #979b9e;
        margin-left: 3px;
        margin-top: 5px;
    }


</style>

<div class="integral">
    <div class="integral-a" style="height:auto;">
        <h1>我能兑换</h1>
        <ul>
            <?php foreach($output['info'] as $k=>$v){?>
                <li>
                    <a href="<?php echo urlJf('goods','index',array('id'=>$v['goods_id']))?>" target="_blank">
                        <div class="integral-a1">
                            <img src="<?php echo $v['goods_image'];?>">
                        </div>
                        <p class="integral-a2"><?php echo $v['goods_name'];?></p>
                        <div class="integral-a3">立即兑换</div>
                        <p class="integral-a4">
                            <span>￥<?php echo $v['goods_price'];?></span>
                            <span>+<?php echo $v['goods_hjb'];?>海吉币</span>
                        </p>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>



