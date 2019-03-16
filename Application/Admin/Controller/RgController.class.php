<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgController extends BaseAuthController
{
    public function index()
    {
        $regiontype = $_GET['regiontype'];
        $snname =  $_GET['snname'];
        if ("rg" == $regiontype)
        {
            $this->logSys(session('emp_atpid'),"访问日志","访问页面->[园区漫游】");
            $treedatas = $this->getRegionTree($regiontype,null);
            $rergionroot = $this->getRegionRoot($regiontype,null);
            $this->assign('treedatas',json_encode($treedatas));
            $this->assign('rgn_atpid',$rergionroot['rgn_atpid']);//默认加载页面传递rgn_atpid
        }
        if ("sn" == $regiontype)
        {
            $this->logSys(session('emp_atpid'),"访问日志","访问页面->[园区漫游】");
            $treedatas = $this->getRegionTree($regiontype,$snname);
            $rergionroot = $this->getRegionRoot($regiontype,$snname);
            $this->assign('treedatas',json_encode($treedatas));
            $this->assign('rgn_atpid',$rergionroot['rgn_atpid']);//默认加载页面传递rgn_atpid
        }
        $this->display();
    }



    //审批中心、报警
    //get.atpcontroller:需要加载的【Rg控制器】
    //get.atptitle:网站位置标题
    public function indexshell()
	{
        $this->display();
	}



}
