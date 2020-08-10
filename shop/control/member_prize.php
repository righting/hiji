<?php
/**
 * 买家 我的实物订单
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class member_prizeControl extends BaseMemberControl {

    public function __construct() {
        parent::__construct();
        Language::read('member_member_index');
        Tpl::output('current_active_name','member_prize');
    }

    /**
     * 个人中心 抽奖中奖记录
     *
     */
    public function indexOp() {
        $prize_record = Model('prize_record');
        $userId  = $_SESSION['member_id'];
        //获取订单信息
        $info=$prize_record->where(['uid'=>$userId])->order('id desc')->page(10)->select();
        Tpl::output('show_page',$prize_record->showpage());
        Tpl::output('info',$info);
        Tpl::output('webTitle',' - 我的中奖记录');
        Tpl::showpage('member_prize.index');
    }



    /**
     * 提交联系资料
     */
    public function bindingOp(){
		$id = $_POST['id'];
		if(!$id || $id<1){
			$rs['status']=1;
			$rs['msg'] = '非法操作';
			echo json_encode($rs);exit;
		}
		$rs = array();
        $prize_record = Model('prize_record');
		$data = array();
		$data['name']  = $_POST['name'];
		$data['addres']  = $_POST['addres'];
        $data['mobile'] = intval($_POST['mobile']);
		if(empty($data['name'])){
			$rs['status']=1;
			$rs['msg'] = '请填写联系人';
			echo json_encode($rs);exit;
		}
		if(empty($data['addres'])){
			$rs['status']=1;
			$rs['msg'] = '请填写收货地址';
			echo json_encode($rs);exit;
		}
		if(empty($data['mobile'])){
			$rs['status']=1;
			$rs['msg'] = '请填写联系人电话';
			echo json_encode($rs);exit;
		}
		$re=$prize_record->where(['id'=>$id])->update($data);
		if($re){
			$rs['status']=1;
			$rs['msg'] = '提交成功';
		}else{
			$rs['status']='-1';
			$rs['msg'] = '提交失败';
		}
        echo json_encode($rs);
    }




}
