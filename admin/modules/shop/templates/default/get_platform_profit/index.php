<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>平台历史总提成</h3>
                <h5>平台历史总提成</h5>
            </div>
        </div>
    </div>
    <div class="ncap-form-all ncap-stat-general">
        <div class="title">
            <h3>平台历史总提成</h3>
        </div>
    </div>
    <div id="flexigrid"></div>
  <div class="ncap-search-ban-s" id="searchBarOpen"><i class="fa fa-search-plus"></i>高级搜索</div>
  <div class="ncap-search-bar">
    <div class="handle-btn" id="searchBarClose"><i class="fa fa-search-minus"></i>收起边栏</div>
    <div class="title">
      <h3>高级搜索</h3>
    </div>
    <form method="get" action="../stat/index.php" name="formSearch" id="formSearch">
      <div id="searchCon" class="content">
        <div class="layout-box">
            <dl>
                <dt>选择统计周期</dt>
                <dd>
                    <input id="date-range" name="search_time" value="" type="text" class="s-input-txt" />
                </dd>
            </dl>
        </div>
      </div>
      <div class="bottom"> <a href="javascript:void(0);" id="ncsubmit" class="ncap-btn ncap-btn-green mr5">提交查询</a></div>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery.numberAnimation.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/laydate/laydate.js"></script>
<script>
function update_flex(){
    $('.ncap-stat-general-single').load("<?php echo urlAdminShop('get_platform_profit','index',['get_type'=>'xml'])?>&" + $("#formSearch").serialize(),
        function () {
            $('.timer').each(count);
        });

    $("#flexigrid").flexigrid({
        url: "<?php echo urlAdminShop('get_platform_profit','index',['get_type'=>'xml'])?>&"+$("#formSearch").serialize(),
        colModel : [
            {display: '订单编号', name : 'order_sn', width : 160, sortable : false, align: 'center', className: 'handle-s'},
            {display: '利润金额', name : 'money', width : 200, sortable : false, align: 'center'},
            {display: '利润的类型', name : 'type',  width : 120, sortable : true, align: 'center'},
            {display: '获取时间', name : 'created_at',  width : 120, sortable : true, align: 'center'},
            {display: '更新时间', name : 'updated_at',  width : 120, sortable : true, align: 'center'},
            {display: '操作', name : 'operation',  width : 100, sortable : true, align: 'center'}
            ],
        buttons : [
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'excel', bclass : 'csv', title : '导出EXCEL文件', onpress : fg_operation }
        ],
        sortname: "ob_id",
        sortorder: "desc",
        usepager: true,
        showTableToggleBtn: true,
        rp: 15,
        title: "平台利润"
    });
}
$(function () {
    laydate.render({
        elem: '#date-range'
        ,type: 'datetime'
        ,range: '~'
    });

    update_flex();
	$('#ncsubmit').click(function(){
	    $('.flexigrid').after('<div id="flexigrid"></div>').remove();
	    update_flex();
    });

    // 高级搜索重置
    $('#ncreset').click(function(){
        $('.flexigrid').after('<div id="flexigrid"></div>').remove();
        update_flex();
    });


// 高级搜索统计周期选择
    show_searchtime();
    $("#search_type").change(function(){
        show_searchtime();
    });
});

//展示搜索时间框
function show_searchtime(){
    s_type = $("#search_type").val();
    $("[id^='searchtype_']").hide();
    $("#searchtype_"+s_type).show();
}


function fg_operation(name, bDiv){
    var stat_url = "<?php echo urlAdminShop('stat_bonus_log','index')?>";
    get_search_excel(stat_url,bDiv);
}
</script>