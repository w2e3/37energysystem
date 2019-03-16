<?php
namespace Mobile\Controller;
use Think\Controller;
class RgItemAnalyzesController extends BaseAuthController
{
  public function index()
  {
    //获得所有子节点

    $rgn_atpid=I('get.rgn_atpid',null);
    $regiontype=I('get.regiontype',null);
    $snname=I('get.snname',null);
    $pre_rgn_atpid=I('get.pre_rgn_atpid',null);
    $category=I('get.category',null);

    //查询参数
    $category = ((I('get.category')) == null) ? "" : I('get.category');
    $start_time = ((I('get.start_time')) == null) ? "" : I('get.start_time');
    $end_time = ((I('get.end_time')) == null) ? "" : I('get.end_time');

    if(strlen($parameter)>0)
    {
      $parameter_arr=explode(',',$parameter);
    }
//    dump($rgn_atpid);
//    dump($pre_rgn_atpid);
//    dump($regiontype);
//    dump($category);
//    dump($end_time);
//    dump($start_time);
//    dump($parameter);
//    dump($parameter_arr);
   //默认显示日报表
   //默认当前天和前一天
   //默认统计显示全部值
    if(strlen($category)==0)
    {
      $category="day";
    }
    if(strlen($start_time)==0)
    {
      $start_time=date("Y-m-d");
      $start_time=date("Y-m-d",strtotime("$start_time -7 days"));
    }
    if(strlen($end_time)==0)
    {
      $end_time=date("Y-m-d");
    }
    $parameter_arr=array();
    if(strlen($parameter)==0)
    {
      $parameter="'电量值','用水量','用冷量','用暖量'";
//      dump($parameter);
      $parameter=explode(',',$parameter);
      foreach ($parameter as $k=>$v)
      {
//        $temp=M('param')->where("p_atpstatus is null and p_name='%s'",array($v))->getField('p_atpid');
        array_push($parameter_arr,$v);
      }
//      dump($parameter);
//      dump($parameter_arr);
    }
    $RgDev=new RgDevController();

    if(strlen($pre_rgn_atpid)==0)
    {
      $pre_rgn_atpid=$rgn_atpid;
    }
    if($regiontype=='sn')
    {
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
    }else
    {
      $RgDev->get_region_list_child($pre_rgn_atpid,$regiontype,$snname);
    }

    $this->assign('rgn_atpid',$rgn_atpid);
    $this->assign('category',$category);
    $this->assign('start_time',$start_time);
    $this->assign('end_time',$end_time);
    $this->getallEnergyAnalyze($rgn_atpid,$regiontype,$snname,$start_time,$end_time,$category,$parameter_arr);
    $this->display('index');
  }



