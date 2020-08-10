<script src="<?php echo jf_TEMPLATES_URL ?>/js/jquery.min.js"></script>
<script src="<?php echo jf_TEMPLATES_URL ?>/js/turntable.js"></script>
<style type="text/css">
    body {
        width: 100%;
        height: auto;
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
    }

    body, td, th {
        font-size: 12px;
    }

    hmtl, body, body, td, th {
        margin: 0;
        padding: 0;
    }

    /*=================================================抽奖主体页面开始========================================================*/
    div#Luck_draw {
        width: 100%;
        height: auto;
        padding-bottom: 25px;
        overflow: hidden;
        background: #fff8d1 url(<?php echo jf_TEMPLATES_URL ?>/images/bj.jpg) repeat-x center top
    }

    div#Luck_draw div#Luck_body {
        width: 1150px;
        height: auto;
        overflow: hidden;
        clear: both;
        margin: 0 auto;
    }

    /*抽奖主容器*/
    div#Luck_draw div#Luck_top {
        width: 994px;
        height: 900px;
        background: url(<?php echo jf_TEMPLATES_URL ?>/images/Luck_bj.png) no-repeat;
        float: right;
        margin-top: 80px;
        clear: both;
    }

    div#Luck_draw .lottery {
        position: relative;
        display: inline-block;
        width: 600px;
        height: 600px;
        overflow: hidden;
        margin-left: 180px;
        margin-top: 265px;

    }

    div#Luck_draw .lottery img {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -76px;
        margin-top: -82px;
        cursor: pointer;
    }

    div#Luck_draw #message {
        position: absolute;
        top: 0px;
        left: 10%;
    }

    /*规则及结果部分*/
    div#Luck_draw div#Luck_Form {
        width: 994px;
        height: auto;
        overflow: hidden;
        clear: both;
        float: right;
        margin-top: 25px;

    }

    div#Luck_draw .Luck_gz {
        width: 480px;
        height: 430px;
        background: #FFF;
        border: 1px solid #FFF;
        border-radius: 5px;
        overflow: hidden;
        float: left;
    }

    div#Luck_draw .Luck_jg {
        width: 480px;
        height: 430px;
        background: #FFF;
        border: 1px solid #FFF;
        border-radius: 5px;
        overflow: hidden;
        float: right;
    }

    div#Luck_draw .Luck_gz .tit {
        width: 420px;
        height: 101px;
        margin: 0 auto;
        background: url(<?php echo jf_TEMPLATES_URL ?>/images/Luck_gz_tt.png) no-repeat;
        clear: both;
        font-size: 34px;
        font-weight: bold;
        color: #dd2f47;
        text-align: center;
        line-height: 85px;
        margin-top: 25px;
    }

    div#Luck_draw .Luck_gz .inner {
        width: 420px;
        height: 260px;
        overflow-x: hidden;
        overflow-y: auto;
        margin: 0 auto;
        margin-top: 20px;
    }

    div#Luck_draw .Luck_gz ul, div#Luck_draw .Luck_gz ul li {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style: none;
    }

    div#Luck_draw .Luck_gz ul li {
        font-size: 14px;
        line-height: 30px;
        margin-bottom: 5px;
    }

    div#Luck_draw .Luck_gz ul li span {
        padding: 3px 8px 3px 8px;
        background: #ffcd46;
        border-radius: 5px;
        margin-right: 5px;
    }

    div#Luck_draw .Luck_jg .tit {
        width: 420px;
        height: 34px;
        margin: 0 auto;
        clear: both;
        font-size: 34px;
        font-weight: bold;
        color: #d3233b;
        text-align: center;
        line-height: 34px;
        margin-top: 55px;
    }

    div#Luck_draw .Luck_jg .inner {
        width: 420px;
        height: 280px;
        overflow: hidden;
        margin: 0 auto;
        margin-top: 20px;
        background: #d3233b;
        border-radius: 5PX;
        padding: 5px 0 5px 0;
    }

    div#Luck_draw .Luck_jg ul, div#Luck_draw .Luck_jg ul li {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style: none;
    }

    div#Luck_draw .Luck_jg .inner ul {
        display: block;
        width: 400px;
        margin-top: 10px;
        margin-left: 10px;
    }

    div#Luck_draw .Luck_jg ul li {
        font-size: 14px;
        height: 30px;
        line-height: 30px;
        margin-bottom: 5px;
        background: #dc4053;
    }

    div#Luck_draw .Luck_jg ul li span {
        display: block;
        height: 100%;
        float: left;
        color: #FFF;
    }

    div#Luck_draw .Luck_jg ul li span.username {
        width: 25%;
        overflow: hidden;
        text-indent: 8px;
    }

    div#Luck_draw .Luck_jg ul li span.shangpin {
        width: 53%;
        overflow: hidden;
    }

    div#Luck_draw .Luck_jg ul li span.data {
        width: 20%;
        overflow: hidden;
        float: right;
    }

    div#Luck_draw div.Luck_clear {
        width: 100%;
        height: 282px;
        position: relative;
        clear: both;
        margin: 0 auto;
    }

    div#Luck_draw div.Luck_clear .Luck_clearinner {
        background: url(<?php echo jf_TEMPLATES_URL ?>/images/Luck_bott_tit.png) no-repeat left top;
        width: 100%;
        height: 282px;
        position: absolute;
        top: -50px;
        z-index: 999;
    }

    div#Luck_draw div.Luck_clear .Luck_clearinner h3 {
        height: 35px;
        line-height: 35px;
        width: 80%;
        display: block;
        font-size: 34px;
        font-weight: 800;
        color: #8c3b04;
        text-align: center;
        margin: 0 auto;
        margin-top: 220px;
    }

    div#Luck_draw div#Luck_bot {
        width: 100%;
        height: auto;
        overflow: hidden;
        clear: both;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_top {
        width: 100%;
        height: 500px;
        position: relative;
    }

    div#Luck_draw div#Luck_bot .Luck_dlsj {
        position: absolute;
        left: 130px;
        top: 0px;
        width: 283px;
        height: 127px;
        overflow: hidden;
    }

    div#Luck_draw div#Luck_bot .Luck_dlsj img {
        width: 283px;
        height: 127px;
    }

    div#Luck_draw div#Luck_bot .Luck_yxsm {
        position: absolute;
        left: 50px;
        top: 170px;
        width: 550px;
        height: 310px;
        background: url(<?php echo jf_TEMPLATES_URL ?>/images/Luck_img_03.png) no-repeat;
    }

    div#Luck_draw div#Luck_bot .Luck_dlsj_img {
        position: absolute;
        right: 30px;
        top: 120px;
        width: 407px;
        height: 256px;
        overflow: hidden;
    }

    div#Luck_draw div#Luck_bot .Luck_dlsj_img a img, div#Luck_draw div#Luck_bot .Luck_dlsj_img img {
        width: 407px;
        height: 256px;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_inner {
        width: 100%;
        height: auto;
        overflow: hidden;
        margin-top: 20px;
        position: relative;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_inner ul {
        padding-left: 150px;
        list-style: none;
        list-style-type: none;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_inner li {
        background: url(<?php echo jf_TEMPLATES_URL ?>/images/Luck_img_05.png) no-repeat;
        width: 125px;
        height: 178px;
        float: left;
        margin-left: 20px;
        margin-right: 35px;
        list-style: none;
        list-style-type: none;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_inner li a {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
    }

    div#Luck_draw div#Luck_bot .Luck_bot_inner li span {
        display: block;
        width: 100px;
        margin-left: 8px;
        margin-top: 120px;
        line-height: 20px;
        color: #FFF;
        font-size: 12px;
        text-align: center;
    }

    div#Luck_draw .Luck_yxsm .inner {
        width: 410px;
        height: 225px;
        overflow: hidden;
        margin-left: 80px;
        margin-top: 60px;
    }

    div#Luck_draw .Luck_yxsm ul, div#Luck_draw .Luck_yxsm ul li {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style: none;
    }

    div#Luck_draw .Luck_yxsm ul li {
        font-size: 14px;
        line-height: 25px;
        margin-bottom: 5px;
        color: #3e6d05;
    }

    div#Luck_draw .Luck_yxsm ul li span {
        padding: 3px 8px 3px 8px;
        background: #ffc91a;
        border-radius: 5px;
        margin-right: 5px;
    }

