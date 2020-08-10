<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_hi_styles.css" rel="stylesheet" type="text/css">

<div class="personal-setting">
    <div class="personal-hi-banner">
        <img src="<?php echo MEMBER_TEMPLATES_URL;?>/images/hi-banner_01.jpg">
    </div>
    <div class="personal-hi-message">
        <div class="hi-person">
            <div class="outer">
                <img src="<?php echo $output['member_info']['member_avatar']?$output['member_info']['member_avatar']:getMemberAvatar($_SESSION['avatar']); ?>">
            </div>
            <span><?php echo $output['member_info']['member_nickname']?></span>
            <ul class="hi-person-message">
                <li>现有HI值：<em><?php echo $output['hi_total']?$output['hi_total']:0?></em></li>
                <li>本月可转出HI值：<em><?php echo $output['EnableExchangeHiValue']['enable_hi'] ?></em></li>
                <li>本月已转出HI值：<em><?php echo $output['EnableExchangeHiValue']['exchangeComplete_month'] ?></em></li>
                <li>将到期的HI值：<em><?php echo $output['hi_expire']?$output['hi_expire']:0; ?></em></li>
            </ul>
        </div>
        <div class="hi-message">
            <div class="hi-message-left">
                <div class="hi-bonus-earn">
                    <h4><i></i>每日分红自动转入HI值：</h4>
                    <form id="form_company_info" action="<?php echo urlMember('member_hi','bonusAutoToHi') ?>" method="post">
                    <input type="hidden" value="ok" name="form_submit" />
                        <span>
                            设定每日奖金自动转入Hi值比例为：<input name="auto_exchange_hi" type="text" value="<?php echo $output['member_hi']['auto_to_hi_percent']*100 ?>">% ；百分比为0则不自动转入
                            <button onclick="javascript:ajaxpost('form_company_info', '', '', 'onerror');" >保存</button>
                        </span>
                    </form>
                </div>
                <div class="hi-bonus-withdraw">
                    <h4><i></i><a href="javascript:void(0)"  class="ncbtn ncbtn-grass" nc_type="dialog" dialog_title="HI值转分红" dialog_id="hitobonus"  uri="<?php echo urlMember('member_hi','hiExchangeBonus') ?>" dialog_width="550" title="HI值转分红">HI值转分红</a><em></em></h4>
                    <div>
                        <p>温馨提示：以每月第一天的总分红Hi值为基数，每月最高只可转30%到余额。</p>
                    </div>
                </div>
            </div>
            <div class="hi-message-right">

                <h4><i></i>直接转入Hi值</h4>
                <form method="post" action="<?php echo urlMember('member_hi','bonusExchangeHi') ?>" id="address_form" target="_parent">
                    <input type="hidden" name="form_submit" value="ok"/>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['member_id'] ?>"/>
                    <input type="hidden" id="available_predeposit" name="available_predeposit" value="<?php echo $output['available_predeposit']; ?>" />

                    <span>奖金余额：￥<input type="text"   value="<?php echo $output['member_info']['available_predeposit']?>" disabled></span>
                    <div><span>转入Hi值：<input type="text" name="exchange_hi" value="0"></span>
                        <button>提交</button>
                    </div>
                </form>




               <!-- <h4><i></i><a href="javascript:void(0)"  class="ncbtn ncbtn-bittersweet" nc_type="dialog" dialog_title="分红转HI值" dialog_id="my_address_edit"  uri="<?php /*echo urlMember('member_hi','bonusExchangeHi') */?>" dialog_width="550" title="分红转HI值">分红转HI值</a></h4>-->




            </div>
        </div>
    </div>
    <div class="personal-hi-details">
        <div class="personal-hi-title">
            <i></i>我的Hi明细
        </div>
        <div class="hi-details-list">
            <h3>
                <span>来源</span>
                <span>H值变化</span>
                <span>变更日期</span>
                <span>有效日期</span>
                <span>备注</span>
            </h3>
            <?php if ( !empty($output['log_list']) && is_array($output['log_list'])){ ?>
            <ul>
                <?php foreach ($output['log_list'] as $val) : ?>
                <li>
                    <span><?php echo $val['hi_type'] ?></span>
                    <span><?php echo $val['get_type'].$val['hi_value'] ?></span>
                    <span><?php echo $val['created_at'] ?></span>
                    <span><?php echo $val['expiration_at']  ?></span>
                    <span><?php echo $val['remark'] ?></span>
                </li>
                <?php endforeach;?>
            </ul>
            <?php }else{?>
               <div style="height:80px;text-align:center;line-height: 80px;color:#ccc;font-size:14px;">暂无数据</div>
            <?php }?>
        </div>
    </div>

    <?php if (count($output['log_list']) > 0) { ?>
        <div class="pagination"> <?php echo $output['show_page']; ?></div>
    <?php } ?>



    <div class="vip-level-list">
        <div class="personal-hi-title">
            <i></i>会员等级与分红Hi值
        </div>
        <h3>
            <b>分红Hi值与等级</b>
            <?php foreach($output['level_info'] as $k=>$v){?>
                <span>
                <img style="width:30px;height:26px;" src="<?php echo MEMBER_TEMPLATES_URL;?>/images/user_level_<?php echo $v['id'];?>.png"/>
                    <?php echo $v['level_name']; ?></span>
            <?php }?>
        </h3>
        <ul class="clearfix">
            <li>
                <b>升级赠送</b>
                <?php foreach($output['level_info'] as $k=>$v){?>
                    <span>+<?php echo $v['give_hi']; ?>Hi</span>
                <?php }?>
            </li>
            <li>
                <b>各等级获Hi值总数</b>
                <?php foreach($output['level_info'] as $k=>$v){?>
                    <span><?php echo $v['total_hi']; ?>Hi</span>
                <?php }?>
            </li>
            <li>
                <b>赠送时限</b>
                <?php foreach($output['level_info'] as $k=>$v){?>
                    <span><?php echo $v['hi_term']; ?>个月</span>
                <?php }?>
            </li>
            <li>
                <b>团队类：推荐赠送</b>
                <span>无</span>
                <span>+1Hi</span>
                <span>+1Hi</span>
                <span>+1Hi</span>
                <span>+1Hi</span>
                <span>+1Hi</span>
            </li>
            <li>
                <b>各等级获Hi值总数</b>
                <span>无</span>
                <span>1Hi</span>
                <span>2Hi</span>
                <span>3Hi</span>
                <span>4Hi</span>
                <span>5Hi</span>
            </li>
            <li>
                <b>存储类：分红自愿转让</b>
                <span>不限</span>
                <span>不限</span>
                <span>不限</span>
                <span>不限</span>
                <span>不限</span>
                <span>不限</span>
            </li>
        </ul>
        <p>温馨提示：赠送Hi值只作为计算分红依据，不能进行提现。</p>
    </div>
