<?php
/**
 * 统计概述
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stat_generalControl extends SystemControl
{
    private $links = [
        ['url' => 'controller=stat_general&action=general', 'lang' => 'stat_generalindex'],
        ['url' => 'controller=stat_general&action=foundation_setting', 'text' => '基础设置'],
    ];

    public function __construct()
    {
        parent::__construct();
        Language::read('stat');
        import('function.statistics');
    }

    public function indexOp()
    {
        $this->generalOp();
    }

    // 系统基本设置
    public function foundation_settingOp()
    {
        $setting_model = Model('setting');
        $field         = [
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
            'PLATFORM_TAX_RATE'
        ];
        $list          = $setting_model->where(['name' => ['in', $field]])->select();
        if ($list) {
            foreach ($list as $key => $value) {
                Tpl::output("{$value['name']}", $value['value']);
            }
        }
        Tpl::setDirquna('shop');
        Tpl::showpage('stat/foundation_setting');
    }

    public function saveFoundationSettingOp()
    {
        /**
         * type_sales_day_bonus_money// 销售/消费日分红
         * type_selling_star_day_bonus_money// 销售明星日分红
         * type_share_day_bonus_for_new_money// 共享日分红-新注册会员
         * type_share_day_bonus_for_old_money// 共享日分红-老会员
         * type_middle_management_bonus_weekly_money// 中层管理周分红
         * type_black_diamond_sales_bonus_money// 至尊消费月分红
         * type_elite_monthly_bonus_money// 销售精英月分红
         * type_top_selling_monthly_bonus_money// 高层销售月分红
         * type_new_sales_award_money// 销售新人奖
         * type_share_day_bonus_money// 共享日分红
         * type_sales_management_week_bonus_money// 销售管理普惠周奖金
         * type_supplier_referral_bonus_money// 供应商推荐奖金
         * type_sales_share_bonus_money// 个人消费分红
         * type_sales_share_bonus_for_team_money// 团队销售分享分红
         * type_sales_share_bonus_for_seller_money// 个人微商销售分红
         * type_consumption_capital_subsidy_consumption_pension_money// 消费资本补贴-消费养老补贴
         * type_consumption_capital_subsidy_garages_dream_money// 消费资本补贴-车房梦想补贴
         */

        $postData = [
            'PLATFORM_TAX_RATE'                                          => intval($_POST['platform_tax_rate']),
            'type_black_diamond_sales_bonus_money'                       => intval($_POST['type_black_diamond_sales_bonus_money']),
            'type_consumption_capital_subsidy_consumption_pension_money' => intval($_POST['type_consumption_capital_subsidy_consumption_pension_money']),
            'type_consumption_capital_subsidy_garages_dream_money'       => intval($_POST['type_consumption_capital_subsidy_garages_dream_money']),
            'type_elite_monthly_bonus_money'                             => intval($_POST['type_elite_monthly_bonus_money']),
            'type_middle_management_bonus_weekly_money'                  => intval($_POST['type_middle_management_bonus_weekly_money']),
            'type_new_sales_award_money'                                 => intval($_POST['type_new_sales_award_money']),
            'type_sales_day_bonus_money'                                 => intval($_POST['type_sales_day_bonus_money']),
            'type_sales_management_week_bonus_money'                     => intval($_POST['type_sales_management_week_bonus_money']),
            'type_sales_share_bonus_for_seller_money'                    => intval($_POST['type_sales_share_bonus_for_seller_money']),
            'type_sales_share_bonus_for_team_money'                      => intval($_POST['type_sales_share_bonus_for_team_money']),
            'type_sales_share_bonus_money'                               => intval($_POST['type_sales_share_bonus_money']),
            'type_selling_star_day_bonus_money'                          => intval($_POST['type_selling_star_day_bonus_money']),
            'type_share_day_bonus_for_new_money'                         => intval($_POST['type_share_day_bonus_for_new_money']),
            'type_share_day_bonus_for_old_money'                         => intval($_POST['type_share_day_bonus_for_old_money']),
            'type_share_day_bonus_money'                                 => intval($_POST['type_share_day_bonus_money']),
            'type_supplier_referral_bonus_money'                         => intval($_POST['type_supplier_referral_bonus_money']),
            'type_top_selling_monthly_bonus_money'                       => intval($_POST['type_top_selling_monthly_bonus_money']),
            'USER_CONSUMPTION_BONUS_RATIO'                               => intval($_POST['user_consumption_bonus_ratio'])
        ];

        $setting_model = Model('setting');
        $field         = [
            'PLATFORM_TAX_RATE',
            'type_black_diamond_sales_bonus_money',
            'type_consumption_capital_subsidy_consumption_pension_money',
            'type_consumption_capital_subsidy_garages_dream_money',
            'type_elite_monthly_bonus_money',
            'type_middle_management_bonus_weekly_money',
            'type_new_sales_award_money',
            'type_sales_day_bonus_money',
            'type_sales_management_week_bonus_money',
            'type_sales_share_bonus_for_seller_money',
            'type_sales_share_bonus_for_team_money',
            'type_sales_share_bonus_money',
            'type_selling_star_day_bonus_money',
            'type_share_day_bonus_for_new_money',
            'type_share_day_bonus_for_old_money',
            'type_share_day_bonus_money',
            'type_supplier_referral_bonus_money',
            'type_top_selling_monthly_bonus_money',
            'USER_CONSUMPTION_BONUS_RATIO'
        ];

        // 检查这两个字段是否已经设置过，如果没有，则添加，如果设置了，则修改
        $set_field_arr = $setting_model->where(['name' => ['in', $field]])->select();
        if ($set_field_arr) {
            foreach ($set_field_arr as $key => $value) {
                if ($value['name'] == $field[$key]) {
                    $update_arr_where['name'] = $field[$key];
                    $update_arr['value']      = $postData[$field[$key]];
                    $setting_model->where($update_arr_where)->update($update_arr);
                } else {
                    $add_arr['name']  = $field[$key];
                    $add_arr['value'] = $postData[$field[$key]];
                    $setting_model->insert($add_arr);
                }
            }
        }
        showMessage('保存成功');
    }

    /**
     * 促销分析
     */
    public function generalOp()
    {
        $model = new statModel();
        //统计的日期0点
        $stat_time = strtotime(date('Y-m-d', time())) - 86400;
        /*
         * 昨日最新情报
         */
        $stime = $stat_time;
        $etime = $stat_time + 86400 - 1;

        $statnew_arr = [];

        //查询订单表下单量、下单金额、下单客户数、平均客单价
        $where                         = [];
        $where['order_isvalid']        = 1;//计入统计的有效订单
        $where['order_add_time']       = ['between', [$stime, $etime]];
        $field                         = ' COUNT(*) as ordernum, SUM(order_amount) as orderamount, COUNT(DISTINCT buyer_id) as ordermembernum, AVG(order_amount) as orderavg ';
        $stat_order                    = $model->getoneByStatorder($where, $field);
        $statnew_arr['ordernum']       = ($t = $stat_order['ordernum']) ? $t : 0;
        $statnew_arr['orderamount']    = ncPriceFormat(($t = $stat_order['orderamount']) ? $t : (0));
        $statnew_arr['ordermembernum'] = ($t = $stat_order['ordermembernum']) ? $t : 0;
        $statnew_arr['orderavg']       = ncPriceFormat(($t = $stat_order['orderavg']) ? $t : 0);
        unset($stat_order);

        //查询订单商品表下单商品数
        $where                        = [];
        $where['order_isvalid']       = 1;//计入统计的有效订单
        $where['order_add_time']      = ['between', [$stime, $etime]];
        $field                        = ' SUM(goods_num) as ordergoodsnum,AVG(goods_pay_price/goods_num) as priceavg ';
        $stat_ordergoods              = $model->getoneByStatordergoods($where, $field);
        $statnew_arr['ordergoodsnum'] = ($t = $stat_ordergoods['ordergoodsnum']) ? $t : 0;
        $statnew_arr['priceavg']      = ncPriceFormat(($t = $stat_ordergoods['priceavg']) ? $t : 0);
        unset($stat_ordergoods);

        //新增会员数
        $where                    = [];
        $where['member_time']     = ['between', [$stime, $etime]];
        $field                    = ' COUNT(*) as newmember ';
        $stat_member              = $model->getoneByMember($where, $field);
        $statnew_arr['newmember'] = ($t = $stat_member['newmember']) ? $t : 0;
        unset($stat_member);

        //会员总数
        $where                    = [];
        $where['member_state']    = 1;
        $field                    = ' COUNT(*) as membernum ';
        $stat_member              = $model->getoneByMember($where, $field);
        $statnew_arr['membernum'] = ($t = $stat_member['membernum']) ? $t : 0;
        unset($stat_member);

        //新增店铺
        $where                   = [];
        $where['store_time']     = ['between', [$stime, $etime]];
        $field                   = ' COUNT(*) as newstore ';
        $stat_store              = $model->getoneByStore($where, $field);
        $statnew_arr['newstore'] = ($t = $stat_store['newstore']) ? $t : 0;
        unset($stat_store);

        //店铺总数
        $where                   = [];
        $field                   = ' COUNT(*) as storenum ';
        $stat_store              = $model->getoneByStore($where, $field);
        $statnew_arr['storenum'] = ($t = $stat_store['storenum']) ? $t : 0;
        unset($stat_store);

        //新增商品，商品总数
        if (C('dbdriver') == 'mysql') {
            $goods_list = $model->statByGoods(['is_virtual' => 0], "COUNT(*) as goodsnum, SUM(IF(goods_addtime>=$stime and goods_addtime<=$etime,1,0)) as newgoods");
        } elseif (C('dbdriver') == 'oracle') {
            $goods_list = $model->statByGoods(['is_virtual' => 0], "COUNT(*) AS goodsnum, SUM(( case when goods_addtime>=$stime AND goods_addtime<=$etime then 1 else 0 end )) AS newgoods");
        }
        $statnew_arr['goodsnum'] = ($t = $goods_list[0]['goodsnum']) > 0 ? $t : 0;
        $statnew_arr['newgoods'] = ($t = $goods_list[0]['newgoods']) > 0 ? $t : 0;
        //平台历史总提成
        $platform_profit                = Model('platform_profit')->field('money')->where(['change_type' => 1])->sum('money');
        $statnew_arr['platform_profit'] = ($platform_profit ? $platform_profit : 0);
        //平台历史总分红
        $bonus_total                = Model('user_bonus_log')->field('money')->sum('money') + Model('user_bonus_pool')->field('money')->sum('money');
        $statnew_arr['bonus_total'] = ($bonus_total ? $bonus_total : 0);
        //平台资金池
        $platform_residual_dividend_profit_model = new platform_residual_dividend_profitModel();
        $prdf                                    = $platform_residual_dividend_profit_model->field('money')->where(['cycle' => $platform_residual_dividend_profit_model::UPDATE_FOR_MONTHLY])->sum('money');
        $statnew_arr['prdf']                     = ($prdf ? $prdf : 0);
        /*
         * 昨日销售走势
         */
        //构造横轴数据
        for ($i = 0; $i < 24; $i++) {
            //统计图数据
            $curr_arr[$i] = 0;//今天
            $up_arr[$i]   = 0;//昨天
            //横轴
            $stat_arr['xAxis']['categories'][] = "$i";
        }
        $stime                   = $stat_time - 86400;//昨天0点
        $etime                   = $stat_time + 86400 - 1;//今天24点
        $yesterday_day           = @date('d', $stime);//昨天日期
        $today_day               = @date('d', $etime);//今天日期
        $where                   = [];
        $where['order_isvalid']  = 1;//计入统计的有效订单
        $where['order_add_time'] = ['between', [$stime, $etime]];
        $field                   = ' SUM(order_amount) as orderamount,DAY(FROM_UNIXTIME(order_add_time)) as dayval,HOUR(FROM_UNIXTIME(order_add_time)) as hourval ';
        if (C('dbdriver') == 'mysql') {
            $stat_order = $model->statByStatorder($where, $field, 0, 0, '', 'dayval,hourval');
        } elseif (C('dbdriver') == 'oracle') {
            $stat_order = $model->statByStatorder($where, $field, 0, 0, '', 'DAY(FROM_UNIXTIME(order_add_time)),HOUR(FROM_UNIXTIME(order_add_time))');
        } else {
            $stat_order = [];
        }
        $up_arr   = [];
        $curr_arr = [];
        if ($stat_order) {
            foreach ($stat_order as $k => $v) {
                if ($today_day == $v['dayval']) {
                    $curr_arr[$v['hourval']] = intval($v['orderamount']);
                }
                if ($yesterday_day == $v['dayval']) {
                    $up_arr[$v['hourval']] = intval($v['orderamount']);
                }
            }
        }
        $stat_arr['series'][0]['name'] = '昨天';
        $stat_arr['series'][0]['data'] = array_values($up_arr);
        $stat_arr['series'][1]['name'] = '今天';
        $stat_arr['series'][1]['data'] = array_values($curr_arr);
        //得到统计图数据
        $stat_arr['title'] = date('Y-m-d', $stat_time) . '销售走势';
        $stat_arr['yAxis'] = '销售额';
        $stattoday_json    = getStatData_LineLabels($stat_arr);
        unset($stat_arr);

        /*
         * 7日内店铺销售TOP30
         */
        $stime                   = $stat_time - 86400 * 6;//7天前0点
        $etime                   = $stat_time + 86400 - 1;//今天24点
        $where                   = [];
        $where['order_isvalid']  = 1;//计入统计的有效订单
        $where['order_add_time'] = ['between', [$stime, $etime]];
        $field                   = ' SUM(order_amount) as orderamount, store_id, min(store_name) as store_name ';
        $storetop30_arr          = $model->statByStatorder($where, $field, 0, 0, 'orderamount desc', 'store_id');

        /*
         * 7日内商品销售TOP30
         */
        $stime                   = $stat_time - 86400 * 6;//7天前0点
        $etime                   = $stat_time + 86400 - 1;//今天24点
        $where                   = [];
        $where['order_isvalid']  = 1;//计入统计的有效订单
        $where['order_add_time'] = ['between', [$stime, $etime]];
        $field                   = ' sum(goods_num) as ordergoodsnum, goods_id, min(goods_name) as goods_name';
        $goodstop30_arr          = $model->statByStatordergoods($where, $field, 0, 30, 'ordergoodsnum desc', 'goods_id');
        Tpl::output('goodstop30_arr', $goodstop30_arr);
        Tpl::output('storetop30_arr', $storetop30_arr);
        Tpl::output('stattoday_json', $stattoday_json);
        Tpl::output('statnew_arr', $statnew_arr);
        Tpl::output('stat_time', $stat_time);
        Tpl::output('top_link', $this->sublink($this->links, 'general'));
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('stat.general.index');
    }

    /**
     * 统计设置
     */
    public function settingOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $update_array = [];
            if ($_POST['pricerange']) {
                $pricerange_arr = [];
                foreach ((array)$_POST['pricerange'] as $k => $v) {
                    $pricerange_arr[] = $v;
                }
                $update_array['stat_pricerange'] = serialize($pricerange_arr);
            } else {
                $update_array['stat_pricerange'] = '';
            }
            $result = $model_setting->updateSetting($update_array);
            if ($result === true) {
                $this->log(L('nc_edit,stat_setting'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,stat_setting'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting                    = $model_setting->getListSetting();
        $list_setting['stat_pricerange'] = unserialize($list_setting['stat_pricerange']);
        Tpl::output('list_setting', $list_setting);
        Tpl::output('top_link', $this->sublink($this->links, 'setting'));
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('stat.setting');
    }

    /**
     * 统计设置
     */
    public function orderprangeOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $update_array = [];
            if ($_POST['pricerange']) {
                $pricerange_arr = [];
                foreach ((array)$_POST['pricerange'] as $k => $v) {
                    $pricerange_arr[] = $v;
                }
                $update_array['stat_orderpricerange'] = serialize($pricerange_arr);
            } else {
                $update_array['stat_orderpricerange'] = '';
            }
            $result = $model_setting->updateSetting($update_array);
            if ($result === true) {
                $this->log(L('nc_edit,stat_setting'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,stat_setting'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting                         = $model_setting->getListSetting();
        $list_setting['stat_orderpricerange'] = unserialize($list_setting['stat_orderpricerange']);
        Tpl::output('list_setting', $list_setting);
        Tpl::output('top_link', $this->sublink($this->links, 'orderprange'));
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('stat.setting.orderprange');
    }
}
