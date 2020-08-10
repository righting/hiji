<?php
/**
 * 我的分红中心
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class member_bounsControl extends BaseMemberControl
{
    public function __construct()
    {
        parent::__construct();
    }
    public  function  indexOp(){
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['lg_member_id'] = $_SESSION['member_id'];
        $list = $model_pd->getPdLogList($condition,20,'*','lg_id desc');
        //统计分红
        $model_bouns_log = Model('user_bouns_log');
        $data_bouns_list = $model_bouns_log->getUserBounsLogList($_SESSION['member_id']);
        $bouns_count = $model_bouns_log->countUserBouns($data_bouns_list);
        //信息输出
        Tpl::output('count',$bouns_count);//统计数据
        Tpl::output('show_page',$model_pd->showpage());
        Tpl::output('list',$data_bouns_list);//列表数据
        Tpl::showpage('member_bouns.index');
    }
}