  //计算分项报表
  public function getallEnergyAnalyze($rgn_atpid,$regiontype,$snname,$start,$end,$category,$param){
    $Model = M();
    if ($rgn_atpid){
      $res = $this->regionrecursive($rgn_atpid);
    }else{
      $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_category = '园区'";
      $result = $Model->query($sql);
      $res = $this->regionrecursive($result[0]['rgn_atpid']);
    }
    $date = [];
    foreach ($res as $key => $value)
    {
      $date[] = $value['rgn_atpid'];
    }

  $selectparam = implode(',',$param);

    $sql_select_region = "
       select 
        t.etr_regionid
        from szny_energytyperegion t 
        left join szny_energytype t1 on t.etr_energytypeid = t1.et_atpid
        left join szny_param t2 on t2.p_energytypeid = t1.et_atpid
        where t.etr_atpstatus is null and t1.et_atpstatus is null and t2.p_atpstatus is null
        and t2.p_name in ($selectparam)
        ";
    $Result_region = $Model ->query($sql_select_region);
    $select_region = [];
    foreach ($Result_region as $k => $v){
      array_push($select_region,$v['etr_regionid']);
    }
    $endrgn_atpidsarray = array_intersect($date,$select_region);
    $endrgn_atpidsstrings = "'". implode("','", $endrgn_atpidsarray)."'" ;

    $Result=array();
    if ('year' == $category) {
      $sql_select = "
                select
                    t1.rgn_name,t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";

      $sql_select.=" where  t.d2y_atpstatus is null";
      $sql_select.=" and  t1.rgn_atpstatus is null";
      $sql_select.=" and  t.d2y_dt between '{$start}' and '{$end}'";
      $sql_select.=" and t.d2y_regionid in ({$endrgn_atpidsstrings})";
      $sql_select.=" group by t.d2y_dt";
      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v)
      {
        $v['time'] = $v['d2y_dt'].'年';
        if (in_array('用冷量',$select_param_array)){
          if (null == $v['d2y_yllaccu'] || '' == $v['d2y_yllaccu']){
            $v['yll'] = '0KW';
          }else{
            $v['yll'] = $v['d2y_yllaccu'].'KW';
          }
        }
        if (in_array('用暖量',$select_param_array)){
          if (null == $v['d2y_ynlaccu'] || '' == $v['d2y_ynlaccu']){
            $v['ynl'] = '0KW';
          }else{
            $v['ynl'] = $v['d2y_ynlaccu'].'KW';
          }
        }
        if (in_array('用水量',$select_param_array)){
          if (null == $v['d2y_syslaccu'] || '' == $v['d2y_syslaccu']){
            $v['ysl'] = '0t';
          }else{
            $v['ysl'] = $v['d2y_syslaccu'].'t';
          }
        }
        if (in_array('电量值',$select_param_array)){
          if (null == $v['d2y_dglaccu'] || '' == $v['d2y_dglaccu']){
            $v['dgl'] = '0KW';
          }else{
            $v['dgl'] = $v['d2y_dglaccu'].'KW';
          }
        }
      }
    }
    else if ('month' == $category)
    {
      $Model = M();
      $sql_select = "
                 select
                    t1.rgn_name,t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";

      $sql_select.=" where  t.d2m_atpstatus is null";
      $sql_select.=" and  t1.rgn_atpstatus is null";
      $sql_select.=" and  t.d2m_dt between '{$start}' and '{$end}'";
      $sql_select.=" and t.d2m_regionid in ({$endrgn_atpidsstrings})";
      $sql_select.=" group by t.d2m_dt";
      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v) {
        $v['time'] = $v['d2m_dt'];
        if (in_array('用冷量',$select_param_array)){
          if (null == $v['d2m_yllaccu'] || '' == $v['d2m_yllaccu']){
            $v['yll'] = '0KW';
          }else{
            $v['yll'] = $v['d2m_yllaccu'].'KW';
          }
        }
        if (in_array('用暖量',$select_param_array)){
          if (null == $v['d2m_ynlaccu'] || '' == $v['d2m_ynlaccu']){
            $v['ynl'] = '0KW';
          }else{
            $v['ynl'] = $v['d2m_ynlaccu'].'KW';
          }
        }
        if (in_array('电量值',$select_param_array)){
          if (null == $v['d2m_dglaccu'] || '' == $v['d2m_dglaccu']){
            $v['dgl'] = '0KW';
          }else{
            $v['dgl'] = $v['d2m_dglaccu'].'KW';
          }
        }
        if (in_array('用水量',$select_param_array)){
          if (null == $v['d2m_syslaccu'] || '' == $v['d2m_syslaccu']){
            $v['dgl'] = '0t';
          }else{
            $v['dgl'] = $v['d2m_syslaccu'].'t';
          }
        }
      }
    }
    elseif('day' == $category)
    {
      $Model = M();
      $sql_select = "
                select
                    t1.rgn_name,t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";

      $sql_select.=" where  t.d2d_atpstatus is null";
      $sql_select.=" and  t1.rgn_atpstatus is null";
      $sql_select.=" and  t.d2d_dt between '{$start}' and '{$end}' ";
      $sql_select.=" and t.d2d_regionid in ($endrgn_atpidsstrings)";
      $sql_select .=" group by t.d2d_dt";

      $Result = $Model->query($sql_select);
      foreach ($Result as $k => &$v) {
        $v['time'] = $v['d2d_dt'];
        if (in_array('用冷量',$select_param_array)){
          if (null == $v['d2d_yllaccu'] || '' == $v['d2d_yllaccu']){
            $v['yll'] = '0KW';
          }else{
            $v['yll'] = $v['d2d_yllaccu'].'KW';
          }
        }
        if (in_array('用暖量',$select_param_array)){
          if (null == $v['d2d_ynlaccu'] || '' == $v['d2d_ynlaccu']){
            $v['ynl'] = '0KW';
          }else{
            $v['ynl'] = $v['d2d_ynlaccu'].'KW';
          }
        }
        if (in_array('电量值',$select_param_array)){
          if (null == $v['d2d_dglaccu'] || '' == $v['d2d_dglaccu']){
            $v['dgl'] = '0KW';
          }else{
            $v['dgl'] = $v['d2d_dglaccu'].'KW';
          }
        }
        if (in_array('用水量',$select_param_array)){
          if (null == $v['d2d_syslaccu'] || '' == $v['d2d_syslaccu']){
            $v['ysl'] = '0T';
          }else{
            $v['ysl'] = $v['d2d_syslaccu'].'T';
          }
        }
      }
    }
    $this->assign("RegionItemdata",$Result);
  }
}