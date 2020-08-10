<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo MEMBER_TEMPLATES_URL; ?>/css/recommend.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/style.css" rel="stylesheet" type="text/css">
<link href="/shop/templates/default/css/banner.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/data/resource/js/TY_banner1.js"></script>
<script type="text/javascript">
    var SHOP_SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
    var UPLOAD_SITE_URL = "<?php echo UPLOAD_SITE_URL; ?>";

    function update_recommend_data(id) {//更新微商推荐商品
        var get_text = $.ajax({
            type: "POST",
            url: '<?php echo urlMember('distribution','updateRecommendGoods') ?>',
            data: $("#" + id + "_form").serialize(),
            async: false
        }).responseText;
        if(get_text=="true"){
            showDialog('推荐商品保存成功', 'succ', '提示信息', null, true, null, '', '', '', 3,3);
            location.reload();   //成功后刷新页面
        }
        return get_text;
    }
    function show_dialog1(id) {//弹出框js
        var d = DialogManager.create(id);//不存在时初始化(执行一次)
        var  dialog_html= $("#" + id + "_dialog").html();

        var dialog_html_out=$("#" + id + "_dialog").detach();
        d.setTitle('输入新的微店名称');
        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(300);
        d.show('center', 1);
        $('body').append(dialog_html_out);
    }
</script>
<!--弹出框-->
<div id="edit_wdname_dialog"  style="display:none;">
    <form style="padding: 10px"" id="form_wdname" action="<?php echo urlMember('distribution','editWdName') ?>" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table border="0" cellpadding="0" cellspacing="0" class="all">
        <tr>
            <th><i>*</i>微店名：</th>
            <td>
                <input name="wd_name" type="text" class="w200" value="<?php echo $output['wd_name'] ?>"/>
                <p style="color: #bb0000">注意：店名最多4个汉字</p>
            </td>
        </tr>
        </tbody>
    </table>
    <button type="button" onclick="javascript:ajaxpost('form_wdname', '', '', 'onerror');" style="margin: 5px 100px ">确 定</button>
    </form>

</div>
<!--弹出框结束-->

