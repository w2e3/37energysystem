<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>中关村集成电路设计院</title>
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/reset.css">
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/yuanqu-new.css">
    <style>
        .rightmsg {
            margin: -15px;;
        }
    </style>
</head>
<body>
<div>
    <div class="onechart">
        <div id="water" style="width: 50%; height: 140px;float: left;"></div>
        <div class="chartmsg">
            <div class="rightmsg">
                <p><b>当日</b>用水总量</p>
                <p class="color_one"><span class="font16"><?php echo ($Result["ysl"]); ?></span>T</p>
                <p><b>当月</b>用水总量</p>
                <p class="color_one"><span class="font16"><?php echo ($Result["m_ysl"]); ?></span>T</p>
                <p><b>当年</b>用水总量</p>
                <p class="color_one"><span class="font16"><?php echo ($Result["y_ysl"]); ?></span>T</p>
            </div>
        </div>
    </div>
    <div class="onechart">
        <div id="electricity" style="width: 50%; height: 140px;float: left;"></div>
        <div class="chartmsg">
            <div class="rightmsg">
                <p><b>当日</b>用电总量</p>
                <p class="color_two"><span class="font16"><?php echo ($Result["dgl"]); ?></span>Kwh</p>
                <p><b>当月</b>用电总量</p>
                <p class="color_two"><span class="font16"><?php echo ($Result["m_dgl"]); ?></span>Kwh</p>
                <p><b>当年</b>用电总量</p>
                <p class="color_two"><span class="font16"><?php echo ($Result["y_dgl"]); ?></span>Kwh</p>
            </div>
        </div>
    </div>
    <div class="onechart">
        <div id="hot" style="width: 50%; height: 140px;float: left;"></div>
        <div class="chartmsg">
            <div class="rightmsg">
                <p><b>当日</b>用暖总量</p>
                <p class="color_three"><span class="font16"><?php echo ($Result["ynl"]); ?></span>Kwh</p>
                <p><b>当月</b>用暖总量</p>
                <p class="color_three"><span class="font16"><?php echo ($Result["m_ynl"]); ?></span>Kwh</p>
                <p><b>当年</b>用暖总量</p>
                <p class="color_three"><span class="font16"><?php echo ($Result["y_ynl"]); ?></span>Kwh</p>
            </div>
        </div>
    </div>
    <div class="onechart">
        <div id="cold" style="width: 50%; height: 140px;float: left;"></div>
        <div class="chartmsg">
            <div class="rightmsg">
                <p><b>当日</b>用冷总量</p>
                <p class="color_four"><span class="font16"><?php echo ($Result["yll"]); ?></span>Kwh</p>
                <p><b>当月</b>用冷总量</p>
                <p class="color_four"><span class="font16"><?php echo ($Result["m_yll"]); ?></span>Kwh</p>
                <p><b>当年</b>用冷总量</p>
                <p class="color_four"><span class="font16"><?php echo ($Result["y_yll"]); ?></span>Kwh</p>
            </div>
        </div>
    </div>
