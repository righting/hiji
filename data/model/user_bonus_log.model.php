<?php
/**
 * 活动
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class user_bonus_logModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_bonus_log');
    }

    // 设置分红类型
    const TYPE_SALES_DAY_BONUS                = 1; // 销售日分红
    const TYPE_SELLING_STAR_DAY_BONUS         = 2; // 销售明星日分红
    const TYPE_SHARE_DAY_BONUS_FOR_NEW        = 3; // 共享日分红-新注册会员
    const TYPE_SHARE_DAY_BONUS_FOR_OLD        = 4; // 共享日分红-老会员
    const TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY = 5; // 中层管理周分红
    const TYPE_BLACK_DIAMOND_SALES_BONUS      = 6; // 至尊销售月分红
    const TYPE_ELITE_MONTHLY_BONUS            = 7; // 销售精英月分红
    const TYPE_TOP_SELLING_MONTHLY_BONUS      = 8; // 高层销售月分红
    const TYPE_NEW_SALES_AWARD                = 9; // 销售新人奖
    const TYPE_SHARE_DAY_BONUS                = 10; // 共享日分红
    const TYPE_SALES_MANAGEMENT_WEEK_BONUS    = 11; // 销售管理普惠周奖金
    const TYPE_SUPPLIER_REFERRAL_BONUS        = 12; // 供应商推荐奖金

    const TYPE_SUPPLY_MONEY                 = 13; // 供货款（转给店铺的商品供货款）
    const TYPE_SUPPLY_FREIGHT               = 14; // 商品运费（转给店铺的商品运费）
    const TYPE_CORPORATE_PROFITS            = 15; // 平台利润（当前商品的税前总销售利润*20%）
    const TYPE_TAX_RATE_MONEY               = 16; // 销售服务税（税前销售利润*销售服务税率）
    const TYPE_SALES_SHARE_BONUS            = 17; // 个人消费分红
    const TYPE_SALES_SHARE_BONUS_FOR_TEAM   = 18; // 团队销售分享分红
    const TYPE_SALES_SHARE_BONUS_FOR_SELLER = 19; // 个人微商销售分红
    const TYPE_SURPLUS_TOTAL_MONEY          = 20; // 剩余可分红利润

    const TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION = 21; // 消费资本补贴-消费养老补贴
    const TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM       = 22; // 消费资本补贴-车房梦想补贴


    // 设置分红频率
    const FREQUENCY_FOR_DAY    = 1; // 每天一次
    const FREQUENCY_FOR_WEEKLY = 7; // 每周一次
    const FREQUENCY_FOR_MONTH  = 28; // 每月一次

    /*const FREQUENCY_FOR_DAY    = 1; // 每天一次
    const FREQUENCY_FOR_WEEKLY = 2; // 每周一次(测试每周2天，正式每周7天)
    const FREQUENCY_FOR_MONTH  = 4; // 每月一次(测试每月4天，正式每周28天)*/

    // 获取指定分红类型
    public function getLogType($type = '')
    {
        $type_arr = [
            self::TYPE_SALES_SHARE_BONUS              => '消费普惠分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_TEAM     => '团队/消费共享分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_SELLER   => '个人微商/消费共享分红',
            self::TYPE_NEW_SALES_AWARD                => '新人普惠分红',
            self::TYPE_SALES_DAY_BONUS                => '消费日分红',
            self::TYPE_SELLING_STAR_DAY_BONUS         => '消费明星日分红',
            self::TYPE_SHARE_DAY_BONUS                => '共享日分红',
            self::TYPE_SALES_MANAGEMENT_WEEK_BONUS    => '管理普惠周奖',
            self::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY => '中层管理周分红',
            self::TYPE_BLACK_DIAMOND_SALES_BONUS      => '至尊消费月分红',
            self::TYPE_ELITE_MONTHLY_BONUS            => '消费精英月分红',
            self::TYPE_TOP_SELLING_MONTHLY_BONUS      => '高层消费月分红',
            self::TYPE_SUPPLIER_REFERRAL_BONUS        => '供应商推荐奖金',

            self::TYPE_SUPPLY_MONEY        => '供货款',
            self::TYPE_SUPPLY_FREIGHT      => '商品运费',
            self::TYPE_CORPORATE_PROFITS   => '平台利润',
            self::TYPE_TAX_RATE_MONEY      => '销售服务税',
            self::TYPE_SURPLUS_TOTAL_MONEY => '剩余可分红利润',

            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION => '消费资本补贴-消费养老补贴',
            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM       => '消费资本补贴-车房梦想补贴',
        ];
        return isset($type_arr[$type]) ? $type_arr[$type] : $type_arr;
    }

    // 获取需要加入消费资本计算的分红类型
    public function getSubsidyLogType($type = '')
    {
        // 7 8 11 12
        $type_arr = [
            self::TYPE_SALES_SHARE_BONUS            => '个人消费分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_TEAM   => '团队/消费共享分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_SELLER => '个人微商/消费共享分红',
            self::TYPE_NEW_SALES_AWARD              => '消费新人奖',
            self::TYPE_SALES_DAY_BONUS              => '消费日分红',
            self::TYPE_SELLING_STAR_DAY_BONUS       => '消费明星日分红',
            self::TYPE_SHARE_DAY_BONUS              => '共享日分红',
            self::TYPE_BLACK_DIAMOND_SALES_BONUS    => '至尊消费月分红',
            self::TYPE_ELITE_MONTHLY_BONUS          => '消费精英月分红'
        ];
        return isset($type_arr[$type]) ? $type_arr[$type] : $type_arr;
    }

    /**
     * 即时结算类
     * TYPE_SALES_SHARE_BONUS = 17; // 个人消费分红
     * TYPE_SALES_SHARE_BONUS_FOR_TEAM = 18; // 团队销售分享分红
     * TYPE_SALES_SHARE_BONUS_FOR_SELLER = 19; // 个人微商销售分红
     * 日分红类
     * TYPE_SALES_DAY_BONUS = 1; // 销售/消费日分红
     * TYPE_SELLING_STAR_DAY_BONUS = 2; // 销售明星日分红
     * TYPE_SHARE_DAY_BONUS_FOR_NEW = 3; // 共享日分红-新注册会员
     * TYPE_SHARE_DAY_BONUS_FOR_OLD = 4; // 共享日分红-老会员
     * 周分红类
     * TYPE_SALES_MANAGEMENT_WEEK_BONUS = 11; // 销售管理普惠周奖金
     * TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY = 5; // 中层管理周分红
     * 月分红类
     * TYPE_SUPPLIER_REFERRAL_BONUS = 12; // 供应商推荐奖金
     * TYPE_NEW_SALES_AWARD  = 9; // 销售新人奖
     * TYPE_BLACK_DIAMOND_SALES_BONUS = 6; // 至尊消费月分红
     * TYPE_ELITE_MONTHLY_BONUS = 7; // 销售精英月分红
     * TYPE_TOP_SELLING_MONTHLY_BONUS = 8; // 高层销售月分红
     */


    /**
     * @param string $type
     * @return array|mixed
     */
    public function getTypeInfo($type = '')
    {
        $type_arr = [
            self::TYPE_SALES_DAY_BONUS                                 => '销售日分红',
            self::TYPE_SELLING_STAR_DAY_BONUS                          => '销售明星日分红',
            self::TYPE_SHARE_DAY_BONUS_FOR_NEW                         => '共享日分红',
            self::TYPE_SHARE_DAY_BONUS_FOR_OLD                         => '共享日分红',
            self::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY                  => '中层管理周分红',
            self::TYPE_BLACK_DIAMOND_SALES_BONUS                       => '至尊销售月分红',
            self::TYPE_ELITE_MONTHLY_BONUS                             => '销售精英月分红',
            self::TYPE_TOP_SELLING_MONTHLY_BONUS                       => '高层销售月分红',
            self::TYPE_NEW_SALES_AWARD                                 => '销售新人奖',
            self::TYPE_SHARE_DAY_BONUS                                 => '共享日分红',
            self::TYPE_SALES_MANAGEMENT_WEEK_BONUS                     => '销售管理普惠周奖金',
            self::TYPE_SUPPLIER_REFERRAL_BONUS                         => '供应商推荐奖金',
            self::TYPE_SUPPLY_MONEY                                    => '商品供货款',
            self::TYPE_SUPPLY_FREIGHT                                  => '商品运费',
            self::TYPE_CORPORATE_PROFITS                               => '平台利润',
            self::TYPE_TAX_RATE_MONEY                                  => '销售服务税',
            self::TYPE_SALES_SHARE_BONUS                               => '个人消费分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_TEAM                      => '团队销售分享分红',
            self::TYPE_SALES_SHARE_BONUS_FOR_SELLER                    => '个人微商销售分红',
            self::TYPE_SURPLUS_TOTAL_MONEY                             => '剩余可分红利润',
            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION => '消费资本补贴-消费养老补贴',
            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM       => '消费资本补贴-车房梦想补贴',
        ];
        return isset($type_arr[$type]) ? $type_arr[$type] : $type_arr;
    }

    /**获取用户分红记录
     *
     * @param $user_id
     * @param $limit
     * @return mixed
     */
    public function getUserBonusLogList($user_id, $limit = null)
    {
        $data = $this->where(['user_id' => $user_id])->order('id desc')->page(15)->select();
        if (empty($data))
            return false;
        foreach ($data as &$val) {
            $val['cn_type'] = $this->getTypeInfo($val['type']);
        }
        unset($val);
        return $data;
    }

    /**统计用户分红
     *
     * @param $where
     * @param $data
     * @return bool
     */
    public function countUserBonus($where = [])
    {
        $member_id = $_SESSION['member_id'];
        empty($where) ? $where['user_id'] = $member_id : $where;
        $data    = $this->field('type,sum(money) as money')->where($where)->group('type')->select();
        $mybonus = [ //初始化数组
            self::TYPE_SALES_DAY_BONUS                => 0,
            self::TYPE_SELLING_STAR_DAY_BONUS         => 0,
            self::TYPE_SHARE_DAY_BONUS_FOR_NEW        => 0,
            self::TYPE_SHARE_DAY_BONUS_FOR_OLD        => 0,
            self::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY => 0,
            self::TYPE_BLACK_DIAMOND_SALES_BONUS      => 0,
            self::TYPE_ELITE_MONTHLY_BONUS            => 0,
            self::TYPE_TOP_SELLING_MONTHLY_BONUS      => 0,
            self::TYPE_NEW_SALES_AWARD                => 0,
            self::TYPE_SHARE_DAY_BONUS                => 0,
            self::TYPE_SALES_MANAGEMENT_WEEK_BONUS    => 0,
            self::TYPE_SUPPLIER_REFERRAL_BONUS        => 0,
            self::TYPE_SUPPLY_MONEY                   => 0,
            self::TYPE_SUPPLY_FREIGHT                 => 0,
            self::TYPE_CORPORATE_PROFITS              => 0,
            self::TYPE_TAX_RATE_MONEY                 => 0,
            self::TYPE_SALES_SHARE_BONUS              => 0,
            self::TYPE_SALES_SHARE_BONUS_FOR_TEAM     => 0,
            self::TYPE_SALES_SHARE_BONUS_FOR_SELLER   => 0,
            self::TYPE_SURPLUS_TOTAL_MONEY            => 0
        ];
        foreach ($data as $v) {
            $mybonus[$v['type']] = $v['money'];
        }
        return $mybonus;
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
        $type_arr = $this->getTypeInfo();
        $data     = [];
        foreach ($new_user_bonus_log_data as $key => $value) {
            $data[$key]['lg_member_id']     = $value['user_id'];    // 用户id
            $data[$key]['lg_type']          = $value['type'];            // 类型
            $data[$key]['lg_freeze_amount'] = $value['money'];  // 金额
            $data[$key]['lg_add_time']      = time();                // 添加时间
            $data[$key]['lg_desc']          = $type_arr[$value['type']]; // 描述
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
        $total_money_arr = [];
        $sql             = 'UPDATE ' . $table_name . ' SET ' . $field . ' = CASE ' . $case_field;
        foreach ($user_update_balance_arr as $key => $value) {
            $this_money = array_sum($value);
            if ($this_money > 0) {
                $sql .= ' WHEN ' . $key . ' THEN ' . $field . '+' . array_sum($value);
            }
            $total_money_arr[] = $this_money;
            unset($this_money);
        }
        $sql .= ' else ' . $field . ' END';
//        $sql .= ' END';
        $total_money = array_sum($total_money_arr);
        if ($total_money > 0) {
            return $sql;
        }
        return '';
    }

    /**
     * 获取数量
     *
     * @param mixed $condition
     * @return int
     */
    public function getCount($condition)
    {
        return $this->where($condition)->count();
    }
}
