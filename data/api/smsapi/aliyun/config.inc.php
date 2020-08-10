<?php
defined('ByCCYNet') or exit('Access Invalid!');
/*
 * 配置文件
 */
$options                      = [];
$options['access_key_id']     = C('ccynet_sms_aliyun_key_id'); // AccessKeyId
$options['access_key_secret'] = C('ccynet_sms_aliyun_key_secret'); // AccessKeySecret
$options['sign_name']         = C('ccynet_sms_signature'); // 短信签名
return $options;