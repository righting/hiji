

<div style="clear: both;"></div>
<div id="web_chat_dialog" style="display: none;float:right;">
</div>
<a id="chat_login" href="javascript:void(0)" style="display: none;"></a>
<div class="wrapper" style="display:none">
    <div class="rg"></div>
</div>
<div id="faq" style="border-top:1px solid #9e0a06;">
    <div class="wrapper">
        <ul>
            <?php if (is_array($output['article_list']) && !empty($output['article_list'])) { ?>
               <?php foreach ($output['article_list'] as $k => $article_class) { ?><?php if (!empty($article_class)) { ?>
                    <li>
                    <dl class="s<?php echo '' . $k + 1; ?>">
                        <dt><?php if (is_array($article_class['class'])) echo $article_class['class']['ac_name']; ?></dt><?php if (is_array($article_class['list']) && !empty($article_class['list'])) { ?><?php foreach ($article_class['list'] as $article) { ?>
                            <dd>
                            <a href="<?php if ($article['article_url'] != '') echo $article['article_url']; else echo urlMember('article', 'show', array('article_id' => $article['article_id'])); ?>"
                               title="<?php echo $article['article_title']; ?>"> <?php echo $article['article_title']; ?> </a>
                            </dd><?php }
                        } ?></dl></li><?php }
                } ?>
                <?php } ?>


            <li style="width:34%;">
                <dl class="s6">
                    <dt>官方微信</dt>
                    <dd><?php echo $output['index_adv']['index_qr']?></dd>
                </dl>
            </li>

        </ul>
    </div>
</div>

<div id="f_rz" class="wrapper">
    <ul>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_01.jpg" /></a></li>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_02.jpg" /></a></li>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_03.jpg" /></a></li>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_04.jpg" /></a></li>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_05.jpg" /></a></li>
        <li><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/new_images/f_rz-4_06.jpg" /></a></li>
    </ul>
</div>

<?php if(!empty($output['linkInfo'])){?>
<div id="flink" class="wrapper">
    <div style="border:1px solid #fff; margin:10px auto; padding:10px; text-align:center;">
        <h3 style=" margin:0 0 10px 0;border-bottom:1px solid #fff;">友情链接</h3>
        <?php foreach($output['linkInfo'] as $k=>$v){?>
            <?php if($k==0){?>
                <a href="<?php echo $v['link_url'];?>" target="_blank"><?php echo $v['link_title'];?></a>
            <?php }else{?>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="<?php echo $v['link_url'];?>" target="_blank"><?php echo $v['link_title'];?></a>
            <?php }?>
        <?php }?>
    </div>
</div>
<?php }?>


<div id="leftsead">
    <ul>
        <li>
            <a id="top_btn">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll06.png" width="47" height="49" class="hides"/>
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l06.png" width="47" height="49" class="shows" />
            </a>
        </li>

        <li>
            <a href="">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll03.png"  width="47" height="49" class="hides"/>
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l03.png" width="47" height="49" class="shows" />
            </a>
        </li>

        <li>
            <a href="">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/ll02.png" width="166" height="49" class="hides"/>
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l04.png" width="47" height="49" class="shows" />
            </a>
        </li>

        <li>
            <a class="youhui">
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/l02.png" width="47" height="49" class="shows" />
                <img src="<?php echo jf_TEMPLATES_URL;?>/images/foot03/zfew.jpg" width="196" height="205" class="hides" usemap="#taklhtml"/>
            </a>
        </li>



    </ul>
</div><!--leftsead end-->

<script type="text/javascript">
    $(document).ready(function(){

        $("#leftsead a").hover(function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").show();
            }else{
                $(this).children("img.hides").show();
                $(this).children("img.shows").hide();
                $(this).children("img.hides").animate({marginRight:'0px'},'slow');
            }
        },function(){
            if($(this).prop("className")=="youhui"){
                $(this).children("img.hides").hide('slow');
            }else{
                $(this).children("img.hides").animate({marginRight:'-143px'},'slow',function(){$(this).hide();$(this).next("img.shows").show();});
            }
        });

        $("#top_btn").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});

    });
</script>

<script type="text/javascript" src="/jf/templates/default/js/scroll.js" charset="utf-8"></script>
<script type="text/javascript" src="/jf/templates/default/js/home_spyb.js" charset="utf-8"></script>


</body>
</html>