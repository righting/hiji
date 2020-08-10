<?php
/**
 * 微分销商城
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 10:12
 */

defined('ByCCYNet') or exit('Access Invalid!');

class subsidyControl extends BaseMemberControl
{
    public function __construct()
    {
        parent::__construct();
        Language::read('member_distribution');//读取语言配置
        Tpl::output('member_sign', 'member');//设置当前导航栏
        $left      = leftMenuList();
        $left_menu = $left['member'];
        Tpl::output('left', $left_menu); //设置当前栏目左侧菜单
        Tpl::output('current_active_name', 'subsidy');
        define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);
    }

    public function indexOp()
    {
        $user_id          = $_SESSION['member_id'];
        $model            = Model('subsidy');
        $where['user_id'] = $user_id;
        $info             = $model->where($where)->select();
        $show_type        = 0;
        if (empty($info)) {
            $show_type = 3;
        } else if (!in_array(1, array_column($info, 'type_id'))) {
            $show_type = 1;
        } else if (!in_array(2, array_column($info, 'type_id'))) {
            $show_type = 2;
        }
        $new_list = array_combine(array_column($info, 'type_id'), $info);


        //获取消费养老金和车房梦想金的分红数据
        $model_bonus_log       = Model('user_bonus_log');
        $bonusWhere['user_id'] = $_SESSION['member_id'];
        $bonusWhere['type']    = ['in', [21, 22]];
        $bonusWhere['money']   = ['gt', 0];
        $bonusCount            = $model_bonus_log->where($bonusWhere)->order('updated_at desc')->select();
        Tpl::output('show_type', $show_type); //设置当前栏目左侧菜单
        Tpl::output('new_list', $new_list);
        Tpl::output('bonusCount', $bonusCount);
        Tpl::output('webTitle', ' - 我的消费补贴');
        Tpl::showpage('subsidy/index');
    }

    public function getApplyFormAlertOp()
    {
        $type = $_GET['type'];
        if (!in_array(intval($type), [1, 2])) {
            showDialog('请求异常', '', 'error');
        }

        $user_id          = $_SESSION['member_id'];
        $model            = Model('subsidy');
        $where['user_id'] = $user_id;
        $where['type_id'] = $type;
        $info             = $model->where($where)->select();

        $proportion = empty($info)?10:$info[0]['proportion'];

        $close_type = 'subsidy_yl';
        if ($type == 2) {
            $close_type = 'subsidy_cf';
        }
        Tpl::output('proportion', $proportion); //设置当前栏目左侧菜单
        Tpl::output('type', $type); //设置当前栏目左侧菜单
        Tpl::output('close_type', $close_type); //设置当前栏目左侧菜单
        Tpl::showpage('subsidy/apply', 'null_layout');
    }

    public function applyOp()
    {
        $user_id = $_SESSION['member_id'];
        $type    = intval($_POST['type_id']);
        if (!in_array($type, [1, 2])) {
            showDialog('请求异常', '', 'error');
        }
        $proportion = intval($_POST['proportion']);
        if (!in_array($proportion, [0, 10, 20, 30, 40, 50])) {
            showDialog('请求异常', '', 'error');
        }
        // 检查当前用户是否已经申请了当前消费资本项目
        $model            = Model('subsidy');
        $where['user_id'] = $user_id;
        $where['type_id'] = $type;
        $info             = $model->where($where)->find();
        if ($info) {
            showDialog('请不要重复申请此项目', '', 'error');
        }
        $date               = date('Y-m-d H:i:s');
        $data['user_id']    = $user_id;
        $data['type_id']    = $type;
        $data['created_at'] = $date;
        $data['updated_at'] = $date;
        $data['proportion'] = $proportion;
        if ($model->insert($data)) {
            showDialog('申请成功', 'reload', 'js');
        }
        showDialog('申请失败，请稍后再试', '', 'error');
    }

}