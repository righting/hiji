<?php
/**
 * 活动
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class user_levelModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_level');
    }

    // 设置会员等级
    const LEVEL_ZERO  = 7;    // 普通用户
    const LEVEL_ONE   = 1;    // 免费会员
    const LEVEL_TWO   = 2;    // 银尊VIP
    const LEVEL_THREE = 3;  // 金尊VIP
    const LEVEL_FOUR  = 4;   // 帝尊VIP
    const LEVEL_FIVE  = 5;   // 天尊VIP
    const LEVEL_SIX   = 6;    // 至尊VIP

    // 获取level_id对应的等级信息
    public function getLevelInfoForLevelId($level_id = '')
    {
        $level_id_arr = [
            self::LEVEL_ZERO  => '普通用户',
            self::LEVEL_ONE   => '免费会员',
            self::LEVEL_TWO   => '银尊VIP',
            self::LEVEL_THREE => '金尊VIP',
            self::LEVEL_FOUR  => '帝尊VIP',
            self::LEVEL_FIVE  => '天尊VIP',
            self::LEVEL_SIX   => '至尊VIP',
        ];
        return isset($level_id_arr[$level_id]) ? $level_id_arr[$level_id] : $level_id_arr;
    }

    //获取所有会员等级信息
    public function getLevelAll($where = [], $field = '*')
    {
        return $this->where($where)->field($field)->select();
    }

    // 根据经验获取等级信息
    public function getLevelInfo($exp)
    {
        $where['exp'] = ['EGT', $exp];
        if (intval($exp) == 0) {
            $where['exp'] = 0;
        }
        // 获取最高等级的会员信息，如果经验值大于最高等级的会员信息，那么返回最高等级的会员信息
        $highest_level_info = $this->order('exp desc')->find();
        if (bccomp($exp, $highest_level_info['exp']) == 1) {
            return $highest_level_info;
        }
        $info = $this->where($where)->order('exp asc')->find();
        return $info;
    }

    // 根据经验获取等级信息
    public function FindLevelInfo($where = [], $order = 'id desc')
    {
        $info = $this->where($where)->order($order)->find();
        return $info;
    }

    // 根据经验获取等级信息（不查询数据库）
    public function getUserLevelInfo($exp_arr, $exp = 0)
    {
        $exp_info = [];

        foreach ($exp_arr as $key => $value) {
            if ($exp >= $value['exp'] && $exp < $exp_arr[$key + 1]['exp']) {
                $exp_info = $value;
                break;
            }
        }
        // 获取最后一个等级的经验值
        $highest_level_info = end($exp_arr);
        if (bccomp($exp, $highest_level_info['exp']) == 1) {
            return $highest_level_info['id'];
        }
        return $exp_info['id'];
    }


    // 计算各等级人头数
    public function getUserHeadcountForLevel($user_arr, $begin_id)
    {
        // 需要处理的各等级的人数
        $new_user_count_arr = [];
        foreach ($user_arr as $id => $count) {
            // 当前职级之前的所有职级
            $new_arr               = $this->getPreviousArr($id, $begin_id);
            $now_position_arr[$id] = $new_arr;
            foreach ($new_arr as $new_id => $new_position_count) {
                $new_user_count_arr[$new_id][$id] = $count;
            }
        }
        $user_count_arr = [];
        foreach ($new_user_count_arr as $k => $v) {
            $user_count_arr[$k] = array_sum($v);   // 每个级别对应的人头数
        }
        return $user_count_arr;
    }

    /**
     * 计算各等级每份分红的金额
     * @param        $user_count_for_level // 各职级的人头数  等级=>人头数
     * @param        $total_money          // 当前分配类型可分配的总利润
     * @param string $rate_name            // 获取比例的类型名称
     * @return array
     */
    public function getEachMoneyForPosition($user_count_for_level, $total_money, $rate_name = 'sales_bonus_for_day')
    {
        // 计算各等级每份分红的金额
        $each_money_arr = [];
        foreach ($user_count_for_level as $level_id => $head_count) {
            // 各职级可分配的利润
            $rate_info = $this->getBonusRate($level_id);
            $rate      = $rate_info[$rate_name];
            $profit    = $this->getEachLevelMoney($total_money, $rate);
            if ($head_count == 0) {
                $each_money_arr[$level_id] = 0;
            } else {
                $each_money_arr[$level_id] = bcdiv($profit, $head_count, 2);
            }
        }
        return $each_money_arr;
    }

    /**
     * 计算各级可分配的利润
     * @param $total_money // 当前分配类型可分配的总利润
     * @param $rate        // 比例
     * @return string
     */
    public function getEachLevelMoney($total_money, $rate)
    {
        // 当前职级可分配的利润
        $this_money = bcdiv(bcmul($total_money, $rate, 2), 100, 2);
        return $this_money;
    }

    // 根据指定等级的id获取开始等级到该等级之间的所有等级
    public function getPreviousArr($id, $begin_id)
    {
        // 获取所有等级
        $arr = $this->getLevelIdArr();
        // 获取开始等级在所有等级中的位置
        $begin_length = array_keys(array_values($arr), $this->getLevelIdArr($begin_id));
        // 获取当前等级在所有等级级中的位置
        $this_location = array_keys(array_values($arr), $this->getLevelIdArr($id));
        $length        = 0;
        if ($this_location[0] > $begin_length[0]) {
            $length = bcsub($this_location[0], $begin_length[0]);
        }
        $new_arr = [];
        if ($length >= 0) {
            $new_arr = array_slice($arr, $begin_length[0], bcadd($length, 1), true);
        }
        return $new_arr;
    }

    // 获取等级id对应等级的数组
    public function getLevelIdArr($level_id = '')
    {
        $level_arr = [
            self::LEVEL_ZERO  => 0,
            self::LEVEL_ONE   => 1,
            self::LEVEL_TWO   => 2,
            self::LEVEL_THREE => 3,
            self::LEVEL_FOUR  => 4,
            self::LEVEL_FIVE  => 5,
            self::LEVEL_SIX   => 6,
        ];
        return isset($level_arr[$level_id]) ? $level_arr[$level_id] : $level_arr;
    }

    // 获取各等级id对应的各种分红的比例(单位：%)
    public function getBonusRate($level_id = '')
    {
        $arr = [
            // 普通用户
            self::LEVEL_ZERO  => [
                'sales_bonus_for_day' => 0,
            ],
            // 免费会员
            self::LEVEL_ONE   => [
                'sales_bonus_for_day' => 0,
            ],
            // 银尊VIP
            self::LEVEL_TWO   => [
                'sales_bonus_for_day'                                  => 20,
                'type_consumption_capital_subsidy_consumption_pension' => 1,
                'type_consumption_capital_subsidy_garages_dream'       => 1,
            ],
            // 金尊VIP
            self::LEVEL_THREE => [
                'sales_bonus_for_day'                                  => 20,
                'type_consumption_capital_subsidy_consumption_pension' => 2,
                'type_consumption_capital_subsidy_garages_dream'       => 2,
            ],
            // 帝尊VIP
            self::LEVEL_FOUR  => [
                'sales_bonus_for_day'                                  => 20,
                'type_consumption_capital_subsidy_consumption_pension' => 3,
                'type_consumption_capital_subsidy_garages_dream'       => 3,
            ],
            // 天尊VIP
            self::LEVEL_FIVE  => [
                'sales_bonus_for_day'                                  => 20,
                'type_consumption_capital_subsidy_consumption_pension' => 4,
                'type_consumption_capital_subsidy_garages_dream'       => 4,
            ],
            // 至尊VIP
            self::LEVEL_SIX   => [
                'sales_bonus_for_day'                                  => 20,
                'type_consumption_capital_subsidy_consumption_pension' => 5,
                'type_consumption_capital_subsidy_garages_dream'       => 5,
            ],
        ];
        return isset($arr[$level_id]) ? $arr[$level_id] : $arr;
    }

    /**
     * 获取用户升级到最高级会员所需积分总和
     * @param $member_id
     * @return mixed
     */
    public function upMaxGradeTotalPoints($member_id)
    {
        $member     = Model('member')->field('level_id')->where(['member_id' => $member_id])->find();
        $user_level = $this->where(['id' => $member['level_id']])->find();
        $point_sum  = $this->field('point')->where(['level' => ['GT', $user_level['level']]])->sum('point');
        return $point_sum;
    }
}
