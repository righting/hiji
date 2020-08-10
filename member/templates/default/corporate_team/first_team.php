<?php if ($output['is_show'] == 1) { ?>
<div class="essential-nav">
	<ul class="tab pngFix">
		<a class="ncbtn ncbtn-mint" href="<?php echo urlMember('member_team','bind') ?>" ><i class="icon-edit"></i>绑定团队</a>
	</ul>
</div>
<?php }else{ ?>
<div id="member_center_box" class="ncm-index-container">

	<div class="user-consume">
		<div class="title"><h3>我的团队成员</h3> </div>
		<table class="ncm-default-table">
			<thead>
			<tr>
				<th class="w10"></th>
				<th class="w150 tl">账户</th>
				<th class="w150 tl">会员等级</th>
				<th class="tl">手机号码</th>
				<th class="w150 tl">职务等级</th>
				<th class="w150 tl">加盟时间</th>

			</tr>
			</thead>

            <?php if (isset($output['lists']) && !empty($output['lists'])){ ?>
			<tbody>


				<?php foreach ($output['lists'] as $value){ ?>
				<tr class="bd-line">
					<td></td>
					<td class="w150 tl"><?php echo $value['member_info']['member_name'] ?></td>
					<td class="w150 tl"><?php echo $output['level_info_for_id'][$value['member_info']['level_id']]['level_name'] ?></td>
					<td class="w150 tl"><?php echo $value['member_info']['member_mobile'] ?></td>
					<td class="w150 tl"><?php echo $output['positions_info_for_id'][$value['member_info']['positions_id']]['title'] ?></td>
					<td class="tl"><?php echo $value['register_at'] ?></td>
				</tr>
				<?php } ?>


			</tbody>
			<tfoot>
			<tr>
				<td colspan="6"><div class="pagination"> <?php echo $output['team_user_page']; ?> </div></td>
			</tr>
            </tfoot>
            <?php }else{ ?>
            <tbody>
                <tr>
                    <td colspan="20" class="norecord">
                        <div class="warning-option">
                            <i>&nbsp;</i>
                            <span>
                                <?php if($output['can_invite'] == 1){ ?>
                                    <?php echo $lang['no_record'];?>
                                <?php }else{ ?>
                                    免费VIP以上等级会员才可邀请团队成员
                                <?php } ?>
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
            <?php } ?>

		</table>
	</div>
</div>
<?php } ?>