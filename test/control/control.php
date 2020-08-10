<?php
// +----------------------------------------------------------------------
// | 功能描述: 
// +----------------------------------------------------------------------
// | Author: Jimlin <lj.xia@163.com>
// +----------------------------------------------------------------------
// | Datetime: 2018/11/29 11:49
// +----------------------------------------------------------------------

class BaseController
{
    protected $member_model          = null;
    protected $store_decoration_only = false;
    protected $member_info           = [];   // 会员信息

    public function __construct()
    {
        $this->member_model = new memberModel();
        //输出会员信息
        //$this->member_info = $this->getMemberAndGradeInfo(true);
    }

    /**
     * 输出会员信息
     * @return array
     */
    protected function getMemberAndGradeInfo()
    {
        $member_info = [];
        //会员详情及会员级别处理
        if ($_SESSION['member_id']) {
            $member_info = $this->member_model->getMemberInfoByID($_SESSION['member_id'], 'member_id,member_name,member_email,level_id,positions_id,member_points,member_h_points');
            if ($member_info) {
                $member_gradeinfo              = $this->member_model->getOneMemberGrade(intval($member_info['member_exppoints']));
                $member_info                   = array_merge($member_info, $member_gradeinfo);
                $member_info['security_level'] = $this->member_model->getMemberSecurityLevel($member_info);
            }
        }
        return $member_info;
    }

    /**
     * 检查当前用户是否已经绑定了团队
     * @param int $user_id
     * @return bool
     */
    protected function checkBindTeam($user_id = 0)
    {
        $register_invite_model = new register_inviteModel();
        $user_id               = empty($user_id) ? $_SESSION['member_id'] : $user_id;
        $check_bind_info       = $register_invite_model->where(['to_user_id' => $user_id])->find();
        return !empty($check_bind_info) ? true : false;
    }

    /**
     * 绑定团队
     * @param int    $user_id
     * @param string $parent_team_id
     * @return bool
     * @throws Exception
     */
    protected function bindTeam($user_id = 0, $parent_team_id = '')
    {
        $user_id          = empty($user_id) ? $_SESSION['member_id'] : $user_id;
        $model_user_level = new user_levelModel();
        // 实名用户才允许绑定团队
        if (intval($_SESSION['isauth']) != 1) {
            exit('实名认证后才可绑定团队');
        }
        // 检查当前用户是否已经绑定了团队
        $check_bind_info = $this->checkBindTeam($user_id);
        if ($check_bind_info) {
            exit('您已经绑定了其他团队，需要换绑请联系客服！');
        }
        // 获取要绑定的团队信息
        $parent_user_info = $this->member_model->where(['member_number' => $parent_team_id, 'member_id' => ['neq', $user_id]])->field('member_id,member_name,member_avatar,member_state,level_id')->find();
        if (empty($parent_user_info)) {
            exit('团队不存在，请确认后再试！');
        }
        if ($parent_user_info['level_id'] == 7) {
            exit('您的邀请人当前会员等级不支持邀请团队！');
        }
        // 将当前用户绑定至团队
        $register_invite_model                = new register_inviteModel();
        $register_invite_data['from_user_id'] = $parent_user_info['member_id'];
        $register_invite_data['to_user_id']   = $user_id;
        $register_invite_data['register_at']  = date('Y-m-d H:i:s');
        $invite                               = $register_invite_model->where(['to_user_id' => $parent_user_info['member_id']])->find();
        $register_invite_data['depth']        = intval($invite['depth']) + 1;
        $bind_result                          = $register_invite_model->addRegisterInvite($register_invite_data);
        if ($bind_result) {
            $this->member_model->memberUpgrade($user_id, $model_user_level::LEVEL_ONE);//升级会员等级
            return true;
        } else {
            // 如果不是，则提示不能换绑，『后期需要改成可换绑时，可改为修改（team_name、pid、parent_user_id、team_id）』
            return false;
        }
    }

