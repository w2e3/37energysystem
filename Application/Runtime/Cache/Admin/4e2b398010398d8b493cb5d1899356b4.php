<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>中关村集成电路设计院</title>
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/reset.css">
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/floor-new.css">
</head>
<body>
<div>
    <div class="yibiao-top">
        <div class="onechart">
            <div id="water" style="width: 100%; max-width: 400px; height: 200px;display: inline-block;"></div>
            <div class="chartmsg">
                <div class="leftmsg">
                    <p><b>当月</b>用水总量</p>
                    <p class="color_one"><span class="font16"><?php echo ($Result["m_ysl"]); ?></span>T</p>
                </div>
                <div class="rightmsg">
                    <p><b>当日</b>用水总量</p>
                    <p class="color_one"><span class="font16"><?php echo ($Result["ysl"]); ?></span>T</p>
                    <p><b>当年</b>用水总量</p>
                    <p class="color_one"><span class="font16"><?php echo ($Result["y_ysl"]); ?></span>T</p>
                </div>
            </div>
        </div>
        <div class="onechart">
            <div id="electricity" style="width: 100%; max-width: 400px; height: 200px;display: inline-block;"></div>
            <div class="chartmsg">
                <div class="leftmsg">
                    <p><b>当月</b>用电总量</p>
                    <p class="color_two"><span class="font16"><?php echo ($Result["m_dgl"]); ?></span>Kwh</p>
                </div>
                <div class="rightmsg">
                    <p><b>当日</b>用电总量</p>
                    <p class="color_two"><span class="font16"><?php echo ($Result["dgl"]); ?></span>Kwh</p>
                    <p><b>当年</b>用电总量</p>
                    <p class="color_two"><span class="font16"><?php echo ($Result["y_dgl"]); ?></span>Kwh</p>
                </div>
            </div>
        </div>
        <div class="onechart">
            <div id="hot" style="width: 100%; max-width: 400px; height: 200px;display: inline-block;"></div>
            <div class="chartmsg">
                <div class="leftmsg">
                    <p><b>当月</b>用暖总量</p>
                    <p class="color_three"><span class="font16"><?php echo ($Result["m_ynl"]); ?></span>Kwh</p>
                </div>
                <div class="rightmsg">
                    <p><b>当日</b>用暖总量</p>
                    <p class="color_three"><span class="font16"><?php echo ($Result["ynl"]); ?></span>Kwh</p>
                    <p><b>当年</b>用暖总量</p>
                    <p class="color_three"><span class="font16"><?php echo ($Result["y_ynl"]); ?></span>Kwh</p>
                </div>
            </div>
        </div>
        <div class="onechart">
            <div id="cold" style="width: 100%; max-width: 400px; height: 200px;display: inline-block;"></div>
            <div class="chartmsg">
                <div class="leftmsg">
                    <p><b>当月</b>用冷总量</p>
                    <p class="color_four"><span class="font16"><?php echo ($Result["m_yll"]); ?></span>Kwh</p>
                </div>
                <div class="rightmsg">
                    <p><b>当日</b>用冷总量</p>
                    <p class="color_four"><span class="font16"><?php echo ($Result["yll"]); ?></span>Kwh</p>
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
                        splitNumber: 10,   // 每份split细分多少段
                        length :12,        // 属性length控制线长
                        lineStyle: {       // 属性lineStyle控制线条样式
                            color: 'auto'
                        }
                    },
                    axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            color: 'auto'
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
                        width : 5
                    },
                    title : {
                        show : true,
                        offsetCenter: [0, '-40%'],       // x, y，单位px
                        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            fontWeight: 'bolder',
                            fontSize: 14
                        }
                    },
                    detail : {
                        formatter:'{value}\r\nMwh',
                        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            color: 'auto',
                            fontWeight: 'bolder',
                            fontSize: 14
                        }
                    },
                    data:[{value: <?php echo ($Result["c_dgl"]); ?>/1000, name: '当月\r\n用电量'}]
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
            splitNumber: 10,   // 每份split细分多少段
                    length :12,        // 属性length控制线长
                    lineStyle: {       // 属性lineStyle控制线条样式
                color: 'auto'
            }
        },
        axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto'
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
            width : 5
        },
        title : {
            show : true,
                    offsetCenter: [0, '-40%'],       // x, y，单位px
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                fontWeight: 'bolder',
                        fontSize: 14
            }
        },
        detail : {
            formatter:'{value}\r\nKt',
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto',
                        fontWeight: 'bolder',
                        fontSize: 14
            }
        },
        data:[{value: <?php echo ($Result["c_ysl"]); ?>/1000, name: '当月\r\n用水量'}]
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
            splitNumber: 10,   // 每份split细分多少段
                    length :12,        // 属性length控制线长
                    lineStyle: {       // 属性lineStyle控制线条样式
                color: 'auto'
            }
        },
        axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto'
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
            width : 5
        },
        title : {
            show : true,
                    offsetCenter: [0, '-40%'],       // x, y，单位px
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                fontWeight: 'bolder',
                        fontSize: 14
            }
        },
        detail : {
            formatter:'{value}\r\nMwh',
                    textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto',
                        fontWeight: 'bolder',
                        fontSize: 14
            }
        },
        data:[{value: <?php echo ($Result["c_ynl"]); ?>/1000, name: '当月\r\n用暖量'}]
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
                        splitNumber: 10,   // 每份split细分多少段
                                length :12,        // 属性length控制线长
                                lineStyle: {       // 属性lineStyle控制线条样式
                            color: 'auto'
                        }
                    },
                    axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                        textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            color: 'auto'
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
                        width : 5
                    },
                    title : {
                        show : true,
                                offsetCenter: [0, '-40%'],       // x, y，单位px
                                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            fontWeight: 'bolder',
                                    fontSize: 14
                        }
                    },
                    detail : {
                        formatter:'{value}\r\nMwh',
                                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                            color: 'auto',
                                    fontWeight: 'bolder',
                                    fontSize: 14
                        }
                    },
                    data:[{value: <?php echo ($Result["c_yll"]); ?>/1000, name: '当月\r\n用冷量'}]
                    }
                    ]
                    };
                coldChart.setOption(coldoption);

    });
</script>
</body>
</html>