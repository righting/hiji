<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="ncsc-index">
  <div class="top-container">
    <div class="basic-info">
      <dl class="ncsc-seller-info">
        <dt class="seller-name">
          <h3><?php echo $_SESSION['seller_session_info']['seller_name']; ?></h3>
        </dt>
        <dd class="seller-permission">管理权限：<strong><?php echo $_SESSION['seller_session_info']['seller_group_name'];?></strong></dd>
        <dd class="seller-last-login">最后登录：<strong><?php echo $_SESSION['seller_session_info']['seller_last_login_time'];?></strong> </dd>
        <dd class="store-name"><?php echo $lang['store_name'].$lang['nc_colon'];?><a  ><?php echo $output['store_info']['store_name'];?></a></dd>
        <dd class="store-grade"><?php echo $lang['store_store_grade'].$lang['nc_colon'];?><strong><?php echo $output['store_info']['grade_name']; ?></strong></dd>
        <dd class="store-validity"><?php echo $lang['store_validity'].$lang['nc_colon'];?><strong><?php echo $output['store_info']['store_end_time_text'];?>
          <?php if ($output['store_info']['reopen_tip']) {?>
          <a href="index.php?controller=store_info&action=reopen">马上续签</a>
          <?php } ?>
          </strong> </dd>
      </dl>
