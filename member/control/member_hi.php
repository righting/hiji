<?php
/**
 * 我的HI值中心
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');
class member_hiControl extends BaseMemberControl
{


    protected $totalHi=0;

    public function __construct()
    {
        parent::__construct();
        Tpl::output('current_active_name','member_hi');
    }

    /**
     * HI值首页
     */
    public function indexOp()
    {
        $user_id = $_SESSION['member_id'];
        $model = Model('user_hi_value');
        $hi_data = $model->getMemberHiInfo($user_id);
        $EnableExchangeHiValue = $model->getEnableExchangeHiValue($user_id);
        $member_hi = $model->where(['user_id'=>$user_id])->find();
        $member_if = Model('member')->getMemberInfo(['member_id'=>$user_id],'available_predeposit');//余额
        Tpl::output('EnableExchangeHiValue',$EnableExchangeHiValue);

        Tpl::output('available_predeposit',$member_if['available_predeposit']);
        $hi_total = 0;
        if (!empty($hi_data)){
            foreach ($hi_data as $v){
                $hi_total+=$v['value'];
            }
            Tpl::output('myhi',$hi_data);
            Tpl::output('hi_total',$hi_total);
        }

        $model_log = Model('user_hi_log');
        $hi_expire = $model_log->getHiExpire($user_id,7);//获取7天内将要过期的Hi值

        $log_list = $model_log->getHiLogList(['user_id'=>$user_id]);


        //获取所有会员等级信息
        $userLevelModel =  Model('user_level');
        $where['level'] = ['gt',0];
        $field='id,level_name,give_hi,hi_term';
        $levelInfo=$userLevelModel->getLevelAll($where,$field);

        //计算出每级获得的总HI值
        foreach($levelInfo as $k=>$v){
            $levelInfo[$k]['give_hi'] = intval($v['give_hi']);
            $this->totalHi += intval($v['give_hi']);
            $levelInfo[$k]['total_hi'] = intval($this->totalHi);
        }

        Tpl::output('level_info',$levelInfo);
        Tpl::output('member_hi',$member_hi);
        Tpl::output('log_list',$log_list);
        Tpl::output('hi_expire',$hi_expire);
        self::profile_menu('log','index');
        Tpl::output('show_page',$model_log->showpage());
        Tpl::output('webTitle',' - 我的HI值');
        Tpl::showpage('member_hi.index');
    }
    public function listOp(){
        $model_log = Model('user_hi_log');
        $log_list = $model_log->getHiLogList(['user_id'=>$_SESSION['member_id']]);
        Tpl::output('log_list',$log_list);

        self::profile_menu('log','list');

        Tpl::showpage('member_hi.list');
    }

    /**
     *分红hi值转分红余额
     */
    public function hiExchangeBonusOp(){
        $user_id = $_SESSION['member_id'];
        $model_hi_value_model = Model('user_hi_value');
        $hi_info = $model_hi_value_model->getEnableExchangeHiValue($user_id);
        if(chksubmit()){
            $hi_value =$_POST['exchange_bonus'];
            //验证操作
            if ($user_id != $_POST['user_id']){
                showDialog('非法操作','','error','');
            }
            //验证数据
            if ($hi_info['enable_hi']<$hi_value){
                showDialog('超出可换现HI值','','error','');
            }
            if (!preg_match("/^[1-9][0-9]*$/",$hi_value)){
                showDialog('输入数组必须为正整数','','error','');
            }
            //事务操作减少hi值与log，增加分红数据与log

            Model::beginTransaction();
            try{
                $model_hi_value_model->changeUserHi($user_id,$hi_value,$model_hi_value_model::HI_TYPE_BONUS_TO_HI,$model_hi_value_model::CHANGE_TYPE_DEC);//操作hi值变化
                Model('predeposit')->changePd('hi_to_bonus',array('amount'=>$hi_value,'member_id'=>$user_id,'member_name'=>$_SESSION['member_name'])); //操作余额
                Model::commit();
                showDialog('转换成功','reload','succ','');
            }catch (Exception $e){
                Model::rollback();
                showDialog('换现失败','','error','');
            }
        }
        Tpl::output('hi_info',$hi_info);
        Tpl::showpage('member_hi.hitobonus','null_layout');
    }

    /**
     * 奖金转hi值
     */
    public function bonusExchangeHiOp(){
        $user_id = $_SESSION['member_id'];
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfo(['member_id'=>$user_id]);//查询用户信息

        if (chksubmit()) {
            $available_predeposit = $_POST['available_predeposit'];//可分红余额
            $exchange_hi = $_POST['exchange_hi'];//此次转入值

            if ($member_info['available_predeposit']!=$available_predeposit || $user_id != $_POST['user_id'] ){//验证合法性
                showDialog('参数不合法','','error','');
            }
            if ( $exchange_hi>$member_info['available_predeposit']){
                showDialog('输入值不能大于可用红分','','error','');
            }
            if (!preg_match("/^[1-9][0-9]*$/",$exchange_hi)){
                showDialog('输入数值必须为正整数','','error','');
            }
            //事务操作增加hi值与log，减少分红数据与log
            $model_hi_value = Model('user_hi_value');
            Db::beginTransaction();
            try{
                $model_hi_value->changeUserHi($user_id,$exchange_hi,$model_hi_value::HI_TYPE_BONUS_TO_HI,$model_hi_value::CHANGE_TYPE_INC);//操作hi值变化
                Model('predeposit')->changePd('bonus_to_hi',array('amount'=>$exchange_hi,'member_id'=>$user_id,'member_name'=>$_SESSION['member_name'])); //操作现金
                Db::commit();
            }catch (Exception $e){
                Db::rollback();
                showDialog('操作失败','','error','');
            }

            showDialog("转入HI值成功",urlMember('member_hi','index'),'notice','',0);
        }
        Tpl::output('available_predeposit',$member_info['available_predeposit']);
        Tpl::showpage('member_hi.bonustohi','null_layout');
    }

    /**
     * 每日分红自动转入到HI值
     */
    public function bonusAutoToHiOp(){
         if (chksubmit()){
             $auto_exchange_hi = intval($_POST['auto_exchange_hi']);
             if ($auto_exchange_hi>=0 &&  $auto_exchange_hi<=100){
                $res =  Model('user_hi_value')->where(['user_id'=>$_SESSION['member_id']])->update(['auto_to_hi_percent'=>$auto_exchange_hi/100]);
                if ($res){
                    showDialog('设置成功','','succ');
                }else{
                    showDialog('设置失败，请重试','','error');
                }
             }else{
                 showDialog('输入比例超出正常范围','','error');
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
    private function profile_menu($menu_type,$menu_key=''){
        $menu_array = array(
            array('menu_key'=>'index',        'menu_name'=>'我的HI值',    'menu_url'=>urlMember('member_hi','index')),
//            array('menu_key'=>'list',       'menu_name'=>'HI值明细',    'menu_url'=>urlMember('member_hi','list')),
        );
//        switch ($menu_type) {
//            case 'cashadd':
//                $menu_array[] = array('menu_key'=>'cashadd','menu_name'=>'提现申请',    'menu_url'=>'index.php?controller=predeposit&action=pd_cash_add');
//                break;
//            case 'cashinfo':
//                $menu_array[] = array('menu_key'=>'cashinfo','menu_name'=>'提现详细',  'menu_url'=>'');
//                break;
//            case 'log':
//            default:
//                break;
//        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}