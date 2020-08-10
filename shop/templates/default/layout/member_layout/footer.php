<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="leftsead">
    <ul>
        <li>
            <a id="top_btn">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll06.png" width="47" height="49" class="hides"/>
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l06.png" width="47" height="49" class="shows" />
            </a>
        </li>

        <?php if ($_SESSION['is_login']) {
            if(count($output['kefu_group_list'])>0){
                foreach($output['kefu_group_list'] as $val){?>
                    <!--<li class="service">
                        <a href="javascript:;" class="icon12" data-id="<?php /*echo $val['id'] */?>"><?php /*echo $val['name'] */?></a>
                    </li>-->
                    <li class="service">
                        <a href="javascript:;" data-id="<?php echo $val['id'] ?>">
                            <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll03.png"  width="47" height="49" class="hides" />
                            <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l03.png" width="47" height="49" class="shows" />
                        </a>
                    </li>
                <?php }}} ?>

        <!--<li>
            <a href="">
                <img src="<?php /*echo jf_TEMPLATES_URL;*/?>/images/foot03/ll03.png"  width="47" height="49" class="hides"/>
                <img src="<?php /*echo jf_TEMPLATES_URL;*/?>/images/foot03/l03.png" width="47" height="49" class="shows" />
            </a>
        </li>-->

        <li>
            <a href="">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll02.png" width="166" height="49" class="hides"/>
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l04.png" width="47" height="49" class="shows" />
            </a>
        </li>

        <li>
            <a class="youhui">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l02.png" width="47" height="49" class="shows" />
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/zfew.jpg" width="196" height="205" class="hides" usemap="#taklhtml"/>
            </a>
        </li>



    </ul>
</div><!--leftsead end-->
<script type="text/javascript">
    $(document).ready(function(){

        $("#leftsead a").hover(function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").show();
            }else{
                $(this).children("img.hides").show();
                $(this).children("img.shows").hide();
                $(this).children("img.hides").animate({marginRight:'0px'},'slow');
            }
        },function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").hide('slow');
            }else{
                $(this).children("img.hides").animate({marginRight:'-143px'},'slow',function(){$(this).hide();$(this).next("img.shows").show();});
            }
        });

        $("#top_btn").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});

    });
</script>
<style>
    #newBridge .nb-icon-wrap{display:none;}
</style>
<?php if ($_SESSION['is_login']) {?>
    <script type="text/javascript">
        $(function() {
            var ws = new fotaisKeFu();
            $("li.service a").click(function(){
                var group = $(this).attr('data-id');
                ws.init({
                    id: "<?php echo $_SESSION['member_id'];?>",
                    name: "<?php echo $_SESSION['member_name'];?>",
                    avatar: "<?php echo $_SESSION['avatar'];?>",
                    group: group
                });
            });
        });
    </script>
<?php } ?>
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
<script src="/chat/templates/default/chat.js"></script>
<link href="/chat/templates/default/css/chat.css" rel="stylesheet" type="text/css">
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
