<?php
defined('ByCCYNet') or exit('Access Invalid!');

class ordersControl extends BaseJfControl
{


    public function indexOp()
    {

    }

    /**
     * 创建订单
     */
    public function createOrdersOp()
    {
        $rs = ['status' => -1, 'data' => '', 'msg' => '系统错误'];
        try {

            $userId    = $_SESSION['member_id'];
            $goodsId   = intval($_GET['goodsId']);
            $addressId = intval($_GET['addressId']);
            $number    = isset($_GET['number']) ? intval($_GET['number']) : 1;
            if (empty($userId)) {
                throw new Exception('请先登录');
            }
            if (empty($goodsId) || !isset($goodsId)) {
                throw new Exception('参数异常：ER20000');
            }
            if (empty($addressId)) {
                throw new Exception('请选择收货信息');
            }

            //获取积分商品信息
            $goodsModel = Model('jfgoods');
            $goodsInfo  = $goodsModel->where(['goods_id' => $goodsId])->find();
            if (empty($goodsInfo) || !is_array($goodsInfo)) {
                throw new Exception('参数异常：ER20001');
            }

            //查询用户积分是否足够


            //获取收货地址信息
            $addressModel = Model('address');
            $addressInfo  = $addressModel->where(['member_id' => $userId, 'address_id' => $addressId])->find();
            if (empty($addressInfo) || !is_array($addressInfo)) {
                throw new Exception('请选择收货信息');
            }


            //生成订单
            $orderModel                  = Model('integral_orders');
            $orderArray['orderNo']       = rand(100, 999) . time() . rand(100, 999);
            $orderArray['userId']        = $userId;
            $orderArray['address_name']  = $addressInfo['true_name'];
            $orderArray['address']       = $addressInfo['area_info'] . ' ' . $addressInfo['address'];
            $orderArray['address_phone'] = $addressInfo['mob_phone'];
            $orderArray['order_money']   = $goodsInfo['goods_price'] * $number;
            $orderArray['order_point']   = $goodsInfo['goods_integral'] * $number;
            $orderArray['order_hjb']     = $goodsInfo['goods_hjb'] * $number;
            $orderArray['create_time']   = date('Y-m-d H:i:s');

            $getOrderId = $orderModel->insert($orderArray);
            if ($getOrderId) {
                //向快照表插入数据
                $orderGoodsModel                = Model('integral_order_goods');
                $orderGoodsArray['orderId']     = $getOrderId;
                $orderGoodsArray['userId']      = $userId;
                $orderGoodsArray['goodsId']     = $goodsInfo['goods_id'];
                $orderGoodsArray['goods_name']  = $goodsInfo['goods_name'];
                $orderGoodsArray['goods_image'] = $goodsInfo['goods_image'];
                $orderGoodsArray['goods_price'] = $goodsInfo['goods_price'];
                $orderGoodsArray['goods_point'] = $goodsInfo['goods_integral'];
                $orderGoodsArray['goods_hjb']   = $goodsInfo['goods_hjb'];
                $orderGoodsArray['number']      = $number;
                $orderGoodsArray['create_time'] = date('Y-m-d H:i:s');
                $insertOrderGoodsInfo           = $orderGoodsModel->insert($orderGoodsArray);
                if ($insertOrderGoodsInfo) {
                    //返回订单信息
                    $data         = ['orderId' => $getOrderId, 'orderNo' => $orderArray['orderNo']];
                    $rs['status'] = 1;
                    $rs['data']   = $data;
                    $rs['msg']    = '生成订单成功';
                } else {
                    throw new Exception('参数异常：ER20002');
                }
            }
        } catch (Exception $e) {
            $rs['msg'] = $e->getMessage();
        }

        echo json_encode($rs);
    }


