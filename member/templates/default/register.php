<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<div class="nc-register-bg">
    <div class="nc-register-box">
        <div class="nc-register-layout">
            <div class="left">
                <div class="nc-register-mode">
                    <ul class="tabs-nav">
                        <li><a href="#default">账号注册<i></i></a></li>
                        <?php if (C('sms_register') == 1) { ?>
                            <li><a href="#mobile">手机注册<i></i></a></li>
                        <?php } ?>
                    </ul>
                    <div id="tabs_container" class="tabs-container">
                        <div id="default" class="tabs-content">
                            <form id="register_form" method="post" class="nc-login-form"
                                  action="<?php echo urlLogin('login', 'usersave'); ?>">
                                <?php Security::getToken(); ?>
                                <dl>
                                    <dt><?php echo $lang['login_register_username']; ?>：</dt>
                                    <dd>
                                        <input type="text" id="user_name" name="user_name" class="text"
                                               tipMsg="<?php echo $lang['login_register_username_to_login']; ?>"/>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><?php echo $lang['login_register_pwd']; ?>：</dt>
                                    <dd>
                                        <input type="password" id="password" name="password" class="text"
                                               tipMsg="<?php echo $lang['login_register_password_to_login']; ?>"/>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><?php echo $lang['login_register_ensure_password']; ?>：</dt>
                                    <dd>
                                        <input type="password" id="password_confirm" name="password_confirm"
                                               class="text"
                                               tipMsg="<?php echo $lang['login_register_input_password_again']; ?>"/>
                                    </dd>
                                </dl>
                                <dl class="mt15">
                                    <dt><?php echo $lang['login_register_email']; ?>：</dt>
                                    <dd>
                                        <input type="text" id="email" name="email" class="text"
                                               tipMsg="<?php echo $lang['login_register_input_valid_email']; ?>"/>
                                    </dd>
                                </dl>

                                <?php if ($output['invite_member_info']['member_id'] > 0) { ?>
                                    <dl class="mt15">
                                        <dt>邀请人ID：</dt>
                                        <dd>
                                            <input type="text" id="invite_member_id" name="invite_member_id" readonly="readonly" value="<?php echo $output['invite_member_info']['member_number']; ?>"  class="text w150" size="10" tipMsg="邀请人ID"/>
                                        </dd>
                                    </dl>
                                    <!--<dl class="mt15">
                                        <dt>真实姓名：</dt>
                                        <dd>
                                            <input type="text" name="real_name"  value=""  class="text "  tipMsg="请输入你的真实姓名"/>
                                        </dd>
                                    </dl>
                                    <dl class="mt15">
                                        <dt>身份证号：</dt>
                                        <dd>
                                            <input type="text" name="member_id_number" value=""  class="text "  tipMsg="你的身份证号码"/>
                                        </dd>
                                    </dl>
                                    <dl class="mt15">
                                        <dt>身份证照：</dt>
                                        <dd>
                                            <div class="ncm-upload-btn"> <a class="a-upload" href="javascript:void(0);"><span>
                                                        <input type="hidden" value="" name="id_card_photo" id="id_card_photo" />
                                                <input type="file" hidefocus="true" size="1" class="input-file" name="pic" id="pic" file_id="0" multiple="" />
                                                </span>
                                                    <i class="icon-upload-alt"></i> 点击上传照片
                                                </a>
                                            </div>
                                        </dd>
                                    </dl>-->
                                <?php } ?>

                                <?php if (C('captcha_status_register') == '1') { ?>
                                    <div class="code-div mt15">
                                        <dl>
                                            <dt><?php echo $lang['login_register_code']; ?>：</dt>
                                            <dd>
                                                <input type="text" id="captcha" name="captcha" class="text w80"
                                                       size="10"
                                                       tipMsg="<?php echo $lang['login_register_input_code']; ?>"/>
                                            </dd>
                                        </dl>
                                        <span>
                                            <img src="index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash(); ?>" name="codeimage" id="codeimage"/>
                                            <a class="makecode" href="javascript:void(0)" onclick="javascript:document.getElementById('codeimage').src='index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash(); ?>&t=' + Math.random();">
                                                <?php echo $lang['login_password_change_code']; ?>
                                            </a>
                                        </span>
                                    </div>
                                <?php } ?>
                                <dl class="clause-div">
                                    <dd>
                                        <input name="agree" type="checkbox" class="checkbox" id="clause" value="1"
                                               checked="checked"/>
                                        <?php echo $lang['login_register_agreed']; ?><a
                                                href="<?php echo urlShop('document', 'index', array('code' => 'agreement')); ?>"
                                                target="_blank" class="agreement"
                                                title="<?php echo $lang['login_register_agreed']; ?>"><?php echo $lang['login_register_agreement']; ?></a>
                                    </dd>
                                </dl>
                                <div class="submit-div">
                                    <input type="submit" id="Submit"
                                           value="<?php echo $lang['login_register_regist_now']; ?>" class="submit"/>
                                </div>
                                <input type="hidden" value="<?php echo $_GET['ref_url'] ?>" name="ref_url">
                                <input name="nchash" type="hidden" value="<?php echo getNchash(); ?>"/>
                                <input type="hidden" name="form_submit" value="ok"/>
                            </form>
                        </div>

                        <?php if (C('sms_register') == 1) { ?>
                            <div id="mobile" class="tabs-content">
                                <form id="post_form" method="post" class="nc-login-form">
                                    <?php Security::getToken(); ?>
                                    <input type="hidden" name="form_submit" value="ok"/>
                                    <input name="nchash" type="hidden" value="<?php echo getNchash(); ?>"/>
                                    <dl>
                                        <dt>手机号：</dt>
                                        <dd>
                                            <input type="text" class="text" tipMsg="请输入手机号码" autocomplete="off" value=""
                                                   name="phone" id="phone">
                                        </dd>
                                    </dl>
                                    <div class="code-div">
                                        <dl>
                                            <dt><?php echo $lang['login_register_code']; ?>：</dt>
                                            <dd>
                                                <input type="text" name="captcha" class="text w100" id="image_captcha"
                                                       size="10"
                                                       tipMsg="<?php echo $lang['login_register_input_code']; ?>"/>
                                            </dd>
                                        </dl>
                                        <span><img src="index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash(); ?>"
                                                   title="<?php echo $lang['login_index_change_checkcode']; ?>"
                                                   name="codeimage" id="sms_codeimage"><a class="makecode"
                                                                                          href="javascript:void(0);"
                                                                                          onclick="javascript:document.getElementById('sms_codeimage').src='index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash(); ?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a></span>
                                    </div>
                                    <div class="tiptext" id="sms_text">确保上方验证码输入正确，点击<span><a href="javascript:void(0);"
                                                                                              onclick="get_sms_captcha('1')"><i
                                                        class="icon-mobile-phone"></i>发送短信验证</a></span>，并将您手机短信所接收到的“6位动态码”输入到下方短信验证，再提交下一步。
                                    </div>
                                    <dl>
                                        <dt>短信验证：</dt>
                                        <dd>
                                            <input type="text" name="sms_captcha" autocomplete="off" tipMsg="输入6位短信验证码"
                                                   class="text" id="sms_captcha" size="15"/>
                                        </dd>
                                    </dl>
                                    <div class="submit-div">
                                        <input type="button" id="submitBtn" class="submit" value="下一步">
                                    </div>
                                </form>
                                <form style="display: none;" id="register_sms_form" class="nc-login-form" method="post"
                                      action="<?php echo urlLogin('connect_sms', 'register'); ?>">
                                    <input type="hidden" name="form_submit" value="ok"/>
                                    <input type="hidden" name="register_captcha" id="register_sms_captcha" value=""/>
                                    <input type="hidden" name="register_phone" id="register_phone" value=""/>
                                    <dl>
                                        <dt><?php echo $lang['login_register_username']; ?>：</dt>
                                        <dd>
                                            <input type="text" id="member_name" name="member_name" class="text w150"
                                                   value=""/>
                                        </dd>
                                        <span class="note">系统生成随机用户名，可选择默认或自行修改一次。</span>
                                    </dl>
                                    <dl>
                                        <dt><?php echo $lang['login_register_pwd']; ?>：</dt>
                                        <dd>
                                            <input type="text" id="sms_password" name="password" class="text w150"
                                                   value=""/>
                                        </dd>
                                        <span class="note">系统生成随机密码，请牢记或修改为自设密码。</span>
                                    </dl>
                                    <dl class="mt15">
                                        <dt><?php echo $lang['login_register_email']; ?>：</dt>
                                        <dd>
                                            <input type="text" id="sms_email" name="email" class="text" value=""
                                                   tipMsg="<?php echo $lang['login_register_input_valid_email']; ?>"/>
                                        </dd>
                                    </dl>
                                    <?php if ($output['invite_member_info']['member_id'] > 0) { ?>
                                        <dl class="mt15">
                                            <dt>邀请人ID：</dt>
                                            <dd>
                                                <input type="text" id="invite_member_id" name="invite_member_id" readonly="readonly"  value="<?php echo $output['invite_member_info']['member_number']; ?>"  class="text w150" size="10" tipMsg="邀请人ID"/>
                                            </dd>
                                        </dl>
                                        <dl class="mt15">
                                            <dt>真实姓名：</dt>
                                            <dd>
                                                <input type="text" name="real_name"  value=""  class="text "  tipMsg="请输入你的真实姓名"/>
                                            </dd>
                                        </dl>
                                        <dl class="mt15">
                                            <dt>身份证号：</dt>
                                            <dd>
                                                <input type="text" name="member_id_number" value=""  class="text "  tipMsg="你的身份证号码"/>
                                            </dd>
                                        </dl>
                                        <dl class="mt15">
                                            <dt>身份证照：</dt>
                                            <dd>
                                                <div class="ncm-upload-btn"> <a class="a-upload" href="javascript:void(0);"><span>
                                                        <input type="hidden" value="" name="id_card_photo" id="id_card_photo1" />
                                                <input type="file" hidefocus="true" size="1" class="input-file" name="pic" id="pic1" file_id="0" multiple="" />
                                                </span>
                                                        <i class="icon-upload-alt"></i> 点击上传照片
                                                    </a>
                                                </div>
                                            </dd>
                                        </dl>
                                    <?php } ?>
                                    <dl class="clause-div">
                                        <dd>
                                            <input name="agree" type="checkbox" class="checkbox" id="sms_clause"
                                                   value="1" checked="checked"/>
                                            <?php echo $lang['login_register_agreed']; ?><a
                                                    href="<?php echo urlShop('document', 'index', array('code' => 'agreement')); ?>"
                                                    target="_blank" class="agreement"
                                                    title="<?php echo $lang['login_register_agreed']; ?>"><?php echo $lang['login_register_agreement']; ?></a>
                                        </dd>
                                    </dl>
                                    <div class="submit-div">
                                        <input type="submit" value="提交注册" class="submit" title="提交注册"/>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="right">
                <?php if (C('qq_isuse') == 1 || C('sina_isuse') == 1 || C('weixin_isuse') == 1) { ?>
                    <div class="api-login">
                        <h4>使用合作网站账号直接登录</h4>
                        <?php if (C('qq_isuse') == 1) { ?>
                            <a href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=toqq" title="QQ账号登录"
                               class="qq"><i></i></a>
                        <?php } ?>
                        <?php if (C('sina_isuse') == 1) { ?>
                            <a href="<?php echo MEMBER_SITE_URL; ?>/api.php?controller=tosina"
                               title="<?php echo $lang['nc_otherlogintip_sina']; ?>" class="sina"><i></i></a>
                        <?php } ?>
                        <?php if (C('weixin_isuse') == 1) { ?>
                            <a href="javascript:void(0);"
                               onclick="ajax_form('weixin_form', '微信账号登录', '<?php echo urlLogin('connect_wx', 'index'); ?>', 360);"
                               title="微信账号登录" class="wx"><i></i></a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="reister-after">
                    <h4><?php echo $lang['login_register_after_regist']; ?></h4>
                    <ol>
                        <li class="ico01"><i></i><?php echo $lang['login_register_buy_info']; ?></li>
                        <li class="ico02"><i></i><?php echo $lang['login_register_collect_info']; ?></li>
                        <li class="ico03"><i></i><?php echo $lang['login_register_honest_info']; ?></li>
                        <li class="ico04"><i></i><?php echo $lang['login_register_openstore_info']; ?></li>
                        <li class="ico05"><i></i><?php echo $lang['login_register_talk_info']; ?></li>
                        <li class="ico06"><i></i><?php echo $lang['login_register_sns_info']; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script>
    $(function () {
        //初始化Input的灰色提示信息
        $('input[tipMsg]').inputTipText({pwd: 'password,password_confirm'});
        //注册方式切换
        $('.nc-register-mode').tabulous({
            //动画缩放渐变效果effect: 'scale'
            effect: 'slideLeft'//动画左侧滑入效果
            //动画下方滑入效果 effect: 'scaleUp'
            //动画反转效果 effect: 'flip'
        });
        var div_form = '#default';
        $(".nc-register-mode .tabs-nav li a").click(function () {
            if ($(this).attr("href") !== div_form) {
                div_form = $(this).attr('href');
                $("" + div_form).find(".makecode").trigger("click");
            }
        });

        var invite_id =$('#invite_member_id').val();
        if(invite_id != undefined && invite_id!=null){//有推荐人时调整表单大小
            $(".nc-register-mode .tabs-content").css('padding','10px 80px 0 100px');
            $(".nc-register-bg").css('height','750px');
            $('.nc-register-layout').css('height','640px');
        }
        //ajax身份证图片上传
        $('#pic').live('change',function(){
            var formhash_val=$("input[name='formhash']").val();
           ajaxImageUpload(formhash_val,'pic','id_card_photo');
        });
        $('#pic1').live('change',function(){
            var formhash_val=$("input[name='formhash']").val();
           ajaxImageUpload(formhash_val,'pic1','id_card_photo1');
        });
        function ajaxImageUpload(formhash_val,fileElementId,id_card_photo){
            $.ajaxFileUpload
            (
                    {
                        url:'<?php echo urlMember('login','pic_upload',array('form_submit'=>ATTACH_STORE)) ?>',
                        type:'post',
                        data: { formhash: formhash_val,form_submit: 'ok'},
                        secureuri:false,
                        fileElementId:fileElementId,
                        dataType: 'json',
                        success: function (data, status)
                        {
                            if (data.status == 1){
                                $("#id_card_photo").val(data.msg);
                                $("#id_card_photo1").val(data.msg);
                                alert("上传成功");
                            }else{
                                alert(data.msg);
                            }
                        },
                        error: function (data, status, e)
                        {
                            alert('上传失败');
                        }
                    }
                )
            }

//注册表单验证
        $("#register_form").validate({
            errorPlacement: function (error, element) {
                var error_td = element.parent('dd');
                error_td.append(error);
                element.parents('dl:first').addClass('error');
            },
            success: function (label) {
                label.parents('dl:first').removeClass('error').find('label').remove();
            },
            submitHandler: function (form) {
                ajaxpost('register_form', '', '', 'onerror');
            },
            onkeyup: false,
            rules: {
                user_name: {
                    required: true,
                    lettersmin: true,
                    lettersmax: true,
                    letters_name: true,
                    remote: {
                        url: 'index.php?controller=login&action=check_member&column=ok',
                        type: 'get',
                        data: {
                            user_name: function () {
                                return $('#user_name').val();
                            }
                        }
                    }
                },
                password_confirm: {
                    required: true,
                    equalTo: '#password'
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: 'index.php?controller=login&action=check_email',
                        type: 'get',
                        data: {
                            email: function () {
                                return $('#email').val();
                            }
                        }
                    }
                },
                <?php if ($output['invite_member_info']['member_id'] > 0) { ?>
                real_name: {
                    required: true,
                    minlength:2,
                    maxlength: 8
                },
                member_id_number: {
                    required: true,
                    minlength: 15,
                    maxlength: 18
                },
                id_card_photo: {
                    required: true,
                },
                <?php } ?>
                <?php if(C('captcha_status_register') == '1') { ?>
                captcha: {
                    required: true,
                    remote: {
                        url: 'index.php?controller=seccode&action=check&nchash=<?php echo getNchash();?>',
                        type: 'get',
                        data: {
                            captcha: function () {
                                return $('#captcha').val();
                            }
                        },
                        complete: function (data) {
                            if (data.responseText == 'false') {
                                document.getElementById('codeimage').src = 'index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();
                            }
                        }
                    }
                },
                <?php } ?>
                agree: {
                    required: true
                }
            },
            messages: {
                real_name:{
                    required: '<i class="icon-exclamation-sign"></i>请填写你的真实姓名',
                    minlength: '<i class="icon-exclamation-sign"></i>请填写不少于2个汉字的姓名',
                    maxlength: '<i class="icon-exclamation-sign"></i>请填写不超过8个汉字的姓名'
                },
                member_id_number:{
                    required: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码',
                    minlength: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码',
                    maxlength: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码'
                },
                id_card_photo:{
                    required: '<i class="icon-exclamation-sign"></i>请上传你的身份证清晰的正面照片',
                },

                user_name: {
                    required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_username'];?>',
                    lettersmin: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_range'];?>',
                    lettersmax: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_range'];?>',
                    letters_name: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_lettersonly'];?>',
                    remote: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_exists'];?>'
                },
                password: {
                    required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_password'];?>',
                    minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>',
                    maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>'
                },
                password_confirm: {
                    required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_password_again'];?>',
                    equalTo: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_not_same'];?>'
                },
                email: {
                    required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_email'];?>',
                    email: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_invalid_email'];?>',
                    remote: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_email_exists'];?>'
                },
                <?php if(C('captcha_status_register') == '1') { ?>
                captcha: {
                    required: '<i class="icon-remove-circle" title="<?php echo $lang['login_register_input_text_in_image'];?>"></i>',
                    remote: '<i class="icon-remove-circle" title="<?php echo $lang['login_register_code_wrong'];?>"></i>'
                },
                <?php } ?>
                agree: {
                    required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_must_agree'];?>'
                }
            }
        });
    });
</script>
<?php if (C('sms_register') == 1) { ?>
    <script type="text/javascript" src="<?php echo LOGIN_RESOURCE_SITE_URL; ?>/js/connect_sms.js"
            charset="utf-8"></script>
    <script>
        $(function () {
            $("#submitBtn").click(function () {
//                if ($("#post_form").valid()) {
//                    check_captcha();
//                }
                $.getScript('index.php?controller=connect_sms&action=register'+'&phone='+$('#phone').val());
                $("#register_sms_form").show();
                $("#post_form").hide();
            });
            $("#post_form").validate({
                errorPlacement: function (error, element) {
                    var error_td = element.parent('dd');
                    error_td.append(error);
                    element.parents('dl:first').addClass('error');
                },
                success: function (label) {
                    label.parents('dl:first').removeClass('error').find('label').remove();
                },
                onkeyup: false,
                rules: {
                    phone: {
                        required: true,
                        mobile: true
                    },
                    captcha: {
                        required: true,
                        minlength: 4,
                        remote: {
                            url: 'index.php?controller=seccode&action=check&nchash=<?php echo getNchash();?>',
                            type: 'get',
                            data: {
                                captcha: function () {
                                    return $('#image_captcha').val();
                                }
                            },
                            complete: function (data) {
                                if (data.responseText == 'false') {
                                    document.getElementById('sms_codeimage').src = 'index.php?controller=seccode&action=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();
                                }
                            }
                        }
                    },
                    sms_captcha: {
                        required: function (element) {
                            return $("#image_captcha").val().length == 4;
                        },
                        minlength: 6
                    }
                },
                messages: {
                    phone: {
                        required: '<i class="icon-exclamation-sign"></i>输入正确的手机号',
                        mobile: '<i class="icon-exclamation-sign"></i>输入正确的手机号'
                    },
                    captcha: {
                        required: '<i class="icon-remove-circle" title="<?php echo $lang['login_register_input_text_in_image'];?>"></i>',
                        minlength: '<i class="icon-remove-circle" title="<?php echo $lang['login_register_input_text_in_image'];?>"></i>',
                        remote: '<i class="icon-remove-circle" title="<?php echo $lang['login_register_code_wrong'];?>"></i>'
                    },
                    sms_captcha: {
                        required: '<i class="icon-exclamation-sign"></i>请输入六位短信动态码',
                        minlength: '<i class="icon-exclamation-sign"></i>请输入六位短信动态码'
                    }
                }
            });
            $('#register_sms_form').validate({
                errorPlacement: function (error, element) {
                    var error_td = element.parent('dd');
                    error_td.append(error);
                    element.parents('dl:first').addClass('error');
                },
                success: function (label) {
                    label.parents('dl:first').removeClass('error').find('label').remove();
                },
                submitHandler: function (form) {
                    ajaxpost('register_sms_form', '', '', 'onerror');
                },
                rules: {
                    <?php if ($output['invite_member_info']['member_id'] > 0) { ?>
                    real_name: {
                        required: true,
                        minlength:2,
                        maxlength: 8
                    },
                    member_id_number: {
                        required: true,
                        minlength: 15,
                        maxlength: 18
                    },
                    id_card_photo: {
                        required: false,
                    },
                    <?php } ?>
                    member_name: {
                        required: true,
                        lettersmin: true,
                        lettersmax: true,
                        letters_name: true,
                        remote: {
                            url: 'index.php?controller=login&action=check_member&column=ok',
                            type: 'get',
                            data: {
                                user_name: function () {
                                    return $('#member_name').val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    email: {
                        email: true,
                        remote: {
                            url: 'index.php?controller=login&action=check_email',
                            type: 'get',
                            data: {
                                email: function () {
                                    return $('#sms_email').val();
                                }
                            }
                        }
                    },
                    agree: {
                        required: true
                    }
                },
                messages: {
                    real_name:{
                        required: '<i class="icon-exclamation-sign"></i>请填写你的真实姓名',
                        minlength: '<i class="icon-exclamation-sign"></i>请填写不少于2个汉字的姓名',
                        maxlength: '<i class="icon-exclamation-sign"></i>请填写不超过8个汉字的姓名'
                    },
                    member_id_number:{
                        required: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码',
                        minlength: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码',
                        maxlength: '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码'
                    },
                    id_card_photo:{
                        required: '<i class="icon-exclamation-sign"></i>请上传你的身份证清晰的正面照片',
                    },
                    member_name: {
                        required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_username'];?>',
                        lettersmin: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_range'];?>',
                        lettersmax: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_range'];?>',
                        letters_name: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_lettersonly'];?>',
                        remote: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_username_exists'];?>'
                    },
                    password: {
                        required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_password'];?>',
                        minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>',
                        maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>'
                    },
                    email: {
                        email: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_invalid_email'];?>',
                        remote: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_email_exists'];?>'
                    },
                    agree: {
                        required: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_must_agree'];?>'
                    }
                }
            });
        });
    </script>
<?php } ?>
<style>
    .a-upload { padding: 4px 10px;height: 20px;line-height: 20px;position: relative;cursor: pointer;color: #888;background: #fafafa;border: 1px solid #ddd;border-radius: 4px;overflow: hidden;display: inline-block;*display: inline; *zoom: 1  }
    .a-upload  input { position: absolute; font-size: 100px;height: 30px;right: 0;top: 0; opacity: 0; filter: alpha(opacity=0); cursor: pointer  }
    .a-upload:hover { color: #444;  background: #eee;  border-color: #ccc;  text-decoration: none  }
</style>