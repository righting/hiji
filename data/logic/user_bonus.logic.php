<?php
/**
 * 虚拟订单行为
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class user_bonusLogic
{
    /**
     * 开始分红,每次分红后需要在platform_profit表中加一条扣除利润的数据
     */
    public function beginBonus()
    {
        // 消费共享分红(一天一统计，一天一分红)
        p('================================ 消费共享分红-团队消费共享分红 ================================');
        $this->statisticsSalesShareBonusForTeam();

        // 统计消费日分红(一月一统计，一天一分红,ok)
        p('================================ 统计消费日分红 ================================');
        $this->salesBonusForDay();

        // 统计消费明星日分红(一月一统计，一天一分红,ok)
        p('================================ 统计销售明星日分红 ================================');
        $this->statisticsSellingStarDayBonus();

        // 统计共享日分红(一月一统计，一天一分红 ok)这里只有老会员的，新会员在消费的时候就会自动统计
        p('================================ 统计共享日分红 ================================');
        $this->statisticalShareDayBonus();

        // 消费新人奖(一天一统计，一天一分红,ok)
        p('================================ 消费新人奖 ================================');
        $this->newPersonalBonus();

        // 中层管理周分红(一月一统计，一周一分红,ok)
        p('================================ 中层管理周分红 ================================');
        $this->statisticsMiddleManagementBonusWeekly();

        // 供应商推荐奖金(一月一统计，一月一分红,ok)
        p('================================ 供应商推荐奖金 ================================');
        $this->statisticsSupplierReferralBonus();

        // 至尊消费月分红(一月一统计，一月一分红，每月十五号,ok)
        p('================================ 至尊消费月分红 ================================');
        $this->statisticsBlackDiamondSalesBonus();

        // 消费精英月分红(一月一统计，一月一分红，每月十五号,ok)
        p('================================ 消费精英月分红 ================================');
        $this->statisticsEliteMonthlyBonus();

        // 高层消费月分红(一月一统计，一月一分红，每月十五号，ok)
        p('================================ 高层消费月分红 ================================');
        $this->statisticsTopSellingMonthlyBonus();

        // 销售管理普惠周奖金(一月一统计，一周一分红,ok)
        p('================================ 销售管理普惠周奖金 ================================');
        $this->statisticsSalesManagementWeekBonus();

        // 消费资本-消费养老(一月一统计，一月一分红,ok)
        p('================================ 消费资本-消费养老 ================================');
        $this->statisticsConsumptionPension();

        // 消费资本-车房梦想(一月一统计，一月一分红)
        p('================================ 消费资本-车房梦想 ================================');
        $this->statisticsGaragesDream();

        // 将奖金池中今天要转给用户的钱转给指定用户
        $this->addMoneyFromMoneyPool();
        showDialog('分红成功', urlShop('test', 'bonus'), 'succ');
    }

    // 统计消费共享分红
    public function statisticsSalesShareBonusForTeam()
    {
        // 今天开始时间
        $current_begin_date = $this->getCurrentBeginDate();
        // 今天结束时间
        $current_end_date = $this->getCurrentEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        // 昨天开始和结束时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        $yesterday_end_at   = $this->getYesterdayEndAt();
        // 检查这个分红是否已经统计了昨天的数据（开始时间是今天的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_SALES_SHARE_BONUS_FOR_TEAM;
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_DAY;// 每天一次
        // 每天统计一次
        $check_has_statistics = $user_bonus_model->where(['created_at' => ['between', [$current_begin_date, $current_end_date]], 'type' => $type_bonus])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->salesShareBonusForTeam();
            return false;
        }
        // 获取所有昨天产生了团队消费共享分红的用户以及他们的上级团队用户
        $user_bonus_pool_model = new user_bonus_poolModel();
        $where['created_at']   = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $where['type']         = $type_bonus;
        $user_arr              = $user_bonus_pool_model->where($where)->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_id_arr = array_unique(array_column($user_arr, 'to_user_id'));
        $data        = [];
        foreach ($user_id_arr as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $current_begin_date;
            $data[$key]['end_at']     = $current_end_date;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll($data);
            // 开始分红
            $this->salesShareBonusForTeam();
        }
        return false;
    }

    // 消费共享分红
    public function salesShareBonusForTeam()
    {
        // 今天开始时间
        $current_begin_date = $this->getCurrentBeginDate();
        // 昨天开始和结束时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        $yesterday_end_at   = $this->getYesterdayEndAt();
        $user_bonus_model   = new user_bonusModel();
        // 当前分红类型
        $type_bonus = $user_bonus_model::TYPE_SALES_SHARE_BONUS_FOR_TEAM;
        $cycle_type = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        // 最近更新时间小于今天开始时间
        $where['updated_at'] = ['LT', $current_begin_date];
        // 统计时间大于今天开始时间
        $where['created_at'] = ['GT', $current_begin_date];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取昨天资金池中产生的消费共享分红总金额（本分红在订单确认时剩余的可分配商品利润中已扣除，不需要再在此处扣除）
        $user_bonus_pool_model               = new user_bonus_poolModel();
        $user_bonus_pool_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $user_bonus_pool_where['type']       = $type_bonus;
        $user_bonus_pool_where['to_user_id'] = ['in', $user_id_arr];
        // 获取每个邀请人的团队产生的总分红 2017/04/28
        $share_bonus_for_team_money_info         = $user_bonus_pool_model->where($user_bonus_pool_where)->field('to_user_id,sum(money) as total_money,sum(sales_profit) as total_sales_profit,sum(order_total_money) as order_total_money')->group('to_user_id')->select();
        $share_bonus_for_team_money_for_user_arr = array_combine(array_column($share_bonus_for_team_money_info, 'to_user_id'), array_column($share_bonus_for_team_money_info, 'total_money'));
        $sales_profit_total_money_arr            = array_combine(array_column($share_bonus_for_team_money_info, 'to_user_id'), array_column($share_bonus_for_team_money_info, 'order_total_money'));
        // 获取昨天资金池中产生的消费共享分红总金额
        $total_money = array_sum($share_bonus_for_team_money_for_user_arr);
        // 获取昨天资金池中产生消费共享分红的订单总税前利润
        $sales_profit_total_money = array_sum($sales_profit_total_money_arr);
        // 获取这些用户的等级信息
        $member_model     = new memberModel();
        $user_level_model = new user_levelModel();
        // 获取该用户的会员等级
        $user_info             = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,level_id,member_name')->select();
        $user_id_and_level_arr = array_combine(array_column($user_info, 'member_id'), array_column($user_info, 'level_id'));
        $user_member_name_arr  = array_combine(array_column($user_info, 'member_id'), array_column($user_info, 'member_name'));
        // 获取等级对应的分享比例
        $level_info                            = $user_level_model->field('id,team_invite_royalty_rate')->select();
        $level_id_and_team_invite_royalty_rate = array_combine(array_column($level_info, 'id'), array_column($level_info, 'team_invite_royalty_rate'));
        $level_name                            = $user_level_model->where(['id' => ['eq', $user_info['level_id']]])->field('id,level_name')->find();
        // 获取这些用户的hi值信息
        $user_hi_value_model  = new user_hi_valueModel();
        $total_hi_value_info  = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("user_id,sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->group('user_id')->select();
        $user_id_and_hi_value = array_combine(array_column($total_hi_value_info, 'user_id'), array_column($total_hi_value_info, 'hi_value'));
        // 获取会员hi值总和
        $total_hi_value = array_sum($user_id_and_hi_value);
        // 获取会员按照等级可获取的分红金额
        $user_bonus_money_for_level = [];
        foreach ($user_id_arr as $user_id) {
            // 当前用户贡献的团队分红池中的金额
            $this_user_team_money = $share_bonus_for_team_money_for_user_arr[$user_id];
            // 当前会员等级
            $this_user_level_id = $user_id_and_level_arr[$user_id];
            // 当前会员等级的分享比例
            $this_user_team_invite_royalty_rate = $level_id_and_team_invite_royalty_rate[$this_user_level_id];
            // 当前用户所有直推会员产生的总利润
            $this_user_team_sales_profit_total_money = $sales_profit_total_money_arr[$user_id];
            // 当前会员按照等级可获取的分红金额
            /**
             * 如果用消费额算有一个问题，消费的多不一定产生的分红就多
             * 例如：有个1w的商品，供货价9990 跟 100的商品 供货价 70
             */
//            $this_user_level_money = bcdiv(bcmul($this_user_team_money,$this_user_team_invite_royalty_rate,2),100,2);
            // 当前用户所有直推会员产生的总利润 / 昨天资金池中产生消费共享分红的订单总利润 * 昨天资金池中产生的消费共享分红总金额 * 当前会员等级的分享比例
            $this_user_level_money                = bcdiv(bcdiv(bcmul(bcmul($this_user_team_sales_profit_total_money, $total_money, 2), $this_user_team_invite_royalty_rate, 2), $sales_profit_total_money, 2), 100, 2);
            $user_bonus_money_for_level[$user_id] = $this_user_level_money;
        }
        // 会员按照等级已分配的分红金额
        $total_bonus_money_for_level = array_sum($user_bonus_money_for_level);
        // 如果等级分配的金额小于总金额，那么剩下的金额按会员hi值来分
        $user_bonus_money_for_hi = [];
        if (bccomp($total_money, $total_bonus_money_for_level) == 1) {
            $total_hi_money = bcsub($total_money, $total_bonus_money_for_level, 2);
            if ($total_hi_money > 0) {
                foreach ($user_id_arr as $user_id) {
                    // 当前会员 HI 值
                    $this_user_hi_value = $user_id_and_hi_value[$user_id];
                    // 当前会员按照HI值可获取的分红金额
                    $this_user_level_money             = bcdiv(bcmul($this_user_hi_value, $total_hi_money, 2), $total_hi_value, 2);
                    $user_bonus_money_for_hi[$user_id] = $this_user_level_money;
                }
            }
        }
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        foreach ($user_id_arr as $ks => $user_id) {
            $remark_arr[] = '当前会员 ID：' . $user_id;
            $remark_arr[] = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '昨天资金池中产生的消费共享分红总金额：' . $total_money;
            $remark_arr[] = '昨天资金池中产生消费共享分红的订单总利润：' . $sales_profit_total_money;
            // 当前用户贡献的团队分红池中的金额
            $this_user_team_money = $share_bonus_for_team_money_for_user_arr[$user_id];
            $remark_arr[]         = '当前用户贡献的团队分红池中的金额：' . $this_user_team_money;
            // 当前用户所有直推会员产生的总利润
            $this_user_team_sales_profit_total_money = $sales_profit_total_money_arr[$user_id];
            $remark_arr[]                            = '当前用户所有直推会员昨天产生的总利润：' . $this_user_team_sales_profit_total_money;
            // 当前会员等级
            $this_user_level_id = $user_id_and_level_arr[$user_id];
            $remark_arr[]       = '当前会员等级id：' . $this_user_level_id;
            $remark_arr[]       = '当前会员等级名称：' . $level_name['level_name'];

            // 当前会员等级的分享比例
            $this_user_team_invite_royalty_rate = $level_id_and_team_invite_royalty_rate[$this_user_level_id];
            $remark_arr[]                       = '当前会员等级的分享比例：' . $this_user_team_invite_royalty_rate;
            // 当前会员 HI 值
            $this_user_hi_value = isset($user_id_and_hi_value[$user_id]) ? $user_id_and_hi_value[$user_id] : 0;
            $remark_arr[]       = '总 HI 值：' . $total_hi_value;
            $remark_arr[]       = '当前会员 HI 值：' . $this_user_hi_value;
            // 当前会员按照等级可获取的分红金额
            $this_user_level_money = isset($user_bonus_money_for_level[$user_id]) ? $user_bonus_money_for_level[$user_id] : 0;
            $remark_arr[]          = '当前会员按照等级可获取的分红金额：' . $this_user_level_money;
            // 当前会员按照hi值可获取的分红金额
            $this_user_hi_money                                    = isset($user_bonus_money_for_hi[$user_id]) ? $user_bonus_money_for_hi[$user_id] : 0;
            $remark_arr[]                                          = '当前会员按照hi值可获取的分红金额：' . $this_user_hi_money;
            $add_money_arr[$user_id]                               = bcadd($this_user_level_money, $this_user_hi_money, 2);
            $remark_arr[]                                          = '当前会员获得的当前分红类型的总金额：' . bcadd($this_user_level_money, $this_user_hi_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $total_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        // 计算已经分出去的分红
        $dividends_paid = array_sum($add_money_arr);
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 将已分配的分红从平台利润中扣除(此分红不已经在订单完成时扣除了当前分红的金额，此处不能再次扣除)
//            $this->platformProfitDec($dividends_paid,$cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 消费资本-消费养老（1,2,3,4,5,6,9,10）
    public function statisticsConsumptionPension()
    {
        // 获取加入了消费养老的用户
        $subsidy_apply_model = new subsidyModel();
        $user_list           = $subsidy_apply_model->where(['type_id' => 1, 'status' => 1])->select();
        if (empty($user_list)) {
            return false;
        }
        // 检查这个月是否已经统计了需要发放消费养老补贴的用户
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION;        // 高层销售月分红
        $frequency_type   = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月分一次

        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->consumptionPension();
            return false;
        }
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 获取加入计算的分红类型
        $user_bonus_log_model = new user_bonus_logModel();
        $type_arr             = $user_bonus_log_model->getSubsidyLogType();
        $user_id_arr          = array_column($user_list, 'user_id');
        // 获取这些用户中上个月获得了分红的用户
        $user_bonus_log_where['user_id']    = ['in', $user_id_arr];
        $user_bonus_log_where['type']       = ['in', array_keys($type_arr)];
        $user_bonus_log_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr                           = $user_bonus_log_model->where($user_bonus_log_where)->field('user_id')->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_data      = array_unique(array_column($user_arr, 'user_id'));
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_type;
            $data[$key]['created_at'] = $current_date;

        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->consumptionPension();
        }
        return false;
    }

    public function consumptionPension()
    {
        $subsidy_type = 1;
        // 当月开始时间
        $bonus_begin_at   = $this->getCurrentMonthBeginDate();
        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION;        // 当前分红类型
        $cycle_type       = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 最近更新时间小于本月开始时间
        $where['updated_at'] = ['LT', $bonus_begin_at];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 本月需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取用户id和对应等级id
        // 获取用户的职位级别信息
        $member_model            = new memberModel();
        $user_lists_for_position = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,level_id,member_name')->select();
        // 以member_id作为数组的键
        $user_level_for_user_id = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'level_id'));
        $user_user_for_user_id  = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'member_name'));
        // 获取用户id对应的转移比例
        $subsidy_model         = new subsidyModel();
        $user_proportion_lists = $subsidy_model->where(['user_id' => ['in', $user_id_arr]])->field('user_id,proportion')->select();
        // 以user_id作为数组的键
        $user_proportion_for_user_id = array_combine(array_column($user_proportion_lists, 'user_id'), array_column($user_proportion_lists, 'proportion'));

        // 获取加入计算的分红类型
        $user_bonus_log_model = new user_bonus_logModel();
        $type_arr             = $user_bonus_log_model->getSubsidyLogType();
        // 获取这些用户上个月获得的总分红

        $user_bonus_log_where['user_id']    = ['in', $user_id_arr];
        $user_bonus_log_where['type']       = ['in', array_keys($type_arr)];
        $user_bonus_log_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr                           = $user_bonus_log_model->where($user_bonus_log_where)->field('user_id,sum(money) as total_money')->group('user_id')->select();
        $user_id_and_total_money            = array_combine(array_column($user_arr, 'user_id'), array_column($user_arr, 'total_money'));

        $user_level_model     = new user_levelModel();
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        foreach ($user_id_and_total_money as $user_id => $user_total_money) {
            $remark_arr[]   = '当前会员 ID：' . $user_id;
            $this_user_name = $user_user_for_user_id[$user_id];
            $remark_arr[]   = '当前会员名称：' . $this_user_name;

            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);

            $remark_arr[] = '分红时间：' . $now_date;
            // 当前用户的等级
            $this_user_level = $user_level_for_user_id[$user_id];
            $remark_arr[]    = '当前用户的等级：' . $this_user_level;
            // 当前用户的分红转移比例
            $this_user_proportion = $user_proportion_for_user_id[$user_id];
            $remark_arr[]         = '当前用户的分红转移比例：' . $this_user_proportion;
            // 当前用户等级对应的比例数组
            $this_user_level_ratio_arr = $user_level_model->getBonusRate($this_user_level);
            // 当前用户等级对应的补贴比例
            $subsidy_ratio = $this_user_level_ratio_arr['type_consumption_capital_subsidy_consumption_pension'];
            $remark_arr[]  = '当前用户等级对应的补贴比例：' . $subsidy_ratio;
            // 当前用户获得的补贴 = 消费分红奖金 x 转移奖金比例 x 补贴比例
            $remark_arr[]                                          = '当前用户上月消费分红奖金：' . $user_total_money;
            $this_user_subsidy_money                               = bcdiv(bcdiv(bcmul(bcmul($user_total_money, $this_user_proportion, 2), $subsidy_ratio, 2), 100, 2), 100, 2);
            $remark_arr[]                                          = '当前用户获得的补贴：' . $this_user_subsidy_money;
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = 0;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
            $add_money_arr[$user_id]                      = $this_user_subsidy_money;
        }

        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
            // 将获得的金额更新到用户补贴表里面，这样就能看到这个用户总共获得了多少补贴了
            $subsidy_model->updateUserSubsidyMoney($add_money_arr, $subsidy_type);
        }
        return false;
    }

    // 消费资本-车房梦想
    public function statisticsGaragesDream()
    {
        // 获取加入了消费养老的用户
        $subsidy_apply_model = new subsidyModel();
        $user_list           = $subsidy_apply_model->where(['type_id' => 2, 'status' => 1])->select();
        if (empty($user_list)) {
            return false;
        }
        // 检查这个月是否已经统计了需要发放消费养老补贴的用户
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM;        // 高层销售月分红
        $frequency_type   = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月分一次

        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->garagesDream();
            return false;
        }

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 获取加入计算的分红类型
        $user_bonus_log_model = new user_bonus_logModel();
        $type_arr             = $user_bonus_log_model->getSubsidyLogType();
        $user_id_arr          = array_column($user_list, 'user_id');
        // 获取这些用户中上个月获得了分红的用户
        $user_bonus_log_where['user_id']    = ['in', $user_id_arr];
        $user_bonus_log_where['type']       = ['in', array_keys($type_arr)];
        $user_bonus_log_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr                           = $user_bonus_log_model->where($user_bonus_log_where)->field('user_id')->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_data      = array_unique(array_column($user_arr, 'user_id'));
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_type;
            $data[$key]['created_at'] = $current_date;

        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->garagesDream();
        }
        return false;
    }

    public function garagesDream()
    {
        $subsidy_type = 2;
        // 当月开始时间
        $bonus_begin_at   = $this->getCurrentMonthBeginDate();
        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM;        // 当前分红类型
        $cycle_type       = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式
        // 最近更新时间小于本月开始时间
        $where['updated_at'] = ['LT', $bonus_begin_at];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_id_lists = $user_bonus_model->where($where)->select();
        // 本月需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取用户id和对应等级id
        // 获取用户的职位级别信息
        $member_model            = new memberModel();
        $user_lists_for_position = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,level_id,member_name')->select();
        // 以member_id作为数组的键
        $user_level_for_user_id = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'level_id'));
        $user_user_for_user_id  = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'member_name'));
        // 获取用户id对应的转移比例
        $subsidy_model         = new subsidyModel();
        $user_proportion_lists = $subsidy_model->where(['user_id' => ['in', $user_id_arr]])->field('user_id,proportion')->select();
        // 以user_id作为数组的键
        $user_proportion_for_user_id = array_combine(array_column($user_proportion_lists, 'user_id'), array_column($user_proportion_lists, 'proportion'));

        // 获取加入计算的分红类型
        $user_bonus_log_model = new user_bonus_logModel();
        $type_arr             = $user_bonus_log_model->getSubsidyLogType();
        // 获取这些用户上个月获得的总分红

        $user_bonus_log_where['user_id']    = ['in', $user_id_arr];
        $user_bonus_log_where['type']       = ['in', array_keys($type_arr)];
        $user_bonus_log_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr                           = $user_bonus_log_model->where($user_bonus_log_where)->field('user_id,sum(money) as total_money')->group('user_id')->select();
        $user_id_and_total_money            = array_combine(array_column($user_arr, 'user_id'), array_column($user_arr, 'total_money'));

        $user_level_model     = new user_levelModel();
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        foreach ($user_id_and_total_money as $user_id => $user_total_money) {
            $remark_arr[]   = '当前会员 ID：' . $user_id;
            $this_user_name = $user_user_for_user_id[$user_id];
            $remark_arr[]   = '当前会员名称：' . $this_user_name;
            $remark_arr[]   = '当前分红类型：' . $type_bonus;
            $remark_arr[]   = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);

            $remark_arr[] = '分红时间：' . $now_date;
            // 当前用户的等级
            $this_user_level = $user_level_for_user_id[$user_id];
            $remark_arr[]    = '当前用户的等级：' . $this_user_level;
            // 当前用户的分红转移比例
            $this_user_proportion = $user_proportion_for_user_id[$user_id];
            $remark_arr[]         = '当前用户的分红转移比例：' . $this_user_proportion;
            // 当前用户等级对应的比例数组
            $this_user_level_ratio_arr = $user_level_model->getBonusRate($this_user_level);
            // 当前用户等级对应的补贴比例
            $subsidy_ratio = $this_user_level_ratio_arr['type_consumption_capital_subsidy_garages_dream'];
            $remark_arr[]  = '当前用户等级对应的补贴比例：' . $subsidy_ratio;
            // 当前用户获得的补贴 = 消费分红奖金 x 转移奖金比例 x 补贴比例
            $remark_arr[]                                          = '当前用户上月消费分红奖金：' . $user_total_money;
            $this_user_subsidy_money                               = bcdiv(bcdiv(bcmul(bcmul($user_total_money, $this_user_proportion, 2), $subsidy_ratio, 2), 100, 2), 100, 2);
            $remark_arr[]                                          = '当前用户获得的补贴：' . $this_user_subsidy_money;
            $add_money_arr[$user_id]                               = $this_user_subsidy_money;
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = 0;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
            $subsidy_model->updateUserSubsidyMoney($add_money_arr, $subsidy_type);
        }
        return false;
    }

    /**
     * 获取分红分期数据
     *
     * @param int $status 0 =上一期 1=当期
     * @return mixed
     */
    public function getStages($status = 1)
    {
        $stagesModel = new stagesModel();
        return $stagesModel->getUserBonusStagesInfo(['status' => $status], 1)[0];//获取上一期的数据【status=1】 1=进行中 0=已闭环
    }

    // 获取上个月开始时间
    public function getLastMonthBeginDate()
    {
        $getStagesInfo = $this->getStages(0);
        return $getStagesInfo['start_time'];
    }

    // 获取上个月结束时间
    public function getLastMonthEndDate()
    {
        $getStagesInfo = $this->getStages(0);
        return $getStagesInfo['end_time'];
    }

    // 获取当月开始时间
    public function getCurrentMonthBeginDate()
    {
        $getStagesInfo = $this->getStages(1);
        return $getStagesInfo['start_time'];
    }

    // 获取当月结束时间
    public function getCurrentMonthEndDate()
    {
        $getStagesInfo = $this->getStages(1);
        return $getStagesInfo['end_time'];
    }

    // 获取当月15号开始时间
    public function getCurrentMiddleMonthDate()
    {
        return date("Y-m-d H:i:s", strtotime(date('Y-m-15')));
    }

    // 获取当月15号结束时间
    public function getCurrentMiddleMonthEndDate()
    {
        return date("Y-m-d H:i:s", strtotime(date('Y-m-16') - 1));
    }

    // 获取上月15号
    public function getLastMonthMiddleMonthDate()
    {
        return date("Y-m-d H:i:s", strtotime("-1 month", strtotime(date('Y-m-15'))));
    }

    // 获取昨天开始时间
    public function getYesterdayBeginAt()
    {
        return date("Y-m-d H:i:s", strtotime("-1 day", strtotime(date('Y-m-d'))));
    }

    // 获取昨天结束时间
    public function getYesterdayEndAt()
    {
        return date("Y-m-d H:i:s", strtotime($this->getCurrentBeginDate()) - 1);
    }

    // 获取到昨天为止，30天以前的开始时间
    // 调整为获取到昨天为止，一个分红周期的时间
    public function thirtyDaysAgoAt()
    {
        $user_bonus_model = new user_bonusModel();
        return $thirty_days_ago_at = date("Y-m-d H:i:s", strtotime('+' . $user_bonus_model::FREQUENCY_FOR_MONTH . ' day', strtotime("+1 day", strtotime(date('Y-m-d'))) - 1));
        //return date("Y-m-d H:i:s", strtotime("-30 day", strtotime($this->getYesterdayBeginAt())));
    }

    // 获取今天开始时间
    public function getCurrentBeginDate()
    {
        return date("Y-m-d H:i:s", strtotime(date('Y-m-d')));
    }

    // 获取当前时间
    public function getCurrentDate()
    {
        return date('Y-m-d H:i:s');
    }

    // 获取今天结束时间
    public function getCurrentEndDate()
    {
        return date("Y-m-d H:i:s", strtotime("+1 day", strtotime(date('Y-m-d'))) - 1);
    }

    // 获取明天开始时间
    public function getTomorrowBeginDate()
    {
        return date("Y-m-d H:i:s", strtotime("+1 day", strtotime(date('Y-m-d'))));
    }

    // 获取上周开始时间
    public function getLastWeeklyBeginDate()
    {
        $getStagesInfo = $this->getStages(1);
        $weekTimeAll   = explode('|', $getStagesInfo['week_time']);
        $nowTime       = date('Y-m-d H:i:s');
        $key           = '';
        $weekStartTime = '';
        foreach ($weekTimeAll as $k => $v) {
            if (explode(',', $v)[0] <= $nowTime && explode(',', $v)[1] >= $nowTime) {
                $key = $k - 1; // -1为获取上周数据
                continue;
            }
        }

        if ($key == '' || $key == '-1') {
            $getStages     = $this->getStages(0);
            $weekTime      = explode('|', $getStages['week_time']);
            $weekStartTime = explode(',', $weekTime[3])[0];
        } else {
            $weekStartTime = explode(',', $weekTimeAll[$key])[0];
        }

        return $weekStartTime;
    }

    // 获取上周结束时间
    public function getLastWeeklyEndDate()
    {
        $getStagesInfo = $this->getStages(1);
        $weekTimeAll   = explode('|', $getStagesInfo['week_time']);
        $nowTime       = date('Y-m-d H:i:s');
        $key           = '';
        $weekStartTime = '';
        foreach ($weekTimeAll as $k => $v) {
            if (explode(',', $v)[0] <= $nowTime && explode(',', $v)[1] >= $nowTime) {
                $key = $k - 1; // -1为获取上周数据
                continue;
            }
        }

        if ($key == '' || $key == '-1') {
            $getStages     = $this->getStages(0);
            $weekTime      = explode('|', $getStages['week_time']);
            $weekStartTime = explode(',', $weekTime[3])[1];
        } else {
            $weekStartTime = explode(',', $weekTimeAll[$key])[1];
        }

        return $weekStartTime;


    }

    // 获取本周开始时间
    public function getCurrentWeeklyBeginDate()
    {
        $getStagesInfo = $this->getStages(1);
        $weekTimeAll   = explode('|', $getStagesInfo['week_time']);
        $nowTime       = date('Y-m-d H:i:s');
        $time          = '';
        foreach ($weekTimeAll as $k => $v) {
            if (explode(',', $v)[0] <= $nowTime && explode(',', $v)[1] >= $nowTime) {
                $time = $v;
                continue;
            }
        }
        return explode(',', $time)[0];
    }

    // 获取本周结束时间
    public function getCurrentWeeklyEndDate()
    {
        $getStagesInfo = $this->getStages(1);
        $weekTimeAll   = explode('|', $getStagesInfo['week_time']);
        $nowTime       = date('Y-m-d H:i:s');
        $time          = '';
        foreach ($weekTimeAll as $k => $v) {
            if (explode(',', $v)[0] <= $nowTime && explode(',', $v)[1] >= $nowTime) {
                $time = $v;
                continue;
            }
        }
        return explode(',', $time)[1];
    }

    // 获取平台利润
    public function getPlatformProfit($where)
    {
        // 获取昨天剩余的可分红利润
        $platform_profit_log_model = new platform_residual_dividend_profitModel();
        $surplus_profit_info       = $platform_profit_log_model->where($where)->find();
        $surplus_profit            = 0;
        if (!empty($surplus_profit_info) && isset($surplus_profit_info['money']) && ($surplus_profit_info['money'] > 0)) {
            $surplus_profit = $surplus_profit_info['money'];
        }
        return $surplus_profit;
    }

    public function getDeductionWhere($frequency_type)
    {
        $user_bonus_model = new user_bonusModel();

        // 如果是日分红，则扣除今天的所有日分红：销售新人奖，销售日分红，销售明星日分红，共享日分红
        $where = [];
        if ($frequency_type == 2) {// 每周一次(每周应该是7天，测试调整为2天，正式版本应该改回来7天)
            // 如果是周分红，分红金额 = 上周的总利润 - 上周扣掉的日分红：中层管理周分红
            $where['type']       = ['in', [14, 6, 7, 15]];
            $where['created_at'] = ['between', [$this->getLastWeeklyBeginDate(), $this->getLastWeeklyEndDate()]];
        } else if ($frequency_type == 2) {// 每周一次(每周应该是7天，测试调整为2天，正式版本应该改回来7天)
            // 如果是月分红，分红金额 = 上月的总利润 - 上月扣掉的周分红 - 上月扣掉的日分红：黑钻销售月分红，销售精英月分红，高层销售月分红，消费资本补贴
            $where['type']       = ['in', [14, 6, 7, 15, 10, 11, 12]];
            $where['created_at'] = ['between', [$this->getLastMonthBeginDate(), $this->getLastMonthEndDate()]];
        } else if ($frequency_type == 1) {
            // 如果是月分红，分红金额 = 上月的总利润 - 上月扣掉的周分红 - 上月扣掉的日分红：黑钻销售月分红，销售精英月分红，高层销售月分红，消费资本补贴
            $where['type']       = ['in', [14, 6, 7, 15]];
            $where['created_at'] = ['between', [$this->getCurrentBeginDate(), $this->getCurrentEndDate()]];
        }
        // 销售管理普惠周奖金，供应商推荐奖金
        return $where;
    }

    // 分红
    public function addMoney($add_money_arr, $current_user_bonus_type = 1)
    {
        $pd_model             = new predepositModel();
        $user_bonus_model     = new user_bonusModel();
        $user_bonus_log_model = new user_bonus_logModel();
        $user_bonus_log_data  = [];
        foreach ($add_money_arr as $key => $value) {
            // 分红数组
            $user_bonus_log_data[] = $user_bonus_log_model->getUserBonusLogDataArr(
                $key,
                $current_user_bonus_type,
                $value
            );
        }
        Db::beginTransaction();
        // 分红日志
        $new_user_bonus_log_data = array_merge($user_bonus_log_data);
        $user_bonus_log_model->insertAll($new_user_bonus_log_data);
        p('分红日志');
        // 预存款变更日志
        $pd_log_data = $user_bonus_log_model->getPdLogDataArr($new_user_bonus_log_data);
        $pd_model->insertAll($pd_log_data);
        p('预存款变更日志');
        // 以用户id为单位获取每个用户需要更新的金额数组
        $user_update_balance_arr = $user_bonus_log_model->getUpdateUserBalance($new_user_bonus_log_data);
        // 预存款修改sql
        $sql = $user_bonus_log_model->getUpdateUserBalanceSQL($user_update_balance_arr);
        if ($sql != '') {
            DB::execute($sql);
            p('预存款修改sql:' . $sql);
        }
        // 更新分红表中的分红时间
        $user_id          = array_keys($add_money_arr);
        $where['user_id'] = ['in', $user_id];
        $where['type']    = $current_user_bonus_type;
        $user_bonus_model->where($where)->update(['updated_at' => $this->getCurrentDate()]);
        Db::commit();
    }

    // 销售新人分红
    public function newPersonalBonusTest($start_date, $end_date)
    {
        // 今天开始时间
        //$current_begin_date = $this->getCurrentBeginDate();

        $current_begin_date = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($start_date)));

        // 昨天结束时间
        $yesterday_begin_at = $start_date;
        $yesterday_end_at   = $end_date;

        $user_bonus_model = new user_bonusModel();

        // 获取到昨天为止，30天以前的开始时间
        $thirty_days_ago_at = $this->thirtyDaysAgoAt();
        //$thirty_days_ago_at = date("Y-m-d H:i:s", strtotime($user_bonus_model::FREQUENCY_FOR_MONTH, strtotime($this->getYesterdayBeginAt())));

        $type_bonus = $user_bonus_model::TYPE_NEW_SALES_AWARD;// 销售新人奖

        $current_date = $this->getCurrentDate();
        // 类型是销售新人奖，开始时间小于今天，且结束时间大于当前时间,最近更新时间小于今天开始时间
        $user_lists_where['type']       = $type_bonus;
        $user_lists_where['begin_at']   = ['LT', $current_begin_date];
        $user_lists_where['end_at']     = ['EGT', $current_date];
        $user_lists_where['updated_at'] = ['elt', $current_begin_date];
        $user_lists                     = $user_bonus_model->where($user_lists_where)->select();
        if (empty($user_lists)) {
            return false;
        }
        $user_id_arr = array_column($user_lists, 'user_id');
        // 获取会员的所有消费总和(按会员id统计)
        $user_consumption_sale_log_day_model     = new user_consumption_sale_log_dayModel();
        $consumption_money_info_where['user_id'] = ['in', $user_id_arr];
        $consumption_money_info_where['type']    = $user_consumption_sale_log_day_model::LOG_TYPE_CONSUMPTION;
        $consumption_money_info                  = $user_consumption_sale_log_day_model->where($consumption_money_info_where)->field('user_id,sum(total_money) as total_money')->group('user_id')->select();
        if (empty($consumption_money_info)) {
            return false;
        }
        // 以用户id为键，消费额为值组合数组
        $consumption_money_for_user_id = array_combine(array_column($consumption_money_info, 'user_id'), array_column($consumption_money_info, 'total_money'));
        // 获取总的消费额
        $total_consumption_money = array_sum(array_column($consumption_money_info, 'total_money'));
        // 昨天开始时间
        //$yesterday_begin_at = $this->getYesterdayBeginAt();
        // 昨天结束时间
        //$yesterday_end_at = $this->getYesterdayEndAt();
        // 获取平台昨天的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        $yesterday_profit_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $yesterday_profit_where['cycle']      = $cycle_type;
        $yesterday_profit                     = $this->getPlatformProfit($yesterday_profit_where);
        if ($yesterday_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($yesterday_profit, 0.02, 2);

        // 获得新人销售鼓励基金的用户
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];

        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));

        foreach ($user_id_arr as $user_id) {
            $this_user_total_money                                 = $consumption_money_for_user_id[$user_id];
            $remark_arr[]                                          = '当前会员ID：' . $user_id;
            $remark_arr[]                                          = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[]                                          = '当前分红类型：' . $type_bonus;
            $remark_arr[]                                          = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[]                                          = '平台昨天的利润：' . $yesterday_profit;
            $remark_arr[]                                          = '当前分红类型可分配的利润：' . $current_bonus_money;
            $remark_arr[]                                          = '该用户所下的订单总金额：' . $this_user_total_money;
            $remark_arr[]                                          = '享受该奖金的所有用户的总订单金额：' . $total_consumption_money;
            $remark_arr[]                                          = '当前用户可获得奖金：' . bcdiv(bcmul($this_user_total_money, $current_bonus_money, 4), $total_consumption_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
            $add_money_arr[$user_id]                      = bcdiv(bcmul($this_user_total_money, $current_bonus_money, 4), $total_consumption_money, 2);
        }

        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 销售新人分红
    public function newPersonalBonus()
    {
        // 今天开始时间
        $current_begin_date = $this->getCurrentBeginDate();

        // 昨天结束时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        $yesterday_end_at   = $this->getYesterdayEndAt();

        // 获取到昨天为止，30天以前的开始时间
        $thirty_days_ago_at = $this->thirtyDaysAgoAt();

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_NEW_SALES_AWARD;// 销售新人奖

        $current_date = $this->getCurrentDate();
        // 类型是销售新人奖，开始时间小于今天，且结束时间大于当前时间,最近更新时间小于今天开始时间
        $user_lists_where['type']       = $type_bonus;
        $user_lists_where['begin_at']   = ['LT', $current_begin_date];
        $user_lists_where['end_at']     = ['EGT', $current_date];
        $user_lists_where['updated_at'] = ['elt', $current_begin_date];
        $user_lists                     = $user_bonus_model->where($user_lists_where)->select();
        if (empty($user_lists)) {
            return false;
        }
        $user_id_arr = array_column($user_lists, 'user_id');
        // 获取会员的所有消费总和(按会员id统计)
        $user_consumption_sale_log_day_model     = new user_consumption_sale_log_dayModel();
        $consumption_money_info_where['user_id'] = ['in', $user_id_arr];
        $consumption_money_info_where['type']    = $user_consumption_sale_log_day_model::LOG_TYPE_CONSUMPTION;
        $consumption_money_info                  = $user_consumption_sale_log_day_model->where($consumption_money_info_where)->field('user_id,sum(total_money) as total_money')->group('user_id')->select();
        if (empty($consumption_money_info)) {
            return false;
        }
        // 以用户id为键，消费额为值组合数组
        $consumption_money_for_user_id = array_combine(array_column($consumption_money_info, 'user_id'), array_column($consumption_money_info, 'total_money'));
        // 获取总的消费额
        $total_consumption_money = array_sum(array_column($consumption_money_info, 'total_money'));
        // 昨天开始时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        // 昨天结束时间
        $yesterday_end_at = $this->getYesterdayEndAt();
        // 获取平台昨天的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        $yesterday_profit_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $yesterday_profit_where['cycle']      = $cycle_type;
        $yesterday_profit                     = $this->getPlatformProfit($yesterday_profit_where);
        if ($yesterday_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($yesterday_profit, 0.02, 2);
        // 获得新人销售鼓励基金的用户
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];

        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));

        foreach ($user_id_arr as $user_id) {
            $this_user_total_money                                 = $consumption_money_for_user_id[$user_id];
            $remark_arr[]                                          = '当前会员ID：' . $user_id;
            $remark_arr[]                                          = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[]                                          = '当前分红类型：' . $type_bonus;
            $remark_arr[]                                          = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[]                                          = '平台昨天的利润：' . $yesterday_profit;
            $remark_arr[]                                          = '当前分红类型可分配的利润：' . $current_bonus_money;
            $remark_arr[]                                          = '该用户所下的订单总金额：' . $this_user_total_money;
            $remark_arr[]                                          = '享受该奖金的所有用户的总订单金额：' . $total_consumption_money;
            $remark_arr[]                                          = '当前用户可获得奖金：' . bcdiv(bcmul($this_user_total_money, $current_bonus_money, 4), $total_consumption_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
            $add_money_arr[$user_id]                      = bcdiv(bcmul($this_user_total_money, $current_bonus_money, 4), $total_consumption_money, 2);
        }

        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 扣除平台利润
    public function platformProfitDec($dividends_paid, $cycle_type)
    {
        $platform_profit_log_model = new platform_residual_dividend_profitModel();
        // 获取扣除利润的时间段
        $platform_profit_log_model->deductSurplusProfit($dividends_paid, $cycle_type);
        return true;
    }

    // 把分红分配给用户
    public function addNewPersonalBonus($add_money_arr)
    {
        $msg      = '销售新人奖';
        $pd_model = new predepositModel();
        $pd_model->beginTransaction();
        $user_new_sales_incentive_fund_model = new user_new_sales_incentive_fundModel();
        $user_bonus_log_model                = new user_bonus_logModel();
        $current_user_bonus_type             = $user_bonus_log_model::TYPE_NEW_SALES_AWARD;
        $bonus_log_data                      = [];
        $date                                = date('Y-m-d H:i:s');
        foreach ($add_money_arr as $key => $value) {
            $data['msg']         = $msg;
            $data['member_id']   = $key;
            $data['member_name'] = '平台';
            $data['amount']      = $value;
            $pd_model->changePd('user_bonus_money', $data);

            $bonus_log_data[$key]['user_id']    = $key;
            $bonus_log_data[$key]['type']       = $current_user_bonus_type;
            $bonus_log_data[$key]['money']      = $value;
            $bonus_log_data[$key]['created_at'] = $date;
            $bonus_log_data[$key]['updated_at'] = $date;
        }

        if (!empty($bonus_log_data)) {
            $user_bonus_log_model->insertAll($bonus_log_data);
        }

        // 更新分红表中的分红时间
        $user_id          = array_keys($add_money_arr);
        $where['user_id'] = ['in', $user_id];
        $user_new_sales_incentive_fund_model->where($where)->update(['updated_at' => $this->getCurrentDate()]);
        $pd_model->commit();
    }

    // 统计销售日分红
    public function salesBonusForDay()
    {

        /**
         * ① 上个月是银尊VIP或以上会员级别的且“个人消费”累积了350元及以上的。
         * ② 上个月是银尊VIP或以上会员级别的且“个人消费”加个人微商销售额总计1000元及以上的。
         * ③ 免费VIP用户上个月“个人消费”累计1000元及以上的。
         * ④ 免费VIP用户上个月“个人消费”加个人微商销售额总计3000元及以上的。
         */

        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（开始时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_SALES_DAY_BONUS;// 销售日分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_DAY;// 每月统计一次，每天分红
        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->salesDayBonus();
            return false;
        }

        // 获取上个月所有$begin_level等级以上有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_level_id']              = ['in', [1, 2, 3, 4, 5, 6]];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();
        // 满足分红条件的会员
        $sales_day_bonus_user_id = $this->getUserArray($user_arr);
        if (empty($sales_day_bonus_user_id)) {
            return false;
        }
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        $created_at     = $this->getCurrentDate();
        $data           = [];
        foreach ($sales_day_bonus_user_id as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $created_at;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll($data);
            $this->salesDayBonus();
        }
        return false;
    }

    // 开始销售日分红
    public function salesDayBonus()
    {
        $user_bonus_model   = new user_bonusModel();
        $user_level_model   = new user_levelModel();
        $current_begin_date = $this->getCurrentBeginDate();    // 今天开始时间
        $bonus_begin_at     = $this->getCurrentMonthBeginDate();  // 当月开始时间
        $type_bonus         = $user_bonus_model::TYPE_SALES_DAY_BONUS; // 当前分红类型
        $cycle_type         = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        // 昨天开始时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        // 昨天结束时间
        $yesterday_end_at = $this->getYesterdayEndAt();
        // 最近更新时间小于今天开始时间
        $where['updated_at'] = ['LT', $current_begin_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取这些用户对应的等级

        // 根据分红用户id查询用户对应的等级，HI 值，销售（消费）额
        // 获取平台昨天的利润
        $yesterday_profit_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $yesterday_profit_where['cycle']      = $cycle_type;
        $yesterday_profit                     = $this->getPlatformProfit($yesterday_profit_where);
        // 如果没有利润，那就不分红
        if ($yesterday_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($yesterday_profit, 0.1, 2);

        // 20%   所有人平分分红
        $common_total_money = bcmul($current_bonus_money, 0.2, 2); // 所有人平分的利润的20%
        $common_money       = bcdiv($common_total_money, count($user_id_arr), 2); // 所有人平分的利润的20%


        // 20% 等级分红
        $level_total_money = bcmul($current_bonus_money, 0.2, 2);


        // 获取会员hi值可获得的总分红 20%
        $hi_money = bcmul($current_bonus_money, 0.2, 2); // 所有人平分的利润的20%


        // 获取会员hi值总和
        $user_hi_value_model = new user_hi_valueModel();
        $total_hi_value_info = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->find();
        $total_hi_value      = $total_hi_value_info['hi_value'];
        // 获取会员日消费/销售额可获得的总分红 40%
        $consumption_and_sale_money = bcmul($current_bonus_money, 0.4, 2);


        // 获取会员日消费/销售额总和
        $user_consumption_sale_log_day_model       = new user_consumption_sale_log_dayModel();
        $yesterday_consumption_and_sale_money_info = $user_consumption_sale_log_day_model->where(['user_id' => ['in', $user_id_arr]])->field('sum(total_money) as yesterday_total_money')->find();
        $yesterday_consumption_and_sale_money      = $yesterday_consumption_and_sale_money_info['yesterday_total_money'];

        $user_model = new memberModel();
        // 获取用户对应的等级，以user_id作为键
        $user_info_arr          = $user_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,level_id,member_name')->select();
        $user_level_info_arr    = array_combine(array_column($user_info_arr, 'member_id'), array_column($user_info_arr, 'level_id'));
        $user_username_info_arr = array_combine(array_column($user_info_arr, 'member_id'), array_column($user_info_arr, 'member_name'));

        // 统计各等级的会员总数
        $total_user_count_for_level = array_count_values($user_level_info_arr);
        // 获取各等级的人头数
        $begin_level_id          = $user_level_model::LEVEL_ONE;
        $head_count_for_position = $user_level_model->getUserHeadcountForLevel($total_user_count_for_level, $begin_level_id);
        // 获取各等级分别可以拿到的平台上月全球销售分红利润
        $each_money_for_level = $user_level_model->getEachMoneyForPosition($head_count_for_position, $level_total_money);


        // 获取用户的昨天的消费/销售总额度，以user_id作为键
        $user_consumption_sale_info_day_arr    = $user_consumption_sale_log_day_model->where(['user_id' => ['in', $user_id_arr]])->field('user_id,sum(total_money) as total_user_consumption_sale_day_money')->group('user_id')->select();
        $total_user_consumption_sale_money_arr = array_combine(array_column($user_consumption_sale_info_day_arr, 'user_id'), $user_consumption_sale_info_day_arr);
        // 获取用户对应的hi值，以user_id作为键
        $total_user_hi_value_info_arr          = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("user_id,sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->group('user_id')->select();
        $total_user_hi_value_info_arr_for_user = array_combine(array_column($total_user_hi_value_info_arr, 'user_id'), $total_user_hi_value_info_arr);
        // 组合用户信息
        $new_user_info = [];
        foreach ($user_id_arr as $user_id) {
            $new_user_info[$user_id]['user_id']                = $user_id;
            $new_user_info[$user_id]['level_id']               = $user_level_info_arr[$user_id];
            $new_user_info[$user_id]['member_name']            = $user_username_info_arr[$user_id];
            $new_user_info[$user_id]['consumption_sale_money'] = isset($total_user_consumption_sale_money_arr[$user_id]) ? $total_user_consumption_sale_money_arr[$user_id]['total_user_consumption_sale_day_money'] : 0;
            $new_user_info[$user_id]['hi_value']               = isset($total_user_hi_value_info_arr_for_user[$user_id]) ? $total_user_hi_value_info_arr_for_user[$user_id]['hi_value'] : 0;
        }
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        $add_money_arr        = [];
        // 分红
        foreach ($new_user_info as $value) {
            $remark_arr[] = '当前会员ID：' . $value['user_id'];
            $remark_arr[] = '当前会员名称：' . $value['member_name'];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '分红时间：' . $now_date;
            $remark_arr[] = '平台昨天的利润：' . $yesterday_profit;
            $remark_arr[] = '当前分红类型可分配的利润 10%：' . $current_bonus_money;
            $remark_arr[] = '所有人平分的利润的20%：' . $common_total_money;
            $remark_arr[] = '所有人获得的平分利润金额：' . $common_money;
            $remark_arr[] = '等级分红总金额 20%：' . $level_total_money;
            $remark_arr[] = '会员日消费/销售额可获得的总分红 40%：' . $consumption_and_sale_money;
            $remark_arr[] = '会员日消费/销售额总和：' . $yesterday_consumption_and_sale_money;
            $remark_arr[] = '用户对应的等级：' . array_to_key_value_str($user_level_info_arr, '、');
            $remark_arr[] = '各等级的会员总数：' . array_to_key_value_str($total_user_count_for_level, '、');
            $remark_arr[] = '各等级的人头数：' . array_to_key_value_str($head_count_for_position, '、');
            $remark_arr[] = '各等级分别可以拿到的平台上月全球销售分红利润：' . array_to_key_value_str($each_money_for_level, '、');
            $remark_arr[] = '当前用户等级：' . $value['level_id'];


            // 用户当前的等级
            $this_user_level_id = $value['level_id'];
            // 当前用户可以叠加的等级
            $this_user_superposition_level_arr = $user_level_model->getPreviousArr($this_user_level_id, $begin_level_id);
            /*****************************************************/
            $remark_arr[] = '当前用户可以叠加的等级：' . implode('、', $this_user_superposition_level_arr);
            /*****************************************************/
            // 当前用户可获得的等级分红
            $level_money = array_sum(array_intersect_key($each_money_for_level, $this_user_superposition_level_arr));
            /*****************************************************/
            $remark_arr[] = '当前用户可获得的等级分红：' . $level_money;
            /*****************************************************/
            // 用户消费/销售额度奖金(销售/消费额度 除以 总额度 乘以分红)
            $consumption_sale_money = bcdiv(bcmul($value['consumption_sale_money'], $consumption_and_sale_money), $yesterday_consumption_and_sale_money, 2);
            /*****************************************************/
            $remark_arr[] = '当前用户消费/销售额度：' . $value['consumption_sale_money'];
            $remark_arr[] = '当前用户消费/销售额度奖金(销售/消费额度 除以 总额度 乘以分红)：' . $consumption_sale_money;
            /*****************************************************/
            // 用户hi获得的分红(用户hi值 除以 总hi值 乘以分红)
            $hi_value_bonus = 0;
            if ($value['hi_value'] > 0 && $hi_money > 0 && $total_hi_value > 0) {
                $hi_value_bonus = bcdiv(bcmul($value['hi_value'], $hi_money), $total_hi_value, 2);
            }
            /*****************************************************/
            $remark_arr[] = '会员 HI 值可获得的总分红 20%：' . $hi_money;
            $remark_arr[] = '会员 HI 值总和：' . $total_hi_value;
            $remark_arr[] = '当前用户HI 值：' . $value['hi_value'];
            $remark_arr[] = '当前用户 HI 值获得的分红：' . $hi_value_bonus;
            /*****************************************************/
            $user_bonus_money = bcadd(bcadd(bcadd($level_money, $consumption_sale_money, 2), $hi_value_bonus, 2), $common_money, 2);
            $remark_arr[]     = '当前用户当前分红类型总共获得的分红：' . $user_bonus_money;

            $system_bonus_log_arr[$value['user_id']]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$value['user_id']]['to_user_id']          = $value['user_id'];
            $system_bonus_log_arr[$value['user_id']]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$value['user_id']]['type'] = 2;
            if ($user_bonus_money > 0) {
                $add_money_arr[$value['user_id']] = $user_bonus_money;
            }
            $system_bonus_log_arr[$value['user_id']]['created_at'] = $now_date;
            $system_bonus_log_arr[$value['user_id']]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }

            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            // 扣除金额
            // 扣除的条件（如：扣昨天，扣上周，扣上个月）当前分的是哪个时间段的利润
            // 扣除类型（1,7,30）
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    public function getThisLevelUserArr($new_user_info, $level = 0)
    {
        $new_arr = [];
        foreach ($new_user_info as $key => $value) {
            $new_arr[$value['level']][] = $value;
        }
        return $new_arr[$level];
    }

    public function returnUserLevelTotalBonus($level, $level_total_money)
    {
        switch ($level) {
            case 1:
                $level_money = 0;
                break;
            case 2:
                $level_money = bcmul($level_total_money, 0.2);      // 贵宾会员等级获得的总分红
                break;
            case 3:
                $level_money = bcmul($level_total_money, 0.2);    // 银尊会员等级获得的总分红
                break;
            case 4:
                $level_money = bcmul($level_total_money, 0.2);     // 金尊会员等级获得的总分红
                break;
            case 5:
                $level_money = bcmul($level_total_money, 0.2);     // 至尊会员等级获得的总分红
                break;
            case 6:
                $level_money = bcmul($level_total_money, 0.2);      // 黑钻会员等级获得的总分红
                break;

        }
        return $level_money;
    }

    public function getUserArray($user_arr)
    {
        // 获取人民币对应的美金额度
        $quota_for_default_vip_for_c       = 1000;   // 免费VIP用户上个月“个人消费”累计
        $quota_for_default_vip_for_c_and_s = 3000;   // 免费VIP用户上个月“个人消费”加个人微商销售额总计
        $quota_for_gb_vip_for_c            = 350;   // 银尊VIP或以上会员级别消费额度
        $quota_for_gb_vip_for_for_c_and_s  = 1000;   // 银尊VIP或以上会员级别的且“个人消费”加个人微商销售额总计额度

        $user_money_data = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][$consumption_user['type']][] = $consumption_user['total_money'];
        }

        // 以用户id为键，level_id为值
        $user_data         = [];
        $user_level_for_id = array_combine(array_column($user_arr, 'user_id'), array_column($user_arr, 'user_level_id'));
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                $this_user_quota_for_c = 0;
                if (isset($money_for_type[1])) {
                    $this_user_quota_for_c = array_sum($money_for_type[1]);
                }
                $this_user_quota_for_c_and_s = 0;
                if (isset($money_for_type[2])) {
                    $this_user_quota_for_c_and_s = array_sum($money_for_type[2]);
                }
                if ($user_level_for_id[$user_id] == 1) {
                    if ($this_user_quota_for_c >= $quota_for_default_vip_for_c || bcadd($this_user_quota_for_c_and_s, $this_user_quota_for_c) >= $quota_for_default_vip_for_c_and_s) {
                        $user_data[] = $user_id;
                        continue;
                    }
                } else {
                    if ($this_user_quota_for_c >= $quota_for_gb_vip_for_c || bcadd($this_user_quota_for_c_and_s, $this_user_quota_for_c) >= $quota_for_gb_vip_for_for_c_and_s) {
                        $user_data[] = $user_id;
                        continue;
                    }
                }

            }
        }
        return $user_data;
    }

    // 统计销售明星日分红
    public function statisticsSellingStarDayBonus()
    {
        // ① 上个月推荐一个银尊会员或以上级别的会员用户成功升级。（即，推荐会员的消费额≧2000元）
        // ② 上个月会员用户的总消费额加上个人微商中的消费订单（销售额）总计达到2500元或以上。
        // @TODO 会员升级的时候，如果升级到银尊会员以上，那么检查该会员的邀请人，如果有邀请人，那么将邀请人加到下个月的销售明星日分红名单中
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（开始时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_SELLING_STAR_DAY_BONUS;// 销售明星日分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_DAY;// 每天一次
        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['created_at' => ['between', [$current_month_begin_date, $current_month_end_date]], 'type' => $type_bonus])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->sellingStarDayBonus();
            return false;
        }

        // 获取上个月所有$begin_level等级以上有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_level_id']              = ['in', [1, 2, 3, 4, 5, 6]];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();

        $user_money_data = [];
        if (!empty($user_arr)) {
            foreach ($user_arr as $consumption_user_key => $consumption_user) {
                // 当前会员的所有消费/销售额
                $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
            }
        }

        // 满足分红条件的会员
        $user_id_arr = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $user_total_money) {
                // ② 上个月会员用户的总消费额加上个人微商中的消费订单（销售额）总计达到2500元或以上。2018/04/08 修改为总计达到2000元或以上
                if (array_sum($user_total_money) >= 2000) {
                    $user_id_arr[] = $user_id;
                    continue;
                }
            }
        }
        if (empty($user_id_arr)) {
            return false;
        }

        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        $created_at     = $this->getCurrentDate();
        $data           = [];
        foreach ($user_id_arr as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $created_at;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll($data);
            $this->sellingStarDayBonus();
        }
        return false;
    }

    // 开始销售明星日分红
    public function sellingStarDayBonus()
    {
        $current_begin_date = $this->getCurrentBeginDate();    // 今天开始时间
        $bonus_begin_at     = $this->getCurrentMonthBeginDate();  // 当月开始时间
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $user_bonus_model                    = new user_bonusModel();
        // 当前分红类型
        $type_bonus = $user_bonus_model::TYPE_SELLING_STAR_DAY_BONUS;

        // 最近更新时间小于今天开始时间
        $where['updated_at'] = ['LT', $current_begin_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }

        // 计算参加该分红所有合格会员用户上个月的总销售额
        $field                                   = 'user_id,type,user_level_id,total_money';
        $user_arr_where['created_at']            = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr_where['type']                  = ['in', [1, 2]];
        $total_consumption_sale_where['user_id'] = ['in', $user_id_arr];
        $user_arr                                = $user_consumption_sale_log_day_model->where($user_arr_where)->field($field)->select();

        $user_money_data = [];
        if (!empty($user_arr)) {
            foreach ($user_arr as $consumption_user_key => $consumption_user) {
                // 当前会员的所有消费/销售额
                $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
                continue;
            }
        }

        // 满足分红条件的会员以及他们的消费额
        $total_user_money_for_user_id = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $user_total_money) {
                $total_user_money_for_user_id[$user_id] = array_sum($user_total_money);
                continue;
            }
        }
        // 获取总消费额
        $total_user_money = array_sum($total_user_money_for_user_id);

        // 昨天开始时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        // 昨天结束时间
        $yesterday_end_at = $this->getYesterdayEndAt();
        // 获取平台昨天的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        $yesterday_profit_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $yesterday_profit_where['cycle']      = $cycle_type;
        $yesterday_profit                     = $this->getPlatformProfit($yesterday_profit_where);
        if ($yesterday_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($yesterday_profit, 0.1, 2);
        // 计算每个会员可获得的分红
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];

        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));

        foreach ($total_user_money_for_user_id as $user_id => $this_user_total_money) {
            $remark_arr[] = '当前会员 ID：' . $user_id;
            $remark_arr[] = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '平台昨天的利润：' . $yesterday_profit;
            $remark_arr[] = '当前分红类型可分配的利润：' . $current_bonus_money;
            $remark_arr[] = '总消费额：' . $total_user_money;
            $remark_arr[] = '当前会员消费额：' . $this_user_total_money;
            $remark_arr[] = '当前会员可获得的分红：' . bcdiv(bcmul($this_user_total_money, $current_bonus_money, 2), $total_user_money, 2);

            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $add_money_arr[$user_id]                      = bcdiv(bcmul($this_user_total_money, $current_bonus_money, 2), $total_user_money, 2);
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        // 计算已经分出去的分红
        $dividends_paid = array_sum($add_money_arr);
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 统计共享日分红-新注册会员（按天统计） 5%
    public function statisticalShareDayBonusForNew($member_id)
    {
        // ① 新会员：当月个人消费累计满350元及以上（或个人消费加个人微商城销售总额累计满1000元及以上）且会员等级是银尊VIP或以上。满足条件的第二天即可获此奖项;下月则按老会员计。
        // @TODO 新会员的分红为每次消费后统计该用户的消费额，如果满足条件，就直接加入分红列表；老会员的分红才需要统计
        // ② 老会员：上月个人消费累计满350元及以上（或个人消费和个人微商城销售总额累计满1000元及以上）且会员等级是银尊VIP或以上。满足条件的于本月开始获得此奖项。
        // 检查当前用户是否已经加入当前分红列表(只要有拿过共享日分红的都不算新注册会员的分红了)
        $user_bonus_model    = new user_bonusModel();
        $type_bonus          = $user_bonus_model::TYPE_SHARE_DAY_BONUS;// 共享日分红
        $bonus_begin_at      = $this->getTomorrowBeginDate();    // 明天开始时间
        $bonus_end_at        = $this->getCurrentMonthEndDate();    // 本月结束时间
        $check_already_exist = $user_bonus_model->where(['user_id' => $member_id, 'type' => $type_bonus])->find();
        if ($check_already_exist) {
            return false;
        }
        // 检查当前会员的会员等级是否为银尊VIP以上
        $user_model = new memberModel();
        $user_info  = $user_model->where(['member_id' => $member_id])->field('member_id,level_id,member_name')->find();
        if (!in_array($user_info['level_id'], [1, 2, 3, 4, 5, 6])) {
            return false;
        }
        // 获取当前月的开始时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        // 获取当前用户本月消费或个人微商销售总额
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$current_month_begin_date, $current_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_id']                    = $member_id;
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();

        $user_money_data = [];
        if (!empty($user_arr)) {
            foreach ($user_arr as $consumption_user_key => $consumption_user) {
                // 当前会员的所有消费/销售额
                $user_money_data[$consumption_user['type']][] = $consumption_user['total_money'];
            }
        }

        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_DAY; // 每天一次
        // 检查会员是否满足分红条件
        $data = [];
        if (!empty($user_money_data)) {
            // 当月个人消费累计满350元及以上（或个人消费加个人微商城销售总额累计满1000元及以上）将用户加入共享日分红列表中
            if (array_sum($user_money_data[1]) > 350 || bcadd(array_sum($user_money_data[1]), array_sum($user_money_data[2])) > 1000) {
                $data['user_id']    = $member_id;
                $data['type']       = $type_bonus;
                $data['begin_at']   = $bonus_begin_at;
                $data['end_at']     = $bonus_end_at;
                $data['frequency']  = $frequency_for_day;
                $data['created_at'] = $current_date;
            }
        }
        if (!empty($data)) {
            $user_bonus_model->insert($data);
            return true;
        }
        return false;
    }

    // 统计共享日分红（按月统计） 5%
    public function statisticalShareDayBonus()
    {
        // 获取当前月开始时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_SHARE_DAY_BONUS;// 共享日分红
        // 检查是不是已经统计过了，如果统计过了，那么直接进入分红(统计时间大于当前月开始时间，小于当前时间，分红开始时间等于本月开始时间（不等于开始时间的是新注册会员的分红）)
        $check_where['created_at'] = ['between', [$current_month_begin_date, $current_date]];
        $check_where['type']       = $type_bonus;
        $check_where['begin_at']   = $current_month_begin_date;
        $check_has_statistics      = $user_bonus_model->where($check_where)->count();
        if ($check_has_statistics > 0) {
            $this->shareDayBonus();
            return false;
        }

        // 获取上个月所有$begin_level等级以上有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_level_id']              = ['in', [2, 3, 4, 5, 6]];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();
        $user_money_data                     = [];
        if (!empty($user_arr)) {
            foreach ($user_arr as $consumption_user_key => $consumption_user) {
                // 当前会员的所有消费/销售额
                $user_money_data[$consumption_user['user_id']][$consumption_user['type']][] = $consumption_user['total_money'];
                continue;
            }
        }
        // 满足分红条件的会员以及他们的消费额
        $user_data = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                $this_user_quota_for_c = 0;
                if (isset($money_for_type[1])) {
                    $this_user_quota_for_c = array_sum($money_for_type[1]);
                }
                $this_user_quota_for_c_and_s = 0;
                if (isset($money_for_type[2])) {
                    $this_user_quota_for_c_and_s = array_sum($money_for_type[2]);
                }
                if ($this_user_quota_for_c >= 350 || bcadd($this_user_quota_for_c_and_s, $this_user_quota_for_c) >= 1000) {
                    $user_data[] = $user_id;
                    continue;
                }
            }
        }
        if (empty($user_data)) {
            return false;
        }
        $data              = [];
        $bonus_begin_at    = $this->getCurrentMonthBeginDate();
        $bonus_end_at      = $this->getCurrentMonthEndDate();
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_DAY;              // 每天一次
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll($data);
            // 开始分红
            $this->shareDayBonus();
        }
        return false;
    }

    // 共享日分红
    public function shareDayBonus()
    {
        $is_first_month = $this->getStages(0);
        if (empty($is_first_month)) return false;

        $current_begin_date = $this->getCurrentBeginDate();    // 今天开始时间
        $bonus_begin_at     = $this->getCurrentMonthBeginDate();  // 当月开始时间

        $user_bonus_model = new user_bonusModel();
        // 当前分红类型
        $type_bonus = $user_bonus_model::TYPE_SHARE_DAY_BONUS;

        // 最近更新时间小于今天开始时间
        $where['updated_at'] = ['LT', $current_begin_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];

        $where['type'] = $type_bonus;
        $user_id_lists = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 昨天开始时间
        $yesterday_begin_at = $this->getYesterdayBeginAt();
        // 昨天结束时间
        $yesterday_end_at = $this->getYesterdayEndAt();
        // 获取平台昨天的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_DAY;// 分红模式
        $yesterday_profit_where['created_at'] = ['between', [$yesterday_begin_at, $yesterday_end_at]];
        $yesterday_profit_where['cycle']      = $cycle_type;
        $yesterday_profit                     = $this->getPlatformProfit($yesterday_profit_where);
        if ($yesterday_profit == 0) {
            return false;
        }

        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($yesterday_profit, 0.05, 2);

        // 平均分配的共产共享
        $money_one       = bcdiv(bcmul($current_bonus_money, 0.4, 2), count($user_id_arr), 2);
        $total_money_two = bcmul($current_bonus_money, 0.6, 2);   // 平台昨天销售分红利润×3%
        // 获取每个用户垂直阵列下面的点位人数
        // 以用户id最小的一个作为起始id，获取该id后面的个数
        $member_model    = new memberModel();
        $all_user_id_arr = $member_model->getAllUserId();
        // 分别获取用户id在所有用户中所在的位置

        // 获取这些会员的职级
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));

        $new_user_info = [];
        foreach ($user_id_arr as $user_id) {
            $user_location                            = array_keys($all_user_id_arr, $user_id); // 当前用户在所有用户中所处位置
            $later_count                              = bcsub(count(array_slice($all_user_id_arr, $user_location[0])), 1);  // 该用户之后注册加入的所有新会员用户
            $user_point                               = intval(floor(bcdiv($later_count, 100)));   // 用户垂直阵列下面的点位人数
            $new_user_info[$user_id]['user_id']       = $user_id;
            $new_user_info[$user_id]['user_location'] = $user_location[0];
            $new_user_info[$user_id]['later_count']   = $later_count;
            $new_user_info[$user_id]['user_point']    = $user_point;
            $new_user_info[$user_id]['member_name']   = $user_member_name_arr[$user_id];
        }
        // 获取所有参加该分红用户阵列下面人数总和
        $dividend_array_count = array_sum(array_column($new_user_info, 'user_point'));
        $add_money_arr        = [];
        $system_bonus_log_arr = [];
        $now_date             = date('Y-m-d H:i:s');

        foreach ($new_user_info as $user) {
            $this_user_one_money = $money_one;
            $this_user_two_money = 0;
            if ($user['user_point'] > 0) {
                $this_user_two_money = bcdiv(bcmul($user['user_point'], $total_money_two, 2), $dividend_array_count, 2);
            }
            $remark_arr[] = '当前会员ID：' . $user['user_id'];
            $remark_arr[] = '当前会员名称：' . $user['member_name'];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '平台昨天的利润：' . $yesterday_profit;
            $remark_arr[] = '当前分红类型可分配的利润：' . $current_bonus_money;
            $remark_arr[] = '平台当天销售分红利润×2%：' . bcmul($current_bonus_money, 0.4, 2);
            $remark_arr[] = '满足该分红获取条件的所有合格人数：' . count($user_id_arr);
            $remark_arr[] = '平均分配金额：' . $money_one;
            $remark_arr[] = '用户垂直阵列下面的点位人数：' . $user['user_point'];
            $remark_arr[] = '所有参加该分红用户阵列下面人数总和：' . $dividend_array_count;
            $remark_arr[] = '平台当天销售分红利润×3%：' . $total_money_two;

            $remark_arr[]                                                  = '点位分配金额：' . $this_user_two_money;
            $remark_arr[]                                                  = '总金额：' . bcadd($this_user_one_money, $this_user_two_money, 2);
            $system_bonus_log_arr[$user['user_id']]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user['user_id']]['to_user_id']          = $user['user_id'];
            $system_bonus_log_arr[$user['user_id']]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user['user_id']]['type']       = 2;
            $add_money_arr[$user['user_id']]                      = bcadd($this_user_one_money, $this_user_two_money, 2);
            $system_bonus_log_arr[$user['user_id']]['created_at'] = $now_date;
            $system_bonus_log_arr[$user['user_id']]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 统计中层管理周分红
    public function statisticsMiddleManagementBonusWeekly()
    {
        // 上个月个人消费满1000元及以上（或个人消费加上个人微商销售达1500元及以上）且职级是市场主任（MC）或以上
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY;        // 中层管理周分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_WEEKLY;              // 每周分一次
        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->middleManagementBonusWeekly();
            return false;
        }
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 获取职级是市场主任（MC）或以上的用户
        $member_model                        = new memberModel();
        $user_lists_for_position             = $member_model->where(['positions_id' => ['in', [3, 4, 5, 6, 7]]])->field('member_id,positions_id')->select();
        $user_lists_for_position_for_user_id = array_column($user_lists_for_position, 'member_id');
        if (empty($user_lists_for_position_for_user_id)) {
            return false;
        }
        // 获取上个月所有满足条件的有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_id']                    = ['in', $user_lists_for_position_for_user_id];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_money_data = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][$consumption_user['type']][] = $consumption_user['total_money'];
        }
        // 满足分红条件的会员以及他们的消费额
        $user_data = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                $this_user_quota_for_c = 0;
                if (isset($money_for_type[1])) {
                    $this_user_quota_for_c = array_sum($money_for_type[1]);
                }
                $this_user_quota_for_c_and_s = 0;
                if (isset($money_for_type[2])) {
                    $this_user_quota_for_c_and_s = array_sum($money_for_type[2]);
                }
                if ($this_user_quota_for_c >= 1000 || bcadd($this_user_quota_for_c_and_s, $this_user_quota_for_c) >= 1500) {
                    $user_data[] = $user_id;
                    continue;
                }
            }
        }
        if (empty($user_data)) {
            return false;
        }
        // 上个月个人消费满1000元及以上（或个人消费加上个人微商销售达1500元及以上）且职级是市场主任（MC）或以上
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;
        }

        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->middleManagementBonusWeekly();
        }
        return false;
    }

    // 中层管理分红
    public function middleManagementBonusWeekly()
    {
        // 本周开始时间
        $current_weekly_begin_date = $this->getCurrentWeeklyBeginDate();
        // 本周结束时间
        $current_weekly_end_date = $this->getCurrentWeeklyEndDate();
        // 当月开始时间
        $bonus_begin_at = $this->getCurrentMonthBeginDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY;        // 当前分红类型
        // 最近更新时间小于本周开始时间
        $where['updated_at'] = ['LT', $current_weekly_begin_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }


        // 上周开始时间
        $last_week_begin_at = $this->getLastWeeklyBeginDate();
        // 上周结束时间
        $last_week_end_at = $this->getLastWeeklyEndDate();

        // 获取平台上周的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_WEEKLY;// 分红模式
        $last_week_profit_where['created_at'] = ['between', [$last_week_begin_at, $last_week_end_at]];
        $last_week_profit_where['cycle']      = $cycle_type;
        $last_week_profit                     = $this->getPlatformProfit($last_week_profit_where);
        if ($last_week_profit == 0) {
            return false;
        }

        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($last_week_profit, 0.1, 2);
        // 分别计算每种模式可以分配的金额
        $money_one   = bcmul($current_bonus_money, 0.2, 2);         // （平台上周销售分红利润 × 2%）
        $money_two   = bcmul($current_bonus_money, 0.2, 2);         // 职务等级（职级）占比额：2%。职级高的可重复叠加复算
        $money_three = bcmul($current_bonus_money, 0.2, 2);       // HI 值占比额：2%。
        $money_four  = bcmul($current_bonus_money, 0.4, 2);        // 销售额占比额：4%。


        //$user_bonus_model;
        // 获取用户的职位级别信息
        $member_model            = new memberModel();
        $user_lists_for_position = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,positions_id,member_name')->select();
        // 以member_id作为数组的键
        $user_position_for_user_id    = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'positions_id'));
        $user_member_name_for_user_id = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'member_name'));

        // 参与分红的用户数
        $user_count = count($user_id_arr);

        // 获取用户对应的hi值，以user_id作为键
        $user_hi_value_model                   = new user_hi_valueModel();
        $total_user_hi_value_info_arr          = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("user_id,sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->group('user_id')->select();
        $total_user_hi_value_info_arr_for_user = array_combine(array_column($total_user_hi_value_info_arr, 'user_id'), $total_user_hi_value_info_arr);
        // 总hi值
        $total_hi_value = array_sum(array_column($total_user_hi_value_info_arr_for_user, 'hi_value'));

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 获取上个月所有满足条件的有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $user_arr_where['created_at']        = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr_where['type']              = ['in', [1, 2]];
        $user_arr_where['user_id']           = ['in', $user_id_arr];
        $user_arr                            = $user_consumption_sale_log_day_model->where($user_arr_where)->field($field)->select();

        if (empty($user_arr)) {
            return false;
        }
        $total_consumption_and_sale_money_arr = [];
        $user_money_data                      = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
            $total_consumption_and_sale_money_arr[]          = $consumption_user['total_money'];
        }

        // 获取参加该分红会员的总销售额
        $last_month_consumption_and_sale_money = array_sum($total_consumption_and_sale_money_arr);

        // 统计各职位级别的总人数
        $position_count_user = array_count_values($user_position_for_user_id);
        // 获取销售主任的类型
        $position_model = new positionsModel();
        // 获取各职级的人头数
        $begin_position_id       = $position_model::POSITIONS_RM;
        $head_count_for_position = $position_model->getUserHeadcountForPositions($position_count_user, $begin_position_id);
        // 获取各等级分别可以拿到的平台上月全球销售分红利润
        $each_money_for_position = $position_model->getEachMoneyForPosition($head_count_for_position, $money_two);
        $now_date                = date('Y-m-d H:i:s');
        // 所有符合条件的会员都能拿到的钱
        $common_money         = bcdiv($money_one, $user_count, 2);
        $add_money_arr        = [];
        $system_bonus_log_arr = [];
        foreach ($user_id_arr as $user_id) {
            $this_member_name = $user_member_name_for_user_id[$user_id];
            $remark_arr[]     = '当前会员 ID：' . $user_id;
            $remark_arr[]     = '当前会员名称：' . $this_member_name;
            $remark_arr[]     = '当前分红类型：' . $type_bonus;
            $remark_arr[]     = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[]     = '分红时间：' . $now_date;
            $remark_arr[]     = '平台上周的利润：' . $last_week_profit;
            $remark_arr[]     = '当前分红类型可分配的利润 10%：' . $current_bonus_money;
            $remark_arr[]     = '平分利润占比额（2%）：' . $money_one;
            $remark_arr[]     = '职务等级（职级）占比额（2%）：' . $money_two;
            $remark_arr[]     = 'HI 值占比额（2%）：' . $money_three;
            $remark_arr[]     = '销售额占比额（4%）：' . $money_four;
            $remark_arr[]     = '各职位级别的总人数：' . array_to_key_value_str($position_count_user, '、');
            $remark_arr[]     = '1.所有符合条件的会员都能拿到的钱：' . $common_money;
            // 当前用户的hi值
            $this_user_hi_value = isset($total_user_hi_value_info_arr_for_user[$user_id]['hi_value']) ? $total_user_hi_value_info_arr_for_user[$user_id]['hi_value'] : 0;
            $remark_arr[]       = '参加该分红会员的总分红 HI 值：' . $total_hi_value;
            $remark_arr[]       = '当前用户的hi值：' . $this_user_hi_value;
            // 用户 HI 值可分到的利润
            $this_user_hi_money = 0;
            if ($this_user_hi_value > 0) {
                $this_user_hi_money = bcdiv(bcmul($this_user_hi_value, $money_three, 2), $total_hi_value, 2);
            }
            $remark_arr[] = '2.当前用户 HI 值可分到的利润：' . $this_user_hi_money;
            // 当前用户的职级
            $this_user_position = $user_position_for_user_id[$user_id];
            $remark_arr[]       = '当前用户的职级：' . $this_user_position;
            // 当前用户可以叠加的职级
            $this_user_superposition_position_arr = $position_model->getPreviousArr($this_user_position, $begin_position_id);
            $remark_arr[]                         = '各职级的人头数：' . array_to_key_value_str($head_count_for_position, '、');
            $remark_arr[]                         = '各职级分别可以拿到的平台上月全球销售分红利润：' . array_to_key_value_str($each_money_for_position, '、');
            $remark_arr[]                         = '当前用户可以叠加的职级：' . implode('、', $this_user_superposition_position_arr);
            // 当前用户该职级可分到的总利润
            $this_user_position_money = array_sum(array_intersect_key($each_money_for_position, $this_user_superposition_position_arr));
            $remark_arr[]             = '3.当前用户该职级可分到的总利润：' . $this_user_position_money;
            // 当前用户消费销售额
            $this_user_total_money = array_sum($user_money_data[$user_id]);
            $remark_arr[]          = '当前用户消费销售额：' . $this_user_total_money;
            $remark_arr[]          = '参加该分红会员的总销售额：' . $last_month_consumption_and_sale_money;
            // 用户消费/销售额度奖金(销售/消费额度 除以 总额度 乘以分红)
            $consumption_sale_money                                = bcdiv(bcmul($this_user_total_money, $money_four), $last_month_consumption_and_sale_money, 2);
            $remark_arr[]                                          = '4.当前用户消费/销售额度奖金：' . $consumption_sale_money;
            $remark_arr[]                                          = '5.当前用户当前分红总金额：' . bcadd(bcadd(bcadd($common_money, $this_user_hi_money, 2), $this_user_position_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $add_money_arr[$user_id]                      = bcadd(bcadd(bcadd($common_money, $this_user_hi_money, 2), $this_user_position_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 根据职别计算出分红的人头数（职别越高，拿的份数越多，占的人头数越高）
    public function getBonusHeadcountForPosition($user_position_for_user_id)
    {
        $position_model = new positionsModel();
        if (empty($user_position_for_user_id)) {
            return 0;
        }
        $new_arr = [];
        foreach ($user_position_for_user_id as $user_id => $position_id) {
            $new_arr[$user_id] = $position_model->getUserPositionCountForRSC($position_id);
        }
        $user_position_headcount = array_sum($new_arr);
        return $user_position_headcount;
    }

    // 根据职别计算出分红的人头数（职别越高，拿的份数越多，占的人头数越高）
    public function getBonusHeadcountForPositionForSSA($user_position_for_user_id)
    {
        $position_model = new positionsModel();
        if (empty($user_position_for_user_id)) {
            return 0;
        }
        $new_arr = [];
        foreach ($user_position_for_user_id as $user_id => $position_id) {
            $new_arr[$user_id] = $position_model->getUserPositionCountForSSA($position_id);
        }
        $user_position_headcount = array_sum($new_arr);
        return $user_position_headcount;
    }

    // 至尊消费月分红(每月15号统计，15号分红)
    public function statisticsBlackDiamondSalesBonus()
    {
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_BLACK_DIAMOND_SALES_BONUS;        // 黑钻销售月分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月分一次
        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->blackDiamondSalesBonus();
            return false;
        }

        // 上个月个人消费满1000元及以上（或个人消费加个人微商销售额达到2000元以上）
        // 等级为至尊VIP会员
        // 职级为资深主管或以上

        // 获取上个月所有有消费或个人微商有销售额的至尊VIP会员
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_level_id']              = 6;
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_arr_for_user_id = array_column($user_arr, 'user_id');
        // 获取职级是资深主管或以上的会员
        $member_model                 = new memberModel();
        $member_where['member_id']    = ['in', array_column($user_arr, 'user_id')];
        $member_where['positions_id'] = ['in', [2, 3, 4, 5, 6, 7]];
        $member_where['level_id']     = 6;
        $member_list                  = $member_model->where($member_where)->field('member_id')->select();
        if (empty($member_list)) {
            return false;
        }
        $member_list_for_user_id = array_column($member_list, 'member_id');
        // 获取消费记录中满足条件的信息（取销售消费满足条件以及等级和职级满足条件的两者的并集）
        $user_arr_intersect = array_intersect_key($member_list_for_user_id, $user_arr_for_user_id);
        $user_money_data    = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][$consumption_user['type']][] = $consumption_user['total_money'];
        }

        // 满足分红条件的会员以及他们的消费额
        $user_data = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                // 如果当前用户在$user_arr_intersect数组中才算满足分红条件
                if (!in_array($user_id, $user_arr_intersect)) {
                    continue;
                }
                $this_user_quota_for_c = 0;
                if (isset($money_for_type[1])) {
                    $this_user_quota_for_c = array_sum($money_for_type[1]);
                }
                $this_user_quota_for_c_and_s = 0;
                if (isset($money_for_type[2])) {
                    $this_user_quota_for_c_and_s = array_sum($money_for_type[2]);
                }
                if ($this_user_quota_for_c >= 1000 || bcadd($this_user_quota_for_c_and_s, $this_user_quota_for_c) >= 2000) {
                    $user_data[] = $user_id;
                    continue;
                }
                continue;
            }
        }
        if (empty($user_data)) {
            return false;
        }

        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            // 上个月个人消费满 150 美金及以上（或个人消费加上个人微商销售达 300 美金及以上）
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->blackDiamondSalesBonus();
        }
        return false;
    }

    // 检查是否可以分红
    public function checkIsDividendDay($dividend_day)
    {
        // 获取当前时间
        $today_date = date('Y-m-d H:i:s');
        // 如果当前时间小于分红日，那么返回true,为不可分红
        $new_dividend_day = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($dividend_day))));
        if ($today_date < $new_dividend_day) {
            return true;
        }
        return false;
    }

    public function blackDiamondSalesBonus()
    {
        // 当月15号分红
        $dividend_day = $this->getCurrentMiddleMonthDate();
        if ($this->checkIsDividendDay($dividend_day)) {
            //return false;
        }

        // 当月开始时间
        $bonus_begin_at = $this->getCurrentMonthBeginDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();

        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_BLACK_DIAMOND_SALES_BONUS;// 当前分红类型

        // 最近更新时间小于本月开始时间
        $where['updated_at'] = ['LT', $bonus_begin_at];

        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();

        // 本月需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }

        // 获取平台上月的利润
        $cycle_type                            = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式
        $last_month_profit_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $last_month_profit_where['cycle']      = $cycle_type;
        $last_month_profit                     = $this->getPlatformProfit($last_month_profit_where);
        if ($last_month_profit == 0) {
            return false;
        }

        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($last_month_profit, 0.1, 2);

        // 分别计算每种模式可以分配的金额
        $money_one  = bcmul($current_bonus_money, 0.2, 2);         // （平台上月销售分红利润 × 2%）
        $money_two  = $last_month_profit;         // 职务等级（职级）占比额：3%。职级高的可重复叠加复算(由于提前算好不能整除，所以直接用所有利润来算)
        $money_four = bcmul($current_bonus_money, 0.5, 2);        // 销售额占比额：5%。

        // 获取用户的职位级别信息
        $member_model            = new memberModel();
        $user_lists_for_position = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,positions_id,member_name')->select();

        // 以member_id作为数组的键
        $user_position_for_user_id = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'positions_id'));
        $user_member_name_user_id  = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'member_name'));

        // 参与分红的用户数
        $user_count = count($user_id_arr);

        // 获取上个月所有满足条件的有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $user_arr_where['created_at']        = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr_where['type']              = ['in', [1, 2]];
        $user_arr_where['user_id']           = ['in', $user_id_arr];
        $user_arr                            = $user_consumption_sale_log_day_model->where($user_arr_where)->field($field)->select();
        if (empty($user_arr)) {
            return false;
        }

        $total_consumption_and_sale_money_arr = [];
        $user_money_data                      = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
            $total_consumption_and_sale_money_arr[]          = $consumption_user['total_money'];
        }

        // 获取参加该分红会员的总销售额
        $last_month_consumption_and_sale_money = array_sum($total_consumption_and_sale_money_arr);

        // 统计各职位级别的总人数
        $position_count_user = array_count_values($user_position_for_user_id);

        // 获取资深主管的类型
        $position_model          = new positionsModel();
        $begin_position_id       = $position_model::POSITIONS_SNA;
        $head_count_for_position = $position_model->getUserHeadcountForPositions($position_count_user, $begin_position_id);

        // 获取各等级分别可以拿到的平台上月全球销售分红利润
        $each_money_for_position = $position_model->getEachMoneyForPosition($head_count_for_position, $money_two, 'black_diamond_sales_bonus');
        $now_date                = date('Y-m-d H:i:s');

        // 所有符合条件的会员都能拿到的钱
        $common_money         = bcdiv($money_one, $user_count, 2);
        $add_money_arr        = [];
        $system_bonus_log_arr = [];
        foreach ($user_id_arr as $user_id) {
            $this_member_name = $user_member_name_user_id[$user_id];
            $remark_arr[]     = '当前会员ID：' . $user_id;
            $remark_arr[]     = '当前会员名称：' . $this_member_name;
            $remark_arr[]     = '当前分红类型：' . $type_bonus;
            $remark_arr[]     = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[]     = '分红时间：' . $now_date;
            $remark_arr[]     = '平台上月的利润：' . $last_month_profit;
            $remark_arr[]     = '当前分红类型可分配的利润 10%：' . $current_bonus_money;
            $remark_arr[]     = '平分利润占比额（2%）：' . $money_one;
            $remark_arr[]     = '职务等级（职级）占比额（3%）：' . bcmul($current_bonus_money, 0.3, 2);;
            $remark_arr[] = '销售额占比额（5%）：' . $money_four;
            $remark_arr[] = '各职位级别的总人数：' . array_to_key_value_str($position_count_user, '、');
            $remark_arr[] = '1.所有符合条件的会员都能拿到的钱：' . $common_money;

            // 当前用户的职级
            $this_user_position = $user_position_for_user_id[$user_id];
            $remark_arr[]       = '当前用户的职级：' . $this_user_position;

            // 当前用户可以叠加的职级
            $this_user_superposition_position_arr = $position_model->getPreviousArr($this_user_position, $begin_position_id);
            $remark_arr[]                         = '各职级的人头数：' . array_to_key_value_str($head_count_for_position, '、');
            $remark_arr[]                         = '各职级分别可以拿到的平台上月全球销售分红利润：' . array_to_key_value_str($each_money_for_position, '、');
            $remark_arr[]                         = '当前用户可以叠加的职级：' . implode('、', $this_user_superposition_position_arr);

            // 当前用户该职级可分到的总利润
            $this_user_position_money = array_sum(array_intersect_key($each_money_for_position, $this_user_superposition_position_arr));
            $remark_arr[]             = '3.当前用户该职级可分到的总利润：' . $this_user_position_money;

            // 当前用户消费销售额
            $this_user_total_money = array_sum($user_money_data[$user_id]);
            $remark_arr[]          = '当前用户消费销售额：' . $this_user_total_money;
            $remark_arr[]          = '参加该分红会员的总销售额：' . $last_month_consumption_and_sale_money;

            // 用户消费/销售额度奖金(销售/消费额度 除以 总额度 乘以分红)
            $consumption_sale_money                                = bcdiv(bcmul($this_user_total_money, $money_four, 4), $last_month_consumption_and_sale_money, 2);
            $remark_arr[]                                          = '4.当前用户消费/销售额度奖金：' . $consumption_sale_money;
            $remark_arr[]                                          = '5.当前用户当前分红总金额：' . bcadd(bcadd($common_money, $this_user_position_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $add_money_arr[$user_id]                      = bcadd(bcadd($common_money, $this_user_position_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }

            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);

            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 根据职级获取该职级之前所有符合条件的职级
    public function getPreviousPositionArr($position_id, $begin_position_id)
    {
        $position_model = new positionsModel();
        // 获取所有职级
        $position_arr = $position_model->getPositionInfo();
        // 获取开始职级在所有职级中的位置
        $begin_position_length = array_keys(array_values(array_keys($position_arr)), $begin_position_id);
        // 获取当前职级在所有职级中的位置
        $this_position_location = array_keys(array_values(array_keys($position_arr)), $position_id);
        $length                 = bcsub($this_position_location[0], $begin_position_length[0]);
        $new_position_arr       = array_slice($position_arr, $begin_position_length[0], bcadd($length, 1), true);
        return $new_position_arr;
    }

    /**
     * 计算人头数
     *
     * @param $position_user_arr // 各职位级别总人数的数组
     * @param $begin_position_id // 开始计算职级的位置
     * @return array
     */
    public function getPositionUserCount($position_user_arr, $begin_position_id)
    {
        ksort($position_user_arr);
        // 需要处理的各职级的人数
        $new_user_count_arr = [];
        foreach ($position_user_arr as $position_id => $position_count) {
            // 当前职级之前的所有职级
            $new_arr                        = $this->getPreviousPositionArr($position_id, $begin_position_id);
            $now_position_arr[$position_id] = $new_arr;
            foreach ($new_arr as $new_position_id => $new_position_count) {
                $new_user_count_arr[$new_position_id][$position_id] = $position_count;
            }
        }

        $user_count_for_position = [];
        foreach ($new_user_count_arr as $k => $v) {
            $user_count_for_position[$k] = array_sum($v);   // 每个级别对应的人头数
        }
        return $user_count_for_position;
    }

    /**
     * 计算各职级每份分红的金额
     *
     * @param        $user_count_for_position // 各职级的人头数
     * @param        $total_money             // 当前分配类型可分配的总利润
     * @param string $rate_name               // 获取比例的类型名称
     * @return array
     */
    public function getEachMoneyForPosition($user_count_for_position, $total_money, $rate_name = 'black_diamond_sales_bonus')
    {
        // 计算各职级每份分红的金额
        $position_model          = new positionsModel();
        $each_money_for_position = [];
        foreach ($user_count_for_position as $position_id => $head_count) {
            // 各职级可分配的利润
            $rate_info = $position_model->getUserPositionBonusRate($position_id);
            $rate      = $rate_info[$rate_name];
            $profit    = $this->getProfitForEachPosition($total_money, $rate);
            if ($head_count == 0) {
                $each_money_for_position[$position_id] = 0;
            } else {
                $each_money_for_position[$position_id] = bcdiv($profit, $head_count, 2);
            }
        }
        return $each_money_for_position;
    }

    /**
     * 计算人头数
     *
     * @param $position_user_arr // 各职位级别总人数的数组
     * @param $begin_position_id // 开始计算职级的位置
     * @return array
     */
    public function getPositionUserTotalHi($position_user_arr, $begin_position_id)
    {
        ksort($position_user_arr);
        // 需要处理的各职级的人数
        $new_user_count_arr = [];
        foreach ($position_user_arr as $position_id => $position_count) {
            // 当前职级之前的所有职级
            $new_arr                        = $this->getPreviousPositionArr($position_id, $begin_position_id);
            $now_position_arr[$position_id] = $new_arr;
            foreach ($new_arr as $new_position_id => $new_position_count) {
                $new_user_count_arr[$new_position_id][$position_id] = $position_count;
            }
        }

        $user_count_for_position = [];
        foreach ($new_user_count_arr as $k => $v) {
            $user_count_for_position[$k] = array_sum($v);   // 每个级别对应的人头数
        }
        return $user_count_for_position;
    }

    /**
     * 计算各职级HI值分红的总金额
     *
     * @param        $user_hi_for_position  // 各职级的HI值总数
     * @param        $total_hi_for_position // 用户hi值
     * @param        $total_money           // 当前分配类型可分配的总利润
     * @param string $rate_name             // 获取比例的类型名称
     * @return array
     */
    public function getEachMoneyForPositionHi($user_hi_for_position, $total_hi_for_position, $total_money, $rate_name = 'black_diamond_sales_bonus')
    {

        // 计算各职级每份分红的金额
        $position_model          = new positionsModel();
        $each_money_for_position = [];
        foreach ($user_hi_for_position as $position_id => $total_hi) {
            // 各职级可分配的利润
            $rate_info                             = $position_model->getUserPositionBonusRate($position_id);
            $rate                                  = $rate_info[$rate_name];
            $profit                                = $this->getProfitForEachPosition($total_money, $rate);
            $each_money_for_position[$position_id] = $profit;
        }
        return $each_money_for_position;
    }

    public function getPositionUserCount备份()
    {
        $position_model = new positionsModel();
        // 获取所有职级
        $position_arr = $position_model->getPositionInfo();
        // 需要处理的各职级的人数
        $position_user_arr = [1 => 3, 6 => 5, 4 => 2];
        ksort($position_user_arr);
        // 当前用户的职级
        $now_user_position_id = 6;
        // 初始值
        $now_position_arr = [];
        foreach ($position_user_arr as $position_id => $position_count) {

            // 当前职级之前的所有职级
            $new_arr                        = array_slice($position_arr, 0, $position_id, true);
            $now_position_arr[$position_id] = $new_arr;
            foreach ($new_arr as $new_position_id => $new_position_count) {

                echo '当前职级 ' . $position_id . ' 当前职级之前的所有职级 ' . $new_position_id . ' 需要增加的人数为 ' . $position_count;
                echo '<br/>';
                $new_user_count_arr[$new_position_id][$position_id] = $position_count;
            }
        }
        print_r($now_position_arr);
        die;
        $user_count_for_position = [];
        foreach ($new_user_count_arr as $k => $v) {
            $user_count_for_position[$k] = array_sum($v);   // 每个级别对应的人头数
        }
        // 各职级可分配的利润
        $profit = 700;
        // 计算各职级每份分红的金额
        $each_money_for_position = [];
        foreach ($user_count_for_position as $position_id => $head_count) {
            $each_money_for_position[$position_id] = bcdiv($profit, $head_count, 2);
        }
//        print_r($now_position_arr);die;
        $c = array_intersect_key($each_money_for_position, $now_position_arr[$now_user_position_id]);
        print_r($c);
        die;
        print_r($each_money_for_position);
        die;
        print_r($user_count_for_position);
        die;
        return $user_count_for_position;
    }

    /**
     * 计算各职级可分配的利润
     *
     * @param $total_money // 当前分配类型可分配的总利润
     * @param $rate        // 比例
     * @return string
     */
    public function getProfitForEachPosition($total_money, $rate)
    {
        // 当前职级可分配的利润
        $this_position_money = bcdiv(bcmul($total_money, $rate, 2), 100);
        return $this_position_money;
    }

    // 统计销售精英月分红
    public function statisticsEliteMonthlyBonus()
    {
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_ELITE_MONTHLY_BONUS;        // 销售精英月分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月 15 号分一次
        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->eliteMonthlyBonus();
            return false;
        }

        // 获取上个月所有有消费或个人微商有销售额的会员等级是免费会员及以上的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = ['in', [1, 2]];
        $where['user_level_id']              = ['in', [1, 2, 3, 4, 5, 6]];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();
        if (empty($user_arr)) {
            return false;
        }
        $user_arr_for_user_id = array_column($user_arr, 'user_id');
        $user_id_and_level_id = array_combine(array_column($user_arr, 'user_id'), array_column($user_arr, 'user_level_id'));

        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_arr_for_user_id];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id')->select();
        if (empty($member_list)) {
            return false;
        }
        // 以用户id为键，职级id为值组合数组
        $user_id_and_position_id_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'positions_id'));
        $user_money_data             = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][$consumption_user['type']][] = $consumption_user['total_money'];
        }

        // 满足分红条件的会员以及他们的消费额
        $user_data = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                // 当前用户的等级
                $this_user_level = $user_id_and_level_id[$user_id];
                // 当前用户的职级
                $this_user_position    = $user_id_and_position_id_arr[$user_id];
                $this_user_quota_for_c = 0;
                if (isset($money_for_type[1])) {
                    $this_user_quota_for_c = array_sum($money_for_type[1]);
                }
                $this_user_quota_for_c_and_s = 0;
                if (isset($money_for_type[2])) {
                    $this_user_quota_for_c_and_s = array_sum($money_for_type[2]);
                }
                // ① 职级是高级主管或以上的：上月个人消费满1000元及以上，或个人消费加销售推荐加个人微商销售额满2000元及以上。

                // ② 会员级别是金尊VIP或以上的：上月个人消费满2000元及以上，或个人消费加销售推荐加个人微商销售额满4000元及以上

                // ③ 免费VIP会员：上月个人消费加销售推荐加个人微商销售额累计满20000元及以上。
                if (in_array($this_user_position, [1, 2, 3, 4, 5, 6, 7]) && ($this_user_quota_for_c >= 1000 || $this_user_quota_for_c_and_s >= 2000)) {
                    $user_data[] = $user_id;
                    continue;
                } else if (in_array($this_user_level, [3, 4, 5, 6]) && ($this_user_quota_for_c >= 2000 || $this_user_quota_for_c_and_s >= 4000)) {
                    $user_data[] = $user_id;
                    continue;
                } else if ($this_user_level == 1 && $this_user_quota_for_c_and_s >= 20000) {
                    $user_data[] = $user_id;
                    continue;
                }
                continue;
            }
        }
        if (empty($user_data)) {
            return false;
        }
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->eliteMonthlyBonus();
        }
        return false;
    }

    // 销售精英月分红
    public function eliteMonthlyBonus()
    {
        // 当月15号分红
        $dividend_day = $this->getCurrentMiddleMonthDate();
        /*if ($this->checkIsDividendDay($dividend_day)) {
            return false;
        }*/
        // 当月开始时间
        $bonus_begin_at = $this->getCurrentMonthBeginDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_ELITE_MONTHLY_BONUS;        // 当前分红类型
        // 最近更新时间小于本月开始时间
        $where['updated_at'] = ['LT', $bonus_begin_at];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 本月需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }


        // 获取平台上月的利润
        $cycle_type                            = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式
        $last_month_profit_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $last_month_profit_where['cycle']      = $cycle_type;
        $last_month_profit                     = $this->getPlatformProfit($last_month_profit_where);
        if ($last_month_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($last_month_profit, 0.1, 2);

        // 分别计算每种模式可以分配的金额
        $money_one   = bcmul($current_bonus_money, 0.4, 2);         // （平台上月销售分红利润 × 4%）
        $money_three = bcmul($current_bonus_money, 0.4, 2);       // HI 值占比额：4%。
        $money_four  = bcmul($current_bonus_money, 0.2, 2);        // 销售额占比额：2%。

        // 参与分红的用户数
        $user_count = count($user_id_arr);

        // 获取用户对应的hi值，以user_id作为键
        $user_hi_value_model                   = new user_hi_valueModel();
        $total_user_hi_value_info_arr          = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("user_id,sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->group('user_id')->select();
        $total_user_hi_value_info_arr_for_user = array_combine(array_column($total_user_hi_value_info_arr, 'user_id'), $total_user_hi_value_info_arr);
        // 总hi值
        $total_hi_value = array_sum(array_column($total_user_hi_value_info_arr_for_user, 'hi_value'));
        // 用户上月总消费/销售额，以user_id作为键
        $user_consumption_sale_log_day_model   = new user_consumption_sale_log_dayModel();
        $user_consumption_sale_info_day_arr    = $user_consumption_sale_log_day_model
            ->where(['user_id' => ['in', $user_id_arr], 'created_at' => ['between', [$last_month_begin_date, $last_month_end_date]]])
            ->field('user_id,sum(total_money) as total_user_consumption_sale_day_money')
            ->group('user_id')->select();
        $total_user_consumption_sale_money_arr = array_combine(array_column($user_consumption_sale_info_day_arr, 'user_id'), $user_consumption_sale_info_day_arr);
        // 获取参加该分红会员的总销售额
        $last_month_consumption_and_sale_money = array_sum(array_column($user_consumption_sale_info_day_arr, 'total_user_consumption_sale_day_money'));
        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));

        // 所有符合条件的会员都能拿到的钱
        $common_money         = bcdiv($money_one, $user_count, 2);
        $add_money_arr        = [];
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        foreach ($user_id_arr as $user_id) {
            $remark_arr[] = '当前会员 ID：' . $user_id;
            $remark_arr[] = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '分红时间：' . $now_date;
            $remark_arr[] = '平台上月的利润：' . $last_month_profit;
            $remark_arr[] = '当前分红类型可分配的利润 10%：' . $current_bonus_money;
            $remark_arr[] = '平分利润占比额（4%）：' . $money_one;
            $remark_arr[] = 'HI 值占比额（4%）：' . $money_three;
            $remark_arr[] = '销售额占比额（2%）：' . $money_four;
            // 当前用户的hi值
            $this_user_hi_value = isset($total_user_hi_value_info_arr_for_user[$user_id]['hi_value']) ? $total_user_hi_value_info_arr_for_user[$user_id]['hi_value'] : 0;
            $remark_arr[]       = '参加该分红会员的总分红 HI 值：' . $total_hi_value;
            $remark_arr[]       = '当前用户的hi值：' . $this_user_hi_value;
            // 用户 HI 值可分到的利润
            $this_user_hi_money = 0;
            if ($this_user_hi_value > 0) {
                $this_user_hi_money = bcdiv(bcmul($this_user_hi_value, $money_three, 2), $total_hi_value, 2);
            }
            $remark_arr[] = '2.当前用户 HI 值可分到的利润：' . $this_user_hi_money;
            // 当前用户消费销售额
            $this_user_total_money = $total_user_consumption_sale_money_arr[$user_id]['total_user_consumption_sale_day_money'];
            $remark_arr[]          = '当前用户消费销售额：' . $this_user_total_money;
            $remark_arr[]          = '参加该分红会员的总销售额：' . $last_month_consumption_and_sale_money;
            // 用户消费/销售额度奖金(销售/消费额度 除以 总额度 乘以分红)
            $consumption_sale_money                                = bcdiv(bcmul($this_user_total_money, $money_four), $last_month_consumption_and_sale_money, 2);
            $remark_arr[]                                          = '4.当前用户消费/销售额度奖金：' . $consumption_sale_money;
            $remark_arr[]                                          = '5.当前用户当前分红总金额：' . bcadd(bcadd($common_money, $this_user_hi_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type'] = 2;
            // 总分红 = HI 值分红 + 用户消费/销售额分红 + 所有合格用户都能拿到的分红
            $add_money_arr[$user_id]                      = bcadd(bcadd($common_money, $this_user_hi_money, 2), $consumption_sale_money, 2);
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }


        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 统计高层销售月分红
    public function statisticsTopSellingMonthlyBonus()
    {
        // 获取当月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model  = new user_bonusModel();
        $type_bonus        = $user_bonus_model::TYPE_TOP_SELLING_MONTHLY_BONUS;        // 高层销售月分红
        $frequency_for_day = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月分一次

        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();

        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->topSellingMonthlyBonus();
            return false;
        }

        // 获取上个月所有个人消费达到了3000元或以上的会员
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = 1;
        $where['total_money']                = ['EGT', 3000];
        $user_arr                            = $user_consumption_sale_log_day_model->where($where)->field($field)->select();

        if (empty($user_arr)) {
            return false;
        }
        $user_arr_for_user_id = array_column($user_arr, 'user_id');
        // 获取职级是市场总监或以上的会员
        $member_model                 = new memberModel();
        $member_where['member_id']    = ['in', array_column($user_arr, 'user_id')];
        $member_where['positions_id'] = ['in', [5, 6, 7]];
        $member_list                  = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        if (empty($member_list)) {
            return false;
        }
        // 以用户id为键，职级id为值组合数组
        $user_id_and_position_id_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'positions_id'));
        $user_member_name_arr        = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));
        $member_list_for_user_id     = array_column($member_list, 'member_id');
        // 获取消费记录中满足条件的信息（取销售消费满足条件以及等级和职级满足条件的两者的并集）
        $user_arr_intersect = array_intersect_key($member_list_for_user_id, $user_arr_for_user_id);
        $user_money_data    = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
        }
        // 满足分红条件的会员以及他们的消费额
        $user_data = [];
        if (!empty($user_money_data)) {
            foreach ($user_money_data as $user_id => $money_for_type) {
                // 如果当前用户在$user_arr_intersect数组中才算满足分红条件
                if (!in_array($user_id, $user_arr_intersect)) {
                    continue;
                }
                $this_user_quota_for_c = 0;
                if (!empty($money_for_type)) {
                    $this_user_quota_for_c = array_sum($money_for_type);
                }

                // 当前用户的职级
                $this_user_position = $user_id_and_position_id_arr[$user_id];
                if (($this_user_position == 5) && ($this_user_quota_for_c >= 3000)) {
                    $user_data[] = $user_id;
                    continue;
                } else if (($this_user_position == 6) && ($this_user_quota_for_c >= 4000)) {
                    $user_data[] = $user_id;
                    continue;
                } else if (($this_user_position == 7) && ($this_user_quota_for_c >= 5000)) {
                    $user_data[] = $user_id;
                    continue;
                }

                continue;
            }
        }
        if (empty($user_data)) {
            return false;
        }

        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];
        foreach ($user_data as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_day;
            $data[$key]['created_at'] = $current_date;

        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->topSellingMonthlyBonus();
        }
        return false;
    }

    // 高层销售月分红
    public function topSellingMonthlyBonus()
    {
        // 当月15号分红
        $dividend_day = $this->getCurrentMiddleMonthDate();
        /* if ($this->checkIsDividendDay($dividend_day)) {
             return false;
         }*/
        // 当月开始时间
        $bonus_begin_at = $this->getCurrentMonthBeginDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();


        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_TOP_SELLING_MONTHLY_BONUS;        // 当前分红类型
        // 最近更新时间小于本月开始时间
        $where['updated_at'] = ['LT', $bonus_begin_at];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 本月需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }

        // 获取平台上月的利润
        $cycle_type                            = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式
        $last_month_profit_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $last_month_profit_where['cycle']      = $cycle_type;
        $last_month_profit                     = $this->getPlatformProfit($last_month_profit_where);
        if ($last_month_profit == 0) {
            return false;
        }
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($last_month_profit, 0.08, 4);
        // 获取每个职级对应的占比额
        $total_md_money  = bcmul($last_month_profit, 0.05, 4);
        $total_gm_money  = bcmul($last_month_profit, 0.02, 4);
        $total_vpm_money = bcmul($last_month_profit, 0.01, 4);

        $money_one_for_hi   = bcmul($total_md_money, 0.4, 4);         // 市场总监可获取的HI值总奖金
        $money_two_for_hi   = bcmul($total_gm_money, 0.25, 4);        // 市场总经理可获取的HI值总奖金
        $money_three_for_hi = bcmul($total_vpm_money, 0.3, 4);
        // 分别计算每种模式可以分配的金额
        /**
         * 37.5
         * 62.5
         * 12.5
         */
