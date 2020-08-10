<?php
/**
 * 前台全球跨境
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/ 欢迎加入www.ccynet.cn/
 */


defined('ByCCYNet') or exit('Access Invalid!');

class globalControl extends BaseGlobalControl
{
    public function indexOp()
    {
        $model_web_config = Model('web_config');
        $index_html       = $model_web_config->where(['web_id' => 634])->find();
        //dump($index_html);
        Tpl::output('index_html', $index_html);
        Tpl::output('webTitle', ' - 全球跨境');

        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $action     = isset($_GET['action']) ? $_GET['action'] : 'index';

        Tpl::output('controller', $controller);
        Tpl::output('action', $action);

        Tpl::showpage('global');
    }
}