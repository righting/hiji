<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 14:59
 */
class cateControl extends BaseHtControl
{
    //每页显示商品数
    const PAGESIZE = 24;

    //模型对象
    private $_model_search;


    public function indexOp()
    {
        Language::read('home_goods_class_index');
        $this->_model_search = Model('search');
        //显示左侧分类
        //默认分类，从而显示相应的属性和品牌
        $default_classid = intval($_GET['cate_id']);


        //全文搜索搜索参数
        $indexer_searcharr = $_GET;

        //搜索消费者保障服务
        $search_ci_arr = [];
        $search_ci_str = '';
        if ($_GET['ci'] && $_GET['ci'] != 0) {
            //处理参数
            $search_ci                          = $_GET['ci'];
            $search_ci_arr                      = explode('_', $search_ci);
            $search_ci_str                      = $search_ci . '_';
            $indexer_searcharr['search_ci_arr'] = $search_ci_arr;
        }


        //获得经过属性过滤的商品信息
        list($goods_param, $brand_array, $initial_array, $attr_array, $checked_brand, $checked_attr) = $this->_model_search->getAttr($_GET, $default_classid);
        Tpl::output('brand_array', $brand_array);
        Tpl::output('initial_array', $initial_array);
        Tpl::output('attr_array', $attr_array);
        Tpl::output('checked_brand', $checked_brand);
        Tpl::output('checked_attr', $checked_attr);

        //查询消费者保障服务
        $contract_item = [];
        if (C('contract_allow') == 1) {
            $contract_item = Model('contract')->getContractItemByCache();
        }
        Tpl::output('contract_item', $contract_item);

        $model_goods = Model('goods');

        //查库搜索

        //处理排序
        $order = 'is_own_shop desc,goods_id desc';
        if (in_array($_GET['key'], ['1', '2', '3'])) {
            $sequence = $_GET['order'] == '1' ? 'asc' : 'desc';
            $order    = str_replace(['1', '2', '3'], ['goods_salenum', 'goods_click', 'goods_promotion_price'], $_GET['key']);
            $order    .= ' ' . $sequence;
        }

        // 字段
        $fields = "goods_id,goods_commonid,goods_name,goods_jingle,gc_id,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,brand_id,color_id,gc_id_3,gc_id_1,gc_id_2,goods_verify,goods_state,is_own_shop,evaluation_good_star,evaluation_count,is_virtual,is_fcode,is_presell,is_book,book_down_time,areaid_1";
        //构造消费者保障服务字段
        if ($contract_item) {
            foreach ($contract_item as $citem_key => $citem_val) {
                $fields .= ",contract_{$citem_key}";
            }
        }

        $goods_class = Model('goods_class')->getGoodsClassForCacheModel();
        $condition   = [];
        if (isset($goods_param['class'])) {
            // 如果是 全球跨境 或者海豚主场 那么就会有 4 级分类，但是数据库只会存最后三级，所以将 4 改为 3
            $depth                        = $goods_param['class']['depth'];
            $condition['gc_id_' . $depth] = $goods_param['class']['gc_id'];
        }
        if (intval($_GET['b_id']) > 0) {
            $condition['brand_id'] = intval($_GET['b_id']);
        }
        if ($_GET['keyword'] != '') {
            $condition['goods_name|goods_jingle'] = ['like', '%' . $_GET['keyword'] . '%'];
        }
        if (intval($_GET['area_id']) > 0) {
            $condition['areaid_1'] = intval($_GET['area_id']);
        }
        if ($_GET['type'] == 1) {
            $condition['is_own_shop'] = 1;
        }
        if ($_GET['new'] == 1) {
            $condition['is_new_arrival'] = 1;
        }
        if ($_GET['yx'] == 1) {
            $condition['is_select'] = 1;
        }
        //消费者保障服务
        if ($contract_item && $search_ci_arr) {
            foreach ($search_ci_arr as $ci_val) {
                $condition["contract_{$ci_val}"] = 1;
            }
        }

        if (isset($goods_param['goodsid_array'])) {
            $condition['goods_id'] = ['in', $goods_param['goodsid_array']];
        }
        if ($goods_class[$default_classid]['show_type'] == 1) {
            $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fields, $order, self::PAGESIZE);
        } else {
            $count      = $model_goods->getGoodsOnlineCount($condition, "distinct goods_commonid");
            $goods_list = $model_goods->getGoodsOnlineList($condition, $fields, self::PAGESIZE, $order, 0, 'goods_commonid', false, $count);
        }

