<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_bonus_details.css" rel="stylesheet" type="text/css">

<div class="receive-dividents">
    <div class="receive-dividents-title">
        历史分红明细
    </div>
    <ul class="receive-dividents-moon" >
        <?php foreach($output['time'] as $k=>$v){?>
            <li <?php if($output['type']==$k){ echo 'class="entire-a entire"';}?>>
                <a href="/member/index.php?controller=member_bonus&action=bonusDetails&type=<?php echo $k;?>"> <?php echo str_replace('-','年',$v['time']).'月'?></a>
            </li>
        <?php }?>
    </ul>

    <div class="receive-dividents-table">
        <div class="receive-dividents-width">
            <div style="width: 100%;overflow: hidden">
                <div class="receive-ul-div">日期</div>
                <ul class="receive-ul-a">
                    <li class="entire-b ">日分红</li>
                    <li>周分红</li>
                    <li>月分红</li>
                </ul>
                <div class="receive-ul-div rect-div"></div>
            </div>
            <hr>
            <?php foreach($output['bonusArray'] as $k=>$v){?>
                <div class="evaluate-estimate" style="display: block">
                    <ul class="receive-ul-b">
                        <li style="color:#000;"><?php echo $k?>日</li>
                        <li style="color:green;">
                            <?php
                            $money = 0;
                            foreach($v as $key=>$val){
                                if($val['type']==1 || $val['type']==2 || $val['type']==10 || $val['type']==17 || $val['type']==18 || $val['type']==19){
                                    $money += $val['money'];
                                }
                            }
                            echo $money;
                            ?>
                        </li>
                        <li style="color:green;">
                            <?php
                            $money = 0;
                            foreach($v as $key=>$val){
                                if($val['type']==11 || $val['type']==5){
                                    $money += $val['money'];
                                }
                            }
                            echo $money;
                            ?>
                        </li>
                        <li style="color:green;">
                            <?php
                            $money = 0;
                            foreach($v as $key=>$val){
                                if($val['type']==6 || $val['type']==7 || $val['type']==8 || $val['type']==9 || $val['type']==12){
                                    $money += $val['money'];
                                }
                            }
                            echo $money;
                            ?>
                        </li>
                        <li></li>
                    </ul>
                </div>
            <?php }?>
        </div>
    </div>
</div>

