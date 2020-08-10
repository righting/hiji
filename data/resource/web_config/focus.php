<div class="home-focus-layout">


    <ul id="fullScreenSlides" class="full-screen-slides">
        <?php if (is_array($output['code_screen_list']['code_info']) && !empty($output['code_screen_list']['code_info'])) { ?>
        <?php foreach ($output['code_screen_list']['code_info'] as $key => $val) { ?>
        <?php if (is_array($val) && $val['ap_id'] > 0) { ?>
                    <li ap_id="<?php echo $val['ap_id']; ?>" style="background: url(<?php echo $val['pic_img']; ?>) center top no-repeat; z-index: 900;">
                        <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
                    </li>
        <?php } else { ?>
                    <li style="background: url('<?php echo $val['pic_img']; ?>') center top no-repeat; z-index: 900;">
                        <a href="<?php echo $val['pic_url']; ?>" target="_blank" title="<?php echo $val['pic_name']; ?>">&nbsp;</a>
                    </li>
                <?php }
            }
        } ?>
    </ul>

    <!--<div class="jfocus-trigeminy">
        <ul style="left: 0px; width: 1552px;">
            <?php /*if (is_array($output['code_focus_list']['code_info']) && !empty($output['code_focus_list']['code_info'])) { */?>
                <?php /*foreach ($output['code_focus_list']['code_info'] as $key => $val) { */?>
                    <li>
                        <?php /*if (is_array($val['pic_list']) && $val['pic_list'][1]['ap_id'] > 0) { */?>
                            <?php /*foreach ($val['pic_list'] as $k => $v) { */?>
                                <a href="<?php /*echo $v['pic_url']; */?>" target="_blank" title="<?php /*echo $v['pic_name']; */?>" style="opacity: 1;">
                                    <img src="<?php /*echo UPLOAD_SITE_URL . '/' . $v['pic_img']; */?>" alt="<?php /*echo $v['pic_name']; */?>">
                                </a>
                            <?php /*}} else { */?>
                            <?php /*foreach ($val['pic_list'] as $k => $v) { */?>
                                <a href="<?php /*echo $v['pic_url']; */?>" target="_blank" title="<?php /*echo $v['pic_name']; */?>" style="opacity: 1;">
                                    <img src="<?php /*echo UPLOAD_SITE_URL . '/' . $v['pic_img']; */?>" alt="<?php /*echo $v['pic_name']; */?>">
                                </a>

                            <?php /*}} */?>
                    </li>
                <?php /*}} */?>


        </ul>
        <div class="pagination"><span style="opacity: 1;"></span><span style="opacity: 0.4;"></span></div>
        <div class="arrow pre" style="opacity: 0;"></div>
        <div class="arrow next" style="opacity: 0;"></div>
    </div>-->


    <script type="text/javascript">
        update_screen_focus();
    </script>

</div>





