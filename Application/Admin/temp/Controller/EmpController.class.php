<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class EmpController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【用户管理】");
        $this->display();
    }

	public function add()
    {
        $this->assignDsEmpRole();
        $this->assignDsEmpOrg();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【用户管理】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('emp');
            $data = $Model->where("emp_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
            $this->assignDsEmpRole($id);
            $this->assignDsEmpOrg($id);
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【用户管理】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("emp");
                $Model_emprole = M('emprole');
                $Model_edpm = M('empdepartment');
                foreach ($array as $id) {
                    $data = $Model->where("emp_atpid='%s'", array($id))->find();
                    $data['emp_atpstatus'] = 'DEL';
                    $data['emp_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['emp_atplastmodifyuser'] = session('emp_account');
                    $Model->where("emp_atpid='%s'", $id)->save($data);
                    $Model_emprole->execute("update szny_emprole t set t.emprole_atpstatus = 'DEL' where t.emprole_empid = '$id'");
                    $Model_edpm->execute("update szny_empdepartment t set t.edpm_atpstatus = 'DEL' where t.edpm_empid = '$id'");
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【用户管理】 / 【删除】");
    }

    public function submit(){
    	$Model = M('emp');
        $Model_emprole = M('emprole');
        $Model_edpm = M('empdepartment');
    	$data = $Model->create();//dump($data);

//        $tcondition['emp_account'] = array('eq',$data['emp_account']);
//        $tcondition['emp_atpstatus'] = array('exp', 'is null');
//        $tparamnum = $Model->where($tcondition)->count();
//        if($tparamnum!=0)
//        {
//            echo "1";
//            die;
//        }
//        $tcondition2['emp_codename'] = array('eq',$data['emp_codename']);
//        $tcondition2['emp_atpstatus'] = array('exp', 'is null');
//        $tparamnum2 = $Model->where($tcondition2)->count();
//        if($tparamnum2!=0)
//        {
//            echo "1";
//            die;
//        }


        if (null == $data['emp_atpid'])
        {
		   //添加
            $data['emp_atpid'] = $this->makeGuid();
            $data['emp_code']='GY'.date('YmdHis', time());
            $data['emp_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['emp_atpcreateuser'] = session('emp_account');
            $data['emp_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['emp_atplastmodifyuser'] = session('emp_account');
            $data['emp_atpsort'] = time();
/********************************************************************************************************************/
            $Model_emprole->execute("update szny_emprole t set t.emprole_atpstatus = 'DEL' where t.emprole_empid = '".$data["emp_atpid"]."'");
            if (null != $_POST['emp_role']) {
//                dump($_POST['emp_role']);
                foreach ($_POST['emp_role'] as $ritem) {
//                    array_push($emp_role,$ritem);
                    $idata = array();
                    $idata['emprole_atpid'] = $this->makeGuid();
                    $idata['emprole_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['emprole_atpcreateuser'] =  session('emp_account');
                    $idata['emprole_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['emprole_atplastmodifyuser'] =  session('emp_account');
                    $idata['emprole_atpsort'] = time();
                    $idata['emprole_roleid'] = $ritem;
                    $idata['emprole_empid'] = $data['emp_atpid'];
                    $Model_emprole->add($idata);
                }
            }
/********************************************************************************************************************/
            $Model_edpm->execute("update szny_empdepartment t set t.edpm_atpstatus = 'DEL' where t.edpm_empid = '".$data["emp_atpid"]."'");
            if (null != $_POST['emp_department']) {
//                dump($_POST['emp_department']);
                foreach ($_POST['emp_department'] as $oitem) {
                    $odata = array();
                    $odata['edpm_atpid'] = $this->makeGuid();
                    $odata['edpm_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $odata['edpm_atpcreateuser'] =  session('emp_account');
                    $odata['edpm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $odata['edpm_atplastmodifyuser'] =  session('emp_account');
                    $idata['edpm_atpsort'] = time();
                    $odata['edpm_departmentid'] = $oitem;
                    $odata['edpm_empid'] = $data['emp_atpid'];
                    $Model_edpm->add($odata);
                }
            }
/********************************************************************************************************************/
            $Model->add($data);
        } else
            {
            $data['emp_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['emp_atplastmodifyuser'] = session('emp_account');
                $Model_emprole->execute("update szny_emprole t set t.emprole_atpstatus = 'DEL' where t.emprole_empid = '". $data["emp_atpid"]."'");
                if (null != $_POST['emp_role']) {
                    foreach ($_POST['emp_role'] as $ritem) {

                        $idata = array();
                        $idata['emprole_atpid'] = $this->makeGuid();
                        $idata['emprole_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                        $idata['emprole_atpcreateuser'] =  session('emp_account');
                        $idata['emprole_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                        $idata['emprole_atplastmodifyuser'] =  session('emp_account');
                        $idata['emprole_atpsort'] = time();
                        $idata['emprole_roleid'] = $ritem;
                        $idata['emprole_empid'] = $data['emp_atpid'];
                        $Model_emprole->add($idata);
                    }
                }
/********************************************************************************************************************/
                $Model_edpm->execute("update szny_empdepartment t set t.edpm_atpstatus = 'DEL' where t.edpm_empid = '".$data["emp_atpid"]."'");
                if (null != $_POST['emp_department']) {
                    //dump($_POST['emp_department']);
                    foreach ($_POST['emp_department'] as $oitem) {
                        $odata = array();
                        $odata['edpm_atpid'] = $this->makeGuid();
                        $odata['edpm_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                        $odata['edpm_atpcreateuser'] =  session('emp_account');
                        $odata['edpm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                        $odata['edpm_atplastmodifyuser'] =  session('emp_account');
                        $idata['edpm_atpsort'] = time();
                        $odata['edpm_departmentid'] = $oitem;
                        $odata['edpm_empid'] = $data['emp_atpid'];
                        $Model_edpm->add($odata);
                    }
                }
/********************************************************************************************************************/
            //修改
            $Model->where("emp_atpid='%s'", array($data['emp_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('emp');
        $Model_emprole = M('emprole');
        $Model_edpm = M('empdepartment');
        $sql_select = "
				select
					t.*
				from szny_emp t
				";
		$sql_count = "
				select
					count(1) c
				from szny_emp t
				";
        $sql_select = $this->buildSql($sql_select, "t.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.emp_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.emp_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.emp_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.emp_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.emp_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.emp_atplastmodifydatetime desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $Count = $Model->query($sql_count, $WhereConditionArray);
//         var_dump($Result);die;
        $emprole_empid = [];
        $edpm_empid = [];
        foreach ($Result as $k => $v)
        {
            array_push($emprole_empid, $v['emp_atpid']);
            $v['emp_role'] = '';
            array_push($edpm_empid, $v['emp_atpid']);
            $v['emp_department'] = '';
        }

        $sql_select_rel = "
select
	*
from szny_emprole t
left join szny_role t1 on t.emprole_roleid = t1.role_atpid
where t.emprole_atpstatus is null and t1.role_atpstatus is null and t.emprole_empid in ('" . implode("','", $emprole_empid) . "')
order by t.emprole_empid , t1.role_name asc ";
        $Result_rel = $Model_emprole->query($sql_select_rel);
//        dump($Result_rel);die();
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['emp_atpid'] == $rmv['emprole_empid']) {
                    if ($v['emp_role'] != '') {
                        $v['emp_role'] = $v['emp_role'] . "," . $rmv['role_name'];
                    } else {
                        $v['emp_role'] = $rmv['role_name'];
                    }
                }
            }
        }

        $sql_select_edpm = "
select
	*
from szny_empdepartment t
left join szny_department t1 on t.edpm_departmentid = t1.dpm_atpid
where t.edpm_atpstatus is null and t1.dpm_atpstatus is null and t.edpm_empid in ('" . implode("','", $edpm_empid) . "')
order by t.edpm_empid , t1.dpm_name asc ";
        $Result_edpm = $Model_edpm->query($sql_select_edpm);
        foreach ($Result as $k => &$v) {
            foreach ($Result_edpm as $rmk => $rmv) {
                if ($v['emp_atpid'] == $rmv['edpm_empid']) {
                    if ($v['emp_department'] != '') {
                        $v['emp_department'] = $v['emp_department'] . "," . $rmv['dpm_name'];
                    } else {
                        $v['emp_department'] = $rmv['dpm_name'];
                    }
                }
            }
        }

        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
/**********************************************************************************************/
    public function assignDsEmpRole($empid)
    {
        $Model = M();
        $sql_select_role = "
            select
                *
            from szny_role t
            where t.role_atpstatus is null
            ";
        $Result_role = $Model->query($sql_select_role);

        $sql_select_emprole = "
            select
                *
            from szny_emprole t
            where t.emprole_atpstatus is null and t.emprole_empid = '$empid'
            ";
        $Result_emprole = $Model->query($sql_select_emprole);//dump($Result_emprole);

        foreach ($Result_role as $rk => &$rv) {
            foreach ($Result_emprole as $erk => &$erv) {
                if ($rv['role_atpid'] == $erv['emprole_roleid']) {
                    $rv['aux_selected'] = '是';
                    break;
                }
            }
        }
        $this->assign('ds_emprole', $Result_role);
    }

    public function assignDsEmpOrg($empid)
    {
        $Model = M();
        $sql_select_org = "
            select
                *
            from szny_department t
            where t.dpm_atpstatus is null
            ";
        $Result_org = $Model->query($sql_select_org);

        $sql_select_orgemp = "
            select
                *
            from szny_empdepartment t
            where t.edpm_atpstatus is null and t.edpm_empid = '$empid'";
        $Result_orgemp = $Model->query($sql_select_orgemp);

        foreach ($Result_org as $ok => &$ov) {
            foreach ($Result_orgemp as $oek => &$oev) {
                if ($ov['dpm_atpid'] == $oev['edpm_departmentid']) {
                    $ov['aux_selected'] = '是';
                    break;
                }
            }
        }
        $this->assign('ds_department', $Result_org);
    }
    //////////////////////////修改密码////////////////////////////////////////////
    public function renewPassword(){
        $emp_atpid = I('get.id','');
        if ($emp_atpid) {
            $Model = M('emp');
            $data = $Model->where("emp_atpid='%s'", array($emp_atpid))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【用户管理】 / 【修改密码】");
    }
    public function submitpassword()
    {
        $Model = M('emp');
        $data = $Model->create();
        $result = $Model->where("emp_atpid='%s'", array($data['emp_atpid']))->save($data);
    }
}