<?php
/**
 * 微分销商城
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 10:12
 */
defined('ByCCYNet') or exit('Access Invalid!');

class distributionControl extends BaseMemberControl {
   public  function  __construct()
   {
       parent::__construct();
       Language::read('member_distribution');//读取语言配置
       Tpl::output('member_sign','member');//设置当前导航栏
       $left= leftMenuList();
       $left_menu = $left['member'];
       Tpl::output('left',$left_menu); //设置当前栏目左侧菜单
       Tpl::output('current_active_name','distribution');
       define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/'.TPL_NAME);
   }
   public function indexOp(){
       $user_id = $_SESSION['member_id'];
       $member_info =Model('member')->getMemberInfo(['member_id'=>$user_id]);
        if ($member_info['is_distribution'] != 1){
            @header('location:'.urlMember('distribution','apply'));//不是微商的用户跳至申请页面
        }
       $distribute_goods = Model('distribute_goods');
       $recommend = $distribute_goods->where(['user_id'=>$user_id])->find();//获取个人微商自己推荐列表
       $recommend = unserialize($recommend['goods_info']);
       if (empty($recommend)){
           $recommend=[[],[]];
       }elseif (count($recommend)<2){
           $recommend[]=array();
       }
       Tpl::output('recommend_list',$recommend);
       $mygoodsinfo['total']=$distribute_goods::GOODS_MAX;

       Tpl::output('mygoodsinfo',$mygoodsinfo);

       $model_class = Model('goods_class');
       $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
       //去除专项商品
       $annual_fee_gc_id = C('annual_fee_gc_id');
       foreach ($goods_class as $k=>$v){
            if ($v['gc_id']==$annual_fee_gc_id){
                unset($goods_class[$k]);
            }
       }
       Tpl::output('goods_class',$goods_class);
       Tpl::output('code_info',$recommend);
       //获取微店名
       $member_detail = Model('member_detail')->where(['member_id'=>$user_id])->find();
       Tpl::output('wd_name',$member_detail['wd_name']);

       switch ($member_info['is_distribution']){
           case 0: $state = '微店状态:未申请';break;
           case 1: $state = '微店状态:正常,有效期至:'.date('Y-m-d',$member_detail['distr_end']) ;break;
           case 2: $state = '微店状态:已过期，请重新申请';break;
       }
       Tpl::output('proc_state',$state);//微店状态信息

       Tpl::showpage('distribution_index');
   }

    /**
     * 微店订单
     */
    public function wdordersOp(){

        $condition['referral_key'] = hj_encrypt($_SESSION['member_id']);
        $model_orderGoods = Model('order_goods');
        $order_goods =$model_orderGoods->where($condition)->select();//订单商品
        $orderArrs = array_unique(array_column($order_goods,'order_id')) ;//订单id
        $order_model = Model('orders');
        $orders = $order_model->where(['order_id'=>['in',implode(',',$orderArrs)]])->page(20)->order('order_id desc')->select();

        Tpl::output('orders',$orders);
        Tpl::output('order_goods',$order_goods);
        Tpl::output('show_page',$order_model->showpage());
        Tpl::showpage('distribution_orders');
    }
    /**
     * ajax删除一个分销商品
     */
   public function ajaxDelOp(){
    if ($_POST){
        $goods_id = $_POST['goods_id'];
        $user_id = $_POST['user_id'];
       if (empty($goods_id) || empty($user_id) || $user_id!=$_SESSION['member_id']){
           exit(json_encode(['state'=>'error','msg'=>'参数错误']));
//           showDialog('参数错误');
        }

        $distribute_goods = Model('distribute_goods');
        $res = $distribute_goods->delGoods(array('user_id'=>$user_id,'goods_id'=>$goods_id));
        if (empty($res)){
            exit(json_encode(['state'=>'error','msg'=>'删除错误，请重试']));
//            showDialog('删除错误，请重试');
        }else{
            exit(json_encode(['state'=>'ok','msg'=>'删除成功','goods_id'=>$goods_id]));
//            showDialog('删除成功','reload','notice','',1);
        }
    }
   }