    /**
     * 订单支付页
     */
    public function orderPayOp()
    {
        $orderRemind = '请您在' . (ORDER_AUTO_CANCEL_TIME * 60) . '分钟内完成支付，逾期订单将自动取消。 ';
        Tpl::output('orderRemind', $orderRemind);


        $userId  = $_SESSION['member_id'];
        $orderId = intval($_GET['orderId']);

        if (empty($userId)) {
            redirect('/member/index.php?controller=login&action=index');
        }

        //获取订单信息
        $orderModel      = Model('integral_orders');
        $orderGoodsModel = Model('integral_order_goods');
        $orderInfo       = $orderModel->where(['userId' => $userId, 'id' => $orderId])->find();
        if (!empty($orderInfo)) {
            $orderInfo['goodsInfo'] = $orderGoodsModel->where(['orderId' => $orderInfo['id']])->find();
        }


        //显示支付接口列表
        $model_payment = Model('payment');
        $condition     = [];
        $payment_list  = $model_payment->getPaymentOpenList($condition);
        if (!empty($payment_list)) {
            unset($payment_list['predeposit']);
            unset($payment_list['offline']);
        }

        Tpl::output('payment_list', $payment_list);

        Tpl::output('orderInfo', $orderInfo);
        Tpl::output('webTitle', '海吉壹佰 - 订单支付');
        Tpl::showpage('order_pay');
    }


    /**
     * 订单余额支付
     */
    public function saveOrderInfoOp()
    {
        $rs      = ['status' => -1, 'data' => '', 'msg' => '异常错误'];
        $userId  = $_SESSION['member_id'];
        $orderId = intval($_POST['orderId']);
        try {
            Db::beginTransaction();

            $userModel       = Model('member');
            $goodsModel      = Model('jfgoods');
            $orderModel      = Model('integral_orders');
            $orderGoodsModel = Model('integral_order_goods');

            //获取订单信息
            $orderInfo      = $orderModel->where(['id' => $orderId, 'userId' => $userId])->find();
            $orderGoodsInfo = $orderGoodsModel->where(['orderId' => $orderInfo['id']])->find();
            if (empty($orderInfo)) {
                throw  new Exception('订单信息异常：ER 1000');
            }
            //判断订单是否支付
            if ($orderInfo['order_status'] == 0) {

                //获取用户账户信息
                $userInfo = $userModel->where(['member_id' => $userId])->field('member_id,available_predeposit,member_h_points,sign_in_money')->find();
                if (empty($userInfo)) {
                    throw new Exception('会员信息异常：ER 1001');
                }

                //判断会员 余额、积分、海吉币是否足够支付
                if ($userInfo['available_predeposit'] < $orderInfo['order_money']) { //会员可用余额
                    throw new Exception('您的余额不足以支付该订单');
                }

                if ($userInfo['member_h_points'] < $orderInfo['order_point']) {//会员积分 【非海豚主场积分】
                    throw new Exception('您的积分不足以支付该订单');
                }

                if ($userInfo['sign_in_money'] < $orderInfo['order_hjb']) {//海吉币
                    throw new Exception('您的海吉币不足以支付该订单');
                }

                //扣除会员对应的金额、积分、海吉币 并修改订单状态

                $memberArray['available_predeposit'] = $userInfo['available_predeposit'] - $orderInfo['order_money'];
                $memberArray['member_h_points']      = $userInfo['member_h_points'] - $orderInfo['order_point'];
                $memberArray['sign_in_money']        = $userInfo['sign_in_money'] - $orderInfo['order_hjb'];

                $saveUserInfo = $userModel->where(['member_id' => $userId])->update($memberArray);
                if ($saveUserInfo) {
                    //修改订单信息
                    $saveOrderArray['order_status'] = 1;
                    $saveOrderArray['pay_time']     = date('Y-m-d H::s');
                    $saveOrderInfo                  = $orderModel->where(['id' => $orderInfo['id']])->update($saveOrderArray);

                    //扣除商品库存、增加销量
                    $getGoodsInfo                    = $goodsModel->where(['goods_id' => $orderGoodsInfo['goodsId']])->field('goods_id,goods_salenum,goods_storage')->find();
                    $goodsInfoArray['goods_storage'] = $getGoodsInfo['goods_storage'] - $orderGoodsInfo['number'];
                    $goodsInfoArray['goods_salenum'] = $getGoodsInfo['goods_salenum'] + $orderGoodsInfo['number'];
                    $saveGoodsInfo                   = $goodsModel->where(['goods_id' => $orderGoodsInfo['goodsId']])->update($goodsInfoArray);

                    if ($saveOrderInfo && $saveGoodsInfo) {

                        //增加积分消费日志
                        if ($orderInfo['order_point'] > 0) {
                            $this->pointsLog($userId, $orderInfo['order_point'], '积分订单' . $orderInfo['orderNo'] . '非海豚主场购物消费');
                        }

                        //增加预存款消费日志
                        if ($orderInfo['order_money'] > 0) {
                            $this->pdLog($userId, $orderInfo['order_money'], '下单、支付预存款，积分订单号：' . $orderInfo['orderNo']);
                        }

                        //增加海吉币消费日志
                        if ($orderInfo['order_hjb'] > 0) {
                            $this->signLog($userInfo['member_id'], $orderInfo['order_hjb'], $orderInfo['orderNo']);
                        }

                        Db::commit();
                        $rs['status'] = 1;
                        $rs['msg']    = '订单支付成功';
                    } else {
                        throw new Exception('订单更新错误：ER 2003');
                    }
                } else {
                    throw new Exception('异常错误：ER 1100');
                }

            } else {
                throw new Exception('该订单已经支付过了！无需重复支付');
            }

        } catch (Exception $e) {
            Db::rollback();
            $rs['msg'] = $e->getMessage();
        }
        echo json_encode($rs);
    }


