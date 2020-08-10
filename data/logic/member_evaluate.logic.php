<?php
/**
 * 评价行为
 *
 * @copyright  Copyright (c) 2007-2015 ccynet Inc. (http://www.ccynet.net)
 * @license    http://www.ccynet.net
 * @link       http://www.ccynet.net
 * @since      File available since Release v1.1
 */

defined('ByCCYNet') or exit('Access Invalid!');

class member_evaluateLogic
{

    public function evaluateListDity($goods_eval_list)
    {
        foreach ($goods_eval_list as $key => $value) {
            $goods_eval_list[$key]['member_avatar'] = getMemberAvatarForID($value['geval_frommemberid']);
        }
        return $goods_eval_list;
    }
}
