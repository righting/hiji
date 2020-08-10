<?php
/**
 * 物流自提服务站父类
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
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

    //获取页面底部文章信息
    public function getFooterArticleInfo()
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


}

class BaseHjbControl extends Control
{

    public function __construct()
    {
        //设置布局
        Tpl::setLayout('home_layout');

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

        $mid_nav = [];
        foreach ($old_nav_list as $key => $value) {
            if ($value['nav_modue'] == 5) {
                $mid_nav[] = $value;
            }
        }
        //获中部导航
        Tpl::output('mid_nav', $mid_nav);

        //获取底部信息
        $this->getFooterArticleInfo();
        //获取底部广告与网站标识
        $index_adv_tmp = Model('web_config')->getWebList(['web_page' => ['in', 'index_fl,index_qr,index_sign']]);
        foreach ($index_adv_tmp as $k => $v) {
            if ($v['web_show'] == 1) {
                $index_adv[$v['web_page']] = $v['web_html'];
            }
        }
        unset($index_adv_tmp);
        Tpl::output('index_adv', $index_adv);


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
}
