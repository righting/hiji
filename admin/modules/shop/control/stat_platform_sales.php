<?php
/**
 * 统计管理（销量分析）
 *
 * @海吉壹佰提供技术支持 授权请申请
 *
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stat_platform_salesControl extends SystemControl
{
    private $links = [
        ['url' => 'controller=stat_trade&action=income', 'lang' => 'stat_sale_income'],
        ['url' => 'controller=stat_trade&action=predeposit', 'lang' => 'stat_predeposit'],
        ['url' => 'controller=stat_trade&action=sale', 'lang' => 'stat_sale']
    ];

    private $search_arr;//处理后的参数

    public function __construct()
    {
        parent::__construct();
        Language::read('stat');
        import('function.statistics');
        import('function.datehelper');
        $model = Model('stat');
        //存储参数
        $this->search_arr = $_REQUEST;
        //处理搜索时间
        $this->search_arr = $model->dealwithSearchTime($this->search_arr);
        // 获得系统年份
        $year_arr = getSystemYearArr();
        // 获得系统月份
        $month_arr = getSystemMonthArr();
        // 获得本月的周时间段
        $week_arr = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
        Tpl::output('year_arr', $year_arr);
        Tpl::output('month_arr', $month_arr);
        Tpl::output('week_arr', $week_arr);
        Tpl::output('search_arr', $this->search_arr);
    }

    public function indexOp()
    {
        Tpl::setDirquna('shop');
        $get_type = $_GET['get_type'];

        $member_model = new memberModel();

        // 如果需要单个会员的信息
        $member_name = trim($_GET['member_name']);
        $where       = [];
        if ($member_name != '') {
            // 获取会员账户的member_id
            $this_member_info = $member_model->where(['member_name' => ['like', $member_name . '%']])->field('member_id')->select();
            if (!empty($this_member_info)) {
                $get_member_id_arr = array_column($this_member_info, 'member_id');
                $where['user_id']  = ['in', $get_member_id_arr];
            } else {
                $where['user_id'] = -1;
            }
        }

        $search_time = trim($_GET['search_time']);// 高级搜索日期范围
        if ($search_time != '') {
            $date_range          = explode('~', $search_time);
            $begin_date          = trim($date_range[0]);
            $begin_day           = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date            = trim($date_range[1]);
            $end_day             = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }

        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();

        $field          = 'type,sum(total_money) as total_money';
        $lists          = $user_consumption_sale_log_day_model->where($where)->field($field)->group('type')->select();
        $type_and_money = array_combine(array_column($lists, 'type'), array_column($lists, 'total_money'));

        //用户个人消费额（普通用户和会员）消费项目包括：1、个人消费；2、升级消费；3、专项消费
        $type_and_money_for_one = 0;

        //个人消费
        if (isset($type_and_money[1])) {
            $type_and_money_for_one = bcadd($type_and_money_for_one, $type_and_money[1], 2);
        }

        //升级消费
        if (isset($type_and_money[4])) {
            $type_and_money_for_one = bcadd($type_and_money_for_one, $type_and_money[4], 2);
        }

        //专项消费
        if (isset($type_and_money[5])) {
            $type_and_money_for_one = bcadd($type_and_money_for_one, $type_and_money[5], 2);
        }

        $total_money_array = $type_and_money;

        if (isset($total_money_array[1])) {
            unset($total_money_array[1]);
        }

        if (isset($total_money_array[4])) {
            unset($total_money_array[4]);
        }

        if (isset($total_money_array[5])) {
            unset($total_money_array[5]);
        }

        //$total_money    = array_sum($type_and_money);
        $total_money = array_sum($total_money_array);

        Tpl::output('type_and_money', $type_and_money);
        Tpl::output('type_and_money_for_one', $type_and_money_for_one);//用户个人消费额（普通用户和会员）
        Tpl::output('total_money', sprintf("%.2f", $total_money));//平台总销售额


        $setting_model                = new settingModel();
        $platform_tax_rate            = $setting_model->where(['name' => 'PLATFORM_TAX_RATE'])->find();// 税率
        $user_consumption_bonus_ratio = $setting_model->where(['name' => 'USER_CONSUMPTION_BONUS_RATIO'])->find();// 个人消费分红比例

        // 获取平台总利润
        $goods_after_tax_profit_log   = new goods_after_tax_profit_logModel();
        $goods_after_tax_profit_info  = $goods_after_tax_profit_log->where($where)->field('sum(money) as goods_after_tax_profit_money,sum(total_money) as total_money')->find();
        $goods_after_tax_profit_money = ($goods_after_tax_profit_info['goods_after_tax_profit_money'] > 0) ? $goods_after_tax_profit_info['goods_after_tax_profit_money'] : 0;
        $goods_total_money            = $goods_after_tax_profit_info['total_money'] ? $goods_after_tax_profit_info['total_money'] : 0;
        Tpl::output('goods_after_tax_profit_money', sprintf("%.2f", $goods_total_money * ((100 - $platform_tax_rate['value']) / 100)));//平台税后总利润
        Tpl::output('goods_total_money', $goods_total_money);//平台总利润

        /*$user_bonus_log             = new user_bonus_logModel();
        $bonus_log_where            = $where;
        $bonus_log_where['user_id'] = ['neq', '1'];
        //$bonus_log_where['type']    = ['neq', '17'];
        $bonus_log_where['type'] = [['neq', 13], ['neq', 14], ['neq', 17], 'and'];//不包括货款、运费及个人消费分红
        $user_bonus_log_info     = $user_bonus_log->where($bonus_log_where)->field('sum(money) as money')->find();
        $user_bonus_money        = $user_bonus_log_info['money'] ? $user_bonus_log_info['money'] : 0;*/
        $user_bonus_money = sprintf("%.2f", $goods_total_money * ((100 - $platform_tax_rate['value']) / 100) * ((100 - $user_consumption_bonus_ratio['value']) / 100));
        Tpl::output('user_bonus_money', $user_bonus_money);//平台分红总金额

        if ($get_type == 'json') {
            $return['type_and_money_for_one']       = $type_and_money_for_one;//用户个人消费额（普通用户和会员）
            $return['type_and_money_for_two']       = isset($type_and_money[2]) ? $type_and_money[2] : 0;//个人微商店铺销售额
            $return['type_and_money_for_three']     = isset($type_and_money[3]) ? $type_and_money[3] : 0;//供应商销售额
            $return['total_money']                  = $total_money;//平台总销售额
            $return['goods_total_money']            = $goods_total_money;//平台总利润
            $return['user_bonus_money']             = $user_bonus_money;//平台分红总金额
            $return['goods_after_tax_profit_money'] = $goods_after_tax_profit_money;//平台税后总利润
            echo json_encode($return);
            die;
        }
        Tpl::showpage('stat/stat_platform_sales');
    }

    /**
     * 平台总销售额
     */
    public function get_xmlOp()
    {
        // 设置页码参数名称
        $condition = [];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = ['like', '%' . $_POST['query'] . '%'];
        }

        $page = $_POST['rp'];

        $model   = Model('user_consumption_sale_log_day');
        $getInfo = $model->page($page)->order('created_at desc')->select();

        $data              = [];
        $data['now_page']  = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        $memberMode        = Model('member');
        foreach ($getInfo as $value) {
            $param                  = [];
            $param['user_id']       = $value['user_id'];
            $userName               = $memberMode->where(['member_id' => $value['user_id']])->field('member_name,member_number')->find();
            $param['member_number'] = $userName['member_number'];
            $param['member_name']   = $userName['member_name'];
            switch ($value['type']) {
                case 1:
                    $typeName = "消费";
                    break;
                case 2:
                    $typeName = "个人销售";
                    break;
                case 3:
                    $typeName = "店铺销售";
                    break;
                default :
                    $typeName = "消费";
            }
            $param['type']              = $typeName;
            $param['total_money']       = $value['total_money'];
            $param['created_at']        = !empty($value['created_at']) ? $value['created_at'] : '';
            $data['list'][$value['id']] = $param;
        }
        echo Tpl::flexigridXML($data);
        exit();
    }

    /**
     * 平台总利润
     */
    public function get_xml_bOp()
    {
        // 设置页码参数名称
        $condition = [];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = ['like', '%' . $_POST['query'] . '%'];
        }

        $page = $_POST['rp'];

        $model     = new  goods_after_tax_profit_logModel();
        $getInfo   = $model->page($page)->order('updated_at desc')->select();
        $order_ids = array_column($getInfo, 'order_id');

        $order_condition['order_id']    = ['in', $order_ids];
        $order_condition['order_state'] = ['eq', 50];// 解冻后的订单

        $order_model = new orderModel();
        $order_info  = $order_model->field('goods_amount,order_amount,shipping_fee')->where($order_condition)->select();

        $goods_model = new goodsModel();

        $data              = [];
        $data['now_page']  = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($getInfo as $key => $value) {
            $goods_info = $goods_model->field('goods_costprice')->where(['goods_id' => ['eq', $value['goods_id']]])->find();

            $param                      = [];
            $param['order_id']          = $value['order_id'];
            $param['order_sn']          = $value['order_sn'];
            $param['order_amount']      = $order_info[$key]['order_amount'];
            $param['shipping_fee']      = $order_info[$key]['shipping_fee'] == 0 ? 0 : $order_info[$key]['shipping_fee'];
            $param['goods_costprice']   = $goods_info['goods_costprice'];
            $param['money']             = sprintf("%.2f", ($param['order_amount'] - $param['goods_costprice'] - $param['shipping_fee']));
            $param['updated_at']        = !empty($value['updated_at']) ? $value['updated_at'] : '';
            $data['list'][$value['id']] = $param;
        }

        echo Tpl::flexigridXML($data);
        exit();
    }

    /**
     * 平台税后总利润
     */
    public function get_xml_cOp()
    {
        // 设置页码参数名称
        $condition = [];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = ['like', '%' . $_POST['query'] . '%'];
        }

        $page = $_POST['rp'];

        $model     = new  goods_after_tax_profit_logModel();
        $getInfo   = $model->page($page)->order('updated_at desc')->select();
        $order_ids = array_column($getInfo, 'order_id');

        $order_condition['order_id']    = ['in', $order_ids];
        $order_condition['order_state'] = ['eq', 50];// 解冻后的订单

        $order_model = new orderModel();
        $order_info  = $order_model->field('goods_amount,order_amount,shipping_fee')->where($order_condition)->select();

        $setting_model     = new settingModel();
        $platform_tax_rate = $setting_model->where(['name' => 'PLATFORM_TAX_RATE'])->find();// 税率

        $goods_model = new goodsModel();

        $data              = [];
        $data['now_page']  = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($getInfo as $key => $value) {
            $goods_info = $goods_model->field('goods_costprice')->where(['goods_id' => ['eq', $value['goods_id']]])->find();

            $param                            = [];
            $param['order_id']                = $value['order_id'];
            $param['order_sn']                = $value['order_sn'];
            $param['order_amount']            = $order_info[$key]['order_amount'];
            $param['shipping_fee']            = $order_info[$key]['shipping_fee'] == 0 ? 0 : $order_info[$key]['shipping_fee'];
            $param['goods_costprice']         = $goods_info['goods_costprice'];
            $param['platform_tax_rate']       = $platform_tax_rate['value'] . '%';
            $param['platform_tax_rate_money'] = sprintf("%.2f", ($param['order_amount'] - $param['goods_costprice'] - $param['shipping_fee']) * ($platform_tax_rate['value'] / 100));
            $param['money']                   = sprintf("%.2f", ($param['order_amount'] - $param['goods_costprice'] - $param['shipping_fee']) * ((100 - $platform_tax_rate['value']) / 100));
            $param['updated_at']              = !empty($value['updated_at']) ? $value['updated_at'] : '';
            $data['list'][$value['id']]       = $param;
        }

        echo Tpl::flexigridXML($data);
        exit();
    }

    /**
     * 平台分红总金额
     */
    public function get_xml_dOp()
    {
        // 设置页码参数名称
        $condition = [];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = ['like', '%' . $_POST['query'] . '%'];
        }

        $page = $_POST['rp'];

        $model     = new  goods_after_tax_profit_logModel();
        $getInfo   = $model->page($page)->order('updated_at desc')->select();
        $order_ids = array_column($getInfo, 'order_id');

        $order_condition['order_id']    = ['in', $order_ids];
        $order_condition['order_state'] = ['eq', 50];// 解冻后的订单

        $order_model = new orderModel();
        $order_info  = $order_model->field('goods_amount,order_amount,shipping_fee')->where($order_condition)->select();

        $setting_model                = new settingModel();
        $platform_tax_rate            = $setting_model->where(['name' => 'PLATFORM_TAX_RATE'])->find();// 税率
        $user_consumption_bonus_ratio = $setting_model->where(['name' => 'USER_CONSUMPTION_BONUS_RATIO'])->find();// 个人消费分红比例

        $goods_model = new goodsModel();

        $data              = [];
        $data['now_page']  = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($getInfo as $key => $value) {
            $goods_info = $goods_model->field('goods_costprice')->where(['goods_id' => ['eq', $value['goods_id']]])->find();

            $param                                     = [];
            $param['order_id']                         = $value['order_id'];
            $param['order_sn']                         = $value['order_sn'];
            $param['order_amount']                     = $order_info[$key]['order_amount'];
            $param['shipping_fee']                     = $order_info[$key]['shipping_fee'] == 0 ? 0 : $order_info[$key]['shipping_fee'];
            $param['goods_costprice']                  = $goods_info['goods_costprice'];
            $param['platform_tax_rate']                = $platform_tax_rate['value'] . '%';
            $param['platform_tax_rate_money']          = sprintf("%.2f", ($param['order_amount'] - $param['goods_costprice'] - $param['shipping_fee']) * ($platform_tax_rate['value'] / 100));
            $param['money']                            = sprintf("%.2f", ($param['order_amount'] - $param['goods_costprice'] - $param['shipping_fee']) * ((100 - $platform_tax_rate['value']) / 100));
            $param['user_consumption_bonus_ratio']     = $user_consumption_bonus_ratio['value'] . '%';
            $param['user_consumption_bonus_money']     = sprintf("%.2f", $param['money'] * ($user_consumption_bonus_ratio['value'] / 100));
            $param['platform_consumption_bonus_money'] = sprintf("%.2f", $param['money'] - $param['user_consumption_bonus_money']);
            $param['updated_at']                       = !empty($value['updated_at']) ? $value['updated_at'] : '';
            $data['list'][$value['id']]                = $param;
        }

        echo Tpl::flexigridXML($data);
        exit();
    }
}
