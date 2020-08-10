<?php
/**
 * 活动
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class user_hi_logModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_hi_log');
    }

    // 记录日志
    public function addLog($user_id, $hi_value, $hi_type, $get_type, $msg)
    {
        $hi_value_model   = new user_hi_valueModel();
        $data['user_id']  = $user_id;
        $data['hi_value'] = $hi_value;
        $data['hi_type']  = $hi_type;
        $data['get_type'] = $get_type;
        //  $expiration_at = 0;
        Db::beginTransaction();

        // 过期时间按照会员当前的等级计算
        $user_model = new memberModel();
        // 获取用户当前拥有的经验值
        $buyer_info     = $user_model->where(['member_id' => $user_id])->field('level_id')->find();
        $buyer_level_id = $buyer_info['level_id'];
        // 获取会员当前等级信息
        $user_level_model = new user_levelModel();
        $user_level_info  = $user_level_model->where(['id' => $buyer_level_id])->find();
        // 获取过期时间
        $expiration_at = date("Y-m-d H:i:s", strtotime("+" . $user_level_info['hi_term'] . " month", strtotime(date('Y-m-d H:i:s'))));

        // 如果是推荐团队赠送的 HI 值，那么会有过期时间
        /* if($hi_type == $hi_value_model::HI_TYPE_RECOMMEND_TEAM){
             // 过期时间按照会员当前的等级计算
             $user_model = Model('member');
             // 获取用户当前拥有的经验值
             $buyer_info = $user_model->where(['member_id'=>$user_id])->field('level_id')->find();
             $buyer_level_id = $buyer_info['level_id'];
             // 获取会员当前等级信息
             $user_level_model = Model('user_level');
             $user_level_info = $user_level_model->where(['id'=>$buyer_level_id])->find();
             // 获取过期时间
             $expiration_at = date("Y-m-d H:i:s",strtotime("+".$user_level_info['hi_term']." month",strtotime(date('Y-m-d H:i:s'))));
         }*/

        $data['expiration_at'] = $expiration_at;
        $data['created_at']    = date('Y-m-d H:i:s');
        $data['remark']        = $msg;
        $add_result            = $this->insert($data);
        if ($add_result) {
            Db::commit();
            return true;
        }
        Db::rollback();
        return false;
    }

    /**
     * 按条件获取hi值日志记录
     *
     * @param null $con
     * @return mixed
     */
    public function getHiLogList($con = null)
    {
        $data = $this->where($con)->page(20)->order('id desc')->select();
        if (empty($data)) {
            return;
        }
        foreach ($data as &$v) {
            switch ($v['hi_type']) {
                case 1:
                    $v['hi_type'] = '升级获得';
                    break;
                case 2:
                    $v['hi_type'] = '推荐获得';
                    break;
                case 3:
                    $v['hi_type'] = '资金转换';
                    break;
            }
            if ($v['get_type'] == 1) {
                $v['get_type'] = '+';
            } else {
                $v['get_type'] = '-';
            }
            if (strtotime($v['expiration_at']) == 0) {
                $v['expiration_at'] = '永久有效';
            }
        }
        unset($v);
        return $data;
    }

    /**
     * 获取当月已兑现hi值
     *
     * @param $user_id
     * @return mixed
     */
    public function getExchangeHi_month($user_id)
    {
        $month_start       = date('Y-m'); // 月初时间
        $con['user_id']    = $user_id;
        $con['get_type']   = 2;// 操作为减少
        $con['hi_type']    = 3;// 类型为兑现
        $con['created_at'] = ['EGT', $month_start];
        $res               = $this->where($con)->sum('hi_value');
        if (empty($res))
            return 0;
        return $res;
    }

    /**
     * 获取将到期HI值总和
     *
     * @param $user_id
     * @param $day_num
     * @return mixed
     */
    public function getHiExpire($user_id, $day_num)
    {
        $date = date('Y-m-d h:i:s', TIMESTAMP - $day_num * 86400);
        return $this->where(['user_id' => $user_id, 'expiration_at' => ['BETWEEN', [$date, date('Y-m-d H:i:s', TIMESTAMP)]]])->sum('hi_value');
    }

    public function getHiType($type)
    {
        $arr = [
            1 => '升级获得',
            2 => '推荐团队赠送',
            3 => '奖金转换',
            4 => '兑现减少'
        ];
        return isset($arr[$type]) ? $arr[$type] : $arr;
    }
}
