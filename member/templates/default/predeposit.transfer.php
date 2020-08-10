<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="essential">
  <div class="essential-nav">
    <?php include template('layout/submenu');?>
  </div>
    <div class="alert alert-success">
        <h4>操作提示：</h4>
        <ul>
            <li>1.请输入完整的收款会员的会员 ID。</li>
            <li>2.确认转账前请先使用 “检查” 按钮，检测用户 ID 号是否正确，确认转账后将会直接到达对方账户。</li>
        </ul>
    </div>
  <div class="ncm-default-form">
    <form method="post" id="transfer_form" action="<?php echo urlMember('predeposit','transfer'); ?>">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt><i class="required">*</i>转账会员 ID 号</dt>
        <dd>
            <input name="user_id" type="text" class="text" id="user_id" maxlength="17"/>
            <input type="button" class="transfer-to-user-info w50" value="检查" />
            <span id="transfer-to-user-info"></span>
        </dd>
      </dl>


        <dl>
            <dt><i class="required">*</i>转账金额</dt>
            <dd>
                <input name="amount" type="text" class="text" id="amount" maxlength="14"/><span></span>
            </dd>
        </dl>

        <dl>
            <dt><i class="required">*</i>支付密码：</dt>
            <dd><input name="password" type="password" class="text w100" id="password" maxlength="20"/><span></span>
                <p class="hint">
                    <?php if (!$output['member_info']['member_paypwd']) {?>
                        <strong class="red">还未设置支付密码</strong><a href="index.php?controller=member_security&action=auth&type=modify_paypwd" class="ncbtn-mini ncbtn-aqua vm ml10" target="_blank">马上设置</a>
                    <?php } ?>
                </p>
            </dd>
        </dl>
      <dl class="bottom">
        <dt>&nbsp; </dt>
        <dd>
          <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_submit']; ?>" /></label>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">


$('.transfer-to-user-info').click(function(){
   var _user_id = $(this).parent().find('#user_id').val();
   if(_user_id == ''){
       var _error_str = '<i class="icon-exclamation-sign"></i>请输入会员 ID';
       $('#transfer-to-user-info').empty().append(_error_str);
       return false;
   }
   var _check_url = "<?php echo urlMember('predeposit','check_user_id');?>";
   $.post(_check_url,{user_id:_user_id},function(response){
       if(response['status'] != 1){
           var _str = '<i class="icon-exclamation-sign"></i>'+response['msg'];
           $('#transfer-to-user-info').empty().append(_str);
       }else{
           var _data = response['data'];
           var _success_str = '<p style="color: #468847">会员 ID 号：'+_data['member_number']+' 账户：'+_data['member_name']+' 昵称：'+_data['member_nickname']+'</p>';
           $('#transfer-to-user-info').empty().append(_success_str);
       }
   },'json');
});


$(function(){
    $('#transfer_form').validate({
        submitHandler:function(form){
            ajaxpost('transfer_form', '', '', 'onerror')
        },
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        rules : {

            user_id :{
                required  : true
            },

            amount      : {
                required  : true,
                number    : true,
                min       : 0.01,
                max       : <?php echo floatval($output['user_money']); ?>
            },

            password : {
                required  : true
            }
        },
        messages : {
            user_id	  : {
                required   :'<i class="icon-exclamation-sign"></i>请输入收款人 ID'
            },

            amount : {
                required  :'<i class="icon-exclamation-sign"></i>请正确输入提现金额',
                number    :'<i class="icon-exclamation-sign"></i>请正确输入提现金额',
                min    	  :'<i class="icon-exclamation-sign"></i>请正确输入提现金额',
                max       :'<i class="icon-exclamation-sign"></i>请正确输入提现金额'
            },
            password : {
                required : '<i class="icon-exclamation-sign"></i>请输入支付密码'
            }
        }
    });
});
</script>