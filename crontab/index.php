<?php
/**
 * 队列
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

$_SERVER['argv'][1] = isset($_GET['controller']) ? $_GET['controller'] : 'month';
$_SERVER['argv'][2] = isset($_GET['action']) ? $_GET['action'] : 'index';
if (empty($_SERVER['argv'][1])) exit('Access Invalid!');

define('APP_ID', 'crontab');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('TRANS_MASTER', true);
require __DIR__ . '/../ccynet.php';

$_GET['controller'] = $_SERVER['argv'][1];
$_GET['action']     = empty($_SERVER['argv'][2]) ? 'index' : $_SERVER['argv'][2];

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');

Base::run();