<?php
namespace Admin\Controller;
use Think\Controller;
class BaseAuthController extends BaseController
{
    function _initialize()
    {
        parent::_initialize();
        if(!session('emp_atpid'))
        {
            $this->redirect('/Admin/Login');
        }else{
            $emp_atpid = session('emp_atpid', '');
            $Model = M('role');
            $sql_select_role = "
            select
             * 
             from szny_role t 
             left join szny_emprole t1 on t1.emprole_roleid = t.role_atpid
             left join szny_emp t2 on t1.emprole_empid = t2.emp_atpid
             where t.role_atpstatus is null and t1.emprole_atpstatus is null and t2.emp_atpstatus is null and t2.emp_atpid = '$emp_atpid'
             ";
            $Result_role = $Model->query($sql_select_role);
            $result = array();
            foreach ($Result_role as $rk => $rv){
                array_push($result,$rv['role_name']);
            }
            $result_role_string = implode(',',$result);
//            dump($result_role_string);die();
            session('emp_role',$result_role_string);
        }
    }
}