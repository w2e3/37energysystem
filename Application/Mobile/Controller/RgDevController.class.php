<?php
namespace Mobile\Controller;
use Think\Controller;
class RgDevController extends BaseController
{
  public  function index()
  {
    //获得园区节点
    $rgn_atpid=I('get.rgn_atpid','');
    $regiontype=I('get.regiontype','');
    $snname=I('get.snname','');
    $pre_rgn_atpid=I('get.pre_rgn_atpid','');

    //获得园区节点的select_option
    $Rgn_data=$this->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
    $this->get_device_info($rgn_atpid,$regiontype,$snname,null);
    $this->assign('rgn_atpid',$rgn_atpid);
    $this->display('index');
  }


  public function detail()
  {

    //获得园区节点
    $rgn_atpid=I('get.rgn_atpid','');
    $regiontype=I('get.regiontype','');
    $snname=I('get.snname','');
    $pre_rgn_atpid=I('get.pre_rgn_atpid','');
    $dev_atpid=I('get.dev_atpid','');

    //获得园区节点的select_option
    $Rgn_data=$this->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
    $this->get_device_info($rgn_atpid,$regiontype,$snname,$dev_atpid);
    $this->assign('rgn_atpid',$rgn_atpid);
    $this->display('detail');
  }
  public function get_region_list($rgn_atpid,$regiontype,$snname)
  {
    $rgn_arr=array();
    if(($regiontype==null)||($regiontype=='rg'))
    {
      $garden_arr=M('region')->where("rgn_atpstatus is null and rgn_category='园区'")->order("rgn_name asc")->find();
      array_push($rgn_arr,$garden_arr);
      $floor_arr=M('region')->where("rgn_atpstatus is null and rgn_category='楼'")->order("rgn_name asc")->select();
      foreach ($floor_arr as $k=>$v)
      {
        array_push($rgn_arr,$v);
        $layer_arr=array();
        $layer_arr=M('region')->where("rgn_atpstatus is null and rgn_category='层' and rgn_pregionid='%s'",array($v['rgn_atpid']))->order("rgn_name asc")->select();
        foreach ($layer_arr as $k1=>$v1)
        {

          array_push($rgn_arr,$v1);
        }
      }
    }
    elseif ($regiontype=='sn')
    {
      $dev_arr=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
      if(count($dev_arr)>0)
      {
        foreach ($dev_arr as $k=>$v)
        {
          $temp=M('region')->where("rgn_atpstatus is null and rgn_atpid='%s'",array($v['rgn_atpid']))->find();
          array_push($rgn_arr,$temp);
        }
      }
    }

    $this->assign('rgn_atpid',$rgn_atpid);
    $this->assign('rgn_arr',$rgn_arr);
  }

