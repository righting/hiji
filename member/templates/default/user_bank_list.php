<link type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layui/css/layui.css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/layui/layui.js"></script>
<script src="/data/resource/js/jquery.js"></script>


<div style="width:90%;margin:0 auto;">
    <table class="layui-table"  lay-size="sm">
        <thead>
        <tr>
            <th style="text-align:center;">开户银行</th>
            <th style="text-align:center;">银行卡号</th>
            <th style="text-align:center;">开户姓名</th>
            <th style="text-align:center;">手机号码</th>
            <th align="center"></th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($output['bankInfo']) && !empty($output['bankInfo'])){?>
            <?php foreach($output['bankInfo'] as $k=>$v){?>
            <tr class="<?php echo $k."-".$v['id'];?>">
                <td align="center"><?php echo $v['bank_name'];?></td>
                <td align="center"><?php echo $v['bank_card_number'];?></td>
                <td align="center"><?php echo $v['bank_user_name'];?></td>
                <td align="center"><?php echo $v['bank_phone'];?></td>
                <td align="center">
                    <?php if($v['is_default']==0){ ?>
                        <a href="javascript:selectedDefault(<?php echo $v['id'];?>);">设为默认 |</a>
                    <?php }?>
                    <a href="javascript:deleteBank(<?php echo $v['id'];?>,<?php echo $k;?>);">解绑</a>
                </td>
            </tr>
            <?php }?>
        <?php }else{ ?>

        <?php } ?>

        </tbody>
    </table>
</div>

<script>

    /*设置为默认提现卡*/
    function selectedDefault(id){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.msg('正在执行中...', {
                icon: 16
                ,shade: 0.01
            });
            $.post('<?php echo urlMember('bank','selectedDefault');?>',{id:id},function(data){
                layer.closeAll();
                if(data==1){
                    layer.msg('设置成功!', {icon: 1});
                    window.location.reload();
                }else{
                    layer.msg('设置失败!', {icon: 5});
                }
            })
        });
    }


    /*删除银行卡*/
    function deleteBank(id,key){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定要解绑此卡吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                layer.load();
                $.post('<?php echo urlMember('bank','deleteBank');?>',{id:id},function(data){
                    layer.closeAll();
                    if(data==1){
                        layer.msg('解绑成功!', {icon: 1});
                        $('.'+key+'-'+id).remove();
                    }else{
                        layer.msg('解绑失败了!', {icon: 5});
                    }
                })
            });
        });
    }
</script>