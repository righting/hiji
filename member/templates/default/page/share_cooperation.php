<?php include template('layout/page_top'); ?>
<link rel="stylesheet" href="/member/templates/default/css/share_cooperation.css" type="text/css" />

    <?php if(!empty($output['bannerInfo'])){?>
        <div class="banner">
            <a target="_blank" href="<?php if(!empty($output['bannerInfo']['img_link'])){echo $output['bannerInfo']['img_link'];}else{echo 'javascript:;';}?>">
                <img src="<?php echo $output['bannerInfo']['img_url']?>" />
            </a>
        </div>
    <?php }?>

    <div class="cooperation">

        <?php echo html_entity_decode($output['info'][0]['page_content']);?>



        <?php if(!empty($output['bannerInfoCenter'][0])){?>
            <div class="cooperation-banner1">
                <a target="_blank" href="<?php if(!empty($output['bannerInfoCenter'][0]['img_link'])){echo $output['bannerInfoCenter'][0]['img_link'];}else{echo 'javascript:;';}?>">
                    <img src="<?php echo $output['bannerInfoCenter'][0]['img_url']?>" />
                </a>
            </div>
        <?php }?>


        <?php echo html_entity_decode($output['info'][1]['page_content']);?>

        <?php echo html_entity_decode($output['info'][2]['page_content']);?>


        <?php if(!empty($output['bannerInfoCenter'][1])){?>
            <div class="cooperation-banner1">
                <a target="_blank" href="<?php if(!empty($output['bannerInfoCenter'][1]['img_link'])){echo $output['bannerInfoCenter'][1]['img_link'];}else{echo 'javascript:;';}?>">
                    <img src="<?php echo $output['bannerInfoCenter'][1]['img_url']?>" />
                </a>
            </div>
        <?php }?>


        <?php echo html_entity_decode($output['info'][3]['page_content']);?>


    </div>



<?php include template('layout/page_footer'); ?>