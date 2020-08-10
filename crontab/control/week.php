<?php
/**
 * 任务计划 - 周执行的任务
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class weekControl extends BaseCronControl
{
    /**
     * 默认方法
     */
    public function indexOp()
    {
        $model      = new stages_crontabModel();
        $is_crontab = $model->getUserBonusStagesCrontabInfo(['frequency' => 0]);
        if ($is_crontab > 0) {
            $this->_week_count();
            $this->_weekly_bonus();
            p(date('Y-m-d H:i:s') . '周计划任务执行成功');
        }
    }

    /**
     * 周统计 2018-4-28
     * 第二个月开始，一月一统计，一周一分红
     */
    private function _week_count()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->statisticsSalesManagementWeekBonus();// 销售管理普惠周奖金
        $user_bonus_logic->statisticsMiddleManagementBonusWeekly();// 中层管理周分红

    }

    /**
     * 周分红 2018-4-28
     * 第二个月开始，一月一统计，一周一分红
     */
    private function _weekly_bonus()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->salesManagementWeekBonus(); // 销售管理普惠周奖金
        $user_bonus_logic->middleManagementBonusWeekly();// 中层管理周分红
    }

}