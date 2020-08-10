<?php
/**
 * 通知模板表
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class mail_templatesModel extends Model {

    public function __construct(){
        parent::__construct('mail_msg_temlates');
    }

    /**
     * 取单条信息
     * @param unknown $condition
     * @param string $fields
     */
    public function getTplInfo($condition = array(), $fields = '*') {
        return $this->where($condition)->field($fields)->find();
    }

    /**
     * 模板列表
     *
     * @param array $condition 检索条件
     * @return array 数组形式的返回结果
     */
    public function getTplList($condition = array()){
        return $this->where($condition)->limit(4)->select();
    }

    public function editTpl($data = array(), $condition = array()) {
        return $this->where($condition)->update($data);
    }

}
