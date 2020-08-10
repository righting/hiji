<?php
/**
 * 会员管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');

class memberControl extends SystemControl{
    const EXPORT_SIZE = 1000;
    public function __construct(){
        parent::__construct();
        Language::read('member');
    }

    public function indexOp() {
        $this->memberOp();
    }

    /**
     * 会员管理
     */
    public function memberOp(){
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

        // 统计每个等级的用户数量
        $member_model = Model('member');
        $old_level_statistics = $member_model->where(['member_state'=>1])->field('level_id,count(level_id) as level_count')->group('level_id')->select();
        $level_statistics = array_combine(array_column($old_level_statistics,'level_id'),array_column($old_level_statistics,'level_count'));
        $user_level_model = Model('user_level');
        $level_type_name_for_level_id = $user_level_model->getLevelInfoForLevelId();
        // 所有会员人数 = 所有人数 - 普通用户
        $total_count = bcsub(array_sum($level_statistics),$level_statistics[$user_level_model::LEVEL_ZERO]);
        // 经销商人数
        $dealers_count = $member_model->where(['is_dealers'=>1])->count();
        //认证人数
        $member_detail_model = Model('member_detail');
        $isauth_count = $member_detail_model->getMemberAuthCount(['isauth'=>1,'id_card_photo'=>['neq','']]);
        //未认证人数
        $waitauth_count =  $member_detail_model->getMemberAuthCount(['isauth'=>0,'id_card_photo'=>['neq','']]);
        Tpl::output('isauth_count',$isauth_count);
        Tpl::output('waitauth_count',$waitauth_count);
        Tpl::output('total_count',$total_count);
        Tpl::output('dealers_count',$dealers_count);
        Tpl::output('level_statistics',$level_statistics);
        Tpl::output('level_type_name_for_level_id',$level_type_name_for_level_id);
        Tpl::showpage('member.index');
    }

    /**
     * 会员修改
     */
    public function member_editOp(){
        $lang   = Language::getLangContent();
        $model_member = Model('member');
        $condition['member_id'] = intval($_GET['member_id']);
        $member_array = $model_member->getMemberInfo($condition);
        /**
         * 保存
         */
        if (chksubmit()){
            /**
             * 验证
             */

            $res = $model_member->checkMemberId(intval($_POST['member_id']),trim($_POST['member_number_const']),trim($_POST['member_number']));
            if (!$res){
                showMessage("会员ID编号重复，请重试");
            }
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
            array("input"=>$_POST["member_email"], "require"=>"true", 'validator'=>'Email', "message"=>$lang['member_edit_valid_email']),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $update_array = array();
                $update_array['member_id']          = intval($_POST['member_id']);
                if (!empty($_POST['member_passwd'])){
                    $update_array['member_passwd'] = hj_password_hash($_POST['member_passwd']);
                }
                if ($member_array['member_number'] != $_POST['member_number_const'].$_POST['member_number']){
                    if (intval($member_array['member_number_edit_num']) ==3){
                        showMessage("会员ID编号已修改3次");
                    }
                    $update_array['member_number_edit_num']       = $member_array['member_number_edit_num']+1;
                }
                $update_array['member_number']      =$_POST['member_number_const'].$_POST['member_number'];
                $update_array['member_email']       = $_POST['member_email'];
                $update_array['member_truename']    = $_POST['member_truename'];
                $update_array['member_sex']         = $_POST['member_sex'];
                $update_array['member_qq']          = $_POST['member_qq'];
                $update_array['member_ww']          = $_POST['member_ww'];
                $update_array['inform_allow']       = $_POST['inform_allow'];
                $update_array['is_buy']             = $_POST['isbuy'];
                $update_array['is_allowtalk']       = $_POST['allowtalk'];
                if (!empty($_POST['member_avatar'])){
                    $update_array['member_avatar'] = $_POST['member_avatar'];
                }
                $result = $model_member->editMember(array('member_id'=>intval($_POST['member_id'])),$update_array);
                if ($result){
                    $url = array(
                    array(
                    'url'=>'index.php?controller=member&action=member',
                    'msg'=>$lang['member_edit_back_to_list'],
                    ),
                    array(
                    'url'=>'index.php?controller=member&action=member_edit&member_id='.intval($_POST['member_id']),
                    'msg'=>$lang['member_edit_again'],
                    ),
                    );
                    $this->log(L('nc_edit,member_index_name').'[ID:'.$_POST['member_id'].']',1);
                    showMessage($lang['member_edit_succ'],$url);
                }else {
                    showMessage($lang['member_edit_fail']);
                }
            }
        }


        Tpl::output('member_array',$member_array);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('member.edit');
    }

    /**
     * 新增会员
     */
    public function member_addOp(){
        $lang   = Language::getLangContent();
        $model_member = Model('member');
        /**
         * 保存
         */
        if (chksubmit()){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["member_name"], "require"=>"true", "message"=>$lang['member_add_name_null']),
                array("input"=>$_POST["member_passwd"], "require"=>"true", "message"=>'密码不能为空'),
                array("input"=>$_POST["member_email"], "require"=>"true", 'validator'=>'Email', "message"=>$lang['member_edit_valid_email'])
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                // 检查是否为经销商
                $is_dealers = intval($_POST['is_dealers']);
                if(!in_array($is_dealers,[1,2])){
                    showMessage('请求异常');
                }
                $insert_array = array();
                $insert_array['member_name']    = trim($_POST['member_name']);
                $insert_array['member_passwd']  = trim($_POST['member_passwd']);
                $insert_array['member_email']   = trim($_POST['member_email']);
                $insert_array['member_truename']= trim($_POST['member_truename']);
                $insert_array['member_sex']     = trim($_POST['member_sex']);
                $insert_array['member_qq']      = trim($_POST['member_qq']);
                $insert_array['member_ww']      = trim($_POST['member_ww']);
                $insert_array['is_dealers']      = $is_dealers;
                //默认允许举报商品
                $insert_array['inform_allow']   = '1';
                if (!empty($_POST['member_avatar'])){
                    $insert_array['member_avatar'] = trim($_POST['member_avatar']);
                }

                $result = $model_member->addMember($insert_array);
                if ($result){
                    $url = array(
                    array(
                    'url'=>'index.php?controller=member&action=member',
                    'msg'=>$lang['member_add_back_to_list'],
                    ),
                    array(
                    'url'=>'index.php?controller=member&action=member_add',
                    'msg'=>$lang['member_add_again'],
                    ),
                    );
                    $this->log(L('nc_add,member_index_name').'[ '.$_POST['member_name'].']',1);
                    showMessage($lang['member_add_succ'],$url);
                }else {
                    showMessage($lang['member_add_fail']);
                }
            }
        }
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('member.add');
    }

    /**
     * ajax操作
     */
    public function ajaxOp(){
        switch ($_GET['branch']){
            /**
             * 验证会员是否重复
             */
            case 'check_user_name':
                $model_member = Model('member');
                $condition['member_name']   = $_GET['member_name'];
                $condition['member_id'] = array('neq',intval($_GET['member_id']));
                $list = $model_member->getMemberInfo($condition);
                if (empty($list)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }
                break;
                /**
             * 验证邮件是否重复
             */
            case 'check_email':
                $model_member = Model('member');
                $condition['member_email'] = $_GET['member_email'];
                $condition['member_id'] = array('neq',intval($_GET['member_id']));
                $list = $model_member->getMemberInfo($condition);
                if (empty($list)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }
                break;
        }
    }

    /**
     * 修改状态 member_state=0 并清除身份证号码
     * 新增伪删除会员
     * 参数  memberId
    **/
    public function delMemberOp(){
        $status=-1;
        $model_member = Model('member');
        $memberId = intval($_POST['memberId']);
        //修改会员状态
        $rs=$model_member->where(['member_id'=>$memberId])->update(['member_state'=>0]);
        if($rs){
            //清空会员身份证号码
            $saveInfo=Model('member_detail')->where(['member_id'=>$memberId])->update(['member_id_number'=>'']);
            if($saveInfo){
                $status=1;
            }
        }
        echo $status;
    }

    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_member = Model('member');
        $condition = array();
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }
        $order = '';
        $param = array('member_id','member_number','member_name','member_avatar','member_email','member_mobile','member_sex','member_truename','member_birthday'
                ,'member_time','member_login_time','member_login_ip','member_points','member_exppoints','member_grade','available_predeposit'
                ,'freeze_predeposit','available_rc_balance','freeze_rc_balance','inform_allow','is_buy','is_allowtalk','member_state'
        );
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];
        }


        //用户状态 1=正常 0=关闭
        $condition['member_state']=1;

        $page = $_POST['rp'];
        // 获取用户信息
        $member_list = $model_member->getMemberList($condition, '*', $page, $order);
        // 获取所有等级
        $user_level_model = Model('user_level');

        $level_arr = $user_level_model->field('id,level_name')->select();
        $level_id_and_name_arr = array_combine(array_column($level_arr,'id'),array_column($level_arr,'level_name'));

        $total_num = $model_member->where($condition)->count(1);
        $sex_array = $this->get_sex();

        $curpage = (intval($_POST['curpage']) > 0 ) ? intval($_POST['curpage']) : 1;
        $data = array();
        $data['now_page'] = $curpage;
        $data['total_num'] = $total_num;

        $register_invite = Model('register_invite');
        $user_id_arr = array_column($member_list,'member_id');
        // 按推荐人统计团队人数
        $to_user_count = $register_invite->where(['from_user_id'=>['in',$user_id_arr]])->field('from_user_id,count(id) as to_user_count')->group('from_user_id')->select();
        $user_id_and_to_user_count = array_combine(array_column($to_user_count,'from_user_id'),array_column($to_user_count,'to_user_count'));
        // 获取这些用户对应的邀请人
        $from_user_arr = $register_invite->where(['to_user_id'=>['in',$user_id_arr]])->field('from_user_id,to_user_id')->select();

        $user_id_and_from_user_id = array_combine(array_column($from_user_arr,'to_user_id'),array_column($from_user_arr,'from_user_id'));

        foreach ($member_list as $value) {
            $param = array();
            $param['operation'] = "<a class='btn blue' href='" .  urlAdminShop('member','member_edit',['member_id'=>$value['member_id']]) . "'><i class='fa fa-pencil-square-o'></i>编辑</a>";
            $param['operation'] .= "<a class='btn red' href=JavaScript:delMember(".$value['member_id'].")>删除</a>";
            $param['member_id'] = $value['member_id'];
            $param['member_number'] = $value['member_number'];
            $param['member_name'] = "<img src=".getMemberAvatarForID($value['member_id'])." class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getMemberAvatarForID($value['member_id']).">\")'>".$value['member_name'];
            $param['member_email'] = $value['member_email'];
            $param['member_mobile'] = $value['member_mobile'];
//            $param['member_sex'] = $sex_array[$value['member_sex']];
            $param['member_truename'] = $value['member_truename'];
//            $param['member_birthday'] = $value['member_birthday'];
            $param['member_time'] = date('Y-m-d', $value['member_time']);
            $param['member_login_time'] = date('Y-m-d', $value['member_login_time']);
            $param['member_login_ip'] = $value['member_login_ip'];
            $param['member_points'] = $value['member_points'];
//            $param['member_exppoints'] = $value['member_exppoints'];
            $param['member_grade'] = $level_id_and_name_arr[$value['level_id']];
            $param['available_predeposit'] = ncPriceFormat($value['available_predeposit']);
            $param['freeze_predeposit'] = ncPriceFormat($value['freeze_predeposit']);
//            $param['available_rc_balance'] = ncPriceFormat($value['available_rc_balance']);
//            $param['freeze_rc_balance'] = ncPriceFormat($value['freeze_rc_balance']);
            // 推荐人id
            $param['from_user_id'] = isset($user_id_and_from_user_id[$value['member_id']]) ? $user_id_and_from_user_id[$value['member_id']] : '未绑定';
            // 团队人数
            $param['to_user_count'] = isset($user_id_and_to_user_count[$value['member_id']]) ? $user_id_and_to_user_count[$value['member_id']] : 0;
            $data['list'][$value['member_id']] = $param;
        }
        echo Tpl::flexigridXML($data);exit();
    }

    /**
     * 性别
     * @return multitype:string
     */
    private function get_sex() {
        $array = array();
        $array[1] = '男';
        $array[2] = '女';
        $array[3] = '保密';
        return $array;
    }
    /**
     * csv导出
     */
    public function export_csvOp() {
        $model_member = Model('member');
        $condition = array();
        $limit = false;
        if ($_GET['id'] != '') {
            $id_array = explode(',', $_GET['id']);
            $condition['member_id'] = array('in', $id_array);
        }
        if ($_GET['query'] != '') {
            $condition[$_GET['qtype']] = array('like', '%' . $_GET['query'] . '%');
        }
        $order = '';
        $param = array('member_id','member_name','member_avatar','member_email','member_mobile','member_sex','member_truename','member_birthday'
                ,'member_time','member_login_time','member_login_ip','member_points','member_exppoints','member_grade','available_predeposit'
                ,'freeze_predeposit','available_rc_balance','freeze_rc_balance','inform_allow','is_buy','is_allowtalk','member_state'
        );
        if (in_array($_GET['sortname'], $param) && in_array($_GET['sortorder'], array('asc', 'desc'))) {
            $order = $_GET['sortname'] . ' ' . $_GET['sortorder'];
        }
        if (!is_numeric($_GET['curpage'])){
            $count = $model_member->getMemberCount($condition);
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $array = array();
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?controller=member&action=index');
				Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
                Tpl::showpage('export.excel');
                exit();
            }
        } else {
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $limit = $limit1 .','. $limit2;
        }

        $member_list = $model_member->getMemberList($condition, '*', null, $order, $limit);
        $this->createCsv($member_list);
    }
    /**
     * 生成csv文件
     */
    private function createCsv($member_list) {
        $model_member = Model('member');
        $member_grade = $model_member->getMemberGradeArr();
        // 性别
        $sex_array = $this->get_sex();
        $data = array();
        foreach ($member_list as $value) {
            $param = array();
            $param['member_id'] = $value['member_id'];
            $param['member_name'] = $value['member_name'];
            $param['member_number'] = $value['member_number'];
            //$param['member_avatar'] = getMemberAvatarForID($value['member_id']);
            $param['member_avatar'] = 'member_avatar';
            $param['member_email'] = $value['member_email'];
            $param['member_mobile'] = $value['member_mobile'];
            $param['member_sex'] = $sex_array[$value['member_sex']];
            $param['member_truename'] = $value['member_truename'];
            $param['member_birthday'] = $value['member_birthday'];
            $param['member_time'] = date('Y-m-d', $value['member_time']);
            $param['member_login_time'] = date('Y-m-d', $value['member_login_time']);
            $param['member_login_ip'] = $value['member_login_ip'];
            $param['member_points'] = $value['member_points'];
            $param['member_exppoints'] = $value['member_exppoints'];
            $param['member_grade'] = ($t = $model_member->getOneMemberGrade($value['member_exppoints'], false, $member_grade))?$t['level_name']:'';
            $param['available_predeposit'] = ncPriceFormat($value['available_predeposit']);
            $param['freeze_predeposit'] = ncPriceFormat($value['freeze_predeposit']);
            $param['available_rc_balance'] = ncPriceFormat($value['available_rc_balance']);
            $param['freeze_rc_balance'] = ncPriceFormat($value['freeze_rc_balance']);
            $param['inform_allow'] = $value['inform_allow'] ==  '1' ? '是' : '否';
            $param['is_buy'] = $value['is_buy'] ==  '1' ? '是' : '否';
            $param['is_allowtalk'] = $value['is_allowtalk'] ==  '1' ? '是' : '否';
            $param['member_state'] = $value['member_state'] ==  '1' ? '是' : '否';
            $data[$value['member_id']] = $param;
        }

        $header = array(
                'member_id' => '会员ID',
                'member_name' => '会员名称',
                'member_number' => 'ID编号',
                'member_avatar' => '会员头像',
                'member_email' => '会员邮箱',
                'member_mobile' => '会员手机',
                'member_sex' => '会员性别',
                'member_truename' => '真实姓名',
                'member_birthday' => '出生日期',
                'member_time' => '注册时间',
                'member_login_time' => '最后登录时间',
                'member_login_ip' => '最后登录IP',
                'member_points' => '会员积分',
                'member_exppoints' => '会员经验',
                'member_grade' => '会员等级',
                'available_predeposit' => '可用预存款(元)',
                'freeze_predeposit' => '冻结预存款(元)',
                'available_rc_balance' => '可用充值卡(元)',
                'freeze_rc_balance' => '冻结充值卡(元)',
                'inform_allow' => '允许举报',
                'is_buy' => '允许购买',
                'is_allowtalk' => '允许咨询',
                'member_state' => '允许登录'
        );
       array_unshift($data, $header);
		$csv = new Csv();
	    $export_data = $csv->charset($data,CHARSET,'gbk');
	    $csv->filename = $csv->charset('member_list',CHARSET).$_GET['curpage'] . '-'.date('Y-m-d');
	    $csv->export($data);   
    }
}
