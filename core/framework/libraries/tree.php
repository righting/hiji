<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/15
 * Time: 10:57
 */
/**
 * 生成多层树状下拉选框的工具模型
 */
defined('ByCCYNet') or exit('Access Invalid!');
class Tree {
    /**
     * 把返回的数据集转换成Tree
     * @access public
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     */
    public function toTree($list=null, $pk='id',$pid = 'pid',$child = '_child'){
        if(null === $list) {
            // 默认直接取查询返回的结果集合
            $list   =   &$this->dataList;
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();

            foreach ($list as $key => $data) {
                $_key = is_object($data)?$data->$pk:$data[$pk];
                $refer[$_key] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = is_object($data)?$data->$pid:$data[$pid];
                $is_exist_pid = false;
                foreach($refer as $k=>$v){
                    if($parentId==$k){
                        $is_exist_pid = true;
                        break;
                    }
                }
                if ($is_exist_pid) {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                } else {
                    $tree[] =& $list[$key];
                }
            }
        }
        return $tree;
    }


    public function toIdTree($list=null, $pk='id',$pid = 'pid',$child = '_child'){
        if(null === $list) {
            // 默认直接取查询返回的结果集合
            $list   =   &$this->dataList;
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();

            foreach ($list as $key => $data) {
                $_key = is_object($data)?$data->$pk:$data[$pk];
                $refer[$_key] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = is_object($data)?$data->$pid:$data[$pid];
                $is_exist_pid = false;
                foreach($refer as $k=>$v){
                    if($parentId==$k){
                        $is_exist_pid = true;
                        break;
                    }
                }
                if ($is_exist_pid) {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][$data[$pk]] =& $list[$key];
                    }
                } else {
                    $tree[$data[$pk]] =& $list[$key];
                }
            }
        }
        return $tree;
    }

    /**
     * 将格式数组转换为树
     *
     * @param array $list
     * @param integer $level 进行递归时传递用的参数
     */
    private $formatTree; //用于树型数组完成递归格式的全局变量
    private function _toFormatTree($list,$level=0,$title = 'title') {
        foreach($list as $key=>$val){
            $tmp_str=str_repeat("&nbsp;",$level*2);
            $tmp_str.="└";

            $val['level'] = $level;
            $val['title_show'] =$level==0?$val[$title]."&nbsp;":$tmp_str.$val[$title]."&nbsp;";
            // $val['title_show'] = $val['id'].'|'.$level.'级|'.$val['title_show'];
            if(!array_key_exists('_child',$val)){
                array_push($this->formatTree,$val);
            }else{
                $tmp_ary = $val['_child'];
                unset($val['_child']);
                array_push($this->formatTree,$val);
                $this->_toFormatTree($tmp_ary,$level+1,$title); //进行下一层递归
            }
        }
        return;
    }

    public function toFormatTree($list,$title = 'title',$pk='id',$pid = 'pid',$root = 0){
        $list = $this->toTree($list,$pk,$pid,'_child',$root);
        $this->formatTree = array();
        $this->_toFormatTree($list,0,$title);
        return $this->formatTree;
    }

    public $arr = array();

    /*
     * 得到当前位置数组
     * @param int
     * @return array
     */
    public function getPos($myid,&$newArr,$this_id='id',$this_pid = 'pid'){
//        print_r($this_pid);die;
        $a=array();
        if(!isset($this->arr[$myid])) {
            return false;
        }
        $newArr[] = $this->arr[$myid];
        $pid = $this->arr[$myid][$this_pid];
        if(isset($this->arr[$pid])){
            $this->getPos($pid,$newArr,$this_id,$this_pid);
        }
        if(is_array($newArr)){
            krsort($newArr);
            foreach($newArr as $v){
                $a[$v[$this_id]] = $v;
            }
        }
        return $a;
    }




    /**
     * 取指定分类ID的所有父级分类
     *
     * @param int $id 父类ID/子类ID
     * @return array $nav_link 返回数组形式类别导航连接
     */

    /**
     * @param $list
     * @param string $id_str
     * @param string $pid_str
     * @param int $id
     * @return array
     */
    function getParent($list,$id_str = 'id',$pid_str = 'pid',$id = 0) {
        if (intval($id)> 0) {
            $return = array();
            /**
             * 取当前类别信息
             */
            $class = $list[$id];
            $return[$id_str] = $class[$id_str];
            /**
             * 是否是子类
             */
            if ($class[$pid_str] != 0) {
                $parent_1 = $list[$class[$pid_str]];
                if ($parent_1[$pid_str] != 0) {
                    $parent_2 = $list[$parent_1[$pid_str]];
                    $return['first_pid'] = $parent_2[$id_str];
                    $return['first_arr'] = $parent_2;
                }
                if (!isset($return['first_pid'])) {
                    $return['first_pid'] = $parent_1[$id_str];
                    $return['first_arr'] = $parent_1;
                } else {
                    $return['second_pid'] = $parent_1[$id_str];
                    $return['second_arr'] = $parent_1;
                }
            }
            if (!isset($return['first_pid'])) {
                $return['first_pid'] = $class[$id_str];
                $return['first_arr'] = $class;
            } else if (!isset($return['second_pid'])) {
                $return['second_pid'] = $class[$id_str];
                $return['second_arr'] = $class;
            } else {
                $return['third_pid'] = $class[$id_str];
                $return['third_arr'] = $class;
            }
        }
        return $return;
    }

    /**
     * 将树形结构的数组按照顺序遍历为二维数组
     *
     */
    public function tree_to_array ($array,$child_str = '_child') {
        static $res;
        if (!is_array($array)) {
            return false;
        }
        foreach ($array as $k=>$v) {
            if (is_array($v) && isset($v[$child_str])) {
                $child = $v[$child_str]; //将这个数组的子节点赋给变量 $child
                unset($v[$child_str]); //释放这个数组的所有子节点
                $res[] = $v; //将释放后的数组填充到新数组 $res
                self::tree_to_array ($child); //递归处理释放前的包含子节点的数组
            } else {
                $res[] = $v;
            }
        }
        return $res;
    }


    public function getFirstId($list,$id,$id_str = 'gc_id',$pid_str = 'gc_parent_id'){
        if($list[$id][$pid_str] == 0){
            return $list[$id][$id_str];
        }
        $pid = $list[$id][$pid_str];
        if($list[$pid][$pid_str] > 0){
            self::getFirstId($list,$list[$pid][$pid_str]);
        }else{
            return $list[$id];
        }

    }
}



