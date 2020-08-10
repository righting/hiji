<div class="footer">
    <div class="footer-top">
        <?php if (is_array($output['article_list']) && !empty($output['article_list'])) { ?>
            <ul><?php foreach ($output['article_list'] as $k => $article_class) { ?><?php if (!empty($article_class)) { ?>
                <li>
                <dl class="s<?php echo '' . $k + 1; ?>">
                    <dt><?php if (is_array($article_class['class'])) echo $article_class['class']['ac_name']; ?></dt><?php if (is_array($article_class['list']) && !empty($article_class['list'])) { ?><?php foreach ($article_class['list'] as $article) { ?>
                        <dd>
                        <a href="<?php if ($article['article_url'] != '') echo $article['article_url']; else echo urlMember('article', 'show', array('article_id' => $article['article_id'])); ?>"
                           title="<?php echo $article['article_title']; ?>"> <?php echo $article['article_title']; ?> </a>
                        </dd><?php }
                    } ?></dl></li><?php }
            } ?>
            </ul><?php } ?></div>
</div>
    <div class="footer-bottom">CopyRight © 2007-2016 海吉壹佰 NewPower Co. 版权所有</div>
</div>
<?php if (C('debug') == 1) { ?>
<div id="think_page_trace" class="trace">
    <fieldset id="querybox">
        <legend><?php echo $lang['nc_debug_trace_title']; ?></legend>
        <div> <?php print_r(Tpl::showTrace()); ?> </div>
    </fieldset></div><?php } ?></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.cookie.js"></script>
<link href="<?php echo RESOURCE_SITE_URL; ?>/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/perfect-scrollbar.min.js"></script>