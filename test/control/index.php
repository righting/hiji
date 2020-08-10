<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2018/11/29 11:51
// +----------------------------------------------------------------------

class indexControl extends BaseController
{
    protected function indexOp()
    {
        $username = $_GET['name'];
        $password = $_GET['psw'];
        //用户登录
        $member = $this->memberLogin($username, $password);

        //获得用户等级信息
        $user_level = $this->member_model->getOneMemberGrade();
        echo '会员当前等级：' . $user_level['level_name'] . '<br>';
        echo '会员一下等级：' . $user_level['upgrade_name'] . '<br>';
        if ($user_level['level'] == 0) {
            //普通用户 需要先认证，绑定团队才能成为免费会员
            echo '普通用户需要先认证再绑定团队才能成为免费会员<br>';
            //认证
            echo '开始执行用户认证<br>';
            $member_detail_model = new member_detailModel();

            $update  = $member_detail_model->editMemberDetail(['member_id' => $member['member_id']], ['isauth' => 1, 'auth_time' => TIMESTAMP]);
            $message = '失败';
            if ($update) {
                $message            = '成功';
                $_SESSION['isauth'] = 1;
            }
            echo '用户认证' . $message . '<br>';
            //绑定团队
            echo '开始执行绑定团队<br>';
            $rs      = $this->bindTeam($member['member_id'], 'HJ10020181209888');
            $message = $rs ? '成功' : '失败';
            echo '用户绑定团队' . $message . '<br>';
        } else {
            //当前会员拥有的可升级HS积分
            echo '会员拥有的可升级HS积分：' . $member['member_points'] . '<br>';
            echo '会员升级到一下等级需要消耗HS积分：' . $user_level['upgrade_point'] . '<br>';
            if ($member['member_points'] >= $user_level['upgrade_point']) {
                echo '会员拥有的可升级HS积分足够会员升级到下一等级，执行会员升级操作<br>';
            } else {
                echo 'HS积分不足以升级到下一等级，需要购买海豚主场商品以获取足够的HS积分<br>';
                $goods_detail = $this->getGoodsDetail(3);
                //dump($goods_detail);
                $post['cart_id'] = [$goods_detail['goods_commonid'] . '|1|'];
                $this->buy_step1($post);
            }
        }
        //dump($user_level);
    }

    /**
     * 绑定会员邀请关系
     */
    public function inviteOp()
    {
        $depth = [1, 2, 3, 4, 5, 6, 7];
        $time  = date('Y-m-d H:i:s');

        $memberModel = new memberModel();
        $inviteModel = new register_inviteModel();

        foreach ($depth as $k => $val) {
            $limit = pow(3, $depth[$k]);

            if ($depth[$k] == 1) {
                $member_id = $memberModel->field('member_id')
                    ->where(['member_id' => ['gt', 1]])
                    ->order('member_id asc')
                    ->limit($limit)
                    ->select();
                $member_id = array_column($member_id, 'member_id');

                $datas = [];
                foreach ($member_id as $key => $value) {
                    $datas[$key]['from_user_id'] = 1;
                    $datas[$key]['to_user_id']   = $value;
                    $datas[$key]['register_at']  = $time;
                    $datas[$key]['depth']        = 1;
                }
                $inviteModel->insertAll($datas);

            } else {
                $invite     = $inviteModel->where(['depth' => $depth[$k - 1]])->order('id asc')->select();
                $to_user_id = array_column($invite, 'to_user_id');

                $member_id = $memberModel->field('member_id')
                    ->where(['member_id' => [['not in', $to_user_id], ['gt', end($to_user_id)]]])
                    ->order('member_id asc')
                    ->limit($limit)
                    ->select();
                $member_id = array_column($member_id, 'member_id');

                $data = [];
                foreach ($member_id as $key => $value) {
                    $data[$key]['from_user_id'] = $invite[floor($key / 3)]['to_user_id'];
                    $data[$key]['to_user_id']   = $value;
                    $data[$key]['register_at']  = $time;
                    $data[$key]['depth']        = $depth[$k];
                }
                $inviteModel->insertAll($data);
            }

        }

    }

