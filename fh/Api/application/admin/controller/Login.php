<?php
namespace app\admin\controller;

use util\captcha\Captcha;
use app\common\model\AdminUser;
use \think\Request;

class Login
{

    /**
     * 列表
     * @throws DbException
     */
    public function index(Captcha $captcha)
    {
        $param = Request::instance()->param();
        if (empty($param['verify_code']) || empty($param['verify_code_id'])) {
            error('验证码不能为空');
        }
         if (empty($param['username']) || empty($param['password'])) {
            error('用户名/密码不能为空');
        }

        //$captcha_result = $captcha->check($param['verify_code'], $param['verify_code_id']);
        //false === $captcha_result && error('验证码错误');

        try {
            $result = AdminUser::login($param);
        } catch (Exception $e) {
            $result = [];
            error($e->getMessage());
        }

        success($result);
    }
}