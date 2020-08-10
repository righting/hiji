<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<div class="xpss-main">
    <div class="xpss-banner">
        <div class="pro-switch">
            <div class="flexslider">
                <ul class="slides">
                    <?php if(!empty($output['lists'][1]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][1]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                    <li>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <div class="img" style=" background:url(<?php echo $pic_info['pic'] ?>) no-repeat center; height:400px;"></div>
                        </a>
                    </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>

    <div class="listing">
        <h3>
            <img src="<?php echo $output['lists'][2]['code_info_arr']['pic'] ?>" width="680" height="150">
        </h3>
        <ul>

                <li>
                    <a href="<?php echo $output['lists'][3]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][3]['code_info_arr']['pic'] ?>" width="288" height="285">
                    </a>
                </li>


                <li>
                    <a href="<?php echo $output['lists'][4]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][4]['code_info_arr']['pic'] ?>" width="288" height="285">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][5]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][5]['code_info_arr']['pic'] ?>" width="288" height="285">
                    </a>
                </li>




                <li>
                    <a href="<?php echo $output['lists'][6]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][6]['code_info_arr']['pic'] ?>" width="288" height="285">
                    </a>
                </li>




                <li>
                    <a href="<?php echo $output['lists'][7]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][7]['code_info_arr']['pic'] ?>" width="230" height="240">
                    </a>
                </li>




                <li>
                    <a href="<?php echo $output['lists'][8]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][8]['code_info_arr']['pic'] ?>" width="230" height="240">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][9]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][9]['code_info_arr']['pic'] ?>" width="230" height="240">
                    </a>
                </li>




                <li>
                    <a href="<?php echo $output['lists'][10]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][10]['code_info_arr']['pic'] ?>" width="230" height="240">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][11]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][11]['code_info_arr']['pic'] ?>" width="230" height="240">
                    </a>
                </li>

        </ul>
    </div>

    <div class="selected">
        <h2></h2>
        <h3>精选推荐</h3>
        <h4>SELECTON OF RECOMMENDED</h4>
        <ul>

                <li class="slider_1">
                    <?php if(!empty($output['lists'][12]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][12]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="1200" height="400">
                        </a>
                        <?php } ?>
                    <?php } ?>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][13]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][13]['code_info_arr']['pic'] ?>" width="595" height="425">
                    </a>
                </li>




                <li class="slider_2">
                    <?php if(!empty($output['lists'][14]['code_info_arr']['pic_arr'])){ ?>
                    <?php foreach ($output['lists'][14]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                        <a href="<?php echo $pic_info['url'] ?>">
                            <img src="<?php echo $pic_info['pic'] ?>" width="290" height="425">
                        </a>
                        <?php } ?>
                    <?php } ?>
                </li>


                <li class="slider_3">
                    <?php if(!empty($output['lists'][15]['code_info_arr']['pic_arr'])){ ?>
                        <?php foreach ($output['lists'][15]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                            <a href="<?php echo $pic_info['url'] ?>">
                                <img src="<?php echo $pic_info['pic'] ?>" width="290" height="425">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][16]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][16]['code_info_arr']['pic'] ?>" width="290" height="425">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][17]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][17]['code_info_arr']['pic'] ?>" width="290" height="425">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][18]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][18]['code_info_arr']['pic'] ?>" width="290" height="280">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][19]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][19]['code_info_arr']['pic'] ?>" width="290" height="130">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][20]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][20]['code_info_arr']['pic'] ?>" width="290" height="140">
                    </a>
                </li>



                <li>
                    <a href="<?php echo $output['lists'][21]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][21]['code_info_arr']['pic'] ?>" width="290" height="425">
                    </a>
                </li>


                <li>
                    <a href="<?php echo $output['lists'][22]['code_info_arr']['url'] ?>">
                        <img src="<?php echo $output['lists'][22]['code_info_arr']['pic'] ?>" width="290" height="425">
                    </a>
                </li>


                <li class="slider_4">
                    <?php if(!empty($output['lists'][23]['code_info_arr']['pic_arr'])){ ?>
                        <?php foreach ($output['lists'][23]['code_info_arr']['pic_arr'] as $pic_info){ ?>
                            <a href="<?php echo $pic_info['url'] ?>">
                                <img src="<?php echo $pic_info['pic'] ?>" width="1200" height="96">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </li>

            <style>
                .span-img{
                    width: 227px;
                    height: 215px;
                    display: block;
                    float: left;
                    margin: 10px 5px;
                }
            </style>
            <li style="display: block;width: 1200px;height:auto">
                <div style="display: block;width: 1200px;" class="slider_5">
                    <?php if(!empty($output['lists'][24]['code_info_arr']['pic_arr'])){ $pic_chunk_arr = array_chunk($output['lists'][24]['code_info_arr']['pic_arr'],10); ?>
                        <?php foreach ($pic_chunk_arr as $pic_info_arr){ ?>
                            <span>
                                <?php foreach ($pic_info_arr as $pic_info){ ?>
                                <a class="span-img" href="<?php echo $pic_info['url'] ?>">
                                    <img src="<?php echo $pic_info['pic'] ?>" width="227" height="215" style="display:block;float: left">
                                </a>
                                <?php } ?>
                            </span>
                        <?php } ?>
                    <?php } ?>
                </div>
            </li>


        </ul>
    </div>


        <div class="know">
            <h3></h3>
            <ul>
                <?php if(!empty($output['goods_list'])){ ?>
                    <?php foreach($output['goods_list'] as $goods_info){ ?>
                        <li>
                            <a href="<?php echo urlShop('goods','index',['goods_id'=>$goods_info['goods_id']]);?>">
                                <div class="know-img"><img src="<?php echo $goods_info['goods_image'];?>"  width="288" height="288"></div>
                                <div class="know-price">
                                    <span><b>¥</b><?php echo $goods_info['goods_price'];?></span>
                                </div>
                                <div class="know-text"><?php echo $goods_info['goods_name'];?></div>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
</div>