<?php
/**
 * 买家 我的实物订单
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class member_point_orderControl extends BaseMemberControl {

    public function __construct() {
        parent::__construct();
        Language::read('member_member_index');
        Tpl::output('current_active_name','member_point_order');
    }

    /**
     * 买家我的积分商城订单
     *
     */
    public function indexOp() {

        $orderModel = Model('integral_orders');
        $orderGoodsModel = Model('integral_order_goods');
        $userId  = $_SESSION['member_id'];

        //获取订单信息
        $orderInfo=$orderModel->where(['userId'=>$userId,'is_delete'=>0])->order('order_status asc,create_time desc')->page(10)->select();
        //获取订单商品信息
        if(!empty($orderInfo)){
            foreach($orderInfo as $k=>$v){
                $orderInfo[$k]['goodsInfo'] = $orderGoodsModel->where(['orderId'=>$v['id']])->find();
            }
        }
        Tpl::output('show_page',$orderModel->showpage());
        Tpl::output('orderInfo',$orderInfo);
        Tpl::output('webTitle',' - 我的积分订单');
        Tpl::showpage('member_point_order.index');
    }



    /**
     * 取消订单
     */
    public function closeOrderOp(){
        $rs =  array('status'=>-1,'data'=>'','msg'=>'取消失败!');
        $orderId  = isset($_POST['orderId'])?intval($_POST['orderId']):'';
        $userId   = $_SESSION['member_id'];
        $orderModel = Model('integral_orders');
        $orderGoodsModel = Model('integral_order_goods');
        Db::beginTransaction();
        try{
            if(empty($orderId) || $orderId<=0){
                throw new Exception('参数异常');
            }

            $getOrderInfo = $orderModel->where(['id'=>$orderId,'userId'=>$userId])->find();

            if(empty($getOrderInfo) || !is_array($getOrderInfo)){
                throw new Exception('获取订单数据异常!');
            }

            if($getOrderInfo['order_status'] != 0 ){
                throw new Exception('该订单状态发生改变、不能取消!');
            }else{
                //修改订单状态
                $saveOrderArray['order_status'] = -1;
                $saveOrderArray['is_delete']  = 1;
                $saveOrderInfo=$orderModel->where(['userId'=>$userId,'id'=>$orderId])->update($saveOrderArray);
                if($saveOrderInfo){
                    $rs['status']=1;
                    $rs['msg'] = '取消订单成功';
                    Db::commit();
                }else{
                    throw new Exception('取消订单数据异常、取消失败');
                }
            }


        }catch (Exception $e){
            Db::rollback();
            $rs['msg'] = $e->getMessage();
        }
        echo json_encode($rs);
    }




    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_key='') {
        Language::read('member_layout');
        $menu_array = array(
            array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_order_list'), 'menu_url'=>'index.php?controller=member_order'),
            array('menu_key'=>'member_order_recycle','menu_name'=>'回收站', 'menu_url'=>'index.php?controller=member_order&recycle=1'),
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
