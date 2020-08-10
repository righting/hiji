<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="essential">
    <div class="alert alert-success">
        <h4>操作提示：</h4>
        <ul>
            <li>1.只有您所实际消费的现金充值金额可开票，已充值还未消费的金额无法开票。如需帮助，可查看开票常见问题。</li>
            <li>2.目前只支持纸质发票，暂不支持电子发票。在您提交开票申请后，我们将在5个工作日内为您开票并用顺丰快递邮寄给您（不包括快递运输时间），请您耐心等待。</li>
            <li>3.开票口径：按消耗开票（即按实际消费金额开票，而不是按充值金额开票）</li>
            <li>4.可开票金额=消耗的现金充值金额-已开过票的金额</li>
            <li>5.消耗的总金额： <?php echo $output['this_user_invoice_money_info']['total_money']; ?>元</li>
            <li>6.获得的分红金额： <?php echo $output['this_user_invoice_money_info']['bonus_money']; ?>元</li>
            <li>7.可开票总金额： <?php echo $output['this_user_invoice_money_info']['can_be_opened_total_money']; ?>元</li>
            <li>8.已开过票的金额： <?php echo $output['this_user_invoice_money_info']['has_be_opened_money']; ?>元</li>
        </ul>
    </div>
  <div class="ncm-default-form">
    <form method="post" id="invoice_form" action="<?php echo urlMember('invoice','apply_save'); ?>">
      <input type="hidden" name="form_submit" value="ok" />
        <dl>
            <dt><i class="required">*</i>可开票金额</dt>
            <dd>
                <span><?php echo $output['this_user_invoice_money_info']['can_be_opened_money']; ?></span>
            </dd>
        </dl>

        <dl>
            <dt><i class="required">*</i>本次开票金额</dt>
            <dd>
                <input name="amount" type="text" class="text" id="amount" maxlength="14"/><span></span>
            </dd>
        </dl>

        <dl>
            <dt><i class="required">*</i>发票类型</dt>
            <dd>
                <span><?php echo $output['info']['type_cn']; ?></span>
            </dd>
        </dl>
        <dl>
            <dt><i class="required">*</i>发票抬头</dt>
            <dd>
                <span><?php echo $output['info']['title']; ?></span>
            </dd>
        </dl>
        <dl>
            <dt>联系方式</dt>
            <dd>
                <span><?php echo $output['address']['true_name']; ?> <?php echo $output['address']['mob_phone']; ?></span>
            </dd>
        </dl>
        <dl>
            <dt>邮寄地址</dt>
            <dd>
                <span><?php echo $output['address']['area_info']; ?> <?php echo $output['address']['address']; ?></span>
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
$(function(){
    $('#invoice_form').validate({
        submitHandler:function(form){
            ajaxpost('invoice_form', '', '', 'onerror')
        },
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        rules : {
            amount      : {
                required  : true,
                number    : true,
                min       : 1,
                max       : <?php echo floatval($output['this_user_invoice_money_info']['can_be_opened_money']); ?>
            }
        },
        messages : {
            amount : {
                required  :'<i class="icon-exclamation-sign"></i>请正确输入开票金额',
                number    :'<i class="icon-exclamation-sign"></i>请正确输入开票金额',
                min    	  :'<i class="icon-exclamation-sign"></i>请正确输入开票金额',
                max       :'<i class="icon-exclamation-sign"></i>请正确输入开票金额'
            }
        }
    });
});
</script>