<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
class upgradeControl extends BaseShopMemberControl {


    public function indexOp() {
        $model  = Model('exhibition');
        $code = 'upgrade';
        $where['code'] = $code;
        $info = $model->getOne($where);
        Tpl::output('info',$info);
        Tpl::showpage('upgrade/index');
    }
}