    /**
     * 推荐分销商品
     */
   public function ajaxHotGoodsOp(){
        if (chksubmit()){
            $goods_num = $_POST['goods_num'];//返回商品数
            $json_encode = Model('goods')->field('goods_id,goods_name,goods_price,goods_image')->where(['goods_state'=>1,'goods_verify'=>1])->order('goods_salenum desc')->limit($goods_num)->select();
            exit(json_encode($json_encode,JSON_UNESCAPED_UNICODE));
        }
   }
    /**
     * 申请分销商城
     */
   public function applyOp(){
       $model_dist = Model('store_distribution');
       $member_id=$_SESSION['member_id'];
       $member_info = Model('member')->getMemberInfoByID($member_id);
        if (chksubmit()){
            Db::beginTransaction();
            try{
                //修改会员分销状态
                $res = Model('member')->editMember(['member_id'=>$member_id],['is_distribution'=>1]);
                if (!$res)
                    throw new Exception("修改失败");
                if ($member_info['is_distribution']==2){
                    $data['distr_end'] = strtotime("+1 year");
                }else{
                    $data['distr_start']=TIMESTAMP;
                    $data['distr_end']=strtotime("+1 year");
                    $res = Model('distribute_goods')->insert(['user_id'=>$member_id]);
                    if (!$res)
                        throw new Exception("修改失败");
                }
                $res = Model('member_detail')->editMemberDetail(['member_id'=>$member_id],$data);
                if (!$res)
                    throw new Exception("修改失败");
                //修改会员结束时间
                Db::commit();
            }catch (Exception $e){
                Db::rollback();
                showDialog("申请失败请重试 ",'','error');
            }
            showDialog("申请微店成功，去推荐商品 ",urlMember('distribution','index'),'succ');
        }

       if ($member_info['is_distribution']==1){
          @header("Location:".urlMember('distribution','index'));  //已经成为分销商跳转到申请进度
       }

       $user_level = Model('user_level');
       $model = $user_level->where(['id'=>$member_info['level_id']])->find();
        if ($model['level']<=$user_level::LEVEL_ONE || $member_info['is_distribution']=='2'){//当前会员为普通或免费等级未成为分销商或分销过期
            //购买专项商品
            $setting = rkcache('setting');//获取设置
            $annual_fee_goods = Model('goods')->getGoodsList(array('gc_id_1'=>$setting['annual_fee_gc_id']),'*','','goods_id desc','5');//获取专项消费商品
            Tpl::output('annual_fee_goods',$annual_fee_goods);
        }

       self::profile_menu('','apply');
       Tpl::output('webTitle',' - 我的微店');
       Tpl::showpage('distribution_apply');
   }
    /**
     * 申请延期操作
     */
   public  function  put_offOp(){
       $model_store_distribution = Model('store_distribution');
       //检查延期条件
       $model_store_distribution->checkPutOffCondition();
       //延期操作
       Db::beginTransaction();
       try{
           Model('member')->editMember(['member_id'=>$_SESSION['member_id']],['is_distribution'=>1]);//变更会员分销状态

           $model_store_distribution->editStoreDistribution(['distri_end_time'=>strtotime("+1 year")],['member_id'=>$_SESSION['member_id'],'distri_state'=>$model_store_distribution::STATE_PASS]);//变更会员分销结束时间
           Db::commit();
           showDialog("申请延期成功","index.php?controller=distribution&action=apply_proc");
       }catch (Exception $e){
           Db::rollback();
           showDialog("申请延期失败","index.php?controller=distribution&action=apply");
       }

   }

    /**
     * 更新个人微商推荐商品
     *
     */
   public function updateRecommendGoodsOp(){
       if ($_POST){
           $member_id=$_SESSION['member_id'];
           $recommend_list = $_POST['recommend_list'];//推荐楼层列表
           $distribute_model = Model('distribute_goods');
            $distribute_goods = $distribute_model->where(['user_id'=>$member_id])->find();
            if (empty($distribute_goods))
                return;
            $goods_info = unserialize($distribute_goods['goods_info']);
            foreach ($recommend_list as $k=>$v){
                if (empty($recommend_list[$k]['goods_list'])){
                    $goods_info[$k]['goods_list']=array();
                }
                $goods_info[$k]=$recommend_list[$k];
            }
            if (!empty($goods_info)){
                $res =$distribute_model->where(['user_id'=>$member_id])->update(['goods_info'=>serialize($goods_info)]);
            }
           if ($res){
               exit(json_encode($res));
           }
       }
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
//        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('web_goods.list','null_layout');
    }

    /**
     * 修改微店店名
     */
    public function editWdNameOp(){
        if (chksubmit()){
            $wd_name = strip_tags(trim($_POST['wd_name']));
            if (mb_strlen($wd_name,"utf-8")>4){
                showDialog('微店名称最多4个汉字,修改请重试','','error','','0');
            }
            if ($wd_name){
                $res = Model('member_detail')->where(['member_id'=>$_SESSION['member_id']])->update(['wd_name'=>$wd_name]);
                if ($res){
                    showDialog('微店名称修改成功','','succ','','0');
                }
            }
            showDialog('微店名称修改失败,请重试','','error','','0');
        }
    }
    /**
     * @param $menu_type
     * @param string $menu_key
     */
    private function profile_menu($menu_type,$menu_key=''){
        $menu_array = array(
            array('menu_key'=>'apply',        'menu_name'=>'微店申请',    'menu_url'=>'index.php?controller=distribution&action=apply'),
        );
        switch ($menu_type) {
            case 'apply':
                $menu_array[] = array('menu_key'=>'apply','menu_name'=>'微店申请',    'menu_url'=>'index.php?controller=distribution&action=apply');
                break;
            default:
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}