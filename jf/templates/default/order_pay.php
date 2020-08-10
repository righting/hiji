<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>


<div class="ncc-wrapper">
<div class="ncc-main">
    <div class="ncc-title">
        <h3>支付提交</h3>
        <h5>订单详情内容可通过查看<a href="/shop/index.php?controller=member_point_order" target="_blank">我的订单</a>进行核对处理。</h5>
    </div>
    <form action="" method="POST" id="buy_form">
        <input type="hidden" name="pay_sn" value="<?php echo $output['pay_info']['pay_sn'];?>">
        <input type="hidden" name="type" value="<?php echo $output['pay_info']['type'];?>">
        <input type="hidden" id="payment_code" name="payment_code" value="">
        <input type="hidden" value="" name="password_callback" id="password_callback">
        <div class="ncc-receipt-info">
            <div class="ncc-receipt-info-title">
                <h3>
                    <?php echo $output['orderRemind'];?>
                </h3>
            </div>

            <table class="layui-table" lay-size="lg" style="margin-top:30px;">
                <colgroup>
                    <col width="250">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>订单号</th>
                    <th>支付方式</th>
                    <th>应付金额(元)</th>
                    <th>应付积分</th>
                    <th>应付海吉币</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $output['orderInfo']['orderNo']?></td>
                    <td>在线支付</td>
                    <td style="color:red;font-size:18px;"><?php echo $output['orderInfo']['order_money']?></td>
                    <td style="color:red;font-size:18px;"><?php echo $output['orderInfo']['order_point']?></td>
                    <td style="color:red;font-size:18px;"><?php echo $output['orderInfo']['order_hjb']?></td>
                </tr>
                </tbody>
            </table>



        </div>
            <div class="ncc-receipt-info">
                <div class="ncc-receipt-info-title">
                    <h3>选择在线支付</h3>
                </div>
                <ul class="ncc-payment-list">
                    <li for="pay_yue" >
                        <label>
                            <i></i>
                            <div class="logo" for="pay_yue"> <img src="<?php echo JF_SITE_URL?>/templates/default/images/yemoney.png" /> </div>
                        </label>
                    </li>
                    <?php foreach($output['payment_list'] as $val) { ?>
                        <li for="<?php echo $val['payment_code']; ?>">
                            <label for="pay_<?php echo $val['payment_code']; ?>">
                                <i></i>
                                <div class="logo" for="pay_<?php echo $val['payment_id']; ?>"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/payment/<?php echo $val['payment_code']; ?>_logo.gif" /> </div>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="ncc-bottom"><a href="javascript:void(0);" id="next_button" class="pay-btn">确认支付</a></div>


        <input type="hidden" id="payType" value=""/>

    </form>
</div>
</div>


<form action="index.php?controller=orders&action=alipay" method="POST" id="alipay_from">
    <input type="hidden"  name='orderId' value="<?php echo $output['orderInfo']['id']?>" id="orderId"/>
</form>



<script type="text/javascript">
    $(function(){
        $('.ncc-payment-list > li').on('click',function(){
            $('.ncc-payment-list > li').removeClass('using');
                $(this).addClass('using');
                var type=$(this).attr('for');
                $('#payType').val(type);
        });

        $('#next_button').on('click',function(){
            var type = $("#payType").val();
            if(type == ''){layer.msg('请选择支付方式');return;}
            if(type == 'pay_yue'){
                layer.prompt({title: '请输入支付密码', formType: 1}, function(pass, index){
                    layer.msg('正在检测支付密码中....',{icon:16 ,shade: 0.01,time:0});
                    $.getJSON('/jf/index.php?controller=orders&action=checkPayPass',{password:pass},function(data){
                        if(data.status==1){
                            layer.closeAll();
                            layer.msg('系统正在处理订单信息、请稍等.....',{icon:16 ,shade: 0.3,time:0});
                            $.ajax({
                                url: '/jf/index.php?controller=orders&action=saveOrderInfo',
                                data:{orderId:'<?php echo $output['orderInfo']['id']?>'},
                                type:'post',
                                dataType: 'json',
                                success:function(data){
                                    layer.closeAll();
                                    if(data.status==1){
                                        window.location.href='/shop/index.php?controller=member_point_order&action=index';
                                    }else{
                                        layer.msg(data.msg)
                                    }
                                }
                            });
                        }else{
                            layer.msg('请输入正确的支付密码!');
                        }
                    })
                });
            }else if(type == 'alipay'){
                layer.msg('系统正在处理订单中....',{icon:16 ,shade: 0.3,time:0});
                $.ajax({
                    url: '/jf/index.php?controller=orders&action=alipay',
                    data:{orderId:'<?php echo $output['orderInfo']['id']?>'},
                    type:'post',
                    dataType: 'json',
                    success:function(data){
                        layer.closeAll();
                        layer.msg('系统正在跳转至支付页面....',{icon:16 ,shade: 0.3,time:0});
                        if(data.status==1){
                            window.location.href=data.data
                        }else{
                            layer.msg(data.msg);
                        }
                    }
                });
               // $('#alipay_from').submit();
            }

        })

    });


</script>