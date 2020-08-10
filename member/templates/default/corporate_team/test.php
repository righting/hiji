<link href="<?php echo MEMBER_TEMPLATES_URL;?>/css/new_member_team.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
    $(function(){
        var slideHeight = 200; // px
        var defHeight = $('.text-wrap').height();
        if(defHeight >= slideHeight){
            $('.text-wrap').css('height' , slideHeight + 'px');
            $('.read-more').append('<a href="#">查看更多</a>');
            $('.read-more a').click(function(){
                var wrap = $(this).parent().prev();
                // var curHeight = $('.text-wrap').height();
                var curHeight = wrap.height();
                if(curHeight == slideHeight){
                    wrap.animate({
                        height: defHeight
                    }, 500);
                    $(this).html('点击折叠');
                }else{
                    wrap.animate({
                        height: slideHeight
                    }, "normal");
                    $(this).html('查看更多');
                }
                return false;
            });
        }
    });
</script>



<div class="personal-setting">
    <div class="personal-honor group-outer">
        <h3 class="group-top"><i></i>我的荣誉</h3>
        <ul>
            <li class="vip-grade">
                <span>会员等级</span>
                <p>
                    <?php
                    $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_level_'.$output['member_info']['level_id'].'.png';
                    echo "<i style='background:url($tplImgUrl) 0 0 no-repeat; background-size:contain;'></i>";
                    ?>
                    <em><?php echo $output['member_info']['level_name']?></em></p>
            </li>
            <li class="group-grade">
                <span>团队职级</span>
                <?php if($output['member_info']['positions_id']<8){?>
                    <p>
                        <?php
                        $tplImgUrl = MEMBER_TEMPLATES_URL.'/images/user_position_'.$output['member_info']['positions_id'].'.png';
                        echo "<i style='background:url($tplImgUrl) 0 0 no-repeat; background-size:60px 60px;'></i>";
                        ?>
                        <em><?php echo $output['member_info']['position_name']?></em>
                    </p>
                <?php }else{?>
                    <p>
                        <em>无职级</em>
                    </p>
                <?php }?>
            </li>
            <li class="group-top-image">
                <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/group_01.jpg">
            </li>
        </ul>
    </div>
    <div class="honor-banner-1">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/mygroup-banner_01.jpg">
    </div>

    <?php if ($output['is_show'] == 1) { ?>
        <div class="essential-nav">
            <ul class="tab pngFix">
                <a style="float: right" class="ncbtn ncbtn-mint" href="<?php echo urlMember('member_team','bind') ?>" ><i class="icon-edit"></i>绑定团队</a>
            </ul>
        </div>
    <?php } ?>

    <div class="personal-group group-outer">
        <h3 class="group-top"><i></i>我的团队</h3>
        <div class="personal-group-bottom">
          <?php if ($output['is_show_top'] == 1) { ?>
            <ul class="group-invite">
                <li class="group-invite-leader">
                    <h4>上级团队ID</h4>
                    <span><?php echo $output['from_user_member_info']['member_number']?$output['from_user_member_info']['member_number']:'暂无'; ?></span>
                </li>
                <li class="group-invite-message">
                    <h4>邀请人姓名</h4>
                    <span><?php echo $output['from_user_member_info']['member_truename']?$output['from_user_member_info']['member_truename']:'暂无'; ?></span>
                </li>
                <li class="group-invite-level">
                    <h4>邀请人电话</h4>
                    <span><?php echo $output['from_user_member_info']['member_mobile']?$output['from_user_member_info']['member_mobile']:'暂无'; ?></span>
                </li>
            </ul>
          <?php } ?>
            <div class="personal-team">
                <ul class="members-nav">
                    <li>会员姓名</li>
                    <li>会员等级</li>
                    <li>团队职级</li>
                    <li>手机号码</li>
                    <li>加入日期</li>
                </ul>
                <?php if (isset($output['invite_user_member_info']) && !empty($output['invite_user_member_info'])){ ?>

                <ul class="members-details">
                    <li class="personal-group-members">
                        <?php foreach ($output['invite_user_member_info'] as $value){ ?>
                            <ul>
                                    <li><?php echo $value['member_name'] ?></li>
                                    <li><?php echo $output['level_info_for_id'][$value['level_id']] ?></li>
                                    <li><?php echo $output['positions_info_for_id'][$value['positions_id']] ?></li>
                                    <li><?php echo $value['member_mobile']? $value['member_mobile']:'暂无'?></li>
                                    <li><?php echo date('Y-m-d',$value['member_time']) ?></li>
                            </ul>
                        <?php }?>
                    </li>
                </ul>
                <?php }else{ ?>
                    <div class="warning-option">
                        <i>&nbsp;</i>
                        <span>
                        <?php if($output['can_invite'] == 1){ ?>
                            <?php echo $lang['no_record'];?>
                        <?php }else{ ?>
                            免费VIP以上等级会员才可邀请团队成员
                        <?php } ?>
                </span>
                    </div>
                <?php }?>

            </div>

            <?php if (count($output['invite_user_member_info'])>0){?>
                <div class="pagination"> <?php echo $output['team_user_page']; ?> </div>
            <?php } ?>



        </div>
    </div>
    <div class="group-link group-outer">
        <h3 class="group-top"><i></i>团队链接</h3>
        <div class="group-link-button">
            <a href="javascript:;">海吉商圈</a>
            <a href="javascript:;">会员联盟</a>
        </div>
    </div>
    <div class="honor-banner-2">
        <img src="<?php echo MEMBER_TEMPLATES_URL; ?>/images/mygroup-banner_02.jpg">
    </div>


    <div class="group-build group-outer">
        <h3 class="group-top"><i></i>团队建设</h3>
        <div class="group-build-details">
            <ul class="group-build-top">
                <li>
                    <h2>团队建设</h2>
                    <div class="group-build-text">
                        <p>
                            <b>团队建设</b>，是指有意识地在组织中努力开发有效的团队，通过自我管理的形式，负责一个完整工作的过程。在该过程中，参与者和推进者都要彼此增进信任，坦诚相对，并愿意共同影响团队去创造不同寻常的业绩。
                        </p>
                        <p>
                            建设一个好的团队！先要营造一个好的氛围！掌握他们的心理状态，用聊天或商量的模式，去多一些了解和团队活动，增强团队凝聚力、执行力和配合意识。并把不利于发挥团队合作的害群之马从你的团队里面清除出局！还有就是要培养团队骨干“领头羊”，以便于工作的顺利开展和执行！ 团队建设，需做到五个统一:<em> 统一的目标、统一的思想、统一的规则、统一的行动、统一的声音。</em>
                        </p>
                        <p>
                            团队建设中发出的危险性信号有：个人目标与团队愿景不一致而产生的精神离职；小团队“小帮派”；不合群的“超级业务员”。团队建设的核心法则：言行一致，实事求是，说到，做到。听话照做，不折不扣，立即执行。全力以赴，成功与借口不能幷存 。珍惜你所拥有的并抱持感恩之心。认真、用心、努力、负责任。绝不讲负面消极，专注于正面积极。别人讲话不插嘴，尊重别人就是尊重自己。
                        </p>
                        <p>
                            <em>体验式团队建设</em>，以一种独有的、有内涵的方式着手，终极目的是实现梦想，拓展心灵空间，同时加强团队凝聚力，达到每个成员与团队之间的一种融合。这种方式更加注重团队成员的参与性、亲历性，追求过程的内涵性，其中包括精神内涵与文化内涵，是一种新兴的团队建设方式。
                        </p>
                    </div>
                </li>
                <li>
                    <h2 class="group-spirit">团队精神</h2>
                    <div class="group-spirit-text">
                        <p>
                            <b>团队精神：</b>团队精神：就是大局意识、协作精神和服务精神的集中体现,是为了团队的利益和目标而相互协作、尽心尽力的意愿和作风，是一流团队中的灵魂。
                        </p>
                        <p>
                            尊重个人的兴趣和成就，发挥团队成员个性和培养团队成员的大局意识，是团队精神的基础。最高境界，是全体成员的向心力、凝聚力，也就是个体利益和整体利益的统一。协同合作，是团队精神的核心。互补互助以共同发挥最大效率的能力，就是团队协作能力。没有明确的协作意愿和协作方式及团队目标，就不能产生真正的内心动力。团队目标没有良好的从业心态和奉献精神，就不会有团队精神。
                        </p>
                        <p>
                            团队精神更强调个人的主动性。团队精神，表现为团队强烈的归属感和一体性，每个团队成员都能强烈地感受到自己是团队当中的一分子，把个人工作和团队目标联系在一起，对团队表现出一种忠诚，对团队的业绩表现出一种荣誉感，对团队的成功表现出一种骄傲，对团队的困境表现出一种忧虑。
                        </p>
                        <p>
                            就是要确立一个目标，树立主动服务的思想，经常沟通和协调，强化激励，形成利益共同体。
                        </p>
                    </div>
                </li>
            </ul>
            <div class="group-build-intro">
                <div class="text-wrap">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum, dolor sit amet consectetur adipisicing elit. At error incidunt porro fuga ipsam sapiente, eum iste, excepturi illum rerum magni, reiciendis repudiandae magnam laboriosam inventore laborum. Accusantium, asperiores enim!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam eveniet accusamus amet, necessitatibus molestias id quos dignissimos maxime commodi qui enim ratione consectetur quia. Natus quibusdam at nostrum explicabo ad.
                        Id laborum ullam doloremque adipisci optio blanditiis natus eum molestiae maxime praesentium molestias ab, omnis, saepe aut officia delectus itaque necessitatibus iste magni eveniet reiciendis quo. Consectetur harum eius necessitatibus!
                        Dolor in magni sit deleniti officiis totam impedit eius libero, aperiam dicta labore quas eos excepturi quia? Molestias cupiditate sit ullam similique incidunt quidem sequi, quod, quasi corporis reprehenderit vel?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum, dolor sit amet consectetur adipisicing elit. At error incidunt porro fuga ipsam sapiente, eum iste, excepturi illum rerum magni, reiciendis repudiandae magnam laboriosam inventore laborum. Accusantium, asperiores enim!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam eveniet accusamus amet, necessitatibus molestias id quos dignissimos maxime commodi qui enim ratione consectetur quia. Natus quibusdam at nostrum explicabo ad.
                        Id laborum ullam doloremque adipisci optio blanditiis natus eum molestiae maxime praesentium molestias ab, omnis, saepe aut officia delectus itaque necessitatibus iste magni eveniet reiciendis quo. Consectetur harum eius necessitatibus!
                        Dolor in magni sit deleniti officiis totam impedit eius libero, aperiam dicta labore quas eos excepturi quia? Molestias cupiditate sit ullam similique incidunt quidem sequi, quod, quasi corporis reprehenderit vel?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                </div>
                <div class="read-more"></div>
            </div>
            <div class="group-spirit-intro">
                <div class="text-wrap">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum, dolor sit amet consectetur adipisicing elit. At error incidunt porro fuga ipsam sapiente, eum iste, excepturi illum rerum magni, reiciendis repudiandae magnam laboriosam inventore laborum. Accusantium, asperiores enim!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam eveniet accusamus amet, necessitatibus molestias id quos dignissimos maxime commodi qui enim ratione consectetur quia. Natus quibusdam at nostrum explicabo ad.
                        Id laborum ullam doloremque adipisci optio blanditiis natus eum molestiae maxime praesentium molestias ab, omnis, saepe aut officia delectus itaque necessitatibus iste magni eveniet reiciendis quo. Consectetur harum eius necessitatibus!
                        Dolor in magni sit deleniti officiis totam impedit eius libero, aperiam dicta labore quas eos excepturi quia? Molestias cupiditate sit ullam similique incidunt quidem sequi, quod, quasi corporis reprehenderit vel?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum, dolor sit amet consectetur adipisicing elit. At error incidunt porro fuga ipsam sapiente, eum iste, excepturi illum rerum magni, reiciendis repudiandae magnam laboriosam inventore laborum. Accusantium, asperiores enim!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam eveniet accusamus amet, necessitatibus molestias id quos dignissimos maxime commodi qui enim ratione consectetur quia. Natus quibusdam at nostrum explicabo ad.
                        Id laborum ullam doloremque adipisci optio blanditiis natus eum molestiae maxime praesentium molestias ab, omnis, saepe aut officia delectus itaque necessitatibus iste magni eveniet reiciendis quo. Consectetur harum eius necessitatibus!
                        Dolor in magni sit deleniti officiis totam impedit eius libero, aperiam dicta labore quas eos excepturi quia? Molestias cupiditate sit ullam similique incidunt quidem sequi, quod, quasi corporis reprehenderit vel?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione itaque cupiditate, sint vero distinctio explicabo veniam totam mollitia illo sunt repellat praesentium fugit maxime nesciunt deserunt necessitatibus illum corrupti delectus?</p>
                </div>
                <div class="read-more"></div>
            </div>
        </div>
    </div>

</div>