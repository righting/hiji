<?php
/**
 * 商品F码模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class goods_fcodeModel extends Model {
    public function __construct(){
        parent::__construct('goods_fcode');
    }
    /**
     * 插入数据
     *
     * @param unknown $insert
     * @return boolean
     */
    public function addGoodsFCodeAll($insert) {
        return $this->insertAll($insert);
    }
    /**
     * 取得F码列表
     *
     * @param array $condition
     * @param string $order
     */
    public function getGoodsFCodeList($condition, $order = 'fc_state asc,fc_id asc') {
        return $this->where($condition)->order($order)->select();
    }

    /**
     * 删除F码
     */
    public function delGoodsFCode($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 取得F码
     */
    public function getGoodsFCode($condition) {
        return $this->where($condition)->find();
    }

    /**
     * 更新F码
     */
    public function editGoodsFCode($data, $condition) {
        return $this->where($condition)->update($data);
    }
}
