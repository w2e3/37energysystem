<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<link href="/szny/Public/vendor/bootstrap-table/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
	<link href="/szny/Public/adminframework/css/font-awesome.css?v=4.4.0" rel="stylesheet">
	<link href="/szny/Public/adminframework/css/plugins/chosen/chosen.css" rel="stylesheet">
	<link href="/szny/Public/adminframework/css/plugins/switchery/switchery.css" rel="stylesheet">
	<link href="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" >
	<link href="/szny/Public/adminframework/css/animate.css" rel="stylesheet">
	<link href="/szny/Public/adminframework/css/style.css?v=4.0.0" rel="stylesheet">
	<link rel="stylesheet" href="/szny/Public/vendor/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<link href="/szny/Public/vendor/diy_component/func_scrolltab/atppagetab.css" rel="stylesheet">
	<base target="_blank">
	<style>
		.wrapper-content {
			padding: 0px;
		}
		.wrapper {
			padding: 0px;
		}

		.ibox-content {
			border-width: 0px 0px;
			padding: 0px 0px 0px 0px
		}
		.gray-bg {
			background-color: #ffffff;
		}
		.table
		{
			max-width: none;;
		}
		* {
			margin: 0;
			padding: 0;
		}
		.tabs .atp-nav {
			border-left: 1px solid #F8F7EE;
			height: 40px;
		}
		.tabs .atp-nav li {
			float: left;
			width: 100px;
			border-top: 1px solid #F8F7EE;
			border-right: 1px solid #F8F7EE;
			list-style: none;
		}
		.tabs .atp-nav li a {
			display: inline-block;
			width: 100%;
			height: 40px;
			background-color: #F8F7EE;
			text-align: center;
			line-height: 40px;
			font-size: 16px;
			color: #ccc;
			text-decoration: none;
		}
		.tabs .atp-nav li a:hover {
			background-color: #fff;
			color: #000;
		}

		.tabs .atp-nav li a.selected {
			background-color: #fff;
			color: #000;
			font-size: 18px;
		}

        .table
        {
            max-width: none;
        }
        .form-control
        {
            display: inline-block;
            margin-bottom: 5px;
        }
        .float-e-margins .btn
        {
            margin-bottom: 1px;
        }
        .control-label
        {
            display: inline-block;
            /*margin-bottom: 5px;;*/
        }
        #atpbiztable tr:hover{
        	cursor: pointer;
        }
	</style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<?php if($_GET['regiontype']== 'rg'): if($_GET['tabshow']!= 'false'): ?><div class="content-tabs">
        <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button>
        <nav class="page-tabs J_menuTabs">
            <div class="page-tabs-content">
                <?php if($_GET['regionlevel']== 'regionroot'): ?><!--根节点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexregionroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>
                <?php if($_GET['regionlevel']== 'region'): ?><!--非根节点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>
                <?php if($_GET['regionlevel']== 'devicepoint'): ?><!--设备点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexdevicepoint?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>

                <a href='/szny/index.php/Admin/RgDev?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=1&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>设备状态</a>
                <?php if($_SESSION['is_hnwl']!= ''): ?><a href='/szny/index.php/Admin/RgItemAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=2&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>分项报表</a>
                    <a href='/szny/index.php/Admin/RgAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=3&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a>
                    <a href='/szny/index.php/Admin/RgReport?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=4&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>报表</a>
                    <a href='/szny/index.php/Admin/RgContrastAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=5&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>同比环比</a>
                    <a href='/szny/index.php/Admin/RgOriginalData/Twicedatad?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=6&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史采集数据</a>

                    <?php else: ?>
                    <?php if($_SESSION['role_iskfs']== false): ?><a href='/szny/index.php/Admin/RgAlarmConfirm?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=2&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self"  class='J_menuTab'>待确认报警</a>
                        <a href='/szny/index.php/Admin/RgRepairAdd?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=3&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>添加维修单</a>
                        <a href='/szny/index.php/Admin/RgRepairDist?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=4&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>待接维修单</a>
                        <a href='/szny/index.php/Admin/RgRepairProcess?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=5&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>待处理维修单</a>
                        <a href='/szny/index.php/Admin/RgAlarmHistory?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=6&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史报警记录</a>
                        <a href='/szny/index.php/Admin/RgRepairHistory?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=7&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史维修记录</a>
                        <a href='/szny/index.php/Admin/RgItemAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=8&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>分项报表</a>
                        <!-- <?php if($_GET['regtype']== 'DEVICE'): else: ?>
                            <a href='/szny/index.php/Admin/RgAnalyzes?regtype=<?php echo ($_GET['regtype']); ?>&tabindex=9&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a><?php endif; ?> -->
                        <a href='/szny/index.php/Admin/RgAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=9&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a>
                        <a href='/szny/index.php/Admin/RgReport?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=10&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>报表</a>
                        <a href='/szny/index.php/Admin/RgContrastAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=11&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>同比环比</a>
                        <a href='/szny/index.php/Admin/RgEngeryPlan?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=12&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>能源计划</a>
                        <a href='/szny/index.php/Admin/RgExceptionDayQs?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=13&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>日报缺失</a>
                        <a href='/szny/index.php/Admin/RgExceptionDayEc?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=14&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>日报异常</a>
                        <a href='/szny/index.php/Admin/RgExceptionHourQs?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=15&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>时报缺失</a>
                        <a href='/szny/index.php/Admin/RgExceptionHourEc?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=16&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>时报异常</a>
                        <a href='/szny/index.php/Admin/RgOriginalData/Twicedatad?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=17&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史采集数据</a>
                        <!--<a href='/szny/index.php/Admin/RgSample/index?regtype=<?php echo ($_GET['regtype']); ?>&tabindex=18&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>示例:雇员管理</a>--><?php endif; endif; ?>

            </div>
        </nav>
        <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
    </div><?php endif; endif; ?>
