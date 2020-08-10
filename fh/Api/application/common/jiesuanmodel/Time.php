<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/13 17:24
// +----------------------------------------------------------------------

namespace app\common\jiesuanmodel;

use Exception;
use think\model\concern\SoftDelete;
use app\common\jiesuanmodel\Configure;
use app\common\jiesuanmodel\TimeConversion;
use app\common\model\Base;
/**
 * 时间计算模型
 * Class Time
 * @package app\common\model
 */
class Time extends Base
{
    protected $table = 'js_config';
    //初始化时间
    private static $NstartTime;
    //当前时间
    private static $NnowTime = 0;
    //格式化时间参数
    private static $limit;

    private static $instance = null;
    //平台的初始化时间
    public static function setSartTime(){
        $time = Configure::getConfig('settlement_system_initialize_tim');
        self::$NstartTime = intval($time);
    }
    /**
    *@function static
    *@description 获取初始化时间
    *@return null
    */
   public static function Instance($time = '')
    {
        $time && self::setTime($time);
        if(self::$instance == null)self::$instance = new Time();
        return self::$instance;
    }

   /**
    *@function static
    *@description 获取时间格式化区间
    *@return null
    */
   public static function getLimit()
    {
        $list = TimeConversion::getlist();
        $list = self::getDataArray($list);
        self::$limit = $list;
    }

    /**
     *@function static
     *@description 时间转换
     *@return array
    */
     public static function getTime()
    {
        $Areturn = [];
        $Areturn['stage'] = 1;
        $Areturn['week'] = 1;

        //获取当前距离初始时间的天数
        $Nday = self::getAllDay();
        
        //获取一期总天数
        $Nstage = (self::$limit['week']*self::$limit['day']);
        if($Nday>$Nstage){
            //当前是第几期
            $Areturn['stage'] = ceil($Nday/$Nstage);
            //减去期数*天数的剩余天数，用来获取周
            $Nday = $Nday-floor($Nday/$Nstage)*$Nstage;
        }
        if($Nday>self::$limit['day']){
            $Areturn['week'] = ceil($Nday/self::$limit['day']);
            //减去周数*天数剩余天数就是第几天
            $Nday = $Nday-floor($Nday/self::$limit['day'])*self::$limit['day'];
        }
        $Areturn['day'] = $Nday;
        return  $Areturn;
    }

    /**
    *@function static
    *@description 获取当前距离初始时间的天数
    *@return float
    */
    public static function getAllDay()
    {
        //初始化时间
        self::setSartTime();
        //设置当前时间
        if(self::$NnowTime == 0)self::setTime();
        //获取时间格式化区间
        self::getLimit();
        $Ntime = self::$NnowTime-self::$NstartTime;
        $Nday = 60*60*24;
        //当前距离初始时间的天数
        $Nday = ceil($Ntime/$Nday);
        return $Nday;
    }

    /**
    *@function static
    *@description 获取周时间区间
    *@param $week int 数量代表几个周，数为负数则是前几周，数为正则是下几周[-1：上一周；-2：上上周，0：当前周，1：下一周；2：下下周]
    *@return array
    */
   public static function getWeek($week = 0)
    {
         $Aarr = [];
         //获取初始化时间
         self::setSartTime();
         //设置当前时间
         if(self::$NnowTime == 0)self::setTime();
         //获取时间格式化区间
         self::getLimit();
        if(self::$NnowTime < self::$NstartTime){
            $Aarr = self::smallStartTime();
        }else{
            $Aarr = self::bigStartTime($week);
        }
        return $Aarr;
    }

     /**
    *@function static
    *@description 获取周(设置的当前时间小于距离初始时间的天数)
    *@return array
    */
    public static function smallStartTime()
     {
        $Aarr = [];
        $Aarr['start'] = date('Y-m-d H:i:s',self::$NstartTime);
        $Aarr['end'] = '';
        //一天的时间戳
        $NtimeStamp = 60*60*24;
        //当前周过了多少天的时间戳
        $Nend = self::$limit['day']*$NtimeStamp+self::$NstartTime;
        $Nend = date('Y-m-d',$Nend);
        $Aarr['end'] = $Nend.' 23:59:59';
        $Aarr['error'] = 1;
        $Aarr['message'] = '当前时间小于平台开始时间（初始化时间），返回初始化第一周时间区间。';
        return $Aarr;
     }

