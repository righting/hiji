<?php
/**
 * 邮件任务队列模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class mail_cronModel extends Model
{
    public function __construct()
    {
        parent::__construct('mail_cron');
    }

    /**
     * 新增商家消息任务计划
     *
     * @param mixed $insert
     * @return mixed
     */
    public function addMailCron($insert)
    {
        return $this->insert($insert);
    }

    /**
     * 查看商家消息任务计划
     *
     * @param mixed  $condition
     * @param int    $limit
     * @param string $order
     * @return mixed
     */
    public function getMailCronList($condition, $limit = 0, $order = 'mail_id asc')
    {
        return $this->where($condition)->limit($limit)->order($order)->select();
    }

    /**
     * 删除商家消息任务计划
     *
     * @param mixed $condition
     * @return mixed
     */
    public function delMailCron($condition)
    {
        return $this->where($condition)->delete();
    }
}
