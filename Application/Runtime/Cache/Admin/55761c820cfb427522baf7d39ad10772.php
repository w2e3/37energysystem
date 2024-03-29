<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>统计查看</title>
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/bootstrap.css">
    <style>
        .nav-tabs {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div style="float: left; width: 100%;display: block;">
    <div id="main" style="height:600px;width:100%;padding:10px;"></div>
</div>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.12.4.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/bootstrap.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/echarts.js"></script>
<script>
    //水电冷暖花费
    var width;
    var height;
    var myChart;
    $(function(){
        //自适应设置
        height = $(window).height();
        $("#main").css("height",height-20);
        setEcharts();
    });
    $(window).resize(function() {
//    width = $(window).width();
//    height = $(window).height();
        $("#mainBar").css("width",width-40);
        $("#mainBar").css("height",height-40);
    });
    function setEcharts(){
        var myChart = echarts.init(document.getElementById('main'));
        option = {
            title : {
                text: '本月水电冷暖用量统计表',
                x:'left'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data:['用量'],
                selected:{
                    '用量':true,
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                show : false,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,

            series: [
                {
                    name:'用量',
                    stack: '总用量',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '70%'],//饼图中心点位置
                    data:<?php echo ($energy_amounts); ?>,

                    label : {
                        normal : {
                            formatter: '{b}:{c}: ({d}%)',
                            textStyle : {
                                fontWeight : 'normal',
                                fontSize : 15
                            }
                        }
                    },
//                    formatter: '{d}元'
                }


            ]
        };
        myChart.setOption(option);
        var ecConfig = echarts.config;
//    function eConsole(param) {
//        if (typeof param.seriesIndex != 'undefined') {
//            //      alert("数据系列:"+param.seriesName+" 坐标Key:"+param.name+" 坐标值:"+param.value);
//        }
//    }
//    myChart.on(ecConfig.EVENT.CLICK, eConsole);
//    myChart.on(ecConfig.EVENT.DBLCLICK, eConsole);
//    //myChart.on(ecConfig.EVENT.HOVER, eConsole);
//    myChart.on(ecConfig.EVENT.DATA_ZOOM, eConsole);
//    myChart.on(ecConfig.EVENT.LEGEND_SELECTED, eConsole);
//    myChart.on(ecConfig.EVENT.MAGIC_TYPE_CHANGED, eConsole);
//    myChart.on(ecConfig.EVENT.DATA_VIEW_CHANGED, eConsole);
    }
</script>
</body>
<style type="text/css">
    /*canvas{width: 85%;margin-top: 120px;}*/
    /*#charts{margin-left: 20px;}*/
    /*#charts{margin-left: 20px;}*/
    /*#charts{margin-left: 20px;}*/
</style>
</html>