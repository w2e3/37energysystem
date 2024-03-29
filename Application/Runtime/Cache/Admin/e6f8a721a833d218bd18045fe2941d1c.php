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

    <script src="/szny/Public/vendor/bootstrap-table/jquery.min.js"></script>
    <script src="/szny/Public/vendor/bootstrap-table/bootstrap/js/bootstrap.min.js"></script>
    <script src="/szny/Public/vendor/My97DatePicker/WdatePicker.js"></script>
    <script src="/szny/Public/adminframework/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/szny/Public/adminframework/js/plugins/chosen/chosen.order.jquery.js"></script>
    <script src="/szny/Public/vendor/chosen-ajax-addition/chosen.ajaxaddition.jquery.js"></script>

    <script src="/szny/Public/adminframework/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
    <script src="/szny/Public/adminframework/js/plugins/switchery/switchery.js"></script>
    <script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.js"></script>
    <!--<script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/locale/bootstrap-table-zh-CN.js"></script>-->
    <script src="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/locale/bootstrap-table-zh-CN-atp.js"></script>
    <script src="/szny/Public/vendor/html5Validate/src/jquery-html5Validate.js"></script>
    <base target="_blank">
    <style>
        .table
        {
            max-width: none;;
        }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
         <div class="ibox-content" style="padding: 10px 10px 10px 10px;margin-bottom: -15px;">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <i class="fa fa-hand-o-right"></i>&nbsp;当前位置:【<?php echo ($page); ?>管理】/【<?php echo ($page); ?>能源】
                </div>
            </div>
         </div>
    </div>
    <div class="ibox-content">
        <div class="row row-lg">
            <div class="col-sm-12">
                <div id="atpbiztoolbar">
                    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_form_no" role="form" class="form-horizontal">
                        <input  id="us_start" type="hidden" class="form-control" value="<?php echo ($start); ?>"  style="width: 120px; display:inline-block;">
                        <input id="us_end" type="hidden" class="form-control"  value="<?php echo ($end); ?>" style="width: 120px; display:inline-block;">
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            查询范围：
                            <?php if(('' == $start)): echo ($lyear); ?>年&nbsp;-&nbsp;<?php echo ($tyear); ?>年&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php else: ?>
                                <?php echo ($start); ?>&nbsp;-<?php echo ($end); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
                        </label>
                        <button class="btn btn-success " type="button" id="btn_configyear">&nbsp;年时间范围选择</button>
                        <button class="btn btn-success " type="button" id="btn_configyue">&nbsp;月时间范围选择</button>
                        <button class="btn btn-success " type="button" id="btn_configday">&nbsp;日时间范围选择</button>
                    </form>
                </div>
                <table id="atpbiztable"></table>
            </div>
        </div>
    </div>
</div>
<div id="sys_dlg" role="dialog" class="modal fade "></div>

<div id="sys_dlg_search_year" role="dialog" class="modal fade ">
    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_year_form" role="form" class="form-horizontal">
        <div class="modal-dialog" style="width: 1000px;z-index: 10;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">日期选择</h4>
                </div>
                <div class="modal-body">
                    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_form_year" role="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>开始时间：</label>
                            <div class="col-sm-4">
                                <input id="year_start" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy'})" required>
                            </div>
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>结束时间：</label>
                            <div class="col-sm-4">
                                <input id="year_end" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy'})" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
                    <button type="button" id="sys_dlg_search_submit_year" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal-backdrop fade in" style="z-index: -101;"></div>
</div>
<div id="sys_dlg_search_month" role="dialog" class="modal fade ">
    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_month_form" role="form" class="form-horizontal">
         <div class="modal-dialog" style="width: 1000px;z-index: 10;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">日期选择</h4>
                </div>
                <div class="modal-body">
                    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_form_month" role="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>开始时间 ：</label>
                            <div class="col-sm-4">
                                <input id="month_start" value="" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy-MM'})" required>
                            </div>
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>结束时间：</label>
                            <div class="col-sm-4">
                                <input id="month_end" value="" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy-MM'})" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
                    <button type="button" id="sys_dlg_search_submit_month" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal-backdrop fade in" style="z-index: -101;"></div>
</div>
<div id="sys_dlg_search_day" role="dialog" class="modal fade ">
    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_day_form" role="form" class="form-horizontal">
        <div class="modal-dialog" style="width: 1000px;z-index: 10;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">日期选择</h4>
                </div>
                <div class="modal-body">
                    <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_search_form_day" role="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>开始时间 ：</label>
                            <div class="col-sm-4">
                                <input id="day_start" value="" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" required>
                            </div>
                            <label class="col-sm-2 control-label"><span style="color: red">*</span>结束时间：</label>
                            <div class="col-sm-4">
                                <input id="day_end" value="" type="text" class="form-control" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
                    <button type="button" id="sys_dlg_search_submit_day" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal-backdrop fade in" style="z-index: -101;"></div>
