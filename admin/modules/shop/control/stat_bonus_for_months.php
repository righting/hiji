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

class stat_bonus_for_monthsControl extends SystemControl
{

    private function getTopLinks()
    {
        $links = [
            ['url' => urlAdminShop('stat_bonus_for_month', 'index', ['bonus_type' => 6]), 'text' => '至尊消费月分红'], // 至尊消费月分红
            ['url' => urlAdminShop('stat_bonus_for_month', 'index', ['bonus_type' => 7]), 'text' => '销售精英月分红'], // 销售精英月分红
            ['url' => urlAdminShop('stat_bonus_for_month', 'index', ['bonus_type' => 8]), 'text' => '高层消费月分红'], // 高层消费月分红
            ['url' => urlAdminShop('stat_bonus_for_months', 'index', ['bonus_type' => 12]), 'text' => '供应商推荐奖金'], // 供应商推荐奖金
            ['url' => urlAdminShop('stat_bonus_for_month', 'index', ['bonus_type' => 21]), 'text' => '消费养老补贴'], // 消费资本补贴-消费养老补贴
            ['url' => urlAdminShop('stat_bonus_for_month', 'index', ['bonus_type' => 22]), 'text' => '车房梦想补贴'], // 消费资本补贴-车房梦想补贴
        ];
        return $links;
    }

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
        $week_arr      = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
        Tpl::output('action', $_GET['action']);
        Tpl::output('year_arr', $year_arr);
        Tpl::output('month_arr', $month_arr);
        Tpl::output('week_arr', $week_arr);
//        }
        Tpl::output('search_arr', $this->search_arr);
    }

    public function indexOp()
    {
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        $get_type              = $_GET['get_type'];
        $user_bonus_log_model  = new user_bonus_logModel();
        $user_money_pool_model = new user_money_poolModel();
        $user_bonus_logic      = new user_bonusLogic();
        $field                 = 'to_user_id,sum(money) as total_money';
        $member_model          = new memberModel();
        // 如果需要单个会员的信息
        $member_name = trim($_GET['member_name']);
        if ($member_name != '') {
            // 获取会员账户的member_id
            $this_member_info = $member_model->where(['member_name' => ['like', $member_name . '%']])->field('member_id')->select();
            if (!empty($this_member_info)) {
                $get_member_id_arr   = array_column($this_member_info, 'member_id');
                $where['to_user_id'] = ['in', $get_member_id_arr];
            } else {
                $where['to_user_id'] = -1;
            }
        }

        $begin_day   = $user_bonus_logic->getCurrentMonthBeginDate();
        $end_day     = $user_bonus_logic->getCurrentMonthEndDate();
        $search_time = $_GET['search_time'];    // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }
        $type     = $user_bonus_log_model::TYPE_BLACK_DIAMOND_SALES_BONUS;
        $type_arr = $user_bonus_log_model->getLogType();
        if (isset($_GET['bonus_type']) && in_array(intval($_GET['bonus_type']), array_keys($type_arr))) {
            $type = intval($_GET['bonus_type']);
        }
        $where['created_at'] = ['between', [$begin_day, $end_day]];
        $where['type']       = $type;
        $page                = 15;
        $lists               = $user_money_pool_model->where($where)->field($field)->page($page)->group('to_user_id')->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'to_user_id');
            $user_id_info_arr        = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['user_id']        = $consumption_list['to_user_id'];
                $new_list[$key]['member_number']  = $user_id_info_arr_for_id[$consumption_list['to_user_id']]['member_number'];
                $new_list[$key]['member_name']    = $user_id_info_arr_for_id[$consumption_list['to_user_id']]['member_name'];
                $new_list[$key]['total_money']    = $consumption_list['total_money'];
                $new_list[$key]['date_range']     = implode('-', [$begin_day, $end_day]);
                $new_list[$key]['this_type_name'] = $type_arr[$type];
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $user_money_pool_model->shownowpage();
            $data['total_num'] = count($user_money_pool_model->where($where)->field($field)->group('to_user_id')->select());
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
            $excel_data[0][0] = ['styleid' => 's_title', 'data' => '用户ID'];
            $excel_data[0][1] = ['styleid' => 's_title', 'data' => '邀请ID号'];
            $excel_data[0][2] = ['styleid' => 's_title', 'data' => '账户'];
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '分红金额'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '统计范围'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '分红类型'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['to_user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['total_money']];
                $excel_data[$k + 1][4] = ['data' => $v['date_range']];
                $excel_data[$k + 1][5] = ['data' => $type_arr[$type]];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset($type_arr[$type] . '统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset($type_arr[$type] . '统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }

        Tpl::output('top_link', $this->newSubLink($this->getTopLinks(), $type));
        Tpl::output('this_type_name', $type_arr[$type]);
        Tpl::output('this_type', $type);
        Tpl::showpage('stat/stat_bonusa');
    }
}
