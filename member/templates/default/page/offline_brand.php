<?php include template('layout/page_top'); ?>
    <link rel="stylesheet" href="/member/templates/default/css/brand.css" type="text/css"/>

<?php
$banner_model = Model('banner');
$banner_lsit = $banner_model->where(array('c_id' => 13))->select();
?>
<?php if ($banner_lsit && count($banner_lsit) == 1) { ?>
    <div class="brand-banner">
        <a target="_blank" href="<?php if (!empty($banner_lsit[0]['img_link'])) {
            echo $banner_lsit[0]['img_link'];
        } else {
            echo 'javascript:;';
        } ?>">
            <img src="<?php echo $banner_lsit[0]['img_url'] ?>"/>
        </a>
    </div>
<?php } ?>
    <div class="brand-main" style="margin-bottom: 20px;">
        <div class="brand-left">
            <ul class="brand-hot">
                <li>
                    <div class="brand-hot-head">
                        <h1 class="title">热点HOT</h1>
                        <a class="brand-title-more" href=""></a>
                    </div>
                    <div class="brand-hot-title">
                        <i>标题：</i>
                        <p>新时代是奋斗者的时代！<br>只有奋斗的人生才能称得上幸福的人生！
                        <h3 style="text-align: right">——习近平</h3>
                        </p>
                    </div>
                    <div class="brand-hot-content">
                        <i>简述：</i>
                        <p>新时代是奋斗者的时代！<br>只有奋斗的人生才能称得上幸福的人生！</p>
                    </div>
                    <a href="" class="brand-hot-more">&gt;&gt;更多</a>
                </li>
                <li>
                    <div class="brand-hot-head">
                        <h1 class="title">热点HOT</h1>
                        <a class="brand-title-more" href=""></a>
                    </div>
                    <div class="brand-hot-title">
                        <i>标题：</i>
                        <p>新时代是奋斗者的时代！<br>只有奋斗的人生才能称得上幸福的人生！
                        <h3 style="text-align: right">——习近平</h3>
                        </p>
                    </div>
                    <div class="brand-hot-content">
                        <i>简述：</i>
                        <p>新时代是奋斗者的时代！<br>只有奋斗的人生才能称得上幸福的人生！</p>
                    </div>
                    <a href="" class="brand-hot-more">&gt;&gt;更多</a>
                </li>
            </ul>

            <div class="brand-left-banner">
                <img src="<?php echo LOGIN_TEMPLATES_URL ?>/images/brand-left-banner1.png">
            </div>
            <div class="brand-left-banner">
                <img src="<?php echo LOGIN_TEMPLATES_URL ?>/images/brand-left-banner2.png">
            </div>
        </div>

        <div class="brand-right">
            <?php echo html_entity_decode($output['page'][0]['page_content']);?>
        </div>
    </div>

<?php include template('layout/page_footer'); ?>