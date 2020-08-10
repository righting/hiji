<?php
/**
 * 用户中心
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class member_informationControl extends BaseShopMemberControl {
    /**
     * 用户中心
     *
     * @param
     * @return
     */
    public function indexOp() {
        $this->memberOp();
    }
    /**
     * 我的资料【用户中心】
     *
     * @param
     * @return
     */
    public function memberOp() {

        Language::read('member_home_member');
        $lang   = Language::getLangContent();
        $model_member   = Model('member');
        if (chksubmit()){
            $post = $_POST;
            $member_array   = array();
            $member_array['member_truename']    = $post['member_truename'];
            $member_array['member_sex']         = $post['member_sex'];
            $member_array['member_nickname']    = $post['member_nickname'];
            $member_array['member_ww']          = $post['member_ww'];
            $member_array['member_qq']          = $post['member_qq'];
            $member_array['member_weixin']      = $post['member_weixin'];
            $member_array['member_avatar']      = $post['member_avatar'];
            if ( $post['member_mobile']){
                $member_array['member_mobile']      =    $post['member_mobile'];
            }
            $member_array['member_areaid']      = $post['area_id'];
            $member_array['member_cityid']      = $post['city_id'];
            $member_array['member_provinceid']  = $post['province_id'];


            $member_array['member_areainfo']    = $post['region'];
            if (strlen($post['birthday']) == 10){
                $member_array['member_birthday']    = $post['birthday'];
            }
            $member_array['member_privacy']     = serialize($post['privacy']);
            $update = $model_member->editMember(array('member_id'=>$_SESSION['member_id']),$member_array);

            $message = $update? $lang['nc_common_save_succ'] : $lang['nc_common_save_fail'];
            showDialog($message,'reload',$update ? 'succ' : 'error');
        }

        if($this->member_info['member_privacy'] != ''){
            $this->member_info['member_privacy'] = unserialize($this->member_info['member_privacy']);
        } else {
            $this->member_info['member_privacy'] = array();
        }
        Tpl::output('member_info',$this->member_info);

        self::profile_menu('member','member');
        Tpl::output('menu_sign','profile');
        Tpl::output('menu_sign_url','index.php?controller=member_information&action=member');
        Tpl::output('menu_sign1','baseinfo');
        Tpl::showpage('member_profile');
    }

    /**
     * 我的资料【详情】
     */
    public function detailOp(){

        Language::read('member_home_member');
        $lang   = Language::getLangContent();
        $member_id = $_SESSION['member_id'];
        $model_member   = Model('member_detail');
        $member_detail = $model_member->getMemberDetailByID($member_id);

        if (chksubmit() && $member_detail['isauth']!=1) {
            if (empty($_POST['real_name']) || empty($_POST['member_id_number'])){
                showDialog('资料填写不完整','reload', 'error');
            }
            //身份证号重复性检测
            $idNumber = Model('member_detail')->where(['member_id_number'=>$_POST['member_id_number'],'member_id'=>['NEQ',$member_id]])->count();
            if ($idNumber>0){
                showDialog('当前身份证号码已被提交过','', 'error');
            }
            $detail = array();
            $detail['member_marital']       =       $_POST['member_marital'];
            $detail['real_name']            =       $_POST['real_name'];
            $detail['member_id_number']     =       $_POST['member_id_number'];
            $detail['member_educational']   =       $_POST['member_educational'];
            $detail['member_industry']      =       $_POST['member_industry'];
            $detail['id_card_photo']        =       $_POST['pic_front'];
            $detail['id_card_photo_back']   =       $_POST['pic_back'];
            $detail['isauth']   = 0;
            $detail['response']   = '';

            Model::beginTransaction();
            try{
                $res = $model_member->editMemberDetail(array('member_id'=>$member_id),$detail);
                if (!$res){
                    throw new Exception("实名信息保存失败");
                }
                $res = Model('member')->editMember(['member_id'=>$member_id],['member_truename'=>$_POST['real_name']]);
                if (!$res){
                    throw new Exception("会员真实姓名修改失败");
                }
                Model::commit();
            }catch (Exception $e){
                Model::rollback();
                showDialog('资料保存失败，稍后请重试!','error');
            }
            if (C('member_auth_auto')==1){//自动实名验证
                $res = Model('member')->memberAuth($member_id,true);
                if ($res['status'])
                    showDialog('尊敬的会员，你的实名认证审核通过','reload', 'succ');
                else{
                    showDialog('尊敬的会员，信息已提交，请等待后台审核','', 'error','',0);
                }
            }
            $message = $res? $lang['nc_common_save_succ'] : $lang['nc_common_save_fail'];
            showDialog($message,'reload',$res ? 'succ' : 'error');
        }

        self::profile_menu('member','detail');

        Tpl::output('member_detail',$member_detail);
        Tpl::showpage('member_profile.detail');
    }
    /**
     * 我的资料【更多个人资料】
     *
     * @param
     * @return
     */
    public function moreOp(){
        /**
         * 读取语言包
         */
        Language::read('member_home_member');

        // 实例化模型
        $model = Model();

        if(chksubmit()){
            $model->table('sns_mtagmember')->where(array('member_id'=>$_SESSION['member_id']))->delete();
            if(!empty($_POST['mid'])){
                $insert_array = array();
                foreach ($_POST['mid'] as $val){
                    $insert_array[] = array('mtag_id'=>$val,'member_id'=>$_SESSION['member_id'],'recommend'=>'0');
                }
                $model->table('sns_mtagmember')->insertAll($insert_array,'',true);
            }
            showDialog(Language::get('nc_common_op_succ'),'','succ');
        }

        // 用户标签列表
        $mtag_array = $model->table('sns_membertag')->order('mtag_sort asc')->limit(1000)->select();

        // 用户已添加标签列表。
        $mtm_array = $model->table('sns_mtagmember')->where(array('member_id'=>$_SESSION['member_id']))->select();
        $mtag_list  = array();
        $mtm_list   = array();
        if(!empty($mtm_array) && is_array($mtm_array)){
            // 整理
            $elect_array = array();
            foreach($mtm_array as $val){
                $elect_array[]  = $val['mtag_id'];
            }
            foreach ((array)$mtag_array as $val){
                if(in_array($val['mtag_id'], $elect_array)){
                    $mtm_list[] = $val;
                }else{
                    $mtag_list[] = $val;
                }
            }
        }else{
            $mtag_list = $mtag_array;
        }
        Tpl::output('mtag_list', $mtag_list);
        Tpl::output('mtm_list', $mtm_list);

        self::profile_menu('member','more');
        Tpl::output('menu_sign','profile');
        Tpl::output('menu_sign_url','index.php?controller=member_information&action=member');
        Tpl::output('menu_sign1','baseinfo');
        Tpl::showpage('member_profile.more');
    }

    public function uploadOp() {
		if (!chksubmit()){
			redirect(urlMember('member_information','avatar'));
		}
		import('function.thumb');
		Language::read('member_home_member,cut');
		$lang	= Language::getLangContent();
		$member_id = $_SESSION['member_id'];

        //上传图片
//        $upload = new UploadFile();
        $upload = new AliOssUpload();
        $upload->set('thumb_width', 500);
        $upload->set('thumb_height',499);
        $ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));

        $upload->set('file_name',"avatar_$member_id.jpg");
        $upload->set('thumb_ext','_new');
        $upload->set('ifremove',true);
        $upload->set('default_dir',ATTACH_AVATAR);
        if (!empty($_FILES['pic']['tmp_name'])){
            $result = $upload->upfile('pic');
            if (!$result){
                exit(json_encode(array('status'=>0,'msg'=>'上传错误，请重试')));
            }

        }else{
            exit(json_encode(array('status'=>0,'msg'=>'上传失败，请尝试更换图片格式或小图片')));
        }
        $img_path = $upload->getSysSetPath() . $upload->file_name;

        Model('member')->editMember(array('member_id'=>$_SESSION['member_id']),array('member_avatar'=>$upload->file_name));
        $_SESSION['avatar'] = $upload->file_name;
        exit(json_encode(array('status'=>1,'msg'=>$img_path),JSON_UNESCAPED_SLASHES));
