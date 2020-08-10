<?php
/**
 * 手机短信记录
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class sms_logModel extends Model{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 增加短信记录
     *
     * @param
     * @return int
     */
    public function addSms($log_array) {
        $log_id = $this->table('sms_log')->insert($log_array);
        return $log_id;
    }

    /**
     * 查询单条记录
     *
     * @param
     * @return array
     */
    public function getSmsInfo($condition) {
        if (empty($condition)) {
            return false;
        }
        $result = $this->table('sms_log')->where($condition)->order('log_id desc')->find();
        return $result;
    }

    /**
     * 查询记录
     *
     * @param
     * @return array
     */
    public function getSmsList($condition = array(), $page = '', $limit = '', $order = 'log_id desc') {
        $result = $this->table('sms_log')->where($condition)->page($page)->limit($limit)->order($order)->select();
        return $result;
    }
}