<?php if (!checkPlatformStore()) { ?>
      <div class="detail-rate">
        <h5><?php echo $lang['store_dynamic_evaluation'].$lang['nc_colon'];?></h5>
        <ul>
        <?php  foreach ($output['store_info']['store_credit'] as $value) {?>
        <li>
          <h5><?php echo $value['text'];?></h5>
          <div class="<?php echo $value['percent_class'];?>" title="<?php echo $value['percent_text'];?><?php echo $value['percent'];?>"><?php echo $value['credit'];?><i></i></div>
        </li>
        <?php } ?>
      </ul>
      </div>
<?php } ?>
    </div>
  </div>
  <div class="seller-cont">
    <div class="container type-a">
      <div class="hd">
        <h3><?php echo $lang['store_owner_info'];?></h3>
        <h5><?php echo $lang['store_notice_info'];?></h5>
      </div>
      <div class="content">
        <dl class="focus">
          <dt>店铺商品发布情况：</dt>
          <dd title="已发布/<?php echo $lang['store_publish_goods'];?>"><em id="nc_goodscount">0</em>&nbsp;/&nbsp;
            <?php if ($output['store_info']['grade_goodslimit'] != 0){ echo $output['store_info']['grade_goodslimit'];} else { echo '不限';} ?>
          </dd>
          <dt><?php echo $lang['store_publish_album'].$lang['nc_colon'];?></dt>
          <dd><em id="nc_imagecount">0</em>&nbsp;/&nbsp;<?php echo $output['store_info']['grade_albumlimit'] > 0 ? $output['store_info']['grade_albumlimit'] : '不限'; ?></dd>
        </dl>
        <ul>
          <li><a href="index.php?controller=store_goods_online&action=index"><?php echo $lang['store_goods_selling'];?> <strong id="nc_online"></strong></a></li>
          <?php if (C('goods_verify')) {?>
          <li><a href="index.php?controller=store_goods_offline&action=index&type=wait_verify&verify=10" title="<?php echo $lang['store_inform30'];?>">发布待平台审核 <strong id="nc_waitverify"></strong></a></li>
          <li><a href="index.php?controller=store_goods_offline&action=index&type=wait_verify&verify=0" title="<?php echo $lang['store_inform30'];?>">平台审核失败 <strong id="nc_verifyfail"></strong></a></li>
          <?php }?>
          <li><a href="index.php?controller=store_goods_offline&action=index"><?php echo $lang['store_goods_storage'];?> <strong id="nc_offline"></strong></a></li>
          <li><a href="index.php?controller=store_goods_offline&action=index&type=lock_up"><?php echo $lang['store_goods_show0'];?> <strong id="nc_lockup"></strong></a></li>
          <li><a href="index.php?controller=store_consult&action=consult_list&type=to_reply"><?php echo $lang['store_to_consult'];?> <strong id="nc_consult"></strong></a></li>
        </ul>
      </div>
    </div>

    <div class="container type-b">
      <div class="hd">
        <h3>系统公告</h3>
        <h5></h5>
      </div>
      <div class="content">
        <ul>
          <?php
			if(is_array($output['article_list']) && !empty($output['article_list'])) {
				foreach($output['article_list'] as $val) {
			?>
          <li><a target="_blank" <?php if($val['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($val['article_url']!='')echo $val['article_url'];else echo urlMember('article', 'show', array('article_id'=>$val['article_id']));?>" title="<?php echo $val['article_title']; ?>">
            <?php echo $val['article_title'];?></a></li>
          <?php
				}
			}
			 ?>
        </ul>
        <dl>
          <dt><?php echo $lang['store_site_info'];?></dt>
          <?php
			if(is_array($output['phone_array']) && !empty($output['phone_array'])) {
				foreach($output['phone_array'] as $key => $val) {
			?>
          <dd><?php echo $lang['store_site_phone'].($key+1).$lang['nc_colon'];?><?php echo $val;?></dd>
          <?php
				}
			}
			 ?>
          <dd><?php echo $lang['store_site_email'].$lang['nc_colon'];?><?php echo C('site_email');?></dd>
        </dl>
      </div>
    </div>
    <div class="container type-a">
      <div class="hd">
        <h3><?php echo $lang['store_business'];?></h3>
        <h5><?php echo $lang['store_business_info'];?></h5>
      </div>
      <div class="content">
        <dl class="focus">
          <dt><?php echo $lang['store_order_info'].$lang['nc_colon'];?></dt>
          <dd><a href="index.php?controller=store_order"><?php echo $lang['store_order_progressing'];?> <strong id="nc_progressing"></strong></a></dd>
          <dt><?php echo $lang['store_complain_info'].$lang['nc_colon'];?></dt>
          <dd><a href="index.php?controller=store_complain&select_complain_state=1"><?php echo $lang['store_complain'];?> <strong id="nc_complain"></strong></a></dd>
        </dl>
        <ul>
          <li><a href="index.php?controller=store_order&action=index&state_type=state_new"><?php echo $lang['store_order_pay'];?> <strong id="nc_payment"></strong></a></li>
          <li><a href="index.php?controller=store_order&action=index&state_type=state_pay"><?php echo $lang['store_shipped'];?> <strong id="nc_delivery"></strong></a></li>
          <li><a href="index.php?controller=store_refund&lock=2"> <?php echo '售前退款';?> <strong id="nc_refund_lock"></strong></a></li>
          <li><a href="index.php?controller=store_refund&lock=1"> <?php echo '售后退款';?> <strong id="nc_refund"></strong></a></li>
          <li><a href="index.php?controller=store_return&lock=2"> <?php echo '售前退货';?> <strong id="nc_return_lock"></strong></a></li>
          <li><a href="index.php?controller=store_return&lock=1"> <?php echo '售后退货';?> <strong id="nc_return"></strong></a></li>
          <li><a href="index.php?controller=store_bill&action=index&bill_state=1"> <?php echo '待确认账单';?> <strong id="nc_bill_confirm"></strong></a></li>
        </ul>
      </div>
    </div>
    <div class="container type-c">
      <div class="hd">
        <h3>销售情况统计</h3>
        <h5>按周期统计商家店铺的订单量和订单金额</h5>
      </div>
      <div class="content">
        <table class="ncsc-default-table">
          <thead>
            <tr>
              <th class="w50">项目</th>
              <th>订单量</th>
              <th class="w100">订单金额</th>
            </tr>
          </thead>
          <tbody>
            <tr class="bd-line">
              <td>昨日销量</td>
              <td><?php echo empty($output['daily_sales']['ordernum']) ? '--' : $output['daily_sales']['ordernum'];?></td>
              <td><?php echo empty($output['daily_sales']['orderamount']) ? '--' : $lang['currency'].$output['daily_sales']['orderamount'];?></td>
            </tr>
            <tr class="bd-line">
              <td>月销量</td>
              <td><?php echo empty($output['monthly_sales']['ordernum']) ? '--' : $output['monthly_sales']['ordernum'];?></td>
              <td><?php echo empty($output['monthly_sales']['orderamount']) ? '--' : $lang['currency'].$output['monthly_sales']['orderamount'];?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="container type-c h500">
      <div class="hd">
        <h3>单品销售排名</h3>
        <h5>掌握30日内最热销的商品及时补充货源</h5>
      </div>
      <div class="content">
        <table class="ncsc-default-table">
          <thead>
            <tr>
              <th>排名</th>
              <th class="tl" colspan="2">商品信息</th>
              <th>销量</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($output['goods_list']) {?>
            <?php  $i = 0;foreach ($output['goods_list'] as $val) {$i++?>
            <tr class="bd-line">
              <td class="w50"><strong><?php echo $i;?></strong></td>
              <td class="w60"><div class="pic-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']))?>" target="_blank"><img alt="<?php echo $val['goods_name'];?>" src="<?php echo cthumb($val['goods_image'], '60');?>"></a></div></td>
              <td><dl class="goods-name">
                  <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']))?>" target="_blank"><?php echo $val['goods_name'];?></a></dt>
                </dl></td>
              <td class="w60"><?php echo $val['goodsnum'];?></td>
            </tr>
            <?php }?>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<script>
$(function(){
	var timestamp=Math.round(new Date().getTime()/1000/60);
    $.getJSON('index.php?controller=seller_center&action=statistics&rand='+timestamp, null, function(data){
        if (data == null) return false;
        for(var a in data) {
            if(data[a] != 'undefined' && data[a] != 0) {
                var tmp = '';
                if (a != 'goodscount' && a != 'imagecount') {
                    $('#nc_'+a).parents('a').addClass('num');
                }
                $('#nc_'+a).html(data[a]);
            }
        }
    });
});
</script>
