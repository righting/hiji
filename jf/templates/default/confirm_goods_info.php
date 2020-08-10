<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/layui.js"></script>

<div class="ncc-wrapper">
<form method="get" id="order_form" name="order_form" action="index.php">

    <div class="ncc-main">
        <div class="ncc-title">
            <h3>确认订单</h3>
            <h5>请仔细核对填写收货等信息。</h5>
        </div>

        <div class="ncc-receipt-info">
            <div class="ncc-receipt-info-title">
                <h3>收货人信息</h3>
                <a href="javascript:void(0)" nc_type="address" id="choose_address">[选择]</a>
                <a href="javascript:void(0)"  onclick="addAddress()">[新增]</a>
            </div>
            <div id="addr_list" class="ncc-candidate-items">
                <ul>
                    <li>
                        <span class="true-name"><?php echo $output['address_info'][0]['true_name']?></span>
                        <span class="address"><?php echo $output['address_info'][0]['area_info'] . $output['address_info'][0]['address']?></span>
                        <span class="phone"><?php echo $output['address_info'][0]['mob_phone']?></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="ncc-receipt-info" id="paymentCon">
            <div class="ncc-receipt-info-title">
                <h3>支付方式</h3>
            </div>
            <div class="ncc-candidate-items">
                <ul>
                    <li>在线支付</li>
                </ul>
            </div>
        </div>

        <div class="ncc-receipt-info">
            <div class="ncc-receipt-info-title">
                <h3>商品清单</h3>
            </div>
            <table class="ncc-table-style">
                <thead>
                <tr>
                    <th class="w50"></th>
                    <th></th>
                    <th>商品</th>
                    <th class="w150">单价(元)</th>
                    <th class="w100">积分</th>
                    <th class="w100">海吉币</th>
                    <th class="w100">购买数量</th>
                    <th class="w50"></th>
                </tr>
                </thead>
                <tbody>
                <tr id="cart_item_21" class="shop-list">
                    <td class="td-border-left"></td>
                    <td class="w100">
                        <a href="javascript:;"  class="ncc-goods-thumb"><img src="<?php echo $output['goodsInfo']['goods_image']?>" alt="<?php echo $output['goodsInfo']['goods_name']?>"></a>
                    </td>
                    <td class="tl">
                        <dl class="ncc-goods-info">
                            <dt>
                                <a href="javascript:;" ><?php echo $output['goodsInfo']['goods_name']?></a></dt>
                            <dd class="goods-spec"></dd>
                        </dl>
                    </td>
                    <td>
                        <em class="goods-price"><?php echo $output['goodsInfo']['goods_price']?></em><!-- E 商品单价 -->
                    </td>
                    <td><em class="goods-price"><?php echo $output['goodsInfo']['goods_integral']?></em></td>
                    <td><em class="goods-price"><?php echo $output['goodsInfo']['goods_hjb']?></em></td>
                    <td><em class="goods-price"><?php echo $output['number']?></em></td>
                    <td class="td-border-right"></td>
                </tr>

                <tr>
                    <td colspan="20">
                        <div class="ncc-store-account" style="width:290px;">
                            <dl>
                                <dt style="width:150px;">商品总金额：</dt>
                                <dd class="sum"><em id="eachStoreGoodsTotal_3"><?php echo $output['goodsInfo']['goods_price']*$output['number']?></em>
                                </dd>
                            </dl>


                            <dl>
                                <dt style="width:150px;">商品总积分：</dt>
                                <dd class="sum"><em nc_type="eachStoreFreight" id="eachStoreFreight_3"><?php echo $output['goodsInfo']['goods_integral']*$output['number']?></em>
                                </dd>
                            </dl>
                            <dl>
                                <dt style="width:150px;">商品海吉币：</dt>
                                <dd class="sum"><em id="eachStoreGoodsTotal_3"><?php echo $output['goodsInfo']['goods_hjb']*$output['number']?></em>
                                </dd>
                            </dl>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tfoot>

                <tr>
                    <td colspan="20">
                        <a style="text-decoration:none;" href="javascript:void(0)" id="submitOrder" class="ncc-next-submit ok">提交订单</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

        <input type="hidden" name="controller" value="orders"/>
        <input type="hidden" name="action" value="orderPay"/>
        <input type="hidden" name="orderId" id="orderId" value=""/>
        <input type="hidden" name="orderNo" id="orderNo" value=""/>

    </div>
