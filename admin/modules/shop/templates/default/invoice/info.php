<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>发票信息</h3>
        <h5>发票详情</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->


  <form id="user_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="member_id" value="<?php echo $output['member_array']['member_id'];?>" />
    <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_array']['member_avatar'];?>" />
    <input type="hidden" name="member_name" value="<?php echo $output['member_array']['member_name'];?>" />
    <div class="ncap-form-default">

      <dl class="row">
        <dt class="tit">
          <label>发票类型</label>
        </dt>
        <dd class="opt"><strong class="red"><?php echo $output['info']['type_cn']; ?></strong></dd>
      </dl>

      <dl class="row">
        <dt class="tit">
          <label>发票抬头</label>
        </dt>
        <dd class="opt"><strong class="red"><?php echo $output['info']['title']; ?></strong> </dd>
      </dl>

      <dl class="row">
        <dt class="tit">
          <label>开票金额</label>
        </dt>
        <dd class="opt"><strong class="red"><?php echo $output['info']['money']; ?></strong> </dd>
      </dl>


      <dl class="row">
        <dt class="tit">
          <label>申请时间</label>
        </dt>
        <dd class="opt"><strong class="red"><?php echo $output['info']['created_at']; ?></strong></dd>
      </dl>

        <dl class="row">
            <dt class="tit">
                <label>申请状态</label>
            </dt>
            <dd class="opt"><strong class="red"><?php echo $output['info']['status_cn']; ?></strong></dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>联系方式</label>
            </dt>
            <dd class="opt"><strong class="red"><?php echo $output['info']['link_man']; ?>    <?php echo $output['info']['link_mobile']; ?></strong></dd>
        </dl>

        <dl class="row">
            <dt class="tit">
                <label>邮寄地址</label>
            </dt>
            <dd class="opt"><strong class="red"><?php echo $output['info']['link_address']; ?></strong></dd>
        </dl>
        <?php if($output['info']['status'] == 2){ ?>
            <dl class="row">
                <dt class="tit">
                    <label>运单号</label>
                </dt>
                <dd class="opt"><strong class="red"><?php echo $output['info']['express_num']; ?></strong></dd>
            </dl>
        <?php } ?>
        <?php if($output['info']['status'] == 1){ ?>
      <div class="bot">
          <a href="<?php echo urlAdminShop('invoice','confirm',['id'=>$output['info']['id']]);?>" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认邮寄</a>
      </div>
        <?php } ?>
    </div>
  </form>
</div>
