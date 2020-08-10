<?php
/**
 * 页面导航管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class navigationControl extends SystemControl
{
    public function __construct()
    {
        parent::__construct();
        Language::read('navigation');
    }

    public function indexOp()
    {
        $type = $_GET['type'];
        $type = in_array($type, array('0', '1', '2')) ? $_GET['type'] : 0;
        $this->navigationOp($type);
    }

    /**
     * 页面导航
     */
    public function navigationOp($type)
    {
        $lang = Language::getLangContent();
        $model_navigation = Model('navigation');
        /**
         * 检索条件
         */
        $condition['like_nav_title'] = trim($_GET['search_nav_title']);
        $condition['nav_location'] = trim($_GET['search_nav_location']);
        in_array($type, array('0', '1', '2')) && $condition['nav_location'] = $type;
        $condition['order'] = 'nav_sort asc';
        $condition['limit'] = 100;
//        $navigation_list = $model_navigation->getNavigationList($condition);

        $navigation_list = $model_navigation->getTreeList($condition);
        /**
         * 整理内容
         */
        if (is_array($navigation_list)) {
            foreach ($navigation_list as $k => $v) {
                switch ($v['nav_location']) {
                    case '0':
                        $navigation_list[$k]['nav_location'] = $lang['navigation_index_top'];
                        break;
                    case '1':
                        $navigation_list[$k]['nav_location'] = $lang['navigation_index_center'];
                        break;
                    case '2':
                        $navigation_list[$k]['nav_location'] = $lang['navigation_index_bottom'];
                        break;
                }
            }
        }

//        $tree_model = Model('tree');
        $tree_model = new Tree();
        $navigation_list = $tree_model->toTree($navigation_list, 'nav_id', 'nav_pid');
//        print_r($navigation_list);die;
        Tpl::output('type', $type);
        Tpl::output('navigation_list', $navigation_list);
        Tpl::output('search_nav_title', trim($_GET['search_nav_title']));
        Tpl::output('search_nav_location', trim($_GET['search_nav_location']));
        Tpl::setDirquna('system');
        Tpl::showpage('navigation.index');
    }

    /**
     * 页面导航 添加
     */
    public function navigation_addOp()
    {
        $lang = Language::getLangContent();
        $model_navigation = Model('navigation');
        /**
         * 自定义导航可选父级(只允许设置两级)
         */
        $navigation_where['nav_type'] = 0;
        $navigation_where['nav_pid'] = 0;
        //$navigation_where['nav_location'] = 1;
        $navigation_type_list = $model_navigation->getNavigationList($navigation_where);
        if (chksubmit()) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["nav_title"], "require" => "true", "message" => $lang['navigation_add_partner_null']),
                array("input" => $_POST["nav_sort"], "require" => "true", 'validator' => 'Number', "message" => $lang['navigation_add_sort_int']),
            );
            switch ($_POST['nav_type']) {
                /**
                 * 自定义
                 */
                case '0':
                    //$obj_validate->setValidate(array("input"=>$_POST["nav_url"], 'validator'=>'Url', "message"=>$lang['navigation_add_url_wrong']));
                    break;
                /**
                 * 商品分类
                 */
                case '1':
                    $obj_validate->setValidate(array("input" => $_POST["goods_class_id"], "require" => "true", "message" => $lang['navigation_add_goods_class_null']));
                    break;
                /**
                 * 文章分类
                 */
                case '2':
                    $obj_validate->setValidate(array("input" => $_POST["article_class_id"], "require" => "true", "message" => $lang['navigation_add_article_class_null']));
                    break;
                /**
                 * 活动
                 */
                case '3':
                    $obj_validate->setValidate(array("input" => $_POST["activity_id"], "require" => "true", "message" => $lang['navigation_add_activity_null']));
                    break;
            }

            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage($error);
            } else {
                $insert_array = array();

                // 检查提交的父级id是否为0或是否是可以选的id
                $navigation_type_group = [];
                if (!empty($navigation_type_list)) {
                    foreach ($navigation_type_list as $k => $v) {
                        $navigation_type_group[$v['nav_id']] = $v['nav_title'];
                    }
                }

                // 只有导航类型选择"自定义导航"、所在位置选择"中部"的时候才可以选择父级id
                $nav_type = trim($_POST['nav_type']);
                $nav_location = trim($_POST['nav_location']);
                $pid = intval($_POST['nav_pid']);
                if ($nav_type != 0 /*|| $nav_location != 1*/) {
                    // 如果不是 自定义导航 且所在位置不是 中部 ；不可以选择父级id
                    if ($pid != 0) {
                        showMessage($lang['navigation_add_can_not_selected']);
                    }
                } else {
                    // 如果是 自定义导航 且所在位置是 中部 且选择了父级 id
                    if ($pid != 0) {
                        if (!in_array($pid, array_keys($navigation_type_group))) {
                            showMessage($lang['navigation_add_pid_null']);
                        }
                    }
                }

                $insert_array['nav_modue'] = trim($_POST['nav_modue']);
                $insert_array['nav_type'] = $nav_type;
                $insert_array['nav_title'] = trim($_POST['nav_title']);
                $insert_array['nav_location'] = $nav_location;
                $insert_array['nav_new_open'] = trim($_POST['nav_new_open']);
                $insert_array['nav_sort'] = trim($_POST['nav_sort']);
                $insert_array['nav_pid'] = $pid;
                switch ($_POST['nav_type']) {
                    /**
                     * 自定义
                     */
                    case '0':
                        $insert_array['nav_url'] = trim($_POST['nav_url']);
                        break;
                    /**
                     * 商品分类
                     */
                    case '1':
                        $insert_array['item_id'] = intval($_POST['goods_class_id']);
                        break;
                    /**
                     * 文章分类
                     */
                    case '2':
                        $insert_array['item_id'] = intval($_POST['article_class_id']);
                        break;
                    /**
                     * 活动
                     */
                    case '3':
                        $insert_array['item_id'] = intval($_POST['activity_id']);
                        break;
                }

                $result = $model_navigation->add($insert_array);
                if ($result) {
                    dkcache('nav');
                    $url = array(
                        array(
                            'url' => 'index.php?controller=navigation&action=navigation_add',
                            'msg' => $lang['navigation_add_again'],
                        ),
                        array(
                            'url' => 'index.php?controller=navigation&action=navigation',
                            'msg' => $lang['navigation_add_back_to_list'],
                        )
                    );
                    $this->log(L('navigation_add_succ') . '[' . $_POST['nav_title'] . ']', null);
                    showMessage($lang['navigation_add_succ'], $url);
                } else {
                    showMessage($lang['navigation_add_fail']);
                }
            }
        }

        /**
         * 商品分类
         */
        $model_goods_class = Model('goods_class');
        $goods_class_list = $model_goods_class->getTreeClassList(3);
        if (is_array($goods_class_list)) {
            foreach ($goods_class_list as $k => $v) {
                $goods_class_list[$k]['gc_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['gc_name'];
            }
        }
        /**
         * 文章分类
         */
        $model_article_class = Model('article_class');
        $article_class_list = $model_article_class->getTreeClassList(2);
        if (is_array($article_class_list)) {
            foreach ($article_class_list as $k => $v) {
                $article_class_list[$k]['ac_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['ac_name'];
            }
        }
        /**
         * 活动
         */
        $activity = Model('activity');
        $activity_list = $activity->getList(array('opening' => true, 'order' => 'activity.activity_sort'));
        Tpl::output('activity_list', $activity_list);
        Tpl::output('goods_class_list', $goods_class_list);
        Tpl::output('article_class_list', $article_class_list);
        Tpl::output('navigation_type_list', $navigation_type_list);
        Tpl::setDirquna('system');
        Tpl::showpage('navigation.add');
    }

    /**
     * 页面导航 编辑
     */
    public function navigation_editOp()
    {
        $lang = Language::getLangContent();
        $model_navigation = Model('navigation');
        /**
         * 自定义导航可选父级(只允许设置两级)
         */
        $navigation_where['nav_type'] = 0;
        $navigation_where['nav_pid'] = 0;
        //$navigation_where['nav_location'] = 1;
        $navigation_type_list = $model_navigation->getNavigationList($navigation_where);

        if (chksubmit()) {
            $nav_id = intval($_POST['nav_id']);
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["nav_title"], "require" => "true", "message" => $lang['navigation_add_partner_null']),
                array("input" => $_POST["nav_sort"], "require" => "true", 'validator' => 'Number', "message" => $lang['navigation_add_sort_int']),
            );
            switch ($_POST['nav_type']) {
                /**
                 * 自定义
                 */
                case '0':
                    //$obj_validate->setValidate(array("input"=>$_POST["nav_url"], 'validator'=>'Url', "message"=>$lang['navigation_add_url_wrong']));
                    break;
                /**
                 * 商品分类
                 */
                case '1':
                    $obj_validate->setValidate(array("input" => $_POST["goods_class_id"], "require" => "true", "message" => $lang['navigation_add_goods_class_null']));
                    break;
                /**
                 * 文章分类
                 */
                case '2':
                    $obj_validate->setValidate(array("input" => $_POST["article_class_id"], "require" => "true", "message" => $lang['navigation_add_article_class_null']));
                    break;
            }

            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage($error);
            } else {
                $navigation_array = $model_navigation->getOneNavigation($nav_id);
                if (empty($navigation_array)) {
                    showMessage($lang['param_error']);
                }

                // 检查提交的父级id是否为0或是否是可以选的id
                $navigation_type_group = [];
                if (!empty($navigation_type_list)) {
                    foreach ($navigation_type_list as $k => $v) {
                        $navigation_type_group[$v['nav_id']] = $v['nav_title'];
                    }
                }

                // 只有导航类型选择"自定义导航"、所在位置选择"中部"的时候才可以选择父级id
                $nav_type = trim($_POST['nav_type']);
                $nav_location = trim($_POST['nav_location']);
                $pid = intval($_POST['nav_pid']);
                if ($nav_type != 0 /*|| $nav_location != 1*/) {
                    if ($pid != 0) {
                        showMessage($lang['navigation_add_can_not_selected']);
                    }
                } else {
                    if ($pid != 0) {
                        if (!in_array($pid, array_keys($navigation_type_group))) {
                            showMessage($lang['navigation_add_pid_null']);
                        }
                    }
                }

                $update_array = array();
                $insert_array['nav_modue'] = trim($_POST['nav_modue']);
                $update_array['nav_id'] = intval($_POST['nav_id']);
                $update_array['nav_type'] = trim($_POST['nav_type']);
                $update_array['nav_title'] = trim($_POST['nav_title']);
                $update_array['nav_location'] = trim($_POST['nav_location']);
                $update_array['nav_new_open'] = trim($_POST['nav_new_open']);
                $update_array['nav_sort'] = trim($_POST['nav_sort']);
                $update_array['nav_pid'] = $pid;
                switch ($_POST['nav_type']) {
                    /**
                     * 自定义
                     */
                    case '0':
                        $update_array['nav_url'] = trim($_POST['nav_url']);
                        break;
                    /**
                     * 商品分类
                     */
                    case '1':
                        $update_array['item_id'] = intval($_POST['goods_class_id']);
                        break;
                    /**
                     * 文章分类
                     */
                    case '2':
                        $update_array['item_id'] = intval($_POST['article_class_id']);
                        break;
                    /**
                     * 活动
                     */
                    case '3':
                        $update_array['item_id'] = intval($_POST['activity_id']);
                        break;
                }
                $result = $model_navigation->updates($update_array);
                if ($result) {
                    dkcache('nav');
                    $url = array(
                        array(
                            'url' => 'index.php?controller=navigation&action=navigation_edit&nav_id=' . intval($_POST['nav_id']),
                            'msg' => $lang['navigation_edit_again'],
                        ),
                        array(
                            'url' => 'index.php?controller=navigation&action=navigation',
                            'msg' => $lang['navigation_add_back_to_list'],
                        )
                    );
                    $this->log(L('navigation_edit_succ') . '[' . $_POST['nav_title'] . ']', null);
                    showMessage($lang['navigation_edit_succ'], $url);
                } else {
                    showMessage($lang['navigation_edit_fail']);
                }
            }
        }
        $navigation_array = $model_navigation->getOneNavigation(intval($_GET['nav_id']));
        if (empty($navigation_array)) {
            showMessage($lang['param_error']);
        }

        /**
         * 商品分类
         */
        $model_goods_class = Model('goods_class');
        $goods_class_list = $model_goods_class->getTreeClassList(3);
        if (is_array($goods_class_list)) {
            foreach ($goods_class_list as $k => $v) {
                $goods_class_list[$k]['gc_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['gc_name'];
            }
        }
        /**
         * 文章分类
         */
        $model_article_class = Model('article_class');
        $article_class_list = $model_article_class->getTreeClassList(2);
        if (is_array($article_class_list)) {
            foreach ($article_class_list as $k => $v) {
                $article_class_list[$k]['ac_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['ac_name'];
            }
        }
        /**
         * 活动
         */
        $activity = Model('activity');
        $activity_list = $activity->getList(array('opening' => true, 'order' => 'activity.activity_sort'));
        Tpl::output('activity_list', $activity_list);
        Tpl::output('navigation_array', $navigation_array);
        Tpl::output('goods_class_list', $goods_class_list);
        Tpl::output('article_class_list', $article_class_list);
        Tpl::output('navigation_type_list', $navigation_type_list);
        Tpl::setDirquna('system');
        Tpl::showpage('navigation.edit');
    }

    /**
     * 删除页面导航
     */
    public function navigation_delOp()
    {
        $lang = Language::getLangContent();
        $model_navigation = Model('navigation');
        if (preg_match('/^[\d,]+$/', $_GET['nav_id'])) {
            $_GET['nav_id'] = explode(',', trim($_GET['nav_id'], ','));
            $model_navigation->del(array('nav_id' => array('in', $_GET['nav_id'])));
            dkcache('nav');
            $this->log(L('article_index_del_succ') . '[ID:' . implode(',', $_GET['nav_id']) . ']', null);
            showMessage($lang['navigation_index_del_succ'], 'index.php?controller=navigation&action=navigation');
        } else {
            showMessage($lang['navigation_index_choose_del'], 'index.php?controller=navigation&action=navigation');
        }
    }

    /**
     * ajax操作
     */
    public function ajaxOp()
    {
        $model_navigation = Model('navigation');
        $update_array = array();
        $update_array['nav_id'] = intval($_GET['id']);
        $update_array['nav_sort'] = trim($_GET['value']);
        $result = $model_navigation->updates($update_array);
        if ($result) {
            dkcache('nav');
            echo json_encode(array('result' => true));
            exit;
        }
    }
}
