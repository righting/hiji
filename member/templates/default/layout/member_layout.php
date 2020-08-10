<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/layer/layer.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/kefu-tool.js"></script>
<script>
//sidebar-menu
$(document).ready(function() {
    $.each($(".side-menu > a"), function() {
        $(this).click(function() {
            var ulNode = $(this).next("ul");
            if (ulNode.css('display') == 'block') {
            	$.cookie(COOKIE_PRE+'Mmenu_'+$(this).attr('key'),1);
            } else {
            	$.cookie(COOKIE_PRE+'Mmenu_'+$(this).attr('key'),null);
            }
			ulNode.slideToggle();
				if ($(this).hasClass('shrink')) {
					$(this).removeClass('shrink');
				} else {
					$(this).addClass('shrink');
				}
        });
    });
	$.each($(".side-menu-quick > a"), function() {
        $(this).click(function() {
            var ulNode = $(this).next("ul");
			ulNode.slideToggle();
				if ($(this).hasClass('shrink')) {
					$(this).removeClass('shrink');
				} else {
					$(this).addClass('shrink');
				}
        });
    });
});
$(function() {
	//展开关闭常用菜单设置
	$('.set-btn').bind("click",
	function() {
		$(".set-container-arrow").show("fast");
		$(".set-container").show("fast");
	});
	$('[nctype="closeCommonOperations"]').bind("click",
	function() {
		$(".set-container-arrow").hide("fast");
		$(".set-container").hide("fast");
	});

    $('dl[nctype="checkcCommonOperations"]').find('input').click(function(){
        var _this = $(this);
        var _dd = _this.parents('dd:first');
        var _type = _this.is(':checked') ? 'add' : 'del';
        var _value = _this.attr('name');
        var _operations = $('[nctype="commonOperations"]');

        // 最多添加5个
        if (_operations.find('li').length >= 5 && _type == 'add') {
            showError('最多只能添加5个常用选项。');
            return false;
        }
        $.getJSON('<?php echo urlShop('member', 'common_operations')?>', {type : _type, value : _value}, function(data){
            if (data) {
                if (_type == 'add') {
                    _dd.addClass('checked');
                    if (_operations.find('li').length == 0) {
                        _operations.fadeIn('slow');
                    }
                    _operations.find('ul').append('<li style="display : none;" nctype="' + _value + '"><a href="' + _this.attr('data-value') + '">' + _this.attr('data-name') + '</a></li>');
                    _operations.find('li[style]').fadeIn('slow');
                } else {
                    _dd.removeClass('checked');
                    _operations.find('li[nctype="' + _value + '"]').fadeOut('slow', function(){
                        $(this).remove();
                        if (_operations.find('li').length == 0) {
                            _operations.fadeOut('slow');
                        }
                    });
                }
            }
        });
    });
});

