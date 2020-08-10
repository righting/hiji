<section class="shortcut">

    <article class="cap">
        <a><img class="cap-img" src="<?php echo SHOP_TEMPLATES_URL; ?>/instructions_resource/capital/capital_bj.png"></a>
    </article>

    <div class="br">
        <nav class="w cont">
            <ul class="nav-tow">
                <?php foreach ($output['all_third_class_arr'] as $value){ ?>
                    <li <?php if ($value['ac_id'] == $output['current_third_class']){ echo 'class="active"'; } ?> ><a href="<?php echo urlShop('instructions','index',['f'=>$output['current_first_class'],'s'=>$output['current_second_class'],'t'=>$value['ac_id']]) ?>"><?php echo $value['ac_name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</section>
<div class="cap-cont w">
    <?php echo $output['article_info']['article_content'];?>
</div>