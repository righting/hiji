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
class banner_categoryControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('db');
    }
    /**
     * 广告分组列表
     */
    public function indexOp() {
        Tpl::setDirquna('system');
        Tpl::showpage('banner_category_list');
    }


    /**
     * 异步调用分组列表
     */
    public function get_xmlOp(){
        $lang   = Language::getLangContent();
        $model = Model('banner_category');
        $condition = array();
        if (!empty($_POST['qtype'])) {
            $condition['ac_id'] = intval($_POST['qtype']);
        }
        if (!empty($_POST['query'])) {
            $condition['like_title'] = $_POST['query'];
        }
        if (!empty($_POST['sortname']) && in_array($_POST['sortorder'],array('asc','desc'))) {
            $condition['order'] = $_POST['sortname'].' '.$_POST['sortorder'];
        }

        $page   = new Page();
        $page->setEachNum(intval($_POST['rp']));
        $page->setStyle('admin');
        $param['table'] ='banner_category';
        $param['order'] ='sort asc,id asc';
        $bannerList=Db::select($param,$page);

        $data = array();
        $data['now_page'] = $page->get('now_page');
        $data['total_num'] = $page->get('total_num');
        if (is_array($bannerList)){
            foreach ($bannerList as $k => $v){
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['id']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?controller=banner_category&action=banner_category_edit&id={$v['id']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['id'] = $v['id'];
                $list['cate_name'] = $v['cate_name'];
                $list['sort'] = $v['sort'];
                $list['status'] = $v['status'] == 0 ? '<span class="no"><i class="fa fa-ban"></i>否</span>' : '<span class="yes"><i class="fa fa-check-circle"></i>是</span>';
                $list['create_time'] = $v['create_time'];
                $data['list'][$v['id']] = $list;
            }
        }
        exit(Tpl::flexigridXML($data));
    }

    /**
     * 添加分组
     */
    public function banner_category_addOp(){
        $lang   = Language::getLangContent();
        $model = Model('banner_category');
        /**
         * 保存
         */
        if (chksubmit()){
            $insert_array = array();
            $insert_array['cate_name'] = trim($_POST['title']);
            $insert_array['status'] = trim($_POST['status']);
            $insert_array['sort'] = trim($_POST['sort']);
            $insert_array['create_time'] = date('Y-m-d H:i:s');
            $result = $model->insert($insert_array);
            if ($result){
                $url = array(array('url'=>'index.php?controller=banner_category&action=index','msg'=>'跳转至广告分组列表'));
                showMessage("添加成功",$url);
            }else {
                showMessage("添加失败!");
            }
        }

        Tpl::output('PHPSESSID',session_id());
        Tpl::setDirquna('system');
        Tpl::showpage('banner_category_add');
    }

    /**
     * 编辑分组
     */
    public function banner_category_editOp(){
        $lang   = Language::getLangContent();
        $model = Model('banner_category');
        /**
         * 保存
         */
        if (chksubmit()){
            $updates_array = array();
            $updates_array['cate_name'] = trim($_POST['title']);
            $updates_array['status'] = trim($_POST['status']);
            $updates_array['sort'] = trim($_POST['sort']);
            $result = Db::update('banner_category',$updates_array,'id='.intval($_POST['id']));
            if ($result){
                $url = array(array('url'=>'index.php?controller=banner_category&action=index','msg'=>'跳转至广告分组列表'));
                showMessage("编辑成功",$url);
            }else {
                showMessage("编辑失败!");
            }
        }

        $info = $model->where(['id'=>$_GET['id']])->find();

        Tpl::output('PHPSESSID',session_id());
        Tpl::output('info',$info);
        Tpl::setDirquna('system');
        Tpl::showpage('banner_category_edit');
    }

    public function deleteOp() {
        if (preg_match('/^[\d]+$/', $_GET['del_id'])) {
            $id=intval($_GET['del_id']);
            $result = Db::delete('banner_category','id='.$id);
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
