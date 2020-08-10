<?php
/**
 * 会员实名认证审核
 */
defined('ByCCYNet') or exit('Access Invalid!');
class member_authControl extends SystemControl
{
    public function __construct()
    {
        parent::__construct();
    }
    public  function  indexOp(){
        Tpl::setDirquna('shop');
        Tpl::showpage('member_auth.list');
    }



    /**
     *新增 2018/04/12
     * 审核会员拒绝通过
     * */
    public function refusedAuthOp(){
        $member_id = $_POST['userId'];
        $caseInfo = $_POST['caseInfo'];
        $rs=Model('member')->refusedAuth($member_id,$caseInfo);
        echo $rs;
    }



    /**
     * 审核会员
     */
    public  function  authOp(){
        $member_id = $_GET['member_id'];
        if (!empty($member_id)){
          Model('member')->memberAuth($member_id);
        }
        $this->indexOp();
    }
    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_auth = Model('member_detail');
        $page = $_POST['rp'];
        $condition['id_card_photo']=['neq',''];
        $member_id = trim($_GET['member_id']);
        if (!empty($member_id)){
            $condition['member.member_id']=$member_id;
        }
        $member_name = trim($_GET['member_name']);
        if (!empty($member_name)){
            $condition['member.member_name']=['like','%'.$member_name.'%'];
        }
        $real_name = trim($_GET['real_name']);
        if (!empty($real_name)){
            $condition['member_detail.real_name']=['like','%'.$real_name.'%'];
        }
        $member_id_number = trim($_GET['member_id_number']);
        if (!empty($member_id_number)){
            $condition['member_detail.member_id_number']=['like','%'.$member_id_number.'%'];
        }
        $member_data =$model_auth->getMemberDetailList($condition,$page);
        $data = array();
        $data['now_page'] = $model_auth->shownowpage();
        $data['total_num'] = $model_auth->gettotalnum();
        foreach ($member_data as $value) {
            $param = array();
            if ($value['isauth']==1){
                $operation='已实名';
            }elseif($value['isauth']==2){
                $operation='已拒绝';
            }else{
                $operation="<a class='btn green' href=index.php?controller=member_auth&action=auth&member_id=" . $value['member_id'] . ">通过</a>";
                $operation.="<a class='btn red' href=JavaScript:show_auth('aic',".$value['member_id'].")>拒绝</a>";
            }
            $param['operation'] = $operation;
            $param['member_id'] = $value['member_id'];
            $param['member_name'] = $value['member_name'];
            $param['member_truename'] = $value['real_name'];
            $param['member_id_number'] = $value['member_id_number'];
            $param['id_card_photo'] ="<a href=JavaScript:show_dialog1('pic','".$value['real_name']."','".$value['member_id_number']."','".$value['id_card_photo']."','".$value['id_card_photo_back']."');>点击查看大图</a>";
            $data['list'][$value['member_id']] = $param;
        }
        echo Tpl::flexigridXML($data);exit();
    }

    public function getUserForExcelOp(){
        $member_model = Model('member');
        $all_user_id_arr = $member_model->getAllUserId();
        $arr_chunk_user_id_arr = array_chunk($all_user_id_arr,100);

        //导出Excel
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));


        foreach ($arr_chunk_user_id_arr as $k => $user_id_arr){
            foreach ($user_id_arr as $key=>$user_id){
                $excel_data[$k][$key] = array('data'=>'（序号：'.$key.'）'.$user_id);
            }
        }

        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('参加矩阵的所有用户',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('参加矩阵的所有用户',CHARSET).date('Y-m-d-H',time()));
        exit();
    }
}