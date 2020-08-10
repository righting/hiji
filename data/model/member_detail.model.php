<?php
/**
 * 会员详情模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class member_detailModel extends Model
{

    public function __construct()
    {
        parent::__construct('member_detail');
    }

    /**根据会员ID获取会员详情记录
     * @param $member_id
     * @return mixed
     */
    public function getMemberDetailByID($member_id){
        return $this->table('member_detail')->where(array('member_id'=>$member_id))->find();
    }

    /**编辑会员详情
     * @param $condition
     * @param $data
     * @return mixed
     */
    public function editMemberDetail($condition, $data)
    {

        $res = $this->table('member_detail')->where($condition)->update($data);
        return $res;
    }

    /**获取会员详情列表
     * @return mixed
     */
    public function getMemberDetailList($condition = array(),$page = null){
        $field = 'member.*,member_detail.real_name,member_detail.member_id_number,member_detail.id_card_photo,member_detail.isauth,member_detail.distr_start,member_detail.distr_end,member_detail.id_card_photo_back';
        $on = 'member.member_id=member_detail.member_id';
        $this->table('member,member_detail')->field($field);

        return $this->join('inner')->on($on)->where($condition)->page($page)->order('member_detail.isauth ')->select(); //获取会员实名记录
    }

    public function getMemberAuthCount($condition = array()){
        $this->table('member,member_detail');
        $on = 'member.member_id=member_detail.member_id';
        return $this->on($on)->where($condition)->count();
    }
}