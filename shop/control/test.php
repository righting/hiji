<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2
 * Time: 16:35
 */
class testControl extends Control
{
    const PAGESIZE=20;
    function curl_post($url, $post) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function newuserOp(){
        $web_code_model = Model('web_code');
        $list = $web_code_model->where(['web_id'=>620])->field('code_type,var_name,show_name')->select();
        $web_id_arr = [625,626,627,628,629,630,631,632,633];
        $add_data = [];
        foreach ($web_id_arr as $web_id){
            foreach ($list as $k=>$v){
                $add_data[$web_id.'_'.$k]['web_id'] = $web_id;
                $add_data[$web_id.'_'.$k]['code_type'] = $v['code_type'];
                $add_data[$web_id.'_'.$k]['var_name'] = $v['var_name'];
                $add_data[$web_id.'_'.$k]['show_name'] = $v['show_name'];
            }
        }
        $new_add_data = array_values($add_data);
        $web_code_model->insertAll($new_add_data);
        print_r($add_data);die;
//    die;
//        $invite = Model('register_invite')->field('depth')->where(['to_user_id'=>104])->find();
//        $register_invite_data['depth'] = intval($invite['depth'])+1;
//        var_dump($register_invite_data);exit;
//        ini_set('max_execution_time', '0');
//        for($i=69;$i<=502;$i++){
//            $data = $this->curl_post(urlMember('login','usersave',['inajax'=>1]), array('user_name'=>'auto'.$i,
//                'password'=>'123456',
//                'password_confirm'=>'123456',
//                'email'=>'email'.$i.'@163.com',
//                'form_submit'=>'ok'
//            ));
//            var_dump($data);
//        }
//        exit("运行结束");
        /*升级会员*/
        //产生会员关系
//      $member_data = Model()->query("select member_id from member");
//      array_pop($member_data)['member_id'];
//      $d = date('Y-m-d H:i:s',time());
//        $i=0;
//      while ($i<=8){
//          $arrs = [];
//
//          $sql="select to_user_id from register_invite where depth=".$i;
//          ++$i;
//         $invite = Model()->query($sql);
//            foreach ($invite as $v){
//                    for($m=0;$m<3;$m++){
//                     $s = array_pop($member_data)['member_id'];
//                     if (!empty($s)){
//                         $arrs[] =['from_user_id'=>$v['to_user_id'],'to_user_id'=>$s,'register_at'=>$d,'depth'=>$i];
//                     }
//                    }
//                    if (count($member_data)==0){
//                        break;
//                    }
//            }
//            if (!empty($arrs)){
//                Model('register_invite')->insertALL($arrs);
//            }
//          if (count($member_data)==0){
//              break;
//          }
//      }


exit;
    }

    public function indexOp()
    {
        Tpl::setLayout('null_layout');
        Tpl::setDir('home');
        Language::read('home_index_index');
        Tpl::output('index_sign', 'index');      // 设置头部导航栏当前选中的位置

        //特卖专区
        Language::read('member_groupbuy');
        $model_groupbuy = Model('groupbuy');
        $group_list = $model_groupbuy->getGroupbuyCommendedList(4);
        Tpl::output('group_list', $group_list);

        //专题获取

        $model_special = Model('cms_special');
        $conition = array();
        $special_list = $model_special->getShopindexList($conition);
        Tpl::output('special_list', $special_list);

        //限时折扣
        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_item = $model_xianshi_goods->getXianshiGoodsCommendList(6);
        Tpl::output('xianshi_item', $xianshi_item);

        //直达楼层信息
        if (C('ccynet_lc') != '') {
            $lc_list = @unserialize(C('ccynet_lc'));
        }
        Tpl::output('lc_list', is_array($lc_list) ? $lc_list : array());

        //首页推荐词链接
        if (C('ccynet_rc') != '') {
            $rc_list = @unserialize(C('ccynet_rc'));
        }
        Tpl::output('rc_list', is_array($rc_list) ? $rc_list : array());

        //推荐品牌
        $brand_r_list = Model('brand')->getBrandPassedList(array('brand_recommend' => 1), 'brand_id,brand_name,brand_pic,brand_xbgpic,brand_tjstore', 0, 'brand_sort asc, brand_id desc', 4);
        Tpl::output('brand_r', $brand_r_list);


        //评价信息
        $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsList(8);
        Tpl::output('goods_evaluate_info', $goods_evaluate_info);

        //板块信息
        $model_web_config = Model('web_config');
        $web_html = $model_web_config->getWebHtml('index');
        Tpl::output('web_html', $web_html);
        Model('seo')->type('index')->show();
        Tpl::showpage('test/new_index');
    }

