<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
class agreementControl extends BaseShopMemberControl {


    public function indexOp() {
        $model  = Model('exhibition');
        $code = 'agreement';
        $where['code'] = $code;
        $info = $model->getOne($where);
        Tpl::output('info',$info);
        Tpl::showpage('agreement/index');
    }
}