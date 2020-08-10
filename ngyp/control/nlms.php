<?php
defined('ByCCYNet') or exit('Access Invalid!');

class nlmsControl extends BaseNgypControl
{


    public function indexOp()
    {
        //获取分类
        $cateModel    = Model('goods_class');
        $nlmsCateInfo = $cateModel->where(['gc_parent_id' => 5422])->select();
        if (!empty($nlmsCateInfo) && is_array($nlmsCateInfo)) {
            $this->getCategory($nlmsCateInfo);
        }

        $top_banner = $this->getBannerList(37);
        $wanle_w_ad = $this->getBannerList(40);
        $wanle_h_ad = $this->getBannerList(41);
        Tpl::output('top_banner', $top_banner);
        Tpl::output('wanle_w_ad', $wanle_w_ad);
        Tpl::output('wanle_h_ad', $wanle_h_ad);

        $ad_a = $this->getBannerList(76);
        Tpl::output('ad_a', $ad_a);

        Tpl::output('nlmsCateInfo', $nlmsCateInfo);
        Tpl::output('web_info', ['name' => '农旅民宿', 'type' => 5]);
        Tpl::showpage('nlms');
    }

    /**
     * 获取子类
     * @param $data
     */
    public function getCategory(&$data)
    {
        $cateModel = Model('goods_class');
        foreach ($data as $k => $v) {
            $data[$k]['info'] = $cateModel->where(['gc_parent_id' => $v['gc_id']])->select();
        }
    }

}
