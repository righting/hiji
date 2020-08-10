<?php
/**
 * 积分礼品购物车操作
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class pointcartControl extends BasePointShopControl {
    public function __construct() {
        parent::__construct();
        //读取语言包
        Language::read('home_pointcart');

        //判断系统是否开启积分和积分兑换功能
        if (C('pointprod_isuse') != 1){
            showDialog(L('pointcart_unavailable'),'index.php','error');
        }
        //验证是否登录
        if ($_SESSION['is_login'] != '1'){
            showDialog(L('pointcart_unlogin_error'),urlLogin('login'),'error');
        }
    }
    /**
     * 积分礼品购物车首页
     */
    public function indexOp() {
        $cart_goods = array();
        $model_pointcart = Model('pointcart');
        $data = $model_pointcart->getPCartListAndAmount(array('pmember_id'=>$_SESSION['member_id']));
        Tpl::output('pgoods_pointall',$data['data']['cartgoods_pointall']);
        Tpl::output('cart_array',$data['data']['cartgoods_list']);
        Tpl::showpage('pointcart_list');
    }

    /**
     * 购物车添加礼品
     */
    public function addOp() {
        $pgid   = intval($_GET['pgid']);
        $quantity   = intval($_GET['quantity']);
        if($pgid <= 0 || $quantity <= 0) {
            echo json_encode(array('done'=>false,'msg'=>L('pointcart_cart_addcart_fail'))); die;
        }

        //验证积分礼品是否存在购物车中
        $model_pointcart = Model('pointcart');
        $check_cart = $model_pointcart->getPointCartInfo(array('pgoods_id'=>$pgid,'pmember_id'=>$_SESSION['member_id']));
        if(!empty($check_cart)) {
            echo json_encode(array('done'=>true)); die;
        }
        //验证是否能兑换
        $data = $model_pointcart->checkExchange($pgid, $quantity, $_SESSION['member_id']);
        if (!$data['state']){
            switch ($data['error']){
                case 'ParameterError':
                    echo json_encode(array('done'=>false,'msg'=>$data['msg'],'url'=>'index.php?controller=pointprod&action=plist')); die;
                    break;
                default:
                    echo json_encode(array('done'=>false,'msg'=>$data['msg'])); die;
                    break;
            }
        }
        $prod_info = $data['data']['prod_info'];
        $model_platform = Model('platform_profit');
        $insert_arr = array();
        $insert_arr['pmember_id']       = $_SESSION['member_id'];
        $insert_arr['pgoods_id']        = $prod_info['pgoods_id'];
        $insert_arr['pgoods_name']      = $prod_info['pgoods_name'];
        $insert_arr['pgoods_points']    = $prod_info['pgoods_points'];
        $insert_arr['pgoods_choosenum'] = $prod_info['quantity'];
        $insert_arr['pgoods_image']     = $prod_info['pgoods_image_old'];
        $insert_arr['pgoods_shipping_fee']  =$model_platform::TYPE_INTEGRAL_FREIGHT;
        $insert_arr['pgoods_service_charge']  =$model_platform::TYPE_INTEGRAL_FEE;
        $cart_state = $model_pointcart->addPointCart($insert_arr);
        echo json_encode(array('done'=>true)); die;
    }

    /**
     * 积分礼品购物车更新礼品数量
     */
    public function updateOp() {
        $pcart_id   = intval($_GET['pc_id']);
        $quantity   = intval($_GET['quantity']);
        //兑换失败提示
        $msg = L('pointcart_cart_modcart_fail');
        //转码
        if (strtoupper(CHARSET) == 'GBK'){
            $msg = Language::getUTF8($msg);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        if($pcart_id <= 0 || $quantity <= 0) {
            echo json_encode(array('msg'=>$msg));
            die;
        }
        //验证礼品购物车信息是否存在
        $model_pointcart    = Model('pointcart');
        $cart_info  = $model_pointcart->getPointCartInfo(array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']));
        if (!$cart_info){
            echo json_encode(array('msg'=>$msg)); die;
        }

        //验证是否能兑换
        $data = $model_pointcart->checkExchange($cart_info['pgoods_id'], $quantity, $_SESSION['member_id']);
        if (!$data['state']){
            echo json_encode(array('msg'=>$data['msg'], 'pgoods_choosenum' => $cart_info['pgoods_choosenum'])); die;
        }
        $prod_info = $data['data']['prod_info'];
        $quantity = $prod_info['quantity'];

        $cart_state = true;
        //如果数量发生变化则更新礼品购物车内单个礼品数量
        if ($cart_info['pgoods_choosenum'] != $quantity){
            $cart_state = $model_pointcart->editPointCart(array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']),array('pgoods_choosenum'=>$quantity));
        }
        if ($cart_state) {
            //计算总金额
            $amount= $model_pointcart->getPointCartAmount($_SESSION['member_id']);
            echo json_encode(array('done'=>'true','subtotal'=>$prod_info['pointsamount'],'amount'=>$amount,'quantity'=>$quantity));
            die;
        }
    }

    /**
     * 积分礼品购物车删除单个礼品
     */
    public function dropOp() {
        $pcart_id   = intval($_GET['pc_id']);
        if($pcart_id <= 0) {
            echo json_encode(array('done'=>false,'msg'=>'删除失败')); die;
        }
        $model_pointcart = Model('pointcart');
        $drop_state = $model_pointcart->delPointCartById($pcart_id,$_SESSION['member_id']);
        if ($drop_state){
            echo json_encode(array('done'=>true)); die;
        } else {
            echo json_encode(array('done'=>false,'msg'=>'删除失败')); die;
        }
    }

    /**
     * 兑换订单流程第一步
     */
    public function step1Op(){
        //获取符合条件的兑换礼品和总积分
        $data = Model('pointcart')->getCartGoodsList($_SESSION['member_id']);
        if (!$data['state']){
            showDialog($data['msg'],'index.php?controller=pointprod','error');
        }
        Tpl::output('pointprod_arr',$data['data']);

        //实例化收货地址模型（不显示自提点地址）
        $address_list = Model('address')->getAddressList(array('member_id'=>$_SESSION['member_id'],'dlyp_id'=>0), 'is_default desc,address_id desc');

        //平台服务费与商品运费
        $model_platform = Model('platform_profit');

        $service_charge = array();//平台服务费
        $freight = array();//运费
        foreach ($data['data']['pointprod_list'] as $v){
            $service_charge[] = $v['pgoods_service_charge'];
            $freight[] = $v['pgoods_shipping_fee'];
        }
        $service_charge = max($service_charge);
        $freight =  max($freight);

        Tpl::output('service_charge',$service_charge);
        Tpl::output('freight',$freight);
        Tpl::output('address_list',$address_list);

        Tpl::showpage('pointcart_step1');
    }
    /**
     * 兑换订单流程第二步
     */
    public function step2Op() {
        $model_pointcart = Model('pointcart');
        //获取符合条件的兑换礼品和总积分
        $data = $model_pointcart->getCartGoodsList($_SESSION['member_id']);
        if (!$data['state']){
            showDialog($data['msg'],'index.php?controller=pointcart','error');
        }
        $pointprod_arr = $data['data'];

        unset($data);

        //验证积分数是否足够
        $data = $model_pointcart->checkPointEnough($pointprod_arr['pgoods_pointall'], $_SESSION['member_id']);
        if (!$data['state']){
            showDialog($data['msg'],'index.php?controller=pointcart','error');
        }
        unset($data);
        $service_charge = array();//平台服务费
        $freight = array();//运费
        foreach ($pointprod_arr['pointprod_list'] as $v){
            $service_charge[] = $v['pgoods_service_charge'];
            $freight[] = $v['pgoods_shipping_fee'];
        }
        $pointprod_arr['pgoods_shipping_fee'] = max($freight);
        $pointprod_arr['pgoods_service_charge'] = max($service_charge);
        $member_info = Model('member')->getMemberInfoByID($_SESSION['member_id']);
        //创建兑换订单
        $data = Model('pointorder')->createOrder($_POST, $pointprod_arr, $member_info);
        if (!$data['state']){
            showDialog($data['msg'],'index.php?controller=pointcart&action=step1','error');
        }
        $order_id = $data['data']['order_id'];
        $where = array();
        $where['point_orderid'] = $order_id;
        $order_info = Model('pointorder')->getPointOrderInfo($where);
        //@header("Location:index.php?controller=pointcart&action=step3&order_id=".$order_id);
        @header("Location:index.php?controller=pointcart&action=pay&pay_sn=".$order_info['point_ordersn']);
    }
    /**
     * 流程第三步
     */
    public function step3Op($order_arr=array()) {
        $order_id = intval($_GET['order_id']);
        if ($order_id <= 0){
            showDialog(L('pointcart_record_error'),'index.php','error');
        }
        $where = array();
        $where['point_orderid'] = $order_id;
        $where['point_buyerid'] = $_SESSION['member_id'];
        $order_info = Model('pointorder')->getPointOrderInfo($where);
        if (!$order_info){
            showDialog(L('pointcart_record_error'),'index.php','error');
        }
        Tpl::output('order_info',$order_info);
        Tpl::showpage('pointcart_step2');
    }
    /**
     * 支付运费与服务费
     */
    public  function payOp(){
        if (!empty($_POST)){

            $pay_sn = $_POST['pay_sn'];
            $payment_code = $_POST['payment_code'];
            $url = 'index.php?controller=member_order';

            if(!preg_match('/^\d{18}$/',$pay_sn)){
                showMessage('参数错误','','html','error');
            }

            //取订单列表

            $model_point = Model('pointorder');
            $param['point_ordersn']=$pay_sn;
            $param['point_orderstate']=20;
            $order_pay_info = $model_point->getPointOrderInfo($param); //积分兑换订单
            if (empty($order_pay_info)){
                showMessage('未找到需要支付的订单', $url, 'html', 'error');
            }
            $order_pay_info['order_type'] = "point_order"  ;//订单类型为积分订单
            $order_pay_info['subject'] = "积分订单";
            $order_pay_info['order_pay_amount']=round(floatval($order_pay_info['point_shipping_fee']+$order_pay_info['point_service_charge']),2);//支付金额
            $order_pay_info['pay_sn']=$order_pay_info['point_ordersn'];
            $order_pay_info['api_pay_amount']=round(floatval($order_pay_info['point_shipping_fee']+$order_pay_info['point_service_charge']),2);
            $logic_payment = Logic('payment');
            $result = $logic_payment->getPaymentInfo($payment_code);//获取支付方式
            if(!$result['state']) {
                showMessage($result['msg'], $url, 'html', 'error');
            }
            $payment_info = $result['data'];

            //转到第三方API支付
            $this->_api_pay($order_pay_info, $payment_info);

        }


        $pay_sn = $_GET['pay_sn'];
        $model = Model('pointorder');
        $order_list = $model->getPointOrderList(array('point_ordersn'=>$pay_sn,'point_orderstate'=>20));
        if (empty($order_list)){
            showMessage('未找到需要支付的订单','index.php?controller=pointprod&action=plist','html','error');
        }
        $pay_info=array();//支付信息
        $pay_info['pay_sn'] = $pay_sn;//支付订单号
        $pay_info['pay_amount_online'] = round(floatval($order_list['point_shipping_fee']+$order_list['point_service_charge']),2)  ;//在线支付金额

        Tpl::output('pay_info',$pay_info);//支付信息
        Tpl::output('order_list',$order_list);//订单信息
        //显示支付接口列表
        $model_payment = Model('payment');
        $condition = array();
        $condition['payment_code'] = array('not in',array('offline','predeposit','wxpay'));
        $condition['payment_state'] = 1;
        $payment_list = $model_payment->getPaymentList($condition);
        if (empty($payment_list)) {
            showMessage('暂未找到合适的支付方式',urlMember('predeposit'),'html','error');
        }
        Tpl::output('payment_list',$payment_list);

        Tpl::showpage('pointcart_pay');
    }
    /**
     * @TODO 3.第三方在线支付接口
     * 第三方在线支付接口
     *
     */
    private function _api_pay($order_info, $payment_info) {
        $payment_api = new $payment_info['payment_code']($payment_info,$order_info);
        if($payment_info['payment_code'] == 'chinabank') {
            // 网银
            $payment_api->submit();
        } elseif ($payment_info['payment_code'] == 'wxpay') {
            // 微信
            if (!extension_loaded('curl')) {
                showMessage('系统curl扩展未加载，请检查系统配置', '', 'html', 'error');
            }
            Tpl::setDir('buy');
            Tpl::setLayout('buy_layout');
            if (array_key_exists('order_list', $order_info)) {
                Tpl::output('order_list',$order_info['order_list']);
                Tpl::output('args','buyer_id='.$_SESSION['member_id'].'&pay_id='.$order_info['pay_id']);
            } else {
                Tpl::output('order_list',array($order_info));
                Tpl::output('args','buyer_id='.$_SESSION['member_id'].'&order_id='.$order_info['order_id']);
            }
            Tpl::output('api_pay_amount',$order_info['api_pay_amount']);
            Tpl::output('pay_url',base64_encode(encrypt($payment_api->get_payurl(),MD5_KEY)));
            Tpl::output('nav_list', rkcache('nav',true));
            Tpl::showpage('payment.wxpay');
        } else {
            // 其他支付方式
            @header("Location: ".$payment_api->get_payurl());
        }
        exit();
    }
}
