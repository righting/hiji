<?php

namespace app\common\model;

use think\Exception;
use think\exception\PDOException;

/**
 * 用户令牌模型
 * Class AdminUserToken
 * @package app\common\model
 */
class AdminUserToken extends Base
{
    protected $table = 'fh_admin_user_token';

    /**
     * 创建令牌
     * @param int $uid 用户id
     * @return string
     */
    static public function createToken($uid = 0, $other_data = [])
    {
        $time  = time();
        $token = md5($uid . $time . rand(10000,99999));
        $data  = [
            'token'           => $token,
            'admin_user_id'   => $uid,
            'expiration_time' => $time + 86400,
            'status'          => 1,
            'create_time'     => $time,
            'other_data'      => $other_data ? json_encode($other_data) : '',
        ];
        self::create($data, true);
        return $token;
    }

    /**
     * 检查令牌
     * @param string $token 令牌
     * @return bool false:过期；否则返回用户信息
     * @throws Exception
     * @throws PDOException
     */
    static public function checkToken($token = '')
    {
        if (empty($token)) return false;
        $time = time();

        $expiration_time = self::where('token', $token)
            ->where('status', 1)
            ->value('expiration_time');

        // 过期
        if (empty($expiration_time) || $expiration_time < $time) {
            self::where('token', $token)->update(['status' => 0]);
            return false;
        }

        // 更新令牌有效期
        if ($expiration_time < time() + 3600) {
            self::where('token', $token)
                ->where('status', 1)
                ->update(['expiration_time' => time() + 7200]);
        }

        // 获取用户信息
        return self::get(['token' => $token]);
    }
}