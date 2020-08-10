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
     * 电子会员卡片   2018-07-03      LFP
     */
    public function member_cardOp(){
        $member_model = Model('member');
        $user_id = $_SESSION['member_id'];
        $member_info = $member_model->where(['member_id'=>$user_id])->find();
        $host = $_SERVER['HTTP_HOST'];
        $hostArr = explode('.',$host);
        $member_info['wdUrl'] =C('https')?'https://':'http://'.implode('.',$hostArr).'/shop/index.php?controller=index&action=myshop&userNumber='.$member_info['member_number'];
        $user_level_model = Model('user_level');
        $user_level_info = $user_level_model->where(['id'=>$member_info['level_id']])->find();
        $member_info['level'] = $user_level_info['level'];
        $member_info['level_name'] = $user_level_info['level_name'];
        $member_info['position_name'] = Model('positions')->where(['id'=>$member_info['positions_id']])->find()['title'];
        //echo '<pre>';print_r($member_info);exit;
        Tpl::output('member_info',$member_info);
        Tpl::showpage('member_card','null_layout');
    }
    /**
     * 会员中心首页
     */
    public function homeOp() {

        $member_model = Model('member');
        $user_id = $_SESSION['member_id'];
        $member_info = $member_model->where(['member_id'=>$user_id])->field('member_id,sign_in_money,member_number,member_name,member_truename,level_id,member_points,member_h_points,member_time,positions_id,member_nickname,member_avatar,available_predeposit,freeze_predeposit,member_contribution')->find();
        $user_level_model = Model('user_level');
        $user_level_info = $user_level_model->where(['id'=>$member_info['level_id']])->find();
        $positions_model = Model('positions');
        $user_position_info = $positions_model->where(['id'=>$member_info['positions_id']])->find();
        $member_info['level'] = $user_level_info['level'];
        $member_info['level_name'] = $user_level_info['level_name'];
        $member_info['position_name'] = $user_position_info['title'];
        $user_hi_value_model = Model('user_hi_value');
        $user_hi_value_info = $user_hi_value_model->where(['user_id'=>$user_id])->field('sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as total_hi_value')->find();
        // 月费日
        $getNextMiddleMonthDate = date("Y-m-d H:i:s", strtotime("+1 month", strtotime(date('Y-m-15'))));


        // 最新的4条文章
        $article_model  = Model('article');
        $article_lists = $article_model->where(['article_show'=>1,'ac_id'=>9])->limit(4)->order('article_id desc')->select();


        // 获取最新的5条订单
        $orderModel = Model('order');
        $orderGoodsModel = Model('order_goods');
        $refundModel  =  Model('refund_return');
        $orderInfo=$orderModel->where(['buyer_id'=>$_SESSION['member_id'],'delete_state'=>0])->field('order_id,order_sn,add_time,order_amount,order_state,refund_state')->limit(5)->order('add_time desc')->select();
        if(is_array($orderInfo) && !empty($orderInfo)){
            foreach($orderInfo as $k=>$v){
                $orderInfo[$k]['goodsInfo']=$orderGoodsModel->where(['order_id'=>$v['order_id']])->field('goods_name,goods_image')->order('rec_id asc')->find();
                $refundState =  $refundModel->where(['order_id'=>$v['order_id']])->find();
                if(!empty($refundState)){
                    $orderInfo[$k]['refund_state']=2;
                }
                if($v['refund_state']!=0){
                    $orderInfo[$k]['refundState'] = $refundModel->where(['order_id'=>$v['order_id']])->field('refund_state')->find();
                }
            }
        }


        $user_level = Model('user_level')->where(['level'=>['GT',$member_info['level']],'level'=>['EGT',2],'point'=>['ELT',$member_info['member_points']]])->select();
        if (count($user_level)>0){
            $member_info['grade_up']=true;
        }
        //个人微店地址
        $host = $_SERVER['HTTP_HOST'];
        $hostArr = explode('.',$host);
        if (strtoupper( substr($hostArr[0],0,5)) == 'HJ100' || strtoupper( substr($hostArr[0],0,3)) == 'WWW'){
            unset($hostArr[0]);
        }
        //$member_info['wdUrl'] =C('https')?'https://':'http://'.strtolower($member_info['member_number']).'.'.implode('.',$hostArr).'/shop/index.php?controller=index&action=myshop';
        $member_info['wdUrl'] =C('https')?'https://':'http://'.implode('.',$hostArr).'/shop/index.php?controller=index&action=myshop&userNumber='.$member_info['member_number'];
        //会员Hi值
        $user_hi = Model('user_hi_value')->field('recommend_team_hi,bonus_to_hi,upgrade_hi')->where(['user_id'=>$user_id])->find();
        //猜你喜欢
        $likeGoods = Model('goods_browse')->getGuessLikeGoods($user_id);
        //会员中心广告
        $adv = Model('web_config')->getWebList(['web_page'=>'member_adv']);
        $pl_rcm = Model('web_config')->getWebList(['web_page'=>'rcm_goods']);



        // 检查当前用户是否已经绑定了团队
        $register_invite_model = Model('register_invite');
        $user_id = $_SESSION['member_id'];
        $check_bind_info = $register_invite_model->where(['to_user_id'=>$user_id])->find();
        if(empty($check_bind_info)){
           $member_info['is_no_bind']=0;
        }else{
            $member_info['is_no_bind']=1;
        }


        //判断今日是否签到
        $signLogModel =  Model('sign_in_log');
        $start_time = date('Y-m-d 00:00:00');
        $end_time  =  date('Y-m-d 23:59:59');
        //查询用户今日是否签到
        $where['user_id']= $user_id;
        $where['sign_in_time']= ['between', [$start_time, $end_time]];
        $signInfo=$signLogModel->where($where)->find();
        $isSignIn=0;
        if(empty($signInfo)){
           $isSignIn = 1;
        }

        //获取分红期数
        $bonusModel = Model('user_bonus_stages');
        $stagesInfo=$bonusModel->where(['status'=>1])->order('id desc')->find();

        $nowTime = date('Y-m-d H:i:s');
        $week  =  explode('|',$stagesInfo['week_time']);
        $stagesInfo['week'] = 1;
        foreach($week as $k=>$v){
            if($nowTime >= explode(',',$v)[0] && $nowTime <= explode(',',$v)[1]){
                $stagesInfo['week'] = $k+1;
                $startTime = strtotime(explode(',',$v)[0]);
                $nowTimes  = strtotime($nowTime);
                $timeDiff  = $nowTimes-$startTime;
                $stagesInfo['days'] = intval($timeDiff/86400)+1;
            }
        }



        Tpl::output('stagesInfo',$stagesInfo);
        Tpl::output('isSignIn',$isSignIn);
        Tpl::output('orderInfo',$orderInfo);
        Tpl::output('pl_rcm',current($pl_rcm)['web_html']);
        Tpl::output('adv',current($adv)['web_html']);
        Tpl::output('user_hi',array_sum($user_hi));
        Tpl::output('likeGoods',$likeGoods);
        Tpl::output('member_info',$member_info);
        Tpl::output('article_lists',$article_lists);
        Tpl::output('getNextMiddleMonthDate',$getNextMiddleMonthDate);
        Tpl::output('total_hi_value',intval($user_hi_value_info['total_hi_value']));
        Tpl::output('webTitle',' - 个人中心');
        Tpl::showpage('member_home');
    }


    public function centerOp(){

        Tpl::showpage('member_center');
    }

    public function ajax_load_member_infoOp() {

        $member_info = $this->member_info;
        $member_info['security_level'] = Model('member')->getMemberSecurityLevel($member_info);

        //代金券数量
        $member_info['voucher_count'] = Model('voucher')->getCurrentAvailableVoucherCount($_SESSION['member_id']);
        Tpl::output('home_member_info',$member_info);

        Tpl::showpage('member_home.member_info','null_layout');
    }

    public function ajax_load_order_infoOp() {
        $model_order = Model('order');

        //交易提醒 - 显示数量
        $member_info['order_nopay_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'NewCount');
        $member_info['order_noreceipt_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'SendCount');
        $member_info['order_noeval_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'EvalCount');
        Tpl::output('home_member_info',$member_info);

        //交易提醒 - 显示订单列表
        $condition = array();
        $condition['buyer_id'] = $_SESSION['member_id'];
        $condition['order_state'] = array('in',array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS));
        $order_list = $model_order->getNormalOrderList($condition,'','*','order_id desc',3,array('order_goods'));

        foreach ($order_list as $order_id => $order) {
            //显示物流跟踪
            $order_list[$order_id]['if_deliver'] = $model_order->getOrderOperateState('deliver',$order);
            //显示评价
            $order_list[$order_id]['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order);
            //显示支付
            $order_list[$order_id]['if_payment'] = $model_order->getOrderOperateState('payment',$order);
            //显示收货
            $order_list[$order_id]['if_receive'] = $model_order->getOrderOperateState('receive',$order);
        }

        Tpl::output('order_list',$order_list);

        //取出购物车信息
        $model_cart = Model('cart');
        $cart_list  = $model_cart->listCart('db',array('buyer_id'=>$_SESSION['member_id']),3);
        Tpl::output('cart_list',$cart_list);
        Tpl::showpage('member_home.order_info','null_layout');
    }

    public function ajax_load_goods_infoOp() {
        //商品收藏
        $favorites_model = Model('favorites');
        $favorites_list = $favorites_model->getGoodsFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 7);
        if (!empty($favorites_list) && is_array($favorites_list)){
            $favorites_id = array();//收藏的商品编号
            foreach ($favorites_list as $key=>$fav){
                $favorites_id[] = $fav['fav_id'];
            }
            $goods_model = Model('goods');
            $field = 'goods_id,goods_name,store_id,goods_image,goods_promotion_price';
            $goods_list = $goods_model->getGoodsList(array('goods_id' => array('in', $favorites_id)), $field);
            Tpl::output('favorites_list',$goods_list);
        }

        //店铺收藏
        $favorites_list = $favorites_model->getStoreFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 6);
        if (!empty($favorites_list) && is_array($favorites_list)){
            $favorites_id = array();//收藏的店铺编号
            foreach ($favorites_list as $key=>$fav){
                $favorites_id[] = $fav['fav_id'];
            }
            $store_model = Model('store');
            $store_list = $store_model->getStoreList(array('store_id'=>array('in', $favorites_id)));
            Tpl::output('favorites_store_list',$store_list);
        }

        $goods_count_new = array();
        if (!empty($favorites_id)) {
            foreach ($favorites_id as $v){
                $count = Model('goods')->getGoodsCommonOnlineCount(array('store_id' => $v));
                $goods_count_new[$v] = $count;
            }
        }
        Tpl::output('goods_count',$goods_count_new);
        Tpl::showpage('member_home.goods_info','null_layout');
    }

    public function ajax_load_sns_infoOp() {
        //我的足迹
        $goods_list = Model('goods_browse')->getViewedGoodsList($_SESSION['member_id'],20);
        $viewed_goods = array();
        if(is_array($goods_list) && !empty($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $goods_id = $val['goods_id'];
                $val['url'] = urlShop('goods', 'index', array('goods_id' => $goods_id));
                $val['goods_image'] = cthumb($val['goods_image'], 240);
                $viewed_goods[$goods_id] = $val;
            }
        }
        Tpl::output('viewed_goods',$viewed_goods);

        //我的圈子
        $model = Model();
        $circlemember_array = $model->table('circle_member')->where(array('member_id'=>$_SESSION['member_id']))->select();
        if(!empty($circlemember_array)) {
            $circlemember_array = array_under_reset($circlemember_array, 'circle_id');
            $circleid_array = array_keys($circlemember_array);
            $circle_list = $model->table('circle')->where(array('circle_id'=>array('in', $circleid_array)))->limit(6)->select();
            Tpl::output('circle_list', $circle_list);
        }

        //好友动态
        $model_fd = Model('sns_friend');
        $fields = 'member.member_id,member.member_name,member.member_avatar';
        $follow_list = $model_fd->listFriend(array('limit'=>15,'friend_frommid'=>"{$_SESSION['member_id']}"),$fields,'','detail');
        $member_ids = array();$follow_list_new = array();
        if (is_array($follow_list)) {
            foreach ($follow_list as $v) {
                $follow_list_new[$v['member_id']] = $v;
                $member_ids[] = $v['member_id'];
            }
        }
        $tracelog_model = Model('sns_tracelog');
        //条件
        $condition = array();
        $condition['trace_memberid'] = array('in',$member_ids);
        $condition['trace_privacy'] = 0;
        $condition['trace_state'] = 0;
        $tracelist = Model()->table('sns_tracelog')->where($condition)->field('count(*) as ccount,trace_memberid')->group('trace_memberid')->limit(5)->select();
        $tracelist_new = array();$follow_list = array();
        if (!empty($tracelist)){
            foreach ($tracelist as $k=>$v){
                $tracelist_new[$v['trace_memberid']] = $v['ccount'];
                $follow_list[] = $follow_list_new[$v['trace_memberid']];
            }
        }
        Tpl::output('tracelist',$tracelist_new);
        Tpl::output('follow_list',$follow_list);
        Tpl::showpage('member_home.sns_info','null_layout');
    }
    public function developingOp(){
        Tpl::showpage('developing');
    }
}
