<?php

namespace Mobile\Controller;
use Think\Controller;
class ZhenyController extends BaseAuthController
{
  public function index()
  {
    $bs = I('get.bs', null);
    $this->getYzZhData($bs);
    $this->display();
  }

  //获取租户信息
  public function get_region_list($rgn_atpid, $regiontype, $snname)
  {
    $rgn_arr = [];

    if (($regiontype == null) || ($regiontype == 'rg')) {
      $garden_arr = M('region')->where("rgn_atpstatus is null and rgn_category='园区'")
                               ->order("rgn_name asc")->find();
      array_push($rgn_arr, $garden_arr);
      $floor_arr = M('region')->where("rgn_atpstatus is null and rgn_category='楼'")
                              ->order("rgn_name asc")->select();
      foreach ($floor_arr as $k => $v) {
        array_push($rgn_arr, $v);
        $layer_arr = [];
        $layer_arr = M('region')
          ->where("rgn_atpstatus is null and rgn_category='层' and rgn_pregionid='%s'", [$v['rgn_atpid']])
          ->order("rgn_name asc")->select();
        foreach ($layer_arr as $k1 => $v1) {
          array_push($rgn_arr, $v1);
        }
      }
    } elseif ($regiontype == 'sn') {
      $dev_arr = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);
      if (count($dev_arr) > 0) {
        foreach ($dev_arr as $k => $v) {
          $temp = M('region')->where("rgn_atpstatus is null and rgn_atpid='%s'", [$v['rgn_atpid']])
                             ->find();
          array_push($rgn_arr, $temp);
        }
      }

    }
    $this->assign('rgn_arr', $rgn_arr);
  }

