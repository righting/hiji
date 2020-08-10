<?php
/**
 * 入口文件
 *
 * 统一入口，进行初始化信息
 *
 *
 * @copyright  Copyright (c) 2007-2015 ccynet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.cn//
 * @link       http://www.ccynet.cn//
 * @since      File available since Release v1.1
 */

//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
define('DS', DIRECTORY_SEPARATOR);
define('BASE_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('BASE_CORE_PATH', BASE_ROOT_PATH . DS . 'core');
define('BASE_DATA_PATH', BASE_ROOT_PATH . DS . 'data');
define("BASE_UPLOAD_PATH", BASE_ROOT_PATH . DS . 'data' . DS . 'upload');

define("BASE_RESOURCE_PATH", BASE_ROOT_PATH . DS . 'data/resource');

require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'function' . DS . 'common.php');

/**
 * 安装判断
 */
if (!is_file(BASE_ROOT_PATH . DS . 'shop' . DS . 'install' . DS . 'lock') && is_file(BASE_ROOT_PATH . DS . 'shop' . DS . 'install' . DS . 'index.php')) {
    if (ProjectName != 'shop') {
        @header("location: ../shop/install/index.php");
    } else {
        @header("location: install/index.php");
    }
    exit;
}

/**
 * 初始化
 */

define('ByCCYNet', true);
define('StartTime', microtime(true));
define('TIMESTAMP', time());
define('DIR_SHOP', 'shop');
define('DIR_MBMBER', 'member');
define('DIR_CMS', 'cms');
define('DIR_CIRCLE', 'circle');
define('DIR_MICROSHOP', 'microshop');
define('DIR_ADMIN', 'admin');
define('DIR_API', 'api');
define('DIR_MOBILE', 'mobile');
define('DIR_WAP', 'wap');
define('DIR_RESOURCE', 'data/resource');
define('DIR_UPLOAD', 'data/upload');
define('ATTACH_PATH', 'shop');
define('ATTACH_COMMON', 'shop/common');
define('ATTACH_AVATAR', 'shop/avatar');
define('ATTACH_EDITOR', 'shop/editor');
define('ATTACH_MEMBERTAG', 'shop/membertag');
define('ATTACH_STORE', 'shop/store');
define('ATTACH_GOODS', 'shop/store/goods');
define('ATTACH_STORE_DECORATION', 'shop/store/decoration');
define('ATTACH_LOGIN', 'shop/login');
define('ATTACH_ARTICLE', 'shop/article');
define('ATTACH_BRAND', 'shop/brand');
define('ATTACH_GOODS_CLASS', 'shop/goods_class');
define('ATTACH_ADV', 'shop/adv');
define('ATTACH_ACTIVITY', 'shop/activity');
define('ATTACH_WATERMARK', 'shop/watermark');
define('ATTACH_POINTPROD', 'shop/pointprod');
define('ATTACH_GROUPBUY', 'shop/groupbuy');
define('ATTACH_SLIDE', 'shop/store/slide');
define('ATTACH_VOUCHER', 'shop/voucher');
define('ATTACH_REDPACKET', 'shop/redpacket');
define('ATTACH_STORE_JOININ', 'shop/store_joinin');
define('ATTACH_REC_POSITION', 'shop/rec_position');
define('ATTACH_CONTRACTICON', 'shop/contracticon');
define('ATTACH_CONTRACTPAY', 'shop/contractpay');
define('ATTACH_WAYBILL', 'shop/waybill');
define('ATTACH_MOBILE', 'mobile');
define('ATTACH_CIRCLE', 'circle');
define('ATTACH_CMS', 'cms');
define('ATTACH_LIVE', 'live');
define('ATTACH_MALBUM', 'shop/member');
define('ATTACH_MICROSHOP', 'microshop');
define('ATTACH_DELIVERY', 'delivery');
define('ATTACH_CHAIN', 'chain');
define('ATTACH_ADMIN_AVATAR', 'admin/avatar');
define('TPL_SHOP_NAME', 'default');
define('TPL_NGYP_NAME', 'default');
define('TPL_CIRCLE_NAME', 'default');
define('TPL_MICROSHOP_NAME', 'default');
define('TPL_CMS_NAME', 'default');
define('TPL_ADMIN_NAME', 'default');
define('TPL_DELIVERY_NAME', 'default');
define('TPL_CHAIN_NAME', 'default');
define('TPL_MEMBER_NAME', 'default');
define('TPL_DISTRIBUTE_NAME', 'default');
define('ADMIN_MODULES_SYSTEM', 'modules/system');
define('ADMIN_MODULES_SHOP', 'modules/shop');
define('ADMIN_MODULES_CMS', 'modules/cms');
define('ADMIN_MODULES_CIECLE', 'modules/circle');
define('ADMIN_MODULES_MICEOSHOP', 'modules/microshop');
define('ADMIN_MODULES_MOBILE', 'modules/mobile');