</div>
<script>
    GLOBAL_SEARCHNAME = "姓名";
    $(function () {
        $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true, width:'150px'});
        $('#atpbiztable').bootstrapTable({
            url: '/szny/index.php/Admin/Usersidenergy/getData?start=<?php echo ($start); ?>&end=<?php echo ($end); ?>&bs=<?php echo ($bs); ?>',         //请求后台的URL（*）
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
//            search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
//            strictSearch: true,
//            showColumns: true,                  //是否显示所有的列
//            showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: false,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "us_atpid",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            detailFormatter: "detailFormatter",
            height:510,
            columns: [
                [
                    // {checkbox: true},
                    {title: '序号', width: 40,align:'center',
                        formatter: function (value, row, index)
                        {
                            var option =  $('#atpbiztable').bootstrapTable("getOptions");
                            return option.pageSize * (option.pageNumber - 1) + index + 1;
                        }
                    },

                    {field: 'us_name', title: '姓名', align:'center', valign:'middle',sortable: true},
                    // {field: 'us_status', title: '状态', align:'center', valign:'middle',sortable: true},
                    {field: 'time', title: '时间段', align:'center', valign:'middle',sortable: true},
                    {field: 'ysl', title: '水能', align:'center', valign:'middle',sortable: true},
                    {field: 'dgl', title: '电能', align:'center', valign:'middle',sortable: true},
                    {field: 'ynl', title: '用暖能', align:'center', valign:'middle',sortable: true},
                    {field: 'yll', title: '用冷能', align:'center', valign:'middle',sortable: true},
                    ////////////////////////////////////////////////////////////////////////////////////////////////
                    {field:'us_atpid',title:'主键',visible:false},
                    {field:'us_atpcreatedatetime',title:'创建时间',visible:false},
                    {field:'us_atpcreateuser',title:'创建人',visible:false},
                    {field:'us_atplastmodifydatetime',title:'最后修改时间',visible:false},
                    {field:'us_atplastmodifyuser',title:'最后修改人',visible:false},
                    {field:'us_atpstatus',title:'数据状态',visible:false},
                    {field:'us_atpsort',title:'数据排序',visible:false},
                    {field:'us_atpremark',title:'数据备注',visible:false},

                ]
            ],
            onDblClickRow: function (row) {
//                $("#sys_dlg").load('/szny/index.php/Admin/Usersidenergy/edit?id=' + row['us_atpid'], function() {
//                    $('#sys_dlg_submit').on('click',submitdata);
//                    $("#sys_dlg").modal({backdrop: false});
//                });
            },
            onSort: function (name, order) {
//                console.log(name+order);
            },
        });
    });

    function queryParams(params) {  //配置参数
        var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
            limit: params.limit,   //页面大小
            offset: params.offset,  //页码
            search: params.search,
            sort: params.sort,  //排序列名
            sortOrder: params.order//排位命令（desc，asc）
        };
        return temp;
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#btn_configyear').on('click',function() {
        $("#sys_dlg_search_year").modal({backdrop: false});
        $('#sys_dlg_search_year').on('shown.bs.modal', function () {
            $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true});
        });
        $('#sys_dlg_search_submit_year').on('click', function () {
            if ($.html5Validate.isAllpass($("#sys_dlg_search_year_form"))) {
                $('#sys_dlg').modal('hide');
                var start = $('#year_start').val();
                var end = $('#year_end').val();
                window.location.href='/szny/index.php/Admin/Usersidenergy/index?start='+start + '&end='+end + '&bs=<?php echo ($bs); ?>';
            }
        });
    });
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#btn_configyue').on('click',function() {
        $("#sys_dlg_search_month").modal({backdrop: false});
        $('#sys_dlg_search_month').on('shown.bs.modal', function () {
            $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true});
        });
        $('#sys_dlg_search_submit_month').on('click', function () {
            if ($.html5Validate.isAllpass($("#sys_dlg_search_month_form"))) {
                $('#sys_dlg').modal('hide');
                var start = $('#month_start').val();
                var end = $('#month_end').val();
                window.location.href='/szny/index.php/Admin/Usersidenergy/index?start='+start + '&end='+end + '&bs=<?php echo ($bs); ?>';
            }
        });
    });
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#btn_configday').on('click',function() {
        $("#sys_dlg_search_day").modal({backdrop: false});
        $('#sys_dlg_search_day').on('shown.bs.modal', function () {
            $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true});
        });
        $('#sys_dlg_search_submit_day').on('click', function () {
            if ($.html5Validate.isAllpass($("#sys_dlg_search_day_form"))) {
                $('#sys_dlg').modal('hide');
                var start = $('#day_start').val();
                var end = $('#day_end').val();
                window.location.href='/szny/index.php/Admin/Usersidenergy/index?start='+start + '&end='+end + '&bs=<?php echo ($bs); ?>';
            }
        });
    });
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    function ATP_FRAME_SECOND_ENTER_CALLBACK()
    {
        $('#atpbiztable').bootstrapTable('refresh');
    }
</script>
</body>
</html>