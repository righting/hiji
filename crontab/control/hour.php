<?php
/**
 * 任务计划 - 小时执行的任务
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class hourControl extends BaseCronControl
{
    /**
     * 执行频率常量 1小时
     *
     * @var int
     */
    const EXE_TIMES = 3600;

    private $_doc;
    private $_xs;
    private $_index;
    private $_search;
    private $_contract_item;

    /**
     * 默认方法
     */
    public function indexOp()
    {
        // 未付款订单超期自动关闭
        $this->_order_timeout_cancel();

        // 更新全文搜索内容
        $this->_xs_update();

        // 职务进升
        $this->_memberPromote();
    }

    /**
     * 未付款订单超期自动关闭
     */
    private function _order_timeout_cancel()
    {
        //实物订单超期未支付系统自动关闭
        $_break                    = false;
        $model_order               = new orderModel();
        $logic_order               = new orderLogic();
        $logic_order_book          = new order_bookLogic();
        $condition                 = [];
        $condition['order_state']  = ORDER_STATE_NEW;
        $condition['chain_code']   = 0;
        $condition['api_pay_time'] = 0;
        $condition['add_time']     = ['lt', TIMESTAMP - ORDER_AUTO_CANCEL_TIME * self::EXE_TIMES];
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', '', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                if ($order_info['order_type'] != 2) {
                    $result = $logic_order->changeOrderStateCancel($order_info, 'system', '系统', '超期未支付系统自动关闭订单', true, ['order_state' => ORDER_STATE_NEW]);
                } else {
                    //预定订单单独处理
                    $result = $logic_order_book->changeOrderStateCancel($order_info, 'system', '系统', '超期未支付系统自动关闭订单');
                }

                if (!$result['state']) {
                    $this->log('实物订单超期未支付关闭失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }

        //虚拟订单超期未支付系统自动关闭
        $_break                    = false;
        $model_vr_order            = Model('vr_order');
        $logic_vr_order            = Logic('vr_order');
        $condition                 = [];
        $condition['order_state']  = ORDER_STATE_NEW;
        $condition['api_pay_time'] = 0;
        $condition['add_time']     = ['lt', TIMESTAMP - ORDER_AUTO_CANCEL_TIME * self::EXE_TIMES];

        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $model_vr_order->getOrderList($condition, '', '*', '', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_vr_order->changeOrderStateCancel($order_info, 'system', '超期未支付系统自动关闭订单', false);
            }
            if (!$result['state']) {
                $this->log('虚拟订单超期未支付关闭失败SN:' . $order_info['order_sn']);
                $_break = true;
                break;
            }
        }
    }

    /**
     * 初始化对象
     */
    private function _ini_xs()
    {
        require(BASE_DATA_PATH . '/api/xs/lib/XS.php');
        $this->_doc    = new XSDocument();
        $this->_xs     = new XS(C('fullindexer.appname'));
        $this->_index  = $this->_xs->index;
        $this->_search = $this->_xs->search;
        $this->_search->setCharset(CHARSET);

        //查询消费者保障服务
        $contract_item = [];
        if (C('contract_allow') == 1) {
            $this->_contract_item = Model('contract')->getContractItemByCache();
        }
    }

    /**
     * 全量创建索引
     */
    public function xs_createOp()
    {
        if (!C('fullindexer.open')) return;
        $this->_ini_xs();
        $model = Model();
        try {
            //每次批量更新商品数
            $step_num    = 100;
            $model_goods = Model('goods');

            if (C('dbdriver') == 'mysql') {
                $_field    = "CONCAT(goods_commonid,',',color_id)";
                $_distinct = 'nc_distinct';
            } elseif (C('dbdriver') == 'oracle') {
                $_field = $_distinct = "goods_commonid||','||color_id";
            }
            $count = $model_goods->getGoodsOnlineCount([], "distinct " . $_field);
            echo 'Total:' . $count . "\n";
            if ($count != 0) {
                for ($i = 0; $i <= $count; $i = $i + $step_num) {
                    if (C('dbdriver') == 'mysql') {
                        $goods_list = $model_goods->getGoodsOnlineList([], '*,' . $_field . ' nc_distinct', 0, '', "{$i},{$step_num}", $_distinct);
                    } elseif (C('dbdriver') == 'oracle') {
                        //先查出所有goods_id,再使用in查询
                        $condition['goods_state']  = 1;
                        $condition['goods_verify'] = 1;
                        $goods_id_list             = $model->table('goods')->where($condition)->field('min(goods_id) as goods_id,' . $_field)->group($_field)->key('goods_id')->limit("{$i},{$step_num}")->select();
                        if ($goods_id_list) {
                            $condition1 = ['goods_id' => ['in', array_keys($goods_id_list)]];
                            $goods_list = $model_goods->getGoodsOnlineList($condition1, '*', 0, '', '', false);
                        }
                    }
                    $this->_build_goods($goods_list);
                    echo $i . " ok\n";
                    flush();
                    ob_flush();
                }
            }

            if ($count > 0) {
                sleep(2);
                $this->_index->flushIndex();
                sleep(2);
                $this->_index->flushLogging();
            }
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * 更新增量索引
     */
    public function _xs_update()
    {
        if (!C('fullindexer.open')) return;
        $this->_ini_xs();
        $model = Model();
        try {
            //更新多长时间内的新增(编辑)商品信息，该时间一般与定时任务触发间隔时间一致,单位是秒,默认3600
            $step_time = self::EXE_TIMES + 60;
            //每次批量更新商品数
            $step_num = 100;

            $model_goods                 = Model('goods');
            $condition                   = [];
            $condition['goods_edittime'] = ['egt', TIMESTAMP - $step_time];
            if (C('dbdriver') == 'mysql') {
                $_field    = "CONCAT(goods_commonid,',',color_id)";
                $_distinct = 'nc_distinct';
            } elseif (C('dbdriver') == 'oracle') {
                $_field = $_distinct = "goods_commonid||','||color_id";
            }
            $count = $model_goods->getGoodsOnlineCount($condition, "distinct " . $_field);
            echo 'Total:' . $count . "\n";
            for ($i = 0; $i <= $count; $i = $i + $step_num) {
                if (C('dbdriver') == 'mysql') {
                    $goods_list = $model_goods->getGoodsOnlineList($condition, '*,' . $_field . ' nc_distinct', 0, '', "{$i},{$step_num}", $_distinct);
                } elseif (C('dbdriver') == 'oracle') {
                    //先查出所有goods_id,再使用in查询
                    $condition['goods_state']  = 1;
                    $condition['goods_verify'] = 1;
                    $goods_id_list             = $model->table('goods')->where($condition)->field('min(goods_id) as goods_id,' . $_field)->group($_field)->key('goods_id')->limit("{$i},{$step_num}")->select();
                    if ($goods_id_list) {
                        $condition1 = ['goods_id' => ['in', array_keys($goods_id_list)]];
                        $goods_list = $model_goods->getGoodsOnlineList($condition1, '*', 0, '', '', false);
                    }
                }
                //通过commonid得到所有goods_id，然后删除全文索引中的goods_id内容
                $goods_commonid_array = [];
                foreach ($goods_list as $_v) {
                    $goods_commonid_array[] = $_v['goods_commonid'];
                }
                if ($goods_commonid_array) {
                    $condition1  = ['goods_commonid' => ['in', $goods_commonid_array]];
                    $goods_list1 = $model_goods->getGoodsOnlineList($condition1, 'goods_id', 0, '', '', false);
                    if ($goods_list1) {
                        $goods_id_array = [];
                        foreach ($goods_list1 as $_v) {
                            $goods_id_array[] = $_v['goods_id'];
                        }
                        $this->_index->del($goods_id_array);
                    }
                }
                $this->_build_goods($goods_list);
                echo $i . " ok\n";
                flush();
                ob_flush();
            }
            if ($count > 0) {
                sleep(2);
                $this->_index->flushIndex();
                sleep(2);
                $this->_index->flushLogging();
            }
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * 索引商品数据
     *
     * @param array $goods_list
     */
    private function _build_goods($goods_list = [])
    {
        if (empty($goods_list) || !is_array($goods_list)) return;
        $goods_class          = Model('goods_class')->getGoodsClassForCacheModel();
        $model_goods          = Model('goods');
        $goods_commonid_array = [];
        $goods_id_array       = [];
        $store_id_array       = [];
        foreach ($goods_list as $k => $v) {
            $goods_commonid_array[] = $v['goods_commonid'];
            $goods_id_array[]       = $v['goods_id'];
            $store_id_array[]       = $v['store_id'];
        }

        //商品图
        $image_list = $model_goods->getGoodsImageList(['goods_commonid' => ['in', $goods_commonid_array]], '*', 'is_default desc,goods_image_id asc');

        // 店铺
        $store_list = Model('store')->getStoreMemberIDList($store_id_array);

        $kill_common_ids = [];
        //首先进行一次循环，根据商品分类的show_type设置，确定哪些SKU显示，缓存哪些商品图
        foreach ($goods_list as $k => $goods_info) {
            if ($goods_class[$goods_info['gc_id']]['show_type'] == 1) {
                //原来的显示方式，显示多个SKU,每个SKU显示各自的图
                foreach ($image_list as $image_info) {
                    if ($goods_info['goods_commonid'] == $image_info['goods_commonid']
                        && $goods_info['store_id'] == $image_info['store_id']
                        && $goods_info['color_id'] == $image_info['color_id']) {
                        $goods_list[$k]['image'][] = $image_info['goods_image'];
                    }
                }
            } else {
                //一个commonid中只显示一个SKU，显示各个SKU的主图
                foreach ($image_list as $image_info) {
                    if ($goods_info['goods_commonid'] == $image_info['goods_commonid']
                        && $goods_info['store_id'] == $image_info['store_id']
                        && $image_info['is_default'] == 1) {
                        $goods_list[$k]['image'][] = $image_info['goods_image'];
                    }
                }
                if (in_array($goods_info['goods_commonid'], $kill_common_ids)) {
                    unset($goods_list[$k]);
                } else {
                    $kill_common_ids[] = $goods_info['goods_commonid'];
                }
            }
        }

        //取common表内容
        $condition_common                   = [];
        $condition_common['goods_commonid'] = ['in', $goods_commonid_array];
        $goods_common_list                  = $model_goods->getGoodsCommonOnlineList($condition_common, '*', 0);
        $goods_common_new_list              = [];
        foreach ($goods_common_list as $k => $v) {
            $goods_common_new_list[$v['goods_commonid']] = $v;
        }

        //取属性表值
        $model_type = Model('type');
        $attr_list  = $model_type->getGoodsAttrIndexList(['goods_id' => ['in', $goods_id_array]], 0, 'goods_id,attr_value_id');
        if (is_array($attr_list) && !empty($attr_list)) {
            $attr_value_list = [];
            foreach ($attr_list as $val) {
                $attr_value_list[$val['goods_id']][] = $val['attr_value_id'];
            }
        }

        //处理商品消费者保障服务信息
        $goods_list = $model_goods->getGoodsContract($goods_list, $this->_contract_item);

        //整理需要索引的数据
        foreach ($goods_list as $k => $v) {
            $cate_3 = $cate_2 = $cate_1 = null;
            $gc_id  = $v['gc_id'];
            $depth  = $goods_class[$gc_id]['depth'];
            if ($depth == 3) {
                $cate_3 = $gc_id;
                $gc_id  = $goods_class[$gc_id]['gc_parent_id'];
                $depth--;
            }
            if ($depth == 2) {
                $cate_2 = $gc_id;
                $gc_id  = $goods_class[$gc_id]['gc_parent_id'];
                $depth--;
            }
            if ($depth == 1) {
                $cate_1 = $gc_id;
                $gc_id  = $goods_class[$gc_id]['gc_parent_id'];
            }
            $index_data                          = [];
            $index_data['pk']                    = $v['goods_id'];
            $index_data['goods_id']              = $v['goods_id'];
            $index_data['goods_name']            = $v['goods_name'];
            $index_data['goods_jingle']          = $v['goods_jingle'];
            $index_data['brand_id']              = $v['brand_id'];
            $index_data['is_book']               = $v['is_book'];
            $index_data['goods_promotion_price'] = $v['goods_promotion_price'];
            $index_data['goods_click']           = $v['goods_click'];
            $index_data['goods_salenum']         = $v['goods_salenum'];
            $index_data['goods_barcode']         = $v['goods_barcode'];
            // 判断店铺是否为自营店铺
            $index_data['store_id']   = $v['is_own_shop'];
            $index_data['area_id']    = $v['areaid_1'];
            $index_data['gc_id']      = $v['gc_id'];
            $index_data['gc_name']    = str_replace('&gt;', '', $goods_common_new_list[$v['goods_commonid']]['gc_name']);
            $index_data['brand_name'] = $goods_common_new_list[$v['goods_commonid']]['brand_name'];
            $index_data['have_gift']  = $v['have_gift'];
            if (!empty($attr_value_list[$v['goods_id']])) {
                $index_data['attr_id'] = implode('_', $attr_value_list[$v['goods_id']]);
            }
            if (!empty($cate_1)) {
                $index_data['cate_1'] = $cate_1;
            } else {
                $index_data['cate_1'] = 0;
            }
            if (!empty($cate_2)) {
                $index_data['cate_2'] = $cate_2;
            } else {
                $index_data['cate_2'] = 0;
            }
            if (!empty($cate_3)) {
                $index_data['cate_3'] = $cate_3;
            } else {
                $index_data['cate_3'] = 0;
            }
            for ($i = 1; $i <= 10; $i++) {
                $index_data['contract_' . $i] = $v['contract_' . $i] ? '1' : '0';
            }
            if (is_array($v['contractlist']) && !empty($v['contractlist'])) {
                foreach ($v['contractlist'] as $xbk => $xbv) {
                    $v['contractlist'][$xbk]                    = [];
                    $v['contractlist'][$xbk]['cti_descurl']     = $xbv['cti_descurl'];
                    $v['contractlist'][$xbk]['cti_name']        = $xbv['cti_name'];
                    $v['contractlist'][$xbk]['cti_icon_url_60'] = $xbv['cti_icon_url_60'];
                }
            }

            $index_data['main_body'] = serialize([
                'goods_promotion_type' => $v['goods_promotion_type'],
                'goods_marketprice'    => $v['goods_marketprice'],
                'contractlist'         => $v['contractlist'],
                'evaluation_good_star' => $v['evaluation_good_star'],
                'is_virtual'           => $v['is_virtual'],
                'is_fcode'             => $v['is_fcode'],
                'is_presell'           => $v['is_presell'],
                'evaluation_count'     => $v['evaluation_count'],
                'member_id'            => $store_list[$v['store_id']]['member_id'],
                'store_domain'         => $store_list[$v['store_id']]['store_domain'],
                'store_id'             => $v['store_id'],
                'goods_storage'        => $v['goods_storage'],
                'goods_image'          => $v['goods_image'],
                'store_name'           => $v['store_name'],
                'image'                => $v['image']
            ]);
            //添加到索引库
            $this->_doc->setFields($index_data);
            $this->_index->update($this->_doc);
        }
    }

    public function xs_clearOp()
    {
        if (!C('fullindexer.open')) return;
        $this->_ini_xs();

        try {
            $this->_index->clean();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    public function xs_flushLoggingOp()
    {
        if (!C('fullindexer.open')) return;
        $this->_ini_xs();
        try {
            $this->_index->flushLogging();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    public function xs_flushIndexOp()
    {
        if (!C('fullindexer.open')) return;
        $this->_ini_xs();

        try {
            $this->_index->flushIndex();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * 会员职级晋升
     */
    private function _memberPromote()
    {
        //获取职务等级信息,以等级为key
        if (empty(rkcache('pos'))) {
            $model_positions = new positionsModel();
            $positions_info  = $model_positions->getPositionAll();
            foreach ($positions_info as $k => &$value) {
                for ($m = 1; $m <= 7; $m++) {
                    if ($value['m_' . $m] > 0) {
                        $value['m'] = ['m_' . $m, $value['m_' . $m]];
                    }
                    if ($value['p_' . $m] > 0) {
                        $value['p'] = ['p_' . $m, $value['p_' . $m]];
                    }
                }
            }
            unset($k, $value, $positions_info[0]);
            wkcache('pos', $positions_info, 86400);
        } else {
            $positions_info = rkcache('pos');
        }

        $cache              = rkcache('pos');
        $top_posstion_level = max(array_column($cache, 'level'));//找到最高职级


        $sql  = 'select a.member_id,c.`level` as member_level,d.level as positions_level,b.from_user_id as pid
               from member a INNER JOIN register_invite b on a.member_id=b.to_user_id inner join user_level c on a.level_id=c.id inner join positions d on a.positions_id=d.id';
        $data = Model()->query($sql);


        $pos_log      = [];
        $contribution = [];

        $model = new memberModel();

        //1-获取邀请表数据 2-遍历中判断用户是否达到职级要求 3-统计会员下级人数并晋升
        foreach ($data as $k => $v) {
            //升级规则
            $key = $v['positions_level'] + 1;
            $m   = isset($positions_info[$key]['m']) ? $positions_info[$key]['m'] : [];//会员等级数量
            $p   = isset($positions_info[$key]['p']) ? $positions_info[$key]['p'] : [];//会员职级数量

            //判断自身等级是否达到要求
            if (($v['positions_level'] < $top_posstion_level) && ($v['member_level'] >= $positions_info[$key]['own_level'])) {
                $member_data         = [];
                $positions_data      = [];
                $member_level_num    = 0;
                $positions_level_num = 0;

                //查找晋升到下一职级需要的指定等级的人数
                if (!empty($m)) {
                    $member_level     = explode('_', $m[0])[1];
                    $member_level_num = $m[1];
                    $coun_member_sql  = "select b.level_id,b.member_id from register_invite a,member b where a.from_user_id=" . $v['member_id'] . " and a.to_user_id=b.member_id and b.level_id>=" . $member_level . " and b.level_id<7";
                    $member_data      = Model()->query($coun_member_sql);
                }
                if (!empty($p)) {
                    //查找晋升到下一职级需要的指定职级的人数
                    $positions_level     = explode('_', $p[0])[1];
                    $positions_level_num = $p[1];
                    $count_positions_sql = "select b.positions_id from register_invite a,member b where a.from_user_id=" . $v['member_id'] . " and a.to_user_id=b.member_id and b.positions_id>=" . $positions_level . " and b.positions_id<8";
                    $positions_data      = Model()->query($count_positions_sql);
                }

                if (($key == 1 && count($member_data) >= $member_level_num) || (count($member_data) >= $member_level_num && count($positions_data) >= $positions_level_num)) {
                    //符合晋升要求，开始升级
                    $result = $model->where(['member_id' => $v['member_id']])->update(['positions_id' => $key]);
                    if ($result) {
                        $old_position = empty($positions_info[$key - 1]['title']) ? '无职级' : $positions_info[$key - 1]['title'];
                        array_push($pos_log, ['member_id' => $v['member_id'], 'level_old' => ($key - 1), 'level_now' => $key, 'created_at' => date('Y-m-d H:i:s', TIMESTAMP), 'remark' => '职务从【' . $old_position . '】升级到【' . $positions_info[$key]['title'] . '】']);
                    }
                }
            }

        }

        if (!empty($pos_log)) {
            Model()->table('positions_log')->insertAll($pos_log);//批量插入会员职务进升日志
        }

        if (!empty($contribution)) {
            $contribution_log = new contribution_logModel();
            $contribution_log->addContributionAll($contribution);//批量处理贡献值
        }

    }
}
