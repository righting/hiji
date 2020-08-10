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
class prize_goodControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('setting');
    }

    public function indexOp() {
 
		Tpl::setDirquna('shop');
        Tpl::showpage('prize_good.index');
    }

    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_prize = Model('prize_record');
		$page = $_POST['rp'];
        $list = $model_prize->order('id desc')->page($page)->select();//echo '<pre>';print_r($list);exit;
		$dispose = array('未处理','已处理');
		$data = array();
		$data['now_page'] = $model_prize->shownowpage();
        $data['total_num'] = $model_prize->gettotalnum();
        foreach ($list as $value) {
            $param = array();
            $operation = '';
			if($value['dispose']==0){
				$operation .= "<a class='btn blue'  href='" . urlAdminShop('prize_good', 'dispose', array('id' => $value['id'])) . "' ><i class='fa fa-list-alt'></i>标注为已处理</a>";
			}else{
				
				$operation .= "<a class='btn'  href='#' >已处理</a>";
			}
           // $operation .= "<a class='btn blue'  href='" . urlAdminShop('prize_good', 'edit', array('id' => $value['id'])) . "' ><i class='fa fa-list-alt'></i>立即处理</a>";
            /**设为精选尖货**/
            $operation .= "</ul>";
            $param['operation'] = $operation;
            $param['id'] = $value['id'];
            $param['prize_name'] = $value['prize_name'];
            $param['prize_image'] ="<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".cthumb($value['prize_image'],'60').">\")'><i class='fa fa-picture-o'></i></a>";
			$param['add_time'] = date('Y-m-d H:i:s',$value['add_time']); 
            $param['name'] = $value['name'];
			$param['addres'] = $value['addres'];
			$param['mobile'] = $value['mobile'];
			$param['dispose'] = $dispose[$value['dispose']];
			if($value['dispose_time']>0){
				$param['dispose_time'] = date('Y-m-d H:i:s',$value['dispose_time']); 
			}else{
				$param['dispose_time'] = '未处理';
			}
			
            $data['list'][$value['id']] = $param;
        }
		
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
        
        if(!empty($id) && $id!='0'){
            $re=$model_prize->where(['id'=>$id])->update($data);
            if($re){
                $rs['status']=1;
                $rs['msg'] = '修改成功';
            }
        }

        echo json_encode($rs);
    }
	public function disposeOp(){
		$model_prize = Model('prize_record');
    
        $id = intval($_GET['id']);
		if(!$id || $id<1){
			showMessage('非法操作');
		}
        $data['dispose']  = 1;
		$data['dispose_time']  = time();
        if(!empty($id) && $id!='0'){
            $re=$model_prize->where(['id'=>$id])->update($data);
            if($re){
				showMessage('处理成功');
            }else{
				showMessage('处理失败');
			}
        }else{
			showMessage('非法操作');
		}

       
    }


}