<?php if($_GET['regiontype']== 'sn'): if($_GET['tabshow']!= 'false'): ?><div class="content-tabs">
        <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button>
        <nav class="page-tabs J_menuTabs">
            <div class="page-tabs-content">



                <?php if($_GET['regionlevel']== 'regionroot'): ?><!--根节点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexregionroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>
                <?php if($_GET['regionlevel']== 'region'): ?><!--非根节点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>
                <?php if($_GET['regionlevel']== 'devicepoint'): ?><!--设备点-->
                    <a href='/szny/index.php/Admin/RgGeneral/indexdevicepoint?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>综合信息</a><?php endif; ?>
                <!--<a href='/szny/index.php/Admin/RgGeneral/indexsn?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=1&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>能源鸟瞰</a>-->
                <a href='/szny/index.php/Admin/RgDev?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=1&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>设备状态</a>

                <?php if($_SESSION['is_hnwl']!= ''): ?><a href='/szny/index.php/Admin/RgItemAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=2&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>分项报表</a>
                    <a href='/szny/index.php/Admin/RgAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=3&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a>
                    <a href='/szny/index.php/Admin/RgReport?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=4&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>报表</a>
                    <a href='/szny/index.php/Admin/RgContrastAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=5&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>同比环比</a>
                    <a href='/szny/index.php/Admin/RgOriginalData/Twicedatad?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=6&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史采集数据</a>

                    <?php else: ?>
                    <?php if($_SESSION['role_iskfs']== false): ?><a href='/szny/index.php/Admin/RgAlarmConfirm?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=2&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self"  class='J_menuTab'>待确认报警</a>
                        <a href='/szny/index.php/Admin/RgRepairAdd?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=3&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>添加维修单</a>
                        <a href='/szny/index.php/Admin/RgRepairDist?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=4&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>待接维修单</a>
                        <a href='/szny/index.php/Admin/RgRepairProcess?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=5&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>待处理维修单</a>
                        <a href='/szny/index.php/Admin/RgAlarmHistory?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=6&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史报警记录</a>
                        <a href='/szny/index.php/Admin/RgRepairHistory?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=7&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史维修记录</a>
                        <a href='/szny/index.php/Admin/RgItemAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=8&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>分项报表</a>
                        <!-- <?php if($_GET['regtype']== 'DEVICE'): else: ?>
                            <a href='/szny/index.php/Admin/RgAnalyzes?regtype=<?php echo ($_GET['regtype']); ?>&tabindex=9&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a><?php endif; ?> -->
                        <a href='/szny/index.php/Admin/RgAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=9&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>数据分析</a>
                        <a href='/szny/index.php/Admin/RgReport?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=10&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>报表</a>
                        <a href='/szny/index.php/Admin/RgContrastAnalyzes?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=11&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>同比环比</a>
                        <a href='/szny/index.php/Admin/RgEngeryPlan?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=12&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>能源计划</a>
                        <a href='/szny/index.php/Admin/RgExceptionDayQs?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=13&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>日报缺失</a>
                        <a href='/szny/index.php/Admin/RgExceptionDayEc?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=14&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>日报异常</a>
                        <a href='/szny/index.php/Admin/RgExceptionHourQs?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=15&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>时报缺失</a>
                        <a href='/szny/index.php/Admin/RgExceptionHourEc?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=16&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>时报异常</a>
                        <a href='/szny/index.php/Admin/RgOriginalData/Twicedatad?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=17&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>历史采集数据</a>
                        <!--<a href='/szny/index.php/Admin/RgSample/index?regtype=<?php echo ($_GET['regtype']); ?>&tabindex=18&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>' target="_self" class='J_menuTab'>示例:雇员管理</a>--><?php endif; endif; ?>

            </div>
        </nav>
        <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
    </div><?php endif; endif; ?>

			<div class="row row-lg">
				<div class="col-sm-12">
					<div id="atpbiztoolbar">
						<button class="btn btn-success" type="button" id="sys_search"><i class="fa fa-search"></i>&nbsp;更多搜索</button>
					</div>
					<table id="atpbiztable"></table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="sys_dlg" role="dialog" class="modal fade "></div>
