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
</head>
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
    .form-control
    {
        display: inline-block;
        margin-bottom: 5px;;
    }
    .float-e-margins .btn
    {
        margin-bottom: 1px;;
    }
    .control-label
    {
        display: inline-block;
        /*margin-bottom: 5px;;*/
    }


</style>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <div id="atpbiztoolbar">
                        <label class="control-label">开始日期：</label>
                        <input type="text" id="starttime" class="form-control" value="<?php echo ($starttime); ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" style="width: 120px;" placeholder="输入开始日期">
                        <label class="control-label">结束日期：</label>
                        <input type="text" id="endtime" class="form-control" value="<?php echo ($endtime); ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" style="width: 120px;" placeholder="输入结束日期">

                        <input type="hidden" id="rgn_atpid" value="<?php echo ($rgn_atpid); ?>">
                        <button class="btn btn-info " type="button" id="sys_search"><i class="fa fa-pencil"></i>&nbsp;搜索</button>
                        <input type="hidden" id="regionid" value="<?php echo ($rgn_atpid); ?>">
                        <!--<button class="btn btn-info " type="button" id="sys_info"><i class="fa fa-pencil"></i>&nbsp;查看</button>-->
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
    var currenttab=5;
    jumptab(currenttab);

</script>
<script>
    GLOBAL_SEARCHNAME = "设备名称";
    $(function () {
        $('#atpbiztable').bootstrapTable({
            url: '/szny/index.php/Admin/Originaldata/getData?regionid=<?php echo ($rgn_atpid); ?>',         //请求后台的URL（*）
            method: 'post',                      //请求方式（*）
            toolbar: '#atpbiztoolbar',                //工具按钮用哪个容器
            striped: true,                      //是否显示行间隔色
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            iconSize: 'outline',
            sortable: true,                     //是否启用排序
            sortName:"data_dt",
            sortOrder: "desc",                   //排序方式
            queryParams: queryParams,//传递参数（*）
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber: 1,                       //初始化加载第一页，默认第一页
            pageSize: 10,                       //每页的记录行数（*）
            pageList: [5,10, 25, 50, 100],        //可供选择的每页的行数（*）
        //    search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
//            strictSearch: true,
            //showColumns: true,                  //是否显示所有的列
            showRefresh: false,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: true,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "data_atpid",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            //  detailView: true,                   //是否显示父子表
            detailFormatter: "detailFormatter",
            height:510,
            columns: [
                [
//                    {checkbox: true},
                    {title: '序号', width: 40,
                        formatter: function (value, row, index)
                        {
                            var option =  $('#atpbiztable').bootstrapTable("getOptions");
                            return option.pageSize * (option.pageNumber - 1) + index + 1;
                        }
                    },
                    {field: 'rgn_name', title: '位置点', sortable: true,width:150},
                    {field: 'dev_code', title: '设备编号', sortable: true,width:150},
                    {field: 'data_dt', title: '时间', sortable: true,width:150},
                <?php if(is_array($arr)): foreach($arr as $key=>$vo): if(!in_array($vo['value'],$otherFields)) { ?>
                    
                           
      
                        {field: 'data_<?php echo ($vo["value"]); ?>', title: '<?php echo ($vo["name"]); ?>', sortable: true},
                     
                    <?php } endforeach; endif; ?>

        {field: 'data_atpid', title: '主键', sortable: true, visible:false},
        {field: 'data_atpcreatedatetime', title: '创建时间', sortable: true, visible:false},
        {field: 'data_atpcreateuser', title: '创建人', sortable: true, visible:false},
        {field: 'data_atplastmodifydatetime', title: '最后修改时间', sortable: true, visible:false},
        {field: 'data_atplastmodifyuser', title: '最后修改人', sortable: true, visible:false},
        {field: 'data_atpstatus', title: '状态', sortable: true, visible:false},
        ]
        ],
        onDblClickRow: function (row) {
//            window.parent.ATP_BOX_OPEN("/szny/index.php/Admin/Originaldata/info?regionid="+row['data_regionid'],checkCallback);
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
            u_account: $("#search_u_account").val(),
            u_name: $("#search_u_name").val(),
            regionid:$("#regionid").val(),
            u_birthday_begin: $("#search_u_birthday_begin").val(),
            endtime: $("#endtime").val(),
            u_role: $("#search_u_role").val(),
            starttime: $("#starttime").val(),
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
        var starttime= $("#starttime").val();
        var endtime= $("#endtime").val();
        var u_role= $("#search_u_role").val();
        var  regionid=$("#rgn_atpid").val();
        if(starttime.length==0){
            alert("开始时间不能为空");
            return;
        }
        if(endtime.length==0){
            alert("结束时间不能为空");
            return;
        }
        if(starttime>endtime){
            alert("时间选择错误");
            return;
        }
        window.location.href='/szny/index.php/Admin/Originaldata/tableindex?endtime='+endtime+'&starttime='+starttime+'&regionid='+regionid;

        $('#atpbiztable').bootstrapTable('refresh')
    });
    function submitdata()
    {
        $("#sys_dlg_form").submit(function(e)
        {
            var formObj = $(this);
            var formURL = formObj.attr("action");
            var formData = new FormData(this);
            $.ajax({
                url: '/szny/index.php/Admin/Originaldata/submit',
                type: 'POST',
                data:  formData,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR)
                {
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

    $('#sys_update').on('click',function() {
        var tablerow = $('#atpbiztable').bootstrapTable('getSelections');
        if(tablerow.length!=1)
        {
            alert("您已多选或者少选，仅能对一条数据进行操作");
        }
        else {
            $("#sys_dlg").load('/szny/index.php/Admin/Originaldata/edit?id=' + tablerow[0]['u_atpid'], function() {
                $('#sys_dlg_submit').on('click',submitdata);
                $("#sys_dlg").modal({backdrop: false});
            });
        }
    });

    function updateInRow(id)
    {
        $("#sys_dlg").load('/szny/index.php/Admin/Originaldata/edit?id=' + id, function() {
            $('#sys_dlg_submit').on('click',submitdata);
            $("#sys_dlg").modal({backdrop: false});
        });
    }

    function delInRow(id)
    {
        if (confirm('确认删除数据?')) {
            var ids = [];
            ids.push(id);
            $.post('/szny/index.php/Admin/Originaldata/del', {ids: ids.join(',')}, function (rep, status) {
                if ('' == rep) {
                    $('#atpbiztable').bootstrapTable('refresh')
                }
                else {
                    alert('删除失败' + "可能是因为数据存在关联无法删除<br>错误详情：" + rep);
                }
            });
        }
    }

    $('#sys_info').on('click',function() {
        var tablerow = $('#atpbiztable').bootstrapTable('getSelections');
        if (tablerow.length != 1) {
            alert("请操作一条数据");
        }
        else {
            window.parent.ATP_BOX_OPEN("/szny/index.php/Admin/Originaldata/info?regionid="+tablerow[0]['data_regionid'],checkCallback);
        }
    });
    function checkCallback(){
        window.parent.ATP_BOX_CLOSE();
    }
</script>
<script>
    $(function () {
        $(".chosen-select2").chosen({disable_search_threshold: 10, search_contains: true, width:'150px'});
    });
</script>
</body>

</html>