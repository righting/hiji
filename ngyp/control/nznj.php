<?php
defined('ByCCYNet') or exit('Access Invalid!');

class nznjControl extends BaseNgypControl
{


    public function indexOp()
    {
        //获取农资农具分类
        $goodsClassModel = Model('goods_class');
        $category        = $goodsClassModel->where(['gc_parent_id' => 5509])->select();

        $gcIdArray = array_column($category, 'gc_id');

        if (!empty($gcIdArray) && is_array($gcIdArray)) {
            $goodsModel            = Model('goods');
            $where['goods_state']  = 1;
            $where['goods_verify'] = 1;
            //获取1F商品
            $where['gc_id'] = ['in', $gcIdArray[0] . ',' . $gcIdArray[1] . ',' . $gcIdArray[2]];
            $oneGoodsInfo   = $goodsModel->where($where)->limit(8)->select();

            //获取2F商品
            $where['gc_id'] = ['in', $gcIdArray[3] . ',' . $gcIdArray[4] . ',' . $gcIdArray[5]];
            $twoGoodsInfo   = $goodsModel->where($where)->limit(8)->select();

            //获取3F商品
            $where['gc_id'] = ['in', $gcIdArray[6] . ',' . $gcIdArray[7] . ',' . $gcIdArray[8] . ',' . $gcIdArray[9]];
            $threeGoodsInfo = $goodsModel->where($where)->limit(8)->select();


            Tpl::output('oneGoodsInfo', $oneGoodsInfo);
            Tpl::output('twoGoodsInfo', $twoGoodsInfo);
            Tpl::output('threeGoodsInfo', $threeGoodsInfo);
        }

        $top_banner = $this->getBannerList(36);
        Tpl::output('top_banner', $top_banner);

        $ad_a = $this->getBannerList(71);
        Tpl::output('ad_a', $ad_a);
        $ad_b = $this->getBannerList(72);
        Tpl::output('ad_b', $ad_b);
        $ad_c = $this->getBannerList(73);
        Tpl::output('ad_c', $ad_c);
        $ad_d = $this->getBannerList(74);
        Tpl::output('ad_d', $ad_d);
        $ad_e = $this->getBannerList(75);
        Tpl::output('ad_e', $ad_e);

        Tpl::output('category', $category);
        Tpl::output('web_info', ['name' => '农资农具', 'type' => 4]);
        Tpl::showpage('nznj');
    }

}
