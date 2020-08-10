<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_invo.css" rel="stylesheet" type="text/css">
<!--我的发票-->
<div class="receipt">
    <div class="receipt-ballots" style="display: block">
        <div class="receipt-ballots-a">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/receipt_1.jpg">
        </div>
        <div class="receipt-ballots-b">
            <div class="receipt-ballots-b1">
                <div class="receipt-yidong">
                    <div class="promote-sculpture-a">
                        <img  src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
                    </div>
                    <div class="promote-sculpture-b">
                        <p><?php echo $output['member_info']['member_nickname'] ?></p>
                        <p class="promote-sculpture-b1">ID:<?php echo $output['member_info']['member_number'] ?></p>
                    </div>
                </div>
                <div class="receipt-yidong2">
                    <div class="promote-sculpture-c1">
                        <p>会员等级</p>
                        <p>团队职级</p>
                    </div>
                    <div class="promote-sculpture-d">
                        <div class="promote-sculpture-d3">
                            <div class="promote-sculpture-d1">
                                <?php
                                $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                                echo "<img src='$tplImgUrl'/>";
                                ?>
                            </div>
                            <?php if($output['member_info']['positions_id']<8){?>
                                <div class="promote-sculpture-d2">
                                    <?php
                                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                                    echo "<img src='$tplImgUrl'/>";
                                    ?>
                                </div>
                            <?php }?>
                        </div>
                        <div class="promote-sculpture-e">
                            <p class="promote-sculpture-p1">
                                <?php echo $output['member_info']['level_name']?>
                            </p>
                            <p class="promote-sculpture-p2">
                                <?php echo $output['member_info']['position_name']?>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="receipt-xian"></div>
            </div>
            <div class="receipt-ballots-b2">
                <div class="receipt-ballots-b2-a">
                    可开金额：<span>￥<?php echo $output['this_user_invoice_money_info']['can_be_opened_money']; ?><?php echo $lang['currency_zh']; ?></span>
                </div>
                <div class="receipt-ballots-b2-b">
                    <a href="javascript:void(0)"><span class="receipt-shen">申请开票</span></a>
                    <a href="javascript:void(0)"><a href="<?php echo urlMember('member_address','address')?>"><span >邮寄信息</span></a></a>
                </div>
            </div>
        </div>
        <div class="receipt-ballots-c">
            <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/receipt_2.jpg">
        </div>
        <div class="receipt-ballots-d3">
            <div class="refund-c1">
                <table>
                    <tbody><tr>
                        <th class="refund-shang">申请时间</th>
                        <th class="refund-tui">开票金额(元)</th>
                        <th class="refund-tui">发票抬头(元)</th>
                        <th class="refund-tui">状态(元)</th>
                        <th class="refund-tui">操作</th>
                    </tr>
                    </tbody></table>
            </div>
            <div class="receipt-ballots-d">

                <?php if (count($output['list']) > 0) { ?>
                    <ul>
                        <?php foreach ($output['list'] as $v) { ?>
                            <li class="receipt-ballots-d1"><?php echo $v['created_at']; ?></li>
                            <li class="refund-tui2"><?php echo $v['money']; ?></li>
                            <li class="refund-tui2"><?php echo $v['title']; ?></li>
                            <li class="refund-tui2 receipt-kai"><?php echo $output['status_info'][$v['status']]; ?></li>
                            <li class="refund-tui2">
                                <a href="<?php echo urlMember('invoice','info',array('id'=>$v['id']))?>">详情</a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <tr>
                        <td colspan="20" class="norecord">
                            <div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></div>
                        </td>
                    </tr>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="receipt-information" style="display: none">
        <div class="receipt-increment">
            <div class="receipt-information-a1">
                <em>填写增票资质信息</em>
                <span>(所有信息均为必填)</span>
            </div>
            <p class="receipt-increment-a">订单编号：<span>&nbsp;</span></p>
            <p class="receipt-increment-a">可开票金额：<span>￥<?php echo $output['this_user_invoice_money_info']['can_be_opened_money']; ?><?php echo $lang['currency_zh']; ?></span></p>
            <div class="receipt-increment-d">
                发票抬头类型：
                <input type="radio" onclick="marriageStatus();"  name="marriageStatus" value="1" checked="checked" class="receipt-checked">个人
                <input type="radio" onclick="marriageStatus();" name="marriageStatus" value="2"  class="receipt-checked" >企业
            </div>
            <h2>确认发票信息</h2>
            <div class="receipt-increment-b">
                <dl>
                    <dt><i class="required">*</i>发票类型：</dt>

                    <select id="invoice-type">
                        <option value="纸质增值税发票">纸质增值税发票</option>
                        <option value="纸质增值税普票">纸质增值税普票</option>

                        <option value="电子增值税发票">电子增值税发票</option>
                        <option value="电子增值税普票">电子增值税普票</option>
                    </select>

                </dl>
            </div>
            <div class="receipt-xian-c">
                <span class="receipt-san1">
                      <i class="receipt-san"></i>
                </span>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>填写开票金额：</dt>
                    <dd>
                        <input class="text w300" type="text" onchange="checkMoney();"  id="money" name="money" value="">
                        <p class="hint hint-money">

                        </p>
                    </dd>
                </dl>
            </div>


            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required">*</i>填写发票抬头：</dt>
                    <dd>
                        <input class="text w300" type="text" id='title' name="title" value="">
                        <p class="hint">
                            发票项目：商家默认将以订单明细开具发票，如需要开具其他项目，请确认提交后与商家沟通协调
                        </p>
                    </dd>
                </dl>
            </div>


            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required"></i>联系人：</dt>
                    <dd>
                        <input class="text w300" type="text" name="name" id="linkName" value="<?php echo $output['address']['true_name']?>">
                        <p class="hint">

                        </p>
                    </dd>
                </dl>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required"></i>联系电话：</dt>
                    <dd>
                        <input class="text w300" type="text" name="phone" id="linkPhone" value="<?php echo $output['address']['mob_phone']?>">
                        <p class="hint">

                        </p>
                    </dd>
                </dl>
            </div>

            <div class="receipt-increment-c" style="display: block">
                <dl>
                    <dt><i class="required"></i>邮寄地址：</dt>
                    <dd>
                        <input class="text w300" type="text" name="address" id="address" value="<?php echo $output['address']['area_info'] . $output['address']['address']?>">
                        <p class="hint">

                        </p>
                    </dd>
                </dl>
            </div>


        </div>
        
        
        <!--企业发票信息-->
        <div id="company" style="display:none; ">

            <div class="receipt-increment-e">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/receipt_3.jpg">
            </div>

            <div class="receipt-information-a">
            <dl>
                <dt><i class="required">*</i>纳税人识别号：</dt>
                <dd>
                    <input name=""  maxlength="50" id="sbh_number" value="">
                    <span></span>
                </dd>
            </dl>

            <dl>
                <dt>开户银行：</dt>
                <dd>
                    <input name="" type="" maxlength="50" id="bank_name" value="">
                    <span></span>
                </dd>
            </dl>
            <dl>
                <dt>银行账户：</dt>
                <dd>
                    <input name="" type="" maxlength="50" id="bank_account" value="">
                    <span></span>
                </dd>
            </dl>
        </div>

        </div>
        
        <div class="receipt-increment-f">
            <span>请确认您的信息</span>
            <ul>
                <li class="receipt-increment-f-a" id="submit">
                    <a href="javascript:void(0)" onclick="submit();">提交申请</a>
                </li>
                <li class="receipt-increment-f-a receipt-ti"><a href="javascript:void(0)">取消</a></li>
            </ul>

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









<form action="<?php echo urlMember('invoice','apply_save');?>" method="post" id="applySubmit">
    <input type="hidden" value="1" name="invoice_type" id="submit-invoice-type"/>
    <input type="hidden" value="1" name="type" id="submit-type"/>
    <input type="hidden" value="0" name="money" id="submit-money"/>
    <input type="hidden" value="" name="title" id="submit-title"/>
    <input type="hidden" value="" name="true_name" id="submit-true-name"/>
    <input type="hidden" value="" name="mob_phone" id="submit-mob-phone"/>
    <input type="hidden" value="" name="address" id="submit-address"/>


    <input type="hidden" value="" name="sbh_number" id="submit-sbh-number"/>
    <input type="hidden" value="" name="bank_name" id="submit-bank-name"/>
    <input type="hidden" value="" name="bank_account" id="submit-bank-account"/>


</form>

<input type="hidden" id="checkSubmit" value="0"/>


<script>
    $(document).ready(function(){
        $(".receipt-ti").click(function () {
            $(".receipt-information").hide();
            $(".receipt-ballots").show();
        });
        $(".receipt-shen").click(function () {
            $(".receipt-ballots").hide();
            $(".receipt-information").show();
        });
    });


    function marriageStatus(){
        var val=$('input[name="marriageStatus"]:checked').val();
        if(val==1){
            $("#company").hide();
        }else{
            $("#company").show();
        }
    }


    function checkMoney(){
        var money = $('#money').val();
        var reg = /^[0-9]+$/;
        $('.hint-money').html('');
        if (!reg.test(money)) {
            $('.hint-money').html('只能输入数字');
        }else{
            if(money > <?php echo $output['this_user_invoice_money_info']['can_be_opened_money']; ?>){
                $('.hint-money').html('已超出可开票金额');
            }
        }
    }

    function submit(){
        var checkSubmit = $('#checkSubmit').val();
        var invoiceType = $("#invoice-type").val();
        var val=$('input[name="marriageStatus"]:checked').val();
        var money = $('#money').val(); //开票金额
        var title = $('#title').val(); //抬头
        var linkName = $('#linkName').val(); //联系人
        var linkPhone = $('#linkPhone').val(); //联系电话
        var address = $('#address').val(); //详细地址
        var sbh_number = $('#sbh_number').val();//纳税人识别号
        var bankName = $('#bank_name').val();//开户行
        var bankAccount = $('#bank_account').val();//银行账号
        var reg = /^[0-9]+$/;
        if(checkSubmit==0){
           $('#checkSubmit').val(1);
            if(money=='' || money==0){$('#checkSubmit').val(0);return;}
            if (!reg.test(money)) {
                $('.hint-money').html('只能输入数字');
                $('#checkSubmit').val(0);
                return;
            }else{
                if(money > <?php echo $output['this_user_invoice_money_info']['can_be_opened_money']; ?>){
                    $('.hint-money').html('已超出可开票金额');
                    $('#checkSubmit').val(0);
                    return;
                }
            }

            if(title==''){
                alert('请输入发票抬头');
                $('#checkSubmit').val(0);
                return;
            }

            $('#submit-invoice-type').val(invoiceType);
            $('#submit-type').val(val);
            $('#submit-money').val(money);
            $('#submit-title').val(title);

            $('#submit-true-name').val(linkName);
            $('#submit-mob-phone').val(linkPhone);
            $('#submit-address').val(address);

            //1=个人 2=企业
            if(val==2){
                if(sbh_number==''){
                    alert('纳税人识别号不能为空');
                    $('#checkSubmit').val(0);
                    return;
                }
                $('#submit-sbh-number').val(sbh_number);
                $('#submit-bank-name').val(bankName);
                $('#submit-bank-account').val(bankAccount);
            }
            $('#applySubmit').submit();

        }
    }


</script>