<?php
/**
 * 接收微信支付异步通知回调地址
 *
 * 
 * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
error_reporting(7);
$_GET['controller']	= 'payment';
$_GET['action']		= 'wxpay_notify';
require_once(dirname(__FILE__).'/../../../index.php');
