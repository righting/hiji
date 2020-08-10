<?php
namespace app\admin\controller;

use app\common\model\Period as PeriodModel;

class Period extends Base
{
	/**
     * 模型
     * @var PeriodModel
     */
    protected $model;

    /**
     * constructor.
     * @param PeriodModel $model
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
        //指定2020-01-01为起始日期，28天为一期
        /*$start_time = strtotime('2020-01-01 00:00:00');
        //当前期数
        $period = ceil((time() - $start_time) / 86400 / 28);

        for ($i=1; $i <= 15; $i++) { 
            $this->model->create([
                'period_num'    => $i,
                'start_time'    => date('Y-m-d H:i:s', $start_time),
                'end_time'      => date('Y-m-d H:i:s', $start_time + 86400*27 - 1),
                'shzlr'         => 0,
                'sylr'          => 0,
                'status'        => 2,
            ]);
            $start_time = $start_time + 86400*28;
        }
        die();*/

        $with  = [];
        $order = 'id asc';
        $this->requestQuery['status'] = 1;
        $list  = $this->model->customPaginateList($this->requestQuery, $this->page, $this->listRows, $order, $with)->toArray();
        
        success($list);
    }
}