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
<!--<div style="float: left; width: 100%;display: block;">
    <div id="main" style="height:600px;width:100%;padding:10px;">
    </div>
</div>-->
<div class="container" style="width:100%;height:600px;padding:10px">
    <div class="row">
        <div id="btS" class="col-xs-6" style="height:300px;"></div>
        <div id="btD" class="col-xs-6" style="height:300px;"></div>
</div>
<div class="row">	
        <div id="btN" class="col-xs-6" style="height:300px;"></div>
        <div id="btL" class="col-xs-6" style="height:300px;"></div>

    </div>
</div>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.12.4.js"></script>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/bootstrap.js"></script>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/echarts.js"></script>

<script>
    //水电冷暖花费
    var width;
    var height;
    var myChartS;
    var myChartD;
    var myChartN;
    var myChartL;
    $(function(){
        //自适应设置
    height = $(window).height()/2;
    $("#btS").css("height",height-20);
    $("#btD").css("height",height-20);
    $("#btN").css("height",height-20);
    $("#btL").css("height",height-20);
        setEcharts();
    });
    $(window).resize(function() {
//    width = $(window).width();
//    height = $(window).height();
        $("#mainBar").css("width",width-40);
        $("#mainBar").css("height",height-40);
    });
    function setEcharts(){
        var myChartS = echarts.init(document.getElementById('btS'));
        option = {
            title : {
                text: '本月水用量统计表',
                x:'center',
                textStyle:{
                    fontStyle:'normal',
                    fontWeight:"lighter",
                    fontSize:18//主题文字字体大小，默认为18px
                },
            },
            series: [
                {
                    name:'用水量',
                    stack: '用量',
                    type: 'pie',
                    radius : ['0','50%'],
                    center: ['50%', '60%'],//饼图中心点位置
                    data:<?php echo ($floor_s_arr); ?>,

                    label : {
                        normal : {
                            formatter: '{b}:{c}: ({d}%)',
                            textStyle : {
                                fontWeight : 'normal',
                                fontSize : 15
                            }
                        }
                    },
                }
            ]
        };
        myChartS.setOption(option);

        var myChartD = echarts.init(document.getElementById('btD'));
        option = {
            title : {
                text: '本月电用量统计表',
                x:'center',
                textStyle:{
                    fontStyle:'normal',
                    fontWeight:"lighter",
                    fontSize:18//主题文字字体大小，默认为18px
                },
            },
             calculable : true,
            series: [

                 {
                 name:'用电量',
                 stack: '用量',
                 type: 'pie',
                     radius : ['0','50%'],
                     center: ['50%', '60%'],//饼图中心点位置
                 data:<?php echo ($floor_d_arr); ?>,

                 label : {
                 normal : {
                 formatter: '{b}:{c}: ({d}%)',
                 textStyle : {
                 fontWeight : 'normal',
                 fontSize : 15
                 }
                 }
                 },
                 },

            ]
        };
        myChartD.setOption(option);


        var myChartN = echarts.init(document.getElementById('btN'));
        option = {
            title : {
                text: '本月暖用量统计表',
                x:'center',
                textStyle:{
                    fontStyle:'normal',
                    fontWeight:"lighter",
                    fontSize:18//主题文字字体大小，默认为18px
                },
            },
            calculable : true,
            series: [

                {
                    name:'用暖量',
                    stack: '用量',
                    type: 'pie',
                    radius : ['0','50%'],
                    center: ['50%', '60%'],//饼图中心点位置
                    data:<?php echo ($floor_n_arr); ?>,

                    label : {
                        normal : {
                            formatter: '{b}:{c}: ({d}%)',
                            textStyle : {
                                fontWeight : 'normal',
                                fontSize : 15
                            }
                        }
                    },
                },

            ]
        };
        myChartN.setOption(option);

        var myChartL = echarts.init(document.getElementById('btL'));
        option = {
            title : {
                text: '本月冷用量统计表',
                x:'center',
                textStyle:{
                    fontStyle:'normal',
                    fontWeight:"lighter",
                    fontSize:18//主题文字字体大小，默认为18px
                },
            },
            calculable : true,
            series: [

                {
                    name:'用冷量',
                    stack: '用量',
                    type: 'pie',
                    radius : ['0','50%'],
                    center: ['50%', '60%'],//饼图中心点位置
                    data:<?php echo ($floor_l_arr); ?>,

                    label : {
                        normal : {
                            formatter: '{b}:{c}: ({d}%)',
                            textStyle : {
                                fontWeight : 'normal',
                                fontSize :15

                            }
                        }
                    },
                },

            ]
        };
        myChartL.setOption(option);
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