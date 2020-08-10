<?php
defined('ByCCYNet') or exit('Access Invalid!');

class goodsControl extends BaseJfControl
{

    /**
     * 商品详情
     */
    public function indexOp()
    {
        $goodsModel = Model('goods');
        $model      = Model('jfgoods');
        $goodsId    = intval($_GET['id']);
        // 商品详细信息
        $info = $model->where(['goods_id' => $goodsId])->find();


        //获取销量最高的5个
        $salenumInfo = $model->order('goods_salenum desc,goods_id desc')->limit(5)->select();

        //随机获取5件商品
        $randInfo = $model->order(' rand() ')->limit(5)->select();

        $goodsImage[] = $info['goods_image'];

        Tpl::output('goods_image', $goodsImage);
        Tpl::output('goods', $info);
        Tpl::output('salenumInfo', $salenumInfo);
        Tpl::output('randInfo', $randInfo);

        Tpl::output('webTitle', $info['goods_name'] . ' - 海吉壹佰-积分商城');
        Tpl::showpage('goods_details');
    }


    /**
     * 确认商品信息
     */
    public function confirmGoodsInfoOp()
    {
        $userId  = $_SESSION['member_id'];
        $goodsId = isset($_POST['goodsId']) ? intval($_POST['goodsId']) : '';
        $number  = isset($_POST['number']) ? intval($_POST['number']) : 1;
        //获取用户收货地址
        $addressModel = Model('address');
        $addressInfo  = $addressModel->where(['member_id' => $userId])->order('is_default desc')->select();

        //获取商品详细信息
        $goodsModel = Model('jfgoods');
        $goodsInfo  = $goodsModel->where(['goods_id' => $goodsId])->find();


        //获取地区表顶级数据
        $areaModel = Model('area');
        $areaInfo  = $areaModel->where(['area_parent_id' => 0])->select();

        Tpl::output('areaInfo', $areaInfo);
        Tpl::output('goodsInfo', $goodsInfo);
        Tpl::output('goodsId', $goodsId);
        Tpl::output('number', $number);
        Tpl::output('address_info', $addressInfo);
        Tpl::output('webTitle', '海吉壹佰 - 确认订单');
        Tpl::showpage('confirm_goods_info');
    }


    /**
     * 检测商品库存
     */
    public function checkStockOp()
    {
        $rs           = ['status' => 1];
        $number       = intval($_GET['number']);
        $goodsId      = intval($_GET['id']);
        $model        = Model('jfgoods');
        $goodsStorage = $model->where(['goods_id' => $goodsId])->field('goods_storage')->find();
        if ($goodsStorage['goods_storage'] < $number) {
            $rs['status'] = -1;
        }
        echo json_encode($rs);
    }

    /**
     * 获取地区
     */
    public function getAreaInfoOp()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        if (empty($id)) {
            echo json_encode([]);
            die;
        }
        $areaModel = Model('area');
        $areaInfo  = $areaModel->where(['area_parent_id' => $id])->select();
        echo json_encode($areaInfo);
    }


    /**
     * 新增收货地址
     */
    public function addAddressOp()
    {
        $rs = ['status' => -1, 'data' => '', 'msg' => '新增地址失败!'];
        //获取地区
        $areaModel = Model('area');
        $areaInfo  = $areaModel->where(['area_id' => ['in', $_POST['quiz1'] . ',' . $_POST['quiz2'] . ',' . $_POST['quiz3']]])->select();


        $addressModel       = Model('address');
        $data['member_id']  = $_SESSION['member_id'];
        $data['true_name']  = $_POST['name'];
        $data['area_id']    = $_POST['quiz1'];
        $data['city_id']    = $_POST['quiz2'];
        $data['address']    = $_POST['address'];
        $data['mob_phone']  = $_POST['phone'];
        $data['is_default'] = $_POST['isDefault'];
        $data['area_info']  = $areaInfo[0]['area_name'] . ' ' . $areaInfo[1]['area_name'] . ' ' . $areaInfo[2]['area_name'];
        if ($data['is_default'] == 1) {
            $addressModel->where(['member_id' => $data['member_id']])->update(['is_default' => 0]);
        }

        $addInfo = $addressModel->insert($data);
        if ($addInfo) {
            $rs['status'] = 1;
            $rs['msg']    = '新增收货地址成功';
        }
        echo json_encode($rs);

    }

}
