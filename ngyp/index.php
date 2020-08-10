<?php
/**
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

define('APP_ID', 'ngyp');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));

require __DIR__ . '/../ccynet.php';

define('APP_SITE_URL', NGYP_SITE_URL);
define('TPL_NAME', TPL_NGYP_NAME);

define('NGYP_TEMPLATES_URL', NGYP_SITE_URL . '/templates/' . TPL_NGYP_NAME);
define('BASE_BGYP_TEMPLATES_URL', dirname(__FILE__) . '/templates/' . TPL_NGYP_NAME);
define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);
define('SHOP_RESOURCE_SITE_URL', SHOP_SITE_URL . DS . 'resource');

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');
Base::run();