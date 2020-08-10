<?php
defined('ByCCYNet') or exit('Access Invalid!');

class indexControl extends BaseHjbControl
{

    /**
     * 积分首页
     */
    public function indexOp()
    {
        $goodsModel             = Model('jfgoods');
        $where['goods_storage'] = ['gt', 0];
        $where['goods_verify']  = ['eq', 1];
        $where['goods_hjb']     = ['gt', 0];
        //获取销量最高的5个
        $salesInfo = $goodsModel->where($where)->order('goods_salenum desc,goods_id desc')->limit(5)->select();

        //F2 随机获取6条商品数据
        $randGoods = $goodsModel->where($where)->order(' rand() ')->limit(6)->select();

        //F3 随机获取3条商品数据
        $randGoodsThree = $goodsModel->where($where)->order(' rand() ')->limit(3)->select();

        //F4 随机获取6条商品数据
        $randGoodsSix = $goodsModel->where($where)->order(' rand() ')->limit(6)->select();


        //获取只需要海吉币兑换的商品
        $where['goods_price']    = 0;
        $where['goods_integral'] = 0;
        $hjbExChange             = $goodsModel->where($where)->order('goods_integral asc')->limit(4)->select();

        $top_banner = $this->getBannerList(45);
        $one_f_left_ad = $this->getBannerList(47);
        $three_f_right_ad = $this->getBannerList(48);

        $one_f_bg_ad = $this->getBannerList(49);
        $two_f_bg_ad = $this->getBannerList(50);
        $three_f_bg_ad = $this->getBannerList(51);
        $four_f_bg_ad = $this->getBannerList(52);

        Tpl::output('top_banner', $top_banner);
        Tpl::output('one_f_left_ad', $one_f_left_ad);
        Tpl::output('three_f_right_ad', $three_f_right_ad);

        Tpl::output('one_f_bg_ad', $one_f_bg_ad);
        Tpl::output('two_f_bg_ad', $two_f_bg_ad);
        Tpl::output('three_f_bg_ad', $three_f_bg_ad);
        Tpl::output('four_f_bg_ad', $four_f_bg_ad);

        Tpl::output('salesInfo', $salesInfo);
        Tpl::output('hjbExChange', $hjbExChange);
        Tpl::output('randGoods', $randGoods);
        Tpl::output('randGoodsThree', $randGoodsThree);
        Tpl::output('randGoodsSix', $randGoodsSix);
        Tpl::output('webTitle', ' - 消费资本-海吉币');
        Tpl::output('current_type', 2);
        Tpl::showpage('index');
    }

    /**
     * 攻略
     */
    public function strategyOp()
    {
        $top_banner = $this->getBannerList(46);
        Tpl::output('top_banner', $top_banner);

        Tpl::output('current_type', 8);
        Tpl::output('webTitle', ' - 海吉币攻略');
        Tpl::showpage('strategy');
    }

    /**
     * 我能兑换
     */
    public function myCanExchangeOp()
    {

        $goodsModel = Model('jfgoods');
        $userModel  = Model('member');
        $userId     = $_SESSION['member_id'];
        //判断是否登录
        if (!empty($userId)) {
            //获取用户海吉币
            $userInfo = $userModel->where(['member_id' => $userId])->field('member_id,sign_in_money')->find();

            //获取我能兑换的商品
            $where['goods_storage']  = ['gt', 0];
            $where['goods_verify']   = ['eq', 1];
            $where['goods_integral'] = ['eq', 0];
            $where['goods_hjb']      = ['elt', $userInfo['sign_in_money']];
            $info                    = $goodsModel->where($where)->order('goods_salenum desc,goods_id desc')->select();
            Tpl::output('info', $info);
            Tpl::output('current_type', 9);
            Tpl::output('webTitle', ' - 海吉币-我能兑换');
            Tpl::showpage('myCanExchange');


        } else {
            redirect('/member/index.php?controller=login&action=index');
        }
    }

}
