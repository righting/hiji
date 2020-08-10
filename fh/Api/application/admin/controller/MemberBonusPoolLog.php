<?php
namespace app\admin\controller;

use app\common\model\Member;
use app\common\model\MemberBonusPoolLog as MemberBonusPoolLogModel;

class MemberBonusPoolLog extends Base
{
	/**
     * 模型
     * @var MemberBonusPoolLogModel
     */
    protected $model;

    /**
     * constructor.
     * @param MemberBonusPoolLogModel $model
     */
    public function __construct(MemberBonusPoolLogModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * 列表
     * @throws DbException
     */
    public function index(Member $memberModel)
    {
        $with  = ['member'];
        $order = 'id desc';
        $list  = $this->model->customPaginateList($this->requestQuery, $this->page, $this->listRows, $order, $with)->toArray();
        foreach ($list['data'] as $k => $v) {
        	$list['data'][$k]['parent'] = $memberModel->getParentAttr('', $v);
        }
        success($list);
    }
}