<div class="essential">
    <div class="essential-nav">
        <ul class="tab pngFix">
            <a style="float: right" class="ncbtn ncbtn-mint" href="<?php echo urlMember('member_team','index') ?>" ><i class="icon-user"></i>我的团队</a>
        </ul>
    </div>

    <div class="ncm-default-form">
        <form method="post" id="team-form" action="<?php echo urlMember('member_team','bindTeam') ?>">
            <input type="hidden" name="form_submit" value="ok" />
            <dl>
                <dt>团队 ID</dt>
                <dd>
                    <span class="w400">
                        <input type="text" class="text" maxlength="20" name="team_id" placeholder="请输入要绑定的团队 ID" value=""/>
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
</div>
<script>
	$('.submit').click(function(){
	    var _form_obj = $(this).closest('form');
	    var _url = _form_obj.attr('action');
	    var _form_data = _form_obj.serialize();
	    $.post(_url,_form_data,function(data){
	        if(data['status'] == 1){
                showSucc(data['msg']);
                window.location.href="<?php echo urlMember('member_team', 'index')?>";
			}else{
                showError(data['msg']);
			}
		},'json');
	});
</script>