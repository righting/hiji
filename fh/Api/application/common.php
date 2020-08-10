<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;

// 应用公共文件

function parse_name($string)
{
	return $string;
}

if (!function_exists('success')) {
    /**
     * 成功
     * @param string|array $msg    响应信息
     * @param string|array $data   响应数据
     * @param array        $header 响应头
     */
    function success($msg = 'success', $data = null, $header = [])
    {
        if (is_array($msg) || is_object($msg)) {
            $data = $msg;
            $msg  = 'success';
        }
        result(0, $msg, $data, $header);
    }
}

if (!function_exists('error')) {
    /**
     * 失败
     * @param string $msg    响应信息
     * @param int    $code   响应状态码
     * @param string $data   响应数据
     * @param array  $header 响应头
     */
    function error($msg = 'error', $code = -1, $data = '', $header = [])
    {
        result($code, $msg, $data, $header);
    }
}

if (!function_exists('result')) {
    /**
     * @param int          $code   响应状态码，0:成功；其它:失败
     * @param string|array $msg    响应信息
     * @param string|array $data   响应数据
     * @param array        $header 响应头
     */
    function result($code = 0, $msg = '', $data = null, $header = [])
    {
        $responseData = ['code' => $code, 'msg' => $msg, 'data' => $data];
        $response = Response::create($responseData, 'json')->header($header);

        throw new HttpResponseException($response);
    }
}

/**
 * 格式化价格
 * @param float $price 价格
 * @return float
 */
function price_format($price)
{
    return number_format($price, 2, '.', '');
}

/**
 * 获取会员详情
 * @param int $member_id 会员ID
 * @return array
 */
function member_info($member_id)
{
    return db('member')->where('member_id', $member_id)->find();
}

/**
 * 获取分红池列表/详情
 * @param string $name 分红池名称
 * @param string $date 指定日期
 * @return array
 */
function bonus_pool($name = null, $date = null)
{
	//指定日期
	if ($date == 'yesterday') {
		$date = date('Ymd', time() - 86400);
	}

	if ($date) {
		$log = db('bonus_pool_day_log')->where('date', $date)->find();
		if ($log) {
			return $name && isset($log[$name]) ? $log[$name] : $log;
		} else {
			return 0;
		}
	}

    $list = db('bonus_pool')->select();

    if ($name !== null) {
        foreach ($list as $k => $v) {
            if ($v['name'] == $name) {
                return $v['surplus_bonus'];
            }
        }
    }

    $info = [];
    foreach ($list as $k => $v) {
    	$info[$v['name']] = $v['surplus_bonus'];
    }
    return $info;
}

/**
 * 更新指定分红池的金额
 * @param int $member_id 会员ID
 * @param float $change_bonus 变化的金额
 * @param string $remark 备注
 * @return bool
 */
function update_bonus_pool($name, $change_bonus, $remark)
{
	if ($change_bonus == 0) {
		return true;
	}

	//插入分红池日志表
	$rs1 = db('bonus_pool_log')->insert([
		'name' 					=> $name,
		'change_surplus_bonus' 	=> $change_bonus,
		'remark' 				=> $remark,
		'add_time' 				=> time(),
	]);
	//修改池子金额
	$rs2 = db('bonus_pool')->where('name', $name)->setInc('surplus_bonus', $change_bonus);
	return $rs1 && $rs2;
}

/**
 * 更新会员余额
 * @param int $member_id 会员ID
 * @param float $change_balance 变化的金额
 * @param string $bonus_name 分红名称
 * @param int $order_id 订单ID
 * @return bool
 */
function update_member_balance($member_id, $change_balance, $bonus_name, $order_id = 0)
{
	if ($change_balance == 0) {
		return true;
	}

	//插入会员分红日志表
    $member_bonus_pool_log = [
        'member_id'             => $member_id,
        'order_id'              => $order_id,
        'name'                  => $bonus_name,
        'change_bonus'  		=> $change_balance,
        'remark'                => $bonus_name,
        'add_time'              => time(),
    ];
    db('member_bonus_pool_log')->insert($member_bonus_pool_log);

	return db('member')->where('member_id', $member_id)->setInc('bonus', $change_balance);
}

/**
 * 指定会员的直推会员
 * @param int $member_id 会员ID
 * @return array
 */
