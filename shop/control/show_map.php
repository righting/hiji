<?php
/**
 * 店铺地址地图
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class show_mapControl extends BaseHomeControl {
    public function __construct() {
        parent::__construct();
    }
    /**
     * 店铺地址地图
     *
     */
    public function indexOp() {
        if (empty($_GET['w'])) {
            $_GET['w'] =500;
        }
        if (empty($_GET['h'])) {
            $_GET['h'] =500;
        }

        $model_store_map = Model('store_map');
        $store_id = intval($_GET['store_id']);
        if ($store_id > 0) {
            $condition = array();
            $condition['store_id'] = $store_id;
            $map_list = $model_store_map->getStoreMapList($condition, '', '', 'map_id asc');
            Tpl::output('map_list',$map_list);
            Tpl::showpage('show_map','null_layout');
        }
    }
}
