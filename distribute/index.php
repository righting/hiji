<?php
/**
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

define('APP_ID','distribute');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

require __DIR__ . '/../ccynet.php';

define('APP_SITE_URL', DISTRIBUTE_SITE_URL);
define('TPL_NAME',TPL_DISTRIBUTE_NAME);
define('DISTRIBUTE_TEMPLATES_URL', DISTRIBUTE_SITE_URL.'/templates/'.TPL_DISTRIBUTE_NAME);
define('BASE_DISTRIBUTE_TEMPLATES_URL', dirname(__FILE__).'/templates/'.TPL_DISTRIBUTE_NAME);
define('DISTRIBUTE_RESOURCE_SITE_URL',DISTRIBUTE_SITE_URL.'/resource');

if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
Base::run();