        Tpl::output('search_ci_str', $search_ci_str);
        Tpl::output('search_ci_arr', $search_ci_arr);
        Tpl::output('show_page1', $model_goods->showpage(4));
        Tpl::output('show_page', $model_goods->showpage(5));

        if (!empty($goods_list)) {

            //查库搜索
            $commonid_array = []; // 商品公共id数组
            $storeid_array  = [];       // 店铺id数组
            foreach ($goods_list as $value) {
                $commonid_array[] = $value['goods_commonid'];
                $storeid_array[]  = $value['store_id'];
            }
            $commonid_array = array_unique($commonid_array);
            $storeid_array  = array_unique($storeid_array);
            // 商品多图
            $goodsimage_more = $model_goods->getGoodsImageList(['goods_commonid' => ['in', $commonid_array]], '*', 'is_default desc,goods_image_id asc');
            // 店铺
            $store_list = Model('store')->getStoreMemberIDList($storeid_array);
            //处理商品消费者保障服务信息
            $goods_list = $model_goods->getGoodsContract($goods_list, $contract_item);


            //搜索的关键字
            $search_keyword = $_GET['keyword'];

            foreach ($goods_list as $key => $value) {

                // 商品多图
                if ($goods_class[$default_classid]['show_type'] == 1) {
                    foreach ($goodsimage_more as $v) {
                        if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id']) {
                            $goods_list[$key]['image'][] = $v['goods_image'];
                        }
                    }
                } else {
                    foreach ($goodsimage_more as $v) {
                        if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id']) {
                            $goods_list[$key]['image'][] = $v['goods_image'];
                        }
                    }
                }

                // 店铺的开店会员编号
                $store_id                         = $value['store_id'];
                $goods_list[$key]['member_id']    = $store_list[$store_id]['member_id'];
                $goods_list[$key]['store_domain'] = $store_list[$store_id]['store_domain'];

                //将关键字置红
                if ($search_keyword) {
                    $goods_list[$key]['goods_name_highlight'] = str_replace($search_keyword, '<font style="color:#f00;">' . $search_keyword . '</font>', $value['goods_name']);
                } else {
                    $goods_list[$key]['goods_name_highlight'] = $value['goods_name'];
                }

