<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgExceptionHourEcController extends BaseAuthController
{
    public function index(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【时报异常】");
        $rgn_atpid = I("get.rgn_atpid","");


        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $sql_rgnwhere = "and t3.almc_regionid in (".$endrgn_atpidsstrings.")";
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $searchcontent = date('y-m-d',time());
        $sql_dtwhere = "and t.alm_datetime like '%$searchcontent%'";

        $Model = M('deviceexception');
        $sql_select = "
select
	CONCAT(LEFT (t.alm_datetime, 10),':00:00') dt,
	count(1) allcount,
	SUM(IF(t.alm_confirmstatus='待确认',1,0)) dqrcount,
	SUM(IF(t.alm_confirmstatus='已忽略',1,0)) yhlcount,
	SUM(IF(t.alm_confirmstatus='已确认',1,0)) yqrcount,
	SUM(IF(t.alm_confirmstatus='待接单',1,0)) djdcount,
	SUM(IF(t.alm_confirmstatus='待处理',1,0)) dclcount,
	SUM(IF(t.alm_confirmstatus='已处理',1,0)) yclcount
from szny_alarm t
left join szny_emp t1 on t.alm_empid = t1.emp_atpid
left join szny_device t2 on t2.dev_atpid = t.alm_deviceid
left join szny_alarmconfig t3 on t3.almc_atpid = t.alm_alarmconfigid
left join szny_region t4 on t4.rgn_atpid = t3.almc_regionid
where t.alm_atpstatus is null $sql_rgnwhere $sql_dtwhere
group by LEFT (t.alm_datetime, 10)
                ";
        $Result = $Model->query($sql_select);
        if(count($Result)==0)
        {
            $this->assign('allcount',"0");
            $this->assign('dqrcount',"0");
            $this->assign('yhlcount',"0");
            $this->assign('yqrcount',"0");
        }
        else
        {
            $this->assign('allcount',$Result[0]['allcount']);
            $this->assign('dqrcount',$Result[0]['dqrcount']);
            $this->assign('yhlcount',$Result[0]['yhlcount']);
            $this->assign('yqrcount',$Result[0]['yqrcount']);
        }
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }

    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);

        $sql_rgnwhere = "and t3.almc_regionid in (".$endrgn_atpidsstrings.")";

        $queryparam = json_decode(file_get_contents("php://input"), true);
        $sql_dtwhere="";
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_dtwhere = "and t.alm_datetime like '%$searchcontent%'";
        }

        $Model = M('deviceexception');
        $sql_select = "
select
	CONCAT(LEFT (t.alm_datetime, 13),':00:00') dt,
	count(1) allcount,
	SUM(IF(t.alm_confirmstatus='待确认',1,0)) dqrcount,
	SUM(IF(t.alm_confirmstatus='已忽略',1,0)) yhlcount,
	SUM(IF(t.alm_confirmstatus='已确认',1,0)) yqrcount,
	SUM(IF(t.alm_confirmstatus='待接单',1,0)) djdcount,
	SUM(IF(t.alm_confirmstatus='待处理',1,0)) dclcount,
	SUM(IF(t.alm_confirmstatus='已处理',1,0)) yclcount
from szny_alarm t
left join szny_emp t1 on t.alm_empid = t1.emp_atpid
left join szny_device t2 on t2.dev_atpid = t.alm_deviceid
left join szny_alarmconfig t3 on t3.almc_atpid = t.alm_alarmconfigid
left join szny_region t4 on t4.rgn_atpid = t3.almc_regionid
where t.alm_atpstatus is null $sql_rgnwhere $sql_dtwhere
group by LEFT (t.alm_datetime, 13)
                ";
        $sql_count = "
select count(1) c from
(
select
	CONCAT(LEFT (t.alm_datetime, 13),':00:00') dt,
	count(1) allcount,
	SUM(IF(t.alm_confirmstatus='待确认',1,0)) dqrcount,
	SUM(IF(t.alm_confirmstatus='已忽略',1,0)) yhlcount,
	SUM(IF(t.alm_confirmstatus='已确认',1,0)) yqrcount,
	SUM(IF(t.alm_confirmstatus='待接单',1,0)) djdcount,
	SUM(IF(t.alm_confirmstatus='待处理',1,0)) dclcount,
	SUM(IF(t.alm_confirmstatus='已处理',1,0)) yclcount
from szny_alarm t
left join szny_emp t1 on t.alm_empid = t1.emp_atpid
left join szny_device t2 on t2.dev_atpid = t.alm_deviceid
left join szny_alarmconfig t3 on t3.almc_atpid = t.alm_alarmconfigid
left join szny_region t4 on t4.rgn_atpid = t3.almc_regionid
where t.alm_atpstatus is null $sql_rgnwhere $sql_dtwhere
group by LEFT (t.alm_datetime, 13)
) t";

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by LEFT (t.alm_datetime, 13) "  . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by LEFT (t.alm_datetime, 13) desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}