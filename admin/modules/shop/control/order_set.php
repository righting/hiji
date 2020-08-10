<?php
/**
 * 网站设置
 *
 *
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */



defined('ByCCYNet') or exit('Access Invalid!');
class order_setControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('setting');
    }

    public function indexOp() {
        $this->baseOp();
    }

    /**
     * 基本信息
     */
    public function baseOp(){
        $model_setting = Model('setting');
        if (chksubmit()){
            $update_array = array();

            if (!empty($_POST['order_time']) && $_POST['order_time'] > 0){
                $update_array['order_time'] = $_POST['order_time'];
            }else{
                $update_array['order_time']=7;
            }

            if (!empty($_POST['order_thaw_time']) && $_POST['order_thaw_time'] > 0){
                $update_array['order_thaw_time'] = $_POST['order_thaw_time'];
            }else{
                $update_array['order_thaw_time']=7;
            }

            if (!empty($_POST['order_delay_time']) && $_POST['order_delay_time'] > 0){
                $update_array['order_delay_time'] = $_POST['order_delay_time'];
            }else{
                $update_array['order_delay_time']=7;
            }
            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('nc_edit,web_set'),1);
                showMessage(L('nc_common_save_succ'));
            }else {
                $this->log(L('nc_edit,web_set'),0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting',$list_setting);
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('order.set');
    }


}
