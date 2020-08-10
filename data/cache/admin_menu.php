<?php defined('ByCCYNet') or exit('Access Invalid!'); return array (
  'system' => 
  array (
    'name' => '平台',
    'child' => 
    array (
      0 => 
      array (
        'name' => '设置',
        'child' => 
        array (
          'setting' => '站点设置',
          'upload' => '上传设置',
          'message' => '邮件设置',
          'admin' => '权限设置',
          'admin_log' => '操作日志',
          'area' => '地区设置',
          'cache' => '清理缓存',
        ),
      ),
      1 => 
      array (
        'name' => '网站',
        'child' => 
        array (
          'article_class' => '文章分类',
          'article' => '文章管理',
          'help_class' => '帮助分类',
          'help' => '帮助中心',
          'page_class' => '单页分类',
          'page' => '单页管理',
          'video_class' => '视频分类',
          'video' => '视频管理',
          'document' => '会员协议',
          'navigation' => '页面导航',
          'rec_position' => '推荐位',
          'exhibition' => '展示型文章',
        ),
      ),
      2 => 
      array (
        'name' => '运维应用',
        'child' => 
        array (
          'link' => '友情连接',
          'ccynet' => '运维控件',
          'goods' => '商品组件',
          'db' => '数据库管理',
          'store' => '店铺组件',
          'member' => '会员组件',
        ),
      ),
      3 => 
      array (
        'name' => '广告管理',
        'child' => 
        array (
          'banner_category' => '广告分组',
          'banner_list' => '广告列表',
        ),
      ),
    ),
  ),
  'shop' => 
  array (
    'name' => '商城',
    'child' => 
    array (
      0 => 
      array (
        'name' => '设置',
        'child' => 
        array (
          'setting' => '商城设置',
          'signIn_set' => '签到设置',
          'order_set' => '订单设置',
          'upload' => '图片设置',
          'search' => '搜索设置',
          'seo' => 'SEO设置',
          'message' => '消息通知',
          'payment' => '支付方式',
          'express' => '快递公司',
          'waybill' => '运单模板',
          'web_config' => '首页管理',
          'web_channel' => '频道管理',
          'prize_set' => '抽奖设置',
        ),
      ),
      1 => 
      array (
        'name' => '商品',
        'child' => 
        array (
          'goods' => '商品管理',
          'goods_class' => '分类管理',
          'brand' => '品牌管理',
          'type' => '类型管理',
          'spec' => '规格管理',
          'goods_album' => '图片空间',
          'goods_recommend' => '商品推荐',
        ),
      ),
      2 => 
      array (
        'name' => '店铺',
        'child' => 
        array (
          'store' => '店铺管理',
          'store_grade' => '店铺等级',
          'store_class' => '店铺分类',
          'sns_strace' => '店铺动态',
          'help_store' => '店铺帮助',
          'store_joinin' => '商家入驻',
          'ownshop' => '自营店铺',
        ),
      ),
      3 => 
      array (
        'name' => '会员',
        'child' => 
        array (
          'member' => '会员管理',
          'member_exp' => '等级经验值',
          'points' => '积分管理',
          'sns_sharesetting' => '分享绑定',
          'sns_malbum' => '会员相册',
          'predeposit' => '预存款',
          'chat_log' => '聊天记录',
          'member_auth' => '实名认证',
        ),
      ),
      4 => 
      array (
        'name' => '交易',
        'child' => 
        array (
          'order' => '商品订单',
          'refund' => '退款管理',
          'return' => '退货管理',
          'consulting' => '咨询管理',
          'inform' => '举报管理',
          'evaluate' => '评价管理',
          'complain' => '投诉管理',
          'invoice' => '发票管理',
        ),
      ),
      5 => 
      array (
        'name' => '运营',
        'child' => 
        array (
          'operating' => '运营设置',
          'bill' => '结算管理',
          'mall_consult' => '平台客服',
          'rechargecard' => '平台充值卡',
          'contract' => '消费者保障服务',
          'dealers' => '经销商申请',
        ),
      ),
      6 => 
      array (
        'name' => '促销',
        'child' => 
        array (
          'operation' => '促销设定',
          'pointprod' => '积分兑换',
          'activity' => '活动管理',
          'prize_goods' => '抽奖礼品',
          'prize_good' => '中奖记录',
        ),
      ),
      7 => 
      array (
        'name' => '统计',
        'child' => 
        array (
          'stat_general' => '概述及设置',
          'stages' => '平台利润统计',
          'stat_bonus_log' => '分红日志',
          'stat_platform_sales' => '平台销量统计',
          'stat_member' => '会员统计',
          'stat_aftersale' => '售后分析',
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
          'stat_positions' => '职级统计',
        ),
      ),
      8 => 
      array (
        'name' => '积分商品',
        'child' => 
        array (
          'jfgoods_online' => '商品管理',
          'jfgoods_add' => '发布商品',
          'jfgoods_category' => '分类列表',
        ),
      ),
      9 => 
      array (
        'name' => '积分订单',
        'child' => 
        array (
          'jforder' => '订单列表',
        ),
      ),
    ),
  ),
);