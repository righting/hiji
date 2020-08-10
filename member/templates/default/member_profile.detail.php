<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="essential">
    <div class="essential-nav">
         <?php include template('layout/submenu');?>
    </div>
    <form action="<?php echo urlMember('member_information','detail') ?>" enctype="multipart/form-data" id="profile_form" method="post">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="pic_front" value="<?php echo  $output['member_detail']['id_card_photo']; ?>" />
        <input type="hidden" name="pic_back" value="<?php echo  $output['member_detail']['id_card_photo_back']; ?>" />
    <div class="essential-detail">
        <div class="autonym">
            <h3>（ 图片清晰且位置方正，更有利于通过系统的审核 ）</h3>
            <ul>
                <li>
                    <input type="file" style="display: none" hidefocus="true" size="1" class="input-file" name="pic" id="pic_front" file_id="0" multiple="" />
                    <div class="autonym-img"><img id="front_img" style="width: 274px;height: 178px" src="<?php echo empty($output['member_detail']['id_card_photo'])? MEMBER_TEMPLATES_URL.'/images/sfz1.png':$output['member_detail']['id_card_photo']?>"></div>
                    <?php if ($output['member_detail']['isauth'] !=1 ){ ?>
                    <a id="front" href="javascript:;"><img  src="<?php echo MEMBER_TEMPLATES_URL;?>/images/sfz3.png"></a>
                    <?php }?>
                    <div class="autonym-title">上传身份证正面照</div>
                </li>

                <li>
                    <input type="file" style="display: none" hidefocus="true" size="1" class="input-file" name="pic" id="pic_back" file_id="0" multiple="" />
                    <div class="autonym-img"><img id="back_img"  style="width: 274px;height: 178px" src="<?php echo empty($output['member_detail']['id_card_photo_back'])? MEMBER_TEMPLATES_URL.'/images/sfz2.png':$output['member_detail']['id_card_photo_back']?>"></div>
                    <?php if ($output['member_detail']['isauth'] !=1 ){ ?>
                    <a id="back" href="javascript:;"><img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/sfz3.png"></a>
                    <?php }?>
                    <div class="autonym-title">上传身份证背面照</div>
                </li>
            </ul>
        </div>

        <div class="essential-detail-center">
            <div class="essential-line">
                <label><i>*</i><?php echo $lang['home_member_truename'].$lang['nc_colon'];?></label>
                <span>
                    <input type="text"  style="float: left" class="text essential-line-input" maxlength="20" name="real_name" value="<?php echo $output['member_detail']['real_name']; ?>" />
                </span>
            </div>

            <div class="essential-line">
                <label><i>*</i><?php echo $lang['home_member_id_number'].$lang['nc_colon'];?></label>
                <span>
                    <input type="text"  style="float: left" class="text essential-line-input" maxlength="18" name="member_id_number" value="<?php echo $output['member_detail']['member_id_number']; ?>" />
                </span>

            </div>
            <div>
                <label <?php if($output['member_detail']['isauth'] ==2){echo "style='color:red'";} ?>>
                    <?php if ($output['member_detail']['isauth'] ==1){
                        echo '恭喜你，实名认证已通过，审核时间：'.date('Y-m-d H:i:s', $output['member_detail']['auth_time']);
                    }else if($output['member_detail']['isauth'] ==2){
                        echo '很抱歉审核失败，请重新提交审核，原因：'.$output['member_detail']['response'];
                    }
                    ?>
                </label>
            </div>

        </div>
        <?php if ($output['member_detail']['isauth'] !=1 ){ ?>
            <a href="javascript:;" onclick="$('#profile_form').submit();" class="essential-detail-button">提 交</a>
         <?php } ?>
    </div>
    </form>
</div>
<script type="text/javascript">
    //注册表单验证
    $(function(){
        $('#front').on('click', function(e) {
            e.preventDefault();
            $("#pic_front").trigger('click');
        })
        $('#back').on('click', function(e) {
            e.preventDefault();
            $("#pic_back").trigger('click');
        })
        $('#profile_form').validate({
            submitHandler:function(form){
                ajaxpost('profile_form', '', '', 'onerror')
            },
            rules : {
                real_name : {
                    required : true,
                    minlength : 2,
                    maxlength : 20
                },
                member_id_number : {
                    required : true,
                    minlength : 15,
                    maxlength : 18,
                    isIdCardNo:true
                },
                pic_front : {
                    required : true,
                },
                pic_back : {
                    required : true,
                }
            },
            messages : {
                real_name : {
                    required : '请填写你的姓名',
                    minlength : '<?php echo $lang['home_member_username_range'];?>',
                    maxlength : '<?php echo $lang['home_member_username_range'];?>'
                },
                member_id_number  : {
                    required : '请填写你的身份证号码',
                    minlength : '<?php echo $lang['home_member_input_idcard'];?>',
                    maxlength : '<?php echo $lang['home_member_input_idcard'];?>',
                    isIdCardNo:'请填写正确的身份证号码'
                },
                pic_front :{
                    required : '请上传身份证正面照片',
                },
                pic_back :{
                    required : '请上传身份证背面照片',
                }
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script type="text/javascript">
    $('#pic_front').live('change',function(){//正面照片上传
        ajaxImageUpload('pic_front');
    });
    $('#pic_back').live('change',function(){//背面照片上传
        ajaxImageUpload('pic_back');
    });
    /*ajax文件上传*/
    function ajaxImageUpload(fileElementId){
        $.ajaxFileUpload
        (
            {
                url:'<?php echo urlMember('member_information','ajaxPicUpload') ?>',
                type:'post',
                data: {form_submit: 'ok',type:fileElementId},
                secureuri:false,
                fileElementId:fileElementId,
                dataType: 'json',
                success: function (data)
                {
                    if (data.status == 1){
                        var text = data.text.replace(/&amp;/g,'\&');
                        if(fileElementId=='pic_front'){
                            $("#front_img").attr('src',data.msg+text);
                            $("input[name='pic_front']").val(data.msg);
                        }else{
                            $("#back_img").attr('src',data.msg+text);
                            $("input[name='pic_back']").val(data.msg);
                        }
                    }else{
                        alert(data.msg);
                    }
                },
                error: function (data)
                {
                    showDialog('上传失败','','error');
                }
            }
        )
    }
    //身份证号码验证，配合validate（）使用
    function IdentityCodeValid(code) {
        var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
        var tip = "";
        var pass= true;

        if(!code || !/^[1-9]\d{5}((1[89]|20)\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])\d{3}[\dx]$/i.test(code)){
            tip = "身份证号格式错误";
            pass = false;
        }

        else if(!city[code.substr(0,2)]){
            tip = "地址编码错误";
            pass = false;
        }
        else{
            //18位身份证需要验证最后一位校验位
            if(code.length == 18){
                code = code.split('');
                //∑(ai×Wi)(mod 11)
                //加权因子
                var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
                //校验位
                var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
                var sum = 0;
                var ai = 0;
                var wi = 0;
                for (var i = 0; i < 17; i++)
                {
                    ai = code[i];
                    wi = factor[i];
                    sum += ai * wi;
                }
                var last = parity[sum % 11];
                if(parity[sum % 11] != code[17].toUpperCase()){
                    tip = "校验位错误";
                    pass =false;
                }
            }
        }
        if(!pass)
            return false;
        return true;
    }
</script>