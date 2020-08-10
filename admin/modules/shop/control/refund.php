<?php
/**
 * 退款管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class refundControl extends SystemControl{
    const EXPORT_SIZE = 1000;
    private $links = array(
            array('url'=>'controller=refund','text'=>'待处理'),
            array('url'=>'controller=refund&action=refund_all','text'=>'所有记录'),
            array('url'=>'controller=refund&action=reason','text'=>'退款退货原因')
    );
    public function __construct(){
        parent::__construct();
        $model_refund = Model('refund_return');
        $model_refund->getRefundStateArray();
        Tpl::output('top_link',$this->sublink($this->links,$_GET['action']));
    }

    public function indexOp() {
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund_manage.list');
    }

    /**
     * 待处理列表
     */
    public function get_manage_xmlOp() {
        $model_refund = Model('refund_return');
        $condition = array();
        //状态:1为处理中,2为待管理员处理,3为已完成
        $condition['refund_state'] = ['in',[2,5,6]];

        list($condition,$order) = $this->_get_condition($condition);

        $refund_list = $model_refund->getRefundList($condition,$_POST['rp'],$order);
        $data = array();
        $data['now_page'] = $model_refund->shownowpage();
        $data['total_num'] = $model_refund->gettotalnum();
        $pic_base_url = UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/';
        foreach ($refund_list as $k => $refund_info) {
            $list = array();
            $list['operation'] = "<a class=\"btn orange\" href=\"index.php?controller=refund&action=edit&refund_id={$refund_info['refund_id']}\"><i class=\"fa fa-gavel\"></i>处理</a>";
            $list['refund_sn'] = $refund_info['refund_sn'];
            $list['refund_amount'] = ncPriceFormat($refund_info['refund_amount']);
            if(!empty($refund_info['pic_info'])) {
                $info = unserialize($refund_info['pic_info']);
                if (is_array($info) && !empty($info['buyer'])) {
                    foreach($info['buyer'] as $pic_name) {
                        $list['pic_info'] .= "<a href='".$pic_base_url.$pic_name."' target='_blank' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".$pic_base_url.$pic_name.">\")'><i class='fa fa-picture-o'></i></a> ";
                    }
                    $list['pic_info'] = trim($list['pic_info']);
                }
            }
            if (empty($list['pic_info'])) $list['pic_info'] = '';
            $list['buyer_message'] = "<span title='{$refund_info['buyer_message']}'>{$refund_info['buyer_message']}</span>";
            $list['add_times'] = date('Y-m-d H:i:s',$refund_info['add_time']);
            $list['goods_name'] = $refund_info['goods_name'];
            if ($refund_info['goods_id'] > 0) {
                $list['goods_name'] = "<a class='open' title='{$refund_info['goods_name']}' href='". urlShop('goods', 'index', array('goods_id' => $refund_info['goods_id'])) .
                "' target='blank'>{$refund_info['goods_name']}</a>";
            }
            $list['seller_message'] = $refund_info['seller_message'];
            $list['seller_times'] = !empty($refund_info['seller_time']) ? date('Y-m-d H:i:s',$refund_info['seller_time']) : '';
            if ($refund_info['goods_image'] != '') {
                $list['goods_image'] = "<a href='".cthumb($refund_info['goods_image'],360)."' target='_blank' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".cthumb($refund_info['goods_image'],240).">\")'><i class='fa fa-picture-o'></i></a> ";
            } else {
                $list['goods_image'] = '';
            }
            $list['goods_id'] = !empty($refund_info['goods_id']) ? $refund_info['goods_id'] : '';
            $list['order_sn'] = $refund_info['order_sn'];
            $list['buyer_name'] = $refund_info['buyer_name'];
            $list['buyer_id'] = $refund_info['buyer_id'];
            $list['store_name'] = $refund_info['store_name'];
            $list['store_id'] = $refund_info['store_id'];
            $data['list'][$refund_info['refund_id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    /**
     * 所有记录
     */
    public function refund_allOp() {
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund_all.list');
    }

    /**
     * 所有记录
     */
    public function get_all_xmlOp() {
        $model_refund = Model('refund_return');
        $condition = array();

        list($condition,$order) = $this->_get_condition($condition);

        $refund_list = $model_refund->getRefundList($condition,!empty($_POST['rp']) ? intval($_POST['rp']) : 15,$order);
        $data = array();
        $data['now_page'] = $model_refund->shownowpage();
        $data['total_num'] = $model_refund->gettotalnum();
        $pic_base_url = UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/';
        foreach ($refund_list as $k => $refund_info) {
            $list = array();
            if ($refund_info['refund_state'] == 2) {
                $list['operation'] = "<a class=\"btn orange\" href=\"index.php?controller=refund&action=edit&refund_id={$refund_info['refund_id']}\"><i class=\"fa fa-gavel\"></i>处理</a>";
            }
            $list['operation'] .= "<a class=\"btn green\" href=\"index.php?controller=refund&action=view&refund_id={$refund_info['refund_id']}\"><i class=\"fa fa-list-alt\"></i>查看</a>";
            $list['refund_sn'] = $refund_info['refund_sn'];
            $list['refund_amount'] = ncPriceFormat($refund_info['refund_amount']);
            if(!empty($refund_info['pic_info'])) {
                $info = unserialize($refund_info['pic_info']);
                if (is_array($info) && !empty($info['buyer'])) {
                    foreach($info['buyer'] as $pic_name) {
                        $list['pic_info'] .= "<a href='".$pic_base_url.$pic_name."' target='_blank' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".$pic_base_url.$pic_name.">\")'><i class='fa fa-picture-o'></i></a> ";
                    }
                    $list['pic_info'] = trim($list['pic_info']);
                }
            }
            if (empty($list['pic_info'])) $list['pic_info'] = '';
            $list['buyer_message'] = "<span title='{$refund_info['buyer_message']}'>{$refund_info['buyer_message']}</span>";
            $list['add_times'] = date('Y-m-d H:i:s',$refund_info['add_time']);
            $list['goods_name'] = $refund_info['goods_name'];
            if ($refund_info['goods_id'] > 0) {
                $list['goods_name'] = "<a class='open' title='{$refund_info['goods_name']}' href='". urlShop('goods', 'index', array('goods_id' => $refund_info['goods_id'])) .
                "' target='blank'>{$refund_info['goods_name']}</a>";
            }
            $state_array = $model_refund->getRefundStateArray('seller');
            $list['seller_state'] = $state_array[$refund_info['seller_state']];

            $admin_array = $model_refund->getRefundStateArray('admin');
            $list['refund_state'] = $refund_info['seller_state'] == 2 ? $admin_array[$refund_info['refund_state']]:'';

            $list['seller_message'] = "<span title='{$refund_info['seller_message']}'>{$refund_info['seller_message']}</i>";
            $list['admin_message'] = "<span title='{$refund_info['admin_message']}'>{$refund_info['admin_message']}</span>";
            $list['seller_times'] = !empty($refund_info['seller_time']) ? date('Y-m-d H:i:s',$refund_info['seller_time']) : '';
            if ($refund_info['goods_image'] != '') {
                $list['goods_image'] = "<a href='".cthumb($refund_info['goods_image'],360)."' target='_blank' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".cthumb($refund_info['goods_image'],240).">\")'><i class='fa fa-picture-o'></i></a> ";
            } else {
                $list['goods_image'] = '';
            }
            $list['goods_id'] = !empty($refund_info['goods_id']) ? $refund_info['goods_id'] : '';
            $list['order_sn'] = $refund_info['order_sn'];
            $list['buyer_name'] = $refund_info['buyer_name'];
            $list['buyer_id'] = $refund_info['buyer_id'];
            $list['store_name'] = $refund_info['store_name'];
            $list['store_id'] = $refund_info['store_id'];
            $data['list'][$refund_info['refund_id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    /**
     * 退款处理页
     * 临时改需求，将就用 2017年12月13日10:57:05
     */
    public function editOp() {
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['refund_id'] = intval($_GET['refund_id']);
        $refund = $model_refund->getRefundReturnInfo($condition);
        $order_id = $refund['order_id'];
        $model_order = Model('order');
        $order = $model_order->getOrderInfo(array('order_id'=> $order_id),array());
        if ($order['payment_time'] > 0) {
            $order['pay_amount'] = $order['order_amount']-$order['rcb_amount']-$order['pd_amount'];//在线支付金额=订单总价格-充值卡支付金额-预存款支付金额
        }
        Tpl::output('order',$order);
        $detail_array = $model_refund->getDetailInfo($condition);
        if(empty($detail_array)) {
            $model_refund->addDetail($refund,$order);
            $detail_array = $model_refund->getDetailInfo($condition);
        }
        Tpl::output('detail_array',$detail_array);
        if (chksubmit()) {
            /*if ($refund['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
                showMessage(Language::get('nc_common_save_fail'));
            }*/

            $deleteRefund = isset($_REQUEST['delete_refund'])?$_REQUEST['delete_refund']:0;
            if($deleteRefund==1){
                $delete=Model()->table('refund_return')->where(array('refund_id'=>$condition['refund_id']))->delete();
                if($delete){
                    $model_order->where(['order_id'=>$order_id])->update(['lock_state'=>0]);
                    showMessage('操作成功','index.php?controller=refund&action=index');
                    die;
                }
            }

            if (!in_array($refund['refund_state'],[2,5,6])) {//检查状态,防止页面刷新不及时造成数据错误
                showMessage('当前状态不可提交');
            }

            if ($detail_array['pay_time'] > 0) {
                $refund['pay_amount'] = $detail_array['pay_amount'];//已完成在线退款金额
            }
            // 如果买家选择了补单退货/退款,那么将该退款/退货订单退款状态改为4.开始补单，如果选择了补单退货/退款，那么只有5.补单完成之后才可以退款/退货
            if(in_array($refund['refund_type'],[1,2]) &&  in_array($refund['refund_state'],[2]) ){
                $refund_array['refund_state'] = 4;//状态:1为处理中,2为待管理员处理,3为已完成
                $model_refund->editRefundReturn($condition, $refund_array);
                unset($refund_array);
                showMessage(Language::get('nc_common_save_succ'));die;
            }
            // 如果是补单退款，且状态为6才可以执行下面的操作
            // 如果是不补单退款，状态为2才可以执行下面的操作

            $new_refund = $model_refund->getRefundReturnInfo($condition);
            $is_rollback = 0;
            if((in_array($new_refund['refund_type'],[1,2])) && ($new_refund['refund_state'] == 5) ){
                $is_rollback = 1;
            }else if((in_array($new_refund['refund_type'],[1,2])) && ($new_refund['refund_state'] == 6)){
                $is_rollback = 2;
            }else if((in_array($new_refund['refund_type'],[3,4])) && ($new_refund['refund_state'] == 2)){
                $is_rollback = 3;
            }
            $refund_return_bd_log_model = Model('refund_return_bd_log');
            $order_goods_model = Model('order_goods');
            $user_bonus_pool_model = Model('user_bonus_pool');
            $user_bonus_log_model = Model('user_bonus_log');
            if($is_rollback > 0){
                // 补单退款的时候需要获取原订单的利润与现订单利润之差
                // 如果跟当前订单有关的所有补单都已经完成了，那么将多余的利润加入到分红池中
                if($is_rollback == 1){ // 当前状态是5.补单完成待确认，需要将当前状态改为6.已确认补单完成
                    // 能来到这一步的都是补单已经完成的订单
                    // 获取当前退货/退款订单的补单订单id
                    $order_arr_where['refund_id'] = $new_refund['refund_id'];
                    $order_arr_where['status'] = 2;
                    $order_arr = $refund_return_bd_log_model->where($order_arr_where)->select();
                    if(empty($order_arr)){
                        showMessage('信息异常，请刷新后再试');
                    }
                    $model_refund->editRefundReturn($condition, ['refund_state'=>6]);
                    showMessage(Language::get('nc_common_save_succ'));die;
                }elseif ($is_rollback == 2){  // 当前状态是6.已确认补单完成，需要将当前状态改为3.已完成补单
                    Db::beginTransaction();
                    $order_arr_where['refund_id'] = $new_refund['refund_id'];
                    $order_arr_where['status'] = 2;
                    $order_arr = $refund_return_bd_log_model->where($order_arr_where)->select();
                    $order_id_arr = array_column($order_arr,'order_id');
                    // 获取这些订单id补了哪些订单，是否有状态为1（未完成补单）的退货/退款订单，如果没有，那么开始回滚操作，如果有，则直接跳过
                    $not_success_count = $refund_return_bd_log_model->where(['order_id'=>['in',$order_id_arr],'status'=>1])->count();
                    if($not_success_count > 0){
                        showMessage('当前退货/退款订单的补单订单还有其他退货/退款订单未完成，全部完成后才可以执行当前操作');die;
                        // 本次操作结束
                    }
                    $is_success_list = $refund_return_bd_log_model->where(['order_id'=>['in',$order_id_arr],'status'=>2])->select();
                    // 将所有补单订单对应的补单成功的退货/退款订单都改为已确认补单完成
                    $refund_id_arr = array_column($is_success_list,'refund_id');

                    $update_arr['admin_time'] = time();
                    $update_arr['refund_state'] = 3;//状态:1为处理中,2为待管理员处理,3为已完成
                    $update_arr['admin_message'] = $_POST['admin_message'];
                    $model_refund->where(['refund_id'=>['in',$refund_id_arr]])->update($update_arr);
                    $refund_return_list = $model_refund->where(['refund_id'=>['in',$refund_id_arr]])->select();
                    // 获取这些订单id补的订单产生的利润
                    // 获取要补的订单产生的总利润
                    $goods_after_tax_profit_log_model = Model('goods_after_tax_profit_log');
                    unset($order_id_arr);
                    $order_id_arr = array_column($refund_return_list,'order_id');
                    $goods_id_arr = array_column($refund_return_list,'goods_id');
                    $goods_after_tax_profit_log_where['order_id'] = ['in',$order_id_arr];
                    $goods_after_tax_profit_log_where['goods_id'] = ['in',$goods_id_arr];
                    $money_list = $goods_after_tax_profit_log_model->where($goods_after_tax_profit_log_where)->select();
                    if(empty($money_list)){
                        showMessage('补单信息错误');die;
                    }
                    // 按订单号将利润信息分开
                    $money_arr = [];    // 每个退货/退款订单对应的需要产生的利润
                    foreach ($refund_return_list as $value){
                        foreach ($money_list as $money_info){
                            if(($money_info['order_id'] == $value['order_id']) && ($money_info['goods_id'] == $value['goods_id'])){
                                $money_arr[$value['refund_id']] = $money_info['money'];
                            }
                        }
                    }
                    if(empty($money_arr)){
                        showMessage('当前没有需要补单的订单');die;
                    }
                    // 要补的订单产生的税后总利润
                    $total_money = array_sum($money_arr);
                    // 获取补单订单产生的总利润
                    // 根据订单id获取这些订单下的所有商品信息

                    $order_goods_list = $order_goods_model->where(['order_id'=>['in',$order_id_arr]])->select();
                    // 获取这些订单的供应商id
                    $store_id_arr = array_column($order_goods_list,'store_id');
                    $setting_model = Model('setting');
                    $set_field_arr = $setting_model->where(['name'=>['in',['annual_fee_gc_id','USER_CONSUMPTION_BONUS_RATIO','PLATFORM_TAX_RATE']]])->select();
                    $set_field_arr_for_name = array_combine(array_column($set_field_arr,'name'),array_column($set_field_arr,'value'));
                    // 获取平台税率
                    $tax_rate = $set_field_arr_for_name['PLATFORM_TAX_RATE'];


                    // 每个商品对应产生的税后利润
                    $new_goods_profit_arr = [];
                    /** 获取每个供应商对应的订单 **/
                    $store_id_and_order_id_arr = [];
                    foreach ($order_goods_list as $new_goods_info){
                        $this_goods_profit = $new_goods_info['goods_pay_price'];
                        $this_goods_tax = bcdiv(bcmul($this_goods_profit,$tax_rate,2),100,2);
                        $new_goods_profit_arr[] = bcsub($this_goods_profit,$this_goods_tax);
                        $store_id_and_order_id_arr[$new_goods_info['store_id']][] = $new_goods_info['order_id'];
                    }
                    // 当前订单可产生的税后利润
                    $new_goods_total_money = array_sum($new_goods_profit_arr);
                    // 获取两者的差，将该利润放入资金池
                    $diff_money = bcsub($new_goods_total_money,$total_money,2);
                    // 开始回滚操作
                    // 如果是补单退款退货，那么只需要抽回原供应商相关金钱即可（供应商的供货款，供应商推荐奖）
                    // 根据供应商id获取供应商对应的会员id（member_id）
                    $store_model = Model('store');
                    $store_member_id_arr = $store_model->where(['store_id'=>['in',$store_id_arr]])->field('store_id,member_id')->select();
                    /** 供应商store_id对应的member_id **/
                    $store_id_and_member_id = array_combine(array_column($store_member_id_arr,'store_id'),array_column($store_member_id_arr,'member_id'));
                    // 获取这些用户
                    // 获取这些order_id对应goods_id产生的供货款

                    $user_bonus_log_order_id_arr = array_column($refund_return_list,'order_id');
                    $user_bonus_log_goods_id_arr = array_column($refund_return_list,'goods_id');
                    $user_bonus_log_where['order_id'] = ['in',$user_bonus_log_order_id_arr];
                    $user_bonus_log_where['goods_id'] = ['in',$user_bonus_log_goods_id_arr];
                    $user_bonus_log_where['type'] = $user_bonus_log_model::TYPE_SUPPLY_MONEY;
                    $user_bonus_log_arr = $user_bonus_log_model->where($user_bonus_log_where)->select();
                    // 按订单号将利润信息分开
                    /** 每个订单对应的供货款 **/
                    $user_bonus_log_money_arr = [];    // 每个退货/退款订单对应的产生的供应商的供货款
                    foreach ($refund_return_list as $value){
                        foreach ($user_bonus_log_arr as $user_bonus_log_money_info){
                            if(($user_bonus_log_money_info['order_id'] == $value['order_id']) && ($user_bonus_log_money_info['goods_id'] == $value['goods_id'])){
                                // [订单id][] = 产生的供货款
                                $user_bonus_log_money_arr[$value['order_id']][] = $user_bonus_log_money_info['money'];
                            }
                        }
                    }

                    if(empty($user_bonus_log_money_arr)){
//                        showMessage('数据异常');die;
                    }
                    // 获取这些order_id对应goods_id产生的供应商推荐奖

                    $user_bonus_pool_order_id_arr = array_column($refund_return_list,'order_id');
                    $user_bonus_pool_goods_id_arr = array_column($refund_return_list,'goods_id');
                    $user_bonus_pool_where['order_id'] = ['in',$user_bonus_pool_order_id_arr];
                    $user_bonus_pool_where['goods_id'] = ['in',$user_bonus_pool_goods_id_arr];
                    $user_bonus_pool_where['type'] = $user_bonus_log_model::TYPE_SUPPLIER_REFERRAL_BONUS;
                    $user_bonus_pool_arr = $user_bonus_pool_model->where($user_bonus_pool_where)->select();
                    // 按订单号将利润信息分开
                    /** 每个推荐供应商的用户对应的获得的供应商推荐奖 **/
                    $user_bonus_pool_money_arr = [];    // 每个退货/退款订单对应的产生的应商推荐奖
                    $change_bonus_status_id = []; // 资金池中需要改为不可使用的资金id
                    foreach ($refund_return_list as $value){
                        foreach ($user_bonus_pool_arr as $user_bonus_pool_money_info){
                            if(($user_bonus_pool_money_info['order_id'] == $value['order_id']) && ($user_bonus_pool_money_info['goods_id'] == $value['goods_id'])){
                                // [推荐供应商的用户] = [获得的供应商推荐奖]
                                $user_bonus_pool_money_arr[$user_bonus_pool_money_info['to_user_id']][] = $user_bonus_pool_money_info['money'];
                                $change_bonus_status_id[] = $user_bonus_pool_money_info['id'];
                            }
                        }
                    }
                    if(empty($user_bonus_pool_money_arr)){
                        showMessage('数据异常');die;
                    }

                    // 根据供应商对应的订单获取订单对应的供货款
                    $store_id_and_money = [];
                    foreach ($store_id_and_order_id_arr as $store_id => $order_id){
                        if(empty($user_bonus_log_money_arr)){
                            $this_order_id_money = 0;
                        }else{
                            $this_order_bonus_arr = isset($user_bonus_log_money_arr[$order_id]) ? $user_bonus_log_money_arr[$order_id] : [];
                            $this_order_id_money = array_sum($this_order_bonus_arr);
                        }
                        $store_id_and_money[$store_id] = $this_order_id_money;
                        unset($this_order_bonus_arr);
                        unset($this_order_id_money);
                    }
                    // 获取store_id对应的member_id todo 2017年12月12日18:51:54任务
                    $store_member_id_and_money = [];    // 回滚供货款
                    $store_member_id_and_money_log = [];    // 回滚供货款日志
                    foreach ($store_id_and_money as $store_id => $money){
                        $this_store_member_id = $store_id_and_member_id[$store_id];
                        $store_member_id_and_money[$this_store_member_id] = $money;
                        $store_member_id_and_money_log[$this_store_member_id]['lg_member_id'] = $this_store_member_id;    // 用户id
                        $store_member_id_and_money_log[$this_store_member_id]['lg_type'] = 'rollback_type_supply_money';            // 类型
                        $store_member_id_and_money_log[$this_store_member_id]['lg_freeze_amount'] = $money;  // 金额
                        $store_member_id_and_money_log[$this_store_member_id]['lg_add_time'] = time();                // 添加时间
                        $store_member_id_and_money_log[$this_store_member_id]['lg_desc'] = '买家退款/退货订单处理成功，收回供货款：'.$money;
                    }

                    // 获取member_id对应的供应商推荐奖 todo 2017年12月12日18:51:54任务
                    $this_to_user_id_money_arr = [];    // 回滚供应商推荐奖
                    $this_to_user_id_money_log = [];    // 回滚供应商推荐奖日志
                    foreach ($user_bonus_pool_money_arr as $to_user_id => $money){
                        $this_to_user_id_money = array_sum($money);
                        $this_to_user_id_money_arr[$to_user_id] = $this_to_user_id_money;
                        $this_to_user_id_money_log[$to_user_id]['lg_member_id'] = $to_user_id;    // 用户id
                        $this_to_user_id_money_log[$to_user_id]['lg_type'] = 'rollback_type_supplier_referral_bonus';            // 类型
                        $this_to_user_id_money_log[$to_user_id]['lg_freeze_amount'] = $this_to_user_id_money;  // 金额
                        $this_to_user_id_money_log[$to_user_id]['lg_add_time'] = time();                // 添加时间
                        $this_to_user_id_money_log[$to_user_id]['lg_desc'] = '供应商有退款/退货订单处理成功，收回供应商推荐奖：'.$this_to_user_id_money;
                    }

                    // 预存款变更日志
                    $pd_model = Model('predeposit');
                    if(!empty($this_to_user_id_money_log)){
//                        $pd_model->insertAll(array_values($this_to_user_id_money_log));
                    }
                    if(!empty($store_member_id_and_money_log)){
//                        $pd_model->insertAll(array_values($store_member_id_and_money_log));
                    }
                    // 将奖金池中相关的供应商推荐奖状态设为2.不可用
                    $user_bonus_pool_model->where(['id'=>['in'=>$change_bonus_status_id]])->update(['status'=>2]);
                    unset($sql);
                    // 将需要加入资金池的利润加入资金池
                    if($diff_money > 0){
                        // 检查本日，本周，本月是否已经统计过数据
                        $platform_residual_dividend_profit_model = Model('platform_residual_dividend_profit');
                        $platform_residual_dividend_profit_model->checkLogUpdate($diff_money);
                    }
                    // 发送买家消息
                    foreach ($refund_return_list as $refund_info){
                        $state = $model_refund->editOrderRefund($refund_info,$this->admin_info['name']);

                        $param['code'] = 'refund_return_notice';
                        $param['member_id'] = $refund_info['buyer_id'];
                        $param['param'] = array(
                            'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund_info['refund_id'])),
                            'refund_sn' => $refund_info['refund_sn']
                        );
                        QueueClient::push('sendMemberMsg', $param);
                        $this->log('退款确认，退款编号'.$refund_info['refund_sn']);
                        unset($param);
                    }
                    Db::commit();
                    showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=index');
                }elseif($is_rollback == 3){
                    // 如果是不补单的退款/退货
                    // 检查要退款/退货的订单时普通订单还是海豚主场的订单
                    $order_id = $refund['order_id'];
                    $order_goods_id = $refund['order_goods_id'];    // 如果是0 则为整个订单退款，不为0 则是订单中的部分商品退款
                    $order_goods_info_where['order_id'] = $order_id;
                    if($order_goods_id > 0){
                        $order_goods_info_where['goods_id'] = $order_goods_id;
                    }
                    $order_goods_info_list = $order_goods_model->where($order_goods_info_where)->select();
                    $ht_order_goods_list = [];              // 升级商品订单
                    $other_order_goods_list = [];           // 非升级商品订单
                    $this_order_goods_pay_price = [];
                    foreach ($order_goods_info_list as $ht_value) {
                        // 将升级商品订单和非升级商品订单分开
                        if ($ht_value['is_deduction'] == 1) {
                            $ht_order_goods_list[$ht_value['rec_id']] = $ht_value;
                        } else {
                            $other_order_goods_list[$ht_value['rec_id']] = $ht_value;
                        }
                        // 获取所有商品产生的总金额
                        $this_order_goods_pay_price[] = $ht_value['goods_pay_price'];
                    }
                    // 分别将海豚主场的积分和其他消费的积分加给用户
                    // 计算海豚主场消费金额
                    $ht_total_money = array_column($ht_order_goods_list,'goods_pay_price');
                    // 计算非海豚主场消费金额
                    $other_total_money = array_column($other_order_goods_list,'goods_pay_price');
                    // 计算可获得的海豚主场积分
                    $hs_count = array_sum($ht_total_money);
                    // 计算可获得的非海豚主场积分
                    $h_count = array_sum($other_total_money);
                    // 检查用户积分是否够回滚（普通积分和海豚主场的积分分别计算）
                    $buyer_id = $refund['buyer_id'];
                    $member_model = Model('member');
                    $check_user_points_where['member_id'] = $buyer_id;
                    $check_user_points_where['member_points'] = ['EGT',$hs_count];
                    $check_user_points_where['member_h_points'] = ['EGT',$h_count];
                    $check_user_points =$member_model->where($check_user_points_where)->find();
                    if(empty($check_user_points)){
                        showMessage('用户积分不足，无法退款/退货');die;
                    }
                    // 获取这个商品产生的总利润
                    // 获取这个商品可以计算的已分出去的钱（个人消费分红，团队共享分红，供货款，税，微店分红，供应商推荐奖,平台提成）
                    $update_where['order_id'] = $refund['order_id'];
                    $update_where['goods_id'] = $refund['goods_id'];
                    $update_where['type'] = ['in',[12]];
                    // 团队共享分红,供应商推荐奖(只改状态，不扣)
                    $user_bonus_pool_model->where($update_where)->update(['status'=>2]);
                    $where['order_id'] = $refund['order_id'];
                    $where['goods_id'] = $refund['goods_id'];
                    $where['type'] = ['in',[18]];
                    $array_one_list = $user_bonus_pool_model->where($where)->select();
                    $array_one = [];
                    foreach ($array_one_list as $array_one_info){
                        $array_one[] = ['money'=>$array_one_info['money'],'user_id'=>$array_one_info['to_user_id']];
                    }

                    $user_bonus_log_where['order_id'] = $refund['order_id'];
                    $user_bonus_log_where['goods_id'] = $refund['goods_id'];
                    $platform_profit_where['type'] = ['in',[17]];
                    // 个人消费分红、供货款、微店分红
                    $array_two = [];
                    $array_two_list = $user_bonus_log_model->where($user_bonus_log_where)->select();
                    foreach ($array_two_list as $array_two_info){
                        $array_two[] = ['money'=>$array_two_info['money'],'user_id'=>$array_two_info['user_id']];
                    }
                    // 税、平台提成
                    $platform_profit_model = Model('platform_profit');
                    $platform_profit_where['order_id'] = $refund['order_id'];
                    $platform_profit_where['goods_id'] = $refund['goods_id'];
                    $platform_profit_where['type'] = ['in',[1,5]];
                    $total_money_info = $platform_profit_model->where($platform_profit_where)->field('sum(money) as total_money')->find();
                    $system_total_money = $total_money_info['total_money'];
                    // 检查资金池中是否够补损
                    $array_three = array_merge($array_one,$array_two);
                    $array_four = [];
                    foreach ($array_three as $array_money_user_id){
                        $array_four[$array_money_user_id['user_id']][] =$array_money_user_id['money'];
                    }
                    // 每个会员对应的要收回的金额
                    $array_five = [];
                    foreach ($array_four as $array_four_user_id=>$array_four_user_money_arr){
                        $array_five[$array_four_user_id] = array_sum($array_four_user_money_arr);
                    }
                    // 可回滚的总金额 = 可回滚的分红 + 平台提成 + 税
                    $total_rollback_money = bcadd(array_sum($array_five),$system_total_money);

                    // 当前退款/退货订单总金额
                    $total_goods_pay_price = array_sum($this_order_goods_pay_price);
                    // 损失的金额
                    $lost_money = bcsub($total_goods_pay_price,$total_rollback_money);
                    // 资金池金额此处为上个月的剩余资金
                    $user_bonus_logic = Logic('user_bonus');
                    // 获取今天所在日期的上月开始结束时间
                    $month_date = [$user_bonus_logic->getLastMonthBeginDate(),$user_bonus_logic->getLastMonthEndDate()];

                    $platform_profit_log_model = new platform_residual_dividend_profitModel();
                    $last_month_money_info = $platform_profit_log_model->where(['created_at' => ['between', $month_date],'cycle'=>$platform_profit_log_model::UPDATE_FOR_MONTHLY])->find();
                    $last_month_money = $last_month_money_info['money'];
                    if($last_month_money < $lost_money){
                        showMessage('资金池余额不足，无法退款/退货');die;
                    }
                    // 补损（抽取资金池中的余额）
                    $platform_profit_log_model->deductSurplusProfit($lost_money, 30);
                    $dec_sql = $this->getUpdateUserBalanceSQL($array_five);
                    Db::execute($dec_sql);


                    $state = $model_refund->editOrderRefund($refund,$this->admin_info['name']);
                    if ($state) {
                        $refund_array = array();
                        $refund_array['admin_time'] = time();
                        $refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
                        $refund_array['admin_message'] = $_POST['admin_message'];
                        $model_refund->editRefundReturn($condition, $refund_array);

                        // 发送买家消息
                        $param = array();
                        $param['code'] = 'refund_return_notice';
                        $param['member_id'] = $refund['buyer_id'];
                        $param['param'] = array(
                            'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                            'refund_sn' => $refund['refund_sn']
                        );
                        QueueClient::push('sendMemberMsg', $param);

                        $this->log('退款确认，退款编号'.$refund['refund_sn']);
                        showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=index');
                    } else {
                        showMessage(Language::get('nc_common_save_fail'));
                    }
                }
            }
            showMessage(Language::get('nc_common_save_fail'));
            /*if(in_array($refund['refund_type'],[1,2])){}else{
                // 如果买家没有选择补单退货/退款，那么该订单产生的所有分红，积分，贡献值，等级，职级都需要回滚 TODO 2017年12月8日17:42:14
                $state = $model_refund->editOrderRefund($refund,$this->admin_info['name']);
                if ($state) {
                    $refund_array = array();
                    $refund_array['admin_time'] = time();
                    $refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
                    $refund_array['admin_message'] = $_POST['admin_message'];
                    $model_refund->editRefundReturn($condition, $refund_array);

                    // 发送买家消息
                    $param = array();
                    $param['code'] = 'refund_return_notice';
                    $param['member_id'] = $refund['buyer_id'];
                    $param['param'] = array(
                        'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                        'refund_sn' => $refund['refund_sn']
                    );
                    QueueClient::push('sendMemberMsg', $param);

                    $this->log('退款确认，退款编号'.$refund['refund_sn']);
                    showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=index');
                } else {
                    showMessage(Language::get('nc_common_save_fail'));
                }

            }*/
        }
        Tpl::output('refund',$refund);
        $info['buyer'] = array();
        if(!empty($refund['pic_info'])) {
            $info = unserialize($refund['pic_info']);
        }


        $refund_return_info = $model_refund->getButtonAndMessageForType($refund['refund_type'],$refund['refund_state']);
        // 获取退货退款类型
        $refund_return_type = $model_refund->getRefundReturnTypeInfo($refund['refund_type']);
        Tpl::output('refund_return_type',$refund_return_type);
        Tpl::output('refund_return_info',$refund_return_info);
        Tpl::output('pic_list',$info['buyer']);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund.edit');
    }

    // 根据每个用户需要更新的金额组合成一条sql
    public function getUpdateUserBalanceSQL($user_update_balance_arr,$table_name = 'member',$field = 'freeze_predeposit',$case_field='member_id'){
        $sql = 'UPDATE '.$table_name.' SET '.$field.' = CASE '.$case_field;
        foreach ($user_update_balance_arr as $key=>$value){
            if($value > 0){
                $sql .= ' WHEN '.$key.' THEN '.$field.'-'.$value;
            }
        }
        $sql .= ' else '.$field.' END';
//        $sql .= ' END';
        return $sql;
    }

    // 根据分红日志数组组合预存款变更日志数组
    public function getPdLogDataArr($new_user_bonus_log_data){
        $user_bonus_log_model = Model('user_bonus_log');
        $type_arr = $user_bonus_log_model->getTypeInfo();
        $data = [];
        foreach ($new_user_bonus_log_data as $key=>$value){
            $data[$key]['lg_member_id'] = $value['user_id'];    // 用户id
            $data[$key]['lg_type'] = $value['type'];            // 类型
            $data[$key]['lg_freeze_amount'] = $value['money'];  // 金额
            $data[$key]['lg_add_time'] = time();                // 添加时间
            $data[$key]['lg_desc'] = $type_arr[$value['type']].'（订单号：'.$value['order_sn'].'）'; // 描述
        }
        return $data;
    }

    /**
     * 退款处理页
     *
     */
    public function editOp备份() {
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['refund_id'] = intval($_GET['refund_id']);
        $refund = $model_refund->getRefundReturnInfo($condition);
        $order_id = $refund['order_id'];
        $model_order = Model('order');
        $order = $model_order->getOrderInfo(array('order_id'=> $order_id),array());
        if ($order['payment_time'] > 0) {
            $order['pay_amount'] = $order['order_amount']-$order['rcb_amount']-$order['pd_amount'];//在线支付金额=订单总价格-充值卡支付金额-预存款支付金额
        }
        Tpl::output('order',$order);
        $detail_array = $model_refund->getDetailInfo($condition);
        if(empty($detail_array)) {
            $model_refund->addDetail($refund,$order);
            $detail_array = $model_refund->getDetailInfo($condition);
        }
        Tpl::output('detail_array',$detail_array);
        if (chksubmit()) {
            /*if ($refund['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
                showMessage(Language::get('nc_common_save_fail'));
            }*/
            if (!in_array($refund['refund_state'],[2,5,6])) {//检查状态,防止页面刷新不及时造成数据错误
                showMessage('当前状态不可提交');
            }
            
            if ($detail_array['pay_time'] > 0) {
                $refund['pay_amount'] = $detail_array['pay_amount'];//已完成在线退款金额
            }
            // 如果买家选择了补单退货/退款,那么将该退款/退货订单退款状态改为4.开始补单，如果选择了补单退货/退款，那么只有5.补单完成之后才可以退款/退货
            if(in_array($refund['refund_type'],[1,2])){
                $refund_array['refund_state'] = 4;//状态:1为处理中,2为待管理员处理,3为已完成
                if($refund['refund_state'] == 5){
                    $refund_array['refund_state'] = 6;//状态:1为处理中,2为待管理员处理,3为已完成
                }
                $model_refund->editRefundReturn($condition, $refund_array);
                unset($refund_array);
                showMessage(Language::get('nc_common_save_succ'));
            }else{
                // 如果买家没有选择补单退货/退款，那么该订单产生的所有分红，积分，贡献值，等级，职级都需要回滚 TODO 2017年12月8日17:42:14
                $state = $model_refund->editOrderRefund($refund,$this->admin_info['name']);
                if ($state) {
                    $refund_array = array();
                    $refund_array['admin_time'] = time();
                    $refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
                    $refund_array['admin_message'] = $_POST['admin_message'];
                    $model_refund->editRefundReturn($condition, $refund_array);

                    // 发送买家消息
                    $param = array();
                    $param['code'] = 'refund_return_notice';
                    $param['member_id'] = $refund['buyer_id'];
                    $param['param'] = array(
                        'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                        'refund_sn' => $refund['refund_sn']
                    );
                    QueueClient::push('sendMemberMsg', $param);

                    $this->log('退款确认，退款编号'.$refund['refund_sn']);
                    showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=index');
                } else {
                    showMessage(Language::get('nc_common_save_fail'));
                }

            }
        }
        Tpl::output('refund',$refund);
        $info['buyer'] = array();
        if(!empty($refund['pic_info'])) {
            $info = unserialize($refund['pic_info']);
        }


        $refund_return_info = $model_refund->getButtonAndMessageForType($refund['refund_type'],$refund['refund_state']);
        // 获取退货退款类型
        $refund_return_type = $model_refund->getRefundReturnTypeInfo($refund['refund_type']);
        Tpl::output('refund_return_type',$refund_return_type);
        Tpl::output('refund_return_info',$refund_return_info);
        Tpl::output('pic_list',$info['buyer']);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund.edit');
    }

    /**
     * 退款记录查看页
     *
     */
    public function viewOp() {
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['refund_id'] = intval($_GET['refund_id']);
        $refund = $model_refund->getRefundReturnInfo($condition);
        Tpl::output('refund',$refund);
        $info['buyer'] = array();
        if(!empty($refund['pic_info'])) {
            $info = unserialize($refund['pic_info']);
        }
        Tpl::output('pic_list',$info['buyer']);
        $detail_array = $model_refund->getDetailInfo($condition);
        Tpl::output('detail_array',$detail_array);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund.view');
    }

    /**
     * 退款退货原因
     */
    public function reasonOp() {
        $model_refund = Model('refund_return');
        $condition = array();

        $reason_list = $model_refund->getReasonList($condition,200);
        Tpl::output('reason_list',$reason_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

        Tpl::showpage('refund_reason.list');
    }

    /**
     * 新增退款退货原因
     *
     */
    public function add_reasonOp() {
        $model_refund = Model('refund_return');
        if (chksubmit()) {
            $reason_array = array();
            $reason_array['reason_info'] = $_POST['reason_info'];
            $reason_array['sort'] = intval($_POST['sort']);
            $reason_array['update_time'] = time();

            $state = $model_refund->addReason($reason_array);
            if ($state) {
                $this->log('新增退款退货原因，编号'.$state);
                showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=reason');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund_reason.add');
    }

    /**
     * 编辑退款退货原因
     *
     */
    public function edit_reasonOp() {
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['reason_id'] = intval($_GET['reason_id']);
        $reason_list = $model_refund->getReasonList($condition);
        $reason = $reason_list[$condition['reason_id']];
        if (chksubmit()) {
            $reason_array = array();
            $reason_array['reason_info'] = $_POST['reason_info'];
            $reason_array['sort'] = intval($_POST['sort']);
            $reason_array['update_time'] = time();
            $state = $model_refund->editReason($condition, $reason_array);
            if ($state) {
                $this->log('编辑退款退货原因，编号'.$condition['reason_id']);
                showMessage(Language::get('nc_common_save_succ'),'index.php?controller=refund&action=reason');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::output('reason',$reason);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('refund_reason.edit');
    }

    /**
     * 删除退款退货原因
     *
     */
    public function del_reasonOp() {
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['reason_id'] = intval($_GET['reason_id']);
        $state = $model_refund->delReason($condition);
        if ($state) {
            $this->log('删除退款退货原因，编号'.$condition['reason_id']);
            showMessage(Language::get('nc_common_del_succ'),'index.php?controller=refund&action=reason');
        } else {
            showMessage(Language::get('nc_common_del_fail'));
        }
    }

    /**
     * 封装共有查询代码
     */
    private function _get_condition($condition) {
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('order_sn','store_name','buyer_name','goods_name','refund_sn'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
        if ($_GET['keyword'] != '' && in_array($_GET['keyword_type'],array('order_sn','store_name','buyer_name','goods_name','refund_sn'))) {
            if ($_GET['jq_query']) {
                $condition[$_GET['keyword_type']] = $_GET['keyword'];
            } else {
                $condition[$_GET['keyword_type']] = array('like',"%{$_GET['keyword']}%");
            }
        }
        if (!in_array($_GET['qtype_time'],array('add_time','seller_time','admin_time'))) {
            $_GET['qtype_time'] = null;
        }
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date']): null;
        if ($_GET['qtype_time'] && ($start_unixtime || $end_unixtime)) {
            $condition[$_GET['qtype_time']] = array('time',array($start_unixtime,$end_unixtime));
        }
        if (floatval($_GET['query_start_amount']) > 0 && floatval($_GET['query_end_amount']) > 0) {
            $condition['refund_amount'] = array('between',floatval($_GET['query_start_amount']).','.floatval($_GET['query_end_amount']));
        }
        if ($_GET['refund_state'] == 2) {
            $condition['refund_state'] = 2;
        }
        $sort_fields = array('buyer_name','store_name','goods_id','refund_id','seller_time','refund_amount','buyer_id','store_id');
        if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        }
        return array($condition,$order);
    }

    /**
     * csv导出
     */
    public function export_step1Op() {
        $model_refund = Model('refund_return');
        $condition = array();
        if (preg_match('/^[\d,]+$/', $_GET['refund_id'])) {
            $_GET['refund_id'] = explode(',',trim($_GET['refund_id'],','));
            $condition['refund_id'] = array('in',$_GET['refund_id']);
        }
        list($condition,$order) = $this->_get_condition($condition);
        if (!is_numeric($_GET['curpage'])){
            $count = $model_refund->getRefundCount($condition);
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $array = array();
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','javascript:history.back(-1)');
                Tpl::showpage('export.excel');
                exit();
            }
            $limit = false;
        } else {
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $limit = $limit1 .','. $limit2;
        }
        $refund_list = $model_refund->getRefundList($condition,'',$order,$limit);
        $this->createCsv($refund_list);
    }

    /**
     * 生成csv文件
     */
    private function createCsv($refund_list) {
        $model_refund = Model('refund_return');
        $list = array();
        $pic_base_url = UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/';
        foreach ($refund_list as $k => $refund_info) {
            $list[$k]['refund_sn'] = $refund_info['refund_sn'];
            $list[$k]['refund_amount'] = ncPriceFormat($refund_info['refund_amount']);
            if(!empty($refund_info['pic_info'])) {
                $info = unserialize($refund_info['pic_info']);
                if (is_array($info) && !empty($info['buyer'])) {
                    foreach($info['buyer'] as $pic_name) {
                        $list[$k]['pic_info'] .= $pic_base_url.$pic_name.'|';
                    }
                    $list[$k]['pic_info'] = trim($list[$k]['pic_info'],'|');
                }
            }
            if (empty($list[$k]['pic_info'])) $list[$k]['pic_info'] = '';
            $list[$k]['buyer_message'] = $refund_info['buyer_message'];
            $list[$k]['add_times'] = date('Y-m-d H:i:s',$refund_info['add_time']);
            $list[$k]['goods_name'] = $refund_info['goods_name'];
            $state_array = $model_refund->getRefundStateArray('seller');
            $list[$k]['seller_state'] = $state_array[$refund_info['seller_state']];
            $admin_array = $model_refund->getRefundStateArray('admin');
            $list[$k]['refund_state'] = $refund_info['seller_state'] == 2 ? $admin_array[$refund_info['refund_state']]:'';
            $list[$k]['seller_message'] = $refund_info['seller_message'];
            $list[$k]['admin_message'] = $refund_info['admin_message'];
            $list[$k]['seller_times'] = !empty($refund_info['seller_time']) ? date('Y-m-d H:i:s',$refund_info['seller_time']) : '';
            if ($refund_info['goods_image'] != '') {
                $list[$k]['goods_image'] = cthumb($refund_info['goods_image'],360);
            } else {
                $list[$k]['goods_image'] = '';
            }
            $list[$k]['goods_id'] = !empty($refund_info['goods_id']) ? $refund_info['goods_id'] : '';
            $list[$k]['order_sn'] = $refund_info['order_sn'];
            $list[$k]['buyer_name'] = $refund_info['buyer_name'];
            $list[$k]['buyer_id'] = $refund_info['buyer_id'];
            $list[$k]['store_name'] = $refund_info['store_name'];
            $list[$k]['store_id'] = $refund_info['store_id'];
        }

        $header = array(
                'refund_sn' => '退单编号',
                'refund_amount' => '退款金额',
                'pic_info' => '申请图片',
                'buyer_message' => '申请原因',
                'add_times' => '申请时间',
                'goods_name' => '涉及商品',
                'seller_state' => '商家处理',
                'refund_state' => '平台处理',
                'seller_message' => '商家处理备注',
                'admin_message' => '平台处理备注',
                'seller_times' => '商家申核时间',
                'goods_image' => '商品图',
                'goods_id' => '商品ID',
                'order_sn' => '订单编号',
                'buyer_name' => '买家',
                'buyer_id' => '买家ID',
                'store_name' => '商家名称',
                'store_id'  => '商家ID'
        );
        array_unshift($list, $header);
        
		$csv = new Csv();
	    $export_data = $csv->charset($list,CHARSET,'gbk');
	    $csv->filename = $csv->charset('refund',CHARSET).$_GET['curpage'] . '-'.date('Y-m-d');
	    $csv->export($list);   		
    }
}
