<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/13 17:24
// +----------------------------------------------------------------------

namespace app\common\haijimodel;

use Exception;
use think\model\concern\SoftDelete;

/**
 * 管理员模型
 * Class AdminUser
 * @package app\common\model
 */
class Orders extends Base
{
    protected $table = 'orders';
}