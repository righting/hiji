<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/ 欢迎加入www.ccynet.cn/
 */


defined('ByCCYNet') or exit('Access Invalid!');

class loginControl extends BaseLoginControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 登录操作
     *
     */
    public function indexOp()
    {
        Language::read("home_login_index,home_login_register");
        $lang = Language::getLangContent();
        //$model_member = Model('member');
        $model_member = new memberModel();
        //检查登录状态
        $model_member->checkloginMember();
        if ($_GET['inajax'] == 1 && C('captcha_status_login') == '1') {
            $script = "document.getElementById('codeimage').src='index.php?controller=seccode&action=makecode&nchash=" . getNchash() . "&t=' + Math.random();";
        }
        $result = chksubmit(true, C('captcha_status_login'), 'num');
        if ($result !== false) {
            if ($result === -11) {
                showDialog($lang['login_index_login_illegal'], 'reload', 'error', $script);
            } elseif ($result === -12) {
                showDialog($lang['login_index_wrong_checkcode'], '', 'error', $script);
            }
            if (process::islock('login')) {
                showDialog($lang['nc_common_op_repeat'], SHOP_SITE_URL, '', 'error', $script);
            }
            $obj_validate                = new Validate();
            $user_name                   = $_POST['user_name'];
            $password                    = $_POST['password'];
            $obj_validate->validateparam = [
                ["input" => $user_name, "require" => "true", "message" => $lang['login_index_username_isnull']],
                ["input" => $password, "require" => "true", "message" => $lang['login_index_password_isnull']],
            ];
            $error                       = $obj_validate->validate();
            if ($error != '') {
                showDialog($error, SHOP_SITE_URL, 'error', $script);
            }
            if (C('ucenter_status')) {
                //$model_ucenter = Model('ucenter');
                $model_ucenter = new ucenterModel();
                $member_id     = $model_ucenter->userLogin(trim($_POST['user_name']), trim($_POST['password']));
                if (intval($member_id) == 0) {
                    if (cookie('tm_login') >= 6) {
                        showDialog($lang['nc_common_op_repeat']);
                    }
                    log_times('login');
                    showDialog($lang['login_index_login_again']);
                }
            }

            $condition                = [];
            $condition['member_name'] = $user_name;
            $condition['member_type'] = $model_member::MEMBER_TYPE_AVERAGE_USER;
            $member_info              = $model_member->getMemberInfo($condition);
            if (empty($member_info) && preg_match('/^0?(13|15|17|18|14)[0-9]{9}$/i', $user_name)) {//根据会员名没找到时查手机号
                unset($condition['member_name']);
                $condition['member_mobile'] = $user_name;
                $member_info                = $model_member->getMemberInfo($condition);
            }
            if (empty($member_info) && (strpos($user_name, '@') > 0)) {//按邮箱和密码查询会员
                unset($condition['member_name']);
                $condition['member_email'] = $user_name;
                $member_info               = $model_member->getMemberInfo($condition);
            }

            if (empty($member_info) && (strpos($user_name, 'HJ') !== false)) {
                unset($condition['member_name']);
                $condition['member_number'] = $user_name;
                $member_info                = $model_member->getMemberInfo($condition);
            }

            // 检查密码是否正确
            if (hj_password_verify($password, $member_info['member_passwd'])) {
                showDialog('账号或密码错误', '', 'error', $script);
            }

            if (is_array($member_info) && !empty($member_info)) {
                if (!$member_info['member_state']) {
                    showDialog($lang['login_index_account_stop'], '', 'error', $script);
                }
            } else {
                process::addprocess('login');
                showDialog($lang['login_index_login_again'], '', 'error', $script);
            }
            // 自动登录
            $member_info['auto_login'] = $_POST['auto_login'];
            $model_member->createSession($member_info);
            process::clear('login');
            if ($_GET['inajax'] == 1) {
                showDialog('登陆成功', $_POST['ref_url'] == '' ? 'reload' : $_POST['ref_url'], 'js');
            } else {
                redirect($_POST['ref_url']);
            }
        } else {
            //登录表单页面
            $_pic = @unserialize(C('login_pic'));
            if ($_pic[0] != '') {
                Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . $_pic[array_rand($_pic)]);
            } else {
                Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . rand(1, 4) . '.jpg');
            }

            if (empty($_GET['ref_url'])) {
                $ref_url = getReferer();
                if (!preg_match('/act=login&action=logout/', $ref_url)) {
                    $_GET['ref_url'] = $ref_url;
                }
            }
            Tpl::output('html_title', C('site_name') . ' - ' . $lang['login_index_login']);
            if ($_GET['inajax'] == 1) {
                Tpl::showpage('login_inajax', 'null_layout');
            } else {
                Tpl::showpage('login');
            }
        }
    }

    /**
     * 退出操作
     *
     * @param int $id 记录ID
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function logoutOp()
    {
        Language::read("home_login_index");
        $lang = Language::getLangContent();
        // 清理COOKIE
        setNcCookie('msgnewnum' . $_SESSION['member_id'], '', -3600);
        setNcCookie('auto_login', '', -3600);
        setNcCookie('cart_goods_num', '', -3600);
        session_unset();
        session_destroy();
        /**
         * 同步登录通知
         */
        if (C('ucenter_status')) {
            /**
             * Ucenter处理
             */
            //$model_ucenter                = Model('ucenter');
            $model_ucenter                = new ucenterModel();
            $out_str                      = $model_ucenter->userLogout();
            $lang['login_logout_success'] = $lang['login_logout_success'] . $out_str;
            if (empty($_GET['ref_url'])) {
                $ref_url = getReferer();
            } else {
                $ref_url = $_GET['ref_url'];
            }
            showMessage($lang['login_logout_success'], 'index.php?controller=login&ref_url=' . urlencode($ref_url));
        } else {
            redirect();
        }
    }

    /**
     * 会员注册页面
     *
     * @param
     * @return
     */
    public function registerOp()
    {
        //20180330去掉手机判断
//        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
//        $uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
//        if (($ua == '' || preg_match($uachar, $ua)) && !strpos(strtolower($_SERVER['REQUEST_URI']), 'wap')) {
//            $rec_id = $_GET['rec'];
//            if (!empty($rec_id)) {
////                header('Location:' . WAP_SITE_URL . '/tmpl/member/register.html?controller=register&rec=' . $rec_id);
//            }
//        } else {
        $rec_id = $_GET['rec'];
        //$model_member = Model('member');
        $model_member = new memberModel();
        // 根据$rec_id获取对应用户的id，根据用户id获取邀请人邀请id
        $member_info['member_id']     = 0;
        $member_info['member_number'] = 0;
        if ($rec_id) {
            $from_user_id = hj_decrypt($rec_id);
            // 检查邀请人是存在
            $from_user_where['member_id'] = $from_user_id;
            $member_info                  = $model_member->where($from_user_where)->field('member_id,member_number')->find();
        }

        Language::read("home_login_register");
        $lang = Language::getLangContent();
        $model_member->checkloginMember();
        Tpl::output('html_title', C('site_name') . ' - ' . $lang['login_register_join_us']);
        Tpl::output('invite_member_info', $member_info);
        Tpl::showpage('register');
//        }
    }

    /**
     * 会员添加操作
     *
     * @param
     * @return
     */
    public function usersaveOp()
    {
        //重复注册验证
        if (process::islock('reg')) {
            showDialog(Language::get('nc_common_op_repeat'));
        }
        Language::read("home_login_register");
        $lang = Language::getLangContent();
        //$model_member = Model('member');
        $model_member = new memberModel();
        $model_member->checkloginMember();

        //结束
        $result = chksubmit(true, C('captcha_status_register'), 'num');
        if ($result) {
            if ($result === -11) {
                showDialog($lang['invalid_request'], '', 'error');
            } elseif ($result === -12) {
                showDialog($lang['login_usersave_wrong_code'], '', 'error');
            }
        } else {
            showDialog($lang['invalid_request'], '', 'error');
        }
        if (C('ucenter_status')) {
            /**
             * Ucenter处理
             */
            //$model_ucenter = Model('ucenter');
            $model_ucenter = new ucenterModel();
            $uid           = $model_ucenter->addUser(trim($_POST['user_name']), trim($_POST['password']), trim($_POST['email']));
            if ($uid < 1) showMessage($lang['login_usersave_regist_fail'], '', 'html', 'error');
            $register_info['member_id'] = $uid;
        }


        $register_info = [];
        // 用户名不能为汉字
        if (!preg_match('|^[0-9a-zA-Z]+$|', trim($_POST['user_name']))) {
            showDialog('用户名不能为汉字', '', 'error');
        }
        $register_info['username']         = $_POST['user_name'];
        $register_info['password']         = $_POST['password'];
        $register_info['password_confirm'] = $_POST['password_confirm'];
        $register_info['email']            = $_POST['email'];


        $member = [];
        // 如果是别人邀请的该用户注册，需要将该用户加入到注册邀请表 register_invite 中
        if (!empty($_POST['invite_member_id'])) {
            $rec_id = $_POST['invite_member_id'];
            // 根据提交的邀请码获取邀请码对应的用户信息
            $member = $model_member->getMemberInfo(['member_number' => $rec_id], 'member_id,member_name,member_avatar,member_state,level_id,is_dealers');
            if (empty($member)) {
                showDialog('邀请码已失效，如有需要请联系您的邀请人重新发送邀请码', '', 'error');
            }
            // 如果用户等级不是免费会员以上，则不能邀请别人注册
            if (($member['level_id'] == 7) && ($member['is_dealers'] != 1)) {
                showDialog('您的邀请人当前会员等级不支持邀请团队', '', 'error');
            }
            $register_info['level_id'] = 1;
        }

        $member_info = $model_member->register($register_info);
        if (isset($member_info['error'])) {
            showDialog($member_info['error']);
        }

        //如何是别人邀请的该用户注册 增加注册用户500HI值
        if ($register_info['level_id'] == 1) {
            //增加HI值
            //$hiModel = Model('user_hi_value');
            $hiModel = new user_hi_valueModel();
            $hiModel->changeUserHi($member_info['member_id'], '500', '2');
        }


        if (!empty($member)) {
            $register_invite_model                = new register_inviteModel();
            $invite                               = $register_invite_model->field('depth')->where(['to_user_id' => $member['member_id']])->find();
            $register_invite_data['from_user_id'] = $member['member_id'];
            $register_invite_data['to_user_id']   = $member_info['member_id'];
            $register_invite_data['register_at']  = date('Y-m-d H:i:s');
            $register_invite_data['depth']        = intval($invite['depth']) + 1;
            //$register_invite_model                = Model('register_invite');
            $register_invite_model->addRegisterInvite($register_invite_data);//写入邀请信息
            //写入实名信息
            $member_detail_model = new member_detailModel();
            $member_detail_model->editMemberDetail(['member_id' => $member_info['member_id']], ['real_name' => $_POST['real_name'], 'member_id_number' => $_POST['member_id_number'], 'id_card_photo' => $_POST['id_card_photo']]);
        }

        $model_member->createSession($member_info, true);
        process::addprocess('reg');

        $_POST['ref_url'] = (strstr($_POST['ref_url'], 'logout') === false && !empty($_POST['ref_url']) ? $_POST['ref_url'] : urlMember('member_information', 'member'));
        if ($_GET['inajax'] == 1) {
            showDialog('', $_POST['ref_url'] == '' ? 'reload' : $_POST['ref_url'], 'js');
        } else {
            redirect($_POST['ref_url']);
        }
    }

    /**
     * 会员名称检测
     *
     * @param
     * @return
     */
    public function check_memberOp()
    {
        if (C('ucenter_status')) {
            /**
             * 实例化Ucenter模型
             */
            //$model_ucenter = Model('ucenter');
            $model_ucenter = new ucenterModel();
            $result        = $model_ucenter->checkUserExit(trim($_GET['user_name']));
            if ($result == 1) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            /**
             * 实例化模型
             */
            //$model_member = Model('member');
            $model_member = new memberModel();
            // 用户名不能为汉字
            if (!preg_match('|^[0-9a-zA-Z]+$|', trim($_GET['user_name']))) {
                echo 'false';
                die;
            }
            $check_member_name = $model_member->getMemberInfo(['member_name' => $_GET['user_name']]);
            if (is_array($check_member_name) && count($check_member_name) > 0) {
                echo 'false';
                die;
            } else {
                echo 'true';
                die;
            }
        }
    }

    /**
     * 电子邮箱检测
     *
     * @param
     * @return
     */
    public function check_emailOp()
    {
        if (C('ucenter_status')) {
            /**
             * 实例化Ucenter模型
             */
            //$model_ucenter = Model('ucenter');
            $model_ucenter = new ucenterModel();
            $result        = $model_ucenter->checkEmailExit(trim($_GET['email']));
            if ($result == 1) {
                echo 'true';
            } else {
                echo 'false';
            }

        } else {
            //$model_member       = Model('member');
            $model_member       = new memberModel();
            $check_member_email = $model_member->getMemberInfo(['member_email' => $_GET['email']]);
            if (is_array($check_member_email) && count($check_member_email) > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    /**
     * 忘记密码页面
     */
    public function forget_passwordOp()
    {
        /**
         * 读取语言包
         */
        Language::read('home_login_register');
        $_pic = @unserialize(C('login_pic'));
        if ($_pic[0] != '') {
            Tpl::output('lpic', UPLOAD_SITE_URL_HTTPS . '/' . ATTACH_LOGIN . '/' . $_pic[array_rand($_pic)]);
        } else {
            Tpl::output('lpic', UPLOAD_SITE_URL_HTTPS . '/' . ATTACH_LOGIN . '/' . rand(1, 4) . '.jpg');
        }
        Tpl::output('html_title', C('site_name') . ' - ' . Language::get('login_index_find_password'));
        Tpl::showpage('find_password');
    }

    /**
     * 找回密码的发邮件处理
     */
    public function find_passwordOp()
    {
        Language::read('home_login_register');
        $lang = Language::getLangContent();

        $result = chksubmit(true, true, 'num');
        if ($result !== false) {
            if ($result === -11) {
                showDialog('非法提交', 'reload', 'error');
            } elseif ($result === -12) {
                showDialog('验证码错误', '', 'error');
            }
        }

        if (empty($_POST['username'])) {
            showDialog($lang['login_password_input_username'], '', 'error');
        }

        if (process::islock('forget')) {
            showDialog($lang['nc_common_op_repeat'], '', 'error');
        }

        //$member_model = Model('member');
        $member_model = new memberModel();
        $member       = $member_model->getMemberInfo(['member_name' => $_POST['username'], 'member_type' => $member_model::MEMBER_TYPE_AVERAGE_USER]);
        if (empty($member) or !is_array($member)) {
            process::addprocess('forget');
            showDialog($lang['login_password_username_not_exists'], '', 'error');
        }

        if (empty($_POST['email'])) {
            showDialog($lang['login_password_input_email'], '', 'error');
        }

        if (strtoupper($_POST['email']) != strtoupper($member['member_email'])) {
            process::addprocess('forget');
            showDialog($lang['login_password_email_not_exists'], '', 'error');
        }
        process::clear('forget');
        //产生密码
        $new_password = random(15);
        if (!($member_model->editMember(['member_id' => $member['member_id']], ['member_passwd' => hj_password_hash($new_password)]))) {
            showDialog($lang['login_password_email_fail'], '', 'error');
        } else {
            if (C('ucenter_status')) {
                /**
                 * Ucenter处理
                 */
                //$model_ucenter = Model('ucenter');
                $model_ucenter = new ucenterModel();
                $model_ucenter->userEdit(['login_name' => $_POST['username'], '', 'password' => trim($new_password)]);
            }
        }

        $model_tpl = Model('mail_templates');
        //$model_tpl             = new mail_templatesModel();
        $tpl_info              = $model_tpl->getTplInfo(['code' => 'reset_pwd']);
        $param                 = [];
        $param['site_name']    = C('site_name');
        $param['user_name']    = $_POST['username'];
        $param['new_password'] = $new_password;
        $param['site_url']     = SHOP_SITE_URL;
        $subject               = ncReplaceText($tpl_info['title'], $param);
        $message               = ncReplaceText($tpl_info['content'], $param);

        $email  = new Email();
        $result = $email->send_sys_email($_POST["email"], $subject, $message);
        showDialog('新密码已经发送至您的邮箱，请尽快登录并更改密码！', '', 'succ', '', 5);
    }

    /**
     * 邮箱绑定验证
     */
    public function bind_emailOp()
    {
        //$model_member = Model('member');
        $model_member = new memberModel();
        $uid          = @base64_decode($_GET['uid']);
        $uid          = decrypt($uid, '');
        list($member_id, $member_email) = explode(' ', $uid);

        if (!is_numeric($member_id)) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $member_info = $model_member->getMemberInfo(['member_id' => $member_id], 'member_email');
        if ($member_info['member_email'] != $member_email) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $member_common_info = $model_member->getMemberCommonInfo(['member_id' => $member_id]);
        if (empty($member_common_info) || !is_array($member_common_info)) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }
        if (md5($member_common_info['auth_code']) != $_GET['hash'] || TIMESTAMP - $member_common_info['send_acode_time'] > 24 * 3600) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $update = $model_member->editMember(['member_id' => $member_id], ['member_email_bind' => 1]);
        if (!$update) {
            showMessage('系统发生错误，如有疑问请与管理员联系', SHOP_SITE_URL, 'html', 'error');
        }

        $data                    = [];
        $data['auth_code']       = '';
        $data['send_acode_time'] = 0;
        $update                  = $model_member->editMemberCommon($data, ['member_id' => $_SESSION['member_id']]);
        if (!$update) {
            showDialog('系统发生错误，如有疑问请与管理员联系');
        }
        showMessage('邮箱设置成功', 'index.php?controller=member_security&action=index');

    }

    /**
     * 注册用户身份证上传
     */
    public function pic_uploadOp()
    {
        if (chksubmit(true)) {
            //上传图片
            $upload = new AliOssUpload();
            $upload->set('thumb_width', 500);
            $upload->set('thumb_height', 499);
            $ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
            $upload->set('file_name', "idcard_" . time() . rand(100, 999) . ".jpg");
            $upload->set('thumb_ext', '_new');
            $upload->set('ifremove', true);
            $upload->set('default_dir', ATTACH_AVATAR);
            if (!empty($_FILES['pic']['tmp_name'])) {
                $result = $upload->upfile('pic');
                if ($result) {
                    $img_path = $upload->getSysSetPath() . $upload->file_name;
                    exit(json_encode(['status' => 1, 'msg' => $img_path]));
                } else {
                    exit(json_encode(['status' => 0, 'msg' => $upload->error]));
                }
            }
        }
    }
}