</style>
<!--[if lte IE 8]>
<style>
    .lottery img {
        display: none;
    }
</style>
<![endif]-->
</head>

<body>
<div id="Luck_draw">
    <div id="Luck_body">
        <div id="Luck_top">
            <div class="lottery">
                <canvas id="myCanvas" width="600" height="600">
                    当前浏览器版本过低，请使用其他浏览器尝试
                </canvas>
                <p id="message"></p>
                <img src="<?php echo jf_TEMPLATES_URL ?>/images/start.png" id="start">
            </div>

            <script>
                var wheelSurf
                // 初始化装盘数据 正常情况下应该由后台返回
                var initData = {
                    "success": true,
                    "list": [{
                        "id": <?php echo $output['list'][0]['id']?>,
                        "name": "<?php echo $output['list'][0]['prize_name']?>",
                        "image": "<?php echo $output['list'][0]['prize_image']?>",
                        "rank": 1,
                        "percent": <?php echo $output['list'][0]['prize_percent']?>
                    },
                        {
                            "id": <?php echo $output['list'][1]['id']?>,
                            "name": "<?php echo $output['list'][1]['prize_name']?>",
                            "image": "<?php echo $output['list'][1]['prize_image']?>",
                            "rank": 2,
                            "percent": <?php echo $output['list'][1]['prize_percent']?>
                        },
                        {
                            "id": <?php echo $output['list'][2]['id']?>,
                            "name": "<?php echo $output['list'][2]['prize_name']?>",
                            "image": "<?php echo $output['list'][2]['prize_image']?>",
                            "rank": 3,
                            "percent": <?php echo $output['list'][2]['prize_percent']?>
                        },
                        {
                            "id": <?php echo $output['list'][3]['id']?>,
                            "name": "<?php echo $output['list'][3]['prize_name']?>",
                            "image": "<?php echo $output['list'][3]['prize_image']?>",
                            "rank": 4,
                            "percent": <?php echo $output['list'][3]['prize_percent']?>
                        },
                        {
                            "id": <?php echo $output['list'][4]['id']?>,
                            "name": "<?php echo $output['list'][4]['prize_name']?>",
                            "image": "<?php echo $output['list'][4]['prize_image']?>",
                            "rank": 5,
                            "percent": <?php echo $output['list'][4]['prize_percent']?>
                        },
                        {
                            "id": <?php echo $output['list'][5]['id']?>,
                            "name": "<?php echo $output['list'][5]['prize_name']?>",
                            "image": "<?php echo $output['list'][5]['prize_image']?>",
                            "rank": 6,
                            "percent": <?php echo $output['list'][5]['prize_percent']?>
                        },
                        {
                            "id": <?php echo $output['list'][6]['id']?>,
                            "name": "<?php echo $output['list'][6]['prize_name']?>",
                            "image": "<?php echo $output['list'][6]['prize_image']?>",
                            "rank": 7,
                            "percent": <?php echo $output['list'][6]['prize_percent']?>
                        }
                    ]
                }

                // 计算分配获奖概率(前提所有奖品概率相加100%)
                function getGift() {
                    var percent = Math.random() * 100
                    var totalPercent = 0
                    for (var i = 0, l = initData.list.length; i < l; i++) {
                        totalPercent += initData.list[i].percent
                        if (percent <= totalPercent) {
                            return initData.list[i]
                        }
                    }
                }

                var list = {}

                var angel = 360 / initData.list.length
                // 格式化成插件需要的奖品列表格式
                for (var i = 0, l = initData.list.length; i < l; i++) {
                    list[initData.list[i].rank] = {
                        id: initData.list[i].id,
                        name: initData.list[i].name,
                        image: initData.list[i].image
                    }
                }
                // 查看奖品列表格式

                // 定义转盘奖品
                wheelSurf = $('#myCanvas').WheelSurf({
                    list: list, // 奖品 列表，(必填)
                    outerCircle: {
                        color: '#df1e15' // 外圈颜色(可选)
                    },
                    innerCircle: {
                        color: '#f4ad26' // 里圈颜色(可选)
                    },
                    dots: ['#fbf0a9', '#fbb936'], // 装饰点颜色(可选)
                    disk: ['#ffb933', '#ffe8b5', '#ffb933', '#ffd57c', '#ffb933', '#ffe8b5', '#ffd57c'], //中心奖盘的颜色，默认7彩(可选)
                    title: {
                        color: '#5c1e08',
                        font: '19px Arial'
                    } // 奖品标题样式(可选)
                })

                // 初始化转盘
                wheelSurf.init()
                // 抽奖
                var throttle = true;
                $("#start").on('click', function () {
                    var prize_open = <?php echo $output['prize_open'];?>;
                    var yes = <?php echo $output['yes'];?>;
                    var login = <?php echo $output['login'];?>;
                    if(login !=1){
                        alert('请您先登陆！');
                        window.location.href="/member/index.php?controller=login&action=index";
                        return false;
                    }
                    if(prize_open != 1){
                        alert('未开启抽奖！');return false;
                    }
                    if(yes != 1){
                        alert('今日抽奖次数已使用完！');return false;
                    }
                    var winData = getGift() // 正常情况下获奖信息应该由后台返回

                    $("#message").html('')
                    if (!throttle) {
                        return false;
                    }
                    throttle = false;
                    var count = 0;
                    // 计算奖品角度

                    for (var key in list) {
                        if (list.hasOwnProperty(key)) {
                            if (winData.id == list[key].id) {
                                break;
                            }
                            count++
                        }
                    }

                    // 转盘抽奖，
                    wheelSurf.lottery((count * angel + angel / 2), function () {
                        //$("#message").html(winData.name)
                        $.ajax({
                            type: "POST",
                            url: '/jf/index.php?controller=index&action=prize_good',
                            async:false,
                            dataType: "json",
                            data:{'id':winData.id},
                            success: function(data) {
                                if(data.status==1){
                                    alert("恭喜你！抽中:" + winData.name);
                                }else{
                                    alert(data.msg);
                                }

                            },
                            error: function(jqXHR){
                               alert("发生错误：" + jqXHR.status);
                            },
                        });
                        throttle = true;
                    })
                })


            </script>
        </div>
        <div id="Luck_Form">
            <div class="Luck_gz">
                <div class="tit">抽奖规则</div>
                <div class="inner">
                    <ul>
                        <li><span>1</span>本抽奖页面目前仅为效果测试页面，目前商城暂不提供奖品抽奖功能，将在后续开放，敬请期待！</li>
                        <li><span>2</span>用户成功获得奖品后，所获实物奖品会在3个工作日内统一发放；虚拟奖品即时开通到账;</li>
                        <li><span>3</span>用户获得奖品后10个工作日为最终申诉日，过期将不再受理本次活动的申诉事宜;</li>
                        <li><span>4</span>如本活动因不可抗力等原因无法执行，吾家网有权取消、终止、修改或暂停本活动;</li>
                        <li><span>5</span>如有问题请拨打400 013 6899，活动最终解释权归海吉壹佰电子商务(深圳)有限公司所有;</li>

                    </ul>
                </div>
            </div>
            <div class="Luck_jg">
                <div class="tit">中奖达人名单</div>
                <div class="inner">
                    <div class="maquee">
                        <ul>
                            <?php foreach ($output['prize_list'] as $key => $value) {?>
                                <li><span class="username"><?php echo $value['member_name']; ?></span><span class="shangpin"><?php echo $value['prize_name']; ?></span><span class="data"><?php echo date('Y-m-d H:i:s',$value['add_time']); ?></span>
                            </li>
                            <?php }?>


                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="Luck_clear">
            <div class="Luck_clearinner">
                <h3>取之于民，&nbsp;&nbsp;&nbsp;用之于民</h3>
            </div>
        </div>

        <div id="Luck_bot">
            <div class="Luck_bot_top">
                <div class="Luck_dlsj"><img src="<?php echo jf_TEMPLATES_URL ?>/images/Luck_img_o1.png"/></div>
                <div class="Luck_yxsm">
                    <div class="inner">
                        <ul>
                            <li><span>1</span>本抽奖页面目前仅为效果测试页面，目前商城暂不提供奖品抽奖功能，将在后续开放，敬请期待！</li>
                            <li><span>2</span>用户成功获得奖品后，所获实物奖品会在3个工作日内统一发放；虚拟奖品即时开通到账;</li>
                            <li><span>3</span>用户获得奖品后10个工作日为最终申诉日，过期将不再受理本次活动的申诉事宜;</li>

                            <li><span>4</span>如有问题请拨打400 013 6899，活动最终解释权归海吉壹佰电子商务(深圳)有限公司所有;</li>

                        </ul>
                    </div>
                </div>
                <div class="Luck_dlsj_img"><a onclick="javascript:alert('此功能暂未开放！');"><img
                                src="<?php echo jf_TEMPLATES_URL ?>/images/Luck_img_02.png"/></a></div>
            </div>
            <div class="Luck_bot_inner">
                <ul>
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:alert('此功能暂未开放！');">
                            <span>发起<br/>积分红包社交圈</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:alert('此功能暂未开放！');">
                            <span>设置<br/>积分红包</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:alert('此功能暂未开放！');">
                            <span>发现<br/>积分红包社交圈</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:alert('此功能暂未开放！');">
                            <span>帮TA点亮<br/>获取发布红包资格</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="javascript:alert('此功能暂未开放！');">
                            <span>分享<br/>求点亮/回点亮</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">
    function autoScroll(obj) {
        $(obj).find("ul").animate({
            marginTop: "-30px"
        }, 500, function () {
            $(this).css({marginTop: "0px"}).find("li:first").appendTo(this);
        })
    }
    $(function () {
        setInterval('autoScroll(".maquee")', 1000);
    })
</script>