</div>







<script type="text/javascript">
    var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
    $(document).ready(function(){

        $('#address_form').validate({
            submitHandler:function(form){
                ajaxpost('address_form', '', '', 'onerror');
            },
            errorLabelContainer: $('#warning'),
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if(errors)
                {
                    $('#warning').show();
                }
                else
                {
                    $('#warning').hide();
                }
            },
            rules : {
                exchange_hi : {
                    required : true
                },

            },
            messages : {
                exchange_hi : {
                    required : '请输入HI值'
                },

            },

        });

    });
</script>









<!--弹出框-->
<!--<div id="autoToHi_dialog"  style="display:none;">
    <form style="padding: 10px"" id="form_company_info" action="<?php /*echo urlMember('member_hi','bonusAutoToHi') */?>" method="post">
    <input type="hidden" value="ok" name="form_submit" />
    <table border="0" cellpadding="0" cellspacing="0" class="all">
        <thead>
        <tr>
            <th colspan="2">每日分红自动转入HI值</th>
        </tr>
        </thead>
        <tbody>
        <tr style="height: 40px;">
            <th><i></i>转入比例：</th>
            <td>
                <input name="auto_exchange_hi" type="text" class="w20" value="<?php /*echo $output['member_hi']['auto_to_hi_percent']*100 */?>"/>%
                <span style="margin-left: 10px;text-align:center">百分比为0则不自动转入</span>
            </td>
        </tr>
        </tbody>
    </table>
    <button type="button" onclick="javascript:ajaxpost('form_company_info', '', '', 'onerror');" style="margin: 5px 100px ">提交设置</button>
    </form>
