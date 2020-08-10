<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="essential">
    <div class="essential-nav">
        <?php include template('layout/submenu');?>
    </div>
    <form method="post" id="profile_form" action="<?php echo urlMember('member_information','member') ?>">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
        <input type="hidden" name="member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
        <input type="hidden" name="area_ids" id="area_ids" value="" />
        <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="province_id" id="_area_1">
        <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="city_id" id="_area_2">
        <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="area_id" id="_area_3">
    <div class="essential-detail">
        <div class="essential-detail-top">
            <label><img style="width: 90px;height: 90px;margin-top: -3px;" id="header_pic" src="<?php echo empty($output['member_info']['member_avatar'])?MEMBER_TEMPLATES_URL.'/images/tx.png':$output['member_info']['member_avatar']; ?>"></label>
            <button style="margin-left: 10px" type="button" id="upHeaderPic" class="essential-sc"><i class="fa fa-upload"> </i>头像上传</button>
            <input style="display: none" type="file" hidefocus="true" size="1" class="input-file" name="pic" id="pic_header" file_id="0" multiple="" />
            </a>
            <span>完善个人信息资料，上传头像图片有助于您结识更多的朋友.</span>
            <em>头像默认尺寸为120*120，请根据系统操作提示进行裁剪并生效. </em>
        </div>

        <div class="essential-detail-center">
            <div class="essential-line">
                <label>* 用户名称：</label>
                <span><?php echo $output['member_info']['member_name']; ?><em><?php echo $output['member_info']['level_name']; ?></em></span>
            </div>

            <div class="essential-line">
                <label>邮箱：</label>
                <span><?php echo $output['member_info']['member_email']; ?>&nbsp;&nbsp;<a href="<?php echo urlMember('member_security','auth',['type'=>'modify_email']) ?>"><?php if ($output['member_info']['member_email_bind'] == '1') { ?>更换邮箱<?php } else { ?>绑定邮箱<?php } ?></a></span>
            </div>
            <div class="essential-line">
                <label>手机号：</label>
                <?php if ($output['member_info']['member_mobile']){ ?>
                    <span><?php echo $output['member_info']['member_mobile']; ?></span>
                <?php }else{?>
               <input type="text" name="member_mobile" value="" />
                <?php }?>
            </div>
            <div class="essential-line">
                <label>微信号：</label>
                <input type="text" name="member_weixin" value="<?php echo $output['member_info']['member_weixin']; ?>" />
            </div>
            <div class="essential-line">
                <label>QQ号：</label>
                <input type="text" name="member_qq" value="<?php echo $output['member_info']['member_qq']; ?>" />
            </div>
            <div class="essential-line">
                <label>* 性别：</label>
                <span>

                    <label>
              <input type="radio" name="member_sex" value="3" <?php if($output['member_info']['member_sex']==3 or ($output['member_info']['member_sex']!=2 and $output['member_info']['member_sex']!=1)) { ?>checked="checked"<?php } ?> />
                        <?php echo $lang['home_member_secret'];?></label>
            &nbsp;&nbsp;
            <label>
              <input type="radio" name="member_sex" value="2" <?php if($output['member_info']['member_sex']==2) { ?>checked="checked"<?php } ?> />
                <?php echo $lang['home_member_female'];?></label>
            &nbsp;&nbsp;
            <label>
              <input type="radio" name="member_sex" value="1" <?php if($output['member_info']['member_sex']==1) { ?>checked="checked"<?php } ?> />
                <?php echo $lang['home_member_male'];?></label>
            </span><span>
            </span>
            </div>

            <div class="essential-line">
                <label>生日：</label>
                <span>
                <input type="text" class="text essential-line-input" name="birthday" maxlength="10" id="birthday" value="<?php echo $output['member_info']['member_birthday']; ?>" />
                </span>
            </div>

            <div class="essential-line">
                <label>所在地区：</label>
                <span>
                    <input class="essential-line-input" type="hidden" name="region" id="region" value="<?php echo $output['member_info']['member_areainfo']; ?>" />
				</span>
            </div>

            <div class="essential-line">
                <label>用户昵称 ：</label>
                <span>
                    <input type="text" class="text essential-line-input" maxlength="30" name="member_nickname" value="<?php echo $output['member_info']['member_nickname']; ?>" />
				</span>
            </div>
        </div>
        <a href="javascript:;" onclick="$('#profile_form').submit();"  class="essential-detail-button"><?php echo $lang['home_member_save_modify'];?></a>
    </div>
    </form>
</div>
<style>
    .essential-line span{width:44%}
</style>
<script type="text/javascript">
    //注册表单验证
    $(function(){
        $('#upHeaderPic').on('click', function(e) {
            e.preventDefault();
            $("#pic_header").trigger('click');
        })
        $("#region").nc_region({show_deep:3,btn_style_html:'style="background-color: #F5F5F5; width: 60px; height: 32px; border: solid 1px #E7E7E7; cursor: pointer"'});
        $('#birthday').datepicker({dateFormat: 'yy-mm-dd'});

        $('#profile_form').validate({
            submitHandler:function(form){
                ajaxpost('profile_form', '', '', 'onerror')
            },
//            rules : {
//                real_name : {
//                    required : true,
//                    minlength : 2,
//                    maxlength : 20
//                },
//                member_id_number : {
//                    required : true,
//                    minlength : 15,
//                    maxlength : 18
//                }
//            },
//            messages : {
//                real_name : {
//                    required : '请填写你的姓名',
//                    minlength : '<?php //echo $lang['home_member_username_range'];?>//',
//                    maxlength : '<?php //echo $lang['home_member_username_range'];?>//'
//                },
//                member_id_number  : {
//                    required : '请填写你的身份证号码',
//                    minlength : '<?php //echo $lang['home_member_input_idcard'];?>//',
//                    maxlength : '<?php //echo $lang['home_member_input_idcard'];?>//'
//                }
//            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script type="text/javascript">
    $('#pic_header').live('change',function(){//用户头像上传
        ajaxImageUpload('pic_header');
    });
    /*ajax文件上传*/
    function ajaxImageUpload(fileElementId){
        $.ajaxFileUpload
        (
            {
                url:'<?php echo urlMember('member_information','upload') ?>',
                type:'post',
                data: {form_submit: 'ok'},
                secureuri:false,
                fileElementId:fileElementId,
                dataType: 'json',
                success: function (data)
                {
                    if (data.status == 1){
                        var path = data.msg.replace(/&amp;/g,'\&');
                        $("input[name='member_avatar']").val(path);
                        $("#header_pic").attr('src',path);
                    }else{
                        alert(data.msg);
                    }
                },
                error: function (data)
                {
                    alert('上传失败');
                }
            }
        )
    }
</script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>