    /**
     * 支付宝支付
     */
    public function alipayOp()
    {
        $rs = ['status' => -1, 'data' => '', 'msg' => '支付异常'];
        try {
            $orderModel      = Model('integral_orders');
            $orderGoodsModel = Model('integral_order_goods');
            $userModel       = Model('member');
            $userId          = $_SESSION['member_id'];
            $orderId         = intval($_POST['orderId']);

            //获取订单信息
            $orderInfo = $orderModel->where(['id' => $orderId, 'userId' => $userId])->find();
            if (empty($orderInfo)) {
                throw  new Exception('订单信息异常：ER 1000');
            }

            //判断订单是否支付
            if ($orderInfo['order_status'] == 0) {

                //获取用户账户信息
                $userInfo = $userModel->where(['member_id' => $userId])->field('member_id,available_predeposit,member_h_points,sign_in_money')->find();
                if (empty($userInfo)) {
                    throw new Exception('会员信息异常：ER 1001');
                }

                //判断会员 积分、海吉币是否足够支付

                if ($userInfo['member_h_points'] < $orderInfo['order_point']) {//会员积分 【非海豚主场积分】
                    throw new Exception('您的积分不足以支付该订单');
                }

                if ($userInfo['sign_in_money'] < $orderInfo['order_hjb']) {//海吉币
                    throw new Exception('您的海吉币不足以支付该订单');
                }


                //获取商品名
                $orderInfo['goods_name'] = $orderGoodsModel->where(['orderId' => $orderInfo['id']])->field('goods_name')->find()['goods_name'];

                //获取支付宝配置信息
                $logic_payment = Logic('payment');
                $result        = $logic_payment->getPaymentInfo('alipay');
                $payment_info  = $result['data'];
                $pay           = new alipay($payment_info, $orderInfo);

                $rs['status'] = 1;
                $rs['data']   = $pay->get_payurl();
                $rs['msg']    = '获取成功';
            } else {
                throw new Exception('该订单已经支付过了！无需重复支付');
            }


        } catch (Exception $e) {
            $rs['msg'] = $e->getMessage();
        }

        echo json_encode($rs);
    }


