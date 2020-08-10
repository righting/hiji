<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="<?php echo urlAdminShop("stat_bonus_log","index");?>" title="返回<?php echo $lang['pending'];?>列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>查看分红日志详细信息</h3>
      </div>
    </div>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="20">分红日志详细信息</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="w150">id：</th>
        <td colspan="20"><?php echo $output['info']['id'];?></td>
      </tr>
      <tr>
          <th>详细说明：</th>
          <td><?php echo $output['info']['remark_arr'];?></td>
      </tr>

    </tbody>
  </table>


</div>
