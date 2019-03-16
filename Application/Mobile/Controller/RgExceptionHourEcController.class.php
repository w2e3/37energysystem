<?php
namespace Mobile\Controller;
use Think\Controller;
class RgExceptionHourEcController extends BaseController
{

    public function index()
    {
      //获得所有子节点
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');


      $RgDev=new RgDevController();
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
      $this->get_RgExceptionDayEc_data($regiontype,$rgn_atpid,$snname);
      $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();

    }

    public function get_RgExceptionDayEc_Data($regiontype,$rgn_atpid,$snname){

      $res=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
      $data=array();
      foreach ($res as $key => $value) {
        $date[] = "'" . $value['rgn_atpid'] . "'";
      }
      $endrgn_atpidsstrings = implode(',', $date);
      $sql_rgnwhere = "and t3.almc_regionid in (".$endrgn_atpidsstrings.")";
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
      $endrgn_atpidsstrings = implode(',', $date);
      $sql_rgnwhere = "and t3.almc_regionid in (".$endrgn_atpidsstrings.")";
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
      $Result = $Model->query($sql_select);
      $this->assign('Data',$Result);
    }
}
