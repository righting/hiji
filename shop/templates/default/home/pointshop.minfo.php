<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/ccy-main.css" rel="stylesheet" type="text/css"><style type="text/css">.classtab a.curr, .category .hover .class{background: #eb0a00;}.public-head-layout .logo-test{ color:#eb0a00}.category .sub-class{ border-color: #eb0a00;}</style>
<!--<?php dump($output['member_info']) ?>-->
<div class="ncp-member-info">
  <div class="avatar"><img src="<?php echo getMemberAvatarForID($_SESSION['member_id']);?>" />
    <div class="frame"></div>
  </div>
  <dl>
    <dt>Hi, <?php echo $_SESSION['member_name'];?></dt>
    <dd>当前等级：<strong><?php echo $output['member_info']['level_name'];?></strong></dd>
<!--    <dd>当前经验值：<strong><?php echo $output['member_info']['member_exppoints'];?><?php echo $output['member_info']['level'];?></strong></dd>-->
  </dl>
</div>
<!--<?php //dump($output['member_info']); ?>-->
<div class="ncp-member-grade">
  <?php if ($output['member_info']['level'] !== -1){ ?>
  <div class="progress-bar">
      <em title="<?php echo $output['member_info']['downgrade_name'];?>需积分<?php echo $output['member_info']['downgrade_point'];?>"><?php echo $output['member_info']['downgrade_name'];?></em>
      <span title="<?php echo $output['member_info']['exppoints_rate'];?>%"><i style="width:<?php echo $output['member_info']['exppoints_rate'];?>%;"></i></span>
      <em title="<?php echo $output['member_info']['upgrade_name'];?>需积分<?php echo $output['member_info']['upgrade_point'];?>"><?php echo $output['member_info']['upgrade_name'];?></em>
      <?php echo $output['member_info']['exppoints_rate'];?>
      <?php if($output['member_info']['exppoints_rate'] == 100){ ?>
      <a class="nc-grade-mini" style="cursor:pointer;" href="<?php echo urlShop('pointshop','buy_grade'); ?>">立即升级</a>
          <?php }else{ ?>
          <a class="nc-grade-mini" style="cursor:pointer;" href="<?php echo urlShop('cate','index',['cate_id'=>1068]); ?>">去购物</a>
      <?php } ?>
  </div>
  <div class="progress">
    <?php if ($output['member_info']['less_exppoints'] > 0){?>
    还差<em><?php echo $output['member_info']['less_exppoints'];?></em>积分即可成为<?php echo $output['member_info']['upgrade_name'];?>等级会员
    <?php } elseif ($output['member_info']['less_exppoints'] == 'none'){?>
    已达到最高会员级别，继续加油保持这份荣誉哦！
    <?php } elseif ($output['member_info']['level'] == 0){?>
        绑定团队即可升级为免费会员
      <?php }?>
  </div>
  <?php } else { ?>
  暂无等级
  <?php } ?>
  <div class="links">
    <div class="links"> <a href="<?php echo urlShop('pointgrade','index');?>" target="_blank">我的成长进度</a> <a href="<?php echo urlShop('pointgrade','exppointlog');?>" target="_blank">积分明细</a> </div>
  </div>
</div>
<div class="ncp-member-point">
  <dl style="border-left: none 0;">
    <a href="<?php echo MEMBER_SITE_URL;?>/index.php?controller=member_points" target="_blank">
    <dt style="padding: 0; margin: 3px; font-size: 16px;height: 20px" >HS:<?php echo $output['member_info']['member_points'];?> </dt>
    <dt style="padding: 0;margin: 3px; font-size: 16px;height: 20px">H:<?php echo $output['member_info']['member_h_points'];?></dt>
    <dd>我的积分</dd>
    </a>
  </dl>
  <?php if (C('voucher_allow')==1){ ?>
  <dl>
    <a href="<?php echo MEMBER_SITE_URL;?>/index.php?controller=member_voucher&action=index" target="_blank">
    <dt><strong><?php echo $output['vouchercount']; ?></strong>张</dt>
    <dd>可用代金券</dd>
    </a>
  </dl>
  <?php } ?>
  <?php if (C('pointprod_isuse')==1){?>
  <dl>
    <a href="<?php echo MEMBER_SITE_URL;?>/index.php?controller=member_pointorder&action=orderlist" target="_blank">
    <dt><strong><?php echo $output['pointordercount'];?></strong>个</dt>
    <dd>已兑换礼品</dd>
    </a>
  </dl>
  <?php }?>
</div>
<?php if (C('pointprod_isuse')==1){?>
<div class="ncp-memeber-pointcart"> <a href="index.php?controller=pointcart" class="btn">礼品兑换购物车<?php if ($output['pointcart_count'] > 0){?><em><?php echo $output['pointcart_count']; ?></em><?php } ?></a>
    <?php  if($output['member_info']['level'] == 0) {?>
     <a href="<?php echo MEMBER_SITE_URL?>/index.php?controller=member_team&action=index" class="btn">绑定团队</a>
    <?php }else{?>
    <a href="index.php?controller=pointshop&action=buy_grade" class="btn">会员进阶</a>
    <?php }?>
</div>
<?php }?>
