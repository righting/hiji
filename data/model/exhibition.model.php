<?php
/**
 * 系统文章
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class exhibitionModel extends Model {
    protected $table = 'exhibition';
    public function __construct()
    {
        parent::__construct('exhibition');
    }
    /*
     * 查询所有系统文章
     */
    public function getList($where = []){
        $list = $this->table($this->table)->where($where)->select();
        return $list;
    }

    /*
     * 查询一条信息
     *
     * @param unknown_type $id
     */
    public function getOne($where){
        $info = $this->table($this->table)->where($where)->find();
        return $info;
    }
    /*
     * 根据标识码查询一条
     *
     * @param unknown_type $id
     */
    public function getOneByCode($code){
        $param  = array(
            'table' => 'document',
            'field' => 'doc_code',
            'value' => $code
        );
        return Db::getRow($param);
    }
    /*
     * 更新
     *
     * @param unknown_type $param
     */
    public function updates($where,$data){
        $result = $this->table($this->table)->where($where)->update($data);
        return $result;
    }
}