function member_subordinate_direct($member_id, $time = null)
{
	$list = db('register_invite')->where(function($query)use($time){
									if (!empty($time['start_time'])) {
					           			$query->where('register_at', 'egt', strtotime($time['start_time']));
					           		}

					           		if (!empty($time['end_time'])) {
					           			$query->where('register_at', 'elt', strtotime($time['end_time']));
					           		}
								 })
								 ->where('from_user_id', 'in', $member_id)
								 ->select();

	return array_column($list, 'to_user_id');
}

/**
 * 指定会员的直属下级
 * @param int $member_id 会员ID
 * @return array
 */
function member_subordinate_positions($member_id, $time = null)
{
	//用户当前等级
	$positions_id = db('member')->where('member_id', $member_id)->value('positions_id');
	if ($positions_id == 8) {
		return [];
	}

	//用户直推会员
	$member_subordinate_direct = member_subordinate_direct($member_id);

	$select_positions_id = 0;
	switch ($positions_id) {
		case 1:
			$select_positions_id = 8;
			break;
		case 2:
			$select_positions_id = 1;
			break;
		case 3:
			$select_positions_id = 2;
			break;
		case 4:
			$select_positions_id = 3;
			break;
		case 5:
			$select_positions_id = 4;
			break;
		case 6:
			$select_positions_id = 5;
			break;
		case 7:
			$select_positions_id = 6;
			break;
	}


	$list = db('member')->where('member_id', 'in', $member_subordinate_direct)
						->where('positions_id', $select_positions_id)
						->column('member_id');

	return $list;
}

/**
 * 会员整个团队的ID
 * @param int $member_id 会员ID
 * @return array
 */
function team_member_ids($member_id, $ids = [])
{
    $ids[] = $member_id;
    $list  = db('register_invite')->where(['from_user_id' => $member_id])->select();

    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $ids = team_member_ids($v['to_user_id'], $ids);
        }
    }

    return $ids;
}

/**
 * 分红操作日志
 * @param string $content 日志
 * @param string $name 分红名称
 * @return array
 */
function bonus_op_log($content, $name = 'system')
{
	return db('bonus_op_log')->insert(['name'=>$name, 'content'=>$content, 'add_time'=>time()]);
}

/**
 * 获取昨天的开始时间和结束时间
 * @return array
 */
function yesterday()
{
	//昨天的00:00:00
    $start_time = date('Y-m-d 00:00:00', strtotime(date('Y-m-d') . ' -1 day'));
    //昨天的23:59:59
    $end_time = date('Y-m-d 23:59:59', strtotime(date('Y-m-d') . ' -1 day'));

	return [
		'start_time' => $start_time,
		'end_time' => $end_time
	];
}

/**
 * 获取上一期的开始时间和结束时间
 * @return array
 */
function pre_period()
{
	//指定2020-01-01为起始日期，28天为一期
	$start_time = strtotime('2020-01-01 00:00:00');
	//当前期数
	$period = ceil((time() - $start_time) / 86400 / 28);

	$pre_period = $period - 1;

	return [
		'start_time' => date('Y-m-d 00:00:00', strtotime('2020-01-01 00:00:00 + '. ($pre_period*28) .' day')),
		'end_time' => date('Y-m-d 23:59:59', strtotime('2020-01-01 00:00:00 + '. ($period*28) .' day') - 1),
	];
}

/**
 * 获取用户指定时间内的消费金额
 *
 * @param int|array $member_id 用户ID
 * @param array $time 时间段
 * @return float
 */
function buyer_order_amount($member_id, $time)
{
	if (!$member_id) {
		return 0;
	}
	return db('orders')->where(function($query)use($time){
			           		if (!empty($time['start_time'])) {
			           			$query->where('thaw_time', 'egt', strtotime($time['start_time']));
			           		}

			           		if (!empty($time['end_time'])) {
			           			$query->where('thaw_time', 'elt', strtotime($time['end_time']));
			           		}
			           })
					   ->where('buyer_id', 'in', $member_id)
			           ->sum('order_amount');
}

/**
 * 获取用户指定时间内的销售金额
 *
 * @param int|array $member_id 用户ID
 * @param array $time 时间段
 * @return float
 */
function seller_order_amount($member_id, $time)
{
	if (!$member_id) {
		return 0;
	}
	return db('orders')->where(function($query)use($time){
			           		if (!empty($time['start_time'])) {
			           			$query->where('thaw_time', 'egt', strtotime($time['start_time']));
			           		}

			           		if (!empty($time['end_time'])) {
			           			$query->where('thaw_time', 'elt', strtotime($time['end_time']));
			           		}
			           })
					   //->where('seller_member_id', 'in', $member_id)
					   ->where('referral_member_id', 'in', $member_id)
			           ->sum('order_amount');
}

