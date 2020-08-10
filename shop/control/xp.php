<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 14:59
 */
class xpControl extends BaseXpControl
{
    //每页显示商品数
    const PAGESIZE = 24;

    public function indexOp()
    {
        $model_web_config = Model('web_config');
        $index_html = $model_web_config->where(['web_id'=>623])->find();
        Tpl::output('index_html',$index_html);
        Tpl::showpage('xp/index');
    }
}