<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">

            <div class="subject">
                <h3>确认邮寄</h3>
            </div>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
            <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
        <ul>
            <li>请将邮寄使用的快递单号填入运单号中。</li>
        </ul>
    </div>
    <form enctype="multipart/form-data" id="user_form" method="post" action="<?php echo urlAdminShop('invoice','save');?>">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="id" value="<?php echo $output['info']['id'];?>" />
        <div class="ncap-form-default">

            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">运单号 </label>
                </dt>
                <dd class="opt">
                    <input type="text"  name="express_num" class="input-txt">
                    <span class="err"></span>
                </dd>
            </dl>

            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
        </div>
    </form>
</div>
<script>
    $("#submitBtn").click(function(){
        if($("#user_form").valid()){
            $("#user_form").submit();
        }
    });
    $('#user_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            express_num: {
                maxlength: 50,
                minlength: 1
            }
        },
        messages : {
            express_num : {
                maxlength: '<i class="fa fa-exclamation-circle"></i>请填写正确的运单号',
                minlength: '<i class="fa fa-exclamation-circle"></i>请填写正确的运单号'
            }
        }
    });
</script>

