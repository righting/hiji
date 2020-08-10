<?php
/**
 * 物流自提服务站父类
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class Control
{

    //获取购物车商品信息 最多3条
    protected function getCartInfo()
    {
        $cartModel = Model('cart');
        $userId    = $_SESSION['member_id'];
        $info      = $cartModel->where(['buyer_id' => $userId])->order('created_at desc')->limit(3)->select();
        return $info;
    }

    //获取用户等级
    protected function getUserLevelInfo()
    {
        $userModel  = Model('member');
        $levelModel = Model('user_level');
        $userId     = $_SESSION['member_id'];
        //获取用户信息
        $getUserInfo               = $userModel->where(['member_id' => $userId])->field('member_id,level_id')->find();
        $getUserInfo['level_name'] = $levelModel->where(['id' => $getUserInfo['level_id']])->find()['level_name'];
        return $getUserInfo;
    }

    //获取最近浏览的商品信息最多3条
    protected function getGoodsBrowseInfo()
    {
        $userId           = $_SESSION['member_id'];
        $goodsModel       = Model('goods');
        $goodsBrowseModel = Model('goods_browse');

        //获取浏览信息记录
        $goodsBrowseInfo = $goodsBrowseModel->where(['member_id' => $userId])->order('browsetime desc')->limit(3)->select();

        $info = [];

        //获取商品信息
        if (!empty($goodsBrowseInfo)) {
            foreach ($goodsBrowseInfo as $k => $v) {
                $goodsInfo = $goodsModel->where(['goods_id' => $v['goods_id'], 'goods_verify' => 1])->field('goods_id,goods_name,goods_image,goods_price')->find();
                if (!empty($goodsInfo)) {
                    $info[] = $goodsInfo;
                }
            }
        }
        return $info;
    }


    /**
     * 检查短消息数量
     *
     */
    protected function checkMessage()
    {
        if ($_SESSION['member_id'] == '') return;
        //判断cookie是否存在
        $cookie_name = 'msgnewnum' . $_SESSION['member_id'];
        if (cookie($cookie_name) != null) {
            $countnum = intval(cookie($cookie_name));
        } else {
            $message_model = Model('message');
            $countnum      = $message_model->countNewMessage($_SESSION['member_id']);
            setNcCookie($cookie_name, "$countnum", 2 * 3600);//保存2小时
        }
        Tpl::output('message_num', $countnum);
    }

    /**
     *  输出头部的公用信息
     *
     */
    protected function showLayout()
    {
        $this->checkMessage();//短消息检查
        $this->article();//文章输出

        $this->showCartCount();

        $old_nav_list = rkcache('nav', true);
        $tree_model   = new Tree();
        $nav_list     = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

        $bottom_nav = [];
        foreach ($nav_list as $key => $value) {
            if ($value['nav_location'] == 2) {
                $bottom_nav[] = $value;
            }
        }
        //获取底部导航
        Tpl::output('bottom_nav', $bottom_nav);

        //热门搜索
        Tpl::output('hot_search', @explode(',', C('hot_search')));
        if (C('rec_search') != '') {
            $rec_search_list = @unserialize(C('rec_search'));
        }
        Tpl::output('rec_search_list', is_array($rec_search_list) ? $rec_search_list : []);

        //历史搜索
        if (cookie('his_sh') != '') {
            $his_search_list = explode('~', cookie('his_sh'));
        }
        Tpl::output('his_search_list', is_array($his_search_list) ? $his_search_list : []);

        $model_class = Model('goods_class');
        $goods_class = $model_class->get_all_category();
        Tpl::output('show_goods_class', $goods_class);//商品分类

        //获取导航
        $old_nav_list = rkcache('nav', true);
        $tree_model   = new Tree();
        $nav_list     = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');
        Tpl::output('nav_list', $nav_list);
        //查询保障服务项目
        Tpl::output('contract_list', Model('contract')->getContractItemByCache());
    }

    /**
     * 显示购物车数量
     */
    protected function showCartCount()
    {
        if (cookie('cart_goods_num') != null) {
            $cart_num = intval(cookie('cart_goods_num'));
        } else {
            //已登录状态，存入数据库,未登录时，优先存入缓存，否则存入COOKIE
            if ($_SESSION['member_id']) {
                $save_type = 'db';
            } else {
                $save_type = 'cookie';
            }
            $cart_num = Model('cart')->getCartNum($save_type, ['buyer_id' => $_SESSION['member_id']]);//查询购物车商品种类
        }
        Tpl::output('cart_goods_num', $cart_num);
    }

    /**
     * 系统公告
     */
    protected function system_notice()
    {
        $model_message                    = Model('article');
        $condition                        = [];
        $condition['ac_id']               = 1;
        $condition['article_position_in'] = ARTICLE_POSIT_ALL . ',' . ARTICLE_POSIT_BUYER;
        $condition['limit']               = 5;
        $article_list                     = $model_message->getArticleList($condition);
        Tpl::output('system_notice', $article_list);
    }

    /**
     * 输出会员等级
     *
     * @param bool $is_return 是否返回会员信息，返回为true，输出会员信息为false
     */
    protected function getMemberAndGradeInfo($is_return = false)
    {
        $member_info = [];
        //会员详情及会员级别处理
        if ($_SESSION['member_id']) {
            $model_member = Model('member');
            $member_info  = $model_member->getMemberInfoByID($_SESSION['member_id']);
            if ($member_info) {
                $member_gradeinfo               = $model_member->getOneMemberGrade();
                $member_info                    = array_merge($member_info, $member_gradeinfo);
                $member_info['voucher_count']   = Model('voucher')->getCurrentAvailableVoucherCount($_SESSION['member_id']);
                $member_info['redpacket_count'] = Model('redpacket')->getCurrentAvailableRedpacketCount($_SESSION['member_id']);
                $member_info['security_level']  = $model_member->getMemberSecurityLevel($member_info);
                $member_info['position_name']   = Model('positions')->where(['id' => $member_info['positions_id']])->find()['title'];
            }
        }
        if ($is_return == true) {//返回会员信息
            return $member_info;
        } else {//输出会员信息
            Tpl::output('member_info', $member_info);
        }
    }

    /**
     * 验证会员是否登录
     *
     */
    protected function checkLogin()
    {
        if ($_SESSION['is_login'] !== '1') {
            $ref_url = request_uri();
            if ($_GET['inajax']) {
                showDialog('', '', 'js', "login_dialog();", 200);
            } else {
                @header("location: " . urlLogin('login', 'index', ['ref_url' => $ref_url]));
            }
            exit;
        }
    }

    //文章输出
    protected function article()
    {
        $show_article = [];//商城公告
        $article_list = [];//下方文章
        if (C('cache_open')) {
            if ($article = rkcache("index/article")) {
                Tpl::output('show_article', $article['show_article']);
                Tpl::output('article_list', $article['article_list']);
                return;
            }
        } else {
            if (file_exists(BASE_DATA_PATH . '/cache/index/article.php')) {
                include(BASE_DATA_PATH . '/cache/index/article.php');
                Tpl::output('show_article', $show_article);
                Tpl::output('article_list', $article_list);
                return;
            }
        }

        $model_article_class = Model('article_class');
        $model_article       = Model('article');
        $notice_class        = ['notice'];
        $code_array          = ['member', 'store', 'payment', 'sold', 'service', 'about'];
        $notice_limit        = 5;
        $faq_limit           = 5;

        $class_condition               = [];
        $class_condition['home_index'] = 'home_index';
        $class_condition['order']      = 'ac_sort asc';
        $article_class                 = $model_article_class->getClassList($class_condition);
        $class_list                    = [];
        if (!empty($article_class) && is_array($article_class)) {
            foreach ($article_class as $key => $val) {
                $ac_code            = $val['ac_code'];
                $ac_id              = $val['ac_id'];
                $val['list']        = [];//文章
                $class_list[$ac_id] = $val;
            }
        }

        $condition                 = [];
        $condition['article_show'] = '1';
        $condition['field']        = 'article.article_id,article.ac_id,article.article_url,article_class.ac_code,article.article_position,article.article_title,article.article_time,article_class.ac_name,article_class.ac_parent_id';
        $condition['order']        = 'article_sort asc,article_time desc';
        $condition['limit']        = '300';
        $article_array             = $model_article->getJoinList($condition);
        if (!empty($article_array) && is_array($article_array)) {
            foreach ($article_array as $key => $val) {
                if ($val['ac_code'] == 'notice' && !in_array($val['article_position'], [ARTICLE_POSIT_SHOP, ARTICLE_POSIT_ALL])) continue;
                $ac_id        = $val['ac_id'];
                $ac_parent_id = $val['ac_parent_id'];
                if ($ac_parent_id == 0) {//顶级分类
                    $class_list[$ac_id]['list'][] = $val;
                } else {
                    $class_list[$ac_parent_id]['list'][] = $val;
                }
            }
        }
        if (!empty($class_list) && is_array($class_list)) {
            foreach ($class_list as $key => $val) {
                $ac_code = $val['ac_code'];
                if (in_array($ac_code, $notice_class)) {
                    $list = $val['list'];
                    array_splice($list, $notice_limit);
                    $val['list']            = $list;
                    $show_article[$ac_code] = $val;
                }
                if (in_array($ac_code, $code_array)) {
                    $list                    = $val['list'];
                    $val['class']['ac_name'] = $val['ac_name'];
                    array_splice($list, $faq_limit);
                    $val['list']    = $list;
                    $article_list[] = $val;
                }
            }
        }
        if (C('cache_open')) {
            wkcache('index/article', [
                'show_article' => $show_article,
                'article_list' => $article_list,
            ]);
        } else {
            $string = "<?php\n\$show_article=" . var_export($show_article, true) . ";\n";
            $string .= "\$article_list=" . var_export($article_list, true) . ";\n?>";
            file_put_contents(BASE_DATA_PATH . '/cache/index/article.php', ($string));
        }

        Tpl::output('show_article', $show_article);
        Tpl::output('article_list', $article_list);
    }

    /**
     * 自动登录
     */
    protected function auto_login()
    {
        $data = cookie('auto_login');
        if (empty($data)) {
            return false;
        }
        $model_member = Model('member');
        if ($_SESSION['is_login']) {
            $model_member->auto_login();
        }
        $member_id = intval(decrypt($data, MD5_KEY));
        if ($member_id <= 0) {
            return false;
        }
        $member_info = $model_member->getMemberInfoByID($member_id);
        $model_member->createSession($member_info);
    }

    //获取广告
    protected function getBannerList($c_id = 0, $id = false)
    {
        if (empty($c_id)) {
            return [];
        }
        $bannerModel     = Model('banner');
        $where['c_id']   = $c_id;
        $where['status'] = 1;
        if (false !== $id) {
            $where['id'] = $id;
            $banner      = $bannerModel->where($where)->order('sort desc')->find();
        } else {
            $banner = $bannerModel->where($where)->order('sort desc')->select();
        }

        return $banner;
    }

    /**
     * 输出客服分组列表
     */
    protected function getKefuGroupList()
    {
        $result = [];
        if ($_SESSION['member_id']) {
            $kefu_groups_model = new kefu_groupsModel();
            $result            = $kefu_groups_model->getGroupsList(['status' => 1], 'id,name');
        }
        Tpl::output('kefu_group_list', $result);
    }
}

