<?php
namespace app\crontab\controller;

/**
 * 用到的表
 * bonus_op_day_log 分红每日操作日志表
 * orders 订单表
 * order_goods 订单商品表
 * order_bonus 订单分红表
 * store 店铺表
 * member 会员表
 * user_hi_value 会员HI值表
 * register_invite 会员推荐关系
 * user_level 会员等级表
 * user_log_ascending_degrading 用户升降级日志记录
 * member_bonus_pool_log 会员分红池日志表
 * positions_log 会员职位变动表
 * bonus_pool 分红池表
 * fh_period 分红期数表
 */
/**
TRUNCATE bonus_op_day_log;
TRUNCATE orders;
TRUNCATE order_goods;
TRUNCATE order_bonus;
TRUNCATE store;
TRUNCATE member;
TRUNCATE user_hi_value;
TRUNCATE register_invite;
TRUNCATE user_log_ascending_degrading;
TRUNCATE member_bonus_pool_log;
TRUNCATE positions_log;
 */

/**
 * 各分红池名称
 * 团队消费共享分红池 tdxfgxfh
 * 微店/消费共享分红 wdxfgxfh
 * 非团队/微店剩余池 ftdwdsy
 * 非团队/个人剩余池 ftdgrsy
 * 消费日分红池 xfrfh
 * 消费明星日分红池 xfmxrfh
 * 共享日分红池 gxrfh
 * 新人普惠分红分红池 xrphfh
 * 管理普惠周分红 glphzfh
 * 中层管理周分红 zcglzfh
 * 至尊消费月分红 zzxfyfh
 * 销售精英月分红 xsjyyfh
 * 高层消费月分红 gcxfyfh
 * 团队剩余池 tdsyc
 *
 * 会员等级ID level
 * 1 免费会员
 * 2 银尊会员
 * 3 金尊会员
 * 4 帝尊会员
 * 5 天尊会员
 * 6 至尊会员
 * 0 普通用户
 */

class Index
{
    public $fhconfig = [];

    public function index()
    {
        ini_set("max_execution_time", 3600);
        ini_set('memory_limit', '512M');

        $fhconfig = db('fh_config')->select();
        foreach ($fhconfig as $k => $v) {
            $this->fhconfig[$v['name']] = $v['value'];
        }

        $bonus_pool = bonus_pool();

        $date = date('Ymd');
        $bonus_op_log_day = db('bonus_op_day_log')->where('date', $date)->find();
        if (empty($bonus_op_log_day)) {
            db('bonus_op_day_log')->insert(['date'=>$date]);
        } else {
            echo '今天已执行任务 #';
            exit();
        }

    	//将新增的字段补充数据（不修改原程序）
    	$this->supplement_data();
        db('bonus_op_day_log')->where('date', $date)->update(['supplement_data'=>1]);
//
//        //将昨天解冻的订单按比例分配到各个分红池
//        $this->orders_to_bonus_pool();
//        db('bonus_op_day_log')->where('date', $date)->update(['orders_to_bonus_pool'=>1]);
//
//        //团队消费共享分红
//        $this->tdxfgxfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['tdxfgxfh'=>1]);
//
//        //消费日分红
//        $this->xfrfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['xfrfh'=>1]);
//
//        //消费明星日分红
//        $this->xfmxrfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['xfmxrfh'=>1]);
//
//        //共享日分红
//        $this->gxrfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['gxrfh'=>1]);
//
//        //新人普惠分红
//        $this->xrphfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['xrphfh'=>1]);
//
//        //管理普惠分红
//        $this->glphzfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['glphzfh'=>1]);
//
//        //中层管理周分红
//        $this->zcglzfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['zcglzfh'=>1]);
//
//        //至尊消费月分红
//        $this->zzxfyfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['zzxfyfh'=>1]);
//
//        //销售精英月分红
//        $this->xsjyyfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['xsjyyfh'=>1]);
//
//        //供应商推荐奖
//        $this->gystjj();
//        db('bonus_op_day_log')->where('date', $date)->update(['gystjj'=>1]);
//
//        //高层消费月分红
//        $this->gcxfyfh();
//        db('bonus_op_day_log')->where('date', $date)->update(['gcxfyfh'=>1]);
//
//        //消费养老补贴
//        $this->xfylbt();
//        db('bonus_op_day_log')->where('date', $date)->update(['xfylbt'=>1]);
//
//        //车房梦想补贴
//        $this->cfmxbt();
//        db('bonus_op_day_log')->where('date', $date)->update(['cfmxbt'=>1]);
//
//        $bonus_pool = bonus_pool();
//
//        db('bonus_pool_day_log')->insert([
//            'tdxfgxfh' => $bonus_pool['tdxfgxfh'],
//            'wdxfgxfh' => $bonus_pool['wdxfgxfh'],
//            'ftdwdsy' => $bonus_pool['ftdwdsy'],
//            'ftdgrsy' => $bonus_pool['ftdgrsy'],
//            'xfrfh' => $bonus_pool['xfrfh'],
//            'xfmxrfh' => $bonus_pool['xfmxrfh'],
//            'gxrfh' => $bonus_pool['gxrfh'],
//            'xrphfh' => $bonus_pool['xrphfh'],
//            'glphzfh' => $bonus_pool['glphzfh'],
//            'zcglzfh' => $bonus_pool['zcglzfh'],
//            'zzxfyfh' => $bonus_pool['zzxfyfh'],
//            //'xfjyyfh' => $bonus_pool['xfjyyfh'],
//            'gcxfyfh' => $bonus_pool['gcxfyfh'],
//            'tdsyc' => $bonus_pool['tdsyc'],
//            'date' => date('Ymd', time()-86400),
//        ]);
//
//        //计算每期的分红总利润，剩余利润
//        $period = db('fh_period')->where('status', 2)->find();
//        if ($period) {
//            //税后总利润
//            $shzlr = db('order_bonus')->where('add_time', 'egt', strtotime($period['start_time']))->where('end_time', 'elt', strtotime($period['end_time']))->sum('at_profit');
//            //剩余利润 = 各分红池剩余
//            $sylr  = $bonus_pool['tdxfgxfh'] + $bonus_pool['wdxfgxfh'] + $bonus_pool['ftdwdsy'] + $bonus_pool['ftdgrsy'] + $bonus_pool['xfrfh'] + $bonus_pool['xfmxrfh'] + $bonus_pool['gxrfh'] + $bonus_pool['xrphfh'] + $bonus_pool['glphzfh'] + $bonus_pool['zcglzfh'] + $bonus_pool['zzxfyfh'] + $bonus_pool['gcxfyfh'] + $bonus_pool['tdsyc'];
//            db('fh_period')->where('id', $period['id'])
//                           ->update([
//                                'shzlr' => $shzlr,
//                                'sylr'  => $sylr,
//                            ]);
//        }

        //设置当前期数为进行中
        $current_period = db('fh_period')->where('start_time', 'egt', date('Y-m-d', time()))
                                         ->order('id asc')
                                         ->find();
        //开始新的一期
        if ($current_period['status'] == 3) {
            //上次设为闭环
            db('fh_period')->where('status', 2)->update(['status'=>1]);
            //本期设为开始
            db('fh_period')->where('id', $current_period['id'])->update(['status'=>2]);
        }

        echo date('Y-m-d H:i:s');
    }

