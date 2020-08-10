<link  href="/layui/css/layui.css" rel="stylesheet" type="text/css"/>
<script src="/layui/layui.js"></script>
<script src="/data/resource/js/jquery.js"></script>



<div style="width:90%;margin:10px auto;" class="layui-form-pane layui-form">


    <div class="layui-form-item">
        <label class="layui-form-label">开户行</label>
        <div class="layui-input-block">
            <input type="text" name="bank_name" id="bank_name"  placeholder="请输入开户行"  class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">银行卡号</label>
        <div class="layui-input-block">
            <input type="number" name="bank_card" id="bank_card"  autocomplete="off"  placeholder="请输入银行卡号"  class="layui-input">
        </div>
    </div>

    <div class="layui-form-item ">
        <label class="layui-form-label">开户姓名</label>
        <div class="layui-input-block">
            <input type="text" name="username" id="username" placeholder="开户姓名"  class="layui-input">
        </div>
    </div>

    <div class="layui-form-item ">
        <label class="layui-form-label">手机号码</label>
        <div class="layui-input-block">
            <input type="number" name="phone" id="phone"  autocomplete="off"  placeholder="手机号码"  class="layui-input">
        </div>
    </div>

    <div class="layui-form-item ">
        <label class="layui-form-label">默认提现卡</label>
        <div class="layui-input-block">
            <input type="checkbox" onclick="alert(this.val())" value="1" name="default" lay-skin="switch" lay-text="是|否" checked>
        </div>
    </div>

    <div style="position:fixed;bottom:20px;width:350px;">
        <button style="width:100%;" onclick="editBank()" class="layui-btn layui-btn-normal">保存</button>
    </div>

</div>

<input type="hidden" value="1" id="checkSubmits"/>

<script>

    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });

    function editBank(){
        var checkSubmit = $("#checkSubmits").val();
        var bankName = $('#bank_name').val();
        var bankCard = $('#bank_card').val();
        var bankUserName = $('#username').val();
        var bankPhone  =$('#phone').val();
        if(checkSubmit==1){
            $("#checkSubmits").val(0);
            if(bankName==''){
                layer.tips('开户行不能为空', '#bank_name', {tips:3, time:1000});
                $("#checkSubmits").val(1);
                return;
            }
            if(bankCard==''){
                layer.tips('银行卡号不能为空', '#bank_card', {tips:3, time:1000});
                $("#checkSubmits").val(1);
                return;
            }
            if(bankUserName==''){
                layer.tips('开户姓名不能为空', '#username', {tips:3, time:1000});
                $("#checkSubmits").val(1);
                return;
            }
            if(bankPhone==''){
                layer.tips('预留手机不能为空', '#phone', {tips:3, time:1000});
                $("#checkSubmits").val(1);
                return;
            }
            var params={};
            var isDefault=0;
            params.bankName =bankName;
            params.bankCard =bankCard;
            params.bankUserName =bankUserName;
            params.bankPhone =bankPhone;
            if($('.layui-unselect>em').html()=='是'){
                isDefault =1;
            }
            params.isDefault=isDefault;
            layer.load();
            $.post('<?php echo urlMember('bank','editBank');?>',{params:params},function(data){
                layer.closeAll();
                if(data==1){
                    layer.msg('保存成功', {icon: 1});
                    window.parent.location.reload();
                }else{
                    layer.msg('保存失败!', {icon: 5});
                    $("#checkSubmits").val(1);
                }
            })
        }
    }


</script>