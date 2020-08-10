<?php
defined('ByCCYNet') or exit('Access Invalid!');
/*
 * 配置文件
 */
$options = array();
$options['apikey'] = C('ccynet_sms_key'); //apikey
$options['signature'] =  C('ccynet_sms_signature'); //签名
return $options;
?>