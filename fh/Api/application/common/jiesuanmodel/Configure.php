<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/16 10:21
// +----------------------------------------------------------------------

namespace app\common\jiesuanmodel;

use think\Cache;

/**
 * 配置模型
 * Class Config
 * @package app\common\model
 */
class Configure extends Base
{

    protected $table = 'js_config';

    // 允许搜索的字段
    protected $searchField = ['name'];

    // 允许作为查询条件的字段
    protected $whereField = [];

    public static $list = [];

    /**
     * 配置列表
     * @return array
     */
    static private function configList()
    {
        $rsult = self::select();
        $list = self::getDataArray($rsult);
        foreach($list as $k=>$v){
            self::$list[$v['name']] = $v['value'];
        }
    }

    /**
     * 根据配置名获取配置值
     * @param string $name
     * @return mixed|string
     */
    static public function getConfig($name = '')
    {
        self::configList();

        if (empty($name)) {
            return self::$list;
        }
        return isset(self::$list[$name]) ? self::$list[$name] : '';
    }
}