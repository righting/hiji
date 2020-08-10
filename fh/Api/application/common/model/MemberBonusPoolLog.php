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
 * 会员分红日志模型
 * Class MemberBonusPoolLog
 * @package app\common\model
 */
class MemberBonusPoolLog extends Base
{
    protected $type = [
        'add_time' => 'timestamp'
    ];

    // 允许搜索的字段
    protected $searchField = ['name'];

    // 允许作为查询条件的字段
    protected $whereField = ['name'];

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

            if (!empty($param['member_number'])) {
                $member_ids = Member::whereLike('member_number', '%' . $param['member_number'] . '%')->column('member_id');
                $this->where('member_id', 'in', $member_ids);
            }

            if (!empty($param['start_time'])) {
                $this->where('add_time', 'egt', strtotime($param['start_time']));
            }

            if (!empty($param['end_time'])) {
                $this->where('add_time', 'lt', strtotime($param['end_time']) + 86400);
            }

        }
    }

    /**
     * 关联会员
     * @return HasMany
     */
    public function member()
    {
        return $this->belongsTo('member', 'member_id')->field('member_id,member_number,member_name');
    }
}