</form>
</div>

<!-- 收货地址ID -->
<input value="<?php echo $output['address_info'][0]['address_id']?>" name="address_id" id="address_id" type="hidden">
<!-- 商品ID -->
<input value="<?php echo $output['goodsId'];?>" name="goods_id" id="goods_id" type="hidden">
<!-- 购买数量 -->
<input value="<?php echo $output['number'];?>" name="number" id="number" type="hidden">





<div id="add_address" style="display:none;">
        <div class="layui-form layui-form-pane" style="padding:10px 10px;">
            <div class="layui-form-item">
                <label class="layui-form-label">收货人</label>
                <div class="layui-input-block">
                    <input type="text" name="title" id="name" placeholder="请输入收货人姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系号码</label>
                <div class="layui-input-block">
                    <input type="text" name="title" id="phone" placeholder="请输入联系号码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">选择地址</label>
                <div class="layui-input-inline">
                    <select id="quiz1" name="quiz1" lay-filter="quiz1">
                        <option value="">请选择省</option>
                        <?php foreach($output['areaInfo'] as $k=>$v){?>
                            <option  value="<?php echo $v['area_id']?>"><?php echo $v['area_name']?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="quiz2" name="quiz2" lay-filter="quiz2">
                        <option value="">请选择市</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="quiz3" name="quiz3">
                        <option value="">请选择县/区</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">详细地址</label>
                <div class="layui-input-block">
                    <input type="text" name="title" id="addressInfo" placeholder="请输入详细地址" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" pane>
                <label class="layui-form-label">默认地址</label>
                <div class="layui-input-block">
                    <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="是|否">
                    <div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch">
                        <em>ON</em>
                        <i></i>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" onclick="addressSubmit()">保存提交</button>
                </div>
            </div>
        </div>
</div>



<div id="address_info" style="display:none;">
    <div style="padding:0 10px;">
        <table class="layui-table" lay-size="sm" >
            <colgroup>
                <col width="100">
                <col width="300">
                <col width="120">
                <col width="90">
                <col width="120">
            </colgroup>
            <thead>
            <tr>
                <th>收货人</th>
                <th>收货地址</th>
                <th>联系号码</th>
                <th>是否默认地址</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($output['address_info'] as $k=>$v){?>
                <tr>
                    <td><?php echo $v['true_name']?></td>
                    <td><?php echo $v['area_info'].' '.$v['address']?></td>
                    <td><?php echo $v['mob_phone']?></td>
                    <td><?php echo ($v['is_default']==1?'是':'否') ?></td>
                    <td>
                        <!--<button class="layui-btn  layui-btn-warm layui-btn-xs">编辑</button>-->
                        <button class="layui-btn layui-btn-normal layui-btn-xs" onclick="choose(<?php echo $v['address_id'].','."'".$v['true_name']."','".$v['area_info'].' '.$v['address']."','".$v['mob_phone']."'";?>)">使用</button>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>




<input  type='hidden' id="checkIsSubmit" value="0"/>
<script>
    $('#choose_address').on('click',function(){
        layer.open({
            title:'收货地址',
            type:1,
            shadeClose: true,
            area:['800px','400px'],
            content:$('#address_info')
        })
    })

    /*新增收货地址*/
    function addAddress(){
        layer.open({
            title:'新增收货地址',
            type:1,
            shadeClose: true,
            area:['760px','550px'],
            content:$('#add_address')
        })
    }


    /*使用收货地址*/
    function choose(id,name,address,phone){
        layer.load();
        $('#address_id').val(id);
        $('.true-name').html(name);
        $('.address').html(address);
        $('.phone').html(phone);
        layer.closeAll();
    }

    function addressSubmit(){
        var name = $("#name").val();
        var phone = $('#phone').val();
        var quiz1 = $('#quiz1').val();
        var quiz2 = $('#quiz2').val();
        var quiz3 = $('#quiz3').val();
        var address = $("#addressInfo").val();
        var is_default = 0;
        if($('.layui-unselect>em').html()=='是'){
            is_default =1;
        }

        if(name == ''){
            layer.tips('收货人姓名不能为空!', '#name', {tips: 1});
            return;
        }

        if(phone == ''){
            layer.tips('联系号码不能为空!', '#phone', {tips: 1});
            return;
        }

        if(quiz1 == ''){
            layer.msg('请选择省份!');
            return;
        }

        if(quiz2 == ''){
            layer.msg('请选择市!');
            return;
        }
        if(quiz3 == ''){
            layer.msg('请选择县/区!');
            return;
        }

        if(address == ''){
            layer.tips('详细地址不能为空!', '#addressInfo', {tips: 1});
            return;
        }

        var params={};
        params.name = name;
        params.phone = phone;
        params.address = address;
        params.quiz1 = quiz1;
        params.quiz2 = quiz2;
        params.quiz3 = quiz3;
        params.isDefault = is_default;

        layer.load();
        $.ajax({
            url: '/jf/index.php?controller=goods&action=addAddress',
            data:params,
            type:'post',
            dataType: 'json',
            success:function(data){
               console.log(data);
               layer.closeAll();
               if(data.status==1){
                   layer.msg(data.msg,{icon:1});
                   setTimeout(function(){
                       window.location.reload();
                   },1000)
               }else{
                   layer.msg(data.msg,{icon:5})
               }
            }
        });

    }



    /**提交商品信息并生成订单**/
    $('#submitOrder').on('click',function(){
        layer.load();
        var checkIsSubmit =  $('#checkIsSubmit').val();
        if(checkIsSubmit != 1){
            $('#checkIsSubmit').val(1);
            var addressId = $('#address_id').val();
            var goodsId   = $('#goods_id').val();
            var number   = $('#number').val();
            $.getJSON('/jf/index.php?controller=orders&action=createOrders',{goodsId:goodsId,number:number,addressId:addressId},function(data){
                layer.closeAll();
                if(data.status==1){
                    layer.msg('正在跳转至订单支付页面',{icon: 16,shade: 0.01});
                    $('#orderId').val(data.data['orderId']);
                    $('#orderNo').val(data.data['orderNo']);
                    checkFormHistory();
                    $("#order_form").submit();
                }else{
                    $('#checkIsSubmit').val(0);
                    layer.msg(data.msg,{icon:5});
                }
            })
        }
    });



    /**表单跳转后禁止返回**/
    function checkFormHistory(){
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    }

    layui.use('form', function() {
        var form = layui.form;
        form.render();
        form.on('select(quiz1)',function(data){
            var elem = data.elem;
            var areaId = data.value;
            $("#quiz2").html("<option value=''>请选择市</option>");
            $("#quiz3").html("<option value=''>请选择县/区</option>");
            form.render('select');
            $.ajax({
                url: '/jf/index.php?controller=goods&action=getAreaInfo',
                data:{id:areaId},
                type:'post',
                dataType: 'json',
                success:function(data){
                    var option = "<option value=''>请选择市</option>";
                    $.each(data,function(i,val){
                        option += "<option value='"+val.area_id+"'>"+val.area_name+"</option>"
                    });
                    $("#quiz2").html(option);
                    form.render('select');
                }
            });
        });

        form.on('select(quiz2)',function(data){
            var elem = data.elem;
            var areaId = data.value;
            if(areaId==''){
                $("#quiz3").html("<option value=''>请选择县/区</option>");
                form.render('select');
                return;
            }
            $.ajax({
                url: '/jf/index.php?controller=goods&action=getAreaInfo',
                data:{id:areaId},
                type:'post',
                dataType: 'json',
                success:function(data){
                    var option = "<option value=''>请选择县/区</option>";
                    $.each(data,function(i,val){
                        option += "<option value='"+val.area_id+"'>"+val.area_name+"</option>"
                    });

                    $("#quiz3").html(option);
                    form.render('select');
                }
            });
        });


    })

</script>