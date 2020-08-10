<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style>
    #newBridge .nb-icon-wrap{display:none;}
</style>
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
</script><?php if (C('node_chat')) {
    $personal = getMemberAvatarForID(2);
    echo getChat($layout);
$chat_html = '';
$web_html .= '<script src="/chat/templates/default/chat.js"></script>';
$web_html .= '<link href="/chat/templates/default/css/chat.css" rel="stylesheet" type="text/css">';
$web_html .= '<div id="web_chat_dialog" style="float: right;">';
    $web_html .= '<div class="chat-box">';
        $web_html .= '<div class="chat-list" style="display: block;">';
            $web_html .= '<div class="chat-list-top"><h1><i></i>联系人</h1><span class="minimize-chat-list"></span></div>';
            $web_html .= '<div id="chat_user_list" class="chat-list-content ps-container">';
                $web_html .= '<div>';
                    $web_html .= '<dl id="chat_user_friends">';
                        $web_html .= '<dt onclick="chat_show_user_list(\'friends\');"><span class="show"></span>我的好友</dt>';
                        $web_html .= '<dd u_id="2" style="display: block;" class="begin-chat">';
                            $web_html .= '<span class="user-avatar">';
                                $web_html .= '<img alt="personal" src="'.$personal.'">';
                                $web_html .= '<i class="offline"></i>';
                            $web_html .= '</span>';
                            $web_html .= '<h5>personal</h5>';
                            $web_html .= '<a href="javascript:void(0)"></a>';
                        $web_html .= '</dd>';
                    $web_html .= '</dl>';
                    $web_html .= '<dl id="chat_user_recent">';
                        $web_html .= '<dt><span class="show"></span>最近联系人</dt>';
                        $web_html .= '<dd id="chat_recent" style="display: none;"></dd>';
                    $web_html .= '</dl>';
                $web_html .= '</div>';
                $web_html .= '<div class="ps-scrollbar-x-rail" style="width: 178px; display: none; left: 0px; bottom: 3px;">';
                    $web_html .= '<div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>';
                $web_html .= '</div>';
                $web_html .= '<div class="ps-scrollbar-y-rail" style="top: 0px; height: 420px; display: none; right: 3px;">';
                    $web_html .= '<div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>';
                $web_html .= '</div>';
            $web_html .= '</div>';
        $web_html .= '</div>';
    $web_html .= '</div>';
$web_html .= '</div>';
$web_html .= '<div id="new_msg_dialog" class="msg-windows" style="display: none;">';
    $web_html .= '<div class="user-tab-bar">';
        $web_html .= '<ul class="user-list" id="user_list"></ul>';
    $web_html .= '</div>';
    $web_html .= '<div class="msg-dialog">';
        $web_html .= '<div class="dialog-body">';
            $web_html .= '<div class="msg-top">';
                $web_html .= '<dl class="user-info">';
                    $web_html .= '<dt class="user-name"></dt>';
                    $web_html .= '<dd class="user-avatar avatar-0"><img src="" alt=""></dd>';
                    $web_html .= '<dd class="store-name"></dd>';
                $web_html .= '</dl>';
                $web_html .= '<span class="dialog-close">&nbsp;</span></div>';
            $web_html .= '<div id="msg_list" class="msg-contnet">';
                $web_html .= '<div id="user_msg_list"></div>';
            $web_html .= '</div>';
            $web_html .= '<div class="msg-input-box">';
                $web_html .= '<div class="msg-input-title">';
                    $web_html .= '<a id="chat_show_smilies" href="javascript:void(0)" class="chat_smiles">表情</a>';
                    $web_html .= '<span class="title">输入聊天信息</span>';
                    $web_html .= '<span class="chat-log-btn off">聊天记录<i></i></span>';
                $web_html .= '</div>';
                $web_html .= '<form id="msg_form" >';
                    $web_html .= '<textarea name="send_message" id="send_message" class="textarea"></textarea>';
                    $web_html .= '<div class="msg-bottom">';
                        $web_html .= '<div id="msg_count"></div>';
                        $web_html .= '<a href="JavaScript:void(0);"  class="msg-button"><i></i>发送消息</a>';
                        $web_html .= '<div id="send_alert"></div>';
                    $web_html .= '</div>';
                $web_html .= '</form>';
            $web_html .= '</div>';
        $web_html .= '</div>';
        $web_html .= '<div id="dialog_chat_log" class="dialog_chat_log"></div>';
        $web_html .= '<div id="dialog_right_clear" class="dialog_right_clear"></div>';
    $web_html .= '</div>';
    $web_html .= '<div id="dialog_clear" class="dialog_clear"></div>';
$web_html .= '</div>';
$web_html .= '<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>';
echo $web_html;
} ?>

<div class="footer">
    <div class="footer-top">
        <?php if (is_array($output['bottom_nav']) && !empty($output['bottom_nav'])) { ?>
            <ul>
            <?php foreach ($output['bottom_nav'] as $k => $article_class) { ?><?php if (!empty($article_class)) { ?>
                <li>
                <dl class="s<?php echo '' . $k + 1; ?>">
                    <dt><?php if (!empty($article_class['nav_title'])) echo $article_class['nav_title']; ?></dt>
                    <?php if (is_array($article_class['_child']) && !empty($article_class['_child'])) { ?><?php foreach ($article_class['_child'] as $article) { ?>
                        <dd>
                        <a href="<?php if ($article['nav_url'] != '') echo $article['nav_url']; ?>" title="<?php echo $article['nav_title']; ?>"> <?php echo $article['nav_title']; ?> </a>
                        </dd>
                    <?php }
                    } ?>
                </dl>
                </li>
            <?php }
            } ?>
            </ul>
        <?php } ?>
    </div>
</div>
<div class="footer-bottom" style="height: 100px">
    CopyRight © 2007-<?=date("Y",time()) ?> 海吉壹佰 <a href="http://www.miibeian.gov.cn/" target="_blank" mxf="sqde" style="color:#666"><?php echo $output['setting_config']['icp_number']; ?></a>NewPower Co. 版权所有
    <?php echo $output['index_adv']['index_qr']?>
</div>
<?php echo $output['index_adv']['index_sign']?>
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
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?62b53fc309b8cd01c3e66ca2715f7aac";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();


    $(function(){
        $(document).on("click","#chat_show_user",function(){
            chart.show();
        });
    });

    window.chart = {
        show:function(){
            $(".nb-icon-inner-wrap").trigger("click");
        }
    };
</script>
<script>
    $('#show_user_info').click(function(){
        var _this = $(this);
        if(_this.hasClass('top-active')){
            _this.removeClass('top-active');
            $('#user-info-box').hide();
        }else{
            _this.addClass('top-active');
            $('#user-info-box').show();
        }

    });
    $('.user-info-close-btn').click(function(){
        if($(this).is(':hidden')){

        }else{
            $('#show_user_info').removeClass('top-active');
            $(this).parent().hide();
        }
    });
</script>
