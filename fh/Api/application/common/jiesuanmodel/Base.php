<?php

namespace app\common\jiesuanmodel;

use PDOStatement;
use think\Collection;
use think\Config;
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
	protected $connection = [];
    // 软删除字段
    protected $deleteTime = 'delete_time';

    // 软删除字段默认值
    protected $defaultSoftDelete = 0;

    // 允许搜索的字段
    protected $searchField = [];

    // 允许作为查询条件的字段
    protected $whereField = [];

    public function __construct($data = [])
    {
    	$this->connection = Config::get('db_jiesuan_config');
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