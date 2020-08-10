<?php
/**
 * 帮助中心     2018-07-12      LFP
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class help_storeControl extends BaseArticleControl
{
    /**
     * 默认进入页面
     */
    public function indexOp()
    {
        /**
         * 读取语言包
         */
        Language::read('home_help_index');
        if (!empty($_GET['article_id'])) {
            $this->showOp();
            exit;
        }
        if (!empty($_GET['ac_id'])) {
            $this->helpOp();
            exit;
        }
        showMessage(Language::get('article_article_not_found'), '', 'html', 'error');//'没有符合条件的文章'
    }

    /**
     * 帮助中心列表显示页面
     */
    public function helpOp()
    {
        $ac_id = $_GET['ac_id'];
        /**
         * 读取语言包
         */
        Language::read('home_help_index');
        $lang = Language::getLangContent();

        /**
         * 得到导航ID
         */
        $nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0;
        Tpl::output('index_sign', 44);
        /**
         * 根据类别编号获取文章类别信息
         */
        $article_class_model = Model('help_class');
        $condition           = [];
        if (!empty($ac_id)) {
            $condition['ac_id'] = intval($ac_id);
            $article_class      = $article_class_model->getOneClass(intval($ac_id));//echo '<pre>';print_r($article_class);exit;
            Tpl::output('class_name', $article_class['ac_name']);
            if (empty($article_class) || !is_array($article_class)) {
                showMessage($lang['article_article_class_not_exists'], '', 'html', 'error');//'该文章分类并不存在'
            }
            $default_count = 5;//定义最新文章列表显示文章的数量
            /**
             * 分类导航
             */
            $nav_link = [
                [
                    'title' => $lang['homepage'],
                    'link'  => SHOP_SITE_URL
                ],
                [
                    'title' => $article_class['ac_name']
                ]
            ];
        }


        Tpl::output('nav_link_list', $nav_link);

        /**
         * 左侧分类导航
         */
        $condition          = [];
        $condition['ac_id'] = 2;
        $sub_class_list     = $article_class_model->getClassList($condition);
        if (empty($sub_class_list) || !is_array($sub_class_list)) {

            $sub_class_list = $article_class_model->getClassList($condition);
        }
        foreach ($sub_class_list as $k => &$v) {
            if (empty($ac_id)) {
                $ac_id = $v['ac_id'];
            }
            $condition                 = [];
            $condition['ac_parent_id'] = $v['ac_id'];
            $sub_class_list[$k]['sub'] = $article_class_model->getClassList($condition);
            foreach ($v['sub'] as $kk => &$vv) {
                if (empty($ac_id)) {
                    $ac_id = $vv['ac_id'];
                }
                $condition                             = [];
                $condition['ac_parent_id']             = $vv['ac_id'];
                $sub_class_list[$k]['sub'][$kk]['sub'] = $article_class_model->getClassList($condition);
                foreach ($sub_class_list[$k]['sub'][$kk]['sub'] as $kkk => &$vvv) {
                    if (empty($ac_id)) {
                        $ac_id = $vvv['ac_id'];
                    }
                    $condition                                          = [];
                    $condition['ac_parent_id']                          = $vvv['ac_id'];
                    $sub_class_list[$k]['sub'][$kk]['sub'][$kkk]['sub'] = $article_class_model->getClassList($condition);
                    $ac_ids[]                                           = $vvv['ac_id'];

                }

            }
        }
        Tpl::output('sub_class_list', $sub_class_list);

        $page_model = Model('page');
        $page       = $page_model->getOneArticleKey('service_store');//echo '<pre>';print_r($page);exit;
        Tpl::output('default_page', $page);
        //echo '<pre>';print_r($page);exit;
        $ac_ids                    = implode(',', $ac_ids);
        $help_model                = Model('newhelp');
        $condition                 = [];
        $condition['ac_ids']       = $ac_ids;
        $condition['article_show'] = '1';
        $page                      = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        $article_list = $help_model->getArticleList($condition, $page);
        Tpl::output('article', $article_list);
        $condition                 = [];
        $condition['ac_ids']       = $ac_ids;
        $condition['common']       = '1';
        $condition['article_show'] = '1';
        $article_list              = $help_model->getArticleList($condition);
        Tpl::output('article_common', $article_list);
        Tpl::output('show_page', $page->show());
        $pid = $_GET['pid'] ? $_GET['pid'] : 0;
        Tpl::output('pid', $pid);
        Tpl::output('type', 'store');
        Model('seo')->type('help')->param(['article_class' => $article_class['ac_name']])->show();
        Tpl::showpage('help_store_list', 'null_layout');
    }

    /**
     * 单篇文章显示页面
     */
    public function showOp()
    {
        /**
         * 读取语言包
         */
        Language::read('home_help_index');
        $lang = Language::getLangContent();
        if (empty($_GET['article_id'])) {
            showMessage($lang['para_error'], '', 'html', 'error');//'缺少参数:文章编号'
        }
        /**
         * 根据文章编号获取文章信息
         */
        $article_model = Model('newhelp');
        $article       = $article_model->getOneArticle(intval($_GET['article_id']));
        if (empty($article) || !is_array($article) || $article['article_show'] == '0') {
            showMessage($lang['article_show_not_exists'], '', 'html', 'error');//'该文章并不存在'
        }
        Tpl::output('article', $article);//echo '<pre>';print_r($article);exit;

        /**
         * 根据类别编号获取文章类别信息
         */
        $article_class_model = Model('help_class');
        $condition           = [];
        $article_class       = $article_class_model->getOneClass($article['ac_id']);
        if (empty($article_class) || !is_array($article_class)) {
            showMessage($lang['article_show_delete'], '', 'html', 'error');//'该文章已随所属类别被删除'
        }
        $default_count = 5;//定义最新文章列表显示文章的数量
        /**
         * 分类导航
         */
        $nav_link = [
            [
                'title' => $lang['homepage'],
                'link'  => SHOP_SITE_URL
            ],
            [
                'title' => $article_class['ac_name'],
                'link'  => urlMember('article', 'article', ['ac_id' => $article_class['ac_id']])
            ],
            [
                'title' => $lang['article_show_article_content']
            ]
        ];
        Tpl::output('nav_link_list', $nav_link);
        /**
         * 左侧分类导航
         */
        $condition          = [];
        $condition['ac_id'] = 2;
        $sub_class_list     = $article_class_model->getClassList($condition);
        if (empty($sub_class_list) || !is_array($sub_class_list)) {

            $condition['ac_parent_id'] = $article_class['ac_parent_id'];
            $sub_class_list            = $article_class_model->getClassList($condition);
        }
        $article_model = Model('newhelp');
        foreach ($sub_class_list as $k => &$v) {
            if (empty($ac_id)) {
                $ac_id = $v['ac_id'];
            }
            $condition                 = [];
            $condition['ac_parent_id'] = $v['ac_id'];
            $sub_class_list[$k]['sub'] = $article_class_model->getClassList($condition);
            foreach ($v['sub'] as $kk => &$vv) {
                if (empty($ac_id)) {
                    $ac_id = $vv['ac_id'];
                }
                $condition                             = [];
                $condition['ac_parent_id']             = $vv['ac_id'];
                $sub_class_list[$k]['sub'][$kk]['sub'] = $article_class_model->getClassList($condition);
                foreach ($sub_class_list[$k]['sub'][$kk]['sub'] as $kkk => &$vvv) {
                    if (empty($ac_id)) {
                        $ac_id = $vvv['ac_id'];
                    }
                    $condition                                          = [];
                    $condition['ac_parent_id']                          = $vvv['ac_id'];
                    $sub_class_list[$k]['sub'][$kk]['sub'][$kkk]['sub'] = $article_class_model->getClassList($condition);
                    $ac_ids[]                                           = $vvv['ac_id'];

                }

            }
        }
        Tpl::output('sub_class_list', $sub_class_list);

        $cate_bread = $sub_class_list[0]['sub'];

        //dump($cate_bread);

        $_ac_parent_name='';
        $_ac_name='';
        foreach ($cate_bread as $kj => $valj) {
            if ($valj['ac_id'] == $article['ac_id']) {
                $_ac_parent_name = $valj['ac_name'];
                break;
            } elseif (!empty($valj['sub'])) {
                foreach ($valj['sub'] as $kkj => $vj) {
                    if ($vj['ac_id'] == $article['ac_id']) {
                        $_ac_name = $vj['ac_name'];
                        $_ac_parent_name = $valj['ac_name'];
                        break;
                    } elseif (!empty($vj['sub'])) {
                        foreach ($vj['sub'] as $jj => $vvj) {
                            if ($vvj['ac_id'] == $article['ac_id']) {
                                $_ac_name = $vvj['ac_name'];
                                $_ac_parent_name = $vj['ac_name'];
                                break;
                            }
                        }
                    }
                }
            }
        }
        Tpl::output('_ac_parent_name', $_ac_parent_name);
        Tpl::output('_ac_name', $_ac_name);

        $ac_ids                    = implode(',', $ac_ids);
        $article_model             = Model('newhelp');
        $condition                 = [];
        $condition['ac_ids']       = $ac_ids;
        $condition['article_show'] = '1';
        $article_list              = $article_model->getArticleList($condition);
        /**
         * 寻找上一篇与下一篇
         */
//        $pre_article    = $next_article = array();
//        if(!empty($article_list) && is_array($article_list)){
//            $pos    = 0;
//            foreach ($article_list as $k=>$v){
//                if($v['article_id'] == $article['article_id']){
//                    $pos    = $k;
//                    break;
//                }
//            }
//            if($pos>0 && is_array($article_list[$pos-1])){
//                $pre_article    = $article_list[$pos-1];
//            }
//            if($pos<count($article_list)-1 and is_array($article_list[$pos+1])){
//                $next_article   = $article_list[$pos+1];
//            }
//        }echo '<pre>';print_r($sub_class_list);exit;
        $condition                 = [];
        $condition['ac_ids']       = $ac_ids;
        $condition['article_show'] = '1';
        $article_list              = $article_model->getArticleList($condition);
        Tpl::output('article_common', $article_list);
        Tpl::output('pre_article', $pre_article);
        Tpl::output('next_article', $next_article);
        $pid = $_GET['pid'] ? $_GET['pid'] : 0;
        Tpl::output('pid', $pid);
        Tpl::output('type', 'store');
        $seo_param                  = [];
        $seo_param['name']          = $article['article_title'];
        $seo_param['article_class'] = $article_class['ac_name'];
        Model('seo')->type('article_content')->param($seo_param)->show();
        Tpl::showpage('help_store_show', 'null_layout');
    }


    /**
     * 单篇文章显示页面
     */
    public function show_listOp()
    {
        /**
         * 读取语言包
         */
        Language::read('home_help_index');
        $lang = Language::getLangContent();
        if (empty($_GET['ac_id'])) {
            showMessage($lang['para_error'], '', 'html', 'error');//'缺少参数:文章编号'
        }
        $article_class_model = Model('help_class');


        $default_count = 5;//定义最新文章列表显示文章的数量

        /**
         * 左侧分类导航
         */
        $condition          = [];
        $condition['ac_id'] = 2;
        $sub_class_list     = $article_class_model->getClassList($condition);

        $article_model = Model('newhelp');
        foreach ($sub_class_list as $k => &$v) {
            if (empty($ac_id)) {
                $ac_id = $v['ac_id'];
            }
            $condition                 = [];
            $condition['ac_parent_id'] = $v['ac_id'];
            $sub_class_list[$k]['sub'] = $article_class_model->getClassList($condition);
            foreach ($v['sub'] as $kk => &$vv) {
                if (empty($ac_id)) {
                    $ac_id = $vv['ac_id'];
                }
                $condition                             = [];
                $condition['ac_parent_id']             = $vv['ac_id'];
                $sub_class_list[$k]['sub'][$kk]['sub'] = $article_class_model->getClassList($condition);
                foreach ($sub_class_list[$k]['sub'][$kk]['sub'] as $kkk => &$vvv) {
                    if (empty($ac_id)) {
                        $ac_id = $vvv['ac_id'];
                    }
                    $condition                                          = [];
                    $condition['ac_parent_id']                          = $vvv['ac_id'];
                    $sub_class_list[$k]['sub'][$kk]['sub'][$kkk]['sub'] = $article_class_model->getClassList($condition);
                    $ac_ids[]                                           = $vvv['ac_id'];

                }

            }
        }
        Tpl::output('sub_class_list', $sub_class_list);//echo '<pre>';print_r($sub_class_list);exit;

        $cate_bread = $sub_class_list[0]['sub'];

        //dump($cate_bread);

        $_ac_parent_name='';
        $_ac_name='';
        foreach ($cate_bread as $kj => $valj) {
            if ($valj['ac_id'] == $_GET['ac_id']) {
                $_ac_parent_name = $valj['ac_name'];
                break;
            } elseif (!empty($valj['sub'])) {
                foreach ($valj['sub'] as $kkj => $vj) {
                    if ($vj['ac_id'] == $_GET['ac_id']) {
                        $_ac_name = $vj['ac_name'];
                        $_ac_parent_name = $valj['ac_name'];
                        break;
                    } elseif (!empty($vj['sub'])) {
                        foreach ($vj['sub'] as $jj => $vvj) {
                            if ($vvj['ac_id'] == $_GET['ac_id']) {
                                $_ac_name = $vvj['ac_name'];
                                $_ac_parent_name = $vj['ac_name'];
                                break;
                            }
                        }
                    }
                }
            }
        }
        Tpl::output('_ac_parent_name', $_ac_parent_name);
        Tpl::output('_ac_name', $_ac_name);

        $ac_ids                    = implode(',', $ac_ids);
        $article_model             = Model('newhelp');
        $condition                 = [];
        $condition['ac_id']        = $_GET['ac_id'];
        $condition['article_show'] = '1';
        $article_list              = $article_model->getArticleList($condition);
        Tpl::output('article_list', $article_list);
        /**
         * 寻找上一篇与下一篇
         */
//        $pre_article    = $next_article = array();
//        if(!empty($article_list) && is_array($article_list)){
//            $pos    = 0;
//            foreach ($article_list as $k=>$v){
//                if($v['article_id'] == $article['article_id']){
//                    $pos    = $k;
//                    break;
//                }
//            }
//            if($pos>0 && is_array($article_list[$pos-1])){
//                $pre_article    = $article_list[$pos-1];
//            }
//            if($pos<count($article_list)-1 and is_array($article_list[$pos+1])){
//                $next_article   = $article_list[$pos+1];
//            }
//        }echo '<pre>';print_r($sub_class_list);exit;
        $condition                 = [];
        $condition['ac_ids']       = $ac_ids;
        $condition['article_show'] = '1';
        $article_list              = $article_model->getArticleList($condition);
        Tpl::output('article_common', $article_list);
        //Tpl::output('pre_article',$pre_article);
        //Tpl::output('next_article',$next_article);
        $pid = $_GET['pid'] ? $_GET['pid'] : 0;
        Tpl::output('pid', $pid);
        Tpl::output('type', 'store');
        $seo_param = [];
        //$seo_param['name'] = $article['article_title'];
        //$seo_param['article_class'] = $article_class['ac_name'];
        Model('seo')->type('article_content')->param($seo_param)->show();
        Tpl::showpage('help_store_show_list', 'null_layout');
    }

    /**
     * 电子会员卡片   2018-07-03      LFP
     */
    public function member_cardOp()
    {

        $member_model = Model('member');
        $user_id      = hj_decrypt($_GET['member_id']);;
        $member_info = $member_model->where(['member_id' => $user_id])->find();
        if (!$member_info) {
            showDialog('非法操作', '', 'error');
        }
        $host                         = $_SERVER['HTTP_HOST'];
        $hostArr                      = explode('.', $host);
        $member_info['wdUrl']         = C('https') ? 'https://' : 'http://' . implode('.', $hostArr) . '/shop/index.php?controller=index&action=myshop&userNumber=' . $member_info['member_number'];
        $user_level_model             = Model('user_level');
        $user_level_info              = $user_level_model->where(['id' => $member_info['level_id']])->find();
        $member_info['level']         = $user_level_info['level'];
        $member_info['level_name']    = $user_level_info['level_name'];
        $member_info['position_name'] = Model('positions')->where(['id' => $member_info['positions_id']])->find()['title'];
        //echo '<pre>';print_r($member_info);exit;

        Tpl::output('mber_info', $member_info);
        Tpl::showpage('member_card', 'null_layout');
    }
}
