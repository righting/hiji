<?php
/**
 * 实物订单行为
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class orderLogic
{

    /**
     * 取消订单
     *
     * @param array   $order_info
     * @param string  $role              操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string  $user              操作人
     * @param string  $msg               操作备注
     * @param boolean $if_update_account 是否变更账户金额
     * @param array   $cancel_condition  订单更新条件,目前只传入订单状态，防止并发下状态已经改变
     * @return array
     */
    public function changeOrderStateCancel($order_info, $role, $user = '', $msg = '', $if_update_account = true, $cancel_condition = [])
    {
        try {
            $model_order = Model('order');
            $model_order->beginTransaction();
            $order_id = $order_info['order_id'];

            //库存销量变更
            $goods_list = $model_order->getOrderGoodsList(['order_id' => $order_id]);
            $data       = [];
            foreach ($goods_list as $goods) {
                $data[$goods['goods_id']] = $goods['goods_num'];
            }
            $result = Logic('queue')->cancelOrderUpdateStorage($data);
            if (!$result['state']) {
                throw new Exception('还原库存失败');
            }
            if ($order_info['chain_id']) {
                $result = Logic(queue)->cancelOrderUpdateChainStorage($data, $order_info['chain_id']);
                if (!$result['state']) {
                    throw new Exception('还原门店库存失败');
                }
            }

            if ($if_update_account) {
                $model_pd = Model('predeposit');
                //解冻充值卡
                $rcb_amount = floatval($order_info['rcb_amount']);
                if ($rcb_amount > 0) {
                    $data_pd                = [];
                    $data_pd['member_id']   = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount']      = $rcb_amount;
                    $data_pd['order_sn']    = $order_info['order_sn'];
                    $model_pd->changeRcb('order_cancel', $data_pd);
                }

                //解冻预存款
                $pd_amount = floatval($order_info['pd_amount']);
                if ($pd_amount > 0) {
                    $data_pd                = [];
                    $data_pd['member_id']   = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount']      = $pd_amount;
                    $data_pd['order_sn']    = $order_info['order_sn'];
                    $model_pd->changePd('order_cancel', $data_pd);
                }
            }

            //更新订单信息
            $update_order                 = ['order_state' => ORDER_STATE_CANCEL];
            $cancel_condition['order_id'] = $order_id;
            $update                       = $model_order->editOrder($update_order, $cancel_condition);
            if (!$update) {
                throw new Exception('保存失败');
            }

            //添加订单日志
            $data             = [];
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_msg']  = '取消了订单';
            $data['log_user'] = $user;
            if ($msg) {
                $data['log_msg'] .= ' ( ' . $msg . ' )';
            }
            $data['log_orderstate'] = ORDER_STATE_CANCEL;
            $model_order->addOrderLog($data);
            $model_order->commit();

            return callback(true, '操作成功');

        } catch (Exception $e) {
            $model_order->rollback();
            return callback(false, '操作失败');
        }
    }

    /**
     * @TODO 13.收货
     * 收货
     * @param array  $order_info
     * @param string $role 操作角色 buyer、seller、admin、system,chain 分别代表买家、商家、管理员、系统、门店
     * @param string $user 操作人
     * @param string $msg  操作备注
     * @return array
     */
    public function changeOrderStateReceive($order_info, $role, $user = '', $msg = '')
    {
        try {

            $order_id    = $order_info['order_id'];
            $model_order = Model('order');

            //更新订单状态
            $update_order                  = [];
            $update_order['finnshed_time'] = TIMESTAMP;
            $update_order['order_state']   = ORDER_STATE_SUCCESS;
            $update                        = $model_order->editOrder($update_order, ['order_id' => $order_id]);
            if (!$update) {
                throw new Exception('保存失败');
            }

            //添加订单日志
            $data                   = [];
            $data['order_id']       = $order_id;
            $data['log_role']       = $role;
            $data['log_msg']        = $msg;
            $data['log_user']       = $user;
            $data['log_orderstate'] = ORDER_STATE_SUCCESS;
            $model_order->addOrderLog($data);
            if ($order_info['buyer_id'] > 0 && $order_info['order_amount'] > 0) {
                $this->splitOrderGoodsListsForStore($order_info);// 确认收货拆分订单
            }
            return callback(true, '操作成功');
        } catch (Exception $e) {
            return callback(false, '操作失败');
        }
    }


    /**
     * @解冻
     *
     * @param array  $order_info
     * @param string $role 操作角色 buyer、seller、admin、system,chain 分别代表买家、商家、管理员、系统、门店
     * @param string $user 操作人
     * @param string $msg  操作备注
     * @return array
     */
    public function changeOrderStateThaw($order_info, $role, $user = '', $msg = '')
    {
        try {

            $order_id    = $order_info['order_id'];
            $model_order = Model('order');

            //更新订单状态
            $update_order = [];
            $update_order['thaw_time'] = TIMESTAMP;
            $update_order['order_state'] = 50;//50为解冻
            $update                      = $model_order->editOrder($update_order, ['order_id' => $order_id]);
            if (!$update) {
                throw new Exception('保存失败');
            }

            //添加订单日志
            $data                   = [];
            $data['order_id']       = $order_id;
            $data['log_role']       = $role;
            $data['log_msg']        = $msg;
            $data['log_user']       = $user;
            $data['log_orderstate'] = 50;
            $model_order->addOrderLog($data);
            return callback(true, '操作成功');
        } catch (Exception $e) {
            return callback(false, '操作失败');
        }
    }


    /**
     * 订单延迟
     *
     * @param array  $order_info
     * @param string $role 操作角色 buyer、seller、admin、system,chain 分别代表买家、商家、管理员、系统、门店
     * @param string $user 操作人
     * @param string $msg  操作备注
     * @return array
     */
    public function changeOrderStateDelay($order_info, $role, $user = '', $msg = '')
    {
        try {

            $order_id     = $order_info['order_id'];
            $model_order  = Model('order');
            $setModel     = Model('setting');
            $list_setting = $setModel->getListSetting();
            //更新订单状态
            $update_order                = [];
            $update_order['delays_time'] = $list_setting['order_delay_time'];
            $update                      = $model_order->editOrder($update_order, ['order_id' => $order_id]);
            if (!$update) {
                throw new Exception('保存失败');
            }

            //添加订单日志
            $data                   = [];
            $data['order_id']       = $order_id;
            $data['log_role']       = $role;
            $data['log_msg']        = $msg;
            $data['log_user']       = $user;
            $data['log_orderstate'] = 30;
            $model_order->addOrderLog($data);
            return callback(true, '操作成功');
        } catch (Exception $e) {
            return callback(false, '操作失败');
        }
    }


    private $_order_info = [];

    // 确认收货拆分订单
    public function splitOrderGoodsListsForStore($order_info)
    {
        $order_model                       = Model('order');
        $field                             = '*';
        $order_goods_condition['order_id'] = $order_info['order_id'];
        $order_goods_condition['buyer_id'] = $order_info['buyer_id'];
        $order_goods_list                  = $order_model->getOrderGoodsList($order_goods_condition, $field);
        $this->_order_info                 = $order_info;
        /**
         * 解冻时才分红
         * 2019-11-5
         */
        // 处理所有订单信息
        //$this->getNewStoreUserAmountOfMoney($order_goods_list);
        //$this->getStoreUserAmountOfMoney($order_goods_list, $order_info);

        // 获取当前订单是否是补单订单
        $order_id                   = $order_info['order_id'];
        $refund_return_bd_log_model = Model('refund_return_bd_log');
        $bd_list                    = $refund_return_bd_log_model->where(['order_id' => $order_id])->select();
        if (!empty($bd_list)) {
            // 如果是补单订单，那么将所有当前订单id对应的补单id状态都改为已完成
            $finished_at = date('Y-m-d H:i:s');
            $refund_return_bd_log_model->where(['order_id' => $order_id])->update(['status' => 2, 'finished_at' => $finished_at]);
            // 获取这条订单补单的时间
            $created_at = $bd_list[0]['created_at'];
            // 检查这些需要补单的订单在相同时间内有没有其他的订单也参与了补单，且状态是未补单的，如果没有了，就需要将退货退款表中这些退货/退款id的信息改为已补单
            $refund_id_arr                   = array_column($bd_list, 'refund_id');
            $refund_list_where['refund_id']  = ['in', $refund_id_arr];
            $refund_list_where['created_at'] = $created_at;
            $refund_list_where['status']     = 1;
            $refund_list                     = $refund_return_bd_log_model->where($refund_list_where)->select();
            if (empty($refund_list)) {
                $refund_return_model = Model('refund_return');
                $refund_return_model->where(['refund_id' => ['in', $refund_id_arr]])->update(['refund_state' => 5]);
            }
        }
    }

    // 支付成功拆分订单
    public function splitOrderGoodsLists($order_info)
    {
        $order_model                       = Model('order');
        $goods_class_model                 = Model('goods_class');
        $field                             = '*';
        $order_goods_condition['order_id'] = $order_info['order_id'];
        $order_goods_condition['buyer_id'] = $order_info['buyer_id'];
        $order_goods_list                  = $order_model->getOrderGoodsList($order_goods_condition, $field);
        // 获取所有属于海豚主场的分类
        $ht_first_id     = $goods_class_model::HT_CATEGORY_TYPE;
        $ht_class_id_arr = $goods_class_model->getChildClass($ht_first_id);
        $ht_class_ids    = array_column($ht_class_id_arr, 'gc_id');
        // 检查订单中是否有属于海豚主场的子订单
        $ht_order_goods_list    = [];              // 海豚主场订单
        $other_order_goods_list = [];           // 其他类目订单
        $fx_order_goods_list    = [];              // 分销推广订单
        $pt_order_goods_list    = [];              // 直销订单
        foreach ($order_goods_list as $value) {
            // 将海豚主场的订单与其他订单分开
            /*if (in_array($value['gc_id'], $ht_class_ids)) {
                $ht_order_goods_list[$value['rec_id']] = $value;
            } else {
                $other_order_goods_list[$value['rec_id']] = $value;
            }*/
            // 2017年11月29日09:38:21需求更新：海豚主场选择了用来升级的订单不计入销售/消费额
            // 将升级商品订单和非升级商品订单分开
            if ($value['is_deduction'] == 1) {
                $ht_order_goods_list[$value['rec_id']] = $value;
            } else {
                $other_order_goods_list[$value['rec_id']] = $value;
            }

            // 将分销推广订单与直销订单分开
            if ($value['referral_key']) {
                $fx_order_goods_list[$value['rec_id']] = $value;
            } else {
                $pt_order_goods_list[$value['rec_id']] = $value;
            }
        }
        $this->_order_info = $order_info;

        /**
         * 处理所有订单信息 $this->getStoreUserAmountOfMoney($order_goods_list)
         *
         * @since 2018/06/08 修改为订单确认收货后才执行分红
         */
        //$this->getStoreUserAmountOfMoney($order_goods_list);

        // 分别将海豚主场的积分和其他消费的积分加给用户
        // 计算海豚主场消费金额
        $ht_total_money = array_column($ht_order_goods_list, 'goods_pay_price');
        // 计算非海豚主场消费金额
        $other_total_money = array_column($other_order_goods_list, 'goods_pay_price');
        // 计算可获得的海豚主场积分
        $hs_count = array_sum($ht_total_money);
        // 计算可获得的非海豚主场积分
        $h_count = array_sum($other_total_money);
        if (C('points_isuse') == 1) {
            if ($hs_count > 0) {
                Model()->table('orders')->where(['order_id' => $order_info['order_id']])->update(['hs_count' => $hs_count]);
                /*$ht_data['pl_memberid'] = $order_info['buyer_id'];
                $ht_data['pl_membername'] = $order_info['buyer_name'];
                $ht_data['orderprice'] = $hs_count;
                $ht_data['order_sn'] = $order_info['order_sn'];
                $ht_data['order_id'] = $order_info['order_id'];
                Model('points')->savePointsLog('order', $ht_data, true);*/
            }
            if ($h_count) {
                Model()->table('orders')->where(['order_id' => $order_info['order_id']])->update(['h_count' => $h_count]);
                /*$h_data['pl_memberid'] = $order_info['buyer_id'];
                $h_data['pl_membername'] = $order_info['buyer_name'];
                $h_data['orderprice'] = $h_count;
                $h_data['order_sn'] = $order_info['order_sn'];
                $h_data['order_id'] = $order_info['order_id'];
                Model('points')->savePointsLog('order_for_other', $h_data, true);*/
            }

        }
    }

    /**
     * 支付成功时就开始分红 @TODO 店铺收到的钱在确认收货时才会到，其他的钱在买家支付成功时就会到账 2017年12月7日18:18:12 需求修改
     *
     * @since 2018/06/08 修改为订单确认收货后才执行分红
     * @param $order_goods_list
     * @param $orderInfo
     */
    public function getStoreUserAmountOfMoney($order_goods_list, $orderInfo)
    {
        $order_info = $orderInfo;
        // p('//////////////////////订单：'.$order_info['order_sn'].'开始处理...//////////////////////');
        // 获取所有店主store_id
        $store_id_arr = array_column($order_goods_list, 'store_id');
        // 根据store_id获取店铺对应的用户信息
        $store_model           = new storeModel();
        $store_info_list_field = 'store_id,store_name,grade_id,member_id,member_name,seller_name';
        $store_info_list       = $store_model->where(['store_id' => ['in', $store_id_arr]])->field($store_info_list_field)->select();
        $new_store_info_list   = [];
        foreach ($store_info_list as $s_i_l_key => $s_i_l_value) {
            // 以店铺id作为数组的键
            $new_store_info_list[$s_i_l_value['store_id']] = $s_i_l_value;
        }
        $store_member_id_arr = array_column($new_store_info_list, 'member_id');
        // 获取这些店铺的拥有者所属团队的用户id（推荐供应商入驻的用户id,如果没有人推荐，那就是平台推荐）
        $store_join_model = new store_joininModel();
        //TODO 订单的供应商多个情况
        $store_register_info     = $store_join_model->where(['member_id' => ['in', $store_member_id_arr]])->field('member_id,invite_user_id,invite_user_level_id')->find();
        $store_invite_user_id    = 1;// 平台的自营会员id
        $store_invite_user_level = 6;// 平台等级：至尊会员
        if (!empty($store_register_info)) {
            $store_invite_user_id    = $store_register_info['invite_user_id'];
            $store_invite_user_level = $store_register_info['invite_user_level_id'];
        }
        $register_invite_model               = new register_inviteModel();
        $pd_model                            = new predepositModel();
        $member_model                        = new memberModel();
        $platform_profit_model               = new platform_profitModel();
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $goods_model                         = new goodsModel();

        $buyer_user_id = $order_info['buyer_id'];
        // 获取当前订单所有商品的id
        $goods_id_arr = array_column($order_goods_list, 'goods_id');
        // 获取当前订单所有商品的名称
        $goods_name_arr = array_column($order_goods_list, 'goods_name');
        // 获取当前订单所有商品的运费,供货价，销售价
        $goods_info_arr = $goods_model->table('goods')->where(['goods_id' => ['in', $goods_id_arr]])->field('goods_id,goods_freight,goods_costprice,goods_price')->select();
        // 以商品goods_id为键重组数据
        $goods_info_arr_for_goods_id = array_combine(array_column($goods_info_arr, 'goods_id'), $goods_info_arr);
        // 以商品goods_id为键，运费为值，重组数据
        $shipping_fee_arr_for_goods_id = array_combine(array_column($goods_info_arr, 'goods_id'), array_column($goods_info_arr, 'goods_freight'));
        // 获取当前订单所有商品的分类
        $goods_class_arr = array_column($order_goods_list, 'gc_id');
        // 根据商品分类获取对应的佣金比例
        $goods_class_model          = new goods_classModel();
        $goods_class_commission_arr = $goods_class_model->where(['gc_id' => ['in', $goods_class_arr]])->field('gc_id,commis_rate as commission_rate')->select();
        // 以分类id为键，佣金比例为值，重组数据
        $goods_class_commission_for_id = array_combine(array_column($goods_class_commission_arr, 'gc_id'), array_column($goods_class_commission_arr, 'commission_rate'));
        $user_level_model              = new user_levelModel();
        // 获取邀请当前用户加入团队的用户
        $team_parent_user_info = $register_invite_model->where(['to_user_id' => $buyer_user_id])->field('from_user_id')->find();
        $team_parent_user_id   = 0;  // 没有人邀请
        if ($team_parent_user_info) {
            $team_parent_user_id = $team_parent_user_info['from_user_id'];
        }
        // 获取所有微商城卖出去的商品的卖家信息
        $seller_goods_referral_key_arr = array_filter(array_column($order_goods_list, 'referral_key'));
        $referral_key_arr              = [];
        if (!empty($seller_goods_referral_key_arr)) {
            foreach ($seller_goods_referral_key_arr as $referral_key) {
                $referral_key_arr[] = $goods_model->getGoodsReferralKey($referral_key);
            }
        }
        $seller_user_info_for_id = [];
        if (!empty($referral_key_arr)) {
            $seller_user_id_arr = array_column($referral_key_arr, 'user_id');
            $seller_user_info   = $member_model->where(['member_id' => ['in', $seller_user_id_arr]])->field('member_id,member_name,level_id,positions_id')->select();
            // 个人微商卖家信息
            $seller_user_info_for_id = array_combine(array_column($seller_user_info, 'member_id'), $seller_user_info);
        }
        // 获取用户等级对应的分享比例
        $user_level_info_arr                        = $user_level_model->select();
        $user_level_info_id_and_seller_royalty_rate = array_combine(array_column($user_level_info_arr, 'id'), array_column($user_level_info_arr, 'seller_royalty_rate'));

        $user_bonus_log_model              = new user_bonus_logModel();
        $type_supply_money                 = $user_bonus_log_model::TYPE_SUPPLY_MONEY;// 供货款
        $type_supply_freight               = $user_bonus_log_model::TYPE_SUPPLY_FREIGHT; // 商品运费
        $type_sales_share_bonus            = $user_bonus_log_model::TYPE_SALES_SHARE_BONUS;// 个人消费分红
        $type_sales_share_bonus_for_team   = $user_bonus_log_model::TYPE_SALES_SHARE_BONUS_FOR_TEAM;// 团队销售分享分红
        $type_sales_share_bonus_for_seller = $user_bonus_log_model::TYPE_SALES_SHARE_BONUS_FOR_SELLER;// 专项消费商品分红完成后的金额
        $type_supplier_referral_bonus      = $user_bonus_log_model::TYPE_SUPPLIER_REFERRAL_BONUS;// 供应商推荐奖金


        $type_corporate_profits        = $platform_profit_model::TYPE_ORDER_BUY;// 平台利润
        $type_tax_rate_money           = $platform_profit_model::TYPE_BONUS;// 销售服务税
        $type_type_surplus_total_money = $platform_profit_model::TYPE_SURPLUS_PROFIT;// 剩余可分红利润
        $platform_profit_log_data      = [];
        $user_bonus_log_data           = [];
        $seller_user_data              = [];
        $surplus_total_money_data      = [];
        $goods_after_tax_profit_log    = [];
        $user_bonus_pool_data          = [];
        $user_bonus_pool_model         = new user_bonus_poolModel();
        $setting_model                 = new settingModel();

        $field_array = [
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

        $set_field_arr          = $setting_model->where(['name' => ['in', $field_array]])->select();
        $set_field_arr_for_name = array_combine(array_column($set_field_arr, 'name'), array_column($set_field_arr, 'value'));
        // 获取平台税率
        $tax_rate = $set_field_arr_for_name['PLATFORM_TAX_RATE'];
        // p('平台税率:'.$tax_rate);
        // 获取个人消费分红比例
        $USER_CONSUMPTION_BONUS_RATIO = $set_field_arr_for_name['USER_CONSUMPTION_BONUS_RATIO'];
        // 获取专项消费顶级分类id
        $annual_fee_gc_id          = $set_field_arr_for_name['annual_fee_gc_id'];
        $now_date                  = date('Y-m-d H:i:s');
        $zx_bonus_order_money_arr  = []; // 专项消费订单金额
        $not_bonus_order_money_arr = [];    // 升级订单金额
        foreach ($order_goods_list as $key => $value) {
            $system_bonus_log_arr[$key]['order_id'] = $order_info['order_id'];
            $system_bonus_log_arr[$key]['order_sn'] = $order_info['order_sn'];
            $system_bonus_log_arr[$key]['goods_id'] = $value['goods_id'];
            $remark_arr[]                           = '订单号：' . $order_info['order_sn'];
            $remark_arr[]                           = '平台税率：' . $tax_rate;
            // 当前商品应该转给店铺的钱(如果是赠品，则直接跳过)
            if ($value['goods_pay_price'] == 0) {
                $system_bonus_log_arr[$key]['remark'] = '当前商品id：' . $value['goods_id'] . '当前商品名称：' . $value['goods_name'] . '的赠品，不参与分红，直接跳过';
                continue;
            }
            // 如果当前商品是升级订单商品或者专项消费商品，那么用户的消费销售额不会计入分红消费销售额中
            $remark_arr[] = '当前商品id：' . $value['goods_id'];
            $remark_arr[] = '当前商品名称：' . $value['goods_name'];
            $remark_arr[] = '当前商品购买数量：' . $value['goods_num'];
            $remark_arr[] = '当前商品供货价：' . $goods_info_arr_for_goods_id[$value['goods_id']]['goods_costprice'];
            // 转给店铺的钱
            $money_transferred_to_the_store = bcmul($goods_info_arr_for_goods_id[$value['goods_id']]['goods_costprice'], $value['goods_num']);
            // 供货款
            $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                $new_store_info_list[$value['store_id']]['member_id'],
                $type_supply_money,
                $money_transferred_to_the_store,
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );

            // 转给店铺的当前商品的运费
            $this_goods_freight = $shipping_fee_arr_for_goods_id[$value['goods_id']];
            // p('2.转给店铺的当前商品的运费:'.$this_goods_freight);
            $remark_arr[] = '转给店铺的当前商品的运费：' . $this_goods_freight;
            // 商品运费
            if ($this_goods_freight > 0) {
                $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                    $new_store_info_list[$value['store_id']]['member_id'],
                    $type_supply_freight,
                    $this_goods_freight,
                    $order_info['order_id'],
                    $value['goods_id'],
                    $order_info['order_sn']
                );
            }

            if ($value['is_deduction'] == 1) {
                $not_bonus_order_money_arr[] = $value['goods_pay_price'];
            }

            // 当前商品的总销售利润（当前商品总价 - 当前商品应该转给店铺的钱）
            $sales_profit = bcsub($value['goods_pay_price'], $money_transferred_to_the_store, 2);


            //商品总价格 = 商品单价 * 购买的商品数量   ---------2018/04/27
            $sales_order_totalMoney = $value['goods_pay_price'];


            // p('3.当前商品的总销售利润（当前商品总价 - 当前商品应该转给店铺的钱）:'.$sales_profit);
            $remark_arr[] = '当前商品税前利润（当前商品总价 - 供应商货款价格）：' . $sales_profit;
            // 如果当前商品的佣金比例大于0才有分红
            if ($goods_class_commission_for_id[$value['gc_id']] <= 0) {
                // p('|-当前商品的佣金为0，没有分红');
                $remark_arr[] = '当前商品的佣金为0，没有分红';
                continue;
            }
            // 平台利润提成比例
            $this_goods_rate = $goods_class_commission_for_id[$value['gc_id']];
            // p('平台利润提成比例:'.$this_goods_rate);
            $remark_arr[] = '平台利润提成比例：' . $this_goods_rate;
            // 平台利润（当前商品的税前总销售利润*20%）
            $platform_profit = bcdiv(bcmul($sales_profit, $this_goods_rate, 2), 100, 2);
            // p('平台利润（当前商品的税前总销售利润*20%）:'.$platform_profit);
            $remark_arr[] = '平台利润（当前商品的税前总销售利润*20%）:' . $platform_profit;
            // 平台利润
            $platform_profit_log_data[] = $this->getPlatformProfitLogDataArr(
                $type_corporate_profits,// 平台利润
                $platform_profit,// 平台利润（当前商品的税前总销售利润*20%）
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );
            // 销售服务税（税前销售利润*销售服务税率）
            $this_goods_tax_rate_money = bcdiv(bcmul($sales_profit, $tax_rate, 2), 100, 2);
            // p('销售服务税（税前销售利润*销售服务税率）:'.$this_goods_tax_rate_money);
            $remark_arr[] = '销售服务税（税前销售利润*销售服务税率）:' . $this_goods_tax_rate_money;
            // 销售服务税
            $platform_profit_log_data[] = $this->getPlatformProfitLogDataArr(
                $type_tax_rate_money,// 销售服务税
                $this_goods_tax_rate_money,// 销售服务税（税前销售利润*销售服务税率）
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );
            //平台税前利润
            $goods_total_money = $sales_profit;
            // 税后剩余可分配的销售利润 = 当前商品的总销售利润 - 销售服务税
            $after_tax_profit = bcsub($sales_profit, $this_goods_tax_rate_money, 2);
            // p('税后剩余可分配的销售利润 = 当前商品的总销售利润 - 销售服务税:'.$after_tax_profit);
            $remark_arr[] = '税后剩余可分配的销售利润 = 当前商品的总销售利润 - 销售服务税:' . $after_tax_profit;
            // 个人消费分红（税后利润*个人消费分红比例）
            $personal_consumption_bonus = bcdiv(bcmul($after_tax_profit, $USER_CONSUMPTION_BONUS_RATIO, 2), 100, 2);
            // p('个人消费分红（税后利润*个人消费分红比例）:'.$personal_consumption_bonus);
            $remark_arr[] = '个人消费分红比例:' . $USER_CONSUMPTION_BONUS_RATIO;
            $remark_arr[] = '个人消费分红（税后利润*个人消费分红比例）:' . $personal_consumption_bonus;

            //商品税后利润、变量值不会发生改变
            $goods_after_tax_profit = $after_tax_profit;
            //平台剩余利润 = 税后剩余可分配的销售利润 - 个人消费分红 --------2018/04/27
            $after_tax_profit = bcsub($after_tax_profit, $personal_consumption_bonus, 2);

            // 个人消费分红
            $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                $buyer_user_id,
                $type_sales_share_bonus,
                $personal_consumption_bonus,
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );

            /**********************************************************/
            $system_bonus_log_arr[$key]['from_user_id'] = $buyer_user_id;
            $system_bonus_log_arr[$key]['to_user_id']   = $buyer_user_id;
            $system_bonus_log_arr[$key]['to_seller_id'] = 0;
            $system_bonus_log_arr[$key]['to_store_id']  = $new_store_info_list[$value['store_id']]['member_id'];
            $system_bonus_log_arr[$key]['created_at']   = $now_date;
            /**********************************************************/

            // 获取当前商品剩余的利润
            //$surplus_total_money = bcsub($after_tax_profit,$personal_consumption_bonus,2);

            // 2018/04/27
            $surplus_total_money = $after_tax_profit;

            // p('当前商品剩余的利润:'.$surplus_total_money);
            $remark_arr[] = '当前商品剩余的利润:' . $surplus_total_money;
            // 如果是专项消费或者是从个人微商城购买的商品，扣除个人消费分红后剩余的销售利润全部归公司所有，不再参与到以下的分红中去
            // 获取当前商品类型深度直到顶级
            $root_id_arr = $goods_class_model->getGoodsClassArrayFirstId(intval($value['gc_id']));
            // 获取当前商品类型的顶级分类id
            $first_id = reset($root_id_arr);
            // p('当前商品类型的顶级分类id:'.$first_id);
            $goods_class_name_arr = $goods_class_model->where(['gc_id' => $first_id])->field('gc_name')->find();
            $remark_arr[]         = '当前商品类型的顶级分类id:' . $first_id;
            $remark_arr[]         = '当前商品类型的顶级分类名称:' . $goods_class_name_arr['gc_name'];
            // 如果当前商品属于专项消费商品
            if (in_array($first_id, [$annual_fee_gc_id])) {
                $zx_bonus_order_money_arr[] = $value['goods_pay_price'];
                $remark_arr[]               = '当前商品属于专项消费商品';
                // 获取当前商品剩余的利润
                unset($surplus_total_money);
                // 专项消费商品剩余的利润 = 税后剩余可分配的销售利润 - 个人消费分红 - 平台利润   2018/04/27
                //$surplus_total_money = bcsub(bcsub($after_tax_profit,$personal_consumption_bonus,2),$platform_profit,2);
                $surplus_total_money = bcsub($after_tax_profit, $platform_profit, 2);

                $remark_arr[] = '专项消费商品剩余的利润 = 税后剩余可分配的销售利润 - 个人消费分红 - 平台利润:' . $surplus_total_money;
                // 专项消费商品剩余的利润全部转给平台
                $platform_profit_log_data[] = $this->getPlatformProfitLogDataArr(
                    $type_type_surplus_total_money,
                    $surplus_total_money,
                    $order_info['order_id'],
                    $value['goods_id'],
                    $order_info['order_sn']
                );

                $system_bonus_log_arr[$key]['surplus_total_money'] = $surplus_total_money;
                $system_bonus_log_arr[$key]['remark']              = implode('|', $remark_arr);
                unset($remark_arr);
                continue;
            }

            // 个人微商销售分红：帮忙卖出该商品的人
            if ($value['referral_key'] != '') {
                // p('|-当前商品属于个人微商销售');
                $remark_arr[]     = '当前商品属于个人微商销售';
                $referral_key_arr = $goods_model->getGoodsReferralKey($value['referral_key']);
                if (empty($referral_key_arr)) {
                    // p('|--微商信息有误');
                    $remark_arr[]                         = '微商信息有误';
                    $system_bonus_log_arr[$key]['remark'] = implode('|', $remark_arr);
                    unset($remark_arr);
                    continue;
                }
                $seller_user_id = $referral_key_arr['user_id'];
                $remark_arr[]   = '微商会员id：' . $seller_user_id;
                if (!isset($seller_user_info_for_id[$seller_user_id])) {
                    $remark_arr[]                         = '微商不存在';
                    $system_bonus_log_arr[$key]['remark'] = implode('|', $remark_arr);
                    unset($remark_arr);
                    continue;
                }
                $seller_user_info       = $seller_user_info_for_id[$seller_user_id];
                $seller_user_level_rate = $user_level_info_id_and_seller_royalty_rate[$seller_user_info['level_id']];
                $remark_arr[]           = '当前微商用户可获得的分享比例：' . $seller_user_level_rate;
                // 个人微商可获得的提成（商品税后利润*各级别会员分享比例）
                $sales_share_bonus_for_seller = bcdiv(bcmul($after_tax_profit, $seller_user_level_rate, 2), 100, 2);
                $remark_arr[]                 = '个人微商可获得的提成（当前商品税后利润*各级别会员分享比例）：' . $sales_share_bonus_for_seller;
                // 个人微商销售分红
                if ($sales_share_bonus_for_seller > 0) {

                    // 个人微商可获得的提成不能超过后台设定的最高金额，2019-6-12
                    if (intval($set_field_arr_for_name['type_sales_share_bonus_for_seller_money']) > 0 && $sales_share_bonus_for_seller > $set_field_arr_for_name['type_sales_share_bonus_for_seller_money']) {
                        $sales_share_bonus_for_seller = $set_field_arr_for_name['type_sales_share_bonus_for_seller_money'];
                    }

                    $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                        $seller_user_id,
                        $type_sales_share_bonus_for_seller,
                        $sales_share_bonus_for_seller,
                        $order_info['order_id'],
                        $value['goods_id'],
                        $order_info['order_sn']
                    );
                    // 如果是从个人微商城里面买的，需要给微商城的拥有者加销售额
                    $seller_user_data[$seller_user_id][] = $value['goods_pay_price'];
                    $remark_arr[]                        = '给微商城的拥有者增加的销售额：' . $value['goods_pay_price'];
                    // 获取当前商品剩余的利润
                    $last_surplus_total_money = bcsub(bcsub($surplus_total_money, $sales_share_bonus_for_seller, 2), $platform_profit, 2);
                    $remark_arr[]             = '获取当前商品剩余的利润：' . $last_surplus_total_money;
                    // 剩余可分红利润
                    $platform_profit_log_data[] = $this->getPlatformProfitLogDataArr(
                        $type_type_surplus_total_money,
                        $last_surplus_total_money,
                        $order_info['order_id'],
                        $value['goods_id'],
                        $order_info['order_sn']
                    );
                }
                $system_bonus_log_arr[$key]['to_seller_id'] = $seller_user_id;
                $system_bonus_log_arr[$key]['remark']       = implode('|', $remark_arr);
                unset($remark_arr);
                continue;
            }
            // 检查当前买家有没有上级团队，如果有，计算团队消费共享分红可分配金额
            $sales_share_bonus_for_team = 0;
            if ($team_parent_user_id > 0) {
                $team_parent_member_name = $member_model->where(['member_id' => $team_parent_user_id])->field('member_name')->find();
                $remark_arr[]            = '有上级团队，上级团队用户id：' . $team_parent_user_id . ',' . '上级团队用户名称：' . $team_parent_member_name['member_name'];
                // 买家的团队上级可获得的提成,将该金额加入团队消费共享分红奖金池中，明天分红
                $sales_share_bonus_for_team = bcdiv(bcmul($goods_after_tax_profit, 20, 2), 100, 2);

                // 团队消费共享分红不能超过后台设定的最高金额，2019-6-13
                if (intval($set_field_arr_for_name['type_sales_share_bonus_for_team']) > 0 && $sales_share_bonus_for_team > $set_field_arr_for_name['type_sales_share_bonus_for_team']) {
                    $sales_share_bonus_for_team = $set_field_arr_for_name['type_sales_share_bonus_for_team'];
                }

                // return dump($sales_share_bonus_for_team);
                $remark_arr[] = '买家的团队上级可获得的提成,将该金额加入团队消费共享分红奖金池中，明天分红：' . $sales_share_bonus_for_team;


                // 团队销售分享分红       2018/04/27
                if ($sales_share_bonus_for_team > 0) {
                    $user_bonus_pool_data[] = $this->getUserBonusPoolDataArr(
                        $buyer_user_id,
                        $team_parent_user_id,
                        $sales_share_bonus_for_team,
                        $sales_profit,
                        $type_sales_share_bonus_for_team,
                        $order_info['order_id'],
                        $value['goods_id'],
                        $order_info['order_sn'],
                        $sales_order_totalMoney
                    );
                }
            }

            // 供应商推荐奖
            // 如果当前店铺是其他会员邀请的，那么需要分一份供应商推荐奖给邀请人，该奖项存入奖金池，一月结算一次
            // 当前商品可以为供应商邀请人提供的奖金
            $this_goods_invite_user_money = 0;
            if ($store_invite_user_id > 0) {
                $type_supplier_referral_bonus_info = $this->getTypeSupplierReferralBonus(
                    $buyer_user_id,
                    $store_invite_user_id,
                    $store_invite_user_level,
                    $goods_after_tax_profit,
                    $type_supplier_referral_bonus,
                    $order_info['order_id'],
                    $value['goods_id'],
                    $order_info['order_sn']
                );
                // 只有供应商推荐奖大于0的时候才会加入奖金池
                if ($type_supplier_referral_bonus_info['this_goods_invite_user_money'] > 0) {
                    $user_bonus_pool_data[]       = $type_supplier_referral_bonus_info['user_bonus_pool_data'];
                    $this_goods_invite_user_money = $type_supplier_referral_bonus_info['this_goods_invite_user_money'];

                    // 供应商推荐奖不能超过后台设定的最高金额，2019-6-13
                    if (intval($set_field_arr_for_name['type_supplier_referral_bonus']) > 0 && $sales_share_bonus_for_team > $set_field_arr_for_name['type_supplier_referral_bonus']) {
                        $this_goods_invite_user_money = $set_field_arr_for_name['type_supplier_referral_bonus'];
                    }

                }
            }

            // 获取当前商品扣掉团队分红和供应商推荐奖后的剩余的利润
            $last_surplus_total_money = bcsub(bcsub($surplus_total_money, $sales_share_bonus_for_team, 2), $platform_profit, 2);
            // 剩余可分红利润(为防止团队分红时有除不尽的比例，这里不会先扣掉团队分红利润，仅作为日志使用)
            $new_surplus_total_money      = bcsub($surplus_total_money, $platform_profit, 2);
            $remark_arr[]                 = '未扣掉团队分红的当前商品剩余的利润：' . $new_surplus_total_money;
            $remark_arr[]                 = '扣掉团队分红后当前商品剩余的利润：' . $last_surplus_total_money;
            $last_supplier_referral_money = bcsub($last_surplus_total_money, $this_goods_invite_user_money, 2);
            $remark_arr[]                 = '当前商品供应商推荐奖：' . $this_goods_invite_user_money;
            $remark_arr[]                 = '扣掉供应商推荐奖的当前商品剩余的利润：' . $last_supplier_referral_money;
            $surplus_total_money_data[]   = $this->getPlatformProfitLogDataArr(
                $type_type_surplus_total_money,
                $last_supplier_referral_money,
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );

            if ($after_tax_profit > 0) {
                // 将商品税后剩余可分配利润记录日志（这条日志不会随分红减少）
                $goods_after_tax_profit_data['money']           = $after_tax_profit;
                $goods_after_tax_profit_data['total_money']     = $goods_total_money; //2018/04/30
                $goods_after_tax_profit_data['created_at']      = date('Y-m-d H:i:s');
                $goods_after_tax_profit_data['updated_at']      = date('Y-m-d H:i:s');
                $goods_after_tax_profit_data['order_id']        = $order_info['order_id'];
                $goods_after_tax_profit_data['order_sn']        = $order_info['order_sn'];
                $goods_after_tax_profit_data['goods_id']        = $value['goods_id'];
                $goods_after_tax_profit_data['store_member_id'] = $new_store_info_list[$value['store_id']]['member_id'];
                $goods_after_tax_profit_log[]                   = $goods_after_tax_profit_data;
                unset($goods_after_tax_profit_data);
            }
            $system_bonus_log_arr[$key]['remark'] = implode('|', $remark_arr);
            unset($remark_arr);
        }
        DB::beginTransaction();
        // 将商品税后剩余可分配利润记录日志
        if (!empty($goods_after_tax_profit_log)) {
            $goods_after_tax_profit_log_model = new goods_after_tax_profit_logModel();
            $goods_after_tax_profit_log_data  = array_merge($goods_after_tax_profit_log);
            $goods_after_tax_profit_log_model->insertAll($goods_after_tax_profit_log_data);
        }

        // 剩余可分红利润日志
        if (!empty($surplus_total_money_data)) {
            $new_surplus_total_money_data = array_merge($surplus_total_money_data);
            // 检查本日，本周，本月是否已经统计过数据
            $platform_residual_dividend_profit_model = new platform_residual_dividend_profitModel();
            $this_order_surplus_total_money_arr      = array_column($new_surplus_total_money_data, 'money');
            $this_order_surplus_total_money          = array_sum($this_order_surplus_total_money_arr);
            $platform_residual_dividend_profit_model->checkLogUpdate($this_order_surplus_total_money);
        }


        // 团队消费共享分红资金池日志
        if (!empty($user_bonus_pool_data)) {
            p('$user_bonus_pool_data');
            p($user_bonus_pool_data);
            $new_user_bonus_pool_data = array_merge($user_bonus_pool_data);
            $user_bonus_pool_model->insertAll($new_user_bonus_pool_data);
        }

        // 平台利润获取日志
        if (!empty($platform_profit_log_data)) {
            $new_platform_profit_log_data = array_merge($platform_profit_log_data);
            $platform_profit_model->insertAll($new_platform_profit_log_data);
        }

        // 分红日志
        if (!empty($user_bonus_log_data)) {
            $new_user_bonus_log_data = array_merge($user_bonus_log_data);
            $user_bonus_log_model->insertAll($new_user_bonus_log_data);
        }

        // 预存款变更日志
        if (!empty($new_user_bonus_log_data)) {
            $pd_log_data = $this->getPdLogDataArr($new_user_bonus_log_data);
            $pd_model->insertAll($pd_log_data);
        }
        if (!empty($new_user_bonus_log_data)) {
            // 以用户id为单位获取每个用户需要更新的金额数组
            $user_update_balance_arr = $this->getUpdateUserBalance($new_user_bonus_log_data);
            // 预存款修改sql
            $sql = $this->getUpdateUserBalanceSQL($user_update_balance_arr);
            DB::execute($sql);
        }


        $zx_bonus_order_money = array_sum($zx_bonus_order_money_arr); // 专项消费订单金额
        if ($zx_bonus_order_money > 0) {
            // 将买家的专项消费金额入库
            $user_consumption_sale_log_day_model->addLog(
                $order_info['buyer_id'],
                $user_consumption_sale_log_day_model::LOG_TYPE_ZX,
                $zx_bonus_order_money
            );
        }

        $not_bonus_order_money = array_sum($not_bonus_order_money_arr);    // 升级订单金额
        if ($not_bonus_order_money > 0) {
            // 将买家的升级消费金额入库
            $user_consumption_sale_log_day_model->addLog(
                $order_info['buyer_id'],
                $user_consumption_sale_log_day_model::LOG_TYPE_SJ,
                $not_bonus_order_money
            );
        }


        $user_consumption_total_money = bcsub(bcsub($order_info['order_amount'], $zx_bonus_order_money, 2), $not_bonus_order_money, 2);
        if ($user_consumption_total_money > 0) {
            // 将买家的消费金额入库 = 订单总价 - 专项消费订单金额 - 升级订单金额
            $user_consumption_sale_log_day_model->addLog(
                $order_info['buyer_id'],
                $user_consumption_sale_log_day_model::LOG_TYPE_CONSUMPTION,
                $user_consumption_total_money
            );
        }

        // 将卖家的销售额入库 = 订单金额 - 运费 // - 专项消费订单金额 - 升级订单金额
        /*$user_consumption_sale_log_day_model->addLog(
            $store_member_id_arr[0],
            $user_consumption_sale_log_day_model::LOG_TYPE_STORE_SALE,
            $order_info['goods_amount']
        );*/

        if (!empty($seller_user_data)) {
            // 将个人微商的销售额入库 = 订单金额 - 专项消费订单金额 - 升级订单金额
            // TODO 2017年11月23日16:14:40 此处使用了循环更新，需要优化
            foreach ($seller_user_data as $seller_user_id => $seller_user_money) {
                $user_consumption_sale_log_day_model->addLog(
                    $seller_user_id,
                    $user_consumption_sale_log_day_model::LOG_TYPE_PERSONAL_SALE,
                    array_sum($seller_user_money)
                );
            }
        }
        // 检查当前用户是否满足共享日分红-新注册会员分红条件
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->statisticalShareDayBonusForNew($buyer_user_id);
        // 生成系统日志
        if (!empty($system_bonus_log_arr)) {
            $system_bonus_log_model   = new system_bonus_logModel();
            $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
            $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
        }
        DB::commit();
        // p('//////////////////////订单：'.$order_info['order_sn'].'处理完成！//////////////////////');
    }


    // 获取发布商品的店铺应该收到的钱 @TODO 店铺收到的钱在确认收货时才会到，其他的钱在买家支付成功时就会到账 2017年12月7日18:18:12 需求修改
    public function getNewStoreUserAmountOfMoney($order_goods_list)
    {
        $order_info = $this->_order_info;
        // 获取所有店主store_id
        $store_id_arr = array_column($order_goods_list, 'store_id');
        // 根据store_id获取店铺对应的用户信息
        $store_model           = Model('store');
        $store_info_list_field = 'store_id,store_name,grade_id,member_id,member_name,seller_name';
        $store_info_list       = $store_model->where(['store_id' => ['in', $store_id_arr]])->field($store_info_list_field)->select();
        $new_store_info_list   = [];
        foreach ($store_info_list as $s_i_l_key => $s_i_l_value) {
            // 以店铺id作为数组的键
            $new_store_info_list[$s_i_l_value['store_id']] = $s_i_l_value;
        }
        $store_member_id_arr = array_column($new_store_info_list, 'member_id');
        // 获取这些店铺的拥有者所属团队的用户id（推荐供应商入驻的用户id,如果没有人推荐，那就是平台推荐）
        $pd_model                            = Model('predeposit');
        $user_consumption_sale_log_day_model = Model('user_consumption_sale_log_day');
        $goods_model                         = Model('goods');

        $buyer_user_id = $order_info['buyer_id'];
        // 获取当前订单所有商品的id
        $goods_id_arr = array_column($order_goods_list, 'goods_id');
        // 获取当前订单所有商品的运费,供货价，销售价
        $goods_info_arr = $goods_model->table('goods')->where(['goods_id' => ['in', $goods_id_arr]])->field('goods_id,goods_freight,goods_costprice,goods_price')->select();
        // 以商品goods_id为键重组数据
        $goods_info_arr_for_goods_id = array_combine(array_column($goods_info_arr, 'goods_id'), $goods_info_arr);
        // 以商品goods_id为键，运费为值，重组数据
        $shipping_fee_arr_for_goods_id = array_combine(array_column($goods_info_arr, 'goods_id'), array_column($goods_info_arr, 'goods_freight'));

        // 获取所有微商城卖出去的商品的卖家信息
        $seller_goods_referral_key_arr = array_filter(array_column($order_goods_list, 'referral_key'));
        $referral_key_arr              = [];
        if (!empty($seller_goods_referral_key_arr)) {
            foreach ($seller_goods_referral_key_arr as $referral_key) {
                $referral_key_arr[] = $goods_model->getGoodsReferralKey($referral_key);
            }
        }
        $user_bonus_log_model = Model('user_bonus_log');
        $type_supply_money    = $user_bonus_log_model::TYPE_SUPPLY_MONEY;              // 供货款
        $type_supply_freight  = $user_bonus_log_model::TYPE_SUPPLY_FREIGHT;          // 商品运费
        $user_bonus_log_data  = [];
        $seller_user_data     = [];
        $now_date             = date('Y-m-d H:i:s');
        foreach ($order_goods_list as $key => $value) {
            $system_bonus_log_arr[$key]['order_id'] = $order_info['order_id'];
            $system_bonus_log_arr[$key]['order_sn'] = $order_info['order_sn'];
            $system_bonus_log_arr[$key]['goods_id'] = $value['goods_id'];
            $remark_arr[]                           = '订单号：' . $order_info['order_sn'];
            // 当前商品应该转给店铺的钱(如果是赠品，则直接跳过)
            if ($value['goods_pay_price'] == 0) {
                $system_bonus_log_arr[$key]['remark'] = '当前商品id：' . $value['goods_id'] . '当前商品名称：' . $value['goods_name'] . '的赠品，不参与分红，直接跳过';
                continue;
            }
            // 如果当前商品是升级订单商品或者专项消费商品，那么用户的消费销售额不会计入分红消费销售额中
            $remark_arr[] = '当前商品id：' . $value['goods_id'];
            $remark_arr[] = '当前商品名称：' . $value['goods_name'];
            $remark_arr[] = '当前商品购买数量：' . $value['goods_num'];
            $remark_arr[] = '当前商品供货价：' . $goods_info_arr_for_goods_id[$value['goods_id']]['goods_costprice'];
            // 转给店铺的钱
            $money_transferred_to_the_store = bcmul($goods_info_arr_for_goods_id[$value['goods_id']]['goods_costprice'], $value['goods_num']);
            $remark_arr[]                   = '转给店铺的钱：' . $money_transferred_to_the_store;
            // 供货款
            $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                $new_store_info_list[$value['store_id']]['member_id'],
                $type_supply_money,
                $money_transferred_to_the_store,
                $order_info['order_id'],
                $value['goods_id'],
                $order_info['order_sn']
            );
            // 转给店铺的当前商品的运费
            $this_goods_freight = $shipping_fee_arr_for_goods_id[$value['goods_id']];
            // p('2.转给店铺的当前商品的运费:'.$this_goods_freight);
            $remark_arr[] = '转给店铺的当前商品的运费：' . $this_goods_freight;
            // 商品运费
            if ($this_goods_freight > 0) {
                // p('|-当前商品的运费 > 0');
                $user_bonus_log_data[] = $this->getUserBonusLogDataArr(
                    $new_store_info_list[$value['store_id']]['member_id'],
                    $type_supply_freight,
                    $this_goods_freight,
                    $order_info['order_id'],
                    $value['goods_id'],
                    $order_info['order_sn']
                );
            }
            /**********************************************************/
            $system_bonus_log_arr[$key]['from_user_id'] = $buyer_user_id;
            $system_bonus_log_arr[$key]['to_user_id']   = $buyer_user_id;
            $system_bonus_log_arr[$key]['to_seller_id'] = 0;
            $system_bonus_log_arr[$key]['to_store_id']  = $new_store_info_list[$value['store_id']]['member_id'];
            $system_bonus_log_arr[$key]['created_at']   = $now_date;
            /**********************************************************/
            $system_bonus_log_arr[$key]['remark'] = implode('|', $remark_arr);
            unset($remark_arr);
        }
        DB::beginTransaction();
        // 分红日志
        if (!empty($user_bonus_log_data)) {
            $new_user_bonus_log_data = array_merge($user_bonus_log_data);
            $user_bonus_log_model->insertAll($new_user_bonus_log_data);
        }

        // 预存款变更日志
        if (!empty($new_user_bonus_log_data)) {
            $pd_log_data = $this->getPdLogDataArr($new_user_bonus_log_data);
            $pd_model->insertAll($pd_log_data);
        }
        if (!empty($new_user_bonus_log_data)) {
            // 以用户id为单位获取每个用户需要更新的金额数组
            $user_update_balance_arr = $this->getUpdateUserBalance($new_user_bonus_log_data);
            // 预存款修改sql
            $sql = $this->getUpdateUserBalanceSQL($user_update_balance_arr);
            DB::execute($sql);
        }

        // 将卖家的销售额入库 = 订单金额 - 运费 // - 专项消费订单金额 - 升级订单金额
        $user_consumption_sale_log_day_model->addLog(
            $store_member_id_arr[0],
            $user_consumption_sale_log_day_model::LOG_TYPE_STORE_SALE,
            $order_info['goods_amount']
        );

        if (!empty($seller_user_data)) {
            // 将个人微商的销售额入库 = 订单金额 - 专项消费订单金额 - 升级订单金额
            // TODO 2017年11月23日16:14:40 此处使用了循环更新，需要优化
            foreach ($seller_user_data as $seller_user_id => $seller_user_money) {
                $user_consumption_sale_log_day_model->addLog(
                    $seller_user_id,
                    $user_consumption_sale_log_day_model::LOG_TYPE_PERSONAL_SALE,
                    array_sum($seller_user_money)
                );
            }
        }

        // 生成系统日志
        if (!empty($system_bonus_log_arr)) {
            $system_bonus_log_model   = Model('system_bonus_log');
            $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
            $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
        }
        DB::commit();
    }


    // 供应商推荐奖数据处理
    public function getTypeSupplierReferralBonus($from_user_id, $to_user_id, $to_user_level, $sales_profit, $type, $order_id = '', $goods_id = '', $order_sn = '')
    {
        $this_goods_invite_user_money = 0;
        if ($to_user_level == 5) {
            $this_goods_invite_user_money = bcdiv(bcmul($sales_profit, 1, 2), 100, 2);
        } elseif ($to_user_level == 6) {
            $this_goods_invite_user_money = bcdiv(bcmul($sales_profit, 2, 2), 100, 2);
        }
        $user_bonus_pool_data = [];
        if ($this_goods_invite_user_money > 0) {
            $user_bonus_pool_data = $this->getUserBonusPoolDataArr(
                $from_user_id,
                $to_user_id,
                $this_goods_invite_user_money,
                $sales_profit,
                $type,
                $order_id,
                $goods_id,
                $order_sn
            );
        }
        $return_arr['this_goods_invite_user_money'] = $this_goods_invite_user_money;
        $return_arr['user_bonus_pool_data']         = $user_bonus_pool_data;
        return $return_arr;
    }

    // 平台收入日志处理
    public function getPlatformProfitLogDataArr($type, $money, $order_id = '', $goods_id = '', $order_sn = '', $change_type = 1)
    {

        $user_bonus_log_data['money']       = $money;
        $user_bonus_log_data['type']        = $type;
        $user_bonus_log_data['change_type'] = $change_type;
        $user_bonus_log_data['created_at']  = date('Y-m-d H:i:s');
        $user_bonus_log_data['updated_at']  = date('Y-m-d H:i:s');
        $user_bonus_log_data['order_id']    = $order_id;
        $user_bonus_log_data['order_sn']    = $order_sn;
        $user_bonus_log_data['goods_id']    = $goods_id;
        return $user_bonus_log_data;
    }

    // 组合分红资金池数组

    /**
     * @param        $from_user_id           // 被邀请人id（买家用户id）
     * @param        $to_user_id             // 邀请人用户id（上级团队）
     * @param        $money                  // 产生的团队分红金额
     * @param        $sales_profit           // 当前商品总利润
     * @param        $type                   // 分红类型
     * @param string $order_id               // 订单id
     * @param string $goods_id               // 商品id
     * @param string $order_sn               // 订单号
     * @param        $sales_order_totalMoney // 消费总额
     * @return mixed
     */
    public function getUserBonusPoolDataArr($from_user_id, $to_user_id, $money, $sales_profit, $type, $order_id = '', $goods_id = '', $order_sn = '', $sales_order_totalMoney = '')
    {
        $user_bonus_log_data['from_user_id']      = $from_user_id;
        $user_bonus_log_data['to_user_id']        = $to_user_id;
        $user_bonus_log_data['money']             = $money;
        $user_bonus_log_data['sales_profit']      = $sales_profit;
        $user_bonus_log_data['created_at']        = date('Y-m-d H:i:s');
        $user_bonus_log_data['order_id']          = $order_id;
        $user_bonus_log_data['order_sn']          = $order_sn;
        $user_bonus_log_data['goods_id']          = $goods_id;
        $user_bonus_log_data['order_total_money'] = $sales_order_totalMoney;
        $user_bonus_log_data['type']              = $type;
        return $user_bonus_log_data;
    }


    // 组合分红日志数组
    public function getUserBonusLogDataArr($user_id, $type, $money, $order_id = '', $goods_id = '', $order_sn = '')
    {
        $user_bonus_log_data['user_id']    = $user_id;
        $user_bonus_log_data['type']       = $type;
        $user_bonus_log_data['money']      = $money;
        $user_bonus_log_data['created_at'] = date('Y-m-d H:i:s');
        $user_bonus_log_data['updated_at'] = date('Y-m-d H:i:s');
        $user_bonus_log_data['order_id']   = $order_id;
        $user_bonus_log_data['order_sn']   = $order_sn;
        $user_bonus_log_data['goods_id']   = $goods_id;
        return $user_bonus_log_data;
    }

    // 根据分红日志数组组合预存款变更日志数组
    public function getPdLogDataArr($new_user_bonus_log_data)
    {
        $user_bonus_log_model = Model('user_bonus_log');
        $type_arr             = $user_bonus_log_model->getTypeInfo();
        $data                 = [];
        foreach ($new_user_bonus_log_data as $key => $value) {
            $data[$key]['lg_member_id']     = $value['user_id'];    // 用户id
            $data[$key]['lg_type']          = $value['type'];            // 类型
            $data[$key]['lg_freeze_amount'] = $value['money'];  // 金额
            $data[$key]['lg_add_time']      = time();                // 添加时间
            $data[$key]['lg_member_name']   = '';                // 会员名称
            $data[$key]['lg_desc']          = $type_arr[$value['type']] . '（订单号：' . $value['order_sn'] . '）'; // 描述
        }
        return $data;
    }

    // 根据分红日志数组按用户id组合每个用户需要更新的金额数组
    public function getUpdateUserBalance($new_user_bonus_log_data)
    {
        $data = [];
        foreach ($new_user_bonus_log_data as $key => $value) {
            $data[$value['user_id']][] = $value['money'];
        }
        return $data;
    }

    // 根据每个用户需要更新的金额组合成一条sql
    public function getUpdateUserBalanceSQL($user_update_balance_arr, $table_name = 'member', $field = 'freeze_predeposit', $case_field = 'member_id')
    {
        $sql = 'UPDATE ' . $table_name . ' SET ' . $field . ' = CASE ' . $case_field;
        foreach ($user_update_balance_arr as $key => $value) {
            $this_money = array_sum($value);
            if ($this_money > 0) {
                $sql .= ' WHEN ' . $key . ' THEN ' . $field . '+' . $this_money;
            }
            unset($this_money);
        }
        $sql .= ' else ' . $field . ' END';
        //$sql .= ' END';
        return $sql;
    }


    /**
     * 加入新人销售鼓励基金
     *
     * @param $user_id // 用户id
     * @return bool
     */
    public function addToNewSalesIncentiveFund($user_id)
    {
        // 检查用户是否已经被加入过新人销售鼓励基金
        $model            = new user_bonusModel();
        $where['user_id'] = $user_id;
        $where['type']    = $model::TYPE_NEW_SALES_AWARD;
        $count            = $model->where($where)->count(1);
        if ($count > 0) {
            return false;
        }
        $save_data['user_id']  = $user_id;
        $save_data['type']     = $model::TYPE_NEW_SALES_AWARD;
        $save_data['begin_at'] = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s')));
        //$save_data['end_at']     = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($save_data['begin_at'])));
        // 2019/5/8 新人销售鼓励基金分红结束时间改为一个分红周期
        $save_data['end_at']     = date("Y-m-d H:i:s", strtotime('+' . $model::FREQUENCY_FOR_MONTH . ' day', strtotime("+1 day", strtotime(date('Y-m-d'))) - 1));
        $save_data['frequency']  = $model::FREQUENCY_FOR_DAY;
        $save_data['created_at'] = date('Y-m-d H:i:s');
        $model->insert($save_data);
        return true;
    }

    /**
     * 用户升级时赠送有期限的 HI 值
     *
     * @param $buyer_id            // 用户id
     * @param $user_old_level_info // 原等级信息
     * @param $user_new_level_info // 新等级信息
     * @return bool
     */
    public function giveTermHI($buyer_id, $user_old_level_info, $user_new_level_info)
    {
        // 新等级与旧等级两者中间的所有等级的 HI 值和 + 新等级的 HI 就是用户此次升级可获得的所有 HI 值
        $user_level_model = Model('user_level');
        $user_hi_model    = Model('user_hi_value');
        // 由于此处未找到获取exp > 0且 <= 10这样得写法，所以只好用原生
//        $sql = 'level > ' . $user_old_level_info . ' and level <=  ' . $user_new_level_info;
//        $total_hi_arr = $user_level_model->where($sql)->select();
//        $total_hi = array_sum(array_column($total_hi_arr, 'give_hi'));   // 本次升级获取的所有 HI 值
        $old_hi   = $user_level_model->where(['level' => $user_old_level_info])->find();
        $new_hi   = $user_level_model->where(['level' => $user_new_level_info])->find();
        $total_hi = $new_hi['give_hi'];
        if (!empty($total_hi)) {
            $user_hi_model->changeUserHi($buyer_id, $total_hi, $user_hi_model::HI_TYPE_UPGRADE, $user_hi_model::CHANGE_TYPE_INC);
        }
        return true;
    }

    /**
     * 更改运费
     *
     * @param array  $order_info
     * @param string $role  操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user  操作人
     * @param float  $price 运费
     * @return array
     */
    public function changeOrderShipPrice($order_info, $role, $user = '', $price)
    {
        try {

            $order_id    = $order_info['order_id'];
            $model_order = Model('order');

            $data                 = [];
            $data['shipping_fee'] = abs(floatval($price));
            $data['order_amount'] = ['exp', 'goods_amount+' . $data['shipping_fee']];
            $update               = $model_order->editOrder($data, ['order_id' => $order_id]);
            if (!$update) {
                throw new Exception('保存失败');
            }
            //记录订单日志
            $data             = [];
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_user'] = $user;
            $data['log_msg']  = '修改了运费' . '( ' . $price . ' )';;
            $data['log_orderstate'] = $order_info['payment_code'] == 'offline' ? ORDER_STATE_PAY : ORDER_STATE_NEW;
            $model_order->addOrderLog($data);
            return callback(true, '操作成功');
        } catch (Exception $e) {
            return callback(false, '操作失败');
        }
    }

    /**
     * 更改价格
     *
     * @param array  $order_info
     * @param string $role  操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user  操作人
     * @param float  $price 价格
     * @return array
     */
    public function changeOrderSpayPrice($order_info, $role, $user = '', $price)
    {
        try {

            $order_id    = $order_info['order_id'];
            $model_order = Model('order');

            $data                 = [];
            $data['goods_amount'] = abs(floatval($price));
            $data['order_amount'] = ['exp', 'shipping_fee+' . $data['goods_amount']];
            $update               = $model_order->editOrder($data, ['order_id' => $order_id]);
            if (!$update) {
                throw new Exception('保存失败');
            }
            //记录订单日志
            $data             = [];
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_user'] = $user;
            $data['log_msg']  = '修改了价格' . '( ' . $price . ' )';;
            $data['log_orderstate'] = $order_info['payment_code'] == 'offline' ? ORDER_STATE_PAY : ORDER_STATE_NEW;
            $model_order->addOrderLog($data);
            return callback(true, '操作成功');
        } catch (Exception $e) {
            return callback(false, '操作失败');
        }
    }

    /**
     * 回收站操作（放入回收站、还原、永久删除）
     *
     * @param array  $order_info
     * @param string $role       操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $state_type 操作类型
     * @return array
     */
    public function changeOrderStateRecycle($order_info, $role, $state_type)
    {
        $order_id    = $order_info['order_id'];
        $model_order = Model('order');
        //更新订单删除状态
        $state  = str_replace(['delete', 'drop', 'restore'], [ORDER_DEL_STATE_DELETE, ORDER_DEL_STATE_DROP, ORDER_DEL_STATE_DEFAULT], $state_type);
        $update = $model_order->editOrder(['delete_state' => $state], ['order_id' => $order_id]);
        if (!$update) {
            return callback(false, '操作失败');
        } else {
            return callback(true, '操作成功');
        }
    }

    /**
     * 发货
     *
     * @param array  $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @return array
     */
    public function changeOrderSend($order_info, $role, $user = '', $post = [])
    {
        $order_id    = $order_info['order_id'];
        $model_order = Model('order');
        try {
            $model_order->beginTransaction();
            $data = [];
            if (!empty($post['reciver_name'])) {
                $data['reciver_name'] = $post['reciver_name'];
            }
            if (!empty($post['reciver_info'])) {
                $data['reciver_info'] = $post['reciver_info'];
            }
            $data['deliver_explain']     = $post['deliver_explain'];
            $data['daddress_id']         = intval($post['daddress_id']);
            $data['shipping_express_id'] = intval($post['shipping_express_id']);
            $data['shipping_time']       = TIMESTAMP;

            $condition             = [];
            $condition['order_id'] = $order_id;
            $condition['store_id'] = $order_info['store_id'];
            $update                = $model_order->editOrderCommon($data, $condition);
            if (!$update) {
                throw new Exception('操作失败');
            }

            $data                  = [];
            $data['shipping_code'] = $post['shipping_code'];
            $data['order_state']   = ORDER_STATE_SEND;
            $data['delay_time']    = TIMESTAMP;
            $update                = $model_order->editOrder($data, $condition);
            if (!$update) {
                throw new Exception('操作失败');
            }
            $model_order->commit();
        } catch (Exception $e) {
            $model_order->rollback();
            return callback(false, $e->getMessage());
        }

        //更新表发货信息
        if ($post['shipping_express_id'] && $order_info['extend_order_common']['reciver_info']['dlyp']) {
            $data                  = [];
            $data['shipping_code'] = $post['shipping_code'];
            $data['order_sn']      = $order_info['order_sn'];
            $express_info          = Model('express')->getExpressInfo(intval($post['shipping_express_id']));
            $data['express_code']  = $express_info['e_code'];
            $data['express_name']  = $express_info['e_name'];
            Model('delivery_order')->editDeliveryOrder($data, ['order_id' => $order_info['order_id']]);
        }

        //添加订单日志
        $data                   = [];
        $data['order_id']       = $order_id;
        $data['log_role']       = 'seller';
        $data['log_user']       = $user;
        $data['log_msg']        = '发出货物(编辑信息)';
        $data['log_orderstate'] = ORDER_STATE_SEND;
        $model_order->addOrderLog($data);

        // 发送买家消息
        $param              = [];
        $param['code']      = 'order_deliver_success';
        $param['member_id'] = $order_info['buyer_id'];
        $param['param']     = [
            'order_sn'  => $order_info['order_sn'],
            'order_url' => urlShop('member_order', 'show_order', ['order_id' => $order_id])
        ];
        QueueClient::push('sendMemberMsg', $param);

        return callback(true, '操作成功');
    }

    /**
     * 收到货款
     *
     * @param array  $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @return array
     */
    public function changeOrderReceivePay($order_list, $role, $user = '', $post = [])
    {
        $model_order = Model('order');

        try {
            $model_order->beginTransaction();

            $model_pd = Model('predeposit');
            foreach ($order_list as $order_info) {
                $order_id = $order_info['order_id'];
                if (!in_array($order_info['order_state'], [ORDER_STATE_NEW])) continue;
                //下单，支付被冻结的充值卡
                $rcb_amount = floatval($order_info['rcb_amount']);
                if ($rcb_amount > 0) {
                    $data_pd                = [];
                    $data_pd['member_id']   = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount']      = $rcb_amount;
                    $data_pd['order_sn']    = $order_info['order_sn'];
                    $model_pd->changeRcb('order_comb_pay', $data_pd);
                }

                //下单，支付被冻结的预存款
                $pd_amount = floatval($order_info['pd_amount']);
                if ($pd_amount > 0) {
                    $data_pd                = [];
                    $data_pd['member_id']   = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount']      = $pd_amount;
                    $data_pd['order_sn']    = $order_info['order_sn'];
                    $model_pd->changePd('order_comb_pay', $data_pd);
                }

                //更新订单相关扩展信息
                $result = $this->_changeOrderReceivePayExtend($order_info, $post);
                if (!$result['state']) {
                    throw new Exception($result['msg']);
                }

                //添加订单日志
                $data                   = [];
                $data['order_id']       = $order_id;
                $data['log_role']       = $role;
                $data['log_user']       = $user;
                $data['log_msg']        = '收到货款(外部交易号:' . $post['trade_no'] . ')';
                $data['log_orderstate'] = ORDER_STATE_PAY;
                $insert                 = $model_order->addOrderLog($data);
                if (!$insert) {
                    throw new Exception('操作失败');
                }

                //更新订单状态
                $update_order                 = [];
                $update_order['order_state']  = ORDER_STATE_PAY;
                $update_order['payment_time'] = ($post['payment_time'] ? strtotime($post['payment_time']) : TIMESTAMP);
                $update_order['payment_code'] = $post['payment_code'];
                if ($post['trade_no'] != '') {
                    $update_order['trade_no'] = $post['trade_no'];
                }
                $condition                = [];
                $condition['order_id']    = $order_info['order_id'];
                $condition['order_state'] = ORDER_STATE_NEW;
                $update                   = $model_order->editOrder($update_order, $condition);
                if (!$update) {
                    throw new Exception('操作失败');
                }
            }

            //更新支付单状态
            $data                  = [];
            $data['api_pay_state'] = 1;
            $update                = $model_order->editOrderPay($data, ['pay_sn' => $order_info['pay_sn']]);
            if (!$update) {
                throw new Exception('更新支付单状态失败');
            }

            $model_order->commit();
        } catch (Exception $e) {
            $model_order->rollback();
            return callback(false, $e->getMessage());
        }

        foreach ($order_list as $order_info) {

            $order_id = $order_info['order_id'];
            //支付成功发送买家消息
            $param              = [];
            $param['code']      = 'order_payment_success';
            $param['member_id'] = $order_info['buyer_id'];
            $param['param']     = [
                'order_sn'  => $order_info['order_sn'],
                'order_url' => urlShop('member_order', 'show_order', ['order_id' => $order_info['order_id']])
            ];
            QueueClient::push('sendMemberMsg', $param);

            //非预定订单下单或预定订单全部付款完成
            if ($order_info['order_type'] != 2 || $order_info['if_send_store_msg_pay_success']) {
                //支付成功发送店铺消息
                $param             = [];
                $param['code']     = 'new_order';
                $param['store_id'] = $order_info['store_id'];
                $param['param']    = [
                    'order_sn' => $order_info['order_sn']
                ];
                QueueClient::push('sendStoreMsg', $param);
                //门店自提发送提货码
                if ($order_info['order_type'] == 3) {
                    $_code  = rand(100000, 999999);
                    $result = $model_order->editOrder(['chain_code' => $_code], ['order_id' => $order_info['order_id']]);
                    if (!$result) {
                        throw new Exception('订单更新失败');
                    }
                    $param                = [];
                    $param['chain_code']  = $_code;
                    $param['order_sn']    = $order_info['order_sn'];
                    $param['buyer_phone'] = $order_info['buyer_phone'];
                    QueueClient::push('sendChainCode', $param);
                }
            }
        }

        return callback(true, '操作成功');
    }

    /**
     * 更新订单相关扩展信息
     *
     * @param unknown $order_info
     * @return unknown
     */
    private function _changeOrderReceivePayExtend($order_info, $post)
    {
        //预定订单收款
        if ($order_info['order_type'] == 2) {
            $result = Logic('order_book')->changeBookOrderReceivePay($order_info, $post);
        }
        return callback(true);
    }
}