<?php
/**
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class positionsModel extends Model
{
    public function __construct()
    {
        parent::__construct('positions');
    }

    const POSITIONS_SME  = 1;     // 高级主管
    const POSITIONS_SNA  = 2;     // 资深主管
    const POSITIONS_RM   = 3;     // 市场主任
    const POSITIONS_MM   = 4;     // 市场经理
    const POSITIONS_MD   = 5;     // 市场总监
    const POSITIONS_GM   = 6;     // 市场总经理
    const POSITIONS_VPM  = 7;     // 市场副总裁
    const POSITIONS_ZERO = 8;     // 无职级


    /*const POSITIONS_SME = 1;     // 高级主管
    const POSITIONS_SNA = 2;    // 资深主管
    const POSITIONS_RM = 3;    // 销售主任
    const POSITIONS_MM = 4;    // 销售经理
    const POSITIONS_MD = 5;    // 销售总监
    const POSITIONS_GM = 6;     // 销售总经理
    const POSITIONS_VPM = 7;    // 销售副总裁
    const POSITIONS_ZERO = 8;    // 无职级*/

    public function getPositionInfo($position_id = '')
    {
        $position_arr = [
            self::POSITIONS_SME  => '高级主管',
            self::POSITIONS_SNA  => '资深主管',
            self::POSITIONS_RM   => '销售主任',
            self::POSITIONS_MM   => '销售经理',
            self::POSITIONS_MD   => '销售总监',
            self::POSITIONS_GM   => '销售总经理',
            self::POSITIONS_VPM  => '销售副总裁',
            self::POSITIONS_ZERO => '无职级',
        ];
        return isset($position_arr[$position_id]) ? $position_arr[$position_id] : $position_arr;
    }

    /**获取所有职务记录
     * @return mixed
     */
    public function getPositionAll()
    {
        $new  = [];
        $data = $this->where()->select();
        if (!empty($data)) {
            foreach ($data as $val) {
                $new[$val['level']] = $val;
            }
        }
        return $new;
    }

    // 根据用户职级，计算该职级占用的销售主任的人数
    public function getUserPositionCountForRSC($position_type = self::POSITIONS_RM)
    {
        switch ($position_type) {
            case self::POSITIONS_RM:
                $user_count = 1;
                break;
            case self::POSITIONS_MM:
                $user_count = 2;
                break;
            case self::POSITIONS_MD:
                $user_count = 3;
                break;
            case self::POSITIONS_GM:
                $user_count = 4;
                break;
            case self::POSITIONS_VPM:
                $user_count = 5;
                break;
            default:
                $user_count = 0;
                break;
        }
        return $user_count;
    }

    // 根据用户职级，计算该职级占用的销售主任的人数
    public function getUserPositionCountForSSA($position_type = self::POSITIONS_SNA)
    {
        switch ($position_type) {
            case self::POSITIONS_SNA:
                $user_count = 1;
                break;
            case self::POSITIONS_RM:
                $user_count = 2;
                break;
            case self::POSITIONS_MM:
                $user_count = 3;
                break;
            case self::POSITIONS_MD:
                $user_count = 4;
                break;
            case self::POSITIONS_GM:
                $user_count = 5;
                break;
            case self::POSITIONS_VPM:
                $user_count = 6;
                break;
            default:
                $user_count = 0;
                break;
        }
        return $user_count;
    }

    // 根据职级获取职级对应的分红比例
    public function getUserPositionBonusRate($position_type = '')
    {
        $arr = [
            // 高级主管
            self::POSITIONS_SME => [
                'middle_management_bonus_weekly'   => 0,
                'black_diamond_sales_bonus'        => 0,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 资深主管
            self::POSITIONS_SNA => [
                'middle_management_bonus_weekly'   => 0,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售主任
            self::POSITIONS_RM  => [
                'middle_management_bonus_weekly'   => 0.4,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售经理
            self::POSITIONS_MM  => [
                'middle_management_bonus_weekly'   => 0.4,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售总监
            self::POSITIONS_MD  => [
                'middle_management_bonus_weekly'   => 0.4,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 3,
                'top_selling_monthly_bonus_for_hi' => 2,
            ],
            // 销售总经理
            self::POSITIONS_GM  => [
                'middle_management_bonus_weekly'   => 0.4,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 1.5,
                'top_selling_monthly_bonus_for_hi' => 0.5,
            ],
            // 销售副总裁
            self::POSITIONS_VPM => [
                'middle_management_bonus_weekly'   => 0.4,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0.7,
                'top_selling_monthly_bonus_for_hi' => 0.3,
            ],
        ];
        return isset($arr[$position_type]) ? $arr[$position_type] : $arr;
    }

    /**
     * 获取会员职务信息
     * @return mixed
     */
    public function getMyPositions()
    {
        $user_id = $_SESSION['member_id'];
        if (empty($user_id))
            return false;
        $model_member = Model('member');
        $member_info  = $model_member->getMemberInfoByID($user_id);//获取缓存会员信息

        $positions_arr = $this->where()->select();
        $arr           = [];
        foreach ($positions_arr as $val) {
            if ($member_info['positions_id'] == $val['id']) {
                $arr = $val;
            }
            if ($val['level'] == $arr['level'] + 1) {
                $arr['nextgradename'] = $val['title'];
            }
        }

        $data = Model('register_invite')->where(['from_user_id' => $user_id])->select();

        $detail['m_total'] = count($data);
        $arr['detail']     = array_filter($detail);

        return $arr;
    }


    // 计算各等级人头数
    public function getUserHeadcountForPositions($user_arr, $begin_id)
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
    public function getEachMoneyForPosition($user_count_for_level, $total_money, $rate_name = 'middle_management_bonus_weekly')
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
        // 获取所有职级
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
            self::POSITIONS_ZERO => 0,
            self::POSITIONS_SME  => 1,
            self::POSITIONS_SNA  => 2,
            self::POSITIONS_RM   => 3,
            self::POSITIONS_MM   => 4,
            self::POSITIONS_MD   => 5,
            self::POSITIONS_GM   => 6,
            self::POSITIONS_VPM  => 7,
        ];
        return isset($level_arr[$level_id]) ? $level_arr[$level_id] : $level_arr;
    }

    // 获取各职级id对应的各种分红的比例(单位：%)
    public function getBonusRate($position_type = '')
    {
        $arr = [
            // 高级主管
            self::POSITIONS_SME => [
                'middle_management_bonus_weekly'   => 0,
                'black_diamond_sales_bonus'        => 0,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 资深主管
            self::POSITIONS_SNA => [
                'middle_management_bonus_weekly'   => 0,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售主任
            self::POSITIONS_RM  => [
                'middle_management_bonus_weekly'   => 20,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售经理
            self::POSITIONS_MM  => [
                'middle_management_bonus_weekly'   => 20,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 0,
                'top_selling_monthly_bonus_for_hi' => 0,
            ],
            // 销售总监
            self::POSITIONS_MD  => [
                'middle_management_bonus_weekly'   => 20,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 37.5,
                'top_selling_monthly_bonus_for_hi' => 25,
            ],
            // 销售总经理
            self::POSITIONS_GM  => [
                'middle_management_bonus_weekly'   => 20,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 18.75,
                'top_selling_monthly_bonus_for_hi' => 6.25,
            ],
            // 销售副总裁
            self::POSITIONS_VPM => [
                'middle_management_bonus_weekly'   => 20,
                'black_diamond_sales_bonus'        => 0.5,
                'top_selling_monthly_bonus'        => 8.75,
                'top_selling_monthly_bonus_for_hi' => 3.75,
            ],
        ];
        return isset($arr[$position_type]) ? $arr[$position_type] : $arr;
    }

    /**
     * 晋升单个用户职务
     */
    public function positionsUpgrade()
    {

    }

    /**
     * 批量晋升职务
     * @param array $member_data
     */
    public function positionsUpgradeAll($member_data = [])
    {
        $positions_info = $this->where()->select();//获取职务信息
        $data           = array_column($positions_info, 'level', 'id');
        $positions_info = array_column($positions_info, 'title', 'id');
        $ids            = implode(',', array_keys($member_data));

        //获取所有晋级会员记录
        $member_list    = Model('member')->getMemberList(['member_id' => ['in', $ids]], 'member_id,member_number,positions_id');
        $member_numbers = array_column($member_list, 'member_number', 'member_id');
        $member_list    = array_column($member_list, 'positions_id', 'member_id');

        //获取所有晋级人的推荐人
        $inviteArrs       = Model('register_invite')->where(['to_user_id' => ['in', $ids]])->select();
        $inviteArrs       = array_column($inviteArrs, 'from_user_id', 'to_user_id');
        $contribution_log = Model('contribution_log');
        $c                = [self::POSITIONS_SME => 1, self::POSITIONS_SNA => 2, self::POSITIONS_RM => 6, self::POSITIONS_MM => 9, self::POSITIONS_MD => 12, self::POSITIONS_GM => 15, self::POSITIONS_VPM => 20];//初始化贡献值数组
        //$sql = 'update member set positions_id = case member_id ';
        $pos_log      = [];
        $contribution = [];
        foreach ($member_data as $member_id => $pos_id) {
            //$sql .= sprintf("WHEN %d THEN %d ", $member_id, $pos_id);//拼接字符串
            if (!empty($inviteArrs[$member_id])) {
                $contribution[] = ['member_id'    => $inviteArrs[$member_id],
                                   'type'         => $contribution_log::CONTRIBUTION_TYPE_PROMOTION,
                                   'val'          => $data[$pos_id],
                                   'contribution' => $c[$data[$pos_id]],
                                   'operate'      => 1,
                                   'create_time'  => TIMESTAMP,
                                   'des'          => '推荐会员【' . $member_numbers[$member_id] . '】职务从【' . $positions_info[$member_list[$member_id]] . '】升级到【' . $positions_info[$pos_id] . '】获取贡献值' . $c[$data[$pos_id]] . 'C'
                ];
            }
            //升级日志
            array_push($pos_log, ['member_id' => $member_id, 'level_old' => $data[$member_list[$member_id]], 'level_now' => $data[$pos_id], 'created_at' => date('Y-m-d H:i:s', TIMESTAMP), 'remark' => '职务从【' . $positions_info[$member_list[$member_id]] . '】升级到【' . $positions_info[$pos_id] . '】']);
        }
        if (!empty($pos_log)) {
            //$sql .= "END WHERE member_id IN ($ids)";
            //Model()->execute($sql);//执行升级动作
            Model()->table('positions_log')->insertAll($pos_log);//批量插入会员职务进升日志
        }
        if (!empty($contribution)) {
            $contribution_log->addContributionAll($contribution);//批量处理贡献值
        }
    }
}
