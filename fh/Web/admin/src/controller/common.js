/**

 @Name：layuiAdmin 公共业务
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL

 */

layui.define(function(exports){
    var $ = layui.$
        ,layer = layui.layer
        ,laytpl = layui.laytpl
        ,setter = layui.setter
        ,view = layui.view
        ,upload = layui.upload
        ,form = layui.form
        ,table = layui.table
        ,admin = layui.admin;
  
    //table表单模板
    table.set({
        method:'post'
        ,where:{
            token: layui.data('admin').token
        }
        ,parseData: function (res) { //res 即为原始返回的数据
            if(res.code == -1){
                location.hash = '/user/login'
            }
            return {
                "code": res.code == 0 ? 0 : 1, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.data.total, //解析数据长度
                "data": res.data.data, //解析数据列表
            };
        }
    });

    //获取省份
    admin.getProvince = function (select_province)
    {
        admin.req({
            url: issUrl.province
            ,type:'post'
            ,async : false
            ,success:function(res){
                if(res.code == 0){
                    var option = '<option value="">请选择省</option>';
                    $.each(res.data,function(key,val) {
                        if(select_province == val.province_id){
                            option += '<option value="'+val.province_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.province_id+'">'+val.title+'</option>';
                        }
                    });
                    $("#province").html(option);
                    form.render();
                }else{
                }
            }
            ,done: function(res){

            }
        });
    }

    //获取城市
    admin.getCity = function (province, select_city)
    {
        admin.req({
            url: issUrl.city
            ,data: {province_id:province}
            ,type:'post'
            ,async : false
            ,success:function(res){

                if(res.code == 0){
                    var option = '<option value="">请选择市</option>';
                    var option2 = '<option value="">请选择县/区</option>';
                    $.each(res.data,function(key,val) {
                        if(select_city == val.city_id){
                            option += '<option value="'+val.city_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.city_id+'">'+val.title+'</option>';
                        }
                    });
                    $("#city").html(option);
                    $("#area").html(option2);
                    form.render();
                }else{
                }
            }
            ,done: function(res){

            }
        });
    }

    //获取地区
    admin.getArea = function getArea(city, select_area)
    {
        admin.req({
            url: issUrl.area
            ,data: {city_id:city}
            ,type:'post'
            ,async : false
            ,success:function(res){
                if(res.code == 0){
                    var option = '<option value="">请选择县/区</option>';
                    $.each(res.data,function(key,val) {
                        if(select_area == val.area_id){
                            option += '<option value="'+val.area_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.area_id+'">'+val.title+'</option>';
                        }
                    });
                    $("#area").html(option);
                    form.render();
                }else{
                }
            }
            ,done: function(res){
            }
        });
    }
    //获取省份
    admin.getProvince2 = function (select_province)
    {
        admin.req({
            url: issUrl.province
            ,type:'post'
            ,success:function(res){

                if(res.code == 0){
                    var option = '<option value="">请选择省</option>';
                    $.each(res.data,function(key,val) {
                        if(select_province == val.province_id){
                            option += '<option value="'+val.province_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.province_id+'">'+val.title+'</option>';
                        }

                    });
                    $("#province2").html(option);
                    form.render();
                }else{

                }

            }
            ,done: function(res){

            }
        });
    }

    //获取城市
    admin.getCity2 = function (province, select_city)
    {
        admin.req({
            url: issUrl.city
            ,data: {province_id:province}
            ,type:'post'
            ,success:function(res){

                if(res.code == 0){
                    var option = '<option value="">请选择市</option>';
                    var option2 = '<option value="">请选择县/区</option>';
                    $.each(res.data,function(key,val) {
                        if(select_city == val.city_id){
                            option += '<option value="'+val.city_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.city_id+'">'+val.title+'</option>';
                        }
                    });
                    $("#city2").html(option);
                    $("#area2").html(option2);
                    form.render();
                }else{
                }
            }
            ,done: function(res){

            }
        });
    }

    //获取地区
    admin.getArea2 = function getArea(city, select_area)
    {
        admin.req({
            url: issUrl.area
            ,data: {city_id:city}
            ,type:'post'
            ,success:function(res){
                if(res.code == 0){
                    var option = '<option value="">请选择县/区</option>';
                    $.each(res.data,function(key,val) {
                        if(select_area == val.area_id){
                            option += '<option value="'+val.area_id+'" selected="selected">'+val.title+'</option>';
                        }else{
                            option += '<option value="'+val.area_id+'">'+val.title+'</option>';
                        }
                    });
                    $("#area2").html(option);
                    form.render();
                }else{
                }
            }
            ,done: function(res){
            }
        });
    }


    //饼形图
    admin.pie = function (elem, total, pie_value) {
        var myChart = echarts.init(document.getElementById(elem));
        var option =
            {
                title: {
                    text: '情况统计',
                    subtext: '订单总数：'+total,
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{b} : {c} ({d}%)'
                },
                series: [
                    {
                        name: '订单总数',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: pie_value,
                        label: {
                            normal: {
                                formatter: '{b}: {c} ({per|{d}%})  ',
                                rich: {
                                    per: {
                                        color: '#000'
                                    }
                                }
                            },
                        },
                    }
                ]
            }
        myChart.setOption(option);
    }

    //柱形图
    admin.line = function (elem, data, pie_value) {
        //订单已完成数量柱形图
        var myChart = echarts.init(document.getElementById(elem));
        var option = {
            grid: {
                top: 20,    //距离容器上边界40像素
                bottom: 30   //距离容器下边界30像素
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                axisLabel: {
                    interval:0,
                }
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '30%']
            },
            visualMap: {
                type: 'piecewise',
                show: false,
                dimension: 0,
                seriesIndex: 0,
                pieces: [{
                    gt: 1,
                    lt: 3,
                    color: 'rgba(0, 180, 0, 0.5)'
                }, {
                    gt: 5,
                    lt: 7,
                    color: 'rgba(0, 180, 0, 0.5)'
                }]
            },
            series: [
                {
                    type: 'line',
                    smooth: 0.6,
                    symbol: 'none',
                    lineStyle: {
                        color: 'green',
                        width: 2
                    },
                    markLine: {
                        symbol: ['none', 'none'],
                        label: {show: false},
                        data: [
                            {xAxis: 1},
                            {xAxis: 3},
                            {xAxis: 5},
                            {xAxis: 7}
                        ]
                    },
                    areaStyle: {},
                    data:pie_value
                }
            ]
        };
        myChart.setOption(option);
    }

    //折线图
    admin.line2 = function (elem, data, pie_value) {
        var myChart = echarts.init(document.getElementById(elem));
        console.log(elem);
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            grid: {
                top: 20,    //距离容器上边界40像素
                bottom: 30   //距离容器下边界30像素
            },
            xAxis: [
                {
                    type: 'category',
                    boundaryGap: false,
                    data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '邮件营销',
                    type: 'line',
                    data: [120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name: '联盟广告',
                    type: 'line',
                    data: [220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name: '视频广告',
                    type: 'line',

                    data: [150, 232, 201, 154, 190, 330, 410]
                },

            ]
        };
        myChart.setOption(option);

    }

    //公共业务的逻辑处理可以写在此处，切换任何页面都会执行
    //……
    var uploadList = []
    admin.uploadFile = function () {
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: '/upload/'
            ,accept: 'file'
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,choose: function(obj){
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-mini test-upload-demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-mini layui-btn-danger test-upload-demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));
                    //单个重传
                    tr.find('.test-upload-demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.test-upload-demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });
                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    uploadList.push(res.data);
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.test-upload-demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    }

    //退出
    admin.events.logout = function(){
        //执行退出接口
        admin.req({
            url: './json/user/logout.js'
            ,type: 'get'
            ,data: {}
            ,done: function(res){ //这里要说明一下：done 是只有 response 的 code 正常才会执行。而 succese 则是只要 http 为 200 就会执行

                //清空本地记录的 token，并跳转到登入页
                admin.exit();
            }
        });
    };




    //对外暴露的接口
    exports('common', {});
});