<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?controller=banner_list&action=index" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>-新增广告</h3>
        <h5>新增广告</h5>
      </div>
    </div>
  </div>
  <form id="article_form" method="post" name="articleForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
        <dl class="row">
            <dt class="tit">
                <label for="cate_id"><em>*</em>所属分组</label>
            </dt>
            <dd class="opt">
                <select name="ac_id" id="ac_id">
                    <option value=""><?php echo $lang['nc_please_choose'];?></option>
                    <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
                        <?php foreach($output['parent_list'] as $k => $v){ ?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['cate_name'];?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <span class="err"></span>
                <p class="notic"></p>
            </dd>
        </dl>

        <dl class="row">
            <dt class="tit">
                <label for="articleForm">标题</label>
            </dt>
            <dd class="opt">
                <input type="text" value="" name="title" id="title" class="input-txt">
                <span class="err"></span>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label for="articleForm">广告时间</label>
            </dt>
            <dd class="opt">
                <input type="date" value=""  style="width:140px;" name="start_time"> -- <input type="date" style="width:140px;" name="end_time" value=""  >
                <span class="err"></span>
                <p class="notic">选择广告的开始时间以及结束时间</p>
            </dd>
        </dl>

        <dl class="row">
            <dt class="tit">图片</dt>
            <dd class="opt">
                <div class="input-file-show" id="divComUploadContainer"><span class="type-file-box">
            <input class="type-file-file" id="fileupload" name="fileupload" type="file" size="30" multiple hidefocus="true" title="点击按钮选择文件上传">
            <input type="text" name="text" id="text" class="type-file-text" />
            <input type="button" name="button" id="button" value="选择上传..." class="type-file-button" />
            </span></div>
                <div id="thumbnails" class="ncap-thumb-list">
                    <ul>
                        <?php if(is_array($output['file_upload'])){?>
                            <?php foreach($output['file_upload'] as $k => $v){ ?>
                                <li id="<?php echo $v['upload_id'];?>" style="margin-top:10px;">
                                    <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                                    <div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>"/></a></div>
                                    <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');" class="del" title="<?php echo $lang['nc_del'];?>">X</a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </dd>
        </dl>

        <input type="hidden" value="" name="img" id="img"/>

      <dl class="row">
        <dt class="tit">
          <label for="articleForm">图片链接</label>
        </dt>
        <dd class="opt">
          <input type="text" value="" name="img_link" id="img_link" class="input-txt">
          <span class="err"></span>
          <p class="notic">当填写"链接"后点击广告图将直接跳转至链接地址。链接格式请以http://开头</p>
        </dd>
      </dl>

        <dl class="row">
            <dt class="tit">
                <label for="articleForm">排序</label>
            </dt>
            <dd class="opt">
                <input type="text" value="255" name="sort" id="sort" class="input-txt">
                <span class="err"></span>
                <p class="notic">数字越小越靠前</p>
            </dd>
        </dl>

        <dl class="row">
            <dt class="tit">
                <label>是否显示</label>
            </dt>
            <dd class="opt">
                <div class="onoff">
                    <label for="status1" class="cb-enable selected" ><?php echo $lang['nc_yes'];?></label>
                    <label for="status0" class="cb-disable" ><?php echo $lang['nc_no'];?></label>
                    <input id="status1" name="status" checked="checked" value="1" type="radio">
                    <input id="status0" name="status" value="0" type="radio">
                </div>
                <p class="notic"></p>
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
    if($("#article_form").valid()){
     $("#article_form").submit();
	}
	});
});

$(document).ready(function(){
	$('#ac_id').on('change',function(){
		if($(this).val() == '1') {
			$('dl[nctype="article_position"]').show();
		}else{
			$('dl[nctype="article_position"]').hide();
		}
	});
	$('#article_form').validate({
        errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
			ac_id : {
                required   : true
            }
        },
        messages : {
			ac_id : {
                required : '<i class="fa fa-exclamation-circle"></i>请选择所属分组'
            }
        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?controller=article&action=article_pic_upload',
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
    var newImg = '<li id="' + file_data.file_id + '" style=margin-top:10px;><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="thumb-list-pics"><a href="javascript:void(0);"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '"/></a></div><a href="javascript:del_file_upload(' + file_data.file_id + ');" class="del" title="<?php echo $lang['nc_del'];?>">X</a></li>';
    $('#img').val('<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name);
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
    $.getJSON('index.php?controller=article&action=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['article_add_del_fail'];?>');
        }
    });
}


</script>