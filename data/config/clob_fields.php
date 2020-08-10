<?php
//大内容类型字段
$clob_fields = [
    'article'                => ['article_content' => null],
    'attribute'              => ['attr_value' => null],
    'circle_recycle'         => ['recycle_content' => null],
    'circle_theme'           => ['theme_content' => null],
    'circle_threply'         => ['reply_content' => null],
    'cms_article'            => ['article_content' => null, 'article_goods' => null, 'article_image_all' => null],
    'cms_index_module'       => ['module_content' => null],
    'cms_picture_image'      => ['image_goods' => null],
    'cms_special'            => ['special_image_all' => null, 'special_content' => null],
    'consult_type'           => ['ct_introduce' => null],
    'document'               => ['doc_content' => null],
    'gadmin'                 => ['limits' => null],
    'goods'                  => ['goods_spec' => null, 'goods_body' => null, 'mobile_body' => null],
    'goods_class_tag'        => ['gc_tag_value' => null],
    'goods_common'           => ['spec_value' => null, 'goods_attr' => null, 'goods_body' => null, 'mobile_body' => null],
    'groupbuy'               => ['groupbuy_intro' => null],
    'help'                   => ['help_info' => null],
    'mail_cron'              => ['contnet' => null],
    'mail_msg_temlates'      => ['content' => null],
    'mall_consult_type'      => ['mct_introduce' => null],
    'member'                 => ['member_qqinfo' => null, 'member_sinainfo' => null, 'member_privacy' => null],
    'member_msg_tpl'         => ['mmt_mail_content' => null],
    'micro_personal'         => ['commend_image' => null, 'commend_buy' => null],
    'offpay_area'            => ['area_id' => null],
    'order_common'           => ['deliver_explain' => null],
    'payment'                => ['payment_config' => null],
    'points_goods'           => ['pgoods_body' => null],
    'rec_position'           => ['content' => null],
    'seller_group'           => ['limits' => null],
    'seo'                    => ['description' => null],
    'setting'                => ['value' => null],
    'sns_binding'            => ['snsbind_openinfo' => null],
    'sns_goods'              => ['snsgoods_likemember' => null],
    'sns_tracelog'           => ['trace_content' => null],
    'store'                  => ['store_zy' => null, 'store_slide' => null, 'store_slide_url' => null, 'store_presales' => null, 'store_aftersales' => null],
    'store_decoration_block' => ['block_content' => null],
    'store_extend'           => ['express' => null, 'pricerange' => null, 'orderpricerange' => null],
    'store_grade'            => ['sg_description' => null],
    'store_msg_tpl'          => ['smt_mail_content' => null],
    'store_navigation'       => ['sn_content' => null],
    'store_plate'            => ['plate_content' => null],
    'store_sns_tracelog'     => ['strace_content' => null],
    'store_watermark'        => ['wm_text' => null],
    'transport_extend'       => ['area_name' => null],
    'store_sns_tracelog'     => ['strace_goodsdata' => null],
    'web_code'               => ['code_info' => null],
    'web'                    => ['web_html' => null],
    'order_snapshot'         => ['goods_attr' => null, 'goods_body' => null, 'plate_top' => null, 'plate_bottom' => null]
];
return $clob_fields;