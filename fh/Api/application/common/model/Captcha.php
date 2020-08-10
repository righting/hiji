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
 * 验证码模型
 * Class Captcha
 * @package app\common\model
 */
class Captcha extends Base
{
    protected $type = [
        'add_time' => 'timestamp'
    ];

    // 允许搜索的字段
    protected $searchField = [];

    // 允许作为查询条件的字段
    protected $whereField = [];
}