    /**
     * 将新增的字段补充数据
     *
     * @return void
     */
    public function supplement_data()
    {
        bonus_op_log('补充数据开始', 'supplement_data');
    	//orders.thaw_time 解冻时间 
    	//orders.goods_costprice 成本价(供货价)
    	//orders.seller_member_id 卖家会员ID
    	//order_goods.goods_costprice  成本价(供货价)
    	//member.hi  HI
    	$order_list = db('orders')->where('order_state', 50)
    						->where('thaw_time', 0)
    						->select();
    	if (!empty($order_list)) {
    		foreach ($order_list as $k => $v) {
    			$seller_member_id = db('store')->where('store_id', $v['store_id'])->value('member_id');
    			$order_goods = db('order_goods')->where('order_id', $v['order_id'])->select();
    			$total_goods_costprice = 0;
    			if ($order_goods) {
    				foreach ($order_goods as $k1 => $v1) {
    					$goods_costprice = db('goods')->where('goods_id', $v1['goods_id'])->value('goods_costprice');
    					if ($goods_costprice) {
    						db('order_goods')->where('rec_id', $v1['rec_id'])->update(['goods_costprice'=>$goods_costprice]);
    						$total_goods_costprice += $goods_costprice;
    					}
    				}
    				db('orders')->where('order_id', $v['order_id'])
    							->update([
    								'goods_costprice' => $total_goods_costprice,
    								'seller_member_id' => $seller_member_id ? $seller_member_id : 0,
    								'thaw_time' => strtotime(date('Y-m-d 23:59:59', time()-86400)),
    							]);
    			}
    		}
    	}

    	$member_list = db('member')->select();
    	$user_hi_value_list = db('user_hi_value')->select();
    	foreach ($member_list as $k => $v) {
    		$hi = 0;
    		foreach ($user_hi_value_list as $k1 => $v1) {
    			if ($v['member_id'] == $v1['user_id']) {
    				$hi = $v1['upgrade_hi'] + $v1['recommend_team_hi'] + $v1['bonus_to_hi'] + $v1['auto_to_hi_percent'] + $v1['allow_hi_to_bonus'];
    			}
    		}
    		if ($hi != $v['hi']) {
    			db('member')->where('member_id', $v['member_id'])->update(['hi'=>$hi]);
    		}
    	}

        bonus_op_log('补充数据完成', 'supplement_data');
    }

    /**
     * 将昨天解冻的订单按比例分配到各个分红池
     * 
     * @return void
     */
    public function orders_to_bonus_pool()
    {
    	bonus_op_log('解冻订单分配开始', 'orders_to_bonus_pool');

    	$yesterday = yesterday();

        //昨天解冻的订单
        $order_list = db('orders')->where('thaw_time', 'egt', strtotime($yesterday['start_time']))
                                  ->where('thaw_time', 'elt', strtotime($yesterday['end_time']))
                                  ->select();

        if (empty($order_list)) {
        	bonus_op_log('没有解冻的订单', 'orders_to_bonus_pool');
            return '';
        }

        foreach ($order_list as $k => $v) {

        	//税前利润 = 订单总额 - 成本总额(供应商成本 + 物流成本)
        	$bt_profit = price_format($v['order_amount'] - $v['shipping_fee'] - $v['goods_costprice']);

        	//税费 = 税前利润 * 税率
        	$tax_fee = price_format($bt_profit * $this->fhconfig['ptslbl'] / 100);

        	//税后利润 = 税前利润 - 税费
        	$at_profit = price_format($bt_profit - $tax_fee);

        	//平台提成 = 税后利润 * 20%
        	$platform_fee = price_format($bt_profit * 0.2);

        	//消费普惠分红 = 税后利润 * 25%
        	$xfphfh = price_format($at_profit * $this->fhconfig['grxffhbl'] / 100);

        	//计算到当前为止的剩余税后利润，后面有用到，计算过程中逐步减少
        	$current_at_profit = price_format($at_profit - $xfphfh - $platform_fee);

    		// 插入 订单分红 表
        	db('order_bonus')->insert([
        		'order_id'		 	=> $v['order_id'],
        		'order_amount' 		=> $v['order_amount'],
        		'shipping_fee' 		=> $v['shipping_fee'],
        		'goods_costprice' 	=> $v['goods_costprice'],
        		'bt_profit' 		=> $bt_profit,
        		'at_profit' 		=> $at_profit,
        		'tax_fee' 			=> $tax_fee,
        		'platform_fee' 		=> $platform_fee,
        		'xfphfh' 			=> $xfphfh,
        		'add_time' 			=> time(),
        	]);
        	
            //消费普惠分红，更新会员分红字段
            update_member_balance($v['buyer_id'], $xfphfh, 'xfphfh', $v['order_id']);

            //当前购买者是否团队
            $member_info = member_info($v['buyer_id']);
            //是团队
            if ($member_info['level_id'] > 0) {
            	//税后利润的20% 进入 团队消费共享分红池
            	update_bonus_pool('tdxfgxfh', price_format($at_profit * 0.2), '订单解冻');

            	//剩下部分为x1
            	$current_at_profit = price_format($current_at_profit - price_format($at_profit * 0.2));

            	$x1 = $current_at_profit;
            	
            	//x1的10%进入消费日分红池，剩下部分为x2
            	update_bonus_pool('xfrfh', price_format($x1 * 0.1), '订单解冻');
            	$x2 = price_format($x1 * 0.9);

            	//x2的10%进入消费明星日分红池，剩下部分为x3
            	update_bonus_pool('xfmxrfh', price_format($x2 * 0.1), '订单解冻');
            	$x3 = price_format($x2 * 0.9);

            	//x3的5%进入共享日分红池，剩下部分为x4
            	update_bonus_pool('gxrfh', price_format($x3 * 0.05), '订单解冻');
            	$x4 = price_format($x3 * 0.95);

            	//x4的2%进入新人普惠分红分红池，剩下部分为x5
            	update_bonus_pool('xrphfh', price_format($x4 * 0.02), '订单解冻');
            	$x5 = price_format($x4 * 0.98);

            	//x5的10%进入管理普惠周分红，剩下部分为x6
            	update_bonus_pool('glphzfh', price_format($x5 * 0.1), '订单解冻');
            	$x6 = price_format($x5 * 0.9);

            	//x6的10%进入中层管理周分红，剩下部分为x7
            	update_bonus_pool('zcglzfh', price_format($x6 * 0.1), '订单解冻');
            	$x7 = price_format($x6 * 0.9);

            	//x7的10%进入至尊消费月分红，剩下部分为x8
            	update_bonus_pool('zzxfyfh', price_format($x7 * 0.1), '订单解冻');
            	$x8 = price_format($x7 * 0.9);

            	//x8的10%进入销售精英月分红，剩下部分为x9
            	update_bonus_pool('xsjyyfh', price_format($x8 * 0.1), '订单解冻');
            	$x9 = price_format($x8 * 0.9);

            	//x9的8%进入高层消费月分红，剩下进入团队剩余池
            	update_bonus_pool('gcxfyfh', price_format($x9 * 0.08), '订单解冻');
            	$x10 = price_format($x9 * 0.92);

            	update_bonus_pool('tdsyc', $x10, '订单解冻');
            }
            //不是团队，判断是否通过微店分享链接购买的
            else {
            	//暂时找不到字段，默认为是
            	if ($v['referral_member_id']) {
            		//微店/消费共享分红
            		//查看店主级别，根据不同级别给商家分红
            		$seller = member_info($v['referral_member_id']);
            		$proportion = 0;
            		switch ($seller['level_id']) {
            			case '0':
            				$proportion = 0.08;
            				break;
            			case '1':
            				$proportion = 0.08;
            				break;
            			case '2':
            				$proportion = 0.1;
            				break;
            			case '3':
            				$proportion = 0.13;
            				break;
            			case '4':
            				$proportion = 0.17;
            				break;
            			case '5':
            				$proportion = 0.22;
            				break;
            			case '6':
            				$proportion = 0.27;
            				break;
            		}
            		//更新会员分红字段
            		update_member_balance($v['referral_member_id'], price_format($at_profit * $proportion), 'wdxfgxfh', $v['order_id']);

            		$current_at_profit = price_format($current_at_profit - price_format($at_profit * $proportion));

            		//剩余利润归入非团队/微店剩余池
            		update_bonus_pool('ftdwdsy', $current_at_profit, '订单结算');
            	}
            	//不是通过微店购买，剩余利润归入非团队/个人剩余池
            	else {
            		update_bonus_pool('ftdgrsy', $current_at_profit, '订单结算');
            	}

            }
        }

        bonus_op_log('解冻订单分配完成', 'orders_to_bonus_pool');
    }

