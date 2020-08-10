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
    <form enctype="multipart/form-data" id="dealers_form" method="post" action="<?php echo urlAdminShop('dealers','save');?>">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="id" value="<?php echo $output['info']['id'];?>" />
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">联系人 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['name'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">职级 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['title'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">手机号 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['mobile'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">加盟地区 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['address'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">加盟说明 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['note'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">申请时间 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['created_at'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">状态 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['status_cn'];?></dd>
            </dl>


            <?php if($output['info']['status'] == 2){?>

            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">后台操作人员id </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['admin_id'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">后台操作人员账号 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['admin_user_name'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">后台操作人员备注 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['admin_msg'];?></dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="member_passwd">后台操作时间 </label>
                </dt>
                <dd class="opt"><?php echo $output['info']['admin_changed_at'];?></dd>
            </dl>
            <?php }else{?>

            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>备注</label>
                </dt>
                <dd class="opt">
                    <textarea id="admin_msg" name="admin_msg" class="tarea"></textarea>
                    <span class="err"></span>
                    <p class="notic">信息回访后，建议在备注里说明，方便核对。</p>
                </dd>
            </dl>

            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
            <?php }?>
        </div>
    </form>
</div>
<script>
    $("#submitBtn").click(function(){
        if($("#dealers_form").valid()){
            $("#dealers_form").submit();
        }
    });
    $('#dealers_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            admin_msg: {
                maxlength: 50,
                minlength: 1
            }
        },
        messages : {
            admin_msg : {
                maxlength: '<i class="fa fa-exclamation-circle"></i>请填写正确的备注信息',
                minlength: '<i class="fa fa-exclamation-circle"></i>请填写正确的备注信息'
            }
        }
    });
</script>

