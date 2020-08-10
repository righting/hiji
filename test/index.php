<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2018/11/29 11:48
// +----------------------------------------------------------------------

define('APP_ID', 'test');
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));

require_once(__DIR__ . '/../ccynet.php');

/*define('APP_SITE_URL', MEMBER_SITE_URL);
define('TPL_NAME', TPL_MEMBER_NAME);

define('J_SITE_URL', JF_SITE_URL);

define('jf_TEMPLATES_URL', JF_SITE_URL . '/templates/' . TPL_NGYP_NAME);


define('MEMBER_TEMPLATES_URL', MEMBER_SITE_URL . '/templates/' . TPL_MEMBER_NAME);
define('BASE_MEMBER_TEMPLATES_URL', dirname(__FILE__) . '/templates/' . TPL_MEMBER_NAME);
define('MEMBER_RESOURCE_SITE_URL', MEMBER_SITE_URL . '/resource');
define('LOGIN_RESOURCE_SITE_URL', LOGIN_SITE_URL . '/resource');
define('LOGIN_TEMPLATES_URL', LOGIN_SITE_URL . '/templates/' . TPL_MEMBER_NAME);
define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);*/

if (!@include(BASE_PATH . '/control/control.php')) exit('control.php isn\'t exists!');
Base::run();