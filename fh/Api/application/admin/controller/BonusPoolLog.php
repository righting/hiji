<?php
namespace app\admin\controller;

use app\common\model\Period as PeriodModel;

class Period extends Base
{
	/**
     * 模型
     * @var BonusPoolLogModel
     */
    protected $model;

    /**
     * constructor.
     * @param BonusPoolLogModel $model
     */
    public function __construct(PeriodModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * 列表
     * @throws DbException
     */
    public function index()
    {
        $with  = [];
        $order = 'id desc';
        $list  = $this->model->customPaginateList($this->requestQuery, $this->page, $this->listRows, $order, $with)->toArray();
        
        success($list);
    }
}