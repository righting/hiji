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

class stat_positionsControl extends SystemControl
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
        $get_type            = $_GET['get_type'];
        $positions_log_model = Model('positions_log');
        $member_model        = Model('member');
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

        $begin_day   = date("Y-m-d H:i:s", strtotime("-1 day", strtotime(date('Y-m-d'))));
        $end_day     = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1);
        $search_time = $_GET['search_time'];    // 高级搜索日期范围
        if ($search_time != '') {
            $date_range = explode('~', $search_time);
            $begin_date = trim($date_range[0]);
            $begin_day  = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($begin_date))));
            $end_date   = trim($date_range[1]);
            $end_day    = date('Y-m-d 23:59:59', strtotime(date('Y-m-d', strtotime($end_date))));
        }

        $where['created_at'] = ['between', [$begin_day, $end_day]];
        $page                = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size           = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
        $lists               = $positions_log_model->where($where)->page($page_size)->select();

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
                $new_list[$key]['remark']        = $consumption_list['remark'];
                $new_list[$key]['created_at']    = $consumption_list['created_at'];

            }
        }

        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $positions_log_model->where($where)->count();
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
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '描述'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '操作时间'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['remark']];
                $excel_data[$k + 1][4] = ['data' => $v['created_at']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('职级统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('职级统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }

        $positions_model       = new positionsModel();
        $positions_type        = $positions_model->getPositionInfo();
        $old_contribution_info = $member_model->where(['member_state' => 1])->field('positions_id,COUNT(1) as member_count')->group('positions_id')->select();
        $contribution_info     = array_combine(array_column($old_contribution_info, 'positions_id'), array_column($old_contribution_info, 'member_count'));
        // 所有拥有职级的人数 = 所有人数 - 无职级的人数
        $total_count = bcsub(array_sum($contribution_info), $contribution_info[$positions_model::POSITIONS_ZERO]);
        Tpl::output('total_count', $total_count);
        Tpl::output('contribution_info', $contribution_info);
        Tpl::output('positions_type', $positions_type);
        Tpl::output('this_type_name', '职级统计');
        Tpl::showpage('stat_positions/index');
    }


    /**
     * 输出XML数据
     */
    public function get_xmlOp()
    {
        $model = Model('member');
        // 设置页码参数名称
        $condition = [];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = ['like', '%' . $_POST['query'] . '%'];
        }

        $page = $_POST['rp'];

        $level = $_GET['level'] ? intval($_GET['level']) : -1;

        if ($level == -1) {
            $where = ['member_state' => 1, 'positions_id' => ['lt', '8']];
        } else {
            $where = ['member_state' => 1, 'positions_id' => $level];
        }
        $getInfo           = $model->where($where)->page($page)->select();
        $data              = [];
        $data['now_page']  = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        $levelName         = '';
        foreach ($getInfo as $value) {
            $param                  = [];
            $param['member_id']     = $value['member_id'];
            $param['member_number'] = $value['member_number'];
            $param['member_name']   = $value['member_name'];
            switch ($value['positions_id']) {
                case 1:
                    $levelName = '高级主管';
                    break;
                case 2:
                    $levelName = '资深主管';
                    break;
                case 3:
                    $levelName = '市场主任';
                    break;
                case 4:
                    $levelName = '市场经理';
                    break;
                case 5:
                    $levelName = '市场总监';
                    break;
                case 6:
                    $levelName = '市场总经理';
                    break;
                case 7:
                    $levelName = '市场副总裁';
                    break;
                default:
                    $levelName = '无职级';
            }
            $param['positions_id']             = $levelName;
            $param['member_login_time']        = !empty($value['member_login_time']) ? date('Y-m-d H:i:s', $value['member_login_time']) : '';
            $param['member_old_login_time']    = !empty($value['member_old_login_time']) ? date('Y-m-d H:i:s', $value['member_old_login_time']) : '';
            $param['member_login_ip']          = $value['member_login_ip'];
            $param['member_old_login_ip']      = $value['member_old_login_ip'];
            $data['list'][$value['member_id']] = $param;
        }
        $excelName = $level == -1 ? '平台拥有职级的总人数' : '平台' . $levelName . '总人数';

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
            $excel_data[0][1] = ['styleid' => 's_title', 'data' => 'ID编号'];
            $excel_data[0][2] = ['styleid' => 's_title', 'data' => '会员名称'];
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '职务级别'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '当前登录时间'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '上次登录时间'];
            $excel_data[0][6] = ['styleid' => 's_title', 'data' => '当前登录IP'];
            $excel_data[0][7] = ['styleid' => 's_title', 'data' => '上次登录IP'];

            foreach ($data['list'] as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['member_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['positions_id']];
                $excel_data[$k + 1][4] = ['data' => $v['member_login_time']];
                $excel_data[$k + 1][5] = ['data' => $v['member_old_login_time']];
                $excel_data[$k + 1][6] = ['data' => $v['member_login_ip']];
                $excel_data[$k + 1][7] = ['data' => $v['member_old_login_ip']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('职级统计 - ' . $excelName . ' - ', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('职级统计 - ' . $excelName . ' - ', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }

        echo Tpl::flexigridXML($data);
        exit();
    }


}
