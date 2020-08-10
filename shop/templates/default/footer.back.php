<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<script language="javascript">
    function fade() {
        $("img[rel='lazy']").each(function () {
            var $scroTop = $(this).offset();
            if ($scroTop.top <= $(window).scrollTop() + $(window).height()) {
                $(this).hide();
                $(this).attr("src", $(this).attr("ccynet-url"));
                $(this).removeAttr("rel");
                $(this).removeAttr("name");
                $(this).fadeIn(500);
            }
        });
    }

    if ($("img[rel='lazy']").length > 0) {
        $(window).scroll(function () {
            fade();
        });
    }
    ;
    fade();
</script><?php /*echo getChat($layout); */?>

<link href="/chat/templates/default/css/chat.css" rel="stylesheet" type="text/css">

<!--
<div id="web_chat_dialog" style="float: right;">
    <div class="chat-box">
        <div class="chat-list" style="display: block;">
            <div class="chat-list-top"><h1><i></i>联系人</h1><span class="minimize-chat-list"></span></div>
            <div id="chat_user_list" class="chat-list-content ps-container">
                <div>
                    <dl id="chat_user_friends">
                        <dt onclick="chat_show_user_list('friends');"><span class="show"></span>我的好友</dt>
                        <dd u_id="2" style="display: block;" class="begin-chat">
                            <span class="user-avatar">
                                <img alt="personal" src="<?php /*echo getMemberAvatarForID(2);*/?>">
                                <i class="offline"></i>
                            </span>
                            <h5>personal</h5>
                            <a href="javascript:void(0)"></a>
                        </dd>
                    </dl>
                    <dl id="chat_user_recent">
                        <dt><span class="show"></span>最近联系人</dt>
                        <dd id="chat_recent" style="display: none;"></dd>
                    </dl>
                </div>
                <div class="ps-scrollbar-x-rail" style="width: 178px; display: none; left: 0px; bottom: 3px;">
                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps-scrollbar-y-rail" style="top: 0px; height: 420px; display: none; right: 3px;">
                    <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="new_msg_dialog" class="msg-windows" style="display: none;">
    <div class="user-tab-bar">
        <ul class="user-list" id="user_list"></ul>
    </div>
    <div class="msg-dialog">
        <div class="dialog-body">
            <div class="msg-top">
                <dl class="user-info">
                    <dt class="user-name"></dt>
                    <dd class="user-avatar avatar-0"><img src="" alt=""></dd>
                    <dd class="store-name"></dd>
                </dl>
                <span class="dialog-close">&nbsp;</span></div>
            <div id="msg_list" class="msg-contnet">
                <div id="user_msg_list"></div>
            </div>
            <div class="msg-input-box">
                <div class="msg-input-title">
                    <a id="chat_show_smilies" href="javascript:void(0)" class="chat_smiles">表情</a>
                    <span class="title">输入聊天信息</span>
                    <span class="chat-log-btn off">聊天记录<i></i></span>
                </div>
                <form id="msg_form" >
                    <textarea name="send_message" id="send_message" class="textarea"></textarea>
                    <div class="msg-bottom">
                        <div id="msg_count"></div>
                        <a href="JavaScript:void(0);"  class="msg-button"><i></i>发送消息</a>
                        <div id="send_alert"></div>
                    </div>
                </form>
            </div>
        </div>
        <div id="dialog_chat_log" class="dialog_chat_log"></div>
        <div id="dialog_right_clear" class="dialog_right_clear"></div>
    </div>
    <div id="dialog_clear" class="dialog_clear"></div>
</div>
<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>

-->



<script src="/chat/templates/default/chat.js"></script>

