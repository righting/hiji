<?php
/**
 * 默认展示页面
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class indexControl extends BaseLoginControl{
    public function __construct() {
        @header("location: " . urlMember('member_information'));
    }
}
