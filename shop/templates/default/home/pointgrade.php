<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_point.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/diagrammaticsketch.css" rel="stylesheet" type="text/css">

<div class="ncp-container">
  <div class="ncp-base-layout">
    <div class="ncp-member-left">
      <?php include_once BASE_TPL_PATH.'/home/pointshop.minfo.php'; ?>
    </div>
      <div class="diagrammaticsketch">
          <div class="diagrammaticsketch-a">
              <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/illustration.png">
          </div>
          <p style="margin-top: 20px">升级积分仅限于海吉主场消费获得的积分可以兑换</p>
          <p>海吉主场消费1人民币=1积分=1Hs</p>
          <p>如月保级消费额仍然在海吉主场消费的，且已作为换算过月奖金制度的消费额，将不
              再可用于兑换升级积分使用，尽可以用于积攒再积分商城换购使用。
          </p>
      </div>
  </div>

  <div class="ncp-grade-layout">
    <div class="title">
      <h3>有效购物金额</h3>
    </div>
    <dl>
      <dt><i class="icon-02"></i>
        <p>有效范围</p>
      </dt>
      <dd>
        <?php if ($output['ruleexplain_arr']['exp_order']){ ?>
        <ul>
          <li>实物交易订单的在<strong>【确认完成】</strong>后，该笔订单金额计入有效购物金额；在您收货后，请到<strong>【实物交易订单】</strong>中，点击<strong>【确认收货】</strong>，经验值会更快地发放；</li>
          <li>虚拟兑换订单的在<strong>【已完成】</strong>后，该笔订单金额计入有效购物金额；</li>
        </ul>
        <?php } ?>
      </dd>
    </dl>
  </div>
</div>
</div>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home.js" id="dialog_js" charset="utf-8"></script> 
