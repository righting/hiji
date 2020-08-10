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
use app\common\jiesuanmodel\Configure;
use app\common\haijimodel\Orders;

/**
 * 时间自动解冻
 * Class 
 * @package app\common\model
 */
class OrderUnlockLog extends Base
{
	protected $name = 'order_unlock_log';
	    // 允许作为查询条件的字段
    protected $whereField = [];

    public static $list = [];
}