/**
 * 商家入驻状态定义
 */

//新申请
define('STORE_JOIN_STATE_NEW', 10);
//完成付款
define('STORE_JOIN_STATE_PAY', 11);
//初审成功
define('STORE_JOIN_STATE_VERIFY_SUCCESS', 20);
//初审失败
define('STORE_JOIN_STATE_VERIFY_FAIL', 30);
//付款审核失败
define('STORE_JOIN_STATE_PAY_FAIL', 31);
//开店成功
define('STORE_JOIN_STATE_FINAL', 40);

//默认颜色规格id(前台显示图片的规格)
define('DEFAULT_SPEC_COLOR_ID', 1);

/**
 * 商品图片
 */
define('GOODS_IMAGES_WIDTH', '60,_120,240,360,1280');
define('GOODS_IMAGES_HEIGHT', '60,_120,240,360,12800');
define('GOODS_IMAGES_EXT', '_60,_120,_240,_360,_1280');

/**
 *  订单状态
 */

//已取消
define('ORDER_STATE_CANCEL', 0);
//已产生但未支付
define('ORDER_STATE_NEW', 10);
//已支付
define('ORDER_STATE_PAY', 20);
//已发货
define('ORDER_STATE_SEND', 30);
//已收货，交易成功
define('ORDER_STATE_SUCCESS', 40);
//订单超过N小时未支付自动取消
define('ORDER_AUTO_CANCEL_TIME', 1);
//订单超过N天未收货自动收货
define('ORDER_AUTO_RECEIVE_DAY', 10);

//预订尾款支付期限(小时)
define('BOOK_AUTO_END_TIME', 72);

//门店支付订单支付提货期限(天)
define('CHAIN_ORDER_PAYPUT_DAY', 7);

/**
 * 订单删除状态
 */

//默认未删除
define('ORDER_DEL_STATE_DEFAULT', 0);
//已删除
define('ORDER_DEL_STATE_DELETE', 1);
//彻底删除
define('ORDER_DEL_STATE_DROP', 2);

/**
 * 文章显示位置状态,1默认网站前台,2买家,3卖家,4全站
 */
define('ARTICLE_POSIT_SHOP', 1);
define('ARTICLE_POSIT_BUYER', 2);
define('ARTICLE_POSIT_SELLER', 3);
define('ARTICLE_POSIT_ALL', 4);

//兑换码过期后可退款时间，15天
define('CODE_INVALID_REFUND', 15);

/**
 * 初始化
 */

if (!@include(BASE_DATA_PATH . '/config' . DS . 'config.ini.php')) exit('config.ini.php isn\'t exists!');
if (file_exists(BASE_PATH . DS . 'config' . DS . 'config.ini.php')) {
    include(BASE_PATH . DS . 'config' . DS . 'config.ini.php');
}
global $config;