                // 验证预定商品是否到期
                if ($value['is_book'] == 1) {
                    if ($value['book_down_time'] < TIMESTAMP) {
                        QueueClient::push('updateGoodsPromotionPriceByGoodsId', $value['goods_id']);
                        $goods_list[$key]['is_book'] = 0;
                    }
                }
            }
        }
        $goods_num = $model_goods->getGoodsCommonCount($condition);
        Tpl::output('goods_num', $goods_num);
        Tpl::output('goods_list', $goods_list);
        if ($_GET['keyword'] != '') {
            Tpl::output('show_keyword', $_GET['keyword']);
        } else {
            Tpl::output('show_keyword', $goods_param['class']['gc_name']);
        }

        $model_goods_class = Model('goods_class');

        // SEO
        if ($_GET['keyword'] == '') {
            $seo_class_name = $goods_param['class']['gc_name'];
            if (is_numeric($_GET['cate_id']) && empty($_GET['keyword'])) {
                $seo_info = $model_goods_class->getKeyWords(intval($_GET['cate_id']));
                if (empty($seo_info[1])) {
                    $seo_info[1] = C('site_name') . ' - ' . $seo_class_name;
                }
                Model('seo')->type($seo_info)->param(['name' => $seo_class_name])->show();
            }
        } elseif ($_GET['keyword'] != '') {
            Tpl::output('html_title', (empty($_GET['keyword']) ? '' : $_GET['keyword'] . ' - ') . C('site_name') . L('nc_common_search'));
        }

        // 当前位置导航
        $nav_link_list = $model_goods_class->getGoodsClassNav(intval($_GET['cate_id']));
        Tpl::output('nav_link_list', $nav_link_list);


        // 地区
        $province_array = Model('area')->getTopLevelAreas();
        Tpl::output('province_array', $province_array);


        loadfunc('search');
        //分类热销
        $hot_goods_list = $model_goods->getGoodsOnlineList($condition, '*', 0, 'goods_salenum desc', 5);
        Tpl::output('hot_goods_list', $hot_goods_list);
        // 浏览过的商品
        $viewed_goods = Model('goods_browse')->getViewedGoodsList($_SESSION['member_id'], 20);
        Tpl::output('viewed_goods', $viewed_goods);

        $cate_id = isset($_GET['cate_id']) ? $_GET['cate_id'] : 0;
        // 分类筛选（显示当前分类的父级直到顶级 以及 当前分类的同级）
        $goods_class_model    = Model('goods_class');
        $goods_class_where    = [];
        $old_goods_class_list = $goods_class_model->getGoodsClassList($goods_class_where);
        // 以id作为数组的键
        $new_goods_class_list = [];
        foreach ($old_goods_class_list as $k => $v) {
            $new_goods_class_list[$v['gc_id']] = $v;
        }
        $tree_model = new Tree();
        // 获取所有分类(要去掉海豚主场和全球跨境的分类)
        $kj_first_id = $model_goods_class::KJ_CATEGORY_TYPE;    // 全球跨境顶级id
        $ht_first_id = $model_goods_class::HT_CATEGORY_TYPE;    // 海豚主场顶级id


        $goods_class_arr_for_id = rkcache('goods_class_arr_for_id');
        if (empty($goods_class_arr_for_id)) {
            $goods_class_arr_for_id = $tree_model->toIdTree($new_goods_class_list, 'gc_id', 'gc_parent_id');
            wkcache('goods_class_arr_for_id', $goods_class_arr_for_id);
        }

        $first_id = 0;
        if (intval($_GET['cate_id']) > 0) {
            // 获取当前类型深度直到顶级
            $root_id_arr = $model_goods_class->getGoodsClassArrayFirstId(intval($_GET['cate_id']));
            // 获取当前类型的顶级分类id
            $first_id = reset($root_id_arr);
            if (in_array($first_id, [$kj_first_id, $ht_first_id])) {
                unset($new_goods_class_list[$first_id]);
            }
        }
        $goods_class_arr = $tree_model->getParent($new_goods_class_list, 'gc_id', 'gc_parent_id', $cate_id);

        // 得到自定义导航信息
        $nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0;
        /*if(in_array($first_id,[$kj_first_id])){
            Tpl::output('index_sign', 14);
        }elseif (in_array($first_id,[$ht_first_id])){
            Tpl::output('index_sign', 50);
        }else{
            Tpl::setLayout('home_layout');
        }*/

        if (in_array($first_id, [$ht_first_id])) {
            Tpl::output('index_sign', 50);
        } else {
            if (in_array($first_id, [$kj_first_id])) {
                Tpl::output('index_sign', 14);
            }
            Tpl::setLayout('home_layout');
        }


        // 如果当前选中的分类属于 全球跨境 或者 海豚主场 ，那么将当前分类顶级父类的下一级作为顶级父类
        if (in_array($first_id, [$kj_first_id, $ht_first_id])) {
            // 新的全部分类
            $goods_class_arr_for_id = $goods_class_arr_for_id[$first_id]['_child'];
        }

        $goods_nav_arr = [];
        if (isset($goods_class_arr['third_pid'])) {
            // 如果是第三级，就展示所有父级以及同级的所有信息
            $goods_class_arr['second_arr']['_child']                                = $goods_class_arr_for_id[$goods_class_arr['first_pid']]['_child'][$goods_class_arr['second_pid']]['_child'];
            $goods_class_arr['first_arr']['_child'][$goods_class_arr['second_pid']] = $goods_class_arr['second_arr'];
            $goods_nav_arr[$goods_class_arr['first_pid']]                           = $goods_class_arr['first_arr'];
        } else if (isset($goods_class_arr['second_pid'])) {
            // 如果是第二级，展示父级的信息，以及同级的所有信息
            $goods_class_arr['first_arr']['_child']       = $goods_class_arr_for_id[$goods_class_arr['first_pid']]['_child'];
            $goods_nav_arr[$goods_class_arr['first_pid']] = $goods_class_arr['first_arr'];
        } else {
            $goods_nav_arr = $goods_class_arr_for_id;
        }

        /*    $first_id_arr = reset($goods_nav_arr);
            $second_class_arr = reset($first_id_arr['_child']);
            $second_class_id = $second_class_arr['gc_id'];
            print_r($goods_nav_arr);die;*/
        $left_nav_html = $this->getLeftHtml($goods_nav_arr, $goods_class_arr);
        Tpl::output('left_nav_html', $left_nav_html);
