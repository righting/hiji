<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="<?php echo urlAdminSystem('exhibition','index');?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3><?php echo (isset($output['info']['id']) ? $lang['nc_edit'].'内容“'.$output['info']['title'].'”' : $lang['nc_add']);?></h3>
      </div>
    </div>
  </div>
  <form id="form" method="post" action="<?php echo urlAdminSystem('exhibition','save');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $output['info']['id'];?>" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label><em>*</em><?php echo $lang['document_index_title'];?></label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['info']['title'];?>" name="title" id="title" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>

        <?php if(!isset($output['info']['id'])){ ?>
        <dl class="row">
            <dt class="tit">
                <label><em>*</em>调用标识码</label>
            </dt>
            <dd class="opt">
                <input type="text" name="code" id="code" class="input-txt">
                <span class="err"></span>
                <p class="notic"></p>
            </dd>
        </dl>
        <?php } ?>
      <dl class="row">
        <dt class="tit">
          <label><em>*</em><?php echo $lang['document_index_content'];?></label>
        </dt>
        <dd class="opt">
          <?php showEditor('content',$output['info']['content']);?>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit"><?php echo $lang['document_index_pic_upload'];?></dt>
        <dd class="opt" id="divComUploadContainer">
          <div class="input-file-show"><span class="type-file-box">
            <input class="type-file-file" id="fileupload" name="fileupload" type="file" size="30" multiple hidefocus="true" title="点击按钮选择文件上传">
            <input type="text" name="text" id="text" class="type-file-text" />
            <input type="button" name="button" id="button" value="选择上传..." class="type-file-button" />
            </span></div>
          <div id="thumbnails" class="ncap-thumb-list">
            <h5><i class="fa fa-exclamation-circle"></i>上传后的图片可以插入到富文本编辑器中使用，无用附件请手动删除，如不处理系统会始终保存该附件图片。</h5>
            <ul>
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>">
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>"/></a></div>
                <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');" class="del" title="<?php echo $lang['nc_del'];?>">X</a><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');" class="inset"><i class="fa fa-clipboard"></i>插入图片</a> </li>
              <?php } ?>
              <?php } ?>
            </ul>
          </div>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a> </div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#form").valid()){
     $("#form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#form').validate({
        errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            title : {
                required   : true
            },
			content : {
                required   : true
            }
        },
        messages : {
            title : {
                required : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['document_index_title_null'];?>'
            },
			dcontent : {
                required : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['document_index_content_null'];?>'
            }
        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',

            url: "<?php echo urlAdminSystem('exhibition','pic_upload',['item_id'=>$output['info']['id']]);?>",
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
    var newImg = '<li id="' + file_data.file_id + '"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '"/></a></div><a href="javascript:del_file_upload(' + file_data.file_id + ');" class="del" title="<?php echo $lang['nc_del'];?>">X</a><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');" class="inset"><i class="fa fa-clipboard"></i>插入图片</a></li>';
    $('#thumbnails > ul').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }

    $.getJSON('index.php?controller=exhibition&action=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('删除失败');
        }
    });
}
</script>