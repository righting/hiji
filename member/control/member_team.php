<?php
/**
 * 会员中心——账户概览
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class member_teamControl extends BaseShopMemberControl
{
    public function __construct() {
        parent::__construct();
        Tpl::output('current_active_name','member_team');
    }

    public function indexOp(){
        $register_invite_model = Model('register_invite');
        $member_model = Model('member');
        $user_id = $_SESSION['member_id'];
        // 获取我的推荐人
        $from_user_info = $register_invite_model->where(['to_user_id'=>$user_id])->find();
        // 如果有推荐人，那么获取推荐人的基本信息
        $field = 'member_id,member_name,member_number,member_truename,member_mobile,level_id,positions_id,member_time';
        $from_user_member_info = [];
        $is_show = 1;       // 是否显示绑定团队按钮
        $is_show_top = 0;
        if(!empty($from_user_info)){
            $is_show = 2;       // 是否显示绑定团队按钮
            $is_show_top = 1;   // 是否显示上级邀请人
            $from_user_member_info = $member_model->where(['member_id'=>$from_user_info['from_user_id']])->field($field)->find();
        }
        if($user_id == 1){
            $is_show = 2;       // 是否显示绑定团队按钮
        }
        // 我的下级团队
        $page_size = 10;
        $invite_user_arr = $register_invite_model->where(['from_user_id'=>$user_id])->page($page_size)->order('register_at desc')->select();
        $invite_user_member_info = [];
        if(!empty($invite_user_arr)){
            $invite_user_id_arr = array_column($invite_user_arr,'to_user_id');
            $invite_user_member_info = $member_model->where(['member_id'=>['in',$invite_user_id_arr]])->field($field)->order('member_time desc')->select();
        }

        // 获取所有等级信息
        $user_level_model = Model('user_level');
        $level_info = $user_level_model->select();
        $level_info_for_id = array_combine(array_column($level_info,'id'),array_column($level_info,'level_name'));
        // 获取所有职级信息
        $positions_model = Model('positions');
        $positions_info = $positions_model->select();
        $positions_info_for_id = array_combine(array_column($positions_info,'id'),array_column($positions_info,'title'));
        $can_invite = 1;
        if($from_user_member_info['level_id'] == 7){
            $can_invite = 0;
        }
        Tpl::output('is_show', $is_show);
        Tpl::output('is_show_top', $is_show_top);
        Tpl::output('from_user_member_info', $from_user_member_info);
        Tpl::output('invite_user_member_info', $invite_user_member_info);
        Tpl::output('level_info_for_id', $level_info_for_id);
        Tpl::output('positions_info_for_id', $positions_info_for_id);
        Tpl::output('team_user_page', $register_invite_model->showpage());
        Tpl::output('can_invite', $can_invite);
        Tpl::output('webTitle',' - 我的团队');
        Tpl::showpage('corporate_team/test');
    }

    public function indexOp备份(){
        // 获取我的推荐人



        // 检查当前用户有没有团队
        // 如果有团队，就显示团队列表
        // 如果没有，就显示绑定团队按钮
        $user_id = $_SESSION['member_id'];
        $page_size = 10;
        $register_invite_model = Model('register_invite');
        $lists = $register_invite_model->where(['from_user_id'=>$user_id])->page($page_size)->select();
        // 检查当前用户有没有绑定团队
        $check_bind = $register_invite_model->where(['to_user_id'=>$user_id])->find();
        $is_show = 0;       // 是否显示绑定团队按钮
        if(empty($check_bind)){
            $is_show = 1;
        }
        $to_user_lists = [];
        $member_model = Model('member');
        if(!empty($lists)){
            $to_user_id_arr = array_column($lists,'to_user_id');
            $field = 'member_id,member_name,member_truename,member_mobile,member_points,member_exppoints,level_id,positions_id';
            $to_user_lists = $member_model->where(['member_id'=>['in',$to_user_id_arr]])->field($field)->select();
            $to_user_lists_for_id = array_combine(array_column($to_user_lists,'member_id'),$to_user_lists);
            foreach ($lists as $key=>$value){
                $lists[$key]['member_info'] = $to_user_lists_for_id[$value['to_user_id']];
            }
        }
        // 获取所有等级信息
        $user_level_model = Model('user_level');
        $level_info = $user_level_model->select();
        $level_info_for_id = array_combine(array_column($level_info,'id'),$level_info);
        // 获取所有职级信息
        $positions_model = Model('positions');
        $positions_info = $positions_model->select();
        $positions_info_for_id = array_combine(array_column($positions_info,'id'),$positions_info);
        // 获取用户当前的等级是否可以邀请会员
        $user_info = $member_model->where(['member_id'=>$user_id])->field($field)->find();
        $can_invite = 1;
        if($user_info['level_id'] == 7){
            $can_invite = 0;
        }
        Tpl::output('is_show', $is_show);
        Tpl::output('lists', $lists);
        Tpl::output('level_info_for_id', $level_info_for_id);
        Tpl::output('positions_info_for_id', $positions_info_for_id);
        Tpl::output('can_invite', $can_invite);
        Tpl::output('team_user_page', $register_invite_model->showpage());
        Tpl::showpage('corporate_team/first_team');
    }


    public function returns($msg = '操作异常',$status = 0,$param = []){
        $return['status'] = $status;
        $return['msg'] = $msg;
        $return['param'] = $param;
        echo json_encode($return);die;
    }

    public function bindOp(){
        // 检查当前用户是否已经绑定了团队
        $register_invite_model = Model('register_invite');
        $user_id = $_SESSION['member_id'];
        $check_bind_info = $register_invite_model->where(['to_user_id'=>$user_id])->find();
        if(!empty($check_bind_info)){
            showDialog('您已经绑定了其他团队，需要换绑请联系客服！', urlMember('member_team', 'index'), 'succ');
        }
        Tpl::showpage('corporate_team/bind');
    }

    public function bindTeamOp(){
        if (chksubmit()) {
            $post = $_POST;
            $user_id = $_SESSION['member_id'];
            $parent_team_id = $post['team_id'];
            $model_user_level = Model('user_level');
            $member_model = Model('member');
            //实名用户才允许绑定团队
            if (intval($_SESSION['isauth'])!=1){
                $this->returns('实名认证后才可绑定团队');
            }
            // 获取要绑定的团队信息
            $parent_user_info = $member_model->where(['member_number' => $parent_team_id,'member_id'=>['neq',$user_id]])->field('member_id,member_name,member_avatar,member_state,level_id')->find();
            if(empty($parent_user_info)){
                $this->returns('团队不存在，请确认后再试！');
            }
            if($parent_user_info['level_id'] == 7){
                $this->returns('您的邀请人当前会员等级不支持邀请团队！');
            }
            // 检查当前用户是否已经绑定了团队
            $register_invite_model = Model('register_invite');
            $check_bind_info = $register_invite_model->where(['to_user_id'=>$user_id])->find();
            if(!empty($check_bind_info)){
                $this->returns('您已经绑定了其他团队，需要换绑请联系客服！');
            }
            // 将当前用户绑定至团队
            $register_invite_data['from_user_id'] = $parent_user_info['member_id'];
            $register_invite_data['to_user_id'] = $user_id;
            $register_invite_data['register_at'] = date('Y-m-d H:i:s');
            $invite = Model('register_invite')->where(['to_user_id'=>$parent_user_info['member_id']])->find();
            $register_invite_data['depth']=intval($invite['depth'])+1;
            $bind_result = $register_invite_model->addRegisterInvite($register_invite_data);
            if($bind_result){
                Model('member')->memberUpgrade($user_id,$model_user_level::LEVEL_ONE);//升级会员等级
                $this->returns('绑定成功!',1);
            }else{
                // 如果不是，则提示不能换绑，『后期需要改成可换绑时，可改为修改（team_name、pid、parent_user_id、team_id）』
                $this->returns('绑定失败！');
            }
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type,$menu_key='') {
        $menu_array     = array();
        switch ($menu_type) {
            case 'member':
                $menu_array = array(
                    array('menu_key'=>'show',  'menu_name'=>'我的团队','menu_url'=>urlMember('member_team','index')),
                    array('menu_key'=>'add',  'menu_name'=>'创建团队','menu_url'=>urlMember('member_team','index')),
                    array('menu_key'=>'bind',  'menu_name'=>'绑定团队','menu_url'=>urlMember('member_team','bind')));
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
