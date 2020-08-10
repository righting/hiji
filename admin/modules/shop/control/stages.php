<?php
/**
 * 统计管理（销量分析）
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stagesControl extends SystemControl
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexOp()
    {
        Tpl::setDirquna('shop');

        $get_type = $_GET['get_type'];
        $model    = new stagesModel();

        $page      = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        $lists     = $model->page($page_size)->order('id asc')->select();
        // 获取这一页信息
        $new_list = [];
        if (!empty($lists)) {
            foreach ($lists as $k => $v) {
                $new_list[$k]['id']          = '第 ' . ($k + 1) . ' 期';
                $new_list[$k]['start_time']  = $v['start_time'];
                $new_list[$k]['end_time']    = $v['end_time'];
                $new_list[$k]['total_money'] = ($v['status'] == 1) ? '' : $v['total_money'];
                $new_list[$k]['money']       = ($v['status'] == 1) ? '' : $v['money'];
                $new_list[$k]['status']      = ($v['status'] == 1) ? '进行中' : '已闭环';
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $model->count();
            $data['list']      = $new_list;
            echo Tpl::flexigridXML($data);
            die;
        }
        Tpl::showpage('stages/index');
    }

}
