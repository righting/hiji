<?php

class exhibitionControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('document');
    }



    public function indexOp(){
        $model  = Model('exhibition');
        $lists   = $model->getList();
		Tpl::setDirquna('system');
        Tpl::output('lists',$lists);
        Tpl::showpage('exhibition/index');
    }

    public function editOp(){
        $model  = Model('exhibition');
        $id = $_GET['id'];
        $where['id'] = $id;
        $info = $model->getOne($where);
        Tpl::setDirquna('system');
        Tpl::output('info',$info);
        Tpl::showpage('exhibition/edit');
    }

    public function addOp(){
        Tpl::setDirquna('system');
        Tpl::showpage('exhibition/edit');
    }

    public function saveOp(){
        if(chksubmit()){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["title"], "require"=>"true", 'message'=>'标题不能为空'),
                array("input"=>$_POST["content"], "require"=>"true", "message"=>'请输入内容')
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $post_id = $_POST['id'];
                $data  = array();
                $model  = Model('exhibition');
                if($post_id){
                    $id = intval($post_id);
                    $data['id']    = $id;
                    $where['id'] = $id;
                    $info = $model->getOne($where);
                    if(empty($info)){
                        showMessage('信息不存在');
                    }
                }else{
                    $code = trim($_POST['code']);
                    if($code == ''){
                        showMessage('调用标识码不能为空');
                    }
                    $data['code'] = $code;
                }

                $data['title'] = trim($_POST['title']);
                $data['content']= trim($_POST['content']);
                $data['created_at']  = date('Y-m-d H:i:s');
                $data['updated_at']  = date('Y-m-d H:i:s');
                if($post_id){
                    $result = $model->updates($where,$data);
                }else{
                    $result = $model->insert($data);
                }


                if ($result){
                    /**
                     * 更新图片信息ID
                     */
                    $model_upload = Model('upload');
                    if (is_array($_POST['file_id'])){
                        foreach ($_POST['file_id'] as $k => $v){
                            $v = intval($v);
                            $update_array = array();
                            $update_array['upload_id'] = $v;
                            $update_array['item_id'] = $id;
                            $model_upload->updates($update_array);
                            unset($update_array);
                        }
                    }

                    $url = array(
                        array(

                            'url'=>urlAdminSystem('exhibition','index'),
                            'msg'=>'返回上一页'
                        ),
                        array(
                            'url'=>urlAdminSystem('exhibition','edit',['id'=>$id]),
                            'msg'=>'再次编辑'
                        ),
                    );
                    $this->log('修改了展示页面信息 [ID:'.$id.']',1);
                    showMessage('保存成功',$url);
                }else {
                    showMessage('保存失败');
                }
            }
        }
    }


    /**
     * 系统文章图片上传
     */
    public function pic_uploadOp(){
        /**
         * 上传图片
         */
//        $upload = new UploadFile();
        $upload = new AliOssUpload();
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
        $insert_array['upload_type'] = '4';
        $insert_array['file_size'] = $_FILES['fileupload']['size'];
        $insert_array['item_id'] = intval($_POST['item_id']);
        $insert_array['upload_time'] = time();
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
     * ajax操作
     */
    public function ajaxOp(){
        switch ($_GET['branch']){
            /**
             * 删除文章图片
             */
            case 'del_file_upload':
                if (intval($_GET['file_id']) > 0){
                    $model_upload = Model('upload');
                    /**
                     * 删除图片
                     */
                    $file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
                    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_ARTICLE.DS.$file_array['file_name']);
                    /**
                     * 删除信息
                     */
                    $model_upload->del(intval($_GET['file_id']));
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }
                break;
        }
    }
}
