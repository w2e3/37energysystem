<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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
            max-width: none;
        }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-content" style="padding: 10px 10px 10px 10px;margin-bottom: -15px;">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <i class="fa fa-hand-o-right"></i>&nbsp;当前位置:【用户权限管理】/【用户管理】
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row row-lg">
            <div class="col-sm-12">
                <div id="atpbiztoolbar">
                    <button class="btn btn-info " type="button" id="sys_add"><i class="fa fa-pencil"></i>&nbsp;添加</button>
                    <!--<button class="btn btn-info " type="button" id="sys_update"><i class="fa fa-pencil-square"></i>&nbsp;编辑</button>-->
                    <!-- <button class="btn btn-danger " type="button" id="sys_del"><i class="fa fa-eraser"></i>&nbsp;批量删除</button> -->
                    <button class="btn btn-warning" type="button" id="sys_renew_password"><i class="fa fa-key"></i>&nbsp;密码修改</button>
                </div>
                <table id="atpbiztable" style="width: 2000px"></table>

            </div>
        </div>
    </div>
</div>
<div id="sys_dlg" role="dialog" class="modal fade "></div>


<script>
    GLOBAL_SEARCHNAME = "用户名称";
    $(function () {
        $('#atpbiztable').bootstrapTable({
            url: '/szny/index.php/Admin/Emp/getData',         //请求后台的URL（*）
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
            uniqueId: "emp_atpid",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            detailFormatter: "detailFormatter",
            height:510,
            columns: [
                [
                    {checkbox: true},
                    {title: '序号', width: 40,align:'center',
                        formatter: function (value, row, index)
                        {
                            var option =  $('#atpbiztable').bootstrapTable("getOptions");
                            return option.pageSize * (option.pageNumber - 1) + index + 1;
                        }
                    },
                    {field: 'emp_account', title: '账号', align:'center', valign:'middle',sortable: true},
//                    {field: 'emp_password', title: '密码',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_name', title: '姓名',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_codename', title: '员工编号',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_category', title: '类型',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_sex', title: '性别',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_mainphone', title: '主电话',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_duty', title: '职务',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_role', title: '角色',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_department', title: '部门',align:'center', valign:'middle', sortable: true},
                    {field: 'emp_indatetime', title: '入职时间',align:'center',width:150, valign:'middle', sortable: true},
                    {field: 'emp_outdatetime', title: '离职时间',align:'center',width:150, valign:'middle', sortable: true},
                    {field: 'emp_changedatetime', title: '变更时间',align:'center',width:150, valign:'middle', sortable: true},
                    {field: 'emp_remark', title: '备注',align:'center', valign:'middle', sortable: true},

                    {field:'emp_atpid',title:'主键',visible:false},
                    {field:'emp_atpcreatedatetime',title:'创建时间',visible:false},
                    {field:'emp_atpcreateuser',title:'创建人',visible:false},
                    {field:'emp_atplastmodifydatetime',title:'最后修改时间',visible:false},
                    {field:'emp_atplastmodifyuser',title:'最后修改人',visible:false},
                    {field:'emp_atpstatus',title:'数据状态',visible:false},
                    {field:'emp_atpsort',title:'数据排序',visible:false},
                    {field:'emp_atpremark',title:'数据备注',visible:false},
                    {field: 'emp_atpid', title: '操作',align:'center', sortable: false,width:100,
                        formatter: function (value, row, index) {
                            var inp = "'"+  value +"'";
                            var a = '<a  class="btn btn-info btn-xs" onclick="updateInRow('+ inp +')">编辑</a>&nbsp;';
                            a += '<a  class="btn btn-danger btn-xs" onclick="delInRow('+ inp +')">删除</a>';
                            return a;
                        }
                    },
                ]
            ],
            onDblClickRow: function (row) {
                $("#sys_dlg").load('/szny/index.php/Admin/Emp/edit?id=' + row['emp_atpid'], function() {
                    $('#sys_dlg_submit').on('click',submitdata);
                    $("#sys_dlg").modal({backdrop: false});
                });
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
            u_name: $("#search_u_name").val(),
            u_type: $("#search_u_type").val(),
            sort: params.sort,  //排序列名
            sortOrder: params.order//排位命令（desc，asc）
        };
        return temp;
    }

    $('#sys_search').on('click',function() {
        $("#sys_dlg_search").modal({backdrop: false});
        $('#sys_dlg_search').on('shown.bs.modal', function () {
            $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true});
        });
        $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true});
        $('#sys_dlg_search_submit').on('click', function () {
            $('#atpbiztable').bootstrapTable('refresh')
        });
    });
    $('#sys_add').on('click',function(){
        $("#sys_dlg").load('/szny/index.php/Admin/Emp/add', function() {
            $('#sys_dlg_submit').on('click', submitdata);
            $("#sys_dlg").modal({backdrop: false});
        });
    });
    function submitdata()
    {
        if ($.html5Validate.isAllpass($("#sys_dlg_form"))) {
            $('#sys_dlg').modal('hide');
            $("#sys_dlg_form").submit(function(e)
            {
                var formObj = $(this);
                var formURL = formObj.attr("action");
                var formData = new FormData(this);
                $.ajax({
                    url: '/szny/index.php/Admin/Emp/submit',
                    type: 'POST',
                    data:  formData,
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data, textStatus, jqXHR)
                    {
                        if(data=='1'){
                            alert("账号或员工编号已存在，禁止重复添加");
                        }
                        $('#atpbiztable').bootstrapTable('refresh')
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        $('#atpbiztable').bootstrapTable('refresh')
                    }
                });
                e.preventDefault();
            });
            $("#sys_dlg_form").submit();
        }
    }
    $('#sys_renew_password').on('click',function(){
        var tablerow = $('#atpbiztable').bootstrapTable('getSelections');
        if(tablerow.length!=1)
        {
            alert("您已多选或者少选，仅能对一条数据进行操作");
        }
        else {
            $("#sys_dlg").load('/szny/index.php/Admin/Emp/renewPassword?id=' + tablerow[0]['emp_atpid'], function() {
                $("#sys_dlg").modal({backdrop: false});
            });
        }
    });

    $('#sys_update').on('click',function() {
        var tablerow = $('#atpbiztable').bootstrapTable('getSelections');
        if(tablerow.length!=1)
        {
            alert("您已多选或者少选，仅能对一条数据进行操作");
        }
        else {
            $("#sys_dlg").load('/szny/index.php/Admin/Emp/edit?id=' + tablerow[0]['emp_atpid'], function() {
                $('#sys_dlg_submit').on('click',submitdata);
                $("#sys_dlg").modal({backdrop: false});
            });
        }
    });
    function updateInRow(id)
    {
        $("#sys_dlg").load('/szny/index.php/Admin/Emp/edit?id=' + id, function() {
            $('#sys_dlg_submit').on('click',submitdata);
            $("#sys_dlg").modal({backdrop: false});
        });
    }
    function updatePhoneInRow(id)
    {
        $("#sys_dlg").load('/szny/index.php/Admin/Emp/editphone?id=' + id + '&', function() {
            $('#sys_dlg_submit').on('click',submitphonedata);
            $("#sys_dlg").modal({backdrop: false});
        });
    }
    function delInRow(id)
    {
        if (confirm('确认删除数据?')) {
            var ids = [];
            ids.push(id);
            $.post('/szny/index.php/Admin/Emp/del', {ids: ids.join(',')}, function (rep, status) {
                if ('' == rep) {
                    $('#atpbiztable').bootstrapTable('refresh')
                }
                else {
                    alert('删除失败' + "可能是因为数据存在关联无法删除<br>错误详情：" + rep);
                }
            });
        }
    }

    $('#sys_del').on('click',function() {
        var tablerow = $('#atpbiztable').bootstrapTable('getSelections');
        if (tablerow.length == 0) {
            alert("您尚未选择数据");
        }
        else {
            if (confirm('确认删除' + tablerow.length + '条数据?')) {
                var ids = [];
                $.each(tablerow, function () {
                    ids.push(this['emp_atpid']);
                });
                $.post('/szny/index.php/Admin/Emp/del', {ids: ids.join(',')}, function (rep, status) {
                    if ('' == rep) {
                        $('#atpbiztable').bootstrapTable('refresh')
                    }
                    else {
                        alert('删除失败' + "可能是因为数据存在关联无法删除<br>错误详情：" + rep);
                    }
                });
            }
        }
    });
    function ATP_FRAME_SECOND_ENTER_CALLBACK()
    {
        $('#atpbiztable').bootstrapTable('refresh');
    }
</script>
</body>
</html>