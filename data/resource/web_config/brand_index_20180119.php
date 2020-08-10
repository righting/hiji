<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<div class="cool-main">
    <div class="cool-big">
        <h3><img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/brand/big_h3.png"></h3>
        <h4>今日主打</h4>
        <ul>
            <li>
                <a href="<?php echo $output['lists'][1]['code_info_arr']['url'] ?>">
                    <div class="big-img"><img src="<?php echo $output['lists'][1]['code_info_arr']['pic'] ?>" width="285" height="390"></div>
                    <div class="big-sign"><img src="/data/upload/shop/brand/<?php echo $output['lists'][1]['code_info_arr']['brand_info']['brand_pic'] ?>" width="84" height="42"></div>
                    <div class="big-text"><?php echo $output['lists'][1]['code_info_arr']['brand_info']['brand_name'] ?></div>
                </a>
            </li>
            <li class="flexslider_1">
                <?php if(!empty($output['lists'][2]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][2]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                    <a href="<?php echo $pic_info['url'] ?>">
                        <div class="big-img" style="width: 585px;height: 390px">
                            <img src="<?php echo $pic_info['pic'] ?>" width="585" height="390">
                        </div>
                    </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li>
                <a href="<?php echo $output['lists'][3]['code_info_arr']['url'] ?>" >
                    <div class="big-img"><img src="<?php echo $output['lists'][3]['code_info_arr']['pic'] ?>" width="285" height="390"></div>
                    <div class="big-sign"><img src="/data/upload/shop/brand/<?php echo $output['lists'][3]['code_info_arr']['brand_info']['brand_pic'] ?>" width="84" height="42"></div>
                    <div class="big-text"><?php echo $output['lists'][3]['code_info_arr']['brand_info']['brand_name'] ?></div>
                </a>
            </li>
            <li class="flexslider_2">
                <?php if(!empty($output['lists'][4]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][4]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                <a href="<?php echo $pic_info['url'] ?>" >
                        <div class="big-img" style="width: 590px;height: 390px">
                            <img src="<?php echo $pic_info['pic'] ?>" width="590" height="390">
                        </div>
                </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li class="flexslider_3">
                <?php if(!empty($output['lists'][5]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][5]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                    <a href="<?php echo $pic_info['url'] ?>" >
                        <div class="big-img" style="width: 590px;height: 390px">
                            <img src="<?php echo $pic_info['pic'] ?>" width="590" height="390">
                        </div>
                    </a>
                    <?php } ?>
                <?php } ?>
            </li>
        </ul>
    </div>
    <div class="never">
        <h3></h3>
        <h4>品牌逛不停</h4>
        <dl>
            <dd><a class="on">全部</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=1057">全球跨境</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=1068">海豚主场</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=1">服饰鞋帽</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=2">礼品箱包</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=3">家居家装</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=256">数码办公</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=308">家用电器</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=470">个护化妆</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=530">珠宝手表</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=593">食品饮料</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=662">运动健康</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=730">汽车用品</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=825">玩具乐器</a></dd>
            <dd><a href="/shop/index.php?controller=cate&action=index&cate_id=888">厨具</a></dd>
        </dl>
        <ul>
            <li class="flexslider_4">
                <?php if(!empty($output['lists'][6]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][6]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="275">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li class="flexslider_5">
                <?php if(!empty($output['lists'][7]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][7]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="275">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li class="flexslider_6">
                <?php if(!empty($output['lists'][8]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][8]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="580">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li>
                <a href="<?php echo $output['lists'][9]['code_info_arr']['url'] ?>" >
                    <img src="<?php echo $output['lists'][9]['code_info_arr']['pic'] ?>" width="780" height="275">
                </a>
            </li>
            <li>
                <a href="<?php echo $output['lists'][10]['code_info_arr']['url'] ?>">
                    <img src="<?php echo $output['lists'][10]['code_info_arr']['pic'] ?>" width="375" height="275">
                </a>
            </li>
            <li>
                <a href="<?php echo $output['lists'][11]['code_info_arr']['url'] ?>" >
                    <img src="<?php echo $output['lists'][11]['code_info_arr']['pic'] ?>" width="780" height="275">
                </a>
            </li>
            <li>
                <a href="<?php echo $output['lists'][12]['code_info_arr']['url'] ?>">
                    <img src="<?php echo $output['lists'][12]['code_info_arr']['pic'] ?>" width="575" height="275">
                </a>
            </li>
            <li>
                <a href="<?php echo $output['lists'][13]['code_info_arr']['url'] ?>" >
                    <img src="<?php echo $output['lists'][13]['code_info_arr']['pic'] ?>" width="575" height="275">
                </a>
            </li>
            <li class="flexslider_7">
                <?php if(!empty($output['lists'][14]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][14]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="580">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li class="flexslider_8" style="margin-left: 20px;">
                <?php if(!empty($output['lists'][15]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][15]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="275">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li class="flexslider_9">
                <?php if(!empty($output['lists'][16]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][16]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="375" height="275">
                        </a>
                    <?php } ?>
                <?php } ?>
            </li>
            <li>
                <a href="<?php echo $output['lists'][17]['code_info_arr']['url'] ?>">
                    <img src="<?php echo $output['lists'][17]['code_info_arr']['pic'] ?>" width="780" height="275">
                </a>
            </li>
        </ul>
    </div>
</div>