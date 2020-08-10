<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/search_goods.js"></script>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/js/layout.css" rel="stylesheet" type="text/css">
<style type="text/css">

    #more_select_nav { font-size: 12px; text-align: right; line-height: 30px; height: 30px; margin-top: -11px; margin-bottom: 10px;}
    #more_select_nav a{ color: #333;background-color: #EEE;display: inline-block; line-height: 30px; height: 30px; width: 100px; text-align: center;border-bottom: solid 1px #D7D7D7;border-left: solid 1px #D7D7D7;border-right: solid 1px #D7D7D7; }

</style>

<div class="ccy-container wrapper">
    <div class="left">
        <div class="ccy-module ccy-module-style02">
            <div class="title">
                <h3>分类筛选</h3>
            </div>
            <div class="content">
                <?php echo $output['left_nav_html'];?>
            </div>
        </div>
        <!-- S 推荐展位 -->
        <!-- S 推荐展位 -->
        <div nctype="booth_goods" class="ccy-module" style=""><div class="title">
                <h3>推广商品</h3></div>
            <div class="content" nc_type="current_display_mode">
                <ul class="ccy-booth-list squares">
                    <?php foreach($output['hot_goods_list'] as $value){
                        $action='index';
                        if($output['index_sign']==50){
                            $action='ht';
                        }
                        ?>
                    <li nctype_goods="<?php echo $value['goods_id'];?>" nctype_store="<?php echo $value['store_id'];?>">
                        <div class="goods-pic"><a href="<?php echo urlShop('goods',$action,array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_name'];?>"><img src="<?php echo cthumb($value['goods_image'], 240);?>" title="<?php echo $value['goods_name'];?>" alt="<?php echo $value['goods_name'];?>"></a> </div>
                        <div class="goods-name"><a href="<?php echo urlShop('goods',$action,array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_jingle'];?>"><?php echo $value['goods_name'];?></a></div>
                        <div class="goods-price" title="商品价格：<?php echo $lang['nc_colon'].$lang['currency'].ncPriceFormat($value['goods_promotion_price']);?>"><?php echo ncPriceFormatForList($value['goods_promotion_price']);?></div>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- E 推荐展位 -->
        <!-- E 推荐展位 -->
        <?php if (!empty($output['viewed_goods']) && is_array($output['viewed_goods'])) { ?>
        <!-- 最近浏览 -->
        <div class="ccy-module ccy-module-style03">
            <div class="title">
                <h3>最近浏览</h3>
            </div>
            <div class="content">
                <div class="ccy-sidebar-viewed ps-container ps-active-y" id="ccySidebarViewed">
                    <ul>
                        <?php foreach ($output['viewed_goods'] as $k => $v) { ?>
                        <li class="ccy-sidebar-bowers">
                            <div class="goods-pic">
                                <a href="<?php echo urlShop('goods', $action, array('goods_id' => $v['goods_id'])); ?>"
                                                      target="_blank"><img
                                            src="<?php echo cthumb($v['goods_image'], 240); ?>"
                                            title="<?php echo $v['goods_name']; ?>"
                                            alt="<?php echo $v['goods_name']; ?>">
                                </a>
                            </div>
                            <dl>
                                <dt>
                                    <a href="<?php echo urlShop('goods', $action, array('goods_id' => $v['goods_id'])); ?>" target="_blank">
                                        <?php echo $v['goods_name']; ?>
                                    </a>
                                </dt>
                                <dd><?php echo $lang['currency']; ?><?php echo ncPriceFormat($v['goods_promotion_price']); ?></dd>
                            </dl>
                        </li>
                        <?php } ?>

                    </ul>
                    <div class="ps-scrollbar-x-rail" style="width: 206px; display: none; left: 0px; bottom: 3px;">
                        <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 124px; display: inherit; right: 3px;">
                        <div class="ps-scrollbar-y" style="top: 0px; height: 116px;"></div>
                    </div>
                </div>
                <a href="<?php echo urlShop('member_goodsbrowse', 'list'); ?>"
                   class="ccy-sidebar-all-viewed">全部浏览历史</a>
            </div>
        </div>
        <!-- 最近浏览 结束 -->
        <?php } ?>

    </div>
    <div class="right">
        <!-- 分类下的推荐商品 -->
        <div id="gc_goods_recommend_div" style="width:980px;"></div>
        <div class="shop_con_list" id="main-nav-holder">
            <nav class="sort-bar" id="main-nav">
                <div class="pagination"><?php echo $output['show_page1']; ?></div>

                <div class="ccy-sortbar-array"> 排序方式：
                    <ul>
                        <li <?php if(!$_GET['key']){?>class="selected"<?php }?>><a href="<?php echo dropParam(array('order', 'key'));?>"  title="<?php echo $lang['goods_class_index_default_sort'];?>"><?php echo $lang['goods_class_index_default'];?></a></li>
                        <li <?php if($_GET['key'] == '1'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1') ? replaceParam(array('key' => '1', 'order' => '1')):replaceParam(array('key' => '1', 'order' => '2')); ?>" <?php if($_GET['key'] == '1'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1')?$lang['goods_class_index_sold_asc']:$lang['goods_class_index_sold_desc']; ?>"><?php echo $lang['goods_class_index_sold'];?><i></i></a></li>
                        <li <?php if($_GET['key'] == '2'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '2') ? replaceParam(array('key' => '2', 'order' => '1')):replaceParam(array('key' => '2', 'order' => '2')); ?>" <?php if($_GET['key'] == '2'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php  echo ($_GET['order'] == '2' && $_GET['key'] == '2')?$lang['goods_class_index_click_asc']:$lang['goods_class_index_click_desc']; ?>"><?php echo $lang['goods_class_index_click']?><i></i></a></li>
                        <li <?php if($_GET['key'] == '3'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3') ? replaceParam(array('key' => '3', 'order' => '1')):replaceParam(array('key' => '3', 'order' => '2')); ?>" <?php if($_GET['key'] == '3'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3')?$lang['goods_class_index_price_asc']:$lang['goods_class_index_price_desc']; ?>"><?php echo $lang['goods_class_index_price'];?><i></i></a></li>
                    </ul>
                </div>
                <div class="ccy-sortbar-filter" nc_type="more-filter">
                    <span class="arrow"></span>
                    <ul>
                        <li><a href="<?php if ($_GET['type'] == 1) { echo dropParam(array('type'));} else { echo replaceParam(array('type' => '1'));}?>" <?php if ($_GET['type'] == 1) {?>class="selected"<?php }?>><i></i>平台自营</a></li>
                        <!--新品上市-->
                        <li><a href="<?php if ($_GET['new'] == 1) { echo dropParam(array('new'));} else { echo replaceParam(array('new' => '1'));}?>" <?php if ($_GET['new'] == 1) {?>class="selected"<?php }?>><i></i>新品</a></li>
                        <!--精选尖货-->
                        <li><a href="<?php if ($_GET['yx'] == 1) { echo dropParam(array('yx'));} else { echo replaceParam(array('yx' => '1'));}?>" <?php if ($_GET['yx'] == 1) {?>class="selected"<?php }?>><i></i>精选</a></li>
                        <!--赠品-->
                        <li><a href="<?php if ($_GET['gift'] == 1) { echo dropParam(array('gift'));} else { echo replaceParam(array('gift' => '1'));}?>" <?php if ($_GET['gift'] == 1) {?>class="selected"<?php }?>><i></i>赠品</a></li>
                        <!-- 消费者保障服务 -->
                        <?php if($output['contract_item']){?>
                            <?php foreach($output['contract_item'] as $citem_k=>$citem_v){ ?>
                                <li><a href="<?php if (in_array($citem_k,$output['search_ci_arr'])){ echo removeParam(array('ci' => $citem_k));} else { echo replaceParam(array("ci" => $output['search_ci_str'].$citem_k));}?>" <?php if (in_array($citem_k,$output['search_ci_arr'])) {?>class="selected"<?php }?>><i></i><?php echo $citem_v['cti_name']; ?></a></li>
                            <?php }?>
                        <?php }?>

                    </ul>
                </div>
                <div class="ccy-sortbar-location">商品所在地：
                    <div class="select-layer">
                        <div class="holder"><em nc_type="area_name"><?php echo $lang['goods_class_index_area']; ?><!-- 所在地 --></em></div>
                        <div class="selected"><a nc_type="area_name"><?php echo $lang['goods_class_index_area']; ?><!-- 所在地 --></a></div>
                        <i class="direction"></i>
                        <ul class="options">
                            <?php require(BASE_TPL_PATH.'/home/goods_class_area.php');?>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- 商品列表循环  -->
            <div>
                <style type="text/css">
                    #box { background: #FFF; width: 238px; height: 410px; margin: -390px 0 0 0; display: block; border: solid 4px #D93600; position: absolute; z-index: 999; opacity: .5 }
                    .shopMenu { position: fixed; z-index: 1; right: 25%; top: 0; }
                </style>
                <div class="squares" nc_type="current_display_mode">
                    <input type="hidden" id="lockcompare" value="unlock">

                    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
                    <ul class="list_pic">
                        <?php foreach($output['goods_list'] as $value){?>
                        <li class="item">
                            <div class="goods-content" nctype_goods=" <?php echo $value['goods_id'];?>" nctype_store="<?php echo $value['store_id'];?>">
                                <div class="goods-pic">
                                    <a href="<?php echo urlShop('goods',$action,array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_name'];?>">
                                        <img src="<?php echo cthumb($value['goods_image'], 360,$value['store_id']);?>" rel='lazy' title="<?php echo $value['goods_name'];?>" alt="<?php echo $value['goods_name'];?>">
                                    </a>
                                </div>
                                <div class="goods-info" style="top: 230px;">
                                    <!--<div class="goods-pic-scroll-show">
                                        <ul>

                                            <li class="selected">
                                                <a href="javascript:void(0);">
                                                    <img src="<?php /*echo cthumb($value['goods_image'], 60,$value['store_id']);*/?>">
                                                </a>
                                            </li>


                                        </ul>
                                    </div>-->
                                    <div class="goods-pic-scroll-show">
                                        <ul>
                                            <?php if(!empty($value['image'])) { array_splice($value['image'], 5);?>
                                                <?php $i=0;foreach ($value['image'] as $val) {$i++?>
                                                    <li<?php if($i==1) {?> class="selected"<?php }?>><a href="javascript:void(0);"><img src="<?php echo cthumb($val, 60,$value['store_id']);?>"/></a></li>
                                                <?php }?>
                                            <?php } else {?>
                                                <li class="selected"><a href="javascript:void(0);"><img src="<?php echo cthumb($value['goods_image'], 60,$value['store_id']);?>" /></a></li>
                                            <?php }?>
                                        </ul>
                                    </div>

                                    <div class="goods-name"><a href="<?php echo urlShop('goods',$action,array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_jingle'];?>"><?php echo $value['goods_jingle'];?><em><?php echo $value['goods_jingle'];?></em></a></div>
                                    <div class="goods-price"> <em class="sale-price" title="<?php echo $lang['goods_class_index_store_goods_price'].$lang['nc_colon'].$lang['currency'].ncPriceFormat($value['goods_promotion_price']);?>"><?php echo '¥';?><?php echo ncPriceFormat($value['goods_promotion_price']);?></em> <em class="market-price" title="市场价：<?php echo $lang['currency'].$value['goods_marketprice'];?>"><?php echo ncPriceFormatForList($value['goods_marketprice']);?></em>
                                        <!--<span class="raty" data-score="5"></span>--> </div>
                                    <div class="goods-sub">
<!--                                        --><?php //if ($_SESSION['is_distribution']==1){ ?>
<!--                                        <span class="goods-compare distr" data-param='{"gid":"--><?php //echo $value['goods_id'];?><!--"}'><i></i>立即推广</span>-->
<!--                                        --><?php //} ?>
                                        <span class="goods-compare" nc_type="compare_<?php echo $value['goods_id'];?>" data-param='{"gid":"<?php echo $value['goods_id'];?>"}'><i></i>加入对比</span>
                                    </div>
                                    <div class="sell-stat">
                                        <ul>
                                            <li><a href="<?php echo urlShop('goods', $action, array('goods_id' => $value['goods_id']));?>#ncGoodsRate" target="_blank" class="status"><?php echo $value['goods_salenum'];?></a>
                                                <p>商品销量</p>
                                            </li>
                                            <li><a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $value['goods_id']));?>" target="_blank"><?php echo $value['evaluation_count'];?></a>
                                                <p>用户评论</p>
                                            </li>
                                            <li><em member_id="<?php echo $value['member_id'];?>">&nbsp;</em></li>
                                        </ul>
                                    </div>
                                    <div class="store"><a href="<?php echo urlShop('show_store','index',array('store_id'=>$value['store_id']), $value['store_domain']);?>" title="<?php echo $value['store_name'];?>" class="name"><?php echo $value['store_name'];?></a></div>
                                    <div class="add-cart">
                                        <a href="javascript:void(0);" nctype="add_cart" data-gid="<?php echo $value['goods_id'];?>"><i class="icon-shopping-cart"></i>加入购物车</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <?php }?>

                        <div class="clear"></div>
                    </ul>
                    <?php }else{?>
                        <div id="no_results" class="no-results"><i></i><?php echo $lang['index_no_record'];?></div>
                    <?php }?>


                </div>
                <form id="buynow_form" method="post" action="/shop/index.php" target="_blank">
                    <input id="act" name="controller" type="hidden" value="buy">
                    <input id="op" name="action" type="hidden" value="buy_step1">
                    <input id="goods_id" name="cart_id[]" type="hidden">
                </form>
                <script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/jquery.raty.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('.raty').raty({
                            path: "/data/resource/js/jquery.raty/img",
                            readOnly: true,
                            width: 80,
                            score: function() {
                                return $(this).attr('data-score');
                            }
                        });
                        //初始化对比按钮
                        initCompare();
                    });
                </script>
            </div>
            <div class="tc mt20 mb20">
                <div class="pagination">
                    <?php echo $output['show_page']; ?>
                </div>
            </div>
        </div>

        <!-- 猜你喜欢 -->
        <div id="guesslike_div" style="width:980px;"></div>
    </div>
    <div class="clear"></div>
