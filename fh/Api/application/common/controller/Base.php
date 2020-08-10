<?php

namespace app\common\controller;

use think\Request;

/**
 * 公共基础控制器
 * Class Base
 * @package app\common\controller
 */
class Base
{
    /**
     * 当前用户id
     * @var int
     */
    protected $uid = 0;

    /**
     * 页码
     * @var int
     */
    protected $page;

    /**
     * 每页显示数
     * @var int
     */
    protected $listRows;

    /**
     * GET/POST参数
     * @var array
     */
    protected $param;

    /**
     * 过滤掉空字符串，null，false等元素后的GET/POST参数
     * @var array
     */
    protected $requestQuery = [];

    /**
     * 请求对象
     * @var Request
     */
    protected $request;

    /**
     * 初始化基础控制器
     * @author Jimlin <284174212@qq.com>
     */
    public function __construct()
    {
        // 获取GET/POST参数
        //$data       = file_get_contents('php://input');
        //$this->param = $data ? json_decode($data, true) : [];
        $this->param = Request::instance()->param();

        // 获取GET/POST参数，保留非空元素及数字0、字符串0
        $this->requestQuery = array_filter($this->param, function ($value) {
            return ($value === 0 || $value == '0' || $value != false) ? true : false;
        });

        $this->page     = isset($this->param['page']) ? intval($this->param['page']) : 0;
        $this->listRows = isset($this->param['limit']) ? intval($this->param['limit']) : 15;
    }

    

}