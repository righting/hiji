<?php
/**
 * 商家入住
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */



defined('ByCCYNet') or exit('Access Invalid!');

class dealersControl extends BaseHomeControl {
    public function __construct() {
        parent::__construct();

        Tpl::setLayout('dealers_layout');

//        $this->checkLogin();
        //检查入驻会员条件
        $phone_array = explode(',',C('site_phone'));
        Tpl::output('phone_array',$phone_array);

        Tpl::output('show_sign','joinin');
        Tpl::output('html_title',C('site_name').' - '.'商家入驻');

        Tpl::output('article_list','');//底部不显示文章分类

    }

    public function indexOp() {
        Tpl::output('step', '1');
        Tpl::output('sub_step', 'step1');
        Tpl::showpage('dealers/index');
    }

    public function saveOp(){
        $post = $_POST;
        $name = $post['name'];
        $title = $post['title'];
        $mobile = $post['mobile'];
        $address = $post['address'];
        $affiliate_note = $post['affiliate_note'];
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$name, "require"=>"true","validator"=>"Length","min"=>"1","max"=>"16","message"=>"联系人不能为空且必须小于16个字"),
            array("input"=>$title, "require"=>"true","validator"=>"Length","min"=>"1","max"=>"50","message"=>"职级不能为空且必须小于50个字"),
            array("input"=>$mobile, "require"=>"true", 'validator'=>'mobile',"message"=>'请正确填写手机号码'),
            array("input"=>$address, "require"=>"true","validator"=>"Length","min"=>"1","max"=>"50","message"=>"请选择区域地址"),
            array("input"=>$affiliate_note, "require"=>"true","validator"=>"Length","min"=>"1","max"=>"100","message"=>"加盟说明不能为空且必须小于100字"),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            showDialog($error,'','error');
        }
        $user_ip = ip2long(getIp());
        $dealers_model = Model('dealers');
        $where['ip'] = $user_ip;
        $where['mobile'] = $mobile;
        $where['_op'] = 'OR';
        // 检查当前ip是否可以提交请求
        $list = $dealers_model->where($where)->order('created_at desc')->select();
        $now_date = date('Y-m-d H:i:s');
        if(!empty($list)){
            // 获取第一条信息
            $first_info = reset($list);
            // 每个ip 一天只能提交一次,获取第二天的开始时间
            $next_apply_date = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($first_info['created_at'])));
            // 如果当前时间小于上次提交的第二天的时间，则不能提交
            if($now_date < $next_apply_date){
                showDialog('操作频繁，请明天再试','','error');
            }
            // 检查当前手机是否已经申请过了
            $this_ip_mobile_arr = array_column($list,'mobile');
            if(in_array($mobile,$this_ip_mobile_arr)){
                showDialog('该手机已经申请过了，请耐心等待客服与您联系','','error');
            }
        }
        //  10 分钟只能提交一次
        $data['name'] = $name;
        $data['title'] = $title;
        $data['mobile'] = $mobile;
        $data['address'] = $address;
        $data['note'] = $affiliate_note;
        $data['ip'] = $user_ip;
        $data['created_at'] = $now_date;
        $data['updated_at'] = $now_date;
        $result = $dealers_model->insert($data);
        if($result){
            showDialog('提交成功,客服将尽快与您取得联系，先逛逛商城吧',urlShop('index'));die;
        }
    }
}
