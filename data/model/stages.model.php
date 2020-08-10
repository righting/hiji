<?php
/**
 * 分红分期
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stagesModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_bonus_stages');
    }

    /**
     * 获取数据
     *
     * @param string $where
     * @param string $limit
     * @param string $field
     * @param string $order
     * @return null
     */
    public function getUserBonusStagesInfo($where = '', $limit = '', $field = '*', $order = 'id desc')
    {
        return $this->where($where)->field($field)->order($order)->limit($limit)->select();
    }


    /**
     * 创建最新一期的数据
     *
     * @return mixed
     */
    public function addUserBonusStagesInfo()
    {
        $user_bonus_model = new user_bonusModel();
        /**
         * 以下是正式
         * 28天一期
         * 7天一周
         */
        $data['start_time'] = date('Y-m-d 00:00:00'); //期数开始时间
        $data['end_time']   = date('Y-m-d 23:59:59', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_MONTH - 1) . ' day')); //期数结束时间 28天为一期
        $weekOneTime        = date('Y-m-d 00:00:00') . ',' . date('Y-m-d 23:59:59', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY - 1) . ' day')); //第一周开始时间和结束时间
        $weekTwoTime        = date('Y-m-d 00:00:00', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY) . ' day')) . ',' . date('Y-m-d 23:59:59', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 6) . ' day')); //第二周开始时间和结束时间
        $weekThreeTime      = date('Y-m-d 00:00:00', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 7) . ' day')) . ',' . date('Y-m-d 23:59:59', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 13) . ' day')); //第三周开始时间和结束时间
        $weekFourTime       = date('Y-m-d 00:00:00', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 14) . ' day')) . ',' . date('Y-m-d 23:59:59', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 20) . ' day')); //第四周开始时间和结束时间
        $data['week_time']  = $weekOneTime . '|' . $weekTwoTime . '|' . $weekThreeTime . '|' . $weekFourTime;

        return $this->insert($data);

    }

    /**
     * 修改数据
     *
     * @param mixed $where
     * @param array $data
     * @return bool
     */
    public function saveUserBonusStagesInfo($where, $data)
    {
        if (empty($where) || empty($data) || !is_array($data)) {
            return false;
        }
        return $this->where($where)->update($data);
    }
}