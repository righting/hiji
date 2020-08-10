<?php
/**
 * 贡献值列表
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class member_contributionControl extends BaseMemberControl {
    public function __construct() {
        parent::__construct();
        Tpl::output('current_active_name','member_contribution');
    }
    /**
     * 贡献值列表
     */
    public function list_logOp(){
        $model = Model('contribution_log');
        $data =$model->where(['member_id'=>$_SESSION['member_id']])->page(20)->order('create_time desc')->select();
        $member = Model('member')->getMemberInfoByID($_SESSION['member_id'],'member_contribution');

        //获取贡献值以类型分组
        $info =  $model->where(['member_id'=>$_SESSION['member_id']])->field('sum(contribution) as contribution,type')->group('type')->order('type asc')->select();

        Tpl::output('total',$member['member_contribution']);
        Tpl::output('info',$info);
        Tpl::output('log_list',$data);
        Tpl::output('show_page',$model->showpage());
        self::profile_menu('C');
        Tpl::output('webTitle',' - 我的贡献值');
        Tpl::showpage('member_contribution.list');
    }
    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @param array     $array      附加菜单
     * @return
     */
    private function profile_menu($menu_key='',$array=array()) {
        $menu_array = array(
            array('menu_key'=>'C',  'menu_name'=>'贡献值明细',    'menu_url'=>urlMember('member_contribution','list_log')),
        );
        if(!empty($array)) {
            $menu_array[] = $array;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
