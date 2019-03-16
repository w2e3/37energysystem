<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>table</title>
    <link href="/szny/Public/vendor/bootstrap-table/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link href="/szny/Public/adminframework/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/szny/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" >
    <link href="/szny/Public/adminframework/css/animate.css" rel="stylesheet">
    <link href="/szny/Public/adminframework/css/style.css?v=4.0.0" rel="stylesheet">
    <link rel="stylesheet" href="/szny/Public/vendor/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <link href="/szny/Public/vendor/diy_component/func_scrolltab/atppagetab.css" rel="stylesheet">
</head>
<body>
<table id="atpbiztable" ></table>

<input type="hidden" name="" value="<?php echo ($_GET['regtype']); ?>" id="bs">
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
    GLOBAL_SEARCHNAME = "报警设备搜索";
    $(function () {
        $('#atpbiztable').bootstrapTable({
            url: '/szny/index.php/Admin/RgGeneral/getAlarmData?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>',         //请求后台的URL（*）
            method: 'post',                      //请求方式（*）
//            toolbar: '#atpbiztoolbar',                //工具按钮用哪个容器
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
//                search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
//            strictSearch: true,
//            showColumns: true,                  //是否显示所有的列
//                showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: false,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "alm_atpid",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            detailFormatter: "detailFormatter",
            height:308,
            columns: [
                [
                    // {checkbox: false},
                    {title: '序号', width: 40,align:'center',
                        formatter: function (value, row, index)
                        {
                            var option =  $('#atpbiztable').bootstrapTable("getOptions");
                            return option.pageSize * (option.pageNumber - 1) + index + 1;
                        }
                    },
                    {field: 'rgn_name', title: '设备点',align:'center', valign:'middle', sortable: true},
//                    {field: 'dev_acquisition', title: '采集号',align:'center', valign:'middle', sortable: false},
//                    {field: 'dev_name', title: '设备类别',align:'center', valign:'middle', sortable: true},
                    {field: 'alm_datetime', title: '报警时间',align:'center', valign:'middle', sortable: true},
                    {field: 'alm_category', title: '能源类别',align:'center', valign:'middle', sortable: true},
                    {field: 'alm_level', title: '报警等级',align:'center', valign:'middle', sortable: true},
                    {field: 'almc_name', title: '报警类型',align:'center', valign:'middle', sortable: true},
                    {field: 'alm_content', title: '事件详情',align:'center', valign:'middle', sortable: true},
                    {field: 'value_param', title: '上下限',align:'center', valign:'middle', sortable: false},
//                    {field: 'emp_name', title: '处理人',align:'center', valign:'middle', sortable: true},
                    {field: 'alm_confirmstatus', title: '报警状态',align:'center', valign:'middle', sortable: true},
//                    {field: 'alm_confirmdate', title: '操作时间',align:'center', valign:'middle', sortable: true},
//                    {field: 'alm_confirmremark', title: '操作描述',align:'center', valign:'middle', sortable: true},


                    {field:'alm_atpid',title:'主键',visible:false},
                    {field:'alm_atpcreatedatetime',title:'创建时间',visible:false},
                    {field:'alm_atpcreateuser',title:'创建人',visible:false},
                    {field:'alm_atplastmodifydatetime',title:'最后修改时间',visible:false},
                    {field:'alm_atplastmodifyuser',title:'最后修改人',visible:false},
                    {field:'alm_atpstatus',title:'数据状态',visible:false},
                    {field:'alm_atpsort',title:'数据排序',visible:false},
                    {field:'alm_atpremark',title:'数据备注',visible:false},
                    {field: 'rgn_atpid', title: '操作',align:'center', sortable: false,width:100,
                       formatter: function (value, row, index) {
                           var inp = "'"+  value +"'";
                           var rgn_atpid = "'"+  row['rgn_atpid'] +"'";
                           var a = '<a  class="btn btn-success btn-xs" onclick="dealAlarm('+ inp +','+ rgn_atpid +')">去处理</a>';
                           return a;
//                           return "";
                       }
                   },
                ]
            ],
            onDblClickRow: function (row) {
                //     $("#sys_dlg").load('/szny/index.php/Admin/RgGeneral/edit?id=' + row['alm_atpid'], function() {
                //         $('#sys_dlg_submit').on('click',submitdata);
                //         $("#sys_dlg").modal({backdrop: false});
                //     });
            },
            onSort: function (name, order) {
//                console.log(name+order);
            },
        });
    });
    function dealAlarm(inp,rgn_atpid){
        if('<?php echo ($_GET['regionlevel']); ?>' == 'devicepoint'){
            window.parent.parent.ATP_REGIONJUMbj(rgn_atpid);
        }else{
            window.parent.parent.parent.ATP_REGIONJUMbj(rgn_atpid);
        }
    }
    function queryParams(params) {  //配置参数
        var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
            limit: params.limit,   //页面大小
            offset: params.offset,  //页码
            search: params.search,
            disposestatus: $("#search_disposestatus").val(),
            rgn_atpid:$('#rgn_atpid').val(),
            sort: params.sort,  //排序列名
            sortOrder: params.order//排位命令（desc，asc）
        };
        return temp;
    }

    $("#sys_search").on('click',function() {
        $('#atpbiztable').bootstrapTable('refresh');
    });
    function ignoreInRow(id)
    {
        $.post('/szny/index.php/Admin/RgGeneral/isignore?alm_atpid='+ id ,function(data){
            if(1 == data){
                if (confirm('忽略报警?')){
                    window.parent.ATP_BOX_OPEN("/szny/index.php/Admin/RgGeneral/reason?alm_atpid="+id,reasonCallback);
                }
            }else{
                alert('只有待确认的报警才能忽略');
            }
            $('#atpbiztable').bootstrapTable('refresh');
        })
    }
    function reasonCallback() {
        window.parent.ATP_BOX_CLOSE();
        var alm_atpid = $('#alm_atpid',parent.document).val();
        var alm_disposeresult = $('#alm_disposeresult',parent.document).val();
        $.post('/szny/index.php/Admin/RgGeneral/ignore',{'alm_atpid':alm_atpid,'alm_disposeresult':alm_disposeresult},function (data) {
            if(1 == data){
                alert('报警忽略成功');
            }else{
                alert('报警忽略失败');
            }
            $('#atpbiztable').bootstrapTable('refresh');
        })
    }

    function comfirmInRow(id)
    {
        if (confirm('确认报警?')){
            $.post('/szny/index.php/Admin/RgGeneral/iscomfirm?alm_atpid='+ id ,function(data){
                if(1 == data){
                    $.post('/szny/index.php/Admin/RgGeneral/comfirm?alm_atpid=' + id,function(data){
                        if(1==data){
                            alert('报警确认成功');
                        }else{
                            alert('报警确认失败');
                        }
                    })
                }else{
                    alert('只有待确认的报警才能确认');
                }
                $('#atpbiztable').bootstrapTable('refresh')
            })
        }
    }

</script>
</body>
</html>