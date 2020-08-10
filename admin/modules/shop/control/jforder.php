<?php
/**
 * 积分订单栏目管理       2018-07-06      LFP
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class jforderControl extends SystemControl{
    private $links = array(
       // array('url'=>'controller=jfgoods_online&action=goods','text'=>'所有商品'),
       // array('url'=>'controller=jfgoods_online&action=goods','text'=>'所有商品'),
        //array('url'=>'controller=jfgoods_online&action=lockup_list','text'=>'下架商品'),
        //array('url'=>'controller=jfgoods_online&action=waitverify_list','text'=>'等待审核'),

    );
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('goods');
    }

    public function indexOp() {
        $this->orderOp();
    }
    /**
     * 积分订单管理
     */
    public function orderOp() {
        //父类列表，只取到第二级
        $gc_list = Model('goods_class')->getGoodsClassList(array('gc_parent_id' => 0));
        Tpl::output('gc_list', $gc_list);

        Tpl::output('top_link',$this->sublink($this->links,'goods'));
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('jforder.index');
    }
    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_goods = Model('jforder');
        $condition = array();
        //$order = '';
        $param = array('goods_commonid', 'goods_name', 'goods_price', 'goods_state', 'goods_verify', 'goods_image', 'goods_jingle', 'gc_id'
                , 'gc_name', 'store_id', 'store_name', 'is_own_shop', 'brand_id', 'brand_name', 'goods_addtime', 'goods_marketprice', 'goods_costprice'
                , 'goods_freight', 'is_virtual', 'virtual_indate', 'virtual_invalid_refund', 'is_fcode'
                , 'is_presell', 'presell_deliverdate','is_select'
        );
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            //$order = $_POST['sortname'] . ' ' . $_POST['sortorder'];
        }
        $page = $_POST['rp'];

        $condition['order_status'] =  ['egt',0];

        $goods_list = $model_goods->getOoderList($condition, '*', $page);

        $data = array();
        $data['now_page'] = $model_goods->shownowpage();
        $data['total_num'] = $model_goods->gettotalnum();
        foreach ($goods_list as $value) {
            $param = array();
            $operation = '';
            //$operation .= "<a class='btn red' href='." . urlShop('goods', 'index', array('goods_id' => $storage_array[$value['goods_commonid']]['goods_id'])) . ".' onclick=\"fg_lonkup('" . $value['goods_commonid'] . "')\"><i class='fa fa-ban'></i>查看详情</a>";
            $operation .= '<a class="btn blue"  href="javascript:;" onclick="orderDetails('.$value['id'].')">查看订单详情</a>';
            $param['operation']     = $operation;
            $param['orderNo']       = $value['orderNo'];
            $param['order_money']   = $value['order_money'];
            $param['order_point']   = $value['order_point'];
            $param['order_hjb']     = $value['order_hjb'];
            switch ($value['order_status']){
                case '0':$statusText="<span style='color:red;'>未支付</span>"; break;
                case '1':$statusText="<span style='color:blue;'>已支付</span>"; break;
                default:$statusText='未支付';
            }
            $param['order_status']  = $statusText;
            $param['create_time']   = $value['create_time'];
            $param['pay_time']      = $value['pay_time'];
            $data['list'][] = $param;
        }

        echo Tpl::flexigridXML($data);exit();
    }



    //积分订单详情
    public function detalsOp(){
        $orderId = $_GET['order_id'];
        $orderModel = Model('integral_orders');
        $orderGoodsModel = Model('integral_order_goods');

        $orderInfo=$orderModel->where(['id'=>$orderId])->find();
        if(!empty($orderInfo)){
            $orderInfo['goodsInfo']=$orderGoodsModel->where(['orderId'=>$orderId])->find();
        }

        Tpl::output('orderInfo',$orderInfo);
        Tpl::setDirquna('shop');
        Tpl::showpage('jforder.detals','null_layout');
    }
}
