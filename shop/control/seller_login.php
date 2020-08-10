<?php
/**
 * 店铺卖家登录
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class seller_loginControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
//        var_dump($_SESSION['seller_session_info']['seller_id']);exit;
//        if (!empty($_SESSION['seller_session_info']['seller_id'])) {
//            @header('location: index.php?controller=seller_center');die;
//        }
    }

    public function indexOp() {
        $this->show_loginOp();
    }

    public function show_loginOp() {
        Tpl::output('nchash', getNchash());
        Tpl::setLayout('null_layout');
        Tpl::showpage('login');
    }

    public function loginOp() {
        $result = chksubmit(true,true,'num');
        if ($result){
            if ($result === -11){
                showDialog('用户名或密码错误','','error');
            } elseif ($result === -12){
                showDialog('验证码错误','','error');
            }
        } else {
            showDialog('非法提交','reload','error');
        }

        $model_seller = Model('seller');
        $seller_info = $model_seller->getSellerInfo(array('seller_name' => $_POST['seller_name']));

        if($seller_info) {

            /*$model_member = Model('member');
            $member_info_where['member_id'] = $seller_info['member_id'];
            if($seller_info['member_id'] != 1){
                $member_info_where['member_type'] = $model_member::MEMBER_TYPE_SUPPLIER;
            }
            $member_info = $model_member->getMemberInfo($member_info_where);*/

            $model_store = Model('store');
            $store_info = $model_store->getStoreInfoByID($seller_info['store_id']);
            if($store_info) {
                if(hj_password_verify($_POST['password'],$store_info['passwd'])){
                    showMessage('用户名密码错误', '', '', 'error');
                }
                // 更新卖家登陆时间
                $model_seller->editSeller(array('last_login_time' => TIMESTAMP), array('seller_id' => $seller_info['seller_id']));

                $model_seller_group = Model('seller_group');
                $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $seller_info['seller_group_id']));

                
                //$store_info = $model_store->getStoreInfoByID($seller_info['store_id']);

                $seller_session_info['is_login'] = '1';
                /*$seller_session_info['member_id'] = $member_info['member_id'];
                $seller_session_info['member_name'] = $member_info['member_name'];
                $seller_session_info['member_email'] = $member_info['member_email'];
                $seller_session_info['is_buy'] = $member_info['is_buy'];
                $seller_session_info['avatar'] = $member_info['member_avatar'];*/
                $seller_session_info['is_buy'] = 1;


                $seller_session_info['grade_id'] = $store_info['grade_id'];
                $seller_session_info['seller_id'] = $seller_info['seller_id'];
                $seller_session_info['seller_name'] = $seller_info['seller_name'];
                $seller_session_info['seller_is_admin'] = intval($seller_info['is_admin']);
                $seller_session_info['store_id'] = intval($seller_info['store_id']);
                $seller_session_info['store_name'] = $store_info['store_name'];
                $seller_session_info['store_avatar'] = $store_info['store_avatar'];
                $seller_session_info['is_own_shop'] = (bool) $store_info['is_own_shop'];
                $seller_session_info['bind_all_gc'] = (bool) $store_info['bind_all_gc'];
                $seller_session_info['seller_limits'] = explode(',', $seller_group_info['limits']);
                $seller_session_info['seller_group_id'] = $seller_info['seller_group_id'];
                $seller_session_info['seller_gc_limits'] = $seller_group_info['gc_limits'];
                if($seller_info['is_admin']) {
                    $seller_session_info['seller_group_name'] = '管理员';
                    $seller_session_info['seller_smt_limits'] = false;
                } else {
                    $seller_session_info['seller_group_name'] = $seller_group_info['group_name'];
                    $seller_session_info['seller_smt_limits'] = explode(',', $seller_group_info['smt_limits']);
                }
                if(!$seller_info['last_login_time']) {
                    $seller_info['last_login_time'] = TIMESTAMP;
                }
                $seller_session_info['seller_last_login_time'] = date('Y-m-d H:i', $seller_info['last_login_time']);
                $seller_menu = $this->getSellerMenuList($seller_info['is_admin'], explode(',', $seller_group_info['limits']));
                $seller_session_info['seller_menu'] = $seller_menu['seller_menu'];
                $seller_session_info['seller_function_list'] = $seller_menu['seller_function_list'];
                if(!empty($seller_info['seller_quicklink'])) {
                    $quicklink_array = explode(',', $seller_info['seller_quicklink']);
                    foreach ($quicklink_array as $value) {
                        $seller_session_info['seller_quicklink'][$value] = $value ;
                    }
                }
                $_SESSION['seller_session_info'] = $seller_session_info;
                setNcCookie('auto_login', '', -3600);
                $this->recordSellerLog('登录成功');
                redirect('index.php?controller=seller_center');
            } else {
                showMessage('用户名密码错误', '', '', 'error');
            }
        } else {
            showMessage('用户名密码错误', '', '', 'error');
        }
    }
}
