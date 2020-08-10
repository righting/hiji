<?php
/**
 * 商品栏目管理
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class jfgoods_onlineControl extends SystemControl{
    private $links = array(
        array('url'=>'controller=jfgoods_online&action=goods','text'=>'所有商品'),
        //array('url'=>'controller=jfgoods_online&action=lockup_list','text'=>'下架商品'),
        //array('url'=>'controller=jfgoods_online&action=waitverify_list','text'=>'等待审核'),

    );
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('goods');
    }

    public function indexOp() {
        $this->goodsOp();
    }
    /**
     * 商品管理
     */
    public function goodsOp() {
        //父类列表，只取到第二级
        $gc_list = Model('goods_class')->getGoodsClassList(array('gc_parent_id' => 0));
        Tpl::output('gc_list', $gc_list);

        Tpl::output('top_link',$this->sublink($this->links,'goods'));
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('jfgoods.index');
    }
    /**
     * 违规下架商品管理
     */
    public function lockup_listOp() {
        Tpl::output('type', 'lockup');
        Tpl::output('top_link',$this->sublink($this->links,'lockup_list'));
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('jfgoods.index');
    }
    /**
     * 等待审核商品管理
     */
    public function waitverify_listOp() {
        Tpl::output('type', 'waitverify');
        Tpl::output('top_link',$this->sublink($this->links,'waitverify_list'));
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('jfgoods.index');
    }

    /**
     * 输出XML数据
     */
    public function get_xmlOp() {
        $model_goods = Model('jfgoods');
        $condition = array();
        $order = ' goods_addtime desc';
        $param = array('goods_commonid', 'goods_name', 'goods_price', 'goods_state', 'goods_verify', 'goods_image', 'goods_jingle', 'gc_id'
                , 'gc_name', 'store_id', 'store_name', 'is_own_shop', 'brand_id', 'brand_name', 'goods_addtime', 'goods_marketprice', 'goods_costprice'
                , 'goods_freight', 'is_virtual', 'virtual_indate', 'virtual_invalid_refund', 'is_fcode'
                , 'is_presell', 'presell_deliverdate','is_select','goods_integral','goods_hjb'
        );
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];
        }

        $page = $_POST['rp'];

        switch ($_GET['type']) {
            // 下架
            case 'lockup':
                $condition['goods_state'] =0;
                $goods_list = $model_goods->getGoodsCommonList($condition, '*', $page, $order);
                break;
                // 等待审核
            case 'waitverify':
                $goods_list = $model_goods->getGoodsCommonWaitVerifyList($condition, '*', $page, $order);
                break;
                // 全部商品
            default:
                $goods_list = $model_goods->getGoodsCommonList($condition, '*', $page, $order);
                break;
        }

        // 库存
        $storage_array = $model_goods->calculateStorage($goods_list);

        // 商品状态
        $goods_state = $this->getGoodsState();

        // 审核状态
        $verify_state = $this->getGoodsVerify();

        $data = array();
        $data['now_page'] = $model_goods->shownowpage();
        $data['total_num'] = $model_goods->gettotalnum();
        foreach ($goods_list as $value) {

            $param = array();
            $operation = '';
            switch ($_GET['type']) {
                // 禁售
                case 'lockup':
                    $operation .= "<a class='btn red' href='javascript:void(0);' onclick=\"fg_del('" . $value['goods_commonid'] . "')\"><i class='fa fa-trash-o'></i>删除</a>";
                    break;
                    // 等待审核
                case 'waitverify':
                    $operation .= "<a class='btn orange' href='javascript:void(0);' onclick=\"fg_verify('" . $value['goods_commonid'] . "')\"><i class='fa fa-check-square'></i>审核</a>";
                    break;
                    // 全部商品
                default:
                   // $operation .= "<a class='btn red' href='javascript:void(0);' onclick=\"fg_lonkup('" . $value['goods_commonid'] . "')\"><i class='fa fa-ban'></i>下架</a>";
                    break;
            }
            //$operation .= "<a href='" . urlAdminShop('jfgoods_online', 'edit_goods', array('commonid' => $value['goods_commonid'])) . "' >编辑</a>";
            $operation .= "<a class='btn blue'  href='" . urlAdminShop('jfgoods_add', 'index', array('goodsId' => $value['goods_id'])) . "' ><i class='fa fa-list-alt'></i>编辑</a>";

            /**设为精选尖货**/
            $operation .= "</ul>";
            $param['operation'] = $operation;
            $param['goods_id'] = $value['goods_id'];
            $param['goods_name'] = $value['goods_name'];
            $param['goods_image'] = "<a href='javascript:void(0);' class='pic-thumb-tip' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".cthumb($value['goods_image'],'60').">\")'><i class='fa fa-picture-o'></i></a>";
            $param['goods_price'] = ncPriceFormat($value['goods_price']);
            $param['goods_integral'] = $value['goods_integral'];
            $param['goods_hjb'] = $value['goods_hjb'];
            $param['goods_storage'] = $value['goods_storage'];
            $param['goods_state'] = $goods_state[$value['goods_state']];
            $param['goods_addtime'] = date('Y-m-d H:i:s', $value['goods_addtime']);
            $data['list'][$value['goods_commonid']] = $param;
        }
        echo Tpl::flexigridXML($data);exit();
    }

    /**
     * 商品状态
     * @return multitype:string
     */
    private function getGoodsState() {
        return array('1' => '出售中', '0' => '仓库中', '10' => '违规下架');
    }

    private function getGoodsVerify() {
        return array('1' => '通过', '0' => '未通过', '10' => '等待审核');
    }

    /**
     * 违规下架
     */
    public function goods_lockupOp() {
        if (chksubmit()) {
            $commonid = intval($_POST['commonid']);
            if ($commonid <= 0) {
                    showDialog(L('nc_common_op_fail'), 'reload');
            }
            $update = array();
            $update['goods_stateremark'] = trim($_POST['close_reason']);

            $where = array();
            $where['goods_commonid'] = $commonid;

            Model('jfgoods')->editProducesLockUp($update, $where);
            showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close()');
        }
        $common_info = Model('jfgoods')->getGoodsCommonInfoByID($_GET['id']);
        Tpl::output('common_info', $common_info);
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('jfgoods.close_remark', 'null_layout');
    }

    /**
     * 删除商品
     */
    public function goods_delOp() {
        $common_id = intval($_GET['id']);
        if ($common_id <= 0) {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
        Model('goods')->delGoodsAll(array('goods_commonid' => $common_id));
        $this->log('删除商品[ID:'.$common_id.']',1);
        exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
    }

    /**
     * 设置商品为精选尖货
     */
    public function goods_set_yxOp() {
        $commonid = intval($_POST['goods_id']);
        if ($commonid <= 0) {
            exit(json_encode(array('state'=>-1,'msg'=>'操作失败')));
        }
        $update = array();

        $where = array();
        $where['goods_commonid'] = $commonid;

        $result = Model('goods')->editProducesJx($update, $where);
        if($result){
            exit(json_encode(array('state'=>1,'msg'=>'操作成功')));
        }
        exit(json_encode(array('state'=>-1,'msg'=>'操作失败')));
    }

    /**
     * 审核商品
     */
    public function goods_verifyOp(){
        if (chksubmit()) {
            $commonid = intval($_POST['commonid']);
            if ($commonid <= 0) {
                    showDialog(L('nc_common_op_fail'), 'reload');
            }
            $update2 = array();
            $update2['goods_verify'] = intval($_POST['verify_state']);

            $update1 = array();
            $update1['goods_verifyremark'] = trim($_POST['verify_reason']);
            $update1 = array_merge($update1, $update2);
            $where = array();
            $where['goods_commonid'] = $commonid;

            $model_goods = Model('goods');
            if (intval($_POST['verify_state']) == 0) {
                $model_goods->editProducesVerifyFail($where, $update1, $update2);
            } else {
                $model_goods->editProduces($where, $update1, $update2);
            }
            showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close();');
        }
        $common_info = Model('goods')->getGoodsCommonInfoByID($_GET['id']);
        Tpl::output('common_info', $common_info);
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('goods.verify_remark', 'null_layout');
    }

    /**
     * ajax获取商品列表
     */
    public function get_goods_sku_listOp() {
        $commonid = $_GET['commonid'];
        if ($commonid <= 0) {
            showDialog('参数错误', '', '', 'CUR_DIALOG.close();');
        }
        $model_goods = Model('goods');
        $goodscommon_list = $model_goods->getGoodsCommonInfoByID($commonid, 'spec_name');
        if (empty($goodscommon_list)) {
            showDialog('参数错误', '', '', 'CUR_DIALOG.close();');
        }
        $spec_name = array_values((array)unserialize($goodscommon_list['spec_name']));
        $goods_list = $model_goods->getGoodsList(array('goods_commonid' => $commonid), 'goods_id,goods_spec,store_id,goods_price,goods_serial,goods_storage,goods_image');
        if (empty($goods_list)) {
            showDialog('参数错误', '', '', 'CUR_DIALOG.close();');
        }

        foreach ($goods_list as $key => $val) {
            $goods_spec = array_values((array)unserialize($val['goods_spec']));
            $spec_array = array();
            foreach ($goods_spec as $k => $v) {
                $spec_array[] = '<div class="goods_spec">' . $spec_name[$k] . L('nc_colon') . '<em title="' . $v . '">' . $v .'</em>' . '</div>';
            }
            $goods_list[$key]['goods_image'] = cthumb($val['goods_image'], '60');
            $goods_list[$key]['goods_spec'] = implode('', $spec_array);
            $goods_list[$key]['url'] = urlShop('goods', 'index', array('goods_id' => $val['goods_id']));
        }

//         /**
//          * 转码
//          */
//         if (strtoupper(CHARSET) == 'GBK') {
//             Language::getUTF8($goods_list);
//         }
//         echo json_encode($goods_list);
        Tpl::output('goods_list', $goods_list);
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('goods.sku_list', 'null_layout');
    }

    /**
     * 商品设置
     */
    public function goods_setOp() {
        $model_setting = Model('setting');
        if (chksubmit()){
            $update_array = array();
            $update_array['goods_verify'] = $_POST['goods_verify'];
            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('nc_edit,nc_goods_set'),1);
                showMessage(L('nc_common_save_succ'));
            }else {
                $this->log(L('nc_edit,nc_goods_set'),0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting',$list_setting);

        Tpl::output('top_link',$this->sublink($this->links,'goods_set'));
						//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
        Tpl::showpage('goods.setting');
    }

    /**
     * csv导出
     */
    public function export_csvOp() {
        $model_goods = Model('goods');
        $condition = array();
        $limit = false;
        if ($_GET['id'] != '') {
            $id_array = explode(',', $_GET['id']);
            $condition['goods_commonid'] = array('in', $id_array);
        }
        if ($_GET['goods_name'] != '') {
            $condition['goods_name'] = array('like', '%' . $_GET['goods_name'] . '%');
        }
        if ($_GET['goods_commonid'] != '') {
            $condition['goods_commonid'] = array('like', '%' . $_GET['goods_commonid'] . '%');
        }
        if ($_GET['store_name'] != '') {
            $condition['store_name'] = array('like', '%' . $_GET['store_name'] . '%');
        }
        if ($_GET['brand_name'] != '') {
            $condition['brand_name'] = array('like', '%' . $_GET['brand_name'] . '%');
        }
        if ($_GET['cate_id'] != '') {
            $condition['gc_id'] = $_GET['cate_id'];
        }
        if ($_GET['goods_state'] != '') {
            $condition['goods_state'] = $_GET['goods_state'];
        }
        if ($_GET['goods_verify'] != '') {
            $condition['goods_verify'] = $_GET['goods_verify'];
        }
        if ($_REQUEST['query'] != '') {
            $condition[$_REQUEST['qtype']] = array('like', '%' . $_REQUEST['query'] . '%');
        }
        $order = '';
        $param = array('goods_commonid', 'goods_name', 'goods_price', 'goods_state', 'goods_verify', 'goods_image', 'goods_jingle', 'gc_id'
                , 'gc_name', 'store_id', 'store_name', 'is_own_shop', 'brand_id', 'brand_name', 'goods_addtime', 'goods_marketprice', 'goods_costprice'
                , 'goods_freight', 'is_virtual', 'virtual_indate', 'virtual_invalid_refund', 'is_fcode'
                , 'is_presell', 'presell_deliverdate'
        );
        if (in_array($_REQUEST['sortname'], $param) && in_array($_REQUEST['sortorder'], array('asc', 'desc'))) {
            $order = $_REQUEST['sortname'] . ' ' . $_REQUEST['sortorder'];
        }
        if (!is_numeric($_GET['curpage'])){
            switch ($_GET['type']) {
                // 禁售
                case 'lockup':
                    $count = $model_goods->getGoodsCommonLockUpCount($condition);
                    break;
                    // 等待审核
                case 'waitverify':
                    $count = $model_goods->getGoodsCommonWaitVerifyCount($condition);
                    break;
                    // 全部商品
                default:
                    $count = $model_goods->getGoodsCommonCount($condition);
                    break;
            }
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $array = array();
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?controller=goods&action=index');
								//创 驰 云 网 络 ccynet.com
		Tpl::setDirquna('shop');
                Tpl::showpage('export.excel');
                exit();
            }
        } else {
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $limit = $limit1 .','. $limit2;
        }
        switch ($_GET['type']) {
            // 禁售
            case 'lockup':
                $goods_list = $model_goods->getGoodsCommonLockUpList($condition, '*', null, $order, $limit);
                break;
                // 等待审核
            case 'waitverify':
                $goods_list = $model_goods->getGoodsCommonWaitVerifyList($condition, '*', null, $order, $limit);
                break;
                // 全部商品
            default:
                $goods_list = $model_goods->getGoodsCommonList($condition, '*', null, $order, $limit);
                break;
        }
        $this->createCsv($goods_list);
    }

    /**
     * 生成csv文件
     */
    private function createCsv($goods_list) {
        // 库存
        $storage_array = Model('goods')->calculateStorage($goods_list);

        // 商品状态
        $goods_state = $this->getGoodsState();

        // 审核状态
        $verify_state = $this->getGoodsVerify();
        $data = array();
        foreach ($goods_list as $value) {
            $param = array();
            $param['goods_commonid'] = $value['goods_id'];
            $param['goods_name'] = $value['goods_name'];
            $param['goods_price'] = ncPriceFormat($value['goods_price']);
            $param['goods_state'] = $goods_state[$value['goods_state']];
            $param['goods_verify'] = $verify_state[$value['goods_verify']];
            $param['goods_image'] = cthumb($value['goods_image'],'60');
            $param['goods_jingle'] = htmlspecialchars($value['goods_jingle']);
            $param['gc_id'] = $value['gc_id'];
            $param['gc_name'] = $value['gc_name'];
            $param['store_id'] = $value['store_id'];
            $param['store_name'] = $value['store_name'];
            $param['is_own_shop'] = $value['is_own_shop'] == 1 ? '平台自营' : '入驻商户';
            $param['brand_id'] = $value['brand_id'];
            $param['brand_name'] = $value['brand_name'];
            $param['goods_addtime'] = date('Y-m-d', $value['goods_addtime']);
            $param['goods_marketprice'] = ncPriceFormat($value['goods_marketprice']);
            $param['goods_costprice'] = ncPriceFormat($value['goods_costprice']);
            $param['goods_freight'] = $value['goods_freight'] == 0 ? '免运费' : ncPriceFormat($value['goods_freight']);
            $param['goods_storage'] = $storage_array[$value['goods_commonid']]['sum'];
            $param['is_virtual'] = $value['is_virtual'] ==  '1' ? '是' : '否';
            $param['virtual_indate'] = $value['is_virtual'] == '1' && $value['virtual_indate'] > 0 ? date('Y-m-d', $value['virtual_indate']) : '--';
            $param['virtual_invalid_refund'] = $value['is_virtual'] ==  '1' ? ($value['virtual_invalid_refund'] == 1 ? '是' : '否') : '--';
            $data[$value['goods_commonid']] = $param;
        }

        $header = array(
                'goods_commonid' => 'SPU',
                'goods_name' => '商品名称',
                'goods_price' => '商品价格(元)',
                'goods_state' => '商品状态',
                'goods_verify' => '审核状态',
                'goods_image' => '商品图片',
                'goods_jingle' => '广告词',
                'gc_id' => '分类ID',
                'store_id' => '店铺ID',
                'store_name' => '店铺名称',
                'is_own_shop' => '店铺类型',
                'brand_id' => '品牌ID',
                'brand_name' => '品牌名称',
                'goods_addtime' => '发布时间',
                'goods_marketprice' => '市场价格(元)',
                'goods_costprice' => '供货价格(元)',
                'goods_freight' => '运费(元)',
                'goods_storage' => '库存',
                'is_virtual' => '虚拟商品',
                'virtual_indate' => '有效期',
                'virtual_invalid_refund' => '允许退款'
        );
       array_unshift($data, $header);
		$csv = new Csv();
	    $export_data = $csv->charset($data,CHARSET,'GBK');
	    $csv->filename = $csv->charset('goods_list',CHARSET).$_GET['curpage'] . '-'.date('Y-m-d');
	    $csv->export($data);
    }
    /**
     * 编辑商品页面
     */
    public function edit_goodsOp() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }
        $model_goods = Model('jfgoods');
        $goodscommon_info = $model_goods->getGoodsCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $_SESSION['seller_session_info']['store_id'] || $goodscommon_info['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }

        //权限组对应分类权限判断
        if (!$_SESSION['seller_session_info']['seller_gc_limits'] && $_SESSION['seller_session_info']['seller_group_id']) {
            $gc_list = Model('seller_group_bclass')->getSellerGroupBclasList(array('group_id'=>$_SESSION['seller_session_info']['seller_group_id']),'','','gc_id','gc_id');
            if (!in_array($goodscommon_info['gc_id'],array_keys($gc_list))) {
                showMessage('您所在的组无权操作该分类下的商品','', 'html', 'error');
            }
        }
        $where = array('goods_commonid' => $common_id, 'store_id' => $_SESSION['seller_session_info']['store_id']);
        $goodscommon_info['g_storage'] = $model_goods->getGoodsSum($where, 'goods_storage');
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        $goodscommon_info['goods_custom'] = unserialize($goodscommon_info['goods_custom']);
        if ($goodscommon_info['mobile_body'] != '') {
            $goodscommon_info['mb_body'] = unserialize($goodscommon_info['mobile_body']);
            if (is_array($goodscommon_info['mb_body'])) {
                $mobile_body = '[';
                foreach ($goodscommon_info['mb_body'] as $val ) {
                    $mobile_body .= '{"type":"' . $val['type'] . '","value":"' . $val['value'] . '"},';
                }
                $mobile_body = rtrim($mobile_body, ',') . ']';
            }
            $goodscommon_info['mobile_body'] = $mobile_body;
        }
        Tpl::output('goods', $goodscommon_info);

        if (intval($_GET['class_id']) > 0) {
            $goodscommon_info['gc_id'] = intval($_GET['class_id']);
        }
        $goods_class = Model('goods_class')->getGoodsClassLineForTag($goodscommon_info['gc_id']);
        Tpl::output('goods_class', $goods_class);

        $model_type = Model('type');
        // 获取类型相关数据
        $typeinfo = $model_type->getAttr($goods_class['type_id'], $_SESSION['seller_session_info']['store_id'], $goodscommon_info['gc_id']);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        Tpl::output('spec_json', $spec_json);
        Tpl::output('sign_i', count($spec_list));
        Tpl::output('spec_list', $spec_list);
        Tpl::output('attr_list', $attr_list);
        Tpl::output('brand_list', $brand_list);
        // 自定义属性
        $custom_list = Model('type_custom')->getTypeCustomList(array('type_id' => $goods_class['type_id']));
        $custom_list = array_under_reset($custom_list, 'custom_id');
        Tpl::output('custom_list', $custom_list);

        // 取得商品规格的输入值
        $goods_array = $model_goods->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_storage,goods_serial,goods_storage_alarm,goods_spec,goods_barcode');
        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {

            // 取得已选择了哪些商品的属性
            $attr_checked_l = $model_type->typeRelatedList ( 'goods_attr_index', array (
                'goods_id' => intval ( $goods_array[0]['goods_id'] )
            ), 'attr_value_id' );
            if (is_array ( $attr_checked_l ) && ! empty ( $attr_checked_l )) {
                $attr_checked = array ();
                foreach ( $attr_checked_l as $val ) {
                    $attr_checked [] = $val ['attr_value_id'];
                }
            }
            Tpl::output ( 'attr_checked', $attr_checked );

            $spec_checked = array();
            foreach ( $goods_array as $k => $v ) {
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val){
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = $val;
                    }
                    $matchs = array_keys($a);
                    sort($matchs);
                    $id = str_replace ( ',', '', implode ( ',', $matchs ) );
                    $sp_value ['i_' . $id . '|marketprice'] = $v['goods_marketprice'];
                    $sp_value ['i_' . $id . '|price'] = $v['goods_price'];
                    $sp_value ['i_' . $id . '|id'] = $v['goods_id'];
                    $sp_value ['i_' . $id . '|stock'] = $v['goods_storage'];
                    $sp_value ['i_' . $id . '|alarm'] = $v['goods_storage_alarm'];
                    $sp_value ['i_' . $id . '|sku'] = $v['goods_serial'];
                    $sp_value ['i_' . $id . '|barcode'] = $v['goods_barcode'];
                }
            }
            Tpl::output('spec_checked', $spec_checked);
        }
        Tpl::output ( 'sp_value', $sp_value );

        // 实例化店铺商品分类模型
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION ['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);
        //处理商品所属分类
        $store_goods_class_tmp = array();
        if (!empty($store_goods_class)){
            foreach ($store_goods_class as $k=>$v) {
                $store_goods_class_tmp[$v['stc_id']] = $v;
                if (is_array($v['child'])) {
                    foreach ($v['child'] as $son_k=>$son_v){
                        $store_goods_class_tmp[$son_v['stc_id']] = $son_v;
                    }
                }
            }
        }
        $goodscommon_info['goods_stcids'] = trim($goodscommon_info['goods_stcids'], ',');
        $goods_stcids = empty($goodscommon_info['goods_stcids'])?array():explode(',', $goodscommon_info['goods_stcids']);
        $goods_stcids_tmp = $goods_stcids_new = array();
        if (!empty($goods_stcids)){
            foreach ($goods_stcids as $k=>$v){
                $stc_parent_id = $store_goods_class_tmp[$v]['stc_parent_id'];
                //分类进行分组，构造为array('1'=>array(5,6,8));
                if ($stc_parent_id > 0){//如果为二级分类，则分组到父级分类下
                    $goods_stcids_tmp[$stc_parent_id][] = $v;
                } elseif (empty($goods_stcids_tmp[$v])) {//如果为一级分类而且分组不存在，则建立一个空分组数组
                    $goods_stcids_tmp[$v] = array();
                }
            }
            foreach ($goods_stcids_tmp as $k=>$v){
                if (!empty($v) && count($v) > 0){
                    $goods_stcids_new = array_merge($goods_stcids_new,$v);
                } else {
                    $goods_stcids_new[] = $k;
                }
            }
        }
        Tpl::output('store_class_goods', $goods_stcids_new);

        // 是否能使用编辑器
        if(checkPlatformStore()){ // 平台店铺可以使用编辑器
            $editor_multimedia = true;
        } else {    // 三方店铺需要
            $editor_multimedia = false;
            if ($this->store_grade['sg_function'] == 'editor_multimedia') {
                $editor_multimedia = true;
            }
        }
        Tpl::output ( 'editor_multimedia', $editor_multimedia );

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        Tpl::output('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        Tpl::output('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['seller_session_info']['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

        // 供货商
        $supplier_list = Model('store_supplier')->getStoreSupplierList(array('sup_store_id' => $_SESSION['seller_session_info']['store_id']));
        Tpl::output('supplier_list', $supplier_list);

        $menu_promotion = array(
            'lock' => $goodscommon_info['goods_lock'] == 1 ? true : false,
            'gift' => $goodscommon_info['is_virtual'] == 1 ? false : true
        );
        //$this->profile_menu('edit_detail','edit_detail', $menu_promotion);
        Tpl::output('edit_goods_sign', true);
        Tpl::setDirquna('shop');
        Tpl::showpage('store_goods_add.step2');
    }
    /**
     * 编辑商品保存
     */
    public function edit_save_goodsOp() {
        $logic_goods = Logic('jfgoods');

        $result =  $logic_goods->updateGoods(
            $_POST,
            $_SESSION['seller_session_info']['store_id'],
            $_SESSION['seller_session_info']['store_name'],
            $this->store_info['store_state'],
            $_SESSION['seller_session_info']['seller_id'],
            $_SESSION['seller_session_info']['seller_name'],
            $_SESSION['seller_session_info']['bind_all_gc']
        );

        if ($result['state']) {
            //提交事务
            showDialog(L('nc_common_op_succ'), $_POST['ref_url'], 'succ');
        } else {
            //回滚事务
            showDialog($result['msg'], urlShop('store_goods_online', 'index'));
        }
    }

    /**
     * 编辑图片
     */
    public function edit_imageOp() {
        $common_id = intval($_GET['commonid']);
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }
        $model_goods = Model('jfgoods');
        $common_list = $model_goods->getGoodsCommonInfoByID($common_id, 'store_id,goods_lock,spec_value,is_virtual,is_fcode,is_presell');
        if ($common_list['store_id'] != $_SESSION['seller_session_info']['store_id'] || $common_list['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }

        $spec_value = unserialize($common_list['spec_value']);
        Tpl::output('value', $spec_value['1']);

        $image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $common_id));
        $image_list = array_under_reset($image_list, 'color_id', 2);

        $img_array = $model_goods->getGoodsList(array('goods_commonid' => $common_id), 'color_id,min(goods_image) as goods_image', 'color_id');
        // 整理，更具id查询颜色名称
        if (!empty($img_array)) {
            foreach ($img_array as $val) {
                if (isset($image_list[$val['color_id']])) {
                    $image_array[$val['color_id']] = $image_list[$val['color_id']];
                } else {
                    $image_array[$val['color_id']][0]['goods_image'] = $val['goods_image'];
                    $image_array[$val['color_id']][0]['is_default'] = 1;
                }
                $colorid_array[] = $val['color_id'];
            }
        }
        Tpl::output('img', $image_array);


        $model_spec = Model('spec');
        $value_array = $model_spec->getSpecValueList(array('sp_value_id' => array('in', $colorid_array), 'store_id' => $_SESSION['seller_session_info']['store_id']), 'sp_value_id,sp_value_name');
        if (empty($value_array)) {
            $value_array[] = array('sp_value_id' => '0', 'sp_value_name' => '无颜色');
        }
        Tpl::output('value_array', $value_array);

        Tpl::output('commonid', $common_id);

        $menu_promotion = array(
            'lock' => $common_list['goods_lock'] == 1 ? true : false,
            'gift' => $model_goods->checkGoodsIfAllowGift($common_list)
        );
        //$this->profile_menu('edit_detail', 'edit_image', $menu_promotion);
        Tpl::setDirquna('shop');
        Tpl::output('edit_goods_sign', true);
        Tpl::showpage('store_goods_add.step3');
    }

    /**
     * 保存商品图片
     */
    public function edit_save_imageOp() {
        if (chksubmit()) {
            $common_id = intval($_POST['commonid']);
            $rs = Logic('goods')->editSaveImage($_POST['img'], $common_id, $_SESSION['seller_session_info']['store_id'], $_SESSION['seller_session_info']['seller_id'], $_SESSION['seller_session_info']['seller_name']);
            if ($rs['state']) {
                showDialog(L('nc_common_op_succ'), $_POST['ref_url'], 'succ');
            } else {
                showDialog(L('nc_common_save_fail'), urlShop('store_goods_online', 'index'));
            }
        }
    }
}