/**
 * 获取指定时间内的指定等级的用户
 *
 * @param int $level 等级
 * @param array $time 时间段
 * @return array
 */
function level_member($level, $time)
{
	if (!$level) {
		return 0;
	}

	if (!is_array($level)) {
		$level = [$level];
	} else {
		$level = explode(',', $level);
	}

	if (!is_array($time)) {
		$time = ['end_time'=>$time];
	}

	$list = db('user_log_ascending_degrading')->field('id,user_id,new_level,max(created_at)')
						->where(function($query)use($time){
			           		if (!empty($time['start_time'])) {
			           			$query->where('created_at', 'egt', $time['start_time']);
			           		}

			           		if (!empty($time['end_time'])) {
			           			$query->where('created_at', 'elt', $time['end_time']);
			           		}
			           })
					   ->where(function($query)use($level){
					   		$query->where('new_level', 'egt', $level[0]);
					   		if (!empty($level[1])) {
			           			$query->where('new_level', 'elt', $level[1]);
			           		}
					   })
					   ->group('user_id')
			           ->select();
    $_list = [];
    foreach ($list as $k => $v) {
    	$v['member_id']       = $v['user_id'];
    	$_list[$v['user_id']] = $v;
    }

    return $_list;
}

/**
 * 获取指定时间内的指定职务的用户
 *
 * @param int $level 等级
 * @param array $time 时间段
 * @return array
 */
function positions_member($level, $time)
{
	if (!$level) {
		return 0;
	}

	if (is_array($level)) {
		$level = [$level];
	} else {
		$level = explode(',', $level);
	}

	if (!is_array($time)) {
		$time = ['end_time'=>$time];
	}

	$list = db('positions_log')->field('id,member_id,level_now,max(created_at)')
						->where(function($query)use($time){
			           		if (!empty($time['start_time'])) {
			           			$query->where('created_at', 'egt', $time['start_time']);
			           		}

			           		if (!empty($time['end_time'])) {
			           			$query->where('created_at', 'elt', $time['end_time']);
			           		}
			           })
					   ->where(function($query)use($level){
					   		$query->where('level_now', 'egt', $level[0]);
					   		if (!empty($level[1])) {
			           			$query->where('level_now', 'elt', $level[1]);
			           		}
					   })
					   ->group('member_id')
			           ->select();
    
    
    return $list;
}

/**
 * 获取指定用户的销售额
 * 销售额指：当前用户的个人消费（ 除升级消费）+ 当前用户的微店销售+上一期新增的直推会员和现有直属一级的个人消费总和
 *
 * @param int $member_id 会员ID
 * @param array $time 时间段
 * @param array $order_amount_type 需要查询的统计金额
 * @return array
 */
