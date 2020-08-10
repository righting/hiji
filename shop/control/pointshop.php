<?php
/**
 * 积分中心
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */


defined('ByCCYNet') or exit('Access Invalid!');

class pointshopControl extends BasePointShopControl
{
    public function __construct()
    {
        parent::__construct();
        //读取语言包
        Language::read('home_pointprod,home_voucher');
    }

    public function indexOp()
    {
        //查询会员及其附属信息
        parent::pointshopMInfo();

        //开启代金券功能后查询推荐的热门代金券列表
        if (C('voucher_allow') == 1) {
            $recommend_voucher = Model('voucher')->getRecommendTemplate(6);
            Tpl::output('recommend_voucher', $recommend_voucher);
        }
        //开启积分兑换功能后查询推荐的热门兑换商品列表
        if (C('pointprod_isuse') == 1) {
            //热门积分兑换商品
            $recommend_pointsprod = Model('pointprod')->getRecommendPointProd(10);
            Tpl::output('recommend_pointsprod', $recommend_pointsprod);
        }
        //开启平台红包功能后查询推荐的红包列表
        if (C('redpacket_allow') == 1) {
            $recommend_rpt = Model('redpacket')->getRecommendRpt(10);
            Tpl::output('recommend_rpt', $recommend_rpt);
        }

        //SEO
        Model('seo')->type('point')->show();
        //分类导航
        $nav_link = [
            0 => ['title' => L('homepage'), 'link' => SHOP_SITE_URL],
            1 => ['title' => L('nc_pointprod')]
        ];
        Tpl::output('nav_link_list', $nav_link);
        Tpl::output('index_sign', '26');
        Tpl::showpage('pointprod');
    }

    /**
     * 积分兑换会员等级
     */
    public function buy_gradeOp()
    {

        if (chksubmit()) {
            Model::beginTransaction();
            try {
                $grade            = $_POST['grade'];
                $member_info      = parent::pointshopMInfo(true)['member_info'];
                $model_user_level = Model('user_level');
                $res              = $model_user_level->FindLevelInfo(['level' => $grade]);//获取等级信息
                $user_old_level   = $model_user_level->FindLevelInfo(['id' => $member_info['level_id']]);//获取会员当前等级信息
                //验证会员能否兑换等级
                $model_pointcart = Model('pointcart');
                $data            = $model_pointcart->checkPointEnough($res['point'], $_SESSION['member_id']);
                if (!$data['state']) {
                    showDialog($data['msg'], 'reload', 'error');
                }
                unset($data);
                //扣除会员积分
                $insert_arr                  = [];
                $insert_arr['pl_memberid']   = $member_info['member_id'];
                $insert_arr['pl_membername'] = $member_info['member_name'];
                $insert_arr['pl_points']     = -$res['point'];
                $insert_arr['grade_name']    = '[' . $res['level_name'] . ']';
                $res                         = Model('points')->savePointsLog('pointmember', $insert_arr, true);
                if (!$res) {
                    throw new Exception("积分操作失败");
                }
                $res = Model('member')->memberUpgrade($member_info['member_id'], $grade, $res['point']);//升级会员等级
                if (!$res) {
                    throw new Exception("会员升级失败");
                }
                Model::commit();
            } catch (Exception $e) {
                Db::rollback();
                showDialog($e->getMessage(), 'reload', 'error');
            }

            showDialog('恭喜,兑换会员成功', 'reload', 'succ');
        }

        //查询会员及其附属信息
        parent::pointshopMInfo();
        $member_info = parent::pointshopMInfo(true)['member_info'];

        //获取全部会员等级
        $member_grade = Model('user_level')->order('id desc')->getLevelAll();
        foreach ($member_grade as $key => &$val) {
            if ($val['level'] <= 1) {
                unset($member_grade[$key]);//免费会员不能兑换，只能绑定团队升级
            }
            if ($val['point'] <= $member_info['member_points'] && $val['level'] > $member_info['level']) {
                if (($member_info['level'] + 1) == $val['level']) {
                    $val['canbuy'] = true;
                } else {
                    $val['canbuy'] = false;
                }
            } else {
                $val['canbuy'] = false;
            }
            $val['now_level'] = $member_info['level'];
        }

        unset($val);

        Tpl::output('member_grade', $member_grade);

        //分类导航
        $nav_link = [
            0 => ['title' => L('homepage'), 'link' => SHOP_SITE_URL],
            1 => ['title' => L('nc_pointprod'), 'link' => urlShop('pointshop', 'index')],
            2 => ['title' => '会员进阶']
        ];
        Tpl::output('nav_link_list', $nav_link);
        Tpl::output('index_sign', '26');
        Tpl::showpage('point_buy_grade');
    }
}
