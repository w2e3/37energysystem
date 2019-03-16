<?php
namespace Mobile\Controller;
use Think\Controller;
class RgAlarmConfirmController extends BaseController
{
      public function index()
    {
      $Model = M();
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');
//      $type = I('get.type',null);
      $this->getAlarmdata($regiontype, $rgn_atpid, $snname,$pre_rgn_atpid);
      $this->display('');
    }

    //查看报警信息
    public function pengingalarm()
    {
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');
      $type = ((I('get.type')) == null) ? "" : I('get.type');

      $type="待确认";
      $RgDev=new RgDevController();
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
      $this->get_region_device_alarm($rgn_atpid,$regiontype,$snname,$type);
      $this->display();
    }

    public function unresolvealarm()
    {
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');
      $type = ((I('get.type')) == null) ? "" : I('get.type');


      $type="待处理";
      $RgDev=new RgDevController();
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
      $this->get_region_device_alarm($rgn_atpid,$regiontype,$snname,$type);

      $this->display('pengingalarm');
    }

  public function histroryalarm()
  {
    $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
    $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
    $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
    $snname = ((I('get.snname')) == null) ? "" : I('get.snname');
    $type = ((I('get.type')) == null) ? "" : I('get.type');

    $type=null;
    $RgDev=new RgDevController();
    $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
    $this->get_region_device_alarm($rgn_atpid,$regiontype,$snname,$type);

    $type="总";
    $this->assign('type',$type);
    $this->display('pengingalarm');
  }


