<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<style type="text/css">
    .add{
        background:#ccc;
    }
</style>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>职级统计</h3>
                <h5>平台针对会员的各项数据统计</h5>
            </div>
            <?php echo $output['top_link'];?> </div>
    </div>
    <div class="ncap-form-all ncap-stat-general">
        <!--<div class="title">
            <h3>平台职级统计</h3>
        </div>-->
        <dl class="row">
            <dd class="opt">
                <ul class="nc-row">
                    <a href="Javascript:update_flex(-1)">
                    <li class="-1 li" style="display: block;">
                        <h4 class="h_-1" style="font-weight: bold;">平台拥有职级的总人数</h4>
                        <h6>平台拥有职级的总人数</h6>
                        <h2 class="timer" id="count-number"  data-to="<?php echo $output['total_count'];?>" data-speed="1500"></h2>
                    </li>
                    </a>
                    <?php foreach ($output['positions_type'] as $positions_id=>$positions_type_name){?>
                    <a href="Javascript:update_flex(<?php echo $positions_id;?>)">
                        <li class="li <?php echo $positions_id;?>">
                            <h4 class="h_<?php echo $positions_id;?>" style="font-weight: bold;"><?php echo $positions_type_name;?>总人数</h4>
                            <h6><?php echo $positions_type_name;?>总人数</h6>
                            <h2 class="timer" id="count-number"  data-to="<?php echo isset($output['contribution_info'][$positions_id]) ? $output['contribution_info'][$positions_id] : 0;?>" data-speed="1500"></h2>
                        </li>
                    </a>
                    <?php }?>
                </ul>
            </dd>
        </dl>
    </div>
    <div id="flexigrid"></div>
    <input id="level_id" name="level_id" value="-1" type="hidden"/>
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
function update_flex(levelId){
    var text = $('.h_'+levelId).html();
    $('.li').removeClass('add');
    $('.'+levelId).addClass('add');
    $('#level_id').val(levelId);
    $('.flexigrid').after('<div id="flexigrid"></div>').remove();
    var level = levelId;
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=stat_positions&action=get_xml&level='+level,
        colModel : [
            {display: '用户ID', name : 'user_id', width : 60, sortable : false, align: 'center', className: 'handle-s'},
            {display: 'ID编号', name : 'member_number', width : 200, sortable : false, align: 'center'},
            {display: '会员名称', name : 'member_name',  width : 150, sortable : true, align: 'center'},
            {display: '职务级别', name : 'positions',  width : 120, sortable : true, align: 'center'},
            {display: '当前登录时间', name : 'member_login_time',  width : 150, sortable : true, align: 'center'},
            {display: '上次登录时间', name : 'member_old_login_time',  width : 150, sortable : true, align: 'center'},
            {display: '当前登录IP', name : 'member_login_ip',  width : 150, sortable : true, align: 'center'},
            {display: '上次登录IP', name : 'member_old_login_ip',  width : 150, sortable : true, align: 'center'}
        ],
        buttons : [
            {display: '<i class="fa fa-file-excel-o"></i>导出'+text+'数据', name : 'excel', bclass : 'csv', title : '导出EXCEL文件', onpress : fg_operation }
        ],
        rp: 15,
        title: "职级统计"
    });


}

$(function () {
    laydate.render({
        elem: '#date-range'
        ,type: 'datetime'
        ,range: '~'
    });

    update_flex(-1);
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
    var stat_url='index.php?controller=stat_positions&action=get_xml&level='+$('#level_id').val();
    get_search_excel(stat_url,bDiv);
}
</script>