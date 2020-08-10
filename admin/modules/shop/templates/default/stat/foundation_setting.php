<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['nc_statgeneral'];?></h3>
        <h5>商城统计最新情报及相关设置</h5>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>

  <form method="post" action="index.php" name="form" id="form">
    <input type="hidden" value="ok" name="form_submit">
    <input type="hidden" name="controller" value="stat_general" />
    <input type="hidden" name="action" value="saveFoundationSetting" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"></dt>
        <dd class="opt">
          <ul class="ncap-ajax-add">
            <li>
                <label><span style="width: 280px; text-align: right; display: inline-block;">个人消费分红比例设置：</span>
                <input type="text" class="txt w100 mr5" value="<?php echo $output['USER_CONSUMPTION_BONUS_RATIO'] ?>" name="user_consumption_bonus_ratio">%
              </label>
            </li>
          </ul>
        </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">平台税率比例设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['PLATFORM_TAX_RATE'] ?>" name="platform_tax_rate">%
                      </label>
                  </li>
              </ul>
          </dd>

          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">消费日分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_sales_day_bonus_money'] ?>" name="type_sales_day_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">明星日分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_selling_star_day_bonus_money'] ?>" name="type_selling_star_day_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit" style="display: none;"></dt>
          <dd class="opt" style="display: none;">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">共享日分红（新注册会员）最高分红金额设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_share_day_bonus_for_new_money'] ?>" name="type_share_day_bonus_for_new_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit" style="display: none;"></dt>
          <dd class="opt" style="display: none;">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">共享日分红最高分红金额设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_share_day_bonus_for_old_money'] ?>" name="type_share_day_bonus_for_old_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">中层管理周分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_middle_management_bonus_weekly_money'] ?>" name="type_middle_management_bonus_weekly_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">至尊消费月分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_black_diamond_sales_bonus_money'] ?>" name="type_black_diamond_sales_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">销售精英月分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_elite_monthly_bonus_money'] ?>" name="type_elite_monthly_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">高层销售月分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_top_selling_monthly_bonus_money'] ?>" name="type_top_selling_monthly_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">销售新人奖金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_new_sales_award_money'] ?>" name="type_new_sales_award_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">共享日分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_share_day_bonus_money'] ?>" name="type_share_day_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">销售管理普惠周奖金上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_sales_management_week_bonus_money'] ?>" name="type_sales_management_week_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">供应商推荐奖金上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_supplier_referral_bonus_money'] ?>" name="type_supplier_referral_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit" style="display: none;"></dt>
          <dd class="opt" style="display: none;">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">个人消费分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_sales_share_bonus_money'] ?>" name="type_sales_share_bonus_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">团队销售分享分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_sales_share_bonus_for_team_money'] ?>" name="type_sales_share_bonus_for_team_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">个人微商销售分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_sales_share_bonus_for_seller_money'] ?>" name="type_sales_share_bonus_for_seller_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">消费养老补贴分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_consumption_capital_subsidy_consumption_pension_money'] ?>" name="type_consumption_capital_subsidy_consumption_pension_money">元
                      </label>
                  </li>
              </ul>
          </dd>
          <dt class="tit"></dt>
          <dd class="opt">
              <ul class="ncap-ajax-add">
                  <li>
                      <label><span style="width: 280px; text-align: right; display: inline-block;">车房梦想补贴分红金额上限设置：</span>
                          <input type="text" class="txt w100 mr5" value="<?php echo $output['type_consumption_capital_subsidy_garages_dream_money'] ?>" name="type_consumption_capital_subsidy_garages_dream_money">元
                      </label>
                  </li>
              </ul>
          </dd>

      </dl>
      <div class="bot"><a id="submit-btn" class="ncap-btn-big ncap-btn-green" href="JavaScript:void(0);"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript">

$(function(){
	
	$('#submit-btn').click(function(){


        $('#form').submit();

    });
})
</script>