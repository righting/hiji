<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>平台利润统计</h3>
                <h5>平台利润统计</h5>
            </div>
        </div>
    </div>
    <div id="flexigrid"></div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery.numberAnimation.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/laydate/laydate.js"></script>
<script>
    function update_flex(){
        $("#flexigrid").flexigrid({
            url: "<?php echo urlAdminShop('stages','index',['get_type'=>'xml'])?>&"+$("#formSearch").serialize(),
            colModel : [
                {display: '分红期数', name : 'id', width : 100, sortable : false, align: 'center'},
                {display: '开始时间', name : 'start_time',  width : 200, sortable : true, align: 'center'},
                {display: '结束时间', name : 'end_time',  width : 200,  sortable : true, align: 'center'},
                {display: '税后总利润', name : 'total_money',  width : 200,  sortable : true, align: 'center'},
                {display: '剩余利润', name : 'money',  width : 200,  sortable : true, align: 'center'},
                {display: '状态', name : 'status',  width : 200, sortable : true, align: 'center'}
            ],
            sortname: "ob_id",
            sortorder: "desc",
            usepager: true,
            showTableToggleBtn: true,
            rp: 15,
            title: "期数列表"
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