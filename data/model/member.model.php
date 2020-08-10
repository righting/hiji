<?php
/**
 * 会员模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class memberModel extends Model
{

    public function __construct()
    {
        parent::__construct('member');
    }

    // 设置会员类型
    const MEMBER_TYPE_AVERAGE_USER = 1; // 普通用户
    const MEMBER_TYPE_SUPPLIER     = 2;     // 供应商

    /**
     * 会员详细信息（查库）
     *
     * @param array  $condition
     * @param string $field
     * @return array
     */
    public function getMemberInfo($condition, $field = '*', $master = false)
    {
        return $this->table('member')->field($field)->where($condition)->master($master)->find();
    }

    /**
     * 取得会员详细信息（优先查询缓存）
     * 如果未找到，则缓存所有字段
     *
     * @param int    $member_id
     * @param string $field 需要取得的缓存键值, 例如：'*','member_name,member_sex'
     * @return array
     */
    public function getMemberInfoByID($member_id, $fields = '*')
    {
        //$member_info = rcache($member_id, 'member', $fields);
        if (empty($member_info)) {
            $member_info = $this->getMemberInfo(['member_id' => $member_id], $fields, true);
            wcache($member_id, $member_info, 'member', 10);
        }
        return $member_info;
    }

    /**
     * 会员列表
     *
     * @param array  $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getMemberList($condition = [], $field = '*', $page = null, $order = 'member_id desc', $limit = '')
    {
        return $this->table('member')->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
    }

    /**
     *获取佣金订单数量
     *
     */
    public function getOrderInviteCount($inviteid, $memberid)
    {
        return $this->table('pd_log')->where(['lg_invite_member_id' => $memberid, 'lg_member_id' => $inviteid])->count();
    }

    /**
     *获取佣金订单总金额
     *
     */
    public function getOrderInviteamount($inviteid, $memberid)
    {
        return $this->table('pd_log')->where(['lg_invite_member_id' => $memberid, 'lg_member_id' => $inviteid])->sum('lg_av_amount');
    }

    /**
     * 会员列表
     *
     * @param array  $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getMembersList($condition, $page = null, $order = 'member_id desc', $field = '*')
    {
        return $this->table('member')->field($field)->where($condition)->page($page)->order($order)->select();
    }


    /**
     * 删除会员
     *
     * @param int $id 记录ID
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function del($id)
    {
        if (intval($id) > 0) {
            $where  = " member_id = '" . intval($id) . "'";
            $result = Db::delete('member', $where);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 会员数量
     *
     * @param array $condition
     * @return int
     */
    public function getMemberCount($condition)
    {
        return $this->table('member')->where($condition)->count();
    }

    /**
     * 编辑会员
     *
     * @param array $condition
     * @param array $data
     */
    public function editMember($condition, $data)
    {
        $update = $this->table('member')->where($condition)->update($data);
        if ($update && $condition['member_id']) {
            dcache($condition['member_id'], 'member');
        }
        return $update;
    }

    /**
     * 登录时创建会话SESSION
     *
     * @param array $member_info 会员信息
     */
    public function createSession($member_info = [], $reg = false)
    {
        if (empty($member_info) || !is_array($member_info)) return;

        $domain        = domain();
        if (empty($member_info['member_avatar'])) {
            $member_avatar = $domain . UPLOAD_SITE_URL . DS . ATTACH_COMMON . DS . C('default_user_portrait');
        } elseif (!preg_match('/^http(s)?:\\/\\/.+/', $member_info['member_avatar'])) {
            $member_avatar = $domain . $member_info['member_avatar'];
        } else {
            $member_avatar = $member_info['member_avatar'];;
        }

        $_SESSION['is_login']        = '1';
        $_SESSION['member_id']       = $member_info['member_id'];
        $_SESSION['member_name']     = $member_info['member_name'];
        $_SESSION['member_email']    = $member_info['member_email'];
        $_SESSION['is_buy']          = isset($member_info['is_buy']) ? $member_info['is_buy'] : 1;
        $_SESSION['avatar']          = $member_avatar;
        $_SESSION['is_distribution'] = $member_info['is_distribution'];
        $_SESSION['member_nickname'] = $member_info['member_nickname'];
        $member_detail               = Model('member_detail')->getMemberDetailByID($member_info['member_id']);
        $_SESSION['isauth']          = $member_detail['isauth'];
        // 头衔COOKIE
        $this->set_avatar_cookie();

        $seller_info                                 = Model('seller')->getSellerInfo(['member_id' => $_SESSION['member_id']]);
        $_SESSION['seller_session_info']['store_id'] = $seller_info['store_id'];

        if (trim($member_info['member_qqopenid'])) {
            $_SESSION['openid'] = $member_info['member_qqopenid'];
        }
        if (trim($member_info['member_sinaopenid'])) {
            $_SESSION['slast_key']['uid'] = $member_info['member_sinaopenid'];
        }

        if (!$reg) {
            //添加会员积分
            $this->addPoint($member_info);
            //添加会员经验值
            $this->addExppoint($member_info);
        }

        if (!empty($member_info['member_login_time'])) {
            $update_info = [
                'member_login_num'      => ($member_info['member_login_num'] + 1),
                'member_login_time'     => TIMESTAMP,
                'member_old_login_time' => $member_info['member_login_time'],
                'member_login_ip'       => getIp(),
                'member_old_login_ip'   => $member_info['member_login_ip']
            ];
            $this->editMember(['member_id' => $member_info['member_id']], $update_info);
        }
        setNcCookie('cart_goods_num', '', -3600);
        // cookie中的cart存入数据库
        Model('cart')->mergecart($member_info, $_SESSION['seller_session_info']['store_id']);
        // cookie中的浏览记录存入数据库
        Model('goods_browse')->mergebrowse($_SESSION['member_id'], $_SESSION['seller_session_info']['store_id']);

        // 自动登录
        if ($member_info['auto_login'] == 1) {
            $this->auto_login();
        }
    }

    /**
     * 获取会员信息
     *
     * @param    array  $param 会员条件
     * @param    string $field 显示字段
     * @return    array 数组格式的返回结果
     */
    public function infoMember($param, $field = '*')
    {
        if (empty($param)) return false;

        //得到条件语句
        $condition_str  = $this->getCondition($param);
        $param          = [];
        $param['table'] = 'member';
        $param['where'] = $condition_str;
        $param['field'] = $field;
        $param['limit'] = 1;
        $member_list    = Db::select($param);
        $member_info    = $member_list[0];
        if (intval($member_info['store_id']) > 0) {
            $param          = [];
            $param['table'] = 'store';
            $param['field'] = 'store_id';
            $param['value'] = $member_info['store_id'];
            $field          = 'store_id,store_name,grade_id';
            $store_info     = Db::getRow($param, $field);
            if (!empty($store_info) && is_array($store_info)) {
                $member_info['store_name'] = $store_info['store_name'];
                $member_info['grade_id']   = $store_info['grade_id'];
            }
        }
        return $member_info;
    }

    /**
     * 7天内自动登录
     */
    public function auto_login()
    {
        // 自动登录标记 保存7天
        setNcCookie('auto_login', encrypt($_SESSION['member_id'], MD5_KEY), 7 * 24 * 60 * 60);
    }

    public function set_avatar_cookie()
    {
        setNcCookie('member_avatar', $_SESSION['avatar'], 365 * 24 * 60 * 60);
    }

    /**
     * 注册
     */
    public function register($register_info)
    {
        // 注册验证
        $obj_validate                = new Validate();
        $obj_validate->validateparam = [
            ["input" => $register_info["username"], "require" => "true", "message" => '用户名不能为空'],
            ["input" => $register_info["password"], "require" => "true", "message" => '密码不能为空'],
            ["input" => $register_info["password_confirm"], "require" => "true", "validator" => "Compare", "operator" => "==", "to" => $register_info["password"], "message" => '密码与确认密码不相同'],
            ["input" => $register_info["email"], "require" => "true", "validator" => "email", "message" => '电子邮件格式不正确'],
        ];
        $error                       = $obj_validate->validate();
        if ($error != '') {
            return ['error' => $error];
        }

        // 验证用户名是否重复
        $check_member_name = $this->getMemberInfo(['member_name' => $register_info['username']]);
        if (is_array($check_member_name) and count($check_member_name) > 0) {
            return ['error' => '用户名已存在'];
        }

        // 验证邮箱是否重复
        $check_member_email = $this->getMemberInfo(['member_email' => $register_info['email']]);
        if (is_array($check_member_email) and count($check_member_email) > 0) {
            return ['error' => '邮箱已存在'];
        }
        // 会员添加
        $member_info                  = [];
        $member_info['member_name']   = $register_info['username'];
        $member_info['member_passwd'] = $register_info['password'];
        $member_info['member_email']  = $register_info['email'];
        $member_info['invite_one']    = $register_info['invite_one'];
        $member_info['invite_two']    = $register_info['invite_two'];
        $member_info['invite_three']  = $register_info['invite_three'];

        if ($register_info['level_id'] == 1) {
            $member_info['level_id'] = 1;
        }

        $insert_id = $this->addMember($member_info);
        if ($insert_id) {
            $member_info['member_id'] = $insert_id;
            $member_info['is_buy']    = 1;

            return $member_info;
        } else {
            return ['error' => '注册失败'];
        }

    }

    /**
     * 注册商城会员
     *
     * @param   array $param 会员信息
     * @return  array 数组格式的返回结果
     */
    public function addMember($param)
    {
        if (empty($param)) {
            return false;
        }
        try {
            $this->beginTransaction();
            $member_info                          = [];
            $member_info['member_id']             = $param['member_id'];
            $member_info['member_number']         = $this->createMemberId();
            $member_info['member_nickname']       = $param['member_name'];//默认昵称为用户名
            $member_info['member_name']           = $param['member_name'];
            $member_info['member_passwd']         = hj_password_hash(trim($param['member_passwd']));
            $member_info['member_email']          = $param['member_email'];
            $member_info['member_time']           = TIMESTAMP;
            $member_info['member_login_time']     = TIMESTAMP;
            $member_info['member_old_login_time'] = TIMESTAMP;
            $member_info['member_login_ip']       = getIp();
            $member_info['member_old_login_ip']   = $member_info['member_login_ip'];
            if (!empty($param['level_id'])) {
                $member_info['level_id'] = $param['level_id'];
            }

            $member_info['member_truename']   = $param['member_truename'];
            $member_info['member_qq']         = $param['member_qq'];
            $member_info['member_sex']        = $param['member_sex'];
            $member_info['member_avatar']     = $param['member_avatar'];
            $member_info['member_qqopenid']   = $param['member_qqopenid'];
            $member_info['member_qqinfo']     = $param['member_qqinfo'];
            $member_info['member_sinaopenid'] = $param['member_sinaopenid'];
            $member_info['member_sinainfo']   = $param['member_sinainfo'];
            $member_info['invite_one']        = $param['invite_one'];
            $member_info['invite_two']        = $param['invite_two'];
            $member_info['invite_three']      = $param['invite_three'];
            $member_info['is_dealers']        = isset($param['is_dealers']) ? $param['is_dealers'] : 2;
            if ($param['member_mobile_bind']) {
                $member_info['member_mobile']      = $param['member_mobile'];
                $member_info['member_mobile_bind'] = $param['member_mobile_bind'];
            }
            if ($param['weixin_unionid']) {
                $member_info['weixin_unionid'] = $param['weixin_unionid'];
                $member_info['weixin_info']    = $param['weixin_info'];
            }
            $insert_id = $this->table('member')->insert($member_info);
            if (!$insert_id) {
                throw new Exception();
            }
            $insert        = $this->addMemberCommon(['member_id' => $insert_id]);
            $detail_insert = $this->_addMemberDetail(['member_id' => $insert_id]);
            $insert_hi     = $this->_addUserHiValue(['user_id' => $insert_id]);
            if (!$insert || !$detail_insert || !$insert_hi) {
                throw new Exception();
            }

            // 添加默认相册
            $insert                = [];
            $insert['ac_name']     = '买家秀';
            $insert['member_id']   = $insert_id;
            $insert['ac_des']      = '买家秀默认相册';
            $insert['ac_sort']     = 1;
            $insert['is_default']  = 1;
            $insert['upload_time'] = TIMESTAMP;
            $rs                    = $this->table('sns_albumclass')->insert($insert);
            //添加会员积分
            if (C('points_isuse')) {
                Model('points')->savePointsLog('regist', ['pl_memberid' => $insert_id, 'pl_membername' => $param['member_name']], false);
            }

            $this->commit();
            return $insert_id;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    /**
     * 会员登录检查
     *
     */
    public function checkloginMember()
    {
        if ($_SESSION['is_login'] == '1') {
            @header("Location: index.php");
            exit();
        }
    }

    /**
     * 检查会员是否允许举报商品
     *
     */
    public function isMemberAllowInform($member_id)
    {
        $condition              = [];
        $condition['member_id'] = $member_id;
        $member_info            = $this->getMemberInfo($condition, 'inform_allow');
        if (intval($member_info['inform_allow']) === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取单条信息
     *
     * @param unknown $condition
     * @param string  $fields
     */
    public function getMemberCommonInfo($condition = [], $fields = '*')
    {
        return $this->table('member_common')->where($condition)->field($fields)->find();
    }

    /**增加会员详情
     *
     * @param $data
     * @return mixed
     */
    private function _addMemberDetail($data)
    {
        return $this->table('member_detail')->insert($data);
    }

    /**新增会员HI值记录
     *
     * @param $data
     * @return mixed
     */
    private function _addUserHiValue($data)
    {
        return $this->table('user_hi_value')->insert($data);
    }

    /**
     * 插入扩展表信息
     *
     * @param unknown $data
     * @return Ambigous <mixed, boolean, number, unknown, resource>
     */
    public function addMemberCommon($data)
    {
        return $this->table('member_common')->insert($data);
    }

    /**
     * 编辑会员扩展表
     *
     * @param unknown $data
     * @param unknown $condition
     * @return Ambigous <mixed, boolean, number, unknown, resource>
     */
    public function editMemberCommon($data, $condition)
    {
        return $this->table('member_common')->where($condition)->update($data);
    }

    /**
     * 添加会员积分
     *
     * @param unknown $member_info
     */
    public function addPoint($member_info)
    {
        if (!C('points_isuse') || empty($member_info)) return;

        //一天内只有第一次登录赠送积分
        if (trim(@date('Y-m-d', $member_info['member_login_time'])) == trim(date('Y-m-d'))) return;

        //加入队列
        $queue_content                = [];
        $queue_content['member_id']   = $member_info['member_id'];
        $queue_content['member_name'] = $member_info['member_name'];
        QueueClient::push('addPoint', $queue_content);
    }

    /**
     * 添加会员经验值
     *
     * @param unknown $member_info
     */
    public function addExppoint($member_info)
    {
        if (empty($member_info)) return;

        //一天内只有第一次登录赠送经验值
        if (trim(@date('Y-m-d', $member_info['member_login_time'])) == trim(date('Y-m-d'))) return;

        //加入队列
        $queue_content                = [];
        $queue_content['member_id']   = $member_info['member_id'];
        $queue_content['member_name'] = $member_info['member_name'];
        QueueClient::push('addExppoint', $queue_content);
    }

    /**
     * 取得会员安全级别
     *
     * @param unknown $member_info
     */
    public function getMemberSecurityLevel($member_info = [])
    {
        $tmp_level = 0;
        if ($member_info['member_email_bind'] == '1') {
            $tmp_level += 1;
        }
        if ($member_info['member_mobile_bind'] == '1') {
            $tmp_level += 1;
        }
        if ($member_info['member_paypwd'] != '') {
            $tmp_level += 1;
        }
        return $tmp_level;
    }

    /**
     * 获得会员等级
     *
     * @param bool  $show_progress 是否计算其当前等级进度
     * @param int   $exppoints     会员经验值
     * @param array $cur_level     会员当前等级
     */
    public function getMemberGradeArr($show_progress = false, $exppoints = 0, $cur_level = '')
    {
        $member_grade = C('member_grade') ? unserialize(C('member_grade')) : [];
        $member_grade = Model('user_level')->getLevelAll();
        //处理会员等级进度
        if ($member_grade && $show_progress) {
            $is_max = false;
            if ($cur_level === '') {
                $cur_gradearr = $this->getOneMemberGrade($exppoints, false, $member_grade);
                $cur_level    = $cur_gradearr['level'];
            }
            foreach ($member_grade as $k => $v) {
                if ($cur_level == $v['level']) {
                    $v['is_cur'] = true;
                }
                $member_grade[$k] = $v;
            }
        }
        return $member_grade;
    }

    /**
     * 获得某一会员等级
     *
     * @param int   $exppoints
     * @param bool  $show_progress 是否计算其当前等级进度
     * @param array $member_grade  会员等级
     */
    public function getOneMemberGrade($show_progress = false)
    {

        $model_grade = Model('user_level');
        $grade_info  = $model_grade->getLevelAll();//获取会员所有等级信息

        $user_id    = $_SESSION['member_id'];
        $res_member = $this->getMemberInfoByID($user_id);//获取会员信息

        $grade_arr = [];
        foreach ($grade_info as $v) {
            $grade_info[$v['level']] = $v;
            if ($res_member['level_id'] == $v['id']) {
                $grade_arr = ['level' => $v['level'], 'level_name' => $v['level_name'], 'exppoints' => $v['exp'], 'orderdiscount' => 0, 'point' => $v['point']];
            }
        }
        //计算提升进度
        //if ($show_progress == true){
        if (intval($grade_arr['level']) >= count($grade_info) - 1) {//如果已达到顶级会员
            $grade_arr['downgrade']           = $grade_info[$grade_arr['level']]['level'];//下一级会员等级
            $grade_arr['downgrade_name']      = $grade_info[$grade_arr['level']]['level_name'];
            $grade_arr['downgrade_exppoints'] = $grade_info[$grade_arr['level']]['exppoints'];
            $grade_arr['downgrade_point']     = $grade_info[$grade_arr['level']]['point'];
            $grade_arr['upgrade']             = $grade_info[$grade_arr['level']]['level'];//上一级会员等级
            $grade_arr['upgrade_name']        = $grade_info[$grade_arr['level']]['level_name'];
            $grade_arr['upgrade_exppoints']   = $grade_info[$grade_arr['level']]['exppoints'];
            $grade_arr['upgrade_point']       = $grade_info[$grade_arr['level']]['point'];
            $grade_arr['less_exppoints']      = 'none';
            $grade_arr['exppoints_rate']      = 100;
        } else {
            $grade_arr['downgrade']           = $grade_info[$grade_arr['level']]['level'];//下一级会员等级
            $grade_arr['downgrade_name']      = $grade_info[$grade_arr['level']]['level_name'];
            $grade_arr['downgrade_exppoints'] = $grade_info[$grade_arr['level']]['exppoints'];
            $grade_arr['downgrade_point']     = $grade_info[$grade_arr['level']]['point'];
            $grade_arr['upgrade']             = $grade_info[$grade_arr['level'] + 1]['level'];//上一级会员等级
            $grade_arr['upgrade_name']        = $grade_info[$grade_arr['level'] + 1]['level_name'];
            $grade_arr['upgrade_exppoints']   = $grade_info[$grade_arr['level'] + 1]['exppoints'];
            $grade_arr['upgrade_point']       = $grade_info[$grade_arr['level'] + 1]['point'];
            //$rate = @round(($res_member['member_points'] / $grade_arr['upgrade_point']) * 100, 2);
            $rate                        = @bcdiv(bcmul($res_member['member_points'], 100), $grade_arr['upgrade_point'], 2);
            $grade_arr['less_exppoints'] = $grade_info[$grade_arr['level'] + 1]['point'] - $res_member['member_points'];
            $grade_arr['exppoints_rate'] = $rate > 100 ? '100' : $rate;
        }
        //}
        return $grade_arr;
    }

    /**
     *产生一个会员ID编号
     */
    public function createMemberId()
    {
        $maxID     = Model('member')->max('member_id');
        $len       = 9 - strlen(++$maxID);
        $num       = rand(pow(10, ($len - 1)), pow(10, $len) - 1) . $maxID;
        $id_number = 'HJ100' . substr(date("Y"), -2) . sprintf("%09d", $num);
        return $id_number;
    }

    /**
     * 检查会员ID编号重复
     *
     * @return bool
     */
    public function checkMemberId($id, $member_number_const, $member_number)
    {
        if (empty($id) || empty($member_number)) {
            return false;
        }
        if (strlen($_POST['member_number']) != 9) {
            showMessage("会员ID编号不满足9位要求");
        }
        if (!preg_match("/^\d*$/", $_POST['member_number'])) {
            showMessage("会员ID编号不是纯数字组成");
        }
        $member_number = $member_number_const . $member_number;
        if (strlen($member_number) != 16) {
            showMessage("会员ID编号不满足16位");
        }

        $parm['member_id']     = ['neq', $id];
        $parm['member_number'] = $member_number;
        $res                   = $this->where($parm)->find();
        if (empty($res)) {
            return true;
        }
        return false;
    }

    /**
     * @param null $member_id 升级用户id
     * @param int  $new_level
     * @param null $points    升级所使用的积分
     * @return bool
     * @throws Exception
     */
    public function memberUpgrade($member_id = null, $new_level, $points = null)
    {
        if (empty($member_id)) {
            $member_id = $_SESSION['member_id'];
        }
        $model_user_level = Model('user_level');

        $level_info_new = $model_user_level->FindLevelInfo(['level' => $new_level]);//查询新等级记录
        $member_info    = $this->getMemberInfo(['member_id' => $member_id]);
        $level_info_old = $model_user_level->FindLevelInfo(['id' => $member_info['level_id']]);
        $c              = [$model_user_level::LEVEL_TWO => 1, $model_user_level::LEVEL_THREE => 2, $model_user_level::LEVEL_FOUR => 3, $model_user_level::LEVEL_FIVE => 4, $model_user_level::LEVEL_SIX => 5];//初始化贡献值数组
        Model::beginTransaction();
        try {
            $model_member = Model('member');
            $model_member->editMember(['member_id' => $member_id], ['level_id' => $level_info_new['id']]);

            $order_logic = Logic('order');
            $order_logic->giveTermHI($member_id, $level_info_old['level'], $new_level);//升级赠送HI值
            if ($new_level >= $model_user_level::LEVEL_TWO) {
                //升到银尊会员以上
                $order_logic->addToNewSalesIncentiveFund($member_id);//赠送新人鼓励基金
            }

            $invite = Model('register_invite')->where(['to_user_id' => $member_id])->find();  //查询推荐人member_id
            if (!empty($invite['from_user_id']) && !empty($c[$new_level])) {
                $contribution_log = Model('contribution_log');
                $contribution_log->operateContribution(['member_id'    => $invite['from_user_id'],//操作贡献值
                                                        'type'         => $contribution_log::CONTRIBUTION_TYPE_UPGRADE,
                                                        'val'          => $new_level,
                    // 'contribution'=>$c[$new_level],
                                                        'contribution' => 1,
                                                        'operate'      => 1,
                                                        'create_time'  => TIMESTAMP,
                                                        'des'          => '推荐会员【' . $member_info['member_number'] . '】等级从【' . $level_info_old['level_name'] . '】升级到【' . $level_info_new['level_name'] . '】获取贡献值1C'
                ]);

                //给上级增加HI值
                $hiModel = Model('user_hi_value');
                $hiModel->changeUserHi($invite['from_user_id'], '1', '2');

            }

            //插入升级日志
            $log_model               = Model('user_log_ascending_degrading');
            $save_data['user_id']    = $member_id;
            $save_data['old_level']  = $level_info_old['level'];
            $save_data['old_point']  = $member_info['member_points'];
            $save_data['new_level']  = $new_level;
            $save_data['new_point']  = $member_info['member_points'];
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['type']       = 1;
            if (empty($points)) {//未使用积分兑换
                $save_data['old_point'] = $member_info['member_points'];
                $save_data['remark']    = '绑定团队自动升级为免费会员';
            } else { //使用积分兑换
                $save_data['old_point'] = $member_info['member_points'] + $points;
                $save_data['remark']    = '使用[' . $points . ']积分兑换成为[' . $level_info_new['level_name'] . ']';
            }

            $res = $log_model->insert($save_data);
            if (empty($res)) {
                throw  new Exception("新增日志错误");
            }
            Model::commit();
            return true;
        } catch (Exception $e) {
            Model::rollback();
            throw  new Exception("新增日志错误");
            return false;
        }
    }

    // 获取所有用户id
    public function getAllUserId()
    {
        $all_user_id_arr = rkcache('all_user_id_arr');
        if (empty($all_user_id_arr)) {
            $all_user_id_arr = $this->getAllUserIdList();
            wkcache('all_user_id_arr', $all_user_id_arr, 600);
        }
        return $all_user_id_arr;
    }

    public function getAllUserIdList()
    {
        // 获取所有实名认证的会员
        $member_detail_model = Model('member_detail');
        $list                = $member_detail_model->where(['isauth' => 1])->field('member_id')->select();
        $user_id_arr         = array_column($list, 'member_id');
        return $user_id_arr;
    }


    /** 新增 2018/04/12
     *会员实名认证拒绝通过
     *
     * @param $member_id 会员 ID
     * @param $caseInfo  拒绝通过理由
     */
    public function refusedAuth($member_id, $caseInfo)
    {
        $status   = -1;
        $md_model = Model('member_detail');
        $rs       = $md_model->where(['member_id' => $member_id])->update(['isauth' => 2, 'response' => $caseInfo]);
        if ($rs) {
            $status = 1;
        }
        return $status;
    }


    /**会员实名认证
     *
     * @param $member_id 会员ID
     * @param $auto      是否比对身份证照片信息
     * @return mixed
     */
    public function memberAuth($member_id, $auto = false)
    {
        $re       = [];
        $md_model = Model('member_detail');
        $data     = $md_model->where(['member_id' => $member_id, 'isauth' => ['NEQ', 1]])->find();
        if (empty($data))
            return $re = ['status' => false, 'msg' => '数据未找到'];
        if ($auto) { //自动比对身份证照片信息
            $cardInfo = $this->aipOcr($data['id_card_photo']);//返回身份证照片信息
            if (trim($cardInfo['words_result']['姓名']['words']) != trim($data['real_name']) || trim($cardInfo['words_result']['公民身份号码']['words']) != trim($data['member_id_number'])) {
                return $re = ['status' => false, 'msg' => '身份证照片信息与填写资料不符合'];
            }
        }
        Model::beginTransaction();
        try {
            $res = Model('member_detail')->editMemberDetail(['member_id' => $member_id], ['isauth' => 1, 'auth_time' => TIMESTAMP]);
            if (!$res)
                throw new Exception('数据修改错误');
            $member = $this->getMemberInfoByID($member_id);
            if ($member) {
                $invite = Model('register_invite')->where(['to_user_id' => $member['member_id']])->find();
                if ($invite) {
                    $user_level = Model('user_level')->where(['id' => $member['level_id']])->find();
                    if ($user_level['level'] == 0) {
                        $res = Model('member')->memberUpgrade($member_id, 1);//有绑定是为普通会员则升级为免费会员
                        if (!$res)
                            throw new Exception('会员升级错误');
                    }
                }
            }
            Model::commit();
        } catch (Exception $e) {
            Model::rollback();
            return $re = ['status' => false, 'msg' => $e->getMessage()];
        }
        return $re = ['status' => true, 'msg' => 'succ'];
    }

    /**
     * 身份证图像识别返回身份证信息
     */
    public function aipOcr($imgPath)
    {

// 引入文字识别OCR SDK
        require_once BASE_DATA_PATH . DS . 'api' . DS . 'AipOcr' . DS . 'AipOcr.php';

// 定义常量
//        const APP_ID = '请填写你的appid';
//        const API_KEY = '请填写你的API_KEY';
//        const SECRET_KEY = '请填写你的SECRET_KEY';
        $ocrArrs = C('ocr');
// 初始化
        $aipOcr = new AipOcr($ocrArrs['app_id'], $ocrArrs['api_key'], $ocrArrs['secret_key']);
// 身份证识别
        $res = ($aipOcr->idcard(file_get_contents($imgPath), true));

// 银行卡识别
//var_dump($aipOcr->bankcard(file_get_contents('bankcard.jpg')));

// 通用文字识别
//        var_dump($aipOcr->general(file_get_contents('general.png')));
        return $res;
    }
}
