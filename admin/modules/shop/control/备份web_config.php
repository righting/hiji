<?php
/**
 * 前台模块编辑(首页)
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class web_configControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('web_config');
    }

    public function indexOp() {
        $this->web_configOp();
    }

    /**
     * 板块列表
     */
    public function web_configOp(){
        $model_web_config = Model('web_config');
        $style_array = $model_web_config->getStyleList();//板块样式数组
        Tpl::output('style_array',$style_array);
        $web_list = $model_web_config->getWebList(array('web_page' => array('like','index%')));
        Tpl::output('web_list',$web_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_config.index');
    }

    /**
     * 基本设置
     */
    public function web_editOp(){
        $model_web_config = Model('web_config');
        $web_id = intval($_GET["web_id"]);
        if (chksubmit()){
            $web_array = array();
            $web_id = intval($_POST["web_id"]);
            $web_array['web_name'] = $_POST["web_name"];
            $web_array['style_name'] = $_POST["style_name"];
            $web_array['web_sort'] = intval($_POST["web_sort"]);
            $web_array['web_show'] = intval($_POST["web_show"]);
            $web_array['update_time'] = time();
            $model_web_config->updateWeb(array('web_id'=>$web_id),$web_array);
            $model_web_config->updateWebHtml($web_id);//更新前台显示的html内容
            $this->log(l('web_config_code_edit').'['.$_POST["web_name"].']',1);
            showMessage(Language::get('nc_common_save_succ'),'index.php?controller=web_config&action=web_config');
        }
        $web_list = $model_web_config->getWebList(array('web_id'=>$web_id));
        Tpl::output('web_array',$web_list[0]);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_config.edit');
    }

    /**
     * 板块编辑
     */
    public function code_editOp(){
        switch ($_GET['type']){//不同类型板块跳转
            case 'index_fl':$this->indexTanChuangOp();break;//网站首页弹出框
            case 'index_qr':$this->indexQrOp();break;//网站底部二维码图片
            case 'index_sign':$this->indexSignOp();break;//网站底部标识
            case 'member_adv':$this->member_homeAdvOp();break;//会员中心首页广告区
            case 'rcm_goods':$this->pl_recommend();break;//平台推荐商品
            case 'index_pic':$this->focus_editOp();break;//焦点图
            case 'index_sale':$this->sale_editOp();break;//促销区
        }
        $model_web_config = Model('web_config');
        $web_id = intval($_GET["web_id"]);
        $code_list = $model_web_config->getCodeList(array('web_id'=>$web_id));
        if(is_array($code_list) && !empty($code_list)) {
            $model_class = Model('goods_class');
            $parent_goods_class = $model_class->getTreeClassList(2);//商品分类父类列表，只取到第二级
            if (is_array($parent_goods_class) && !empty($parent_goods_class)){
                foreach ($parent_goods_class as $k => $v){
                    $parent_goods_class[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
                }
            }
            Tpl::output('parent_goods_class',$parent_goods_class);

            $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
            Tpl::output('goods_class',$goods_class);

            foreach ($code_list as $key => $val) {//将变量输出到页面
                $var_name = $val["var_name"];
                $code_info = $val["code_info"];
                $code_type = $val["code_type"];
                $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
                Tpl::output('code_'.$var_name,$val);
            }
            $style_array = $model_web_config->getStyleList();//样式数组
            Tpl::output('style_array',$style_array);
            $web_list = $model_web_config->getWebList(array('web_id'=>$web_id));
            Tpl::output('web_array',$web_list[0]);
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
            Tpl::showpage('web_code.edit');
        } else {
            showMessage(Language::get('nc_no_record'));
        }
    }

    /**
     * 更新前台显示的html内容
     */
    public function web_htmlOp(){
        $model_web_config = Model('web_config');
        $web_id = intval($_GET["web_id"]);
        $web_list = $model_web_config->getWebList(array('web_id'=>$web_id));
        $web_array = $web_list[0];
        if(!empty($web_array) && is_array($web_array)) {
            $model_web_config->updateWebHtml($web_id,$web_array);
            showMessage(Language::get('nc_common_op_succ'),'index.php?controller=web_config&action=web_config');
        } else {
            showMessage(Language::get('nc_common_op_fail'));
        }
    }

    /**
     * 头部切换图设置
     */
    public function focus_editOp() {
        $model_web_config = Model('web_config');
        $web_id = '101';
        $web_id=$_GET['web_id'];
        $code_list = $model_web_config->getCodeList(array('web_id'=> $web_id));
        if(is_array($code_list) && !empty($code_list)) {
            foreach ($code_list as $key => $val) {//将变量输出到页面
                $var_name = $val['var_name'];
                $code_info = $val['code_info'];
                $code_type = $val['code_type'];
                $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
                Tpl::output('code_'.$var_name,$val);
            }
        }
        $screen_adv_list = $model_web_config->getAdvList("screen");//焦点大图广告数据
        Tpl::output('screen_adv_list',$screen_adv_list);
        $focus_adv_list = $model_web_config->getAdvList("focus");//三张联动区广告数据
        Tpl::output('focus_adv_list',$focus_adv_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

        Tpl::showpage('web_focus.edit');
    }

    /**
     * 平台推荐商品
     */
   public function pl_recommendOp(){
       $web_id='615';
       $model_web_config = Model('web_config');
       $code_list_tmp = $model_web_config->getCodeList(['web_id'=>$web_id]);
       foreach ($code_list_tmp as $k=>$val){
           $code_list_tmp[$k]['code_info'] = $model_web_config->get_array($val['code_info'],$val['code_type']);
       }

       $code_list = $model_web_config->getCodeList(array('web_id'=>$web_id));
       if(is_array($code_list) && !empty($code_list)) {
           $model_class = Model('goods_class');
           $parent_goods_class = $model_class->getTreeClassList(2);//商品分类父类列表，只取到第二级
           if (is_array($parent_goods_class) && !empty($parent_goods_class)){
               foreach ($parent_goods_class as $k => $v){
                   $parent_goods_class[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
               }
           }
           Tpl::output('parent_goods_class',$parent_goods_class);

           $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
           Tpl::output('goods_class',$goods_class);

           foreach ($code_list as $key => $val) {//将变量输出到页面
               $var_name = $val["var_name"];
               $code_info = $val["code_info"];
               $code_type = $val["code_type"];
               $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
               Tpl::output('code_'.$var_name,$val);
           }
           $style_array = $model_web_config->getStyleList();//样式数组
           Tpl::output('style_array',$style_array);
           $web_list = $model_web_config->getWebList(array('web_id'=>$web_id));
           Tpl::output('web_array',$web_list[0]);
           Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
           Tpl::showpage('web_pl_recommend');
       } else {
           showMessage(Language::get('nc_no_record'));
       }
   }
    /**
     * 会员中心广告位
     */
    public function member_homeAdvOp(){
        $web_id='614';
        $model_web_config = Model('web_config');
        $code_list_tmp = $model_web_config->getCodeList(['web_id'=>$web_id]);
        foreach ($code_list_tmp as $k=>$val){
            $code_list_tmp[$k]['code_info'] = $model_web_config->get_array($val['code_info'],$val['code_type']);
        }
        $code_adv = current($code_list_tmp);
        Tpl::output('name','今日优选');
        Tpl::output('code_adv',$code_adv);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_adv.index');
    }
    /**
     *首页弹窗
     */
    public function indexTanChuangOp(){
        $web_id=$_GET['web_id'];
        $model_web_config = Model('web_config');
        $code_list_tmp = $model_web_config->getCodeList(['web_id'=>$web_id]);
        foreach ($code_list_tmp as $k=>$val){
            $code_list_tmp[$k]['code_info'] = $model_web_config->get_array($val['code_info'],$val['code_type']);
        }
        $code_adv = current($code_list_tmp);
        Tpl::output('name','首页弹窗');
        Tpl::output('code_adv',$code_adv);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_adv.index');
    }
    /**
     *首页底部二维码
     */
    public function indexQrOp(){
        $web_id=$_GET['web_id'];
        $model_web_config = Model('web_config');
        $code_list_tmp = $model_web_config->getCodeList(['web_id'=>$web_id]);
        foreach ($code_list_tmp as $k=>$val){
            $code_list_tmp[$k]['code_info'] = $model_web_config->get_array($val['code_info'],$val['code_type']);
        }
        $code_adv = current($code_list_tmp);
        Tpl::output('name','首页底部二维码');
        Tpl::output('code_adv',$code_adv);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_adv.index');
    }
    /**
     *首页底部网站标识
     */
    public function indexSignOp(){
        $web_id=$_GET['web_id'];
        $model_web_config = Model('web_config');
        $code_list_tmp = $model_web_config->getCodeList(['web_id'=>$web_id]);
        foreach ($code_list_tmp as $k=>$val){
            $code_list_tmp[$k]['code_info'] = $model_web_config->get_array($val['code_info'],$val['code_type']);
        }
        $code_adv = current($code_list_tmp);
        Tpl::output('name','首页底部网站标识');
        Tpl::output('code_adv',$code_adv);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_adv.index');
    }
    /**
     * 更新html内容
     */
    public function html_updateOp() {
        $model_web_config = Model('web_config');
        $web_id = intval($_GET["web_id"]);
        $web_list = $model_web_config->getWebList(array('web_id'=> $web_id));
        $web_array = $web_list[0];
        if(!empty($web_array) && is_array($web_array)) {
            $model_web_config->updateWebHtml($web_id,$web_array);
            showMessage(Language::get('nc_common_op_succ'));
        } else {
            showMessage(Language::get('nc_common_op_fail'));
        }
    }

    /**
     * 头部促销区
     */
    public function sale_editOp() {
        $model_web_config = Model('web_config');
        $web_id = '121';
        $code_list = $model_web_config->getCodeList(array('web_id'=> $web_id));
        if(is_array($code_list) && !empty($code_list)) {
            $model_class = Model('goods_class');
            $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
            Tpl::output('goods_class',$goods_class);
            foreach ($code_list as $key => $val) {//将变量输出到页面
                $var_name = $val['var_name'];
                $code_info = $val['code_info'];
                $code_type = $val['code_type'];
                $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
                Tpl::output('code_'.$var_name,$val);
            }
        }
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_sale.edit');
    }
    /**
     * 海豚主场首页
     */
    public function htIndexOp()
    {
        $model_web_config = Model('web_config');
        $web_id = '616';
        $code_list = $model_web_config->getCodeList(array('web_id'=> $web_id));
        $model_class = Model('goods_class');
        $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
        Tpl::output('goods_class',$goods_class);
        foreach ($code_list as $key => $val) {//将变量输出到页面
            $var_name = $val['var_name'];
            $code_info = $val['code_info'];
            $code_type = $val['code_type'];
            $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
            Tpl::output('code_'.$var_name,$val);
        }

        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_ht.edit');
    }
    /**
     * 商品分类
     */
    public function category_listOp() {
        $model_class = Model('goods_class');
        $gc_parent_id = intval($_GET['id']);
        $gc_parent_id=0;//只选择一级分类
        $goods_class = $model_class->getGoodsClassListByParentId($gc_parent_id);
        $goods_nav = Model('goods_class_nav')->getGoodsClassNavALL();
        $nav_ico = array();
        foreach ($goods_nav as $k=>$v){
            $nav_ico[$v['gc_id']]=$v['cn_pic']; //一级分类图标文件
        }
        unset($goods_nav);
        foreach ($goods_class as &$v){
            $v['cn_pic']=$nav_ico[$v['gc_id']];
        }
        unset($v);
        Tpl::output('goods_class',$goods_class);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_goods_class','null_layout');
    }

    /**
     * 商品推荐
     */
    public function recommend_listOp() {
        $model_web_config = Model('web_config');
        $condition = array();
        $gc_id = intval($_GET['id']);
        if ($gc_id > 0) {
//            $condition['gc_id'] = $gc_id;
            $condition['gc_id_1|gc_id_2|gc_id_3|gc_id_4']=$gc_id;//分类模糊查询
        }
        $goods_name = trim($_GET['goods_name']);
        if (!empty($goods_name)) {
            $goods_id = intval($_GET['goods_name']);
            if ($goods_id === $goods_name) {
                $condition['goods_id'] = $goods_id;
            } else {
                $condition['goods_name'] = array('like','%'.$goods_name.'%');
            }
        }
        $goods_list = $model_web_config->getGoodsList($condition,'goods_id desc',6);
        Tpl::output('show_page',$model_web_config->showpage(2));
        Tpl::output('goods_list',$goods_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_goods.list','null_layout');
    }

    /**
     * 商品排序查询
     */
    public function goods_listOp() {
        $model_web_config = Model('web_config');
        $condition = array();
        $order = 'goods_salenum desc,goods_id desc';//销售数量
        $goods_order = trim($_GET['goods_order']);
        if (!empty($goods_order)) {
            $order = $goods_order.' desc,goods_id desc';
        }
        $gc_id = intval($_GET['id']);
        if ($gc_id > 0) {
            //$condition['gc_id'] = $gc_id;
            $condition['gc_id_1|gc_id_2|gc_id_3|gc_id_4']=$gc_id;//分类模糊查询
        }
        $goods_name = trim($_GET['goods_name']);
        if (!empty($goods_name)) {
            $goods_id = intval($_GET['goods_name']);
            if ($goods_id === $goods_name) {
                $condition['goods_id'] = $goods_id;
            } else {
                $condition['goods_name'] = array('like','%'.$goods_name.'%');
            }
        }
        $goods_list = $model_web_config->getGoodsList($condition,$order,6);
        Tpl::output('show_page',$model_web_config->showpage(2));
        Tpl::output('goods_list',$goods_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_goods_order','null_layout');
    }

    /**
     * 品牌
     */
    public function brand_listOp() {
        $model_brand = Model('brand');
        /**
         * 检索条件
         */
        $condition = array();
        if (!empty($_GET['brand_name'])) {
            $condition['brand_name'] = array('like', '%' . trim($_GET['brand_name']) . '%');
        }
        if (!empty($_GET['brand_initial'])) {
            $condition['brand_initial'] = trim($_GET['brand_initial']);
        }
        $brand_list = $model_brand->getBrandPassedList($condition, '*', 6);
        Tpl::output('show_page',$model_brand->showpage());
        Tpl::output('brand_list',$brand_list);
		Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_brand.list','null_layout');
    }

    /**
     * 保存设置
     */
    public function code_updateOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $state = $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
        }
        if($state) {
            echo '1';exit;
        } else {
            echo '0';exit;
        }
    }

    /**
     * 保存图片
     */
    public function upload_picOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $file_name = 'web-'.$web_id.'-'.$code_id;
            $pic_name = $this->_upload_pic($file_name);//上传图片
            if (!empty($pic_name)) {
                $code_info['pic'] = $pic_name;
            }

            Tpl::output('var_name',$var_name);
            Tpl::output('pic',$code_info['pic']);
            Tpl::output('type',$code_info['type']);
            Tpl::output('ap_id',$code_info['ap_id']);
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $state = $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
            Tpl::showpage('web_upload_pic','null_layout');
        }
    }

    /**
     * 中部推荐图片
     */
    public function recommend_picOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        $key_id = intval($_POST['key_id']);
        $pic_id = intval($_POST['pic_id']);
        if (!empty($code) && ($key_id > 0) && ($pic_id > 1)) {
            $code_info = $code['code_info'];
            $code_type = $code['code_type'];
            $code_info = $model_web_config->get_array($code_info,$code_type);//原数组

            $var_name = "pic_list";
            $pic_info = $_POST[$var_name];
            $pic_info['pic_id'] = $pic_id;
            if (!empty($code_info[$key_id]['pic_list'][$pic_id]['pic_img'])) {//原图片
                $pic_info['pic_img'] = $code_info[$key_id]['pic_list'][$pic_id]['pic_img'];
            }

            $file_name = 'web-'.$web_id.'-'.$code_id.'-'.$key_id.'-'.$pic_id;
            $pic_name = $this->_upload_pic($file_name);//上传图片
            if (!empty($pic_name)) {
                $pic_info['pic_img'] = $pic_name;
            }

            $recommend_list = array();
            $recommend_list = $_POST['recommend_list'];
            $recommend_list['pic_list'] = $code_info[$key_id]['pic_list'];
            $code_info[$key_id] = $recommend_list;
            $code_info[$key_id]['pic_list'][$pic_id] = $pic_info;

            Tpl::output('pic',$pic_info);
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $state = $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
            Tpl::showpage('web_recommend_pic','null_layout');
        }
    }

    /**
     * 保存促销区左侧广告图
     */
    public  function  sales_picOp(){

        $sale_id = intval($_POST['sale_id']);

        $file_name = 'salespic-'.$sale_id;
        $pic_name = $this->_upload_pic($file_name);//上传图片

        Tpl::output('pic',$pic_name);
        Tpl::output('var_name',$sale_id);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

        Tpl::showpage('web_upload_sales_pic','null_layout');
    }
    /**
     * 保存切换图片
     */
    public function slide_advOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $pic_id = intval($_POST['slide_id']);
            if ($pic_id > 0) {
                $var_name = "slide_pic";
                $pic_info = $_POST[$var_name];
                $pic_info['pic_id'] = $pic_id;
                if (!empty($code_info[$pic_id]['pic_img'])) {//原图片
                    $pic_info['pic_img'] = $code_info[$pic_id]['pic_img'];
                }
                $file_name = 'web-'.$web_id.'-'.$code_id.'-'.$pic_id;
                $pic_name = $this->_upload_pic($file_name);//上传图片
                if (!empty($pic_name)) {
                    $pic_info['pic_img'] = $pic_name;
                }

                $code_info[$pic_id] = $pic_info;
                Tpl::output('pic',$pic_info);
            }
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

            Tpl::showpage('web_upload_slide','null_layout');
        }
    }

    /**
     * 保存焦点区切换大图
     */
    public function screen_picOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];
            $key = intval($_POST['key']);
            $ap_pic_id = intval($_POST['ap_pic_id']);
            if ($ap_pic_id > 0 && $ap_pic_id == $key) {
                $ap_color = $_POST['ap_color'];
                $code_info[$ap_pic_id]['color'] = $ap_color;
                Tpl::output('ap_pic_id',$ap_pic_id);
                Tpl::output('ap_color',$ap_color);
            }
            $pic_id = intval($_POST['screen_id']);
            if ($pic_id > 0 && $pic_id == $key) {
                $var_name = "screen_pic";
                $pic_info = $_POST[$var_name];
                $pic_info['pic_id'] = $pic_id;
                if (!empty($code_info[$pic_id]['pic_img'])) {//原图片
                    $pic_info['pic_img'] = $code_info[$pic_id]['pic_img'];
                }
                $file_name = 'web-'.$web_id.'-'.$code_id.'-'.$pic_id;
                $pic_name = $this->_upload_pic($file_name);//上传图片
                if (!empty($pic_name)) {
                    $pic_info['pic_img'] = $pic_name;
                }

                $code_info[$pic_id] = $pic_info;
                Tpl::output('pic',$pic_info);
            }
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

            Tpl::showpage('web_upload_screen','null_layout');
        }
    }

    /**
     * 保存焦点区切换小图
     */
    public function focus_picOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $key = intval($_POST['key']);
            $slide_id = intval($_POST['slide_id']);
            $pic_id = intval($_POST['pic_id']);
            if ($pic_id > 0 && $slide_id == $key) {
                $var_name = "focus_pic";
                $pic_info = $_POST[$var_name];
                $pic_info['pic_id'] = $pic_id;
                if (!empty($code_info[$slide_id]['pic_list'][$pic_id]['pic_img'])) {//原图片
                    $pic_info['pic_img'] = $code_info[$slide_id]['pic_list'][$pic_id]['pic_img'];
                }
                $file_name = 'web-'.$web_id.'-'.$code_id.'-'.$slide_id.'-'.$pic_id;
                $pic_name = $this->_upload_pic($file_name);//上传图片
                if (!empty($pic_name)) {
                    $pic_info['pic_img'] = $pic_name;
                }

                $code_info[$slide_id]['pic_list'][$pic_id] = $pic_info;
                Tpl::output('pic',$pic_info);
            }
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
			Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/

            Tpl::showpage('web_upload_focus','null_layout');
        }
    }

    /**
     * 上传图片
     */
    private function _upload_pic($file_name) {
        $pic_name = '';
        if (!empty($file_name)) {
            if (!empty($_FILES['pic']['name'])) {//上传图片
//                $upload = new UploadFile();
                $upload = new AliOssUpload();
                $filename_tmparr = explode('.', $_FILES['pic']['name']);
                $ext = end($filename_tmparr);
                $upload->set('default_dir',ATTACH_EDITOR);
                $upload->set('file_name',$file_name.".".$ext);
                $result = $upload->upfile('pic');
                $img_path = $upload->getSysSetPath() . $upload->file_name;
                if ($result) {
                    $pic_name = $img_path.'?'.mt_rand(100,999);//加随机数防止浏览器缓存图片
                }
            }
        }
        return $pic_name;
    }
}
