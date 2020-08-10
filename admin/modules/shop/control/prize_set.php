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
class prize_setControl extends SystemControl{
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
			//是否开启抽奖
            if (!empty($_POST['prize_open']) && $_POST['prize_open'] > 0){
                $update_array['prize_open'] = $_POST['prize_open'];
            }else{
                $update_array['prize_open']=0;
            }
			//免费抽奖次数
			if (!empty($_POST['prize_free_num']) && $_POST['prize_free_num'] > 0){
                $update_array['prize_free_num'] = $_POST['prize_free_num'];
            }else{
                $update_array['prize_free_num']=0;
            }
			//使用积分抽奖次数
			if (!empty($_POST['prize_jf_num']) && $_POST['prize_jf_num'] > 0){
                $update_array['prize_jf_num'] = $_POST['prize_jf_num'];
            }else{
                $update_array['prize_jf_num']=0;
            }
			//多少积分抽一次
			if (!empty($_POST['prize_jf_money']) && $_POST['prize_jf_money'] > 0){
                $update_array['prize_jf_money'] = $_POST['prize_jf_money'];
            }else{
                $update_array['prize_jf_money']=0;
            }
			//echo '<pre>';print_r($update_array);exit;
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
        Tpl::showpage('prize.set');
    }


}
