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

class stat_store_saleControl extends SystemControl
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
        Tpl::output('search_arr', $this->search_arr);
    }

    public function indexOp()
    {
        Tpl::setDirquna('shop');
        $get_type                            = $_GET['get_type'];
        $user_consumption_sale_log_day_model = new user_consumption_sale_log_dayModel();
        $type                                = $user_consumption_sale_log_day_model::LOG_TYPE_STORE_SALE;
        $field                               = 'user_id,user_level_id,sum(total_money) as total_money,created_at';
        $member_model                        = new memberModel();
        $store_model                         = new storeModel();
        // 如果需要单个会员的信息
        $store_name = trim($_GET['store_name']);
        if ($store_name != '') {
            // 获取供应商账户的member_id
            $this_store_info = $store_model->where(['store_name' => ['like', $store_name . '%']])->field('member_id')->select();
            if (!empty($this_store_info)) {
                $get_store_id_arr = array_column($this_store_info, 'member_id');
                $where['user_id'] = ['in', $get_store_id_arr];
            } else {
                $where['user_id'] = -1;
            }
        }

//        隐藏默认时间
//        $begin_day = date("Y-m-d H:i:s", strtotime(date('Y-m-d'))); // 今天的开始时间
//        $end_day = date("Y-m-d H:i:s", strtotime("+1 day", strtotime(date('Y-m-d')))-1);    // 今天的结束时间
        $search_time = $_GET['search_time'];    // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        }
        if (isset($begin_day) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }
        $where['type'] = $type;
        $page          = 15;
        $lists         = $user_consumption_sale_log_day_model->where($where)->field($field)->page($page)->group('user_id')->select();

        // 获取这一页的供应商信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'user_id');
            $user_id_info_arr        = $store_model->where(['member_id' => ['in', $user_id_arr]])->field('store_id,member_id,store_name,seller_name,store_company_name')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['store_id']    = $user_id_info_arr_for_id[$consumption_list['user_id']]['store_id'];
                $new_list[$key]['store_name']  = $user_id_info_arr_for_id[$consumption_list['user_id']]['store_name'];
                $new_list[$key]['seller_name'] = $user_id_info_arr_for_id[$consumption_list['user_id']]['seller_name'];
                $new_list[$key]['total_money'] = $consumption_list['total_money'];
                $new_list[$key]['created_at']  = $consumption_list['created_at'];
            }
        }

        if ($get_type == 'xml') {
            $data             = [];
            $data['now_page'] = $user_consumption_sale_log_day_model->shownowpage();
            //$data['total_num'] = $user_consumption_sale_log_day_model->gettotalnum();
            //TODO user_id去重，待优化
            $total_num         = $user_consumption_sale_log_day_model->where($where)->field("user_id")->group("user_id")->select();
            $data['total_num'] = count($total_num);
            $data['list']      = $new_list;
            echo Tpl::flexigridXML($data);
            die;
        }

        if ($_GET['exporttype'] == 'excel') {
            //获取全部店铺结账数据
            //导出Excel
            import('libraries.excel');
            $excel_obj  = new Excel();
            $excel_data = [];
            //设置样式
            $excel_obj->setStyle(['id' => 's_title', 'Font' => ['FontName' => '宋体', 'Size' => '12', 'Bold' => '1']]);
            //header
            $excel_data[0][0] = ['styleid' => 's_title', 'data' => '供应商ID'];
            $excel_data[0][1] = ['styleid' => 's_title', 'data' => '供应商名称'];
            $excel_data[0][2] = ['styleid' => 's_title', 'data' => '供应商账户'];
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '销售金额'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '创建时间'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['store_id']];
                $excel_data[$k + 1][1] = ['data' => $v['store_name']];
                $excel_data[$k + 1][2] = ['data' => $v['seller_name']];
                $excel_data[$k + 1][3] = ['data' => $v['total_money']];
                $excel_data[$k + 1][4] = ['data' => $v['created_at']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('供应商销售统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('供应商销售统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }
        Tpl::showpage('stat/stat_store_sale');
    }
}
