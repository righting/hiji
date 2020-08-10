<?php
/**贡献值日志模型
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 17:41
 */
defined('ByCCYNet') or exit('Access Invalid!');
class contribution_logModel extends Model{
    const CONTRIBUTION_TYPE_UPGRADE=1; //会员升级
    const CONTRIBUTION_TYPE_PROMOTION=2; //会员升职
    const CONTRIBUTION_TYPE_SALES=3; //微商销售业务奖励

    public function __construct($table = null)
    {
        parent::__construct('contribution_log');
    }

    /**操作贡献值
     * @param array $data
     * @return mixed
     */
    public function operateContribution($data=array()){
        $this->insert($data);//插入贡献值日志记录
        $member_contribution_operate='+';
        if ($data['operate']==2){
            $member_contribution_operate='-';
        }
        $res = Model('member')->editMember(['member_id'=>$data['member_id']],['member_contribution'=>['exp','member_contribution'.$member_contribution_operate.$data['contribution']]]);//修改会员贡献值
        return $res;
    }

    /**批量增加贡献值
     * @param array $data
     */
    public function addContributionAll($data=array()){
        if (is_array($data) && !empty($data)){
            $this->insertAll($data);
            $data = array_column($data,$data['contribution'],$data['member_id']);
            $sql = 'update member set positions_id = case member_id ';
            $ids = '';
            foreach ($data as $k=>$v) {
                $sql .= sprintf("WHEN %d THEN member_contribution+%d ", $k, $v);//拼接字符串
                $ids .=$k.',';
            }
            $ids = substr($ids,0,strlen($ids)-1);
            $sql .= "END WHERE member_id IN ($ids)";
            Model()->execute($sql);//增加贡献值
        }
    }

}