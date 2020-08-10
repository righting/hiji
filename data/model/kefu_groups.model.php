<?php
/**
 * 地区模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class kefu_groupsModel extends Model
{

    public function __construct()
    {
        parent::__construct('kefu_groups');
    }

    /**
     * 客服分组列表
     *
     * @param array  $condition
     * @param string $fields
     * @return mixed
     */
    public function getGroupsList($condition = [], $fields = '*')
    {
        return $this->where($condition)->field($fields)->select();
    }

}
