<?php
defined('ByCCYNet') or exit('Access Invalid!');

class ncgyControl extends BaseNgypControl
{


    public function indexOp()
    {
        $top_banner = $this->getBannerList(39);
        $mid_ad     = $this->getBannerList(43);

        Tpl::output('top_banner', $top_banner);
        Tpl::output('mid_ad', $mid_ad);

        Tpl::output('web_info', ['name' => '农村公益', 'type' => 7]);
        Tpl::showpage('ncgy');
    }

}
