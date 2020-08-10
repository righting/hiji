<?php
/**
 * 会员模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class system_bonus_logModel extends Model
{
    public function __construct()
    {
        parent::__construct('system_bonus_log');
    }

    /**
     * 获得总数量
     *
     * @param $where
     * @return mixed
     */
    public function getCount($where)
    {
        return $this->table('system_bonus_log')->where($where)->count();
    }
}