    /**
     * 团队消费共享分红
     * 所有团队用户(会员用户)
     *
     * @return void
     */
    public function tdxfgxfh()
    {
    	$bonus_name = 'tdxfgxfh';

    	bonus_op_log('团队消费共享分红开始', $bonus_name);

    	//当前为止所有的团队用户(会员用户)
    	$member_list = db('member')->where('level_id', 'elt', 7)->select();

    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//平台当日所有会员的消费总额(当日解冻的订单总额)
    	$total_order_amount = 0;

        $yesterday = yesterday();

        //昨天解冻的订单
        $order_list = db('orders')->where('thaw_time', 'egt', strtotime($yesterday['start_time']))
                                  ->where('thaw_time', 'elt', strtotime($yesterday['end_time']))
                                  ->select();

        if (!$order_list) {
        	return bonus_op_log('没有解冻的订单', $bonus_name);
        }

        $total_order_amount = array_sum(array_column($order_list, 'order_amount'));

        //有参与分红的用户，第二步用到
        $bonus_member_list = [];

    	foreach ($member_list as $k => $v) {
    		$member_ids = member_subordinate_direct($v['member_id']);

    		if (empty($member_ids)) {
    			bonus_op_log($v['member_id'] . ' 没有直属会员', $bonus_name);
    			continue;
    		}

    		//该会员直推的所有直属会员当日的消费总额
    		$member_order_amount = 0;
    		foreach ($order_list as $k1 => $v1) {
    			if (in_array($v1['buyer_id'], $member_ids)) {
    				$member_order_amount += $v1['order_amount'];
    			}
    		}

    		if ($member_order_amount == 0) {
    			bonus_op_log($v['member_id'] . ' 直属会员没有消费', $bonus_name);
    			continue;
    		}

    		//根据会员等级，按不同比例分红
    		$proportion = 0;
    		switch ($v['level_id']) {
    			case '1':
    				$proportion = 0.2;
    				break;
    			case '2':
    				$proportion = 0.4;
    				break;
    			case '3':
    				$proportion = 0.55;
    				break;
    			case '4':
    				$proportion = 0.7;
    				break;
    			case '5':
    				$proportion = 0.85;
    				break;
    			case '6':
    				$proportion = 1;
    				break;
    		}
    		//分红 = 【该会员直推的所有直属会员当日的消费总额 ÷ 平台当日所有会员的消费总额】×团队/消费共享分红池 × $proportion
    		$bonus = price_format($member_order_amount / $total_order_amount * $start_bonus_pool * $proportion);

    		$end_bonus_pool -= $bonus;

    		//消费普惠分红，更新会员分红字段
            update_member_balance($v['member_id'], $bonus, $bonus_name);

            $bonus_member_list[] = $v;
    	}


    	//分红结束后
    	bonus_op_log(sprintf("第一步结束后，分红前：%s，分红后：%s", $start_bonus_pool, $end_bonus_pool), $bonus_name);

    	/**
    	 * 若该团队消费共享分红中还有结余利润，根据第二步公式的分红HI值再次计算。
         * 第二步公式的分红 = [团队/消费共享分红池－分配第一步的总分红] × 该会员推荐人当日的分红HI值 / 当日参加此奖项的所有会员推荐人的总分红HI值
    	 *
    	 */
    	$surplus  = price_format($end_bonus_pool);

        //获取推荐人HI值
        foreach ($bonus_member_list as $k => $v) {
            $bonus_member_list[$k]['from_user_hi'] = 0;
            //获取推荐人
            $from_user_id = db('register_invite')->where('to_user_id', $v['member_id'])->value('from_user_id');
            if (!$from_user_id) {
                bonus_op_log($v['member_id'] . ' 没有推荐人', $bonus_name);
                continue;
            }
            $member_info = member_info($from_user_id);
            $bonus_member_list[$k]['from_user_hi'] = $member_info['hi'];
        }

    	$total_hi = array_sum(array_column($bonus_member_list, 'from_user_hi'));
    	if ($surplus > 0) {
    		foreach ($bonus_member_list as $k => $v) {
                if ($total_hi > 0 && $v['from_user_hi'] > 0) {
                    $bonus = price_format($v['from_user_hi'] / $total_hi * $surplus);
                    $end_bonus_pool = $end_bonus_pool - $bonus;
                    //更新会员分红字段
                    update_member_balance($v['member_id'], $bonus, $bonus_name);
                }
    		}
    		bonus_op_log(sprintf("第二步结束后，分红前：%s，分红后：%s", $start_bonus_pool, $end_bonus_pool), $bonus_name);
    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '订单结算');

    	bonus_op_log('团队消费共享分红完成', $bonus_name);
    }

    /**
     * 消费日分红
     *
     * @return void
     */
    public function xfrfh()
    {
    	$bonus_name = 'xfrfh';

    	bonus_op_log('消费日分红开始', $bonus_name);

    	$member_list = [];

    	$pre_period = pre_period();

    	//昨天消费日分红池
    	$bonus_pool = bonus_pool($bonus_name);

    	//当前消费日分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	/**
    	 * 1.上一期是银尊会员及以上等级的，且“个人消费”累积了150元及以上的或“个人消费”加微店销售金额达到1000元及以上的。
    	 * 2.免费会员上一期“个人消费”累计了300元及以上的或“个人消费”加微店销售金额总计1000元及以上的
    	 */
    	//上一期结束时间为止，最后的等级是免费会员或以上的用户
    	$list = level_member('1,6', $pre_period['end_time']);

    	//上一期累计消费，第四步有用到
   		$total_order_amount = 0;

   		foreach ($list as $k => $v) {
   			//上期消费情况
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['buyer_order_amount','seller_order_amount']);

			//是否符合条件
			$is_conform = false;

   			//免费会员
   			if ($v['new_level'] == 1 && $member_pre_period_order['buyer_order_amount'] >= 300) {
   				$is_conform = true;
   			} 
   			//银尊会员及以上等级
   			elseif ($member_pre_period_order['buyer_order_amount'] >= 150) {
   				$is_conform = true;
   			}

			if ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['seller_order_amount'] >= 1000) {
				$is_conform = true;
			}

