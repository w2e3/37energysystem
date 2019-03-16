<?php
namespace Mobile\Controller;
use Think\Controller;
class RgGeneralController extends BaseAuthController
{
  public function index()
  {
//      获取园区节点
    $rgn_atpid = I('get.rgn_atpid', null);
    $regiontype = I('get.regiontype', null);
    $snname = I('get.snname', null);
    $this->get_sdql($rgn_atpid, $regiontype, $snname);
    $this->func_alarminfo($rgn_atpid, $regiontype, $snname,null);
//   $this->func_energytrend($rgn_atpid, 'rg', null);
    $this->display('index');
  }

  public function getweekdays($time)
  {
    $week_arr = [];
    $now_datetime = strtotime();
    $day_6_forward = date('Y-m-d', strtotime("$time - 6 days"));
    $day_time = $day_6_forward;
    while (strtotime($day_time) <= strtotime($time)) {
      array_push($week_arr, $day_time);
      $day_time = date("Y-m-d", strtotime("$day_time + 1 days"));
    }
    return $week_arr;
  }

  public function get_sdql($rgn_atpid, $regiontype, $snname)
  {
    //如果传入的参数的值为null，则查询整个园区的水电信息
    //否则查询楼层的水电信息值
    //查询在此之前七天内的信息
    //一周的总用水量，用电量，用暖量
    $total_ysl = [];
    $total_ydl = [];
    $total_yll = [];
    $total_ynl = [];
    $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);

    foreach ($res as $key => $value) {
      $date[] = "" . $value['rgn_atpid'] . "";
    }

    $endrgn_atpidsstrings = implode(',', $date);
    $titname = $res[0]['rgn_name'];
    $day = date('Y-m-d', time());
    $month = date('Y-m', time());
    $year = date('Y', time());
    $dayc = date('d', time());
    $where['d2d_regionid'] = ['in', $endrgn_atpidsstrings];
    $where1['d2m_regionid'] = ['in', $endrgn_atpidsstrings];
    $where2['d2y_regionid'] = ['in', $endrgn_atpidsstrings];
    $where['d2d_dt'] = $day;
    $where1['d2m_dt'] = $month;
    $where2['d2y_dt'] = $year;

