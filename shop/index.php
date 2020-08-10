<?php
/**
 * 商城板块初始化文件
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

define('APP_ID', 'shop');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));

require __DIR__ . '/../ccynet.php';

$wapurl = WAP_SITE_URL;
$agent  = $_SERVER['HTTP_USER_AGENT'];
//if (strpos($agent, "comFront") || strpos($agent, "iPhone") || strpos($agent, "MIDP-2.0") || strpos($agent, "Opera Mini") || strpos($agent, "UCWEB") || strpos($agent, "Android") || strpos($agent, "Windows CE") || strpos($agent, "SymbianOS"))
//header("Location:$wapurl");

define('APP_SITE_URL', SHOP_SITE_URL);
define('TPL_NAME', TPL_SHOP_NAME);
define('J_SITE_URL', JF_SITE_URL);
define('jf_TEMPLATES_URL', JF_SITE_URL . '/templates/' . TPL_NGYP_NAME);
define('SHOP_RESOURCE_SITE_URL', SHOP_SITE_URL . DS . 'resource');
define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);
define('BASE_TPL_PATH', BASE_PATH . '/templates/' . TPL_NAME);

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');
Base::run();