class BaseLoginControl extends Control
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        /**
         * 读取通用、布局的语言包
         */
        Language::read('common,core_lang_index');

        /**
         * 设置布局文件内容
         */
        Tpl::setLayout('login_layout');

        /**
         * 获取导航
         */
        Tpl::output('nav_list', rkcache('nav', true));

        /**
         * 客服分组
         */
        $this->getKefuGroupList();

        $old_nav_list = rkcache('nav', true);
        $tree_model   = new Tree();
        $nav_list     = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

        $bottom_nav = [];
        foreach ($nav_list as $key => $value) {
            if ($value['nav_location'] == 2) {
                $bottom_nav[] = $value;
            }
        }
        //获取底部导航
        Tpl::output('bottom_nav', $bottom_nav);

        /**
         * 自动登录
         */
        $this->auto_login();
    }

}

class BaseMemberControl extends Control
{
    protected $member_info = [];   // 会员信息

    public function __construct()
    {
        if (!C('site_status')) halt(C('closed_reason'));

        Language::read('common,member_layout');

        //会员验证
        $this->checkLogin();
        //输出头部的公用信息
        $this->showLayout();
        Tpl::setLayout('no_member_header_layout');

        //获得会员信息
        $this->member_info = $this->getMemberAndGradeInfo(true);
        Tpl::output('member_info', $this->member_info);

        //获取底部广告与网站标识
        $index_adv_tmp = Model('web_config')->getWebList(['web_page' => ['in', 'index_fl,index_qr,index_sign']]);
        foreach ($index_adv_tmp as $k => $v) {
            if ($v['web_show'] == 1) {
                $index_adv[$v['web_page']] = $v['web_html'];
            }
        }
        unset($index_adv_tmp);

        Tpl::output('index_adv', $index_adv);


        //获取热门搜索数据
        $setModel = Model('setting');
        $setInfo  = $setModel->where(['name' => 'hot_search'])->find();
        if (!empty($setInfo['value'])) {
            if (strstr($setInfo['value'], ',')) {
                $setInfo = explode(',', $setInfo['value']);
            } else {
                $setInfo[0] = $setInfo['value'];
            }
        }
        Tpl::output('setInfo', $setInfo);


        //获取友情链接
        $linkModel = Model('link');
        $linkInfo  = $linkModel->getLinkList();
        Tpl::output('linkInfo', $linkInfo);

        $userId = $_SESSION['member_id'];
        if (!empty($userId)) {
            //获取历史商品浏览记录
            $goodsBrowseInfo = $this->getGoodsBrowseInfo();
            Tpl::output('goodsBrowseInfo', $goodsBrowseInfo);

            //获取会员等级信息
            $userLevelInfo = $this->getUserLevelInfo();
            Tpl::output('levelInfo', $userLevelInfo);

            //获取购物车信息
            $userCartInfo = $this->getCartInfo();
            Tpl::output('cartInfo', $userCartInfo);
        }


        $left      = leftMenuList();
        $right     = rightMenuList();
        $left_menu = $left['member'];
        Tpl::output('member_sign', 'member');      // 设置会员中心导航栏当前选中的位置
        Tpl::output('right', $right);
        Tpl::output('left', $left_menu);


        // 系统消息
        $this->system_notice();
        // 页面高亮
        Tpl::output('controller', $_GET['controller']);
        /**
         * 文章
         */
        $this->article();

        /**
         * 客服分组
         */
        $this->getKefuGroupList();
    }

}

