<?php
defined('ByCCYNet') or exit('Access Invalid!');

class xffpControl extends BaseNgypControl
{

    public function indexOp()
    {
        $top_banner = $this->getBannerList(38);
        $adv_a = $this->getBannerList(83);
        $adv_b = $this->getBannerList(84);
        $adv_c = $this->getBannerList(85);
        $adv_d = $this->getBannerList(86);
        Tpl::output('top_banner', $top_banner);
        Tpl::output('adv_a', $adv_a);
        Tpl::output('adv_b', $adv_b);
        Tpl::output('adv_c', $adv_c);
        Tpl::output('adv_d', $adv_d);
        Tpl::output('web_info', ['name' => '消费扶贫', 'type' => 6]);
        Tpl::showpage('xffp');
    }

}
