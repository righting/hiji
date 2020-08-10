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
 * 会员模型
 * Class Member
 * @package app\common\model
 */
class Member extends Base
{
    protected $type = [
        'add_time' => 'timestamp'
    ];

    // 允许搜索的字段
    protected $searchField = [];

    // 允许作为查询条件的字段
    protected $whereField = [];

    // 推荐人
    public function getParentAttr($value, $data)
    {
        $from_user_id = RegisterInvite::where('to_user_id', $data['member_id'])->value('from_user_id');
        if ($from_user_id) {
            $parent = Member::where('member_id', $from_user_id)->field('member_id,member_number,member_name')->find();
            return $parent ? $parent->toArray() : null;
        }
        return null;
    }

    /**
     * 关联上级
     * @return HasMany
     */
    public function member()
    {
        return $this->belongsTo('member', 'member_id')->field('member_id,member_number,member_name');
    }
}