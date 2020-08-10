<?php
/**
 * 消费记录模型管理
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class consumeModel extends Model {
    public function __construct(){
        parent::__construct('consume');
    }

    /**
     * 消费记录列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getConsumeList($condition, $field = '*', $page = 0, $limit = 0) {
        return $this->field($field)->where($condition)->limit($limit)->order('consume_id desc')->page($page)->select();
    }

    /**
     * 添加消费记录
     * @param unknown $insert
     * @return boolean
     */
    public function addConsume($insert) {
        return $this->insert($insert);
    }

    /**
     * 删除消费记录
     * @param array $condition
     * @return boolean
     */
    public function delConsume($condition) {
        return $this->where($condition)->delete();
    }
}