</div>
<form style="display: none" method="post" target="_parent" action="<?php echo urlShop('goods','addDistributeGoodsToStore') ?>" id="apply_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" name="goods_id" value=""/>
</form>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/waypoints.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/search_category_menu.js"></script>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/jquery.fly.min.js" charset="utf-8"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/requestAnimationFrame.js" charset="utf-8"></script>
<![endif]-->
<script type="text/javascript">
    var defaultSmallGoodsImage = 'shop/common/default_goods_image_240.gif';
    var defaultTinyGoodsImage = 'shop/common/default_goods_image_60.gif';

    $(function(){
        //申请分销
        $(".distr").click(function(){
            var goods_id = $(this).data('param').gid;
            $("#apply_form input[name='goods_id']").val(goods_id);
            // 添加到我的分销店铺
             ajaxpost('apply_form');
        });
        $('#files').tree({
            expanded: 'li:lt(2)'
        });
        //品牌索引过长滚条
        $('#ncBrandlist').perfectScrollbar({suppressScrollX:true});
        //浮动导航  waypoints.js
        $('#main-nav-holder').waypoint(function(event, direction) {
            $(this).parent().toggleClass('sticky', direction === "down");
            event.stopPropagation();
        });
        // 单行显示更多
        $('span[nc_type="show"]').click(function(){
            s = $(this).parents('dd').prev().find('li[nc_type="none"]');
            if(s.css('display') == 'none'){
                s.show();
                $(this).html('<i class="icon-angle-up"></i>收起');
            }else{
                s.hide();
                $(this).html('<i class="icon-angle-down"></i>更多');
            }
        });
        <?php if(isset($_GET['area_id']) && intval($_GET['area_id']) > 0){?>
        // 选择地区后的地区显示
        $('[nc_type="area_name"]').html('<?php echo $output['province_array'][intval($_GET['area_id'])]; ?>');
        <?php }?>


		
        //浏览历史处滚条
        $('#ccySidebarViewed').perfectScrollbar({suppressScrollX:true});


        //猜你喜欢
        $('#guesslike_div').load('<?php echo urlShop('search', 'get_guesslike', array()); ?>', function(){
            $(this).show();
        });

        //获取更多
        $('#more_select_nav a').click(function(){
            var attr = $(this).attr('class');
            if(attr == 'down'){
                $(this).attr('class','up');
                $(this).find('i').removeClass('icon-angle-down').addClass('icon-angle-up');
                $(this).find('span').html('精简选项&nbsp;');
                $('.ccy-module-filter .hide_dl').show();
            }else{
                $(this).attr('class','down');
                $(this).find('i').removeClass('icon-angle-up').addClass('icon-angle-down');
                $(this).find('span').html('更多选项&nbsp;');
                $('.ccy-module-filter .hide_dl').hide();
            }
        });
    });
</script>










<!-- 对比 -->
<script type="text/javascript">
    $(function(){
        // Membership card
        $('[nctype="mcard"]').membershipCard({type:'shop'});
    });
</script>

<ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 21; top: 0px; left: 0px; display: none;"></ul></body></html>