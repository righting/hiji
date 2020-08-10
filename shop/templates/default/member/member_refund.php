<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/new_member_refund.css"  />

<!--售后退款-->
<div class="refund">
    <div class="refund-a">
        <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/refund_1.jpg">
    </div>
    <div class="refund-b">
        <div class="refund-bao">
            <div class="refund-b1">
                <div class="refund-b1-a">
                    <div class="refund-b1-a1">
                        <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
                    </div>
                    <div class="refund-b2">
                        <h3><?php echo $output['member_info']['member_nickname'] ?></h3>
                        <p>ID:<?php echo $output['member_info']['member_number'] ?></p>
                        <div class="homepage-hui">
                            <?php
                            $tplImgUrl = SHOP_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                            echo "<i class='homepage-tian' style='background:url($tplImgUrl) no-repeat;background-size:contain;background-position:center;'></i>";
                            ?>
                            <span><?php echo $output['member_info']['level_name'] ?></span>
                            <?php if($output['member_info']['positions_id']<8){?>
                                <?php
                                $tplImgUrl = SHOP_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                                echo "<i class='homepage-zun' style='background:url($tplImgUrl);background-size:cover;background-position:center;'></i>";
                                ?>
                                <span><?php echo $output['member_info']['position_name'] ?></span>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="refund-b3">
                <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/refund_2.jpg">
            </div>
        </div>
        <ul>
            <li><a href="<?php echo urlShop('member_refund','index',array('type'=>0));?>">所有订单 <span><?php echo $output['countAll']?></span></a></li>
            <li><a href="<?php echo urlShop('member_refund','index',array('type'=>1));?>">退款中 <span><?php echo $output['countRefundAll']?></span></a></span></a></li>
            <li><a href="<?php echo urlShop('member_refund','index',array('type'=>2));?>">退货中 <span><?php echo $output['countReturnAll']?></span></a></li>
            <li><a href="<?php echo urlShop('member_refund','index',array('type'=>3));?>">已完成 <span><?php echo $output['countCompleteAll']?></span></a></li>
        </ul>

    </div>
    <div class="refund-c">
        <div class="refund-c1">
            <table>
                <tr>
                    <th class="refund-shang">商品</th>
                    <th class="refund-tui">退款金额(元)</th>
                    <th class="refund-tui">审核状态</th>
                    <th class="refund-tui">平台确认</th>
                    <th class="refund-tui">操作</th>
                </tr>
            </table>
        </div>
        <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
            <div class="refund-c2">
                <?php foreach ($output['refund_list'] as $key => $val) { ?>
                    <ul>
                        <li class="refund-ding">
                                <div class="refund-ding-a">
                                    <img src="<?php echo cthumb($val['goods_image'],60);?>"  onMouseOver="toolTip('<img src=<?php echo cthumb($val['goods_image'],240);?>>')" onMouseOut="toolTip()"/>
                                </div>
                            <div>
                                <p><?php echo $val['goods_name']; ?></p>
                                <p>订单编号：<span><?php echo $val['order_sn'];?></span></p>
                                <p>退款编号：<span><?php echo $val['refund_sn']; ?></span></p>
                                <p>申请时间：<span><?php echo date("Y-m-d H:i:s",$val['add_time']);?></span></p>
                            </div>
                        </li>
                        <li class="refund-tui2"><?php echo $val['refund_amount'];?></li>
                        <li class="refund-tui2"><?php echo $output['state_array'][$val['seller_state']]; ?></li>
                        <li class="refund-tui2">
                            <?php echo ($val['seller_state'] == 2 && $val['refund_state'] >= 2) ? $output['admin_array'][$val['refund_state']]:''; ?>&nbsp;
                        </li>
                        <li class="refund-tui2">
                            <?php if(in_array($val['refund_type'],[1,3])){ ?>
                                <a href="index.php?controller=member_refund&action=view&refund_id=<?php echo $val['refund_id']; ?>"><?php echo $lang['nc_view'];?></a>
                            <?php }else{ ?>
                                <a href="index.php?controller=member_return&action=view&return_id=<?php echo $val['refund_id']; ?>"><?php echo $lang['nc_view'];?></a>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="refund-xian"></div>
                <?php } ?>
            </div>
            <div class="pagination"><?php echo $output['show_page']; ?></div>
        <?php } else { ?>
            <tr>
                <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
            </tr>
        <?php } ?>
    </div>
    <div class="refund-d">
        <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/refund_3.jpg">
    </div>
    <div class="refund-e">
        <div class="promote-b1">
            <div class="promote-b1-a">
                <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/true.png">
            </div>
            <p class="promote-b1-b">优秀供应商队商品</p>
        </div>

        <ul>
            <?php $sum = count($output['likeGoods']);
            while (!empty($output['likeGoods'])){
                $data = array_slice($output['likeGoods'],0,4);
                ?>
                <?php foreach ($data as $item):?>
            <li>
                    <a  href="/shop/index.php?controller=goods&action=index&goods_id=<?php echo $item['goods_id'] ?> " target="_blank">
                        <img  src="<?php echo $item['goods_image']; ?>" alt="<?php echo $item['goods_name']; ?>" title="<?php echo $item['goods_name']; ?>">
                    </a>
            </li>
                <?php endforeach; ?>
                <?php array_splice($output['likeGoods'],0,4); } ?>

        </ul>
    </div>
</div>
