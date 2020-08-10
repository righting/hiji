<?php
/**
 * 任务计划 - 月执行的任务
 */

defined('ByCCYNet') or exit('Access Invalid!');

class monthFifteenControl extends BaseCronControl
{
    /**
     * 默认方法
     */
    public function indexOp()
    {
        $this->_dividend_monthly_fifteen_statistics();
        $this->_monthly_fifteen_bonus();
        p(date('Y-m-d H:i:s') . '每月15日计划任务执行成功');
    }

    /**
     * 分红月统计 每月15日统计
     */
    public function _dividend_monthly_fifteen_statistics()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->statisticsBlackDiamondSalesBonus(); //每月15日统计
        $user_bonus_logic->statisticsEliteMonthlyBonus();   //每月15日统计
        $user_bonus_logic->statisticsTopSellingMonthlyBonus(); //每月15日统计
        p(date('Y-m-d') . '当月15日分红统计成功');
    }

    /**
     * 每月十五号才分红的奖项
     */
    public function _monthly_fifteen_bonus()
    {
        $user_bonus_logic = new user_bonusLogic();
        $user_bonus_logic->blackDiamondSalesBonus();
        $user_bonus_logic->eliteMonthlyBonus();
        $user_bonus_logic->topSellingMonthlyBonus();
        p(date('Y-m-d') . '当月15日分红成功');
    }

}