/*
 * 实现树形结构的基类
 * @author zhengguorui
 */
class SimpleTree {
    // 节点名称
    var $data = array ();
    // 以下三个为实现树结构的数组
    var $child = array (- 1 => array () );    // 节点的儿子
    var $parent = array ();                    // 节点的父亲
    var $layer = array (- 1 => - 1 );         // 节点的深度

    /*
     * 默认根节点为0，其父亲节点为-1
     */
    function Tree($value) {
        $this->setNode ( 0, - 1, $value );
    }

    /* 设置新节点。
     * （自身id，父节点id，名称）
     */
    function setNode($id, $parent, $value) {
        $parent = $parent ? $parent : 0;

        // 存节点名
        $this->data[$id] = $value;
        // 存子节点
        $this->child[$id] = array ();
        // 设置父节点的子为自己
        $this->child[$parent] [] = $id;
        // 设置父节点
        $this->parent [$id] = $parent;
        // 设置节点层级
        if (! isset ( $this->layer [$parent] )) {
            $this->layer [$id] = 0;
        } else {
            $this->layer [$id] = $this->layer [$parent] + 1;
        }
    }

    /*
     * 递归取子节点集合
     */
    function getList(&$tree, $root = 0) {
        foreach ( $this->child[$root] as $key => $id ) {
            // 取root的子节点
            $tree [] = $id;
            // 递归取子节点的子节点
            if ($this->child[$id])
                $this->getList ( $tree, $id );
        }
    }

