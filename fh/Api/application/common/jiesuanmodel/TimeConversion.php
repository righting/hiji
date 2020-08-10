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
 * 时间转换对应数据
 * Class Config
 * @package app\common\model
 */
class TimeConversion extends Base
{
	protected $name = 'time_conversion';

    // 允许搜索的字段
    protected $searchField = ['name'];

    // 允许作为查询条件的字段
    protected $whereField = [];
    /**
     * 配置列表
     * @return array
     */
    static public function getlist()
    {
        $rsult = self::select();
        $list = self::getDataArray($rsult);
       	return $list[0];
    }

}