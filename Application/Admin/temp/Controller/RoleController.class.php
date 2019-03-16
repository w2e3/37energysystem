<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RoleController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【角色管理】");
        $this->display();
    }

	public function add()
    {
        $this->assignDsRoleModule();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【角色管理】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('role');
            $data = $Model->where("role_atpid='%s'", array($id))->find();

            if ($data) {
                $this->assign('data', $data);
            }
            $this->assignDsRoleModule($id);
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【角色管理】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("role");
                foreach ($array as $id) {
                    $data = $Model->where("role_atpid='%s'", array($id))->find();
                    $data['role_atpstatus'] = 'DEL';
                    $data['role_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['role_atplastmodifyuser'] = session('emp_account');
                    $Model->where("role_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【角色管理】 / 【删除】");
    }

    public function submit(){
    	$Model = M('role');
    	$Model_rolemodule = M('rolemodule');
    	$data = $Model->create();//dump($data);
        if (null == $data['role_atpid'])
        {
		   //添加
            $data['role_atpid'] = $this->makeGuid();
            $data['role_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['role_atpcreateuser'] = session('emp_account');
            $data['role_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['role_atplastmodifyuser'] = session('emp_account');
            $data['role_atpsort'] = time();
/********************************************************************************************************************/
            $Model_rolemodule->execute("update szny_rolemodule t set t.rolemodule_atpstatus = 'DEL' where t.rolemodule_roleid = '".$data["role_atpid"]."'");
//            dump($Model->_sql());
//            dump($_POST['emp_role']);
//            die();
            if (null != $_POST['role_module']) {
                foreach ($_POST['role_module'] as $mitem) {
                    $idata = array();
                    $idata['rolemodule_atpid'] = $this->makeGuid();
                    $idata['rolemodule_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atpcreateuser'] =  session('emp_account');
                    $idata['rolemodule_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atplastmodifyuser'] =  session('emp_account');
                    $idata['rolemodule_atpsort'] = time();
                    $idata['rolemodule_moduleid'] = $mitem;
                    $idata['rolemodule_roleid'] = $data['role_atpid'];
                    $Model_rolemodule->add($idata);
                }
            }
            //添加
            $Model->add($data);
        } else
            {
            $data['role_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['role_atplastmodifyuser'] = session('emp_account');

/********************************************************************************************************************/
                $Model_rolemodule->execute("update szny_rolemodule t set t.rolemodule_atpstatus = 'DEL' where t.rolemodule_roleid = '".$data["role_atpid"]."'");
//            dump($Model->_sql());
//            dump($_POST['emp_role']);
//            die();
            if (null != $_POST['role_module']) {
                foreach ($_POST['role_module'] as $mitem) {
                    $idata = array();
                    $idata['rolemodule_atpid'] = $this->makeGuid();
                    $idata['rolemodule_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atpcreateuser'] =  session('emp_account');
                    $idata['rolemodule_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atplastmodifyuser'] =  session('emp_account');
                    $idata['rolemodule_atpsort'] = time();
                    $idata['rolemodule_moduleid'] = $mitem;//
                    $idata['rolemodule_roleid'] = $data['role_atpid'];
                    $Model_rolemodule->add($idata);
                }
            }
        	//修改
            $Model->where("role_atpid='%s'", array($data['role_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					t.*
				from szny_role t 
				";
		$sql_count = "
				select
					count(1) c
				from szny_role t 
				";
        $sql_select = $this->buildSql($sql_select, "t.role_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.role_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.role_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.role_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.role_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.role_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.role_atplastmodifydatetime desc";
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
        // var_dump($Result);die;

        $rolemodule_roleid = [];
        foreach ($Result as $k => $v)
        {
            array_push($rolemodule_roleid, $v['role_atpid']);
            $v['role_module'] = '';
        }
//        dump($emprole_empid);
        $sql_select_rel = "
select
	*
from szny_rolemodule t
left join szny_module t1 on t.rolemodule_moduleid = t1.module_atpid
where t.rolemodule_atpstatus is null and t1.module_atpstatus is null and t.rolemodule_roleid in ('" . implode("','", $rolemodule_roleid) . "')
order by t.rolemodule_roleid , t1.module_name asc ";
        $Result_rel = $Model->query($sql_select_rel);
//        dump($Result_rel);die();
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['role_atpid'] == $rmv['rolemodule_roleid']) {
                    if ($v['role_module'] != '') {
                        $v['role_module'] = $v['role_module'] . "," . $rmv['module_name'];
                    } else {
                        $v['role_module'] = $rmv['module_name'];
                    }
                }
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function assignDsRoleModule($roleid)
    {
        $Model = M();
        $sql_select_module = "
            select
                *
            from szny_module t
            where t.module_atpstatus is null
            order by t.module_name asc
            ";
        $Result_module = $Model->query($sql_select_module);

        $sql_select_rolemodule = "
            select
                *
            from szny_rolemodule t
            where t.rolemodule_atpstatus is null and t.rolemodule_roleid = '$roleid' ";
        $Result_rolemodule = $Model->query($sql_select_rolemodule);//dump($Result_emprole);

        foreach ($Result_module as $mk => &$mv) {
            foreach ($Result_rolemodule as $rmk => &$rmv) {
                if ($mv['module_atpid'] == $rmv['rolemodule_moduleid']) {
                    $mv['aux_selected'] = '是';
                    break;
                }
            }
        }
       // dump($Result_module);
        $this->assign('ds_rolemodule', $Result_module);
    }
}