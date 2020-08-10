<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31
 * Time: 16:30
 */
class bankControl{
    /**
     * 银行卡管理
     */
    public function userBankListOp(){
        //获取所有银行卡信息
        $model = Model();
        $bankInfo=$model->table('member_bank')->where(['user_id'=>$_SESSION['member_id'],'status'=>1])->order('is_default desc,id asc')->select();
        Tpl::output('bankInfo',$bankInfo);
        Tpl::showpage('user_bank_list','null_layout');
    }

    /**
     * 添加、修改银行卡信息页
     */
    public function userEditBankOp(){

        Tpl::showpage('user_edit_bank','null_layout');
    }


    /**
     * 添加、修改银行卡信息
     */
    public function editBankOp(){
        $rs = -1;
        $post = $_POST['params'];
        $id = isset($post['id'])?intval($post['id']):'';
        $userId = $_SESSION['member_id'];
        $model = Model();
        $data = array();
        $data['user_id'] = $userId;
        $data['bank_name'] = htmlentities($post['bankName']);
        $data['bank_card_number'] = htmlentities($post['bankCard']);
        $data['bank_user_name'] = htmlentities($post['bankUserName']);
        $data['bank_phone'] = htmlentities($post['bankPhone']);
        $data['is_default'] = htmlentities($post['isDefault']);
        if($data['is_default']==1){
            $model->table('member_bank')->where(['user_id'=>$userId])->update(['is_default'=>0]);
        }
        if(empty($id)){
            $data['create_time']= date('Y-m-d H:i:s');
            $re=$model->table('member_bank')->insert($data);
            if($re){
                $rs=1;
            }
        }
        echo $rs;
    }

    /**\
     * 设置为默认提现卡
     */
    public function selectedDefaultOp(){
        $rs = -1;
        $id = isset($_POST['id'])?intval($_POST['id']):'';
        $userId = $_SESSION['member_id'];
        $model = Model();
        if(!empty($id)){
            $close=$model->table('member_bank')->where(['user_id'=>$userId])->update(['is_default'=>0]);
            if($close){
                $re=$model->table('member_bank')->where(['user_id'=>$userId,'id'=>$id])->update(['is_default'=>1]);
                if($re){
                    $rs=1;
                }
            }
        }
        echo $rs;
    }

    /**
     * 隐藏银行卡
     */
    public function deleteBankOp(){
        $rs = -1;
        $id = isset($_POST['id'])?intval($_POST['id']):'';
        $userId = $_SESSION['member_id'];
        $model = Model();
        if(!empty($id)){
            $re=$model->table('member_bank')->where(['user_id'=>$userId,'id'=>$id])->update(['status'=>0]);
            if($re){
                $rs=1;
            }
        }
        echo $rs;
    }

}