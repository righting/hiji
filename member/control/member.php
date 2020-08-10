<?php
/**
 * 会员中心——账户概览
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class memberControl extends BaseMemberControl{

    /**
     * 会员级别
     */
    public function userLevelOp(){
        Tpl::output('current_active_name','pointgrade');
        Tpl::output('webTitle',' - 会员级别');
        Tpl::showpage('member_level');
    }

    /**
     * 我的海吉币
     */
    public function userCoinsOp(){
        $model = Model('sign_in_log');
        $userId = $_SESSION['member_id'];
        $info=$model->where(['user_id'=>$userId])->page(6)->order('sign_in_time desc')->select();
        Tpl::output('show_page',$model->showpage());
        Tpl::output('info',$info);
        Tpl::output('current_active_name','userCoins');
        Tpl::output('webTitle',' - 我的海吉币');
        Tpl::showpage('member_coins');
    }




    /**
     * 我的商城
     */
    public function homeOp() {
        $model_consume = Model('consume');
        $consume_list = $model_consume->getConsumeList(array('member_id' => $_SESSION['member_id']), '*', 0, 10);
        Tpl::output('consume_list', $consume_list);
        Tpl::showpage('member_home');
    }
    public function testOp(){
        Db::beginTransaction();
        try{
            $model_member = Model('member');
            $res = $model_member->editMember(array('member_id' => 104), array('level_id' => 1));
            Model::beginTransaction();
            try{
                Db::commit();
            }catch (Exception $e){
                Db::rollback();
            }
            throw new Exception('aa');
            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            echo  $e->getMessage();
        }

    }
}
