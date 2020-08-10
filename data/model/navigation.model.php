<?php
/**
 * 文件的简短描述
 *
 * 文件的详细描述
 *
 * * @海吉壹佰 (c) 2015-2018 CCYNet Inc. (http://www.ccynet.cn/)
 * @license    http://www.ccynet.c om
 * @link       http://www.ccynet.cn/
 * @since      海吉壹佰提供技术支持 授权请申请
 */
defined('ByCCYNet') or exit('Access Invalid!');

class navigationModel extends Model {
    /**
     * 列表
     *
     * @param array $condition 检索条件
     * @param obj $page 分页
     * @return array 数组结构的返回结果
     */
    public function getNavigationList($condition,$page = ''){

        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'navigation';
        $param['where'] = $condition_str;
        $param['order'] = $condition['order'] ? $condition['order'] : 'nav_id';
        $result = Db::select($param,$page);
        return $result;
    }

    /**
     * 构造检索条件
     *
     * @param int $id 记录ID
     * @return string 字符串类型的返回结果
     */
    private function _condition($condition){
        $condition_str = ' ';
        if ($condition['like_nav_title'] != ' '){
            $condition_str .= " and nav_title like '%". $condition['like_nav_title'] ."%'";
        }
        if ($condition['nav_location'] != '' || $condition['nav_location'] === 0){
            $condition_str .= " and nav_location = '". $condition['nav_location'] ."'";
        }
        if ($condition['nav_type'] != '' || $condition['nav_type'] === 0){
            $condition_str .= " and nav_type = '". $condition['nav_type'] ."'";
        }
        if ($condition['nav_pid'] != '' || $condition['nav_pid'] === 0){
            $condition_str .= " and nav_pid = '". $condition['nav_pid'] ."'";
        }

        return $condition_str;
    }

    /**
     * 取单个内容
     *
     * @param int $id ID
     * @return array 数组类型的返回结果
     */
    public function getOneNavigation($id){
        if (intval($id) > 0){
            $param = array();
            $param['table'] = 'navigation';
            $param['field'] = 'nav_id';
            $param['value'] = intval($id);
            $result = Db::getRow($param);
            return $result;
        }else {
            return false;
        }
    }

    /**
     * 新增
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function add($param){
        if (empty($param)){
            return false;
        }
        if (is_array($param)){
            $tmp = array();
            foreach ($param as $k => $v){
                $tmp[$k] = $v;
            }
            $result = Db::insert('navigation',$tmp);
            return $result;
        }else {
            return false;
        }
    }

    /**
     * 更新信息
     *
     * @param array $param 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function updates($param){
        if (empty($param)){
            return false;
        }
        if (is_array($param)){
            $tmp = array();
            foreach ($param as $k => $v){
                $tmp[$k] = $v;
            }
            $where = " nav_id = '". $param['nav_id'] ."'";
            $result = Db::update('navigation',$tmp,$where);
            return $result;
        }else {
            return false;
        }
    }

    /**
     * 删除
     *
     * @return bool 布尔类型的返回结果
     */
    public function del($condition = array()){
        return $this->table('navigation')->where($condition)->delete();
    }


    /**
     * 取分类列表，按照深度归类
     * @param array $condition
     * @param string $show_deep 显示深度
     * @return array 数组类型的返回结果
     */
    public function getTreeList($condition  = array(),$show_deep='2'){
        $class_list = $this->getNavigationList($condition);
        $show_deep = intval($show_deep);
        $result = array();
        if(is_array($class_list) && !empty($class_list)) {
            $result = $this->_getTreeList($show_deep,$class_list);
        }
        return $result;
    }

    /**
     * 递归 整理分类
     *
     * @param int $show_deep 显示深度
     * @param array $class_list 类别内容集合
     * @param int $deep 深度
     * @param int $parent_id 父类编号
     * @param int $i 上次循环编号
     * @return array $show_class 返回数组形式的查询结果
     */
    private function _getTreeList($show_deep,$class_list,$deep=1,$parent_id=0,$i=0){
        static $show_class = array();//树状的平行数组
        if(is_array($class_list) && !empty($class_list)) {
            $size = count($class_list);
            if($i == 0){
                $show_class = array();//从0开始时清空数组，防止多次调用后出现重复
            }
            for ($i;$i < $size;$i++) {//$i为上次循环到的分类编号，避免重新从第一条开始
                $val = $class_list[$i];
                $nav_id = $val['nav_id'];
                $nav_pid   = $val['nav_pid'];
                if($nav_pid == $parent_id) {
                    $val['deep'] = $deep;
                    $show_class[] = $val;
                    if($deep < $show_deep && $deep < 2) {//本次深度小于显示深度时执行，避免取出的数据无用
                        $this->_getTreeList($show_deep,$class_list,$deep+1,$nav_id,$i+1);
                    }
                }
                /*if($nav_pid > $parent_id) {
                    break; //当前分类的父编号大于本次递归的时退出循环
                }*/
            }
        }
        return $show_class;
    }

    /**
     * 取指定分类ID下的所有子类
     *
     * @param int/array $parent_id 父ID 可以单一可以为数组
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function getChild($parent_id){
        $all_class = $this->getNavigationList(array('order'=>'nav_pid asc,nav_sort asc,nav_id asc'));
        if (is_array($all_class)){
            if (!is_array($parent_id)){
                $parent_id = array($parent_id);
            }
            $result = array();
            foreach ($all_class as $k => $v){
                $nav_id  = $v['nav_id'];//返回的结果包括父类
                $nav_pid   = $v['nav_pid'];
                if (in_array($nav_id,$parent_id) || in_array($nav_pid,$parent_id)){
                    $result[] = $v;
                }
            }
            return $result;
        }else {
            return false;
        }
    }
}