<div class="essential" style="width: 980px">
    <div class="ncs-recommend" >
        <div class="alert"><span class="mr30"><?php echo $lang['distribution_tips'] ?>：
            <strong class="mr5 red" style="font-size: 18px;"><?php echo $output['proc_state']?></strong>
        </div>
        <div class="alert"><span class="mr30"><?php echo $lang['distribution_tips'] ?>：
            <strong class="mr5 red" style="font-size: 18px;">每个模块可推荐最多【<span id="goods_sum"><?php echo $output['mygoodsinfo']['total']  ?></span>】个商品，为了展示美观请选择10的倍数个商品,点击编辑商品<!--，点击【<a href="<?php echo urlShop('cate','index') ?>">立即推荐</a>】选择商品--></strong>
        </div>
        <a class="ncbtn ncbtn-bittersweet" onclick="javascript:show_dialog1('edit_wdname');">编辑微店名</a>
        <a class="ncbtn ncbtn-bittersweet" href="<?php echo urlMember('distribution','wdorders') ?>">我的微店订单</a>
        <?php if (!empty($output['recommend_list']) && is_array($output['recommend_list'])) {?>
            <?php foreach ($output['recommend_list'] as $k => $val) :?>
                <div class="recommend" style="width: 980px">
                    <div class="recommend-top">
                        <span></span>
                        <em><?php echo $val['recommend']['name'] ?></em>
                        <a style="margin-right:<?php echo  empty($val['goods_list'])?'100px':'0px'; ?>; height: 20px;padding-left: 5px" class="ncbtn ncbtn-mint" href="JavaScript:;" onclick="show_recommend_dialog(<?php echo $k ?>)">编辑商品</a>
                    </div>

                    <div class="pro-switch">
                        <div class="flexslider1">
                            <ul class="slides">
                                <?php
                                while (!empty($val['goods_list'])){
                                    $data = array_slice($val['goods_list'],0,10);
                                    ?>
                                    <li>

                                        <?php for($i=0;$i<5;$i++){
                                            $data1 = array_slice($data,$i*2,2);
                                            ?>
                                            <div class="slides-box" style="width: 180px">
                                                <?php foreach ($data1 as $item):?>
                                                    <a href="<?php echo urlShop('goods','index',['goods_id'=>$item['goods_id']])?>">
                                                        <div class="slides-box-img"><img src="<?php echo $item['goods_pic'] ?>"></div>
                                                        <div class="slides-box-title"><?php echo $item['goods_name'] ?></div>
                                                        <div class="slides-box-price"><span>¥</span><em><?php echo $item['goods_price'] ?></em></div>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php } ?>
                                    </li>
                                    <?php array_splice($val['goods_list'],0,10); } ?>
                            </ul>
                            <script type="text/javascript">
                                $(function() {
                                    $('.flexslider1').flexslider({
                                        animation: "slide",
                                        start: function(slider) {
                                            $('body').removeClass('loading');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php }?>
<!--        <div class="alert"><span class="mr30">--><?php //echo $lang['distribution_tips'] ?><!--：-->
<!--            <strong class="mr5 red" style="font-size: 18px;">点击【<a href="--><?php //echo urlShop('member','home') ?><!--">个人中心</a>】首页查看微商城推广链接</strong>-->
<!--        </div>-->
<!--        <strong>平台热销商品</strong>-->
<!--        <div class="content">-->
<!--            <ul id="hot_sales">-->
<!---->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
    <script src="<?php echo ADMIN_SITE_URL; ?>/resource/js/jquery.ajaxContent.pack.js"></script>
    <script src="<?php echo BASE_SITE_URL; ?>/data/resource/js/common_select.js"></script>
    <script src="<?php echo BASE_SITE_URL; ?>/data/resource/js/waypoints.js"></script>
    <script src="<?php echo ADMIN_SITE_URL ?>/resource/js/web_index.js"></script>
<!--商品推荐弹出框-->
    <!-- 商品推荐模块 -->
    <div id="recommend_list_dialog" style="display:none;">
        <div class="s-tips"><i></i>小提示：单击查询出的商品选中，双击已选择的可以删除，最多<?php echo $output['mygoodsinfo']['total']  ?>个，保存后生效。每排5个商品</div>
        <form id="recommend_list_form">
            <input type="hidden" name="member_id" value="<?php echo $_SESSION['member_id']; ?>">
            <div id="recommend_input_list" style="display:none;"><!-- 推荐拖动排序 --></div>
            <?php if (is_array($output['code_info']) && !empty($output['code_info'])) { ?>
                <?php foreach ($output['code_info'] as $key => $val) { ?>
                    <div class="ncap-form-default" select_recommend_id="<?php echo $key; ?>">
                        <dl class="row">
                            <dt class="tit"> 商品推荐模块标题名称</dt>
                            <dd class="opt">
                                <input name="recommend_list[<?php echo $key; ?>][recommend][name]"
                                       value="<?php echo $val['recommend']['name']; ?>" type="text" class="input-txt">
                                <p class="notic">修改该区域中部推荐商品模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏</p>
                            </dd>
                        </dl>
                    </div>
                    <div class="ncap-form-all" select_recommend_id="<?php echo $key; ?>">
                        <dl class="row">
                            <dt class="tit">推荐商品</dt>
                            <dd class="opt">
                                <ul class="dialog-goodslist-s1 goods-list">
                                    <?php if (!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                                        <?php foreach ($val['goods_list'] as $k => $v) { ?>
                                            <li id="select_recommend_<?php echo $key; ?>_goods_<?php echo $k; ?>">
                                                <div ondblclick="del_recommend_goods(<?php echo $v['goods_id']; ?>);"
                                                     class="goods-pic">
                                                    <span class="ac-ico" onclick="del_recommend_goods(<?php echo $v['goods_id']; ?>);"></span>
                                                    <span class="thumb size-72x72"><i></i>
                                                    <img select_goods_id="<?php echo $v['goods_id']; ?>"
                                                         title="<?php echo $v['goods_name']; ?>"
                                                         goods_name="<?php echo $v['goods_name']; ?>"
                                                         src="<?php echo  $v['goods_pic']; ?>"
                                                         onload="javascript:DrawImage(this,72,72);"/>
                                                </span>
                                                </div>
                                                <div class="goods-name"><a
                                                            href="<?php echo SHOP_SITE_URL . "/index.php?controller=goods&goods_id=" . $v['goods_id']; ?>"
                                                            target="_blank"><?php echo $v['goods_name']; ?></a>
                                                </div>
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_id]"
                                                       value="<?php echo $v['goods_id']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][market_price]"
                                                       value="<?php echo $v['market_price']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_name]"
                                                       value="<?php echo $v['goods_name']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_price]"
                                                       value="<?php echo $v['goods_price']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_pic]"
                                                       value="<?php echo $v['goods_pic']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][goods_list][<?php echo $v['goods_id']; ?>][goods_salenum]"
                                                       value="<?php echo $v['goods_salenum']; ?>" type="hidden">
                                            </li>
                                        <?php } ?>
                                    <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                                        <?php foreach ($val['pic_list'] as $k => $v) { ?>
                                            <li id="select_recommend_<?php echo $key; ?>_pic_<?php echo $k; ?>"
                                                style="display:none;">
                                                <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_id]"
                                                       value="<?php echo $v['pic_id']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_name]"
                                                       value="<?php echo $v['pic_name']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_url]"
                                                       value="<?php echo $v['pic_url']; ?>" type="hidden">
                                                <input name="recommend_list[<?php echo $key; ?>][pic_list][<?php echo $v['pic_id']; ?>][pic_img]"
                                                       value="<?php echo $v['pic_img']; ?>" type="hidden">
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                <?php } ?>
            <?php } ?>
            <div id="add_recommend_list" style="display:none;"></div>
            <div class="ncap-form-all">
                <dl class="row">
                    <dt class="tit">选择要展示的推荐商品</dt>
                    <dd class="opt">
                        <div class="search-bar">
                            <label id="recommend_gcategory">商品分类
                                <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id"/>
                                <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names"/>
                                <select>
                                    <option value="0">请选择</option>
                                    <?php if (!empty($output['goods_class']) && is_array($output['goods_class'])) { ?>
                                        <?php foreach ($output['goods_class'] as $k => $v) { ?>
                                            <option value="<?php echo $v['gc_id']; ?>"><?php echo $v['gc_name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </label>
                            <input type="text" value="" name="recommend_goods_name" id="recommend_goods_name"
                                   placeholder="输入商品名称或SKU编号" class="txt w150">
                            <a href="JavaScript:void(0);" onclick="ws_get_recommend_goods();"
                               class="ncap-btn">查询</a></div>
                        <div id="show_recommend_goods_list" class="show-recommend-goods-list"></div>
                    </dd>
                </dl>
            </div>
            <div class="bot"><a href="JavaScript:void(0);" onclick="update_recommend_data('recommend_list');"
                                class="ncap-btn-big ncap-btn-green"><span>保存</span></a>
            </div>
        </form>
    </div>
    <!--商品推荐弹出框结束-->
</div>
</div>
<form style="display: none" method="post" target="_parent" action="<?php echo urlShop('goods','addDistributeGoodsToStore') ?>" id="recommend_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" name="goods_id" value=""/>
</form>
<script type="text/javascript">
    $(function(){
        var user_id = <?php echo $_SESSION['member_id'];?>;
      $("#my_sales .del_goods").live("click",function(){//删除我推荐的商品
          var goods_id=$(this).data("id");
          $.post("<?php echo urlMember('distribution','ajaxDel') ?>",{goods_id:goods_id,user_id:user_id,form_submit:'ok'},function(result){ //删除一个推荐商品
              var result = eval('(' + result + ')');

              if(result.state='ok'){
                //移除当前li
                $("#"+result.goods_id).remove();
              }else{
                  alert(result.msg);
              }
          });
      });

//        $.post("<?php //echo urlMember('distribution','ajaxHotGoods') ?>//",{goods_num:45,form_submit:'ok'},function(result) { //ajax请求推荐分销商品数据
//            var result = eval('(' + result + ')');
//            var htmlstr='';
//            for(var i=0;i<result.length;i++) {
//                var goods_name =  '<dt class="goods-name"><a href="#" target="_blank" <em>'+result[i].goods_name+'</em></a></dt>';
//                var goods_pic = '<dd class="goods-pic"><a href="#" target="_blank" ><img src='+result[i].goods_image+' /></a></dd>';
//                var goods_price = '<dd class="goods-price">￥'+result[i].goods_price+'</dd>';
//                htmlstr+='<li id='+result[i].goods_id+'><dl>'+goods_name+goods_pic+goods_price+'<a class="recommend" data-goods_id='+result[i].goods_id+' href="javascript:;">立即推广</a></dl></li>'
//            }
//            $("#hot_sales").html(htmlstr);
//        });

        $("#hot_sales .recommend").live("click",function(){
            var goods_id = $(this).data('goods_id');
            $("#recommend_form input[name='goods_id']").val(goods_id);
            ajaxpost('recommend_form');
            //向已推荐栏目添加前端数据
            if($("#my_sales #"+goods_id).length>0){

            }else{
                var str=$('#goods_sum').html();
                if(str.length<0)
                    return ;
                var goods_sum=str.replace(/[^0-9]+/g, '');//最多可推荐商品数
                if($("#my_sales li").length<goods_sum) //获取当前已推荐商品数
                {
                    var html = $("#"+goods_id).prop("outerHTML");
                    html=html.replace('recommend','del_goods ncbtn btn-grapefruit').replace('立即推广','删除').replace('data-goods_id','data-id');
                    $("#my_sales").append(html);
                }
            }
        });
    });
</script>
<style>
   .content li {float: left;}
</style>
