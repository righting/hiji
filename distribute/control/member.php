<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 16:50
 */

class memberControl extends BaseDistributeControl
{
    public function homeOp(){
        $left = leftMenuList();
        $right = rightMenuList();
        $left_menu = $left['distribute'];
        Tpl::output('member_sign','distribute');      // 设置会员中心导航栏当前选中的位置
        Tpl::output('right',$right);
        Tpl::output('left',$left_menu);
        Tpl::showpage('member_home');
    }
}