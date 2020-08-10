<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 14:59
 */
class signControl
{

    public function indexOp(){

    }


    /**
     * 每日签到
     */
    public function ajaxSignOp(){
        $rs=array('status'=>-1,'msg'=>'参数错误');
        $userId = $_SESSION['member_id'];
        $model = Model();
        $start_time = date('Y-m-d 00:00:00');
        $end_time  =  date('Y-m-d 23:59:59');
        //查询用户今日是否签到
        $where['user_id']= $userId;
        $where['sign_in_time']= ['between', [$start_time, $end_time]];
        $checkInfo =  $model->table('sign_in_log')->where($where)->find();

        if(empty($checkInfo)){
            //获取签到配置
            $getSetInfo =  $model->table('setting')->where(['name'=>'sign_in_number'])->find();
            $setIncMoney=$model->table('member')->where(['member_id'=>$userId])->setInc('sign_in_money',$getSetInfo['value']); // 增加用户的海吉币
            if($setIncMoney){
                $insertArray = array();
                $insertArray['user_id'] = $userId;
                $insertArray['number'] = $getSetInfo['value'];
                $insertArray['source'] = '签到赠送';
                $insertArray['sign_in_time'] = date('Y-m-d H:i:s');
                $insertArray['content']  = '签到成功、赠送海吉币 '.$getSetInfo['value'] .' 个';
                $re=$model->table('sign_in_log')->insert($insertArray);
                if($re){
                    $rs['status']=1;
                    $rs['msg']  = $insertArray['content'];
                }
            }
        }else{
            $rs['msg'] = '您今日已经签到过了！';
        }
        echo json_encode($rs);
    }
}