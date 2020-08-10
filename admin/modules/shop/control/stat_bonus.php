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

class stat_bonusControl extends SystemControl
{
    private function getTopLinks()
    {
        $links = [
            ['url' => urlAdminShop('stat_bonus', 'index', ['bonus_type' => 17]), 'text' => '个人消费分红'], // 个人消费分红
            ['url' => urlAdminShop('stat_bonus', 'index', ['bonus_type' => 18]), 'text' => '团队/消费共享分红'], // 团队/消费共享分红
            ['url' => urlAdminShop('stat_bonus', 'index', ['bonus_type' => 19]), 'text' => '个人微商/消费共享分红'], // 个人微商/消费共享分红
            ['url' => urlAdminShop('stat_bonus', 'index', ['bonus_type' => 9]), 'text' => '消费新人奖'], // 消费新人奖
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
        $get_type             = $_GET['get_type'];
        $user_bonus_log_model = new user_bonus_logModel();
        $field                = 'user_id,sum(money) as total_money,created_at';
        $member_model         = new memberModel();
        // 如果需要单个会员的信息
        $member_name = trim($_GET['member_name']);
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

        $search_time = trim($_GET['search_time']);  // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        } else {
            $user_bonus_logic = new user_bonusLogic();
            // 获取当月开始时间
            $current_month_begin_date = $user_bonus_logic->getCurrentMonthBeginDate();
            $begin_day                = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($current_month_begin_date))));
            // 获取当月结束时间
            $current_month_end_date = $user_bonus_logic->getCurrentMonthEndDate();
            $end_day                = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($current_month_end_date))));
        }

        $type     = $user_bonus_log_model::TYPE_SALES_SHARE_BONUS;//个人消费分红
        $type_arr = $user_bonus_log_model->getLogType();
        if (isset($_GET['bonus_type']) && in_array(intval($_GET['bonus_type']), array_keys($type_arr))) {
            $type = intval($_GET['bonus_type']);
        }
        if (isset($begin_date) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }
        $where['type'] = $type;

        $page = 15;
        if ($_GET['exporttype'] == 'excel') {
            $page = !empty($where) ? $user_bonus_log_model->getCount($where) : 100000;
        }
        $lists = $user_bonus_log_model->where($where)->field($field)->page($page)->group('user_id')->order('updated_at desc')->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'user_id');
            $user_id_info_arr        = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['user_id']        = $consumption_list['user_id'];
                $new_list[$key]['member_number']  = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_number'];
                $new_list[$key]['member_name']    = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_name'];
                $new_list[$key]['total_money']    = $consumption_list['total_money'];
                $new_list[$key]['created_at']     = $consumption_list['created_at'];
                $new_list[$key]['this_type_name'] = $type_arr[$type];
                $new_list[$key]['operation']      = '<a href="' . urlAdminShop("stat_bonus", "log_info", ["user_id" => $consumption_list["user_id"], "bonus_type" => $type]) . '" class="btn green show-remark"><i class="fa fa-list-alt"></i>查看</a>';
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $user_bonus_log_model->shownowpage();
            $data['total_num'] = count($user_bonus_log_model->where($where)->field($field)->group('user_id')->select());
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
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '创建时间'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '分红类型'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['total_money']];
                $excel_data[$k + 1][4] = ['data' => $v['created_at']];
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
        Tpl::showpage('stat/stat_bonus');
    }

    public function log_infoOp()
    {
        Tpl::setDirquna('shop');
        $user_id              = intval($_GET['user_id']);
        Tpl::output('user_id', $user_id);
        $get_type             = $_GET['get_type'];
        $user_bonus_log_model = new user_bonus_logModel();
        $field                = 'user_id,money,created_at';
        $member_model         = new memberModel();
        // 如果需要单个会员的信息
        $member_name = trim($_GET['member_name']);
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

        $search_time = trim($_GET['search_time']);  // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        } else {
            $user_bonus_logic = new user_bonusLogic();
            // 获取当月开始时间
            $current_month_begin_date = $user_bonus_logic->getCurrentMonthBeginDate();
            $begin_day                = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($current_month_begin_date))));
            // 获取当月结束时间
            $current_month_end_date = $user_bonus_logic->getCurrentMonthEndDate();
            $end_day                = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($current_month_end_date))));
        }

        $type     = $user_bonus_log_model::TYPE_SALES_SHARE_BONUS;//个人消费分红
        $type_arr = $user_bonus_log_model->getLogType();
        if (isset($_GET['bonus_type']) && in_array(intval($_GET['bonus_type']), array_keys($type_arr))) {
            $type = intval($_GET['bonus_type']);
        }
        if (isset($begin_date) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }
        $where['type']    = $type;
        $where['user_id'] = $user_id;
        Tpl::output('bonus_type', $type);

        $page = 15;
        if ($_GET['exporttype'] == 'excel') {
            $page = !empty($where) ? $user_bonus_log_model->getCount($where) : 100000;
        }

        $lists = $user_bonus_log_model->where($where)->field($field)->page($page)->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'user_id');
            $user_id_info_arr        = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['user_id']        = $consumption_list['user_id'];
                $new_list[$key]['member_number']  = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_number'];
                $new_list[$key]['member_name']    = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_name'];
                $new_list[$key]['money']    = $consumption_list['money'];
                $new_list[$key]['created_at']     = $consumption_list['created_at'];
                $new_list[$key]['this_type_name'] = $type_arr[$type];
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $user_bonus_log_model->shownowpage();
            $data['total_num'] = count($user_bonus_log_model->where($where)->field($field)->group('user_id')->select());
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
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '创建时间'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '分红类型'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['money']];
                $excel_data[$k + 1][4] = ['data' => $v['created_at']];
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
        Tpl::showpage('stat/log_info');
    }
}
