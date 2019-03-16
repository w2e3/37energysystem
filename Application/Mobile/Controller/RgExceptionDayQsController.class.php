<?php
namespace Mobile\Controller;
use Think\Controller;
class RgExceptionDayQsController extends BaseController
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
      $this->get_RgExceptionDayEc_data($regiontype,$rgn_atpid,$snname,null);
      $this->assign('rgn_atpid',$rgn_atpid);
      $this->display('index');
    }

  public function get_RgExceptionDayEc_data($regiontype,$rgn_atpid,$snname,$deve_atpid)
  {
    $res=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
    $data=array();
    foreach ($res as $key => $value)
    {
      $date[] = "'" . $value['rgn_atpid'] . "'";
    }
    $endrgn_atpidsstrings = implode(',', $date);
    $Model = M('deviceexception');
    $sql_select = "
                select
                     *
                from szny_deviceexception t
                left join szny_device t1 on t.deve_deviceid = t1.dev_atpid
                left join szny_region t2 on t.deve_regionid = t2.rgn_atpid
                left join szny_emp t3 on t.deve_opempid = t3.emp_atpid
                ";

      $sql_select.=" where t.deve_atpstatus is null";
    if ($deve_atpid!=null)
    {
      $sql_select.=" and t.deve_atpid = '{$deve_atpid}'";
    }
      $sql_select.=" and  t1.dev_atpstatus is null";
      $sql_select.=" and t2.rgn_atpstatus is null";
      $sql_select.=" and t3.emp_atpstatus is null";
      $sql_select.=" and t.deve_type  = '日报缺失'";
      $sql_select.=" and t2.rgn_atpid in (".$endrgn_atpidsstrings.")";
      $sql_select.=" order by t.deve_dt desc";
      $Result = $Model->query($sql_select);
    $this->assign('Data',$Result);
    }

    public function detail()
    {
      //获得所有子节点
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');

      $deve_atpid = ((I('get.deve_atpid')) == null) ? "" : I('get.deve_atpid');


      $RgDev=new RgDevController();
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
      $this->get_RgExceptionDayEc_data($regiontype,$rgn_atpid,$snname,$deve_atpid);
      $this->assign('rgn_atpid',$rgn_atpid);
      $this->display();
    }
}