<div class="ccy-footer">
    <div id="cti" class="wrapper">
        <ul><?php if ($output['contract_list']) { ?>
                <?php foreach ($output['contract_list'] as $k => $v) { ?>
                    <?php if ($v['cti_descurl']) { ?>
                        <li>
                            <a href="<?php echo $v['cti_descurl']; ?>" target="_blank">
                                <span class="icon">
                                    <img style="width: 60px;" src="<?php echo $v['cti_icon_url_60']; ?>"/>
                                </span>
                                <span class="name"> <?php echo $v['cti_name']; ?> </span>
                            </a>
                        </li>
            <?php } else { ?>
                        <li>
                        <span class="icon"> <img style="width: 60px;" src="<?php echo $v['cti_icon_url_60']; ?>"/> </span>
                        <span class="name"> <?php echo $v['cti_name']; ?> </span>
                        </li><?php }
                }
        } ?>
            <li class="rf">客服电话：<em class="red"><?php echo $output['setting_config']['ccynet_phone']; ?></em>
                <em class="rgb9"><?php echo $output['setting_config']['ccynet_time']; ?></em>
            </li>
        </ul>
    </div>
    <div id="faq">
        <div class="wrapper"><?php if (is_array($output['article_list']) && !empty($output['article_list'])) { ?>
                <ul><?php foreach ($output['article_list'] as $k => $article_class) { ?><?php if (!empty($article_class)) { ?>
                    <li>
                    <dl class="s<?php echo '' . $k + 1; ?>">
                        <dt><?php if (is_array($article_class['class'])) echo $article_class['class']['ac_name']; ?></dt><?php if (is_array($article_class['list']) && !empty($article_class['list'])) { ?><?php foreach ($article_class['list'] as $article) { ?>
                            <dd>
                            <a href="<?php if ($article['article_url'] != '') echo $article['article_url']; else echo urlMember('article', 'show', array('article_id' => $article['article_id'])); ?>"
                               title="<?php echo $article['article_title']; ?>"> <?php echo $article['article_title']; ?> </a>
                            </dd><?php }
                        } ?></dl></li><?php }
                } ?>
                <li class="cooperation">
                <dl>
                    <dt>商家合作</dt>
                    <dd><p>错过天猫？别再错过我们！</p>
                        <p>海吉壹佰开启全新旅程！</p><a href="<?php echo urlShop('show_joinin', 'index'); ?>" class="btn"
                                             target="_blank"><span>关于入驻</span>&gt;</a></dd>
                </dl></li></ul><?php } ?></div>
    </div>
    <div id="footer">
        <div class="wrapper">
            <div class="screen clearfix">
                <div class="fl right-flag"><a href="http://www.ccynet.cn/" target="_blank" rel="nofollow"><img
                                src="<?php echo SHOP_SITE_URL; ?>/img/credit-flag3.png"></a><a
                            href="http://www.ccynet.cn//" target="_blank" rel="nofollow"><img
                                src="<?php echo SHOP_SITE_URL; ?>/img/isc2.png"></a></div>
                <div class="fl about-us"><p><a
                                href="<?php echo SHOP_SITE_URL; ?>">返回首页</a><?php if (!empty($output['nav_list']) && is_array($output['nav_list'])) { ?><?php foreach ($output['nav_list'] as $nav) { ?><?php if ($nav['nav_location'] == '2') { ?>
                            <span>|</span>
                            <a  <?php if ($nav['nav_new_open']){ ?>target="_blank" <?php } ?>href="<?php switch ($nav['nav_type']) {
                                case '0':
                                    echo $nav['nav_url'];
                                    break;
                                case '1':
                                    echo urlShop('search', 'index', array('cate_id' => $nav['item_id']));
                                    break;
                                case '2':
                                    echo urlMember('article', 'article', array('ac_id' => $nav['item_id']));
                                    break;
                                case '3':
                                    echo urlShop('activity', 'index', array('activity_id' => $nav['item_id']));
                                    break;
                            } ?>"><?php echo $nav['nav_title']; ?></a><?php }
                        }
                        } ?><span>|</span><a href="<?php echo urlshop('link'); ?>">友情链接</a></p>
                    <p>CopyRight © 2007-2016 海吉壹佰 <a href="http://www.miibeian.gov.cn/" target="_blank" mxf="sqde"
                                                          style="color:#666"><?php echo $output['setting_config']['icp_number']; ?></a>
                        NewPower Co. 版权所有</p>
                    <p><?php echo html_entity_decode($output['setting_config']['statistics_code'], ENT_QUOTES); ?></p>
                </div>
            </div>
            <?php if (C('debug') == 1) { ?>
                <div id="think_page_trace" class="trace">
                <fieldset id="querybox">
                    <legend><?php echo $lang['nc_debug_trace_title']; ?></legend>
                    <div> <?php print_r(Tpl::showTrace()); ?> </div>
                </fieldset></div><?php } ?></div>
        <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.cookie.js"></script>
        <link href="<?php echo RESOURCE_SITE_URL; ?>/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/qtip/jquery.qtip.min.js"></script>
        <link href="<?php echo RESOURCE_SITE_URL; ?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
        <!-- 对比 -->
        <script src="<?php echo SHOP_RESOURCE_SITE_URL; ?>/js/compare.js"></script>
        <script type="text/javascript">
            $(function () {
// Membership card
                $('[nctype="mcard"]').membershipCard({type: 'shop'});
            });
        </script>
