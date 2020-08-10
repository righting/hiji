<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:17
 */
class incentiveControl extends BaseShopMemberControl {
    public function indexOp() {
        // 获取分红类型
        $article_class_model    = Model('article_class');

        $article_class_list = rkcache('incentive_$article_class_list');
        if(empty($goods_class_arr_for_id)){
            $article_class_list = $article_class_model->where(['ac_parent_id'=>12])->select();
            wkcache('incentive_$article_class_list',$article_class_list);
        }

        // 默认展示第一个分红的文章
        $type = $_GET['ac_id'];
        if(!in_array($type,array_column($article_class_list,'ac_id'))){
            $type = $article_class_list[0]['ac_id'];
        }

        $article_model = Model('article');

        $info = rkcache('incentive_info_'.$type);
        if(empty($goods_class_arr_for_id)){
            $info = $article_model->where(['ac_id'=>$type])->find();
            wkcache('incentive_info_'.$type,$info);
        }

        $user_id = $_SESSION['member_id'];
        $likeGoods = Model('goods_browse')->getGuessLikeGoods($user_id);
        $likeGoods = array_slice($likeGoods,0,5);

        Tpl::output('current_active_name','incentive');
        Tpl::output('likeGoods',$likeGoods);
        Tpl::output('this_type',$type);
        Tpl::output('info',$info);
        Tpl::output('article_class_list',$article_class_list);
        Tpl::output('webTitle',' - 分红奖金制度');
        Tpl::showpage('incentive/index');

    }


    public function getArticleInfoOp(){
        $acId = isset($_GET['ac_id'])?$_GET['ac_id']:'';
        $rs = array('status'=>-1,'data'=>$acId);
        if(!empty($acId)){
            $article_model = Model('article');
            $info = $article_model->where(['ac_id'=>$acId])->field('article_content')->find();
            if($info){
                $rs['status']=1;
                $rs['data']=$info['article_content'];
            }
        }
        echo json_encode($rs);
    }











}