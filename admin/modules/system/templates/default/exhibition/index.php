<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>展示型文章</h3>
        <h5>个人中心一些单页面的展示型栏目</h5>
      </div>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>会员中心的：奖励制度、晋级说明、经销商协议和政策等都是在这里添加的</li>
    </ul>
  </div>
  <table class="flex-table">
    <thead>
      <tr>
        <th width="24" align="center" class="sign"><i class="ico-check"></i></th>
        <th width="60" class="handle-s" align="center">操作</th>
        <th width="300" align="left">标题</th>
        <th width="300" align="left">时间</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

      <?php if(!empty($output['lists']) && is_array($output['lists'])){ ?>
      <?php foreach($output['lists'] as $k => $v){ ?>
      <tr>
        <td class="sign"><i class="ico-check"></i></td>
        <td class="handle-s"><a class="btn blue" href="<?php echo urlAdminSystem('exhibition','edit',['id'=>$v['id']]); ?>"><i class="fa fa-pencil-square-o"></i>修改</a></td>
        <td><?php echo $v['title']; ?></td>
        <td><?php echo $v['created_at']; ?></td>
        <td></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no-data">
        <td colspan="100" class="no-data"><i class="fa fa-lightbulb-o"></i><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script>
$(function(){
	$('.flex-table').flexigrid({
		height:'auto',// 高度自动
		usepager: false,// 不翻页
		striped: true,// 使用斑马线
		resizable: false,// 不调节大小
		title: '<?php echo $lang['nc_list'];?>',// 表格标题
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据' , onpress : fg_operation}
        ],
		reload: false,// 不使用刷新
		columnControl: false// 不使用列控制      
    });

    function fg_operation(name) {
        if (name == 'add') {
            window.location.href = "<?php echo urlAdminSystem('exhibition','add');?>";
        }
    }
});
</script>