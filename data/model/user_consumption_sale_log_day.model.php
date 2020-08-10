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

class user_consumption_sale_log_dayModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_consumption_sale_log_day');
    }

    // 设置人民币与美元的汇率
    const RMB_TO_DOLLAR = 0.1523;   // 1元 人民币 转 美元
    const DOLLAR_TO_RMB = 6.5677;   // 1美元 转 人民币

    // 设置记录的类型
    const LOG_TYPE_CONSUMPTION   = 1; // 消费
    const LOG_TYPE_PERSONAL_SALE = 2; // 个人销售
    const LOG_TYPE_STORE_SALE    = 3; // 店铺销售
    const LOG_TYPE_SJ            = 4; // 升级消费
    const LOG_TYPE_ZX            = 5; // 专项消费


    /**
     * 会员销售消费统计入库
     *
     * @param $user_id // 用户id
     * @param $type    // 记录产生的类型
     * @param $money   // 该信息产生的总金额
     * @return bool
     */
    public function addLog($user_id, $type, $money)
    {
        $member_model          = Model('member');
        $user_member_info      = $member_model->where(['member_id' => $user_id])->field('level_id')->find();
        $user_level_id         = $user_member_info['level_id'];
        $data['user_id']       = $user_id;
        $data['type']          = $type;
        $data['total_money']   = $money;        // 商品总金额
        $data['user_level_id'] = $user_level_id;
        $data['created_at']    = date('Y-m-d H:i:s');
        $today_begin_date      = date('Y-m-d H:i:s', strtotime(date('Y-m-d')));
        $today_end_date        = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($today_begin_date)) - 1);
        // 检查当前用户，当前类型的数据今天是否已经存在，如果存在则修改，如果不存在，则添加
        $where['user_id']    = $user_id;
        $where['type']       = $type;
        $where['created_at'] = ['between', [$today_begin_date, $today_end_date]];
        $info                = $this->where($where)->find();
        if ($info) {
            $this->where(['id' => $info['id']])->setInc('total_money', $money);
        } else {
            $this->insert($data);
        }
    }

    /**统计消费金额
     *
     * @param $con
     */
    public function countUsersSales($con)
    {
        $this->where($con)->sum('total_money');
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
