<?php
defined('ByCCYNet') or exit('Access Invalid!');

class indexControl extends BaseJfControl
{

    /**
     * 积分首页
     */
    public function indexOp()
    {
        $goodsModel = Model('jfgoods');


        $where['goods_storage'] = ['gt', 0];
        $where['goods_verify']  = ['eq', 1];

        //获取销量最高的5个
        $salenumInfo = $goodsModel->where($where)->order('goods_salenum desc,goods_id desc')->limit(5)->select();

        //现金 + 积分少也能换
        $moneyDesc = $goodsModel->where($where)->order('goods_integral asc')->limit(4)->select();

        //积分多 更划算
        $integralDesc = $goodsModel->where($where)->order('goods_integral desc,goods_price asc')->limit(6)->select();

        //随机获取3条商品数据
        $randGoods = $goodsModel->where($where)->order(' rand() ')->limit(3)->select();

        Tpl::output('salenumInfo', $salenumInfo);
        Tpl::output('moneyDesc', $moneyDesc);
        Tpl::output('integralDesc', $integralDesc);
        Tpl::output('randGoods', $randGoods);
        Tpl::output('webTitle', '海吉壹佰  - 积分商城首页');
        Tpl::output('current_type', 1);
        Tpl::showpage('index');
    }

    /**
     * 我能兑换
     */
    public function myCanExchangeOp()
    {

        $goodsModel = Model('jfgoods');
        $userModel  = Model('member');
        $userId     = $_SESSION['member_id'];
        //判断是否登录
        if (!empty($userId)) {
            //获取用户积分
            $userInfo = $userModel->where(['member_id' => $userId])->field('member_id,member_h_points')->find();

            //获取我能兑换的商品
            $where['goods_storage']  = ['gt', 0];
            $where['goods_verify']   = ['eq', 1];
            $where['goods_integral'] = ['elt', $userInfo['member_h_points']];
            $where['goods_hjb']      = ['eq', 0];
            $info                    = $goodsModel->where($where)->order('goods_salenum desc,goods_id desc')->select();
            Tpl::output('info', $info);
            Tpl::output('current_type', 3);
            Tpl::showpage('myCanExchange');
            Tpl::output('webTitle', '海吉壹佰  - 积分商城 - 我能兑换');
        } else {
            redirect('/member/index.php?controller=login&action=index');
        }
    }


    /**
     * 积分特权
     */
    public function integralPrivilegeOp()
    {
        $userId        = $_SESSION['member_id'];
        $model_prize   = Model('prize');
        $model_setting = Model('setting');
        $prize_record  = Model('prize_record');
        $list_setting  = $model_setting->getListSetting();
        $list          = $model_prize->order('prize_sort desc')->select();
        Tpl::output('prize_open', $list_setting['prize_open']);
        $time  = time();
        $start = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
        $end   = mktime(23, 59, 59, date("m", $time), date("d", $time), date("Y", $time));

        $today_num_where             = [];
        $today_num_where['uid']      = 7;
        $today_num_where['add_time'] = ['between', [$start, $end]];
        $today_num                   = $prize_record->where($today_num_where)->count();
        if ($today_num > ($list_setting['prize_free_num'] + $list_setting['prize_jf_num'])) {//查看今日抽奖次数是否使用完了
            $yes = 0;
        } else {
            $yes = 1;
        }
        $prize_list = $prize_record->order('id desc')->page(20)->select();
        foreach ($prize_list as $key => $value) {
            $userModel                       = Model('member');
            $userInfo                        = $userModel->where(['member_id' => $value['uid']])->field('member_id,member_name,member_h_points,sign_in_money')->find();
            $prize_list[$key]['member_name'] = $userInfo['member_name'];
        }
        if ($userId && $userId > 0) {
            $login = 1;
        } else {
            $login = 0;
        }
        Tpl::output('login', $login);
        Tpl::output('prize_list', $prize_list);
        Tpl::output('yes', $yes);//var_dump($list_setting['prize_open']);exit;
        Tpl::output('list', $list);//var_dump($list_setting['prize_open']);exit;
        Tpl::output('current_type', 2);
        Tpl::output('webTitle', '海吉壹佰  - 积分商城 - 积分特权');
        Tpl::showpage('integralPrivilege');
    }

