<?php
/**
 * 默认展示页面
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */


defined('ByCCYNet') or exit('Access Invalid!');

class indexControl extends BaseHomeControl
{

    /**
     * 测试
     */
    /*public function hiOp()
    {
        //获取职务等级信息,以等级为key
        if (empty(rkcache('user_level_cache'))) {
            $user_level_model = new user_levelModel;
            $user_level_info  = $user_level_model->getLevelAll(['level' => ['neq', 0]]);
            wkcache('user_level_cache', $user_level_info, 86400);
        } else {
            $user_level_info = rkcache('user_level_cache');
        }
        $user_level_infos = [];
        foreach ($user_level_info as $k => $v) {
            $user_level_infos[$v['level']] = $v['give_hi'];
        }

        $user_hi_value_model = new user_hi_valueModel();
        $member_model        = new memberModel;
        $member_info         = $member_model->getMemberList(['level_id' => ['in', '6,5,2'], 'member_state' => ['eq', 1], 'is_dealers' => ['eq', 2], 'member_type' => ['eq', 1]], '*', '', 'member_id asc',3281);

        foreach ($member_info as $key => $value) {
            for ($i=1; $i<=$value['level_id']; $i++)
            {
                $user_hi_value_model->changeUserHi($value['member_id'], $user_level_infos[$i]);
            }
        }

    }*/


    public function indexOp()
    {
        Language::read('home_index_index');
        Tpl::output('index_sign', 'index');      // 设置头部导航栏当前选中的位置

        //板块信息
        $model_web_config = Model('web_config');
        $index_adv_html   = $model_web_config->where(['web_show' => 1, 'web_id' => ['in', [101, 611, 617, 620, 624, 625, 626, 627, 628, 629, 630, 631, 632, 633]]])->select();
        $new_html_arr     = array_combine(array_column($index_adv_html, 'web_id'), $index_adv_html);
        Tpl::output('new_html_arr', $new_html_arr);
        Model('seo')->type('index')->show();
        Tpl::showpage('index');
    }


    public function testOp()
    {
        Language::read('home_index_index');
        Tpl::output('index_sign', 'index');      // 设置头部导航栏当前选中的位置

        //特卖专区
        Language::read('member_groupbuy');
        $model_groupbuy = Model('groupbuy');
        $group_list     = $model_groupbuy->getGroupbuyCommendedList(4);
        Tpl::output('group_list', $group_list);

        //专题获取

        $model_special = Model('cms_special');
        $conition      = [];
        $special_list  = $model_special->getShopindexList($conition);
        Tpl::output('special_list', $special_list);

        //限时折扣
        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_item        = $model_xianshi_goods->getXianshiGoodsCommendList(6);
        Tpl::output('xianshi_item', $xianshi_item);

        //直达楼层信息
        if (C('ccynet_lc') != '') {
            $lc_list = @unserialize(C('ccynet_lc'));
        }
        Tpl::output('lc_list', is_array($lc_list) ? $lc_list : []);

        //首页推荐词链接
        if (C('ccynet_rc') != '') {
            $rc_list = @unserialize(C('ccynet_rc'));
        }
        Tpl::output('rc_list', is_array($rc_list) ? $rc_list : []);

        //推荐品牌
        $brand_r_list = Model('brand')->getBrandPassedList(['brand_recommend' => 1], 'brand_id,brand_name,brand_pic,brand_xbgpic,brand_tjstore', 0, 'brand_sort asc, brand_id desc', 4);
        Tpl::output('brand_r', $brand_r_list);


        //评价信息
        $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsList(8);
        Tpl::output('goods_evaluate_info', $goods_evaluate_info);

        //板块信息
        $model_web_config = Model('web_config');
        $web_html         = $model_web_config->getWebHtml('index');
        Tpl::output('web_html', $web_html);
        Model('seo')->type('index')->show();
        Tpl::showpage('test/test');
    }

    //json输出商品分类
    public function josn_classOp()
    {
        /**
         * 实例化商品分类模型
         */
        $model_class = Model('goods_class');
        $goods_class = $model_class->getGoodsClassListByParentId(intval($_GET['gc_id']));
        $array       = [];
        if (is_array($goods_class) and count($goods_class) > 0) {
            foreach ($goods_class as $val) {
                $array[$val['gc_id']] = ['gc_id' => $val['gc_id'], 'gc_name' => htmlspecialchars($val['gc_name']), 'gc_parent_id' => $val['gc_parent_id'], 'commis_rate' => $val['commis_rate'], 'gc_sort' => $val['gc_sort']];
            }
        }
        /**
         * 转码
         */
        if (strtoupper(CHARSET) == 'GBK') {
            $array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        } else {
            $array = array_values($array);
        }
        echo $_GET['callback'] . '(' . json_encode($array) . ')';
    }

