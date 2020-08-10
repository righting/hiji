<?php
/**
 * 会员模型
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class register_inviteModel extends Model {

    public function __construct(){
        parent::__construct('register_invite');
    }

    public function addRegisterInvite($param){
        if(empty($param)) {
            return false;
        }
        $data['from_user_id'] = $param['from_user_id'];
        $data['to_user_id'] = $param['to_user_id'];
        $data['depth'] = $param['depth'];
        $data['register_at'] = $param['register_at'];
        $insert = $this->insert($data);
        if($insert){
            return $insert;

        }
        return false;
    }
}