			if ($is_conform) {
				$member_info = member_info($v['member_id']);
				$member_list[$v['member_id']] = [
					'member_id' => $v['member_id'],
					'hi' 	    => $v['hi'],
					'new_level' => $v['new_level'],
					'member_pre_period_order' => $member_pre_period_order,
				];

                $total_order_amount += $member_pre_period_order['total_amount'];
			}
			
   		}

   		if (!$member_list) {
   			return bonus_op_log('没有符合条件的用户', $bonus_name);
   		}

   		//将（昨天消费日分红池）按比例分成四份（2:2:2:4）
   		$x1 = $bonus_pool * 0.2;
   		$x2 = $bonus_pool * 0.2;
   		$x3 = $bonus_pool * 0.2;
   		$x4 = $bonus_pool * 0.4;

   		//参与分红的总人数
   		$total_member = count($member_list);

        //每个级别对应的人数
        $level_num2 = 0;
        $level_num3 = 0;
        $level_num4 = 0;
        $level_num5 = 0;
        $level_num6 = 0;

        foreach ($member_list as $k => $v) {
            switch ($v['new_level']) {
                case '2':
                    $level_num2++;
                    break;
                case '3':
                    $level_num2++;
                    $level_num3++;
                    break;
                case '4':
                    $level_num2++;
                    $level_num3++;
                    $level_num4++;
                    break;
                case '5':
                    $level_num2++;
                    $level_num3++;
                    $level_num4++;
                    $level_num5++;
                    break;
                case '6':
                    $level_num2++;
                    $level_num3++;
                    $level_num4++;
                    $level_num5++;
                    $level_num6++;
                    break;
            }
        }

   		//银尊会员
   		$bonus2_level2 = $x2 * 0.2 / 5 / $level_num2;
   		//金尊会员
   		$bonus2_level3 = $x2 * 0.2 / 5 / $level_num3;
   		//帝尊会员
   		$bonus2_level4 = $x2 * 0.2 / 5 / $level_num4;
   		//天尊会员
   		$bonus2_level5 = $x2 * 0.2 / 5 / $level_num5;
   		//至尊会员
   		$bonus2_level6 = $x2 * 0.2 / 5 / $level_num6;

   		//总HI值，第三步用到
   		$total_hi = array_sum(array_column($member_list, 'hi'));

   		foreach ($member_list as $k => $v) {
   			$bonus1 = $x1 / $total_member;

   			$bonus2 = 0;

   			switch ($v['new_level']) {
   				case '2':
   					$bonus2 = $bonus2_level2;
   					break;
   				case '3':
   					$bonus2 = $bonus2_level3;
   					break;
   				case '4':
   					$bonus2 = $bonus2_level4;
   					break;
   				case '5':
   					$bonus2 = $bonus2_level5;
   					break;
   				case '6':
   					$bonus2 = $bonus2_level6;
   					break;
   			}

   			//当前用户HI / 总Hi * x3
   			$bonus3 = $v['hi'] / $total_hi * $x3;

   			//满足条件的当前会员上一期的累计消费额(个人消费 + 微店销售) （不算升级消费）/ 满足当前条件会员等级的所有人上一期的累计消费额(个人消费 + 微店销售) * X4
   			$bonus4 = ($v['member_pre_period_order']['total_amount']) / $total_order_amount * $x4;

   			$bonus5 = price_format($bonus1 + $bonus2 + $bonus3 + $bonus4);

            if ($bonus5 > $this->fhconfig['xfrfhjesx']) {
                $bonus5 = $this->fhconfig['xfrfhjesx'];
            }

   			//更新会员分红字段
            update_member_balance($v['member_id'], $bonus5, $bonus_name);

            $end_bonus_pool -= $bonus5;
   		}

   		update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '消费日分红');

    	bonus_op_log('消费日分红完成', $bonus_name);
    }

    /**
     * 消费明星日分红
     *
     * @return void
     */
    public function xfmxrfh()
    {
    	$bonus_name = 'xfmxrfh';

    	bonus_op_log('消费日分红开始', $bonus_name);

    	$pre_period = pre_period();

    	//当前消费明星日分红
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	/**
    	 * 1.上一期推荐银尊会员（只计算新增的）及以上等级会员，成功升级了且该会员的消费额≧2000元。 
    	 * 2.当前会员上一期的个人消费（包括：升级消费）或会员微店的销售金额达到2000元及以上。
    	 */

    	//符合条件的会员
    	$member_list = [];

    	//上期注册的用户
    	$register_invite_list = db('register_invite')->where('register_at', 'egt', $pre_period['start_time'])
    									             ->where('register_at', 'elt', $pre_period['end_time'])
    									             ->select();
    	if ($register_invite_list) {
            //获取上期为止的银尊会员以上的用户
            $tmp = level_member('1,6', $pre_period['end_time']);
            $level_member_ids = array_column($tmp, 'member_id');
            foreach ($register_invite_list as $k => $v) {
                $from_user_id = $v['from_user_id'];
                if (isset($member_list[$from_user_id])) {
                    continue;
                }
                //查看被推荐的会员是否达到银尊会员以上
                if (is_array($v['to_user_id'], $level_member_ids)) {
                    if (buyer_order_amount($v['to_user_id'], $pre_period) >= 2000) {
                        $member_info             = member_info($from_user_id);
                        $member_pre_period_order = member_pre_period_order($from_user_id, $pre_period, ['update_level_point', 'buyer_order_amount', 'seller_order_amount', 'pp_mds_update_level_point', 'pp_mds_buyer_order_amount', 'pp_mds_seller_order_amount']);
                        $member_list[$from_user_id] = [
                            'member_id'                 => $member_info['member_id'],
                            'hi'                        => $member_info['hi'],
                            'member_pre_period_order'   => $member_pre_period_order,
                        ];
                    }
                }
            }
    	}

    	//上一期的订单，获取符合条件2的用户
    	$order_list = db('orders')->where('thaw_time', 'egt', strtotime($pre_period['start_time']))
                                  ->where('thaw_time', 'elt', strtotime($pre_period['end_time']))
                                  ->select();
        if (!$order_list) {
        	return bonus_op_log('上期没有订单', $bonus_name);
        }
        $buyer_member_ids  = array_column($order_list, 'buyer_id');
        $seller_member_ids = array_column($order_list, 'referral_member_id');
        $member_ids  = array_unique(array_merge([], $buyer_member_ids, $seller_member_ids));
        foreach ($member_ids as $k => $v) {
        	if (!isset($member_list[$v])) {
        		$member_info 			 = member_info($v);
                $member_pre_period_order = member_pre_period_order($v, $pre_period, ['update_level_point', 'buyer_order_amount', 'seller_order_amount', 'pp_mds_update_level_point', 'pp_mds_buyer_order_amount', 'pp_mds_seller_order_amount']);
                if (
                    ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['update_level_point']) >= 2000 || ($member_pre_period_order['seller_order_amount'] >= 2000)
                )
	        	$member_list[] = [
	        		'member_id' 				=> $member_info['member_id'],
	        		'hi' 						=> $member_info['hi'],
	        		'member_pre_period_order' 	=> $member_pre_period_order,
	        	];
        	}
        }

        if (empty($member_list)) {
        	return bonus_op_log('没有符合条件的用户', $bonus_name);
        }

        //参加分红总销售额
        $total_amount = 0;
        foreach ($member_list as $k => $v) {
        	$total_amount += $v['member_pre_period_order']['total_amount'];
        }

        foreach ($member_list as $k => $v) {
        	
        	//当前会员用户上一期的总销售额 / 参加分红总销售额 × 消费明星日分红池;  总销售额指：当前用户的个人消费（含个人升级消费）+ 微店销售+上一期新增的直推会员（直属一级）的个人消费和微店销售
        	if (!$total_amount) {
        		continue;
        	}

        	$bonus = $v['member_pre_period_order']['total_amount'] / $total_amount * $start_bonus_pool;

        	if ($bonus > 0) {

        		//更新会员分红字段
	        	update_member_balance($v['member_id'], $bonus, $bonus_name);

	        	$end_bonus_pool -= $bonus;
        	}

        }

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '消费明星日分红');

    	bonus_op_log('消费明星日分红完成', $bonus_name);
    }

    /**
     * 共享日分红
     *
     * @return void
     */
    public function gxrfh()
    {
    	$bonus_name = 'gxrfh';

    	bonus_op_log('共享日分红开始', $bonus_name);

    	$member_list = [];

    	$pre_period = pre_period();

    	//当前共享日分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	/**
    	 * 1.上一期是银尊会员及以上等级的，且“个人消费”累积了150元及以上的或“个人消费”加微店销售金额达到1000元及以上的。
    	 * 2.免费会员上一期“个人消费”累计了300元及以上的或“个人消费”加微店销售金额总计1000元及以上的
    	 */
    	//上一期结束时间为止，最后的等级是免费会员或以上的用户
    	$level_member_list = level_member(1, $pre_period['end_time']);

   		foreach ($level_member_list as $k => $v) {
   			//是否符合条件
			$is_conform = false;

   			//“个人消费”累积消费
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['buyer_order_amount', 'seller_order_amount']);

   			//免费会员且“个人消费”累积了150元及以上
   			if ($v['new_level'] == 1 && $member_pre_period_order['buyer_order_amount'] >= 300) {
   				$is_conform = true;
   			} 

   			//银尊会员及以上等级“个人消费”累积了150元
   			elseif ($member_pre_period_order['buyer_order_amount'] >= 150) {
   				$is_conform = true;
   			}

   			//“个人消费”加微店销售金额总计1000元及以上的
   			elseif ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['seller_order_amount'] >= 1000) {
   				$is_conform = true;
   			}

   			if ($is_conform) {
   				$member_info 			 = member_info($v['member_id']);
	        	$member_list[$v['member_id']] = [
	        		'member_id' 				=> $member_info['member_id'],
	        		'hi' 						=> $member_info['hi'],
	        		'member_pre_period_order' 	=> $member_pre_period_order,
	        	];
   			}
   		}

   		if (!$member_list) {
   			return bonus_op_log('没有符合条件的用户', $bonus_name);
   		}

   		//当前注册总人数，后面计算阵列用到
   		$all_member_ids = db('member')->column('member_ids');

   		//总阵列人数
   		$total_array_number = 0;

   		//分红总人数
   		$total_member = count($member_list);

   		//计算每个用户垂直阵列下面的点位人数
   		foreach ($member_list as $k => $v) {

   			//获取当前会员所处阵列位置
			$position = array_search($v['member_id'], $all_member_ids) + 1;

			//总人数 - 当前阵列位置 = 排在后面的人数
			$array_number = floor((count($all_member_ids) - $position) / 100);

   			$member_list[$k]['array_number'] = $array_number;

   			$total_array_number += $array_number;
   		}

   		foreach ($member_list as $k => $v) {
   			//共享日分红池 40% ÷ 上期满足该分红获取条件的所有合格人数 +（用户垂直阵列下面的点位人数 ÷ 上期所有参加该分红用户阵列下面人数总和 × 共享日分红池 60%）

   			$bonus = $start_bonus_pool * 0.4 / $total_member;

   			if ($v['array_number'] && $total_array_number > 0) {
   				$bonus += ($v['array_number'] / $total_array_number * $start_bonus_pool * 0.6);
   			}

   			$bonus = price_format($bonus);

            if ($bonus > $this->fhconfig['gxrfhjesx']) {
                $bonus = $this->fhconfig['gxrfhjesx'];
            }

   			$end_bonus_pool -= $bonus;

   			//更新会员分红字段
	        update_member_balance($v['member_id'], $bonus, $bonus_name);
   		}

   		update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '共享日分红');

    	bonus_op_log('共享日分红完成', $bonus_name);
    }

    /**
     * 新人普惠分红
     *
     * @return void
     */
    public function xrphfh()
    {
    	$bonus_name = 'xrphfh';

    	bonus_op_log('新人普惠分红开始', $bonus_name);

    	$member_ids = [];

    	//当前新人普惠分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天新人普惠分红池
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');

    	$yesterday = yesterday();

    	//28天前的00:00:00
        $start_time = strtotime(date('Y-m-d 00:00:00', strtotime(date('Y-m-d') . ' -29 day')));
        //昨天的23:59:59
        $end_time = strtotime(date('Y-m-d 23:59:59', strtotime(date('Y-m-d') . ' -1 day')));

    	//升级记录
    	$list = db('user_log_ascending_degrading')->field('id,user_id,new_level,min(created_at)')
    											  ->where('created_at', 'egt', $start_time)
    											  ->where('created_at', 'elt', $end_time)
    											  ->where('type', 1)
    											  ->where('old_level', 0)
    											  ->select();

    	if (empty($list)) {
    		return bonus_op_log('没有符合条件的用户', $bonus_name);
    	}

    	foreach ($list as $k => $v) {
    		//个人“个人消费”（除升级外的）累计达到350元或以上
    		$buyer_order_amount = buyer_order_amount($v['user_id'], ['end_time'=>$end_time]);
    		if ($buyer_order_amount < 350) {
    			unset($list[$k]);
    		}
    	}

    	$user_level  = [];
    	$_user_level = db('user_level')->select();
    	foreach ($_user_level as $k => $v) {
    		$user_level[$v['id']] = $v;
    	}

    	//总积分
    	$total_point = 0;
    	foreach ($list as $k => $v) {
    		$total_point += $user_level[$v['new_level']]['point'];
    	}

    	foreach ($list as $k => $v) {
    		//该用户第一次成功升级会员所使用的积分对应的金额／ 从当前用户开始计算当前分红的日期起享受该奖金的所有用户的第一次成功升级会员所使用的积分对应的金额总和 × 昨日新人普惠分红池。
    		$bonus = $user_level[$v['new_level']]['point'] / $total_point * $bonus_pool;

            $max_bonus = 0;
            switch ($v['new_level']) {
                case '2':
                    $max_bonus = $this->fhconfig['xsxrjjesx_2'];
                    break;
                case '3':
                    $max_bonus = $this->fhconfig['xsxrjjesx_3'];
                    break;
                case '4':
                    $max_bonus = $this->fhconfig['xsxrjjesx_4'];
                    break;
                case '5':
                    $max_bonus = $this->fhconfig['xsxrjjesx_5'];
                    break;
                case '6':
                    $max_bonus = $this->fhconfig['xsxrjjesx_6'];
                    break;
            }
            if ($bonus > $max_bonus) {
                $bonus = $max_bonus;
            }

    		$end_bonus_pool -= $bonus;

   			//更新会员分红字段
	        update_member_balance($v['user_id'], $bonus, $bonus_name);
    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '新人普惠分红');

    	bonus_op_log('新人普惠分红完成', $bonus_name);
    }

    /**
     * 管理普惠周分红
     *
     * @return void
     */
    public function glphzfh()
    {
    	$bonus_name = 'glphzfh';

        $date = date("N");
        if ($date != 1) {
            return bonus_op_log('管理普惠周分红 星期一才执行', $bonus_name);
        }

    	bonus_op_log('管理普惠周分红开始', $bonus_name);

    	$pre_period = pre_period();

    	//当前管理普惠周分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天管理普惠周分红池（当前程序每周一执行，所以昨日分红即上周分红）
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');
    	$bonus_pool_ftdwdsy = bonus_pool('ftdwdsy', 'yesterday');
    	$bonus_pool_ftdgrsy = bonus_pool('ftdgrsy', 'yesterday');

    	$member_list = positions_member('1,7', $pre_period['end_time']);

    	//上一期“个人消费”（除升级外的）累积达到800元或以上
    	foreach ($member_list as $k => $v) {
    		$order_amount = buyer_order_amount($v['member_id'], $pre_period);
			if ($order_amount < 800) {
				unset($member_list[$k]);
			}
    	}

    	if (!$member_list) {
    		return bonus_op_log('没有符合条件的用户', $bonus_name);
    	}

    	//奖金总和:只包含消费普惠分红、团队消费共享分红、微店消费共享分红、消费日分红、消费明星日分红、共享日分红、新人普惠分红、中层管理周分红、至尊消费月分红、销售精英月分红、商家推荐分红、高层消费月份红
    	$allow_bonus_name = ['xfphfh', 'tdxfgxfh', 'wdxfgxfh', 'xfrfh', 'xfmxrfh', 'gxrfh', 'xrphfh', 'zcglzfh', 'zzxfyfh', 'xsjyyfh', 'gcxfyfh', 'sjtjfh'];

    	//满足当前满足分红条件的所有用户整个团队
    	$all_team_member_ids = [];
    	$total_bonus = 0;
    	foreach ($member_list as $k => $v) {
    		$team_member_ids    = team_member_ids($v['member_id']);
    		$member_total_bonus = db('member_bonus_pool_log')->where('name', 'in', $allow_bonus_name)
    											  ->where('member_id', 'in', $team_member_ids)
    											  ->where('add_time', 'egt', strtotime($pre_period['start_time']))
    											  ->where('add_time', 'elt', strtotime($pre_period['end_time']))
    											  ->sum('change_bonus');
    		$member_list[$k]['team_member_ids'] = $team_member_ids;
    		$member_list[$k]['total_bonus'] = $member_total_bonus;
    		$all_team_member_ids = array_merge($all_team_member_ids, $team_member_ids);
    		$total_bonus += $member_total_bonus;
    	}

    	foreach ($member_list as $k => $v) {
    		//{ 当前用户整个团队上一期的奖金总和(上一期的最后一天)  / 满足当前满足分红条件的所有用户整个团队上一期的奖金总和 * 上一周管理普惠周分红池 }   + { (上一周非团队/微店剩余池 + 上一周非团队/个人剩余池 ) *10% / 参与当前分红的总人数 }
    		$bonus = 0;
    		if ($total_bonus > 0) {
    			$bonus = price_format($v['total_bonus'] / $total_bonus * $bonus_pool + (($bonus_pool_ftdwdsy + $bonus_pool_ftdgrsy) * ($this->fhconfig['glphzfhdc'] / 10) / count($member_list)));
    		}
    		
    		if ($bonus > 0) {
    			$end_bonus_pool -= $bonus;

   				//更新会员分红字段
	        	update_member_balance($v['member_id'], $bonus, $bonus_name);
    		}
    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '管理普惠周分红');

    	bonus_op_log('管理普惠周分红完成', $bonus_name);
    }

    /**
     * 中层管理周分红
     *
     * @return void
     */
    public function zcglzfh()
    {
    	$bonus_name = 'zcglzfh';

        $date = date("N");
        if ($date != 1) {
            return bonus_op_log('中层管理周分红 星期一才执行', $bonus_name);
        }

    	bonus_op_log('中层管理周分红开始', $bonus_name);

    	$pre_period = pre_period();

    	//当前中层管理周分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天中层管理周分红池
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');

    	$member_list = positions_member('3,7', $pre_period['end_time']);

    	//上一期“个人消费”（除升级外的）累积达到1000元或以上
    	foreach ($member_list as $k => $v) {
    		$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msp_buyer_order_amount']);
			if ($member_pre_period_order['buyer_order_amount'] < 1000) {
				unset($member_list[$k]);
				continue;
			}
			$member_info = member_info($v['member_id']);
    		$member_list[$k]['hi'] = $member_info['hi'];
    		$member_list[$k]['level_now'] = $v['level_now'];
			$member_list[$k]['member_pre_period_order'] = $member_pre_period_order;
    	}

    	if (!$member_list) {
    		return bonus_op_log('没有符合条件的用户', $bonus_name);
    	}

    	//各级别合格人数
    	$qualified_num3 = 0;
    	$qualified_num4 = 0;
    	$qualified_num5 = 0;
    	$qualified_num6 = 0;
    	$qualified_num7 = 0;
    	$total_amount = 0;

    	foreach ($member_list as $k => $v) {
    		switch ($v['level_now']) {
    			case '3':
    				$qualified_num3++;
    				break;
    			case '4':
    				$qualified_num3++;
    				$qualified_num4++;
    				break;
    			case '5':
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				break;
    			case '6':
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				$qualified_num6++;
    				break;
    			case '7':
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				$qualified_num6++;
    				$qualified_num7++;
    				break;
    		}
    		$total_amount += $v['member_pre_period_order']['total_amount'];
    	}

    	//总Hi值
    	$total_hi = array_sum(array_column($member_list, 'hi'));

    	foreach ($member_list as $k => $v) {
    		//市场主任的中层管理周分红:（上周中层管理周分红池 × 20%）÷ 上期合格会员总人数 +（上周中层管理周分红池×4%）÷上期市场主任及以上合格总人数 + 当前会员分红HI值÷上期参加该分红会员的总分红HI值×上周中层管理周分红池×20% + 上期当前会员销售额/上期参加该分红的所有会员的总销售额 * 上周中层管理周分红池 40%。
    		//销售额指：当前用户的个人消费（ 除升级消费）+ 当前用户的微店销售+上一期新增的直推会员和现有直属一级的个人消费总和

    		//市场主任
    		$bonus = ($bonus_pool * 0.2 / count($member_list)) + ($bonus_pool * 0.04 / $qualified_num3) + ($v['hi'] / $total_hi * $bonus_pool * 0.2) + ($v['member_pre_period_order']['total_amount'] / $total_amount * $bonus_pool * 0.4);

    		//市场经理或以上
    		if ($v['level_now'] >= 4) {
    			$bonus += ($bonus_pool * 0.04 / $qualified_num4);
    		}

    		//市场总监或以上
    		if ($v['level_now'] >= 5) {
    			$bonus += ($bonus_pool * 0.04 / $qualified_num5);
    		}

    		//市场总经理或以上
    		if ($v['level_now'] >= 6) {
    			$bonus += ($bonus_pool * 0.04 / $qualified_num6);
    		}

    		//市场副总裁或以上
    		if ($v['level_now'] >= 6) {
    			$bonus += ($bonus_pool * 0.04 / $qualified_num7);
    		}

    		$bonus = price_format($bonus);

            if ($bonus > $this->fhconfig['zcglzfhjesx']) {
                $bonus = $this->fhconfig['zcglzfhjesx'];
            }

    		$end_bonus_pool -= $bonus;

   			//更新会员分红字段
	        update_member_balance($v['member_id'], $bonus, $bonus_name);
    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '中层管理周分红');

    	bonus_op_log('中层管理周分红完成', $bonus_name);
    }

    /**
     * 至尊消费月分红
     *
     * @return void
     */
    public function zzxfyfh()
    {
    	$bonus_name = 'zzxfyfh';

        $pre_period = pre_period();

        //上期结束到目前为止，第15天
        if ((time() - strtotime($pre_period['end_time'])) / 86400 == 15) {
            return bonus_op_log('至尊消费月分红 第15天才执行', $bonus_name);
        }

    	bonus_op_log('至尊消费月分红开始', $bonus_name);

    	//当前至尊消费月分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天至尊消费月分红池
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');

    	//资深主管以上
    	$member_list = positions_member('2,7', $pre_period['end_time']);
   		if (!$member_list) {
   			return bonus_op_log('没有符合条件的用户1', $bonus_name);
   		}

   		foreach ($member_list as $k => $v) {
   			//在上期的级别为至尊会员
   			$last_level = db('user_log_ascending_degrading')->where('user_id', $v['member_id'])
   															->where('created_at', 'elt', $pre_period['end_time'])
   															->order('id desc')
   															->value('new_level');
   			if ($last_level != 6) {
   				unset($member_list[$k]);
                continue;
   			}
   			//个人消费在1000元以上
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msp_buyer_order_amount']);
			if ($member_pre_period_order['buyer_order_amount'] < 1000) {
				unset($member_list[$k]);
				continue;
			}
			$member_list[$k]['member_pre_period_order'] = $member_pre_period_order;
   		}

   		if (!$member_list) {
   			return bonus_op_log('没有符合条件的用户2', $bonus_name);
   		}

    	//各级别合格人数
    	$qualified_num2 = 0;
    	$qualified_num3 = 0;
    	$qualified_num4 = 0;
    	$qualified_num5 = 0;
    	$qualified_num6 = 0;
    	$qualified_num7 = 0;
    	$total_amount = 0;

    	foreach ($member_list as $k => $v) {
    		switch ($v['level_now']) {
    			case '2':
    				$qualified_num2++;
    				break;
    			case '3':
    				$qualified_num2++;
    				$qualified_num3++;
    				break;
    			case '4':
    				$qualified_num2++;
    				$qualified_num3++;
    				$qualified_num4++;
    				break;
    			case '5':
    				$qualified_num2++;
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				break;
    			case '6':
    				$qualified_num2++;
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				$qualified_num6++;
    				break;
    			case '7':
    				$qualified_num2++;
    				$qualified_num3++;
    				$qualified_num4++;
    				$qualified_num5++;
    				$qualified_num6++;
    				$qualified_num7++;
    				break;
    		}
    		$total_amount += $v['member_pre_period_order']['total_amount'];
    	}

    	foreach ($member_list as $k => $v) {
    		//1、资深主管至尊消费月分红：平台上期至尊消费月分红池 × 20% ÷ 上期合格总人数 + 平台上期至尊消费月分红池 × 5% ÷ 上期资深主管及以上合格总人数 + 本会员用户上期销售额 ÷ 上期参加该分红级别会员的总销售额（除升级消费外） ÷ 平台上期至尊消费月分红池 × 50%。

    		//资深主管
    		$bonus = ($bonus_pool * 0.2 / count($member_list)) + ($bonus_pool * 0.05 / $qualified_num2) + ($v['member_pre_period_order']['total_amount'] / $total_amount * $bonus_pool * 0.5);

    		//市场主任或以上
    		if ($v['level_now'] >= 3) {
    			$bonus += ($bonus_pool * 0.05 / $qualified_num3);
    		}

    		//市场经理或以上
    		if ($v['level_now'] >= 4) {
    			$bonus += ($bonus_pool * 0.05 / $qualified_num4);
    		}

    		//市场总监或以上
    		if ($v['level_now'] >= 5) {
    			$bonus += ($bonus_pool * 0.05 / $qualified_num5);
    		}

    		//市场总经理或以上
    		if ($v['level_now'] >= 6) {
    			$bonus += ($bonus_pool * 0.05 / $qualified_num6);
    		}

    		//市场副总裁或以上
    		if ($v['level_now'] == 7) {
    			$bonus += ($bonus_pool * 0.05 / $qualified_num7);
    		}

    		$bonus = price_format($bonus);

            if ($bonus > $this->fhconfig['zzxfyfhjesx']) {
                $bonus = $this->fhconfig['zzxfyfhjesx'];
            }

    		$end_bonus_pool -= $bonus;

   			//更新会员分红字段
	        update_member_balance($v['member_id'], $bonus, $bonus_name);
    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '至尊消费月分红');

    	bonus_op_log('至尊消费月分红完成', $bonus_name);

    }

    /**
     * 销售精英月分红
     *
     * @return void
     */
    public function xsjyyfh()
    {
    	$bonus_name = 'xsjyyfh';

        $pre_period = pre_period();

        //上期结束到目前为止，第15天
        if ((time() - strtotime($pre_period['end_time'])) / 86400 == 15) {
            return bonus_op_log('销售精英月分红 第15天才执行', $bonus_name);
        }

    	bonus_op_log('销售精英月分红开始', $bonus_name);

    	//最后分红的用户
    	$member_list = [];

    	//当前销售精英月分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天销售精英月分红池
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');

    	/**
    	 * 1.会员职级是高级主管及以上的：上期“个人消费”累计达到1000元及以上或“个人消费”加被推荐会员的个人消费额加微店销售额达到2000元及以上。 
    	 * 2.会员级别是银尊VIP或以上的：上期“个人消费”累计达到3000元及以上或“个人消费”加被推荐会员的个人消费额加微店销售额达到5000元及以上。
    	 * 3.免费VIP会员：上期“个人消费”加被推荐会员的个人消费额加微店销售额达到20000元及以上。 
    	 */

    	//满足条件1
    	$member_list1 = positions_member('1,7', $pre_period['end_time']);
   		foreach ($member_list1 as $k => $v) {
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['update_level_point', 'buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msp_buyer_order_amount', 'pp_mds_seller_order_amount']);
   			//个人消费
   			if ($member_pre_period_order['buyer_order_amount'] < 1000) {

				if ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['pp_mds_buyer_order_amount'] + $member_pre_period_order['pp_mds_seller_order_amount'] < 2000) {
					continue;
				}
   			}

   			$member_info = member_info($v['member_id']);
   			$member_list[$v['member_id']] = [
   				'member_id' 			  => $v['member_id'],
   				'hi' 					  => $member_info['hi'],
   				'member_pre_period_order' => $member_pre_period_order
   			];
   		}

   		//满足条件2
   		$member_list2 = level_member('2,6', $pre_period['end_time']);
   		foreach ($member_list2 as $k => $v) {
   			if (isset($member_list[$v['member_id']])) {
   				continue;
   			}
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['update_level_point', 'buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msp_buyer_order_amount', 'pp_mds_seller_order_amount']);
   			if ($member_pre_period_order['buyer_order_amount'] < 3000) {
				if ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['pp_mds_buyer_order_amount'] + $member_pre_period_order['pp_mds_seller_order_amount'] < 5000) {
					continue;
				}
   			}
   			$member_info = member_info($v['member_id']);
   			$member_list[$v['member_id']] = [
   				'member_id' 			  => $v['member_id'],
   				'hi' 					  => $member_info['hi'],
   				'member_pre_period_order' => $member_pre_period_order
   			];
   		}

   		//满足条件3
   		$member_list3 = db('member')->where('level_id', 0)->select();
   		foreach ($member_list3 as $k => $v) {
   			if (isset($member_list[$v['member_id']])) {
   				continue;
   			}
   			$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['update_level_point', 'buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msp_buyer_order_amount', 'pp_mds_seller_order_amount']);
   			if ($member_pre_period_order['buyer_order_amount'] + $member_pre_period_order['pp_mds_buyer_order_amount'] + $member_pre_period_order['msp_buyer_order_amount'] < 20000) {
					continue;
				}

   			$member_info = member_info($v['member_id']);
   			$member_list[$v['member_id']] = [
   				'member_id' 			  => $v['member_id'],
   				'hi' 					  => $member_info['hi'],
   				'member_pre_period_order' => $member_pre_period_order
   			];
   		}

   		if (empty($member_list)) {
   			return bonus_op_log('没有符合条件的用户', $bonus_name);
   		}

   		$total_hi = array_sum(array_column($member_list, 'hi'));

   		$total_amount = 0;
   		foreach ($member_list as $k => $v) {
   			$tmp = $v['member_pre_period_order'];
   			$total_amount += ($tmp['buyer_order_amount'] + $tmp['update_level_point'] + $tmp['seller_order_amount'] + $tmp['pp_mds_buyer_order_amount'] + $tmp['msp_buyer_order_amount']);
   		}


        if ($total_amount > 0 && $total_hi > 0) {
            foreach ($member_list as $k => $v) {
                //核算公式：(上期销售精英月分红池 × 40% ÷ 上期合格总人数)+(上期该会员分红HI值 ÷ 上期参加该分红所有会员的总分红HI值 × 上期销售精英月分红池 ×40%)+（上期会员销售额/上期参加该分红会员的总销售额 ×上期团队剩余池 × 20%）

                $bonus = price_format(($bonus_pool * 0.4 / count($member_list)) + ($v['hi'] / $total_hi * $bonus_pool * 0.4) + (($v['member_pre_period_order']['buyer_order_amount'] + $v['member_pre_period_order']['update_level_point'] + $v['member_pre_period_order']['seller_order_amount'] + $v['member_pre_period_order']['pp_mds_buyer_order_amount'] + $v['member_pre_period_order']['msp_buyer_order_amount']) / $total_amount * $bonus_pool * 0.2));


                if ($bonus > 0) {
                    if ($bonus > $this->fhconfig['xsjyyfhjesx']) {
                        $bonus = $this->fhconfig['xsjyyfhjesx'];
                    }

                    $end_bonus_pool -= $bonus;

                    //更新会员分红字段
                    update_member_balance($v['member_id'], $bonus, $bonus_name);
                } 
            }
        }

   		update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '销售精英月分红');

    	bonus_op_log('销售精英月分红完成', $bonus_name);

    }

    /**
     * 供应商推荐奖（每个月15号触发）
     *
     * @return void
     */
    public function gystjj()
    {
    	$bonus_name = 'gystjj';

    	//（每3个月为一个计算周期）每一期的第15天1-3发放
    	//上一期的开始时间
    	$month = date('m');
    	if (!in_array($month, [4, 7, 10, 1])) {
    		return bonus_op_log('未到结算月份', $bonus_name);
    	} elseif (date('d') != 15) {
            return bonus_op_log('未到结算日期', $bonus_name);
        }

        bonus_op_log('供应商推荐奖开始', $bonus_name);

    	//如果是1月份，则计算上年10~12月份的
    	if ($month == 1) {
    		$year = date('Y') - 1;
    		$start_time = $year . '-10-01 00:00:00';
    		$end_time   = $year . '-12-31 23:59:59';
    	} else {
    		$year = date('Y');
    		$start_time = $year . '-'. ($month-3) .'-01 00:00:00';
    		$t 			= date('t', strtotime($year . '-' . ($month-1)));
    		$end_time 	= $year . '-'. ($month-1) .'-' . $t .' 23:59:59';
    	}

    	$member_list = level_member('5,6', $end_time);
    	if (!$member_list) {
    		return bonus_op_log('没有符合条件的用户1', $bonus_name);
    	}


    	foreach ($member_list as $k => $v) {
    		//1.当月个人消费（除升级外的）累计满了365元（除升级外的）
    		$buyer_order_amount = buyer_order_amount($v['member_id'], ['start_time'=>date('Y-m-01')]);

    		if ($buyer_order_amount < 365) {
    			unset($member_list[$k]);
    			continue;
    		}

    		//2.该分红安全期期间，每月个人消费（除升级外的）需累计满365元及以上
    		for ($i=0; $i < 3; $i++) { 
    			$tmp_start_time = $year . '-'. ($month-3+$i) .'-01 00:00:00';
    			$t 				= date('t', strtotime($year . '-' . ($month-1+$i)));
    			$tmp_end_time 	= $year . '-'. ($month-1+$i) .'-' . $t .' 23:59:59';
    			$buyer_order_amount = buyer_order_amount($v['member_id'], ['start_time'=>$tmp_start_time, 'end_time'=>$tmp_end_time]);
    			if ($buyer_order_amount < 365) {
	    			unset($member_list[$k]);
	    			continue;
	    		}
    		}
    	}
    	if (!$member_list) {
    		return bonus_op_log('没有符合条件的用户2', $bonus_name);
    	}

    	foreach ($member_list as $k => $v) {
    		//用户所推荐的店铺
    		$member_subordinate_direct = member_subordinate_direct($v['member_id']);
    		if (!$member_subordinate_direct) {
    			continue;
    		}
    		$order_ids = db('orders')->where('thaw_time', 'egt', strtotime($start_time))
    								 ->where('thaw_time', 'elt', strtotime($end_time))
    								 ->where('referral_member_id', 'in', $member_subordinate_direct)
    								 ->column('order_id');
    		if (!$order_ids) {
    			continue;
    		}
    		$order_bonus = db('order_bonus')->where('order_id', 'in', $order_ids)->select();
    		$bonus = 0;
    		$proportion = $v['new_level'] == 5 ? 0.01 : 0.02;
    		foreach ($order_bonus as $k1 => $v1) {
    			//1.至尊VIP会员：该商家商品上期销售总额的消费分红利润（税后可分配） × 2%。
				//2.天尊VIP会员：该商家商品上期销售总额的消费分红利润 （税后可分配）× 1%。
    			$bonus += ($v1['at_profit'] * $proportion);
    		}

            if ($bonus > $this->fhconfig['gystjjjsx']) {
                $bonus = $this->fhconfig['gystjjjsx'];
            }

    		//更新会员分红字段
		    update_member_balance($v['member_id'], $bonus, $bonus_name);
    	}
    	bonus_op_log('供应商推荐奖完成', $bonus_name);
    }

    /**
     * 高层消费月分红
     *
     * @return void
     */
    public function gcxfyfh()
    {
    	$bonus_name = 'gcxfyfh';

        $pre_period = pre_period();

        //上期结束到目前为止，第15天
        if ((time() - strtotime($pre_period['end_time'])) / 86400 == 15) {
            return bonus_op_log('高层消费月分红 第15天才执行', $bonus_name);
        }

    	bonus_op_log('高层消费月分红开始', $bonus_name);

    	//最后分红的用户
    	$member_list = [];

    	//当前高层消费月分红池
    	$start_bonus_pool = $end_bonus_pool = bonus_pool($bonus_name);

    	//昨天高层消费月分红池
    	$bonus_pool = bonus_pool($bonus_name, 'yesterday');

    	//市场总监以上
    	$member_list = positions_member('5,7', $pre_period['end_time']);

    	foreach ($member_list as $k => $v) {
    		//市场总监：上一期个人消费累计达到3000元或以上
    		//市场总经理：上一期个人消费累计达到4000元或以上
    		//市场副总裁：上一期个人消费累计达到5000元或以上 
    		//备注：个人消费均不包含用于升级的消费
    		$member_pre_period_order = member_pre_period_order($v['member_id'], $pre_period, ['buyer_order_amount', 'seller_order_amount', 'pp_mds_buyer_order_amount', 'msd_buyer_order_amount']);
    		if ($v['level_now'] == 5 && $member_pre_period_order['buyer_order_amount'] < 3000) {
    			unset($member_list[$k]);
    			continue;
    		} elseif ($v['level_now'] == 6 && $member_pre_period_order['buyer_order_amount'] < 4000) {
    			unset($member_list[$k]);
    			continue;
    		} elseif ($v['level_now'] == 7 && $member_pre_period_order['buyer_order_amount'] < 5000) {
    			unset($member_list[$k]);
    			continue;
    		}

    		$member_info = member_info($v['member_id']);
    		$member_list[$k]['hi'] = $member_info['hi'];
    		$member_list[$k]['member_pre_period_order'] = $member_pre_period_order;
    	}

    	if (!$member_list) {
    		return bonus_op_log('没有符合条件的用户', $bonus_name);
    	}

    	//各级别合格人数
    	$qualified_num5 = 0;
    	$qualified_num6 = 0;
    	$qualified_num7 = 0;

    	//各级别分红总HI
    	$qualified_num5_hi = 0;
    	$qualified_num6_hi = 0;
    	$qualified_num7_hi = 0;

    	//各级别分红总销售额
    	$qualified_num5_total_amount = 0;
    	$qualified_num6_total_amount = 0;
    	$qualified_num7_total_amount = 0;

    	foreach ($member_list as $k => $v) {
    		$tmp = $v['member_pre_period_order']['total_amount'];

    		switch ($v['level_now']) {
    			case '5':
    				$qualified_num5++;
    				$qualified_num5_hi += $v['hi'];
    				$qualified_num5_total_amount += $tmp;
    				break;
    			case '6':
    				$qualified_num5++;
    				$qualified_num6++;
    				$qualified_num6_hi += $v['hi'];
    				$qualified_num5_hi += $v['hi'];
    				$qualified_num5_total_amount += $tmp;
    				$qualified_num6_total_amount += $tmp;
    				break;
    			case '7':
    				$qualified_num5++;
    				$qualified_num6++;
    				$qualified_num7++;
    				$qualified_num5_hi += $v['hi'];
    				$qualified_num6_hi += $v['hi'];
    				$qualified_num7_hi += $v['hi'];
    				$qualified_num5_total_amount += $tmp;
    				$qualified_num6_total_amount += $tmp;
    				$qualified_num7_total_amount += $tmp;
    				break;
    		}

       	}

    	foreach ($member_list as $k => $v) {
    		$tmp = $v['member_pre_period_order']['total_amount'];

    		//市场总监
    		$bonus = ($bonus_pool * 0.25 / $qualified_num5) + ($v['hi'] > 0 ? ($v['hi'] / $qualified_num5_hi * $bonus_pool * 0.1875) : 0)  + ($tmp / $qualified_num5_total_amount * $bonus_pool * 0.1875);

    		//市场总经理
    		if ($v['level_now'] > 5 && $qualified_num6_hi > 0) {
    			$bonus += ($bonus_pool * 0.125 / $qualified_num6) + ($v['hi'] > 0 ? ($v['hi'] / $qualified_num6_hi * $bonus_pool * 0.0625) : 0) + ($tmp / $qualified_num6_total_amount * $bonus_pool * 0.0625);
    		}

    		//市场副总裁
    		if ($v['level_now'] > 6) {
    			$bonus += ($bonus_pool * 0.0625 / $qualified_num7) + ($v['hi'] / $qualified_num7_hi * $bonus_pool * 0.03) + ($tmp / $qualified_num7_total_amount * $bonus_pool * 0.0325);
    		}

    		$bonus = price_format($bonus);

    		if ($bonus > 0) {
                if ($bonus > $this->fhconfig['gcxsyfhjesx']) {
                    $bonus = $this->fhconfig['gcxsyfhjesx'];
                }

    			$end_bonus_pool -= $bonus;

	   			//更新会员分红字段
		        update_member_balance($v['member_id'], $bonus, $bonus_name);
    		}

    	}

    	update_bonus_pool($bonus_name, $start_bonus_pool - $end_bonus_pool, '高层消费月分红');

    	bonus_op_log('高层消费月分红完成', $bonus_name);
    }

    /**
     * 消费养老补贴
     * 
     * @return void
     */
    public function xfylbt()
    {
    	$bonus_name = 'xfylbt';

        $pre_period = pre_period();

        //上期结束到目前为止，第15天
        if ((time() - strtotime($pre_period['end_time'])) / 86400 == 15) {
            return bonus_op_log('消费养老补贴开始 第15天才执行', $bonus_name);
        }

    	bonus_op_log('消费养老补贴开始', $bonus_name);

    	//免费会员以上
    	$member_list = db('member')->where('level_id', 'egt', 2)->where('level_id', 'elt', 6)->select();

    	foreach ($member_list as $k => $v) {
    		$proportion = 0;
    		switch ($v['level_id']) {
    			case '2':
    				$proportion = 0.01;
    				break;
    			case '3':
    				$proportion = 0.02;
    				break;
    			case '4':
    				$proportion = 0.03;
    				break;
    			case '5':
    				$proportion = 0.04;
    				break;
    			case '6':
    				$proportion = 0.05;
    				break;
    		}
    		$bonus = 0 * $proportion;
    		//更新会员分红字段
		    update_member_balance($v['member_id'], $bonus, $bonus_name);
    	}

    	bonus_op_log('消费养老补贴完成', $bonus_name);
    }

    /**
     * 车房梦想补贴
     * 
     * @return void
     */
    public function cfmxbt()
    {
    	$bonus_name = 'cfmxbt';

        $pre_period = pre_period();

        //上期结束到目前为止，第15天
        if ((time() - strtotime($pre_period['end_time'])) / 86400 == 15) {
            return bonus_op_log('车房梦想补贴开始 第15天才执行', $bonus_name);
        }

    	bonus_op_log('车房梦想补贴开始', $bonus_name);

    	//免费会员以上
    	$member_list = db('member')->where('level_id', 'egt', 2)->where('level_id', 'elt', 6)->select();

    	foreach ($member_list as $k => $v) {
    		$proportion = 0;
    		switch ($v['level_id']) {
    			case '2':
    				$proportion = 0.01;
    				break;
    			case '3':
    				$proportion = 0.02;
    				break;
    			case '4':
    				$proportion = 0.03;
    				break;
    			case '5':
    				$proportion = 0.04;
    				break;
    			case '6':
    				$proportion = 0.05;
    				break;
    		}
    		$bonus = 0 * $proportion;
    		//更新会员分红字段
		    update_member_balance($v['member_id'], $bonus, $bonus_name);
    	}

    	bonus_op_log('车房梦想补贴完成', $bonus_name);
    }
}
