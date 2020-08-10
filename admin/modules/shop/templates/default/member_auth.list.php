<?php defined('ByCCYNet') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>实名认证</h3>
        <h5>会员实名认证记录管理</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a href="JavaScript:void(0);" class="current">实名认证</a></li>
      </ul>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span>
    </div>
    <ul>
      <li>仔细核对会员真实姓名、用户名、身份证号、身份证照片信息是否符合</li>
            <li>你可对会员实名进行审核通过操作</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
  <div class="ncap-search-ban-s" id="searchBarOpen"><i class="fa fa-search-plus"></i>高级搜索</div>
  <div class="ncap-search-bar" style="display: block">
    <div class="handle-btn" id="searchBarClose"><i class="fa fa-search-minus"></i>收起边栏</div>
    <div class="title">
      <h3>高级搜索</h3>
    </div>
    <form method="get" name="formSearch" id="formSearch">
      <div id="searchCon" class="content">
        <div class="layout-box">
          <dl>
            <dt>用户ID</dt>
            <dd>
              <label>
                <input type="text" value="<?php echo $_GET['member_id'];?>" name="member_id" id="member_id" class="s-input-txt" placeholder="输入会员ID">
              </label>
            </dd>
          </dl>
          <dl>
            <dt>用户名</dt>
            <dd>
              <label>
                <input type="text" value="<?php echo $_GET['member_name'];?>" name="member_name" id="member_name" class="s-input-txt" placeholder="输入会员用户名">
              </label>
            </dd>
          </dl>
            <dl>
                <dt>真实姓名</dt>
                <dd>
                    <label>
                        <input type="text" value="<?php echo $_GET['real_name'];?>" name="real_name" id="real_name" class="s-input-txt" placeholder="输入会员真实姓名">
                    </label>
                </dd>
            </dl>
            <dl>
                <dt>身份证号码</dt>
                <dd>
                    <label>
                        <input type="text" value="<?php echo $_GET['member_id_number'];?>" name="member_id_number" id="member_id_number" class="s-input-txt" placeholder="输入会员身份证号码">
                    </label>
                </dd>
            </dl>
        </div>
      </div>
      <div class="bottom"><a href="javascript:void(0);" id="ncsubmit" class="ncap-btn ncap-btn-green mr5">提交查询</a><a href="javascript:void(0);" id="ncreset" class="ncap-btn ncap-btn-orange" title="撤销查询结果，还原列表项所有内容"><i class="fa fa-retweet"></i><?php echo $lang['nc_cancel_search'];?></a></div>
    </form>
  </div>

    <div id="pic_dialog" style="display: none">
        <p style="font-size: 18px;font-family: "microsoft yahei", "Microsoft YaHei"">姓名:【<span id="name"></span>】 身份证号码:【<span id="number"></span>】</p>
        <img style="width: 500px;height: 320px" id="front" src="" alt="身份证正面照"/>
        <img style="width: 500px;height: 320px" id="back" src="" alt="身份证反面照"/>
    </div>


    <!--新增弹出框 2018/04/12 start-->
    <div id="aic_dialog" style="display: none">
        <input type="hidden" id="userId" value=""/>
        <input type="text"  style='width:238px;' id="caseInfo"  class='caseInfo' name="caseInfo" value="" placeholder="请填写而拒绝原因"><br/><br/>
        <button style="width:100%;padding:0 20px; " onclick="submit()">提交</button>
    </div>
    <!--新增弹出框 2018/04/12 end-->



</div>
<script type="text/javascript">
    function show_dialog1(id,name,number,front,back) {//弹出框
        $("#name").html(name);
        $("#number").html(number);
        $("#front").attr('src',front);
        $("#back").attr('src',back);
        var d = DialogManager.create(id);//(执行一次)
        var dialog_html = $("#" + id + "_dialog").html();
        d.setTitle('实名信息');
        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(510);
        d.show('center', 1);
    }


    /*新增弹出框 2018/04/12 start*/
    function show_auth(id,userId) {//弹出框
        $('#userId').val(userId);
        var d = DialogManager.create(id);//(执行一次)
        var dialog_html = $("#" + id + "_dialog").html();
        d.setTitle('拒绝原因');
        d.setContents('<div id="' + id + '_dialog" class="' + id + '_dialog">' + dialog_html + '</div>');
        d.setWidth(250);
        d.show('center', 1);
    }

    //拒绝原因
    function submit(){
        var uesrId= $('#userId').val();
        var caseInfo = $('.caseInfo').eq(1).val();
        if(caseInfo!=''){
            $.post('index.php?controller=member_auth&action=refusedAuth',{userId:uesrId,caseInfo:caseInfo},function(data){
                if(data==1){
                    location.href='';
                }
                console.log(data);
            })
        }else{
            alert('请填写拒绝原因!');
        }
    }


    /*新增弹出框 2018/04/12 end*/



$(function(){
    $('#searchBarOpen').click();
    $('')
    // 高级搜索提交
    $('#ncsubmit').click(function(){
        $("#flexigrid").flexOptions({url: 'index.php?controller=member_auth&action=get_xml&'+$("#formSearch").serialize(),query:'',qtype:''}).flexReload();
    });

    // 高级搜索重置
    $('#ncreset').click(function(){
        $("#flexigrid").flexOptions({url: 'index.php?controller=member_auth&action=get_xml'}).flexReload();
        $("#formSearch")[0].reset();
    });
    $("#flexigrid").flexigrid({
        url: 'index.php?controller=member_auth&action=get_xml&'+$("#formSearch").serialize(),
        colModel : [
            {display: '操作', name : 'operation', width : 170, sortable : false, align: 'center', className: 'handle-s'},
            {display: '用户ID', name : 'member_id', width : 60, sortable : false, align: 'left'},
            {display: '用户名', name : 'member_name', width : 120, sortable : false, align: 'left'},
            {display: '真实姓名', name : 'member_truename', width : 120, sortable : false, align: 'left'},
            {display: '身份证号', name : 'member_id_number', width : 180, sortable : true, align: 'left'},
            {display: '身份证照片', name : 'id_card_photo', width : 400, sortable : false, align: 'left'},
            ],
        sortname: "id",
        sortorder: "desc",
        title: '实名认证列表'
    });
});
</script>
