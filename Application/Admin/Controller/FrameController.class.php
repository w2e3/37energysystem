<?php
namespace Admin\Controller;
use Think\Controller;
class FrameController extends BaseAuthController {

    public function index()
    {
        $emp_atpid = session('emp_atpid', '');
        $Model = M();
        $sql_select_module = "
        select
         t.module_name
        from szny_module t
        left join szny_rolemodule t1 on t.module_atpid = t1.rolemodule_moduleid
        left join szny_role t2 on t1.rolemodule_roleid = t2.role_atpid
        left join szny_emprole t3 on t3.emprole_roleid = t2.role_atpid
        left join szny_emp t4 on t4.emp_atpid = t3.emprole_empid
        where t.module_atpstatus is null and t1.rolemodule_atpstatus is null and t2.role_atpstatus is null and t3.emprole_atpstatus is null and t4.emp_atpstatus is null 
        and t4.emp_atpid = '$emp_atpid'
        ";
        $Result_module = $Model->query($sql_select_module);
        $select_module =array();
        foreach ($Result_module as $mk => $mv){
            array_push($select_module,$mv['module_name']);
        }


        session('select_module',$select_module);
//        dump($select_module);die();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面->[园区概览】");
        $this->assign('ds_module', $select_module);
        $this->display();
    }

    public function index2()
    {
        $Model = M();
        $sql_select_module = "
        select
            *
        from newatp_module t
        where t.m_atpstatus is null and t.m_type = '模块' order by t.m_order asc ";
        $Result_module = $Model->query($sql_select_module);
        $this->assign('ds_module', $Result_module);
        $rgn_atpid = I('get.rgn_atpid','');
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }
    public function doing(){
        $rgn_atpid = I("get.rgn_atpid","");//dump($rgn_atpid);
        $this->assign("rgn_atpid",$rgn_atpid);
        $this->display();
    }
    public function doing1(){
        $rgn_atpid = I("get.rgn_atpid","");//dump($rgn_atpid);
        $this->assign("rgn_atpid",$rgn_atpid);
        $this->display();
    }
    public function welcome(){
        $this->display();
    }

    public function processview(){
        $this->display();
    }
}