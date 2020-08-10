<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style>
    .ncc-candidate-items input[type="checkbox"], .ncc-candidate-items .checkbox {
        margin: 0 5px 0 20px;
    }
    .ncc-candidate-items input[type="checkbox"], .ncc-candidate-items .checkbox, .ncc-candidate-items label, .ncc-candidate-items a {
        font-size: 12px;
        vertical-align: middle;
        letter-spacing: normal;
        word-spacing: normal;
        display: inline-block;
    }
</style>
<div class="ncc-form-default">
      <div class="ncc-candidate-items">
          <ul>
              <?php foreach ($output['refund_return_list'] as $return_refund_item){ ?>
              <li class="inv_item">
                  <input value="<?php echo $return_refund_item['refund_id'] ?>" type="checkbox" name="refund_sn[]">
                  <label for="add_inv">补单号：<?php echo $return_refund_item['refund_sn'] ?></label>
                  <label for="add_inv">订单号：<?php echo $return_refund_item['order_sn'] ?></label>
              </li>
              <?php } ?>
          </ul>
      </div>
</div>

<script type="text/javascript">

</script>