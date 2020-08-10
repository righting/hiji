<?php
/**
 * 商品栏目管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

class jfgoods_addControl extends SystemControl{
    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        Tpl::setDirquna('shop');
        $goodsId =  isset($_GET['goodsId'])?intval($_GET['goodsId']):'';

        if(!empty($goodsId)){
            $model = Model('jfgoods');
            $info=$model->where(['goods_id'=>$goodsId])->find();
            Tpl::output('info',$info);
        }

        $cateModel = Model('jfgoods_category');
        $cateInfo=$cateModel->select();

        Tpl::output('cateInfo',$cateInfo);
        Tpl::output('goodsId',$goodsId);
        Tpl::showpage('jfgoods_add');
    }


    public function addGoodsOp(){
        $rs = array('status'=>-1,'data'=>'','msg'=>'新增失败');
        $model = Model('jfgoods');
        $goodsId = intval($_POST['goodsId']);
        $data['goods_name']  = $_POST['goodsName'];
        $data['goods_price'] = intval($_POST['goodsPrice']);
        $data['goods_integral'] = intval($_POST['goodsPoint']);
        $data['goods_hjb'] = intval($_POST['goodsHjb']);
        $data['goods_storage'] = intval($_POST['inventory']);
        $data['goods_jingle'] = $_POST['goodsDesc'];
        $data['goods_image'] = $_POST['goodsImage'];
        $data['goods_body'] = $_POST['goodsDetails'];
        $data['gc_id'] = intval($_POST['gcId']);
        $data['goods_state'] = 1;
        $data['goods_verify'] = 1;
        if(!empty($goodsId) && $goodsId!='0'){
            $re=$model->where(['goods_id'=>$goodsId])->update($data);
            if($re){
                $rs['status']=1;
                $rs['msg'] = '修改成功';
            }
        }else{
            $data['goods_addtime'] = time();
            $re=$model->insert($data);
            if($re){
                $rs['status']=1;
                $rs['msg'] = '新增成功';
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

}