    /**
     * 注册用户
     */
    public function usersOp()
    {
        echo 'http://' . $_SERVER['HTTP_HOST'] . '/test/index.php?controller=index&action=users&<font color="red">min</font>=1&<font color="red">max</font>=10<br><br>';
        echo '<b>min参数：必须</b><br>';
        echo '<b>max参数：必须</b><br><br>';
        echo '步长建议是：10，否则有可能会执行超时！<br>';
        echo '例如第一次执行时，min参数是1，max参数是10，那么第二次执行时，min参数应该是11，而max参数应该是20<br><br>';
        echo '如果min参数是1，max参数是10，则会批量注册<font color="red">用户名为：hiji2000001-hiji2000010。密码及支付密码统一为：123456</font><br>';
        echo '所有已经注册的用户已经绑定邮箱，绑定手机，实名认证并且拥有1000000预付款<br><br>';

        $min = $_GET['min'];
        $max = $_GET['max'];

        if (empty($min) || !is_numeric($min) || empty($max) || !is_numeric($max)) {
            exit('缺少参数或者参数错误');
        }
        ini_set('memory_limit', '2048M');    // 临时设置最大内存占用为3G
        set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过期

        //构造数据
        $username_prefix          = 'hiji2';//用户名前缀
        $data['password']         = '123456';//密码
        $data['password_confirm'] = '123456';//确认密码

        $result = [];
        for ($i = $min; $i <= $max; $i++) {
            $num = substr(strval($i + 100000000), -6);

            $data['username'] = $username_prefix . $num;
            $data['email']    = $username_prefix . $num . '@qq.com';
            $data['mobile']   = '138001' . $num;
            $result[]         = $this->member_model->register($data);
            if (array_key_exists('error', $result[0])) {
                echo $result[0]['error'] . '<br>';
                break;
            }
            if (!empty($result)) {
                foreach ($result as $key => $value) {
                    if (!array_key_exists('error', $value)) {
                        //echo '用户：' . $value['member_name'] . '注册成功。<br>';
                        // 1、设置支付密码 绑定手机 绑定邮箱 增加预存款
                        $this->member_model->editMember(['member_id' => $value['member_id']], ['member_paypwd' => md5('123456'), 'member_mobile_bind' => 1, 'member_mobile' => $data['mobile'], 'member_email_bind' => 1, 'member_email' => $data['email'], 'available_predeposit' => 1000000]);
                        // 2、实名认证
                        $member_detail_model = new member_detailModel();
                        $member_detail_model->editMemberDetail(['member_id' => $value['member_id']], ['isauth' => 1, 'auth_time' => TIMESTAMP]);
                    } else {
                        echo $value['error'] . '<br>';
                        break;
                    }
                }
            }

            if ($i == $max) {
                echo '<b>第' . $min . '到' . $max . '位用户注册成功</b><br><br>';
                $_min = $max + 1;
                $_max = $max + 10;
                echo "是否批量注册第{$_min}到{$_max}位用户？";
                $url = 'http://' . $_SERVER['HTTP_HOST'] . '/test/index.php?controller=index&action=users&min=' . $_min . '&max=' . $_max;
                echo '<a href="' . $url . '">' . $url . '</a>';
            }
            $result[] = $data;
        }

        //unset($result['member_passwd'], $result['member_email'], $result['invite_one'], $result['invite_two'], $result['invite_three']);
        //dump($result);
    }

