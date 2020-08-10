<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/16 10:21
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Cache;

/**
 * 配置模型
 * Class Config
 * @package app\common\model
 */
class Config extends Base
{

    protected $table = 'fh_config';

    // 允许搜索的字段
    protected $searchField = ['name', 'value'];

    // 允许作为查询条件的字段
    protected $whereField = [];

    /**
     * 配置列表
     * @return array
     */
    static private function configList()
    {
        $list = Cache::tag('sys_config')->get('config_list');
        if (empty($list)) {
            $list = self::where('id', 'gt', 0)->column('value', 'name');
            if ($list) {
                Cache::tag('sys_config')->set('config_list', $list);
            }
        }
        return $list;
    }

    /**
     * 根据配置名获取配置值
     * @param string $name
     * @return mixed|string
     */
    static public function getConfig($name = '')
    {
        $config = self::configList();

        if (empty($name)) {
            return $config;
        }
        
        return isset($config[$name]) ? $config[$name] : '';
    }
}