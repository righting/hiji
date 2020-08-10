
// 指定图表的配置项和数据
var label_pie1 = {
    label: {
        show:true,

        fontFamily: 'DINCond-Bold',
        color: '#05c1ff',
        formatter:function (params){
            if(params.dataIndex ==0)
                var str = '{a|'+params.percent + '}';
            return  str
        },
        rich: {
            a: {
                color: '#05c1ff',
                fontSize: 30,
                align: 'center'
            }
        },
        position:'center'
    },
    labelLine : {
        show : false
    }
};
//物资消耗预警指数图表
function consume(elem,data,label_pie1) {
    var myChart = echarts.init(document.getElementById(elem));
    var option = {
        series : [
            {
                type:'pie',
                radius : ['63%', '80%'],
                center: ['50%','45%'],
                hoverAnimation: false,
                startAngle: 270,
                itemStyle : {
                    normal : label_pie1
                },
                data: data,
                /*  data:[
                      {value:0.6,itemStyle:{color: '#fedf00'}},
                      {value:0.4,itemStyle:{color: '#00a2ff'}},
                  ]*/
            }
        ],
        color: ['#05c1ff','#26345d']
    }
    myChart.setOption(option);
};

//物资出入库统计图表
function outPut(elem,data) {
    var myChart = echarts.init(document.getElementById(elem));
    var option = {
        color: ['#3598f5', '#f6c75b'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            data: ['出库', '入库'],
            right: 50,
            top: 0,
            textStyle: {color: '#fff',fontSize: 14},
        },
        calculable: true,
        grid:{
            top: 40,
            bottom: 20,
        },
        xAxis: [
            {
                type: 'category',
                data:data.title,
                axisLabel: {
                    color: '#fff',
                    interval:0
                },
                axisPointer: {
                    type: 'shadow'
                },
                axisLine: {
                    lineStyle: {color: 'rgba(238, 235, 233,0.4)'}
                },
                axisTick: {show: false},
                // axisTick:{length: 10}
            }
        ],
        yAxis: [
            {
                type: 'value',
                // min: 'dataMin',
                name: "单位：个",
                max: 'dataMax',
                interval: 100,
                nameTextStyle:{
                    color: '#fff',
                    fontSize: 14,
                    fontFamily: 'Source Han Sans CN'
                },
                nameGap: 10,
                axisLabel: {
                    color: '#fff'
                },
                axisLine: {
                    lineStyle: {color: 'rgba(238, 235, 233,0.4)'},
                },
                axisTick: {show: false},
                splitLine: {
                    show: false
                }
            }
        ],
        series: [
            {
                name: '出库',
                type: 'bar',
                barGap: 0,
                data: data.output
            },
            {
                name: '入库',
                type: 'bar',
                data: data.input
            },
        ]
    };
    myChart.setOption(option);
}

//物资类型图表
function material(elem,data) {
    var myChart = echarts.init(document.getElementById(elem));
    var option = {
        color: ['#3fecff', '#4c63f2', '#ed5400', '#7351e3', '#ff4873', '#fdd100'],
        title: {
            text: data.total,
            subtext: '设施总数',
            x: 'center',
            y: 120,
            textStyle: {
                fontSize:30,
                fontWeight:'normal',
                color: ['#fff']
            },
            subtextStyle: {
                color: '#fff',
                fontSize: 16
            },
        },

        series: [
            // 主要展示层的
            {
                radius: ['40%', '50%'],
                type: 'pie',
                labelLine: {
                    normal: {
                        show: true,
                        length: 30,
                        length2: 70,
                        lineStyle: {
                            color: '#2df6fe',
                            size:30
                        },
                        align: 'center'
                    },
                    color: "#000",
                    emphasis: {
                        show: true
                    }
                },
                label:{
                    normal:{
                        formatter: function(params){
                            var str = '';
                            switch(params.name){
                                case params.name:str = '{a|}{nameStyle|'+params.name+'}'+'{rate|'+params.value+'}';break;
                            }
                            return str
                        },
                        padding: [0, -75],
                        height: 30,
                        rich: {
                            nameStyle: {
                                fontSize: 12,
                                color: "#fff",
                                align: 'left'
                            },
                            rate: {
                                fontSize: 14,
                                color: "#1ab4b8",
                                align: 'center'
                            }
                        }
                    }
                },
                data:data.list,
            },
        ]
    };
    myChart.setOption(option);
}

