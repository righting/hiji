<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2019/3/4 10:26
// +----------------------------------------------------------------------

defined('ByCCYNet') or exit('Access Invalid!');

class crontabControl extends Control
{

    protected $member_info = [];// 会员信息

    public function indexOp()
    {
        //商品id|数量
        $cart_id = ['179|1|'];

        //登录
        $this->loginUser();

        //购买
        $buy_goods = $this->buyGoods($cart_id);

        $order_ids = [];
        foreach ($buy_goods['data']['order_list'] as $value) {
            $order_ids[] = $value['order_id'];
        }

        $order_id = $order_ids[0];
        $pay_sn   = $buy_goods['data']['pay_sn'];

        //支付
        $this->payGoods($pay_sn);

        //发货
        $this->sendGoods($order_id);

        //订单自动完成
        $this->orderAutoComplete();

        //订单自动解冻
        $this->orderAutoThaw();

        //注销登录
        session_unset();
        session_destroy();
    }

    /**
     * 获取购买用户信息
     * @param int $start_user_id
     * @param int $end_user_id
     * @return array
     * @throws Exception
     */
    private function loginUser($start_user_id = 2, $end_user_id = 3280)
    {
        $member_model = new memberModel();

        // 获得买家
        $buyer_id = $this->getUserId($start_user_id, $end_user_id, false);

        $buyer_info        = $member_model->getMemberInfoByID($buyer_id);
        $this->member_info = $this->getMemberAndGradeInfo(true);

        //登录
        $member_model->createSession($buyer_info);
        $this->log('用户：' . $_SESSION['member_name'] . ' 于' . date('Y-m-d H:i:s', TIMESTAMP) . '登录成功');
        return $buyer_info;
    }

    /**
     * 购买商品
     *
     * @param $cart_id
     * @return array
     */
    private function buyGoods(array $cart_id = [])
    {
        $buy_logic = new buyLogic();

        //购买第一步 获取商品基础信息
        $buy_one = $buy_logic->buyStep1($cart_id, '', $_SESSION['member_id'], $_SESSION['seller_session_info']['store_id'], '', $this->member_info['orderdiscount'], $this->member_info['level'], '');

        //购买第二步 生成订单
        $data = $buy_logic->changeAddr($buy_one['data']['freight_list'], $buy_one['data']['address_info']['city_id'], $buy_one['data']['address_info']['area_id'], $_SESSION['member_id']);

        $post = [
            'cart_id'           => $cart_id,
            'goods_id'          => $cart_id,
            'pay_name'          => 'online',
            'address_id'        => $buy_one['data']['address_info']['address_id'],
            'buy_city_id'       => $buy_one['data']['address_info']['city_id'],
            'allow_offpay'      => '0',
            'offpay_hash'       => $data['offpay_hash'],
            'offpay_hash_batch' => $data['allow_offpay_batch'],
        ];

        $result = $buy_logic->buyStep2($post, $_SESSION['member_id'], $_SESSION['member_name'], $_SESSION['member_email'], 0, $buy_one['level_id']);
        
        $this->log('用户：' . $_SESSION['member_name'] . ' 于' . date('Y-m-d H:i:s', TIMESTAMP) . '购买商品成功');
        return $result;
    }

