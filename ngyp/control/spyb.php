<?php
defined('ByCCYNet') or exit('Access Invalid!');

class spybControl extends BaseNgypControl {


    public function indexOp(){

        $model = Model('goods');
        $field='goods_id,goods_name,goods_image,goods_price,goods_marketprice';

        //有机农产品
        $randGoods=$model->where(['gc_id'=>5530,'goods_state'=>1,'goods_verify'=>1])->field($field)->order(' rand() ')->limit(8)->select();
        //绿色食品
        $randGoods1=$model->where(['gc_id'=>5531,'goods_state'=>1,'goods_verify'=>1])->field($field)->order(' rand() ')->limit(8)->select();
        //无公害农产品
        $randGoods2=$model->where(['gc_id'=>5532,'goods_state'=>1,'goods_verify'=>1])->field($field)->order(' rand() ')->limit(8)->select();
        //地域农产品
        $randGoods3=$model->where(['gc_id'=>5533,'goods_state'=>1,'goods_verify'=>1])->field($field)->order(' rand() ')->limit(8)->select();

        Tpl::output('randGoods',$randGoods);
        Tpl::output('randGoods1',$randGoods1);
        Tpl::output('randGoods2',$randGoods2);
        Tpl::output('randGoods3',$randGoods3);

        $top_banner = $this->getBannerList(34);
        Tpl::output('top_banner', $top_banner);
        $ad_h = $this->getBannerList(42);
        Tpl::output('ad_h', $ad_h);
        $ad_a = $this->getBannerList(63);
        Tpl::output('ad_a', $ad_a);
        $ad_b = $this->getBannerList(64);
        Tpl::output('ad_b', $ad_b);
        $ad_c = $this->getBannerList(65);
        Tpl::output('ad_c', $ad_c);
        $ad_d = $this->getBannerList(66);
        Tpl::output('ad_d', $ad_d);
        $ad_e = $this->getBannerList(67);
        Tpl::output('ad_e', $ad_e);
        $ad_f = $this->getBannerList(68);
        Tpl::output('ad_f', $ad_f);
        $ad_g = $this->getBannerList(69);
        Tpl::output('ad_g', $ad_g);
        $ad_i = $this->getBannerList(77);
        Tpl::output('ad_i', $ad_i);

        Tpl::output('web_info',array('name'=>'三品一标','type'=>2));
        Tpl::showpage('spyb');
    }

}
