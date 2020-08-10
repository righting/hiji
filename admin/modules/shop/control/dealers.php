<?php
/**
 * 结算管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class dealersControl extends SystemControl{
    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;


    public function __construct(){
        parent::__construct();
    }

    /**
     * 结算单列表
     *
     */
    public function indexOp(){
		Tpl::setDirquna('shop');
        
        $get_type = $_GET['get_type'];
        $dealers_model = Model('dealers');
        $list = $dealers_model->page(15)->order('created_at desc')->select();
        $count = $dealers_model->page(15)->order('created_at desc')->count();
        $status_info[1] = '申请中';
        $status_info[2] = '已回访';
        $new_list = [];

        foreach ($list as $key=>$value){
            if($value['status'] == 1){
                $new_list[$key]['operation'] = '<a class="btn orange" href="'.urlAdminShop('dealers','confirm',['id'=>$value['id']]).'"><i class="fa fa-gavel"></i>处理</a>';
            }else{
                $new_list[$key]['operation'] = '<a class="btn orange" href="'.urlAdminShop('dealers','confirm',['id'=>$value['id']]).'"><i class="fa fa-gavel"></i>详情</a>';
            }

            $new_list[$key]['id'] = $value['id'];
            $new_list[$key]['name'] = $value['name'];
            $new_list[$key]['title'] = $value['title'];
            $new_list[$key]['mobile'] = $value['mobile'];
            $new_list[$key]['address'] = $value['address'];
            $new_list[$key]['status_cn'] = $status_info[$value['status']];
            $new_list[$key]['created_at'] = $value['created_at'];

        }

        if($get_type == 'xml'){
            $data = array();
            $data['now_page'] = $dealers_model->shownowpage();
            $data['total_num'] = $count;
            $data['list'] = $new_list;
            echo Tpl::flexigridXML($data);die;
        }

        Tpl::output('list',$new_list);
        Tpl::output('show_page',$dealers_model->showpage());
        Tpl::output('status_info',$status_info);
        
        Tpl::showpage('dealers/index');
    }

    public function confirmOp(){
        Tpl::setDirquna('shop');
        $id = intval($_GET['id']);

        $model = Model('dealers');
        $info = $model->where(['id'=>$id])->find();
        if(empty($info)){
            showDialog('信息不存在或当前状态不可进行该操作');die;
        }
        $status_info[1] = '申请中';
        $status_info[2] = '已回访';
        $info['status_cn'] = $status_info[$info['status']];
        $close_type = 'dealers_edit';
        Tpl::output('close_type',$close_type);
        Tpl::output('info',$info);

        Tpl::showpage('dealers/confirm');
    }

    public function saveOp(){
        if (chksubmit()) {
            $post = $_POST;
            $id = intval($post['id']);
            $admin_msg = trim($post['admin_msg']);
            if($id == 0){
                showDialog('请求异常','','error');
            }
            if($admin_msg == ''){
                showDialog('请填写回访备注','','error');
            }
            $model = Model('dealers');
            // 检查当前用户是否已经填写发票信息
            $info = $model->where(['id'=>$id,'status'=>1])->find();
            if(empty($info)){
                showDialog('信息不存在或当前状态不可进行该操作');die;
            }
            // 如果不是，则更新
            $update_data['admin_id'] = $this->admin_info['id'];
            $update_data['admin_user_name'] = $this->admin_info['name'];
            $update_data['admin_msg'] = $admin_msg;
            $update_data['admin_changed_at'] = date('Y-m-d H:i:s');
            $update_data['status'] = 2;
            $update_data['updated_at'] = date('Y-m-d H:i:s');
            $model->where(['id'=>$id,'status'=>1])->update($update_data);
            showDialog('操作成功',urlAdminShop('dealers','index'));die;
        }


    }
}
