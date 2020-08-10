<?php if ($output['is_show'] == 1) { ?>
<div class="essential-nav">
	<ul class="tab pngFix">
		<a class="ncbtn ncbtn-mint" href="<?php echo urlMember('member_team','bind') ?>" ><i class="icon-edit"></i>绑定团队</a>
	</ul>
</div>
<?php } ?>
<?php if (isset($output['info']) && !empty($output['info'])) { ?>
    <div id="member_center_box" class="ncm-index-container">
        <div class="user-account">
            <dl class="account01">
                <a title="团队 ID">
                    <dt>团队 ID</dt>
                    <dd class="value"><em> <?php echo $output['info']['team_show_id']; ?> </em></dd>
                </a>
            </dl>
            <dl class="account02">
                <a href="javascript:;">
                    <dt>团队名称</dt>
                    <dd class="value"><em><?php echo $output['info']['title']; ?></em></dd>
                </a>
            </dl>
            <dl class="account03">
                <a href="javascript:;" title="团队一级成员数">
                    <dt>团队一级成员数</dt>
                    <dd class="value">
                        <em><?php echo $output['first_count'] ? $output['first_count'] : 0; ?></em>人
                    </dd>
                </a>
            </dl>
            <dl class="account04">
                <a href="javascript:;">
                    <dt>团队二级成员数</dt>
                    <dd class="value">
                        <em><?php echo $output['second_count'] ? $output['second_count'] : 0; ?></em>人
                    </dd>
                </a>
            </dl>
            <dl class="account05">
                <a href="javascript:;" title="团队成员总数">
                    <dt>团队成员总数</dt>
                    <dd class="value"><em><?php echo $output['total_team_user_count']; ?></em>人</dd>
                </a>
            </dl>
        </div>

    </div>
<?php } else { ?>
	<div class="ncm-default-form">
		<form method="post" id="team-form" action="<?php echo urlMember('member_team','addTeam') ?>">
			<input type="hidden" name="form_submit" value="ok" />
			<dl>
				<dt>团队名称</dt>
				<dd>
					<span class="w400">
						<input type="text" class="text" maxlength="20" name="title" placeholder="请输入团队名称" value=""/>
					</span>
				</dd>
			</dl>

			<dl class="bottom">
				<dt></dt>
				<dd>
					<label class="submit-border">
						<input type="button" class="submit" value="提交"/>
					</label>
				</dd>
			</dl>
		</form>
	</div>
<script>
	$('.submit').click(function(){
	    var _form_obj = $(this).closest('form');
	    var _url = _form_obj.attr('action');
	    var _form_data = _form_obj.serialize();
	    $.post(_url,_form_data,function(data){
	        if(data['status'] == 1){
                showSucc('添加成功');
                window.location.reload();
			}else{
                showError(data['msg']);
			}
		},'json');
	});
</script>
<?php } ?>