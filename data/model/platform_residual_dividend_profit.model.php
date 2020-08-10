<?php
/**
 * 会员模型
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class platform_residual_dividend_profitModel extends Model
{
    public function __construct()
    {
        parent::__construct('platform_residual_dividend_profit');
    }

    // 设置更新周期
    const UPDATE_FOR_DAY     = 1;
    const UPDATE_FOR_WEEKLY  = 7;
    const UPDATE_FOR_MONTHLY = 28;

    /*const UPDATE_FOR_DAY     = 1;
    const UPDATE_FOR_WEEKLY  = 2;// 每周一次(每周应该是7天，测试调整为2天，正式版本应该改回来7天)
    const UPDATE_FOR_MONTHLY = 4;// 每月一次(每月应该是28天，测试调整为4天，正式版本应该改回来28天)*/

    // 新增剩余利润
    public function checkLogUpdate($surplus_total_money)
    {
        p('*******************剩余利润统计结算入库开始*****************************');
        $user_bonus_logic        = Logic('user_bonus');
        $p_r_d_p_where           = sprintf(' (cycle = ' . self::UPDATE_FOR_DAY . ' AND created_at between "%s" AND "%s") ', $user_bonus_logic->getCurrentBeginDate(), $user_bonus_logic->getCurrentEndDate());
        $p_r_d_p_where           .= sprintf(' OR (cycle = ' . self::UPDATE_FOR_WEEKLY . ' AND created_at between "%s" AND "%s") ', $user_bonus_logic->getCurrentWeeklyBeginDate(), $user_bonus_logic->getCurrentWeeklyEndDate());
        $p_r_d_p_where           .= sprintf(' OR (cycle = ' . self::UPDATE_FOR_MONTHLY . ' AND created_at between "%s" AND "%s") ', $user_bonus_logic->getCurrentMonthBeginDate(), $user_bonus_logic->getCurrentMonthEndDate());
        $p_r_d_p_result          = $this->where($p_r_d_p_where)->select();
        $new_surplus_total_money = $surplus_total_money;
        // 如果是首次更新
        if (empty($p_r_d_p_result)) {
            $data_arr[]  = $this->getNeedUpdateLogArr(self::UPDATE_FOR_DAY, $new_surplus_total_money);
            $data_arr[]  = $this->getNeedUpdateLogArr(self::UPDATE_FOR_WEEKLY, $new_surplus_total_money);
            $data_arr[]  = $this->getNeedUpdateLogArr(self::UPDATE_FOR_MONTHLY, $new_surplus_total_money);
            $insert_data = array_merge($data_arr);
            $this->insertAll($insert_data);
            return false;
        }
        // 获取所有记录类型
        $cycle_type_arr = [self::UPDATE_FOR_DAY, self::UPDATE_FOR_WEEKLY, self::UPDATE_FOR_MONTHLY];
        // 获取已经存在的记录类型
        $existence_cycle_arr = array_column($p_r_d_p_result, 'cycle');
        // 获取需要更新的记录id
        $need_update_id_arr = array_column($p_r_d_p_result, 'id');
        $this->where(['id' => ['in', $need_update_id_arr]])->setInc('money', $new_surplus_total_money);
        // 获取需要新增的类型
        $diff_cycle_arr = array_diff($cycle_type_arr, $existence_cycle_arr);
        // 如果全部都已经存在，则不需要新增加记录
        if (empty($diff_cycle_arr)) {
            return false;
        }
        $diff_data_arr = [];
        foreach ($diff_cycle_arr as $key => $value) {
            $diff_data_arr[] = $this->getNeedUpdateLogArr($value, $new_surplus_total_money);
        }
        if (!empty($diff_data_arr)) {
            $this->insertAll($diff_data_arr);
        }
        return false;
    }

    // 分红扣除利润
    public function deductSurplusProfit($deduction_money, $cycle_type)
    {
        $user_bonus_logic = Logic('user_bonus');
        $where            = $this->getUpdateWhereArr($cycle_type);
        // 获取满足条件的日志
        $p_r_d_p_result          = $this->where($where)->select();
        $new_surplus_total_money = $deduction_money;
        // 如果获取的信息是天
        // 如果是首次更新，没有利润，所以直接不分红
        if (empty($p_r_d_p_result)) {
            return false;
        }

        if ($cycle_type == self::UPDATE_FOR_DAY) {
            // 昨天的开始和结束时间
            $begin_at = $user_bonus_logic->getYesterdayBeginAt();
            $day_date = $this->getYesterdayBeginAndEndDate();
            // 获取昨天所在的周和月
            $week_date  = $this->getWeeklyBeginAndEndDate($begin_at);
            $month_date = $this->getMonthBeginAndEndDate($begin_at);
        } else if ($cycle_type == self::UPDATE_FOR_WEEKLY) {
            // 如果是周分红，就获取今天所在日期的上周开始结束时间和上月开始结束时间
            $week_date  = [$user_bonus_logic->getLastWeeklyBeginDate(), $user_bonus_logic->getLastWeeklyEndDate()];
            $month_date = [$user_bonus_logic->getLastMonthBeginDate(), $user_bonus_logic->getLastMonthEndDate()];
        } else if ($cycle_type == self::UPDATE_FOR_MONTHLY) {
            // 如果是月分红，就获取今天所在日期的上月开始结束时间
            $month_date = [$user_bonus_logic->getLastMonthBeginDate(), $user_bonus_logic->getLastMonthEndDate()];
        }
        Db::beginTransaction();
        // 减利润
        if (isset($day_date)) {
            $this->where(['created_at' => ['between', $day_date], 'cycle' => self::UPDATE_FOR_DAY])->setDec('money', $new_surplus_total_money);
        }
        if (isset($week_date)) {
            $this->where(['created_at' => ['between', $week_date], 'cycle' => self::UPDATE_FOR_WEEKLY])->setDec('money', $new_surplus_total_money);
        }
        if (isset($month_date)) {
            $this->where(['created_at' => ['between', $month_date], 'cycle' => self::UPDATE_FOR_MONTHLY])->setDec('money', $new_surplus_total_money);
        }
        Db::commit();
        return true;
    }


    public function getNeedUpdateLogArr($cycle, $money)
    {
        $user_bonus_logic = Logic('user_bonus');
        switch ($cycle) {
            case self::UPDATE_FOR_DAY:
                $begin_at = $user_bonus_logic->getCurrentBeginDate();
                $end_at   = $user_bonus_logic->getCurrentEndDate();
                break;
            case self::UPDATE_FOR_WEEKLY:
                $begin_at = $user_bonus_logic->getCurrentWeeklyBeginDate();
                $end_at   = $user_bonus_logic->getCurrentWeeklyEndDate();
                break;
            case self::UPDATE_FOR_MONTHLY:
                $begin_at = $user_bonus_logic->getCurrentMonthBeginDate();
                $end_at   = $user_bonus_logic->getCurrentMonthEndDate();
                break;
        }
        $created_at             = $user_bonus_logic->getCurrentDate();
        $updated_at             = $user_bonus_logic->getCurrentDate();
        $arr_data['money']      = $money;
        $arr_data['begin_at']   = $begin_at;
        $arr_data['end_at']     = $end_at;
        $arr_data['created_at'] = $created_at;
        $arr_data['updated_at'] = $updated_at;
        $arr_data['cycle']      = $cycle;
        return $arr_data;
    }

    public function getUpdateWhereArr($cycle)
    {
        $user_bonus_logic = Logic('user_bonus');
        switch ($cycle) {
            case self::UPDATE_FOR_DAY:
                $begin_at = $user_bonus_logic->getYesterdayBeginAt();
                $end_at   = $user_bonus_logic->getYesterdayEndAt();
                break;
            case self::UPDATE_FOR_WEEKLY:
                $begin_at = $user_bonus_logic->getLastWeeklyBeginDate();
                $end_at   = $user_bonus_logic->getLastWeeklyEndDate();
                break;
            case self::UPDATE_FOR_MONTHLY:
                $begin_at = $user_bonus_logic->getLastMonthBeginDate();
                $end_at   = $user_bonus_logic->getLastMonthEndDate();
                break;
        }

        //$arr_data['begin_at'] = $begin_at;
        //$arr_data['end_at'] = $end_at;
        //$arr_data['cycle'] = $cycle;

        $arr_data['created_at'] = ['between', [$begin_at, $end_at]];
        $arr_data['cycle']      = $cycle;
        return $arr_data;
    }

    public function getYesterdayBeginAndEndDate()
    {
        $user_bonus_logic = Logic('user_bonus');
        $begin_at         = $user_bonus_logic->getYesterdayBeginAt();
        $end_at           = $user_bonus_logic->getYesterdayEndAt();
        return [$begin_at, $end_at];
    }


    // 获取指定日期所在周开始和结束时间
    public function getWeeklyBeginAndEndDate($date, $start = 1)
    {
        $timestamp = strtotime($date);
        // 获取日期是周几
        $day = date("w", $timestamp);
        // 计算开始日期
        if ($day >= $start) {
            $start_date_timestamp = mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp) - ($day - $start), date('Y', $timestamp));
        } elseif ($day < $start) {
            $start_date_timestamp = mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp) - 7 + $start - $day, date('Y', $timestamp));
        }
        // 结束日期=开始日期+6
        $end_date_timestamp = mktime(23, 59, 59, date('m', $start_date_timestamp), date('d', $start_date_timestamp) + 6, date('Y', $start_date_timestamp));
        $start_date         = date('Y-m-d H:i:s', $start_date_timestamp);
        $end_date           = date('Y-m-d H:i:s', $end_date_timestamp);
        return [$start_date, $end_date];
    }


    // 获取指定日期所在月开始和结束时间
    public function getMonthBeginAndEndDate($date)
    {
        $timestamp  = strtotime($date);
        $month_days = date('t', $timestamp);
        $start_date = date('Y-m-1 00:00:00', $timestamp);
        $end_date   = date('Y-m-' . $month_days . ' 23:59:59', $timestamp);
        return [$start_date, $end_date];
    }
}