  //获取节点树的数组
  public function get_region_list_child($rgn_atpid,$regiontype,$snname)
  {
    $rgn_arr=array();
    $rgn_data=array();
    if(($regiontype==null)||($regiontype=='rg'))
    {
      $rgn_data=M('region')->where("rgn_atpstatus is null and rgn_atpid='%s'",array($rgn_atpid))->find();
      if($rgn_data['rgn_category']=='园区')
      {
        array_push($rgn_arr,$rgn_data);
        $floor_arr=M('region')->where("rgn_atpstatus is null and rgn_category='楼'")->order("rgn_name asc")->select();
        foreach ($floor_arr as $k=>$v)
        {
          array_push($rgn_arr,$v);
          $layer_arr=array();
          $layer_arr=M('region')->where("rgn_atpstatus is null and rgn_category='层' and rgn_pregionid='%s'",array($v['rgn_atpid']))->order("rgn_name asc")->select();
          foreach ($layer_arr as $k1=>$v1)
          {
            array_push($rgn_arr,$v1);
          }
        }
      }
      elseif($rgn_data['rgn_category']=='楼')
      {
        $layer_arr=M('region')->where("rgn_atpstatus is null and rgn_category='层' and rgn_pregionid='%s'",array($rgn_data['rgn_atpid']))->order("rgn_name asc")->select();
        foreach ($layer_arr as $k=>$v)
        {
          array_push($rgn_arr,$v);
        }
      }elseif($rgn_data['rgn_category']=='层')
      {
        array_push($rgn_arr,$rgn_data);
      }
    }
    elseif ($regiontype=='sn')
    {
      $dev_arr=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);

      if(count($dev_arr)>0)
      {
        foreach ($dev_arr as $k=>$v)
        {
          $temp=M('region')->where("rgn_atpstatus is null and rgn_atpid='%s'",array($v['rgn_atpid']))->find();
          array_push($rgn_arr,$temp);
        }
      }
    }
    $this->assign('rgn_data',$rgn_data);
    $this->assign('rgn_arr',$rgn_arr);
  }

  public function get_region_dev($rgn_atpid,$regiontype,$snname)
  {
    $data=[];
    $res=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
    foreach ($res as $key => $value)
    {
      $date[] = "'" . $value['rgn_atpid'] . "'";
    }
    $endrgn_atpidsstrings = implode(',', $date);
    $Model = M();
    $sql_select = "
                select
                    *
                from szny_device t 
                join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                join szny_devicemodel t2 on t.dev_devicemodelid = t2.dm_atpid
                ";

    $sql_select.=" where t.dev_atpstatus is null";
    $sql_select.="  and  t1.rgn_atpstatus is null";
    $sql_select.="  and t2.dm_atpstatus is null";
    $sql_select.="  and t1.rgn_atpid in (".$endrgn_atpidsstrings.")";
    $Result=$Model->query($sql_select);
    $this->assign('DeviceInfo',$Result);
  }

    //获取综合信息的数据
    public function get_device_info($rgn_atpid,$regiontype,$snname,$dev_atpid)
    {
      $res=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
      foreach ($res as $key => $value)
      {
        $date[] = "'" . $value['rgn_atpid'] . "'";
      }
      $endrgn_atpidsstrings = implode(',', $date);

      $Model = M();
      $sql_select = "
                select
                    *
                from szny_device t 
                join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                join szny_devicemodel t2 on t.dev_devicemodelid = t2.dm_atpid
                ";

      $sql_select .=" where t.dev_atpstatus is null";
      $sql_select .=" and t.dev_atpstatus is null";
      $sql_select .=" and t1.rgn_atpstatus is null";
      $sql_select .=" and t1.rgn_atpstatus is null";
      if($dev_atpid!=null)
      {
        $sql_select .=" and t.dev_atpid='{$dev_atpid}'";
      }
      $sql_select .=" and t1.rgn_atpid in ($endrgn_atpidsstrings)";
      $sql_select .=" order by t1.rgn_name asc";
      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v){
        //查找楼设备点所在的层
        $pregionid =$Model->query("select rgn_pregionid from szny_region where rgn_atpid='".$v['rgn_pregionid']."'");
        $Result[$k]['pregionid']=$pregionid[0]['rgn_pregionid'];
        $dev_atpid = $v['dev_atpid'];
        $Model = M('repairdetail');
        $select_is_one = "
            select 
            count(1) c 
            from szny_repairdetail t 
            left join szny_device t1 on t.rd_deviceid = t1.dev_atpid 
            where t.rd_atpstatus is null and t1.dev_atpstatus is null and t1.dev_status = '启用' and t1.dev_atpid = '$dev_atpid'
            ";
        $Result_is_one = $Model->query($select_is_one);
        $v['c'] = $Result_is_one[0]['c'];
      }
      foreach ($Result as $key => &$value) {
        $Result[$key]['rgn_path'] = substr($Result[$key]['rgn_name'],9,2).'号楼'.substr($Result[$key]['rgn_name'],12,2).'层';
        if(substr($Result[$key]['rgn_name'],9,2) == 'CD'){
          $Result[$key]['rgn_path'] = 'CD座之间连廊'.substr($Result[$key]['rgn_name'],12,2).'层';
        }
        if(substr($Result[$key]['rgn_name'],9,2) == 'FF'){
          $Result[$key]['rgn_path'] = 'EF座之间连廊'.substr($Result[$key]['rgn_name'],12,2).'层';
        }
      }
      $this->assign('DeviceInfo',$Result);
    }
}