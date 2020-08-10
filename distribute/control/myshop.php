<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/12
 * Time: 18:14
 */
class myshopControl extends BaseDistributeControl
{
    public  function  __construct()
    {
        define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/'.TPL_NAME);
    }

    public function indexOp(){
        $rec = $_GET['rec'];
        if (empty($rec))
            return false;
        $member_id = hj_decrypt($rec) ;
        $distribute_goods = Model('distribute_goods');
        $mygoodstotal = $distribute_goods->getGoodsByUserID($member_id);
        Tpl::output('mygoodstotal',$mygoodstotal);

        Tpl::showpage('myshop/index');
    }
}