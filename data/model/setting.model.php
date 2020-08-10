<?php
/**
 * 系统设置内容
 *
 *
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');
class settingModel extends Model{
    public function __construct(){
        parent::__construct('setting');
    }

    const EXP_LEVEL_ZERO = 0;
    const EXP_LEVEL_ONE = 1;
    const EXP_LEVEL_TWO = 2;
    const EXP_LEVEL_THREE = 3;
    const EXP_LEVEL_FOUR = 4;
    const EXP_LEVEL_FIVE = 5;


    public function setExpLevel($level = ''){
        $level_group = [
            self::EXP_LEVEL_ZERO => '免费会员',
            self::EXP_LEVEL_ONE => '贵宾会员',
            self::EXP_LEVEL_TWO => '银尊会员',
            self::EXP_LEVEL_THREE => '金尊会员',
            self::EXP_LEVEL_FOUR => '至尊会员',
            self::EXP_LEVEL_FIVE => '黑钻会员',
        ];
        return isset($level_group[$level]) ? $level_group[$level] : $level_group;
    }

    /**
     * 读取系统设置信息
     *
     * @param string $name 系统设置信息名称
     * @return array 数组格式的返回结果
     */
    public function getRowSetting($name){
        $param  = array();
        $param['table'] = 'setting';
        $param['where'] = "name='".$name."'";
        $result = Db::select($param);
        if(is_array($result) and is_array($result[0])){
            return $result[0];
        }
        return false;
    }

    /**
     * 读取系统设置列表
     *
     * @param
     * @return array 数组格式的返回结果
     */
    public function getListSetting(){
        $param = array();
        $param['table'] = 'setting';
        $result = Db::select($param);
        /**
         * 整理
         */
        if (is_array($result)){
            $list_setting = array();
            foreach ($result as $k => $v){
                $list_setting[$v['name']] = $v['value'];
            }
        }
        return $list_setting;
    }

    /**
     * 更新信息
     *
     * @param array $param 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function updateSetting($param){
        if (empty($param)){
            return false;
        }

        if (is_array($param)){
            foreach ($param as $k => $v){
                $tmp = array();
                $specialkeys_arr = array('statistics_code');
                $tmp['value'] = (in_array($k,$specialkeys_arr) ? htmlentities($v,ENT_QUOTES) : $v);
                $where = " name = '". $k ."'";
                $result = Db::update('setting',$tmp,$where);
                if ($result !== true){
                    return $result;
                }
            }
            dkcache('setting');
            // @unlink(BASE_DATA_PATH.DS.'cache'.DS.'setting.php');
            return true;
        }else {
            return false;
        }
    }

}
