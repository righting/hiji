<?php
/**
 * 我的分红中心
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class member_bonusControl extends BaseMemberControl
{
    public function __construct()
    {
        parent::__construct();
        Tpl::output('current_active_name','member_bonus');
    }

    /**
     * 我的分红
     */
    public  function  indexOp(){
        //获取本月开始的时间戳
        $beginThisMonth=mktime(0,0,0,date('m'),1,date('Y'));
        //获取本月结束的时间戳
        $endThisMonth=mktime(23,59,59,date('m'),date('t'),date('Y'));


        //统计本月分红
        $model_bonus_log = Model('user_bonus_log');
        $bonusWhere['user_id'] = $_SESSION['member_id'];
        $bonusWhere['updated_at'] = ['between',[date('Y-m-d H:i:s',$beginThisMonth),date('Y-m-d H:i:s',$endThisMonth)]];
        $bonusWhere['type'] = ['in',[1,2,3,4,5,6,7,8,9,10,11,12,17,18,19]];
        $bonus_count = $model_bonus_log->countUserBonus($bonusWhere);
        $bonus_type = Model('user_bonus')->getTypeInfo();


        //查询本月消费金额
        $orderModel = Model('orders');
        $orderWhere['buyer_id'] = $_SESSION['member_id'];
        $orderWhere['order_state'] = ['gt','10'];
        $orderWhere['refund_state'] = 0;
        $orderWhere['payment_time'] = ['between',[$beginThisMonth,$endThisMonth]];
        $orderMoney=$orderModel->where($orderWhere)->field('sum(order_amount) as totalMoney')->find();


        //查询历史分红记录
        $historyWhere['user_id']=$_SESSION['member_id'];
        $historyInfo=    $model_bonus_log->where($historyWhere)->field('updated_at')->order('updated_at desc')->select();
        $timeArray=[];
        //提取出时间如2018-05
        foreach($historyInfo as $k=>$v){
            $time = explode('-',$v['updated_at']);
            $timeArray[$k]['time']=$time[0].'-'.$time[1];
        }

        $new = $news  = array();
        foreach ($timeArray as $key => $value) {
            if(!in_array($value['time'], $new)) {
                $new[] = $value['time'];  //$new保存不重复的值
                $news[$key] = $value;   //$news保存不重复的数组值
                $userBonusWhere['user_id'] = $_SESSION['member_id'];
                $userBonusWhere['updated_at'] = ['like',"%".$value['time']."%"];
                $userBonusWhere['type'] = ['in',[1,2,3,4,5,6,7,8,9,10,11,12,17,18,19]];
                $news[$key]['info'] = $model_bonus_log->countUserBonus($userBonusWhere);
            }
        }

        //数据输出
        Tpl::output('thisMonthMoney',!empty($orderMoney['totalMoney'])?$orderMoney:'0');//本月消费金额
        Tpl::output('count',$bonus_count);//统计数据
        Tpl::output('news',$news);//统计历史数据
        Tpl::output('typeList',$bonus_type);
        Tpl::output('webTitle',' - 我的分红');
        Tpl::showpage('member_bonus.index');
    }

    /**
     * 历史分红详细列表
     */
    public function bonusDetailsOp(){
        $type = isset($_GET['type'])?$_GET['type']:'0';
        $currentTime = time();
        $cyear = floor(date("Y",$currentTime));
        $cMonth = floor(date("m",$currentTime));

        $time = array();
        for($i=0;$i<6;$i++){
            $nMonth = $cMonth-$i;
            $cyear = $nMonth == 0 ? ($cyear-1) : $cyear;
            $nMonth = $nMonth <= 0 ? 12+$nMonth : $nMonth;
            $date = $cyear."-".$nMonth."-1";
            $firstday = date('Y-m-01', strtotime($date));
            $lastday = date('t', strtotime($date));
            if(strlen($nMonth)==1){
                $nMonth = '0'.$nMonth;
            }
            $time[$i]['time']=$cyear."-".$nMonth;
            $time[$i]['day'] =  $lastday;
        }


        $model_bonus_log = Model('user_bonus_log');
        $bonusWhere['user_id'] = $_SESSION['member_id'];
        $bonusArray = array();
        //获取每月分红所有数据
        for($i=1;$i<=$time[$type]['day'];$i++){
            if(strlen($i)==1){
                $k = '0'.$i;
            }else{
                $k = $i;
            }
            $bonusWhere['updated_at'] = ['between',[$time[$type]['time'].'-'.$k.' 00:00:00',$time[$type]['time'].'-'.$k.' 23:59:59']];
            $bonusArray[$i] = $model_bonus_log->where($bonusWhere)->field('type,updated_at,money')->select();
        }


        Tpl::output('bonusArray',$bonusArray);
        Tpl::output('type',$type);
        Tpl::output('time',$time);
        Tpl::showpage('member_bonus.details');
    }









    /**
     * 查询统计分红
     */
    public function bonusSearchOp(){
      if (chksubmit()){
          $con['user_id'] =  $_SESSION['member_id'];
          if ($_POST['bonus_type']){
              $con['type'] = $_POST['bonus_type'];
          }
          if ($_POST['query_start_date']){
              $con['created_at']=['EGT',$_POST['query_start_date']];
          }
          if ($_POST['query_end_date']){
              $con['created_at']=['ELT',$_POST['query_end_date']];
          }
          $model_bonus = Model('user_bonus_log');
          $data = $model_bonus->field('type,sum(money) as money')->where($con)->group('type')->select();
          exit(json_encode($data));
      }
    }
}