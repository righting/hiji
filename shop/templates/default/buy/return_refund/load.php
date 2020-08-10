<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<div class="ncc-receipt-info" id="bu_dan_form">
    <div class="ncc-receipt-info-title">
        <h3>您当前存在需要补单的订单，请选择是否补单</h3>
    </div>
    <div class="ncc-candidate-items">
        <ul>
            <li>
                <input value="2" nc_type="return_refund" checked type="radio" name="is_bd">
                <label for="load_return_refund">不补单</label>
            </li>
            <li>
                <input value="1" nc_type="return_refund" type="radio" name="is_bd">
                <label for="load_return_refund">补单</label>
            </li>
            <div id="load_return_refund_box"><!-- 存放新增地址表单 --></div>
        </ul>
    </div>
</div>


<script type="text/javascript">

    $(function(){
        $('input[nc_type="return_refund"]').on('click',function(){
            if ($(this).val() == 1) {
                $('#load_return_refund_box').load(SITEURL+'/index.php?controller=buy&action=load_return_refund');
            } else {
                $('#load_return_refund_box').html('');
            }
        });
    });
</script>