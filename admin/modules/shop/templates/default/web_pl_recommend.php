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
                    <div class="middle">
                        <div>
                            <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
                                <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
                                    <dl recommend_id="<?php echo $key; ?>">
                                        <dt>
                                        <h4><?php echo $val['recommend']['name']; ?></h4>
                                        <a href="JavaScript:del_recommend(<?php echo $key; ?>);"><i
                                                class="fa fa-trash"></i><?php echo $lang['nc_del']; ?></a> <a
                                            href="JavaScript:show_recommend_dialog(<?php echo $key; ?>);"><i
                                                class="fa fa-shopping-cart"></i><?php echo '商品块'; ?></a>  </dt>
                                        <dd>
                                            <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                                                <ul class="goods-list">
                                                    <?php foreach ($val['goods_list'] as $k => $v) { ?>
                                                        <li><span><a href="javascript:void(0);"> <img
                                                                        title="<?php echo $v['goods_name']; ?>"
                                                                        src="<?php echo  $v['goods_pic']; ?>"/></a></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                                                <div class="middle-banner">

                                                    <?php foreach ($val['pic_list'] as $pic_key => $pic_val) { ?>
                                                        <a href="javascript:void(0);" class="left-a">
                                                            <img pic_url="<?php echo $pic_val['pic_url']; ?>" title="<?php echo $pic_val['pic_name']; ?>" stitle="<?php echo $pic_val['pic_sname']; ?>" src="<?php echo $pic_val['pic_img']; ?>"/>
                                                        </a>
                                                    <?php } ?>

                                                </div>
                                            <?php } else { ?>
                                                <ul class="goods-list">
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                    <li><span><i class="icon-gift"></i></span></li>
                                                </ul>
                                            <?php } ?>
                                        </dd>
                                    </dl>
                                <?php } ?>
                            <?php } ?>
                            <div class="add-tab" id="btn_add_list">
                                <a href="JavaScript:add_recommend();">
                                    <i class="icon-plus-sign-alt"></i>
                                    <?php echo $lang['web_config_add_recommend']; ?>
                                </a>
                                <?php echo $lang['web_config_recommend_max']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </dd>
        </dl>

    </div>
    <div class="bot"><a href="<?=urlAdminShop('web_config','web_html',['web_id'=>615])?>"
                        class="ncap-btn-big ncap-btn-green"
                        id="submitBtn"><?php echo $lang['web_config_web_html']; ?></a></div>
</div>

