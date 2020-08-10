<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<article>
    <div class="home-focus-layout">
        <ul id="fullScreenSlides" class="full-screen-slides">

            <?php if(!empty($output['lists'][1]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][1]['code_info_arr']['pic_arr'] as $pic_info){ ?>
            <li style="background: url('<?php echo $pic_info['pic'] ?>') center top no-repeat; z-index: 900;">
                <a href="<?php echo $pic_info['url'] ?>" target="_blank" title="<?php echo $pic_info['title'] ?>">&nbsp;</a>
            </li>
                    <?php } ?>
            <?php } ?>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="wrap_nav">
        <a href="<?php echo $output['lists'][2]['code_info_arr']['url'] ?>" class="wrap_h hover_origin"><img src="<?php echo $output['lists'][2]['code_info_arr']['pic'] ?>" width="1200" height="150"><div class="hover_top"></div></a>
        <div class="advert-menu">
            <ul class="flexslider_a">
                    <?php if(!empty($output['lists'][3]['code_info_arr']['pic_arr'])){ ?>
                        <?php foreach ($output['lists'][3]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                <li><a href="" class="hover_origin"><img src="<?php echo $pic_info['pic'] ?>" width="235" height="206"><div class="hover_top"></div></a></li>
                        <?php } ?>
                    <?php } ?>
            </ul>
        </div>
    </div>
    <div class="wrap_nav">
        <ul class="tab" id="tab">
            <li class="active">今日疯抢</li>
            <li>明日预告</li>
        </ul>
        <div class="box">
            <ul>
                <?php if(!empty($output['lists'][4]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][4]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                <li>
                    <a href="<?php echo $pic_info['url'] ?>">
                        <div class="origin">
                            <img src="<?php echo $pic_info['pic'] ?>" width="585" height="248"/>
                            <div class="mengcen"><?php echo $pic_info['title'] ?></div>
                        </div>
                        <div class="pic">
                            <?php echo $pic_info['f_title'] ?>
                        </div>
                    </a>
                </li>
                    <?php } ?>
                <?php } ?>

            </ul>
        </div>
        <div class="box" style="display: none;">
            <ul>

                <?php if(!empty($output['lists'][5]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][5]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                <li>
                    <a href="<?php echo $pic_info['url'] ?>">
                        <div class="origin">
                            <img src="<?php echo $pic_info['pic'] ?>" width="585" height="248" />
                            <div class="mengcen"><?php echo $pic_info['title'] ?></div>
                        </div>
                        <div class="pic">
                            <?php echo $pic_info['f_title'] ?>
                        </div>
                    </a>
                </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="wrap_nav">
        <div class="activity">
            <dl style="display:block;width: 600px;height:100%;float: left">

                <dt style="display:block;width: 200px;height:100%;float: left">
                    <a href="<?php echo $output['lists'][6]['code_info_arr']['url'] ?>" class="hover_origin">
                        <img src="<?php echo $output['lists'][6]['code_info_arr']['pic'] ?>" width="195" height="544">
                        <div class="hover_top"></div>
                    </a>
                </dt>

                <span class="flexslider_b" style="display:block;width: 400px;height:100%;float: left">
                <?php if(!empty($output['lists'][7]['code_info_arr']['pic_arr'])){ $array_chunk_pic_info = array_chunk($output['lists'][7]['code_info_arr']['pic_arr'],6); ?>
                <?php foreach ($array_chunk_pic_info as $pic_info_arr){ ?>
                      <span>
                            <?php foreach ($pic_info_arr as $pic_info){ ?>
                                  <dd><a href="" class="hover_origin"><img src="<?php echo $pic_info['pic'] ?>" width="196" height="182"><p><?php echo $pic_info['title'] ?></p><div class="hover_top"></div></a></dd>
                            <?php } ?>
                      </span>
                    <?php } ?>
                <?php } ?>
                </span>
            </dl>
        </div>
        <div class="activity">
            <dl style="display:block;width: 600px;height:100%;float: left">
                <dt style="display:block;width: 200px;height:100%;float: left">
                    <a href="<?php echo $output['lists'][8]['code_info_arr']['url'] ?>" class="hover_origin">
                        <img src="<?php echo $output['lists'][8]['code_info_arr']['pic'] ?>" width="195" height="544">
                        <div class="hover_top"></div>
                    </a>
                </dt>

                <span class="flexslider_c" style="display:block;width: 400px;height:100%;float: left">
                <?php if(!empty($output['lists'][9]['code_info_arr']['pic_arr'])){$array_chunk_pic_info_right = array_chunk($output['lists'][9]['code_info_arr']['pic_arr'],6); ?>
                <?php foreach ($array_chunk_pic_info_right as $pic_info_right){ ?>
                    <span>
                        <?php foreach ($pic_info_right as $pic_info){ ?>
                        <dd><a href="<?php echo $pic_info['url'] ?>" class="hover_origin"><img src="<?php echo $pic_info['pic'] ?>" width="196" height="182"><p><?php echo $pic_info['title'] ?></p><div class="hover_top"></div></a></dd>
                        <?php } ?>
                   </span>
                    <?php } ?>
                <?php } ?>
                </span>
            </dl>
        </div>
        <div class="pics">
            <?php if(!empty($output['lists'][10]['code_info_arr']['pic_arr'])){ ?>
            <?php foreach ($output['lists'][10]['code_info_arr']['pic_arr'] as $pic_info){ ?>
            <a href=""><img src="<?php echo $pic_info['pic'] ?>" width="392" height="183"></a>
                <?php } ?>
            <?php } ?>

        </div>
    </div>

    <div class="wrap_nav">
        <div class="naice_top">
            <?php if(!empty($output['lists'][11]['code_info_arr']['pic_arr'])){ ?>
            <?php foreach ($output['lists'][11]['code_info_arr']['pic_arr'] as $pic_info){ ?>
            <a href=""><img src="<?php echo $pic_info['pic'] ?>" width="594" height="237"></a>
            <?php } ?>
            <?php } ?>

        </div>
        <div class="naice_top">
            <div class="naice_left">

                <a href="<?php echo $output['lists'][12]['code_info_arr']['url'] ?>">
                    <img src="<?php echo $output['lists'][12]['code_info_arr']['pic'] ?>" width="392" height="183">
                </a>

                <div class="naice_top">
                    <?php if(!empty($output['lists'][13]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][13]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                    <a href=""><img src="<?php echo $pic_info['pic'] ?>" width="189" height="183"></a>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>

            <div class="naice_cont flexslider_d">
                <?php if(!empty($output['lists'][14]['code_info_arr']['pic_arr'])){ ?>
                <?php foreach ($output['lists'][14]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $output['lists'][14]['code_info_arr']['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="391" height="380">
                        </a>
                    <?php } ?>
                <?php } ?>

            </div>

            <div class="naice_right">
                <a href="<?php echo $output['lists'][15]['code_info_arr']['url'] ?>"><img src="<?php echo $output['lists'][15]['code_info_arr']['pic'] ?>" width="392" height="183"></a>
                <div class="naice_top">

                    <?php if(!empty($output['lists'][16]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][16]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                    <a href="<?php echo $pic_info['url'] ?>"><img src="<?php echo $pic_info['pic'] ?>" width="125" height="183"></a>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

</article>