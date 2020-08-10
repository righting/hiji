<?php
/**
 * 买家发票模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class invoiceModel extends Model {

    public function __construct() {
        parent::__construct('invoice');
    }

    const STATUS_IN = 1;    // 申请中
    const STATUS_SUCCESS = 2;   // 已邮寄

    /**
     * 取得买家默认发票
     *
     * @param array $condition
     */
    public function getDefaultInvInfo($condition = array()) {
        return $this->where($condition)->order('inv_state asc')->find();
    }

    /**
     * 取得单条发票信息
     *
     * @param array $condition
     */
    public function getInvInfo($condition = array()) {
        return $this->where($condition)->find();
    }

    /**
     * 取得发票列表
     *
     * @param unknown_type $condition
     * @return unknown
     */
    public function getInvList($condition, $limit = '', $field = '*') {
        return $this->field($field)->where($condition)->limit($limit)->select();
    }

    /**
     * 删除发票信息
     *
     * @param unknown_type $condition
     * @return unknown
     */
    public function delInv($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 新增发票信息
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function addInv($data) {
        return $this->insert($data);
    }

    // 获取用户可开发票金额
    public function getUserInvoicesCanBeOpened($user_id){
        // 用户消费金额
        $user_consumption_sale_log_day_model = Model('user_consumption_sale_log_day');
        $type = $user_consumption_sale_log_day_model::LOG_TYPE_CONSUMPTION;
        $where['type'] = $type;
        $where['user_id'] = $user_id;
        $field = 'user_id,sum(total_money) as total_money';
        $this_user_consumption_amount_info = $user_consumption_sale_log_day_model->where($where)->field($field)->find();
        // 用户分红获得的金额
        $user_bonus_log_model = Model('user_bonus_log');
        $this_user_bonus_money_info = $user_bonus_log_model->where(['user_id'=>$user_id])->field('user_id,sum(money) as total_money')->find();
        // 用户已开发票金额
        $this_user_has_opened_money_info = $this->where(['user_id'=>$user_id])->field('user_id,sum(money) as total_money')->find();
        // 用户总的可开发票金额 = 用户消费金额 - 分红获得的金额
        $this_user_invoices_can_be_opened_total_money = bcsub($this_user_consumption_amount_info['total_money'],$this_user_bonus_money_info['total_money'],2);
        // 用户当前可开发票金额 = 用户总的可开发票金额 - 已开发票金额
        $this_user_invoices_can_be_opened_money = bcsub($this_user_invoices_can_be_opened_total_money,$this_user_has_opened_money_info['total_money'],2);
        $info['total_money'] = $this_user_consumption_amount_info['total_money'];  // 消费总金额
        $info['bonus_money'] = $this_user_bonus_money_info['total_money'];         // 获得的分红金额
        $info['can_be_opened_total_money'] = $this_user_invoices_can_be_opened_total_money; // 发票总金额
        $info['has_be_opened_money'] = $this_user_has_opened_money_info['total_money']; // 当前已开发票金额
        $info['can_be_opened_money'] = $this_user_invoices_can_be_opened_money; // 当前可开发票金额
        return $info;
    }

}