    /**
     * 通知处理(支付宝异步通知)
     *
     */
    public function notifyOp()
    {
        $tradeStatus = $_POST['trade_status'];
        $orderNo     = $_POST['out_trade_no'];
        $model       = Model('integral_orders');
        $userModel   = Model('member');
        $orderInfo   = $model->where(['orderNo' => $orderNo])->find();

        if ($tradeStatus == 'TRADE_SUCCESS') {
            if ($orderInfo['status'] == 0) {
                //获取用户信息
                $userInfo = $userModel->where(['member_id' => $orderInfo['userId']])->field('member_id,available_predeposit,member_h_points,sign_in_money')->find();

                //扣除会员对应的积分、海吉币 并修改订单状态
                $memberArray['member_h_points'] = $userInfo['member_h_points'] - $orderInfo['order_point'];
                $memberArray['sign_in_money']   = $userInfo['sign_in_money'] - $orderInfo['order_hjb'];
                $saveUserInfo                   = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);
                if ($saveUserInfo) {
                    //修改订单信息
                    $saveOrderArray['order_status'] = 1;
                    $saveOrderArray['order_type']   = 1;
                    $saveOrderArray['pay_time']     = date('Y-m-d H::s');
                    $saveOrderInfo                  = $model->where(['id' => $orderInfo['id']])->update($saveOrderArray);

                    //增加积分消费日志
                    if ($orderInfo['order_point'] > 0) {
                        $this->pointsLog($userInfo['member_id'], $orderInfo['order_point'], '积分订单' . $orderInfo['orderNo'] . '非海豚主场购物消费');
                    }

                    //增加预存款消费日志
                    if ($orderInfo['order_money'] > 0) {
                        $this->pdLog($userInfo['member_id'], $orderInfo['order_money'], '下单、支付预存款，积分订单号：' . $orderInfo['orderNo']);
                    }

                    //增加海吉币消费日志
                    if ($orderInfo['order_hjb'] > 0) {
                        $this->signLog($userInfo['member_id'], $orderInfo['order_money'], $orderInfo['orderNo']);
                    }

                    if ($saveOrderInfo) {
                        exit('success');
                    }
                }
            }
        }

        exit('fail');
    }


    /**
     * 增加积分消费日志
     * @param $userId
     * @param $point
     * @param $desc
     */
    public function pointsLog($userId, $point, $desc)
    {
        $rs = false;
        if ($point > 0) {
            $model                 = Model('points_log');
            $data['pl_memberid']   = $userId;
            $data['pl_membername'] = $_SESSION['member_name'];
            $data['pl_points']     = '-' . $point;
            $data['pl_addtime']    = time();
            $data['pl_desc']       = $desc;
            $data['pl_stage']      = 'order_for_other';
            $add                   = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }

    /**
     * 增加预存款消费日志
     * @param $userId
     * @param $money
     * @param $desc
     */
    public function pdLog($userId, $money, $desc)
    {
        $rs = false;
        if ($money > 0) {
            $model                  = Model('pd_log');
            $data['lg_member_id']   = $userId;
            $data['lg_member_name'] = $_SESSION['member_name'];
            $data['lg_type']        = 'order_pay';
            $data['lg_av_amount']   = '-' . $money;
            $data['lg_add_time']    = time();
            $data['lg_desc']        = $desc;
            $add                    = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }

    /**
     * 增加海吉币消费日志
     * @param $userId
     * @param $number
     * @param $orderNo
     */
    public function signLog($userId, $number, $orderNo)
    {
        $rs = false;
        if ($number > 0) {
            $model                = Model('sign_in_log');
            $data['number']       = $number;
            $data['user_id']      = $userId;
            $data['source']       = '';
            $data['content']      = '兑换商品、使用海吉币 ' . $number . ' 个';
            $data['use_info']     = '兑换商品';
            $data['use_orderNo']  = $orderNo;
            $data['sign_in_time'] = date('Y-m-d- H:i:s');
            $add                  = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }


    /**
     * 检测支付密码是否正确
     */
    public function checkPayPassOp()
    {
        $rs              = ['status' => -1];
        $password        = htmlentities($_GET['password']);
        $userId          = $_SESSION['member_id'];
        $userModel       = Model('member');
        $userPayPassword = $userModel->where(['member_id' => $userId])->field('member_paypwd')->find();

        if ($userPayPassword['member_paypwd'] === md5($password)) {
            $rs['status'] = 1;
        }
        echo json_encode($rs);
    }

}
