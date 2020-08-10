<?php
/**
 * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class user_hi_valueModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_hi_value');
    }

    // 设置HI值类型
    const HI_TYPE_UPGRADE        = 1; // 升级获得的HI值
    const HI_TYPE_RECOMMEND_TEAM = 2; // 推荐团队赠送的HI值
    const HI_TYPE_BONUS_TO_HI    = 3; // 奖金转换的HI值

    // 设置改变HI值得类型（增加，减少）
    const CHANGE_TYPE_INC = 1; // 增加HI值
    const CHANGE_TYPE_DEC = 2; // 减少HI值

    // 设置分红HI值转现比便
    const EXCHANGE_PERCENT = 0.3; // 默认比便为30%

    // 设置每月最高转出金额
    const EXCHANGE_MAX = 2000; // 默认2000HI值即2000元

    /**
     * 改变用户HI值
     *
     * @param     $user_id
     * @param     $hi_value
     * @param int $hi_type
     * @param int $change_type
     * @return bool
     */
    public function changeUserHi($user_id, $hi_value, $hi_type = 1, $change_type = 1)
    {
        // 检查当前用户的HI值信息是否存在于数据库中
        $hi_value_info = $this->where(['user_id' => $user_id])->find();
        $field         = $this->getHiValueFieldForType($hi_type);
        Db::beginTransaction();
        if (empty($hi_value_info)) {
            // 如果是增加HI值，则添加，如果是减少，则设置值为0
            $msg_title = '增加HI值 ';
            if ($change_type == self::CHANGE_TYPE_DEC) {
                $hi_value  = 0;
                $msg_title = '减少HI值 ';
            }
            $insert_data['user_id'] = $user_id;
            $insert_data[$field]    = $hi_value;
            $this->insert($insert_data);
        } else {
            // 如果存在，则修改信息
            $old_hi    = $hi_value_info[$field];
            $msg_title = '增加HI值 ';
            if ($change_type == self::CHANGE_TYPE_DEC) {
                // 如果是减少HI值，需要检查减少后的HI值是否大于等于0；如果不是，则直接修改为0
                $new_hi = bcsub($old_hi, $hi_value);
                if (bccomp($new_hi, 0) < 0) {
                    $new_hi = 0;
                }
                $msg_title = '减少HI值 ';
            } else {
                $new_hi = bcadd($old_hi, $hi_value);
            }
            $update_data[$field] = $new_hi;
            $this->where(['user_id' => $user_id])->update($update_data);
        }
        // 记录HI改变日志
        $log_model = new user_hi_logModel();
        $msg       = $msg_title . $hi_value;
        $result    = $log_model->addLog($user_id, $hi_value, $hi_type, $change_type, $msg);
        if ($result) {
            Db::commit();
            return true;
        }
        Db::rollback();
        return false;
    }

    /**
     * 根据HI值类型返回该类型对应的字段
     *
     * @param int $type
     * @return array|mixed
     */
    public function getHiValueFieldForType($type)
    {
        $field_type_arr = [
            self::HI_TYPE_UPGRADE        => 'upgrade_hi',
            self::HI_TYPE_RECOMMEND_TEAM => 'recommend_team_hi',
            self::HI_TYPE_BONUS_TO_HI    => 'bonus_to_hi',
        ];
        return isset($field_type_arr[$type]) ? $field_type_arr[$type] : $field_type_arr;
    }

    /**
     * 获取单个会员hi值统计
     *
     * @param int $user_id
     * @return array|bool
     */
    public function getMemberHiInfo($user_id)
    {
        $data = $this->where(['user_id' => $user_id])->find();

        if (empty($data)) return false;

        return [
            ['type' => '升级获得', 'value' => $data[self::getHiValueFieldForType(self::HI_TYPE_UPGRADE)]],
            ['type' => '推荐团队获得', 'value' => $data[self::getHiValueFieldForType(self::HI_TYPE_RECOMMEND_TEAM)]],
            ['type' => '奖金转换获得', 'value' => $data[self::getHiValueFieldForType(self::HI_TYPE_BONUS_TO_HI)]]
        ];
    }

    /**
     * 获取用户当前可兑现hi值
     *
     * @param $user_id
     * @return array
     */
    public function getEnableExchangeHiValue($user_id)
    {
        $data                   = [];
        $model_log              = new user_hi_logModel();
        $exchangeComplete_month = $model_log->getExchangeHi_month($user_id); // 获取本月已兑现HI值

        $my_hi_value                    = $this->where(['user_id' => $user_id])->find();
        $data['exchangeComplete_month'] = $exchangeComplete_month;
        $data['allow_hi_to_bonus']      = $my_hi_value['allow_hi_to_bonus'];
        $data['exchange_max']           = self::EXCHANGE_MAX;
        $data['pre']                    = self::EXCHANGE_PERCENT;
        $data['enable_hi']              = $my_hi_value['allow_hi_to_bonus'] * self::EXCHANGE_PERCENT - $exchangeComplete_month;
        return $data;
    }

}
