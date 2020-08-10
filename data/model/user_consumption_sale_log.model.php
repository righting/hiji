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

class user_consumption_sale_logModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_consumption_sale_log');
    }

    // 设置记录的类型
    const LOG_TYPE_CONSUMPTION        = 1; // 消费
    const LOG_TYPE_PERSONAL_SALE      = 2; // 个人销售
    const LOG_TYPE_STORE_SALE         = 3; // 店铺销售
    const LOG_TYPE_STORE_DISTRIBUTION = 4; // 分销商品保底价
    // 设置记录的来源类型
    const SOURCE_TYPE_FROM_HT_ORDER_BUY            = 1;// 购买商城海豚主场商品
    const SOURCE_TYPE_FROM_HT_ORDER_SALE           = 2;// 销售商城海豚主场商品
    const SOURCE_TYPE_FROM_OTHER_ORDER_BUY         = 3;// 购买商城其他类型商品
    const SOURCE_TYPE_FROM_OTHER_ORDER_SALE        = 4;// 销售商城其他类型商品
    const SOURCE_TYPE_FROM_DEFAULT_BUY             = 5;// 购买商品
    const SOURCE_TYPE_FROM_DEFAULT_SALE            = 6;// 销售商品
    const SOURCE_TYPE_FROM_STORE_SALE_DISTRIBUTION = 7;// 分销商品

    /**
     * 添加平台流水日志
     *
     * @param     $user_id      // 用户id
     * @param     $type         // 记录产生的类型
     * @param     $source_type  // 记录的来源类型
     * @param     $source_id    // 操作的信息id 如购买商品那么就是订单id
     * @param     $operation_id // 操作的信息id 如购买商品那么就是商品id
     * @param     $total_money  // 该信息产生的总金额
     * @param     $change_money // 该用户改变的金额
     * @param int $user_exp     // 产生这条记录时用户的经验
     * @return bool
     */
    public function addLog($user_id, $type, $source_type, $source_id, $operation_id, $change_money, $total_money, $user_exp = 0)
    {
        $data['user_id']      = $user_id;
        $data['type']         = $type;
        $data['source_type']  = $source_type;
        $data['source_id']    = $source_id;// 订单id
        $data['operation_id'] = $operation_id;// 商品id
        $data['total_money']  = $total_money;// 商品总金额
        $data['change_money'] = $change_money;// 用户得到的金额
        $data['remark']       = $this->generateRemarkInfo($source_type);
        $data['user_exp']     = $user_exp;
        $data['created_at']   = date('Y-m-d H:i:s');
        p('销售额' . json_encode($data));
        if ($this->insert($data)) {
            return true;
        }
        return false;
    }

    // 生成备注信息
    public function generateRemarkInfo($source_type)
    {
        switch ($source_type) {
            case self::SOURCE_TYPE_FROM_HT_ORDER_BUY:
                $remark = '购买商城海豚主场商品';
                break;
            case self::SOURCE_TYPE_FROM_HT_ORDER_SALE:
                $remark = '销售商城海豚主场商品';
                break;
            case self::SOURCE_TYPE_FROM_OTHER_ORDER_BUY:
                $remark = '购买商城其他类型商品';
                break;
            case self::SOURCE_TYPE_FROM_OTHER_ORDER_SALE:
                $remark = '销售商城其他类型商品';
                break;
            case self::SOURCE_TYPE_FROM_DEFAULT_BUY:
                $remark = '购买商品';
                break;
            case self::SOURCE_TYPE_FROM_DEFAULT_SALE:
                $remark = '销售商品';
                break;
            case self::SOURCE_TYPE_FROM_STORE_SALE_DISTRIBUTION:
                $remark = '店铺分销利润';
                break;
            default:
                $remark = '购买商城海豚主场商品';
                break;
        }
        return $remark;
    }

    // 根据来源类型获取相关信息
    public function getSourceInfo($source_type, $source_id, $operation_id)
    {
        $source_model = Model('orders');
        switch ($source_type) {
            case self::SOURCE_TYPE_FROM_HT_ORDER_BUY:
                $where['order_id'] = $source_id;
                $where['goods_id'] = $operation_id;
                break;
            case self::SOURCE_TYPE_FROM_HT_ORDER_SALE:
                break;
            case self::SOURCE_TYPE_FROM_OTHER_ORDER_BUY:
                break;
            case self::SOURCE_TYPE_FROM_OTHER_ORDER_SALE:
                break;
        }
    }
}
