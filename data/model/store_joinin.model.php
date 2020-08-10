<?php
/**
 * 店铺入驻模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class store_joininModel extends Model{

    public function __construct(){
        parent::__construct('store_joinin');
    }

    /**
     * 读取列表
     * @param array $condition
     *
     */
    public function getList($condition,$page='',$order='',$field='*'){
        $result = $this->table('store_joinin')->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
    }

    /**
     * 店铺入驻数量
     * @param unknown $condition
     */
    public function getStoreJoininCount($condition) {
        return  $this->where($condition)->count();
    }

    /**
     * 读取单条记录
     * @param array $condition
     *
     */
    public function getOne($condition){
        $result = $this->where($condition)->find();
        return $result;
    }

    /*
     *  判断是否存在
     *  @param array $condition
     *
     */
    public function isExist($condition) {
        $result = $this->getOne($condition);
        if(empty($result)) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    /*
     * 增加
     * @param array $param
     * @return bool
     */
    public function save($param){
        return $this->insert($param);
    }

    /*
     * 增加
     * @param array $param
     * @return bool
     */
    public function saveAll($param){
        return $this->insertAll($param);
    }

    /*
     * 更新
     * @param array $update
     * @param array $condition
     * @return bool
     */
    public function modify($update, $condition){
        return $this->where($condition)->update($update);
    }

    /*
     * 删除
     * @param array $condition
     * @return bool
     */
    public function drop($condition){
        return $this->where($condition)->delete();
    }

    /**
     * 编辑
     * @param array $condition
     * @param array $update
     * @return bool
     */
    public function editStoreJoinin($condition, $update) {
        return $this->where($condition)->update($update);
    }
    /**
     * 检查店铺入驻条件
     * @return bool
     */
    public function checkStoreJoin(){
        //入驻条件 绑定团队且上级团队用户为黑钻或至尊VIP
        $model_user_level = Model('user_level');
        $sql="select c.level from corporate_team_user a inner join member b on a.parent_user_id=b.member_id inner join user_level c on b.level_id = c.id where a.user_id=".$_SESSION['member_id'];
        $data = Model()->query($sql);
        if ($data['level']>=$model_user_level::LEVEL_FIVE){
            return true;
        }
        return false;

    }
}
