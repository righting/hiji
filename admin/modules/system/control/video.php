<?php
/**
 * 视频管理         2018-07-03      LFP
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class videoControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('video');
    }

    public function indexOp() {
        $this->videoOp();
    }

    /**
     * 视频管理
     */
    public function videoOp(){
        $type = $_GET['type']?$_GET['type']:'0';
        /**
         * 分类列表
         */
        $model_class = Model('video_class');
        $parent_list = $model_class->getTreeClassList(1);
        Tpl::output('video_type',$parent_list);
        Tpl::output('type',$type);
        Tpl::setDirquna('system');
        Tpl::showpage('video.index');
    }

    public function deleteOp() {
        $model_page = Model('video');
        if (preg_match('/^[\d,]+$/', $_GET['del_id'])) {
            $_GET['del_id'] = explode(',',trim($_GET['del_id'],','));
            $model_upload = Model('upload');
            foreach ($_GET['del_id'] as $k => $v){
                $v = intval($v);
                $condition['upload_type'] = '1';
                $condition['item_id'] = $v;
                $upload_list = $model_upload->getUploadList($condition);
                if (is_array($upload_list)){
                    foreach ($upload_list as $k_upload => $v_upload){
                        $model_upload->del($v_upload['upload_id']);
                        @unlink(BASE_UPLOAD_PATH.DS.ATTACH_ARTICLE.DS.$v_upload['file_name']);
                    }
                }
                $model_page->del($v);
            }
            $this->log(L('help_index_del_succ').'[ID:'.implode(',',$_GET['del_id']).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }
    /**
     * 异步调用单页列表
     */
    public function get_xmlOp(){
        $type = $_GET['type']?$_GET['type']:'';
        $lang   = Language::getLangContent();
        $model_page = Model('video');
        $condition = array();
        if (!empty($_POST['qtype'])) {
            $condition['ac_id'] = intval($_POST['qtype']);
        }
        if (!empty($_POST['query'])) {
            $condition['like_title'] = $_POST['query'];
        }
        $condition['video_type'] = $type;
        $condition['order'] = ltrim($condition['order'].',video_id desc',',');
        $page   = new Page();
        $page->setEachNum(intval($_POST['rp']));
        $page->setStyle('admin');
        $page_list = $model_page->getVideoList($condition,$page);
        $data = array();
        $data['now_page'] = $page->get('now_page');
        $data['total_num'] = $page->get('total_num');
        if (is_array($page_list)){
            foreach ($page_list as $k => $v){
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['video_id']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?controller=video&action=video_edit&video_id={$v['video_id']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['page_title'] = $v['video_title'];
                $list['page_show'] = $v['video_sort'];
                $list['periods'] = $v['periods'];
                $list['page_time'] = date('Y-m-d H:i:s',$v['time']);
                $data['list'][$v['video_id']] = $list;
            }
        }
        exit(Tpl::flexigridXML($data));
    }
    public function page_key_name(){
        $data = array(
            array('keys'=>'share_position','name'=>'分享阵地'),
            array('keys'=>'shareholder_apply','name'=>'股东商申请'),
            array('keys'=>'member_develop','name'=>'会员发展中心'),
            array('keys'=>'store_serve','name'=>'商家服务')
        );
        return $data;
    }
    public function getname($exname){

        $dir = "../../../shop/video/";

        $i=1;

        if(!is_dir($dir)){

            mkdir($dir,0777);

        }


        while(true){

            if(!is_file($dir.$i.".".$exname)){

                $name=$i.".".$exname;

                break;

            }

            $i++;

        }

        return array('s_url'=>$dir.$name,'h_rul'=>'/shop/video/'.$name,'name'=>$i);

    }
    /**
     * 文章添加
     */
    public function video_addOp(){
        $lang   = Language::getLangContent();
        $model_page = Model('video');
        $page_key_name = $this->page_key_name();
        //var_dump($page_key_name);exit;
        /**
         * 保存
         */
        if (chksubmit()){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["page_title"], "require"=>"true", "message"=>$lang['help_add_title_null']),

                //array("input"=>$_POST["article_url"], 'validator'=>'Url', "message"=>$lang['help_add_url_wrong']),
//                 array("input"=>$_POST["article_content"], "require"=>"true", "message"=>$lang['help_add_content_null']),

            );
            $error = '';
            if ($error != ''){
                showMessage($error);
            }else {
                $exname=strtolower(substr($_FILES['video']['name'],(strrpos($_FILES['video']['name'],'.')+1)));
                $uploadfile = $this->getname($exname);
                //var_dump(move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile));exit;
                if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile['s_url'])) {

                    $insert_array = array();
                    $insert_array['video_title'] = trim($_POST['page_title']);
                    $insert_array['periods'] = trim($_POST['periods']);
                    $insert_array['video_sort'] = trim($_POST['sort']);
                    $insert_array['video_type'] = trim($_POST['video_type']);
                    $insert_array['time'] = time();
                    $insert_array['video_url'] = $uploadfile['h_rul'];
                    //上传图片
                    $upload = new UploadFile();
                    $dir = "./shop/video/";
                    $upload->set('default_dir',$dir);
                    $upload->set('thumb_ext',   '');
                    $upload->set('file_name',$uploadfile['name'].'.jpg');
                    $upload->set('ifremove',false);
                    if (!empty($_FILES['login_pic1']['name'])){
                        $result = $upload->upfile('login_pic1');
                        if (!$result){
                            showMessage($upload->error,'','','error');
                        }else{
                            $insert_array['video_img'] = '/video/'.$upload->file_name;
                        }
                    }elseif ($_POST['old_login_pic1'] != ''){
                        $insert_array['video_img'] = '/video/'.$_POST['video_id'].'.jpg';
                    }

                    $result = $model_page->add($insert_array);//echo '<pre>';var_dump($result);exit;


                    if ($result){
                        /**
                         * 更新图片信息ID
                         */
                        /*$model_upload = Model('upload');
                        if (is_array($_POST['file_id'])){
                            foreach ($_POST['file_id'] as $k => $v){
                                $v = intval($v);
                                $update_array = array();
                                $update_array['upload_id'] = $v;
                                $update_array['item_id'] = $result;
                                $model_upload->updates($update_array);
                                unset($update_array);
                            }
                        }
                        */
                        $url = array(
                            array(
                                'url'=>'index.php?controller=video',
                                'msg'=>"{$lang['help_add_tolist']}",
                            ),
                            array(
                                'url'=>'index.php?controller=video&action=page_add&ac_id='.intval($_POST['ac_id']),
                                'msg'=>"{$lang['help_add_continueadd']}",
                            ),
                        );
                        $this->log(L('page_add_ok').'['.$_POST['page_title'].']',null);
                        showMessage("{$lang['help_add_ok']}",$url);
                    }else {
                        showMessage("{$lang['help_add_fail']}");
                    }

                }else {

                    showMessage('上传失败');

                }

            }
        }
        /**
         * 分类列表
         */
        $model_class = Model('video_class');
        $parent_list = $model_class->getTreeClassList(3);
        if (is_array($parent_list)){
            $unset_sign = false;
            foreach ($parent_list as $k => $v){
                $parent_list[$k]['ac_name'] = str_repeat("&nbsp;",$v['deep']*3).$v['ac_name'];
            }
        }
        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        $condition['upload_type'] = '1';
        $condition['item_id'] = '0';
        $file_upload = $model_upload->getUploadList($condition);
        if (is_array($file_upload)){
            foreach ($file_upload as $k => $v){
                $file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'.$file_upload[$k]['file_name'];
            }
        }

        Tpl::output('PHPSESSID',session_id());
        Tpl::output('ac_id',intval($_GET['ac_id']));
        Tpl::output('page_key_name',$page_key_name);
        Tpl::output('parent_list',$parent_list);
        Tpl::output('file_upload',$file_upload);
        Tpl::setDirquna('system');
        Tpl::showpage('video.add');
    }

    /**
     * 文章编辑
     */
    public function video_editOp(){
        $lang    = Language::getLangContent();
        $model_page = Model('video');
        $page_key_name = $this->page_key_name();
        if (chksubmit()){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["video_title"], "require"=>"true", "message"=>$lang['help_add_title_null']),

            );
            //$error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $update_array = array();
                $update_array['video_id'] = intval($_POST['video_id']);
                if($_FILES['video']['name']){
                    $exname=strtolower(substr($_FILES['video']['name'],(strrpos($_FILES['video']['name'],'.')+1)));
                    $uploadfile = $this->getname($exname);
                    //var_dump(move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile));exit;
                    if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile['s_url'])) {
                        $insert_array['video_url'] = $uploadfile['h_rul'];

                    }
                }
                //上传图片
                $upload = new UploadFile();
                $dir = "./shop/video/";
                $upload->set('default_dir',$dir);
                $upload->set('thumb_ext',   '');
                $upload->set('file_name',$_POST['video_id'].'.jpg');
                $upload->set('ifremove',false);
                    if (!empty($_FILES['login_pic1']['name'])){
                    $result = $upload->upfile('login_pic1');
                    if (!$result){
                        showMessage($upload->error,'','','error');
                    }else{
                        $update_array['video_img'] = '/video/'.$upload->file_name;
                    }
                }elseif ($_POST['old_login_pic1'] != ''){
                        $update_array['video_img'] = '/video/'.$_POST['video_id'].'.jpg';
                }
                //echo '<pre>';print_r($_POST['video_id'].'.jpg');exit;
                $update_array['video_title'] = trim($_POST['page_title']);
                $update_array['periods'] = trim($_POST['periods']);
                $update_array['video_sort'] = trim($_POST['sort']);
                $update_array['video_type'] = trim($_POST['video_type']);
                $result = $model_page->updates($update_array);

                if($result){
                    $url = array(
                        array(
                            'url'=>$_POST['ref_url'],
                            'msg'=>$lang['help_edit_back_to_list'],
                        ),
                        array(
                            'url'=>'index.php?controller=video&action=page_edit&page_id='.intval($_POST['page_id']),
                            'msg'=>$lang['help_edit_edit_again'],
                        ),
                    );
                    $this->log(L('page_edit_succ').'['.$_POST['page_title'].']',null);
                    showMessage($lang['help_edit_succ'],$url);
                }else {
                    showMessage($lang['help_edit_fail']);
                }
            }
        }

        $page_array = $model_page->getOneArticle(intval($_GET['video_id']));
        if (empty($page_array)){
            showMessage($lang['param_error']);
        }

        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        $condition['upload_type'] = '1';
        $condition['item_id'] = $page_array['page_id'];
        $file_upload = $model_upload->getUploadList($condition);
        if (is_array($file_upload)){
            foreach ($file_upload as $k => $v){
                $file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'.$file_upload[$k]['file_name'];
            }
        }
        /**
         * 分类列表
         */
        $model_class = Model('video_class');
        $parent_list = $model_class->getTreeClassList(3);
        if (is_array($parent_list)){
            $unset_sign = false;
            foreach ($parent_list as $k => $v){
                $parent_list[$k]['ac_name'] = str_repeat("&nbsp;",$v['deep']*3).$v['ac_name'];
            }
        }
        Tpl::output('PHPSESSID',session_id());
        Tpl::output('file_upload',$file_upload);
        Tpl::output('page_array',$page_array);
        Tpl::output('page_key_name',$page_key_name);
        Tpl::output('parent_list',$parent_list);
        Tpl::setDirquna('system');
        Tpl::showpage('video.edit');
    }
    /**
     * 文章图片上传
     */
    public function article_pic_uploadOp(){
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
        $insert_array['upload_type'] = '1';
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
