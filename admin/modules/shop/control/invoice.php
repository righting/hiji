<?php
/**
 * 预存款管理
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class invoiceControl extends SystemControl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 发票管理
     */
    public function indexOp()
    {
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        $get_type       = $_GET['get_type'];
        $invoice_model  = Model('invoice');
        $list           = $invoice_model->where(['status' => 1])->page(15)->order('created_at desc')->select();
        $count          = $invoice_model->where(['status' => 1])->page(15)->order('created_at desc')->count();
        $status_info[1] = '申请中';
        $status_info[2] = '已邮寄';
        $new_list       = [];

        $model       = Model('user_invoice_info');
        $type_cn_arr = $model->geTypeInfo();
        foreach ($list as $key => $value) {
            $new_list[$key]['id']         = $value['id'];
            $new_list[$key]['user_id']    = $value['user_id'];
            $new_list[$key]['type_cn']    = $type_cn_arr[$value['type']];
            $new_list[$key]['status_cn']  = $status_info[$value['status']];
            $new_list[$key]['created_at'] = $value['created_at'];
            $new_list[$key]['view_btn']   = "<a class='btn blue' href='" . urlAdminShop('invoice', 'info', ['id' => $value['id']]) . "' ><i class='fa fa-eye'></i>详情</a>";
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $invoice_model->shownowpage();
            $data['total_num'] = $count;
            $data['list']      = $new_list;
            echo Tpl::flexigridXML($data);
            die;
        }

        Tpl::output('list', $new_list);
        Tpl::output('show_page', $invoice_model->showpage());
        Tpl::output('status_info', $status_info);
        Tpl::showpage('invoice/index');
    }

    public function infoOp()
    {
        Tpl::setDirquna('shop');
        $id            = intval($_GET['id']);
        $invoice_model = Model('invoice');
        $info          = $invoice_model->where(['id' => $id])->find();
        if (empty($info)) {
            showMessage('信息不存在');
        }
        $model           = Model('user_invoice_info');
        $info['type_cn'] = $model->geTypeInfo($info['type']);
        if (intval($info['sbh_type']) > 0) {
            $info['sbh_type_cn'] = $model->geSBHTypeInfo($info['sbh_type']);
        }
        $status_info[1]    = '申请中';
        $status_info[2]    = '已邮寄';
        $info['status_cn'] = $status_info[$info['status']];
        Tpl::output('info', $info);
        Tpl::showpage('invoice/info');
    }

    public function confirmOp()
    {
        Tpl::setDirquna('shop');
        $id    = intval($_GET['id']);
        $model = Model('invoice');
        $info  = $model->where(['id' => $id, 'status' => 1])->find();
        if (empty($info)) {
            showMessage('信息不存在或当前状态不可进行该操作');
        }
        $close_type = 'invoice_edit';
        Tpl::output('close_type', $close_type);
        Tpl::output('info', $info);
        Tpl::showpage('invoice/confirm');
    }

    public function saveOp()
    {
        if (chksubmit()) {
            $post        = $_POST;
            $id          = intval($post['id']);
            $express_num = trim($post['express_num']);
            if ($id == 0) {
                showDialog('请求异常', '', 'error');
            }
            if ($express_num == '') {
                showDialog('请填写运单号', '', 'error');
            }

            $model = Model('invoice');
            // 检查当前用户是否已经填写发票信息
            $info = $model->where(['id' => $id, 'status' => 1])->find();
            if (empty($info)) {
                showDialog('信息不存在或当前状态不可进行该操作');
                die;
            }
            // 如果不是，则新增
            $model->where(['id' => $id, 'status' => 1])->update(['express_num' => $express_num, 'status' => 2]);
            showDialog('操作成功', urlAdminShop('invoice', 'index'));
            die;
        }


    }
}
