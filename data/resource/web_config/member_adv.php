<?php if (!empty($output['code_adv'])){?>
<div class="personal-ad">
    <h3>今日优选<a href=""><i class="fa fa-angle-right"></i></a></h3>
    <div class="personal-shop-text">
        <div class="right-side-focus" style="
    width: 100%;
    height: 200px;
    position: relative;
    z-index: 1;
    overflow: hidden;">
            <ul style="left: -200px; width: 1000px; height: 200px; position: absolute; z-index: 1;">
                <?php if (is_array($output['code_adv']['code_info'])){
                    foreach ($output['code_adv']['code_info'] as $item):
                        ?>
                        <li style="
    width: 190px;
    height:200px;
    overflow: hidden;
    float: left;">
                            <a href="<?php echo $item['pic_url']; ?>" title="<?php echo $item['pic_name']; ?>" target="_blank">
                                <img style="width: 190px" src="<?php echo $item['pic_img']; ?>" alt="<?php echo $item['pic_name']; ?>">
                            </a>
                        </li>
                    <?php endforeach; } ?>
            </ul>
        </div>
    </div>
</div>
<?php }?>