//        $money_one_for_hi = bcmul($current_bonus_money, 0.25, 4);         // 市场总监可获取的HI值总奖金
//        $money_two_for_hi = bcmul($current_bonus_money, 0.0625, 4);        // 市场总经理可获取的HI值总奖金
//        $money_three_for_hi = bcmul($current_bonus_money, 0.0375, 4);       // 市场副总裁可获取的HI值总奖金


        // 获取用户的职位级别信息
        $member_model            = new memberModel();
        $user_lists_for_position = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,positions_id,member_name')->select();
        // 以member_id作为数组的键
        $user_position_for_user_id = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'positions_id'));
        $user_member_name_arr      = array_combine(array_column($user_lists_for_position, 'member_id'), array_column($user_lists_for_position, 'member_name'));

        // 参与分红的用户数
        $user_count = count($user_id_arr);

        // 获取上个月所有满足条件的有消费或个人微商有销售额的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,user_level_id,total_money';
        $user_arr_where['created_at']        = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_arr_where['type']              = 1;
        $user_arr_where['user_id']           = ['in', $user_id_arr];
        $user_arr                            = $user_consumption_sale_log_day_model->where($user_arr_where)->field($field)->select();

        if (empty($user_arr)) {
            return false;
        }
        $total_consumption_and_sale_money_arr = [];
        $user_money_data                      = [];
        foreach ($user_arr as $consumption_user_key => $consumption_user) {
            // 当前会员的所有消费额
            $user_money_data[$consumption_user['user_id']][] = $consumption_user['total_money'];
            $total_consumption_and_sale_money_arr[]          = $consumption_user['total_money'];
        }
        // 获取参加该分红会员的总销售额
        $last_month_consumption_and_sale_money = array_sum($total_consumption_and_sale_money_arr);

        // 统计各职位级别的总人数
        $position_count_user = array_count_values($user_position_for_user_id);

        // 获取销售总监的类型
        $position_model    = new positionsModel();
        $begin_position_id = $position_model::POSITIONS_MD;
        // 获取人头数
        $head_count_for_position = $position_model->getUserHeadcountForPositions($position_count_user, $begin_position_id);
        // 获取各职级分别可以拿到的平台上月全球销售分红利润
        $each_money_for_position = $position_model->getEachMoneyForPosition($head_count_for_position, $current_bonus_money, 'top_selling_monthly_bonus');

        /*
        // 获取各职级hi值可以分的总金额
        p('$money_one_for_hi');
        p($money_one_for_hi);
        p('$money_two_for_hi');
        p($money_two_for_hi);
        p('$money_three_for_hi');
        p($money_three_for_hi);

        p('// 平台上月的利润');
        p($last_month_profit);    // 平台上月的利润
        p('// 当前分红类型可分配的利润');
        p($current_bonus_money);  // 当前分红类型可分配的利润
        p('// 每个职级平均分的钱');
        p($each_money_for_position);die;
        */


        // 获取用户对应的hi值，以user_id作为键
        $user_hi_value_model                   = new user_hi_valueModel();
        $total_user_hi_value_info_arr          = $user_hi_value_model->where(['user_id' => ['in', $user_id_arr]])->field("user_id,sum(upgrade_hi+recommend_team_hi+bonus_to_hi) as hi_value")->group('user_id')->select();
        $total_user_hi_value_info_arr_for_user = array_combine(array_column($total_user_hi_value_info_arr, 'user_id'), $total_user_hi_value_info_arr);
        $add_money_arr                         = [];
        // 分别获取每个职级中各用户的HI值
        $each_money_for_hi_arr = [];
        foreach ($user_position_for_user_id as $user_id => $position_id) {
            $each_money_for_hi_arr[$position_id][$user_id] = $total_user_hi_value_info_arr_for_user[$user_id]['hi_value'];
        }
        // 分别获取每个职级中总的HI值
        $total_hi_for_position = [];
        foreach ($each_money_for_hi_arr as $position_id => $hi_arr) {
            $total_hi_for_position[$position_id] = array_sum($hi_arr);
        }
        /**
         * [5] => 3000
         * [7] => 4000
         * [6] => 3000
         */
        // 获取各职级的总hi值数（按人头数算）
        $user_total_hi_for_position = $position_model->getUserHeadcountForPositions($total_hi_for_position, $begin_position_id);
        /**
         * [5] => 10000
         * [6] => 7000
         * [7] => 4000
         */


        // 获取每个职级hi值的分红总额