    /**
    *@function static
    *@description 获取周(设置的当前时间大于距离初始时间的天数)
    *@param $week int 数量代表几个周，数为负数则是前几周，数为正则是下几周
    *@return array
    */
    public static function bigStartTime($week = 0)
    {
        $Aarr = [];
        $Aarr['start'] = '';
        $Aarr['end'] = '';
        
        $Ntime = self::$NnowTime-self::$NstartTime;
        //一天的时间戳
        $NtimeStamp = 60*60*24;
        //当前距离初始时间的天数
        $NallDay = floor($Ntime/$NtimeStamp);

        //一共几个周
        $Nweek = ($NallDay>self::$limit['day'])?floor($NallDay/self::$limit['day']):0;
        //今天是当前周的第几天
        $Nday = ($Nweek>0)?($NallDay-$Nweek*self::$limit['day']):$NallDay;
        //当前周过了多少天的时间戳
        $NnextWeekLastDay = $Nday*$NtimeStamp;
        //当前周开始时间时间戳
        $NStartTime = self::$NnowTime-$NnextWeekLastDay;
        //计算当前周
        if($week == 0){
            $Stime = date('Y-m-d',$NStartTime);
            $Aarr['start'] = $Stime.' 00:00:01';
             //如果是当前周则当前时间为结束时间(如果设置的时间大于或者等于当前时间则设置时间为最后时间)
            if(self::$NnowTime>=time()){
                $Aarr['end'] = date('Y-m-d H:i:s',self::$NnowTime);
            }else{
                //如果小于当前时间则计算开始时间+7天的时间戳是否大于当前时间，如果小于当前时间则为最后时间，否则是当前时间为最后时间
                $Stime = strtotime($Aarr['start'])+(self::$limit['day']-1)*$NtimeStamp;
                $Stime = ($Stime>time())?time():$Stime;
                $Aarr['end'] = date('Y-m-d',$Stime).' 23:59:59';
            }
        }elseif($week != 0){//计算上几周或者下几周
            //周的时间戳倍数
            $NnextWeekTime = self::$limit['day']*$week*$NtimeStamp;
            //查询周开始时间
            $NStartTime = $NStartTime+$NnextWeekTime;
            //查询周结束时间
            $NendTime = $NStartTime+$NtimeStamp*(self::$limit['day']-1);
            $Aarr['start'] = date('Y-m-d',$NStartTime).' 00:00:01';
            $Aarr['end'] = date('Y-m-d',$NendTime).' 23:59:59';
        }
        return $Aarr;
    }

    /**
     *@function static
     *@description 当前期时间区间[-1：上一期；-2：上上期，0：当前期，1：下一期；2：下下期]
     *@return null
    */
    public static function getStageTime($site = 0)
    {
        $Aarr = [];
        $Aarr['start'] = '';
        $Aarr['end'] = '';
        $Aarr['message'] = [];
        //一天的时间戳
        $NtimeStamp = 60*60*24;
        //获取当前距离初始时间的天数
        $Nday = self::getAllDay();
        $NweekDay = 0;
        //获取一期总天数
        $Nstage = (self::$limit['week']*self::$limit['day'])-1;

        if($Nday>$Nstage){
            //当前是第几期
            $stage = floor($Nday/$Nstage);
            //减去期数*天数的剩余天数，用来获取周
            $Nday = $Nday-$stage*$Nstage;
        }
        if($Nday>self::$limit['day']){
            //已经过了几个周
            $week = floor($Nday/self::$limit['day']);
            //当前已经过的周一共多少天
            $NweekDay = $week*self::$limit['day'];
            //减去周数*天数剩余天数就是第几天
            $Nday = $Nday-$week*self::$limit['day'];
        }
        //当前周过了几天+当前已经过了几个周的天数
        $Nday = $Nday+$NweekDay-1;
        //当已经过了当前期多少天的时间戳
        $Ntime = $Nday*$NtimeStamp;
        $NstartTime = 0;
        $NendTime = 0;
        //当前期的开始时间戳
        $NstartTime = self::$NnowTime - $Ntime;

        if($site == 0){
            $NendTime = $NstartTime+$Nstage*$NtimeStamp;
            $Aarr['start'] = date('Y-m-d',$NstartTime).' 00:00:01';
            $Aarr['end'] = date('Y-m-d',$NendTime).' 23:59:59';
        }elseif($site != 0){
            //期的时间戳倍数
            $Nday = ($Nstage+1)*$NtimeStamp*$site;
            $NstartTime += $Nday;
            $NendTime = $NstartTime+($Nstage*$NtimeStamp);
        }
         $Aarr['start'] = date('Y-m-d',$NstartTime).' 00:00:01';
         $Aarr['end'] = date('Y-m-d',$NendTime).' 23:59:59';
        return $Aarr;
    }

    /**
     *@function static
     *@description 设置当前时间
     *@param $stime [string(2020-07-15 00:00:01)|int(1594742400)]
     *@return null
    */
    public static function setTime($Stime = '')
    {   
        //初始化时间
        self::setSartTime();
        if(!$Stime){
            self::$NnowTime = time();
        }else{
           //判断设置的时间是数字还是字符串格式分别设置
           if(is_numeric($Stime)){
             $Stime = date('Y-m-d H:i:s',$Stime);
             $Atime = explode(':',$Stime);
             if($Atime[2]<=1)$Atime[2] = '02';
             $Stime = strtotime(implode(':',$Atime));
             self::$NnowTime = $Stime;
           }
           if(!is_numeric($Stime)){
            $Atime = explode(':',$Stime);
            if(count($Atime) == 1)$Stime = $Stime.' 00:00:02';
            self::$NnowTime = strtotime($Stime);
           }
        }
    }


    /**
     *@function static
     *@description 检测当前时间是第几期第几周第几天
     *@param $stime [string(2020-07-15 00:00:01)|int(1594742400)]
     *@return null
    */
    public static function checkTime($Stime = '')
    {
        $Stime && self::setTime($Stime);
        return self::getTime();
         
    } 


    /**
    *@function static
    *@description 上一周
    *@return array
    */
    public static function prevWeek()
    {
        !self::$NnowTime && self::setTime();
        return self::getWeek(-1);
    }


    /**
    *@function static
    *@description 下一周
    *@return array
    */
    static function nextWeek()
    {
        !self::$NnowTime && self::setTime();
        return self::getWeek(1);
    }

    /**
    *@function static
    *@description 上一期
    *@return array
    */
    public static function prevStage()
    {
        !self::$NnowTime && self::setTime();
        return self::getStageTime(-1);
    }


    /**
    *@function static
    *@description 下一期
    *@return array
    */
    public static function nextStage()
    {
        !self::$NnowTime && self::setTime();
        return self::getStageTime(1);
    }
}