</div>
</div>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.12.4.js"></script>
<!--<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts.js"></script>-->
<!--<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts-more.js"></script>-->
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/echarts.js"></script>
<script>
    $(function () {
        var electricityChart = echarts.init(document.getElementById('electricity'));
        var electricityoption = {
            series : [
                {
                    name:'指标',
                    type:'gauge',
                    min:0,
                    max:parseInt(2*<?php echo ($Result["c_dgl_plan"]); ?>/1000),
                    splitNumber: 4,       // 分割段数，默认为5
                            axisLine: {            // 坐标轴线
                        lineStyle: {       // 属性lineStyle控制线条样式
                            color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']],
                                    width: 8
                        }
        },
        axisTick: {            // 坐标轴小标记
            splitNumber: 5,   // 每份split细分多少段
                    length :6,        // 属性length控制线长
                    lineStyle: {       // 属性lineStyle控制线条样式
                color: 'auto'
            }
        },
        axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto',
                fontSize: 10
            }
        },
        splitLine: {           // 分隔线
            show: true,        // 默认显示，属性show控制显示与否
                    length :1,         // 属性length控制线长
                    lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                color: 'auto'
            }
        },
        pointer : {
            width : 3
        },
        title : {
            show : true,
                    offsetCenter: [0, '-40%'],       // x, y，单位px
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontWeight: 'bolder',
                        fontSize: 10
            }
        },
        detail : {
            formatter:'{value}\r\nMwh',
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto',
                        fontWeight: 'bolder',
                        fontSize: 10
            }
        },
        data:[{value: <?php echo ($Result["c_dgl"]); ?>/1000, name: '用电量'}]
    }
    ]
    };
    electricityChart.setOption(electricityoption);
    //---------------------------------------------





    var waterChart = echarts.init(document.getElementById('water'));
    var wateroption = {
        series : [
            {
                name:'指标',
                type:'gauge',
                min:0,
                max:parseInt(2*<?php echo ($Result["c_ysl_plan"]); ?>/1000),
    splitNumber: 4,       // 分割段数，默认为5
            axisLine: {            // 坐标轴线
        lineStyle: {       // 属性lineStyle控制线条样式
            color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']],
                    width: 8
        }
    },
    axisTick: {            // 坐标轴小标记
        splitNumber: 5,   // 每份split细分多少段
                length :6,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
            color: 'auto'
        }
    },
    axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontSize: 10
        }
    },
    splitLine: {           // 分隔线
        show: true,        // 默认显示，属性show控制显示与否
                length :5,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
            color: 'auto'
        }
    },
    pointer : {
        width : 3
    },
    title : {
        show : true,
                offsetCenter: [0, '-40%'],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    detail : {
        formatter:'{value}\r\nKt',
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    data:[{value: <?php echo ($Result["c_ysl"]); ?>/1000, name: '用水量'}]
    }
    ]
    };
    waterChart.setOption(wateroption);


    //---------------------------------------------

    var hotChart = echarts.init(document.getElementById('hot'));
    var hotoption = {
        series : [
            {
                name:'指标',
                type:'gauge',
                min:0,
                max:parseInt(2*<?php echo ($Result["c_ynl_plan"]); ?>/1000),
    splitNumber: 4,       // 分割段数，默认为5
            axisLine: {            // 坐标轴线
        lineStyle: {       // 属性lineStyle控制线条样式
            color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']],
                    width: 8
        }
    },
    axisTick: {            // 坐标轴小标记
        splitNumber: 5,   // 每份split细分多少段
                length :6,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
            color: 'auto'
        }
    },
    axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontSize: 10
        }
    },
    splitLine: {           // 分隔线
        show: true,        // 默认显示，属性show控制显示与否
                length :5,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
            color: 'auto'
        }
    },
    pointer : {
        width : 3
    },
    title : {
        show : true,
                offsetCenter: [0, '-40%'],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    detail : {
        formatter:'{value}\r\nMwh',
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    data:[{value: <?php echo ($Result["c_ynl"]); ?>/1000, name: '用暖量'}]
    }
    ]
    };
    hotChart.setOption(hotoption);




    //---------------------------------------------

    var coldChart = echarts.init(document.getElementById('cold'));
    var coldoption = {
        series : [
            {
                name:'指标',
                type:'gauge',
                min:0,
                max:parseInt(2*<?php echo ($Result["c_yll_plan"]); ?>/1000),
    splitNumber: 4,       // 分割段数，默认为5
            axisLine: {            // 坐标轴线
        lineStyle: {       // 属性lineStyle控制线条样式
            color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']],
                    width: 8
        }
    },
    axisTick: {            // 坐标轴小标记
        splitNumber: 5,   // 每份split细分多少段
                length :6,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
            color: 'auto'
        }
    },
    axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontSize: 10
        }
    },
    splitLine: {           // 分隔线
        show: true,        // 默认显示，属性show控制显示与否
                length :5,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
            color: 'auto'
        }
    },
    pointer : {
        width : 3
    },
    title : {
        show : true,
                offsetCenter: [0, '-40%'],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    detail : {
        formatter:'{value}\r\nMwh',
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
            color: 'auto',
                    fontWeight: 'bolder',
                    fontSize: 10
        }
    },
    data:[{value: <?php echo ($Result["c_yll"]); ?>/1000, name: '用冷量'}]
    }
    ]
    };
    coldChart.setOption(coldoption);








