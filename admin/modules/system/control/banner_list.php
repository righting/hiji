<?php
/**
 * 文章管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class banner_listControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('db');
    }
    /**
     * 广告分组列表
     */
    public function indexOp() {
        $type = $_GET['type'] ? intval($_GET['type']) : '0';

        !empty($type) && $condition['id'] = $type;
        $condition['status'] = 1;

        $model = Model('banner_category');
        $banner_category = $model->limit(500)->select($condition);

        Tpl::output('type',$type);
        Tpl::output('banner_category', $banner_category);
        Tpl::setDirquna('system');
        Tpl::showpage('banner_list');
    }


    /**
     * 异步调用分组列表
     */
    public function get_xmlOp(){
        $type = $_GET['type'] ? intval($_GET['type']) : '0';
        $cateModel = Model('banner_category');

        $page = new Page();
        $page->setEachNum(intval($_POST['rp']));
        $page->setStyle('admin');
        $param['table'] = 'banner';
        !empty($type) && $param['where'] = 'c_id='.$type;
        $param['order'] = 'c_id asc,sort asc';
        $bannerList = Db::select($param, $page);

        $data = array();
        $data['now_page'] = $page->get('now_page');
        $data['total_num'] = $page->get('total_num');
        if (is_array($bannerList)){
            foreach ($bannerList as $k => $v){
                $cateInfo = $cateModel->where(['id'=>$v['c_id']])->find();
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['id']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?controller=banner_list&action=banner_list_edit&id={$v['id']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['sort'] = $v['sort'];
                $list['cate_name'] = $cateInfo['cate_name'];
                $list['title'] = $v['title'];
                $list['img_url'] = "<a href='javascript:;' onclick=\"imgShow('{$v['img_url']}')\">查看图片</a>";
                $list['img_link'] = $v['img_link'];
                $list['start_time'] = $v['start_time'];
                $list['end_time'] = $v['end_time'];
                $list['status'] = $v['status'] == 0 ? '<span class="no"><i class="fa fa-ban"></i>否</span>' : '<span class="yes"><i class="fa fa-check-circle"></i>是</span>';
                $list['create_time'] = $v['create_time'];
                $data['list'][$v['id']] = $list;
            }
        }
        exit(Tpl::flexigridXML($data));
    }




    /**
     * 添加广告
     */
    public function banner_list_addOp(){
        $lang   = Language::getLangContent();
        $model = Model('banner');
        /**
         * 保存
         */
        if (chksubmit()){
                $insert_array = array();
                $insert_array['c_id'] = intval($_POST['ac_id']);
                $insert_array['start_time'] = trim($_POST['start_time']);
                $insert_array['end_time'] = trim($_POST['end_time']);
                $insert_array['img_url'] = $_POST['img'];
                $insert_array['img_link'] = trim($_POST['img_link']);
                $insert_array['status'] = trim($_POST['status']);
                $insert_array['sort'] = trim($_POST['sort']);
                $insert_array['title'] = trim($_POST['title']);
                $result = $model->insert($insert_array);
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
                            $update_array['item_id'] = $result;
                            $model_upload->updates($update_array);
                            unset($update_array);
                        }
                    }

                    $url = array(array('url'=>'index.php?controller=banner_list&action=index','msg'=>'跳转至广告列表'));
                    showMessage("添加成功",$url);

                }else {
                    showMessage("添加失败!");
                }
        }

        /**
         * 分组列表
         */
        $model_class = Model('banner_category');
        $parent_list = $model_class->limit(500)->order(['sort asc,id asc'])->select();

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
        Tpl::output('parent_list',$parent_list);
        Tpl::output('file_upload',$file_upload);
        Tpl::setDirquna('system');
        Tpl::showpage('banner_list_add');
    }

    /**
     * 广告编辑
     */
    public function banner_list_editOp(){
        $lang   = Language::getLangContent();
        $model = Model('banner');
        $id = intval($_GET['id']);
        /**
         * 保存
         */
        if (chksubmit()){
            $updates_array = array();
            $updates_array['c_id'] = intval($_POST['ac_id']);
            $updates_array['start_time'] = trim($_POST['start_time']);
            $updates_array['end_time'] = trim($_POST['end_time']);
            $updates_array['img_url'] = $_POST['img'];
            $updates_array['img_link'] = trim($_POST['img_link']);
            $updates_array['status'] = trim($_POST['status']);
            $updates_array['sort'] = trim($_POST['sort']);
            $updates_array['title'] = trim($_POST['title']);
            $result = Db::update('banner',$updates_array,'id='.intval($_POST['id']));
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
                        $update_array['item_id'] = $result;
                        $model_upload->updates($update_array);
                        unset($update_array);
                    }
                }

                $url = array(array('url'=>'index.php?controller=banner_list&action=index','msg'=>'跳转至广告列表'));
                showMessage("编辑成功",$url);
            }else {
                showMessage("编辑失败!");
            }
        }



        $info = $model->where(['id'=>$id])->find();

        /**
         * 分组列表
         */
        $model_class = Model('banner_category');
        $parent_list = $model_class->limit(500)->order(['sort asc,id asc'])->select();

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
        Tpl::output('parent_list',$parent_list);
        Tpl::output('file_upload',$file_upload);
        Tpl::output('info',$info);
        Tpl::setDirquna('system');
        Tpl::showpage('banner_list_edit');
    }



    public function deleteOp() {
        if (preg_match('/^[\d]+$/', $_GET['del_id'])) {
            $id=intval($_GET['del_id']);
            $result = Db::delete('banner','id='.$id);
            if($result){
                exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
            }else{
                exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
            }
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }

}
