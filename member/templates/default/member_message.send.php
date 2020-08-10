<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="essential">
  <div class="essential-nav">
    <ul class="tab">
      <?php if(is_array($output['member_menu']) and !empty($output['member_menu'])) { 
	foreach ($output['member_menu'] as $key => $val) {
		$classname = 'normal';
		if($val['menu_key'] == $output['menu_key']) {
			$classname = 'active';
		}
		if ($val['menu_key'] == 'message'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newcommon'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'system'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
		}elseif ($val['menu_key'] == 'close'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newpersonal'].'</span>)</a></li>';
		}else{
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
		}
	}
}?>
    </ul>
  </div>
  <div class="ncm-message-send">
    <div class="ncm-message-send-form">
      <div class="ncm-default-form">
        <form method="post" id="send_form" action="<?php echo MEMBER_SITE_URL;?>/index.php?controller=member_message&action=savemsg">
          <input type="hidden" name="form_submit" value="ok" />
          <dl>
            <dt><i class="required">*</i><?php echo $lang['home_message_reveiver'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" class="text w500" name="to_member_name" value="<?php echo $output['member_name']; ?>" <?php if (!empty($output['member_name'])){echo "readonly";}?>/>
              <p class="hint"><?php echo $lang['home_message_separate'];?></p>
            </dd>
          </dl>
          <dl>
            <dt>消息类型：</dt>
            <dd><span class="mr10">
              <input type="radio" class="radio vm" value="2" name="msg_type" checked="checked" />
              <?php echo $lang['home_message_open'];?></span><span>
              <input type="radio" class="radio vm" name="msg_type" value="0" />
              <?php echo $lang['home_message_close'];?></span></dd>
          </dl>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['home_message_content'].$lang['nc_colon'];?></dt>
            <dd>
              <textarea name="msg_content" rows="3" class="textarea w500 h100"></textarea>
              <p class ="error"></p>
            </dd>
          </dl>
          <div class="bottom">
            <label class="submit-border">
              <input type="submit" class="submit" value="<?php echo $lang['home_message_ensure_send'];?>" />
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('a[nc_type="to_member_name"]').click(function (){
        var str = $('input[name="to_member_name"]').val();
        var id = $(this).attr('id');
        if(str.indexOf(id+',') < 0){
            doFriend(id+',', 'add');
        }else{
            doFriend(id, 'delete');
        }
    });
});
$(function(){
  $('#send_form').validate({
        errorPlacement: function(error, element){
            $(element).next('p').html(error);
        },
        submitHandler:function(form){
            ajaxpost('send_form', '', '', 'onerror') 
        },   
        rules : {
            to_member_name : {
                required   : true
            },
            msg_content : {
                required   : false
            }
        },
        messages : {
            to_member_name : {
                required : '<?php echo $lang['home_message_receiver_null'];?>.'
            },
            msg_content : {
                required   : '<?php echo $lang['home_message_content_null'];?>.'
            }
        }
    });
});

</script> 