//        $total_hi_money[5] = $money_one_for_hi;
//        $total_hi_money[6] = $money_two_for_hi;
//        $total_hi_money[7] = $money_three_for_hi;
        $total_hi_money = $position_model->getEachMoneyForPosition($head_count_for_position, $current_bonus_money, 'top_selling_monthly_bonus_for_hi');
        // 获取当前用户职级获得的hi值分红总额
        $now_date             = date('Y-m-d H:i:s');
        $system_bonus_log_arr = [];
        foreach ($user_id_arr as $user_id) {
            $remark_arr[] = '当前会员 ID：' . $user_id;
            $remark_arr[] = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '分红时间：' . $now_date;
            $remark_arr[] = '平台上月的利润：' . $last_month_profit;
            $remark_arr[] = '当前分红类型可分配的利润 8%：' . $current_bonus_money;
            $remark_arr[] = '销售总监占比额 5%：' . $total_md_money;
            $remark_arr[] = '销售总经理占比额 2%：' . $total_gm_money;
            $remark_arr[] = '销售副总裁占比额 1%：' . $total_vpm_money;
            $remark_arr[] = '各职位级别的总人数：' . array_to_key_value_str($position_count_user, '、');
            $remark_arr[] = '各职级的人头数：' . array_to_key_value_str($head_count_for_position, '、');
            $remark_arr[] = '各职级分别可以拿到的HI值分红总利润：' . array_to_key_value_str($total_hi_money, '、');
            $remark_arr[] = '各职级的总hi值数（按人头数算）：' . array_to_key_value_str($user_total_hi_for_position, '、');
            // 当前用户的职级
            $this_user_position = $user_position_for_user_id[$user_id];
            $remark_arr[]       = '当前用户的职级：' . $this_user_position;

            // 当前用户可叠加计算的职级项
            $new_position_arr = $position_model->getPreviousArr($this_user_position, $begin_position_id);

            $remark_arr[] = '各职级分别可以拿到的平台上月全球销售分红利润：' . array_to_key_value_str($each_money_for_position, '、');
            $remark_arr[] = '当前用户可以叠加的职级：' . implode('、', $new_position_arr);
            // 每个职级可获得的分红
            $user_each_position_money = array_intersect_key($each_money_for_position, $new_position_arr);
            $remark_arr[]             = '每个职级可获得的分红：' . array_to_key_value_str($user_each_position_money);
            // 当前用户该职级可分到的总利润
            $this_user_position_money = array_sum($user_each_position_money);
            $remark_arr[]             = '当前用户该职级可分到的总利润：' . $this_user_position_money;
            // 当前用户的hi值
            $this_user_hi_value = isset($total_user_hi_value_info_arr_for_user[$user_id]['hi_value']) ? $total_user_hi_value_info_arr_for_user[$user_id]['hi_value'] : 0;
            $remark_arr[]       = '当前用户的hi值：' . $this_user_hi_value;
            $this_user_hi_money = 0;
            if ($this_user_hi_value > 0) {
                $this_user_total_money_for_hi = [];
                foreach ($new_position_arr as $positions_id) {
                    // 当前用户在当前职级可获得的总分红(当前用户的hi x 当前职级的总分红 / 当前职级的所有hi值)
                    $this_user_total_money_for_hi[] = bcdiv(bcmul($this_user_hi_value, $total_hi_money[$positions_id], 4), $user_total_hi_for_position[$positions_id], 4);
                }
                if (!empty($this_user_total_money_for_hi)) {
                    $this_user_hi_money = array_sum($this_user_total_money_for_hi);
                }
            }
            $remark_arr[]                                          = '当前用户的hi值获得的分红：' . $this_user_hi_money;
            $remark_arr[]                                          = '当前用户获得的总分红：' . bcadd($this_user_position_money, $this_user_hi_money, 2);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = $current_bonus_money;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $add_money_arr[$user_id]                      = bcadd($this_user_position_money, $this_user_hi_money, 2);
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }

        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    /**
     * @param $user_id                    // 用户id
     * @param $new_position_arr           // 用户当前包括叠加的所有职级
     * @param $user_hi_value              // 用户当前拥有的hi值
     * @param $user_total_hi_for_position // 各职级拥有的hi值总数
     * @param $each_money_for_hi          // 各职级分别可分配的总利润
     * @return int
     */
    public function getUserMoneyForTopSellingMonthlyBonus($user_id, $new_position_arr, $user_hi_value, $user_total_hi_for_position, $each_money_for_hi)
    {

        $total_money = [];
        foreach ($new_position_arr as $position_id => $position_name) {
            $total_money[$position_id] = bcdiv(bcmul($user_hi_value, $each_money_for_hi[$position_id], 2), $user_total_hi_for_position[$position_id], 2);
        }
        $return_total_money = array_sum($total_money);
        return $return_total_money;
    }

    // 统计销售管理普惠周奖金
    public function statisticsSalesManagementWeekBonus()
    {
        // 获取本周开始和结束时间
        $current_weekly_begin_date = $this->getCurrentWeeklyBeginDate();
        $current_weekly_end_date   = $this->getCurrentWeeklyEndDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model     = new user_bonusModel();
        $type_bonus           = $user_bonus_model::TYPE_SALES_MANAGEMENT_WEEK_BONUS;// 销售管理普惠周奖金
        $frequency_for_weekly = $user_bonus_model::FREQUENCY_FOR_WEEKLY; // 每周分一次
        // 每周统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_weekly_begin_date, $current_weekly_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->salesManagementWeekBonus();
            return false;
        }
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 获取上个月所有有个人消费的用户
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $field                               = 'user_id,type,sum(total_money) as total_money';
        $where['created_at']                 = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']                       = 1;
        $has_consumption_user_arr            = $user_consumption_sale_log_day_model->where($where)->field($field)->group('user_id')->select();
        if (empty($has_consumption_user_arr)) {
            return false;
        }
        // 满800或以上的用户
        $new_has_consumption_user_arr = [];
        foreach ($has_consumption_user_arr as $value) {
            if ($value['total_money'] >= 800) {
                $new_has_consumption_user_arr[] = $value['user_id'];
            }
        }
        if (empty($new_has_consumption_user_arr)) {
            return false;
        }
        // 获取职级是高级主管及以上的会员
        $member_model                                  = new memberModel();
        $user_lists_for_position_where['positions_id'] = ['in', [1, 2, 3, 4, 5, 6, 7]];
        $user_lists_for_position_where['member_id']    = ['in', $new_has_consumption_user_arr];
        $user_lists_for_position                       = $member_model->where($user_lists_for_position_where)->field('member_id,positions_id,member_name')->select();
        if (empty($user_lists_for_position)) {
            return false;
        }
        $user_arr = array_column($user_lists_for_position, 'member_id');

        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        $bonus_end_at   = $this->getCurrentMonthEndDate();
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $data         = [];

        foreach ($user_arr as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $bonus_begin_at;
            $data[$key]['end_at']     = $bonus_end_at;
            $data[$key]['frequency']  = $frequency_for_weekly;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll(array_values($data));
            // 开始分红
            $this->salesManagementWeekBonus();
        }
        return false;

    }

    // 销售管理普惠周奖金
    public function salesManagementWeekBonus()
    {
        // 本周开始时间
        $current_weekly_begin_date = $this->getCurrentWeeklyBeginDate();
        // 当月开始时间
        $bonus_begin_at = $this->getCurrentMonthBeginDate();
        // 上周开始时间
        $last_week_begin_at = $this->getLastWeeklyBeginDate();
        // 上周结束时间
        $last_week_end_at = $this->getLastWeeklyEndDate();
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();
        // 如果是第一个月，则不分红 2019-04-12
        if (empty($last_month_begin_date) || empty($last_month_end_date)) {
            return false;
        }

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_SALES_MANAGEMENT_WEEK_BONUS;// 当前分红类型
        // 最近更新时间小于本周开始时间
        $where['updated_at'] = ['LT', $current_weekly_begin_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $bonus_begin_at];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取平台上周的利润
        $cycle_type                           = $user_bonus_model::FREQUENCY_FOR_WEEKLY;// 分红模式
        $last_week_profit_where['created_at'] = ['between', [$last_week_begin_at, $last_week_end_at]];
        $last_week_profit_where['cycle']      = $cycle_type;
        $last_week_profit                     = $this->getPlatformProfit($last_week_profit_where);
        // 当前分红类型可分配的利润
        $current_bonus_money = bcmul($last_week_profit, 0.1, 2);
        // 获取这些用户邀请的会员
        $register_invite = new register_inviteModel();
        $invite_user_arr = $register_invite->where(['from_user_id' => ['in', $user_id_arr]])->select();
        if (empty($invite_user_arr)) {
            return false;
        }
        // 组合邀请人和被邀请人数据
        $from_user_id_arr = [];
        foreach ($invite_user_arr as $value) {
            $from_user_id_arr[$value['from_user_id']][] = $value['to_user_id'];
        }
        // 所有被邀请人用户id
        $be_invite_user_arr = array_column($invite_user_arr, 'to_user_id');
        // 获取这些被邀请人上周获得的总奖金
        $bonus_type_arr                                  = [17, 18, 19, 9, 1, 2, 10, 5, 6, 7, 8];
        $user_bonus_log_model                            = new user_bonus_logModel();
        $last_week_total_bonus_money_where['user_id']    = ['in', $be_invite_user_arr];
        $last_week_total_bonus_money_where['type']       = ['in', $bonus_type_arr];
        $last_week_total_bonus_money_where['created_at'] = ['between', [$last_week_begin_at, $last_week_end_at]];
        $last_week_total_bonus_money                     = $user_bonus_log_model->where($last_week_total_bonus_money_where)->field('user_id,sum(money) as total_money')->group('user_id')->select();
        // 将用户id和总奖金组合
        $last_week_total_bonus_money_for_user_id = array_combine(array_column($last_week_total_bonus_money, 'user_id'), array_column($last_week_total_bonus_money, 'total_money'));
        $total_user_total_team_money             = array_sum($last_week_total_bonus_money_for_user_id);
        $system_bonus_log_arr                    = [];
        $now_date                                = date('Y-m-d H:i:s');
        $add_money_arr                           = [];
        // 获取这些会员的职级
        $member_model              = new memberModel();
        $member_where['member_id'] = ['in', $user_id_arr];
        $member_list               = $member_model->where($member_where)->field('member_id,positions_id,member_name')->select();
        // 以用户id为键，职级id为值组合数组
        $user_member_name_arr = array_combine(array_column($member_list, 'member_id'), array_column($member_list, 'member_name'));
        foreach ($from_user_id_arr as $user_id => $team_child_user) {
            $remark_arr[] = '当前会员 ID：' . $user_id;
            $remark_arr[] = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[] = '当前分红类型：' . $type_bonus;
            $remark_arr[] = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $remark_arr[] = '分红时间：' . $now_date;
            // 当前用户邀请的会员获得的分红数组
            $this_user_invite_bonus_arr = array_intersect_key($last_week_total_bonus_money_for_user_id, array_flip($team_child_user));
            $remark_arr[]               = '当前用户邀请的会员获得的分红数组：' . array_to_key_value_str($this_user_invite_bonus_arr);
            $this_user_total_team_money = 0;
            if (!empty($this_user_invite_bonus_arr)) {
                $this_user_total_team_money = array_sum($this_user_invite_bonus_arr);
            }
            $remark_arr[]    = '平台上周剩余总利润：' . $last_week_profit;
            $remark_arr[]    = '当前分红类型可分配利润：' . $current_bonus_money;
            $remark_arr[]    = '所有参加当前分红的用户邀请的会员获得的总分红：' . $total_user_total_team_money;
            $remark_arr[]    = '当前用户邀请的会员获得的总分红：' . $this_user_total_team_money;
            $this_user_money = 0;
            if ($this_user_total_team_money > 0) {
                $this_user_money         = bcdiv(bcmul($this_user_total_team_money, $current_bonus_money, 2), $total_user_total_team_money, 2);
                $add_money_arr[$user_id] = $this_user_money;
                $remark_arr[]            = '当前用户获得的总奖金：' . $this_user_money;
            }
            unset($this_user_money);
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = 0;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
        }
        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除
            $this->platformProfitDec($dividends_paid, $cycle_type);
            $this->addMoney($add_money_arr, $type_bonus);
        }
        return false;
    }

    // 统计供应商推荐奖金
    public function statisticsSupplierReferralBonus()
    {
        // 获取本月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();

        // 供应商推荐奖金分红开始时间为从当月开始到第四个月的15号才分红

        // 检查这个分红是否已经统计了上个月的数据（入库时间是这个月的）
        $user_bonus_model    = new user_bonusModel();
        $type_bonus          = $user_bonus_model::TYPE_SUPPLIER_REFERRAL_BONUS;        // 供应商推荐奖金
        $frequency_for_month = $user_bonus_model::FREQUENCY_FOR_MONTH;              // 每月一次

        // 每月统计一次
        $check_has_statistics = $user_bonus_model->where(['type' => $type_bonus, 'created_at' => ['between', [$current_month_begin_date, $current_month_end_date]]])->count();
        if ($check_has_statistics > 0) {
            // 如果已经统计过了，那么直接分红
            $this->supplierReferralBonus();
            return false;
        }
        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        // 获取所有上个月产生了供应商推荐奖金的用户以及他们的上级团队用户
        $user_bonus_pool_model = new user_bonus_poolModel();
        $where['created_at']   = ['between', [$last_month_begin_date, $last_month_end_date]];
        $where['type']         = $type_bonus;
        $user_arr              = $user_bonus_pool_model->where($where)->select();
        if (empty($user_arr)) {
            return false;
        }
        // 获取当前时间
        $current_date = $this->getCurrentDate();
        $user_id_arr  = array_unique(array_column($user_arr, 'to_user_id'));
        $data         = [];
        foreach ($user_id_arr as $key => $user_id) {
            $data[$key]['user_id']    = $user_id;
            $data[$key]['type']       = $type_bonus;
            $data[$key]['begin_at']   = $current_month_begin_date;
            $data[$key]['end_at']     = $current_month_end_date;
            $data[$key]['frequency']  = $frequency_for_month;
            $data[$key]['created_at'] = $current_date;
        }
        if (!empty($data)) {
            $user_bonus_model->insertAll($data);
            // 开始分红
            $this->supplierReferralBonus();
        }
        return false;
    }

    // 供应商推荐奖金
    public function supplierReferralBonus()
    {
        // 获取本月开始和结束时间
        $current_month_begin_date = $this->getCurrentMonthBeginDate();
        $current_month_end_date   = $this->getCurrentMonthEndDate();

        // 获取上个月开始时间
        $last_month_begin_date = $this->getLastMonthBeginDate();
        // 获取上个月结束时间
        $last_month_end_date = $this->getLastMonthEndDate();

        $user_bonus_model = new user_bonusModel();
        $type_bonus       = $user_bonus_model::TYPE_SUPPLIER_REFERRAL_BONUS;// 当前分红类型
        $cycle_type       = $user_bonus_model::FREQUENCY_FOR_MONTH;// 分红模式
        // 最近更新时间小于本月开始时间
        //$where['updated_at'] = ['LT', $current_month_begin_date];
        // 最近更新时间小于本月结束时间
        $where['updated_at'] = ['LT', $current_month_end_date];
        // 统计时间大于当月开始时间
        $where['created_at'] = ['GT', $current_month_begin_date];
        $where['type']       = $type_bonus;
        $user_id_lists       = $user_bonus_model->where($where)->select();
        // 今天需要分红的用户
        $user_id_arr = array_column($user_id_lists, 'user_id');
        if (count($user_id_arr) == 0) {
            return false;
        }
        // 获取昨天资金池中产生的消费共享分红总金额（本分红在订单确认时剩余的可分配商品利润中已扣除，不需要再在此处扣除）
        $user_bonus_pool_model               = new user_bonus_poolModel();
        $user_bonus_pool_where['created_at'] = ['between', [$last_month_begin_date, $last_month_end_date]];
        $user_bonus_pool_where['type']       = $type_bonus;
        $user_bonus_pool_where['to_user_id'] = ['in', $user_id_arr];
        // 获取每个邀请人下面的供应商产生的总分红
        $share_bonus_for_team_money_info         = $user_bonus_pool_model->where($user_bonus_pool_where)->field('to_user_id,sum(money) as total_money')->group('to_user_id')->select();
        $share_bonus_for_team_money_for_user_arr = array_combine(array_column($share_bonus_for_team_money_info, 'to_user_id'), array_column($share_bonus_for_team_money_info, 'total_money'));


        // 获取这些用户的等级id
        $member_model                            = new memberModel();
        $user_lists_for_level_where['member_id'] = ['in', $user_id_arr];
        $user_lists_for_level                    = $member_model->where($user_lists_for_level_where)->field('member_id,level_id,member_name')->select();
        $user_id_and_level_id                    = array_combine(array_column($user_lists_for_level, 'member_id'), array_column($user_lists_for_level, 'level_id'));
        $user_member_name_arr                    = array_combine(array_column($user_lists_for_level, 'member_id'), array_column($user_lists_for_level, 'member_name'));


        // 将所有属于该邀请人邀请的供应商产生的销售利润组合到该邀请人下
        $add_money_arr        = [];
        $system_bonus_log_arr = [];
        $now_date             = date('Y-m-d H:i:s');

        $user_level_model           = new user_levelModel();
        $level_name                 = $user_level_model->where(['id' => ['in', $user_id_arr]])->field('id,level_name')->select();
        $user_member_level_name_arr = array_combine(array_column($level_name, 'id'), array_column($level_name, 'level_name'));


        foreach ($share_bonus_for_team_money_for_user_arr as $user_id => $total_money) {
            $remark_arr[]                                          = '当前会员 ID：' . $user_id;
            $remark_arr[]                                          = '当前会员名称：' . $user_member_name_arr[$user_id];
            $remark_arr[]                                          = '当前分红类型：' . $type_bonus;
            $remark_arr[]                                          = '当前分红类型名称：' . $user_bonus_model->getTypeInfo($type_bonus);
            $this_user_level_id                                    = $user_id_and_level_id[$user_id];
            $remark_arr[]                                          = '当前会员等级：' . $this_user_level_id;
            $remark_arr[]                                          = '当前会员等级名称：' . $user_member_level_name_arr[$user_id];
            $remark_arr[]                                          = '当前会员可获得的总奖金：' . $total_money;
            $system_bonus_log_arr[$user_id]['current_bonus_money'] = 0;
            $system_bonus_log_arr[$user_id]['to_user_id']          = $user_id;
            $system_bonus_log_arr[$user_id]['remark']              = implode('|', $remark_arr);
            unset($remark_arr);
            $system_bonus_log_arr[$user_id]['type']       = 2;
            $add_money_arr[$user_id]                      = $total_money;
            $system_bonus_log_arr[$user_id]['created_at'] = $now_date;
            $system_bonus_log_arr[$user_id]['bonus_type'] = $type_bonus;
            continue;
        }

        if (!empty($add_money_arr)) {
            // 生成系统日志
            if (!empty($system_bonus_log_arr)) {
                $system_bonus_log_model   = new system_bonus_logModel();
                $new_system_bonus_log_arr = array_values($system_bonus_log_arr);
                $system_bonus_log_model->insertAll($new_system_bonus_log_arr);
            }
            // 已分配的分红
//            $dividends_paid = array_sum($add_money_arr);
            // 将已分配的分红从平台利润中扣除(此分红不已经在订单完成时扣除了当前分红的金额，此处不能再次扣除)
//            $this->platformProfitDec($dividends_paid,$cycle_type);
            // 供应商奖金需要在当月统计之后的第四个月的十五号用户才能提取这笔钱
            // 此处先将这些钱放进用户资金池
            $this->addToMoneyPool($add_money_arr, $type_bonus);

        }
        return false;
    }

    // 分红
    public function addToMoneyPool($add_money_arr, $current_user_bonus_type = 1)
    {
        $user_bonus_model      = new user_bonusModel();
        $user_money_pool_model = new user_money_poolModel();
        // 供应商奖金需要在当月统计之后的第四个月的十五号用户才能提取这笔钱
        $arrival_at = date('Y-m-d H:i:s', strtotime(date('Y-m-15 H:i:s', strtotime('+3 month'))));
        $data       = [];
        $date       = date('Y-m-d H:i:s');
        foreach ($add_money_arr as $user_id => $money) {
            // 分红数组
            $data[$user_id]['from_user_id'] = 0;
            $data[$user_id]['to_user_id']   = $user_id;
            $data[$user_id]['money']        = $money;
            $data[$user_id]['created_at']   = $date;
            $data[$user_id]['arrival_at']   = $arrival_at;
            $data[$user_id]['type']         = $current_user_bonus_type;
        }
        if (!empty($data)) {
            Db::beginTransaction();
            $user_money_pool_model->insertAll(array_values($data));
            // 更新分红表中的分红时间
            $user_id          = array_keys($add_money_arr);
            $where['user_id'] = ['in', $user_id];
            $where['type']    = $current_user_bonus_type;
            $user_bonus_model->where($where)->update(['updated_at' => $this->getCurrentDate()]);
            Db::commit();
        }
    }

    // 将奖金池中今天要转给用户的钱转给指定用户
    public function addMoneyFromMoneyPool()
    {
        $user_money_pool_model = new user_money_poolModel();
        // 今天开始时间
        $current_begin_date = $this->getCurrentBeginDate();
        // 今天结束时间
        $current_end_date = $this->getCurrentEndDate();
        $add_money_arr    = $user_money_pool_model->where(['created_at' => ['between', [$current_begin_date, $current_end_date]]])->select();
        $pd_model         = new predepositModel();

        $user_bonus_log_model = new user_bonus_logModel();
        $user_bonus_log_data  = [];
        foreach ($add_money_arr as $key => $value) {
            // 分红数组
            $user_bonus_log_data[] = $user_bonus_log_model->getUserBonusLogDataArr(
                $value['to_user_id'],
                $value['type'],
                $value['money']
            );
        }
        Db::beginTransaction();
        // 分红日志
        $new_user_bonus_log_data = array_merge($user_bonus_log_data);
        $user_bonus_log_model->insertAll($new_user_bonus_log_data);
        p('分红日志');
        // 预存款变更日志
        $pd_log_data = $user_bonus_log_model->getPdLogDataArr($new_user_bonus_log_data);
        $pd_model->insertAll($pd_log_data);
        p('预存款变更日志');
        // 以用户id为单位获取每个用户需要更新的金额数组
        $user_update_balance_arr = $user_bonus_log_model->getUpdateUserBalance($new_user_bonus_log_data);
        // 预存款修改sql
        $sql = $user_bonus_log_model->getUpdateUserBalanceSQL($user_update_balance_arr);
        DB::execute($sql);
        p('预存款修改sql:' . $sql);

        Db::commit();
    }
}
