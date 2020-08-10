<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['member_index_manage']?></h3>
        <h5><?php echo $lang['member_shop_manage_subhead']?></h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li><?php echo $lang['member_index_help1'];?></li>
      <li><?php echo $lang['member_index_help2'];?></li>
    </ul>
  </div>
    <div class="ncap-form-all ncap-stat-general">
        <div class="title">
            <h3>平台会员信息统计</h3>
        </div>
        <dl class="row">
            <dd class="opt">
                <ul class="nc-row">
                    <li title="平台总人数：<?php echo $output['total_count']+$output['level_statistics'][7];?>">
                        <h4>平台总人数</h4>
                        <h6>平台总人数</h6>
                        <h2 class="timer" id="count-number" data-speed="1500"><?php echo $output['total_count']+$output['level_statistics'][7];?></h2>
                    </li>
                    <li title="平台拥有会员总人数：<?php echo $output['total_count'];?>">
                        <h4>平台拥有会员总人数</h4>
                        <h6>平台拥有会员总人数</h6>
                        <h2 class="timer" id="count-number" data-speed="1500"><?php echo $output['total_count'];?></h2>
                    </li>

                    <?php foreach ($output['level_type_name_for_level_id'] as $level_id=>$level_type_name){?>
                        <li title="<?php echo $level_type_name;?>人数：<?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?>人">
                            <h4><?php echo $level_type_name;?>人数</h4>
                            <h6><?php echo $level_type_name;?>人数</h6>
                            <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?></h2>
                        </li>
                    <?php }?>
                    <li title="实名认证人数：<?php echo isset($output['isauth_count']) ? $output['isauth_count'] : 0;?>人">
                        <h4>实名认证人数人数</h4>
                        <h6>已通过实名认证的人数</h6>
                        <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['isauth_count']) ? $output['isauth_count'] : 0;?></h2>
                    </li>
                    <li title="实名认证待审核人数：<?php echo isset($output['waitauth_count']) ? $output['waitauth_count'] : 0;?>人">
                        <h4>实名认证待审核人数</h4>
                        <h6>实名认证待审核的人数</h6>
                        <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['waitauth_count']) ? $output['waitauth_count'] : 0;?></h2>
                    </li>
                    <li title="经销商人数：<?php echo isset($output['dealers_count']) ? $output['dealers_count'] : 0;?>人">
                        <h4>经销商人数</h4>
                        <h6>经销商人数</h6>
                        <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['dealers_count']) ? $output['dealers_count'] : 0;?></h2>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=member&action=get_xml',
        colModel : [
            {display: '操作', name : 'operation', width : 120, sortable : true, align: 'center'},
            {display: '会员ID', name : 'member_id', width : 40, sortable : true, align: 'center'},
            {display: 'ID编号', name : 'member_number', width : 130, sortable : true, align: 'center'},
            {display: '会员名称', name : 'member_name', width : 120, sortable : true, align: 'left'},
            {display: '会员邮箱', name : 'member_email', width : 120, sortable : true, align: 'left'},
            {display: '会员手机', name : 'member_mobile', width : 100, sortable : true, align: 'center'},
//            {display: '会员性别', name : 'member_sex', width : 60, sortable : true, align: 'center'},
            {display: '真实姓名', name : 'member_truename', width : 100, sortable : true, align: 'left'},
//            {display: '出生日期', name : 'member_birthday', width : 100, sortable : true, align: 'center'},
            {display: '注册时间', name : 'member_time', width : 80, sortable : true, align: 'center'},
            {display: '最后登录时间', name : 'member_login_time', width : 80, sortable : true, align: 'center'},
            {display: '最后登录IP', name : 'member_login_ip', width : 80, sortable : true, align: 'center'},
            {display: '会员积分', name : 'member_points', width : 60, sortable : true, align: 'center'},
//            {display: '会员经验', name : 'member_exppoints', width : 60, sortable : true, align: 'center'},
            {display: '会员等级', name : 'member_grade', width : 60, sortable : false, align: 'center'},
            {display: '可用预存款(元)', name : 'available_predeposit', width : 90, sortable : true, align: 'center', className: 'normal'},
            {display: '冻结预存款(元)', name : 'freeze_predeposit', width : 80, sortable : true, align: 'center', className: 'abnormal'},
//            {display: '可用充值卡(元)', name : 'available_rc_balance', width : 100, sortable : true, align: 'center', className: 'normal'},
//            {display: '冻结充值卡(元)', name : 'freeze_rc_balance', width : 100, sortable : true, align: 'center', className: 'abnormal'},
            {display: '推荐人ID', name : 'from_user_id', width : 50, sortable : true, align: 'center'},
            {display: '团队人数', name : 'to_user_count', width : 50, sortable : true, align: 'center'},
            ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operation },
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出CVS文件', onpress : fg_operation }		
            ],
        searchitems : [
            {display: '会员编号', name : 'member_number'},
            {display: '会员名称', name : 'member_name'}
            ],
        sortname: "member_id",
        sortorder: "desc",
        title: '商城会员列表'
    });
	
});



function delMember(memberId){
    if (confirm('您确定要删除该用户吗？')) {
        $.post('index.php?controller=member&action=delMember',{memberId:memberId},function(data){
            if(data==1){
                location.href='';
            }
            console.log(data);
        })
    }
}


function fg_operation(name, bDiv) {
    if (name == 'add') {
        window.location.href = 'index.php?controller=member&action=member_add';
    }
    if (name == 'csv') {
        if ($('.trSelected', bDiv).length == 0) {
            if (!confirm('您确定要下载全部数据吗？')) {
                return false;
            }
        }
        var itemids = new Array();
        $('.trSelected', bDiv).each(function(i){
            itemids[i] = $(this).attr('data-id');
        });
        fg_csv(itemids);
    }
}

function fg_csv(ids) {
    id = ids.join(',');
    window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&action=export_csv&id=' + id;
}
</script> 

