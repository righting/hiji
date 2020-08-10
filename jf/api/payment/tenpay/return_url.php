<?php
/**
 * @TODO       5.财付通返回地址
 * 财付通返回地址
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

error_reporting(7);
$_GET['controller']   = 'payment';
$_GET['action']       = 'return';
$_GET['payment_code'] = 'tenpay';

//赋值，方便后面合并使用支付宝验证方法
$_GET['out_trade_no']       = $_GET['sp_billno'];
$_GET['extra_common_param'] = $_GET['attach'];
$_GET['trade_no']           = $_GET['transaction_id'];

require_once(dirname(__FILE__) . '/../../../index.php');