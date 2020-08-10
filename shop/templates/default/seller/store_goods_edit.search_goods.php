<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
<ul class="goods-list">
  <?php foreach($output['goods_list'] as $key=>$val){?>
  <li>
    <div class="goods-thumb"><img src="<?php echo cthumb($val['goods_image'], 240);?>"/></div>
    <dl class="goods-info">
      <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name'];?></a> </dt>
      <dd>销售价格：<?php echo $lang['currency'].ncPriceFormat($val['goods_price']);?>
    </dl>
    <a nctype="a_choose_goods" data-param="{gid:<?php echo $val['goods_id'];?>, gname:'<?php echo $val['goods_name'];?>', gimage:'<?php echo cthumb($val['goods_image'], '60');?>', gimage240:'<?php echo cthumb($val['goods_image'], '240');?>', gurl:'<?php echo urlShop('goods', 'index', array('goods_id'=>$val['goods_id']));?>', gprice:'<?php echo ncPriceFormat($val['goods_price']);?>'}" href="javascript:void(0);" class="ncbtn-mini ncbtn-mint"><i class="icon-plus"></i>添加商品</a> </li>
  <?php } ?>
</ul>
<div class="pagination"><?php echo $output['show_page'];?></div>
<?php } else { ?>
<div class="norecord"><?php echo $lang['no_record'];?></div>
<?php } ?>
