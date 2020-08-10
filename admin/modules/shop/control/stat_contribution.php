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

class stat_contributionControl extends SystemControl
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

    public function indexOp()
    {
        Tpl::setDirquna('shop');/*创 驰 云 网 络 ccynet.com*/
        $get_type               = $_GET['get_type'];
        $contribution_log_model = Model('contribution_log');
        $member_model           = Model('member');
        // 如果需要单个会员的信息
        $member_name = trim($_GET['member_name']);
        if ($member_name != '') {
            // 获取会员账户的member_id
            $this_member_info = $member_model->where(['member_name' => ['like', $member_name . '%']])->field('member_id')->select();
            if (!empty($this_member_info)) {
                $get_member_id_arr  = array_column($this_member_info, 'member_id');
                $where['member_id'] = ['in', $get_member_id_arr];
            } else {
                $where['member_id'] = -1;
            }
        }

        //$begin_day = strtotime(date("Y-m-d H:i:s", strtotime("-1 day", strtotime(date('Y-m-d')))));
        //$end_day = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y'))-1));
        $search_time = $_GET['search_time'];    // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = strtotime(date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date)))));
            $end_date   = trim($date_range[1]);
            $end_day    = strtotime(date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date)))));
        }
        if (!isset($begin_day) || !isset($end_day)) {
            empty($where) && $where = " 1=1 ";
        } else {
            $where['create_time'] = ['between', [$begin_day, $end_day]];
        }

        $page      = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        $lists     = $contribution_log_model->where($where)->page($page_size)->select();

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($lists)) {
            $user_id_arr             = array_column($lists, 'member_id');
            $user_id_info_arr        = $member_model->where(['member_id' => ['in', $user_id_arr]])->field('member_id,member_number,member_name,member_nickname')->select();
            $user_id_info_arr_for_id = array_combine(array_column($user_id_info_arr, 'member_id'), $user_id_info_arr);
            foreach ($lists as $key => $consumption_list) {
                $new_list[$key]['user_id']       = $consumption_list['member_id'];
                $new_list[$key]['member_number'] = $user_id_info_arr_for_id[$consumption_list['member_id']]['member_number'];
                $new_list[$key]['member_name']   = $user_id_info_arr_for_id[$consumption_list['member_id']]['member_name'];
                $new_list[$key]['contribution']  = $consumption_list['contribution'];
                $new_list[$key]['des']           = $consumption_list['des'];
                $new_list[$key]['created_at']    = date('Y-m-d H:i:s', $consumption_list['create_time']);

            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $contribution_log_model->where($where)->count();
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
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '贡献值'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '描述'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '操作时间'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['contribution']];
                $excel_data[$k + 1][4] = ['data' => $v['des']];
                $excel_data[$k + 1][5] = ['data' => $v['created_at']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('贡献值统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('贡献值统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }
        $contribution_info = $member_model->field('sum(member_contribution) as total_member_contribution')->find();
        Tpl::output('contribution_info', $contribution_info);
        Tpl::output('this_type_name', '贡献值统计');
        Tpl::showpage('stat_contribution/index');
    }

}
