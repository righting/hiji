<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<div class="nch-container wrapper">

    <div class="right" style="float: left">
        <div class="nch-article-con">
            <h1><?php echo $output['info']['title'];?></h1>
            <h2><?php echo $output['info']['created_at'];?></h2>
            <div class="default">
                <p><?php echo $output['info']['content'];?></p>
            </div>
        </div>
    </div>
</div>