</div>-->
<!--弹出框结束-->
<!--<div class="essential">
    <div class="essential-nav">
        <?php /*include template('layout/submenu'); */?>
        <a href="javascript:void(0)" onclick="javascript:show_dialog1('autoToHi');" style="float: right" class="ncbtn ncbtn-sunflower" ><i class="icon-map-marker"></i>自动转入HI值</a>
        <a href="javascript:void(0)" style="float: right" class="ncbtn ncbtn-grass" nc_type="dialog" dialog_title="HI值转分红" dialog_id="hitobonus"  uri="<?php /*echo urlMember('member_hi','hiExchangeBonus') */?>" dialog_width="550" title="HI值转分红"><i class="icon-map-marker"></i>HI值转分红</a>
        <a href="javascript:void(0)" style="float: right" class="ncbtn ncbtn-bittersweet" nc_type="dialog" dialog_title="分红转HI值" dialog_id="my_address_edit"  uri="<?php /*echo urlMember('member_hi','bonusExchangeHi') */?>" dialog_width="550" title="分红转HI值"><i class="icon-map-marker"></i>分红转HI值</a>
    </div>
    <div id="tabbox">
        <ul class="tabs" id="tabs2">
            <li>HI值总额</li>
            <li>分红HI值</li>
        </ul>
        <ul class="tab_conbox" id="tab_conbox2">
            <li class="tab_con " style="display: list-item;">
                <dl>
                   <?php /*if(!isset($output['myhi']) && !empty($output['myhi'])){ */?>
                    <?php /* foreach ($output['myhi'] as $v ): */?>
                    <dd style="width: 33%">
                        <span><?php /*echo $v['type']*/?></span>
                        <em><?php /*echo $v['value']*/?><?php /*echo $lang['currency_zh']; */?></em>
                    </dd>
                    <?php /*endforeach; */?>
                   <?php /*} */?>
                </dl>
            </li>
            <li class="tab_con " >
                <dl>
                    <dd style="width: 25%">
                        <span>现有HI值</span>
                        <em><?php /*echo $output['hi_total']?$output['hi_total']:0*/?></em>
                    </dd>
                    <dd style="width: 25%">
                        <span>本月可转出HI值</span>
                        <em><?php /*echo $output['EnableExchangeHiValue']['enable_hi'] */?></em>
                    </dd>
                    <dd style="width: 25%">
                        <span>本月已转出HI值</span>
                        <em><?php /*echo $output['EnableExchangeHiValue']['exchangeComplete_month'] */?></em>
                    </dd>
                    <dd style="width: 25%">
                        <span>将到期的HI值</span>
                        <em><?php /*echo $output['hi_expire']?$output['hi_expire']:0; */?></em>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="partic-list">
        <h3>
            <span style="width: 20%">来源/用途</span>
            <b style="width: 20%">分红变化</b>
            <b style="width: 20%">变更日期</b>
            <b style="width: 20%">过期日期</b>
            <b style="width: 20%">备注</b>
        </h3>
        <?php /*if ( !empty($output['log_list']) && is_array($output['log_list'])){ */?>
        <ul>
            <?php /*foreach ($output['log_list'] as $val) : */?>
            <li>
                <span style="width: 20%"><?php /*echo $val['hi_type'] */?></span>
                <b style="width: 20%"><?php /*echo $val['get_type'].$val['hi_value'] */?></b>
                <b style="width: 20%"><?php /*echo $val['created_at'] */?></b>
                <b style="width: 20%"><?php /*echo $val['expiration_at']  */?></b>
                <b style="width: 20%"><?php /*echo $val['remark'] */?></b>
            </li>
            <?php /*endforeach;*/?>
        </ul>
        <?php /*}else{*/?>
               <div class="warning-option"><i>&nbsp;</i><span><?php /*echo $lang['no_record']; */?></span></div>
        <?php /*}*/?>
    </div>
    <?php /*if (count($output['log_list']) > 0) { */?>
        <div class="pagination"> <?php /*echo $output['show_page']; */?></div>
    <?php /*} */?>
</div>-->

<script type="text/javascript">
    $(document).ready(function() {
        jQuery.jqtab = function(tabtit,tab_conbox,shijian) {
            $(tab_conbox).find("li").hide();
            $(tabtit).find("li:first").addClass("thistab").show();
            $(tab_conbox).find("li:first").show();

            $(tabtit).find("li").bind(shijian,function(){
                $(this).addClass("thistab").siblings("li").removeClass("thistab");
                var activeindex = $(tabtit).find("li").index(this);
                $(tab_conbox).children().eq(activeindex).show().siblings().hide();
                return false;
            });

        };

        $.jqtab("#tabs","#tab_conbox","click");

        $.jqtab("#tabs2","#tab_conbox2","mouseenter");

    });
    function show_dialog1(id) {//弹出框js
        var d = DialogManager.create(id);//不存在时初始化(执行一次)
        var  dialog_html= $("#" + id + "_dialog").html();

        var dialog_html_out=$("#" + id + "_dialog").detach();
        d.setTitle('设置每日分红自动转入到HI值');
        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(320);
        d.show('center', 1);
        $('body').append(dialog_html_out);
    }
    $(function(){
        $("#hi_to_bonus").click(function(){
            var hi_value=$("#hi_value").val();
            var user_id=$(this).data("userid");
            var hi_ok=parseInt($("#hi_ok").val());
            var form_submit="ok";
            if(hi_value.length==0){
                alert("请输入要换现的HI值");
                return ;
            }
            if(Math.floor(hi_value)!=hi_value){
                alert("HI值必须为正整数");
                return ;
            }
            hi_value = parseInt(hi_value);
            if(hi_value<=0 ){
                alert("HI值必须为正整数");
                return ;
            }
            if(hi_value>hi_ok){
                alert("你没有足够的HI换现，请重新输入");
                return ;
            }
            $.post("<?php echo urlMember('member_hi','hiExchangeBonus') ?>",{'hi_value':hi_value,'user_id':user_id,'form_submit':form_submit},function(data){
                alert(data);
                location.reload();
            });
        });
    });
</script>
<style>
    .hiform input{border-radius:5px;font-size: 16px; font-weight:bold; }
    .hiform span{font-size: 18px;color: #cd0a0a}
    .hiform li{height: 40px;width: 100%;font-size: 14px}
    .hiform td{width: 50%;border-top: 0px solid black
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;padding: 10px}
    .hiform {border: double; }

</style>