    //写入抽奖记录
    public function prize_goodOp()
    {
        $id = $_REQUEST['id'];//测试使用
        //$id = $_POST['id'];
        $time  = time();
        $start = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
        $end   = mktime(23, 59, 59, date("m", $time), date("d", $time), date("Y", $time));
        if (!$id || $id < 1) {
            $rs = ['status' => -1, 'msg' => '非法操作'];
            echo json_encode($rs);
            exit;
        }
        $prize        = Model('prize');
        $prize_record = Model('prize_record');
        $prize_info   = $prize->where(['id' => $id])->find();
        if (!$prize_info) {
            $rs = ['status' => -1, 'msg' => '非法操作'];
            echo json_encode($rs);
            exit;
        }
        $userId = $_SESSION['member_id'];
        //获取用户信息
        $userModel                   = Model('member');
        $userInfo                    = $userModel->where(['member_id' => $userId])->field('member_id,available_predeposit,member_h_points,sign_in_money')->find();
        $model_setting               = Model('setting');
        $list_setting                = $model_setting->getListSetting();
        $today_num_where             = [];
        $today_num_where['uid']      = $userId;
        $today_num_where['add_time'] = ['between', [$start, $end]];
        $today_num                   = $prize_record->where($today_num_where)->count();
        if ($today_num > ($list_setting['prize_free_num'] + $list_setting['prize_jf_num'])) {//查看今日抽奖次数是否使用完了
            $rs = ['status' => -1, 'msg' => '今日抽奖次数已使用完了'];
            echo json_encode($rs);
            exit;
        }


        $insert_data                = [];
        $insert_data['add_time']    = $time;
        $insert_data['uid']         = $userId;
        $insert_data['prize_name']  = $prize_info['prize_name'];
        $insert_data['prize_image'] = $prize_info['prize_image'];
        //$rs = array('status'=>-1,'msg'=>'测试','test'=>$prize_info);

        if ($today_num > $list_setting['prize_free_num'] && $list_setting['prize_jf_money'] > 0) {//查看当前次数量是否免费

            if ($userInfo['member_h_points'] < $insert_data['prize_jf_money']) {
                $rs = ['status' => -1, 'msg' => '积分不已不够抽奖！'];
                echo json_encode($rs);
                exit;
            }
            $memberArray                    = [];
            $memberArray['member_h_points'] = $userInfo['member_h_points'] - $list_setting['prize_jf_money'];
            $saveUserInfo                   = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);

            $this->pointsLog($userInfo['member_id'], $list_setting['prize_jf_money'], '抽奖扣除' . $list_setting['prize_jf_money'] . '积分');
        }
        if ($prize_info['dispose']) {//需要后台人工处理
            if ($prize_info['prize_jf'] > 0) {//是否有奖励海吉币 增加海吉币
                $memberArray['sign_in_money'] = $userInfo['sign_in_money'] + $prize_info['prize_jf'];

                //积分、海吉币
                $memberArray  = [];
                $saveUserInfo = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);
                $this->signLog($userInfo['member_id'], $orderInfo['prize_jf'], $prize_info['id']);
            }
            if ($prize_info['prize_jf2'] > 0) {//是否有奖励积分 增加海吉币
                $memberArray                    = [];
                $memberArray['member_h_points'] = $userInfo['member_h_points'] + $prize_info['prize_jf2'] - $list_setting['prize_jf_money'];

                //积分、海吉币

                $saveUserInfo = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);

                $this->pointsLog1($userInfo['member_id'], $prize_info['prize_jf2'], '抽奖获得' . $prize_info['prize_jf2'] . '积分');
            }
            $insert_data['dispose'] = 0;
        } else {//无需后台人工处理
            if ($prize_info['prize_jf'] > 0) {//是否有奖励海吉币 增加海吉币
                $memberArray                  = [];
                $memberArray['sign_in_money'] = $userInfo['sign_in_money'] + $prize_info['prize_jf'];

                //积分、海吉币

                $saveUserInfo = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);

                $this->signLog($userInfo['member_id'], $prize_info['prize_jf'], $prize_info['id']);
            }
            //echo $prize_info['prize_jf2'];exit;
            if ($prize_info['prize_jf2'] > 0) {//是否有奖励积分 增加海吉币
                $memberArray                    = [];
                $memberArray['member_h_points'] = $userInfo['member_h_points'] + $prize_info['prize_jf2'] - $list_setting['prize_jf_money'];

                //积分、海吉币

                $saveUserInfo = $userModel->where(['member_id' => $userInfo['member_id']])->update($memberArray);

                $this->pointsLog1($userInfo['member_id'], $prize_info['prize_jf2'], '抽奖获得' . $prize_info['prize_jf2'] . '积分');
            }

            $insert_data['dispose']      = 1;
            $insert_data['dispose_time'] = $time;
        }

        //echo '<pre>';print_r($insert_data);exit;

        $result = $prize_record->insert($insert_data);
        if ($result) {

            $rs = ['status' => 1, 'msg' => '成功'];
            echo json_encode($rs);
            exit;
        } else {
            $rs = ['status' => -1, 'msg' => '抽奖失败,请联系平台'];
            echo json_encode($rs);
            exit;
        }
    }

    /**
     * 增加海吉币消费日志
     * @param $userId
     * @param $number
     * @param $orderNo
     */
    public function signLog($userId, $number, $orderNo)
    {
        $rs = false;
        if ($number > 0) {
            $model                = Model('sign_in_log');
            $data['number']       = $number;
            $data['user_id']      = $userId;
            $data['source']       = '';
            $data['content']      = '抽奖获得海吉币 ' . $number . ' 个';
            $data['use_info']     = '抽奖获得';
            $data['use_orderNo']  = $orderNo;
            $data['sign_in_time'] = date('Y-m-d- H:i:s');//echo '<pre>';print_r($data);exit;
            $add                  = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }

    /**
     * 增加积分日志
     * @param $userId
     * @param $point
     * @param $desc
     */
    public function pointsLog($userId, $point, $desc)
    {
        $rs = false;
        if ($point > 0) {
            $model                 = Model('points_log');
            $data['pl_memberid']   = $userId;
            $data['pl_membername'] = $_SESSION['member_name'];
            $data['pl_points']     = '-' . $point;
            $data['pl_addtime']    = time();
            $data['pl_desc']       = $desc;
            $data['pl_stage']      = 'prize';
            $add                   = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }

    /**
     * 增加积分日志
     * @param $userId
     * @param $point
     * @param $desc
     */
    public function pointsLog1($userId, $point, $desc)
    {
        $rs = false;
        if ($point > 0) {
            $model                 = Model('points_log');
            $data['pl_memberid']   = $userId;
            $data['pl_membername'] = $_SESSION['member_name'];
            $data['pl_points']     = '+' . $point;
            $data['pl_addtime']    = time();
            $data['pl_desc']       = $desc;
            $data['pl_stage']      = 'prize';
            $add                   = $model->insert($data);
            if ($add) {
                $rs = true;
            }
        }
        return $rs;
    }
}
