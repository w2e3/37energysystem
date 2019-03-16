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
        /*.wrapper-content {*/
        /*padding: 0px;*/
        /*}*/
        /*.wrapper {*/
        /*padding: 0px;*/
        /*}*/

        .table
        {
            max-width: none;;
        }
        /*.main-left{width: 20%;float: left;background-color: #fff}*/
        /*.main-right{width: 79%;float: left; margin-left:1%}*/

        .main-left{width: 200px;float: left;background-color: #fff;overflow-y:scroll;}
        .main-right{ margin-left:215px;overflow: hidden;}

        .fixed-table-container tbody .selected td {
            background-color: yellow;
        }

        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
            background-color: yellow;
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
    <div class="ibox float-e-margins">
        <div class="ibox-content" style="padding: 10px 10px 10px 10px;margin-bottom: -15px;">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <i class="fa fa-hand-o-right"></i>&nbsp;当前位置:【数据管理】/【原始数据管理】
                </div>
            </div>
        </div>
    </div>
    <div class="ibox float-e-margins">
        <div class="main-left">
            <div class="content_wrap" style="width: 100%;max-height: 700px;">

                <!--<div style="margin-top: 4px;width: 99%">-->
                    <!--<input type="text" id="treesearchcontent" placeholder="请输入筛选内容" >-->
                    <!--<input type="button" id="treesearch" value="搜索" >-->
                <!--</div>-->
                <ul id="treeDemo" class="ztree"></ul>
            </div>
        </div>

        <div class="main-right">
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <iframe id="contentframe" src="/szny/index.php/Admin/Originaldata/tableindex"  frameborder="no" width="100%" scrolling="yes" height="700px" ></iframe>
                    </div>
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
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/szny/Public/vendor/zTree_v3/js/jquery.ztree.excheck.js"></script>
<script src="/szny/Public/vendor/html5Validate/src/jquery-html5Validate.js"></script>
<script>
    GLOBAL_SEARCHNAME = "按名称列搜索（支持自定义）";
    var setting = {
        view:{
            selectedMulti:false
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pid",
                rootPId: 0
            }
        },
        callback: {
            beforeClick: function (treeId, treeNode, clickFlag) {

            },
            onClick: function (event, treeId, treeNode) {

                if ('设备点' == treeNode.type) {
                    RGN_ATPID = treeNode.id;
                    $('#contentframe').attr('src',"/szny/index.php/Admin/Originaldata/tableindex?regionid=" + RGN_ATPID);
                   // $('#atpbiztable').bootstrapTable('refresh');
                }
            }
        }
    };
    var zNodes =<?php echo ($treedatas); ?>;
    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        zTree.expandAll(true);
    });

    $(function () {
        $('#treesearchcontent').bind("keypress",function(){
            if(event.keyCode == '13')
            {
//                alert('回车事件');
            }
        });
//        $('#treesearch').on("click",function(){alert('树搜索事件');});
    });

    ATP_BOX_OPEN = function(url,childcallback) {
        $("#sys_dlg").load(url, function() {
            $('#sys_dlg_submit').on('click', childcallback);
            $("#sys_dlg").modal({backdrop: false});
        });
    }
    ATP_BOX_CLOSE = function() {
        $('#sys_dlg').modal('hide');
    }
    ATP_BOX_VALIDATE = function() {
        if ($.html5Validate.isAllpass($("#sys_dlg_form"))) {
            return true;
        }
        else {
            return false;
        }
    }
</script>
</body>

</html>