    //查看报警详情
  public  function  detail()
  {

    $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
    $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
    $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
    $snname = ((I('get.snname')) == null) ? "" : I('get.snname');


    $dev_atpid= ((I('get.dev_atpid')) == null) ? "" : I('get.dev_atpid');
    $type="待确认";



    $this->getAlarmdata_detail($rgn_atpid,$regiontype,$snname,$dev_atpid,$type);

    $this>$this->display('detail');
  }
   public function getAlarmdata($regiontype, $rgn_atpid, $snname,$pre_rgn_atpid)
    {
      $Model = M();
      $res = $this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
      foreach ($res as $key => $value) {
        $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
      }
      $rgn_atpidlist = implode(',', $trgn_atpid);
      $sql_select = "
                select
                    *
                from szny_alarm t
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
                left join szny_region t3 on t5.almc_regionid = t3.rgn_atpid
                left join szny_device t1 on t3.rgn_deviceid = t1.dev_atpid
                 where t.alm_atpstatus is null and t1.dev_atpstatus is null
                 and t2.emp_atpstatus is null and t3.rgn_atpstatus is null
                 and t.alm_confirmstatus = '待确认'
				";
      $sql_select.="and t3.rgn_atpid in (" . $rgn_atpidlist . ")";

      if ($alm_atpid!=null)
      {
        $sql_select.="and t.alm_atpid = '{$alm_atpid}'";
      }

      $Result = $Model->query($sql_select);

      $alarmconfig_atpid = [];
      foreach ($Result as $k => $v) {
        array_push($alarmconfig_atpid, $v['almc_atpid']);
        $v['value_param'] = '';
      }
      $ModelParam = M();
        $sql_selectparam= "
				select
					*
				from szny_alarmparam t
				left join szny_devicemodelparam t1 on t.almp_paramid = t1.dmp_atpid
				where t.almp_atpstatus is null and t1.dmp_atpstatus is null
				and t.almp_alarmid in ('".implode("','",$alarmconfig_atpid)."')
				order by t1.dmp_atpcreatedatetime asc  ";
        $Result_rel = $ModelParam->query($sql_selectparam);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['almc_atpid'] == $rmv['almp_alarmid']) {
                    if ($v['value_param'] != '') {
                        $v['value_param'] = $v['value_param'] . "<br/>" . $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    } else {
                        $v['value_param'] = $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    }
                }
            }
        }
      $this->assign('Alarm_data',$Result);
    }

      public function selectdevice()
    {
      $Model = M();
      $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
      $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
      $snname = ((I('get.snname')) == null) ? "" : I('get.snname');

        $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);
      foreach ($res as $key => $value) {
        $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
      }
      $rgn_atpidlist = implode(',', $trgn_atpid);
      $queryparam = json_decode(file_get_contents("php://input"), true);
      $sql_select = "
                select
                  t3.*,count(t.alm_atpid) alm_count
                from szny_alarm t
                left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
                where t.alm_atpstatus is null and t1.dev_atpstatus is null
                and  t2.emp_atpstatus is null and t3.rgn_atpstatus is null
                and  t.alm_confirmstatus = '待确认'
				";

      $sql_select .= "and  t3.rgn_atpid in (" . $rgn_atpidlist . ")";
      $sql_select .= " group by t3.rgn_atpid";
      $sql_select .= " order by t3.rgn_name asc";
      $Result = $Model->query($sql_select);
      $this->assign('devicealarm',$Result);
      $this->display();
    }

      public function getAlarmdata_detail($rgn_atpid,$regiontype,$snname,$dev_atpid,$type)
    {
      $Model = M();
        $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid,$snname);
      foreach ($res as $key => $value) {
        $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
      }
      $rgn_atpidlist = implode(',', $trgn_atpid);
      $sql_select = "
				select
					*
				from szny_alarm t
				left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
				left join szny_emp t2 on t.alm_empid = t2.emp_atpid
				left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
        left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
				";
      $sql_select.=" where t.alm_atpstatus is null";
      $sql_select.=" and  t1.dev_atpstatus is null";
      $sql_select.=" and t2.emp_atpstatus is null";
      $sql_select.=" and  t3.rgn_atpstatus is null";
      if($type=='待确认')
      {
        $sql_select.=" and  t.alm_confirmstatus = '待确认'";
      }

      if($dev_atpid!=null)
      {
        $sql_select.=" and t3.rgn_atpid = '{$dev_atpid}'";
      }else
      {
        $sql_select.=" and t3.rgn_atpid in (" . $rgn_atpidlist . ")";
      }

      $sql_select .=" order by t.alm_datetime asc";

      $Result = $Model->query($sql_select);
      $alarmconfig_atpid = [];
      foreach ($Result as $k => $v) {
        array_push($alarmconfig_atpid, $v['almc_atpid']);
        $v['value_param'] = '';
      }
      $ModelParam = M();
      $sql_selectparam = "
               select
                   *
               from szny_alarmparam t
               left join szny_param t1 on t.almp_paramid = t1.p_atpid
               where t.almp_atpstatus is null and t1.p_atpstatus is null and t.almp_alarmid in ('" . implode("','", $alarmconfig_atpid) . "')";
      $Result_rel = $ModelParam->query($sql_selectparam);
      foreach ($Result as $k => &$v) {
        foreach ($Result_rel as $rmk => $rmv) {
          if ($v['almc_atpid'] == $rmv['almp_alarmid']) {
            if ($v['value_param'] != '') {
              $v['value_param'] = $v['value_param'] . "<br/>" . $rmv['p_name'] . ":下限" . $rmv['almp_floor'] . "---上限" . $rmv['almp_upper'];
            } else {
              $v['value_param'] = $rmv['p_name'] . ":下限" . $rmv['almp_floor'] . "---上限" . $rmv['almp_upper'];
            }
          }
        }
      }
     $this->assign("AlarmData",$Result);
    }

      public function deal(){
      $this->display();
      $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【待确认报警】");
    }

      public function dealsubmit(){
      $Model = M('alarm');
      $data = $Model->create();
      $data['alm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
      $data['alm_atplastmodifyuser'] = session('emp_account');
      $data['alm_empid'] = session('emp_atpid');
      $data['alm_confirmstatus'] = "已确认";
      $data['alm_confirmdate'] = date('Y-m-d H:i:s', time());
      $Model->where("alm_atpid='%s'", array($data['alm_atpid']))->save($data);
    }

      public function ignore(){
      $this->display();
    }

      public function ignoresubmit(){
      $Model = M('alarm');
      $data = $Model->create();
      $data['deve_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
      $data['deve_atplastmodifyuser'] = session('emp_account');
      $data['alm_empid'] = session('emp_atpid');
      $data['alm_confirmstatus'] = "已忽略";
      $data['alm_confirmdate'] = date('Y-m-d H:i:s', time());
      $Model->where("alm_atpid='%s'", array($data['alm_atpid']))->save($data);
    }


  public function get_region_device_alarm($rgn_atpid,$regiontype,$snname,$type)
  {
    $data = [];
    $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);
    foreach ($res as $key => $value) {
      $date[] = "'" . $value['rgn_atpid'] . "'";
    }
    $endrgn_atpidsstrings = implode(',', $date);
    $Model = M();
    $sql_select = "
                 select
                  t3.*,count(t.alm_atpid) alm_count
                from szny_alarm t
                left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
                ";

    $sql_select .= " where t.alm_atpstatus is null";
    $sql_select .= " and  t1.dev_atpstatus is null";
    $sql_select .= " and  t2.emp_atpstatus is null";
    $sql_select .= " and  t3.rgn_atpstatus is null";
    if($type=='待确认')
    {
      $sql_select .= " and t.alm_confirmstatus = '待确认'";
    }

    if($type=='待接单')
    {
      $sql_select .= " and t.alm_confirmstatus = '待确认'";
    }
    $sql_select .= " and t3.rgn_atpid in (" . $endrgn_atpidsstrings . ")";
    $sql_select .= " group by t3.rgn_atpid";
    $sql_select .= " order by t3.rgn_name asc";
    $Result = $Model->query($sql_select);
    $this->assign('DeviceInfo', $Result);
  }
}