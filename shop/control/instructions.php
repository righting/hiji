<?php
/**
 * 默认展示页面
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */


defined('ByCCYNet') or exit('Access Invalid!');
class instructionsControl extends BaseInstructionsControl{

    public function __construct()
    {
        parent::__construct();
        // 获取三个顶级分类
        $article_class_model = Model('article_class');
        $first_where['ac_id'] = ['in',[7,27,34]];
        $first_where['ac_parent_id'] = ['in',[7,27,34]];
        $first_where['_op'] = 'OR';
        $first_class_list = $article_class_model->where($first_where)->order('ac_sort desc')->select();
        $top_nav_arr = [];

        foreach ($first_class_list as $key=>$value){
            if($value['ac_parent_id'] == 0){
                $top_nav_arr[$value['ac_id']] = $value;
            }
        }
        if(!empty($top_nav_arr)){
            foreach ($top_nav_arr as $top_key=>$top_nav_value){
                foreach ($first_class_list as $key=>$value){
                    if($value['ac_parent_id'] == $top_nav_value['ac_id']){
                        $top_nav_arr[$top_key]['child'][] = $value;
                    }
                    continue;
                }
            }
        }

        $all_class_id = array_column($first_class_list,'ac_id');    // 所有分类id
        $default_class = reset($top_nav_arr); // 默认为第一个分类
        $current_first_class = intval($_GET['f']);
        // 获取当前选中的一级分类id（默认为第一个分类）
        if(!in_array($current_first_class,$all_class_id)){
            $current_first_class = $default_class['ac_id'];
        }


        $current_second_class = intval($_GET['s']);
        // 获取当前选中的二级分类id（默认为第一个分类的第一个子分类）
        // 检查二级分类是否属于当前一级分类的子分类，如果不是则默认为当前一级分类的第一个子分类
        $all_second_class_id = array_column($top_nav_arr[$current_first_class]['child'],'ac_id');
        if(!in_array($current_second_class,$all_second_class_id)){
            $current_second_class = reset($all_second_class_id);
        }

        // 获取当前选中的三级分类id（默认为第一个）
        $current_third_class = intval($_GET['t']);
        // 检查当前三级分类是否属于当前选中的二级分类
        $third_info = $article_class_model->where(['ac_id'=>$current_third_class,'ac_parent_id'=>$current_second_class])->find();
        if(!$third_info){
            // 如果不存在，那么获取二级分类的第一个子类
            $all_third_class_arr = $article_class_model->where(['ac_parent_id'=>$current_second_class])->order('ac_sort desc')->select();
            $default_third_class = reset($all_third_class_arr);
            $current_third_class = $default_third_class['ac_id'];
        }
        // 根据三级分类id获取对应的文章
        $article_model = Model('article');
        $article_info = $article_model->where(['ac_id'=>$current_third_class])->find();

        Tpl::output('top_nav_arr',$top_nav_arr);
        Tpl::output('current_first_class',$current_first_class);
        Tpl::output('current_second_class',$current_second_class);
        Tpl::output('current_third_class',$current_third_class);
        Tpl::output('all_third_class_arr',$all_third_class_arr);
        Tpl::output('article_info',$article_info);
    }


    public function indexOp(){

        Tpl::showpage('instructions/index');
    }


    /**
     * 海吉商学院
     */
    public function schoolOfBusinessOp(){

        Tpl::showpage('instructions/school_of_business');
    }


    /**
     * 海吉商圈
     */
    public function businessCircleOp(){


        Tpl::showpage('instructions/business_circle');
    }

    /**
     * 合作共赢
     */
    public function cooperationOp(){

        Tpl::showpage('instructions/cooperation');
    }


}
