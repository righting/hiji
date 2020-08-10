<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style>
    .ncap-stat-general li {
        width: 30%;
        height: 60px;
        position: relative;
        z-index: 1;
        border-top: dashed 1px #E7E7E7;
        border-left: dashed 1px #E7E7E7;
        margin: -1px 0 0 -1px;
    }

    .add{
        background:#ccc;
    }
</style>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>平台销量统计</h3>
                <h5>平台各项销量数据统计</h5>
            </div>
        </div>
    </div>
    <div class="ncap-form-all ncap-stat-general">
        <!--<div class="title">
            <h3>平台销量统计</h3>
        </div>-->
        <dl class="row">
            <dd class="opt">
                <ul class="nc-row">
                    <a href="Javascript:update_flex()">
                    <li class="li 1" title="平台总销售额(元) = 用户个人消费额 + 个人微商店铺销售额">
                        <h4 style="top: 21px; font-weight: bold;">平台总销售额</h4>
                        <!--<h6>平台总销售额(元) = 用户个人消费额 + 个人微商店铺销售额</h6>-->
                        <h2 class="timer" id="total-money" data-speed="1500"><?php echo $output['total_money'];?>元</h2>
                    </li>
                    </a>

                    <a href="Javascript:update_flex_b()">
                        <li class="li 3"  title="平台总利润(元) = 平台总销售额 - 货款 - 运费">
                            <h4 style="top: 21px; font-weight: bold;">平台总利润</h4>
                            <!--<h6>平台总利润(元) = 平台总销售额 - 货款 - 运费</h6>-->
                            <h2 class="timer" id="goods_total_money" data-speed="1500"><?php echo $output['goods_total_money'];?>元</h2>
                        </li>
                    </a>

                    <a href="Javascript:update_flex_c()">
                    <li class="li 2"  title="平台税后总利润(元) = 平台总利润 - 税额">
                        <h4 style="top: 21px; font-weight: bold;">平台税后总利润</h4>
                        <!--<h6>平台税后总利润(元) = 平台总利润 - 税额</h6>-->
                        <h2 class="timer" id="total-after-tax-profit" data-speed="1500"><?php echo $output['goods_after_tax_profit_money'];?>元</h2>
                    </li>
                    </a>

                    <a href="Javascript:update_flex_d()">
                        <li class="li 4"  title="平台分红总金额(元) = 平台税后总利润 - 个人消费分红">
                            <h4 style="top: 21px; font-weight: bold;">平台分红总金额</h4>
                            <!--<h6>平台分红总金额(元) = 平台税后总利润 - 个人消费分红</h6>-->
                            <h2 class="timer" id="user_bonus_money" data-speed="1500"><?php echo $output['user_bonus_money'];?>元</h2>
                        </li>
                    </a>

                    <a href="index.php?controller=stat_consumption">
                    <li  title="普通用户和会员消费额">
                        <h4 style="top: 21px; font-weight: bold;">用户个人消费额</h4>
                        <!--<h6>用户个人消费额</h6>-->
                        <h2 class="timer" id="type-and-money-for-one"  data-speed="1500"><?php echo $output['type_and_money_for_one'];?>元</h2>
                    </li>
                    </a>
                    <a href="index.php?controller=stat_seller_sale">
                    <li title="个人微商店铺销售额">
                        <h4 style="top: 21px; font-weight: bold;">个人微商店铺销售额</h4>
                        <!--<h6>个人微商店铺销售额</h6>-->
                        <h2 class="timer" id="type-and-money-for-two"  data-speed="1500"><?php echo isset($output['type_and_money'][2]) ? $output['type_and_money'][2] : 0;?>元</h2>
                    </li>
                    </a>
                    <a href="index.php?controller=stat_store_sale">
                    <li title="供应商销售额(元) = 自营店铺销售额 + 入驻店名销售额">
                        <h4 style="top: 21px; font-weight: bold;">供应商销售额</h4>
                        <!--<h6>供应商销售额(元) = 自营店铺销售额 + 入驻店名销售额</h6>-->
                        <h2 class="timer" id="type-and-money-for-three"  data-speed="1500"><?php echo isset($output['type_and_money'][3]) ? $output['type_and_money'][3] : 0;?>元</h2>
                    </li>
                    </a>
                </ul>
        </dl>
    </div>
    <div id="flexigrid"></div>
  <!--<div class="ncap-search-ban-s" id="searchBarOpen"><i class="fa fa-search-plus"></i>高级搜索</div>
  <div class="ncap-search-bar">
    <div class="handle-btn" id="searchBarClose"><i class="fa fa-search-minus"></i>收起边栏</div>
    <div class="title">
      <h3>高级搜索</h3>
    </div>
    <form method="get" action="<?php /*echo urlAdminShop('stat_platform_sales') */?>" name="formSearch" id="formSearch">
      <div id="searchCon" class="content">
        <div class="layout-box">
            <dl>
                <dt>选择统计周期</dt>
                <dd>
                    <input id="search-time" name="search_time" value="" type="text" class="s-input-txt" />
                </dd>
            </dl>
        </div>
      </div>
        <div class="bottom">
            <a href="javascript:void(0);" id="ncsubmit" class="ncap-btn ncap-btn-green mr5">提交查询</a>
        </div>
    </form>
  </div>-->
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/laydate/laydate.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/statistics.js"></script>
<script>
    function update_flex(){
        $('.li').removeClass('add');
        $('.1').addClass('add');
        $('.flexigrid').after('<div id="flexigrid"></div>').remove();
        $("#flexigrid").flexigrid({
            //url: "<?php echo urlAdminShop('stat_positions','index',['get_type'=>'xml'])?>&"+$("#formSearch").serialize(),
            url: 'index.php?controller=stat_platform_sales&action=get_xml',
            colModel : [
                {display: '用户ID', name : 'user_id', width : 60, sortable : false, align: 'center', className: 'handle-s'},
                {display: 'ID编号', name : 'member_number', width : 150, sortable : true, align: 'center'},
                {display: '用户名', name : 'member_name', width : 120, sortable : true, align: 'center'},
                {display: '所属类型', name : 'type', width : 200, sortable : false, align: 'center'},
                {display: '消费金额', name : 'total_money',  width : 150, sortable : true, align: 'center'},
                {display: '操作时间', name : 'member_login_time',  width : 150, sortable : true, align: 'center'}
            ],
            rp: 10,
            title: "平台总销售额"
        });

    }

    function update_flex_b(){
        $('.li').removeClass('add');
        $('.3').addClass('add');
        $('.flexigrid').after('<div id="flexigrid"></div>').remove();
        $("#flexigrid").flexigrid({
            url: 'index.php?controller=stat_platform_sales&action=get_xml_b',
            colModel : [
                {display: '订单ID', name : 'user_id', width : 120, sortable : false, align: 'center', className: 'handle-s'},
                {display: '订单编号', name : 'order_sn', width : 150, sortable : true, align: 'center'},
                {display: '商品总价', name : 'order_amount', width : 120, sortable : true, align: 'center'},
                {display: '商品运费', name : 'shipping_fee', width : 120, sortable : true, align: 'center'},
                {display: '商品货款', name : 'goods_costprice', width : 120, sortable : true, align: 'center'},
                {display: '商品利润', name : 'money', width : 120, sortable : true, align: 'center'},
                {display: '创建日期', name : 'updated_at', width : 200, sortable : false, align: 'center'}
            ],
            rp: 10,
            title: "平台总利润"
        });
    }

    function update_flex_c(){
        $('.li').removeClass('add');
        $('.2').addClass('add');
        $('.flexigrid').after('<div id="flexigrid"></div>').remove();
        $("#flexigrid").flexigrid({
            url: 'index.php?controller=stat_platform_sales&action=get_xml_c',
            colModel : [
                {display: '订单ID', name : 'user_id', width : 120, sortable : false, align: 'center', className: 'handle-s'},
                {display: '订单编号', name : 'order_sn', width : 150, sortable : true, align: 'center'},
                {display: '商品总价', name : 'order_amount', width : 120, sortable : true, align: 'center'},
                {display: '商品运费', name : 'shipping_fee', width : 120, sortable : true, align: 'center'},
                {display: '商品货款', name : 'goods_costprice', width : 120, sortable : true, align: 'center'},
                {display: '商品税率', name : 'platform_tax_rate', width : 120, sortable : true, align: 'center'},
                {display: '商品税额', name : 'platform_tax_rate_money', width : 120, sortable : true, align: 'center'},
                {display: '税后金额', name : 'money', width : 120, sortable : true, align: 'center'},
                {display: '创建日期', name : 'updated_at', width : 200, sortable : false, align: 'center'}
            ],
            rp: 10,
            title: "平台税后总利润"
        });
    }

    function update_flex_d(){
        $('.li').removeClass('add');
        $('.4').addClass('add');
        $('.flexigrid').after('<div id="flexigrid"></div>').remove();
        $("#flexigrid").flexigrid({
            url: 'index.php?controller=stat_platform_sales&action=get_xml_d',
            colModel : [
                {display: '订单ID', name : 'user_id', width : 120, sortable : false, align: 'center', className: 'handle-s'},
                {display: '订单编号', name : 'order_sn', width : 150, sortable : true, align: 'center'},
                {display: '商品总价', name : 'order_amount', width : 120, sortable : true, align: 'center'},
                {display: '商品运费', name : 'shipping_fee', width : 80, sortable : true, align: 'center'},
                {display: '商品货款', name : 'goods_costprice', width : 120, sortable : true, align: 'center'},
                {display: '商品税率', name : 'platform_tax_rate', width : 80, sortable : true, align: 'center'},
                {display: '商品税额', name : 'platform_tax_rate_money', width : 120, sortable : true, align: 'center'},
                {display: '税后金额', name : 'money', width : 120, sortable : true, align: 'center'},
                {display: '个人分红比例', name : 'user_consumption_bonus_ratio', width : 100, sortable : true, align: 'center'},
                {display: '个人分红金额', name : 'user_consumption_bonus_money', width : 120, sortable : true, align: 'center'},
                {display: '平台分红金额', name : 'platform_consumption_bonus_money', width : 120, sortable : true, align: 'center'},
                {display: '创建日期', name : 'updated_at', width : 200, sortable : false, align: 'center'}
            ],
            rp: 10,
            title: "平台税后总利润"
        });
    }