    /**
     * 支付商品
     *
     * @param $pay_sn
     */
    private function payGoods($pay_sn)
    {
        $order_logic   = new orderLogic();
        $payment_logic = new paymentLogic();

        $order_pay_info = $payment_logic->getRealOrderInfo($pay_sn, $_SESSION['member_id']);

        //站内余额支付
        $order_list = $this->pdPay($order_pay_info['data']['order_list']);

        //计算本次需要在线支付（分别是含站内支付、纯第三方支付接口支付）的订单总金额
        $pay_amount        = 0;
        $api_pay_amount    = 0;
        $pay_order_id_list = [];
        if (!empty($order_list)) {
            foreach ($order_list as $order_info) {
                if ($order_info['order_state'] == ORDER_STATE_NEW) {
                    $api_pay_amount      += $order_info['order_amount'] - $order_info['pd_amount'] - $order_info['rcb_amount'];
                    $pay_order_id_list[] = $order_info['order_id'];
                }
                $pay_amount += $order_info['order_amount'];
            }
        }

        if (empty($api_pay_amount)) {
            foreach ($order_list as $order_info) {
                $order_logic->splitOrderGoodsLists($order_info);// 分红
            }
        }
        $this->log('用户：' . $_SESSION['member_name'] . ' 于' . date('Y-m-d H:i:s', TIMESTAMP) . '支付成功');
    }

    /**
     * 站内余额支付(充值卡、预存款支付) 实物订单
     *
     * @param array $order_list
     * @return array|mixed
     */
    private function pdPay($order_list)
    {
        $model_member = new memberModel();
        $buyer_info   = $model_member->getMemberInfoByID($_SESSION['member_id']);
        try {
            $model_member->beginTransaction();
            $buy_1_logic = new buy_1Logic();
            //使用预存款支付
            $order_list = $buy_1_logic->pdPay($order_list, [], $buyer_info);
            //特殊订单站内支付处理
            $buy_1_logic->extendInPay($order_list);
            $model_member->commit();
        } catch (Exception $e) {
            $model_member->rollback();
            $this->log('支付失败');
        }
        return $order_list;
    }

    /**
     * 发货
     *
     * @param $order_id
     */
    private function sendGoods($order_id)
    {
        $condition['order_id'] = $order_id;
        $condition['store_id'] = 5;

        $order_model = new orderModel();
        $order_info  = $order_model->getOrderInfo($condition, ['order_common', 'order_goods']);

        $deliver_post = [
            'ref_url'             => '',
            'form_submit'         => 'ok',
            'shipping_express_id' => $order_info['extend_order_common']['shipping_express_id'],
            'reciver_name'        => $order_info['extend_order_common']['reciver_name'],
            'reciver_area'        => $order_info['extend_order_common']['reciver_info']['area'],
            'reciver_street'      => $order_info['extend_order_common']['reciver_info']['street'],
            'reciver_mob_phone'   => $order_info['extend_order_common']['reciver_info']['mob_phone'],
            'reciver_tel_phone'   => $order_info['extend_order_common']['reciver_info']['tel_phone'],
            'reciver_dlyp'        => $order_info['extend_order_common']['reciver_info']['dlyp'],
            'daddress_id'         => $order_info['daddress_info']['address_id'],
            'shipping_code'       => ''
        ];

        $deliver_post['reciver_info'] = $this->getReciverInfo($deliver_post);

        $order_logic = new orderLogic();
        $order_logic->changeOrderSend($order_info, 'seller', 5, $deliver_post);
        $this->log('商家于' . date('Y-m-d H:i:s', TIMESTAMP) . '发货');
    }

    /**
     * 组合reciver_info
     *
     * @param array $post
     * @return string
     */
    private function getReciverInfo(array $post = [])
    {
        $reciver_info = [
            'address'   => $post['reciver_area'] . ' ' . $post['reciver_street'],
            'phone'     => trim($post['reciver_mob_phone'] . ',' . $post['reciver_tel_phone'], ','),
            'area'      => $post['reciver_area'],
            'street'    => $post['reciver_street'],
            'mob_phone' => $post['reciver_mob_phone'],
            'tel_phone' => $post['reciver_tel_phone'],
            'dlyp'      => $post['reciver_dlyp']
        ];
        return serialize($reciver_info);
    }

    /**
     * 订单自动完成
     */
    private function orderAutoComplete()
    {
        //实物订单发货后，超期自动收货完成
        $_break                   = false;
        $model_order              = new orderModel();
        $logic_order              = new orderLogic();
        $condition                = [];
        $condition['order_state'] = ORDER_STATE_SEND;
        $condition['lock_state']  = 0;
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) break;
            $order_list = $model_order->getOrderList($condition, '', '*', 'delay_time asc', 100);
            if (empty($order_list)) break;

