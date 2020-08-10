<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/layui.js"></script>

<style>
    input.password, input.text, input[type=password], input[type=text]{
        height:38px;
    }
</style>
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>新增/编辑积分(海吉币)商品</h3>
            </div>
        </div>
    </div>
        <div style="margin:50px 0px;padding:20px;width:41.5%;">
            <div class="layui-form layui-form-pane" >

                <div class="layui-form-item">
                    <label class="layui-form-label">商品分类</label>
                    <div class="layui-input-block">
                        <select name="cid" id="cId">
                            <option value=""></option>
                            <?php foreach ($output['cateInfo'] as $k=>$v){?>
                                <option <?php if($output['info']['gc_id']==$v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['cate_name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商品名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="goodsName" id="goodsName" value="<?php echo $output['info']['goods_name'];?>"  placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">出售价格</label>
                    <div class="layui-input-inline">
                        <input type="number" name="goodsPrice" id="goodsPrice" value="<?php if(!empty($output['info'])){ echo $output['info']['goods_price'];}else{echo '0.00';}?>" placeholder="请输入商品价格" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">价格在1-9999999之间</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">使用积分</label>
                    <div class="layui-input-inline">
                        <input type="number" name="goodsPoint" id="goodsPoint" value="<?php if(!empty($output['info'])){ echo $output['info']['goods_integral'];}else{echo '0';}?>"  placeholder="兑换商品时使用的积分" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">积分兑换商品时使用、为0表示不需要积分支付</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">海吉币</label>
                    <div class="layui-input-inline">
                        <input type="number" name="goodsHjb" id="goodsHjb" value="<?php if(!empty($output['info'])){ echo $output['info']['goods_hjb'];}else{echo '0';}?>" placeholder="请输入海吉币" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">海吉币兑换商品时使用、为0表示不需要海吉币支付</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">商品库存</label>
                    <div class="layui-input-inline">
                        <input type="number" name="inventory" id="inventory" value="<?php if(!empty($output['info'])){ echo $output['info']['goods_storage'];}else{echo '0';}?>" placeholder="商品库存不足时不会显示" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">商品库存</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">商品主图</label>
                    <div class="layui-input-block">
                        <!--<input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">-->
                        <div class="input-file-show" id="divComUploadContainer">
                            <span class="type-file-box" style="height:36px;">
                                <input style="height:36px;" class="type-file-file" id="fileupload" name="fileupload" type="file" size="30" multiple hidefocus="true" title="点击按钮选择文件上传">
                                <input type="text" name="text" id="text" class="type-file-text" />
                                <input style="height:36px;" type="button" name="button" id="button" value="选择上传..." class="type-file-button" />
                            </span>
                        </div>
                        <div id="thumbnails" class="ncap-thumb-list">
                            <ul>
                                <?php if(!empty($output['info']['goods_image'])){?>
                                <li>
                                    <div class="thumb-list-pics">
                                        <a href="javascript:void(0);">
                                            <img style="width:100px;height:100px;" src="<?php echo $output['info']['goods_image'];?>"/>
                                        </a>
                                    </div>
                                </li>
                                <?php }?>
                                <?php if(is_array($output['file_upload'])){?>
                                    <?php foreach($output['file_upload'] as $k => $v){ ?>
                                        <li id="<?php echo $v['upload_id'];?>">
                                            <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                                            <div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>"/></a></div>
                                            <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');" class="del" title="<?php echo $lang['nc_del'];?>">X</a><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');" class="inset"><i class="fa fa-trash"></i>插入图片</a> </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">商品描述</label>
                    <div class="layui-input-block">
                        <textarea name="desc" id="goodsDesc" placeholder="请输入内容" class="layui-textarea"><?php if(!empty($output['info'])){ echo $output['info']['goods_jingle'];}?></textarea>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">商品详情</label>
                    <div class="layui-input-block" id="goodsDetails">
                        <?php showEditor('goods_desc',$output['info']['goods_body']);?>
                    </div>
                </div>


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn"  onclick="goodsSubmit()" lay-filter="formDemo">立即保存</button>
                    </div>
                </div>

            </div>
        </div>

<!--商品图片-->
<input type="hidden" id="goodsImage" value="<?php echo $output['info']['goods_image'];?>"/>
<input type="hidden" id="goodsId" value="<?php echo $output['info']['goods_id'];?>"/>

<input type="hidden" id="checkSubmit" value="0"/>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script>
    layui.use('form', function(){
        var form = layui.form;
    });
    $(function(){
        // 图片上传
        $('#fileupload').each(function(){
            $(this).fileupload({
                dataType: 'json',
                url: 'index.php?controller=jfgoods_add&action=goods_pic_upload',
                done: function (e,data) {
                    if(data != 'error'){
                        add_uploadedfile(data.result);
                    }
                }
            });
        });
    });

    function add_uploadedfile(file_data)
    {
        var newImg = '<li id="' + file_data.file_id + '"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '"/></a></div><a href="javascript:del_file_upload(' + file_data.file_id + ');" class="del" title="<?php echo $lang['nc_del'];?>">X</a></li>';
        $("#goodsImage").val('<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>'+file_data.file_name);
        $('#thumbnails > ul').prepend(newImg);
    }

    function insert_editor(file_path){
        KE.appendHtml('article_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
    }

    function del_file_upload(file_id)
    {
        if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
            return;
        }
        $('#' + file_id).remove();
    }




    function goodsSubmit(){
        var checkSubmit = $("#checkSubmit").val();

        var goodsId = $('#goodsId').val();
        var gcId = $('#cId').val();
        var goodsName = $('#goodsName').val();
        var goodsPrice = $('#goodsPrice').val();
        var goodsPoint =  $('#goodsPoint').val();
        var goodsHjb  = $('#goodsHjb').val();
        var inventory = $('#inventory').val();
        var goodsDesc = $('#goodsDesc').val();
        var goodsDetails = $("iframe").contents().find("body").html();
        var goodsImage = $('#goodsImage').val();

        var params ={};
        params.goodsId = goodsId;
        params.gcId = gcId;
        params.goodsName = goodsName;
        params.goodsPrice = goodsPrice;
        params.goodsPoint = goodsPoint;
        params.goodsHjb = goodsHjb;
        params.goodsImage = goodsImage;
        params.inventory = inventory;
        params.goodsDesc = goodsDesc;
        params.goodsDetails = goodsDetails;

        if(goodsName==''){
            layer.msg('请输入商品名称',{time:1500});
            return;
        }


        if(goodsPrice=='' || goodsPrice < 1 ){
            layer.msg('请输入商品价格',{time:1500});
            return;
        }


        if(goodsImage==''){
            layer.msg('请上传商品主图',{time:1500});
            return;
        }


        layer.load();
        if(checkSubmit == 0){
            $("#checkSubmit").val(1);
            $.ajax({
                url: 'index.php?controller=jfgoods_add&action=addGoods',
                data:params,
                type:'post',
                dataType: 'json',
                success:function(data){
                    layer.closeAll();
                    if(data.status==1){
                        layer.msg(data.msg,{icon:1});
                        setTimeout(function(){
                            if(data.msg=='修改成功'){
                                window.location.href="index.php?controller=jfgoods_online&action=index"
                            }else{
                                window.location.reload();
                            }
                        },1000)
                    }else{
                        $("#checkSubmit").val(0);
                        layer.msg(data.msg,{icon:5})
                    }
                }
            });

        }


    }


</script>