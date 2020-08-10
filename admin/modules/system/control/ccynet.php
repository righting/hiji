<?php
/**
 * 运维控件管理 海吉壹佰 ccynet.cn
 *by wansyb QQ499063702
 */
defined('ByCCYNet') or exit('Access Invalid!');

class ccynetControl extends SystemControl
{
    private $links = [
        ['url' => 'controller=ccynet&action=base', 'lang' => 'ccynet_set'],
        ['url' => 'controller=ccynet&action=banner', 'lang' => 'top_set'],
//        array('url'=>'controller=ccynet&action=lc','lang'=>'lc_set'),
        ['url' => 'controller=ccynet&action=sms', 'lang' => 'sms_set'],
//		array('url'=>'controller=ccynet&action=rc','lang'=>'rc_set'),
//		array('url'=>'controller=ccynet&action=webchat','lang'=>'webchat_set'),

    ];

    public function __construct()
    {
        parent::__construct();
        Language::read('ccynet,setting');
    }

    public function indexOp()
    {
        $this->baseOp();
    }

    /**
     * 基本信息
     */
    public function baseOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $list_setting                   = $model_setting->getListSetting();
            $update_array                   = [];
            $update_array['ccynet_stitle']  = $_POST['ccynet_stitle'];
            $update_array['ccynet_phone']   = $_POST['ccynet_phone'];
            $update_array['ccynet_time']    = $_POST['ccynet_time'];
            $update_array['ccynet_invite2'] = $_POST['ccynet_invite2'];
            $update_array['ccynet_invite3'] = $_POST['ccynet_invite3'];
            $result                         = $model_setting->updateSetting($update_array);
            if ($result === true) {
                $this->log(L('nc_edit,ccynet_set'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,ccynet_set'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();

        Tpl::output('list_setting', $list_setting);

        //输出子菜单
        Tpl::output('top_link', $this->sublink($this->links, 'base'));
        //创 驰 云 网 络 ccynet.com
        Tpl::setDirquna('system');
        Tpl::showpage('ccynet.base');
    }

    /**
     * 顶部广告信息
     */
    public function bannerOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            if (!empty($_FILES['ccynet_top_banner_pic']['name'])) {
//                $upload = new UploadFile();
                $upload = new AliOssUpload();
                $upload->set('default_dir', ATTACH_COMMON);
                $result = $upload->upfile('ccynet_top_banner_pic');
                if ($result) {
                    $_POST['ccynet_top_banner_pic'] = $upload->file_name;
                } else {
                    showMessage($upload->error, '', '', 'error');
                }
            }
            $list_setting                             = $model_setting->getListSetting();
            $update_array                             = [];
            $update_array['ccynet_top_banner_name']   = $_POST['top_banner_name'];
            $update_array['ccynet_top_banner_url']    = $_POST['top_banner_url'];
            $update_array['ccynet_top_banner_color']  = $_POST['top_banner_color'];
            $update_array['ccynet_top_banner_status'] = $_POST['top_banner_status'];
            if (!empty($_POST['ccynet_top_banner_pic'])) {
                $update_array['ccynet_top_banner_pic'] = $_POST['ccynet_top_banner_pic'];
            }
            $result = $model_setting->updateSetting($update_array);
            if ($result === true) {
                //判断有没有之前的图片，如果有则删除
                if (!empty($list_setting['ccynet_top_banner_pic']) && !empty($_POST['ccynet_top_banner_pic'])) {
                    @unlink(BASE_UPLOAD_PATH . DS . ATTACH_COMMON . DS . $list_setting['ccynet_top_banner_pic']);
                }
                $this->log(L('nc_edit,top_set'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,top_set'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }

        $list_setting = $model_setting->getListSetting();

        Tpl::output('list_setting', $list_setting);

        //输出子菜单
        Tpl::output('top_link', $this->sublink($this->links, 'banner'));
        //创 驰 云 网 络 ccynet.com
        Tpl::setDirquna('system');
        Tpl::showpage('ccynet.banner');
    }

    /**
     * 楼层快速直达列表
     */
    public function lcOp()
    {
        $model_setting = Model('setting');
        $lc_info       = $model_setting->getRowSetting('ccynet_lc');
        if ($lc_info !== false) {
            $lc_list = @unserialize($lc_info['value']);
        }
        if (!$lc_list && !is_array($lc_list)) {
            $lc_list = [];
        }
        Tpl::output('lc_list', $lc_list);
        Tpl::output('top_link', $this->sublink($this->links, 'lc'));
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('ccynet.lc');
    }

    /**
     * 楼层快速直达添加
     */
    public function lc_addOp()
    {
        $model_setting = Model('setting');
        $lc_info       = $model_setting->getRowSetting('ccynet_lc');
        if ($lc_info !== false) {
            $lc_list = @unserialize($lc_info['value']);
        }
        if (!$lc_list && !is_array($lc_list)) {
            $lc_list = [];
        }
        if (chksubmit()) {
            if (count($lc_list) >= 8) {
                showMessage('最多可设置8个楼层', 'index.php?controller=ccynet&action=lc');
            }
            if ($_POST['lc_name'] != '' && $_POST['lc_value'] != '') {
                $data = ['name' => stripslashes($_POST['lc_name']), 'value' => stripslashes($_POST['lc_value'])];
                array_unshift($lc_list, $data);
            }
            $result = $model_setting->updateSetting(['ccynet_lc' => serialize($lc_list)]);
            if ($result) {
                showMessage('保存成功', 'index.php?controller=ccynet&action=lc');
            } else {
                showMessage('保存失败');
            }
        }
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/

        Tpl::showpage('ccynet.lc_add');
    }

    /**
     * 删除
     */
    public function lc_delOp()
    {
        $model_setting = Model('setting');
        $lc_info       = $model_setting->getRowSetting('ccynet_lc');
        if ($lc_info !== false) {
            $lc_list = @unserialize($lc_info['value']);
        }
        if (!empty($lc_list) && is_array($lc_list) && intval($_GET['id']) >= 0) {
            unset($lc_list[intval($_GET['id'])]);
        }
        if (!is_array($lc_list)) {
            $lc_list = [];
        }
        $result = $model_setting->updateSetting(['ccynet_lc' => serialize(array_values($lc_list))]);
        if ($result) {
            showMessage('删除成功');
        }
        showMessage('删除失败');
    }

    /**
     * 编辑
     */
    public function lc_editOp()
    {
        $model_setting = Model('setting');
        $lc_info       = $model_setting->getRowSetting('ccynet_lc');
        if ($lc_info !== false) {
            $lc_list = @unserialize($lc_info['value']);
        }
        if (!is_array($lc_list)) {
            $lc_list = [];
        }
        if (!chksubmit()) {
            if (!empty($lc_list) && is_array($lc_list) && intval($_GET['id']) >= 0) {
                $current_info = $lc_list[intval($_GET['id'])];
            }
            Tpl::output('current_info', is_array($current_info) ? $current_info : []);
            Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
            Tpl::showpage('ccynet.lc_add');
        } else {
            if ($_POST['lc_name'] != '' && $_POST['lc_value'] != '' && $_POST['id'] != '' && intval($_POST['id']) >= 0) {
                $lc_list[intval($_POST['id'])] = ['name' => stripslashes($_POST['lc_name']), 'value' => stripslashes($_POST['lc_value'])];
            }
            $result = $model_setting->updateSetting(['ccynet_lc' => serialize($lc_list)]);
            if ($result) {
                showMessage('编辑成功', 'index.php?controller=ccynet&action=lc');
            }
            showMessage('编辑失败');
        }


    }

    /**
     * 首页热门关键词链接
     */
    public function rcOp()
    {
        $model_setting = Model('setting');
        $rc_info       = $model_setting->getRowSetting('ccynet_rc');
        if ($rc_info !== false) {
            $rc_list = @unserialize($rc_info['value']);
        }
        if (!$rc_list && !is_array($rc_list)) {
            $rc_list = [];
        }
        Tpl::output('rc_list', $rc_list);
        Tpl::output('top_link', $this->sublink($this->links, 'rc'));
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('ccynet.rc');
    }

    /**
     * 楼层快速直达添加
     */
    public function rc_addOp()
    {
        $model_setting = Model('setting');
        $rc_info       = $model_setting->getRowSetting('ccynet_rc');
        if ($rc_info !== false) {
            $rc_list = @unserialize($rc_info['value']);
        }
        if (!$rc_list && !is_array($rc_list)) {
            $rc_list = [];
        }
        if (chksubmit()) {
            if (count($rc_list) >= 8) {
                showMessage('最多可设置8个楼层', 'index.php?controller=ccynet&action=rc');
            }
            if ($_POST['rc_name'] != '' && $_POST['rc_value'] != '' && $_POST['rc_blod'] != '') {
                $data = ['name' => stripslashes($_POST['rc_name']), 'value' => stripslashes($_POST['rc_value']), 'is_blod' => stripslashes($_POST['rc_blod'])];
                array_unshift($rc_list, $data);
            }
            $result = $model_setting->updateSetting(['ccynet_rc' => serialize($rc_list)]);
            if ($result) {
                showMessage('保存成功', 'index.php?controller=ccynet&action=rc');
            } else {
                showMessage('保存失败');
            }
        }
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/

        Tpl::showpage('ccynet.rc_add');
    }

    /**
     * 删除
     */
    public function rc_delOp()
    {
        $model_setting = Model('setting');
        $rc_info       = $model_setting->getRowSetting('ccynet_rc');
        if ($rc_info !== false) {
            $rc_list = @unserialize($rc_info['value']);
        }
        if (!empty($rc_list) && is_array($rc_list) && intval($_GET['id']) >= 0) {
            unset($rc_list[intval($_GET['id'])]);
        }
        if (!is_array($rc_list)) {
            $rc_list = [];
        }
        $result = $model_setting->updateSetting(['ccynet_rc' => serialize(array_values($rc_list))]);
        if ($result) {
            showMessage('删除成功');
        }
        showMessage('删除失败');
    }

    /**
     * 编辑
     */
    public function rc_editOp()
    {
        $model_setting = Model('setting');
        $rc_info       = $model_setting->getRowSetting('ccynet_rc');
        if ($rc_info !== false) {
            $rc_list = @unserialize($rc_info['value']);
        }
        if (!is_array($rc_list)) {
            $rc_list = [];
        }
        if (!chksubmit()) {
            if (!empty($rc_list) && is_array($rc_list) && intval($_GET['id']) >= 0) {
                $current_info = $rc_list[intval($_GET['id'])];
            }
            Tpl::output('current_info', is_array($current_info) ? $current_info : []);
            Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
            Tpl::showpage('ccynet.rc_add');
        } else {
            if ($_POST['rc_name'] != '' && $_POST['rc_value'] != '' && $_POST['rc_blod'] != '' && $_POST['id'] != '' && intval($_POST['id']) >= 0) {
                $rc_list[intval($_POST['id'])] = ['name' => stripslashes($_POST['rc_name']), 'value' => stripslashes($_POST['rc_value']), 'is_blod' => stripslashes($_POST['rc_blod'])];
            }
            $result = $model_setting->updateSetting(['ccynet_rc' => serialize($rc_list)]);
            if ($result) {
                showMessage('编辑成功', 'index.php?controller=ccynet&action=rc');
            }
            showMessage('编辑失败');
        }


    }

    /**
     * 短信平台设置
     */
    public function smsOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $update_array                    = [];
            $update_array['ccynet_sms_type'] = $_POST['ccynet_sms_type'];
            $update_array['ccynet_sms_tgs']  = $_POST['ccynet_sms_tgs'];
            $update_array['ccynet_sms_zh']   = $_POST['ccynet_sms_zh'];
            $update_array['ccynet_sms_pw']   = $_POST['ccynet_sms_pw'];
            $update_array['ccynet_sms_key']  = $_POST['ccynet_sms_key'];

            $update_array['ccynet_sms_aliyun_key_id']     = $_POST['ccynet_sms_aliyun_key_id'];
            $update_array['ccynet_sms_aliyun_key_secret'] = $_POST['ccynet_sms_aliyun_key_secret'];

            $update_array['ccynet_sms_signature'] = $_POST['ccynet_sms_signature'];
            $update_array['ccynet_sms_bz']        = $_POST['ccynet_sms_bz'];
            $result                               = $model_setting->updateSetting($update_array);
            if ($result === true) {
                $this->log(L('nc_edit,sms_set'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,sms_set'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting', $list_setting);

        Tpl::output('top_link', $this->sublink($this->links, 'sms'));
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('ccynet.sms');
    }

    /**
     * 默认微信公众号设置
     */
    public function webchatOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $update_array                             = [];
            $update_array['ccynet_webchat_appid']     = $_POST['ccynet_webchat_appid'];
            $update_array['ccynet_webchat_appsecret'] = $_POST['ccynet_webchat_appsecret'];
            $result                                   = $model_setting->updateSetting($update_array);
            if ($result === true) {
                $this->log(L('nc_edit,sms_set'), 1);
                showMessage(L('nc_common_save_succ'));
            } else {
                $this->log(L('nc_edit,sms_set'), 0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting', $list_setting);

        Tpl::output('top_link', $this->sublink($this->links, 'webchat'));
        Tpl::setDirquna('system');/*创 驰 云 网 络 ccynet.com*/
        Tpl::showpage('ccynet.webchat');
    }
}