<!-- 商品推荐模块 -->
<div id="recommend_list_dialog" style="display:none;">
    <div class="s-tips"><i></i><?php echo $lang['web_config_recommend_goods_tips']; ?></div>
    <form id="recommend_list_form">
        <input type="hidden" name="web_id" value="<?php echo $output['code_recommend_list']['web_id']; ?>">
        <input type="hidden" name="code_id" value="<?php echo $output['code_recommend_list']['code_id']; ?>">
        <div id="recommend_input_list" style="display:none;"><!-- 推荐拖动排序 --></div>
        <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
            <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
                <div class="ncap-form-default" select_recommend_id="<?php echo $key; ?>">
                    <dl class="row">
                        <dt class="tit"> <?php echo $lang['web_config_recommend_title']; ?></dt>
                        <dd class="opt">
                            <input name="recommend_list[<?php echo $key; ?>][recommend][name]"
                                   value="<?php echo $val['recommend']['name']; ?>" type="text" class="input-txt">
                            <p class="notic"><?php echo $lang['web_config_recommend_tips']; ?></p>
                        </dd>
                    </dl>
                </div>
                <div class="ncap-form-all" select_recommend_id="<?php echo $key; ?>">
                    <dl class="row">
                        <dt class="tit"><?php echo $lang['web_config_recommend_goods']; ?></dt>
                        <dd class="opt">
                            <ul class="dialog-goodslist-s1 goods-list">
                                <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                                    <?php foreach ($val['goods_list'] as $k => $v) { ?>
                                        <li id="select_recommend_<?php echo $key; ?>_goods_<?php echo $k; ?>">
                                            <div ondblclick="del_recommend_goods(<?php echo $v['goods_id']; ?>);"
                                                 class="goods-pic">
                                                <span class="ac-ico" onclick="del_recommend_goods(<?php echo $v['goods_id']; ?>);"></span>
                                                <span class="thumb size-72x72"><i></i>
                                                    <img select_goods_id="<?php echo $v['goods_id']; ?>"
                                                         title="<?php echo $v['goods_name']; ?>"
                                                         goods_name="<?php echo $v['goods_name']; ?>"
                                                         src="<?php echo  $v['goods_pic']; ?>"
                                                         onload="javascript:DrawImage(this,72,72);"/>
                                                </span>
                                            </div>
                                            <div class="goods-name"><a
                                                    href="<?php echo SHOP_SITE_URL . "/index.php?controller=goods&goods_id=" . $v['goods_id']; ?>"
                                                    target="_blank"><?php echo $v['goods_name']; ?></a>
                                            </div>
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_id]"
                                                   value="<?php echo $v['goods_id']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][market_price]"
                                                   value="<?php echo $v['market_price']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_name]"
                                                   value="<?php echo $v['goods_name']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_price]"
                                                   value="<?php echo $v['goods_price']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_pic]"
                                                   value="<?php echo $v['goods_pic']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_salenum]"
                                                   value="<?php echo $v['goods_salenum']; ?>" type="hidden">
                                        </li>
                                    <?php } ?>
                                <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                                    <?php foreach ($val['pic_list'] as $k => $v) { ?>
                                        <li id="select_recommend_<?php echo $key; ?>_pic_<?php echo $k; ?>"
                                            style="display:none;">
                                            <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_id]"
                                                   value="<?php echo $v['pic_id']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_name]"
                                                   value="<?php echo $v['pic_name']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_url]"
                                                   value="<?php echo $v['pic_url']; ?>" type="hidden">
                                            <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_img]"
                                                   value="<?php echo $v['pic_img']; ?>" type="hidden">
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                </div>
            <?php } ?>
        <?php } ?>
        <div id="add_recommend_list" style="display:none;"></div>
        <div class="ncap-form-all">
            <dl class="row">
                <dt class="tit"><?php echo $lang['web_config_recommend_add_goods']; ?></dt>
                <dd class="opt">
                    <div class="search-bar">
                        <label id="recommend_gcategory">商品分类
                            <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id"/>
                            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names"/>
                            <select>
                                <option value="0"><?php echo $lang['nc_please_choose']; ?></option>
                                <?php if (!empty($output['goods_class']) && is_array($output['goods_class'])) { ?>
                                    <?php foreach ($output['goods_class'] as $k => $v) { ?>
                                        <option value="<?php echo $v['gc_id']; ?>"><?php echo $v['gc_name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </label>
                        <input type="text" value="" name="recommend_goods_name" id="recommend_goods_name"
                               placeholder="输入商品名称或SKU编号" class="txt w150">
                        <a href="JavaScript:void(0);" onclick="get_recommend_goods();"
                           class="ncap-btn"><?php echo $lang['nc_query']; ?></a></div>
                    <div id="show_recommend_goods_list" class="show-recommend-goods-list"></div>
                </dd>
            </dl>
        </div>
        <div class="bot"><a href="JavaScript:void(0);" onclick="update_recommend();"
                            class="ncap-btn-big ncap-btn-green"><span><?php echo $lang['web_config_save']; ?></span></a>
        </div>
    </form>
</div>
<!-- 中部推荐图片 -->
<div id="recommend_pic_dialog" style="display:none;">
    <div class="s-tips"><i class="fa fa-lightbulb-o"></i><?php echo '单击广告图选中对应的位置，在底部上传和修改图片信息。'; ?></div>
    <form id="recommend_pic_form" name="recommend_pic_form" enctype="multipart/form-data" method="post"
          action="index.php?controller=web_config&action=recommend_pic" target="upload_pic">
        <input type="hidden" name="form_submit" value="ok"/>
        <input type="hidden" name="web_id" value="<?php echo $output['code_recommend_list']['web_id']; ?>">
        <input type="hidden" name="code_id" value="<?php echo $output['code_recommend_list']['code_id']; ?>">
        <input type="hidden" name="key_id" value="">
        <input type="hidden" name="pic_id" value="">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit"><?php echo '推荐模块标题名称'; ?></dt>
                <dd class="opt">
                    <input name="recommend_list[recommend][name]" value="" type="text" class="input-txt">
                    <p class="notic"><?php echo ' 修改该区域中部推荐模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏'; ?></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">广告图区域选择</dt>
                <dd class="opt" id="add_recommend_pic">
                    <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
                        <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
                            <?php if (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                                <div select_recommend_pic_id="<?php echo $key; ?>" class="middle-banner">
                                    <?php foreach ($val['pic_list'] as $pic_key => $pic_val) { ?>
                                        <a recommend_pic_id="<?php echo $pic_val['pic_id']; ?>" href="javascript:void(0);" class="left-a">
                                            <img pic_url="<?php echo $pic_val['pic_url']; ?>"
                                                 title="<?php echo $pic_val['pic_name']; ?>"
                                                 pic_name="<?php echo $pic_val['pic_name']; ?>"
                                                 pic_sname="<?php echo $pic_val['pic_sname']; ?>"
                                                 stitle="<?php echo $pic_val['pic_sname']; ?>"
                                                 pic_sname="<?php echo $pic_val['pic_sname']; ?>"
                                                 src="<?php echo $pic_val['pic_img']; ?>"/>
                                        </a>
                                    <?php } ?>
                                    <?php if(count($val['pic_list']) < 10) { $begin_key = 12;$end_key = bcsub(10,count($val['pic_list'])) ?>
                                        <?php for($i = 0;$i < $end_key;$i++) { ?>

                                            <a href="javascript:void(0);" recommend_pic_id="<?php echo bcadd($begin_key,$i); ?>" class="left-a">160*160</a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit"><?php echo '文字标题'; ?></dt>
                <dd class="opt">
                    <input class="input-txt" type="text" name="pic_list[pic_name]" value="">
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit"><?php echo '文字副标题'; ?></dt>
                <dd class="opt">
                    <input class="input-txt" type="text" name="pic_list[pic_sname]" value="">
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit"><?php echo '跳转链接'; ?></dt>
                <dd class="opt">
                    <input class="input-txt" type="text" name="pic_list[pic_url]" value="<?php echo SHOP_SITE_URL; ?>">
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit"><?php echo '图片上传'; ?></dt>
                <dd class="opt">
                    <div class="input-file-show"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' value='' class='type-file-text'/>
            <input type='button' name='button' id='button1' value='选择上传...' class='type-file-button'/>
            <input name="pic" id="pic" type="file" class="type-file-file" value='' size="30">
            </span></div>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" onclick="$('#recommend_pic_form').submit();"
                                class="ncap-btn-big ncap-btn-green"><span><?php echo $lang['web_config_save']; ?></span></a>
            </div>
        </div>
    </form>
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
