<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/home_goods.css" rel="stylesheet" type="text/css">
<div class="wrapper pr">
    <div class="ncs-recommend" style="">
        <div class="title">
            <h4>我的微店</h4>
            <img src="<?php echo getMemberAvatar($_s['member_avatar']); ?>">
        </div>
            <div class="content">
                <ul>
                    <?php foreach ($output['mygoodstotal'] as $goods) { ?>
                        <li>
                            <dl>
                                <dt class="goods-name"><a
                                        href="<?php echo $goods['goods_url']; ?>"
                                        target="_blank"
                                        title="<?php echo $goods['goods_jingle']; ?>"><?php echo $goods['goods_name']; ?>
                                        <em><?php echo $goods['goods_jingle']; ?></em></a></dt>
                                <dd class="goods-pic"><a
                                        href="<?php echo $goods['goods_url']; ?>"
                                        target="_blank" title="<?php echo $goods['goods_jingle']; ?>"><img
                                            src="<?php echo cthumb($goods['goods_image'], 240); ?>"
                                            alt="<?php echo $goods['goods_name']; ?>"/></a></dd>
                                <dd class="goods-price"><?php echo $lang['currency']; ?><?php echo $goods['goods_price']; ?></dd>
                            </dl>
                        </li>
                    <?php } ?>
                </ul>
                <div class="clear"></div>
            </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
        $(".del_goods").click(function(){
            $goods_id=$(this).data("id");
            $user_id = $(this).data("userid");;
            $.post("<?php echo urlMember('distribution','ajaxDel') ?>",{'goods_id':$goods_id,'user_id':$user_id},function(data){
                alert('删除成功');
                window.location.reload();
            });
        });
    });
</script>