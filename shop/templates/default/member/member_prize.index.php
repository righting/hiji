<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"/>

<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/layer/layer.js"></script>

<div class="essential">

    <div class="essential-nav">
        <?php include template('layout/submenu'); ?>
    </div>


    <table class="ncm-default-table order">
        <thead>
        <tr>
            <th class="w10"></th>
            <th colspan="2">商品</th>
            <th class="w90">单价（元）</th>
            <th class="w90">积分</th>
            <th class="w90">海吉币</th>
            <th class="w50">数量</th>
            <th class="w130">订单状态</th>
        </tr>
        </thead>

        <?php foreach($output['info'] as $k=>$v){?>
            <tbody>
            <tr>
                <td colspan="19" class="sep-row"></td>
            </tr>
            <tr>
                <th colspan="19">
             
                <span style="margin-right:25px;font-size:13px;">
                    抽奖时间：<?php echo $v['add_time'];?>
                </span>

                </th>
            </tr>

            <!-- S 商品列表 -->
            <tr>
                <td class="bdl"></td>
                <td class="w70">
                    <div class="ncm-goods-thumb">
                        
						<img src="<?php echo $v['prize_image']?>" >
                        
                    </div>
                </td>
                <td class="tl">
                    <dl class="goods-name">
                        <dt>
                            <?php echo $v["prize_name"]?>
                        </dt>
                    </dl>
                </td>
                <td>平台是否处理：<?php if($v['dispose']==1){echo '已处理，时间：'.date('Y-m-d H:i:s');}else{echo '未处理';}?><p class="green"></p></td>
               
                <td>
                    <?php if($v["dispose"]==0){ ?>
						<?php if(!$v["mobile"]){ ?>
							<a href="javascript:;" onclick='closeOrder("<?php echo $v['id'];?>")' class="layui-btn layui-btn-danger  layui-btn-sm" style="margin-top:5px;">填写联系资料</a>
						<?php }else{?>
							<a href="javascript:;" onclick='closeOrder("<?php echo $v['id'];?>")' class="layui-btn layui-btn-danger  layui-btn-sm" style="margin-top:5px;">修改联系资料</a>
						<?php }?>
                        
                    <?php }else{?>
                        <span style="color:rgb(74,178,255);">已处理</span>
                    <?php }?>

                    </td>
            </tr>
            </tbody>
        <?php }?>

        <tfoot>
        <tr>
            <td colspan="19"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
        </tr>
        </tfoot>

    </table>

</div>
<script charset="utf-8" type="text/javascript"
        src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/sns.js"></script>
<script type="text/javascript">
    $(function () {
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });


    /*取消订单*/
    function closeOrder(id){
        layer.confirm('', {
            title:'填写联系资料',
            content:'<div>填写联系资料平台会与您联系</div><div>联系人：<input id="name" name="name" value=""></div><div>联系人电话：<input id="mobile" name="mobile" value=""></div><div>收货地址：<input id="addres" name="addres" value=""></div>'
        }, function(){
           layer.load();
		   var name = $("#name").val();
		   var mobile = $("#mobile").val();
		   var addres = $("#addres").val();
		   if(!name){
				layer.msg('请填写联系人');
		   }
		   if(!mobile){
				layer.msg('请填写联系人电话');
		   }
		   if(!addres){
				layer.msg('请填写收货地址');
		   }
            $.ajax({
                url: '<?php echo urlShop('member_prize','binding')?>',
                data:{'id':id,'name':name,'mobile':mobile,'addres':addres},
                type:'post',
                dataType: 'json',
                success:function(data){
                    layer.closeAll();
                    if(data.status==1){
                        layer.msg(data.msg,{icon:1});
                        setTimeout(function(){
                            window.location.reload();
                        },1000)
                    }else{
                        layer.msg(data.msg)
                    }
                }
            });
        });
    }

</script> 
