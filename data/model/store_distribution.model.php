<?php
/**
 * 店铺续签
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持
 */
defined('ByCCYNet') or exit('Access Invalid!');

class store_distributionModel extends Model {
    public function __construct() {
        parent::__construct('store_distribution');
    }
    const  STATE_WAIT=0; //申请中
    const  STATE_PASS=1; //申请通过
    const  STATE_REJECT=2; //申请拒绝
    /**
     * 取得列表
     * @param unknown $condition
     * @param string $pagesize
     * @param string $order
     */
    public function getStoreDistributionList($condition = array(), $pagesize = '', $order = 'distri_id desc') {
        return $this->where($condition)->order($order)->page($pagesize)->select();
    }

    /**
     * 增加新记录
     * @param unknown $data
     * @return
     */
    public function addStoreDistribution($data) {
        return $this->insert($data);
    }

    /**
     * 取单条信息
     * @param unknown $condition
     */
    public function getStoreDistributionInfo($condition) {
        return $this->where($condition)->find();
    }

    /**
     * 更新记录
     * @param unknown $condition
     * @param unknown $data
     */
    public function editStoreDistribution($data,$condition) {
        return $this->where($condition)->update($data);
    }

    /**
     * 取得数量
     * @param unknown $condition
     */
    public function getStoreDistributionCount($condition) {
        return $this->where($condition)->count();
    }

    /**
     * 删除记录
     * @param unknown $condition
     */
    public function delStoreDistribution($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 检查会员申请分销进度
     * @param $member_id
     */
    public function checkApplyProc($member_id){
       $member_detail =  Model('member_detail')->getMemberDetailByID($member_id);
       $member =  Model('member')->getMemberInfoByID($member_id);
       switch ($member['is_distribution']){
           case 0: $state = '未申请分销';break;
           case 1: $state = '已是分销商,有效期至:'.date('Y-m-d',$member_detail['distr_end']) ;break;
           case 2: $state = '已过期，请重新申请';break;
       }
       return $state;
    }

    /**
     * 检查分销商申请延期条件
     */
    public function  checkPutOffCondition(){
        //过去一年内消费总和
        $time = time();
        $condition['buyer_id'] = $_SESSION['member_id'];
        $condition['order_state'] = array('in',array('20','30','40'));
        $begin = strtotime("-1 year");//一年以前时间戳
        $condition['add_time'] = array('between',array($begin,$time));
        $data = Model('order')->getOrderList($condition);
        $sales_money = 0;
        foreach ($data as $v){
            $sales_money += $v['goods_amount'];
        }
        if ($sales_money<365){
            showMessage("你未达到延期条件",'index.php?controll=distribution&action=index');
        }
    }
    /**
     * 检查会员申请成为分销商资格
     */
    public function checkApplyCondition()
    {
        //检查是否符合申请条件（当月消费专项商品并且实名）

        $member_detail = Model('member_detail')->getMemberDetailByID($_SESSION['member_id']);
        if ($member_detail['isauth'] != 1){
            showDialog("你还未实名认证，不能申请分销",'index.php?controll=distribution&action=index','error');
        }
        $member_info = Model('member')->getMemberInfoByID($_SESSION['member_id']);
        $user_level = Model('user_level');
        $level_info = $user_level->where(array('id'=>$member_info['level_id']))->find();
        if ($level_info['level']<=$user_level::LEVEL_ONE){
            $this->_check_annual_fee();
        }else if ($member_info['is_distribution']==2){
            $this->_check_annual_fee();
        }


    }

    /**
     * 检查会员当月是否有专项消费
     */
    private function _check_annual_fee(){
        $setting = rkcache('setting');//获取设置
        $annual_fee_gc_id = $setting['annual_fee_gc_id'];
        unset($setting);
        $field = 'order_goods.goods_price,order_goods.goods_num,order_goods.buyer_id,order_goods.gc_id,order_goods.goods_id';
        $on = 'orders.order_id=order_goods.order_id';
        $this->table('orders,order_goods')->field($field);
        $condition['order_state'] = array('in',array('20','30','40'));
        $condition['order_goods.buyer_id'] = $_SESSION['member_id'];
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));//月初时间戳
        $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));//月未时间戳
        $condition['add_time'] = array('between',array($beginThismonth,$endThismonth));

        $data =  $this->join('inner')->on($on)->where($condition)->select(); //获取个人当月消费记录
        $goods_ids = implode(',',array_column($data,'goods_id'));
        $goods = Model('goods')->where(['gc_id_1'=>$annual_fee_gc_id,'goods_id'=>['in',$goods_ids]])->count();
        if (empty($goods)){
            showDialog("你当月未进行专项消费",'','error');
        }
    }
}