function member_pre_period_order($member_id, $time = null, $order_amount_type = [])
{
	if (!$time) {
		$time = pre_period();
	}

	if (!is_array($time)) {
		$time = ['end_time'=>$time];
	}
	$update_level_point = 0;
	$buyer_order_amount = 0;
	$seller_order_amount = 0;
	$pp_mds_buyer_order_amount = 0;
	$pp_mds_seller_order_amount = 0;
	$msd_buyer_order_amount = 0;
	$msd_seller_order_amount = 0;
	$pp_mds_update_level_point = 0;
	$msp_buyer_order_amount = 0;
	$msp_seller_order_amount = 0;

	//用户消费金额
	if (in_array('buyer_order_amount', $order_amount_type)) {
		$buyer_order_amount = buyer_order_amount($member_id, $time);
	}

	//用户微店金额
	if (in_array('seller_order_amount', $order_amount_type)) {
		$seller_order_amount = seller_order_amount($member_id, $time);
	}

	//上期新增直推会员
	if (in_array('pp_mds_buyer_order_amount', $order_amount_type) || in_array('pp_mds_seller_order_amount', $order_amount_type)) {
		$pp_mds = member_subordinate_direct($member_id, $time);
	}
	if (in_array('pp_mds_buyer_order_amount', $order_amount_type)) {
		$pp_mds_buyer_order_amount  = buyer_order_amount($pp_mds, $time);
	}
	if (in_array('pp_mds_seller_order_amount', $order_amount_type)) {
		$pp_mds_seller_order_amount = seller_order_amount($pp_mds, $time);
	}

	//现有直推一级
	if (in_array('msd_buyer_order_amount', $order_amount_type) || in_array('msd_seller_order_amount', $order_amount_type)) {
		$member_subordinate_direct = member_subordinate_direct($member_id);
	}
	if (in_array('msd_buyer_order_amount', $order_amount_type)) {
		$msd_buyer_order_amount    = buyer_order_amount($member_subordinate_direct, $time);
	}
	if (in_array('msd_seller_order_amount', $order_amount_type)) {
		$msd_seller_order_amount   = seller_order_amount($member_subordinate_direct, $time);
	}

	//现有直属一级
	if (in_array('msp_buyer_order_amount', $order_amount_type) || in_array('msp_seller_order_amount', $order_amount_type)) {
		$member_subordinate_positions = member_subordinate_positions($member_id, $time);
	}
	if (in_array('msp_buyer_order_amount', $order_amount_type)) {
		$msp_buyer_order_amount    = buyer_order_amount($member_subordinate_positions, $time);
	}
	if (in_array('msp_seller_order_amount', $order_amount_type)) {
		$msp_seller_order_amount    = seller_order_amount($member_subordinate_positions, $time);
	}

	$total_amount = $update_level_point + $buyer_order_amount + $seller_order_amount + $msd_buyer_order_amount + $msd_seller_order_amount + $pp_mds_buyer_order_amount + $pp_mds_seller_order_amount + $pp_mds_update_level_point + $msp_buyer_order_amount + $msp_seller_order_amount;

    return [
    	//升级消费
    	'update_level_point' => $update_level_point,
    	'buyer_order_amount' => $buyer_order_amount,
    	'seller_order_amount' => $seller_order_amount,
    	'msd_buyer_order_amount' => $msd_buyer_order_amount,
    	'msd_seller_order_amount' => $msd_seller_order_amount,
    	'pp_mds_update_level_point' => $pp_mds_update_level_point,
    	'pp_mds_buyer_order_amount' => $pp_mds_buyer_order_amount,
    	'pp_mds_seller_order_amount' => $pp_mds_seller_order_amount,
    	'msp_buyer_order_amount' => $msp_buyer_order_amount,
    	'msp_seller_order_amount' => $msp_seller_order_amount,
    	'total_amount' => $total_amount
    ];
}

/**
 * 获取用户HI
 *
 * @param int $member_id 会员ID
 * @return int
 */
function hi($member_id)
{
	$user_hi_value = db('user_hi_value')->where('user_id', $member_id)->find();

	if ($user_hi_value) {
		return $user_hi_value['upgrade_hi'] + $user_hi_value['recommend_team_hi'] + $user_hi_value['bonus_to_hi'] + $user_hi_value['auto_to_hi_percent'] + $user_hi_value['allow_hi_to_bonus'];
	}

	return 0;
}

/**
 * 解密函数
 *
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0)
{
    if (empty($txt)) return $txt;
    if (empty($key)) $key = md5(MD5_KEY);

    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey  = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum  = 0;
    $i     = 0;
    $tlen  = @strlen($txt);
    while (isset($key{$i})) $knum += ord($key{$i++});
    $ch1   = @$txt{$knum % $tlen};
    $nh1   = strpos($chars, $ch1);
    $txt   = @substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2   = @$txt{$nh1 % $tlen};
    $nh2   = @strpos($chars, $ch2);
    $txt   = @substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3   = @$txt{$nh2 % $tlen};
    $nh3   = @strpos($chars, $ch3);
    $txt   = @substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp   = '';
    $j     = 0;
    $k     = 0;
    $tlen  = @strlen($txt);
    $klen  = @strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0) $j += 64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(['-', '_', '.'], ['+', '/', '='], $tmp);
    $tmp = trim(base64_decode($tmp));

    if (preg_match("/\d{10}_/s", substr($tmp, 0, 11))) {
        if ($ttl > 0 && (time() - substr($tmp, 0, 11) > $ttl)) {
            $tmp = null;
        } else {
            $tmp = substr($tmp, 11);
        }
    }
    return $tmp;
}

/**
 * 取得COOKIE的值
 *
 * @param string $name
 * @return unknown
 */
function cms_cookie($name = '')
{
    $name = defined('COOKIE_PRE') ? COOKIE_PRE . $name : strtoupper(substr(md5(MD5_KEY), 0, 4)) . '_' . $name;
    return $_COOKIE[$name];
}