<?php
/**
 * 网银在线自动对账文件
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

error_reporting(7);
$_GET['controller']   = 'payment';
$_GET['action']       = 'notify';
$_GET['payment_code'] = 'chinabank';

//赋值，方便后面合并使用支付宝验证方法
$_POST['out_trade_no']       = $_POST['v_oid'];
$_POST['extra_common_param'] = $_POST['remark1'];
$_POST['trade_no']           = $_POST['v_idx'];

require_once(dirname(__FILE__) . '/../../../index.php');