<?php
/**
 * 买家发票模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class user_invoice_infoModel extends Model {

    public function __construct() {
        parent::__construct('user_invoice_info');
    }

    // 设置发票类型
    const TYPE_ONE = 1; // 1.个人增值税普通发票;2.企业增值税普通发票
    const TYPE_TWO = 2; // 1.个人增值税普通发票;2.企业增值税普通发票

    // 设置纳税人识别号类型
    const SBH_TYPE_ZERO = 0;    //  纳税人识别号0.不需要（只有企业发票必选）；1.社会统一信用代码；2.税务登记证号码
    const SBH_TYPE_ONE = 1;     //  纳税人识别号0.不需要（只有企业发票必选）；1.社会统一信用代码；2.税务登记证号码
    const SBH_TYPE_TWO = 2;     //  纳税人识别号0.不需要（只有企业发票必选）；1.社会统一信用代码；2.税务登记证号码

    public function geTypeInfo($type = ''){
        $arr = [
            self::TYPE_ONE => '个人增值税普通发票',
            self::TYPE_TWO => '企业增值税普通发票'
        ];
        return isset($arr[$type]) ? $arr[$type] : $arr;
    }
    public function geSBHTypeInfo($type = ''){
        $arr = [
            self::SBH_TYPE_ONE => '社会统一信用代码',
            self::SBH_TYPE_TWO => '税务登记证号码'
        ];
        return isset($arr[$type]) ? $arr[$type] : $arr;
    }
}
