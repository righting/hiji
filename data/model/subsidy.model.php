<?php
/**
 * 交易新模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class subsidyModel extends Model
{
    public function __construct()
    {
        parent::__construct('subsidy_apply');
    }

    // 更新用户消费资本补贴金额
    public function updateUserSubsidyMoney($add_money_arr, $subsidy_type)
    {
        $update_sql = $this->getUserSubsidyMoneyStr($add_money_arr, $subsidy_type);
        DB::execute($update_sql);
    }

    // 获取更新消费资本补贴sql字符串
    public function getUserSubsidyMoneyStr($user_update_balance_arr, $subsidy_type)
    {
        $sql = 'UPDATE subsidy_apply SET total_money = CASE user_id';
        foreach ($user_update_balance_arr as $key => $value) {
            if ($value > 0) {
                $sql .= ' WHEN ' . $key . ' THEN total_money+' . $value;
            }
        }
        $sql .= ' END';
        $sql .= ' WHERE type_id = ' . $subsidy_type;
        return $sql;
    }
}
