<?php if (!empty($output['code_adv'])){?>
<div class="footer-bottom">
    <?php if (is_array($output['code_adv']['code_info'])){
        foreach ($output['code_adv']['code_info'] as $item):
    ?>
    <a href="<?php echo $item['pic_url'] ?>" target="_blank" rel="nofollow"><img src="<?php echo $item['pic_img'] ; ?>"></a>
    <?php endforeach; } ?>
</div>
<?php }?>