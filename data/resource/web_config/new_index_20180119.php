<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

    <div class="banner-bot-menu">
        <ul>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=1068">
                    <div class="db">
                        <span class="icon1"></span>
                        <em>海豚主场</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=1">
                    <div class="db">
                        <span class="icon2"></span>
                        <em>服饰鞋帽</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=2">
                    <div class="db">
                        <span class="icon3"></span>
                        <em>礼品箱包</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=3">
                    <div class="db">
                        <span class="icon4"></span>
                        <em>家居家装</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=256">
                    <div class="db">
                        <span class="icon5"></span>
                        <em>数码办公</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
            <li>
                <a href="/shop/index.php?controller=cate&action=index&cate_id=308">
                    <div class="db">
                        <span class="icon6"></span>
                        <em>家用电器</em>
                    </div>
                    <div class="sm">
                        <em>点击进入</em>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="inmain-line">
        <div class="line-tz">
            <h3>
                <span><?php echo $output['lists'][1]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][1]['code_info_arr']['f_title'] ?></em>
                <a href="<?php echo $output['lists'][1]['code_info_arr']['url'] ?>" class="more"></a>
            </h3>
            <div class="line-tz-img"><img src="<?php echo $output['lists'][1]['code_info_arr']['pic'] ?>"></div>
            <div class="line-tz-text">
                <span><?php echo $output['lists'][1]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][1]['code_info_arr']['f_title'] ?></em>
            </div>
        </div>


        <div class="line-tz2">

            <div class="line-tz-img" style="height: 470px">

                <div class="pro-switch">
                    <div>
                        <ul class="flexslidera">
                            <?php if(!empty($output['lists'][2]['code_info_arr']['pic_arr'])){ ?>
                            <?php foreach ($output['lists'][2]['code_info_arr']['pic_arr'] as $pic_info){ ?>

                            <li style="height: 470px">
                                <a href="<?php echo $pic_info['url'] ?>" style="height: 470px">
                                    <div class="img">
                                        <img src="<?php echo $pic_info['pic'] ?>" width="545" height="470" style="height: 470px">
                                    </div>
                                </a>
                            </li>
                                    <?php } ?>
                            <?php } ?>

                        </ul>

                    </div>
                </div>
            </div>
        </div>



        <div class="line-tz3">
            <h3>
                <span><?php echo $output['lists'][3]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][3]['code_info_arr']['f_title'] ?></em>
                <a href="<?php echo $output['lists'][3]['code_info_arr']['url'] ?>" class="more"></a>
            </h3>
            <div class="line-tz-img"><img src="<?php echo $output['lists'][3]['code_info_arr']['pic'] ?>"></div>
            <div class="line-tz-text">
                <span><?php echo $output['lists'][3]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][3]['code_info_arr']['f_title'] ?></em>
            </div>
        </div>
    </div>
    <div class="inmain-line">
        <div class="line-tz4">
            <h3>
                <span><?php echo $output['lists'][4]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][4]['code_info_arr']['f_title'] ?></em>
                <a href="<?php echo $output['lists'][4]['code_info_arr']['url'] ?>" class="more"></a>
            </h3>
            <div class="line-tz-img"><img src="<?php echo $output['lists'][4]['code_info_arr']['pic'] ?>"></div>
            <div class="line-tz-text">
                <span><?php echo $output['lists'][4]['code_info_arr']['title'] ?></span>
                <em><?php echo $output['lists'][4]['code_info_arr']['f_title'] ?></em>
            </div>
        </div>
        <div class="line-tz5">
            <h3>
                <span><?php echo $output['lists'][5]['code_info_arr']['title'] ?> </span>
                <em><?php echo $output['lists'][5]['code_info_arr']['f_title'] ?></em>
                <a href="<?php echo $output['lists'][5]['code_info_arr']['url'] ?>" class="more"></a>
            </h3>
            <div class="line-tz-img"><img src="<?php echo $output['lists'][5]['code_info_arr']['pic'] ?>"></div>
            <div class="line-tz-text">
                <span><?php echo $output['lists'][5]['code_info_arr']['title'] ?> </span>
                <em><?php echo $output['lists'][5]['code_info_arr']['f_title'] ?></em>
            </div>
        </div>
        <div class="line-tz6 ">
            <ul class="flexsliderc">
                <?php if(!empty($output['lists'][6]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][6]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <li><a href="<?php echo $pic_info['url'] ?>"><img src="<?php echo $pic_info['pic'] ?>"></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="guess">
        <h3>猜你喜欢</h3>
        <h4>GUESS YOU LIKE</h4>
        <ul>
            <li>
                <a href="<?php echo $output['lists'][7]['code_info_arr']['url'] ?>" style="width:460px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][7]['code_info_arr']['pic'] ?>">
                </a>
            </li>


            <li class="guess-li-center">

                    <ul class="flexsliderb">
                        <?php if(!empty($output['lists'][8]['code_info_arr']['pic_arr'])){ ?>
                        <?php foreach ($output['lists'][8]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <li style="border: 0;margin:0;height: 555px"><a href="<?php echo $pic_info['url'] ?>"><img src="<?php echo $pic_info['pic'] ?>" width="220" height="527"></a></li>
                            <?php  } ?>
                        <?php } ?>
                    </ul>

            </li>


            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][9]['code_info_arr']['url'] ?>" style="width:220px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][9]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][10]['code_info_arr']['url'] ?>" style="width:220px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][10]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][11]['code_info_arr']['url'] ?>" style="width:220px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][11]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][12]['code_info_arr']['url'] ?>" style="width:220px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][12]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][13]['code_info_arr']['url'] ?>" style="width:460px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][13]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][14]['code_info_arr']['url'] ?>" style="width:702px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][14]['code_info_arr']['pic'] ?>">
                </a>
            </li>
            <li class="guess-li-right">
                <a href="<?php echo $output['lists'][15]['code_info_arr']['url'] ?>" style="width:460px;height: 265px;display: block">
                    <img src="<?php echo $output['lists'][15]['code_info_arr']['pic'] ?>">
                </a>
            </li>
        </ul>

    </div>
