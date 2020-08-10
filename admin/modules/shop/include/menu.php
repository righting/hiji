<?php
/**
 * 菜单
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */
defined('ByCCYNet') or exit('Access Invalid!');

$_menu['shop'] = array(
    'name' => '商城',
    'child' => array(
        array(
            'name' => '设置',
            'child' => array(
                'setting' => '商城设置',
                'signIn_set' => '签到设置',
                'order_set' => '订单设置',
                'upload' => '图片设置',
                'search' => '搜索设置',
                'seo' => $lang['nc_seo_set'],
                'message' => $lang['nc_message_set'],
                'payment' => $lang['nc_pay_method'],
                'express' => $lang['nc_admin_express_set'],
                'waybill' => '运单模板',
                'web_config' => '首页管理',
                'web_channel' => '频道管理',
                'prize_set' => '抽奖设置',

            )),
        array(
            'name' => $lang['nc_goods'],
            'child' => array(
                'goods' => $lang['nc_goods_manage'],
                'goods_class' => $lang['nc_class_manage'],
                'brand' => $lang['nc_brand_manage'],
                'type' => $lang['nc_type_manage'],
                'spec' => $lang['nc_spec_manage'],
                'goods_album' => $lang['nc_album_manage'],
                'goods_recommend' => '商品推荐'
            )),
        array(
            'name' => $lang['nc_store'],
            'child' => array(
                'store' => $lang['nc_store_manage'],
                'store_grade' => $lang['nc_store_grade'],
                'store_class' => $lang['nc_store_class'],
//                                'domain' => $lang['nc_domain_manage'],
                'sns_strace' => $lang['nc_s_snstrace'],
                'help_store' => '店铺帮助',
                'store_joinin' => '商家入驻',
                'ownshop' => '自营店铺'
            )),
        array(
            'name' => $lang['nc_member'],
            'child' => array(
                'member' => $lang['nc_member_manage'],
                'member_exp' => '等级经验值',
                'points' => $lang['nc_member_pointsmanage'],
                'sns_sharesetting' => $lang['nc_binding_manage'],
                'sns_malbum' => $lang['nc_member_album_manage'],
//                                'snstrace' => $lang['nc_snstrace'],
//                                'sns_member' => $lang['nc_member_tag'],
                'predeposit' => $lang['nc_member_predepositmanage'],
                'chat_log' => '聊天记录',
                'member_auth' => '实名认证',
            )),
        array(
            'name' => $lang['nc_trade'],
            'child' => array(
                'order' => $lang['nc_order_manage'],
//                                'vr_order' => '虚拟订单',
                'refund' => '退款管理',
                'return' => '退货管理',
//                                'vr_refund' => '虚拟订单退款',
                'consulting' => $lang['nc_consult_manage'],
                'inform' => $lang['nc_inform_config'],
                'evaluate' => $lang['nc_goods_evaluate'],
                'complain' => $lang['nc_complain_config'],
		        'invoice' => '发票管理'
            )),
        array(
            'name' => $lang['nc_operation'],
            'child' => array(
                'operating' => '运营设置',
                'bill' => $lang['nc_bill_manage'],
//                                'vr_bill' => '虚拟订单结算',
                'mall_consult' => '平台客服',
                'rechargecard' => '平台充值卡',
//                                'delivery' => '物流自提服务站',
                'contract' => '消费者保障服务',
                'dealers' => '经销商申请',

            )),
        array(
            'name' => '促销',
            'child' => array(
                'operation' => '促销设定',
//                                'groupbuy' => $lang['nc_groupbuy_manage'],
//                                'vr_groupbuy' => '虚拟团购设置',
//                                'promotion_cou' => '加价购',
//                                'promotion_xianshi' => $lang['nc_promotion_xianshi'],
//                                'promotion_mansong' => $lang['nc_promotion_mansong'],
//                                'promotion_bundling' => $lang['nc_promotion_bundling'],
//                                'promotion_booth' => '推荐展位',
//                                'promotion_book' => '预售商品',
//                                'promotion_fcode' => 'Ｆ码商品',
//                                'promotion_combo' => '推荐组合',
//                                'promotion_sole' => '手机专享',
                'pointprod' => $lang['nc_pointprod'],
//                                'voucher' => $lang['nc_voucher_price_manage'],
//                                'redpacket' => '平台红包',
                'activity' => $lang['nc_activity_manage'],
                'prize_goods' => '抽奖礼品',
                'prize_good' => '中奖记录',
            )),
        array(
            'name' => $lang['nc_stat'],
            'child' => array(
                                'stat_general' => $lang['nc_statgeneral'],
                                'stages' => '平台利润统计',
                                'stat_bonus_log' => '分红日志',
                                'stat_platform_sales' => '平台销量统计',
//                                'stat_industry' => $lang['nc_statindustry'],
                                'stat_member' => $lang['nc_statmember'],
//                                'stat_store' => $lang['nc_statstore'],
//                                'stat_trade' => $lang['nc_stattrade'],
//                                'stat_goods' => $lang['nc_statgoods'],
//                                'stat_marketing' => $lang['nc_statmarketing'],
                                'stat_aftersale' => $lang['nc_stataftersale'],
                'stat_consumption' => '个人消费统计',
                'stat_seller_sale' => '个人微商销售统计',
                'stat_store_sale' => '供应商销售统计',
                'stat_bonus' => '分红统计',
                'stat_bonus_for_day' => '日分红统计',
                'stat_bonus_for_week' => '周分红统计',
                'stat_bonus_for_month' => '月分红统计',
                'stat_hi' => '分红hi值统计',
                'stat_points' => '积分统计',
                'stat_contribution' => '贡献值统计',
                'stat_positions' => '职级统计'
            )),
        array(
            'name' => '积分商品',
            'child' => array(
                'jfgoods_online' => '商品管理',
                //'jfgoods_offline' => '仓库中的商品',
                'jfgoods_add' => '发布商品',
                'jfgoods_category' => '分类列表',
            )),
        array(
            'name' => '积分订单',
            'child' => array(
                'jforder' => '订单列表',
            )),
    ));
