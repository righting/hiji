<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_invo.css" rel="stylesheet" type="text/css">
<!--我的发票-->
<div class="receipt">
    <div class="receipt-information" style="display:block">
        <div class="receipt-increment">
            <div class="receipt-information-a1">
                <em>发票信息</em>
            </div>
            <div class="receipt-increment-b">
                <dl>
                    <dt><i class="required">*</i>发票抬头类型：</dt>
                    <dd><?php
                        if($output['info']['type']==1){
                            echo '个人';
                        }else{
                            echo '企业';
                        }?></dd>
                </dl>
            </div>
            <div class="receipt-increment-b">
                <dl>
                    <dt><i class="required">*</i>发票类型：</dt>
                    <dd><?php echo $output['info']['invoice_type']?></dd>
                </dl>
            </div>

            <div class="receipt-increment-b">
                <dl>
                    <dt><i class="required">*</i>申请状态：</dt>
                    <dd><?php echo $output['info']['status_cn']?></dd>
                </dl>
            </div>

            <div class="receipt-xian-c">
                <span class="receipt-san1">
                      <i class="receipt-san"></i>
                </span>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>开票金额：</dt>
                    <dd>
                        <?php echo $output['info']['money']?>
                    </dd>
                </dl>
            </div>


            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>发票抬头：</dt>
                    <dd>
                        <?php echo $output['info']['title']?>
                    </dd>
                </dl>
            </div>


            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>联系人：</dt>
                    <dd>
                        <?php echo $output['info']['link_man']?>
                    </dd>
                </dl>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>联系电话：</dt>
                    <dd>
                        <?php echo $output['info']['link_mobile']?>
                    </dd>
                </dl>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>邮寄地址：</dt>
                    <dd>
                        <?php echo $output['info']['link_address']?>
                    </dd>
                </dl>
            </div>


        </div>

        <!--企业发票信息-->
        <div id="company" style="display:<?php if($output['info']['type']==2){ echo 'block'; }else{ echo 'none'; }?>; ">
            <div class="receipt-increment-e">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/receipt_3.jpg">
            </div>

            <div class="receipt-information-a">
                <dl>
                    <dt><i class="required">*</i>纳税人识别号：</dt>
                    <dd>
                        <?php echo $output['info']['number']?>
                    </dd>
                </dl>

                <dl>
                    <dt><i class="required">*</i>开户银行：</dt>
                    <dd>
                        <?php echo $output['info']['bank_name']?>
                    </dd>
                </dl>
                <dl>
                    <dt><i class="required">*</i>银行账户：</dt>
                    <dd>
                        <?php echo $output['info']['bank_account']?>
                    </dd>
                </dl>
            </div>

        </div>
    </div>




    <!--猜你喜欢-->
    <div class="refund-e" style="display: block">
        <div class="promote-b1">
            <div class="promote-b1-a">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/true.png">
            </div>
            <p class="promote-b1-b">猜你喜欢</p>
        </div>

        <ul>
            <?php $sum = count($output['likeGoods']);
            while (!empty($output['likeGoods'])){
                $data = array_slice($output['likeGoods'],0,4);
                ?>
                <?php foreach ($data as $item):?>
                    <li>
                        <a href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                            <img  src="<?php echo $item['goods_image']; ?>" alt="<?php echo $item['goods_name']; ?>" title="<?php echo $item['goods_name']; ?>">
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php array_splice($output['likeGoods'],0,4); } ?>
        </ul>
    </div>

</div>
