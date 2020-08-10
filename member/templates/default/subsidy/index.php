<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_subsidy.css" rel="stylesheet" type="text/css">

<div class="personal-setting">
    <!--<div class="consume-subsidy">
        <ul class="consume-tabs">
            <li class="my-consume-subsidy cur"><i></i><span>我的消费补贴</span></li>
            <li class="consume-raise"><i></i><span>消费养老金</span></li>
            <li class="dream-subsidy"><i></i><span>车房梦想金</span></li>
        </ul>
        <div class="consume-sub"></div>
    </div>-->
    <div class="personal-consume">
        <div class="consume-left">
            <div class="outer">
                <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
            </div>
            <div class="consume-message-id">
                <span><?php echo $output['member_info']['member_nickname'] ?></span>
                <p>ID:<?php echo $output['member_info']['member_number'] ?></p>
            </div>
        </div>
        <div class="consume-mid">
            <ul>
                <li class="vip-level">
                    <span>会员等级</span>

                    <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                    echo "<img src=".$tplImgUrl.">";
                    ?>
                    <em><?php echo $output['member_info']['level_name'] ?></em>
                </li>

                    <li class="group-level">
                        <span>团队职级</span>
                            <?php if($output['member_info']['positions_id']<8){?>
                                <?php
                                $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                                echo "<img src=".$tplImgUrl.">";
                                ?>
                            <?php }?>
                        <em <?php if($output['member_info']['positions_id']==8){ echo "style='padding-left:90px;'" ;}?>><?php echo $output['member_info']['position_name'] ?></em>
                    </li>
            </ul>
        </div>
        <div class="consume-right">
            <a href="javascript:;" data-type="1" nc_type="dialog" dialog_title="消费养老申请" dialog_id="subsidy_yl" uri="<?php echo urlMember('subsidy','getApplyFormAlert',['type'=>1]);?>" dialog_width="550" title="消费养老">消费养老金</a>
            <a href="javascript:;"  data-type="2" nc_type="dialog" dialog_title="车房梦想申请" dialog_id="subsidy_cf" uri="<?php echo urlMember('subsidy','getApplyFormAlert',['type'=>2]);?>" dialog_width="550" title="车房梦想">车房梦想金</a>
        </div>
    </div>
    <div class="consume-pension consume-funds">
        <h3 class="group-top"><i></i>海吉壹佰消费养老金</h3>
        <div class="consume-main">
            <div class="title">
                <span class="pension-bal"><i></i>余额：<em><?php echo (isset($output['new_list'][1]) ? $output['new_list'][1]['total_money'] : 0) ?></em></span>
                <span class="pension-per"><i></i>比例：<em><?php echo (isset($output['new_list'][1]) ? $output['new_list'][1]['proportion'] : 0) ?>%</em></span>
            </div>
            <div class="consume-details pension-details">
                <h4>
                    <span>来源</span>
                    <span>比例</span>
                    <span>余额变更</span>
                    <span>日期</span>
                </h4>
                <ul class="bal-details">
                    <?php foreach($output['bonusCount'] as $k=>$v){?>
                        <?php if($v['type']==21){?>
                            <li class="bal-details-item">
                                <ul>
                                    <li>余额转入</li>
                                    <li><?php echo (isset($output['new_list'][1]) ? $output['new_list'][1]['proportion'] : 0) ?>%</li>
                                    <li><?php echo $v['money']?></li>
                                    <li><?php echo $v['updated_at']?></li>
                                </ul>
                            </li>
                        <?php  } ?>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div class="pensioin-banner">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/pension-banner.jpg">
    </div>
    <div class="dream-funds consume-funds">
        <h3 class="group-top"><i></i>海吉壹佰车房梦想金</h3>
        <div class="consume-main">
            <div class="title">
                <span class="funds-bal"><i></i>余额：<em><?php echo (isset($output['new_list'][2]) ? $output['new_list'][2]['total_money'] : 0) ?></em></span>
                <span class="funds-per"><i></i>比例：<em><?php echo (isset($output['new_list'][2]) ? $output['new_list'][2]['proportion'] : 0) ?>%</em></span>
            </div>
            <div class="consume-details funds-details">
                <h4>
                    <span>来源</span>
                    <span>比例</span>
                    <span>余额变更</span>
                    <span>日期</span>
                </h4>
                <ul class="bal-details">
                    <?php foreach($output['bonusCount'] as $k=>$v){?>
                        <?php if($v['type']==22){?>
                        <li class="bal-details-item">
                            <ul>
                                <li>余额转入</li>
                                <li><?php echo (isset($output['new_list'][2]) ? $output['new_list'][2]['proportion'] : 0) ?>%</li>
                                <li><?php echo $v['money']?></li>
                                <li><?php echo $v['updated_at']?></li>
                            </ul>
                        </li>
                        <?php  } ?>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div class="dream-funds-banner">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/dream-funds-banner.jpg">
    </div>
    <div class="consume-text">
        <div>
            <h4>消费养老金</h4>
            <p>
                消费养老保险金简称消费养老金，是将消费者在平台消费所获得的消费分红利润，部分转化为养老保险金的新型养老保险机制。是一条生生不息、充满内生活力的养老保险体制机制和养老资金新渠道，是应对我国人口老龄化的重要举措，是国务院关于“支持商业保险机构为个人和家庭提供个性化、差异化养老保障”指示精神的落地践行。
            </p>
            <p>
                海吉壹佰会员消费养老保险，是一种普惠性创新保险模式，也是一种普惠性创新消费新模式。整合了消费者、生产者、经营者、保险机构、民政部门、银行金融等多元化多方面资源，具有巨大社会效益，解放了消费，释放了消费能力，拉动了经济发展，促进了保险业改革创新，具有新时代特征。
            </p>
        </div>
        <div>
            <h4>车房梦想金</h4>
            <p>
                每一个人都有自己的梦想。梦想就是目标。不管是短期还是长期的，有个梦想就有个盼头而朝着她去努力一把。给自己定个小目标，比如说先挣它一个亿。万一实现了呢？
            </p>
            <p>
                新版五子登科，就是新时代青年人成家立业的普遍梦想。可别小看这个梦想，这就是人民日益增长日益广泛的美好生活需求。为此，海吉壹佰特设立“车房梦想金”以助力大家去尽早尽快地实现这个梦想。海吉壹佰将以“消费补贴”奖励的形式，根据申请梦想金会员的消费业绩和消费征信，一边是给予5%的平台销售利润的“分红与奖金制度”的梦想金补贴，一边是设立限额标准的征信扶持金。当你的车房梦想标准与你的“车房梦想金”留存金额相匹配和与你的消费征信消费业绩相匹配时，海吉壹佰将按区配评估值给你增值服务和中介担保服务及匹配现金，让您轻松实现梦想。
            </p>
        </div>
        <div>
            <h4>养老金投保</h4>
            <p>
                会员在申请和签订了《海吉壹佰消费养老补贴协议》后，再进行消费并将获得的分红奖金自动设置好分红转移比例到平台你的消费养老保险金账户中，平台每月根据会员自动转移的消费分红奖金额，按该会员等级进行相应的补贴。消费养老保险金及补贴金每积攒满1000元及以上，可进行一次养老金投保提取，会员提取后平台将自动根据会员的提取指令要求，将会员的消费养老保险金一次性追加到会员绑定的社保卡金融账户上。具体金额和进账明细会员可在“个人中心”－“我的消费补贴”中进行查看。追加养老金之后，会员可以自行到自己的社保卡金融账户中查询到账情况。
            </p>
            <p>
                如果已经投保，但是提供的金融账户号、身份证号码、名字等信息有误，导致退回的会员可到当地社保中心确认并修改后再提取。如未退回的会员需自行去当地社保中心处理和解决。
            </p>
        </div>
        <div>
            <h4>梦想金留存</h4>
            <p>
                会员在申请和签订了《海吉壹佰车房梦想金补贴协议》后，再进行消费并将获得的分红奖金自动设置好分红转移比例到平台你的车房梦想金账户中，平台每月根据会员自动转移的消费分红奖金额，按该会员等级进行相应的补贴。车房梦想金及补贴金每积攒满1000元及以上，可进行一次车房梦想金投保提取，会员提取后平台将自动根据会员的提取指令要求，将会员的车房梦想金一次性追加到会员绑定的个人公积金账户上。具体金额和进账明细会员可在“个人中心”－“我的消费补贴”中进行查看。追加车房梦想金之后，会员可以自行到自己的个人公积金账户中查询到账情况。
            </p>
            <p>
                会员提取车房梦想金到个人公积金账户的，会员后期有车房梦想需求的将更统一按公积金的要求进行贷款或支持，平台不再根据会员需求和消费征信进行额外支援。平台额外支援仅限留存在海吉壹佰的公积金会员账户中的，并根据会员的消费征信、会员等级和团队职级等进行评估后给予相应支援。
            </p>
        </div>
        <div>
            <h4>消费公积金</h4>
            <p>
                消费公积金是海吉壹佰消费公积金的简称，不同于住房公积金或消费基金，用途类似于公司法的公司公积金。是海吉壹佰平台的普惠性创新，具有福利性、返还性、普惠性、自愿性。
            </p>
            <p>
                海吉壹佰消费公积金，是指从会员个人收益中自愿提取在平台消费中所产生的消费分红收益，储以备用的部分或全部分红利润资金。是为增值资本用以增强个人消费信用和增信车房梦想金消费或慈善捐赠或以备个人不时之需的个人消费储备资金或个人消费留存收入。
            </p>
            <p>
                海吉壹佰会员消费公积金，经会员申请消费公积金账号，按每月固定等级额度自愿自选留存，等级高则征信高，留存期长则征信强，为充值消费金。
            </p>
        </div>
        <div>
            <h4>公积金留存</h4>
            <p>
                会员在成功申请了海吉壹佰消费公积金账户后，在进行消费时，将获得的分红奖金自动设置好分红转移比例到平台你的海吉壹佰消费公积金账户中，或将您个人获得的消费补贴设置定期转存到海吉壹佰消费公积金账户中，以增强个人消费信用，以备个人不时之需时，能便于评估你的个人征信而获得平台或合作保险机构的额外部分的资金支援。
            </p>
            <p>
                海吉壹佰的消费公积金账户是海吉壹佰平台会员独立持有的类银行卡账户的电子账户，并非银行卡形式。该电子账户仅限于能与合作银行或合作保险机构进行数据对接、共享、平账和资金转移等功能。
            </p>
        </div>
    </div>
</div>