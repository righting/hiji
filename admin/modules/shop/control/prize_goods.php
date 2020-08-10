<?php
/**
 * 网站设置
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class prize_goodsControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('goods');
    }

    public function indexOp() {
 
		Tpl::setDirquna('shop');
        Tpl::showpage('prize.index');
    }

    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_prize = Model('prize');
        $list = $model_prize->order('prize_sort desc')->select();
		//echo '<pre>';print_r($list);exit;
		$data['now_page'] = 1;
        $data['total_num'] = 7;
        foreach ($list as $value) {

            $param = array();
            $operation = '';
            $operation .= "<a class='btn blue'  href='" . urlAdminShop('prize_goods', 'edit', array('id' => $value['id'])) . "' ><i class='fa fa-list-alt'></i>编辑</a>";

            /**设为精选尖货**/
            $operation .= "</ul>";
            $param['operation'] = $operation;
            $param['id'] = $value['id'];
            $param['prize_name'] = $value['prize_name'];
            $param['prize_image'] ="<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".cthumb($value['prize_image'],'60').">\")'><i class='fa fa-picture-o'></i></a>";
            $param['prize_percent'] = $value['prize_percent'];
			$param['prize_sort'] = $value['prize_sort'];
            $data['list'][$value['id']] = $param;
        }
		//echo '<pre>';print_r($data);exit;
        echo Tpl::flexigridXML($data);exit();
    }
	public function editOp() {

        $id =  isset($_GET['id'])?intval($_GET['id']):'';
		$model_prize = Model('prize');
		$info = $model_prize->where(['id'=>$id])->find();
		Tpl::output('info',$info);
		Tpl::setDirquna('shop');
        Tpl::showpage('prize_edit');
    }
	public function edit_subOp(){
		$model_prize = Model('prize');
        $rs = array('status'=>-1,'data'=>'','msg'=>'修改失败');
        $id = intval($_POST['id']);
		if(!$id || $id<1){
			$rs = array('status'=>-1,'data'=>'','msg'=>'非法操作');
			echo json_encode($rs);exit;
		}
        $data['prize_name']  = $_POST['prize_name'];
        $data['prize_percent'] = intval($_POST['prize_percent']);
        $data['prize_sort'] = intval($_POST['prize_sort']);
        $data['prize_image'] = $_POST['prize_image'];
		$data['prize_jf'] = intval($_POST['prize_jf']);
		$data['prize_jf2'] = intval($_POST['prize_jf2']);
		$data['dispose'] = intval($_POST['dispose']);
        
        if(!empty($id) && $id!='0'){
            $re=$model_prize->where(['id'=>$id])->update($data);
            if($re){
                $rs['status']=1;
                $rs['msg'] = '修改成功';
            }
        }

        echo json_encode($rs);
    }
	/**
     * 图片上传
     */
    public function goods_pic_uploadOp(){
        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload->set('default_dir',ATTACH_ARTICLE);
        $result = $upload->upfile('fileupload');
        if ($result){
            $_POST['pic'] = $upload->file_name;
        }else {
            echo 'error';exit;
        }
        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        /**
         * 图片数据入库
         */
        $insert_array = array();
        $insert_array['file_name'] = $_POST['pic'];
        $insert_array['upload_type'] = '0';
        $insert_array['file_size'] = $_FILES['fileupload']['size'];
        $insert_array['upload_time'] = time();
        $insert_array['item_id'] = intval($_POST['item_id']);
        $result = $model_upload->add($insert_array);
        if ($result){
            $data = array();
            $data['file_id'] = $result;
            $data['file_name'] = $_POST['pic'];
            $data['file_path'] = $_POST['pic'];
            /**
             * 整理为json格式
             */
            $output = json_encode($data);
            echo $output;
        }

    }
	/**
     * 增加积分消费日志
     * @param $userId
     * @param $point
     * @param $desc
     */
    public function pointsLog($userId,$point,$desc){
        $rs = false;
        if($point > 0){
            $model = Model('points_log');
            $data['pl_memberid'] = $userId;
            $data['pl_membername'] = $_SESSION['member_name'];
            $data['pl_points'] = '-'.$point;
            $data['pl_addtime'] = time();
            $data['pl_desc'] = $desc;
            $data['pl_stage'] = 'order_for_other';
            $add=$model->insert($data);
            if($add){
                $rs=true;
            }
        }
        return $rs;
    }
}
