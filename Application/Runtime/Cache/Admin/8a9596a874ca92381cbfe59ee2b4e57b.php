<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>中关村集成电路设计园能源管理系统</title>
    <meta name="keywords" content="中关村集成电路设计园能源管理系统">
    <meta name="description" content="中关村集成电路设计园能源管理系统">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <!--<link rel="shortcut icon" href="favicon.ico">-->
    <link href="/szny/Public/adminframework/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/szny/Public/vendor/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/animate.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/style_atp.css?v=4.0.0" rel="stylesheet">
    <style>
        #content-main {
            height: calc(100% - 100px);
            overflow: hidden;
        }
    </style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navig                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           tion">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <!--<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                           &lt;!&ndash;<span class="block m-t-xs"><strong class="font-bold username"></strong></span>
                            <span class="text-muted text-xs block">管理员<b class="caret"></b></span>
                            </span>&ndash;&gt;
                        </a>-->
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <!--<li><a class="J_menuItem" href="form_avatar.html">修改密码</a></li>-->
                            <li><a href="login.html" target="_self">安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">IC<br>PARK
                    </div>
                </li>
                <?php if(in_array('010-园区概览',$ds_module)){ ?>

                    <li>
                        <a class="J_menuItem" href="/szny/index.php/Admin/Parkoverview/index">
                            <i class="fa fa-institution"></i>
                            <span class="nav-label">园区概览</span>
                        </a>
                        <ul class="nav nav-second-level">
                        </ul>
                    </li>


                <?php } ?>
                <?php if(in_array('020-园区漫游',$ds_module)){ ?>


                    <li>
                        <a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=rg">
                            <i class="fa fa-institution"></i>
                            <span class="nav-label">园区漫游</span>
                        </a>
                        <ul class="nav nav-second-level">
                        </ul>
                    </li>


                <?php } ?>
                <?php if(in_array('040-专项能源',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-microchip"></i>
                        <span class="nav-label">专项能源</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('041-制冷机房',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=zljf">制冷机房</a></li>
                        <?php } ?>
                        <?php if(in_array('042-配电室',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=pds">配电室</a></li>
                        <?php } ?>
                        <!-- <?php if(in_array('043-充电桩',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=cdz">充电桩</a></li>
                        <?php } ?> -->
                        <?php if(in_array('044-锅炉房',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=glf">锅炉房</a></li>
                        <?php } ?>
                        <!-- <?php if(in_array('045-图书馆',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=tsg">图书馆</a></li>
                        <?php } ?>
                        <?php if(in_array('046-邮局',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=yj">邮局</a></li>
                        <?php } ?>
                        <?php if(in_array('047-文化活动中心',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/index?regiontype=sn&snname=whhdzj">文化活动中心</a></li>
                        <?php } ?> -->
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('030-数据对比',$ds_module)){ ?>
                <li>
                    <a class="J_menuItem" href="/szny/index.php/Admin/Datacontrast/index">
                        <i class="fa fa-exchange"></i>
                        <span class="nav-label">数据对比</span>
                    </a>
					<ul class="nav nav-second-level">
                    </ul>
                </li>
                <?php } ?>
                
                <?php if(in_array('050-预警中心',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-microchip"></i>
                        <span class="nav-label">预警中心</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('051-报警中心',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/indexshell?controller=RgAlarmHistory&title=报警中心">报警中心</a></li>
                        <?php } ?>
                        <?php if(in_array('052-报警配置',$ds_module)){ ?>
                        <!-- <li><a class="J_menuItem" href="/szny/index.php/Admin/Alarmconfiguration/index">报警配置</a></li> -->
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Alarmconfig/index">报警配置</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('090-审批中心',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-pencil-square-o"></i>
                        <span class="nav-label">审批中心</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('091-延期维修看板',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/indexshell?controller=RgRepairDelay&title=延期维修看板">延期维修看板</a></li>
                        <?php } ?>
                        <?php if(in_array('092-维修单接单',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/indexshell?controller=RgRepairDist&title=维修单接单">维修单接单</a></li>
                        <?php } ?>
                        <?php if(in_array('093-维修单处理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/indexshell?controller=RgRepairProcess&title=维修单处理">维修单处理</a></li>
                        <?php } ?>
                        <?php if(in_array('094-全部维修单',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Rg/indexshell?controller=RgRepairHistory&title=全部维修单">全部维修单</a></li>
                        <?php } ?>
                        <?php if(in_array('095-数据修改审批',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Twicedatasp/index">数据修改单审批</a></li>
                        <?php } ?>
                        <?php if(in_array('096-数据修改浏览',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/TwicedataHistory/index">全部数据修改单</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('100-设备管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-wrench"></i>
                        <span class="nav-label">设备管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('101-园区设备',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Deviceregion/index">关联园区设备</a></li>
                        <?php } ?>
                        <?php if(in_array('102-设备卡片',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Device/index">设备卡片管理</a></li>
                        <?php } ?>
                        <?php if(in_array('103-设备参数',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Devicemodelparam/index">设备参数</a></li>
                        <?php } ?>
                        <?php if(in_array('104-参数配置',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Parammap/index">参数配置</a></li>
                        <?php } ?>
                        <!-- <li><a class="J_menuItem" href="/szny/index.php/Admin/Alarmconfig/index">报警配置</a></li> -->
                        <?php if(in_array('105-厂家设备',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Devicemodel/index">厂家设备</a></li>
                        <?php } ?>
                        <?php if(in_array('106-厂家管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Company/index">厂家管理</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('060-租户管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-user-circle"></i>
                        <span class="nav-label">租户管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('061-租户管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Userside/index?bs=zh">租户管理</a></li>
                        <?php } ?>
                        <?php if(in_array('062-租户能源',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Usersidenergy/index?bs=zh">租户能源</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('070-业主管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-address-book"></i>
                        <span class="nav-label">业主管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('071-业主管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Userside/index?bs=yz">业主管理</a></li>
                        <?php } ?>
                        <?php if(in_array('072-业主能源',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Usersidenergy/index?bs=yz">业主能源</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('080-数据管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span class="nav-label">数据管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('081-二次数据管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Twicedata/index">二次数据管理</a></li>
                        <?php } ?>
                        <?php if(in_array('082-原始数据管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Originaldata/index">原始数据管理</a></li>
                        <?php } ?>
                        <!--<li><a class="J_menuItem" href="/szny/index.php/Admin/Energyreport/index">能源报表</a></li>-->
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('110-库存管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-shopping-bag"></i>
                        <span class="nav-label">备件管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('111-备件管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Part/index">备件管理</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('120-用户权限管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-user-circle-o"></i>
                        <span class="nav-label">用户权限管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('121-用户管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Emp/index">用户管理</a></li>
                        <?php } ?>
                        <?php if(in_array('122-角色管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Role/index">角色管理</a></li>
                        <?php } ?>
                        <?php if(in_array('123-模块管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Module/index">模块管理</a></li>
                        <?php } ?>
                        <?php if(in_array('124-部门管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Department/index">部门管理</a></li>
                        <?php } ?>
                        <!--<?php if(in_array('125-管辖设备',$ds_module)){ ?>-->
                        <!--<li><a class="J_menuItem" href="/szny/index.php/Admin/Roledevicemodule/index">管辖设备</a></li>-->
                        <!--<?php } ?>-->
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('130-基础数据管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-database"></i>
                        <span class="nav-label">基础数据管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('131-园区管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Region/index">园区管理</a></li>
                        <?php } ?>
                        <!--<?php if(in_array('132-能源类别',$ds_module)){ ?>-->
                        <!--<li><a class="J_menuItem" href="/szny/index.php/Admin/Regiongraphic/index">011平面图管理</a></li>-->
                        <!--<li><a class="J_menuItem" href="/szny/index.php/Admin/Energytype/index">能源类别</a></li>-->
                        <!--<?php } ?>-->
                        <?php if(in_array('133-统计参数',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Param/index">统计参数</a></li>
                        <?php } ?>
                        <?php if(in_array('134-参数配置',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Parammap/index">参数配置</a></li>
                        <?php } ?>
                        <?php if(in_array('135-字典管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Config/index">字典浏览</a></li>
                        <?php } ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Config/sdindex?type=sd">配置水电单价</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('140-系统管理',$ds_module)){ ?>
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <span class="nav-label">系统管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('141-日志管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Log/index">日志管理</a></li>
                        <?php } ?>
                        <?php if(in_array('143-定时任务日志',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Tasklog/index">定时任务日志</a></li>
                        <?php } ?>
                        <?php if(in_array('144-数据库管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Database/index">数据库管理</a></li>
                        <?php } ?>
                        <?php if(in_array('145-采集设备管理',$ds_module)){ ?>
                        <!--<li><a class="J_menuItem" href="/szny/index.php/Admin/Server/index">150-服务器管理</a></li>-->
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Plc/index">采集设备管理</a></li>
                        <?php } ?>
                        <?php if(in_array('146-采集软件管理',$ds_module)){ ?>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Revdata/index">采集软件管理</a></li>
                        <li><a class="J_menuItem" href="/szny/index.php/Admin/Revdatamsg/index">采集软件命令历史</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div id="qh" class="navbar-header gq" >
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <img src="/szny/Public/img/banner.png" width="470" height="40" style="margin-top: 10px;margin-left: 8px;">
                </div>
                <ul class="nav navbar-top-links navbar-right">

                    <!--<li class="dropdown">-->
                        <!--<a  class="J_menuItem dropdown-toggle count-info" data-toggle="dropdown" href="/szny/index.php/Admin/Frame/processview">-->
                            <!--<i class="fa fa-bell"></i> <span class="label label-primary">进度</span>-->
                        <!--</a>-->
                    <!--</li>-->
                    <li class="dropdown hidden-xs">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="line-height: 10px;">
                                    <span class="clear">
                                   <span class="block m-t-xs"><strong class="font-bold username"></strong></span>
                                    <span class="text-muted text-xs block"><?php echo (session('emp_account')); ?>(<?php echo (session('emp_role')); ?>)<b class="caret"></b></span>
                                    </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="J_menuItem" href="/szny/index.php/Admin/Changepassword">修改密码</a></li>
                            <li><a class="" href="/szny/index.php/Admin/Login" target="_SELF">登出</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row J_mainContent" id="content-main">
            <?php if(in_array('010-园区概览',$ds_module)){ ?>
            
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/szny/index.php/Admin/Parkoverview/index/" frameborder="0" data-id="/szny/index.php/Admin/Frame/Welcome" seamless></iframe>

            <?php }else{ ?>
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/szny/index.php/Admin/Frame/welcome" frameborder="0" data-id="/szny/index.php/Admin/Frame/Welcome" seamless></iframe>
            <?php } ?>
        </div>
        <div class="footer">
            <div class="pull-right">
                &copy; 2017-2018
                <a href="javascript:" target="">中关村集成电路设计园能源管理系统</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->

    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">
        </div>
    </div>
    <!--右侧边栏结束-->
</div>

<!-- 全局js -->
<script src="/szny/Public/adminframework/js/jquery.min.js?v=2.1.4"></script>
<script src="/szny/Public/adminframework/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/szny/Public/adminframework/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/szny/Public/adminframework/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/szny/Public/adminframework/js/plugins/layer/layer.min.js"></script>

<!-- 自定义js -->
<script src="/szny/Public/adminframework/js/hplus_atp.js?v=4.0.0"></script>
<script type="text/javascript" src="/szny/Public/adminframework/js/contabs.js"></script>

<!-- 第三方插件 -->
<!--<script src="/szny/Public/adminframework/js/plugins/pace/pace.min.js"></script>-->
<script>
$('.J_menuItem').on('click',function() {
    $(this).css('color','#fff').parent('li').siblings('li').children('.J_menuItem').css('color','#a7b1c2')
})
 // 联动左树右页
    ATP_REGIONJUMPbj = function (rgn_atpid) {
        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
        var node = treeObj.getNodeByParam("id", rgn_atpid);
        treeObj.selectNode(node);
        $('#contentframe').attr('src',"/szny/index.php/Admin/RgAlarmConfirm/index?rgn_atpid="+rgn_atpid);
    };
    // 联动左树右页
    ATP_REGIONJUMP = function (region_id) {
        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
        var node = treeObj.getNodeByParam("id", region_id);
        treeObj.selectNode(node);
        $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/index2?rgn_atpid=" + region_id);
    };
</script>
</body>
</html>