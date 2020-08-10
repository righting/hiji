<?php
/**
 * 会员模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class platform_profitModel extends Model {
    public function __construct(){
        parent::__construct('platform_profit');
    }

    // 设置平台利润来源
    const TYPE_ORDER_BUY = 1;   // 购买商品
    const TYPE_MONTHLY_CHARGE = 2;   // 月服务费
    const TYPE_INTEGRAL_FEE = 3;   // 积分商城平台服务推广费
    const TYPE_INTEGRAL_FREIGHT = 4;   // 积分商城商品运费
    const TYPE_BONUS = 5;   // 分红扣除的利润(销售服务税)
    const TYPE_SURPLUS_PROFIT = 6;   // 专项消费商品分红完成后的金额



    // 设置利润增减类型
    const CHANGE_TYPE_INC = 1;  // 增加
    const CHANGE_TYPE_DEC = 2;  // 减少

    public function get_profit_resouce($type){
        $desc = '';
        switch ($type){
            case self::TYPE_ORDER_BUY:
                $desc = '购买商品';
                break;
            case self::TYPE_MONTHLY_CHARGE:
                $desc = '月服务费';
                break;
            case self::TYPE_INTEGRAL_FEE:
                $desc = '积分商城平台服务推广费';
                break;
            case self::TYPE_INTEGRAL_FREIGHT:
                $desc = '积分商城商品运费';
                break;
            case self::TYPE_BONUS:
                $desc = '分红扣除的利润(销售服务税)';
                break;
            case self::TYPE_SURPLUS_PROFIT:
                $desc = '专项消费商品分红完成后的金额';
                break;
        }
        return $desc;
    }
}