//        self::profile_menu('member','avatar');
//        Tpl::output('menu_sign','profile');
//        Tpl::output('menu_sign_url','index.php?controller=member_information&action=member');
//         Tpl::output('menu_sign1','avatar');
//         Tpl::output('newfile',cthumb($img_path, 120));
//	    Tpl::output('height',get_height(BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR.'/'.$upload->thumb_image));
//	    Tpl::output('width',get_width(BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR.'/'.$upload->thumb_image));
//         Tpl::showpage('member_profile.avatar');

    }

    /**
     * 裁剪
     *
     */
    public function cutOp(){
        if (chksubmit()){
            print_r($_POST);die;
            $thumb_width = 120;
            $x1 = $_POST["x1"];
            $y1 = $_POST["y1"];
            $x2 = $_POST["x2"];
            $y2 = $_POST["y2"];
            $w = $_POST["w"];
            $h = $_POST["h"];
            $scale = $thumb_width/$w;
            $_POST['newfile'] = str_replace('..', '', $_POST['newfile']);
            if (strpos($_POST['newfile'],"avatar_{$_SESSION['member_id']}_new.") !== 0) {
                redirect('index.php?controller=member_information&action=avatar');
            }
            $src = BASE_UPLOAD_PATH.DS.ATTACH_AVATAR.DS.$_POST['newfile'];
            $avatarfile = BASE_UPLOAD_PATH.DS.ATTACH_AVATAR.DS."avatar_{$_SESSION['member_id']}.jpg";

			import('function.thumb');
			$cropped = resize_thumb($avatarfile, $src,$w,$h,$x1,$y1,$scale);
            @unlink($src);
            Model('member')->editMember(array('member_id'=>$_SESSION['member_id']),array('member_avatar'=>'avatar_'.$_SESSION['member_id'].'.jpg'));
            $_SESSION['avatar'] = 'avatar_'.$_SESSION['member_id'].'.jpg';
            redirect('index.php?controller=member_information&action=avatar');
        }
    }

    /**
     * 绑定信息
     *
     * @param
     * @return
     */
    public function avatarOp() {
        Language::read('member_home_member');
        $lang   = Language::getLangContent();
        $member_info = $this->member_info;
        $member_info['security_level'] = Model('member')->getMemberSecurityLevel($member_info);

        self::profile_menu('member','bindinfo');
        Tpl::output('member_info',$member_info);

        Tpl::showpage('member_profile.avatar');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type,$menu_key='') {
        $menu_array     = array();
        switch ($menu_type) {
            case 'member':
                $menu_array = array(
                1=>array('menu_key'=>'member',  'menu_name'=>Language::get('home_member_base_infomation'),'menu_url'=>'index.php?controller=member_information&action=member'),
                2=>array('menu_key'=>'detail',  'menu_name'=>Language::get('home_member_detail'),'menu_url'=>'index.php?controller=member_information&action=detail'),
                3=>array('menu_key'=>'bindinfo',  'menu_name'=>'绑定信息','menu_url'=>'index.php?controller=member_information&action=avatar'),
                );
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }

    /**
     * 身份证照片ajax上传
     */
    public  function  ajaxPicUploadOp()
    {
        if (chksubmit()){
            //上传图片
            $upload = new AliOssUpload();
            $upload->set('thumb_width', 500);
            $upload->set('thumb_height',350);
//            $ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
            $upload->set('file_name',"idcard_".$_POST['type'].($_SESSION['member_id']?$_SESSION['member_id']:time().rand(100,999)).".jpg");
            $upload->set('thumb_ext','_new');
            $upload->set('ifremove',true);
            $upload->set('default_dir',ATTACH_AVATAR);
            if (!empty($_FILES['pic']['tmp_name'])){
                $result = $upload->upfile('pic');
                if ($result){
                    $img_path = $upload->getSysSetPath() . $upload->file_name;
                    $text = '@watermark=2&text='.$this->urlsafe_b64encode('仅限海吉壹百实名认证').'&color=I0ZGRkZGRg&s=50&t=90&p=6&x=10&voffset=20';//水印文字
                    exit(json_encode(array('status'=>1,'msg'=>$img_path,'text'=>$text),JSON_UNESCAPED_SLASHES));
                }else{
                    exit(json_encode(array('status'=>0,'msg'=>$upload->error)));
                }
            }
        }
    }
    public function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
}
