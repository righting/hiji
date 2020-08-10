<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 14:59
 */
class jxControl extends BaseJxControl
{
    //每页显示商品数
    const PAGESIZE = 24;

    public function indexOp()
    {
        $model_web_config = Model('web_config');
        $index_html = $model_web_config->where(['web_id'=>622])->find();
        Tpl::output('index_html',$index_html);
        Tpl::output('webTitle',' - 精选尖货');
        Tpl::showpage('jx/index');
    }
}