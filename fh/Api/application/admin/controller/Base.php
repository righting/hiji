<?php

namespace app\admin\controller;

use \think\Request;
use app\common\model\AdminUserToken;

class Base extends \app\common\controller\Base
{
    /**
     * 当前访问客户端
     * @var string
     */
    protected $client;

    /**
     * 令牌
     * @var string
     */
    protected $token;

    /**
     * 初始化基础控制器
     */
    public function __construct()
    {
        parent::__construct();

        if (empty($this->param['token'])) {
            error('令牌必须');
        }
        $rs = AdminUserToken::checkToken($this->param['token']);
        if (!$rs) {
            error('令牌无效');
        }

        $this->uid = $rs->admin_user_id;

        //$user = $this->systemLogin();
        //$this->uid = $user['id'];
    }

    /**
     * 系统后台登录验证
     *
     * @param
     * @return array 数组类型的返回结果
     */
    protected final function systemLogin() {
        define('MD5_KEY', 'e2f89a47879059059593b6ddf97e7780');
        define('COOKIE_PRE', '1894_');
        $cookie = '_YT77TS2PRC-RavTBof9MnKAQxWogCr3fMXH-Kjm7RQ3nedLnbOnH-Kjm4RQ3veH6tP4n08SG3LRb5ToCs7sQsJGSoRl6ARYys7oD48zW7Pxu_RYOUB8L96TmodFuoT8-s_YP92TC6ORy7Ru3qk_ILx6DK3LRb5To-s7rcsHyGBfhW3Tn6i7os28TSALUL0dbnX7os28TC7RQ5uytJZhveqZaFtn2JrpeSUB8L96TmofluoT8-s_Ynl6CGBfhW7Tn7jOLkxIiGBfhW3Tn6j7osA';
        //取得cookie内容，解密，和系统匹配
        //$user = unserialize(decrypt(cms_cookie('sys_key'),MD5_KEY));
        $user = @unserialize(decrypt($cookie,MD5_KEY));
        if (!key_exists('gid',(array)$user) || !isset($user['sp']) || (empty($user['name']) || empty($user['id']))){
            error('请先登录', 201);
        }
        return $user;
    }
}