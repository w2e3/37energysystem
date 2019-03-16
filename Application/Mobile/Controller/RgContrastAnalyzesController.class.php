<?php
namespace Mobile\Controller;
use Think\Controller;
class RgContrastAnalyzesController extends BaseController
{
    public function index(){

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
        $category="year";
      }
      if(strlen($start_time)==0)
      {
        $start_time=date("Y");
        $start_time=date("Y",strtotime("$start_time -1 year"));
      }

      if(strlen($end_time)==0)
      {
        $end_time=date("Y");
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
      $parameter_name=M('param')->where("p_atpstatus is null and p_atpid='%s'",array($parameter))->getField('p_name');
      $this->assign('rgn_id',$rgn_atpid);
      $this->assign('category',$category);
      $this->assign('start_time',$start_time);
      $this->assign('end_time',$end_time);
      $this->assign('parameter_arrs',$parameter_arrs);
      $this->assign('parameter',$parameter);
      $this->assign('parameter_name',$parameter_name);
      $this->getRgContrastAnalyzes($rgn_atpid,$regiontype,$snname,$start_time,$end_time,$category,$parameter);
      $this->display();
    }
    //详情
    public function getRgContrastAnalyzes($rgn_atpid,$regiontype,$snname,$start,$end,$category,$parameter)
    {
//      dump($rgn_atpid);
//      dump($regiontype);
//      dump($start);
//      dump($end);
//      var_dump($category);
//      dump($parameter);

        $ids=$rgn_atpid;
        $idarray = explode(',',$ids);
        $endstring = "'".implode("','",$idarray)."'";
        $result=array();
        if ( "year" == $category) {
          $this->assign('RgContrastAnalyzes',$result);
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2y_dt from szny_data2year t where t.d2y_atpstatus is null and t.d2y_dt between '$start' and '$end' group by t.d2y_dt order by t.d2y_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
//            $select_param_id = $parameter;
            $Result_select_param = M('param')->where("p_atpid='%s'", array($parameter))->find();
            $select_param = $Result_select_param['p_name'];
//            dump($result);
//            dump($Result_select_param);
            foreach ($result as $k => &$v){
                $res = $this->regionrecursive($v['rgn_atpid']);
                $res_name = M('region')->where("rgn_atpid ='%s'",$v['rgn_atpid'])->find();
                $v['rgn_name'] = $res_name['rgn_name'];
                $v['time'] = $v['d2y_dt'];
                $v['region_time'] = $res_name['rgn_name']."【". $v['d2y_dt']."】";
                $time = $v['d2y_dt'];
                $date = [];
                foreach ($res as $key => $value) {
                    $date[] = $value['rgn_atpid'];
                }
                $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
                $sql_select_sum_current_value = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt = '$time' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model->query($sql_select_sum_current_value);
                $last = $time -1;
                $sql_select_sum_last_value = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt = '$last' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model->query($sql_select_sum_last_value);
                foreach ($Result_sum_current_value as $rck => $rcv){
                    foreach ($Result_sum_last_value as $rlk => $rlv){
                        if ('用水量' == $select_param) {
                            $v['category'] = '用水量';
                            if (null == $rcv['d2y_syslaccu'] || '' == $rcv['d2y_syslaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_syslaccu'].'t';
                            }
                            if (null == $rlv['d2y_syslaccu'] || '' == $rlv['d2y_syslaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_syslaccu'].'t';
                            }
                            if (0 == $rlv['d2y_syslaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_syslaccu']/$rlv['d2y_syslaccu'])*100).'%';
                            }
                        }
                        if ('电量值' == $select_param) {
                            $v['category'] = '电量值';
                            if (null == $rcv['d2y_dglaccu'] || '' == $rcv['d2y_dglaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_dglaccu'].'KW';
                            }
                            if (null == $rlv['d2y_dglaccu'] || '' == $rlv['d2y_dglaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_dglaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_dglaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_yllaccu']/$rlv['d2y_yllaccu'])*100).'%';
                            }
                        }
                        if ('用冷量' == $select_param) {
                            $v['category'] = '用冷量';
                            if (null == $rcv['d2y_yllaccu'] || '' == $rcv['d2y_yllaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_yllaccu'].'KW';
                            }
                            if (null == $rlv['d2y_yllaccu'] || '' == $rlv['d2y_yllaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_yllaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_yllaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_yllaccu']/$rlv['d2y_yllaccu'])*100).'%';
                            }
                        }
                        if ('用暖量' == $select_param) {
                            $v['category'] = '用暖量';
                            if (null == $rcv['d2y_ynlaccu'] || '' == $rcv['d2y_ynlaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_ynlaccu'].'KW';
                            }
                            if (null == $rlv['d2y_ynlaccu'] || '' == $rlv['d2y_ynlaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_ynlaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_ynlaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_ynlaccu']/$rlv['d2y_ynlaccu'])*100).'%';
                            }
                        }
                    }
                }
            }
            $serices_benqizhi = [];
            $serices_benqizhi['name'] = '本期值';
            $serices_benqizhi['stack'] = 1;
            $serices_benqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_benqizhi_data,(int)$rv['本期值']);
            }
            $serices_benqizhi['data'] = $serices_benqizhi_data;
            $serices_shangqizhi = [];
            $serices_shangqizhi['name'] = '上期值';
            $serices_shangqizhi['stack'] = 2;
            $serices_shangqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_shangqizhi_data,(int)$rv['上期值']);
            }
            $serices_shangqizhi['data'] = $serices_shangqizhi_data;
            $series = [];
            array_push($series,$serices_benqizhi);
            array_push($series,$serices_shangqizhi);
            foreach ($result as $k => &$v){
                $v['series'] = $series;
            }
          $this->assign('RgContrastAnalyzes',$result);
        }
        elseif ("month"== $category)
        {
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by t.rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2m_dt from szny_data2month t where t.d2m_atpstatus is null and t.d2m_dt between '".$start."' and '".$end."' group by t.d2m_dt order by t.d2m_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
            $Result_select_param = M('param')->where("p_atpid='%s'", array($parameter))->find();
            $select_param = $Result_select_param['p_name'];
            foreach ($result as $k => &$v){
                $res = $this->regionrecursive($v['rgn_atpid']);
                $res_name = M('region')->where("rgn_atpid ='%s'",$v['rgn_atpid'])->find();
                $v['rgn_name'] = $res_name['rgn_name'];
                $v['time'] = $v['d2m_dt'];
                $v['region_time'] = $res_name['rgn_name']."【". $v['d2m_dt']."】";
                $time = $v['d2m_dt'];
                $date = [];
                foreach ($res as $key => $value) {
                    $date[] = $value['rgn_atpid'];
                }
                $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
                $sql_select_sum_current_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$time."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model->query($sql_select_sum_current_value);
                $time  = strtotime($time);
                $last = date('Y-m', strtotime ("-1 years", $time));
                $last_month = date('Y-m', strtotime ("-1 months", $time));
                $sql_select_sum_last_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$last."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model->query($sql_select_sum_last_value);
                $sql_select_sum_last_month_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$last_month."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_month_value = $Model->query($sql_select_sum_last_month_value);
                foreach ($Result_sum_current_value as $rck => $rcv){
                    foreach ($Result_sum_last_value as $rlk => $rlv){
                        foreach ($Result_sum_last_month_value as $rlmk => $rlmv){
                            if ('用水量' == $select_param) {
                                $v['category'] = '用水量';
                                if (null == $rcv['d2m_syslaccu'] || '' == $rcv['d2m_syslaccu']) {
                                    $v['本期值'] = '0t';
                                }else{
                                    $v['本期值'] =$rcv['d2m_syslaccu'].'t';
                                }
                                if (null == $rlv['d2m_syslaccu'] || '' == $rlv['d2m_syslaccu']) {
                                    $v['上期值'] = '0t';
                                }else{
                                    $v['上期值'] =$rlv['d2m_syslaccu'].'t';
                                }
                                if (null == $rlmv['d2m_syslaccu'] || '' == $rlmv['d2m_syslaccu']) {
                                    $v['去年同期值'] = '0t';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_syslaccu'].'t';
                                }
                                if (0 == $rlv['d2m_syslaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_syslaccu']/$rlv['d2m_syslaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_syslaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_syslaccu']/$rlmv['d2m_syslaccu'])*100).'%';
                                }
                            }
                            if ('电量值' == $select_param) {
                                $v['category'] = '电量值';
                                if (null == $rcv['d2m_dglaccu'] || '' == $rcv['d2m_dglaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_dglaccu'].'KW';
                                }
                                if (null == $rlv['d2m_dglaccu'] || '' == $rlv['d2m_dglaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_dglaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_dglaccu'] || '' == $rlmv['d2m_dglaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_dglaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_dglaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_dglaccu']/$rlv['d2m_dglaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_dglaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_dglaccu']/$rlmv['d2m_dglaccu'])*100).'%';
                                }
                            }
                            if ('用冷量' == $select_param) {
                                $v['category'] = '用冷量';
                                if (null == $rcv['d2m_yllaccu'] || '' == $rcv['d2m_yllaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_yllaccu'].'KW';
                                }
                                if (null == $rlv['d2m_yllaccu'] || '' == $rlv['d2m_yllaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_yllaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_yllaccu'] || '' == $rlmv['d2m_yllaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_yllaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_yllaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_yllaccu']/$rlv['d2m_yllaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_yllaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_yllaccu']/$rlmv['d2m_yllaccu'])*100).'%';
                                }
                            }
                            if ('用暖量' == $select_param) {
                                $v['category'] = '用暖量';
                                if (null == $rcv['d2m_ynlaccu'] || '' == $rcv['d2m_ynlaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_ynlaccu'].'KW';
                                }
                                if (null == $rlv['d2m_ynlaccu'] || '' == $rlv['d2m_ynlaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_ynlaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_ynlaccu'] || '' == $rlmv['d2m_ynlaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_ynlaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_ynlaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_ynlaccu']/$rlv['d2m_ynlaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_ynlaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_ynlaccu']/$rlmv['d2m_ynlaccu'])*100).'%';
                                }
                            }
                        }
                    }
                }
            }
            $serices_benqizhi = [];
            $serices_benqizhi['name'] = '本期值';
            $serices_benqizhi['stack'] = 1;
            $serices_benqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_benqizhi_data,(int)$rv['本期值']);
            }
            $serices_benqizhi['data'] = $serices_benqizhi_data;
            $serices_shangqizhi = [];
            $serices_shangqizhi['name'] = '上期值';
            $serices_shangqizhi['stack'] = 2;
            $serices_shangqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_shangqizhi_data,(int)$rv['上期值']);
            }
            $serices_shangqizhi['data'] = $serices_shangqizhi_data;
            $serices_qunianzhi = [];
            $serices_qunianzhi['name'] = '去年同期值';
            $serices_qunianzhi['stack'] = 3;
            $serices_qunianzhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_qunianzhi_data,(int)$rv['去年同期值']);
            }
            $serices_qunianzhi['data'] = $serices_qunianzhi_data;
            $series = [];
            array_push($series,$serices_benqizhi);
            array_push($series,$serices_shangqizhi);
            array_push($series,$serices_qunianzhi);
            foreach ($result as $k => &$v){
                $v['series'] = $series;
            }
//          dump($result);
          $this->assign('RgContrastAnalyzes',$result);
        }

    }
    function combineArray($arr1,$arr2) {
        $result = array();
        foreach ($arr1 as $item1) {
            foreach ($arr2 as $item2) {
                $array = array_merge($item1,$item2);
                array_push($result,$array);
            }
        }
        return $result;
    }
}