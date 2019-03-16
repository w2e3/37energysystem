<?php if (!defined('THINK_PATH')) exit();?>﻿﻿<div class="modal-dialog" style="width: 1000px;z-index: 10;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" data-dismiss="modal" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">数据编辑</h4>
        </div>
        <div class="modal-body">
            <form onkeydown="if(event.keyCode==13){return false;}"  id="sys_dlg_form" role="form" class="form-horizontal">
                <div>
                    <!--<ul class="nav nav-tabs">-->
                        <!--&lt;!&ndash;<li class="active"><a data-toggle="tab" href="#tab-1">基础信息</a></li>&ndash;&gt;-->
                        <!--&lt;!&ndash;<li class=""><a data-toggle="tab" href="#tab-2">球员/领队信息</a></li>&ndash;&gt;-->
                        <!--&lt;!&ndash;<li class=""><a data-toggle="tab" href="#tab-3">裁判信息</a></li>&ndash;&gt;-->
                        <!--&lt;!&ndash;<li class=""><a data-toggle="tab" href="#tab-4">保险信息</a></li>&ndash;&gt;-->
                    <!--</ul>-->
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <span style="color: red">*</span>
                                        账号：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_account" type="text" value="<?php echo ($data["emp_account"]); ?>" class="form-control" required>
                                    </div>
                                    <label class="col-sm-2 control-label">密码：</label>
                                    <div class="col-sm-4">
                                        <input name="emp_password" type="password" value="<?php echo ($data["emp_password"]); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <span style="color:red;">*</span>
                                        姓名：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_name" type="text"  value="<?php echo ($data["emp_name"]); ?>" required class="form-control" required>
                                    </div>
                                    <label class="col-sm-2 control-label">
                                        <span style="color:red;">*</span>
                                        员工编号：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_codename" type="text"  value="<?php echo ($data["emp_codename"]); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        类型：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_category" type="text"  value="<?php echo ($data["emp_category"]); ?>" class="form-control">
                                    </div>
                                    <label class="col-sm-2 control-label">
                                        性别：
                                    </label>
                                    <div class="col-sm-4">
                                        <select name="emp_sex" class="chosen-select" >
                                            <option value="">&nbsp;==请选择==</option>
                                            <option value="男" <?php if(($data["emp_sex"] == '男')): ?>selected<?php else: endif; ?> >男</option>
                                            <option value="女" <?php if(($data["emp_sex"] == '女')): ?>selected<?php else: endif; ?> >女</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        主电话：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_mainphone" type="text"  value="<?php echo ($data["emp_mainphone"]); ?>" class="form-control">
                                    </div>
                                    <label class="col-sm-2 control-label">
                                        职务：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_duty" type="text"  value="<?php echo ($data["emp_duty"]); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        入职时间：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_indatetime" type="text"  value="<?php echo ($data["emp_indatetime"]); ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control">
                                    </div>
                                    <label class="col-sm-2 control-label">
                                        离职时间：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_outdatetime" type="text"  value="<?php echo ($data["emp_outdatetime"]); ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        变更时间：
                                    </label>
                                    <div class="col-sm-4">
                                        <input name="emp_changedatetime" type="text"  value="<?php echo ($data["emp_changedatetime"]); ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        备注：
                                    </label>
                                    <div class="col-sm-10">
                                        <input name="emp_remark" type="text"  value="<?php echo ($data["emp_remark"]); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">角色：</label>
                                    <div class="col-sm-10">
                                        <select name="emp_role[]" class="chosen-select" multiple id="role">
                                            <?php if(is_array($ds_emprole)): foreach($ds_emprole as $erk=>$erv): if(('是' == $erv['aux_selected'])): ?><option value="<?php echo ($erv["role_atpid"]); ?>" selected ><?php echo ($erv["role_name"]); ?></option>
                                                    <?php else: ?>
                                                    <option value="<?php echo ($erv["role_atpid"]); ?>" ><?php echo ($erv["role_name"]); ?></option><?php endif; endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">部门：</label>
                                    <div class="col-sm-10">
                                        <select name="emp_department[]" class="chosen-select" multiple id="department">
                                            <?php if(is_array($ds_department)): foreach($ds_department as $dmk=>$dmv): if(('是' == $dmv['aux_selected'])): ?><option value="<?php echo ($dmv["dpm_atpid"]); ?>" selected ><?php echo ($dmv["dpm_name"]); ?></option>
                                                    <?php else: ?>
                                                    <option value="<?php echo ($dmv["dpm_atpid"]); ?>" ><?php echo ($dmv["dpm_name"]); ?></option><?php endif; endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input name="emp_atpid" type="hidden" value="<?php echo ($data["emp_atpid"]); ?>" class="form-control">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
            <button type="button"  id="sys_dlg_submit" class="btn btn-primary">保存</button>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in" style="z-index: -101;"></div>
<script>
$(function () {
    $(".js-switch").each(function(){
        new Switchery(this, {color: '#1AB394'});
    });
    $(".file-pretty").prettyFile();
    $("#role").chosen({disable_search_threshold: 6, search_contains: true,width:'750px'});
    $("#department").chosen({disable_search_threshold: 6, search_contains: true,width:'750px'});
    $(".chosen-select").chosen({disable_search_threshold: 6, search_contains: true,width:'284px'});
});
</script>