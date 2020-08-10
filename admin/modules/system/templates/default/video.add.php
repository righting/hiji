<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?controller=video&action=video" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3><?php echo $lang['help_index_manage'];?> - <?php echo $lang['nc_new'];?>视频</h3>
        <h5><?php echo $lang['help_index_manage_subhead'];?></h5>
      </div>
    </div>
  </div>
  <form id="page_form" method="post" name="pageForm" enctype="multipart/form-data">
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

        <dl class="row">
            <dt class="tit">
                <label><em>*</em>排序</label>
            </dt>
            <dd class="opt">
                <input type="text" value="" name="sort" id="sort" class="input-txt">
                <span class="err"></span>
                <p class="notic"></p>
            </dd>
        </dl>


      <dl class="row">
        <dt class="tit">期数</dt>
        <dd class="opt">
          <select name="periods" id="page_key">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>

              <option <?php if($output['page_array']['periods'] == 1){ ?>selected='selected'<?php } ?> value="1">第1期</option>
              <option <?php if($output['page_array']['periods'] == 2){ ?>selected='selected'<?php } ?> value="2">第2期</option>
              <option <?php if($output['page_array']['periods'] == 3){ ?>selected='selected'<?php } ?> value="3">第3期</option>
              <option <?php if($output['page_array']['periods'] == 4){ ?>selected='selected'<?php } ?> value="4">第4期</option>
              <option <?php if($output['page_array']['periods'] == 5){ ?>selected='selected'<?php } ?> value="5">第5期</option>
              <option <?php if($output['page_array']['periods'] == 6){ ?>selected='selected'<?php } ?> value="6">第6期</option>

          </select>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">类型</dt>
        <dd class="opt">
          <select name="video_type" id="video_type">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>
            <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
            <?php foreach($output['parent_list'] as $k => $v){ ?>
            <option <?php if($output['ac_id'] == $v['ac_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['ac_id'];?>"><?php echo $v['ac_name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </dd>
      </dl>
        <dl class="row">
            <dt class="tit">
                <label for="login_pic1">视频封面</label>
            </dt>
            <dd class="opt">
                <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.'/video/'.$output['page_array']['video_img']);?>"><i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.$output['page_array']['video_img']);?>>')" onMouseOut="toolTip()"></i></a></span><span class="type-file-box">
            <input name="login_pic1" type="file" class="type-file-file" id="login_pic1" size="30" hidefocus="true" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效"/>
            </span></div>
                <p class="notic">请使用450*350像素jpg/gif/png格式的图片。</p>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label><em>*</em>视频</label>
            </dt>
            <dd class="opt">
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000000">

                <input type=file name=video size=20>
            </dd>
        </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>

<script type="text/javascript">
    // 模拟网站LOGO上传input type='file'样式
    $(function(){
        var textButton1="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='选择上传...' class='type-file-button' />"

        $(textButton1).insertBefore("#login_pic1");

        $("#login_pic1").change(function(){$("#textfield1").val($("#login_pic1").val());});

// 上传图片类型
        $('input[class="type-file-file"]').change(function(){
            var filepath=$(this).val();
            var extStart=filepath.lastIndexOf(".");
            var ext=filepath.substring(extStart,filepath.length).toUpperCase();
            if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
                alert("<?php echo $lang['default_img_wrong'];?>");
                $(this).attr('value','');
                return false;
            }
        });

        $('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');
        $('.nyroModal').nyroModal();
    });
</script>
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




        },
        messages : {
            page_title : {
                required : '<i class="fa fa-exclamation-circle"></i><?php echo $lang['help_add_title_null'];?>'
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