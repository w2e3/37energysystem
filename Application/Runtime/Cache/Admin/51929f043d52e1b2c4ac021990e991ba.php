<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="/szny/Public/vendor/bootstrap-table/bootstrap/css/bootstrap.css" rel="stylesheet" >
    <link href="/szny/Public/adminframework/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" >
    <link href="/szny/Public/adminframework/css/animate.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/style.css?v=4.0.0" rel="stylesheet">
    <link rel="stylesheet" href="/szny/Public/vendor/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <base target="_blank">
    <style>
        .table
        {
            max-width: none;
        }

        .main-left{width: 200px;float: left;background-color: #fff;overflow-y:scroll;}
        .main-right{ margin-left:215px;overflow: hidden;}

        .fixed-table-container tbody .selected td {
            /*background-color: yellow;*/
        }

        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
            /*background-color: yellow;*/
        }

        .bootstrap-table .table:not(.table-condensed),
        .bootstrap-table .table:not(.table-condensed) > tbody > tr > th,
        .bootstrap-table .table:not(.table-condensed) > tfoot > tr > th,
        .bootstrap-table .table:not(.table-condensed) > thead > tr > td,
        .bootstrap-table .table:not(.table-condensed) > tbody > tr > td,
        .bootstrap-table .table:not(.table-condensed) > tfoot > tr > td {
            padding: 4px 8px 4px 8px;
        }


        .fixed-table-container thead th .th-inner,
        .fixed-table-container tbody td .th-inner {
            padding: 4px 8px 4px 8px;
            line-height: 24px;
            vertical-align: top;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .fixed-table-container .bs-checkbox .th-inner {
            padding: 8px 0;
        }
        #treesearchcontent{width: 130px;float: left;;margin-left: 10px;}
        #treesearch{width: 50px;border:0;height: 25.5px;background-color: #009688;line-height: 24px;color: #fff}

    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <!--<div class="ibox float-e-margins">-->
        <!--<div class="ibox-content" style="padding: 10px 10px 10px 10px;margin-bottom: -15px;">-->
            <!--<div class="row row-lg">-->
                <!--<div class="col-sm-12">-->
                    <!--<i class="fa fa-hand-o-right"></i>&nbsp;当前位置:<?php echo ($ATPLocationName); ?>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <div class="ibox float-e-margins">
        <div class="main-left">
            <div class="content_wrap" style="width: 100%;max-height: 700px;">
                <ul id="regionTree" class="ztree"></ul>
            </div>
        </div>
        <div class="main-right">
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <?php if($_GET['regiontype']== 'rg'): ?><iframe id="contentframe" src="/szny/index.php/Admin/RgGeneral/indexregionroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=regionroot&tabindex=0&rgn_atpid=<?php echo ($rgn_atpid); ?>"  frameborder="no" width="100%" scrolling="yes" height="1400px" ></iframe>
                        <?php else: ?>
                            <iframe id="contentframe" src="/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=region&tabindex=0&rgn_atpid=<?php echo ($rgn_atpid); ?>"  frameborder="no" width="100%" scrolling="yes" height="1400px" ></iframe><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="sys_dlg" role="dialog" class="modal fade "></div>
<div id="sys_searchdlg" role="dialog" class="modal fade "></div>

<script src="/szny/Public/vendor/bootstrap-table/jquery.min.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap/js/bootstrap.min.js"></script>
<script src="/szny/Public/vendor/My97DatePicker/WdatePicker.js"></script>
<script src="/szny/Public/adminframework/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/szny/Public/adminframework/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<script src="/szny/Public/adminframework/js/plugins/switchery/switchery.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.js"></script>
<script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/locale/bootstrap-table-zh-CN-atp.js"></script>
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.excheck.js"></script>
<script src="/szny/Public/vendor/html5Validate/src/jquery-html5Validate.js"></script>
<script src="/szny/Public/vendor/diy_component/func_scrolltab/atppagetab.js"></script>
<script src="/szny/Public/js/atptab.js"></script>

<SCRIPT type="text/javascript">
    RGN_ATPID="";
    rootnode=null;
    var setting = { 
        view: {
            nameIsHTML:true,
            dblClickExpand: false
        },
        data: {
            key:{
                key: "t"
            },
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pid",
                rootPId: null
            }
        },
        callback: {
            onClick: onClick
        }
    };
    var zNodes = <?php echo ($treedatas); ?>;
    var curExpandNode = null;
    function onClick(e,treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("regionTree");
        zTree.expandNode(treeNode, null, null, null, true);
        RGN_ATPID = treeNode.id;
        if ('园区根' == treeNode.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexregionroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=regionroot&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
        if ('园区' == treeNode.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=region&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
        if ('设备点' == treeNode.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexdevicepoint?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=devicepoint&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
    }
    $(document).ready(function(){
        $.fn.zTree.init($("#regionTree"), setting, zNodes);
        RGN_ATPID = "<?php echo ($rgn_atpid); ?>";
        zTree = $.fn.zTree.getZTreeObj("regionTree");
        rootnode = zTree.getNodeByParam("id","<?php echo ($rgn_atpid); ?>");
        zTree.selectNode(rootnode);
    });
</SCRIPT>
<script>
    $(document).ready(function(){
        $(".js-switch").each(function(){
            new Switchery(this, {color: '#1AB394'});
        });
        $(".file-pretty").prettyFile();
        $(".chosen-select").chosen({disable_search_threshold: 6, search_contains: true,width:'284px'});
    });


   // 联动左树右页,报警
   ATP_REGIONJUMbj = function (rgn_atpid) {
       var node = zTree.getNodeByParam("id", RGN_ATPID);
       var regionlevel = "";
       if ('园区根' == node.type) {
           regionlevel = "regionroot";
       }
       if ('园区' == node.type) {
           regionlevel = "region";
       }
       if ('设备点' == node.type) {
           regionlevel = "devicepoint";
       }
       $('#contentframe').attr('src', "/szny/index.php/Admin/RgAlarmConfirm?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=" + regionlevel + "&tabindex=2&rgn_atpid=" + RGN_ATPID + "&rgn_atpidcurrent=" + rgn_atpid);
       document.body.scrollTop = document.documentElement.scrollTop = 0;
   };

    ATP_REGIONJUMZH = function (devicepoint_rgn_atpid) {
        var node = zTree.getNodeByParam("id", RGN_ATPID);
        var regionlevel = "";
        if(null!=devicepoint_rgn_atpid) {
            var tregionlevel = "";
            if ('园区根' == node.type) {
                tregionlevel = "regionroot";
            }
            if ('园区' == node.type) {
                tregionlevel = "region";
            }
            if ('设备点' == node.type) {
                tregionlevel = "devicepoint";
            }
            $('#contentframe').attr('src', "/szny/index.php/Admin/RgGeneral/indexdevicepoint?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=" + tregionlevel + "&tabindex=0&rgn_atpid=" + devicepoint_rgn_atpid);
            return;
        }
        if ('园区根' == node.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexregionroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=regionroot&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
        if ('园区' == node.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=region&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
        if ('设备点' == node.type) {
            $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexdevicepoint?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=devicepoint&tabindex=0&rgn_atpid=" + RGN_ATPID);
        }
    };



//    联动左树右页
   ATP_REGIONJUMP = function (region_id) {
       var treeObj = $.fn.zTree.getZTreeObj("regionTree");
       var node = treeObj.getNodeByParam("id", region_id);
       treeObj.selectNode(node);
       $('#contentframe').attr('src',"/szny/index.php/Admin/RgGeneral/indexregion?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=region&tabindex=0&rgn_atpid=" + region_id);
   };

    function ATP_FRAME_SECOND_ENTER_CALLBACK() {

    }

</script>
</body>
</html>