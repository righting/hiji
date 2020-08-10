<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
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
  <div class="ncm-header" style="height: 70px;">
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
                                  <dt><a href="javascript:;" style="color: #EA746B"><?php echo $right_c_k; ?></a></dt>
                                  <?php if (!empty($right_c_v)) { ?>
                                      <?php foreach ($right_c_v as $right_t_k=>$right_t_v){ ?>
                                          <dd><a href="<?php echo $right_t_v['url']; ?>"><?php echo $right_t_v['name']; ?></a></dd>
                                      <?php }?>
                                  <?php }?>
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