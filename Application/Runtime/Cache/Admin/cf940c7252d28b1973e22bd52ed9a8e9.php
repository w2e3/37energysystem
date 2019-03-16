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
    <div class="row">
        <div class="col-lg-8 col-sm-6 m-b-xs">
            <div data-toggle="buttons" class="btn-group nav-tabs" style="width: 80%;">
                <?php if($is_ysl){ if($is_active=='ysl'){ ?>
                <label class="btn btn-sm btn-white active" data-target="0">
                    <input type="radio" id="option1" name="options">用水量</label>
                <?php  }else { ?>
                <label class="btn btn-sm btn-white" data-target="0">
                    <input type="radio" id="option1" name="options">用水量</label>
                <?php }} ?>
                <?php if($is_ydl){ if($is_active=='ydl'){ ?>
                <label class="btn btn-sm btn-white active" data-target="1">
                    <input type="radio" id="option2" name="options">电量值</label>
                <?php  }else { ?>
                <label class="btn btn-sm btn-white" data-target="1">
                    <input type="radio" id="option2" name="options">电量值</label>
                <?php }} ?>
                <?php if($is_ynl){ if($is_active=='ynl'){ ?>
                <label class="btn btn-sm btn-white active" data-target="2">
                    <input type="radio" id="option3" name="options">暖能用量</label>
                <?php  }else { ?>
                <label class="btn btn-sm btn-white" data-target="2">
                    <input type="radio" id="option3" name="options">暖能用量</label>
                <?php }}?>
                <?php if($is_yll){ if($is_active=='yll'){ ?>
                <label class="btn btn-sm btn-white active" data-target="3">
                    <input type="radio" id="option4" name="options">冷能用量</label>
                <?php  }else { ?>
                <label class="btn btn-sm btn-white" data-target="3">
                    <input type="radio" id="option4" name="options">冷能用量</label>
                <?php }}?>

                <!--<label class="btn btn-sm btn-white active" data-target="0">-->
                    <!--<input type="radio" id="option1" name="options">用水量</label>-->
                <!--<label class="btn btn-sm btn-white" data-target="1">-->
                    <!--<input type="radio" id="option2" name="options">电量值</label>-->
                <!--<label class="btn btn-sm btn-white" data-target="2">-->
                    <!--<input type="radio" id="option3" name="options">暖能用量</label>-->
                <!--<label class="btn btn-sm btn-white" data-target="3">-->
                    <!--<input type="radio" id="option4" name="options">冷能用量</label>-->
            </div>
        </div>
        <div class="ctab cbody tab-content" style="width: 95%;margin:auto;margin-top: 70px;">

            <?php if($is_ysl){ if($is_active=='ysl'){ ?>
            <div class="ctab content active" id="charts1" style="height: 280px;"></div>
            <?php  }else { ?>
            <div class="ctab content" id="charts1" style="display: none;height: 280px;"></div>
            <?php }} ?>
            <?php if($is_ydl){ if($is_active=='ydl'){ ?>
            <div class="ctab content active" id="charts2" style="height: 300px;"></div>
            <?php  }else { ?>
            <div class="ctab content" id="charts2" style="display: none;height: 300px;"></div>
            <?php }} ?>
            <?php if($is_ynl){ if($is_active=='ynl'){ ?>
            <div class="ctab content active" id="charts3" style="height: 300px;"></div>
            <?php  }else { ?>
            <div class="ctab content" id="charts3" style="display: none;height: 300px;"></div>
            <?php }}?>
            <?php if($is_yll){ if($is_active=='yll'){ ?>
            <div class="ctab content active" id="charts4" style="height: 300px;"></div>
            <?php  }else { ?>
            <div class="ctab content" id="charts4" style="display: none;height: 300px;"></div>
            <?php }}?>

            <!--<div class="ctab content " id="charts1" style="height: 280px;">-->
            <!--</div>-->
            <!--<div class="ctab content active" id="charts2" style="display: none;height: 300px;">-->
            <!--</div>-->
            <!--<div class="ctab content " id="charts3" style="display: none;height: 300px;">-->
            <!--</div>-->
            <!--<div class="ctab content " id="charts4" style="display:none;height: 300px;">-->
            <!--</div>-->
        </div>
    </div>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.12.4.js"></script>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/bootstrap.js"></script>
    <script src="/szny/Public/vendor/diy_component/yuanqu_page/js/echarts.js"></script>

    <script>
        var charts = [];
        var opts = [{
            color:['#0099cc'],
            title: {
                text: '用水量',
                left: '20px'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: ['用水量']
            },
            toolbox: {
                show: false,
                feature: {
                    mark: { show: true },
                    dataView: { show: true, readOnly: true },
                    magicType: { show: true, type: ['line', 'bar'] },
                    restore: { show: true },
                    saveAsImage: { show: true }
                }
            },
            xAxis: {
                data: [""+<?php echo ($day30[29]["dt_m"]); ?>+"月"+  <?php echo ($day30[29]["dt_d"]); ?> +"日", ""+<?php echo ($day30[28]["dt_m"]); ?>+"月"+  <?php echo ($day30[28]["dt_d"]); ?> +"日", ""+<?php echo ($day30[27]["dt_m"]); ?>+"月"+  <?php echo ($day30[27]["dt_d"]); ?> +"日", ""+<?php echo ($day30[26]["dt_m"]); ?>+"月"+  <?php echo ($day30[26]["dt_d"]); ?> +"日", ""+<?php echo ($day30[25]["dt_m"]); ?>+"月"+  <?php echo ($day30[25]["dt_d"]); ?> +"日", ""+<?php echo ($day30[24]["dt_m"]); ?>+"月"+  <?php echo ($day30[24]["dt_d"]); ?> +"日", ""+<?php echo ($day30[23]["dt_m"]); ?>+"月"+  <?php echo ($day30[23]["dt_d"]); ?> +"日", ""+<?php echo ($day30[22]["dt_m"]); ?>+"月"+  <?php echo ($day30[22]["dt_d"]); ?> +"日", ""+<?php echo ($day30[21]["dt_m"]); ?>+"月"+  <?php echo ($day30[21]["dt_d"]); ?> +"日", ""+<?php echo ($day30[20]["dt_m"]); ?>+"月"+  <?php echo ($day30[20]["dt_d"]); ?> +"日", ""+<?php echo ($day30[19]["dt_m"]); ?>+"月"+  <?php echo ($day30[19]["dt_d"]); ?> +"日", ""+<?php echo ($day30[18]["dt_m"]); ?>+"月"+  <?php echo ($day30[18]["dt_d"]); ?> +"日", ""+<?php echo ($day30[17]["dt_m"]); ?>+"月"+  <?php echo ($day30[17]["dt_d"]); ?> +"日", ""+<?php echo ($day30[16]["dt_m"]); ?>+"月"+  <?php echo ($day30[16]["dt_d"]); ?> +"日", ""+<?php echo ($day30[15]["dt_m"]); ?>+"月"+  <?php echo ($day30[15]["dt_d"]); ?> +"日", ""+<?php echo ($day30[14]["dt_m"]); ?>+"月"+  <?php echo ($day30[14]["dt_d"]); ?> +"日", ""+<?php echo ($day30[13]["dt_m"]); ?>+"月"+  <?php echo ($day30[13]["dt_d"]); ?> +"日", ""+<?php echo ($day30[12]["dt_m"]); ?>+"月"+  <?php echo ($day30[12]["dt_d"]); ?> +"日", ""+<?php echo ($day30[11]["dt_m"]); ?>+"月"+  <?php echo ($day30[11]["dt_d"]); ?> +"日", ""+<?php echo ($day30[10]["dt_m"]); ?>+"月"+  <?php echo ($day30[10]["dt_d"]); ?> +"日", ""+<?php echo ($day30[9]["dt_m"]); ?>+"月"+  <?php echo ($day30[9]["dt_d"]); ?> +"日", ""+<?php echo ($day30[8]["dt_m"]); ?>+"月"+  <?php echo ($day30[8]["dt_d"]); ?> +"日", ""+<?php echo ($day30[7]["dt_m"]); ?>+"月"+  <?php echo ($day30[7]["dt_d"]); ?> +"日", ""+<?php echo ($day30[6]["dt_m"]); ?>+"月"+  <?php echo ($day30[6]["dt_d"]); ?> +"日", ""+<?php echo ($day30[5]["dt_m"]); ?>+"月"+  <?php echo ($day30[5]["dt_d"]); ?> +"日", ""+<?php echo ($day30[4]["dt_m"]); ?>+"月"+  <?php echo ($day30[4]["dt_d"]); ?> +"日", ""+<?php echo ($day30[3]["dt_m"]); ?>+"月"+  <?php echo ($day30[3]["dt_d"]); ?> +"日", ""+<?php echo ($day30[2]["dt_m"]); ?>+"月"+  <?php echo ($day30[2]["dt_d"]); ?> +"日", ""+<?php echo ($day30[1]["dt_m"]); ?>+"月"+  <?php echo ($day30[1]["dt_d"]); ?> +"日", ""+<?php echo ($day30[0]["dt_m"]); ?>+"月"+  <?php echo ($day30[0]["dt_d"]); ?> +"日"]
            },
            yAxis: {},
            series: [{
                name: '用水量',
                type: 'bar',
                data: [<?php echo ($day30[29]["ysl"]); ?>, <?php echo ($day30[28]["ysl"]); ?>, <?php echo ($day30[27]["ysl"]); ?>, <?php echo ($day30[26]["ysl"]); ?>, <?php echo ($day30[25]["ysl"]); ?>, <?php echo ($day30[24]["ysl"]); ?>, <?php echo ($day30[23]["ysl"]); ?>, <?php echo ($day30[22]["ysl"]); ?>, <?php echo ($day30[21]["ysl"]); ?>, <?php echo ($day30[20]["ysl"]); ?>, <?php echo ($day30[19]["ysl"]); ?>, <?php echo ($day30[18]["ysl"]); ?>, <?php echo ($day30[17]["ysl"]); ?>, <?php echo ($day30[16]["ysl"]); ?>, <?php echo ($day30[15]["ysl"]); ?>, <?php echo ($day30[14]["ysl"]); ?>, <?php echo ($day30[13]["ysl"]); ?>, <?php echo ($day30[12]["ysl"]); ?>, <?php echo ($day30[11]["ysl"]); ?>, <?php echo ($day30[10]["ysl"]); ?>, <?php echo ($day30[9]["ysl"]); ?>, <?php echo ($day30[8]["ysl"]); ?>, <?php echo ($day30[7]["ysl"]); ?>, <?php echo ($day30[6]["ysl"]); ?>, <?php echo ($day30[5]["ysl"]); ?>, <?php echo ($day30[4]["ysl"]); ?>, <?php echo ($day30[3]["ysl"]); ?>, <?php echo ($day30[2]["ysl"]); ?>, <?php echo ($day30[1]["ysl"]); ?>, <?php echo ($day30[0]["ysl"]); ?>]
            }]
        }, {
            color:['#3366cc'],
            title: {
                text: '电量值',
                left: '20px'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: ['电量值']
            },
            toolbox: {
                show: false,
                feature: {
                    mark: { show: true },
                    dataView: { show: true, readOnly: true },
                    magicType: { show: true, type: ['line', 'bar'] },
                    restore: { show: true },
                    saveAsImage: { show: true }
                }
            },
            xAxis: {
                data: [""+<?php echo ($day30[29]["dt_m"]); ?>+"月"+  <?php echo ($day30[29]["dt_d"]); ?> +"日", ""+<?php echo ($day30[28]["dt_m"]); ?>+"月"+  <?php echo ($day30[28]["dt_d"]); ?> +"日", ""+<?php echo ($day30[27]["dt_m"]); ?>+"月"+  <?php echo ($day30[27]["dt_d"]); ?> +"日", ""+<?php echo ($day30[26]["dt_m"]); ?>+"月"+  <?php echo ($day30[26]["dt_d"]); ?> +"日", ""+<?php echo ($day30[25]["dt_m"]); ?>+"月"+  <?php echo ($day30[25]["dt_d"]); ?> +"日", ""+<?php echo ($day30[24]["dt_m"]); ?>+"月"+  <?php echo ($day30[24]["dt_d"]); ?> +"日", ""+<?php echo ($day30[23]["dt_m"]); ?>+"月"+  <?php echo ($day30[23]["dt_d"]); ?> +"日", ""+<?php echo ($day30[22]["dt_m"]); ?>+"月"+  <?php echo ($day30[22]["dt_d"]); ?> +"日", ""+<?php echo ($day30[21]["dt_m"]); ?>+"月"+  <?php echo ($day30[21]["dt_d"]); ?> +"日", ""+<?php echo ($day30[20]["dt_m"]); ?>+"月"+  <?php echo ($day30[20]["dt_d"]); ?> +"日", ""+<?php echo ($day30[19]["dt_m"]); ?>+"月"+  <?php echo ($day30[19]["dt_d"]); ?> +"日", ""+<?php echo ($day30[18]["dt_m"]); ?>+"月"+  <?php echo ($day30[18]["dt_d"]); ?> +"日", ""+<?php echo ($day30[17]["dt_m"]); ?>+"月"+  <?php echo ($day30[17]["dt_d"]); ?> +"日", ""+<?php echo ($day30[16]["dt_m"]); ?>+"月"+  <?php echo ($day30[16]["dt_d"]); ?> +"日", ""+<?php echo ($day30[15]["dt_m"]); ?>+"月"+  <?php echo ($day30[15]["dt_d"]); ?> +"日", ""+<?php echo ($day30[14]["dt_m"]); ?>+"月"+  <?php echo ($day30[14]["dt_d"]); ?> +"日", ""+<?php echo ($day30[13]["dt_m"]); ?>+"月"+  <?php echo ($day30[13]["dt_d"]); ?> +"日", ""+<?php echo ($day30[12]["dt_m"]); ?>+"月"+  <?php echo ($day30[12]["dt_d"]); ?> +"日", ""+<?php echo ($day30[11]["dt_m"]); ?>+"月"+  <?php echo ($day30[11]["dt_d"]); ?> +"日", ""+<?php echo ($day30[10]["dt_m"]); ?>+"月"+  <?php echo ($day30[10]["dt_d"]); ?> +"日", ""+<?php echo ($day30[9]["dt_m"]); ?>+"月"+  <?php echo ($day30[9]["dt_d"]); ?> +"日", ""+<?php echo ($day30[8]["dt_m"]); ?>+"月"+  <?php echo ($day30[8]["dt_d"]); ?> +"日", ""+<?php echo ($day30[7]["dt_m"]); ?>+"月"+  <?php echo ($day30[7]["dt_d"]); ?> +"日", ""+<?php echo ($day30[6]["dt_m"]); ?>+"月"+  <?php echo ($day30[6]["dt_d"]); ?> +"日", ""+<?php echo ($day30[5]["dt_m"]); ?>+"月"+  <?php echo ($day30[5]["dt_d"]); ?> +"日", ""+<?php echo ($day30[4]["dt_m"]); ?>+"月"+  <?php echo ($day30[4]["dt_d"]); ?> +"日", ""+<?php echo ($day30[3]["dt_m"]); ?>+"月"+  <?php echo ($day30[3]["dt_d"]); ?> +"日", ""+<?php echo ($day30[2]["dt_m"]); ?>+"月"+  <?php echo ($day30[2]["dt_d"]); ?> +"日", ""+<?php echo ($day30[1]["dt_m"]); ?>+"月"+  <?php echo ($day30[1]["dt_d"]); ?> +"日", ""+<?php echo ($day30[0]["dt_m"]); ?>+"月"+  <?php echo ($day30[0]["dt_d"]); ?> +"日"]
            },
            yAxis: {},
            series: [{
                name: '电量值',
                type: 'bar',
                data: [<?php echo ($day30[29]["ydl"]); ?>, <?php echo ($day30[28]["ydl"]); ?>, <?php echo ($day30[27]["ydl"]); ?>, <?php echo ($day30[26]["ydl"]); ?>, <?php echo ($day30[25]["ydl"]); ?>, <?php echo ($day30[24]["ydl"]); ?>, <?php echo ($day30[23]["ydl"]); ?>, <?php echo ($day30[22]["ydl"]); ?>, <?php echo ($day30[21]["ydl"]); ?>, <?php echo ($day30[20]["ydl"]); ?>, <?php echo ($day30[19]["ydl"]); ?>, <?php echo ($day30[18]["ydl"]); ?>, <?php echo ($day30[17]["ydl"]); ?>, <?php echo ($day30[16]["ydl"]); ?>, <?php echo ($day30[15]["ydl"]); ?>, <?php echo ($day30[14]["ydl"]); ?>, <?php echo ($day30[13]["ydl"]); ?>, <?php echo ($day30[12]["ydl"]); ?>, <?php echo ($day30[11]["ydl"]); ?>, <?php echo ($day30[10]["ydl"]); ?>, <?php echo ($day30[9]["ydl"]); ?>, <?php echo ($day30[8]["ydl"]); ?>, <?php echo ($day30[7]["ydl"]); ?>, <?php echo ($day30[6]["ydl"]); ?>, <?php echo ($day30[5]["ydl"]); ?>, <?php echo ($day30[4]["ydl"]); ?>, <?php echo ($day30[3]["ydl"]); ?>, <?php echo ($day30[2]["ydl"]); ?>, <?php echo ($day30[1]["ydl"]); ?>, <?php echo ($day30[0]["ydl"]); ?>]
            }]
        }, {
            color:['#ff6347'],
            title: {
                text: '暖能用量',
                left: '20px'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: ['暖能用量']
            },
            toolbox: {
                show: false,
                feature: {
                    mark: { show: true },
                    dataView: { show: true, readOnly: true },
                    magicType: { show: true, type: ['line', 'bar'] },
                    restore: { show: true },
                    saveAsImage: { show: true }
                }
            },
            xAxis: [{
                type: 'category',
                data: [""+<?php echo ($day30[29]["dt_m"]); ?>+"月"+  <?php echo ($day30[29]["dt_d"]); ?> +"日", ""+<?php echo ($day30[28]["dt_m"]); ?>+"月"+  <?php echo ($day30[28]["dt_d"]); ?> +"日", ""+<?php echo ($day30[27]["dt_m"]); ?>+"月"+  <?php echo ($day30[27]["dt_d"]); ?> +"日", ""+<?php echo ($day30[26]["dt_m"]); ?>+"月"+  <?php echo ($day30[26]["dt_d"]); ?> +"日", ""+<?php echo ($day30[25]["dt_m"]); ?>+"月"+  <?php echo ($day30[25]["dt_d"]); ?> +"日", ""+<?php echo ($day30[24]["dt_m"]); ?>+"月"+  <?php echo ($day30[24]["dt_d"]); ?> +"日", ""+<?php echo ($day30[23]["dt_m"]); ?>+"月"+  <?php echo ($day30[23]["dt_d"]); ?> +"日", ""+<?php echo ($day30[22]["dt_m"]); ?>+"月"+  <?php echo ($day30[22]["dt_d"]); ?> +"日", ""+<?php echo ($day30[21]["dt_m"]); ?>+"月"+  <?php echo ($day30[21]["dt_d"]); ?> +"日", ""+<?php echo ($day30[20]["dt_m"]); ?>+"月"+  <?php echo ($day30[20]["dt_d"]); ?> +"日", ""+<?php echo ($day30[19]["dt_m"]); ?>+"月"+  <?php echo ($day30[19]["dt_d"]); ?> +"日", ""+<?php echo ($day30[18]["dt_m"]); ?>+"月"+  <?php echo ($day30[18]["dt_d"]); ?> +"日", ""+<?php echo ($day30[17]["dt_m"]); ?>+"月"+  <?php echo ($day30[17]["dt_d"]); ?> +"日", ""+<?php echo ($day30[16]["dt_m"]); ?>+"月"+  <?php echo ($day30[16]["dt_d"]); ?> +"日", ""+<?php echo ($day30[15]["dt_m"]); ?>+"月"+  <?php echo ($day30[15]["dt_d"]); ?> +"日", ""+<?php echo ($day30[14]["dt_m"]); ?>+"月"+  <?php echo ($day30[14]["dt_d"]); ?> +"日", ""+<?php echo ($day30[13]["dt_m"]); ?>+"月"+  <?php echo ($day30[13]["dt_d"]); ?> +"日", ""+<?php echo ($day30[12]["dt_m"]); ?>+"月"+  <?php echo ($day30[12]["dt_d"]); ?> +"日", ""+<?php echo ($day30[11]["dt_m"]); ?>+"月"+  <?php echo ($day30[11]["dt_d"]); ?> +"日", ""+<?php echo ($day30[10]["dt_m"]); ?>+"月"+  <?php echo ($day30[10]["dt_d"]); ?> +"日", ""+<?php echo ($day30[9]["dt_m"]); ?>+"月"+  <?php echo ($day30[9]["dt_d"]); ?> +"日", ""+<?php echo ($day30[8]["dt_m"]); ?>+"月"+  <?php echo ($day30[8]["dt_d"]); ?> +"日", ""+<?php echo ($day30[7]["dt_m"]); ?>+"月"+  <?php echo ($day30[7]["dt_d"]); ?> +"日", ""+<?php echo ($day30[6]["dt_m"]); ?>+"月"+  <?php echo ($day30[6]["dt_d"]); ?> +"日", ""+<?php echo ($day30[5]["dt_m"]); ?>+"月"+  <?php echo ($day30[5]["dt_d"]); ?> +"日", ""+<?php echo ($day30[4]["dt_m"]); ?>+"月"+  <?php echo ($day30[4]["dt_d"]); ?> +"日", ""+<?php echo ($day30[3]["dt_m"]); ?>+"月"+  <?php echo ($day30[3]["dt_d"]); ?> +"日", ""+<?php echo ($day30[2]["dt_m"]); ?>+"月"+  <?php echo ($day30[2]["dt_d"]); ?> +"日", ""+<?php echo ($day30[1]["dt_m"]); ?>+"月"+  <?php echo ($day30[1]["dt_d"]); ?> +"日", ""+<?php echo ($day30[0]["dt_m"]); ?>+"月"+  <?php echo ($day30[0]["dt_d"]); ?> +"日"]
            }],
            yAxis: [{
                // type: 'value'
            }],
            // visualMap: {
            // show: false,
            // min: 0,
            // max: 400,
            // range: [0, 370],
            // inRange: { color: ['red', 'blue', 'green'] },
            // outOfRange: {
            // color: ['red', 'rgba(3,4,5,0.4)', 'yellow'],
            // symbolSize: [30, 100]
            // }
            // },
            series: [{
                name: '暖能用量',
                type: 'bar',
                data: [<?php echo ($day30[29]["ynl"]); ?>, <?php echo ($day30[28]["ynl"]); ?>, <?php echo ($day30[27]["ynl"]); ?>, <?php echo ($day30[26]["ynl"]); ?>, <?php echo ($day30[25]["ynl"]); ?>, <?php echo ($day30[24]["ynl"]); ?>, <?php echo ($day30[23]["ynl"]); ?>, <?php echo ($day30[22]["ynl"]); ?>, <?php echo ($day30[21]["ynl"]); ?>, <?php echo ($day30[20]["ynl"]); ?>, <?php echo ($day30[19]["ynl"]); ?>, <?php echo ($day30[18]["ynl"]); ?>, <?php echo ($day30[17]["ynl"]); ?>, <?php echo ($day30[16]["ynl"]); ?>, <?php echo ($day30[15]["ynl"]); ?>, <?php echo ($day30[14]["ynl"]); ?>, <?php echo ($day30[13]["ynl"]); ?>, <?php echo ($day30[12]["ynl"]); ?>, <?php echo ($day30[11]["ynl"]); ?>, <?php echo ($day30[10]["ynl"]); ?>, <?php echo ($day30[9]["ynl"]); ?>, <?php echo ($day30[8]["ynl"]); ?>, <?php echo ($day30[7]["ynl"]); ?>, <?php echo ($day30[6]["ynl"]); ?>, <?php echo ($day30[5]["ynl"]); ?>, <?php echo ($day30[4]["ynl"]); ?>, <?php echo ($day30[3]["ynl"]); ?>, <?php echo ($day30[2]["ynl"]); ?>, <?php echo ($day30[1]["ynl"]); ?>, <?php echo ($day30[0]["ynl"]); ?>]
            }]
        }, {
            color:['#40e0d0'],
            title: {
                text: '冷能用量',
                left: '20px'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: ['冷能用量']
            },
            toolbox: {
                show: false,
                feature: {
                    mark: { show: true },
                    dataView: { show: true, readOnly: true },
                    magicType: { show: true, type: ['line', 'bar'] },
                    restore: { show: true },
                    saveAsImage: { show: true }
                }
            },
            xAxis: {
                type: 'category',
                data: [""+<?php echo ($day30[29]["dt_m"]); ?>+"月"+  <?php echo ($day30[29]["dt_d"]); ?> +"日", ""+<?php echo ($day30[29]["dt_m"]); ?>+"月"+  <?php echo ($day30[29]["dt_d"]); ?> +"日", ""+<?php echo ($day30[27]["dt_m"]); ?>+"月"+  <?php echo ($day30[27]["dt_d"]); ?> +"日", ""+<?php echo ($day30[26]["dt_m"]); ?>+"月"+  <?php echo ($day30[26]["dt_d"]); ?> +"日", ""+<?php echo ($day30[25]["dt_m"]); ?>+"月"+  <?php echo ($day30[25]["dt_d"]); ?> +"日", ""+<?php echo ($day30[24]["dt_m"]); ?>+"月"+  <?php echo ($day30[24]["dt_d"]); ?> +"日", ""+<?php echo ($day30[23]["dt_m"]); ?>+"月"+  <?php echo ($day30[23]["dt_d"]); ?> +"日", ""+<?php echo ($day30[22]["dt_m"]); ?>+"月"+  <?php echo ($day30[22]["dt_d"]); ?> +"日", ""+<?php echo ($day30[21]["dt_m"]); ?>+"月"+  <?php echo ($day30[21]["dt_d"]); ?> +"日", ""+<?php echo ($day30[20]["dt_m"]); ?>+"月"+  <?php echo ($day30[20]["dt_d"]); ?> +"日", ""+<?php echo ($day30[19]["dt_m"]); ?>+"月"+  <?php echo ($day30[19]["dt_d"]); ?> +"日", ""+<?php echo ($day30[18]["dt_m"]); ?>+"月"+  <?php echo ($day30[18]["dt_d"]); ?> +"日", ""+<?php echo ($day30[17]["dt_m"]); ?>+"月"+  <?php echo ($day30[17]["dt_d"]); ?> +"日", ""+<?php echo ($day30[16]["dt_m"]); ?>+"月"+  <?php echo ($day30[16]["dt_d"]); ?> +"日", ""+<?php echo ($day30[15]["dt_m"]); ?>+"月"+  <?php echo ($day30[15]["dt_d"]); ?> +"日", ""+<?php echo ($day30[14]["dt_m"]); ?>+"月"+  <?php echo ($day30[14]["dt_d"]); ?> +"日", ""+<?php echo ($day30[13]["dt_m"]); ?>+"月"+  <?php echo ($day30[13]["dt_d"]); ?> +"日", ""+<?php echo ($day30[12]["dt_m"]); ?>+"月"+  <?php echo ($day30[12]["dt_d"]); ?> +"日", ""+<?php echo ($day30[11]["dt_m"]); ?>+"月"+  <?php echo ($day30[11]["dt_d"]); ?> +"日", ""+<?php echo ($day30[10]["dt_m"]); ?>+"月"+  <?php echo ($day30[10]["dt_d"]); ?> +"日", ""+<?php echo ($day30[9]["dt_m"]); ?>+"月"+  <?php echo ($day30[9]["dt_d"]); ?> +"日", ""+<?php echo ($day30[8]["dt_m"]); ?>+"月"+  <?php echo ($day30[8]["dt_d"]); ?> +"日", ""+<?php echo ($day30[7]["dt_m"]); ?>+"月"+  <?php echo ($day30[7]["dt_d"]); ?> +"日", ""+<?php echo ($day30[6]["dt_m"]); ?>+"月"+  <?php echo ($day30[6]["dt_d"]); ?> +"日", ""+<?php echo ($day30[5]["dt_m"]); ?>+"月"+  <?php echo ($day30[5]["dt_d"]); ?> +"日", ""+<?php echo ($day30[4]["dt_m"]); ?>+"月"+  <?php echo ($day30[4]["dt_d"]); ?> +"日", ""+<?php echo ($day30[3]["dt_m"]); ?>+"月"+  <?php echo ($day30[3]["dt_d"]); ?> +"日", ""+<?php echo ($day30[2]["dt_m"]); ?>+"月"+  <?php echo ($day30[2]["dt_d"]); ?> +"日", ""+<?php echo ($day30[1]["dt_m"]); ?>+"月"+  <?php echo ($day30[1]["dt_d"]); ?> +"日", ""+<?php echo ($day30[0]["dt_m"]); ?>+"月"+  <?php echo ($day30[0]["dt_d"]); ?> +"日"]
            },
            yAxis: {},
            series: [{
                name: '冷能用量',
                type: 'bar',
                data: [<?php echo ($day30[29]["yll"]); ?>, <?php echo ($day30[28]["yll"]); ?>, <?php echo ($day30[27]["yll"]); ?>, <?php echo ($day30[26]["yll"]); ?>, <?php echo ($day30[25]["yll"]); ?>, <?php echo ($day30[24]["yll"]); ?>, <?php echo ($day30[23]["yll"]); ?>, <?php echo ($day30[22]["yll"]); ?>, <?php echo ($day30[21]["yll"]); ?>, <?php echo ($day30[20]["yll"]); ?>, <?php echo ($day30[19]["yll"]); ?>, <?php echo ($day30[18]["yll"]); ?>, <?php echo ($day30[17]["yll"]); ?>, <?php echo ($day30[16]["yll"]); ?>, <?php echo ($day30[15]["yll"]); ?>, <?php echo ($day30[14]["yll"]); ?>, <?php echo ($day30[13]["yll"]); ?>, <?php echo ($day30[12]["yll"]); ?>, <?php echo ($day30[11]["yll"]); ?>, <?php echo ($day30[10]["yll"]); ?>, <?php echo ($day30[9]["yll"]); ?>, <?php echo ($day30[8]["yll"]); ?>, <?php echo ($day30[7]["yll"]); ?>, <?php echo ($day30[6]["yll"]); ?>, <?php echo ($day30[5]["yll"]); ?>, <?php echo ($day30[4]["yll"]); ?>, <?php echo ($day30[3]["yll"]); ?>, <?php echo ($day30[2]["yll"]); ?>, <?php echo ($day30[1]["yll"]); ?>, <?php echo ($day30[0]["yll"]); ?>]
            }]
        }];
    </script>
    <script>
        var show_index=null;
        var div_id;


        $(function() {

            $(".cbody>.content").each(function() {
//                console.log($(this).get(0));
//                console.log($(this).attr('id'));
                if(div_id==null)
                {
                    div_id=$(this).attr('id');

                }
                //有几中能源显示这就初始化几个 div_id 目前等于charts3
                charts.push(echarts.init($(this).get(0)));

            });

            $(".cbody>.content:gt(0)").hide();
            $(".nav-tabs ").delegate('label', 'click', function(e) {
                if ($(this).hasClass("active")) {
                    return;
                }
                $(this).addClass('active').siblings('label').removeClass("active");
                var index = $(this).data('target');
                var optskey = $(this).data('target');

                <?php if($is_ynl &&!$is_ysl){?>
                   var index = index-2;
                <?php }?>

//                console.log(index);
                $('.cbody>.content:eq(' + index + ')').show(function() {
                     charts[index].setOption(opts[optskey]);
                    charts[index].resize();
                }).siblings().hide();

            });

//            console.log(div_id);
            if(div_id=='charts1') {
                show_index=0;
            } else if(div_id=='charts2') {
                show_index=1;
            } else if(div_id=='charts3') {
                show_index=2;
            } else if(div_id=='charts4') {
                show_index=3;
            }


//            console.log(charts);
//            console.log(show_index);
            charts[0].setOption(opts[show_index]);
        });
        $(window).resize(function() {
            $(charts).each(function(index, chart) {
                chart.resize();
            });
        });
    </script>
</body>
<style type="text/css">
    canvas{width: 85%;margin-top: 120px;}
    #charts{margin-left: 20px;}
    #charts{margin-left: 20px;}
    #charts{margin-left: 20px;}
</style>
</html>