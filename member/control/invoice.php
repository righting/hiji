<?php
/**
 * 预存款管理
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class invoiceControl extends BaseMemberControl {
    public function __construct(){
        parent::__construct();
        Tpl::output('current_active_name','invoice');
    }

    /**
     * 发票管理
     */
    public function indexOp(){

        $invoice_model = Model('invoice');
        $user_id = $_SESSION['member_id'];
        $this_user_invoice_money_info = $invoice_model->getUserInvoicesCanBeOpened($user_id);
//        print_r($this_user_invoice_money_info);die;

        $model = Model('user_invoice_info');
        // 检查当前用户是否已经填写发票信息
        $info = $model->where(['user_id'=>$user_id])->find();
        if(!empty($info)){
            $info['type_cn'] = $model->geTypeInfo($info['type']);
            if(intval($info['sbh_type']) > 0){
                $info['sbh_type_cn'] = $model->geSBHTypeInfo($info['sbh_type']);
            }
        }

        // 获取当前用户的默认收货地址
        $address_class = Model('address');
        $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id'],'is_default'=>1))->find();
        if(empty($address_info)){
            $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id']))->find();
        }

        $list = $invoice_model->where(['user_id'=>$user_id])->page(15)->order('created_at desc')->select();

        $status_info[1] = '申请中';
        $status_info[2] = '已开';

        //猜你喜欢
        $user_id = $_SESSION['member_id'];
        $likeGoods = Model('goods_browse')->getGuessLikeGoods($user_id);
        $likeGoods = array_slice($likeGoods,0,5);

        Tpl::output('likeGoods',$likeGoods);
        Tpl::output('list',$list);
        Tpl::output('show_page',$invoice_model->showpage());
        Tpl::output('this_user_invoice_money_info',$this_user_invoice_money_info);// 用户发票信息
        Tpl::output('info',$info);
        Tpl::output('address',$address_info);
        Tpl::output('status_info',$status_info);
        Tpl::output('webTitle',' - 我的发票');
        Tpl::showpage('invoice/index');
    }

    public function infoOp(){
        $id = intval($_GET['id']);
        $user_id = $_SESSION['member_id'];
        $invoice_model = Model('invoice');
        $info = $invoice_model->where(['user_id'=>$user_id,'id'=>$id])->find();
        if(empty($info)){
            showMessage('信息不存在');
        }

        //猜你喜欢
        $user_id = $_SESSION['member_id'];
        $likeGoods = Model('goods_browse')->getGuessLikeGoods($user_id);
        $likeGoods = array_slice($likeGoods,0,5);

        Tpl::output('likeGoods',$likeGoods);

        $model = Model('user_invoice_info');
        $info['type_cn'] = $model->geTypeInfo($info['type']);
        if(intval($info['sbh_type']) > 0){
            $info['sbh_type_cn'] = $model->geSBHTypeInfo($info['sbh_type']);
        }
        $status_info[1] = '申请中';
        $status_info[2] = '已开';
        $info['status_cn'] = $status_info[$info['status']];
        Tpl::output('info',$info);
        Tpl::showpage('invoice/info');
    }



    public function applyOp(){
        $invoice_model = Model('invoice');
        $user_id = $_SESSION['member_id'];
        $this_user_invoice_money_info = $invoice_model->getUserInvoicesCanBeOpened($user_id);
//        print_r($this_user_invoice_money_info);die;

        $model = Model('user_invoice_info');
        // 检查当前用户是否已经填写发票信息
        $info = $model->where(['user_id'=>$user_id])->find();
        $info['type_cn'] = $model->geTypeInfo($info['type']);
        if(intval($info['sbh_type']) > 0){
            $info['sbh_type_cn'] = $model->geSBHTypeInfo($info['sbh_type']);
        }
        // 获取当前用户的默认收货地址
        $address_class = Model('address');
        $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id'],'is_default'=>1))->find();
        if(empty($address_info)){
            $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id']))->find();
        }
        Tpl::output('this_user_invoice_money_info',$this_user_invoice_money_info);// 用户发票信息
        Tpl::output('info',$info);
        Tpl::output('address',$address_info);
        Tpl::showpage('invoice/apply');
    }



    public function apply_saveOp(){

        $type = $_POST['type'];
        $invoiceType = $_POST['invoice_type'];
        $money = $_POST['money'];
        $title = $_POST['title'];
        $linkMan = $_POST['true_name'];
        $linkMobile = $_POST['mob_phone'];
        $linkAddress = $_POST['address'];

        $number = $_POST['sbh_number'];
        $bankName = $_POST['bank_name'];
        $bankAccount = $_POST['bank_account'];



        $invoice_model = Model('invoice');
        $user_id = $_SESSION['member_id'];
        $this_user_invoice_money_info = $invoice_model->getUserInvoicesCanBeOpened($user_id);
        if(($money < 0) || ($money > $this_user_invoice_money_info['can_be_opened_money'])){
            showDialog('请输入正确的开票金额','','error');
        }
        $data['user_id'] = $user_id;
        $data['type'] = $type;
        $data['invoice_type'] = $invoiceType;
        $data['title'] = $title;
        $data['link_man'] = $linkMan;
        $data['link_mobile'] = $linkMobile;
        $data['link_address'] = $linkAddress;
        $data['money'] = $money;
        $data['created_at'] = date('Y-m-d H:i:s');


        if($type==2){
            $data['number'] = $number;
            $data['sbh_type'] = 3;
            $data['bank_name'] = $bankName;
            $data['bank_account'] = $bankAccount;
        }

        if($invoice_model->insert($data)){
            showDialog('申请成功',urlMember('invoice','index'));die;
        }
    }




   /* public function apply_saveOp(){
        if (chksubmit()) {
            $money = floatval($_POST['amount']);
            $invoice_model = Model('invoice');
            $user_id = $_SESSION['member_id'];
            $this_user_invoice_money_info = $invoice_model->getUserInvoicesCanBeOpened($user_id);
            if(($money < 0) || ($money > $this_user_invoice_money_info['can_be_opened_money'])){
                showDialog('请输入正确的开票金额','','error');
            }
            $model = Model('user_invoice_info');
            // 检查当前用户是否已经填写发票信息
            $info = $model->where(['user_id'=>$user_id])->find();
            if(empty($info)){
                showDialog('请先完善发票信息','','error');
            }

            // 获取当前用户的默认收货地址
            $address_class = Model('address');
            $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id'],'is_default'=>1))->find();
            if(empty($address_info)){
                $address_info = $address_class->where(array('member_id'=>$_SESSION['member_id']))->find();
                if(empty($address_info)){
                    showDialog('请先完善地址信息','','error');
                }
            }
            $data['user_id'] = $user_id;
            $data['type'] = $info['type'];
            $data['title'] = $info['title'];
            $data['sbh_type'] = $info['sbh_type'];
            $data['number'] = $info['number'];
            $data['link_man'] = $address_info['true_name'];
            $data['link_mobile'] = $address_info['mob_phone'];
            $data['link_address'] = $address_info['area_info'].''.$address_info['address'];
            $data['money'] = $money;
            $data['created_at'] = date('Y-m-d H:i:s');
            if($invoice_model->insert($data)){
                showDialog('申请成功',urlMember('invoice','index'));die;
            }
            showDialog('请求异常，请联系客服',urlMember('invoice','index'));die;
        }
    }*/



    public function editOp(){
        $close_type = 'invoice_edit';
        Tpl::output('close_type',$close_type);
        Tpl::showpage('invoice/edit','null_layout');
    }

    public function saveOp(){
        if (chksubmit()) {
            $post = $_POST;
            $type = intval($post['type']);
            if(!in_array($type,[1,2])){
                showDialog('请求异常','','error');
            }
            $title = trim($post['title']);
            if($title == ''){
                showDialog('请填写发票抬头','','error');
            }
            $sbh_type = 0;
            $number = '';
            if($type == 2){
                $sbh_type = intval($post['sbh_type']);
                if(!in_array($sbh_type,[1,2])){
                    showDialog('请求异常','','error');
                }
                $number = trim($post['number']);
                if($number == ''){
                    showDialog('请填写纳税人识别号','','error');
                }
            }
            $user_id = $_SESSION['member_id'];
            $data['type'] = $type;
            $data['title'] = $title;
            $data['sbh_type'] = $sbh_type;
            $data['number'] = $number;
            $model = Model('user_invoice_info');
            // 检查当前用户是否已经填写发票信息
            $info = $model->where(['user_id'=>$user_id])->find();
            if($info){
                // 如果是，则修改
                $model->where(['id'=>$info['id'],'user_id'=>$user_id])->update($data);
                showDialog('修改成功','reload');die;
            }
            $data['user_id'] = $user_id;
            // 如果不是，则新增
            $model->insert($data);
            showDialog('添加成功','reload');die;
        }


    }
}
