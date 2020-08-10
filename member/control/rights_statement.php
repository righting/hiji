<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
class rights_statementControl extends BaseShopMemberControl {



    public function indexOp() {

        //猜你喜欢
        $user_id = $_SESSION['member_id'];
        $likeGoods = Model('goods_browse')->getGuessLikeGoods($user_id);
        $likeGoods = array_slice($likeGoods,0,5);
        //获取会员职务信息
        $model = Model('positions');
        $posit_info = $model->getMyPositions();


        Tpl::output('current_active_name','rights_statement');
        Tpl::output('likeGoods',$likeGoods);
        Tpl::output('posit_info',$posit_info);
        Tpl::output('webTitle',' - 会员权益说明');
        Tpl::showpage('incentive/user_statement');
    }
}