<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<!---------------------页面内容静态资源文件开始---------------------------->
<link href="/shop/templates/default/css/home_index/home_index.css" rel="stylesheet" type="text/css">
<style>
    .edit-btn{
        color: #FFF;
        background: rgba(0,0,0,0.2);
        border: solid 1px rgba(0,0,0,0.1);
        text-decoration: none;
        line-height: 20px;
        text-align: center;
        height: 20px;
        float: right;
    }
    .hover-box:hover {
        filter:progid:DXImageTransform.Microsoft.gradient(enabled='true', startColorstr='#19000000', endColorstr='#19000000'); background: rgba(0,0,0,0.1); box-shadow: 0 0 0 2px rgba(0,0,0,0.25);
    }
    #add_recommend_pic .middle-banner a.opacity-100{
        opacity: 100;
    }
</style>
<script src="/shop/templates/default/js/home_index.js"></script>
<!---------------------页面内容静态资源文件结束---------------------------->
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
            <h3><?php echo $lang['web_config_style_name']; ?>
                :<?php echo $output['style_array'][$output['web_array']['style_name']]; ?></h3>
        </div>
        <!---------------------页面内容开始---------------------------->


        <div class="guess">
            <?php if(in_array(16,$output['var_name_arr'])){  ?>
                <div class="gg edit-btn" id="edit-btn-<?php echo $output['lists'][16]['code_info_arr']['id'] ?>" data-id="<?php echo $output['lists'][16]['code_info_arr']['id'] ?>" data-code-id="<?php echo $output['lists'][16]['code_id'] ?>" data-type="<?php echo $output['lists'][16]['code_info_arr']['type'] ?>">
                    <span style="display: none" data-title="<?php echo $output['lists'][16]['code_info_arr']['title'] ?>" data-f-title="<?php echo $output['lists'][16]['code_info_arr']['f_title'] ?>" data-url="<?php echo $output['lists'][16]['code_info_arr']['url'] ?>" data-pic="<?php echo $output['lists'][16]['code_info_arr']['pic'] ?>"  ></span>
                    <a href="">
                        <img src="<?php echo $output['lists'][16]['code_info_arr']['pic'] ?>">
                    </a>
                </div>
            <?php }else{ ?>
                <div class="gg edit-btn" data-id="16" id="edit-btn-16" data-code-id="" data-type="1">
                    <span style="display: none" data-title="" data-f-title="" data-url="" data-pic="<?php echo SHOP_TEMPLATES_URL;?>/images/home_index/img19.png"></span>
                    <a href="">
                        <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/home_index/img19.png">
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="inmain">

            <span class="line-lb hover-box" style="display: block;">

                <?php if(in_array(17,$output['var_name_arr'])){  ?>
                <a href="" class="edit-btn" id="edit-btn-edit-btn-<?php echo $output['lists'][17]['code_info_arr']['id'] ?>" data-id="<?php echo $output['lists'][17]['code_info_arr']['id'] ?>" data-code-id="<?php echo $output['lists'][17]['code_id'] ?>" data-type="<?php echo $output['lists'][17]['code_info_arr']['type'] ?>">
                    <span style="display: none" data-title="" data-f-title="" data-url="" data-pic="" data-json='<?php echo $output['goods_list_json']; ?>'>
                    </span>编辑</a>
                <div class="line-lb">
                    <ul>
                        <?php if(!empty($output['goods_list'])){ ?>
                        <?php foreach($output['goods_list'] as $goods_info){ ?>
                        <li>
                            <a href="<?php echo urlShop('goods','index',['goods_id'=>$goods_info['goods_id']]);?>">
                                <div class="line-lb-img"><img src="<?php echo $goods_info['goods_image'];?>"></div>
                                <div class="line-lb-text"><?php echo $goods_info['goods_name'];?></div>
                                <div class="line-lb-price">¥<?php echo $goods_info['goods_price'];?></div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </div>

                <?php }else{ ?>


                <a href="" class="edit-btn" id="edit-btn-17" data-id="17" data-code-id="" data-type="4">
                    <span style="display: none" data-title="" data-f-title="" data-url="" data-pic="" data-json=''>
                    </span>编辑</a>
                <div class="line-lb">
                    <ul>

                    </ul>
                </div>

                <?php } ?>
            </span>

        </div>


        <!---------------------页面内容结束---------------------------->
    </div>
    <div class="bot">
        <a href="<?php echo urlAdminShop('web_config','update_index_web_html',['web_id'=>$_GET['web_id']]) ?>"
                        class="ncap-btn-big ncap-btn-green"
                        id="submitBtn"><?php echo $lang['web_config_web_html']; ?>
        </a>
    </div>
</div>

<style>
    .dialog-box{
        min-width: 800px;
        height: auto;
        display: none;
        float: left;
        position:fixed;
        top:20%;
        left:20%;
    }
</style>


<!--单图-->
<div class="dialog-box" id="edit_box_dialog">
    <div id="fwin_edit_box" class="dialog_wrapper ui-draggable"
         style="z-index: 1100; position: absolute; width: 640px; left: 35%; top: 23%;">
        <div class="dialog_body" style="position: relative;">
            <h3 class="dialog_head ui-draggable-handle" style="cursor: move;">
                <span class="dialog_title">
                    <span class="dialog_title_icon"></span>
                </span>
                <span class="dialog_close_button">X</span>
            </h3>
            <div class="dialog_content" style="margin: 0px; padding: 0px;">
                <div id="edit_box_dialog" class="edit_box_dialog">
                    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo urlAdminShop('web_config','save_new_index') ?>">
                        <input type="hidden" name="form_submit" value="ok">
                        <input type="hidden" name="web_id" value="<?php echo $output['get_web_id'] ?>">
                        <input type="hidden" name="code_id" id="code-id-1" value="">
                        <input type="hidden" name="id" id="box-id-1">
                        <input type="hidden" name="type" id="type-1">
                        <div class="ncap-form-default">
                            <dl class="row">
                                <dt class="tit">
                                    <label>广告图区域选择</label>
                                </dt>
                                <dd class="opt">
                                    <div style="display: block;">
                                        <a href="javascript:void(0);"
                                           style="display:block;width: 200px;height: 200px;float: left">
                                            <img title="99" width="200" height="200" id="one_image"
                                                 src="">
                                            <input type="hidden" name="pic" id="one_image_url" value="">
                                        </a>
                                    </div>
                                </dd>
                            </dl>

                            <dl class="row">
                                <dt class="tit">
                                    <label>标题</label>
                                </dt>
                                <dd class="opt">
                                    <input id="title-1" name="title" value="海吉壹佰" class="input-txt" type="text">
                                </dd>
                            </dl>
                            <dl class="row">
                                <dt class="tit">
                                    <label>副标题</label>
                                </dt>
                                <dd class="opt">
                                    <input id="f_title-1" name="f_title" value="" class="input-txt" type="text">
                                </dd>
                            </dl>
                            <dl class="row">
                                <dt class="tit">
                                    <label>跳转链接</label>
                                </dt>
                                <dd class="opt">
                                    <input id="url-1" name="url" value="" class="input-txt" type="text">
                                </dd>
                            </dl>

                            <dl class="row">
                                <dt class="tit">图片上传</dt>
                                <dd class="opt">
                                    <div class="input-file-show" style="padding-left:0">
                                        <span class="type-file-box" style="width: auto">
                                            <input type="button" name="button" id="upload-btn" value="选择上传..." class="type-file-button">
                                        </span>
                                    </div>
                                </dd>
                            </dl>


                            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green submit-btn">保存</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="clear:both; display:block;"></div>
    </div>
    <div id="dialog_manage_screen_locker" style="
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    outline: 0;
    -webkit-overflow-scrolling: touch;
    background-color: rgb(0, 0, 0);
    filter: alpha(opacity=60);
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 998;
        "></div>
</div>
<!--单图结束-->


<!--多图-->
<div class="dialog-box" id="edit_images_box_dialog">
    <div id="fwin_edit_box" class="dialog_wrapper ui-draggable"
         style="z-index: 1100; position: absolute; width: 640px; left: 35%; top: 23%;">
        <div class="dialog_body" style="position: relative;">
            <h3 class="dialog_head ui-draggable-handle" style="cursor: move;">
                <span class="dialog_title">
                    <span class="dialog_title_icon"></span>
                </span>
                <span class="dialog_close_button">X</span>
            </h3>
            <div class="dialog_content" style="margin: 0px; padding: 0px;">
                <div id="edit_box_dialog" class="edit_box_dialog">
                    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo urlAdminShop('web_config','save_new_index_adv_pic') ?>">
                        <input type="hidden" name="form_submit" value="ok">
                        <input type="hidden" name="web_id" value="<?php echo $output['get_web_id'] ?>">
                        <input type="hidden" name="code_id" id="code-id-3" value="">
                        <input type="hidden" name="id" id="box-id-3">
                        <input type="hidden" name="type" id="type-3">
                        <div class="ncap-form-default">
                            <dl class="row">
                                <dt class="tit">
                                    <label>广告图区域选择</label>
                                </dt>

                                <dd class="opt" id="add_recommend_pic" data-pic-id="1">
                                    <div class="middle-banner">
                                        <a href="javascript:void(0);" id="pic_id_1" pic-id="1" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_2" pic-id="2" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_3" pic-id="3" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_4" pic-id="4" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_5" pic-id="5" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_6" pic-id="6" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_7" pic-id="7" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_8" pic-id="8" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_9" pic-id="9" class="left-a" data-title="" data-f-title="" data-url=""></a>

                                        <a href="javascript:void(0);" id="pic_id_10" pic-id="10" class="left-a" data-title="" data-f-title="" data-url=""></a>
                                    </div>

                                </dd>

                            </dl>

                            <dl class="row">
                                <dt class="tit">
                                    <label>标题</label>
                                </dt>
                                <dd class="opt">
                                    <input id="title-3" name="title" value="" class="input-txt" type="text">
                                </dd>
                            </dl>
                            <dl class="row">
                                <dt class="tit">
                                    <label>副标题</label>
                                </dt>
                                <dd class="opt">
                                    <input id="f_title-3" name="f_title" value="" class="input-txt" type="text">
                                </dd>
                            </dl>
                            <dl class="row">
                                <dt class="tit">
                                    <label>跳转链接</label>
                                </dt>
                                <dd class="opt">
                                    <input id="url-3" name="url" value="" class="input-txt" type="text">
                                </dd>
                            </dl>

                            <dl class="row">
                                <dt class="tit">图片上传</dt>
                                <dd class="opt">
                                    <div class="input-file-show" style="padding-left:0">
                                        <span class="type-file-box" style="width: auto">
                                            <input type="button" name="button" id="upload-images-btn" value="选择上传..." class="type-file-button">
                                        </span>
                                    </div>
                                </dd>
                            </dl>

                            <div class="bot">
                                <a href="JavaScript:;" class="ncap-btn-big ncap-btn-green save-btn">保存当前图片信息</a>
                                <a href="JavaScript:;" class="ncap-btn-big ncap-btn-green submit-btn">更新到页面</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="clear:both; display:block;"></div>
    </div>
    <div id="dialog_manage_screen_locker" style="
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    outline: 0;
    -webkit-overflow-scrolling: touch;
    background-color: rgb(0, 0, 0);
    filter: alpha(opacity=60);
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 998;
        "></div>
</div>
<!--多图结束-->

<!--商品开始-->
<div class="dialog-box" id="edit_product_box_dialog">

    <div id="fwin_edit_box" class="dialog_wrapper ui-draggable"
         style="z-index: 1100; position: fixed;min-width:800px;max-width: 1200px">
        <div class="dialog_body" style="position: relative;">
            <h3 class="dialog_head ui-draggable-handle" style="cursor: move;">
                <span class="dialog_title">
                    <span class="dialog_title_icon"></span>
                </span>
                <span class="dialog_close_button">X</span>
            </h3>
            <div class="dialog_content" style="margin: 0px; padding: 0px;">
                <div id="edit_box_dialog" class="edit_box_dialog">
                    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo urlAdminShop('web_config','save_new_index_goods') ?>">
                        <input type="hidden" name="form_submit" value="ok">
                        <input type="hidden" name="web_id" value="<?php echo $output['get_web_id'] ?>">
                        <input type="hidden" name="code_id" id="code-id-4" value="">
                        <input type="hidden" name="id" id="box-id-4">
                        <input type="hidden" name="type" id="type-4">
                        <div class="ncap-form-default">

                            <!--商品列表开始-->
                            <dl class="row">
                                <dt class="tit">推荐商品</dt>
                                <dd class="opt">
                                    <ul class="dialog-goodslist-s1 goods-list ui-sortable" id="goods-list"></ul>
                                </dd>
                            </dl>
                            <!--商品列表结束-->

                            <!--选择商品开始-->
                            <dl class="row">
                                <dt class="tit">选择要展示的推荐商品</dt>
                                <dd class="opt">
                                    <div class="search-bar" >
                                        <label id="recommend_gcategory">商品分类
                                            <input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id">
                                            <select class="select-change">
                                                <option value="0">-请选择-</option>
                                                <?php if (!empty($output['goods_class_list'])){ ?>
                                                    <?php foreach ($output['goods_class_list'] as $type){ ?>
                                                        <option data-explain="20" value="<?php echo $type['gc_id'] ?>"><?php echo $type['gc_name'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </label>
                                        <input type="text" value="" name="recommend_goods_name" id="recommend_goods_name" placeholder="输入商品名称或SKU编号" class="txt w150">
                                        <a href="javascript:;"  class="ncap-btn search-goods-btn">查询</a>
                                    </div>
                                    <div id="show_recommend_goods_list" class="show-recommend-goods-list">
                                    </div>
                                </dd>
                            </dl>
                            <!--选择商品结束-->


                            <div class="bot"><a href="javascript:;" class="ncap-btn-big ncap-btn-green submit-btn">保存</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="clear:both; display:block;"></div>
    </div>
    <div id="dialog_manage_screen_locker" style="
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    outline: 0;
    -webkit-overflow-scrolling: touch;
    background-color: rgb(0, 0, 0);
    filter: alpha(opacity=60);
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 998;
        "></div>
</div>
<!--商品结束-->


<script src="<?php echo ADMIN_RESOURCE_URL; ?>/js/jquery.ajaxContent.pack.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/plupload-2.3.6/moxie.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/plupload-2.3.6/plupload.dev.js"></script>

<script>
    /**
     * data-type 编辑类型
     * 1.单图；2.多图轮播；3.多图展示；4.商品展示
     */
    $('.edit-btn').click(function(){
        var obj = $(this);
        var _type = obj.attr('data-type');
        var _code_id = obj.attr('data-code-id');
        var _id = obj.attr('data-id');
        var _title = obj.find('span').attr('data-title');
        var _f_title = obj.find('span').attr('data-f-title');
        var _url = obj.find('span').attr('data-url');
        var _pic = obj.find('span').attr('data-pic');

        $('#box-id-'+_type).val(_id);
        $('#code-id-'+_type).val(_code_id);
        $('#type-'+_type).val(_type);
        $('#title-'+_type).val(_title);
        $('#f_title-'+_type).val(_f_title);
        $('#url-'+_type).val(_url);
        $('#one_image').attr('src',_pic);
        $('#one_image_url').val(_pic);
        if(_type == 1){
            $('#edit_box_dialog').show();
        }else if(_type == 2){

        }else if(_type == 3){
            var _pic_json_data = obj.find('span').attr('data-json');
            if(_pic_json_data != ''){
                var _pic_json_data_json = jQuery.parseJSON(_pic_json_data);
                $.each(_pic_json_data_json, function (index, i) {
                    var _append_pic_info_str = '';
                    var _append_img_str = '';
//                console.log(index + "..." + i.pic+"..."+i.title);
                    $('#pic_id_'+i.id).attr('data-title',i.title);
                    $('#pic_id_'+i.id).attr('data-f-title',i.f_title);
                    $('#pic_id_'+i.id).attr('data-url',i.url);
                    _append_pic_info_str = getAppendPicInfoStr(i.id,i.title,i.f_title,i.url);
                    $('#pic_id_'+i.id).find('.image-data-box').remove();
                    $('#pic_id_'+i.id).append(_append_pic_info_str);
                    _append_img_str = getAppendPicStr(i.id,i.pic);
                    $('#pic_id_'+i.id).find('.img-data-box').remove();
                    $('#pic_id_'+i.id).append(_append_img_str);

                });
            }
            $('#edit_images_box_dialog').show();
        }else if(_type == 4){
            var _goods_json_data = obj.find('span').attr('data-json');
            var _goods_json_data_json = jQuery.parseJSON(_goods_json_data);
            var _default_url = "<?php echo urlShop('goods','index') ?>";
            var _str = '';
            if(_goods_json_data_json){
                $.each(_goods_json_data_json, function (index, i) {
//                console.log(index + "..." + i.goods_id+"..."+i.goods_price);
                    _str += getAppendGoodsStr(i.goods_id,i.goods_image,i.goods_name,i.goods_name,_default_url+ $.param({
                        'goods_id': i.goods_id
                    }));
                });
                $('#goods-list').empty().append(_str);
            }

//            console.log(_str);
            $('#edit_product_box_dialog').show();
        }

    });
    $('.dialog_close_button').click(function(){
        $(this).closest('.dialog-box').hide();
    });
    $('.submit-btn').click(function(){
        var _form = $(this).closest('form');
        var _url = _form.attr('action');
        var _form_data = _form.serialize();
        $.post(_url,_form_data,function(response){
            if(response['status'] == -1){
                showDialog(response.msg, 'error');return false;
            }
            var _code_id = response['data']['code_id'];
            var _data_id = response['data']['data_id'];
            console.log(_code_id);
            console.log(_data_id);
            _form.find('input[name="code_id"]').val(_code_id);
            $('#edit-btn-'+_data_id).attr('data-code-id',_code_id);
            window.location.reload();
        },'json');
    });
</script>
<script>
    // 单图上传
    var uploader = new plupload.Uploader({
        browse_button : 'upload-btn', //触发文件选择对话框的按钮，为那个元素id
        url : "<?php echo urlAdminShop('web_config','ali_upload_pic') ?>",//服务器端的上传页面地址
        max_file_size: '2mb',//限制为2MB
        filters: [{title: "Image files",extensions: "jpg,gif,png"}]//图片限制
    });
    //在实例对象上调用init()方法进行初始化
    uploader.init();
    //绑定各种事件，并在事件监听函数中做你想做的事
    uploader.bind('FilesAdded',function(uploader,files){
        uploader.start();
    });
    uploader.bind('FileUploaded',function(uploader,files,data){
            $("#one_image").attr('src',data.response);
            $("#one_image_url").val(data.response);
    });
</script>

<script>
    // 多图上传
    var images_uploader = new plupload.Uploader({
        browse_button : 'upload-images-btn', //触发文件选择对话框的按钮，为那个元素id
        url : "<?php echo urlAdminShop('web_config','ali_upload_pic') ?>",//服务器端的上传页面地址
        max_file_size: '2mb',//限制为2MB
        filters: [{title: "Image files",extensions: "jpg,gif,png"}]//图片限制
    });
    //在实例对象上调用init()方法进行初始化
    images_uploader.init();
    //绑定各种事件，并在事件监听函数中做你想做的事
    images_uploader.bind('FilesAdded',function(images_uploader,files){
        images_uploader.start();
    });
    images_uploader.bind('FileUploaded',function(images_uploader,files,data){
        var _pic_id = $('#add_recommend_pic').attr('data-pic-id');
        var _append_img_str = getAppendPicStr(_pic_id,data.response);
        $('#pic_id_'+_pic_id).find('.img-data-box').remove();
        $('#pic_id_'+_pic_id).append(_append_img_str);
    });
</script>
<script>
    $('body').on('change','.select-change',function(){
        var obj = $(this);
        var _id = $(this).find('option:selected').val();
        $('#cate_id').val(_id);
        var _url = "<?php echo urlAdminShop('web_config','get_address_select_html') ?>";
        $.get(_url,{id:_id},function(content){
            obj.nextAll('select').remove();
            if(content != ''){
                obj.after(content);
            }
        });
    });

    $('.search-goods-btn').click(function(){
        var _id = $('#cate_id').val();
        var _name = $('#recommend_goods_name').val();
        $("#show_recommend_goods_list").load('index.php?controller=web_config&action=recommend_list&' + $.param({
            'id': _id,
            'goods_name': _name
        }));
    });
    $('#show_recommend_goods_list').on('click','.dialog-goodslist-s2>li',function(){
        var _goods_obj = $(this).find('.thumb > img');
        var _goods_id = _goods_obj.attr('goods_id');
        var _goods_img = _goods_obj.attr('src');
        var _goods_title = _goods_obj.attr('title');
        var _goods_name = _goods_obj.attr('goods_name');
        var _goods_url = $(this).find('.goods-name > a').attr('href');
        var _str = getAppendGoodsStr(_goods_id,_goods_img,_goods_title,_goods_name,_goods_url);
        $('#goods-list').append(_str);
    });

    $('#goods-list').on('click','.del-btn',function(){
        $(this).closest('li').remove();
    });

    function getAppendGoodsStr(id,img,title,name,goods_url){
        var str = '';
        str += '<li class="ui-sortable-handle"><div class="goods-pic"><span class="ac-ico del-btn"></span><span class="thumb size-72x72"><i></i>';
        str += '<img title="'+title+'" goods_name="'+name+'" src="'+img+'"  width="72" height="72">';
        str += '</span></div>';
        str += '<div class="goods-name"><a href="'+goods_url+'" target="_blank">'+name+'</a>';
        str += '<input name="goods_id[]" value="'+id+'" type="hidden"></li>';
        return str;
    }

    function getAppendPicStr(pic_id,img){
        var _str = '<span class="img-data-box">';
         _str += '<img src="'+img+'">';
         _str += '<input type="hidden" name="image_data['+pic_id+'][pic]" value="'+img+'"></span>';
        return _str;
    }
    function getAppendPicInfoStr(id,title,f_title,url){
        var _str = '<span class="image-data-box" style="display:none">';
            _str += '<input type="hidden" name="image_data['+id+'][id]" value="'+id+'">';
            _str += '<input type="hidden" name="image_data['+id+'][title]" value="'+title+'">';
            _str += '<input type="hidden" name="image_data['+id+'][f_title]" value="'+f_title+'">';
            _str += '<input type="hidden" name="image_data['+id+'][url]" value="'+url+'"></span>';
        return _str;
    }

    $('#add_recommend_pic').on('click','.left-a',function(){
        var obj = $(this);
        obj.parent().find('.opacity-100').removeClass('opacity-100');
        obj.addClass('opacity-100');
        var _this_pic_id = obj.attr('pic-id');
        $('#add_recommend_pic').attr('data-pic-id',_this_pic_id);
        var _type = obj.closest('form').find('input[name="type"]').val();
        var _title = obj.attr('data-title');
        var _f_title = obj.attr('data-f-title');
        var _url = obj.attr('data-url');
        $('#title-'+_type).val(_title);
        $('#f_title-'+_type).val(_f_title);
        $('#url-'+_type).val(_url);
    });

    $('.save-btn').click(function(){
        var obj = $(this).closest('form');
        var _type = obj.find('input[name="type"]').val();
        var _title = $('#title-'+_type).val();
        var _f_title = $('#f_title-'+_type).val();
        var _url = $('#url-'+_type).val();
        var _this_pic_id = $('#add_recommend_pic').attr('data-pic-id');
        console.log(_title);
        console.log(_f_title);
        console.log(_url);
        console.log(_this_pic_id);
        var _data_obj = $('#pic_id_'+_this_pic_id);
        _data_obj.attr('data-title',_title);
        _data_obj.attr('data-f-title',_f_title);
        _data_obj.attr('data-url',_url);
        var _append_pic_info_str = getAppendPicInfoStr(_this_pic_id,_title,_f_title,_url);
        _data_obj.find('.image-data-box').remove();
        _data_obj.append(_append_pic_info_str);
    });
</script>