    /**
     * json输出地址数组 原data/resource/js/area_array.js
     */
    public function json_areaOp()
    {
        $_GET['src'] = $_GET['src'] != 'db' ? 'cache' : 'db';
        echo $_GET['callback'] . '(' . json_encode(Model('area')->getAreaArrayForJson($_GET['src'])) . ')';
    }

    /**
     * 根据ID返回所有父级地区名称
     */
    public function json_area_showOp()
    {
        $area_info['text'] = Model('area')->getTopAreaName(intval($_GET['area_id']));
        echo $_GET['callback'] . '(' . json_encode($area_info) . ')';
    }

    //判断是否登录
    public function loginOp()
    {
        echo ($_SESSION['is_login'] == '1') ? '1' : '0';
    }

    /**
     * 头部最近浏览的商品
     */
    public function viewed_infoOp()
    {
        $info = [];
        if ($_SESSION['is_login'] == '1') {
            $member_id    = $_SESSION['member_id'];
            $info['m_id'] = $member_id;
            if (C('voucher_allow') == 1) {
                $time_to         = time();//当前日期
                $info['voucher'] = Model()->table('voucher')->where(['voucher_owner_id'   => $member_id, 'voucher_state' => 1,
                                                                     'voucher_start_date' => ['elt', $time_to], 'voucher_end_date' => ['egt', $time_to]])->count();
            }
            $time_to         = strtotime(date('Y-m-d'));//当前日期
            $time_from       = date('Y-m-d', ($time_to - 60 * 60 * 24 * 7));//7天前
            $info['consult'] = Model()->table('consult')->where(['member_id'          => $member_id,
                                                                 'consult_reply_time' => [['gt', strtotime($time_from)], ['lt', $time_to + 60 * 60 * 24], 'and']])->count();
        }
        $goods_list = Model('goods_browse')->getViewedGoodsList($_SESSION['member_id'], 5);
        if (is_array($goods_list) && !empty($goods_list)) {
            $viewed_goods = [];
            foreach ($goods_list as $key => $val) {
                $goods_id                = $val['goods_id'];
                $val['url']              = urlShop('goods', 'index', ['goods_id' => $goods_id]);
                $val['goods_image']      = cthumb($val['goods_image'], 60);
                $viewed_goods[$goods_id] = $val;
            }
            $info['viewed_goods'] = $viewed_goods;
        }
        if (strtoupper(CHARSET) == 'GBK') {
            $info = Language::getUTF8($info);
        }
        echo json_encode($info);
    }

    /**
     * 查询每月的周数组
     */
    public function getweekofmonthOp()
    {
        import('function.datehelper');
        $year     = $_GET['y'];
        $month    = $_GET['m'];
        $week_arr = getMonthWeekArr($year, $month);
        echo json_encode($week_arr);
        die;
    }

    /**
     * 我的微商城
     */
    public function myshopOp()
    {
        $rec       = $_GET['rec'];
        $member_id = hj_decrypt($rec);

        /*$domainArray = explode('.', $_SERVER['HTTP_HOST']);//获取当前域名
        if (strtoupper(substr($domainArray[0],0,5))=='HJ100'){//使用域名前缀
            $w_user =Model('member')->where(['member_number'=>$domainArray[0]])->find();
            if ($w_user){
                $member_id=$w_user['member_id'];
            }
        }*/

        //获取微店店主ID 并生成推广码写入SESSION
        $userNumber = isset($_GET['userNumber']) ? $_GET['userNumber'] : '';
        if (!empty($userNumber)) {
            $w_user = Model('member')->where(['member_number' => $userNumber, 'is_distribution' => 1])->find();
            if ($w_user) {
                $member_id                = $w_user['member_id'];
                $_SESSION['referral_key'] = hj_encrypt($member_id);;
            } else {
                unset($_SESSION['referral_key']);
            }
        }

        $recommend = Model('distribute_goods')->where(['user_id' => $member_id])->find();//获取个人微商自己推荐列表
        Tpl::output('recommend_list', unserialize($recommend['goods_info']));


        $model_web_config = Model('web_config');
        $index_adv_html   = $model_web_config->where(['web_show' => 1, 'web_id' => ['in', [101, 611, 617, 620, 624, 625, 626, 627, 628, 629, 630, 631, 632, 633]]])->select();
        $new_html_arr     = array_combine(array_column($index_adv_html, 'web_id'), $index_adv_html);
        //板块信息
        Tpl::output('new_html_arr', $new_html_arr);
        Model('seo')->type('index')->show();
        Tpl::showpage('distribution_myshop');
    }
}
