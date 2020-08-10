<?php
/**
 * 帮助中心     2018-07-12      LFP
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */

header("content-type:text/html;charset=utf-8");         //设置编码

defined('ByCCYNet') or exit('Access Invalid!');

class pageControl extends BaseArticleControl {

    /**
     * 单篇文章显示页面
     */
    public function showOp(){
        /*if($_GET['page_key']=='service_centre'){//服务中心
            $url = '/member/index.php?controller=page&action=show&page_key=share_service_centre';
            @header("Location:$url");
        }*/
        if($_GET['page_key']=='share_module'){//分享模块
            $type =  isset($_GET['type'])?intval($_GET['type']):'';
            if(!empty($type) && $type >0){
                switch ($type){
                    case 42:$title='软文分享';break;
                    case 43:$title='音频分享';break;
                    case 44:$title='图片分享';break;
                    case 45:$title='H5分享';break;
                }
                Tpl::output('webTitle',' - 分享阵地-'.$title);
                Tpl::output('current_type',3);
                Tpl::showpage('page_share_module_type','null_layout');
                exit;
            }
            $page_model  = Model('page');
            $page    = $page_model->getOneArticleKey($_GET['page_key']);
            Tpl::output('page',$page);
            //获取视频
            $videoModel = Model('video');
            $videoInfo=$videoModel->getVideoList(['video_type'=>3]);
            Tpl::output('videoInfo',$videoInfo);
            Tpl::output('webTitle',' - 分享阵地-分享模块');
            Tpl::output('current_type',3);
            Tpl::output('page_key',$_GET['page_key']);
            Tpl::output('type',$_GET['type']);
            Tpl::showpage('page_share_module','null_layout');
            exit;
        }


        if($_REQUEST['ajaxapi']==1){
            $page_model  = Model('page');
            $page    = $page_model->getOneArticleKey($_GET['page_key']);
            if(empty($page) || !is_array($page) || $page['page_show']=='0'){
                echo json_encode(array('stata'=>9,'msg'=>'页面不存在'));
            }
            echo json_encode(array('stata'=>0,'msg'=>$page['page_content']));
        }else{
            $page_model  = Model('page');
            $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
            $page_class_model  = Model('page_class');
            $page_type = $page_class_model->getOneClass($page[0]['page_type']);
            Tpl::output('current_type',3);
            Tpl::output('page_type',$page_type);
            $this->$_GET['page_key']();
        }

    }
    //绿色发展
    public function green_develop(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
        showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }

        //echo showEditorFilterHtml('page_content',$page['page_content']);
        //echo $page['page_content'];exit;



        $model = Model('goods_class');
        $where['status'] = 1;
        $where['gc_parent_id'] = 5204;
        $field='gc_id,gc_name,gc_parent_id';

        //获取农耕优品分类下的顶级分类
        $getCategoryInfo =$model->where($where)->field($field)->select();
        //获取顶级分类下的子类
        $this->getNgypAllCategory($getCategoryInfo);


        Tpl::output('goods_category_info',$getCategoryInfo);

        Tpl::output('page',$page);
        $article_model  = Model('article');
        $article = $article_model->getArticleList(array('ac_id'=>29));
        Tpl::output('article1',$article);
        $article = $article_model->getArticleList(array('ac_id'=>30));
        Tpl::output('article2',$article);
        $article = $article_model->getArticleList(array('ac_id'=>31));
        Tpl::output('article3',$article);

