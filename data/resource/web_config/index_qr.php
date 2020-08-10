<?php if (!empty($output['code_adv'])){?>
        <?php if (is_array($output['code_adv']['code_info'])){
            foreach ($output['code_adv']['code_info'] as $item):?>
                <img style="height: 100px" src="<?php echo $item['pic_img'] ; ?>" />
            <?php endforeach; } ?>
<?php }?>