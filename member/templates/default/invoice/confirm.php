<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="essential">
  <div class="essential-nav">
    <?php include template('layout/submenu');?>
  </div>
    <div class="alert alert-success">
        <h4>操作提示：</h4>
        <ul>
            <li>1.只有您所实际消费的现金充值金额可开票，已充值还未消费的金额无法开票。如需帮助，可查看开票常见问题。</li>
            <li>2.目前只支持纸质发票，暂不支持电子发票。在您提交开票申请后，我们将在5个工作日内为您开票并用顺丰快递邮寄给您（不包括快递运输时间），请您耐心等待。</li>
            <li>3.开票口径：按消耗开票（即按实际消费金额开票，而不是按充值金额开票）</li>
            <li>4.可开票金额=消耗的现金充值金额-已开过票的金额</li>
            <li>5.消耗的现金充值金额： 1531.00元 （不包含代金券、赠送、返利金额）</li>
            <li>6.已开过票的金额： 718.00元</li>
        </ul>
    </div>
  <div class="ncm-default-form">
    <form method="post" id="transfer_form" action="<?php echo urlMember('predeposit','transfer'); ?>">
      <input type="hidden" name="form_submit" value="ok" />
        <dl>
            <dt><i class="required">*</i>开票信息</dt>
            <dd>
                <span>55550.00</span>
            </dd>
        </dl>
        <dl>
            <dt><i class="required">*</i>邮寄信息</dt>
            <dd>
                <span>55550.00</span>
            </dd>
        </dl>
        <dl>
            <dt><i class="required">*</i>本次开票金额</dt>
            <dd>
                <input name="amount" type="text" class="text" id="amount" maxlength="14"/><span></span>
            </dd>
        </dl>

      <dl class="bottom">
        <dt>&nbsp; </dt>
        <dd>
          <label class="submit-border"><input type="submit" class="submit" value="确认开票" /></label>
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