$(function () {
    update_flex();

    laydate.render({
        elem: '#search-time'
        ,type: 'datetime'
        ,range: '~'
    });

    $('#ncsubmit').click(function(){
        var _date = $('#search-time').val();
        $.get("<?php echo urlAdminShop('stat_platform_sales') ?>",{search_time:_date,get_type:'json'},function(data){
            var total_money = data['total_money'];
            var user_bonus_money = data['user_bonus_money'];
            var goods_total_money = data['goods_total_money'];
            var goods_after_tax_profit_money = data['goods_after_tax_profit_money'];
            var type_and_money_for_one = data['type_and_money_for_one'];
            var type_and_money_for_three = data['type_and_money_for_three'];
            var type_and_money_for_two = data['type_and_money_for_two'];
            $('#total-money').text(total_money+'元');
            $('#total-money').closest('li').attr('title','平台总销售额：'+total_money+'元');

            $('#goods_total_money').text(goods_total_money+'元');
            $('#goods_total_money').closest('li').attr('title','平台总利润：'+goods_total_money+'元');

            $('#user_bonus_money').text(user_bonus_money+'元');
            $('#user_bonus_money').closest('li').attr('title','平台分红总金额：'+user_bonus_money+'元');

            $('#type-and-money-for-one').text(type_and_money_for_one+'元');
            $('#type-and-money-for-one').closest('li').attr('title','用户个人消费额（普通用户和会员）：'+type_and_money_for_one+'元');


            $('#type-and-money-for-two').text(type_and_money_for_two+'元');
            $('#type-and-money-for-two').closest('li').attr('title','个人微商铺销售额：'+type_and_money_for_two+'元');

            $('#type-and-money-for-three').text(type_and_money_for_three+'元');
            $('#type-and-money-for-three').closest('li').attr('title','供应商销售额：'+type_and_money_for_three+'元');

            $('#total-after-tax-profit').text(goods_after_tax_profit_money+'元');
            $('#total-after-tax-profit').closest('li').attr('title','平台总利润：'+goods_after_tax_profit_money+'元');
        },'json');
    });
});
</script>