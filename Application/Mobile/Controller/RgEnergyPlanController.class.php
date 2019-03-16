<?php
namespace Mobile\Controller;
use Think\Controller;
class RgEnergyPlanController extends BaseController
{
  public function index()
  {
    //获得所有子节点
    $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
    $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
    $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
    $snname = ((I('get.snname')) == null) ? "" : I('get.snname');
    $ep_atpid = ((I('get.ep_atpid')) == null) ? "" : I('get.ep_atpid');

    $RgDev=new RgDevController();
    $RgDev->get_region_list_child($rgn_atpid,$regiontype,$snname);
    $this->getallEnergy($rgn_atpid,$regiontype,$snname);
    $this->display('list');
  }

  public function getallEnergy($rgn_atpid,$regiontype,$snname)
  {

    //显示该位置点下的所有能源计划
    $Model = M();
    $res = $this->getRegionDevicePoint($regiontype, $rgn_atpid, $snname);
    foreach ($res as $key => $value)
    {
      $date[] = "'" . $value['rgn_atpid'] . "'";
    }
    $endrgn_atpidsstrings = implode(',', $date);
    $Model = M();
    $sql_select = "
            select 
            * 
            from szny_energyplan t 
            left join szny_region t1 on t.ep_regionid = t1.rgn_atpid
            ";
    $sql_select.=" where t.ep_atpstatus is null";
    $sql_select.=" and t1.rgn_atpstatus is null";
    $sql_select.=" and t1.rgn_atpid in (".$endrgn_atpidsstrings.")";

    $Result = $Model->query($sql_select);
    foreach($Result as $k => &$v){
      $ep_atpid = $v['ep_atpid'];
      $Model = M();
      $select_is_one ="select count(*) c from szny_energyplandetail t where t.epd_atpstatus is null and t.epd_energyplanid = '{$ep_atpid}'";
      $Result_is_one = $Model->query($select_is_one);
      $v['c'] = $Result_is_one[0]['c'];
    }
    $this->assign("EnergyPlanData",$Result);
  }

  public function detail()
  {
    $ep_atpid=I("get.ep_atpid");
    $this->getEnergyPlanInfo($ep_atpid);
    $this->display('detail');
  }


  public function getEnergyPlanInfo($ep_atpid){

    $Model = M();
    $sql_select = "
          select 
          * 
          from szny_energyplandetail t
          left join szny_energyplan t1
          on t.epd_energyplanid = t1.ep_atpid
          ";
    $sql_select.=" where t.epd_atpstatus is null";
    $sql_select.=" and t.epd_energyplanid = '{$ep_atpid}'";
    $sql_select.=" order by t.epd_startdatetime asc";
    $Result = $Model->query($sql_select);
    $this->assign("EnergyPlanInfo",$Result);
  }

  public function add()
  {
    $$rgn_atpid=I('get.$rgn_atpid',null);
    $this->getRegion($rgn_atpid);
    $this->display();
  }

  public function getRegion($rgn_atpid){
    if ($rgn_atpid){
      $res = $this->regionrecursive_orderbyrgn_name($rgn_atpid);
    }else{
      $Model = M();
      $sql = "select rgn_atpid from szny_region where rgn_category = '园区'";
      $result = $Model->query($sql);
      $res = $this->regionrecursive_orderbyrgn_name($result[0]['rgn_atpid']);
    }
    $this->assign('region',$res);
  }

  public function submit(){

    $rgn_atpid=I("get.rgn_atpid",null);
    $regiontype=I("get.regiontype",null);
    $snname=I("get.snname",null);
    $ep_name = I('post.ep_name','');
    $ep_category = I('post.ep_category','');
    $ep_startdatetime = I('post.ep_startdatetime','');
    $ep_enddatetime = I('post.ep_enddatetime','');
    $ep_regionid = I('post.ep_regionid','');
    $ep_atpid = I('post.ep_atpid','');
    $Model_energyplan = M('energyplan');
    $Model_statrel = M('statrel');
    if('' == $ep_atpid || null == $ep_atpid){
      $Model_energyplan ->startTrans();//启动事务
      $data['ep_atpid'] = $this->makeGuid();
      $data['ep_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
      $data['ep_atpcreateuser'] = session('emp_account');
      $data['ep_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
      $data['ep_atplastmodifyuser'] = session('emp_account');
      $data['ep_name'] = $ep_name;
      $data['ep_category'] = $ep_category;
      $data['ep_startdatetime'] = $ep_startdatetime;
      $data['ep_enddatetime'] = $ep_enddatetime;
      $data['ep_regionid'] = $ep_regionid;
      //添加
      $Result = $Model_energyplan->add($data);
      if(!$Result){
        $Model_energyplan->rollback();
      }
      /*****************************************/
      $data_sr['sr_atpid'] = $this->makeGuid();
      $data_sr['sr_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
      $data_sr['sr_atpcreateuser'] = session('emp_account');
      $data_sr['sr_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
      $data_sr['sr_atplastmodifyuser'] = session('emp_account');
      $data_sr['sr_energyplanid'] =  $data['ep_atpid'];
      $data_sr['sr_regionid'] = $ep_regionid;
      $resu = $Model_statrel->add($data_sr);
      if(!$resu){
        $Model_energyplan->rollback();
      }
      $Model_energyplan->commit();
      $url="index?rgn_atpid={$rgn_atpid}&regiontype={$regiontype}&sname={$snname}";
      $this->success('添加成功',$url);
    }else{
      $data['ep_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
      $data['ep_atplastmodifyuser'] = session('emp_account');
      $data['ep_name'] = $ep_name;
      $data['ep_category'] = $ep_category;
      $data['ep_startdatetime'] = $ep_startdatetime;
      $data['ep_enddatetime'] = $ep_enddatetime;
      $data['ep_regionid'] = $ep_regionid;
      $Model_energyplan->where("ep_atpid='%s'", array($ep_atpid))->save($data);

      $url="detail?rgn_atpid={$rgn_atpid}&regiontype={$regiontype}&sname={$snname}";
      $this->success('添加成功',$url);
    }
  }

  public function addetail(){
    $energyplanid = I('get.epd_atpid','');
    $Model = M();
    $sql_select = "select * from szny_energyplandetail where epd_atpid = " ."'" .$energyplanid. "'";
    $data = $Model->query($sql_select);
    $this->ajaxReturn($data[0]);
    $this->display();
  }
}