<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/15
 * Time: 17:41
 */
class joinControl extends BaseHomeControl{
    public function developingOp(){
        Language::read('home_index_index');
        Tpl::output('index_sign','37');      // 设置头部导航栏当前选中的位置

        Tpl::showpage('join');
    }





    /**
     * 智能便利店
     */
    public function smartConvenienceStoreOp(){

        Tpl::showpage('smart_convenience_Store');
    }



    /**
     * 绿色发展
     */
    public function greenDevelopmentOp(){

        Tpl::showpage('green_development');
    }

}