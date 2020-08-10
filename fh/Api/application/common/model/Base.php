<?php

namespace app\common\model;

use PDOStatement;
use think\Collection;
use think\db\Query;
use think\exception\DbException;
use think\Model;
use think\model\relation\BelongsTo;
use think\Paginator;
use think\Request;

/**
 * 公共基础模型
 * Class Model
 * @package app\common\model
 */
class Base extends Model
{
    // 开启自动写入时间戳字段
    //protected $autoWriteTimestamp = true;

    // 软删除字段
    protected $deleteTime = 'delete_time';

    // 软删除字段默认值
    protected $defaultSoftDelete = 0;

    // 允许搜索的字段
    protected $searchField = [];

    // 允许作为查询条件的字段
    protected $whereField = [];

    // 查询缓存名后缀
    protected $cacheSuffix = 'powerfox_';

    // 请求对象
    protected $request;

    // 当前用户
    protected $uid;

    // 数据缓存时间
    protected $cacheTime = 86400;

    // 页码
    protected $page;

    // 每页显示数
    protected $listRows;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->request   = Request::instance();
        $this->uid       = $this->request->param('uid/d', 0);
        $this->page      = $this->request->param('page/d', 1);
        $this->listRows  = $this->request->param('limit/d', 15);
    }

    // 模型初始化
    public static function init()
    {
        
    }

    /**
     * 构造查询条件
     * @param $param
     */
    protected function paraseSearch($param = [])
    {
        if (count($param) > 0) {
            // 时间范围查询
            if (isset($param['time_range'])) {
                $range = explode(' - ', $param['time_range']);
                $this->where(function ($query) use ($range) {
                    $query->whereTime('create_time', 'between', $range);
                });
            }

            // 关键词like搜索
            if (isset($param['keyword']) && count($this->searchField) > 0) {
                $this->searchField = implode('|', $this->searchField);
                $this->whereLike($this->searchField, '%' . $param['keyword'] . '%');
            }

            // 字段条件查询
            if (count($this->whereField) > 0) {
                foreach ($param as $key => $value) {
                    if (in_array($key, $this->whereField)) {
                        $this->where($key, $value);
                    }
                }
            }

        }
    }

    /**
     * 通用删除数据
     * @param int|array|string $id 数据id，格式：1或者[1,2,3]或者1,2,3
     * @return bool
     */
    public function del($id)
    {
        $ids = ids_to_array($id);
        return !empty($ids) ? $this::destroy($ids) : false;
    }

    /**
     * 模型通用分页
     * @param array $param    查询条件
     * @param int   $page     页码
     * @param int   $listRows 每页数量
     * @param mixed $order    排序
     * @param mixed $with     关联预载入
     * @return Paginator
     * @throws DbException
     */
    public function customPaginateList($param = [], $page = 1, $listRows = 10, $order = '', $with = '')
    {
        $model = $this;
        $this->paraseSearch($param);
        !$order && $order = 'id desc';
        $with && $model = $model->with($with);
        $order && $model = $model->order($order);

        $list = $model
            ->paginate($listRows, false, ['list_rows' => $listRows, 'page' => $page, 'query' => $param]);

        return $list;
    }
    public static function getDataArray($object){
       return  collection($object)->toArray();
    }  

}