class BaseShopMemberControl extends BaseMemberControl
{
    public function __construct()
    {
        parent::__construct();
        $old_nav_list = rkcache('nav', true);
        $tree_model   = new Tree();
        $nav_list     = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

        $bottom_nav = [];
        foreach ($nav_list as $key => $value) {
            if ($value['nav_location'] == 2) {
                $bottom_nav[] = $value;
            }
        }
        //获取底部导航
        Tpl::output('bottom_nav', $bottom_nav);

        $left      = leftMenuList();
        $right     = rightMenuList();
        $left_menu = $left['member'];
        Tpl::output('member_sign', 'member');      // 设置会员中心导航栏当前选中的位置
        Tpl::output('right', $right);
        Tpl::output('left', $left_menu);

        /**
         * 客服分组
         */
        $this->getKefuGroupList();
    }
}

class BaseArticleControl extends Control
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        /**
         * 读取通用、布局的语言包
         */
        Language::read('common,core_lang_index');
        //输出会员信息
        $this->member_info = $this->getMemberAndGradeInfo(true);
        Tpl::output('member_info', $this->member_info);

        /**
         * 设置布局文件内容
         */
        Tpl::setLayout('article_layout');

        /**
         * 获取导航
         */
        Tpl::output('nav_list', rkcache('nav', true));

        /**
         *  输出头部的公用信息
         */
        $this->showLayout();

        /**
         * 文章
         */
        $this->article();


        //获取底部广告与网站标识
        $index_adv_tmp = Model('web_config')->getWebList(['web_page' => ['in', 'index_fl,index_qr,index_sign']]);
        foreach ($index_adv_tmp as $k => $v) {
            if ($v['web_show'] == 1) {
                $index_adv[$v['web_page']] = $v['web_html'];
            }
        }
        unset($index_adv_tmp);

        Tpl::output('index_adv', $index_adv);


        //获取热门搜索数据
        $setModel = Model('setting');
        $setInfo  = $setModel->where(['name' => 'hot_search'])->find();
        if (!empty($setInfo['value'])) {
            if (strstr($setInfo['value'], ',')) {
                $setInfo = explode(',', $setInfo['value']);
            } else {
                $setInfo[0] = $setInfo['value'];
            }
        }
        Tpl::output('setInfo', $setInfo);

        $old_nav_list = rkcache('nav', true);
        $tree_model   = new Tree();
        $nav_list     = $tree_model->toTree($old_nav_list, 'nav_id', 'nav_pid');

        $bottom_nav = [];
        foreach ($nav_list as $key => $value) {
            if ($value['nav_location'] == 2) {
                $bottom_nav[] = $value;
            }
        }
        //获取底部导航
        Tpl::output('bottom_nav', $bottom_nav);

        //获取底部广告
        $article_right_ad = $this->getBannerList(29, 44);
        Tpl::output('article_right_ad', $article_right_ad);
        $banner_a = $this->getBannerList(80);
        Tpl::output('banner_a', $banner_a);
        $banner_b = $this->getBannerList(81);
        Tpl::output('banner_b', $banner_b);
        $banner_c = $this->getBannerList(82);
        Tpl::output('banner_c', $banner_c);

        $ad_a = $this->getBannerList(78);
        Tpl::output('ad_a', $ad_a);

        $ad_b = $this->getBannerList(79);
        Tpl::output('ad_b', $ad_b);

        //获取友情链接
        $linkModel = Model('link');
        $linkInfo  = $linkModel->getLinkList();
        Tpl::output('linkInfo', $linkInfo);

        $userId = $_SESSION['member_id'];
        if (!empty($userId)) {
            //获取历史商品浏览记录
            $goodsBrowseInfo = $this->getGoodsBrowseInfo();
            Tpl::output('goodsBrowseInfo', $goodsBrowseInfo);

            //获取会员等级信息
            $userLevelInfo = $this->getUserLevelInfo();
            Tpl::output('levelInfo', $userLevelInfo);

            //获取购物车信息
            $userCartInfo = $this->getCartInfo();
            Tpl::output('cartInfo', $userCartInfo);
        }

        /**
         * 客服分组
         */
        $this->getKefuGroupList();

    }

}