    //数据查询
    $Result['dgl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_dglaccu");
    $Result['ysl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_syslaccu");
    $Result['ynl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_ynlaccu");
    $Result['yll'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_yllaccu");
    $Result['m_dgl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_dglaccu");
    $Result['m_ysl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_syslaccu");
    $Result['m_ynl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_ynlaccu");
    $Result['m_yll'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_yllaccu");
    $Result['y_dgl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_dglaccu");
    $Result['y_ysl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_syslaccu");
    $Result['y_ynl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_ynlaccu");
    $Result['y_yll'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_yllaccu");

    //格式化
    $Result['c_ysl'] = $Result['m_ysl'];
    $Result['ysl'] = number_format($Result['ysl'], 1);
    $Result['m_ysl'] = number_format($Result['m_ysl'], 1);
    $Result['y_ysl'] = number_format($Result['y_ysl'], 1);

    $Result['c_dgl'] = $Result['m_dgl'];
    $Result['dgl'] = number_format($Result['dgl'], 1);
    $Result['m_dgl'] = number_format($Result['m_dgl'], 1);
    $Result['y_dgl'] = number_format($Result['y_dgl'], 1);

    $Result['c_ynl'] = $Result['m_ynl'];
    $Result['ynl'] = number_format($Result['ynl'], 1);
    $Result['m_ynl'] = number_format($Result['m_ynl'], 1);
    $Result['y_ynl'] = number_format($Result['y_ynl'], 1);

    $Result['c_yll'] = $Result['m_yll'];
    $Result['yll'] = number_format($Result['yll'], 1);
    $Result['m_yll'] = number_format($Result['m_yll'], 1);
    $Result['y_yll'] = number_format($Result['y_yll'], 1);


    //查询当月的能源计划
    $month = date('Y-m', time());
    $month_start_time = date('Y-m', time()) . '-01';
    $month_days = getDaysByMonth(strtotime($month_start_time));
    $month_end_time = date('Y-m', time()) . '-' . $month_days;

    //查询在这段时间的能源计划值
    $day_sum = cal_totaldays($month_start_time, $month_end_time);

    $rgn_atpid = I("get.rgn_atpid", "");
    $month_enery_data = $this->getmonthEnergyPlan($month_start_time, $month_end_time, $rgn_atpid);
    $Result['c_dgl_plan'] = $month_enery_data['total_ydl'] > 0 ? $month_enery_data['total_ydl'] : 200000;
    $Result['c_ysl_plan'] = $month_enery_data['total_ysl'] > 0 ? $month_enery_data['total_ysl'] : 200000;
    $Result['c_yll_plan'] = $month_enery_data['total_yll'] > 0 ? $month_enery_data['total_yll'] : 200000;
    $Result['c_ynl_plan'] = $month_enery_data['total_ynl'] > 0 ? $month_enery_data['total_ynl'] : 200000;

    $this->assign('Result', $Result);
  }

  //获得能源计划在这段时间的值
  public function getmonthEnergyPlan($start_time, $end_time, $rgn_atpid)
  {
    $total_ydl = 0;
    $total_ysl = 0;
    $total_yll = 0;
    $total_ynl = 0;
    $in_monthdays = 0;
    $energyplan_arr = M('energyplan')
      ->where("ep_atpstatus is null and ep_regionid='%s'", [$rgn_atpid])->select();
    if (count($energyplan_arr) > 0) {
      foreach ($energyplan_arr as $k => $v) {
        $month_plan_arr = $this->getmonthplandays($v, $start_time, $end_time);
        if ($month_plan_arr['toal_days'] > 0) {
          //水电能源计划值
          $ydl_plan_data = M('energyplandetail')
            ->where("epd_atpstatus is null and epd_category='电' and epd_energyplanid='%s'", [$v['ep_atpid']])
            ->find();
          $ysl_plan_data = M('energyplandetail')
            ->where("epd_atpstatus is null and epd_category='水' and epd_energyplanid='%s'", [$v['ep_atpid']])
            ->find();
          $yll_plan_data = M('energyplandetail')
            ->where("epd_atpstatus is null and epd_category='冷' and epd_energyplanid='%s'", [$v['ep_atpid']])
            ->find();
          $ynl_plan_data = M('energyplandetail')
            ->where("epd_atpstatus is null and epd_category='暖' and epd_energyplanid='%s'", [$v['ep_atpid']])
            ->find();
          if ($month_plan_arr['energy_total_days'] > 0) {
            $total_ydl += $ydl_plan_data['epd_requiredvalue'] / $month_plan_arr['energy_total_days'] * $month_plan_arr['toal_days'];
            $total_ysl += $ysl_plan_data['epd_requiredvalue'] / $month_plan_arr['energy_total_days'] * $month_plan_arr['toal_days'];
            $total_yll += $yll_plan_data['epd_requiredvalue'] / $month_plan_arr['energy_total_days'] * $month_plan_arr['toal_days'];
            $total_ynl += $ynl_plan_data['epd_requiredvalue'] / $month_plan_arr['energy_total_days'] * $month_plan_arr['toal_days'];
          }
        }
      }
    }
    return ['total_ydl' => intval($total_ydl), 'total_ysl' => intval($total_ysl), 'total_yll' => intval($total_yll), 'total_ynl' => intval($total_ynl)];
  }

  //获得能源计划这段时间的天数
  public function getmonthplandays($data, $start_time, $end_time)
  {
    $toal_days = 0;
    $energy_total_days = 0;
    $energy_total_days = cal_totaldays($data['ep_startdatetime'], $data['ep_enddatetime']);

    if ((strtotime($data['ep_startdatetime']) >= strtotime($start_time)) && (strtotime($data['ep_enddatetime']) <= strtotime($end_time))) {
      $toal_days = cal_totaldays($data['ep_startdatetime'], $data['ep_enddatetime']);
    } elseif ((strtotime($data['ep_startdatetime']) <= strtotime($start_time)) && (strtotime($data['ep_enddatetime']) >= strtotime($end_time))) {
      $toal_days = cal_totaldays($start_time, $end_time);
    } elseif ((strtotime($data['ep_startdatetime']) >= strtotime($start_time)) && (strtotime($data['ep_enddatetime']) >= strtotime($end_time))) {
      $toal_days = cal_totaldays($data['ep_startdatetime'], $end_time);
    } elseif ((strtotime($data['ep_startdatetime']) <= strtotime($start_time)) && (strtotime($data['ep_enddatetime']) <= strtotime($end_time))) {
      $toal_days = cal_totaldays($start_time, $data['ep_enddatetime']);
    }

    return ['toal_days' => $toal_days, 'energy_total_days' => $energy_total_days];
  }

  //报警信息
  public function func_alarminfo($rgn_atpid, $regiontype, $snname,$alm_atpid)
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
//    $Result=array();
    $this->assign('Alarm_data',$Result);
    $this->display();
  }

  //最近7天能源趋势图
  public function func_energytrend()
  {

    $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
    $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
    $snname = ((I('get.snname')) == null) ? "" : I('get.snname');

    $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);

    foreach ($res as $key => $value) {
      $date[] = "" . $value['rgn_atpid'] . "";
    }
    $endrgn_atpidsstrings = implode(',', $date);

    $day7_arr=$this->getweekdays(date("Y-m-d"));

    $strtime = date("Y-m-d", time());
    $endtime = date("Y-m-d", strtotime("-30 day"));

    $where7day['d2d_regionid'] = ['in', $endrgn_atpidsstrings];
    $where7day['d2d_dt'] = ['between', "$day7_arr[0],$day7_arr[6]"];


    $mod = M("data2day")
      ->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll,d2d_dt")
      ->where($where7day)
      ->group("d2d_dt")
      ->order("d2d_dt desc")->select();


    //最近7天的用水量，用电量，用冷量，用暖量
    $ysl_arr_7=array();
    $ydl_arr_7=array();
    $ynl_arr_7=array();
    $yll_arr_7=array();

    foreach ($mod as $k=>$v)
    {
      foreach ($day7_arr as $k1=>$v1)
      {
        if($v['d2d_dt']==$v1)
        {
          array_push($ysl_arr_7,$v['ysl']);
          array_push($ydl_arr_7,$v['ydl']);
          array_push($ynl_arr_7,$v['yll']);
          array_push($yll_arr_7,$v['ynl']);
        }
      }
    }

    foreach ($day7_arr as $k=>$v)
    {
      $day7_arr[$k]=substr($v,5);
    }

    //判断最近所在位置点的表信息
    $is_ysl = false;
    $is_ydl = false;
    $is_yll = false;
    $is_ynl = false;
    $is_active = null;
    $dev_arr = [];
    foreach ($res as $k => $v) {
      $dev_category = M('device')
        ->where("dev_atpstatus is null and dev_atpid='%s'", [$v['rgn_deviceid']])
        ->getField('dev_name');
      if ($dev_category == '电表') {
        if (!in_array('电表', $dev_arr)) {
          $dev_arr[] = '电表';
        }
      } elseif ($dev_category == '水表') {
        if (!in_array('水表', $dev_arr)) {

          $dev_arr[] = '水表';
        }
      } elseif ($dev_category == '冷暖表') {
        if (!in_array('冷暖表', $dev_arr)) {
          $dev_arr[] = '冷暖表';
        }
      }
    }


    if (in_array('电表', $dev_arr)) {
      $is_ydl = true;
    }
    if (in_array('水表', $dev_arr)) {
      $is_ysl = true;
    }
    if (in_array('冷暖表', $dev_arr)) {
      $is_ynl = true;
      $is_yll = true;
    }


    if (($is_ysl) && ($is_active == null)) {
      $is_active = 'ysl';
    }
    if (($is_ydl) && ($is_active == null)) {
      $is_active = 'ydl';
    }
    if (($is_ynl) && ($is_active == null)) {
      $is_active = 'ynl';
    }
    if (($is_yll) && ($is_active == null)) {
      $is_active = 'yll';
    }

    $this->assign('ysl_arr_7',json_encode($ysl_arr_7));
    $this->assign('ydl_arr_7',json_encode($ydl_arr_7));
    $this->assign('ynl_arr_7',json_encode($ynl_arr_7));
    $this->assign('yll_arr_7',json_encode($yll_arr_7));
    $this->assign('day7_arr',json_encode($day7_arr));

//    $this->assign("day30", $day30);

    $this->assign('is_ysl', $is_ysl);
    $this->assign('is_ydl', $is_ydl);
    $this->assign('is_yll', $is_yll);
    $this->assign('is_ynl', $is_ynl);
    $this->assign('is_active', $is_active);

    $this->display();
  }

  public function alarmdetail()
  {
    $rgn_atpid = I('get.rgn_atpid', null);
    $regiontype = I('get.regiontype', null);
    $snname = I('get.snname', null);
    $pre_rgn_atpid = I('get.pre_rgn_atpid', null);
    $alm_atpid = I('get.alm_atpid', null);


    $RgDev=new RgDevController();
    $RgDev->get_region_list_child($rgn_atpid,$regiontype,$snname);
    $this->assign('rgn_atpid',$rgn_atpid);

    //取得报警信息
    $this->func_alarminfo($rgn_atpid, $regiontype, $snname,$alm_atpid);
  }
}