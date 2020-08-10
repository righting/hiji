<?php
/**
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

define('APP_ID', 'member');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));

require_once(__DIR__ . '/../ccynet.php');

define('APP_SITE_URL', MEMBER_SITE_URL);
define('TPL_NAME', TPL_MEMBER_NAME);

define('J_SITE_URL', JF_SITE_URL);

define('jf_TEMPLATES_URL', JF_SITE_URL . '/templates/' . TPL_NGYP_NAME);

define('MEMBER_TEMPLATES_URL', MEMBER_SITE_URL . '/templates/' . TPL_MEMBER_NAME);
define('BASE_MEMBER_TEMPLATES_URL', dirname(__FILE__) . '/templates/' . TPL_MEMBER_NAME);
define('MEMBER_RESOURCE_SITE_URL', MEMBER_SITE_URL . '/resource');
define('LOGIN_RESOURCE_SITE_URL', LOGIN_SITE_URL . '/resource');
define('LOGIN_TEMPLATES_URL', LOGIN_SITE_URL . '/templates/' . TPL_MEMBER_NAME);
define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);
define('SHOP_RESOURCE_SITE_URL',SHOP_SITE_URL.DS.'resource');

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');
Base::run();