<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<script type="text/javascript">
    var SHOP_SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
    var UPLOAD_SITE_URL = "<?php echo UPLOAD_SITE_URL; ?>";
</script>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="index.php?controller=web_config&action=web_config"
                                   title="返回<?php echo '板块区'; ?>列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3><?php echo $lang['web_config_index']; ?> - 设计“<?php echo $output['web_array']['web_name'] ?>”板块</h3>
                <h5><?php echo $lang['nc_web_index_subhead']; ?></h5>
            </div>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="<?php echo $lang['nc_prompts_title']; ?>"><?php echo $lang['nc_prompts']; ?></h4>
            <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span']; ?>"></span></div>
        <ul>
            <li><?php echo $lang['web_config_edit_help1']; ?></li>
            <li><?php echo $lang['web_config_edit_help2']; ?></li>
            <li><?php echo $lang['web_config_edit_help3']; ?></li>
        </ul>
    </div>
    <div class="ncap-form-all">
        <div class="title">
            <h3>商城广告区域设置</h3>
        </div>
        <dl class="row">
            <dt class="tit">
                <label><?php echo $lang['web_config_edit_html'] . $lang['nc_colon']; ?></label>
            </dt>
            <dd class="opt">
                <div class="home-templates-board-layout style-<?php echo $output['web_array']['style_name']; ?>">
                    <div class="left" style="width: 100%">
                        <dl style="float: left">
                            <dt>
                            <h4 style="width: 150px"><?php echo $output['name']; ?></h4>
                            <a href="JavaScript:show_dialog('upload_adv');"><?php echo $lang['nc_edit']; ?></a></dt>
                            <dd class="adv-pic">
                                <div id="picture_adv" class="picture">
                                    <?php if (is_array($output['code_adv']['code_info']) && !empty($output['code_adv']['code_info'])) {
                                        $adv = current($output['code_adv']['code_info']);
                                        ?>
                                        <?php if (is_array($adv) && !empty($adv)) { ?>
                                            <img src="<?php echo $adv['pic_img']; ?>" width="212" height="212"/>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </dd>
        </dl>

    </div>
    <div class="bot"><a href="<?=urlAdminShop('web_config','web_html',['web_id'=>$output['code_adv']['web_id']])?>"
                        class="ncap-btn-big ncap-btn-green"
                        id="submitBtn"><?php echo $lang['web_config_web_html']; ?></a></div>
</div>

<!-- 切换广告图片 -->
<div id="upload_adv_dialog" class="upload_adv_dialog" style="display:none;">
    <div class="s-tips"><i class="fa fa-lightbulb-o"></i><?php echo '小提示：单击图片选中修改，拖动可以排序，最少保留1个，最多可加5个，保存后生效。'; ?></div>
    <form id="upload_adv_form" name="upload_adv_form" enctype="multipart/form-data" method="post"
          action="index.php?controller=web_config&action=slide_adv" target="upload_pic">
        <input type="hidden" name="web_id" value="<?php echo $output['code_adv']['web_id']; ?>">
        <input type="hidden" name="code_id" value="<?php echo $output['code_adv']['code_id']; ?>">
        <div class="ncap-form-all">
            <dl class="row">
                <dt class="tit"><?php echo '已上传图片'; ?></dt>
                <dd class="opt">
                    <ul class="adv dialog-adv-s1">
                        <?php if (is_array($output['code_adv']['code_info']) && !empty($output['code_adv']['code_info'])) { ?>
                            <?php foreach ($output['code_adv']['code_info'] as $key => $val) { ?>
                                <?php if (is_array($val) && !empty($val)) { ?>
                                    <li slide_adv_id="<?php echo $val['pic_id']; ?>">
                                        <div class="adv-pic"><span class="ac-ico"
                                                                   onclick="del_slide_adv(<?php echo $val['pic_id']; ?>);"></span><img
                                                onclick="select_slide_adv(<?php echo $val['pic_id']; ?>);"
                                                title="<?php echo $val['pic_name']; ?>"
                                                src="<?php echo $val['pic_img']; ?>"/></div>
                                        <input name="adv[<?php echo $val['pic_id']; ?>][pic_id]"
                                               value="<?php echo $val['pic_id']; ?>" type="hidden">
                                        <input name="adv[<?php echo $val['pic_id']; ?>][pic_name]"
                                               value="<?php echo $val['pic_name']; ?>" type="hidden">
                                        <input name="adv[<?php echo $val['pic_id']; ?>][pic_url]"
                                               value="<?php echo $val['pic_url']; ?>" type="hidden">
                                        <input name="adv[<?php echo $val['pic_id']; ?>][pic_img]"
                                               value="<?php echo $val['pic_img']; ?>" type="hidden">

                                    </li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <a class="ncap-btn" href="JavaScript:add_slide_adv();"><i
                            class="fa fa-plus"></i><?php echo '新增图片'; ?>&nbsp;(最多5个)</a></dd>
            </dl>
        </div>
        <div id="upload_slide_adv" class="ncap-form-default" style="display:none;">
            <dl class="row">
                <dt class="tit"><?php echo '文字标题'; ?></dt>
                <dd class="opt">
                    <input type="hidden" name="slide_id" value="">
                    <input class="input-txt" type="text" name="slide_pic[pic_name]" value="">
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><?php echo $lang['web_config_upload_url']; ?></label>
                </dt>
                <dd class="opt">
                    <input name="slide_pic[pic_url]" value="" class="input-txt" type="text">
                    <p class="notic"><?php echo $lang['web_config_adv_url_tips']; ?></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit"><?php echo $lang['web_config_upload_adv_pic'] . $lang['nc_colon']; ?></dt>
                <dd class="opt">
                    <div class="input-file-show"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text'/>
            <input type='button' name='button' id='button1' value='选择上传...' class='type-file-button'/>
            <input name="pic" id="pic" type="file" class="type-file-file" size="30">
            </span></div>
                    <p class="notic"><?php echo $lang['web_config_upload_pic_tips']; ?></p>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_adv_form').submit();"
                                class="ncap-btn-big ncap-btn-green"><?php echo $lang['web_config_save']; ?></a></div>
        </div>
    </form>
</div>
<iframe style="display:none;" src="" name="upload_pic"></iframe>
<script src="<?php echo ADMIN_RESOURCE_URL; ?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/waypoints.js"></script>
<script src="<?php echo ADMIN_RESOURCE_URL ?>/js/web_index.js"></script>