        Tpl::output('webTitle',' - 线下加盟-绿色发展');
        Tpl::output('current_type',5);
        Tpl::showpage('page/green_develop','null_layout');
    }

    //海吉积分
    public function consumption_integral(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }


        Tpl::output('page',$page);

        Tpl::output('current_type',3);

        Tpl::output('webTitle',' - 消费资本-海吉积分');



        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }
    //消费公积金
    public function consumption_accumulation(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }


        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-消费公积金');
        Tpl::output('current_type',4);

        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //消费养老保险
    public function consumption_provide(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }


        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-消费养老保险');
        Tpl::output('current_type',5);

        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }
    //车房梦想金
    public function consumption_dream(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }


        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-车房梦想金');
        Tpl::output('current_type',6);


        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }
    //海吉慈善基金
    public function consumption_charity(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
        }

        Tpl::output('current_type',7);
        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-海吉慈善基金');



        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //品牌托管
    public function offline_brand(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
           // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>13])->limit(1)->order('sort asc,id desc')->find();
        Tpl::output('bannerInfo',$bannerInfo);

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 线下加盟-品牌托管');
        Tpl::output('current_type',2);
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //24小时便利店
    public function offline_24(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }


        //获取视频
        $videoModel = Model('video');
        $videoInfo=$videoModel->getVideoList(['video_type'=>7,'limit'=>1]);
        Tpl::output('videoInfo',$videoInfo);

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 线下加盟-24小时便利店');
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }
    //智能售货机
    public function offline_capacity(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 线下加盟-智能售货机');
        Tpl::output('current_type',3);
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //跨境购体验店
    public function offline_cross(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-跨境购体验店');
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //养老康乐院
    public function offline_provide(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }
        Tpl::output('webTitle',' - 消费资本-养老康乐院');
        Tpl::output('page',$page);
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    //消费养老保险卡服务中心
    public function offline_consumption(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 消费资本-消费养老保险卡服务中心');
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    /**关于我们-资质荣誉**/
    public function share_about(){
        $type = $_GET['type'];
        if($type!='' && $type > 30){
            $this->share_about_newsOp($type);exit;
        }

        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>19])->limit(5)->order('id asc')->select();
        Tpl::output('bannerInfo',$bannerInfo);
        //获取广告图右
        $bannerInfoRight = $bannerModel->where(['c_id'=>20])->limit(1)->order('id asc')->find();
        Tpl::output('bannerInfoRight',$bannerInfoRight);

        if($type==1){
            $model = Model('page');
            $pageWhere['page_key'] = $_GET['page_key'];
            $pageWhere['page_show'] = 1;
            $info=$model->getPageList($pageWhere);
            Tpl::output('info',$info);
            Tpl::output('webTitle',' - 分享阵地-资质荣誉');
            Tpl::output('current_type',2);
            Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
        }else{
            $model = Model('page');
            $pageWhere['page_key'] = $_GET['page_key'];
            $pageWhere['page_show'] = 1;
            $info=$model->getPageList($pageWhere);
            Tpl::output('info',$info);
            Tpl::output('webTitle',' - 分享阵地-关于我们');
            Tpl::output('current_type',2);
            Tpl::showpage('page/share_about_home','null_layout');
        }

    }


    /**关于我们-子菜单**/
    public function share_about_newsOp($type){

        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>19])->limit(5)->order('id asc')->select();
        Tpl::output('bannerInfo',$bannerInfo);
        //获取广告图右
        $bannerInfoRight = $bannerModel->where(['c_id'=>20])->limit(1)->order('id asc')->find();
        Tpl::output('bannerInfoRight',$bannerInfoRight);

        $article_model  = Model('article');
        $where['ac_id'] = $type;
        $article = $article_model->getArticleList($where);
        Tpl::output('article',$article);
        $topTitle='';

        switch ($type){
            case '35':$topTitle='知识产权';break;
            case '36':$topTitle='媒体报道';break;
            case '37':$topTitle='战略合伙';break;
            case '38':$topTitle='代理加盟';break;
            case '39':$topTitle='咨询通告';break;
            case '40':$topTitle='联系我们';break;
            case '41':$topTitle='地图导航';break;
        }
        Tpl::output('type',$type);
        Tpl::output('top_title',$topTitle);
        Tpl::output('webTitle',' - 分享阵地-'.$topTitle);
        Tpl::output('current_type',2);
        Tpl::showpage('page/share_about_news','null_layout');
    }


    /**分享模块**/
    public function share_module(){

    }

    //招贤纳士
    public function share_celebrated(){
        /**
         * 读取语言包
         */
        Language::read('home_page_index');
        $lang   = Language::getLangContent();
        if(empty($_GET['page_key'])){
            // showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
        }

        /**
         * 根据文章编号获取文章信息
         */
        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>$_GET['page_key']));
        if(empty($page) || !is_array($page) || $page['page_show']=='0'){
            //showMessage('页面不存在','','html','error');//'该文章并不存在'
        }

        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 分享阵地-招贤纳士');
        Tpl::output('current_type',5);
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }


    /**海吉商学院**/
    public function share_college(){
        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>22])->limit(1)->order('sort asc,id desc')->select();
        Tpl::output('bannerInfo',$bannerInfo);
        //获取底部广告图
        $bannerInfoBottom = $bannerModel->where(['c_id'=>25])->limit(2)->order('id asc')->select();
        Tpl::output('bannerInfoBottom',$bannerInfoBottom);



        //获取经营管理视频
        $videoModel = Model('video');
        $glInfo=$videoModel->getVideoList(['video_type'=>4,'limit'=>4]);
        Tpl::output('glInfo',$glInfo);

        //获取公信力建设视频
        $gxlInfo=$videoModel->getVideoList(['video_type'=>5,'limit'=>4]);
        Tpl::output('gxlInfo',$gxlInfo);

        //获取海吉商圈视频
        $hjsqInfo=$videoModel->getVideoList(['video_type'=>6,'limit'=>4]);
        Tpl::output('hjsqInfo',$hjsqInfo);

        Tpl::output('webTitle',' - 分享阵地-海吉商学院');
        Tpl::output('current_type',4);
        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }

    /**海吉商学院-海吉商圈**/
    public function share_college_sq(){
        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>22])->limit(1)->order('sort asc,id desc')->select();
        Tpl::output('bannerInfo',$bannerInfo);
        //获取底部广告图
        $bannerInfoBottom = $bannerModel->where(['c_id'=>25])->limit(2)->order('id asc')->select();
        Tpl::output('bannerInfoBottom',$bannerInfoBottom);

        //获取海吉商圈视频
        $videoModel = Model('video');
        $hjsqInfo=$videoModel->getVideoList(['video_type'=>6,'limit'=>1]);
        Tpl::output('hjsqInfo',$hjsqInfo);


        $page_model  = Model('page');
        $page    = $page_model->getPageList(array('page_key'=>'share_college'));
        $page_class_model  = Model('page_class');
        $page_type = $page_class_model->getOneClass($page[0]['page_type']);
        Tpl::output('page_type',$page_type);
        Tpl::output('page',$page);
        Tpl::output('webTitle',' - 分享阵地-海吉商圈');
        Tpl::output('current_type',4);
        Tpl::showpage('page/share_college_sq','null_layout');
    }



    /**海吉服务中心**/
    public function share_service_centre(){
        Tpl::output('webTitle',' - 分享阵地-海吉服务中心');
        Tpl::showpage('page/share_service_centre','null_layout');
    }
    /**海吉服务中心**/
    public function service_centre(){
        Tpl::output('webTitle',' - 分享阵地-海吉服务中心');
        Tpl::showpage('page/share_service_centre','null_layout');
    }


    /**合作共赢**/
    public function share_cooperation(){
        //获取顶部广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>23])->order('sort asc,id desc')->find();
        Tpl::output('bannerInfo',$bannerInfo);

        //获取中间广告图
        $bannerInfoCenter = $bannerModel->where(['c_id'=>24])->limit(2)->order('id asc')->select();
        Tpl::output('bannerInfoCenter',$bannerInfoCenter);

        //获取单页内容
        $model = Model('page');
        $pageWhere['page_key'] = $_GET['page_key'];
        $pageWhere['page_show'] = 1;
        $info=$model->getPageList($pageWhere);
        Tpl::output('info',$info);
        Tpl::output('webTitle',' - 线下加盟-合作共赢');
        Tpl::output('current_type',4);

        Tpl::showpage('page/'.$_GET['page_key'],'null_layout');
    }



    /**会员发展中心**/
    public function member_develop(){
        $model = Model('page');
        $pageWhere['page_key'] = $_GET['page_key'];
        $pageWhere['page_show'] = 1;
        $info=$model->getPageList($pageWhere);
        Tpl::output('info',$info);

        //获取广告图
        $bannerModel = Model('banner');
        $bannerInfo = $bannerModel->where(['c_id'=>12])->limit(5)->order('sort asc,id desc')->select();
        Tpl::output('bannerInfo',$bannerInfo);

        $article_model  = Model('article');
        $where['ac_id'] = 33;
        $where['limit'] = 2;
        $article = $article_model->getArticleList($where);
        Tpl::output('article1',$article);

        $where['ac_id'] = 34;
        $where['limit'] = 5;
        $article2 = $article_model->getArticleList($where);
        Tpl::output('article2',$article2);

        Tpl::output('webTitle',' - 线下加盟-会员发展中心');
        Tpl::output('current_type',6);
        Tpl::showpage('page/member_develop','null_layout');
    }


    public function messageOp(){
        $model = Model('new_message');
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['weixin'] = $_POST['weixin'];
        $data['area']  = $_POST['area'];
        $data['message']  = $_POST['message'];
        $data['create_time']  = date('Y-m-d H:i:s');
        $rs=$model->insert($data);
        echo json_encode($rs);
    }












    /**获取农耕优品子类
     * @param $data
     */
    protected  function getNgypAllCategory(&$data){
        if(empty($data) && !is_array($data)){return false;}
        $model = Model('goods_class');
        $where['status'] = 1;
        $field='gc_id,gc_name,gc_parent_id';
        foreach($data as $k=>$v){
            $where['gc_parent_id'] = ['eq',$v['gc_id']];
            $data[$k]['cateInfo']=$model->where($where)->field($field)->select();
            if(!empty($data[$k]['cateInfo']) && is_array($data[$k]['cateInfo'])){
                $this->getNgypAllCategory($data[$k]['cateInfo']);
            }else{
                continue;
            }
        }
    }
}