//        Tpl::output('second_class_id', $second_class_id);
        Tpl::showpage('cate/index');
    }

    public function htOp()
    {
        $model_web_config = Model('web_config');
        //板块信息
        $web_html = $model_web_config->getWebHtml('index_ht');
        Tpl::output('web_html', $web_html);
        $index_adv_html = $model_web_config->where(['web_id' => 619])->find();
        Tpl::output('index_adv_html', $index_adv_html);
        $code_list = $model_web_config->getWebList(['web_page' => 'ht_index']);
        Tpl::output('ht_index', current($code_list));
        Tpl::output('index_sign', 50);
        Tpl::output('webTitle', ' - 海豚主场');
        Tpl::showpage('cate/ht');
    }

    public function getLeftHtml($goods_nav_arr, $goods_class_arr)
    {
        $first_pid  = (isset($goods_class_arr['first_pid']) && $goods_class_arr['first_pid']) ? $goods_class_arr['first_pid'] : null;
        $second_pid = (isset($goods_class_arr['second_pid']) && $goods_class_arr['second_pid']) ? $goods_class_arr['second_pid'] : null;
        $third_pid  = (isset($goods_class_arr['third_pid']) && $goods_class_arr['third_pid']) ? $goods_class_arr['third_pid'] : null;
        $html       = $this->getFirstHtml($goods_nav_arr, $goods_class_arr, $first_pid, $second_pid, $third_pid);
        return $html;
    }

    public function getFirstHtml($goods_nav_arr, $goods_class_arr, $first_pid, $second_pid, $third_pid)
    {
        $default_html = '<ul id="files" class="tree" role="tree">';
        if (isset($first_pid)) {
            $default_html .= '<li role="treeitem" aria-expanded="true"><i class="tree-parent" tabindex="0"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $goods_nav_arr[$goods_class_arr['first_pid']]['gc_id']]) . '" class="selected">' . $goods_nav_arr[$goods_class_arr['first_pid']]['gc_name'] . '</a>';
            if (isset($goods_nav_arr[$goods_class_arr['first_pid']]['_child'])) {
                // 获取选中一级分类的子级
                $default_html .= $this->getSecondHtml($goods_nav_arr[$goods_class_arr['first_pid']]['_child'], $second_pid, $third_pid);
                $default_html .= '</li>';
            }
            // 获取其他未选中的一级分类及其所有子级
            /*  foreach ($goods_nav_arr as $first_val) {
                  if ($first_val['gc_id'] != $first_pid) {
                      $default_html .= '<li role="treeitem" aria-expanded="false"><i class="tree-parent tree-parent-collapsed" tabindex="-1"></i><a href="' . urlShop('cate', 'index', array('cate_id' => $first_val['gc_id'])) . '">' . $first_val['gc_name'] . '</a>';
                      if (isset($first_val['_child']) && !empty($first_val['_child'])) {
                          $default_html .= $this->getSecondHtml($first_val['_child'], $second_pid, $third_pid);
                      }
                      $default_html .= '</li>';
                  }
              }*/

        } else {
            foreach ($goods_nav_arr as $first_val) {
                // 如果没有选中的一级分类，这里就显示所有的一级分类
                $default_html .= '<li role="treeitem" aria-expanded="false"><i class="tree-parent tree-parent-collapsed" tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $first_val['gc_id']]) . '">' . $first_val['gc_name'] . '</a>';
                if (isset($first_val['_child']) && !empty($first_val['_child'])) {
                    $default_html .= $this->getSecondHtml($first_val['_child'], null, null);
                }
                $default_html .= '</li>';
            }
        }
        $default_html .= '</ul>';
        return $default_html;
    }

    public function getSecondHtml($second_goods, $second_pid, $third_id)
    {
        $default_html = '<ul role="group" class="tree-group-collapsed">';
        if (isset($second_pid)) {
            $default_html .= '<li role="treeitem" aria-expanded="true"><i class="tree-parent" tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $second_goods[$second_pid]['gc_id']]) . '" class="selected">' . $second_goods[$second_pid]['gc_name'] . '</a>';
            if (isset($second_goods[$second_pid]['_child'])) {
                // 获取选中二级分类的子级
                $default_html .= $this->getThirdHtml($second_goods[$second_pid]['_child'], $third_id);
                $default_html .= '</li>';
            }
            // 获取其他未选中的二级分类及其所有子级
            foreach ($second_goods as $second_val) {
                if ($second_val['gc_id'] != $second_pid) {
                    $default_html .= '<li role="treeitem" aria-expanded="false"><i class="tree-parent tree-parent-collapsed" tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $second_val['gc_id']]) . '">' . $second_val['gc_name'] . '</a>';
                    if (isset($second_val['_child']) && !empty($second_val['_child'])) {
                        $default_html .= $this->getThirdHtml($second_val['_child'], $third_id);
                    }
                    $default_html .= '</li>';
                }
            }
        } else {
            foreach ($second_goods as $second_val) {
                $default_html .= '<li role="treeitem" aria-expanded="false"><i class="tree-parent tree-parent-collapsed" tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $second_val['gc_id']]) . '">' . $second_val['gc_name'] . '</a>';
                if (isset($second_val['_child']) && !empty($second_val['_child'])) {
                    $default_html .= $this->getThirdHtml($second_val['_child'], null);
                }
                $default_html .= '</li>';
            }
        }
        $default_html .= '</ul>';
        return $default_html;
    }

    public function getThirdHtml($third_goods, $third_pid)
    {
        $default_html = '<ul role="group" class="">';
        if (isset($third_pid)) {
            $default_html .= '<li class="tree-parent tree-parent-collapsed" role="treeitem"><i tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $third_goods[$third_pid]['gc_id']]) . '" class="selected">' . $third_goods[$third_pid]['gc_name'] . '</a></li>';
            foreach ($third_goods as $third_val) {
                if ($third_val['gc_id'] != $third_pid) {
                    $default_html .= '<li class="tree-parent tree-parent-collapsed" role="treeitem"><i tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $third_val['gc_id']]) . '">' . $third_val['gc_name'] . '</a>';
                    $default_html .= '</li>';
                }
            }
        } else {
            foreach ($third_goods as $third_val) {
                $default_html .= '<li class="tree-parent tree-parent-collapsed" role="treeitem"><i tabindex="-1"></i><a href="' . urlShop('cate', 'index', ['cate_id' => $third_val['gc_id']]) . '">' . $third_val['gc_name'] . '</a>';
                $default_html .= '</li>';
            }
        }

        $default_html .= '</ul>';
        return $default_html;
    }
}