    public function beginBonusOp(){
    die;
        $user_bonus_logic = Logic('user_bonus');
        $user_bonus_logic->statisticalShareDayBonus();
    }

    public function bonusOp()
    {
        Tpl::setLayout('null_layout');
        Tpl::setDir('home');
        // 获取用户信息
        $member_model = Model('member');
        $member_list = $member_model->field('member_id,member_name,level_id,positions_id')->select();
        // 获取职级信息
        $position_model = Model('positions');
        $positions_info_arr = $position_model->select();
        $positions_info = array_combine(array_column($positions_info_arr, 'id'), array_column($positions_info_arr, 'title'));
        // 获取会员等级信息
        $user_level_model = Model('user_level');
        $user_level_info_arr = $user_level_model->select();
        $user_level_info = array_combine(array_column($user_level_info_arr, 'level'), array_column($user_level_info_arr, 'level_name'));

        Tpl::output('member_list', $member_list);
        Tpl::output('positions_info', $positions_info);
        Tpl::output('user_level_info', $user_level_info);
        Tpl::showpage('test/bonus_index');
    }

    public function addBonusInfoOp()
    {
        $post = $_POST;
        $user_bonus_logic = Logic('user_bonus');
        // 平台上个月总利润
        $last_month_total_money = $post['last_month_total_money'];
        $platform_profit_model = Model('platform_profit');
        $platform_profit_last_month_data['user_id'] = 0;
        $platform_profit_last_month_data['money'] = $last_month_total_money;
        $platform_profit_last_month_data['type'] = 1;
        $platform_profit_last_month_data['change_type'] = 1;
        $platform_profit_last_month_data['created_at'] = $user_bonus_logic->getLastMonthMiddleMonthDate();
        $platform_profit_last_month_data['order_id'] = 0;
        $platform_profit_last_month_data['remark'] = '测试添加平台上个月总利润';
        $platform_profit_last_month_data['admin_id'] = 0;
        $platform_profit_model->insert($platform_profit_last_month_data);


        // 平台上周总利润
        $last_weekly_total_money = $post['last_weekly_total_money'];
        $platform_profit_last_weekly_data['user_id'] = 0;
        $platform_profit_last_weekly_data['money'] = $last_weekly_total_money;
        $platform_profit_last_weekly_data['type'] = 1;
        $platform_profit_last_weekly_data['change_type'] = 1;
        $platform_profit_last_weekly_data['created_at'] = date("Y-m-d H:i:s", strtotime("-1 week", strtotime(date('Y-m-d H:i:s'))));
        $platform_profit_last_weekly_data['order_id'] = 0;
        $platform_profit_last_weekly_data['remark'] = '测试添加平台上周总利润';
        $platform_profit_last_weekly_data['admin_id'] = 0;
        $platform_profit_model->insert($platform_profit_last_weekly_data);


        // 平台昨天的总利润
        $yesterday_total_money = $post['yesterday_total_money'];
        $platform_profit_yesterday_data['user_id'] = 0;
        $platform_profit_yesterday_data['money'] = $yesterday_total_money;
        $platform_profit_yesterday_data['type'] = 1;
        $platform_profit_yesterday_data['change_type'] = 1;
        $platform_profit_yesterday_data['created_at'] = date("Y-m-d H:i:s", strtotime("-1 day", strtotime(date('Y-m-d H:i:s'))));
        $platform_profit_yesterday_data['order_id'] = 0;
        $platform_profit_yesterday_data['remark'] = '测试添加平台昨天的总利润';
        $platform_profit_yesterday_data['admin_id'] = 0;
        $platform_profit_model->insert($platform_profit_yesterday_data);


        $yesterday = date("Y-m-d H:i:s", strtotime("-1 day", strtotime(date('Y-m-d H:i:s'))));
        $last_weekly = date("Y-m-d H:i:s", strtotime("-1 week", strtotime(date('Y-m-d'))));
        $last_month = date("Y-m-d H:i:s", strtotime("-1 month", strtotime(date('Y-m-15'))));

        $user_consumption_sale_log_day_model = Model('user_consumption_sale_log_day');
        // 消费额
        $consumption = $post['consumption'];
        $consumption_data = [];
        $consumption_last_weekly_data = [];
        $consumption_last_month_data = [];
        foreach ($consumption as $consumption_user_id => $consumption_user_money) {
            $consumption_data[$consumption_user_id]['user_id'] = $consumption_user_id;
            $consumption_data[$consumption_user_id]['user_exp'] = 0;
            $consumption_data[$consumption_user_id]['type'] = 1;
            $consumption_data[$consumption_user_id]['total_money'] = $consumption_user_money;
            $consumption_data[$consumption_user_id]['created_at'] = $yesterday;

            $consumption_last_weekly_data[$consumption_user_id]['user_id'] = $consumption_user_id;
            $consumption_last_weekly_data[$consumption_user_id]['user_exp'] = 0;
            $consumption_last_weekly_data[$consumption_user_id]['type'] = 1;
            $consumption_last_weekly_data[$consumption_user_id]['total_money'] = $consumption_user_money;
            $consumption_last_weekly_data[$consumption_user_id]['created_at'] = $last_weekly;


            $consumption_last_month_data[$consumption_user_id]['user_id'] = $consumption_user_id;
            $consumption_last_month_data[$consumption_user_id]['user_exp'] = 0;
            $consumption_last_month_data[$consumption_user_id]['type'] = 1;
            $consumption_last_month_data[$consumption_user_id]['total_money'] = $consumption_user_money;
            $consumption_last_month_data[$consumption_user_id]['created_at'] = $last_month;
        }
        $user_consumption_sale_log_day_model->insertAll(array_values($consumption_data));
        $user_consumption_sale_log_day_model->insertAll(array_values($consumption_last_weekly_data));
        $user_consumption_sale_log_day_model->insertAll(array_values($consumption_last_month_data));

        // 销售额
        $sales_volume = $post['sales_volume'];
        $sales_volume_last_week_data = [];
        $sales_volume_data = [];
        $sales_volume_last_month_data = [];
        foreach ($sales_volume as $sales_volume_user_id => $sales_volume_user_money) {
            $sales_volume_data[$sales_volume_user_id]['user_id'] = $sales_volume_user_id;
            $sales_volume_data[$sales_volume_user_id]['user_exp'] = 0;
            $sales_volume_data[$sales_volume_user_id]['type'] = 3;
            $sales_volume_data[$sales_volume_user_id]['total_money'] = $sales_volume_user_money;
            $sales_volume_data[$sales_volume_user_id]['created_at'] = $yesterday;

            $sales_volume_last_week_data[$sales_volume_user_id]['user_id'] = $sales_volume_user_id;
            $sales_volume_last_week_data[$sales_volume_user_id]['user_exp'] = 0;
            $sales_volume_last_week_data[$sales_volume_user_id]['type'] = 3;
            $sales_volume_last_week_data[$sales_volume_user_id]['total_money'] = $sales_volume_user_money;
            $sales_volume_last_week_data[$sales_volume_user_id]['created_at'] = $last_weekly;

            $sales_volume_last_month_data[$sales_volume_user_id]['user_id'] = $sales_volume_user_id;
            $sales_volume_last_month_data[$sales_volume_user_id]['user_exp'] = 0;
            $sales_volume_last_month_data[$sales_volume_user_id]['type'] = 3;
            $sales_volume_last_month_data[$sales_volume_user_id]['total_money'] = $sales_volume_user_money;
            $sales_volume_last_month_data[$sales_volume_user_id]['created_at'] = $last_month;
        }

        $user_consumption_sale_log_day_model->insertAll(array_values($sales_volume_data));
        $user_consumption_sale_log_day_model->insertAll(array_values($sales_volume_last_week_data));
        $user_consumption_sale_log_day_model->insertAll(array_values($sales_volume_last_month_data));

        // 积分
        $point = $post['point'];
        $member_model = Model('member');
        $point_data = [];
        $sql = 'UPDATE member SET member_points = CASE member_id';
        foreach ($point as $point_user_id => $point_user_money) {
            $sql .= " WHEN " . $point_user_id . " THEN " . $point_user_money;
        }
        $sql .= ' END';
        DB::execute($sql);
        // HI值
        $hi_value = $post['hi_value'];
        $user_hi_value_model = Model('user_hi_value');
        $user_hi_value_data = [];
        foreach ($hi_value as $hi_value_user_id => $hi_value_user_value) {
            $user_hi_value_data[$hi_value_user_id]['user_id'] = $hi_value_user_id;
            $user_hi_value_data[$hi_value_user_id]['upgrade_hi'] = $hi_value_user_value;
            $user_hi_value_data[$hi_value_user_id]['recommend_team_hi'] = 0;
            $user_hi_value_data[$hi_value_user_id]['bonus_to_hi'] = 0;
        }
        $user_hi_value_model->insertAll(array_values($user_hi_value_data));

        // 新人鼓励基金
        $user_bonus_model = Model('user_bonus');
        $user_new_sales_incentive_fund = $post['hi_value'];
        $user_new_sales_incentive_fund_data = [];
        foreach ($user_new_sales_incentive_fund as $user_new_sales_incentive_fund_user_id => $user_new_sales_incentive_fund_user_value) {
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['user_id'] = $user_new_sales_incentive_fund_user_id;
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['type'] = $user_new_sales_incentive_fund_user_id;
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['begin_at'] = $user_bonus_logic->thirtyDaysAgoAt();
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['end_at'] = $user_bonus_logic->getYesterdayEndAt();
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['frequency'] = 28;
            $user_new_sales_incentive_fund_data[$user_new_sales_incentive_fund_user_id]['created_at'] = $user_bonus_logic->getCurrentMonthBeginDate();
        }
        $user_bonus_model->insertAll(array_values($user_new_sales_incentive_fund_data));
        showDialog('数据添加成功', urlShop('test', 'bonus'), 'succ');
    }


