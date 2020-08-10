<?php
/**
 * 父类
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class BaseCronControl
{

    public function shutdown()
    {
        exit("success at " . date('Y-m-d H:i:s', TIMESTAMP) . "\n");
    }

    public function __construct()
    {
        register_shutdown_function([$this, "shutdown"]);
    }

    /**
     * 记录日志
     *
     * @param mixed   $content 日志内容
     * @param boolean $if_sql  是否记录SQL
     */
    protected function log($content, $if_sql = true)
    {
        if ($if_sql) {
            $log = Log::read();
            if (!empty($log) && is_array($log)) {
                $content .= end($log);
            }
        }
        Log::record('queue\\' . $content, Log::RUN);
    }

    /**
     * 更新订单中的佣金比例[多个地方调用，写到父类中]
     */
    protected function _order_commis_rate_update()
    {
        //实物订单，每次最多处理50W个商品佣金
        $_break              = false;
        $model_order         = new orderModel();
        $store_bind_class    = new store_bind_classModel();
        $model_refund_return = new refund_returnModel();

        for ($i = 0; $i < 5000; $i++) {
            if ($_break) {
                break;
            }
            $model_order->beginTransaction();
            $limit      = $i * 100 . ',' . '100';
            $goods_list = $model_order->getOrderGoodsList(['commis_rate' => 0], 'rec_id,goods_id,store_id,gc_id', $limit, null, '');
            if (!empty($goods_list)) {
                //$commis_rate_list : store_id => array(gc_id => commis_rate)
                $commis_rate_list = $store_bind_class->getStoreGcidCommisRateList($goods_list);
                //更新订单商品佣金值
                foreach ($goods_list as $v) {
                    //如果未查到店铺或分类ID，则佣金置0
                    if (!isset($commis_rate_list[$v['store_id']][$v['gc_id']])) {
                        $commis_rate = 0;
                    } else {
                        $commis_rate = $commis_rate_list[$v['store_id']][$v['gc_id']];
                    }
                    $update = $model_order->editOrderGoods(['commis_rate' => $commis_rate], ['rec_id' => $v['rec_id']]);
                    if (!$update) {
                        $this->log('更新实物订单商品佣金值失败');
                        $_break = true;
                        break;
                    }
                    $update = $model_refund_return->editRefundReturn(['store_id' => $v['store_id'], 'goods_id' => $v['goods_id']], ['commis_rate' => $commis_rate]);
                    if (!$update) {
                        $this->log('更新实物订单退款佣金值失败');
                        $_break = true;
                        break;
                    }
                }
            } else {
                break;
            }
            $model_order->commit();
        }
        $model_order->commit();

        //虚拟订单，每次最多处理50W个商品佣金
        $_break          = false;
        $model_order     = new vr_orderModel();
        $model_vr_refund = new vr_refundModel();

        for ($i = 0; $i < 5000; $i++) {
            if ($_break) {
                break;
            }
            $model_order->beginTransaction();
            $goods_list = $model_order->getOrderList(['commis_rate' => 200], '', 'order_id,store_id,gc_id', '', 100);
            if (!empty($goods_list)) {
                //$commis_rate_list : store_id => array(gc_id => commis_rate)
                $commis_rate_list = $store_bind_class->getStoreGcidCommisRateList($goods_list);
                //更新订单商品佣金值
                foreach ($goods_list as $v) {
                    //如果未查到店铺或分类ID，则佣金置0
                    if (!isset($commis_rate_list[$v['store_id']][$v['gc_id']])) {
                        $commis_rate = 0;
                    } else {
                        $commis_rate = $commis_rate_list[$v['store_id']][$v['gc_id']];
                    }
                    $update = $model_order->editOrder(['commis_rate' => $commis_rate], ['order_id' => $v['order_id']]);
                    if (!$update) {
                        $this->log('更新虚拟订单商品佣金值失败');
                        $_break = true;
                        break;
                    }
                    $update = $model_order->editOrderCode(['commis_rate' => $commis_rate], ['order_id' => $v['order_id']]);
                    if (!$update) {
                        $this->log('更新虚拟订单兑换码佣金值失败');
                        $_break = true;
                        break;
                    }
                    $update = $model_vr_refund->editRefund(['order_id' => $v['order_id']], ['commis_rate' => $commis_rate]);
                    if (!$update) {
                        $this->log('更新虚拟订单商品退款佣金值失败');
                        $_break = true;
                        break;
                    }
                }
            } else {
                break;
            }
            $model_order->commit();
        }
        $model_order->commit();
    }
}
