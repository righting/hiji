<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/member_article.css" rel="stylesheet" type="text/css">
<div class="personal-setting">
    <div class="personal-setting-message">
        <div class="personal-setting-message-top">
            <div class="personal-message">
                <label>
                    <img style="height: 65px;width: 65px; border-radius:32px;" src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
                </label>
                <span>
                        <?php
                        $h=date("H");
                        if($h<11) echo "早上好!";
                        else if($h<13) echo "中午好！";
                        else if($h<18) echo "下午好！";
                        else echo "晚上好！";
                        ?>
                    <i>(<?php echo $output['member_info']['member_nickname'] ?> )</i>
                    </span>
                <?php if($output['member_info']['level_id'] != 7){ ?>
                    <em>会员ID：<?php echo $output['member_info']['member_number'] ?></em>
                <?php } ?>
            </div>



            <div class="personal-vip-level personal-level">
                <?php
                $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                echo "<img style='width:40px;' src='$tplImgUrl'>";
                ?>
                <span><?php echo $output['member_info']['level_name'] ?></span>
            </div>

            <?php if($output['member_info']['positions_id']<8){?>
            <div class="personal-team-level personal-level" style="width:121px;">
                <?php
                $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                echo "<img style='width:40px;' src='$tplImgUrl'>";
                ?>
                <span><?php echo $output['posit_info']['title'] ?></span>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="personal-banner-1">
        <a href="#"><img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/vip-banner_01.jpg"></a>
    </div>
    <div class="members-level level-same">
        <div class="level-top">
            <i></i>
            <span>会员等级与规则</span>
        </div>
        <div class="level-bottom">
            <div>
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/new-vip-level_01.png">
            </div>
        </div>
    </div>
    <div class="team-level level-same">
        <div class="level-top">
            <i></i>
            <span>团队职级与规划</span>
        </div>
        <div class="level-bottom-2">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/new-vip-level_02.png">
        </div>
    </div>
    <div class="personal-banner-2">
        <a href="#"><img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/vip-banner_02.jpg"></a>
    </div>
    <div class="profit-intro">
        <div class="profit-intro-top level-top">
            <i></i>
            <span>会员权益介绍</span>
        </div>
        <div class="profit-intro-bottom">
            <ul>
                <li>
                    <h5>利润分红</h5>
                    <p>十三项分红奖金，每项都分别与会员等级、个人消费、月低保消费（月保底消费）有关，开启了消费者（会员）参与企业利润分红新纪元。用日常消费的钱赚钱和人脉变现，将越花越有。</p>
                </li>
                <li>
                    <h5>消费补奖</h5>
                    <p>会员只要申请通过完善资料都能获得“车房梦想金”和“消费养老保险金”的消费奖补。是平台会员最实在的公益和普惠奖补，是“会员自己的电商”的赋能奖。</p>
                </li>
                <li>
                    <h5>专享服务</h5>
                    <p>绿色菜篮子的健康专享；平台各项重大活动的特邀专享。</p>
                </li>
                <li>
                    <h5>线下体验</h5>
                    <p>平台线下“海吉壹佰智能便利店”和“海吉商圈”线下商铺的贵宾消费体验和分红，平台线下实体“生态康养院”、“农耕文化园”、三品一标基地等多项特享体验。</p>
                </li>
                <li>
                    <h5>海吉币</h5>
                    <p>登录、分享、上传、购物、做任务、参与活动等攒取海吉币，“打赏”“点赞”“知识付费”等社交分享、互动赋能的“随手礼”，及在“海吉兑吧”中兑换特优商品</p>
                </li>
                <li>
                    <h5>海吉积分</h5>
                    <p>消费积分。会员自主升级时赠送和日常消费购物时赠送，是消费利润分红的表现和额外奖补，当钱花，可累计自动升级、可在“积分商城”兑换商品。</p>
                </li>
                <li>
                    <h5>分红Hi值</h5>
                    <p>会员自主升级时等值等额或配比配送，与获消费利润分红时的分红奖励制度的核算公式关联，可有限与现金交换，相对而言分红Hi值越多越高则获分红越多。</p>
                </li>
                <li>
                    <h5>贡献值</h5>
                    <p>给对平台做出贡献和每月消费极大及平台“超级会员”的特别奖励。在高级高层会员专为平台“股东商”时的资格评审的重要赋能KSF指标。</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="vip-favorite">
        <div class="vip-favorite-top level-top">
            <i></i>
            <span>会员最爱买</span>
        </div>
        <div class="vip-favorite-bottom">
            <?php $sum = count($output['likeGoods']);
            while (!empty($output['likeGoods'])){
                $data = array_slice($output['likeGoods'],0,4);
                ?>
                <?php foreach ($data as $item):?>
                    <a style="padding: 0px;margin-left: 3px" href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                        <div>
                            <img style="width:174px;height:220px;" src="<?php echo $item['goods_image']; ?>" alt="<?php echo $item['goods_name']; ?>" title="<?php echo $item['goods_name']; ?>">
                        </div>
                    </a>
                <?php endforeach; ?>
                <?php array_splice($output['likeGoods'],0,4); } ?>
        </div>
    </div>
</div>

