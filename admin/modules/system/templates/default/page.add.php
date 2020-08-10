<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?controller=help&action=help" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3><?php echo $lang['help_index_manage'];?> - <?php echo $lang['nc_new'];?>单页</h3>
        <h5><?php echo $lang['help_index_manage_subhead'];?></h5>
      </div>
    </div>
  </div>
  <form id="page_form" method="post" name="pageForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label><em>*</em><?php echo $lang['help_index_title'];?></label>
        </dt>
        <dd class="opt">
          <input type="text" value="" name="page_title" id="page_title" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>

      <dl class="row" nctype="page_position" style="display: none">
        <dt class="tit">
          <label>出现位置</label>
        </dt>
        <dd class="opt">
          <input id="page_position1" name="page_position" checked="checked" value="1" type="radio">
          <label for="page_position1" ><span>商城前台</span></label>
          <input id="page_position2" name="page_position" value="2" type="radio">
          <label for="page_position2" ><span>买家中心</span></label>
          <input id="page_position3" name="page_position" value="3" type="radio">
          <label for="page_position3" ><span>商家中心</span></label>
          <input id="page_position4" name="page_position" value="4" type="radio">
          <label for="page_position4" ><span>全站</span></label>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="pageForm"><?php echo $lang['help_add_url'];?></label>
        </dt>
        <dd class="opt">
          <input type="text" value="" name="page_url" id="page_url" class="input-txt">
          <span class="err"></span>
          <p class="notic"><?php echo $lang['help_add_url_tip'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['help_add_show'];?></label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="page_show1" class="cb-enable selected" ><?php echo $lang['nc_yes'];?></label>
            <label for="page_show0" class="cb-disable" ><?php echo $lang['nc_no'];?></label>
            <input id="page_show1" name="page_show" checked="checked" value="1" type="radio">
            <input id="page_show0" name="page_show" value="0" type="radio">
          </div>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">页面</dt>
        <dd class="opt">
          <select name="page_key" id="page_key">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>
            <?php if(!empty($output['page_key_name']) && is_array($output['page_key_name'])){ ?>
            <?php foreach($output['page_key_name'] as $pkk => $pkv){ ?>
            <option <?php if($output['page_array']['page_key'] == $pkv['keys']){ ?>selected='selected'<?php } ?> value="<?php echo $pkv['keys'];?>"><?php echo $pkv['name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </dd>
      </dl>
      
	  <dl class="row">
        <dt class="tit">
          <label for="cate_id"><em>*</em>类型</label>
        </dt>
        <dd class="opt">
          <select name="page_type" id="page_type">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>
            <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
            <?php foreach($output['parent_list'] as $k => $v){ ?>
            <option <?php if($output['ac_id'] == $v['ac_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['ac_id'];?>"><?php echo $v['ac_name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <span class="err"></span>
          <p class="notic">当选择发布“商城公告”时，还需要设置下面的“出现位置”项</p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><em>*</em><?php echo $lang['help_add_content'];?></label>
        </dt>
        <dd class="opt">
          <?php showEditor('page_content');?>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit"><?php echo $lang['help_add_upload'];?></dt>
        <dd class="opt">
          <div class="input-file-show" id="divComUploadContainer"><span class="type-file-box">
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
                <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');" class="del" title="<?php echo $lang['nc_del'];?>">X</a><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');" class="inset"><i class="fa fa-trash"></i>插入图片</a> </li>
              <?php } ?>
              <?php } ?>
            </ul>
          </div>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#page_form").valid()){
     $("#page_form").submit();
	}
	});
});

$(document).ready(function(){
	$('#ac_id').on('change',function(){
		if($(this).val() == '1') {
			$('dl[nctype="page_position"]').show();
		}else{
			$('dl[nctype="page_position"]').hide();
		}
	});
	$('#page_form').validate({
        errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            page_title : {
                required   : true
            },

			page_url : {
				url : true
            },
			page_content : {
                required   : function(){
                    return $('#page_url').val() == '';
                }
            },

        },
        messages : {
            page_title : {
                required : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['help_add_title_null'];?>'
            },

			page_url : {
				url : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['help_add_url_wrong'];?>'
            },
			page_content : {
                required : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['help_add_content_null'];?>'
            },

        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?controller=page&action=page_pic_upload',
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
    var newImg = '<li id="' + file_data.file_id + '"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_page.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '"/></a></div><a href="javascript:del_file_upload(' + file_data.file_id + ');" class="del" title="<?php echo $lang['nc_del'];?>">X</a><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_page.'/';?>' + file_data.file_name + '\');" class="inset"><i class="fa fa-clipboard"></i>插入图片</a></li>';
    $('#thumbnails > ul').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('page_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?controller=page&action=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['help_add_del_fail'];?>');
        }
    });
}


</script>