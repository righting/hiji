<?php defined('ByCCYNet') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
<?php
$bannerModel = Model('banner');
$bannerInfo=$bannerModel->where(['c_id'=>28])->find();
?>

<?php if(!empty($bannerInfo)){?>
    <div class="banner">
        <a target="_blank" href="<?php if(!empty($bannerInfo['img_link'])){echo $bannerInfo['img_link'];}else{echo 'javascript:;';}?>">
            <img src="<?php echo $bannerInfo['img_url']?>" style="width: 100%;height: 100%"></a>
    </div>
<?php }?>
<div class="ncm-container">
    <?php require_once($tpl_file);?>
  <div class="clear"></div>
</div>
<?php require_once template('layout/footer');?>
</body></html>