<?php
namespace Mobile\Controller;
use Think\Controller;
class RgAnalyzesController extends BaseController
{
  public function index()
  {
    //获得所有子节点
    $rgn_atpid = (I('get.rgn_atpid') == null) ? "" : I('get.rgn_atpid');
    $pre_rgn_atpid = (I('get.pre_rgn_atpid') == null) ? "" : I('get.pre_rgn_atpid');
    $regiontype = (I('get.regiontype') == null) ? "" : I('get.regiontype');
    $snname = ((I('get.snname')) == null) ? "" : I('get.snname');

    //查询参数
    $category = ((I('get.category')) == null) ? "" : I('get.category');
    $start_time = ((I('get.start_time')) == null) ? "" : I('get.start_time');
    $end_time = ((I('get.end_time')) == null) ? "" : I('get.end_time');
    $parameter = ((I('get.parameter')) == null) ? "" : I('get.parameter');

    $parameter_arr=array();
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

    $parameter_arrs=array();
    $parameter_str="电量值,用水量,用冷量,用暖量";
    $parameter_arr=explode(',',$parameter_str);
//      dump($parameter_arr);
    foreach ($parameter_arr as $k=>$v)
    {
      $temp=M('param')->where("p_atpstatus is null and p_name='%s'",array($v))->find();

      array_push($parameter_arrs,$temp);
    }
    if(strlen($parameter)==0)
    {
      $parameter=M('param')->where("p_atpstatus is null and p_name='%s'",array('电量值'))->getField('p_atpid');
    }
    if(strlen($category)==0)
    {
      $category='day';
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

    $RgDev=new RgDevController();

//    dump($pre_rgn_atpid);

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

//      dump($parameter_arrs);
    $parameter_name=M('param')->where("p_atpstatus is null and p_atpid='%s'",array($parameter))->getField('p_name');
    $this->assign('rgn_id',$rgn_atpid);
    $this->assign('category',$category);
    $this->assign('start_time',$start_time);
    $this->assign('end_time',$end_time);
    $this->assign('parameter_arrs',$parameter_arrs);
    $this->assign('parameter',$parameter);
    $this->assign('parameter_name',$parameter_name);
    $this->getallEnergyAnalyze($rgn_atpid,$regiontype,$snname,$start_time,$end_time,$category,$parameter);
    $this->display('index');
  }


  public function getallEnergyAnalyze($rgn_atpid,$regiontype,$snname,$start,$end,$category,$parameter)
  {
//    var_dump($category);
//    var_dump($parameter);
    $values=null;
    $selectParam=$parameter;
//    var_dump($selectParam);
    $Model = M();
    $list = M('region')->where("rgn_atpid='$rgn_atpid'")->find();
    // dump($list);
    if($list['rgn_category']=='设备点'){
      $sql_select_child_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid = '$rgn_atpid'";
    }else{
      $sql_select_child_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_pregionid = '$rgn_atpid'";
    }

    $Result_select_child_region  = $Model->query($sql_select_child_region);
    $select_child_region_array = [];
    foreach ($Result_select_child_region as $rscrk => $rscrv){
      array_push($select_child_region_array,$rscrv['rgn_atpid']);
    }
    $select_child_region_strings = "'". implode("','",$select_child_region_array)."'";

    $Model_region = M('region');
    $sql_select = "
				select
					t.*
				from szny_region t
				";

    $sql_select .= " where t.rgn_atpstatus is null";
    $sql_select .= " and t.rgn_atpid in ({$select_child_region_strings})";

    $Result = $Model_region->query($sql_select);
    $Result_select_param = M('param')->where("p_atpid='%s'", array($selectParam))->find();
//    dump($Result_select_param);
    $select_param = $Result_select_param['p_name'];

    foreach ($Result as $k=>&$v){
      $res = $this->regionrecursive($v['rgn_atpid']);
      $date = [];
      foreach ($res as $key => $value) {
        $date[] = $value['rgn_atpid'];
      }
      $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
      $Model_sum = M();
      $sum = strlen($start);
      if ('year' == $category) {
        $current_time = $start . '-' . $end;
        $v['time'] = $current_time;
        $sql_select_sum_current_value = "
                select
                    sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt between '" . $start . "' and '" . $end . "' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
        $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
        $series_array = [];
        $series_array_data = [];
        foreach ($Result_sum_current_value as $sk => $sv) {
          if ('用水量' == $select_param) {
            $v['name'] = '用水量占比';
            $v['category'] = '用水量';
            if (null == $sv['d2y_syslaccu'] || '' == $sv['d2y_syslaccu']) {
//                            $v['ysl'] = '0KW';
              $v['ysl'] = '0T';
              $values = $v['ysl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
//                            $v['ysl'] = $sv['d2y_syslaccu'] . 'KW';
              $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
              $values = (int)$sv['d2d_syslaccu'].'T';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2y_syslaccu']);
            }
            $v['val'] = $values;
          }
          if ('电量值' == $select_param) {
            $v['name'] = '电量值占比';
            $v['category'] = '电量值';
            if (null == $sv['d2y_dglaccu'] || '' == $sv['d2y_dglaccu']) {
              $v['dgl'] = '0KW';
              $values = $v['dgl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['dgl'] = $sv['d2y_dglaccu'] . 'KW';
              $values=(int)$sv['d2y_dglaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2y_dglaccu']);
            }
            $v['val']=$value;
          }
          if ('用冷量' == $select_param) {
            $v['name'] = '用冷量占比';
            $v['category'] = '用冷量';
            if (null == $sv['d2y_yllaccu'] || '' == $sv['d2y_yllaccu']) {
              $v['yll'] = '0KW';
              $values = $v['yll'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['yll'] = $sv['d2y_yllaccu'] . 'KW';
              $values=(int)$sv['d2y_yllaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2y_yllaccu']);
            }
            $v['val']=$value;
          }
          if ('用暖量' == $select_param) {
            $v['name'] = '用暖量占比';
            $v['category'] = '用暖量';
            if (null == $sv['d2y_ynlaccu'] || '' == $sv['d2y_ynlaccu']) {
              $v['ynl'] = '0KW';
              $values = $v['ynl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['ynl'] = $sv['d2y_ynlaccu'] . 'KW';
              $values = (int)$sv['d2y_ynlaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2y_ynlaccu']);
            }
            $v['val']=$value;
          }
        }
        $series_array['data'] = $series_array_data;
        $v['series'] =$series_array;
        $v['type'] = 'pie';
      }
      elseif ('month' == $category)
      {
        $current_time = $start . '-' . $end;
        $v['time'] = $current_time;
        $sql_select_sum_current_value = "
                select
                    sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt between '" . $start . "' and '" . $end . "' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
        $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
        $series_array = [];
        $series_array_data = [];
        foreach ($Result_sum_current_value as $sk => $sv) {
          if ('用水量' == $select_param) {
            $v['name'] = '用水量占比';
            $v['category'] = '用水量';
            if (null == $sv['d2m_syslaccu'] || '' == $sv['d2m_syslaccu']) {
//                            $v['ysl'] = '0KW';
              $v['ysl'] = '0T';
              $values = $v['ysl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
              $values = (int)$sv['d2d_syslaccu'].'T';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2m_syslaccu']);
            }
            $v['val'] = $values;
          }
          if ('电量值' == $select_param) {
            $v['name'] = '电量值占比';
            $v['category'] = '电量值';
            if (null == $sv['d2m_dglaccu'] || '' == $sv['d2m_dglaccu']) {
              $v['dgl'] = '0KW';
              $values = $v['dgl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['dgl'] = $sv['d2m_dglaccu'] . 'KW';
              $values=(int)$sv['d2d_dglaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2m_dglaccu']);
            }
            $v['val']=$value;
          }
          if ('用冷量' == $select_param) {
            $v['name'] = '用冷量占比';
            $v['category'] = '用冷量';
            if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
              $v['yll'] = '0KW';
              $values = $v['yll'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['yll'] = $sv['d2m_yllaccu'] . 'KW';
              $values = (int)$sv['d2d_yllaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2m_yllaccu']);
            }
            $v['val']=$value;
          }
          if ('用暖量' == $select_param) {
            $v['name'] = '用暖量占比';
            $v['category'] = '用暖量';
            if (null == $sv['d2m_ynlaccu'] || '' == $sv['d2m_ynlaccu']) {
              $v['ynl'] = '0KW';
              $value=$v['ynl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['ynl'] = $sv['d2m_ynlaccu'] . 'KW';
              $values = (int)$sv['d2d_ynlaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2m_ynlaccu']);
            }
            $v['val']=$value;
          }
        }
        $series_array['data'] = $series_array_data;
        $v['series'] =$series_array;
        $v['type'] = 'pie';
      }elseif ( 'day' == $category){
        $current_time = $start . '-' . $end;
        $v['time'] = $current_time;
        $sql_select_sum_current_value = "
                select
                    sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu ,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                where t.d2d_atpstatus is null and t1.rgn_atpstatus is null and t.d2d_dt between '" . $start . "' and '" . $end . "' and t.d2d_regionid in (" . $endrgn_atpidsstrings . ")
                ";
        $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
        $series_array = [];
        $series_array_data = [];
        foreach ($Result_sum_current_value as $sk => $sv) {
          if ('用水量' == $select_param) {
            $v['name'] = '用水量占比';
            $v['category'] = '用水量';
            if (null == $sv['d2d_syslaccu'] || '' == $sv['d2d_syslaccu']) {
//                            $v['ysl'] = '0KW';
              $v['ysl'] = '0T';
              $values = $v['ysl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
              $values = (int)$sv['d2d_syslaccu'].'T';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2d_syslaccu']);
            }
            $v['val'] = $values;
          }
          if ('电量值' == $select_param) {
            $v['name'] = '电量值占比';
            $v['category'] = '电量值';
            if (null == $sv['d2d_dglaccu'] || '' == $sv['d2d_dglaccu']) {
              $v['dgl'] = '0KW';
              $values = $v['dgl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['dgl'] = $sv['d2d_dglaccu'] . 'KW';
              $values=(int)$sv['d2d_dglaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2d_dglaccu']);
            }
            $v['val']=$value;
          }
          if ('用冷量' == $select_param) {
            $v['name'] = '用冷量占比';
            $v['category'] = '用冷量';
            if (null == $sv['d2d_yllaccu'] || '' == $sv['d2d_yllaccu']) {
              $v['yll'] = '0KW';
              $values = $v['yll'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['yll'] = $sv['d2d_yllaccu'] . 'KW';
              $values = (int)$sv['d2d_yllaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2d_yllaccu']);
            }
            $v['val']=$value;
          }
          if ('用暖量' == $select_param) {
            $v['name'] = '用暖量占比';
            $v['category'] = '用暖量';
            if (null == $sv['d2d_ynlaccu'] || '' == $sv['d2d_ynlaccu']) {
              $v['ynl'] = '0KW';
              $value=$v['ynl'];
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,0);
            } else {
              $v['ynl'] = $sv['d2d_ynlaccu'] . 'KW';
              $values = (int)$sv['d2d_ynlaccu'].'KW';
              array_push($series_array_data,$v['rgn_name']);
              array_push($series_array_data,(int)$sv['d2d_ynlaccu']);
            }
            $v['val']=$value;
          }
        }
        $series_array['data'] = $series_array_data;
        $v['series'] =$series_array;
        $v['type'] = 'pie';
      }
    }

//    dump($Result);
    $this->assign("EnergyAnalyze",$Result);
  }

}