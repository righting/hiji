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
                <h3>编辑奖品</h3>
            </div>
        </div>
    </div>
        <div style="margin:50px 0px;padding:20px;width:41.5%;">
            <div class="layui-form layui-form-pane" >

               
                <div class="layui-form-item">
                    <label class="layui-form-label">奖品名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="prize_name" id="prize_name" value="<?php echo $output['info']['prize_name'];?>"  placeholder="请输入奖品名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">奖品概率</label>
                    <div class="layui-input-inline">
                        <input type="number" name="prize_percent" id="prize_percent" value="<?php if(!empty($output['info'])){ echo $output['info']['prize_percent'];}else{echo '0.00';}?>" placeholder="请输入奖品概率" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">七个奖品加起来不能超过100</div>
                </div>
				
				<div class="layui-form-item">
                    <label class="layui-form-label">奖品类型</label>
                    <div class="layui-input-inline">
                        <dd class="opt">
							<select id="dispose"  name="dispose" >
								<option value="1" <?php if ($output['info']['dispose']==1)  echo 'selected'?>>实物奖品</option>
								<option value="0" <?php if ($output['info']['dispose']!=1)  echo 'selected'?>>虚拟奖品</option>
							</select>
							<span class="err"></span>
							<p class="notic"></p>
						</dd>
                    </div>
                    <div class="layui-form-mid layui-word-aux">实物奖品需要后台人工处,虚拟奖品为自动处理</div>
                </div>
				<div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">奖励海吉币数量</label>
                    <div class="layui-input-inline">
                        <input type="number" name="prize_jf" id="prize_jf" value="<?php if(!empty($output['info'])){ echo $output['info']['prize_jf'];}else{echo '0';}?>"  placeholder="奖励海吉币数量" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">实物奖品可不填写</div>
                </div>
				<div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">奖励积分数量</label>
                    <div class="layui-input-inline">
                        <input type="number" name="prize_jf2" id="prize_jf2" value="<?php if(!empty($output['info'])){ echo $output['info']['prize_jf2'];}else{echo '0';}?>"  placeholder="奖励积分数量" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">实物奖品可不填写</div>
                </div>
				
                <div class="layui-form-item">
                    <label class="layui-form-label">奖品排序</label>
                    <div class="layui-input-inline">
                        <input type="number" name="prize_sort" id="prize_sort" value="<?php if(!empty($output['info'])){ echo $output['info']['prize_sort'];}else{echo '0';}?>"  placeholder="奖品排序" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">数字越大的排越前面</div>
                </div>

           

                <div class="layui-form-item">
                    <label class="layui-form-label">奖品图片</label>
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
                                <?php if(!empty($output['info']['prize_image'])){?>
                                <li>
                                    <div class="thumb-list-pics">
                                        <a href="javascript:void(0);">
                                            <img style="width:100px;height:100px;" src="<?php echo $output['info']['prize_image'];?>"/>
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
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn"  onclick="goodsSubmit()" lay-filter="formDemo">立即保存</button>
                    </div>
                </div>

            </div>
        </div>

<!--奖品图片-->
<input type="hidden" id="prize_image" value="<?php echo $output['info']['prize_image'];?>"/>
<input type="hidden" id="id" value="<?php echo $output['info']['id'];?>"/>

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
                url: 'index.php?controller=prize_goods&action=goods_pic_upload',
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
        $("#prize_image").val('<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>'+file_data.file_name);
		$('#thumbnails > ul').empty()
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

        var id = $('#id').val();
        var prize_name = $('#prize_name').val();
        var prize_percent = $('#prize_percent').val();
        var prize_sort =  $('#prize_sort').val();
        var prize_image = $('#prize_image').val();
		var dispose = $('#dispose').val();
		var prize_jf = $('#prize_jf').val();
		var prize_jf2 = $('#prize_jf2').val();
        var params ={};
        params.id = id;
        params.prize_name = prize_name;
        params.prize_percent = prize_percent;
        params.prize_sort = prize_sort;
		params.prize_image = prize_image;
		params.dispose = dispose;
		params.prize_jf = prize_jf;
		params.prize_jf2 = prize_jf2;

        if(prize_name==''){
            layer.msg('请输入奖品名称',{time:1500});
            return;
        }
        if(prize_image==''){
            layer.msg('请上传奖品图片',{time:1500});
            return;
        }


        layer.load();
        if(checkSubmit == 0){
            $("#checkSubmit").val(1);
            $.ajax({
                url: 'index.php?controller=prize_goods&action=edit_sub',
                data:params,
                type:'post',
                dataType: 'json',
                success:function(data){
                    layer.closeAll();
                    if(data.status==1){
                        layer.msg(data.msg,{icon:1});
                        setTimeout(function(){
                            if(data.msg=='修改成功'){
                                window.location.href="index.php?controller=prize_goods&action=index"
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