function material2(elem,count,data) {
    var myChart = echarts.init(document.getElementById(elem));
    var option = {
        color: ['#3fecff', '#4c63f2', '#ed5400', '#7351e3', '#ff4873', '#fdd100'],
        title: {
            text: count,
            subtext: '设施总数',
            x: 'center',
            y: '120',
            textStyle: {
                fontSize:40,
                fontWeight:'normal',
                color: ['#fff']
            },
            subtextStyle: {
                color: '#fff',
                fontSize: 16
            },
        },
        legend: {
            orient: 'horizontal',
            bottom: '0',
            itemGap: 25,
            textStyle:{
                color:'#fff',
            },
            data: ['定保设施','绿化保洁','公共设施','消防设备','告示/指引牌']
        },
        series: [
            // 主要展示层的
            {
                radius: ['40%', '50%'],
                type: 'pie',
                labelLine: {
                    normal: {
                        show: true,
                        length: 30,
                        length2: 70,
                        lineStyle: {
                            color: '#2df6fe',
                            size:30
                        },
                        align: 'center'
                    },
                    color: "#000",
                    emphasis: {
                        show: true
                    }
                },
                label:{
                    normal:{
                        formatter: function(params){
                            var str = '';
                            switch(params.name){
                                case params.name:str = '{a|}{nameStyle|'+params.name+'}'+'\n{rate|'+params.value+'}';break;
                            }
                            return str
                        },
                        padding: [0, -55],
                        rich: {
                            nameStyle: {
                                fontSize: 12,
                                lineHeight: 25,
                                color: "#fff",
                                align: 'left'
                            },
                            rate: {
                                fontSize: 14,
                                color: "#1ab4b8",
                                align: 'center'
                            }
                        }
                    }
                },
                data:data,
            },

        ]
    };
    myChart.setOption(option);
}

//事件预警统计
function vehicle(elem,data) {
    var myChart = echarts.init(document.getElementById(elem));
    var option = {
        color: ['#66c5c2', '#fffd99'],
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            left: 'center',
            top: 0,
            itemWidth: 30,   // 设置图例图形的宽
            itemHeight: 10,  // 设置图例图形的高
            data: [{
                name: '当前',
                // 强制设置图形为圆。
                // 设置文本为红色
                textStyle: {
                    color: '#66c5c2'
                }
            },{
                name: '平均值',
                // 强制设置图形为圆。
                // 设置文本为红色
                textStyle: {
                    color: '#fffd99'
                }
            }
            ],
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true,
        },

        xAxis: {
            type: 'category',
            data: ['8:00','9:00','10:00','11:00','12:00','13:00','14:00'],
            axisLabel: {
                color: '#fff',
                interval:0
            },
            axisTick: {show: false},
            splitLine: {
                show: true,
                lineStyle:{
                    opacity:0.4
                }
            },
            axisLine:{
                lineStyle:{
                    color:'#fff',
                    opacity:0.4
                }
            },
        },
        yAxis: {
            type: 'value',
            interval: 100,
            nameTextStyle:{
                color: '#fff',
                fontSize: 14,
                fontFamily: 'Source Han Sans CN'
            },
            nameGap: 10,
            axisLabel: {
                color: '#fff'
            },
            axisLine:{
                lineStyle:{
                    color:'#fff',
                    opacity:0.1
                }
            },
            splitLine: {
                show: true,
                lineStyle:{
                    opacity:0.4
                }
            },
            axisTick: {show: false},
        },
        series: [
            {
                name:'当前',
                type:'line',
                stack: '总量',
                data:[120, 132, 101, 134, 90, 230, 210]
            },
            {
                name:'平均值',
                type:'line',
                stack: '总量',
                data:[220, 182, 191, 234, 290, 330, 310]
            },

        ]
    };
    myChart.setOption(option);
}

//选中导航
function pageNumber() {
    var pageType = $.getQueryString('pageType');
    if(pageType == 1 || pageType == null){
        $(".head-left").children('li').eq(0).addClass('active')
    }else if(pageType == 2){
        $(".head-left").children('li').eq(1).addClass('active')
    }else if(pageType == 3){
        $(".head-left").children('li').eq(2).addClass('active')
    }else if(pageType == 4){
        $(".head-right").children('li').eq(0).addClass('active')
    }else if(pageType == 5){
        $(".head-right").children('li').eq(1).addClass('active')
    }else if(pageType == 6){
        $(".head-right").children('li').eq(2).addClass('active')
    }
}