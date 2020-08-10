<?php
/**
 * 任务计划 - 天执行的任务
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class dateControl extends BaseCronControl
{

    /**
     * 该文件中所有任务执行频率，默认1天，单位：秒
     *
     * @var int
     */
    const EXE_TIMES = 86400;

    /**
     * 优惠券即将到期提醒时间，单位：天
     *
     * @var int
     */
    const VOUCHER_INTERVAL = 5;

    /**
     * 兑换码即将到期提醒时间，单位：天
     *
     * @var int
     */
    const VR_CODE_INTERVAL = 5;

    /**
     * 订单结束后可评论时间，15天，60*60*24*15
     *
     * @var int
     */
    const ORDER_EVALUATE_TIME = 1296000;

    /**
     * 订单结束后可追加评价时间，182.5， 60*60*24*182.5
     */
    const ORDER_EVALUATE_AGAIN_TIME = 15768000;

    /**
     * 每次到货通知消息数量
     *
     * @var int
     */
    const ARRIVAL_NOTICE_NUM = 100;

    private $_model_store;
    private $_model_store_ext;
    private $_model_bill;
    private $_model_order;
    private $_model_store_cost;
    private $_model_vr_bill;
    private $_model_vr_order;

    public function jimOp()
    {
        $field_array         = [
            'type_sales_day_bonus_money',
            'type_selling_star_day_bonus_money',
            'type_share_day_bonus_for_new_money',
            'type_share_day_bonus_for_old_money',
            'type_middle_management_bonus_weekly_money',
            'type_black_diamond_sales_bonus_money',
            'type_elite_monthly_bonus_money',
            'type_top_selling_monthly_bonus_money',
            'type_new_sales_award_money',
            'type_share_day_bonus_money',
            'type_sales_management_week_bonus_money',
            'type_supplier_referral_bonus_money',
            'type_sales_share_bonus_money',
            'type_sales_share_bonus_for_team_money',
            'type_sales_share_bonus_for_seller_money',
            'type_consumption_capital_subsidy_consumption_pension_money',
            'type_consumption_capital_subsidy_garages_dream_money',
            'USER_CONSUMPTION_BONUS_RATIO',
            'PLATFORM_TAX_RATE',
            'annual_fee_gc_id'
        ];

        $setting_model                 = new settingModel();
        $set_field_arr                 = $setting_model->where(['name' => ['in', $field_array]])->select();
        $set_field_arr_for_name        = array_combine(array_column($set_field_arr, 'name'), array_column($set_field_arr, 'value'));
        dump($set_field_arr_for_name);
    }

    /**
     * 默认方法
     */
    public function indexOp()
    {
        set_time_limit(0);
        $a = microtime(true);
        p($a);

        /**
         * 创建分红分期数据以及更新分红分期数据
         */
        $this->_edit_stages();
        $stages_log = microtime(true);
        p($stages_log);

//        // 分红日统计
//        $this->_dividend_day_statistics();
//        $b = microtime(true);
//        p($b);
//
//        // 日分红
//        $this->_daily_dividend();
//        $c = microtime(true);
//        p($c);
//        p(date('Y-m-d H:i:s') . '天计划任务执行成功');

        //订单超期后不允许评价
        $this->_order_eval_expire_update();
        $d = microtime(true);
        p($d);

        //订单超期后不允许追加评价
        $this->_order_eval_again_expire_update();
        $e = microtime(true);
        p($e);

        // 预定订单及时支付尾款提醒
        $this->_order_book_end_pay_notice();
        $f = microtime(true);
        p($f);

        //订单自动完成
        $this->_order_auto_complete();
        $g = microtime(true);
        p($g);

        //订单自动解冻
        $this->_order_auto_thaw();
        $g = microtime(true);
        p($g);

        //预定订单超时未付尾款取消订单
        $this->_order_book_timeout_cancel();
        $h = microtime(true);
        p($h);

        //更新订单扩展表收货人所在省份ID
        $this->_order_reciver_provinceid_update();
        $i = microtime(true);
        p($i);

        //更新退款申请超时处理
        Model('trade')->editRefundConfirm();
        $j = microtime(true);
        p($j);

        //更新商品访问量
        $this->_goods_click_update();
        $k = microtime(true);
        p($k);

        //商品到货通知提醒
        $this->_arrival_notice();
        $l = microtime(true);
        p($l);

        //缓存订单及订单商品相关数据
        $this->_order_goods_cache();
        $m = microtime(true);
        p($m);

        //会员相关数据统计
        $this->_member_stat();
        $n = microtime(true);
        p($n);

        //取消无货后门店商品的标记
        $this->_delivery_goods_sign_update();
        $o = microtime(true);
        p('$o' . $o);

        //生成结算
        $this->_create_bill();
        $p = microtime(true);
        p('$p' . $p);

        //个人销售额获取贡献值
        $this->_userSalesGainC();

        //每日分红自动转入到HI值
        $this->_bonusAutoToHi();

        //检测微商截止日期
        $this->_checkMemberDistributionState();
    }

    // 分红日统计
    public function _dividend_day_statistics()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->statisticsSalesShareBonusForTeam();// 统计消费共享分红，已加最高分红金额限制 2019-6-11
        $user_bonus_logic->newPersonalBonus();// 销售新人分红，已加最高分红金额限制 2019-6-11
    }

    // 日分红
    public function _daily_dividend()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->addMoneyFromMoneyPool();// 将奖金池中今天要转给用户的钱转给指定用户
        $user_bonus_logic->salesShareBonusForTeam();// 消费共享分红，已加最高分红金额限制 2019-6-11
        $user_bonus_logic->salesDayBonus();// 开始销售日分红，已加最高分红金额限制 2019-6-11
        $user_bonus_logic->sellingStarDayBonus();// 开始销售明星日分红，已加最高分红金额限制 2019-6-11
        $user_bonus_logic->shareDayBonus();// 共享日分红，已加最高分红金额限制 2019-6-11
        $user_bonus_logic->newPersonalBonus();// 销售新人分红，已加最高分红金额限制 2019-6-11

        // 每月十五号才分红的奖项 移动到当前目录下的 monthFifteen.php
        /*$user_bonus_logic->blackDiamondSalesBonus();
        $user_bonus_logic->eliteMonthlyBonus();
        $user_bonus_logic->topSellingMonthlyBonus();*/
    }

    /**
     * 预定订单及时支付尾款提醒
     */
    private function _order_book_end_pay_notice()
    {
        $model_order                  = Model('order');
        $model_order_book             = Model('order_book');
        $logic_order_book             = Logic('order_book');
        $condition                    = [];
        $condition['book_step']       = 2;
        $condition['book_pay_time']   = 0;
        $condition['book_pay_notice'] = 0;
        $condition['book_end_time']   = ['lt', TIMESTAMP + BOOK_AUTO_END_TIME * 3600];
        //最多处理1000个订单
        $order_book_list = $model_order_book->getOrderBookList($condition, '', '', '*', 1000);
        if (empty($order_book_list)) return;
        foreach ($order_book_list as $order_book_info) {
            $mobile                     = $order_book_info['book_buyer_phone'];
            $condition                  = [];
            $condition['book_step']     = 1;
            $condition['book_order_id'] = $order_book_info['book_order_id'];
            $order_book_info            = $model_order_book->getOrderBookInfo($condition);

            //如果已经支付，发送通知
            if (!empty($order_book_info['book_pay_time'])) {
                $order_info = $model_order->getOrderInfo(['order_id' => $order_book_info['book_order_id']], [], 'order_sn,buyer_id');
                // 发送买家消息
                $param              = [];
                $param['code']      = 'order_book_end_pay';
                $param['member_id'] = $order_info['buyer_id'];
                $param['number']    = ['mobile' => $mobile];
                $param['param']     = [
                    'order_sn'  => $order_info['order_sn'],
                    'order_url' => urlShop('member_order', 'index')
                ];
                QueueClient::push('sendMemberMsg', $param);
            }
            //更新通知状态
            $condition                  = [];
            $condition['book_step']     = 2;
            $condition['book_order_id'] = $order_book_info['book_order_id'];
            $update                     = $model_order_book->editOrderBook(['book_pay_notice' => 1], $condition);
            if (!$update) {
                $this->log('更新预定订单尾款支付提醒状态失败order_id:' . $order_book_info['book_order_id']);
                break;
            }
        }
    }

    /**
     * 预定订单超时未付尾款取消订单
     */
    private function _order_book_timeout_cancel()
    {
        $model_order                = Model('order');
        $model_order_book           = Model('order_book');
        $logic_order_book           = Logic('order_book');
        $condition                  = [];
        $condition['book_step']     = 2;
        $condition['book_pay_time'] = 0;
        $condition['book_end_time'] = ['lt', TIMESTAMP];
        //最多处理1000个订单
        $order_book_list = $model_order_book->getOrderBookList($condition, '', '', '*', 1000);
        if (empty($order_book_list)) return;
        foreach ($order_book_list as $order_book_info) {
            $condition                     = [];
            $condition['book_step']        = 1;
            $condition['book_order_id']    = $order_book_info['book_order_id'];
            $condition['book_cancel_time'] = 0;
            $order_book_info               = $model_order_book->getOrderBookInfo($condition);

            //如果已经支付定金
            if (!empty($order_book_info['book_pay_time'])) {
                //取消订单
                $order_info = $model_order->getOrderInfo(['order_id' => $order_book_info['book_order_id']]);
                $result     = $logic_order_book->changeOrderStateCancel($order_info, 'system', '系统', '超期未支付尾款系统自动关闭订单');
                if (!$result['state']) {
                    $this->log('预定订单超期未支付尾款关闭失败order_id:' . $order_book_info['book_order_id']);
                    break;
                }
            }
        }
    }

    /**
     * 订单自动完成
     */
    private function _order_auto_complete()
    {

        //虚拟订单过使用期自动完成
        $_break                   = false;
        $model_order              = Model('vr_order');
        $logic_order              = Logic('vr_order');
        $condition                = [];
        $condition['order_state'] = ORDER_STATE_PAY;
        $condition['vr_indate']   = ['lt', TIMESTAMP];
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', 'order_id,order_sn', 'vr_indate asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateSuccess($order_info['order_id']);
                if (!$result['state']) {
                    $this->log('虚拟订单过使用期自动完成失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }


        $setModel     = Model('setting');
        $list_setting = $setModel->getListSetting();
        //实物订单发货后，超期自动收货完成
        $_break                   = false;
        $model_order              = Model('order');
        $logic_order              = Logic('order');
        $condition                = [];
        $condition['order_state'] = ORDER_STATE_SEND;
        $condition['lock_state']  = 0;
        $condition['delay_time']  = ['lt', TIMESTAMP - ($list_setting['order_time'] * 86400)];
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', 'delay_time asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $k => $order_info) {
                $timeDelays = $list_setting['order_time'] + $order_info['delays_time']; //系统订单自动收货时间+订单延迟时间
                if (TIMESTAMP >= $order_info['delay_time'] + ($timeDelays * 86400)) {  //当前时间 》= (订单发货时间+系统自动收货时间+订单延迟时间)
                    $result = $logic_order->changeOrderStateReceive($order_info, 'system', '系统', '超期未收货系统自动完成订单');
                    if (!$result['state']) {
                        $this->log('实物订单超期未收货自动完成订单失败SN:' . $order_info['order_sn']);
                        $_break = true;
                        break;
                    }
                } else {
                    unset($order_info);
                }
            }
        }
    }

    /**
     * 订单自动解冻
     */
    private function _order_auto_thaw()
    {
        $setModel     = Model('setting');
        $list_setting = $setModel->getListSetting();
        //实物订单发货后，超期自动收货完成
        $_break                     = false;
        $model_order                = Model('order');
        $logic_order                = Logic('order');
        $condition                  = [];
        $condition['order_state']   = 40;
        $condition['lock_state']    = 0;
        $condition['finnshed_time'] = ['lt', TIMESTAMP - ($list_setting['order_thaw_time'] * 86400)];
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', 'finnshed_time asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {

                /**@since 执行分红  2018/06/22 修改为订单解冻后才执行分红 */
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
     * 自提订单中，已经关闭订单的，删除
     */
    private function _order_delivery_cancel_del()
    {
        $model_delivery = Model('delivery_order');
        $model_order    = Model('order');

        for ($i = 0; $i < 10; $i++) {
            $delivery_list = $model_delivery->getDeliveryOrderDefaultList([], '*', 0, 'order_id asc', 100);
            if (!empty($delivery_list)) {
                $order_ids = [];
                foreach ($delivery_list as $k => $v) {
                    $order_ids[] = $v['order_id'];
                }
                $condition                = [];
                $condition['order_state'] = ORDER_STATE_CANCEL;
                $condition['order_id']    = ['in', $order_ids];
                $order_list               = $model_order->getOrderList($condition, '', 'order_id');
                if (!empty($order_list)) {
                    $order_ids = [];
                    foreach ($order_list as $k => $v) {
                        $order_ids[] = $v['order_id'];
                    }
                    $del = $model_delivery->delDeliveryOrder(['order_id' => ['in', $order_ids]]);
                    if (!$del) {
                        $this->log('删除自提点订单失败');
                    }
                } else {
                    break;
                }
            } else {
                break;
            }
        }
    }

    /**
     * 更新订单扩展表中收货人所在省份ID
     */
    private function _order_reciver_provinceid_update()
    {
        $model_order = Model('order');
        $model_area  = Model('area');

        //每次最多处理5W个订单
        $condition                        = [];
        $condition['reciver_province_id'] = 0;
        $condition['reciver_city_id']     = ['neq', 0];
        for ($i = 0; $i < 500; $i++) {
            $order_list = $model_order->getOrderCommonList($condition, 'reciver_city_id', 'order_id desc', 100);
            if (!empty($order_list)) {
                $city_ids = [];
                foreach ($order_list as $v) {
                    if (!in_array($v['reciver_city_id'], $city_ids)) {
                        $city_ids[] = $v['reciver_city_id'];
                    }
                }
                $area_list = $model_area->getAreaList(['area_id' => ['in', $city_ids]], 'area_parent_id,area_id');
                if (!empty($area_list)) {
                    foreach ($area_list as $v) {
                        $update = $model_order->editOrderCommon(['reciver_province_id' => $v['area_parent_id']], ['reciver_city_id' => $v['area_id']]);
                        if (!$update) {
                            $this->log('更新订单扩展表中收货人所在省份ID失败');
                            break;
                        }
                    }
                }
            } else {
                break;
            }
        }
    }

    /**
     * 增加会员积分和经验值
     */
    private function _add_points()
    {
        return;
        $model_points    = Model('points');
        $model_exppoints = Model('exppoints');

        //24小时之内登录的会员送积分和经验值,每次最多处理5W个会员
        $model_member                   = Model('member');
        $condition                      = [];
        $condition['member_login_time'] = ['gt', TIMESTAMP - self::EXE_TIMES];
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $member_list = $model_member->getMemberList($condition, 'member_name,member_id', 0, '', "{$i},100");
            if (!empty($member_list)) {
                foreach ($member_list as $member_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('login', ['pl_memberid' => $member_info['member_id'], 'pl_membername' => $member_info['member_name']], true);
                    }
                    $model_exppoints->saveExppointsLog('login', ['exp_memberid' => $member_info['member_id'], 'exp_membername' => $member_info['member_name']], true);

                }
            } else {
                break;
            }
        }

        //24小时之内注册的会员送积分,每次最多处理5W个会员
        if (C('points_isuse')) {
            $condition                = [];
            $condition['member_time'] = ['gt', TIMESTAMP - self::EXE_TIMES];
            for ($i = 0; $i < 50000; $i = $i + 100) {
                $member_list = $model_member->getMemberList($condition, 'member_name,member_id', 0, 'member_id desc', "{$i},100");
                if (!empty($member_list)) {
                    foreach ($member_list as $member_info) {
                        $model_points->savePointsLog('regist', ['pl_memberid' => $member_info['member_id'], 'pl_membername' => $member_info['member_name']], true);
                    }
                } else {
                    break;
                }
            }
        }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $model_order                = Model('order');
        $condition                  = [];
        $condition['finnshed_time'] = ['gt', TIMESTAMP - self::EXE_TIMES];
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $order_list = $model_order->getOrderList($condition, '', 'buyer_name,buyer_id,order_amount,order_sn,order_id', '', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('order', ['pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']], true);
                    }
                    $model_exppoints->saveExppointsLog('order', ['exp_memberid' => $order_info['buyer_id'], 'exp_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']], true);
                }
            } else {
                break;
            }
        }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $model_order                = Model('vr_order');
        $condition                  = [];
        $condition['finnshed_time'] = ['gt', TIMESTAMP - self::EXE_TIMES];
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $order_list = $model_order->getOrderList($condition, '', 'buyer_name,buyer_id,order_amount,order_sn,order_id', '', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('order', ['pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']], true);
                    }
                    $model_exppoints->saveExppointsLog('order', ['exp_memberid' => $order_info['buyer_id'], 'exp_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']], true);
                }
            } else {
                break;
            }
        }
    }

    /**
     * 代金券即将过期提醒
     */
    private function _voucher_will_expire()
    {
        $time_start                = mktime(0, 0, 0, date("m"), date("d") + self::VOUCHER_INTERVAL, date("Y"));
        $time_stop                 = $time_start + self::EXE_TIMES - 1;
        $where                     = [];
        $where['voucher_end_date'] = [['egt', $time_start], ['elt', $time_stop], 'and'];
        $list                      = Model('voucher')->getVoucherUnusedList($where);
        if (!empty($list)) {
            foreach ($list as $val) {
                $param              = [];
                $param['code']      = 'voucher_will_expire';
                $param['member_id'] = $val['voucher_owner_id'];
                $param['param']     = [
                    'indate'      => date('Y-m-d H:i:s', $val['voucher_end_date']),
                    'voucher_url' => urlMember('member_voucher', 'index')
                ];
                QueueClient::push('sendMemberMsg', $param);
            }
        }
    }

    /**
     * 虚拟兑换码即将过期提醒
     */
    private function _vr_code_will_expire()
    {
        $time_start         = mktime(0, 0, 0, date("m"), date("d") + self::VR_CODE_INTERVAL, date("Y"));
        $time_stop          = $time_start + self::EXE_TIMES - 1;
        $where              = [];
        $where['vr_indate'] = [['egt', $time_start], ['elt', $time_stop], 'and'];
        $list               = Model('vr_order')->getCodeUnusedList($where, 'order_id,min(buyer_id) as buyer_id,min(rec_id) as rec_id,min(vr_indate) as vr_indate');
        if (!empty($list)) {
            foreach ($list as $val) {
                $param              = [];
                $param['code']      = 'vr_code_will_expire';
                $param['member_id'] = $val['buyer_id'];
                $param['param']     = [
                    'indate'       => date('Y-m-d H:i:s', $val['vr_indate']),
                    'vr_order_url' => urlShop('member_vr_order', 'index')
                ];
                QueueClient::push('sendMemberMsg', $param);
            }
        }
    }

    /**
     * 订单超期后不允许评价
     */
    private function _order_eval_expire_update()
    {

        //实物订单超期未评价自动更新状态，每次最多更新1000个订单
        $model_order                      = Model('order');
        $condition                        = [];
        $condition['order_state']         = ORDER_STATE_SUCCESS;
        $condition['evaluation_state']    = 0;
        $condition['finnshed_time']       = ['lt', TIMESTAMP - self::ORDER_EVALUATE_TIME];
        $update                           = [];
        $update['evaluation_state']       = 2;
        $update['evaluation_again_state'] = 2;
        $update                           = $model_order->editOrder($update, $condition, 1000);
        if (!$update) {
            $this->log('更新实物订单超期不能评价失败');
        }

        //虚拟订单超期未评价自动更新状态，每次最多更新1000个订单
        $model_order                   = Model('vr_order');
        $condition                     = [];
        $condition['order_state']      = ORDER_STATE_SUCCESS;
        $condition['evaluation_state'] = 0;
        $condition['use_state']        = 1;
        $condition['finnshed_time']    = ['lt', TIMESTAMP - self::ORDER_EVALUATE_TIME];
        $update                        = [];
        $update['evaluation_state']    = 2;
        $update                        = $model_order->editOrder($update, $condition, 1000);
        if (!$update) {
            $this->log('更新虚拟订单超期不能评价失败');
        }
    }

    /**
     * 订单超期后不允许追加评价
     */
    private function _order_eval_again_expire_update()
    {
        //实物订单超期未评价自动更新状态，每次最多更新1000个订单
        $model_order                         = Model('order');
        $condition                           = [];
        $condition['order_state']            = ORDER_STATE_SUCCESS;
        $condition['evaluation_again_state'] = 0;
        $condition['finnshed_time']          = ['lt', TIMESTAMP - self::ORDER_EVALUATE_AGAIN_TIME];
        $update                              = [];
        $update['evaluation_again_state']    = 2;
        $update                              = $model_order->editOrder($update, $condition, 1000);
        if (!$update) {
            $this->log('更新实物订单超期不能评价失败');
        }
    }

    /**
     * 门店自提订单、支付方式为门店支付的订单7天内未自提自动取消
     */
    private function _order_chain_timeout_cancel()
    {

        $_break                    = false;
        $model_order               = Model('order');
        $logic_order               = Logic('order');
        $condition                 = [];
        $condition['order_state']  = ORDER_STATE_NEW;
        $condition['payment_code'] = 'chain';
        $condition['add_time']     = ['lt', TIMESTAMP - 60 * 60 * 24 * CHAIN_ORDER_PAYPUT_DAY];
        //分批，每批处理100个订单，最多处理1W个订单
        for ($i = 0; $i < 100; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', '', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateCancel($order_info, 'system', '系统', '超期未提货系统自动关闭订单', false, ['order_state' => ORDER_STATE_NEW]);
                if (!$result['state']) {
                    $this->log('门店自提订单订单超期未提货关闭失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }
    }

    /**
     * 更新商品访问量(redis)
     */
    private function _goods_click_update()
    {
        $data = rcache('updateRedisDate', 'goodsClick');
        foreach ($data as $key => $val) {
            Model('goods')->editGoodsById(['goods_click' => ['exp', 'goods_click +' . $val]], $key);
        }
        dcache('updateRedisDate', 'goodsClick');
    }

    /**
     * 更新商品促销到期状态(目前只有满即送)
     */
    private function _goods_promotion_state_update()
    {
        //满即送过期
        Model('p_mansong')->editExpireMansong();
    }

    /**
     * 商品到货通知提醒
     */
    private function _arrival_notice()
    {
        $strat_time = strtotime("-30 day"); // 只通知最近30天的记录

        $model_arrtivalnotice = Model('arrival_notice');
        // 删除30天之前的记录
        $model_arrtivalnotice->delArrivalNotice(['an_addtime' => ['lt', $strat_time], 'an_type' => 1]);

        $count = $model_arrtivalnotice->getArrivalNoticeCount([]);
        $times = ceil($count / self::ARRIVAL_NOTICE_NUM);
        if ($times == 0) return false;
        for ($i = 0; $i <= $times; $i++) {

            $notice_list = $model_arrtivalnotice->getArrivalNoticeList([], '*', $i . ',' . self::ARRIVAL_NOTICE_NUM);
            if (empty($notice_list)) continue;

            // 查询商品是否已经上架
            $goodsid_array = [];
            foreach ($notice_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            $goodsid_array = array_unique($goodsid_array);
            $goods_list    = Model('goods')->getGoodsOnlineList(['goods_id' => ['in', $goodsid_array], 'goods_storage' => ['gt', 0]], 'goods_id');
            if (empty($goods_list)) continue;

            // 需要通知到货的商品
            $goodsid_array = [];
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }

            // 根据商品id重新查询需要通知的列表
            $notice_list = $model_arrtivalnotice->getArrivalNoticeList(['goods_id' => ['in', $goodsid_array]], '*');
            if (empty($notice_list)) continue;

            foreach ($notice_list as $val) {
                $param              = [];
                $param['code']      = 'arrival_notice';
                $param['member_id'] = $val['member_id'];
                $param['param']     = [
                    'goods_name' => $val['goods_name'],
                    'goods_url'  => urlShop('goods', 'index', ['goods_id' => $val['goods_id']])
                ];
                $param['number']    = ['mobile' => $val['an_mobile'], 'email' => $val['an_email']];
                QueueClient::push('sendMemberMsg', $param);
            }

            // 清楚发送成功的数据
            $model_arrtivalnotice->delArrivalNotice(['goods_id' => ['in', $goodsid_array]]);
        }
    }

    /**
     * 缓存订单及订单商品相关数据
     */
    private function _order_goods_cache()
    {
        $model = Model('stat');
        //查询最后统计的记录
        $latest_record = $model->table('stat_ordergoods')->order('stat_updatetime desc,rec_id desc')->find();
        $stime         = 0;
        if ($latest_record) {
            $start_time = strtotime(date('Y-m-d', $latest_record['stat_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d', strtotime(C('setup_date'))));//从系统的安装时间开始统计
        }
        for ($stime = $start_time; $stime < time(); $stime = $stime + 86400) {
            $etime = $stime + 86400 - 1;
            //避免重复统计，开始时间必须大于最后一条记录的记录时间
            $search_stime = $latest_record['stat_updatetime'] > $stime ? $latest_record['stat_updatetime'] : $stime;
            //统计一天的数据，如果结束时间大于当前时间，则结束时间为当前时间，避免因为查询时间的延迟造成数据遗落
            $search_etime = ($t = ($stime + 86400 - 1)) > time() ? time() : ($stime + 86400 - 1);

            //查询时间段内新订单或者更新过的订单，在缓存表中需要将新订单和更新过的订单进行重新缓存
            $where             = [];
            $where['log_time'] = ['between', [$search_stime, $search_etime]];

            //查询记录总条数
            $countnum_arr = $model->table('order_log')->field('COUNT(DISTINCT order_id) as countnum')->where($where)->find();
            $countnum     = intval($countnum_arr['countnum']);

            for ($i = 0; $i < $countnum; $i += 100) {//每次查询100条
                $orderlog_list = [];
                $orderlog_list = $model->table('order_log')->field('DISTINCT order_id')->where($where)->limit($i . ',100')->select();
                if ($orderlog_list) {
                    //店铺ID数组
                    $storeid_arr = [];

                    //商品ID数组
                    $goodsid_arr = [];

                    //商品公共表ID数组
                    $goods_commonid_arr = [];

                    //订单ID数组
                    $orderid_arr = [];

                    //整理需要缓存的订单ID
                    foreach ((array)$orderlog_list as $k => $v) {
                        $orderid_arr[] = $v['order_id'];
                    }
                    unset($orderlog_list);

                    //查询订单数据
                    $field          = 'order_id,order_sn,store_id,buyer_id,buyer_name,add_time,payment_code,order_amount,shipping_fee,evaluation_state,order_state,refund_state,refund_amount,order_from';
                    $order_list_tmp = $model->table('orders')->field($field)->where(['order_id' => ['in', $orderid_arr]])->select();
                    $order_list     = [];
                    foreach ((array)$order_list_tmp as $k => $v) {
                        //判读订单是否计入统计（在线支付订单已支付或者经过退款的取消订单或者货到付款订单订单已成功）
                        $v['order_isvalid'] = 0;
                        if ($v['payment_code'] != 'offline' && $v['order_state'] != ORDER_STATE_NEW && $v['order_state'] != ORDER_STATE_CANCEL) {//在线支付并且已支付并且未取消
                            $v['order_isvalid'] = 1;
                        } elseif ($v['order_state'] == ORDER_STATE_CANCEL && $v['refund_state'] != 0) {//经过退款的取消订单
                            $v['order_isvalid'] = 1;
                        } elseif ($v['payment_code'] == 'offline' && $v['order_state'] == ORDER_STATE_SUCCESS) {//货到付款订单，订单成功之后才计入统计
                            $v['order_isvalid'] = 1;
                        }
                        $order_list[$v['order_id']] = $v;
                        $storeid_arr[]              = $v['store_id'];
                    }
                    unset($order_list_tmp);

                    //查询订单扩展数据
                    $field                 = 'order_id,reciver_province_id';
                    $order_common_list_tmp = $model->table('order_common')->field($field)->where(['order_id' => ['in', $orderid_arr]])->select();
                    $order_common_list     = [];
                    foreach ((array)$order_common_list_tmp as $k => $v) {
                        $order_common_list[$v['order_id']] = $v;
                    }
                    unset($order_common_list_tmp);

                    //查询店铺信息
                    $field          = 'store_id,store_name,grade_id,sc_id';
                    $store_list_tmp = $model->table('store')->field($field)->where(['store_id' => ['in', $storeid_arr]])->select();
                    $store_list     = [];
                    foreach ((array)$store_list_tmp as $k => $v) {
                        $store_list[$v['store_id']] = $v;
                    }
                    unset($store_list_tmp);

                    //查询订单商品
                    $field           = 'rec_id,order_id,goods_id,goods_name,goods_price,goods_num,goods_image,goods_pay_price,store_id,buyer_id,goods_type,promotions_id,commis_rate,gc_id';
                    $ordergoods_list = $model->table('order_goods')->field($field)->where(['order_id' => ['in', $orderid_arr]])->select();
                    foreach ((array)$ordergoods_list as $k => $v) {
                        $goodsid_arr[] = $v['goods_id'];
                    }

                    //查询商品信息
                    $field          = 'goods_id,goods_commonid,goods_price,goods_serial,gc_id,gc_id_1,gc_id_2,gc_id_3,goods_image';
                    $goods_list_tmp = $model->table('goods')->field($field)->where(['goods_id' => ['in', $goodsid_arr]])->select();
                    foreach ((array)$goods_list_tmp as $k => $v) {
                        $goods_commonid_arr[] = $v['goods_commonid'];
                    }

                    //查询商品公共信息
                    $field                 = 'goods_commonid,goods_name,brand_id,brand_name';
                    $goods_common_list_tmp = $model->table('goods_common')->field($field)->where(['goods_commonid' => ['in', $goods_commonid_arr]])->select();
                    $goods_common_list     = [];
                    foreach ((array)$goods_common_list_tmp as $k => $v) {
                        $goods_common_list[$v['goods_commonid']] = $v;
                    }
                    unset($goods_common_list_tmp);

                    //处理商品数组
                    $goods_list = [];

                    foreach ((array)$goods_list_tmp as $k => $v) {
                        $v['goods_commonname']      = $goods_common_list[$v['goods_commonid']]['goods_name'];
                        $v['brand_id']              = $goods_common_list[$v['goods_commonid']]['brand_id'];
                        $v['brand_name']            = $goods_common_list[$v['goods_commonid']]['brand_name'];
                        $goods_list[$v['goods_id']] = $v;
                    }
                    unset($goods_list_tmp);

                    //查询订单缓存是否存在，存在则删除
                    $model->table('stat_ordergoods')->where(['order_id' => ['in', $orderid_arr]])->delete();
                    //查询订单缓存是否存在，存在则删除
                    $model->table('stat_order')->where(['order_id' => ['in', $orderid_arr]])->delete();

                    //整理新增数据
                    $ordergoods_insert_arr = [];
                    foreach ((array)$ordergoods_list as $k => $v) {
                        $tmp                        = [];
                        $tmp['rec_id']              = $v['rec_id'];
                        $tmp['stat_updatetime']     = $search_etime;
                        $tmp['order_id']            = $v['order_id'];
                        $tmp['order_sn']            = $order_list[$v['order_id']]['order_sn'];
                        $tmp['order_add_time']      = $order_list[$v['order_id']]['add_time'];
                        $tmp['payment_code']        = $order_list[$v['order_id']]['payment_code'];
                        $tmp['order_amount']        = $order_list[$v['order_id']]['order_amount'];
                        $tmp['shipping_fee']        = $order_list[$v['order_id']]['shipping_fee'];
                        $tmp['evaluation_state']    = $order_list[$v['order_id']]['evaluation_state'];
                        $tmp['order_state']         = $order_list[$v['order_id']]['order_state'];
                        $tmp['refund_state']        = $order_list[$v['order_id']]['refund_state'];
                        $tmp['refund_amount']       = $order_list[$v['order_id']]['refund_amount'];
                        $tmp['order_from']          = $order_list[$v['order_id']]['order_from'];
                        $tmp['order_isvalid']       = $order_list[$v['order_id']]['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id']            = $v['store_id'];
                        $tmp['store_name']          = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id']            = $store_list[$v['store_id']]['grade_id'];
                        $tmp['sc_id']               = $store_list[$v['store_id']]['sc_id'];
                        $tmp['buyer_id']            = $order_list[$v['order_id']]['buyer_id'];
                        $tmp['buyer_name']          = $order_list[$v['order_id']]['buyer_name'];
                        $tmp['goods_id']            = $v['goods_id'];
                        $tmp['goods_name']          = $v['goods_name'];
                        $tmp['goods_commonid']      = intval($goods_list[$v['goods_id']]['goods_commonid']);
                        $tmp['goods_commonname']    = ($t = $goods_list[$v['goods_id']]['goods_commonname']) ? $t : $v['goods_name'];
                        $tmp['gc_id']               = intval($goods_list[$v['goods_id']]['gc_id']);
                        $tmp['gc_parentid_1']       = intval($goods_list[$v['goods_id']]['gc_id_1']);
                        $tmp['gc_parentid_2']       = intval($goods_list[$v['goods_id']]['gc_id_2']);
                        $tmp['gc_parentid_3']       = intval($goods_list[$v['goods_id']]['gc_id_3']);
                        $tmp['brand_id']            = intval($goods_list[$v['goods_id']]['brand_id']);
                        $tmp['brand_name']          = ($t = $goods_list[$v['goods_id']]['brand_name']) ? $t : '';
                        $tmp['goods_serial']        = ($t = $goods_list[$v['goods_id']]['goods_serial']) ? $t : '';
                        $tmp['goods_price']         = $v['goods_price'];
                        $tmp['goods_num']           = $v['goods_num'];
                        $tmp['goods_image']         = $goods_list[$v['goods_id']]['goods_image'];
                        $tmp['goods_pay_price']     = $v['goods_pay_price'];
                        $tmp['goods_type']          = $v['goods_type'];
                        $tmp['promotions_id']       = $v['promotions_id'];
                        $tmp['commis_rate']         = $v['commis_rate'];
                        $ordergoods_insert_arr[]    = $tmp;
                    }
                    $model->table('stat_ordergoods')->insertAll($ordergoods_insert_arr);
                    $order_insert_arr = [];

                    foreach ((array)$order_list as $k => $v) {
                        $tmp                        = [];
                        $tmp['order_id']            = $v['order_id'];
                        $tmp['order_sn']            = $v['order_sn'];
                        $tmp['order_add_time']      = $v['add_time'];
                        $tmp['payment_code']        = $v['payment_code'];
                        $tmp['order_amount']        = $v['order_amount'];
                        $tmp['shipping_fee']        = $v['shipping_fee'];
                        $tmp['evaluation_state']    = $v['evaluation_state'];
                        $tmp['order_state']         = $v['order_state'];
                        $tmp['refund_state']        = $v['refund_state'];
                        $tmp['refund_amount']       = $v['refund_amount'];
                        $tmp['order_from']          = $v['order_from'];
                        $tmp['order_isvalid']       = $v['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id']            = $v['store_id'];
                        $tmp['store_name']          = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id']            = $store_list[$v['store_id']]['grade_id'];
                        $tmp['sc_id']               = $store_list[$v['store_id']]['sc_id'];
                        $tmp['buyer_id']            = $v['buyer_id'];
                        $tmp['buyer_name']          = $v['buyer_name'];
                        $order_insert_arr[]         = $tmp;
                    }
                    $model->table('stat_order')->insertAll($order_insert_arr);
                }
            }
        }
    }

    /**
     * 会员相关数据统计
     */
    private function _member_stat()
    {
        $model = Model('stat');
        //查询最后统计的记录
        $latest_record = $model->getOneStatmember([], '', 'statm_id desc');
        $stime         = 0;
        if ($latest_record) {
            $start_time = strtotime(date('Y-m-d', $latest_record['statm_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d', strtotime(C('setup_date'))));//从系统的安装时间开始统计
        }
        $j = 1;
        for ($stime = $start_time; $stime < time(); $stime = $stime + 86400) {
            //数据库更新数据数组
            $insert_arr = [];
            $update_arr = [];

            //结束时间
            $etime = $stime + 86400 - 1;

            //统计订单下单量和下单金额
            $field                       = ' orders.order_id,orders.add_time,orders.buyer_id,orders.buyer_name,orders.order_amount,order_log.log_orderstate,orders.payment_code';
            $where                       = [];
            $where['orders.order_state'] = [['neq', ORDER_STATE_NEW], ['neq', ORDER_STATE_CANCEL], 'and'];//去除未支付和已取消订单
            $where['order_log.log_time'] = ['between', [$stime, $etime]];//按照订单付款的操作时间统计
            //货到付款当交易成功进入统计，非货到付款当付款后进入统计
            $where['payment_code'] = ['exp', "(orders.payment_code='offline' and order_log.log_orderstate = '" . ORDER_STATE_SUCCESS . "') or (orders.payment_code<>'offline' and order_log.log_orderstate = '" . ORDER_STATE_PAY . "' )"];
            $orderlist_tmp         = [];
            $orderlist_tmp         = $model->statByOrderLog($where, $field, 0, 0, 'order_id');//此处由于底层的限制，仅能查询1000条，如果日下单量大于1000，则需要limit的支持
            $order_list            = [];
            $orderid_list          = [];
            foreach ((array)$orderlist_tmp as $k => $v) {
                if (($v['payment_code'] <> 'offline' && $v['log_orderstate'] == ORDER_STATE_PAY) || ($v['payment_code'] == 'offline' && $v['log_orderstate'] == ORDER_STATE_SUCCESS)) {
                    $addtime = strtotime(date('Y-m-d', $v['add_time']));
                    if ($addtime != $stime) {//订单如果隔天支付的话，需要进行统计数据更新
                        if (!$update_arr[$addtime][$v['buyer_id']]) {
                            $update_arr[$addtime][$v['buyer_id']] = $v['buyer_name'];
                        }
                    } else {
                        $order_list[$v['buyer_id']]['buyer_name']  = $v['buyer_name'];
                        $order_list[$v['buyer_id']]['ordernum']    = intval($order_list[$v['buyer_id']]['ordernum']) + 1;
                        $order_list[$v['buyer_id']]['orderamount'] = floatval($order_list[$v['buyer_id']]['orderamount']) + (($t = floatval($v['order_amount'])) > 0 ? $t : 0);
                    }
                    //记录订单ID数组
                    $orderid_list[] = $v['order_id'];
                }
            }

            //统计下单商品件数
            $ordergoods_tmp  = [];
            $ordergoods_list = [];
            if ($orderid_list && count($orderid_list) > 0) {
                $field                    = ' orders.add_time,orders.buyer_id,orders.buyer_name,order_goods.goods_num ';
                $where                    = [];
                $where['orders.order_id'] = ['in', $orderid_list];
                $ordergoods_tmp           = $model->statByOrderGoods($where, $field, 0, 0, 'orders.order_id');

                foreach ((array)$ordergoods_tmp as $k => $v) {
                    $addtime = strtotime(date('Y-m-d', $v['add_time']));
                    if ($addtime != $stime) {//订单如果隔天支付的话，需要进行统计数据更新

                    } else {
                        $ordergoods_list[$v['buyer_id']]['goodsnum'] = $ordergoods_list[$v['buyer_id']]['goodsnum'] + (($t = floatval($v['goods_num'])) > 0 ? $t : 0);
                    }
                }
            }

            //统计的预存款记录
            if (C('dbdriver') == 'mysql') {
                $field = ' lg_member_id,min(lg_member_name) as lg_member_name,SUM(IF(lg_av_amount>=0,lg_av_amount,0)) as predincrease, SUM(IF(lg_av_amount<=0,lg_av_amount,0)) as predreduce ';
            } elseif (C('dbdriver') == 'oracle') {
                $field = ' lg_member_id,min(lg_member_name) as lg_member_name,SUM((case when lg_av_amount>=0 then lg_av_amount else 0 end)) as predincrease, SUM((case when lg_av_amount<=0 then lg_av_amount else 0 end)) as predreduce ';
            }

            $where                = [];
            $where['lg_add_time'] = ['between', [$stime, $etime]];
            $predeposit_tmp       = $model->getPredepositInfo($where, $field, 0, 'lg_member_id', 0, 'lg_member_id');
            $predeposit_list      = [];
            foreach ((array)$predeposit_tmp as $k => $v) {
                $predeposit_list[$v['lg_member_id']] = $v;
            }

            //统计的积分记录
            if (C('dbdriver') == 'mysql') {
                $field = ' pl_memberid,min(pl_membername) as pl_membername,SUM(IF(pl_points>=0,pl_points,0)) as pointsincrease, SUM(IF(pl_points<=0,pl_points,0)) as pointsreduce ';
            } elseif (C('dbdriver') == 'oracle') {
                $field = ' pl_memberid,min(pl_membername) as pl_membername,SUM((case when pl_points>=0 then pl_points else 0 end)) as pointsincrease, SUM((case when pl_points<=0 then pl_points else 0 end)) as pointsreduce ';
            }

            $where               = [];
            $where['pl_addtime'] = ['between', [$stime, $etime]];
            $points_tmp          = $model->statByPointslog($where, $field, 0, 0, '', 'pl_memberid');
            $points_list         = [];
            foreach ((array)$points_tmp as $k => $v) {
                $points_list[$v['pl_memberid']] = $v;
            }

            //处理需要更新的数据
            foreach ((array)$update_arr as $k => $v) {
                foreach ($v as $m_k => $m_v) {
                    //查询的时间段
                    $up_stime = $k;
                    $up_etime = $up_stime + 86400 - 1;

                    //查询时间时间段内的订单总数和订单总金额
                    $where                = [];
                    $where['order_state'] = [['neq', ORDER_STATE_NEW], ['neq', ORDER_STATE_CANCEL], 'and'];//去除未支付和已取消订单
                    $where['add_time']    = ['between', [$up_stime, $up_etime]];
                    //货到付款当交易成功进入统计，非货到付款当付款后进入统计
                    $where['payment_code'] = ['exp', "(payment_code='offline' and order_state = '" . ORDER_STATE_SUCCESS . "') or (payment_code<>'offline')"];
                    $orderlist_amount      = $model->statByOrder($where, 'SUM(order_amount) as amount,COUNT(*) as num', 0, 0, 'order_id');

                    //查询时间时间段内的下单商品件数
                    $where                       = [];
                    $where['orders.order_state'] = [['neq', ORDER_STATE_NEW], ['neq', ORDER_STATE_CANCEL], 'and'];//去除未支付和已取消订单
                    $where['orders.add_time']    = ['between', [$up_stime, $up_etime]];
                    //货到付款当交易成功进入统计，非货到付款当付款后进入统计
                    $where['orders.payment_code'] = ['exp', "(orders.payment_code='offline' and orders.order_state = '" . ORDER_STATE_SUCCESS . "') or (orders.payment_code<>'offline')"];
                    $ordergoods_amount            = $model->statByOrderGoods($where, 'SUM(order_goods.goods_num) as gnum');

                    //查询记录是否存在
                    $statmember_info = $model->getOneStatmember(['statm_time' => $k, 'statm_memberid' => $m_k]);

                    if ($statmember_info) {
                        //构造更新数组
                        $m_v                      = [];
                        $m_v['statm_ordernum']    = $orderlist_amount[0]['num'];
                        $m_v['statm_orderamount'] = floatval($orderlist_amount[0]['amount']);
                        $m_v['statm_goodsnum']    = floatval($ordergoods_amount[0]['gnum']);
                        $m_v['statm_updatetime']  = $stime;
                        $model->updateStatmember(['statm_time' => $k, 'statm_memberid' => $m_k], $m_v);
                    } else {
                        $tmp                         = [];
                        $tmp['statm_memberid']       = $m_k;
                        $tmp['statm_membername']     = $m_v;
                        $tmp['statm_time']           = $k;
                        $tmp['statm_updatetime']     = $stime;
                        $tmp['statm_ordernum']       = intval($orderlist_amount[0]['num']);
                        $tmp['statm_orderamount']    = floatval($orderlist_amount[0]['amount']);
                        $tmp['statm_goodsnum']       = intval($ordergoods_amount[0]['gnum']);
                        $tmp['statm_predincrease']   = 0;
                        $tmp['statm_predreduce']     = 0;
                        $tmp['statm_pointsincrease'] = 0;
                        $tmp['statm_pointsreduce']   = 0;
                        $insert_arr[]                = $tmp;
                    }
                    unset($statmember_info);
                }
            }

            //处理获得所有会员ID数组
            $memberidarr_order      = $order_list ? array_keys($order_list) : [];
            $memberidarr_ordergoods = $ordergoods_list ? array_keys($ordergoods_list) : [];
            $memberidarr_predeposit = $predeposit_list ? array_keys($predeposit_list) : [];
            $memberidarr_points     = $points_list ? array_keys($points_list) : [];
            $memberid_arr           = array_merge($memberidarr_order, $memberidarr_ordergoods, $memberidarr_predeposit, $memberidarr_points);
            //查询会员信息
            $memberid_list = Model('member')->getMemberList(['member_id' => ['in', $memberid_arr]], '', 0);

            foreach ((array)$memberid_list as $k => $v) {
                $tmp                     = [];
                $tmp['statm_memberid']   = $v['member_id'];
                $tmp['statm_membername'] = $v['member_name'];
                $tmp['statm_time']       = $stime;
                $tmp['statm_updatetime'] = $stime;
                //因为记录可能已经存在，所以加上之前的统计记录
                $tmp['statm_ordernum']       = (($t = intval($order_list[$tmp['statm_memberid']]['ordernum'])) > 0 ? $t : 0);
                $tmp['statm_orderamount']    = (($t = floatval($order_list[$tmp['statm_memberid']]['orderamount'])) > 0 ? $t : 0);
                $tmp['statm_goodsnum']       = (($t = intval($ordergoods_list[$tmp['statm_memberid']]['goodsnum'])) ? $t : 0);
                $tmp['statm_predincrease']   = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predincrease'])) ? $t : 0);
                $tmp['statm_predreduce']     = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predreduce'])) ? $t : 0);
                $tmp['statm_pointsincrease'] = (($t = intval($points_list[$tmp['statm_memberid']]['pointsincrease'])) ? $t : 0);
                $tmp['statm_pointsreduce']   = (($t = intval($points_list[$tmp['statm_memberid']]['pointsreduce'])) ? $t : 0);
                $insert_arr[]                = $tmp;
            }

            //删除旧的统计数据
            $model->delByStatmember(['statm_time' => $stime]);
            $model->table('stat_member')->insertAll($insert_arr);
        }
    }

    /**
     * 取消无货后门店商品的标记
     *
     * @return boolean
     */
    private function _delivery_goods_sign_update()
    {
        $list = Model('chain_stock')->getChainStockList([''], 'sum(stock) as stock_sum,goods_id', 0, 'stock_sum asc', 'goods_id');
        if (empty($list)) {
            return true;
        }
        $goods_ids = [];
        foreach ($list as $val) {
            if ($val['stock_sum'] <= 0) {
                $goods_ids[] = $val['goods_id'];
            } else {
                break;
            }
        }

        Model('goods')->editGoodsById(['is_chain' => 0], $goods_ids);
        return true;
    }

    private function _create_bill()
    {
        $this->_model_store      = Model('store');
        $this->_model_store_ext  = Model('store_extend');
        $this->_model_bill       = Model('bill');
        $this->_model_order      = Model('order');
        $this->_model_store_cost = Model('store_cost');
        $this->_model_vr_bill    = Model('vr_bill');
        $this->_model_vr_order   = Model('vr_order');


        //实物订单结算
        $this->_real_order();


    }

    /**
     * 生成上月账单[实物订单]
     * 考虑到老版本，判断 一下有没有ID为1的店铺，如果没有，则向表中插入一条ID:1的记录。
     * 从店铺扩展表中得取所有店铺结算周期设置，循环逐个生成每个店铺结算单。
     * 如果值为0，则还是按月结算流程，如果值大于0，则按 X天周期结算。
     */
    private function _real_order()
    {

        //向前兼容
        $this->_model_store_ext = Model('store_extend');
        if (!$this->_model_store_ext->getStoreExtendInfo(['store_id' => 1])) {
            $this->_model_store_ext->addStoreExtend(['store_id' => 1]);
        }

        $count = $this->_model_store_ext->getStoreExtendCount();

        $step_num = 100;
        for ($i = 0; $i <= $count; $i = $i + $step_num) {
            //每次取出100个店铺信息
            $store_list = $this->_model_store_ext->getStoreExendList([], "{$i},{$step_num}");
            if (is_array($store_list) && $store_list) {
                foreach ($store_list as $kk => $store_info) {
                    $start_time = $this->_get_start_date($store_info['store_id']);
                    if ($start_time !== 0) {
                        if ($store_info['bill_cycle']) {
                            $this->_create_bill_cycle_by_day($start_time, $store_info);
                        } else {
                            $this->_create_bill_cycle_by_month($start_time, $store_info, $kk);
                        }
                    }
                }
            }
        }
    }

    /**
     * 结算周期为月结
     *
     * @param unknown $start_time
     * @param unknown $store_info
     */
    private function _create_bill_cycle_by_month($start_unixtime, $store_info, $flag_static)
    {
        $i              = 1;
        $start_unixtime = strtotime(date('Y-m-01 00:00:00', $start_unixtime));
        $current_time   = strtotime(date('Y-m-01 00:00:01', TIMESTAMP));
        while (($time = strtotime('-' . $i . ' month', $current_time)) >= $start_unixtime) {
            if (date('Ym', $start_unixtime) == date('Ym', $time)) {
                //如果两个月份相等检查库是里否存在
                $order_statis = $this->_model_bill->getOrderStatisInfo(['os_month' => date('Ym', $start_unixtime)]);
                if ($order_statis) {
                    break;
                }
            }
            //该月第一天0时unix时间戳
            $first_day_unixtime = strtotime(date('Y-m-01 00:00:00', $time));
            //该月最后一天最后一秒时unix时间戳
            $last_day_unixtime = strtotime(date('Y-m-01 23:59:59', $time) . " +1 month -1 day");
            $os_month          = date('Ym', $first_day_unixtime);

            try {
                $this->_model_order->beginTransaction();
                //生成单个店铺月订单出账单
                $data                  = [];
                $data['ob_store_id']   = $store_info['store_id'];
                $data['ob_start_date'] = $first_day_unixtime;
                $data['ob_end_date']   = $last_day_unixtime;
                $this->_create_real_order_bill($data);

                if ($flag_static === 0) {
                    $data                  = [];
                    $data['os_month']      = $os_month;
                    $data['os_year']       = date('Y', $first_day_unixtime);
                    $data['os_start_date'] = $first_day_unixtime;
                    $data['os_end_date']   = $last_day_unixtime;
                    $this->_model_bill->addOrderStatis($data);
                }

                $this->_model_order->commit();
            } catch (Exception $e) {
                $this->log('实物账单:' . $e->getMessage());
                $this->_model_order->rollback();
            }
            $i++;
        }
    }

    /**
     * 结算周期为X天结算
     *
     * @param unknown $start_time
     * @param unknown $store_info
     */
    private function _create_bill_cycle_by_day($start_unixtime, $store_info)
    {
        $i              = $store_info['bill_cycle'] - 1;
        $start_unixtime = strtotime(date('Y-m-d 00:00:00', $start_unixtime));
        $current_time   = strtotime(date('Y-m-d 00:00:00', TIMESTAMP));
        while (($time = strtotime('+' . $i . ' day', $start_unixtime)) < $current_time) {
            $first_day_unixtime    = strtotime(date('Y-m-d 00:00:00', $start_unixtime));    //开始那天0时unix时间戳
            $last_day_unixtime     = strtotime(date('Y-m-d 23:59:59', $time)); //结束那天最后一秒时unix时间戳
            $data                  = [];
            $data['os_start_date'] = $first_day_unixtime;
            $data['os_end_date']   = $last_day_unixtime;

            try {
                $this->_model_order->beginTransaction();
                //生成单个店铺订单出账单
                $data                  = [];
                $data['ob_store_id']   = $store_info['store_id'];
                $data['ob_start_date'] = $first_day_unixtime;
                $data['ob_end_date']   = $last_day_unixtime;
                $this->_create_real_order_bill($data);

                $this->_model_order->commit();
            } catch (Exception $e) {
                $this->log('实物账单:' . $e->getMessage());
                $this->_model_order->rollback();
            }
            $start_unixtime = strtotime(date('Y-m-d 00:00:00', $last_day_unixtime + 86400));
        }
    }

    /**
     * 结算周期为X天结算
     *
     * @param unknown $start_time
     * @param unknown $store_info
     */
    private function _create_vr_bill_cycle_by_day($start_unixtime, $store_info)
    {
        $i              = $store_info['bill_cycle'] - 1;
        $start_unixtime = strtotime(date('Y-m-d 00:00:00', $start_unixtime));
        $current_time   = strtotime(date('Y-m-d 00:00:00', TIMESTAMP));
        while (($time = strtotime('+' . $i . ' day', $start_unixtime)) < $current_time) {
            $first_day_unixtime    = strtotime(date('Y-m-d 00:00:00', $start_unixtime));    //开始那天0时unix时间戳
            $last_day_unixtime     = strtotime(date('Y-m-d 23:59:59', $time)); //结束那天最后一秒时unix时间戳
            $data                  = [];
            $data['os_start_date'] = $first_day_unixtime;
            $data['os_end_date']   = $last_day_unixtime;

            try {
                $this->_model_vr_order->beginTransaction();
                //生成单个店铺订单出账单
                $data                  = [];
                $data['ob_store_id']   = $store_info['store_id'];
                $data['ob_start_date'] = $first_day_unixtime;
                $data['ob_end_date']   = $last_day_unixtime;
                $this->_create_vr_order_bill($data);

                $this->_model_vr_order->commit();
            } catch (Exception $e) {
                $this->log('虚拟账单:' . $e->getMessage());
                $this->_model_vr_order->rollback();
            }
            $start_unixtime = strtotime(date('Y-m-d 00:00:00', $last_day_unixtime + 86400));
        }
    }

    /**
     * 取得结算开始时间
     * 从order_bill表中取该店铺结算单中最大的ob_end_date作为本次结算开始时间
     * 如果未找到结算单，则查询该店铺订单表(已经完成状态)和店铺费用表，把里面时间较早的那个作为本次结算开始时间
     *
     * @param int $store_id
     */
    private function _get_start_date($store_id)
    {
        $bill_info      = $this->_model_bill->getOrderBillInfo(['ob_store_id' => $store_id], 'max(ob_end_date) as stime');
        $start_unixtime = 0;
        if ($bill_info['stime']) {
            $start_unixtime = $bill_info['stime'] + 1;
        } else {
            $condition                  = [];
            $condition['order_state']   = ORDER_STATE_SUCCESS;
            $condition['store_id']      = $store_id;
            $condition['finnshed_time'] = ['gt', 0];
            $order_info                 = $this->_model_order->getOrderInfo($condition, [], 'min(finnshed_time) as stime');
            $condition                  = [];
            $condition['cost_store_id'] = $store_id;
            $condition['cost_state']    = 0;
            $condition['cost_time']     = ['gt', 0];
            $cost_info                  = $this->_model_store_cost->getStoreCostInfo($condition, 'min(cost_time) as stime');
            if ($order_info['stime']) {
                if ($cost_info['stime']) {
                    $start_unixtime = $order_info['stime'] < $cost_info['stime'] ? $order_info['stime'] : $cost_info['stime'];
                } else {
                    $start_unixtime = $order_info['stime'];
                }
            } else {
                if ($cost_info['stime']) {
                    $start_unixtime = $cost_info['stime'];
                }
            }
            if ($start_unixtime) {
                $start_unixtime = strtotime(date('Y-m-d 00:00:00', $start_unixtime));
            }
        }
        return $start_unixtime;
    }

    /**
     * 取得结算开始时间
     * 从vr_order_bill表中取该店铺结算单中最大的ob_end_date作为本次结算开始时间
     * 如果未找到结算单，则查询该店铺订单表(已经完成状态)的订单最小时间作为本次结算开始时间
     *
     * @param int $store_id
     */
    private function _get_vr_start_date($store_id)
    {
        $bill_info      = $this->_model_vr_bill->getOrderBillInfo(['ob_store_id' => $store_id], 'max(ob_end_date) as stime');
        $start_unixtime = 0;
        if ($bill_info['stime']) {
            $start_unixtime = $bill_info['stime'] + 1;
        } else {
            $condition                = [];
            $condition['order_state'] = ['in', [ORDER_STATE_PAY, ORDER_STATE_SUCCESS]];
            $condition['store_id']    = $store_id;
            $order_info               = $this->_model_vr_order->getOrderInfo($condition, 'min(add_time) as stime');
            if ($order_info['stime']) {
                $start_unixtime = $order_info['stime'];
            }
            if ($start_unixtime) {
                $start_unixtime = strtotime(date('Y-m-d 00:00:00', $start_unixtime));
            }
        }
        return $start_unixtime;
    }

    /**
     * 生成单个店铺订单出账单[实物订单]
     *
     * @param int $data
     */
    private function _create_real_order_bill($data)
    {
        $data_bill['ob_start_date'] = $data['ob_start_date'];
        $data_bill['ob_end_date']   = $data['ob_end_date'];
        $data_bill['ob_state']      = 0;
        $data_bill['ob_store_id']   = $data['ob_store_id'];
        if (!$this->_model_bill->getOrderBillInfo(['ob_store_id' => $data['ob_store_id'], 'ob_start_date' => $data['ob_start_date']])) {
            $insert = $this->_model_bill->addOrderBill($data_bill);
            if (!$insert) {
                throw new Exception('生成账单失败');
            }
            //对已生成空账单进行销量、退单、佣金统计
            $data_bill['ob_id'] = $insert;
            $update             = $this->_calc_real_order_bill($data_bill);
            if (!$update) {
                throw new Exception('更新账单失败');
            }

            // 发送店铺消息
            $param             = [];
            $param['code']     = 'store_bill_affirm';
            $param['store_id'] = $data_bill['ob_store_id'];
            $param['param']    = [
                'state_time' => date('Y-m-d H:i:s', $data_bill['ob_start_date']),
                'end_time'   => date('Y-m-d H:i:s', $data_bill['ob_end_date']),
                'bill_no'    => $data_bill['ob_id']
            ];
            QueueClient::push('sendStoreMsg', $param);
        }
    }

    /**
     * 计算某月内，某店铺的销量，退单量，佣金[实物订单]
     *
     * @param array $data_bill
     */
    private function _calc_real_order_bill($data_bill)
    {

        $order_condition                  = [];
        $order_condition['order_state']   = ORDER_STATE_SUCCESS;
        $order_condition['store_id']      = $data_bill['ob_store_id'];
        $order_condition['finnshed_time'] = ['between', "{$data_bill['ob_start_date']},{$data_bill['ob_end_date']}"];

        $update = [];

        //订单金额
        $fields                    = 'sum(order_amount) as order_amount,sum(rpt_amount) as rpt_amount,sum(shipping_fee) as shipping_amount,min(store_name) as store_name';
        $order_info                = $this->_model_order->getOrderInfo($order_condition, [], $fields);
        $update['ob_order_totals'] = floatval($order_info['order_amount']);

        //红包
        $update['ob_rpt_amount'] = floatval($order_info['rpt_amount']);

        //运费
        $update['ob_shipping_totals'] = floatval($order_info['shipping_amount']);
        //店铺名字
        $store_info              = $this->_model_store->getStoreInfoByID($data_bill['ob_store_id']);
        $update['ob_store_name'] = $store_info['store_name'];

        //佣金金额
        $order_info               = $this->_model_order->getOrderInfo($order_condition, [], 'count(DISTINCT order_id) as count');
        $order_count              = $order_info['count'];
        $commis_rate_totals_array = [];
        //分批计算佣金，最后取总和
        for ($i = 0; $i <= $order_count; $i = $i + 300) {
            $order_list     = $this->_model_order->getOrderList($order_condition, '', 'order_id', '', "{$i},300");
            $order_id_array = [];
            foreach ($order_list as $order_info) {
                $order_id_array[] = $order_info['order_id'];
            }
            if (!empty($order_id_array)) {
                $order_goods_condition             = [];
                $order_goods_condition['order_id'] = ['in', $order_id_array];
                $field                             = 'SUM(ROUND(goods_pay_price*commis_rate/100,2)) as commis_amount';
                $order_goods_info                  = $this->_model_order->getOrderGoodsInfo($order_goods_condition, $field);
                $commis_rate_totals_array[]        = $order_goods_info['commis_amount'];
            } else {
                $commis_rate_totals_array[] = 0;
            }
        }
        $update['ob_commis_totals'] = floatval(array_sum($commis_rate_totals_array));

        //退款总额
        $model_refund                     = Model('refund_return');
        $refund_condition                 = [];
        $refund_condition['seller_state'] = 2;
        $refund_condition['store_id']     = $data_bill['ob_store_id'];
        $refund_condition['goods_id']     = ['gt', 0];
        $refund_condition['admin_time']   = [['egt', $data_bill['ob_start_date']], ['elt', $data_bill['ob_end_date']], 'and'];
        $refund_info                      = $model_refund->getRefundReturnInfo($refund_condition, 'sum(refund_amount) as refund_amount,sum(rpt_amount) as rpt_amount');
        $update['ob_order_return_totals'] = floatval($refund_info['refund_amount']);

        //全部退款时的红包
        $update['ob_rf_rpt_amount'] = floatval($refund_info['rpt_amount']);

        //退款佣金
        $refund = $model_refund->getRefundReturnInfo($refund_condition, 'sum(ROUND(refund_amount*commis_rate/100,2)) as amount');
        if ($refund) {
            $update['ob_commis_return_totals'] = floatval($refund['amount']);
        } else {
            $update['ob_commis_return_totals'] = 0;
        }

        //店铺活动费用
        $model_store_cost                = Model('store_cost');
        $cost_condition                  = [];
        $cost_condition['cost_store_id'] = $data_bill['ob_store_id'];
        $cost_condition['cost_state']    = 0;
        $cost_condition['cost_time']     = [['egt', $data_bill['ob_start_date']], ['elt', $data_bill['ob_end_date']], 'and'];
        $cost_info                       = $model_store_cost->getStoreCostInfo($cost_condition, 'sum(cost_price) as cost_amount');
        $update['ob_store_cost_totals']  = floatval($cost_info['cost_amount']);

        //已经被取消的预定订单但未退还定金金额
        $model_order_book               = Model('order_book');
        $condition                      = [];
        $condition['book_store_id']     = $data_bill['ob_store_id'];
        $condition['book_cancel_time']  = ['between', "{$data_bill['ob_start_date']},{$data_bill['ob_end_date']}"];
        $order_book_info                = $model_order_book->getOrderBookInfo($condition, 'sum(book_real_pay) as pay_amount');
        $update['ob_order_book_totals'] = floatval($order_book_info['pay_amount']);

        //本期应结
        $update['ob_result_totals'] = $update['ob_order_totals'] + $update['ob_rpt_amount'] + $update['ob_order_book_totals'] - $update['ob_order_return_totals'] -
            $update['ob_commis_totals'] + $update['ob_commis_return_totals'] - $update['ob_rf_rpt_amount'] - $update['ob_store_cost_totals'];
        $update['ob_store_cost_totals'];
        $update['ob_create_date'] = TIMESTAMP;
        $update['ob_state']       = 1;
        $update['os_month']       = date('Ym', $data_bill['ob_end_date'] + 1);
        return $this->_model_bill->editOrderBill($update, ['ob_id' => $data_bill['ob_id']]);
    }

    /**
     * 生成账单[虚拟订单]
     */
    private function _vr_order()
    {
        $count = $this->_model_store_ext->getStoreExtendCount();

        $step_num = 100;
        for ($i = 0; $i <= $count; $i = $i + $step_num) {
            //每次取出100个店铺信息
            $store_list = $this->_model_store_ext->getStoreExendList([], "{$i},{$step_num}");
            if (is_array($store_list) && $store_list) {
                foreach ($store_list as $kk => $store_info) {
                    $start_time = $this->_get_vr_start_date($store_info['store_id']);
                    if ($start_time !== 0) {
                        if ($store_info['bill_cycle']) {
                            $this->_create_vr_bill_cycle_by_day($start_time, $store_info);
                        } else {
                            $this->_create_vr_bill_cycle_by_month($start_time, $store_info, $kk);
                        }
                    }
                }
            }
        }
    }

    /**
     * 结算周期为月结
     *
     * @param unknown $start_time
     * @param unknown $store_info
     */
    private function _create_vr_bill_cycle_by_month($start_unixtime, $store_info, $flag_static)
    {
        $i              = 1;
        $start_unixtime = strtotime(date('Y-m-01 00:00:00', $start_unixtime));
        $current_time   = strtotime(date('Y-m-01 00:00:01', TIMESTAMP));
        while (($time = strtotime('-' . $i . ' month', $current_time)) >= $start_unixtime) {
            if (date('Ym', $start_unixtime) == date('Ym', $time)) {
                //如果两个月份相等检查库是里否存在
                $order_statis = $this->_model_vr_bill->getOrderStatisInfo(['os_month' => date('Ym', $start_unixtime)]);
                if ($order_statis) {
                    break;
                }
            }
            //该月第一天0时unix时间戳
            $first_day_unixtime = strtotime(date('Y-m-01 00:00:00', $time));
            //该月最后一天最后一秒时unix时间戳
            $last_day_unixtime = strtotime(date('Y-m-01 23:59:59', $time) . " +1 month -1 day");
            $os_month          = date('Ym', $first_day_unixtime);

            try {
                $this->_model_vr_order->beginTransaction();
                //生成单个店铺月订单出账单
                $data                  = [];
                $data['ob_store_id']   = $store_info['store_id'];
                $data['ob_start_date'] = $first_day_unixtime;
                $data['ob_end_date']   = $last_day_unixtime;
                $this->_create_vr_order_bill($data);

                if ($flag_static === 0) {
                    $data                  = [];
                    $data['os_month']      = $os_month;
                    $data['os_year']       = date('Y', $first_day_unixtime);
                    $data['os_start_date'] = $first_day_unixtime;
                    $data['os_end_date']   = $last_day_unixtime;
                    $this->_model_vr_bill->addOrderStatis($data);
                }

                $this->_model_vr_order->commit();
            } catch (Exception $e) {
                $this->log('虚拟账单:' . $e->getMessage());
                $this->_model_vr_order->rollback();
            }
            $i++;
        }
    }

    /**
     * 生成所有店铺订单出账单[虚拟订单]
     *
     * @param array $data
     * @throws Exception
     */
    private function _create_vr_order_bill($data)
    {
        $data_bill['ob_start_date'] = $data['ob_start_date'];
        $data_bill['ob_end_date']   = $data['ob_end_date'];
        $data_bill['ob_state']      = 0;
        $data_bill['ob_store_id']   = $data['ob_store_id'];
        if (!$this->_model_vr_bill->getOrderBillInfo(['ob_store_id' => $data['ob_store_id'], 'ob_start_date' => $data['ob_start_date']])) {
            $insert = $this->_model_vr_bill->addOrderBill($data_bill);
            if (!$insert) {
                throw new Exception('生成账单失败');
            }
            //对已生成空账单进行销量、退单、佣金统计
            $data_bill['ob_id'] = $insert;
            $update             = $this->_calc_vr_order_bill($data_bill);
            if (!$update) {
                throw new Exception('更新账单失败');
            }

            // 发送店铺消息
            $param             = [];
            $param['code']     = 'store_bill_affirm';
            $param['store_id'] = $data_bill['ob_store_id'];
            $param['param']    = [
                'state_time' => date('Y-m-d H:i:s', $data_bill['ob_start_date']),
                'end_time'   => date('Y-m-d H:i:s', $data_bill['ob_end_date']),
                'bill_no'    => $data_bill['ob_id']
            ];
            QueueClient::push('sendStoreMsg', $param);
        }
    }

    /**
     * 计算某月内，某店铺的销量，佣金
     *
     * @param array $data_bill
     * @return mixed
     */
    private function _calc_vr_order_bill($data_bill)
    {

        //计算已使用兑换码
        $order_condition               = [];
        $order_condition['vr_state']   = 1;
        $order_condition['store_id']   = $data_bill['ob_store_id'];
        $order_condition['vr_usetime'] = ['between', "{$data_bill['ob_start_date']},{$data_bill['ob_end_date']}"];

        $update = [];

        //订单金额
        $fields                    = 'sum(pay_price) as order_amount,SUM(ROUND(pay_price*commis_rate/100,2)) as commis_amount';
        $order_info                = $this->_model_vr_order->getOrderCodeInfo($order_condition, $fields);
        $update['ob_order_totals'] = floatval($order_info['order_amount']);

        //佣金金额
        $update['ob_commis_totals'] = $order_info['commis_amount'];

        //计算已过期不退款兑换码
        $order_condition                      = [];
        $order_condition['vr_state']          = 0;
        $order_condition['store_id']          = $data_bill['ob_store_id'];
        $order_condition['vr_invalid_refund'] = 0;
        $order_condition['vr_indate']         = ['between', "{$data_bill['ob_start_date']},{$data_bill['ob_end_date']}"];

        //订单金额
        $fields                    = 'sum(pay_price) as order_amount,SUM(ROUND(pay_price*commis_rate/100,2)) as commis_amount';
        $order_info                = $this->_model_vr_order->getOrderCodeInfo($order_condition, $fields);
        $update['ob_order_totals'] += floatval($order_info['order_amount']);

        //佣金金额
        $update['ob_commis_totals'] += $order_info['commis_amount'];

        //店铺名
        $store_info              = $this->_model_store->getStoreInfoByID($data_bill['ob_store_id']);
        $update['ob_store_name'] = $store_info['store_name'];

        //本期应结
        $update['ob_result_totals'] = $update['ob_order_totals'] - $update['ob_commis_totals'];
        $update['ob_create_date']   = TIMESTAMP;
        $update['ob_state']         = 1;
        $update['os_month']         = date('Ym', $data_bill['ob_end_date'] + 1);
        return $this->_model_vr_bill->editOrderBill($update, ['ob_id' => $data_bill['ob_id']]);
    }

    /*************************************分红********************************************************/

    /**
     * 检查会员分销过期
     */
    private function _checkMemberDistributionState()
    {
        $model                  = Model('member_detail');
        $con['is_distribution'] = 1;
        $con['distr_end']       = ['LT', time()];
        $data                   = $model->getMemberDetailList($con);
        $user_level_model       = Model('user_level');
        $level_info             = $user_level_model->getLevelAll();
        $level                  = [];
        foreach ($level_info as $val) {
            $level[$val['id']] = $val;
        }
        unset($level_info, $val);

        if (!empty($data)) {
            Db::beginTransaction();
            try {
                $model_member     = Model('member');
                $user_sales_model = Model('user_consumption_sales_log_day');

                foreach ($data as $v) {
                    //检查银尊及以上会员是否完成保底消费，如完成则自动延期
                    if ($level[$v['level_id']]['level'] > $user_level_model::LEVEL_ONE) {
                        $con['user_id']    = $v['member_id'];//会员
                        $con['type']       = $user_sales_model::LOG_TYPE_CONSUMPTION;//金额类型
                        $con['created_at'] = ['GT', strtotime("-1 year")];
                        $total_sales       = $user_sales_model->countUsersSales($con);
                        if ($total_sales >= $level[$v['level_id']]['bottom_consumption']) {
                            //完成保底消费
                            $model->editMemberDetail(['member_id' => $v['member_id']], ['distr_end' => strtotime("+1 year")]);//将会员分销结束时间延长一年
                            continue;
                        }
                    }
                    $model_member->editMember(['member_id' => $v['member_id']], ['is_distribution' => 2]);//将会员分销状态变更为过期
                }
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                return false;
            }

        }
        return true;
    }

    /**
     * 根据用户销售额达标获取贡献值
     */
    private function _userSalesGainC()
    {
        $sql  = "SELECT user_id,  sum(total_money) as total  FROM user_consumption_sale_log_day WHERE created_at>=" . date('Y-m', time()) . "&& type = 2 GROUP BY user_id";//分用户统计本月个人销售额
        $data = Model()->query($sql);
        if (!empty($data)) {
            $ids              = implode(',', array_column($data, 'user_id'));
            $sql              = "select member_id,sum(contribution) as c_val from contribution_log where create_time>=" . strtotime(date("Y-m", time())) . " && member_id in (" . $ids . ") && type=3 group by member_id";//分用户统计本月已赠送微商销售贡献值
            $contribution     = Model()->query($sql);
            $c_arrs           = array_column($contribution, 'c_val', 'member_id');
            $contribution_log = Model('contribution_log');
            foreach ($data as $item) {
                $c = intval($item['total'] / 20000) - $c_arrs[$item['user_id']];//获取当月贡献值差额（当月需赠送-已赠送）
                if ($c > 0) {
                    $contribution_log->operateContribution(['member_id'    => $item['user_id'],//操作贡献值
                                                            'type'         => $contribution_log::CONTRIBUTION_TYPE_SALES,
                                                            'val'          => 20000 * $c,
                                                            'contribution' => $c,
                                                            'operate'      => 1,
                                                            'create_time'  => TIMESTAMP,
                                                            'des'          => '个人月销售【' . val . '】获取贡献值' . $c . 'C'
                    ]);
                }
            }
        }
    }

    /**
     * 每日分红自转转入到HI值
     */
    private function _bonusAutoToHi()
    {
        //判断是否为月初
        if (date('Y-m-01', time() == date('Y-m-d', time()))) {
            Model()->query("update user_hi_value set allow_hi_to_bonus=bonus_to_hi");
        }
        //获取有设置自动分红转HI会员
        $autoToHiUser = Model('user_hi_value')->field('user_id,auto_to_hi_percent')->where(['auto_to_hi_percent' => ['GT', 0]])->select();
        $userIds      = implode(array_column($autoToHiUser, 'user_id'));
        $autoToHiUser = array_column($autoToHiUser, 'auto_to_hi_percent', 'user_id');
        //获取今日有新分红会员
        $member_bonus = Model('user_bonus_log')
            ->field('user_id,sum(money) as money')
            ->where(['created_at' => [['EGT', date('Y-m-d', TIMESTAMP)], ['LT', date('Y-m-d', strtotime('+1 day'))]],
                     'user_id'    => ['IN', $userIds]
            ])
            ->group('user_id')
            ->select();
        $member       = Model('member')->field('member_id,available_predeposit')->where(['member_id' => ['IN', $userIds]])->select();//获取会员当前预存款
        $member       = array_column($member, 'available_predeposit', 'member_id');
        if (!empty($member_bonus)) {
            $member_sql      = "UPDATE member SET available_predeposit = CASE member_id ";//批量更新会员预存款SQL
            $pd_log_sql      = "INSERT INTO pd_log (lg_member_id,lg_type,lg_av_amount,lg_freeze_amount,lg_add_time,lg_desc) VALUES ";//新增预存款操作日志记录
            $member_hi_sql   = "UPDATE user_hi_value SET bonus_to_hi = CASE user_id "; //批量更新用户HI值
            $user_hi_log_sql = "INSERT INTO user_hi_log (user_id,hi_value,hi_type,get_type,created_at,remark) VALUES ";//批量新增用户HI值变更记录
            $i               = 0;
            foreach ($member_bonus as $val) {
                $money = number_format($val['money'] * $autoToHiUser[$val['user_id']], 2);
                if ($money > $member[$val['user_id']]) {
                    continue;//如果当前预存款不能足额扣取则不执行
                }
                $member_sql      .= sprintf("WHEN %d THEN available_predeposit-%.2f ", $val['user_id'], $money);
                $pd_log_sql      .= sprintf("(%d,'%s',%.2f,%d,%d,'用户转入HI值,减少预存款')", $val['user_id'], 'bonus_to_hi', -$money, 0, TIMESTAMP) . ',';
                $member_hi_sql   .= sprintf("WHEN %d THEN bonus_to_hi+%.2f ", $val['user_id'], $money);
                $user_hi_log_sql .= sprintf("(%d,%.2f,%d,%d,'%s','%s')", $val['user_id'], $money, 3, 1, date('Y-m-d H:i:s', time()), '增加HI值' . $money) . ',';
                ++$i;
            }
            $member_sql      .= "END WHERE member_id IN (" . $userIds . ")";
            $pd_log_sql      = rtrim($pd_log_sql, ',');
            $member_hi_sql   .= "END WHERE user_id IN (" . $userIds . ")";
            $user_hi_log_sql = rtrim($user_hi_log_sql, ',');

        }
        if ($i == 0) {
            return;//没有sql语句则返回
        }
        Model::beginTransaction();
        try {
            $res = Model()->execute($member_sql);//扣除预存款
            if (!$res) {
                throw new Exception('预存款扣除失败');
            }
            $res = Model()->execute($pd_log_sql);//新增预存款变更记录
            if (!$res) {
                throw new Exception('预存款新增日志失败');
            }
            $res = Model()->execute($member_hi_sql);//新增HI值
            if (!$res) {
                throw new Exception('新增HI值失败');
            }
            $res = Model()->execute($user_hi_log_sql);//新增HI值变更记录
            if (!$res) {
                throw new Exception('HI值新增日志失败');
            }
            Model::commit();
        } catch (Exception $e) {
            Model::rollback();
            p($e->getMessage());
        }
    }

    /**
     * 分红分期表数据处理
     * 28天为一期 一期4周
     */
    public function _edit_stages()
    {
        $stagesModel        = Model('stages');
        $stagesCrontabModel = new stages_crontabModel();
        $getStagesInfo      = $stagesModel->getUserBonusStagesInfo(['status' => 1], 1)[0];//获取最新一期的数据【status=1】 1=进行中 0=已闭环

        if (!empty($getStagesInfo)) {
            $nowTime = date('Y-m-d H:i:s');//获取当前时间
            if ($nowTime > $getStagesInfo['end_time']) { //当前时间 > 上一期结束时间

                $where['created_at'] = ['between', [$getStagesInfo['start_time'], $getStagesInfo['end_time']]];
                //获取平台税前总利润
                $goodsAfterTaxProfitLogModel = Model('goods_after_tax_profit_log');
                $getRemainingMoney           = $goodsAfterTaxProfitLogModel->where($where)->field('sum(total_money) as total_money')->find();

                //获取时间段内已分红金额
                $where['user_id']  = ['neq', 1];
                $where['type']     = [['neq', 13], ['neq', 14], 'and'];//不应包括货款及运费 2019/4/9
                $userBonusLogModel = Model('user_bonus_log');
                $getUserBonusMoney = $userBonusLogModel->where($where)->field('sum(money) as total_money')->find();


                //计算平台总利润税
                $money = bcmul($getRemainingMoney['total_money'], '0.25');


                //修改期数中的总利润、剩余利润、状态
                $data['money']       = ($getRemainingMoney['total_money'] - $money) - $getUserBonusMoney['total_money']; //平台剩余利润 = 平台税后总利润 - 已分红金额
                $data['total_money'] = ($getRemainingMoney['total_money'] - $money); //税后总利润 = 平台税前总利润 - 税
                $data['status']      = 0;
                $saveInfo            = $stagesModel->saveUserBonusStagesInfo(['id' => $getStagesInfo['id']], $data);
                if ($saveInfo) {
                    //将上一期闭环后创建新一期数据
                    $stages_id = $stagesModel->addUserBonusStagesInfo();
                    // 创建新一期分红自动执行日期
                    $stagesCrontabModel->addUserBonusStagesCrontabInfo($stages_id);
                }
            }
        } else {
            //创建第一期数据
            $stages_id = $stagesModel->addUserBonusStagesInfo();
            // 创建第一期分红自动执行日期
            $stagesCrontabModel->addUserBonusStagesCrontabInfo($stages_id);
        }

    }

}