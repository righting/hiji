<?php

namespace app\common\haijimodel;

use PDOStatement;
use think\Collection;
use think\db\Query;
use think\Config;
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
        $this->connection = Config::get('db_shop_config');
        parent::__construct($data);
    }

    // 模型初始化
    public static function init()
    {
        
    }
    public static function getDataArray($object){
       return  collection($object)->toArray();
    } 

}