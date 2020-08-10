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

class stat_bonus_logControl extends SystemControl
{

    private function getTopLinks()
    {
        $links = [
            ['url' => urlAdminShop('stat_bonus_for_day', 'index', ['bonus_type' => 1]), 'text' => '消费日分红'], // 消费日分红
            ['url' => urlAdminShop('stat_bonus_for_day', 'index', ['bonus_type' => 2]), 'text' => '消费明星日分红'], // 消费明星日分红
            ['url' => urlAdminShop('stat_bonus_for_day', 'index', ['bonus_type' => 10]), 'text' => '共享日分红'], // 共享日分红
        ];
        return $links;
    }

    private $search_arr;//处理后的参数
    private $bonus_type = 0;

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
        //if (in_array($_REQUEST['action'],array('sale_trend','get_sale_xml','get_plat_sale'))){
        $this->search_arr = $model->dealwithSearchTime($this->search_arr);
        // 获得系统年份
        $year_arr = getSystemYearArr();
        //
        // 获得系统月份
        $month_arr = getSystemMonthArr();
        // 获得本月的周时间段
        $week_arr         = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
        $this->bonus_type = isset($_GET['bonus_type']) ? intval($_GET['bonus_type']) : 0;
        $user_bonus_model = new user_bonusModel();
        $user_bonus_type  = $user_bonus_model->getTypeInfo();
        Tpl::output('user_bonus_type', $user_bonus_type);
        Tpl::output('bonus_type', $this->bonus_type);
        Tpl::output('year_arr', $year_arr);
        Tpl::output('month_arr', $month_arr);
        Tpl::output('week_arr', $week_arr);
        //}
        Tpl::output('search_arr', $this->search_arr);
    }

    public function indexOp()
    {
        Tpl::setDirquna('shop');
        $get_type             = $_GET['get_type'];
        $user_bonus_log_model = new user_bonus_logModel();
        $field                = 'id,user_id,type,money,created_at,updated_at,order_id,order_sn,goods_id';
        $member_model         = new memberModel();
        $user_bonus_model     = new user_bonusModel();
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

        //隐藏默认时间
        //$begin_day = date("Y-m-d H:i:s", strtotime(date('Y-m-d'))); // 今天的开始时间
        //$end_day = date("Y-m-d H:i:s", strtotime("+1 day", strtotime(date('Y-m-d')))-1);// 今天的结束时间

        $search_time = trim($_GET['search_time']);// 高级搜索日期范围
        if (!empty($search_time)) {
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

        Tpl::output('begin_day', $begin_day);
        Tpl::output('end_day', $end_day);

        if (isset($begin_day) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        }

        if (!empty($this->bonus_type)) {
            $where['type'] = ['eq', $this->bonus_type];
        } else {
            $where['type'] = [['neq', 13], ['neq', 14], 'and'];
        }

        $page      = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        if ($_GET['exporttype'] == 'excel') {
            $page_size = !empty($where) ? $user_bonus_log_model->getCount($where) : 100000;
        }

        $lists = $user_bonus_log_model->where($where)->field($field)->page($page_size)->order('created_at desc')->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'user_id');
            $user_id_info_arr        = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['user_id']       = $consumption_list['user_id'];
                $new_list[$key]['member_number'] = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_number'];
                $new_list[$key]['member_name']   = $user_id_info_arr_for_id[$consumption_list['user_id']]['member_name'];
                $new_list[$key]['money']         = $consumption_list['money'];
                $new_list[$key]['type']          = $user_bonus_model->getTypeInfo($consumption_list['type']);
                $new_list[$key]['created_at']    = $consumption_list['created_at'];
                //$new_list[$key]['operation']     = '<a href="' . urlAdminShop("stat_bonus_log", "log_info", ["user_id" => $consumption_list["user_id"],"type" => $consumption_list["type"]]) . '" class="btn green show-remark"><i class="fa fa-list-alt"></i>查看</a>';
                unset($this_remark_str);
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $user_bonus_log_model->where($where)->field($field)->count();
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
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '用户ID'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '邀请ID号'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '账户'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '金额'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '类型'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '时间'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][] = ['data' => $v['user_id']];
                $excel_data[$k + 1][] = ['data' => $v['member_number']];
                $excel_data[$k + 1][] = ['data' => $v['member_name']];
                $excel_data[$k + 1][] = ['data' => $v['money']];
                $excel_data[$k + 1][] = ['data' => $v['type']];
                $excel_data[$k + 1][] = ['data' => $v['created_at']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('分红日志统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('分红日志统计', CHARSET) . date('Y-m-d-H-i-s', time()));
            exit();
        }

        Tpl::showpage('stat_bonus_log/index');
    }

    /*public function indexOp()
    {
        Tpl::setDirquna('shop');
        $get_type               = $_GET['get_type'];
        $system_bonus_log_model = new system_bonus_logModel();
        $field                  = 'id,to_user_id,remark,created_at';
        $member_model           = new memberModel();
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

        //隐藏默认时间
        //$begin_day = date("Y-m-d H:i:s", strtotime(date('Y-m-d'))); // 今天的开始时间
        //$end_day = date("Y-m-d H:i:s", strtotime("+1 day", strtotime(date('Y-m-d')))-1);// 今天的结束时间

        $search_time = $_GET['search_time'];// 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        }

        if (isset($begin_day) && isset($end_day)) {
            $where['created_at'] = ['between', [$begin_day, $end_day]];
        } else {
            $where = "1 = 1";
        }

        $page      = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        if ($_GET['exporttype'] == 'excel') {
            //$page_size = $system_bonus_log_model->getCount($where);
            //$page_size = 2;
        }

        $lists = $system_bonus_log_model->where($where)->field($field)->page($page_size)->order('created_at desc')->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $to_user_id_arr             = array_column($lists, 'to_user_id');
            $to_user_id_info_arr        = $member_model->where(['member_id' => ['in', $to_user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $to_user_id_info_arr_for_id = array_combine(array_column($to_user_id_info_arr, 'member_id'), $to_user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['to_user_id']    = $consumption_list['to_user_id'];
                $new_list[$key]['member_number'] = $to_user_id_info_arr_for_id[$consumption_list['to_user_id']]['member_number'];
                $new_list[$key]['member_name']   = $to_user_id_info_arr_for_id[$consumption_list['to_user_id']]['member_name'];
                //$this_remark_str = $this->getRemarkArrToStr($consumption_list['remark']);
                $new_list[$key]['remark']     = '<div title="' . str_replace('|', '    ', $consumption_list['remark']) . '">' . $consumption_list['remark'] . '</div>';
                $new_list[$key]['created_at'] = $consumption_list['created_at'];
                $new_list[$key]['operation']  = '<a href="' . urlAdminShop("stat_bonus_log", "log_info", ["id" => $consumption_list["id"]]) . '" class="btn green show-remark"><i class="fa fa-list-alt"></i>查看</a>';
                unset($this_remark_str);
            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $system_bonus_log_model->where($where)->field($field)->count();
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
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '用户ID'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '邀请ID号'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '账户'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '详情'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '分红时间'];
            $excel_data[0][] = ['styleid' => 's_title', 'data' => '查看详情'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][] = ['data' => $v['to_user_id']];
                $excel_data[$k + 1][] = ['data' => $v['member_number']];
                $excel_data[$k + 1][] = ['data' => $v['member_name']];
                $excel_data[$k + 1][] = ['data' => $v['remark']];
                $excel_data[$k + 1][] = ['data' => $v['created_at']];
                $excel_data[$k + 1][] = ['data' => $v['operation']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('分红日志统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('分红日志统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }

        Tpl::showpage('stat_bonus_log/index');
    }*/

    public function log_infoOp()
    {
        Tpl::setDirquna('shop');
        $user_id                = intval($_GET['user_id']);
        $bonus_type             = intval($_GET['type']);
        $system_bonus_log_model = new system_bonus_logModel();
        $info                   = $system_bonus_log_model->where(['to_user_id' => $user_id, 'bonus_type' => $bonus_type])->find();
        $info['remark_arr']     = $this->getRemarkArrToStr($info['remark']);
        Tpl::output('info', $info);
        Tpl::showpage('stat_bonus_log/log_info');
    }

    public function getRemarkArrToStr($remark_str)
    {
        $remark_arr = explode('|', $remark_str);
        $str        = '';
        foreach ($remark_arr as $value) {
            $str .= '<p>' . $value . '</p>';
        }
        return $str;
    }
}
