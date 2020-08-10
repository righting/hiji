<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
defined('ByCCYNet') or exit('Access Invalid!');

class promotionControl extends BaseShopMemberControl {
    public function __construct()
    {
        parent::__construct();
        Tpl::output('current_active_name','promotion');
    }

    public function indexOp() {
        $model  = Model('exhibition');
        $code = 'promotion';
        $where['code'] = $code;
        $info = $model->getOne($where);
        Tpl::output('info',$info);

        //获取会员职务信息
        define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/'.TPL_NAME);

        $model = Model('positions');
        $posit_info = $model->getMyPositions();
        Tpl::output('posit_info',$posit_info);
        Tpl::output('webTitle',' - 职级晋升');
        Tpl::showpage('promotion/index');
    }

    /**
     * 展示我的职务信息以及进晋进程
     */
    public function mypositionsOp(){
        //获取会员职务信息
        define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/'.TPL_NAME);

        $model = Model('positions');
        $posit_info = $model->getMyPositions();
        Tpl::output('posit_info',$posit_info);

        Tpl::showpage('promotion/mypositions');
    }
}