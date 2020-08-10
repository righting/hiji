<?php
/**
 * 预存款管理
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class predepositControl extends BaseMemberControl {
    public function __construct(){
        parent::__construct();
        Language::read('member_predeposit');
       // Tpl::setLayout('new_member_layout');
        Tpl::output('current_active_name','predeposit');
    }

    /**
     * 充值添加
     */
    public function recharge_addOp(){
        if (!chksubmit()){
            //信息输出
            self::profile_menu('recharge_add','recharge_add');
            Tpl::showpage('predeposit.pd_add');
            exit();
        }
        $pdr_amount = abs(floatval($_POST['pdr_amount']));
        if ($pdr_amount <= 0) {
            showMessage(Language::get('predeposit_recharge_add_pricemin_error'),'','html','error');
        }
        $model_pdr = Model('predeposit');
        $data = array();
        $data['pdr_sn'] = $pay_sn = $model_pdr->makeSn();
        $data['pdr_member_id'] = $_SESSION['member_id'];
        $data['pdr_member_name'] = $_SESSION['member_name'];
        $data['pdr_amount'] = $pdr_amount;
        $data['pdr_add_time'] = TIMESTAMP;
        $insert = $model_pdr->addPdRecharge($data);
        if ($insert) {
            //转向到商城支付页面
            redirect(SHOP_SITE_URL . '/index.php?controller=buy&action=pd_pay&pay_sn='.$pay_sn);
        }
    }


    /**
     * 充值添加
     */
    public function transferOp(){
        if (!chksubmit()){
            // 获取当前用户的可转账金额
            $member_model = Model('member');
            $user_id = $_SESSION['member_id'];
            $user_info = $member_model->where(['member_id'=>$user_id])->field('available_predeposit')->find();
            $user_money = $user_info['available_predeposit'];

            //信息输出
            Tpl::output('user_money',$user_money);
            self::profile_menu('transfer','transfer');
            Tpl::showpage('predeposit.transfer');
            exit();
        }
        if (chksubmit()){
        $post = $_POST;
        $obj_validate = new Validate();
        $amount = abs(floatval($post['amount']));
        $validate_arr[] = array("input"=>$amount, "require"=>"true",'validator'=>'Compare','operator'=>'>=',"to"=>'0.01',"message"=>Language::get('predeposit_cash_add_pricemin_error'));
        $validate_arr[] = array("input"=>$post["user_id"], "require"=>"true","message"=>'用户id不能为空');
        $validate_arr[] = array("input"=>$post["password"], "require"=>"true","message"=>'请输入支付密码');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate->validate();
        if ($error != ''){
            showDialog($error,'','error');
        }
        // 检查会员member_number
        $member_number = trim($post['user_id']);
        $member_model = Model('member');
        $where['member_number'] = $member_number;
        $info = $member_model->where($where)->field('member_id,member_number,member_name,member_nickname')->find();
        $transfer_money_member_id = $info['member_id'];
        if(empty($info)){
            showDialog('会员ID不存在，请确认后再试','','error');
        }

        // 检查会员转账金额是否充足
        $user_id = $_SESSION['member_id'];
            if($transfer_money_member_id == $user_id){
                showDialog('不能给自己转账','','error');
            }
        $user_info = $member_model->where(['member_id'=>$user_id])->field('available_predeposit,member_paypwd,member_nickname,member_number')->find();
        $user_money = $user_info['available_predeposit'];
        $member_pay_password = $user_info['member_paypwd'];
        $transfer_money = $amount;
        if($user_money < $transfer_money){
            showDialog('可用金额不足','','error');
        }
        // 检查会员支付密码
        $post_pay_password = $post['password'];
       /* if(hj_password_verify($post_pay_password,$member_pay_password)){
            showDialog('支付密码错误','','error');
        }*/
        if (md5($post_pay_password) != $member_pay_password) {
            showDialog('支付密码错误','','error');
        }

        try {
            Db::beginTransaction();
            // 扣除当前会员的可用预存款
            $member_model->where(['member_id'=>$user_id])->setDec('available_predeposit',$transfer_money);
            // 增加收款会员的可用预存款
            $member_model->where(['member_id'=>$transfer_money_member_id])->setInc('available_predeposit',$transfer_money);
            // 记录预存款变更日志
            // 减少可用金额日志
            $set_dec_data['lg_member_id'] = $user_id;    // 用户id
            $set_dec_data['lg_type'] = 'transfer_to_user';            // 类型
            $set_dec_data['lg_av_amount'] = '-'.$transfer_money;  // 金额
            $set_dec_data['lg_add_time'] = time();                // 添加时间
            $set_dec_data['lg_desc'] = '转账给会员: '.$info['member_name'].'(会员 ID ：'.$info['member_number'].')'; // 描述


            // 增加可用金额日志
            $set_inc_data['lg_member_id'] = $transfer_money_member_id;    // 用户id
            $set_inc_data['lg_type'] = 'transfer_get_foe_user';            // 类型
            $set_inc_data['lg_av_amount'] = $transfer_money;  // 金额
            $set_inc_data['lg_add_time'] = time();                // 添加时间
            $set_inc_data['lg_desc'] = '收到会员: '.$user_info['member_nickname'].'(会员 ID ：'.$user_info['member_number'].' )的转账'; // 描述
            $log_data = array_merge(array($set_dec_data),array($set_inc_data));
            $model_pd = Model('predeposit');

            $model_pd->insertAll($log_data);
            Db::commit();
            showDialog('转账成功','index.php?controller=predeposit&action=pd_log_list','succ');
        } catch (Exception $e) {
            Db::rollback();
            showDialog($e->getMessage(),'index.php?controller=predeposit&action=transfer','error');
        }
        }
    }

    public function returns($msg = '请求异常',$status = -1,$data = []){
        $return['status'] = $status;
        $return['msg'] = $msg;
        $return['data'] = $data;
        echo json_encode($return);die;
    }

    public function check_user_idOp(){
        $member_number = trim($_POST['user_id']);
        if($member_number == ''){
            $this->returns('请求异常');
        }
        $where['member_number'] = $member_number;
        $member_model = Model('member');
        $info = $member_model->where($where)->field('member_number,member_name,member_nickname')->find();
        if(empty($info)){
            $this->returns('请求异常');
        }
        $this->returns('success',1,$info);
    }


    /**
     * 充值列表
     */
    public function indexOp(){
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        if (!empty($_GET['pdr_sn'])) {
            $condition['pdr_sn'] = $_GET['pdr_sn'];
        }

        $model_pd = Model('predeposit');
        $list = $model_pd->getPdRechargeList($condition,20,'*','pdr_id desc');

        self::profile_menu('log','recharge_list');
        Tpl::output('list',$list);
        Tpl::output('show_page',$model_pd->showpage());

        Tpl::showpage('predeposit.pd_list');
    }

    /**
     * 查看充值详细
     *
     */
    public function recharge_showOp(){
        $pdr_id = intval($_GET["id"]);
        if ($pdr_id <= 0){
            showDialog(Language::get('predeposit_parameter_error'),'','error');
        }

        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        $condition['pdr_id'] = $pdr_id;
        $condition['pdr_payment_state'] = 1;
        $info = $model_pd->getPdRechargeInfo($condition);
        if (!$info){
            showDialog(Language::get('predeposit_record_error'),'','error');
        }
        Tpl::output('info',$info);
        self::profile_menu('rechargeinfo','rechargeinfo');
        Tpl::showpage('predeposit.pd_info');
    }

    /**
     * 删除充值记录
     *
     */
    public function recharge_delOp(){
        $pdr_id = intval($_GET["id"]);
        if ($pdr_id <= 0){
            showDialog(Language::get('predeposit_parameter_error'),'','error');
        }

        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_member_id'] = $_SESSION['member_id'];
        $condition['pdr_id'] = $pdr_id;
        $condition['pdr_payment_state'] = 0;
        $result = $model_pd->delPdRecharge($condition);
        if ($result){
            showDialog(Language::get('nc_common_del_succ'),'reload','succ','CUR_DIALOG.close()');
        }else {
            showDialog(Language::get('nc_common_del_fail'),'','error');
        }
    }

    /**
     * 预存款变更日志
     */
    public function pd_log_listOp(){
        $model_pd = Model('predeposit');
        $type = isset($_GET['type'])?intval($_GET['type']):'1';
        $condition = array();
        $condition['lg_member_id'] = $_SESSION['member_id'];
        if($type!==1){
            switch ($type){
                case 2:$condition['lg_desc'] = ['like','%'.'下单'.'%'];break;
                case 3:$condition['lg_type'] = ['in',[1,2,3,4,5,6,7,8,9,10,11,12,17,18,19]];break;
                case 4:$condition['lg_desc'] = ['like','%'.'充值'.'%'];break;
                case 5:$condition['lg_desc'] = ['like','%'.'提现'.'%'];break;
            }
        }
        $list = $model_pd->getPdLogList($condition,15,'*','lg_id desc');
        $new_list = [];
        foreach ($list as $key=>$value){
            if(in_array($value['lg_type'],[1,2,3,4,5,6,7,8,9,10,11,12,17,18,19])){
                $value['lg_desc'] = $value['lg_desc'].'【冻结金额 +'.$value['lg_freeze_amount'].'】';
            }
            $new_list[$key] = $value;
        }

        $userModel =  Model('member');
        $userInfo=$userModel->getMemberInfo(['member_id'=>$_SESSION['member_id']],'member_id,member_number');


        //获取会员等级晋升信息
        $where['type']=1;
        $where['des'] = ['like','%'.$userInfo['member_number'].'%'];
        $userLevelInfo=$this->getUserLevelOrPositionsInfo($where);


        //获取会员职务以及职务晋升信息
        $model = Model('positions');
        $userPositions = $model->getMyPositions();
        $where['type']=2;
        $userPositionsInfo = $this->getUserLevelOrPositionsInfo($where);

        //获取默认提现卡
        $bankModel = Model();
        $defaultBank=$bankModel->table('member_bank')->where(['user_id'=>$_SESSION['member_id'],'status'=>1,'is_default'=>1])->find();


        //信息输出
        self::profile_menu('log','loglist');
        Tpl::output('defaultBank',$defaultBank);
        Tpl::output('userPositions',$userPositions);
        Tpl::output('userPositionsInfo',$userPositionsInfo);
        Tpl::output('show_page',$model_pd->showpage());
        Tpl::output('list',$new_list);
        Tpl::output('userLevelInfo',$userLevelInfo);
        Tpl::output('type',$type);
        Tpl::output('webTitle',' - 我的账户');
        Tpl::showpage('predeposit.pd_log_list');
    }

    public function getUserLevelOrPositionsInfo($where){
        $contributionLogModel = Model('contribution_log');
        $info=$contributionLogModel->where($where)->order('create_time desc')->field('create_time,des')->select();
        if(is_array($info) && !empty($info)){
            foreach($info as $k=>$v){
                $info[$k]['des'] = explode('】',$v['des']);
            }
        }
        return $info;
    }


    /**
     * 充值卡余额变更日志
     */
    public function rcb_log_listOp()
    {
        $model = Model();
        $list = $model->table('rcb_log')->where(array(
            'member_id' => $_SESSION['member_id'],
        ))->page(20)->order('id desc')->select();

        //信息输出
        self::profile_menu('log', 'rcb_log_list');
        Tpl::output('show_page', $model->showpage());
        Tpl::output('list', $list);
        Tpl::showpage('predeposit.rcb_log_list');
    }

    /**
     * 申请提现
     */
    public function pd_cash_addOp(){
        if (chksubmit()){
            $obj_validate = new Validate();
            $pdc_amount = abs(floatval($_POST['pdc_amount']));
            $validate_arr[] = array("input"=>$pdc_amount, "require"=>"true",'validator'=>'Compare','operator'=>'>=',"to"=>'0.01',"message"=>Language::get('predeposit_cash_add_pricemin_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_name"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanbanknull_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_no"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanaccountnull_error'));
            $validate_arr[] = array("input"=>$_POST["pdc_bank_user"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuannamenull_error'));
            $validate_arr[] = array("input"=>$_POST["password"], "require"=>"true","message"=>'请输入支付密码');
            $obj_validate -> validateparam = $validate_arr;
            $error = $obj_validate->validate();
            if ($error != ''){
                showDialog($error,'','error');
            }

            $model_pd = Model('predeposit');
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfoByID($_SESSION['member_id']);
            //验证支付密码
            if (md5($_POST['password']) != $member_info['member_paypwd']) {
                showDialog('支付密码错误','','error');
            }
            //验证金额是否足够
            if (floatval($member_info['available_predeposit']) < $pdc_amount){
                showDialog(Language::get('predeposit_cash_shortprice_error'),'index.php?controller=predeposit&action=pd_cash_list','error');
            }
            try {
                $model_pd->beginTransaction();
                $pdc_sn = $model_pd->makeSn();
                $data = array();
                $data['pdc_sn'] = $pdc_sn;
                $data['pdc_member_id'] = $_SESSION['member_id'];
                $data['pdc_member_name'] = $_SESSION['member_name'];
                $data['pdc_amount'] = $pdc_amount;
                $data['pdc_bank_name'] = $_POST['pdc_bank_name'];
                $data['pdc_bank_no'] = $_POST['pdc_bank_no'];
                $data['pdc_bank_user'] = $_POST['pdc_bank_user'];
                $data['pdc_add_time'] = TIMESTAMP;
                $data['pdc_payment_state'] = 0;
                $insert = $model_pd->addPdCash($data);
                if (!$insert) {
                    throw new Exception(Language::get('predeposit_cash_add_fail'));
                }
                //冻结可用预存款
                $data = array();
                $data['member_id'] = $member_info['member_id'];
                $data['member_name'] = $member_info['member_name'];
                $data['amount'] = $pdc_amount;
                $data['order_sn'] = $pdc_sn;
                $model_pd->changePd('cash_apply',$data);
                $model_pd->commit();
                showDialog(Language::get('predeposit_cash_add_success'),'index.php?controller=predeposit&action=pd_cash_list','succ','CUR_DIALOG.close()');
            } catch (Exception $e) {
                $model_pd->rollback();
                showDialog($e->getMessage(),'index.php?controller=predeposit&action=pd_cash_list','error');
            }
        }
    }

    /**
     * 提现列表
     */
    public function pd_cash_listOp(){
        $condition = array();
        $condition['pdc_member_id'] =  $_SESSION['member_id'];
        if (preg_match('/^\d+$/',$_GET['sn_search'])) {
            $condition['pdc_sn'] = $_GET['sn_search'];
        }
        if (isset($_GET['paystate_search'])){
            $condition['pdc_payment_state'] = intval($_GET['paystate_search']);
        }
        $model_pd = Model('predeposit');
        $cash_list = $model_pd->getPdCashList($condition,30,'*','pdc_id desc');

        self::profile_menu('log','cashlist');
        Tpl::output('list',$cash_list);
        Tpl::output('show_page',$model_pd->showpage());
        Tpl::showpage('predeposit.pd_cash_list');
    }

    /**
     * 提现记录详细
     */
    public function pd_cash_infoOp(){
        $pdc_id = intval($_GET["id"]);
        if ($pdc_id <= 0){
            showMessage(Language::get('predeposit_parameter_error'),'index.php?controller=predeposit&action=pd_cash_list','html','error');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdc_member_id'] = $_SESSION['member_id'];
        $condition['pdc_id'] = $pdc_id;
        $info = $model_pd->getPdCashInfo($condition);
        if (empty($info)){
            showMessage(Language::get('predeposit_record_error'),'index.php?controller=predeposit&action=pd_cash_list','html','error');
        }

        self::profile_menu('cashinfo','cashinfo');
        Tpl::output('info',$info);
        Tpl::showpage('predeposit.pd_cash_info');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type,$menu_key=''){
        $menu_array = array(
            array('menu_key'=>'loglist',        'menu_name'=>'账户余额',    'menu_url'=>'index.php?controller=predeposit&action=pd_log_list'),
            array('menu_key'=>'recharge_list',  'menu_name'=>'充值明细',    'menu_url'=>'index.php?controller=predeposit&action=index'),
            array('menu_key'=>'cashlist',       'menu_name'=>'余额提现',    'menu_url'=>'index.php?controller=predeposit&action=pd_cash_list'),
            array('menu_key'=>'transfer',       'menu_name'=>'会员转账',    'menu_url'=>'index.php?controller=predeposit&action=transfer'),
        );
        switch ($menu_type) {
            case 'rechargeinfo':
                $menu_array[] = array('menu_key'=>'rechargeinfo','menu_name'=>'充值详细',  'menu_url'=>'');
                break;
            case 'recharge_add':
                $menu_array[] = array('menu_key'=>'recharge_add','menu_name'=>'在线充值',   'menu_url'=>'');
                break;
            case 'cashadd':
                $menu_array[] = array('menu_key'=>'cashadd','menu_name'=>'提现申请',    'menu_url'=>'index.php?controller=predeposit&action=pd_cash_add');
                break;
            case 'cashinfo':
                $menu_array[] = array('menu_key'=>'cashinfo','menu_name'=>'提现详细',  'menu_url'=>'');
                break;
            case 'log':
            default:
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
