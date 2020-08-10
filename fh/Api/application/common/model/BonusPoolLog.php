<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/13 17:24
// +----------------------------------------------------------------------

namespace app\common\model;

use Exception;

/**
 * 分红池日志模型
 * Class BonusPoolLog
 * @package app\common\model
 */
class BonusPoolLog extends Base
{
    protected $type = [
        'add_time' => 'timestamp'
    ];

    // 允许搜索的字段
    protected $searchField = [];

    // 允许作为查询条件的字段
    protected $whereField = [];

    /**
     * 构造查询条件
     * @param $param
     */
    protected function paraseSearch($param = [])
    {
        if (count($param) > 0) {
            if (!empty($param['name'])) {
                $this->where('name', $param['name']);
            }
            
            if (!empty($param['start_time'])) {
                $this->where('add_time', 'egt', strtotime($param['start_time']));
            }

            if (!empty($param['end_time'])) {
                $this->where('add_time', 'lt', strtotime($param['end_time']) + 86400);
            }

        }
    }
}