    /*
     * 返回节点的名称
     */
    function getValue($id) {
        return $this->data[$id];
    }

    /*
     * 返回节点的深度
     */
    function getLayer($id, $space = false) {
        return $space ? str_repeat ( $space, $this->layer [$id] ) : $this->layer [$id];
    }

    /*
     * 返回节点的父亲
     */
    function getParent($id) {
        return $this->parent[$id];
    }

    /*
     * 返回节点的父节点路径，直到root
     */
    function getParents($id) {
        while ( $this->parent[$id] != - 1 ) {
            $id = $parent [$this->layer [$id]] = $this->parent [$id];
        }
        ksort($parent);
        reset($parent);
        return $parent;
    }

    /*
     * 返回直接子节点，仅一层
     */
    function getChild($id) {
        return $this->child[$id];
    }

    /*
     * 返回所有子节点
     */
    function getChilds($id = 0) {
        $child = array ($id );
        $this->getList ( $child, $id );
        return $child;
    }

}



/*
 * 菜单树形结构类
 * 增加品牌列表属性
 * 和getset方法
 * @author zhengguorui
 */
class TreeMenu extends SimpleTree{
    // 增加新属性，节点拥有的品类
    protected $brands = array ();
    public $data = [];
    /*
     * 设置某节点的品类
     * （节点id，品类id，品类名称）
     */
    function setBrand($id = 0, $brand_id = -1, $brand_name = "null" ) {

        if( $this->data[$id]) {
            return;
        }
        // 先给自己的 list 新增
        if (! isset ( $this->brands [$id] )) {
            $this->brands [$id] = array();
        }
        if( !isset($this->brands[$id][$brand_id]) ){
            $this->brands[$id][$brand_id] = $brand_name;
        }

        // 然后递归给自己的父节点新增
        self::setBrand( parent::getParent($id), $brand_id, $brand_name);
    }

    /*
     * 返回节点下拥有的品类列表
     */
    function getBrands($id = 0, $isList=false) {
        $origlist = array();
        if( isset($this->brands[$id]) ){
            $origlist = $this->brands[$id];
        }
        return self::brandtoarray($origlist, $isList );
    }

    /*
     * 返回父节点
     */
    function getParent($id, $isList=false) {
        if($id==0){
            return array();
        }
        $origlist = parent::getParent($id);
        return self::idtoarray( array("0"=>$origlist), $isList );
    }

    /*
     * 返回节点的父节点路径，直到root
     */
    function getParents($id, $isList=false) {
        $origlist = parent::getParents($id);
        return self::idtoarray($origlist, $isList );
    }

    /*
     * 返回直接子节点，仅一层
     */
    function getChild($id, $isList=false) {
        $origlist = parent::getChild($id);
        return self::idtoarray( $origlist, $isList );
    }

    /*
     * 返回所有子节点
     */
    function getChilds($id = 0, $isList=false) {
        $origlist = parent::getChilds($id);
        return self::idtoarray($origlist, $isList );
    }

    /*
     * 将 index->id 的数组方式转为 id->name 的方式
     */
    function idtoarray($origlist, $isList=false){
        $newlist = array();
        if(isset($origlist)){
            $newlist = array();
            foreach ( $origlist as $key => $value ) {
                if($isList){
                    array_push($newlist, array(
                        'id'    =>    $value,
                        'name'    =>    self::getValue($value),
                    ));
                }else{
                    $newlist[$value] = self::getValue($value);
                }
            }
        }
        return $newlist;
    }

    /*
     * 将 index->id 的数组方式转为 id->name 的方式
     */
    function brandtoarray($origlist, $isList=false){
        $newlist = array();
        if(isset($origlist)){
            $newlist = array();
            foreach ( $origlist as $key => $value ) {
                if($isList){
                    array_push($newlist, array(
                        'id'    =>    $key,
                        'name'    =>    $value,
                    ));
                }else{
                    $newlist[$key] = $value;
                }
            }
        }
        return $newlist;
    }

}