    /**
     * 添加收货地址
     */
    public function add_addressOP()
    {
        $addressModel       = new addressModel();
        $address            = $addressModel->select();
        $address_members_id = array_column($address, 'member_id');

        $memberModel = new memberModel();
        $where       = ['member_id' => ['not in', $address_members_id]];
        $limit       = $memberModel->where($where)->count();
        $list        = $memberModel->where($where)->field('member_id')->limit($limit)->select();
        $user_id_arr = array_column($list, 'member_id');

        $addressData = [];

        foreach ($user_id_arr as $key => $value) {
            $addressData[$key]['member_id'] = $value;
            $addressData[$key]['true_name'] = '小姐姐';
            $addressData[$key]['area_id']   = 3059;
            $addressData[$key]['city_id']   = 291;
            $addressData[$key]['area_info'] = '广东 深圳市 宝安区';
            $addressData[$key]['address']   = '龙华新区龙峰三路福龙家园A栋2B';
            $addressData[$key]['mob_phone'] = '13800138000';
        }

        $addressModel->insertAll($addressData);

    }

    /**
     * 用户登录
     * @param string $username
     * @param string $password
     * @return array
     */
    protected function memberLogin($username = '', $password = '')
    {
        if (empty($_SESSION['is_login'])) {
            $validate                = new Validate();
            $validate->validateparam = [
                ["input" => $username, "require" => "true", "message" => '账号不能为空'],
                ["input" => $password, "require" => "true", "message" => '密码不能为空'],
            ];
            $error                   = $validate->validate();
            if (!empty($error)) {
                exit($error);
            }

            $condition                = [];
            $condition['member_name'] = $username;
            $condition['member_type'] = memberModel::MEMBER_TYPE_AVERAGE_USER;
            $member_info              = $this->member_model->getMemberInfo($condition);
            if (empty($member_info) && preg_match('/^0?(13|14|15|17|18)[0-9]{9}$/i', $username)) {//根据会员名没找到时查手机号
                unset($condition['member_name']);
                $condition['member_mobile'] = $username;
                $member_info                = $this->member_model->getMemberInfo($condition);
            }
            if (empty($member_info) && (strpos($username, '@') > 0)) {//按邮箱和密码查询会员
                unset($condition['member_name']);
                $condition['member_email'] = $username;
                $member_info               = $this->member_model->getMemberInfo($condition);
            }
            if (empty($member_info) && (strpos($username, 'HJ') !== false)) {
                unset($condition['member_name']);
                $condition['member_number'] = $username;
                $member_info                = $this->member_model->getMemberInfo($condition);
            }

            if (is_array($member_info) && !empty($member_info)) {
                // 检查密码是否正确
                if (!empty(hj_password_verify($password, $member_info['member_passwd']))) {
                    exit('账号或密码错误');
                }
                if (!$member_info['member_state']) {
                    exit('账号被停用');
                }
            } else {
                exit('账号错误');
            }

            $this->member_model->createSession($member_info);
            $_SESSION['member_info'] = $member_info;

            if (!empty($member_info['member_mobile']) && empty($member_info['member_name']) && empty($member_info['member_email'])) {
                $user = $member_info['member_mobile'];
            } elseif (empty($member_info['member_mobile']) && empty($member_info['member_name']) && !empty($member_info['member_email'])) {
                $user = $member_info['member_email'];
            } else {
                $user = $member_info['member_name'];
            }
            echo '用户' . $user . '登录成功<br>';
            //设置支付密码
            if (empty($member_info['member_paypwd'])) {
                $update  = $this->member_model->editMember(['member_id' => $member_info['member_id']], ['member_paypwd' => md5('123456')]);
                $message = $update ? '成功' : '失败';
                echo '支付密码设置' . $message . '<br>';
            }
            //增加预存款
            if ($member_info['available_predeposit'] <= 0) {
                $update  = $this->member_model->editMember(['member_id' => $member_info['member_id']], ['available_predeposit' => 1000000]);
                $message = $update ? '成功' : '失败';
                echo '预存款添加' . $message . '<br>';
            }
            return $member_info;
        } else {
            return $_SESSION['member_info'];
        }
    }

    /**
     * 用户登出
     */
    public function logoutOp()
    {
        // 清理COOKIE
        setNcCookie('msgnewnum' . $_SESSION['member_id'], '', -3600);
        setNcCookie('auto_login', '', -3600);
        setNcCookie('cart_goods_num', '', -3600);
        session_unset();
        session_destroy();
        echo '退出成功';
    }

}