            foreach ($order_list as $k => $order_info) {
                $result = $logic_order->changeOrderStateReceive($order_info, 'system', '系统', '超期未收货系统自动完成订单');
                if (!$result['state']) {
                    $this->log('实物订单超期未收货自动完成订单失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }

        }
    }

    /**
     * 订单自动解冻
     */
    private function orderAutoThaw()
    {
        //实物订单发货后，超期自动收货完成
        $_break                   = false;
        $model_order              = new orderModel();
        $logic_order              = new orderLogic();
        $condition                = [];
        $condition['order_state'] = 40;
        $condition['lock_state']  = 0;
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) break;
            $order_list = $model_order->getOrderList($condition, '', '*', 'finnshed_time asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $field                             = '*';
                $order_goods_condition['order_id'] = $order_info['order_id'];
                $order_goods_condition['buyer_id'] = $order_info['buyer_id'];
                $order_goods_list                  = $model_order->getOrderGoodsList($order_goods_condition, $field);
                $logic_order->getStoreUserAmountOfMoney($order_goods_list, $order_info);
                $result = $logic_order->changeOrderStateThaw($order_info, 'system', '系统', '超期未解冻系统自动解冻订单');
                if (!$result['state']) {
                    $this->log('实物订单超期未收货自动完成订单失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }
    }

    /**
     * 获取买家id
     *
     * @param int  $start_user_id 开始id
     * @param int  $end_user_id   结束id
     * @param bool $order         是否顺序购买 true=顺序，false=随机
     * @return array|mixed
     * @throws Exception
     */
    private function getUserId($start_user_id = 2, $end_user_id = 3280, $order = true)
    {
        $member_model = new memberModel();
        if ($order) {
            $order_model = new orderModel();
            //获取最新一位购买成功的用户id
            $condition['order_state'] = ['gt', 10];
            $last_buyer               = $order_model->table('orders')->where($condition)->field('order_id,buyer_id')->order('order_id desc')->find();

            //得到购买者id
            $buyer_id = $last_buyer ? ($last_buyer['buyer_id'] >= $end_user_id ? $start_user_id : $last_buyer['buyer_id'] + 1) : $start_user_id;

            //检验购买者id
            $is_buyer = $member_model->table('member')->where(['member_id' => $buyer_id])->field('member_id')->find();
            if (empty($is_buyer)) {
                $condition              = [];
                $condition['member_id'] = ['gt', $buyer_id];
                $buyer                  = $member_model->table('member')->where($condition)->field('member_id')->order('member_id asc')->find();
                $buyer_id               = $buyer['member_id'];
            }
        } else {
            $auto_order_user_array = rkcache('auto_order_users');
            if (empty($auto_order_user_array)) {
                for ($i = $start_user_id; $i <= $end_user_id; $i++) {
                    $auto_order_user_array[] = $i;
                }
                wkcache('auto_order_users', $auto_order_user_array);
            }

            shuffle($auto_order_user_array);// 打乱数组
            $buyer_id = array_slice($auto_order_user_array, 0, 1);// 抽取数据
        }

        //检验购买者id
        $is_buyer = $member_model->table('member')->where(['member_id' => $buyer_id])->field('member_id')->find();
        if (empty($is_buyer)) {
            $this->getUserId($start_user_id, $end_user_id, false);
        }
        return $buyer_id;
    }

    /**
     * 记录日志
     *
     * @param string  $content 日志内容
     * @param boolean $if_sql  是否记录SQL
     */
    private function log($content, $if_sql = true)
    {
        if ($if_sql) {
            $log = Log::read();
            if (!empty($log) && is_array($log)) {
                $content .= end($log);
            }
        }
        Log::record('queue\\' . $content);
    }

}