//默认平台店铺id
define('DEFAULT_PLATFORM_STORE_ID', $config['default_store_id']);
define('URL_MODEL', $config['url_model']);
define('SUBDOMAIN_SUFFIX', $config['subdomain_suffix']);
define('BASE_SITE_URL', $config['base_site_url']);
define('SHOP_SITE_URL', $config['shop_site_url']);
define('CMS_SITE_URL', $config['cms_site_url']);
define('CMS_modules_URL', $config['cms_modules_url']);
define('CIRCLE_SITE_URL', $config['circle_site_url']);
define('CIRCLE_modules_URL', $config['circle_modules_url']);
define('MICROSHOP_SITE_URL', $config['microshop_site_url']);
define('MICROSHOP_modules_URL', $config['microshop_modules_url']);
define('ADMIN_SITE_URL', $config['admin_site_url']);
define('ADMIN_modules_URL', $config['admin_modules_url']);
define('MOBILE_SITE_URL', $config['mobile_site_url']);
define('MOBILE_modules_URL', $config['mobile_modules_url']);
define('WAP_SITE_URL', $config['wap_site_url']);
define('UPLOAD_SITE_URL', $config['upload_site_url']);
define('RESOURCE_SITE_URL', $config['resource_site_url']);
define('DELIVERY_SITE_URL', $config['delivery_site_url']);
define('LOGIN_SITE_URL', $config['member_site_url']);
define('RESOURCE_SITE_URL_HTTPS', $config['resource_site_url']);
define('CHAIN_SITE_URL', $config['chain_site_url']);
define('MEMBER_SITE_URL', $config['member_site_url']);
define('NGYP_SITE_URL', $config['ngyp_site_url']);
define('JF_SITE_URL', $config['jf_site_url']);
define('HJB_SITE_URL', $config['hjb_site_url']);
define('SELLER_SITE_URL', $config['seller_site_url']);
define('LOGIN_RESOURCE_SITE_URL', MEMBER_SITE_URL . '/resource');
define('UPLOAD_SITE_URL_HTTPS', $config['upload_site_url']);
define('CHAT_SITE_URL', $config['chat_site_url']);
define('NODE_SITE_URL', $config['node_site_url']);
define('DISTRIBUTE_SITE_URL', $config['distribute_site_url']);
// 设置日志记录位置
defined('RUNTIME_PATH') or define('RUNTIME_PATH', '/runtime' . DS);
define('CHARSET', $config['db'][1]['dbcharset']);
define('DBDRIVER', $config['dbdriver']);
define('SESSION_EXPIRE', $config['session_expire']);
define('LANG_TYPE', $config['lang_type']);
define('COOKIE_PRE', $config['cookie_pre']);
define('DBPRE', $config['tablepre']);
define('DBNAME', $config['db'][1]['dbname']);

$_GET['controller'] = is_string($_GET['controller']) ? strtolower($_GET['controller']) : (is_string($_POST['controller']) ? strtolower($_POST['controller']) : null);
$_GET['action']     = is_string($_GET['action']) ? strtolower($_GET['action']) : (is_string($_POST['action']) ? strtolower($_POST['action']) : null);

if (empty($_GET['controller'])) {
    require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'core' . DS . 'route.php');
    new Route($config);
}

//统一ACTION
$_GET['controller'] = preg_match('/^[\w]+$/i', $_GET['controller']) ? $_GET['controller'] : 'index';
$_GET['action']     = preg_match('/^[\w]+$/i', $_GET['action']) ? $_GET['action'] : 'index';

//对GET POST接收内容进行过滤,$ignore内的下标不被过滤
$ignore = ['article_content', 'pgoods_body', 'doc_content', 'content', 'sn_content', 'g_body', 'store_description', 'p_content', 'groupbuy_intro', 'remind_content', 'note_content', 'adv_pic_url', 'adv_word_url', 'adv_slide_url', 'appcode', 'mail_content', 'message_content', 'member_gradedesc'];

if (!class_exists('Security')) require(BASE_CORE_PATH . DS . 'framework' . DS . 'libraries' . DS . 'security.php');

$_GET     = !empty($_GET) ? Security::getAddslashesForInput($_GET, $ignore) : [];
$_POST    = !empty($_POST) ? Security::getAddslashesForInput($_POST, $ignore) : [];
$_REQUEST = !empty($_REQUEST) ? Security::getAddslashesForInput($_REQUEST, $ignore) : [];
$_SERVER  = !empty($_SERVER) ? Security::getAddSlashes($_SERVER) : [];

//启用ZIP压缩
if ($config['gzip'] == 1 && function_exists('ob_gzhandler') && $_GET['inajax'] != 1) {
    ob_start('ob_gzhandler');
} else {
    ob_start();
}

require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'libraries' . DS . 'queue.php');
require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'function' . DS . 'core.php');
require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'core' . DS . 'base.php');
require_once(BASE_CORE_PATH . DS . 'framework' . DS . 'function' . DS . 'goods.php');

if (function_exists('spl_autoload_register')) {
    spl_autoload_register(['Base', 'autoload']);
} else {
    function __autoload($class)
    {
        return Base::autoload($class);
    }
}