</script>
<div class="ncm-container">
  <div class="ncm-header">
    <div class="ncm-header-top">
      <div class="ncm-member-info">


          <div class="avatar"><a href="<?php echo urlMember('member_information', 'member');?>" title="修改头像"><img src="<?php echo getMemberAvatar($output['member_info']['member_avatar']);?>">
          <div class="frame"></div>
          </a>
          <?php if (intval($output['message_num']) > 0){ ?>
          <a href="<?php echo urlMember('member_message','message')?>" class="new-message" title="新消息"><?php echo intval($output['message_num']); ?></a>
          <?php }?>
        </div>
        <dl>
          <dt><a href="<?php echo urlMember('member_information', 'member');?>" title="修改资料"><?php echo $output['member_info']['member_nickname'];?></a></dt>
          <dd>会员等级：
            <?php if ($output['member_info']['level_name']){ ?>
            <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
            <?php } ?>
          </dd>
          <dd>上次登录：<?php echo date('Y年m月d日 H:i:s',$output['member_info']['member_old_login_time']);?> </dd>
        </dl>
      </div>
      <div class="ncm-set-menu">
        <dl class="zhaq">
          <dt>账户安全</dt>
          <dd>
            <ul>
              <li><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_pwd'));?>"><span class="zhaq01"></span><sub></sub>
                <h5>修改密码</h5>
                </a> </li>
              <li <?php if($output['member_info']['member_email_bind'] == '1') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_email'));?>"><span class="zhaq02"></span><sub></sub>
                <h5>邮箱绑定</h5>
                </a> </li>
              <li <?php if($output['member_info']['member_mobile_bind'] == '1') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_mobile'));?>"><span class="zhaq03"></span><sub></sub>
                <h5>手机绑定</h5>
                </a> </li>
              <li <?php if($output['member_info']['member_paypwd'] != '') {?>class="have"<?php }?>><a href="<?php echo urlMember('member_security', 'auth', array('type' => 'modify_paypwd'));?>"><span class="zhaq04"></span><sub></sub>
                <h5>支付密码</h5>
                </a> </li>
            </ul>
          </dd>
        </dl>
        <dl class="zhcc">
          <dt>账户财产</dt>
          <dd>
            <ul>
              <li><a href="<?php echo urlMember('predeposit', 'recharge_add');?>"> <span class="zhcc01"></span>
                <h5>在线充值</h5>
                </a> </li>
            </ul>
          </dd>
        </dl>
        <dl class="xgsz">
          <dt>相关设置</dt>
          <dd>
            <ul class="trade-function-03">
              <li><a href="<?php echo urlMember('member_address', 'address');?>"><span class="xgsz01"></span>
                <h5>收货地址</h5>
                </a> </li>
              <li><a href="<?php echo urlMember('member_message', 'setting');?>"><span class="xgsz02"></span>
                <h5>消息接收</h5>
                </a> </li>
              
            </ul>
          </dd>
        </dl>
      </div>
    </div>
    <div class="ncm-header-nav">
      <ul class="nav-menu">
          <?php foreach ($output['right'] as $right_key=>$right_value){ ?>
              <?php if ($right_key == $output['member_sign']) { ?>
                  <li><a href="<?php echo $right_value['url']; ?>" class="current"><?php echo $right_value['name']; ?></a></li>
              <?php } else { ?>
                  <li class="set">
                      <a href="<?php echo $right_value['url']; ?>">
                          <?php echo $right_value['name']; ?>
                          <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?><i></i><?php }?>
                      </a>
                  <?php if (isset($right_value['child']) && !empty($right_value['child'])) { ?>
                      <div class="sub-menu">
                          <?php foreach ($right_value['child'] as $right_c_k=>$right_c_v){ ?>
                              <dl>
                                  <dt><?php echo $left_f_v['name']; ?><i class="fa fa-caret-down"></i></dt>
                                  <?php if (!empty($left_f_v['child'])) { ?>
                                      <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                                          <dd <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?> class="personal-left-active" <?php } ?>>
                                <span style="display:block;float:left;width: 18px;height: 25px;line-height:25px;">
                                    <?php if(isset($output['current_active_name']) && $output['current_active_name'] == $left_c_v['active_name']){ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/white/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php }else{ ?>
                                        <img src="/shop/templates/default/images/member_left_icon/gray/<?php echo $left_c_v['icon']; ?>"  style="vertical-align: middle;">
                                    <?php } ?>

                                </span>
                                              <a href="<?php echo $left_c_v['url']; ?>" style="float: left;margin-left: 5px;: "><?php echo $left_c_v['name'];?></a>
                                          </dd>
                                      <?php } ?>
                                  <?php } ?>
                              </dl>
                          <?php }?>
                      </div>
                  <?php }?>



                  </li>
              <?php }?>
          <?php }?>
      </ul>
      <div class="notice">
        <ul class="line">
          <?php if (is_array($output['system_notice']) && !empty($output['system_notice'])) { ?>
          <?php foreach ($output['system_notice'] as $v) { ?>
          <li><a <?php if($v['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($v['article_url']!='')echo $v['article_url'];else echo urlMember('article', 'show', array('article_id'=>$v['article_id']));?>"><?php echo $v['article_title']?>
            <time>(<?php echo date('Y-m-d',$v['article_time']);?>)</time>
            </a> </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      <script>
$(function() {
    var _wrap = $('ul.line');
    var _interval = 2000;
    var _moving;
    _wrap.hover(function() {
        clearInterval(_moving);
    },
    function() {
        _moving = setInterval(function() {
            var _field = _wrap.find('li:first');
            var _h = _field.height();
            _field.animate({
                marginTop: -_h + 'px'
            },
            600,
            function() {
                _field.css('marginTop', 0).appendTo(_wrap);
            })
        },
        _interval)
    }).trigger('mouseleave');
});
</script> 
    </div>



  </div>
  <div class="left-layout">
    <ul id="sidebarMenu" class="ncm-sidebar">


        <?php foreach ($output['left'] as $left_f_k=>$left_f_v) { ?>
            <li class="side-menu">
                <a href="javascript:void(0)" key="<?php echo $left_f_k; ?>" <?php if (cookie('Mmenu_' . $key) == 1) echo 'class="shrink"'; ?>>
                    <h3><?php echo $left_f_v['name']; ?></h3>
                </a>
                <?php if (!empty($left_f_v['child'])) { ?>
                    <ul <?php if (cookie('Mmenu_' . $key) == 1) echo 'style="display:none"'; ?>>
                        <?php foreach ($left_f_v['child'] as $left_c_k=>$left_c_v) { ?>
                            <li <?php if ($key == $output['controller']) { ?>class="selected"<?php } ?>>
                                <a href="<?php echo $left_c_v['url']; ?>"><?php echo $left_c_v['name'];; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>


    </ul>
  </div>
  <div class="right-layout">
    <?php require_once($tpl_file);?>
  </div>
  <div class="clear"></div>
</div>
<?php require_once template('layout/footer');?>
</body></html>