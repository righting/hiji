<?php
/**
 * 前台control父类
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/
class BaseControl
{
    public function __construct()
    {
        Language::read('common');
    }
}