    public function wipeDataOp()
    {
        $platform_profit_model = Model('platform_profit');
        $platform_profit_model->where(['id' => ['GT', 0]])->delete();
        $user_consumption_sale_log_day_model = Model('user_consumption_sale_log_day');
        $user_consumption_sale_log_day_model->where(['id' => ['GT', 0]])->delete();
        $member_model = Model('member');
        $member_model->where(['member_id' => ['GT', 0]])->update(['member_points' => 0, 'available_predeposit' => 0, 'freeze_predeposit' => 0]);
        $user_hi_value_model = Model('user_hi_value');
        $user_hi_value_model->where(['id' => ['GT', 0]])->delete();
        $pd_log_model = Model('pd_log');
        $pd_log_model->where(['lg_id' => ['GT', 0]])->delete();
        $user_new_sales_incentive_fund_model = Model('user_new_sales_incentive_fund');
        $user_new_sales_incentive_fund_model->where(['id' => ['GT', 0]])->delete();
        $user_bonus_model = Model('user_bonus');
        $user_bonus_model->where(['id' => ['GT', 0]])->delete();
        showDialog('清除成功', urlShop('test', 'bonus'), 'succ');
    }


    //批量修改 data二维数组 field关键字段 参考ci 批量修改函数 传参方式
    function batch_update($table_name = '', $data = array(), $field = '')
    {
        if (!$table_name || !$data || !$field) {
            return false;
        } else {
            $sql = 'UPDATE ' . $table_name;
        }
        $con = array();
        $con_sql = array();
        $fields = array();
        foreach ($data as $key => $value) {
            $x = 0;
            foreach ($value as $k => $v) {
                if ($k != $field && !$con[$x] && $x == 0) {
                    $con[$x] = " set {$k} = (CASE {$field} ";
                } elseif ($k != $field && !$con[$x] && $x > 0) {
                    $con[$x] = " {$k} = (CASE {$field} ";
                }
                if ($k != $field) {
                    $temp = $value[$field];
                    $con_sql[$x] .= " WHEN '{$temp}' THEN '{$v}' ";
                    $x++;
                }
            }
            $temp = $value[$field];
            if (!in_array($temp, $fields)) {
                $fields[] = $temp;
            }
        }
        $num = count($con) - 1;
        foreach ($con as $key => $value) {
            foreach ($con_sql as $k => $v) {
                if ($k == $key && $key < $num) {
                    $sql .= $value . $v . ' end),';
                } elseif ($k == $key && $key == $num) {
                    $sql .= $value . $v . ' end)';
                }
            }
        }
        $str = implode(',', $fields);
        $sql .= " where {$field} in({$str})";
//        $res = M($table_name)->execute($sql);
//        return $res;
        return $sql;
    }

//测试
    function testOp()
    {
        $update_array = array();
        for ($i = 2; $i < 7; $i++) {
            $data = array();
            $data['id'] = $i;
            $data['memeber_type'] = $i;
            $data['memeber_type_state'] = $i;
            $update_array[] = $data;
        }
        $res = $this->batch_update('yl_member', $update_array, 'id');
        echo $res;
    }

    public function get_statisticsOp(){
        $logic = Logic('user_bonus');
        $result = $logic->statisticsGaragesDream();
        print_r($result);die;
    }
}