<?php

namespace app\admin\controller;

use util\captcha\Captcha;

class Pub
{

    /**
     * 验证码生成
     * @param Captcha $captcha 验证码类
     */
    public function verify(Captcha $captcha)
    {
        success($captcha->entry());
    }
}