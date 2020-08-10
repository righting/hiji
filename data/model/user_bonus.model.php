<?php
/**
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 *
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

defined('ByCCYNet') or exit('Access Invalid!');

class user_bonusModel extends Model
{
    public function __construct()
    {
        parent::__construct('user_bonus');
    }

    // 设置分红类型
    const TYPE_SALES_DAY_BONUS                = 1; // 销售/消费日分红
    const TYPE_SELLING_STAR_DAY_BONUS         = 2; // 销售明星日分红
    const TYPE_SHARE_DAY_BONUS_FOR_NEW        = 3; // 共享日分红-新注册会员
    const TYPE_SHARE_DAY_BONUS_FOR_OLD        = 4; // 共享日分红-老会员
    const TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY = 5; // 中层管理周分红
    const TYPE_BLACK_DIAMOND_SALES_BONUS      = 6; // 至尊消费月分红
    const TYPE_ELITE_MONTHLY_BONUS            = 7; // 销售精英月分红
    const TYPE_TOP_SELLING_MONTHLY_BONUS      = 8; // 高层销售月分红
    const TYPE_NEW_SALES_AWARD                = 9; // 销售新人奖
    const TYPE_SHARE_DAY_BONUS                = 10; // 共享日分红
    const TYPE_SALES_MANAGEMENT_WEEK_BONUS    = 11; // 销售管理普惠周奖金
    const TYPE_SUPPLIER_REFERRAL_BONUS        = 12; // 供应商推荐奖金

    const TYPE_SUPPLY_MONEY                 = 13; // 供货款（转给店铺的商品供货款）
    const TYPE_SUPPLY_FREIGHT               = 14; // 商品运费（转给店铺的商品运费）
    const TYPE_CORPORATE_PROFITS            = 15; // 平台利润（当前商品的税前总销售利润*20%）
    const TYPE_TAX_RATE_MONEY               = 16; // 销售服务税（税前销售利润*销售服务税率）
    const TYPE_SALES_SHARE_BONUS            = 17; // 个人消费分红
    const TYPE_SALES_SHARE_BONUS_FOR_TEAM   = 18; // 团队销售分享分红
    const TYPE_SALES_SHARE_BONUS_FOR_SELLER = 19; // 个人微商销售分红
    const TYPE_SURPLUS_TOTAL_MONEY          = 20; // 剩余可分红利润

    const TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION = 21; // 消费资本补贴-消费养老补贴
    const TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM       = 22; // 消费资本补贴-车房梦想补贴

    /**
     * 即时结算类
     * TYPE_SALES_SHARE_BONUS = 17; // 个人消费分红
     * TYPE_SALES_SHARE_BONUS_FOR_TEAM = 18; // 团队销售分享分红
     * TYPE_SALES_SHARE_BONUS_FOR_SELLER = 19; // 个人微商销售分红
     * 日分红类
     * TYPE_SALES_DAY_BONUS = 1; // 销售/消费日分红
     * TYPE_SELLING_STAR_DAY_BONUS = 2; // 销售明星日分红
     * TYPE_SHARE_DAY_BONUS_FOR_NEW = 3; // 共享日分红-新注册会员
     * TYPE_SHARE_DAY_BONUS_FOR_OLD = 4; // 共享日分红-老会员
     * 周分红类
     * TYPE_SALES_MANAGEMENT_WEEK_BONUS = 11; // 销售管理普惠周奖金
     * TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY = 5; // 中层管理周分红
     * 月分红类
     * TYPE_BLACK_DIAMOND_SALES_BONUS = 6; // 至尊消费月分红
     * TYPE_ELITE_MONTHLY_BONUS = 7; // 销售精英月分红
     * TYPE_TOP_SELLING_MONTHLY_BONUS = 8; // 高层销售月分红
     * TYPE_SUPPLIER_REFERRAL_BONUS = 12; // 供应商推荐奖金
     * TYPE_NEW_SALES_AWARD  = 9; // 销售新人奖
     */

    // 设置分红频率
    const FREQUENCY_FOR_DAY    = 1; // 每天一次
    const FREQUENCY_FOR_WEEKLY = 7; // 每周一次
    const FREQUENCY_FOR_MONTH  = 28; // 每月一次

    /*const FREQUENCY_FOR_DAY    = 1; // 每天一次
    const FREQUENCY_FOR_WEEKLY = 2; // 每周一次(每周应该是7天，测试调整为2天，正式版本应该改回来7天)
    const FREQUENCY_FOR_MONTH  = 4; // 每月一次(每周应该是28天，测试调整为4天，正式版本应该改回来28天)*/

    public function getTypeInfo($type = '')
    {
        $type_arr = [
            self::TYPE_SALES_DAY_BONUS                                 => '销售日分红',//1
            self::TYPE_SELLING_STAR_DAY_BONUS                          => '销售明星日分红',//2
            self::TYPE_SHARE_DAY_BONUS_FOR_NEW                         => '共享日分红-新注册会员',//3
            self::TYPE_SHARE_DAY_BONUS_FOR_OLD                         => '共享日分红-老会员',///4
            self::TYPE_MIDDLE_MANAGEMENT_BONUS_WEEKLY                  => '中层管理周分红',//5
            self::TYPE_BLACK_DIAMOND_SALES_BONUS                       => '至尊销售月分红',//6
            self::TYPE_ELITE_MONTHLY_BONUS                             => '销售精英月分红',//7
            self::TYPE_TOP_SELLING_MONTHLY_BONUS                       => '高层销售月分红',//8
            self::TYPE_NEW_SALES_AWARD                                 => '销售新人奖',//9
            self::TYPE_SHARE_DAY_BONUS                                 => '共享日分红',//10
            self::TYPE_SALES_MANAGEMENT_WEEK_BONUS                     => '销售管理普惠周奖金',//11
            self::TYPE_SUPPLIER_REFERRAL_BONUS                         => '供应商推荐奖金',//12
            self::TYPE_SUPPLY_MONEY                                    => '商品供货款',//13
            self::TYPE_SUPPLY_FREIGHT                                  => '商品运费',//14
            self::TYPE_CORPORATE_PROFITS                               => '平台利润',//15
            self::TYPE_TAX_RATE_MONEY                                  => '销售服务税',//16
            self::TYPE_SALES_SHARE_BONUS                               => '个人消费分红',//17
            self::TYPE_SALES_SHARE_BONUS_FOR_TEAM                      => '团队销售分享分红',//18
            self::TYPE_SALES_SHARE_BONUS_FOR_SELLER                    => '个人微商销售分红',//19
            self::TYPE_SURPLUS_TOTAL_MONEY                             => '剩余可分红利润',//20
            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_CONSUMPTION_PENSION => '消费资本补贴-消费养老补贴',//21
            self::TYPE_CONSUMPTION_CAPITAL_SUBSIDY_GARAGES_DREAM       => '消费资本补贴-车房梦想补贴',//22
        ];
        return isset($type_arr[$type]) ? $type_arr[$type] : $type_arr;
    }

    // 系统基本设置
    public function getBonusSetting($type = '')
    {
        $bonusType = [
            'type_sales_day_bonus_money',
            'type_selling_star_day_bonus_money',
            'type_share_day_bonus_for_new_money',
            'type_share_day_bonus_for_old_money',
            'type_middle_management_bonus_weekly_money',
            'type_black_diamond_sales_bonus_money',
            'type_elite_monthly_bonus_money',
            'type_top_selling_monthly_bonus_money',
            'type_new_sales_award_money',
            'type_share_day_bonus_money',
            'type_sales_management_week_bonus_money',
            'type_supplier_referral_bonus_money',
            'type_sales_share_bonus_money',
            'type_sales_share_bonus_for_team_money',
            'type_sales_share_bonus_for_seller_money',
            'type_consumption_capital_subsidy_consumption_pension_money',
            'type_consumption_capital_subsidy_garages_dream_money',
            'USER_CONSUMPTION_BONUS_RATIO',
            'PLATFORM_TAX_RATE'
        ];
        $model     = new settingModel();
        if (in_array($type, $bonusType)) {
            $result = $model->where(['name' => $type])->find();
            return $result ? $result['value'] : 0;
        }
        return 0;
    }
}