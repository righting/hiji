<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?controller=banner_category&action=index" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>-新增分类</h3>
        <h5>新增分类</h5>
      </div>
    </div>
  </div>
  <form id="article_form" method="post" name="articleForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
        <dl class="row">
            <dt class="tit">
                <label for="articleForm">分类名称</label>
            </dt>
            <dd class="opt">
                <input type="text" value="" name="title" id="title" class="input-txt">
                <span class="err"></span>
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
	$('#article_form').validate({
        errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
			title : {
                required   : true
            }
        },
        messages : {
			title : {
                required : '<i class="fa fa-exclamation-circle"></i>名称不能为空'
            }
        }
    });
});



</script>