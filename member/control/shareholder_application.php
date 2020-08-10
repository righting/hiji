<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
class shareholder_applicationControl extends BaseShopMemberControl {


    public function indexOp() {
        $model  = Model('exhibition');
        $code = 'shareholder_application';
        $where['code'] = $code;
        $info = $model->getOne($where);
        Tpl::output('current_active_name','shareholder_application');
        Tpl::output('info',$info);
        Tpl::output('webTitle',' - 股东商申请');
        Tpl::showpage('incentive/shareholder');
    }
}