    /**
     * 单个商品信息页
     * @param int $goods_id
     * @return array
     */
    protected function getGoodsDetail($goods_id = 0)
    {
        // 商品详细信息
        $model_goods  = new goodsModel();
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
        $goods_info   = $goods_detail['goods_info'];
        if (empty($goods_info)) {
            exit('商品已下架或不存在');
        }

        // 生成缓存的键值
        $hash_key = $goods_info['goods_id'];
        $_cache   = rcache($hash_key, 'product');

        $goods_info = array_merge($goods_info, $_cache);

        // 如果使用运费模板
        if ($goods_info['transport_id'] > 0) {
            // 取得三种运送方式默认运费
            $model_transport = new transportModel();
            $transport       = $model_transport->getExtendList(['transport_id' => $goods_info['transport_id']]);
            if (!empty($transport) && is_array($transport)) {
                foreach ($transport as $v) {
                    $goods_info[$v['type'] . "_price"] = $v['sprice'];
                }
            }
        }
        return $goods_info;
    }

    /**
     * 实物商品 购物车、直接购买第一步:选择收获地址和配送方式
     * @param array $post
     */
    protected function buy_step1(array $post = [])
    {
        //得到购买数据
        $logic_buy = new buyLogic();;
        $result = $logic_buy->buyStep1($post['cart_id'], $post['ifcart'], $_SESSION['member_id'], $_SESSION['seller_session_info']['store_id'], $post['jjg'], $this->member_info['orderdiscount'], $this->member_info['level'], $post['ifchain']);
        dump($result);
        if (!$result['state']) {
            exit($result['msg']);
        } else {
            $result = $result['data'];
        }
        // 检查当前用户是否存在需要补单的订单，如果有，那么就要询问用户当前订单是否为补单订单，选择是之后需要检查当前订单与补单订单之间的利润
        $refund_return_model                 = new refund_returnModel();
        $refund_return_where['buyer_id']     = $_SESSION['member_id'];
        $refund_return_where['refund_state'] = 4;
        $refund_return_list                  = $refund_return_model->where($refund_return_where)->select();
        Tpl::output('refund_return_list', $refund_return_list);

        //print_r($refund_return_list);die;

        // 检查当前用户是否已经绑定了团队
        $register_invite_model = new register_inviteModel();
        $user_id               = $_SESSION['member_id'];
        $check_bind_info       = $register_invite_model->where(['to_user_id' => $user_id])->find();
        if (empty($check_bind_info)) {
            $result['Hs']['is_bind'] = 0;
        } else {
            $result['Hs']['is_bind'] = 1;
        }


        //将商品ID、数量、运费模板、运费序列化，加密，输出到模板，选择地区AJAX计算运费时作为参数使用
        Tpl::output('freight_hash', $result['freight_list']);

        //输出用户默认收货地址
        if (!$post['ifchain']) {
            Tpl::output('address_info', $result['address_info']);
        }

        //输出有货到付款时，在线支付和货到付款及每种支付下商品数量和详细列表
        Tpl::output('pay_goods_list', $result['pay_goods_list']);
        Tpl::output('ifshow_offpay', $result['ifshow_offpay']);
        Tpl::output('deny_edit_payment', $result['deny_edit_payment']);

        //输出是否有门店自提支付
        Tpl::output('ifshow_chainpay', $result['ifshow_chainpay']);
        Tpl::output('chain_store_id', $result['chain_store_id']);

        //不提供增值税发票时抛出true(模板使用)
        //Tpl::output('vat_deny', $result['vat_deny']);

        //增值税发票哈希值(php验证使用)
        //Tpl::output('vat_hash', $result['vat_hash']);

        //输出默认使用的发票信息
        //Tpl::output('inv_info', $result['inv_info']);

        //删除购物车无效商品
        $logic_buy->delCart($post['ifcart'], $_SESSION['member_id'], $post['invalid_cart']);

        //标识购买流程执行步骤
        Tpl::output('buy_step', 'step2');

        Tpl::output('ifcart', $post['ifcart']);

        Tpl::output('ifchain', $post['ifchain']);

        //输出会员折扣
        Tpl::output('zk_list', $result['zk_list']);

        //店铺信息
        $store_model = new storeModel();
        $store_list  = $store_model->getStoreMemberIDList(array_keys($result['store_cart_list']), 'store_id,member_id,store_domain,is_own_shop');
        Tpl::output('store_list', $store_list);

        $current_goods_info = current($result['store_cart_list']);
        Tpl::output('current_goods_info', $current_goods_info[0]);

        // 推广邀请码
        $referral_key = $result['referral_key'];
        Tpl::output('referral_key', $referral_key);
        //Tpl::showpage('buy_step1');
    }

