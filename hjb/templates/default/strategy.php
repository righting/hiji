<link rel="stylesheet" href="<?php echo HJB_TEMPLATES_URL; ?>/css/hjb.css" type="text/css"/>

<div class="hjb-raiders-banner">
    <?php foreach($output['top_banner'] as $k=>$v){?>
        <a href="<?php if(!empty($v['img_link'])){echo $v['img_link'];}else echo 'javascript:void(0);'?>"><img src="<?php echo $v['img_url'];?>" class="banner"></a>
    <?php }?>
</div>
<div class="hjb-raiders">
    <div class="hjb-raiders-wrap">
        <div class="hjb-raider-top">
            <div class="hjb-raiders-left">
                <div class="hjb-coin">
                    <img src="<?php echo HJB_TEMPLATES_URL; ?>/images/hjb-coin.png">
                </div>
                <div class="hjb-coin-convert">
                    <h1 class="title">海吉币</h1>
                    <div class="hjb-coin-banner">
                        <img src="<?php echo HJB_TEMPLATES_URL; ?>/images/hjb-convert.png">
                    </div>
                    <ul class="hjb-convert-list">
                        <li>
                            <a href="javascript:">攒惊喜</a>
                        </li>
                        <li>
                            <a href="javascript:">兑礼品</a>
                        </li>
                        <li>
                            <a href="javascript:">拼打赏</a>
                        </li>
                        <li>
                            <a href="javascript:">当钱花</a>
                        </li>
                    </ul>
                    <div class="hjb-left-bottom">
                        <ul>
                            <li><a href=""></a></li>
                            <li><a href=""></a></li>
                            <li><a target="_blank" href="/member/index.php?controller=member&action=userCoins"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="hjb-raider-right">
                <div class="hjb-swear">
                    <p>海吉币是海吉壹佰社交消费融电商、智能生态电商的一种完全个性化的网站特用虚拟货币。绝不是传销、资金盘的坑蒙欺诈的圈钱用所谓的虚拟货币、数字货币、电子货币。</p>
                    <p>
                        海吉币，具有个性在开发潜力和再增值内生活力，是网站的相对性价价值表现符号，目前只在电商虚拟世界中交汇，具有品牌信息功能和文化价值，精神价值，个性价值和无界自由价值指数性。与淘宝的淘金币、京东的钢镚、百度的百度币、亚马逊的亚马逊比相同。在网站电商中具有点赞、打赏、礼物、兑换、促销和积攒人气指数、彰显品牌价值指数和品牌内涵文化精神指数的功能作用，能和“消费积分”并驾齐驱，互为相对性价值，可在网站电商内通兑通换，当钱花，好玩好用好实惠、好省钱的再增值生态通道，生态消费场景作用的体验式虚拟货币、即非真实流通货币！</p>
                </div>
                <div class="hjb-convert-detail">
                    <h1 class="title"><span>海吉币</span><em></em>攻略</h1>
                    <ul>
                        <li>
                            <a href="#hjb-problem">常见问题</a>
                        </li>
                        <li>
                            <a href="#hjb-zan">攒海吉币</a>
                        </li>
                        <li>
                            <a href="#hjb-spend">花海吉币</a>
                        </li>
                    </ul>
                </div>
                <ul id="hjb-problem">
                    <li>
                        <h1 class="title">①海吉币有什么用？</h1>
                        <p>
                            “平台分享阵地”里的知识问答的付费打赏、“直播电商”的礼物打赏、社交和“海吉商圈”里对圈友的点赞打赏；“海吉币活动”和“海吉币兑吧”中兑换商品，参加抽奖活动等；商家积攒人气、提升曝光率；海吉币储存在升值</p>
                    </li>
                    <li>
                        <h1 class="title">②如何攒取海吉币？</h1>
                        <p>
                            “平台分享阵地”里的知识问答的付费打赏、“直播电商”的礼物打赏、社交和“海吉商圈”里对圈友的点赞打赏；“海吉币活动”和“海吉币兑吧”中兑换商品，参加抽奖活动等；商家积攒人气、提升曝光率；海吉币储存在升值</p>
                    </li>
                    <li>
                        <h1 class="title">③海吉币对供应商家有什么好处？</h1>
                        <p>
                            “平台分享阵地”里的知识问答的付费打赏、“直播电商”的礼物打赏、社交和“海吉商圈”里对圈友的点赞打赏；“海吉币活动”和“海吉币兑吧”中兑换商品，参加抽奖活动等；商家积攒人气、提升曝光率；海吉币储存在升值</p>
                    </li>
                    <li>
                        <h1 class="title">④海吉币能买吗？</h1>
                        <p>
                            “平台分享阵地”里的知识问答的付费打赏、“直播电商”的礼物打赏、社交和“海吉商圈”里对圈友的点赞打赏；“海吉币活动”和“海吉币兑吧”中兑换商品，参加抽奖活动等；商家积攒人气、提升曝光率；海吉币储存在升值</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hjb-raider-bottom">
            <ul id="hjb-zan">
                <li>
                    <h2 class="sub-title">签到领取</h2>
                    <p>每日登陆签到领取；</p>
                    <p>日日连续登陆签到领取更多</p>
                </li>
                <li>
                    <h2 class="sub-title">完成任务领取</h2>
                    <p>每日可到任务中心完成任务，即可获取相应海吉币</p>
                </li>
                <li>
                    <h2 class="sub-title">互动玩法</h2>
                    <p>与其他用户互动、点赞、分享、被打赏等均可获得海吉币</p>
                </li>
                <li>
                    <h2 class="sub-title">平台购物</h2>
                    <p>购买商家赠送海吉币的商品即可获取</p>
                </li>
            </ul>
            <ul id="hjb-spend">
                <li>
                    <h2 class="sub-title">海吉币兑吧购物</h2>
                    <p>到海吉币专项兑换购物频道兑换商品，享受不一样的体验。省钱好玩、过吧土豪瘾</p>
                </li>
                <li>
                    <h2 class="sub-title">开通专享频道</h2>
                    <p>抢红包、玩游戏、过家家等专享有好玩的频道</p>
                </li>
                <li>
                    <h2 class="sub-title">海吉币打赏</h2>
                    <p>直播电商、美女直播、知识分享海吉商学院听课、会员社交互动点赞、海吉商圈、线下连实体店也都随时隐活动宜用</p>
                </li>
                <li>
                    <h2 class="sub-title">海吉币活动</h2>
                    <p>参与海吉币活动中的各种刺激好玩的游戏、抽奖、抢红包以小博大、惊喜连连</p>
                </li>
                <li>
                    <h2 class="sub-title">存储增值</h2>
                    <p>越花越有、越存越值化身消费积分拟痛兑换</p>
                </li>
            </ul>
            <div class="hjb-task-center">
                <div class="hjb-task-banner">
                    <img src="<?php echo HJB_TEMPLATES_URL; ?>/images/hjb-task-banner.png">
                </div>
                <ul class="hjb-task-list">
                    <li>
                        <h1 class="title">互动任务</h1>
                        <p>首次开通“直播电商”和知识付费等分享互动应用工具及下载APP积攒</p>
                    </li>
                    <li>
                        <h1 class="title">分享任务</h1>
                        <p>分享网站、微信公众号、海吉商学院等软文及商品到朋友圈积攒</p>
                    </li>
                    <li>
                        <h1 class="title">消费任务</h1>
                        <p>首次购买10元以上众筹定制产品和消费扶贫产品即可获取积攒</p>
                    </li>
                    <li>
                        <h1 class="title">生活任务</h1>
                        <p>购买消费者保护金、第三方支付账户安全险、退款运费管理赔险积攒</p>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>