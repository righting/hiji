<?php

header("access-control-allow-origin:*");
defined('ByCCYNet') or exit('Access Invalid!');

class indexControl extends BaseNgypControl
{


    public function indexOp()
    {
        $model             = Model('goods');
        $goods_class_model = Model('goods_class');
        $field             = 'goods_id,goods_name,goods_image,goods_price,goods_marketprice';

        //随机获取商品
        $randGoods  = $model->where(['gc_id_1' => $goods_class_model::NG_CATEGORY_TYPE, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order(' rand() ')->limit(8)->select();

        //获取热卖商品
        $fieryGoods = $model->where(['gc_id_1' => $goods_class_model::NG_CATEGORY_TYPE, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_salenum desc,goods_id asc')->limit(6)->select();

        //获取新品上架
        $newGoods = $model->where(['gc_id_1' => $goods_class_model::NG_CATEGORY_TYPE, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_addtime desc')->limit(6)->select();

        $centerGoods = $model->where(['gc_id_1' => $goods_class_model::NG_CATEGORY_TYPE, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(9)->select();

        // 有机食品
        $organic_food_recommend = $model->where(['gc_id' => 5512, 'goods_state' => 1, 'goods_verify' => 1, 'is_select' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//推荐
        $organic_food_dami = $model->where(['gc_id' => 5514, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机大米
        $organic_food_zaliang = $model->where(['gc_id' => 5515, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机杂粮

        // 地道特产
        $techan_recommend = $model->where(['gc_id' => 5516, 'goods_state' => 1, 'goods_verify' => 1, 'is_select' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//推荐
        $techan_dami = $model->where(['gc_id' => 5519, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机大米
        $techan_zaliang = $model->where(['gc_id' => 5520, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机杂粮

        // 季节优品
        $jijie_recommend = $model->where(['gc_id' => 5517, 'goods_state' => 1, 'goods_verify' => 1, 'is_select' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//推荐
        $jijie_dami = $model->where(['gc_id' => 5521, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机大米
        $jijie_zaliang = $model->where(['gc_id' => 5522, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机杂粮

        // 人气热卖
        $hot_sale_recommend = $model->where(['gc_id' => 5518, 'goods_state' => 1, 'goods_verify' => 1, 'is_select' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//推荐
        $hot_sale_dami = $model->where(['gc_id' => 5523, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机大米
        $hot_sale_zaliang = $model->where(['gc_id' => 5524, 'goods_state' => 1, 'goods_verify' => 1])->field($field)->order('goods_id desc')->limit(6)->select();//有机杂粮

        Tpl::output('randGoods', $randGoods);
        Tpl::output('fieryGoods', $fieryGoods);
        Tpl::output('newGoods', $newGoods);
        Tpl::output('centerGoods', $centerGoods);
        // 有机食品
        Tpl::output('organic_food_recommend', $organic_food_recommend);
        Tpl::output('organic_food_dami', $organic_food_dami);
        Tpl::output('organic_food_zaliang', $organic_food_zaliang);
        // 地道特产
        Tpl::output('techan_recommend', $techan_recommend);
        Tpl::output('techan_dami', $techan_dami);
        Tpl::output('techan_zaliang', $techan_zaliang);
        // 季节优品
        Tpl::output('jijie_recommend', $jijie_recommend);
        Tpl::output('jijie_dami', $jijie_dami);
        Tpl::output('jijie_zaliang', $jijie_zaliang);
        // 人气热卖
        Tpl::output('hot_sale_recommend', $hot_sale_recommend);
        Tpl::output('hot_sale_dami', $hot_sale_dami);
        Tpl::output('hot_sale_zaliang', $hot_sale_zaliang);


        $top_banner = $this->getBannerList(33);
        Tpl::output('top_banner', $top_banner);
        $ad_a = $this->getBannerList(53);
        Tpl::output('ad_a', $ad_a);
        $ad_b = $this->getBannerList(54);
        Tpl::output('ad_b', $ad_b);
        $ad_c = $this->getBannerList(55);
        Tpl::output('ad_c', $ad_c);
        $ad_d = $this->getBannerList(56);
        Tpl::output('ad_d', $ad_d);
        $ad_e = $this->getBannerList(57);
        Tpl::output('ad_e', $ad_e);
        $ad_f = $this->getBannerList(58);
        Tpl::output('ad_f', $ad_f);
        $ad_g = $this->getBannerList(59);
        Tpl::output('ad_g', $ad_g);
        $ad_h = $this->getBannerList(60);
        Tpl::output('ad_h', $ad_h);
        $ad_i = $this->getBannerList(61);
        Tpl::output('ad_i', $ad_i);
        $ad_j = $this->getBannerList(62);
        Tpl::output('ad_j', $ad_j);

        Tpl::output('web_info', ['name' => '首页', 'type' => 1]);
        Tpl::showpage('index');
    }

    public function indexajaxOp()
    {
        $condition = [];
        if ($_GET['type'] == 1 || $_GET['type'] == 2) {
            $condition['video_type'] = $_GET['type'];
        }
        $page_model = Model('video');
        $page       = $page_model->getVideoList($condition);
        foreach ($page as $k => $v) {
            $page[$k]['video_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $v['video_url'];
            $page[$k]['video_img'] = 'http://' . $_SERVER['HTTP_HOST'] . UPLOAD_SITE_URL . '/' . ATTACH_PATH . $v['video_img'];
        }
        echo json_encode(['stata' => 0, 'msg' => $page]);
    }

}
