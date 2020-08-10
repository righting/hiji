<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div class="banner">
  <div class="user-box">

    <div class="user-joinin">
      <h3>亲爱的：<?php echo $_SESSION['member_name'];?></h3>
      <dl>
        <dt><?php echo $lang['welcome_to_site'].$output['setting_config']['site_name']; ?></dt>
        <dd> 若您还没有填写入驻申请资料<br/>
          请点击“<a mxf="sqde" href="<?php echo urlShop('store_joinin', 'step0');?>" target="_blank">我要入驻</a>”进行入驻资料填写</dd>
        <dd>若您的店铺还未开通<br/>
          请通过“<a href="javascript:;"  onclick="javascript:show_dialog1('search_progress');">查看入驻进度</a>”了解店铺开通的最新状况 </dd>
      </dl>
      <div class="bottom"><a href="<?php echo urlShop('store_joinin', 'step0');?>" target="_blank">我要入驻</a><a href="javascript:;" onclick="javascript:show_dialog1('search_progress');" >查看入驻进度</a></div>
    </div>

  </div>
  <ul id="fullScreenSlides" class="full-screen-slides">
    <?php $pic_n = 0;?>
    <?php if(!empty($output['pic_list']) && is_array($output['pic_list'])){ ?>
    <?php foreach($output['pic_list'] as $key => $val){ ?>
    <?php if(!empty($val)){ $pic_n++; ?>
    <li style="background-color: #F1A595; background-image: url(<?php echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/'.$val;?>)" ></li>
    <?php } ?>
    <?php } ?>
    <?php } ?>
  </ul>
</div>
<!--弹出框-->
 <div id="search_progress_dialog"  style="display:none;">
     <form style="padding: 10px"" id="form_company_info" action="<?php echo urlShop('store_joinin','search_progress') ?>" method="post">
         <table border="0" cellpadding="0" cellspacing="0" class="all">
             <thead>
             <tr>
                 <th colspan="2">入驻信息查询</th>
             </tr>
             </thead>
             <tbody>
             <tr style="height: 40px;">
                 <th><i>*</i>绑定手机号：</th>
                 <td>
                     <input name="mobile" type="text" class="w200"/>
                     <span></span>
                 </td>
             </tr>
             <tr>
                 <th><i>*</i>邀请人 ID：</th>
                 <td>
                     <input name="invite_id" type="text" class="w200"/>
                     <span></span>
                 </td>
             </tr>
             </tbody>
         </table>
         <button type="submit"  style="margin: 5px 100px ">提交查询</button>
     </form>

 </div>
<!--弹出框结束-->
<div class="indextip">
  <div class="container"> <span class="title"><i></i>
    <h3>贴心提示</h3>
    </span> <span class="content"><?php echo $output['show_txt'];?></span></div>
</div>
<div class="main mt30">
  <h2 class="index-title">入驻流程</h2>
  <div class="joinin-index-step"><span class="step"><i class="a"></i>签署入驻协议</span><span class="arrow"></span><span class="step"><i class="b"></i>商家信息提交</span><span class="arrow"></span><span class="step"><i class="c"></i>平台审核资质</span><span class="arrow"></span><span class="step"><i class="d"></i>商家缴纳费用</span><span class="arrow"></span><span class="step"><i class="e"></i>店铺开通</span></div>
  <h2 class="index-title">入驻指南</h2>
  <div class="joinin-info">
    <ul class="tabs-nav">
      <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ $i = 0;?>
      <?php foreach($output['help_list'] as $key => $val){ $i++;?>
      <li class="<?php echo $i==1 ? 'tabs-selected':'';?>">
        <h3><?php echo $val['help_title'];?></h3>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
      <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ $i = 0;?>
      <?php foreach($output['help_list'] as $key => $val){ $i++;?>
    <div class="tabs-panel <?php echo $i==1 ? '':'tabs-hide';?>"><?php echo $val['help_info'];?></div>
      <?php } ?>
      <?php } ?>
  </div>
</div>
<script>
$(document).ready(function(){
	$("#login_form ").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
		rules: {
			user_name: "required",
			password: "required"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : 'index.php?controller=seccode&action=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            }
			<?php } ?>
		},
		messages: {
			user_name: "用户名不能为空",
			password: "密码不能为空"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : '验证码不能为空',
                minlength: '验证码不能为空',
				remote	 : '验证码错误'
            }
			<?php } ?>
		}
	});
});

function show_dialog1(id) {//弹出框js
    var d = DialogManager.create(id);//不存在时初始化(执行一次)
    var  dialog_html= $("#" + id + "_dialog").html();

    var dialog_html_out=$("#" + id + "_dialog").detach();
    d.setTitle('商家入驻审核查询');
    d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
    d.setWidth(320);
    d.show('center', 1);
    $('body').append(dialog_html_out);
}
</script>
<?php if( $pic_n > 1) { ?>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<?php }else { ?>
<script>
$(document).ready(function(){
    $(".tabs-nav > li > h3").bind('mouseover', (function(e) {
    	if (e.target == this) {
    		var tabs = $(this).parent().parent().children("li");
    		var panels = $(this).parent().parent().parent().children(".tabs-panel");
    		var index = $.inArray(this, $(this).parent().parent().find("h3"));
    		if (panels.eq(index)[0]) {
    			tabs.removeClass("tabs-selected").eq(index).addClass("tabs-selected");
    			panels.addClass("tabs-hide").eq(index).removeClass("tabs-hide");
    		}
    	}
    }));
});
</script>
<?php } ?>
