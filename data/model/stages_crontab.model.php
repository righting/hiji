<?php
/**
 * 分红分期
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stages_crontabModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_bonus_stages_crontab');
    }

    /**
     * 获取数据
     *
     * @param array $condision
     * @return mixed
     */
    public function getUserBonusStagesCrontabInfo(array $condision = [])
    {
        $condision['status']       = 0;
        $condision['crontab_date'] = date('Y-m-d 00:00:00');
        return $this->where($condision)->count();
    }


    /**
     * 创建最新一期的数据
     *
     * @return mixed
     */
    public function addUserBonusStagesCrontabInfo($stages_id = 0)
    {
        $rs = $this->where(['stages_id' => $stages_id, 'status' => 0])->count();
        if ($rs > 0) return false;

        $user_bonus_model = new user_bonusModel();

        // 月
        $monthDate = date('Y-m-d', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_MONTH) . ' day'));
        // 第一周
        $weekOneDate = date('Y-m-d', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY) . ' day'));
        // 第一周
        $weekTwoDate = date('Y-m-d', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 7) . ' day'));
        // 第一周
        $weekThreeDate = date('Y-m-d', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 14) . ' day'));
        // 第一周
        $weekFourDate = date('Y-m-d', strtotime('+' . ($user_bonus_model::FREQUENCY_FOR_WEEKLY + 21) . ' day'));

        $dataList = [
            ['stages_id' => $stages_id, 'crontab_date' => $monthDate, 'frequency' => 1],
            ['stages_id' => $stages_id, 'crontab_date' => $weekOneDate],
            ['stages_id' => $stages_id, 'crontab_date' => $weekTwoDate],
            ['stages_id' => $stages_id, 'crontab_date' => $weekThreeDate],
            ['stages_id' => $stages_id, 'crontab_date' => $weekFourDate],
        ];

        $this->insert(['stages_id' => $stages_id, 'crontab_date' => $monthDate, 'frequency' => 1]);
        $this->insert(['stages_id' => $stages_id, 'crontab_date' => $weekOneDate]);
        $this->insert(['stages_id' => $stages_id, 'crontab_date' => $weekTwoDate]);
        $this->insert(['stages_id' => $stages_id, 'crontab_date' => $weekThreeDate]);
        $this->insert(['stages_id' => $stages_id, 'crontab_date' => $weekFourDate]);

        return true;

        //return $dataList;
        //return $this->insertAll($dataList);
    }

}