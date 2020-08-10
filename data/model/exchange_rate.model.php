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
class exchange_rateModel extends Model {
    public function __construct(){
        parent::__construct('exchange_rate');
    }

    // 设置人民币与美元的汇率
    const RMB_TO_DOLLAR = 0.1523;   // 1元 人民币 转 美元
    const DOLLAR_TO_RMB = 6.5677;   // 1美元 转 人民币


    // 获取人民币换美元的汇率
    public function getRmbToDollarExchangeRate(){
        return 0.1523;
    }

    // 获取美元换人民币的汇率
    public function getDollarToRmbExchangeRate(){
        return 6.5677;
    }

    // 计算人民币换美元的金额
    public function getRmbToDollarMoney($rmb_money = 1){
        $dollar_money = bcmul($rmb_money,$this->getRmbToDollarExchangeRate(),4);
        return $dollar_money;
    }

    // 获取美元换人民币的金额
    public function getDollarToRmbMoney($dollar_money = 1){
        $rmb_money = bcmul($dollar_money,$this->getDollarToRmbExchangeRate(),4);
        return $rmb_money;
    }
}
