<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/ht_style.css" rel="stylesheet" type="text/css">
<div class="htzc">
    <div class="htzc-banner" style="background: url(<?=$output['code_tit']['code_info']['pic'];?>) no-repeat center; height: 760px;"></div>
    <?php $data = array_shift($output['code_recommend_list']['code_info']); ?>
    <?php if (!empty($data)){$titArrs = explode('/',$data['recommend']['name'])?>
    <div class="htzc-hl">
        <h3><?=$titArrs[0]?></h3>
        <h4><?=$titArrs[1]?></h4>
        <?php if (!empty($data['pic_list']) && is_array($data['pic_list'])) {?>
        <ul>
            <?php foreach ($data['pic_list'] as $pic): ?>
            <li>
                <div class="htzc-xl-img"><a href="<?=$pic['pic_url'];?>"><img src="<?=$pic['pic_img'];?>"></a></div>
                <div class="htzc-xl-title"><?=$pic['pic_name'];?></div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    <?php $data = array_shift($output['code_recommend_list']['code_info']); ?>
    <?php if (!empty($data)){$titArrs = explode('/',$data['recommend']['name'])?>
    <div class="htzc-xl">
        <h3><?=$titArrs[0]?></h3>
        <h4><?=$titArrs[1]?></h4>
        <?php if (!empty($data['goods_list']) && is_array($data['goods_list'])) {?>
        <ul>
            <?php foreach ($data['goods_list'] as $goods): ?>
            <li>
                <div class="htzc-xl-img"><img src="<?=$goods['goods_pic'];?>"></div>
                <div class="htzc-xl-title"><?=$goods['goods_name'];?></div>
                <div class="htzc-xl-price">
                    <span>市场价:<?=$goods['market_price'];?>  </span>
                    <label>商城价:<em> ¥<b><?=$goods['goods_price'];?></b></em></label>
                </div>
                <div class="htzc-xl-bottom">
                    <a href="index.php?controller=goods&action=index&goods_id=<?=$goods['goods_id'];?>">立即购买</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    <?php $data = array_shift($output['code_recommend_list']['code_info']); ?>
    <?php if (!empty($data)){$titArrs = explode('/',$data['recommend']['name'])?>
    <div class="htzc-xp">
        <h3><?=$titArrs[0]?></h3>
        <h4><?=$titArrs[1]?></h4>
        <?php if (!empty($data['goods_list']) && is_array($data['goods_list'])) {?>
        <ul>
            <?php foreach ($data['goods_list'] as $goods): ?>
            <li>
                <div class="htzc-xp-img"><img src="<?=$goods['goods_pic'];?>"></div>
                <div class="htzc-xp-bottom">
                    <div class="htzc-xp-title"><?=$goods['goods_name'];?></div>
                    <?php $priceArrs = explode('.',$goods['goods_price'])?>
                    <label>活动价:<span> ¥<em><?=$priceArrs[0];?></em>.<?=$priceArrs[1];?></span></label>
                    <a href="index.php?controller=goods&action=index&goods_id=<?=$goods['goods_id'];?>">点击抢购</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php } ?>
        <a href="index.php?controller=cate&action=index&cate_id=1068" class="htzc-xp-more">查看更多</a>

        <a href="javascript:scroll(0,0)" class="htzc-xp-hh"></a>
    </div>
    <?php } ?>
</div>
