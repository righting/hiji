/**

 @Name：layuiAdmin Echarts集成
 @Author：star1029
 @Site：http://www.layui.com/admin/
 @License：GPL-2

 */


layui.define(function (exports) {

    //区块轮播切换
    layui.use(['admin', 'carousel'], function () {
        var $ = layui.$
            , admin = layui.admin
            , carousel = layui.carousel
            , element = layui.element
            , device = layui.device();

        //轮播切换
        $('.layadmin-carousel').each(function () {
            var othis = $(this);
            carousel.render({
                elem: this
                , width: '100%'
                , arrow: 'none'
                , interval: othis.data('interval')
                , autoplay: othis.data('autoplay') === true
                , trigger: (device.ios || device.android) ? 'click' : 'hover'
                , anim: othis.data('anim')
            });
        });

    });

    //折线图
    layui.use(['echarts'], function () {
        var $ = layui.$
            , echarts = layui.echarts;

        //近期一周店铺数量增长折线图
        var echnormline1 = [], normline1 = [
            {
                title: {
                    text: '近期一周店铺数量增长折线图',
                    x: "center"
                },
                tooltip: {
                    trigger: 'axis'
                },
                // calculable : true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: [
                    {
                        name: '数量',
                        type: 'line',
                        data: [101, 110, 150, 123, 612, 138, 10],
                    }
                ]
            }
        ]
            , echnormline1 = $('#LAY-index-heaparea').children('div')
            , rendernormline1 = function (index) {
            echnormline1[index] = echarts.init(echnormline1[index], layui.echartsTheme);
            echnormline1[index].setOption(normline1[index]);
            // window.onresize = echnormline[index].resize;
        };
        if (!echnormline1[0]) return;
        rendernormline1(0);

        //近期一周租借数量增长折线图
        var echnormline2 = [], normline2 = [
            {
                title: {
                    text: '近期一周租借数量增长折线图',
                    x: "center"
                },
                tooltip: {
                    trigger: 'axis'
                },
                // calculable : true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: [
                    {
                        name: '数量',
                        type: 'line',
                        data: [101, 110, 150, 123, 612, 138, 10],
                    }
                ]
            }
        ]
            , echnormline2 = $('#LAY-index-heapline').children('div')
            , rendernormline2 = function (index) {
            echnormline2[index] = echarts.init(echnormline2[index], layui.echartsTheme);
            echnormline2[index].setOption(normline2[index]);
            // window.onresize = echnormline[index].resize;
        };
        if (!echnormline2[0]) return;
        rendernormline2(0);

        //近期一周报修数量增长折线图
        var echnormline3 = [], normline3 = [
            {
                title: {
                    text: '近期一周报修数量增长折线图',
                    x: "center"
                },
                tooltip: {
                    trigger: 'axis'
                },
                // calculable : true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: [
                    {
                        name: '数量',
                        type: 'line',
                        data: [101, 110, 150, 123, 612, 138, 10],
                    }
                ]
            }
        ]
            , echnormline3 = $('#LAY-index-area').children('div')
            , rendernormline3 = function (index) {
            echnormline3[index] = echarts.init(echnormline3[index], layui.echartsTheme);
            echnormline3[index].setOption(normline3[index]);
            // window.onresize = echnormline[index].resize;
        };
        if (!echnormline3[0]) return;
        rendernormline3(0);


        //各级代理分成柱状图
        var echnormcol = [], normcol = [
            {
                title: {
                    text: '各级代理分成柱状图',
                    x: "center"
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: '{a} <br/>{b} : {c} k'
                },
                // calculable : true,
                xAxis: [
                    {
                        type: 'category',
                        data: ['平台分成', '代理商分成', '铺货商分成', '加盟商分成', '业务分成', '商户分成']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}k'
                        }
                    }
                ],
                series: [
                    {
                        name: '金额',
                        type: 'bar',
                        barWidth: 30,//柱图宽度
                        data: [20, 30, 70, 23.2, 25.6, 76.7],
                    },
                ]
            }
        ]
            , elemNormcol = $('#LAY-index-diffline').children('div')
            , renderNormcol = function (index) {
            echnormcol[index] = echarts.init(elemNormcol[index], layui.echartsTheme);
            echnormcol[index].setOption(normcol[index]);
            window.onresize = echnormcol[index].resize;
        };
        if (!elemNormcol[0]) return;
        renderNormcol(0);

        //近一个月租借数量前五的店铺
        var echnormcol1 = [], normcol1 = [
            {
                title: {
                    text: '近一个月租借数量前五的店铺',
                    x: "center"
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: '{a} <br/>{b} : {c} k'
                },
                // calculable : true,
                xAxis: [
                    {
                        type: 'category',
                        data: ['美宜家', '九龙山庄', '凯美城', '深圳书城', '龙兴联泰']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                    }
                ],
                series: [
                    {
                        name: '金额',
                        type: 'bar',
                        barWidth: 30,//柱图宽度
                        data: [20, 30, 70, 23.2, 25.6],
                    },
                ]
            }
        ]
            , elemNormcol1 = $('#LAY-index-logline').children('div')
            , renderNormcol1 = function (index) {
            echnormcol1[index] = echarts.init(elemNormcol1[index], layui.echartsTheme);
            echnormcol1[index].setOption(normcol1[index]);
            window.onresize = echnormcol1[index].resize;
        };
        if (!elemNormcol1[0]) return;
        renderNormcol1(0);

    });

    //饼图
    layui.use(['echarts'], function () {
        var $ = layui.$
            , echarts = layui.echarts;

        //近期一周用户数量增长折线图
        var echnormline = [], normline = [
            {
                title: {
                    text: '订单统计',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },

                series: [
                    {
                        name: '订单总数',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: [
                            {value: 335, name: '订单总数'},
                            {value: 175, name: '已完成的'},
                            {value: 125, name: '进行中的'},
                            {value: 35, name: '超时订单'}
                        ],
                        label: {
                            normal: {
                                formatter: ' {b} : {per|{d}%}  ',
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
        ]
            , elemnormline = $('#LAY-index-normline')
            , rendernormline = function (index) {
            echnormline[index] = echarts.init(elemnormline[index], layui.echartsTheme);
            echnormline[index].setOption(normline[index]);
            window.onresize = echnormline[index].resize;
        };
        if (!elemnormline[0]) return;
        rendernormline(0);
    });

    //柱状图
    layui.use(['echarts'], function () {
        var $ = layui.$
            , echarts = layui.echarts;


        //堆积柱状图
        var echheapcol = [], heapcol = [
            {
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    left: 10,
                    data: ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: ['50%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: [
                            {value: 335, name: '直接访问'},
                            {value: 310, name: '邮件营销'},
                            {value: 234, name: '联盟广告'},
                            {value: 135, name: '视频广告'},
                            {value: 1548, name: '搜索引擎'}
                        ]
                    }
                ]
            }
        ]
            , elemHeapcol = $('#LAY-index-heapcol').children('div')
            , renderHeapcol = function (index) {
            echheapcol[index] = echarts.init(elemHeapcol[index], layui.echartsTheme);
            echheapcol[index].setOption(heapcol[index]);
            window.onresize = echheapcol[index].resize;
        };
        if (!elemHeapcol[0]) return;
        renderHeapcol(0);

        //不等距柱形图
        var echdiffcol = [], diffcol = [
            {
                title: {
                    text: '双数值柱形图',
                    subtext: '纯属虚构'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        show: true,
                        type: 'cross',
                        lineStyle: {
                            type: 'dashed',
                            width: 1
                        }
                    },
                    formatter: function (params) {
                        return params.seriesName + ' : [ ' + params.value[0] + ', ' + params.value[1] + ' ]';
                    }
                },
                legend: {
                    data: ['数据1', '数据2']
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'value'
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLine: {
                            lineStyle: {
                                color: '#dc143c'
                            }
                        }
                    }
                ],
                series: [
                    {
                        name: '数据1',
                        type: 'bar',
                        data: [
                            [1.5, 10], [5, 7], [8, 8], [12, 6], [11, 12], [16, 9], [14, 6], [17, 4], [19, 9]
                        ],
                        markPoint: {
                            data: [
                                // 纵轴，默认
                                {
                                    type: 'max',
                                    name: '最大值',
                                    symbol: 'emptyCircle',
                                    itemStyle: {normal: {color: '#dc143c', label: {position: 'top'}}}
                                },
                                {
                                    type: 'min',
                                    name: '最小值',
                                    symbol: 'emptyCircle',
                                    itemStyle: {normal: {color: '#dc143c', label: {position: 'bottom'}}}
                                },
                                // 横轴
                                {
                                    type: 'max',
                                    name: '最大值',
                                    valueIndex: 0,
                                    symbol: 'emptyCircle',
                                    itemStyle: {normal: {color: '#1e90ff', label: {position: 'right'}}}
                                },
                                {
                                    type: 'min',
                                    name: '最小值',
                                    valueIndex: 0,
                                    symbol: 'emptyCircle',
                                    itemStyle: {normal: {color: '#1e90ff', label: {position: 'left'}}}
                                }
                            ]
                        },
                        markLine: {
                            data: [
                                // 纵轴，默认
                                {type: 'max', name: '最大值', itemStyle: {normal: {color: '#dc143c'}}},
                                {type: 'min', name: '最小值', itemStyle: {normal: {color: '#dc143c'}}},
                                {type: 'average', name: '平均值', itemStyle: {normal: {color: '#dc143c'}}},
                                // 横轴
                                {type: 'max', name: '最大值', valueIndex: 0, itemStyle: {normal: {color: '#1e90ff'}}},
                                {type: 'min', name: '最小值', valueIndex: 0, itemStyle: {normal: {color: '#1e90ff'}}},
                                {type: 'average', name: '平均值', valueIndex: 0, itemStyle: {normal: {color: '#1e90ff'}}}
                            ]
                        }
                    },
                    {
                        name: '数据2',
                        type: 'bar',
                        barHeight: 10,
                        data: [
                            [1, 2], [2, 3], [4, 4], [7, 5], [11, 11], [18, 15]
                        ]
                    }
                ]
            }
        ]
            , elemDiffcol = $('#LAY-index-diffcol').children('div')
            , renderDiffcol = function (index) {
            echdiffcol[index] = echarts.init(elemDiffcol[index], layui.echartsTheme);
            echdiffcol[index].setOption(diffcol[index]);
            window.onresize = echdiffcol[index].resize;
        };
        if (!elemDiffcol[0]) return;
        renderDiffcol(0);

        //彩虹柱形图
        var echcolorline = [], colorline = [
            {
                title: {
                    x: 'center',
                    text: 'ECharts例子个数统计',
                    subtext: 'Rainbow bar example',
                    link: 'http://echarts.baidu.com/doc/example.html'
                },
                tooltip: {
                    trigger: 'item'
                },
                calculable: true,
                grid: {
                    borderWidth: 0,
                    y: 80,
                    y2: 60
                },
                xAxis: [
                    {
                        type: 'category',
                        show: false,
                        data: ['Line', 'Bar', 'Scatter', 'K', 'Pie', 'Radar', 'Chord', 'Force', 'Map', 'Gauge', 'Funnel']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        show: false
                    }
                ],
                series: [
                    {
                        name: 'ECharts例子个数统计',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: function (params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#C1232B', '#B5C334', '#FCCE10', '#E87C25', '#27727B',
                                        '#FE8463', '#9BCA63', '#FAD860', '#F3A43B', '#60C0DD',
                                        '#D7504B', '#C6E579', '#F4E001', '#F0805A', '#26C0C0'
                                    ];
                                    return colorList[params.dataIndex]
                                },
                                label: {
                                    show: true,
                                    position: 'top',
                                    formatter: '{b}\n{c}'
                                }
                            }
                        },
                        data: [12, 21, 10, 4, 12, 5, 6, 5, 25, 23, 7],
                        markPoint: {
                            tooltip: {
                                trigger: 'item',
                                backgroundColor: 'rgba(0,0,0,0)',
                                formatter: function (params) {
                                    return '<img src="' + params.data.symbol.replace('image://', '') + '"/>';
                                }
                            },
                            data: [
                                {xAxis: 0, y: 350, name: 'Line', symbolSize: 20},
                                {xAxis: 1, y: 350, name: 'Bar', symbolSize: 20},
                                {xAxis: 2, y: 350, name: 'Scatter', symbolSize: 20},
                                {xAxis: 3, y: 350, name: 'K', symbolSize: 20},
                                {xAxis: 4, y: 350, name: 'Pie', symbolSize: 20},
                                {xAxis: 5, y: 350, name: 'Radar', symbolSize: 20},
                                {xAxis: 6, y: 350, name: 'Chord', symbolSize: 20},
                                {xAxis: 7, y: 350, name: 'Force', symbolSize: 20},
                                {xAxis: 8, y: 350, name: 'Map', symbolSize: 20},
                                {xAxis: 9, y: 350, name: 'Gauge', symbolSize: 20},
                                {xAxis: 10, y: 350, name: 'Funnel', symbolSize: 20},
                            ]
                        }
                    }
                ]
            }
        ]
            , elemColorline = $('#LAY-index-colorline').children('div')
            , renderColorline = function (index) {
            echcolorline[index] = echarts.init(elemColorline[index], layui.echartsTheme);
            echcolorline[index].setOption(colorline[index]);
            window.onresize = echcolorline[index].resize;
        };
        if (!elemColorline[0]) return;
        renderColorline(0);

        //标准条形图
        var echnormbar = [], normbar = [
            {
                title: {
                    text: '世界人口总量',
                    subtext: '数据来自网络'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['2011年', '2012年']
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'value',
                        boundaryGap: [0, 0.01]
                    }
                ],
                yAxis: [
                    {
                        type: 'category',
                        data: ['巴西', '印尼', '美国', '印度', '中国', '世界人口(万)']
                    }
                ],
                series: [
                    {
                        name: '2011年',
                        type: 'bar',
                        data: [18203, 23489, 29034, 104970, 131744, 630230]
                    },
                    {
                        name: '2012年',
                        type: 'bar',
                        data: [19325, 23438, 31000, 121594, 134141, 681807]
                    }
                ]
            }
        ]
            , elemNormbar = $('#LAY-index-normbar').children('div')
            , renderNormbar = function (index) {
            echnormbar[index] = echarts.init(elemNormbar[index], layui.echartsTheme);
            echnormbar[index].setOption(normbar[index]);
            window.onresize = echnormbar[index].resize;
        };
        if (!elemNormbar[0]) return;
        renderNormbar(0);

        //堆积条形图
        var echheapbar = [], heapbar = [
            {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    data: ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'value'
                    }
                ],
                yAxis: [
                    {
                        type: 'category',
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                    }
                ],
                series: [
                    {
                        name: '直接访问',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                        data: [320, 302, 301, 334, 390, 330, 320]
                    },
                    {
                        name: '邮件营销',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                        data: [120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name: '联盟广告',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                        data: [220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name: '视频广告',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                        data: [150, 212, 201, 154, 190, 330, 410]
                    },
                    {
                        name: '搜索引擎',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                        data: [820, 832, 901, 934, 1290, 1330, 1320]
                    }
                ]
            }
        ]
            , elemheapbar = $('#LAY-index-heapbar').children('div')
            , renderheapbar = function (index) {
            echheapbar[index] = echarts.init(elemheapbar[index], layui.echartsTheme);
            echheapbar[index].setOption(heapbar[index]);
            window.onresize = echheapbar[index].resize;
        };
        if (!elemheapbar[0]) return;
        renderheapbar(0);

        //旋风条形图
        var echwindline = [], labelRight = {normal: {label: {position: 'right'}}}, windline = [
            {
                title: {
                    text: '交错正负轴标签',
                    subtext: 'From ExcelHome',
                    sublink: 'http://e.weibo.com/1341556070/AjwF2AgQm'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                grid: {
                    y: 80,
                    y2: 30
                },
                xAxis: [
                    {
                        type: 'value',
                        position: 'top',
                        splitLine: {lineStyle: {type: 'dashed'}},
                    }
                ],
                yAxis: [
                    {
                        type: 'category',
                        axisLine: {show: false},
                        axisLabel: {show: false},
                        axisTick: {show: false},
                        splitLine: {show: false},
                        data: ['ten', 'nine', 'eight', 'seven', 'six', 'five', 'four', 'three', 'two', 'one']
                    }
                ],
                series: [
                    {
                        name: '生活费',
                        type: 'bar',
                        stack: '总量',
                        itemStyle: {
                            normal: {
                                color: 'orange',
                                borderRadius: 5,
                                label: {
                                    show: true,
                                    position: 'left',
                                    formatter: '{b}'
                                }
                            }
                        },
                        data: [
                            {value: -0.07, itemStyle: labelRight},
                            {value: -0.09, itemStyle: labelRight},
                            0.2, 0.44,
                            {value: -0.23, itemStyle: labelRight},
                            0.08,
                            {value: -0.17, itemStyle: labelRight},
                            0.47,
                            {value: -0.36, itemStyle: labelRight},
                            0.18
                        ]
                    }
                ]
            }
        ]
            , elemwindline = $('#LAY-index-windline').children('div')
            , renderwindline = function (index) {
            echwindline[index] = echarts.init(elemwindline[index], layui.echartsTheme);
            echwindline[index].setOption(windline[index]);
            window.onresize = echwindline[index].resize;
        };
        if (!elemwindline[0]) return;
        renderwindline(0);
    });

    //地图
    layui.use(['echarts'], function () {
        var $ = layui.$
            , echarts = layui.echarts;

        var echplat = [], plat = [
            {
                title: {
                    text: '2011全国GDP（亿元）',
                    subtext: '数据来自国家统计局'
                },
                tooltip: {
                    trigger: 'item'
                },
                dataRange: {
                    orient: 'horizontal',
                    min: 0,
                    max: 55000,
                    text: ['高', '低'],           // 文本，默认为数值文本
                    splitNumber: 0
                },
                series: [
                    {
                        name: '2011全国GDP分布',
                        type: 'map',
                        mapType: 'china',
                        mapLocation: {
                            x: 'center'
                        },
                        selectedMode: 'multiple',
                        itemStyle: {
                            normal: {label: {show: true}},
                            emphasis: {label: {show: true}}
                        },
                        data: [
                            {name: '西藏', value: 605.83},
                            {name: '青海', value: 1670.44},
                            {name: '宁夏', value: 2102.21},
                            {name: '海南', value: 2522.66},
                            {name: '甘肃', value: 5020.37},
                            {name: '贵州', value: 5701.84},
                            {name: '新疆', value: 6610.05},
                            {name: '云南', value: 8893.12},
                            {name: '重庆', value: 10011.37},
                            {name: '吉林', value: 10568.83},
                            {name: '山西', value: 11237.55},
                            {name: '天津', value: 11307.28},
                            {name: '江西', value: 11702.82},
                            {name: '广西', value: 11720.87},
                            {name: '陕西', value: 12512.3},
                            {name: '黑龙江', value: 12582},
                            {name: '内蒙古', value: 14359.88},
                            {name: '安徽', value: 15300.65},
                            {name: '北京', value: 16251.93, selected: true},
                            {name: '福建', value: 17560.18},
                            {name: '上海', value: 19195.69, selected: true},
                            {name: '湖北', value: 19632.26},
                            {name: '湖南', value: 19669.56},
                            {name: '四川', value: 21026.68},
                            {name: '辽宁', value: 22226.7},
                            {name: '河北', value: 24515.76},
                            {name: '河南', value: 26931.03},
                            {name: '浙江', value: 32318.85},
                            {name: '山东', value: 45361.85},
                            {name: '江苏', value: 49110.27},
                            {name: '广东', value: 53210.28, selected: true}
                        ]
                    }
                ]
            }
        ]
            , elemplat = $('#LAY-index-plat').children('div')
            , renderplat = function (index) {
            echplat[index] = echarts.init(elemplat[index], layui.echartsTheme);
            echplat[index].setOption(plat[index]);
            window.onresize = echplat[index].resize;
        };
        if (!elemplat[0]) return;
        renderplat(0);
    });

    exports('senior', {})

});