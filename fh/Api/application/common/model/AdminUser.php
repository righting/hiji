<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2020/1/13 17:24
// +----------------------------------------------------------------------

namespace app\common\model;

use Exception;
use think\model\concern\SoftDelete;

/**
 * 管理员模型
 * Class AdminUser
 * @package app\common\model
 */
class AdminUser extends Base
{
    protected $table = 'fh_admin_user';

    /**
     * 登录
     * @param array $param
     * @return array
     * @throws Exception
     */
    static public function login(array $param = [])
    {
        $result = self::get(['username' => $param['username']]);

        if (!$result) {
            !$result && exception('用户不存在');
        }
        if (md5($param['password']) != $result->password) {
            exception('密码错误');
        }
        if ((int)$result->status !== 1) {
            exception('用户被停用');
        }

        $data      = ['username' => $result->username, 'realname' => $result->realname, 'phone' => $result->phone];
        $token = AdminUserToken::createToken($result->id, $data);

        return ['token' => $token, 'info' => array_merge(['id' => $result->id], $data)];
    }
}