    /**
     * 创建订单
     * @param int $goodsId
     * @param int $addressId
     * @param int $number
     */
    protected function createOrdersOp($goodsId = 0, $addressId = 0, $number = 1)
    {
        $rs = ['status' => -1, 'data' => '', 'msg' => '系统错误'];
        try {
            $userId = $_SESSION['member_id'];

            if (empty($userId)) {
                throw new Exception('请先登录');
            }
            if (empty($goodsId) || !isset($goodsId)) {
                throw new Exception('参数异常：ER20000');
            }
            if (empty($addressId)) {
                throw new Exception('请选择收货信息');
            }

            //获取积分商品信息
            $goodsModel = new jfgoodsModel();
            $goodsInfo  = $goodsModel->where(['goods_id' => $goodsId])->find();
            if (empty($goodsInfo) || !is_array($goodsInfo)) {
                throw new Exception('参数异常：ER20001');
            }

            //查询用户积分是否足够


            //获取收货地址信息
            $addressModel = new addressModel();
            $addressInfo  = $addressModel->where(['member_id' => $userId, 'address_id' => $addressId])->find();
            if (empty($addressInfo) || !is_array($addressInfo)) {
                throw new Exception('请选择收货信息');
            }


            //生成订单
            $orderModel                  = Model('integral_orders');
            $orderArray['orderNo']       = rand(100, 999) . time() . rand(100, 999);
            $orderArray['userId']        = $userId;
            $orderArray['address_name']  = $addressInfo['true_name'];
            $orderArray['address']       = $addressInfo['area_info'] . ' ' . $addressInfo['address'];
            $orderArray['address_phone'] = $addressInfo['mob_phone'];
            $orderArray['order_money']   = $goodsInfo['goods_price'] * $number;
            $orderArray['order_point']   = $goodsInfo['goods_integral'] * $number;
            $orderArray['order_hjb']     = $goodsInfo['goods_hjb'] * $number;
            $orderArray['create_time']   = date('Y-m-d H:i:s');

            $getOrderId = $orderModel->insert($orderArray);
            if ($getOrderId) {
                //向快照表插入数据
                $orderGoodsModel                = Model('integral_order_goods');
                $orderGoodsArray['orderId']     = $getOrderId;
                $orderGoodsArray['userId']      = $userId;
                $orderGoodsArray['goodsId']     = $goodsInfo['goods_id'];
                $orderGoodsArray['goods_name']  = $goodsInfo['goods_name'];
                $orderGoodsArray['goods_image'] = $goodsInfo['goods_image'];
                $orderGoodsArray['goods_price'] = $goodsInfo['goods_price'];
                $orderGoodsArray['goods_point'] = $goodsInfo['goods_integral'];
                $orderGoodsArray['goods_hjb']   = $goodsInfo['goods_hjb'];
                $orderGoodsArray['number']      = $number;
                $orderGoodsArray['create_time'] = date('Y-m-d H:i:s');
                $insertOrderGoodsInfo           = $orderGoodsModel->insert($orderGoodsArray);
                if ($insertOrderGoodsInfo) {
                    //返回订单信息
                    $data         = ['orderId' => $getOrderId, 'orderNo' => $orderArray['orderNo']];
                    $rs['status'] = 1;
                    $rs['data']   = $data;
                    $rs['msg']    = '生成订单成功';
                } else {
                    throw new Exception('参数异常：ER20002');
                }
            }
        } catch (Exception $e) {
            $rs['msg'] = $e->getMessage();
        }

        echo json_encode($rs);
    }
}