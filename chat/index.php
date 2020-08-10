<?php
/**
 * 初始化文件
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

define('APP_ID', 'chat');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)) . '/ccynet.php')) exit('ccynet.php isn\'t exists!');

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');

Base::run();