//获取所有租户的能源信息
  public function getRegiondata($regiontype, $rgn_atpid, $snname, $bs, $type, $start, $end, $us_atpid)
  {
    $regionid = [];
    $Result = [];
    $Model = M('');
    $regionid=array();
    if ($bs == 'zh')
    {
      $where['us_category'] = '租户';
      $regionid = M('usersideregion')->field("usr_regionid")
                                     ->join("szny_userside on szny_userside.us_atpid = szny_usersideregion.usr_usersideid")
                                     ->where($where)->select();
    }
    elseif ($bs == 'yz')
    {
      $where['us_category'] = '业主';
      $regionid = M('usersideregion')->field("usr_regionid")
                                     ->join("szny_userside on szny_userside.us_atpid = szny_usersideregion.usr_usersideid")
                                     ->where($where)->select();
    }
    foreach ($regionid as $key => $value)
    {
      $date[] = "'" . $value['usr_regionid'] . "'";
    }
    $endrgn_atpidsstrings = implode(',', $date);

    if ($type == 'year') {
      $sql_select = "
               select
                   t3.us_atpid, t3.us_name,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t 
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2y_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";

      $sql_select .= "where t.d2y_atpstatus is null";
      $sql_select .= " and t2.usr_atpstatus is null";
      $sql_select .= " and t3.us_atpstatus is null";

      $sql_select .= " and t.d2y_dt between '{$start}' and '{$end}'";
      $sql_select .= " and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")";


      if ($us_atpid != null) {
        $sql_select .= " and t3.us_atpid='{$us_atpid}'";
      }
      if ($bs == 'yz') {
        $sql_select .= " and  t3.us_category  = '业主'";

      } elseif ($bs == 'zh') {
        $sql_select .= " and  t3.us_category  = '租户'";
      }

      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v) {
        $v['time'] = $start . '年 -- ' . $end . '年';
        if (null == $v['d2y_yllaccu'] || '' == $v['d2y_yllaccu']) {
          $v['yll'] = '0KW';
        } else {
          $v['yll'] = $v['d2y_yllaccu'] . 'KW';
        }
        if (null == $v['d2y_ynlaccu'] || '' == $v['d2y_ynlaccu']) {
          $v['ynl'] = '0KW';
        } else {
          $v['ynl'] = $v['d2y_ynlaccu'] . 'KW';
        }
        if (null == $v['d2y_syslaccu'] || '' == $v['d2y_syslaccu']) {
          $v['ysl'] = '0t';
        } else {
          $v['ysl'] = $v['d2y_syslaccu'] . 't';
        }
        if (null == $v['d2y_dglaccu'] || '' == $v['d2y_dglaccu']) {
          $v['dgl'] = '0KW';
        } else {
          $v['dgl'] = $v['d2y_dglaccu'] . 'KW';
        }
      }
    }
    elseif ($type == 'month')
    {
      $sql_select = "
                select
                t3.us_atpid, t3.us_name,t3.us_status,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2m_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";

      $sql_select .= "where t.d2m_atpstatus is null";
      $sql_select .= " and t2.usr_atpstatus is null";
      $sql_select .= " and t3.us_atpstatus is null";

      $sql_select .= " and t.d2m_dt between '{$start}' and '{$end}'";
      $sql_select .= " and t.d2m_regionid in ({$endrgn_atpidsstrings})";

      if ($bs == 'yz') {
        $sql_select .= " and  t3.us_category  = '业主'";

      } elseif ($bs == 'zh')
      {
        $sql_select .= " and  t3.us_category  = '租户'";
      }
      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v) {
        $v['time'] = $start . ' -- ' . $end;
        if (null == $v['d2m_yllaccu'] || '' == $v['d2m_yllaccu']) {
          $v['yll'] = '0KW';
        } else {
          $v['yll'] = $v['d2m_yllaccu'] . 'KW';
        }
        if (null == $v['d2m_ynlaccu'] || '' == $v['d2m_ynlaccu']) {
          $v['ynl'] = '0KW';
        } else {
          $v['ynl'] = $v['d2m_ynlaccu'] . 'KW';
        }
        if (null == $v['d2m_syslaccu'] || '' == $v['d2m_syslaccu']) {
          $v['dgl'] = '0t';
        } else {
          $v['dgl'] = $v['d2m_syslaccu'] . 't';
        }
        if (null == $v['d2m_dglaccu'] || '' == $v['d2m_dglaccu']) {
          $v['dgl'] = '0KW';
        } else {
          $v['dgl'] = $v['d2m_dglaccu'] . 'KW';
        }

      }
    }
    elseif ($type == 'day')
    {
      $sql_select = "
                select
                    t3.us_atpid,t3.us_name,t3.us_status,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2d_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";

      $sql_select .= "where t.d2d_atpstatus is null";
      $sql_select .= " and t2.usr_atpstatus is null";
      $sql_select .= " and t3.us_atpstatus is null";

      $sql_select .= " and t.d2d_dt between '{$start}' and '{$end}'";
      $sql_select .= " and t.d2d_regionid in ({$endrgn_atpidsstrings})";

      if ($bs == 'yz') {
        $sql_select .= " and  t3.us_category  = '业主'";

      } elseif ($bs == 'zh') {
        $sql_select .= " and  t3.us_category  = '租户'";
      }
      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v) {
        $v['time'] = $start . ' -- ' . $end;
        if (null == $v['d2d_yllaccu'] || '' == $v['d2d_yllaccu']) {
          $v['yll'] = '0KW';
        } else {
          $v['yll'] = $v['d2d_yllaccu'] . 'KW';
        }
        if (null == $v['d2d_ynlaccu'] || '' == $v['d2d_ynlaccu']) {
          $v['ynl'] = '0KW';
        } else {
          $v['ynl'] = $v['d2d_ynlaccu'] . 'KW';
        }
        if (null == $v['d2d_syslaccu'] || '' == $v['d2d_syslaccu']) {
          $v['ysl'] = '0t';
        } else {
          $v['ysl'] = $v['d2d_syslaccu'] . 't';
        }
        if (null == $v['d2d_dglaccu'] || '' == $v['d2d_dglaccu']) {
          $v['dgl'] = '0KW';
        } else {
          $v['dgl'] = $v['d2d_dglaccu'] . 'KW';
        }
      }
    }
    $this->assign('Result', $Result);
  }

  public function detail()
  {
    $rgn_atpid = I('get.rgn_atpid', null);
    $regiontype = I('get.regiontype', null);
    $snname = I('get.snname', null);
    $pre_rgn_atpid = I('get.pre_rgn_atpid', null);
    $bs = I('get.bs', null);
    $start_time = I('get.start_time', null);
    $end_time = I('get.end_time', null);
    $type = I('get.category', null);
    $category = I('get.category', null);
    $us_atpid = I('get.us_atpid', null);



    if ($category == null) {
      $category = 'year';
    }
    if ($start_time == null) {
      $start_time = date("Y");
      $start_time = intval($start_time);
      $end_time = intval($start_time);
    }

    $this->assign('category',$category);
    $this->assign('start_time',$start_time);
    $this->assign('end_time',$end_time);
    $this->getRegiondata($regiontype, $rgn_atpid, $snname, $bs, $category, $start_time, $end_time, $us_atpid);
    $this->display('detail');
  }

  //取得租户/业主的信息
  public function getYzZhData($bs){
    $Model = M('userside');
    $sql_select = "
                select
                    t.*
                from szny_userside t
                ";

    $sql_select.=" where t.us_atpstatus is null";
    if($bs == 'yz'){
      $sql_select.=" and t.us_category  = '业主'";
    }elseif($bs == 'zh'){
      $sql_select.=" and t.us_category  = '租户'";
    }
    $sql_select.=" order by t.us_name desc";
    $Result = $Model->query($sql_select);
    $this->assign('Data',$Result);
  }
}