<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_incentive.css" rel="stylesheet" type="text/css">



<div class="personal-setting">
    <div class="bonus-rules-header">
        <div class="outer">
            <img src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
        </div>
        <div class="bonus-per-id">
            <span><?php echo $output['member_info']['member_nickname'] ?></span>
            <p>ID:<?php echo $output['member_info']['member_number'] ?></p>
        </div>
        <div class="bonus-bal">
            <p>我的账户余额：<em><?php echo ($output['member_info']['available_predeposit'])+($output['member_info']['freeze_predeposit']) ?></em>元</p>
            <p>我的海吉积分：<em>0</em>积分</p>
        </div>
    </div>
    <div class="bonus-banner1">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/bonus-banner_01.jpg">
    </div>

    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="rules-icon"></i>
            <span>分红奖金制度</span>
        </h3>


        <div class="bonus-rules-profits">
            <ul class="rules-title">
                <?php foreach ($output['article_class_list'] as $k=>$type_info){ ?>
                    <li class="<?php if($k == 0){ echo 'rules-title-active'; } ?>">
                        <a href='javascript:;' name="<?php echo $type_info['ac_id'];?>">
                            <?php echo $type_info['ac_name'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="rules-details">
                <h2><?php echo $output['info']['article_title'];?></h2>
                <div class="default">
                    <?php echo $output['info']['article_content'];?>
                </div>
            </div>
            <div class="rules-hint">
                <span>温馨提示：</span>
                <p>1、平台是会员制社交消费生态融电商，旨在促进消费和消费升级，创造真实的社会价值，为消费者参与平台利润分红实现可持续性消费和“双创”升级及创新驱动新零售、新消费模式服务，具有解放消费、解放实体、去传销、去库存的社会责任意义。</p>
                <p>2、会员直推，只向他人或被推荐人推广平台为社交消费电商可在平台免费注册购物消费而获得销售分红，不得向被推荐人强制销售任何产品或收取任何费用。</p>
                <p>3、团队职级晋升中对各职级的条件要求，不做为本人消费分红的计算依据或团队计酬，只作为绩效考核KSF指标分进行评估职级晋升。相关分红与奖项的计算，此KSF指标分为评估分值系数。团队职级越高，则KSF指标分数越高，相对应分红与奖项会越高。</p>
            </div>
        </div>
    </div>

    <div class="bonus-banner2">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/bonus-banner_02.jpg">
    </div>
</div>





<!--<div class="personal-setting">
    <div class="bonus-rules-header">
        <div class="personal-message-left">
            <div class="outer">
                <img src="<?php /*echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); */?>">
            </div>
            <div class="personal-message-id">
                <span><?php /*echo $output['member_info']['member_nickname'] */?></span>
                <p>ID:<?php /*echo $output['member_info']['member_number'] */?></p>
            </div>
        </div>
        <div class="divider"></div>
        <div class="personal-grade-message">
            <ul>
                <li class="vip-level">
                    <span>会员等级</span>
                    <?php
/*                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                    echo "<img src='$tplImgUrl'>";
                    */?>
                    <em><?php /*echo $output['member_info']['level_name'] */?></em>
                </li>
                <li class="group-level">
                    <span>团队职级</span>
                    <?php /*if($output['member_info']['positions_id']<8){*/?>
                    <?php
/*                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                    echo "<img src='$tplImgUrl'>";
                    */?>
                    <?php /*}*/?>
                    <em <?php /*if($output['member_info']['positions_id']==8){ echo "style='margin-left:91px;'";} */?>><?php /*echo $output['member_info']['position_name'] */?></em>
                </li>
            </ul>
        </div>
    </div>
    <div class="bonus-rules-banner">
        <img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/bonus-rules-banner_01.jpg">
    </div>
    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="vip-icon"></i>
            <span>会员身份等级</span>
        </h3>
        <div class="vip-level-all">
            <img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/vip-level-all.png">
        </div>
    </div>
    <div class="bonus-rules-banner1">
        <img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/bonus-rules-banner_02.png">
    </div>




    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="rules-icon"></i>
            <span>规则与权益</span>
        </h3>


        <div class="bonus-rules-profits">
            <ul class="rules-title">
                <?php /*foreach ($output['article_class_list'] as $k=>$type_info){ */?>
                    <li class="<?php /*if($k == 0){ echo 'rules-title-active'; } */?>">
                        <a href='javascript:;' name="<?php /*echo $type_info['ac_id'];*/?>">
                            <?php /*echo $type_info['ac_name'] */?>
                        </a>
                    </li>
                <?php /*} */?>
            </ul>
            <div class="rules-details">
                <h2><?php /*echo $output['info']['article_title'];*/?></h2>
                <div class="default">
                    <?php /*echo $output['info']['article_content'];*/?>
                </div>
            </div>
        </div>


    </div>




    <div class="bonus-rules-banner1">
        <img src="<?php /*echo MEMBER_TEMPLATES_URL; */?>/images/bonus-rules-banner_03.png">
    </div>
    <div class="personal-box">
        <h3 class="personal-box-top">
            <i class="recommend-icon"></i>
            <span>推荐商品</span>
        </h3>
        <ul class="recommend-goods">
            <?php /*$sum = count($output['likeGoods']);
            while (!empty($output['likeGoods'])){
                $data = array_slice($output['likeGoods'],0,4);
                */?>
                <?php /*foreach ($data as $item):*/?>
                        <li>
                            <a href="/shop/index.php?controller=goods&action=index&goods_id=<?php /*echo $item['goods_id'] */?> " target="_blank">
                            <img  src="<?php /*echo $item['goods_image']; */?>" alt="<?php /*echo $item['goods_name']; */?>" title="<?php /*echo $item['goods_name']; */?>">
                            </a>
                        </li>
                <?php /*endforeach; */?>
                <?php /*array_splice($output['likeGoods'],0,4); } */?>
    </div>
</div>-->


<script>
    $('.rules-title').on('click','a',function(e) {
        e.preventDefault();
        var id = this.name;
        var text = $(this).html();
        $('.rules-details h2').html(text);
        $(this).parent().addClass('rules-title-active').siblings().removeClass();
        $.getJSON("<?php echo urlMember('incentive','getArticleInfo') ?>",{ac_id:id},function(data){
            var ruleHtml=data.data;
            $('.rules-details .default').html(ruleHtml);
        })
    })
</script>