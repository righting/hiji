<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/16 10:21
// +----------------------------------------------------------------------

namespace app\common\jiesuanmodel;

use think\Cache;
use app\common\jiesuanmodel\Configure;
use app\common\jiesuanmodel\OrderUnlockLog;
use app\common\haijimodel\Orders;

/**
 * 时间自动解冻
 * Class 
 * @package app\common\model
 */
class OrderAutoThaw extends Base
{
	private static ?array $Atime = [];
	//当前分页
	private static int $NcurrentPage = 1;
	//总页数
	private static int $NtotalPage = 0;
	//每次循环解冻数量（分页）
	private static int $Nlimit = 100;
	//需要解冻的订单总数量
	private static int $Ntotal = 0;
	//一共执行了解冻订单条目
	private static int $unLockTotal = 0;
	//查询条件
	private static ?array $Awhere = [];
	//查询条件
	private static string $Sorder = 'order_id desc';
	//获取自动解冻时间
	private static function getThawTime():void
	{
		$Nday = Configure::getConfig('order_unfreezing_time');
		$Ntime = 60*60*24;
		$Ntime = $Ntime*intval($Nday);
		$Ndate = time()-$Ntime;
		$Sdate = date('Y-m-d',$Ndate);
		$SstartDate = $Sdate.' 00:00:01';
		$SendDate = $Sdate.' 23:59:59';
		self::$Atime['start'] = strtotime($SstartDate);
		self::$Atime['end'] = strtotime($SendDate);
	}

	//获取订单总量
	private static function getOrderTotal():void
	{
		self::getThawTime();
		self::$Awhere['lock_state'] = ['>',0];
		self::$Awhere['finnshed_time'] = ['>',self::$Atime['start']];
		self::$Awhere['finnshed_time'] = ['<',self::$Atime['end']];
		self::$Ntotal = Orders::where(self::$Awhere)->count();
		self::$NtotalPage = ceil(self::$Ntotal/self::$Nlimit);
	}

	//获取订单列表
	private static function getOrderList():array
	{
		//优化limit查询
		if(self::$NcurrentPage>1){
			$Nstart = self::$NcurrentPage*self::$Nlimit;
			$Ssql = Orders::where(self::$Awhere)->field('order_id')->order(self::$Sorder)->limit($Nstart,1)->buildSql();
			self::$Awhere['order_id'] = ['>=',$Ssql];
		}
		$Olist = Orders::where(self::$Awhere)->order(self::$Sorder)->limit(self::$Nlimit)->select();
		$Alist = self::getDataArray($Olist);
		return $Alist;
	}

	//开始设置订单操作（惠普分红+解冻）
	public static function doCrontab():bool
	{
		self::getOrderTotal();
		self::setOrder();
		return true;
	}

	//设置订单
	private static function setOrder(){
		$list = self::getOrderList();
		foreach($list as $k=>$v){
			self::unLock($v);
		}
		//记录当前分页
		self::$NcurrentPage = self::$NcurrentPage+1;
		if(self::$NcurrentPage<=self::$NtotalPage){
			self::setOrder();
		}
	}

	//设置订单解锁
	private static function unLock(array $order = []):void
	{
		$ALogInfo = [];
		$ALogInfo['start_time'] = time();
		$ALogInfo['order_sn'] = $order['order_sn'];
		$result = Orders::where(['order_id'=>$order['order_id']])->update(['lock_state'=>0,'order_state'=>40]);
		$ALogInfo['end_time'] = time();
		//添加解锁日志
		self::unLockLog($ALogInfo);
		unset($ALogInfo);

		//累加设置订单条目
		$result && self::$unLockTotal = self::$unLockTotal+1;
	}

	//日志记录
	private static function unLockLog(array $ALogInfo = [])
	{
		$ALogInfo['crontab_time'] = date('Y-m-d H:i:s',time());
		$ALogInfo['unlock_type'] = 1;
		OrderUnlockLog::create($ALogInfo);
	}
}