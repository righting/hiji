<div class="nch-breadcrumb-layout" style="display: block;float: left;margin: auto;width: 100%">
  <?php if(!empty($output['nav_link_list']) && is_array($output['nav_link_list'])){?>
  <div class="nch-breadcrumb wrapper"><i class="icon-home"></i>
    <?php foreach($output['nav_link_list'] as $nav_link){?>
    <?php if(!empty($nav_link['link'])){?>
    <span><a href="<?php echo $nav_link['link'];?>"><?php echo $nav_link['title'];?></a></span><span class="arrow">></span>
    <?php }else{?>
    <span><?php echo $nav_link['title'];?></span>
    <?php }?>
    <?php 	
		if($nav_link['title']=='海豚主场')
			echo ('<style>.top-ht img{height:100%;margin-bottom:0;}</style>');
	}?>
  </div>
  <?php }?>
</div>
