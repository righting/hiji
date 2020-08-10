<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>会员统计</h3>
        <h5>平台针对会员的各项数据统计</h5>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>
    <div class="ncap-form-all ncap-stat-general">
        <div class="title">
            <h3>平台会员信息统计</h3>
        </div>
        <dl class="row">
            <dd class="opt">
                <ul class="nc-row">
                    <li title="平台总积分：<?php echo $output['total_count'];?>">
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
                    <li title="实名认证人数：<?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?>人">
                        <h4>实名认证人数人数</h4>
                        <h6>已通过实名认证的人数</h6>
                        <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?></h2>
                    </li>
                    <li title="实名认证待审核人数：<?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?>人">
                        <h4>实名认证待审核人数</h4>
                        <h6>实名认证待审核的人数</h6>
                        <h2 class="timer" id="count-number"  data-speed="1500"><?php echo isset($output['level_statistics'][$level_id]) ? $output['level_statistics'][$level_id] : 0;?></h2>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/statistics.js"></script> 
<script>
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=stat_member&action=get_member_xml&t=<?php echo $_GET['t'];?>',
        colModel : [
            {display: '会员名称', name : 'member_name', width : 120, sortable : false, align: 'left'},
            {display: '真实姓名', name : 'member_truename',  width : 100, sortable : false, align: 'left'},
            {display: '邮箱', name : 'member_email',  width : 120, sortable : false, align: 'left'},
            {display: '注册时间', name : 'member_time',  width : 120, sortable : false, align: 'center'},
            {display: '登录次数', name : 'member_login_num',  width : 80, sortable : false, align: 'center'},
            {display: '最后登录时间', name : 'member_login_time',  width : 100, sortable : false, align: 'center'},
            {display: '最后登录IP', name : 'member_login_ip',  width : 100, sortable : false, align: 'center'},
            {display: '等级', name : 'level_name',  width : 50, sortable : false, align: 'center'},
            {display: '积分', name : 'member_points',  width : 50, sortable : false, align: 'center'},
            {display: '可用预存款(元)', name : 'available_predeposit',  width : 100, sortable : false, align: 'center'},
            {display: '冻结预存款(元)', name : 'freeze_predeposit',  width : 100, sortable : false, align: 'center'}
            ],
        buttons : [
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'excel', bclass : 'csv', title : '导出EXCEL文件', onpress : fg_operation }
        ],
        usepager: true,
        rp: 15,
        title: '会员详细'
    });
});
function fg_operation(name, bDiv){
    var stat_url = 'index.php?controller=stat_member&action=showmember&exporttype=excel&t=<?php echo $_GET['t'];?>';
    get_excel(stat_url,bDiv);
}
</script> 
