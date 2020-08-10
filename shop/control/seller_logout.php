<?php
/**
 * 店铺卖家注销
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class seller_logoutControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        $this->logoutOp();
    }

    public function logoutOp() {
        $this->recordSellerLog('注销成功');
        // 清除店铺消息数量缓存
        setNcCookie('storemsgnewnum'.$_SESSION['seller_session_info']['seller_id'],0,-3600);
        session_destroy();
        redirect(urlShop('seller_login'));
    }

}
