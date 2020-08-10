<?php
/**
 * 平台利润表
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */


defined('ByCCYNet') or exit('Access Invalid!');

class get_platform_profitControl extends SystemControl
{

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
//        if (in_array($_REQUEST['action'],array('sale_trend','get_sale_xml','get_plat_sale'))){
        $this->search_arr = $model->dealwithSearchTime($this->search_arr);
        // 获得系统年份
        $year_arr = getSystemYearArr();
        //
        // 获得系统月份
        $month_arr = getSystemMonthArr();
        // 获得本月的周时间段
        $week_arr = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
        Tpl::output('year_arr', $year_arr);
        Tpl::output('month_arr', $month_arr);
        Tpl::output('week_arr', $week_arr);
//        }
        Tpl::output('search_arr', $this->search_arr);
    }

//    平台历史总提成
    public function indexOp()
    {
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        $get_type = $_GET['get_type'];
        $platform_profit_model = Model('platform_profit');
        $field = 'id,sum(money) as money,type,change_type,created_at,updated_at,order_id,order_sn,remark';
        $search_time = $_GET['search_time'];    // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date = trim($date_range[1]);
            $end_day = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        }
        if (isset($begin_day) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];

        }
        $where['change_type'] =1;
        $page = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        $lists = $platform_profit_model
            ->where($where)
            ->field($field)
            ->page($page_size)
            ->order("created_at desc")
            ->group('order_id')
            ->select();

        // 获取这一页的用户信息
        $new_list = [];
        if(!empty($lists)){
            foreach ($lists as $key=>$consumption_list){
                $new_list[$key]['order_sn'] = $consumption_list['order_sn'];
                $new_list[$key]['money'] = $consumption_list['money'];
                $new_list[$key]['type'] = $platform_profit_model->get_profit_resouce($consumption_list['type']);
                $new_list[$key]['created_at'] = $consumption_list['created_at'];
                $new_list[$key]['updated_at'] = $consumption_list['updated_at'];
                $new_list[$key]['operation'] = '<a href="'.urlAdminShop("order","show_order",["order_id"=>$consumption_list["order_id"]]).'" class="btn green show-remark"><i class="fa fa-list-alt"></i>查看订单</a>';
                unset($this_remark_str);
            }
        }

        if($get_type == 'xml'){
            $data = array();
            $data['now_page'] = $page;
            $data['total_num'] = count($platform_profit_model->where($where)->field($field)->group("order_id")->select());
            $data['list'] = $new_list;
//            print_r($data);exit;
            echo Tpl::flexigridXML($data);die;
        }


        Tpl::showpage('get_platform_profit/index');
    }

}
