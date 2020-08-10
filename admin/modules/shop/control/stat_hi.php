<?php
/**
 * 统计管理（销量分析）
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

defined('ByCCYNet') or exit('Access Invalid!');

class stat_hiControl extends SystemControl
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
        $get_type     = $_GET['get_type'];
        $member_model = Model('member');
        if (isset($_GET['data_type']) && $_GET['data_type'] != '0') {
            //获取升级总HI值列表，推荐团队总 HI 值列表，奖金转换总 HI 值列表
            $user_hi_model = Model('user_hi_value');
            $where         = [];
            switch ($_GET['data_type']) {
                case 'upgrade_hi':
                    $where['upgrade_hi'] = ['neq', 0];
                    break;
                case 'recommend_team_hi':
                    $where['recommend_team_hi'] = ['neq', 0];
                    break;
                case 'bonus_to_hi':
                    $where['bonus_to_hi'] = ['neq', 0];
                    break;
            }
            $page              = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
            $page_size         = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
            $user_hi_value_arr = $user_hi_model
                ->where($where)
                ->field('user_id,upgrade_hi,recommend_team_hi,bonus_to_hi,(upgrade_hi+recommend_team_hi+bonus_to_hi) as total_hi')
                ->page($page_size)
                ->select();
            if (empty($user_hi_value_arr)) {
                return [];
            }
            $member_id_arr = array_column($user_hi_value_arr, 'user_id');
            //获取用户信息
            $member_id_arr_info       = $member_model
                ->where(['member_id' => ['in', $member_id_arr]])
                ->field('member_id,member_number,member_name')
                ->select();
            $user_id_and_hi_value_arr = array_combine(array_column($user_hi_value_arr, 'user_id'), $user_hi_value_arr);
        } else {
            // 如果需要单个会员的信息
            $member_name = trim($_GET['member_name']);
            $where       = [];
            if ($member_name != '') {
                $where['member_name'] = ['like', $member_name . '%'];
            }
            // 获取所有用户
            $page               = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
            $page_size          = isset($_POST['rp']) ? intval($_POST['rp']) : 15;
            $member_id_arr_info = $member_model
                ->where($where)->field('member_id,member_number,member_name')->page($page_size)->select();
            if (empty($member_id_arr_info)) {
                return [];
            }
            $member_id_arr = array_column($member_id_arr_info, 'member_id');
            // 获取这些用户的hi值
            $user_hi_model            = Model('user_hi_value');
            $user_hi_value_arr        = $user_hi_model->where(['user_id' => ['in', $member_id_arr]])->field('user_id,upgrade_hi,recommend_team_hi,bonus_to_hi,(upgrade_hi+recommend_team_hi+bonus_to_hi) as total_hi')->select();
            $user_id_and_hi_value_arr = array_combine(array_column($user_hi_value_arr, 'user_id'), $user_hi_value_arr);
        }

        // 获取这一页的用户信息
        $new_list = [];
        if (!empty($member_id_arr_info)) {
            foreach ($member_id_arr_info as $key => $member_info) {
                $new_list[$key]['operation']         = "<a class='btn green' href='" . urlAdminShop('stat_hi', 'hi_log', ['user_id' => $member_info['member_id']]) . "'><i class='fa fa-list-alt'></i>查看日志</a>";
                $new_list[$key]['user_id']           = $member_info['member_id'];
                $new_list[$key]['member_number']     = $member_info['member_number'];
                $new_list[$key]['member_name']       = $member_info['member_name'];
                $new_list[$key]['total_hi']          = isset($user_id_and_hi_value_arr[$member_info['member_id']]) ? $user_id_and_hi_value_arr[$member_info['member_id']]['total_hi'] : 0;
                $new_list[$key]['upgrade_hi']        = isset($user_id_and_hi_value_arr[$member_info['member_id']]) ? $user_id_and_hi_value_arr[$member_info['member_id']]['upgrade_hi'] : 0;
                $new_list[$key]['recommend_team_hi'] = isset($user_id_and_hi_value_arr[$member_info['member_id']]) ? $user_id_and_hi_value_arr[$member_info['member_id']]['recommend_team_hi'] : 0;
                $new_list[$key]['bonus_to_hi']       = isset($user_id_and_hi_value_arr[$member_info['member_id']]) ? $user_id_and_hi_value_arr[$member_info['member_id']]['bonus_to_hi'] : 0;
            }
        }

        if ($get_type == 'xml') {
            $data             = [];
            $data['now_page'] = $page;
            if (isset($_GET['data_type']) && $_GET['data_type'] != '0') {
                $data['total_num'] = $user_hi_model->where($where)->count();
            } else {
                $data['total_num'] = $member_model->where($where)->count();
            }
            $data['list'] = $new_list;
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
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '总hi值'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '升级获得'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '邀请团队获得'];
            $excel_data[0][6] = ['styleid' => 's_title', 'data' => '奖金转换'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['member_number']];
                $excel_data[$k + 1][2] = ['data' => $v['member_name']];
                $excel_data[$k + 1][3] = ['data' => $v['total_hi']];
                $excel_data[$k + 1][4] = ['data' => $v['upgrade_hi']];
                $excel_data[$k + 1][5] = ['data' => $v['recommend_team_hi']];
                $excel_data[$k + 1][6] = ['data' => $v['bonus_to_hi']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('分红hi值统计', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('分红hi值统计', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }


        // 平台当前总hi值情况
        $total_hi_info             = $user_hi_model->field('sum(upgrade_hi) as total_upgrade_hi,sum(recommend_team_hi) as total_recommend_team_hi,sum(bonus_to_hi) as total_bonus_to_hi')->find();
        $total_hi_info['total_hi'] = array_sum($total_hi_info);


        Tpl::output('total_hi_info', $total_hi_info);
        Tpl::output('this_type_name', '分红hi值');
        Tpl::showpage('stat_hi/index');
    }


    public function hi_logOp()
    {
        Tpl::setDirquna('shop');
        $get_type = $_GET['get_type'];
        $user_id  = intval($_GET['user_id']);
        // 获取这个用户获取hi值的记录
        $user_hi_log_model = Model('user_hi_log');
        $page              = isset($_POST['curpage']) ? intval($_POST['curpage']) : 1;
        $page_size         = isset($_POST['rp']) ? intval($_POST['rp']) : 1;

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
        //$where['created_at'] = ['between', [$begin_day, $end_day]];
        $where['user_id']    = $user_id;

        $lists = $user_hi_log_model->where($where)->page($page_size)->order('id desc')->select();
        //dump($where);
        //dump($lists);
        //die;
        // 获取这一页的用户信息
        $hi_type_arr = $user_hi_log_model->getHiType();
        $new_list    = [];
        if (!empty($lists)) {
            foreach ($lists as $key => $hi_log_info) {
                $new_list[$key]['user_id']       = $hi_log_info['id'];
                $new_list[$key]['hi_value']      = $hi_log_info['hi_value'];
                $new_list[$key]['hi_type']       = $hi_type_arr[$hi_log_info['hi_type']];
                $new_list[$key]['get_type']      = ($hi_log_info['get_type'] == 1) ? '增加' : '减少';
                $new_list[$key]['expiration_at'] = ($hi_log_info['expiration_at'] == 0) ? '永久' : $hi_log_info['expiration_at'];
                $new_list[$key]['created_at']    = $hi_log_info['created_at'];
            }
        }
        if ($get_type == 'xml') {
            $data              = [];
            $data['now_page']  = $page;
            $data['total_num'] = $user_hi_log_model->where(['user_id' => $user_id])->count();
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
            $excel_data[0][1] = ['styleid' => 's_title', 'data' => 'HI值数额'];
            $excel_data[0][2] = ['styleid' => 's_title', 'data' => 'HI值类型'];
            $excel_data[0][3] = ['styleid' => 's_title', 'data' => '获取类型'];
            $excel_data[0][4] = ['styleid' => 's_title', 'data' => '过期时间'];
            $excel_data[0][5] = ['styleid' => 's_title', 'data' => '获取时间'];
            //data
            foreach ($new_list as $k => $v) {
                $excel_data[$k + 1][0] = ['data' => $v['user_id']];
                $excel_data[$k + 1][1] = ['data' => $v['hi_value']];
                $excel_data[$k + 1][2] = ['data' => $v['hi_type']];
                $excel_data[$k + 1][3] = ['data' => $v['get_type']];
                $excel_data[$k + 1][4] = ['data' => $v['expiration_at']];
                $excel_data[$k + 1][5] = ['data' => $v['created_at']];
            }
            $excel_data = $excel_obj->charset($excel_data, CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('hi值记录', CHARSET));
            $excel_obj->generateXML($excel_obj->charset('hi值记录', CHARSET) . date('Y-m-d-H', time()));
            exit();
        }
        Tpl::output('this_type_name', '分红hi值获取记录');
        Tpl::output('user_id', $user_id);
        Tpl::showpage('stat_hi/log_lists');
    }
}