//        $('#electricity').highcharts({
//            chart: {
//                type: 'gauge',
//                plotBackgroundColor: null,
//                plotBackgroundImage: null,
//                plotBorderWidth: 0,
//                plotShadow: false
//            },
//            title: {
//                text: ''
//            },
//            pane: {
//                startAngle: -130,
//                endAngle: 130,
////                background: [{
////                    backgroundColor: {
////                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                        stops: [
////                            [0, '#FFF'],
////                            [1, '#333']
////                        ]
////                    },
////                    borderWidth: 0,
////                    outerRadius: '109%'
////                }, {
////                    backgroundColor: {
////                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                        stops: [
////                            [0, '#333'],
////                            [1, '#FFF']
////                        ]
////                    },
////                    borderWidth: 1,
////                    outerRadius: '107%'
////                }, {
////                    // default background
////                }, {
////                    backgroundColor: '#DDD',
////                    borderWidth: 0,
////                    outerRadius: '105%',
////                    innerRadius: '103%'
////                }]
//            },
//            // the value axis
//            yAxis: {
//                min: 0,
//                max: parseInt(2*<?php echo ($Result["c_dgl_plan"]); ?>),
//                minorTickInterval: 'auto',
//                minorTickWidth: 1,
//                minorTickLength: 10,
//                minorTickPosition: 'inside',
//                minorTickColor: '#666',
//                tickPixelInterval: 30,
//                tickWidth: 2,
//                tickPosition: 'inside',
//                tickLength: 10,
//                tickColor: '#666',
//                labels: {
//                    step: 2,
//                    rotation: 'auto'
//                },
//                title: {
//                    text: ''
//                },
//                plotBands: [{
//                    from: 0,
//                    to: parseInt(<?php echo ($Result["c_dgl_plan"]); ?>/2),
//                    color: '#228b22' // green
//                }, {
//                    from: parseInt(<?php echo ($Result["c_dgl_plan"]); ?>/2),
//                    to: parseInt(<?php echo ($Result["c_dgl_plan"]); ?>),
//                    color: '#48bfff' // yellow
//                }, {
//                    from: parseInt(<?php echo ($Result["c_dgl_plan"]); ?>),
//                    to: parseInt(2*<?php echo ($Result["c_dgl_plan"]); ?>),
//                    color: '#ff4500' // red
//                }]
//            },
//            series: [{
//                name: '电量值',
//                data: [<?php echo ($Result["c_dgl"]); ?>],
//            tooltip: {
//                valueSuffix: ' Kwh'
//            }
//        }
//        ]
//    });
//    $('#water').highcharts({
//        chart: {
//            type: 'gauge',
//            plotBackgroundColor: null,
//            plotBackgroundImage: null,
//            plotBorderWidth: 0,
//            plotShadow: false
//        },
//        title: {
//            text: ""
//        },
//        pane: {
//            startAngle: -130,
//            endAngle: 130,
////            background: [{
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#FFF'],
////                        [1, '#333']
////                    ]
////                },
////                borderWidth: 0,
////                outerRadius: '109%'
////            }, {
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#333'],
////                        [1, '#FFF']
////                    ]
////                },
////                borderWidth: 1,
////                outerRadius: '107%'
////            }, {
////                // default background
////            }, {
////                backgroundColor: '#DDD',
////                borderWidth: 0,
////                outerRadius: '105%',
////                innerRadius: '103%'
////            }]
//        },
//        // the value axis
//        yAxis: {
//            min: 0,
//            max: parseInt(2*<?php echo ($Result["c_ysl_plan"]); ?>),
//            minorTickInterval: 'auto',
//            minorTickWidth: 1,
//            minorTickLength: 10,
//            minorTickPosition: 'inside',
//            minorTickColor: '#666',
//            tickPixelInterval: 30,
//            tickWidth: 2,
//            tickPosition: 'inside',
//            tickLength: 10,
//            tickColor: '#666',
//            labels: {
//                step: 2,
//                rotation: 'auto'
//            },
//            title: {
//                text: ''
//            },
//        plotBands: [{
//            from: 0,
//            to: parseInt(<?php echo ($Result["c_ysl_plan"]); ?>/2),
//        color: '#228b22' // green
//        }, {
//            from: parseInt(<?php echo ($Result["c_ysl_plan"]); ?>/2),
//            to: parseInt(<?php echo ($Result["c_ysl_plan"]); ?>),
//            color: '#48bfff' // yellow
//        }, {
//            from: parseInt(<?php echo ($Result["c_ysl_plan"]); ?>),
//            to: parseInt(2*<?php echo ($Result["c_ysl_plan"]); ?>),
//            color: '#ff4500' // red
//        }]
//    },
//        series: [{
//            name: '用水量',
//            data: [<?php echo ($Result["c_ysl"]); ?>],
//            tooltip: {
//            valueSuffix: 'T'
//        }
//    }
//        ]
//    })
//    ;
//    $('#hot').highcharts({
//        chart: {
//            type: 'gauge',
//            plotBackgroundColor: null,
//            plotBackgroundImage: null,
//            plotBorderWidth: 0,
//            plotShadow: false
//        },
//        title: {
//            text: ""
//        },
//        pane: {
//            startAngle: -130,
//            endAngle: 130,
////            background: [{
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#FFF'],
////                        [1, '#333']
////                    ]
////                },
////                borderWidth: 0,
////                outerRadius: '109%'
////            }, {
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#333'],
////                        [1, '#FFF']
////                    ]
////                },
////                borderWidth: 1,
////                outerRadius: '107%'
////            }, {
////                // default background
////            }, {
////                backgroundColor: '#DDD',
////                borderWidth: 0,
////                outerRadius: '105%',
////                innerRadius: '103%'
////            }]
//        },
//        // the value axis
//        yAxis: {
//            min: 0,
//            max: parseInt(2*<?php echo ($Result["c_ynl_plan"]); ?>),
//            minorTickInterval: 'auto',
//            minorTickWidth: 1,
//            minorTickLength: 10,
//            minorTickPosition: 'inside',
//            minorTickColor: '#666',
//            tickPixelInterval: 30,
//            tickWidth: 2,
//            tickPosition: 'inside',
//            tickLength: 10,
//            tickColor: '#666',
//            labels: {
//                step: 2,
//                rotation: 'auto'
//            },
//            title: {
//                text: ""
//            },
//            plotBands: [{
//                from: 0,
//                to: parseInt(<?php echo ($Result["c_ynl_plan"]); ?>/2),
//        color: '#228b22' // green
//         }, {
//            from: parseInt(<?php echo ($Result["c_ynl_plan"]); ?>/2),
//            to: parseInt(<?php echo ($Result["c_ynl_plan"]); ?>),
//            color: '#48bfff' // yellow
//        }, {
//            from: parseInt(<?php echo ($Result["c_ynl_plan"]); ?>),
//            to: parseInt(2*<?php echo ($Result["c_ynl_plan"]); ?>),
//            color: '#ff4500' // red
//        }]
//        },
//        series: [{
//            name: '暖能用量',
//            data: [<?php echo ($Result["c_ynl"]); ?>],
//        tooltip: {
//            valueSuffix: ' Kwh'
//        }
//    }
//    ]
//    })
//    ;
//    $('#cold').highcharts({
//        chart: {
//            type: 'gauge',
//            plotBackgroundColor: null,
//            plotBackgroundImage: null,
//            plotBorderWidth: 0,
//            plotShadow: false
//        },
//        title: {
//            text: ""
//        },
//        pane: {
//            startAngle: -130,
//            endAngle: 130,
////            background: [{
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#FFF'],
////                        [1, '#333']
////                    ]
////                },
////                borderWidth: 0,
////                outerRadius: '109%'
////            }, {
////                backgroundColor: {
////                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
////                    stops: [
////                        [0, '#333'],
////                        [1, '#FFF']
////                    ]
////                },
////                borderWidth: 1,
////                outerRadius: '107%'
////            }, {
////                // default background
////            }, {
////                backgroundColor: '#DDD',
////                borderWidth: 0,
////                outerRadius: '105%',
////                innerRadius: '103%'
////            }]
//        },
//        // the value axis
//        yAxis: {
//            min: 0,
//            max: parseInt(2*<?php echo ($Result["c_yll_plan"]); ?>),
//            minorTickInterval: 'auto',
//            minorTickWidth: 1,
//            minorTickLength: 10,
//            minorTickPosition: 'inside',
//            minorTickColor: '#666',
//            tickPixelInterval: 30,
//            tickWidth: 2,
//            tickPosition: 'inside',
//            tickLength: 10,
//            tickColor: '#666',
//            labels: {
//                step: 2,
//                rotation: 'auto'
//            },
//            title: {
//                text: ""
//            },
//        plotBands: [{
//            from: 0,
//            to: parseInt(<?php echo ($Result["c_yll_plan"]); ?>/2),
//        color: '#228b22' // green
//         }, {
//            from: parseInt(<?php echo ($Result["c_yll_plan"]); ?>/2),
//            to: parseInt(<?php echo ($Result["c_yll_plan"]); ?>),
//            color: '#48bfff' // yellow
//        }, {
//            from: parseInt(<?php echo ($Result["c_yll_plan"]); ?>),
//            to: parseInt(2*<?php echo ($Result["c_yll_plan"]); ?>),
//            color: '#ff4500' // red
//        }]
//        },
//        series: [{
//            name: '冷能用量',
//            data: [<?php echo ($Result["c_yll"]); ?>],
//        tooltip: {
//            valueSuffix: 'Kwh'
//        }
//    }
//    ]
//    })
//    ;

    });
</script>
</body>
</html>