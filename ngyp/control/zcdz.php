<?php
defined('ByCCYNet') or exit('Access Invalid!');

class zcdzControl extends BaseNgypControl
{


    public function indexOp()
    {
        $top_banner = $this->getBannerList(35);
        Tpl::output('top_banner', $top_banner);
        $ad_a = $this->getBannerList(70);
        Tpl::output('ad_a', $ad_a);
        Tpl::output('web_info', ['name' => '众筹定制', 'type' => 3]);
        Tpl::showpage('zcdz');
    }

}
