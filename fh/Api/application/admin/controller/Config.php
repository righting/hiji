<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/13 17:40
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\model\Config as ConfigModel;
use think\exception\DbException;
use think\Cache;

/**
 * 配置控制器
 * Class Battery
 * @package app\admin\controller
 */
class Config extends Base
{
    /**
     * 模型
     * @var BatteryModel
     */
    protected $model;

    /**
     * Config constructor.
     * @param ConfigModel $model
     */
    public function __construct(ConfigModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * 列表
     * @throws DbException
     */
    public function info()
    {
        //KBMVFILSGWIUSFVU
        $info = ConfigModel::getConfig();
        success($info);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $info = ConfigModel::getConfig();
        foreach ($this->param as $k => $v) {
            if (isset($info[$k]) && $info[$k] != $v) {
                ConfigModel::where('name', $k)->update(['value' => $v]);
            }
        }
        // 清空配置缓存
        Cache::clear('sys_config');
        success();
    }
}