<script src="/szny/Public/vendor/bootstrap-table/jquery.min.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap/js/bootstrap.min.js"></script>
<script src="/szny/Public/vendor/My97DatePicker/WdatePicker.js"></script>
<script src="/szny/Public/adminframework/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/szny/Public/adminframework/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<script src="/szny/Public/adminframework/js/plugins/switchery/switchery.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/locale/bootstrap-table-zh-CN-atp.js"></script>
<script src="/szny/Public/vendor/html5Validate/src/jquery-html5Validate.js"></script>
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.excheck.js"></script>
<script src="/szny/Public/vendor/diy_component/func_scrolltab/atppagetab.js"></script>

<script>
	jumptab('<?php echo ($_GET['tabindex']); ?>');
	window.parent.ATP_BOX_INIT();
	window.parent.ATP_BOX_SEARCHINIT();
	$(function () {
        $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true, width:'150px'});
    });
</script>
<script>
	var navs = $('.tabs .onetab');
 	navs.on('click',function() {
	 	$(this).addClass('selected').parent().siblings().children('.onetab').removeClass('selected');
 	})

    $('.left_button').click(function() {
    	var tabswidth = $('.tabs').width()-50;
    	console.log(tabswidth);
    	$('.atp-nav').css('transform','translateX(0)');
    	$('.left_button').hide();
    })


    $('.right_button').click(function() {
    	var tabswidth = -$('.tabs').width()+50;
    	console.log(tabswidth);
    	$('.atp-nav').css('transform','translateX('+tabswidth+'px)');
    	$('.left_button').show();
    })

	/***********************************************************************************************************/
	GLOBAL_SEARCHNAME = "搜索位置点";
	$(function () {
		$('#atpbiztable').bootstrapTable({
			url: '/szny/index.php/Admin/RgDev/getData?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=<?php echo ($_GET['tabindex']); ?>&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>',       //请求后台的URL（*）
			method: 'post',                      //请求方式（*）
			toolbar: '#atpbiztoolbar',                //工具按钮用哪个容器
			striped: true,                      //是否显示行间隔色
			cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
			pagination: true,                   //是否显示分页（*）
			iconSize: 'outline',
			sortable: true,                     //是否启用排序
			sortName:"",
			sortOrder: "",                   //排序方式
			queryParams: queryParams,//传递参数（*）
			sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
			pageNumber: 1,                       //初始化加载第一页，默认第一页
			pageSize: 10,                       //每页的记录行数（*）
			pageList: [5,10, 25, 50, 100],        //可供选择的每页的行数（*）
            search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
//            strictSearch: true,
//            showColumns: true,                  //是否显示所有的列
            showRefresh: true,                  //是否显示刷新按钮
			minimumCountColumns: 2,             //最少允许的列数
			clickToSelect: true,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
			uniqueId: "dev_atpid",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
			detailView: false,                   //是否显示父子表
			detailFormatter: "detailFormatter",
			height:510,
			columns: [
				[
//                    {checkbox: true},
					{title: '序号', width: 40,align:'center',
						formatter: function (value, row, index)
						{
							var option =  $('#atpbiztable').bootstrapTable("getOptions");
							return option.pageSize * (option.pageNumber - 1) + index + 1;
						}
					},
					{field: 'rgn_name', title: '位置点',align:'center', valign:'middle', sortable: true},
					{field: 'rgn_path', title: '设备所在位置',align:'center', valign:'middle', sortable: false},
					{field: 'dev_acquisition', title: '采集号',align:'center', valign:'middle', sortable: true},
					{field: 'dev_code', title: '设备卡编号', align:'center', valign:'middle',sortable: true},
					{field: 'dev_name', title: '设备类型',align:'center', valign:'middle', sortable: true},
					// {field: 'dev_ip', title: 'IP地址',align:'center', valign:'middle', sortable: true},
					{field: 'dev_lastuploadtime', title: '最后上传时间',align:'center', valign:'middle', sortable: true},
					// {field: 'dev_unuploadlegth', title: '未上传时间',align:'center', valign:'middle', sortable: true,
					// 	formatter: function (value, row, index) {
					// 		var a = row['dev_unuploadlegth'] + '小时';
					// 		if (null == value || '' == value) {
					// 			return '';
					// 		}
					// 		else {
					// 			return a;
					// 		}
					// 	}
					// },
					{field: 'dev_status', title: '状态',align:'center', valign:'middle', sortable: true},
					//////////////////////////////////////////////////////////////////////////////////////////////
					{field:'dev_atpid',title:'主键',visible:false},
					{field:'dev_atpcreatedatetime',title:'创建时间',visible:false},
					{field:'dev_atpcreateuser',title:'创建人',visible:false},
					{field:'dev_atplastmodifydatetime',title:'最后修改时间',visible:false},
					{field:'dev_atplastmodifyuser',title:'最后修改人',visible:false},
					{field:'dev_atpstatus',title:'数据状态',visible:false},
					{field:'dev_atpsort',title:'数据排序',visible:false},
					{field:'dev_atpremark',title:'数据备注',visible:false},
					{field: 'dev_atpid', title: '操作',align:'center', sortable: false,width:150,
						formatter: function (value, row, index) {
							var pregionid="'"+  row.pregionid +"'";
							var rgnname="'"+  row.rgn_name +"'";
							var rgn_atpid="'"+  row.rgn_atpid +"'";
							var inp = "'"+  value +"'";
							var a = '<a  class="btn btn-success btn-xs" onclick="dealInRow(' + inp + ','+rgn_atpid+')">综合信息</a>&nbsp;';
								a += '<a  class="btn btn-info btn-xs" onclick="checkInRow(' +rgn_atpid+','+pregionid+','+rgnname+')">位置查看</a>&nbsp;<a class="btn btn-danger btn-xs" onclick="jumpreal(' + inp + ','+rgn_atpid+')">实时数据</a>';
								return a;
						}
					},
				]
			],
			onDblClickRow: function (row) {
//               window.parent.ATP_BOX_OPEN("/szny/index.php/Admin/RgDev/checkdev?dev_atpid="+row['dev_atpid']+"&rgn_atpid="+row['rgn_atpid'],checkCallback);

			},
			onSort: function (name, order) {
//                console.log(name+order);
			},
		});
	});
	function checkCallback() {
        window.parent.ATP_BOX_CLOSE();
    }
	function queryParams(params) {  //配置参数
		var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
			limit: params.limit,   //页面大小
			offset: params.offset,  //页码
			search: params.search,
			sort: params.sort,  //排序列名
			devicename:$('#devicename').val(),
			sortOrder: params.order,//排位命令（desc，asc）
			dev_name:$('#dev_name',parent.document).val(),
            rgn_name:$('#rgn_name',parent.document).val(),
            dev_acquisition:$('#dev_acquisition',parent.document).val(),
            dev_lastuploadtime:$('#dev_lastuploadtime',parent.document).val(),
            dev_unuploadlegth:$('#dev_unuploadlegth',parent.document).val(),
            dev_regionid:$('#rgn_atpid',parent.document).val()
		};
		return temp;
	}
	function dealInRow(id,rgn_atpid) {
		window.parent.ATP_REGIONJUMZH(rgn_atpid);
	}

	function checkInRow(region_id,pregionid,rgnname)
	{

//		console.log(rgnname);
		if(rgnname.indexOf("0101") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0102") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0103") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0104") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0105") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0106") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0107") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0108") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F1_ceng8F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2A01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2A10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2A_ceng10F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2B01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2B10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2B_ceng10F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2C01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng10F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C11") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng11F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C12") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng12F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2C13") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2C_ceng13F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2D01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng10F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D11") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng11F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D12") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng12F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2D13") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2D_ceng13F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2E01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2E10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2E_ceng10F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("2F01") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F02") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F03") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F04") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F05") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F06") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F07") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F08") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng8F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F09") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng9F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("2F10") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F2F_ceng10F?rgn_atpidcurrent='+region_id;};

		if(rgnname.indexOf("0301") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng1F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0302") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng2F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0303") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng3F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0304") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng4F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0305") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng5F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0306") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng6F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0307") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng7F?rgn_atpidcurrent='+region_id;};
		if(rgnname.indexOf("0308") ==0) {parent.location.href = '/szny/index.php/Admin/Parkoverview/F3_ceng8F?rgn_atpidcurrent='+region_id;};


	}

	function jumpreal(id,rgn_atpid)
	{
//		parent.location.href = '/szny/index.php/Admin/Parkoverview?rgn_atpid=' + pregionid + '&rgnname=' + rgnname+'&regtype=<?php echo ($_GET['regtype']); ?>';
		var url = "/szny/index.php/Admin/OriginaldataReal/index?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=<?php echo ($_GET['tabindex']); ?>&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>&regionid="+rgn_atpid;
		window.open (url,'实时曲线','height=800,width=1000,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
//		window.open(url,'实时曲线','fullscreen=0,directories=1,location=1,menubar=1,resizable=1,scrollbars=1,status=1,titlebar=1,toolbar=1');
	}

	function ATP_FRAME_SECOND_ENTER_CALLBACK()
	{
		$('#atpbiztable').bootstrapTable('refresh');
	}
	// 高级搜索
	$("#sys_search").on('click',function() {
//		ATP_BOX_SEARCHOPEN
		window.parent.ATP_BOX_SEARCHOPEN("/szny/index.php/Admin/RgDev/advancedsearch?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=<?php echo ($_GET['tabindex']); ?>&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>&rgn_name=" + $(".input-outline").val(), submitsearchdata, 'rgn_name', $(".input-outline").val());
    });
    function submitsearchdata(){
		window.parent.ATP_BOX_SEARCHCLOSE();
		if(null!=$('#rgn_name',parent.document).val()){
			$('#atpbiztable').bootstrapTable('resetSearch',$('#rgn_name',parent.document).val());
		}
        $('#atpbiztable').bootstrapTable('refresh');
    }
</script>
</body>
</html>