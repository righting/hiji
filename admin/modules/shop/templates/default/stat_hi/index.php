<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>平台HI值统计</h3>
                <h5>平台针对会员的各项数据统计</h5>
            </div>
            <?php /*echo $output['top_link'];*/?><!-- </div>-->
            <form method="get" action="../stat/index.php" name="formSearch" id="formSearch" style="float:right;">
                <div id="searchCon" class="content" style="float:left;">
                    <div class="layout-box">
                        <dl style="float:left;">
                            <dt style="float:left; line-height: 50px; padding-right: 5px;">会员账号</dt>
                            <dd style="float:left; line-height: 50px; padding-right: 5px;">
                                <input id="member-name" name="member_name" value="" type="text" class="s-input-txt" style="margin-top: 12px;" />
                            </dd>
                        </dl>
                        <dl style="float:left;">
                            <dt style="float:left; line-height: 50px; padding-right: 5px;">选择统计周期</dt>
                            <dd style="float:left; line-height: 50px; padding-right: 5px;">
                                <input id="date-range" name="search_time" value="" type="text" class="s-input-txt" style="margin-top: 12px;" />
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="bottom" style="float:left; margin-top: 12px;"> <a href="javascript:void(0);" id="ncsubmit" class="ncap-btn ncap-btn-green mr5">提交查询</a></div>
            </form>
    </div>
    <div class="ncap-form-all ncap-stat-general">
        <!--<div class="title">
            <h3>平台HI值统计</h3>
        </div>-->
        <dl class="row">
            <dd class="opt">
                <ul class="nc-row">
                    <li <?php if(!$_GET['data_type']){ ?>style="background-color:#d6d5d5"<?php } ?> title="平台总 HI 值：<?php echo $output['total_hi_info']['total_hi'];?>">
                        <a href="/admin/modules/shop/index.php?controller=stat_hi&action=index">
                        <h4 style="font-weight: bold;">平台总 HI 值</h4>
                        <h6>平台总 HI 值</h6>
                        <h2 class="timer" id="count-number"  data-to="<?php echo $output['total_hi_info']['total_hi'];?>" data-speed="1500"></h2>
                        </a>
                    </li>
                    <li <?php if($_GET['data_type'] == 'upgrade_hi'){ ?>style="background-color:#d6d5d5"<?php } ?> title="升级总HI值：<?php echo $output['total_hi_info']['total_upgrade_hi'];?>">
                        <a href="/admin/modules/shop/index.php?controller=stat_hi&action=index&data_type=upgrade_hi">
                            <h4 style="font-weight: bold;">升级总HI值</h4>
                            <h6>升级获得的总 HI 值</h6>
                            <h2 class="timer" id="count-number"  data-to="<?php echo $output['total_hi_info']['total_upgrade_hi'];?>" data-speed="1500"></h2>
                        </a>
                    </li>
                    <li <?php if($_GET['data_type'] == 'recommend_team_hi'){ ?>style="background-color:#d6d5d5"<?php } ?> title="推荐团队总 HI 值：<?php echo $output['total_hi_info']['total_recommend_team_hi'];?>">
                        <a href="/admin/modules/shop/index.php?controller=stat_hi&action=index&data_type=recommend_team_hi">
                        <h4 style="font-weight: bold;">推荐团队总 HI 值</h4>
                        <h6>推荐团队获得的总 HI 值</h6>
                        <h2 class="timer" id="count-number"  data-to="<?php echo $output['total_hi_info']['total_recommend_team_hi'];?>" data-speed="1500"></h2>
                        </a>
                    </li>
                    <li <?php if($_GET['data_type'] == 'bonus_to_hi'){ ?>style="background-color:#d6d5d5"<?php } ?> title="奖金转换总 HI 值：<?php echo $output['total_hi_info']['total_bonus_to_hi'];?>">
                        <a href="/admin/modules/shop/index.php?controller=stat_hi&action=index&data_type=bonus_to_hi">
                        <h4 style="font-weight: bold;">奖金转换总 HI 值</h4>
                        <h6>奖金转换的总 HI 值</h6>
                        <h2 class="timer" id="count-number"  data-to="<?php echo $output['total_hi_info']['total_bonus_to_hi'];?>" data-speed="1500"></h2>
                        </a>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
    <div id="flexigrid"></div>
  <!--<div class="ncap-search-ban-s" id="searchBarOpen"><i class="fa fa-search-plus"></i>高级搜索</div>
  <div class="ncap-search-bar">
    <div class="handle-btn" id="searchBarClose"><i class="fa fa-search-minus"></i>收起边栏</div>
    <div class="title">
      <h3>高级搜索</h3>
    </div>
    <form method="get" action="../stat/index.php" name="formSearch" id="formSearch">
      <div id="searchCon" class="content">
        <div class="layout-box">
            <dl>
                <dt>会员账号</dt>
                <dd>
                    <input id="member-name" name="member_name" value="" type="text" class="s-input-txt" />
                </dd>
            </dl>
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
  </div>-->
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery.numberAnimation.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/laydate/laydate.js"></script>
<script>
function update_flex(){
    $('.ncap-stat-general-single').load("<?php echo urlAdminShop('stat_hi','index',['get_type'=>'xml','data_type'=>$_GET['data_type']?$_GET['data_type']:0])?>&" + $("#formSearch").serialize(),
        function () {
            $('.timer').each(count);
        });

    $("#flexigrid").flexigrid({
        url: "<?php echo urlAdminShop('stat_hi','index',['get_type'=>'xml','data_type'=>$_GET['data_type']?$_GET['data_type']:0])?>&"+$("#formSearch").serialize(),
        colModel : [
            {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
            {display: '用户ID', name : 'user_id', width : 60, sortable : false, align: 'center', className: 'handle-s'},
            {display: '邀请ID号', name : 'member_number', width : 200, sortable : false, align: 'center'},
            {display: '账户', name : 'member_name',  width : 120, sortable : true, align: 'center'},
            {display: '总hi值', name : 'total_hi',  width : 80, sortable : true, align: 'center'},
            {display: '升级获得', name : 'upgrade_hi',  width : 300, sortable : true, align: 'center'},
            {display: '邀请团队获得', name : 'recommend_team_hi',  width : 100, sortable : true, align: 'center'},
            {display: '奖金转换', name : 'bonus_to_hi',  width : 100, sortable : true, align: 'center'}
            ],
        buttons : [
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'excel', bclass : 'csv', title : '导出EXCEL文件', onpress : fg_operation }
        ],
        sortname: "ob_id",
        sortorder: "desc",
        usepager: true,
        showTableToggleBtn: true,
        rp: 15,
        title: "<?php echo $output['this_type_name'];?>统计"
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

	$('#searchBarOpen').click();


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
    var stat_url = "<?php echo urlAdminShop('stat_hi','index')?>";
    get_search_excel(stat_url,bDiv);
}
</script>