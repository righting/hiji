<?php
/**
 * 单页管理         2018-07-03      LFP
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class pageControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('page');
    }

    public function indexOp() {
        $this->pageOp();
    }

    /**
     * 单页管理
     */
    public function pageOp(){
        $type = $_GET['type']?$_GET['type']:'0';
        /**
         * 分类列表
         */
        $model_class = Model('page_class');
        $parent_list = $model_class->getTreeClassList(1);
        Tpl::output('page_type',$parent_list);
        Tpl::output('type',$type);
        Tpl::setDirquna('system');
        Tpl::showpage('page.index');
    }

    public function deleteOp() {
        $model_page = Model('page');
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
        $type = $_GET['type']?$_GET['type']:'0';

        $lang   = Language::getLangContent();
        $model_page = Model('page');
        $condition = array();
        if (!empty($_POST['qtype'])) {
            $condition['ac_id'] = intval($_POST['qtype']);
        }
        if (!empty($_POST['query'])) {
            $condition['like_title'] = $_POST['query'];
        }
        if($type != 0){
            $model_class = Model('page_class');

                $s_list = $model_class->getChildClass($type);
                foreach ($s_list as $sk=>$sv){
                    $page_type[] = $sv['ac_id'];

                }


            $condition['page_types'] = implode(",", $page_type);

        }


        $condition['order'] = ltrim($condition['order'].',page_id desc',',');
        $page   = new Page();
        $page->setEachNum(intval($_POST['rp']));
        $page->setStyle('admin');
        $page_list = $model_page->getPageList($condition,$page);
        $data = array();
        $data['now_page'] = $page->get('now_page');
        $data['total_num'] = $page->get('total_num');
        if (is_array($page_list)){


            foreach ($page_list as $k => $v){
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['page_id']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?controller=page&action=page_edit&page_id={$v['page_id']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['page_title'] = $v['page_title'];
                $list['page_show'] = $v['page_show'] == 0 ? '<span class="no"><i class="fa fa-ban"></i>否</span>' : '<span class="yes"><i class="fa fa-check-circle"></i>是</span>';
                $list['page_time'] = date('Y-m-d H:i:s',$v['page_time']);
                $data['list'][$v['page_id']] = $list;
            }
        }
        //echo '<pre>';print_r($page_list);exit;
        exit(Tpl::flexigridXML($data));
    }
    public function page_key_name(){
    $data = array(

        array('keys'=>'nzgy','name'=>'农村公益'),
        array('keys'=>'nlms','name'=>'农旅民宿'),
        array('keys'=>'nznj','name'=>'农资农具'),
        array('keys'=>'xffp','name'=>'消费扶贫'),
        array('keys'=>'zcdz','name'=>'众筹定制'),

        array('keys'=>'consumption_capital','name'=>'消费资本'),
        array('keys'=>'consumption_hjb','name'=>'海吉币'),
        array('keys'=>'consumption_integral','name'=>'海吉积分'),
        array('keys'=>'consumption_accumulation','name'=>'消费公积金'),
        array('keys'=>'consumption_provide','name'=>'消费养老保险'),
        array('keys'=>'consumption_dream','name'=>'车房梦想基金'),
        array('keys'=>'consumption_charity','name'=>'海吉慈善基金'),

        array('keys'=>'offline_franchised','name'=>'线下加盟'),
        array('keys'=>'offline_brand','name'=>'品牌托管'),
        array('keys'=>'offline_24','name'=>'24 h 便利店'),
        array('keys'=>'offline_capacity','name'=>'智能售货机'),
        array('keys'=>'offline_cross','name'=>'跨境购体验店'),
        array('keys'=>'offline_provide','name'=>'养老康乐院'),
        array('keys'=>'offline_consumption','name'=>'消费养老保险卡服务中心'),
        array('keys'=>'green_develop','name'=>'绿色发展'),

        array('keys'=>'share_position','name'=>'分享阵地'),
        array('keys'=>'share_about','name'=>'关于我们'),
        array('keys'=>'share_service_centre','name'=>'海吉服务中心'),
        //array('keys'=>'share_trading','name'=>'海吉商圈'),
        array('keys'=>'share_college','name'=>'海吉商学院'),
        //array('keys'=>'share_convenience','name'=>'智能便利店'),
        array('keys'=>'share_celebrated','name'=>'招贤纳士'),
        array('keys'=>'share_buffet_service','name'=>'自助服务首页'),
        array('keys'=>'share_cooperation','name'=>'合作共赢'),

        array('keys'=>'member_center','name'=>'会员中心'),
        array('keys'=>'member_develop','name'=>'会员发展中心'),

        array('keys'=>'service_centre','name'=>'服务中心'),
        array('keys'=>'service_store','name'=>'商家服务'),
        array('keys'=>'service_member','name'=>'消费者服务'),

        array('keys'=>'shareholder_apply','name'=>'股东商申请'),
        array('keys'=>'hj_integral','name'=>'海吉积分'),
        array('keys'=>'consume_accumulation','name'=>'消费公积金'),
        array('keys'=>'consume_annuity','name'=>'消费者养老保险'),
        array('keys'=>'philanthropic','name'=>'海吉慈善基金'),
        array('keys'=>'dream','name'=>'梦想金'),
    );
    return $data;
}
    public function get_page_type(){
        $model_class = Model('page_class');
        $data = $model_class->getTreeClassList(3);
        return $data;
    }
    /**
     * 文章添加
     */
    public function page_addOp(){
        $lang   = Language::getLangContent();
        $model_page = Model('page');
        $page_key_name = $this->page_key_name();
        $page_type = $this->get_page_type();
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
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {

                $insert_array = array();
                $insert_array['page_title'] = trim($_POST['page_title']);
                $insert_array['page_url'] = trim($_POST['page_url']);
                $insert_array['page_show'] = trim($_POST['page_show']);
                $insert_array['page_key'] = trim($_POST['page_key']);
                $insert_array['page_type'] = trim($_POST['page_type']);
                $insert_array['page_content'] = trim($_POST['page_content']);
                $insert_array['page_time'] = time();

                $result = $model_page->add($insert_array);
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

                    $url = array(
                        array(
                            'url'=>'index.php?controller=page&action=page',
                            'msg'=>"{$lang['help_add_tolist']}",
                        ),
                        array(
                            'url'=>'index.php?controller=page&action=page_add&ac_id='.intval($_POST['ac_id']),
                            'msg'=>"{$lang['help_add_continueadd']}",
                        ),
                    );
                    $this->log(L('page_add_ok').'['.$_POST['page_title'].']',null);
                    showMessage("{$lang['help_add_ok']}",$url);
                }else {
                    showMessage("{$lang['help_add_fail']}");
                }
            }
        }
        /**
         * 分类列表
         */
        $model_class = Model('page_class');
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
        Tpl::output('parent_list',$parent_list);
        Tpl::output('page_type',$page_type);
        Tpl::output('page_key_name',$page_key_name);
        Tpl::output('file_upload',$file_upload);
        Tpl::setDirquna('system');
        Tpl::showpage('page.add');
    }

    /**
     * 文章编辑
     */
    public function page_editOp(){
        $lang    = Language::getLangContent();
        $model_page = Model('page');
        $page_key_name = $this->page_key_name();
        $page_type = $this->get_page_type();
        if (chksubmit()){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["page_title"], "require"=>"true", "message"=>$lang['help_add_title_null']),

            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $update_array = array();
                $update_array['page_id'] = intval($_POST['page_id']);
                $update_array['page_title'] = trim($_POST['page_title']);
                $update_array['page_url'] = trim($_POST['page_url']);
                $update_array['page_show'] = trim($_POST['page_show']);
                //$update_array['page_key'] = trim($_POST['page_key']);
                $update_array['page_content'] = trim($_POST['page_content']);
                $result = $model_page->updates($update_array);
                if ($result){
                    /**
                     * 更新图片信息ID
                     */
                    $model_upload = Model('upload');
                    if (is_array($_POST['file_id'])){
                        foreach ($_POST['file_id'] as $k => $v){
                            $update_array = array();
                            $update_array['upload_id'] = intval($v);
                            $update_array['item_id'] = intval($_POST['page_id']);
                            $model_upload->updates($update_array);
                            unset($update_array);
                        }
                    }

                    $url = array(
                        array(
                            'url'=>$_POST['ref_url'],
                            'msg'=>$lang['help_edit_back_to_list'],
                        ),
                        array(
                            'url'=>'index.php?controller=updates&action=page_edit&page_id='.intval($_POST['page_id']),
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

        $page_array = $model_page->getOneArticle(intval($_GET['page_id']));
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
        $model_class = Model('page_class');
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
        Tpl::output('page_type',$page_type);
        Tpl::output('parent_list',$parent_list);
        Tpl::setDirquna('system');
        Tpl::showpage('page.edit');
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
