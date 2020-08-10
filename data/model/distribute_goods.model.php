<?php
/**
 * 个人分销店铺模型
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class distribute_goodsModel extends Model {

    const GOODS_MAX = 30;//个人分销商品最大数
    public function __construct() {
        parent::__construct('distribute_goods');
    }

    /**新增一个分销商品
     * @param $data
     */
    public function addGoods($data){
        $arrs=array('status'=>true,'msg'=>'新增成功');//返回结果
        if (empty($data)){
            $arrs['status']=false;
            $arrs['msg']='数据错误';
        }else if ($this->getGoodsTotalByUserID($data['user_id'])>=self::GOODS_MAX){
            $arrs['status']=false;
            $arrs['msg']='个人最多只能推广【'.self::GOODS_MAX.'】个商品';
        }else if(!empty($this->getGoodsByOne(['goods_id'=>$data['goods_id'],'user_id'=>$data['user_id']]))){
            $arrs['status']=false;
            $arrs['msg']='你已经推广过此商品';
        } else{
            $res = $this->insert($data);
            if ($res == false){
                $arrs['status']=false;
                $arrs['msg']='数据新增失败，请重试';
            }
        }
        return $arrs ;
    }

    /**获取用户分销商品详情
     * @param $user_id
     * @return bool
     */
    public  function  getGoodsByUserID($user_id){
        if (empty($user_id))
            return false;
        $field = 'goods.goods_name,goods.store_name,goods.goods_image,goods.goods_price,goods.goods_jingle,distribute_goods.*';
        $on = 'goods.goods_id=distribute_goods.goods_id';
        $this->table('goods,distribute_goods')->field($field);
        return $this->join('inner')->on($on)->where(array('distribute_goods.user_id'=>$user_id))->select();
    }
    /**
     * 获取个人分销商品总数
     */
    public function getGoodsTotalByUserID($user_id){
        if (empty($user_id))
            return false;
        return $this->table('distribute_goods')->where(['user_id'=>$user_id])->count();
    }

    /**获取一个分销商品
     * @param $goods_id
     * @return mixed
     */
    public function getGoodsByOne($condition){
        return $this->where($condition)->find();
    }
    /**删除一个分销商品
     * @param $goods_id
     * @return bool
     */
    public function delGoods($condition){
        if (empty($condition))
            return false;
        return $this->where($condition)->delete();
    }
}