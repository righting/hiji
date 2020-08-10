<?php
/**
 * 店铺门店库存模型
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class chain_stockModel extends Model
{
    public function __construct()
    {
        parent::__construct('chain_stock');
    }

    /**
     * 门店库存列表
     *
     * @param array  $condition
     * @param string $field
     * @param int    $page
     * @return array
     */
    public function getChainStockList($condition, $field = '*', $page = 0, $order = '', $group = '')
    {
        return $this->field($field)->where($condition)->order($order)->group($group)->page($page)->select();
    }

    /**
     * 门店库存
     *
     * @param array $condition
     * @return array
     */
    public function getChainStockInfo($condition)
    {
        return $this->where($condition)->find();
    }

    /**
     * 添加门店库存
     *
     * @param unknown $insert
     * @return boolean
     */
    public function addChainStock($insert)
    {
        $result = $this->insert($insert, true);
        if ($result) {
            if (intval($insert['stock']) > 0) {
                Model('goods')->editGoodsById(['is_chain' => '1'], $insert['goods_id']);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新门店库存
     *
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editChainStock($update, $condition)
    {
        return $this->where($condition)->update($update);
    }

    /**
     * 删除门店库存
     *
     * @param array $condition
     * @return boolean
     */
    public function delChainStock($condition)
    {
        return $this->where($condition)->delete();
    }
}
