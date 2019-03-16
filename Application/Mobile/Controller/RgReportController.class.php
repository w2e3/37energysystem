<?php
namespace Mobile\Controller;
use Think\Controller;
class RgReportController extends BaseAuthController{
    public function index(){

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

      $parameter_name=M('param')->where("p_atpstatus is null and p_atpid='%s'",array($parameter))->getField('p_name');
      $this->assign('rgn_id',$rgn_atpid);
      $this->assign('category',$category);
      $this->assign('start_time',$start_time);
      $this->assign('end_time',$end_time);
      $this->assign('parameter_arrs',$parameter_arrs);
      $this->assign('parameter',$parameter);
      $this->assign('parameter_name',$parameter_name);
      $this->getRegPort($rgn_atpid,$regiontype,$snname,$start_time,$end_time,$category,$parameter);
      $this->display('index');
    }

    //详情
    public function getRegPort($rgn_atpid,$regiontype,$snname,$start,$end,$category,$parameter){
        $ids=$rgn_atpid;
        $idarray = explode(',',$ids);
        $endstring = "'".implode("','",$idarray)."'";

        $Model = M('region');
        $sql_select = "
				select
					t.rgn_name,t.rgn_atpid
				from szny_region t
				";

        $sql_select.=" where t.rgn_atpstatus is null";
        $sql_select.=" and t.rgn_atpid in ($endstring)";
        $sql_select.=" order by t.rgn_name asc";

//        var_dump($sql_select);
        $Result = $Model->query($sql_select);
//        $select_param_id = M('param')->where("p_atpstatus is null and p_name='%s'",array($parameter))->getField('p_atpid');
        $select_param_id = $parameter;
        $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
        $select_param = $Result_select_param['p_name'];
        foreach ($Result as $k => &$v)
        {
            $res = $this->regionrecursive($v['rgn_atpid']);
            $date = [];
            foreach ($res as $key => $value) {
                $date[] = $value['rgn_atpid'];
            }
            $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
            if (null == $start) {
                $start = date('Y', strtotime('-1 year'));
                $end = date('Y', time());
            }

            $Model_sum = M();
            if ("year" == $category) {
                $sql_select_sum = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
                $sql_select_sum.=" where t.d2y_atpstatus is null";
                $sql_select_sum.=" and t1.rgn_atpstatus is null";
                $sql_select_sum.=" and t.d2y_dt between '{$start}' and '{$end}'";
                $sql_select_sum.=" and t.d2y_regionid in ($endrgn_atpidsstrings)";
                $sql_select_sum.=" group by t.d2y_dt order by t.d2y_dt desc";

//                var_dump($sql_select_sum);
                $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                $series_array_time = [];
//                dump($Result_sum);
                foreach ($Result_sum as $sk => $sv) {
                  array_push($series_array_time,$sv['d2y_dt']);
                    if ('用冷量' == $select_param) {
                        $v['category'] = '用冷量';
                        if (null == $sv['d2y_yllaccu'] || '' == $sv['d2y_yllaccu']) {
                            $v[$sv['d2y_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2y_dt']] = $sv['d2y_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_yllaccu']);
                        }
                    }
                    if ('用暖量' == $select_param) {
                        $v['category'] = '用暖量';
                        if (null == $sv['d2y_ynlaccu'] || '' == $sv['d2y_ynlaccu']) {
                            $v[$sv['d2y_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2y_dt']] = $sv['d2y_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_ynlaccu']);
                        }
                    }
                    if ('用水量' == $select_param) {
                        $v['category'] = '用水量';
                        if (null == $sv['d2y_syslaccu'] || '' == $sv['d2y_syslaccu']) {
                            $v[$sv['d2y_dt']] = '0t';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2y_dt']] = $sv['d2y_syslaccu'] . 't';
                            array_push($series_array_data,(int)$sv['d2y_syslaccu']);
                        }
                    }
                    if ('电量值' == $select_param) {
                        $v['category'] = '电量值';
                        if (null == $sv['d2y_dglaccu'] || '' == $sv['d2y_dglaccu']) {
                            $v[$sv['d2y_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2y_dt']] = $sv['d2y_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_dglaccu']);
                        }
                    }
                    array_push($time,$sv['d2y_dt']);
                }
                $v['time'] = implode(",",$time);
                $series_array['data'] = $series_array_data;
                $series_array['time'] = $series_array_time;
                $v['series'] =$series_array;
            }
            else if ("month" == $category)
            {
                $Model_sum = M();
                $sql_select_sum = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";

                $sql_select_sum.=" where t.d2m_atpstatus is null";
                $sql_select_sum.=" and t1.rgn_atpstatus is null";
                $sql_select_sum.=" and t.d2m_dt between '{$start}' and '{$end}'";
                $sql_select_sum.=" and t.d2m_regionid in ($endrgn_atpidsstrings)";
                $sql_select_sum.=" group by t.d2m_dt order by t.d2m_dt desc";

                $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                $series_array_time=[];
                foreach ($Result_sum as $sk => &$sv) {
                  array_push($series_array_time,$sv['d2m_dt']);
                    if ('用冷量'== $select_param) {
                        $v['category'] = '用冷量';
                        if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
                            $v[$sv['d2m_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2m_dt']] = $sv['d2m_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_yllaccu']);
                        }
                    }
                    if ('用暖量'== $select_param) {
                        $v['category'] = '用暖量';
                        if (null == $sv['d2m_ynlaccu'] || '' == $sv['d2m_ynlaccu']) {
                            $v[$sv['d2m_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2m_dt']] = $sv['d2m_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_ynlaccu']);
                        }
                    }
                    if ('电量值' == $select_param) {
                        $v['category'] = '电量值';
                        if (null == $sv['d2m_dglaccu'] || '' == $sv['d2m_dglaccu']) {
                            $v[$sv['d2m_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2m_dt']] = $sv['d2m_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_dglaccu']);
                        }
                    }
                    if ('用水量' == $select_param) {
                        $v['category'] = '用水量';
                        if (null == $sv['d2m_syslaccu'] || '' == $sv['d2m_syslaccu']) {
                            $v[$sv['d2m_dt']] = '0t';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2m_dt']] = $sv['d2m_syslaccu'] . 't';
                            array_push($series_array_data,(int)$sv['d2m_syslaccu']);
                        }
                    }
                    array_push($time,$sv['d2m_dt']);
                }
                $v['time'] = implode(",",$time);
                $series_array['data'] = $series_array_data;
              $series_array['time'] = $series_array_time;
                $v['series'] =$series_array;

            }
            else if ("day" == $category)
            {
                $Model_sum = M();
                $sql_select_sum = "
                select
                    t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";

              $sql_select_sum.=" where t.d2d_atpstatus is null";
              $sql_select_sum.=" and t1.rgn_atpstatus is null";
              $sql_select_sum.=" and t.d2d_dt between '{$start}' and '{$end}'";
              $sql_select_sum.=" and t.d2d_regionid in ($endrgn_atpidsstrings)";
              $sql_select_sum.=" group by t.d2d_dt order by t.d2d_dt desc";

              $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                $series_array_time = [];
                foreach ($Result_sum as $sk => &$sv) {
                  array_push($series_array_time,$sv['d2d_dt']);
                    if ('用冷量'== $select_param) {
                        $v['category'] = '用冷量';
                        if (null == $sv['d2d_yllaccu'] || '' == $sv['d2d_yllaccu']) {
                            $v[$sv['d2d_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2d_dt']] = $sv['d2d_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_yllaccu']);
                        }
                    }
                    if ('用暖量'== $select_param) {
                        $v['category'] = '用暖量';
                        if (null == $sv['d2d_ynlaccu'] || '' == $sv['d2d_ynlaccu']) {
                            $v[$sv['d2d_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2d_dt']] = $sv['d2d_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_ynlaccu']);
                        }
                    }
                    if ('电量值'== $select_param) {
                        $v['category'] = '电量值';
                        if (null == $sv['d2d_dglaccu'] || '' == $sv['d2d_dglaccu']) {
                            $v[$sv['d2d_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2d_dt']] = $sv['d2d_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_dglaccu']);
                        }
                    }
                    if ('用水量' ==  $select_param) {
                        $v['category'] = '用水量';
                        if (null == $sv['d2d_syslaccu'] || '' == $sv['d2d_syslaccu']) {
                            $v[$sv['d2d_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2d_dt']] = $sv['d2d_syslaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_syslaccu']);
                        }
                    }
                    array_push($time,$sv['d2d_dt']);
                }
                $v['time'] = implode(",",$time);
                $series_array['data'] = $series_array_data;
                $series_array['time'] = $series_array_time;
                $v['series'] =$series_array;
            }
        }
//        dump($Result);
        $this->assign('RegionPortdata',$Result);

    }
}