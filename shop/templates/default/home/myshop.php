<link href="<?php echo SHOP_TEMPLATES_URL; ?>/js/index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/home_index.js" charset="utf-8"></script>

<!--<style type="text/css">.category {
        display: block !important;
    }</style>-->
<div class="clear"></div><!-- HomeFocusLayout Begin-->

<!-- HomeFocusLayout Begin-->
<?php echo $output['web_html']['index_pic']; ?>
<!--HomeFocusLayout End-->





<div class="wrapper">
    <div class="mt10">
        <div class="mt10"><a title="物流自提服务站广告" target="_blank" href="javascript:;"> <img
                        border="0" alt="物流自提服务站广告" src="/data/upload/shop/adv/05561319076203865.jpg"
                        style="width:1200px;height:100px"> </a></div>
    </div>
</div>
<!--StandardLayout Begin-->
<?php echo $output['web_html']['index']; ?>
<!--StandardLayout End-->

<div class="wrapper">
    <div class="mt10">
        <?php echo loadadv(9, 'html'); ?>
    </div>
</div>

<style>
    .sidebar {
        position: fixed;
        top: 10px;
        left: 10px;
    }
    .sidebar li {
        height: 26px;
        line-height: 26px;
        text-align: center;
        cursor: pointer;
        width: 50px;
    }
    .sidebar li a {
        display: block;
        padding: 0 6px;
        color: #999;
        border-bottom: 1px dotted #c2c2c2;
    }
    .sidebar li p {
        display: none;
        color: #34af7c;
    }
    .sidebar li.active p, .sidebar li.on p {
        display: block;
    }
    .sidebar li.active a, .sidebar li.on a {
        display: none;
    }
    ol, ul {
        list-style: none;
    }
</style>


<script>
    // 获取页面中的所有floor-layout的个数
    $(function(){
       var _floor_length = $('.floor-layout').length;
       var _floor_name = '';
       var _floor_id = '';
       if(_floor_length > 0){
           var _str = '<div class="sidebar" style="display: block; top: 367px; left: 9.5px;"><ul>';
           $(".floor-layout").each(function(){
               _floor_name = $(this).find('.floor-left .txt-type span').text();
               _floor_id = $(this).attr('id');
                _str += '<li><a href="#'+_floor_id+'">'+_floor_name+'</a></li>';
           });
           _str += '</ul></div>';
       }
       $('body').append(_str);
    });
</script>
