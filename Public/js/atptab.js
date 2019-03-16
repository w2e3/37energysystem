/**
 * 编辑框初始化
 */
ATP_BOX_INIT = function () {
    $("#sys_dlg").empty();
};
/**
 * 编辑框打开
 */
ATP_BOX_OPEN = function (url, childcallback) {
    $("#sys_dlg").load(url, function () {
        $('#sys_dlg_submit').on('click', childcallback);
        $("#sys_dlg").modal({backdrop: false});
    });
};
/**
 * 编辑框关闭
 */
ATP_BOX_CLOSE = function () {
    $('#sys_dlg').modal('hide');
};
/**
 * 编辑框验证
 */
ATP_BOX_VALIDATE = function () {
    if ($.html5Validate.isAllpass($("#sys_dlg_form"))) {
        return true;
    }
    else {
        return false;
    }
};

/**
 * 搜索框初始化
 */
ATP_BOX_SEARCHINIT = function () {
    $("#sys_searchdlg").empty();
};
/**
 * 搜索框打开
 */
ATP_BOX_SEARCHOPEN = function (url, childcallback,defaultsearchelement,defaultsearchtext) {
    if($("#sys_searchdlg").children().length){
        //含有子元素
        if(null!=defaultsearchelement)
        {
            $("#"+defaultsearchelement).val(defaultsearchtext);
        }
        $("#sys_searchdlg").modal({backdrop: false});
    }else{
        //没有有子元素
        $("#sys_searchdlg").load(url, function () {
            $('#sys_dlg_search_submit').on('click', childcallback);
            $("#sys_searchdlg").modal({backdrop: false});
        });
    }
};
/**
 * 搜索框关闭
 */
ATP_BOX_SEARCHCLOSE = function () {
    $('#sys_searchdlg').modal('hide');
};
