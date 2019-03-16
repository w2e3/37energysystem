<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DatacontrastenergyController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据对比】 / 【单面机能耗】");
        $ids = I("get.ids","");
        $this->assign('ids',$ids);
        //////////////////////////////////////////////////////////////////////
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
            //////////////////////////////////////////////////////////////////
            $sum = strlen($start);
            if ( 4 == $sum){
                $current_time = $start.'-'.$end;
                $last_end =$start-1;
                $last_start = $last_end-($end-$start);
                $last_time = $last_start.'-'.$last_end;
                $columns = [];
                $columns[] =array('field'=>$current_time,'title'=>'本期值');
                $columns[] =array('field'=>$last_time,'title'=>'上期值');
                $columns[] =array('field'=>'mam','title'=>'单面积均值');
                $this->assign('columns',$columns);
            }elseif(7 == $sum){
                $current_time = $start.'-'.$end;
                $diff_time_num = $this->getMonthNum($start,$end);
                $last_end =date('Y-m',strtotime("$start -1 months"));
                $last_start=date('Y-m',strtotime("$last_end -".$diff_time_num."months"));
                $last_time = $last_start.'-'.$last_end;
                $yoy_start = date('Y-m',strtotime("$start -1 year"));
                $yoy_end = date('Y-m',strtotime("$end -1 year"));
                $yoy_time = $yoy_start.'-'.$yoy_end;
                $columns = [];
                $columns[] =array('field'=>$current_time,'title'=>'本期值');
                $columns[] =array('field'=>$last_time,'title'=>'上期值');
                $columns[] =array('field'=>$yoy_time,'title'=>'去年同期值');
                $columns[] =array('field'=>'mam','title'=>'单面积均值');
                $this->assign('columns',$columns);
            }elseif (10 == $sum){
                $current_time = $start.'-'.$end;
                $diff_time_num = $this->getDayNum($start,$end);
                $last_end =date('Y-m-d',strtotime("$start -1 days"));
                $last_start=date('Y-m-d',strtotime("$last_end -".$diff_time_num."days"));
                $last_time = $last_start.'-'.$last_end;
                $yoy_start = date('Y-m-d',strtotime("$start -1 year"));
                $yoy_end = date('Y-m-d',strtotime("$end -1 year"));
                $yoy_time = $yoy_start.'-'.$yoy_end;
                $columns = [];
                $columns[] =array('field'=>$current_time,'title'=>'本期值');
                $columns[] =array('field'=>$last_time,'title'=>'上期值');
                $columns[] =array('field'=>$yoy_time,'title'=>'去年同期值');
                $columns[] =array('field'=>'mam','title'=>'单面积均值');
                $this->assign('columns',$columns);
            }

        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $lyear2 = date("Y", strtotime("-3 year"));
            $tyear2 = date("Y", strtotime("-2 year"));
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
            //////////////////////////////////////////////////////////////////////
            $columns = [];
            $columns[] =array('field'=>"$lyear-$tyear",'title'=>'本期值');
            $columns[] =array('field'=>"$lyear2-$tyear2",'title'=>'上期值');
            $columns[] =array('field'=>'mam','title'=>'单面积均值');
            $this->assign('columns',$columns);
        }
        /////////////////////////////////////////////////////////////////////
        $parammore = I('get.selectParam','');
        if (null == $parammore) {
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v) {
                if ('电量值' == $v['p_name']) {
                    $v['aux_selected'] = '是';
                    $selectParam = $v['p_atpid'];
                }
            }
            $this->assign('param', $param);
            $this->assign('selectParam', $selectParam);
        }else{
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            $sql_select_param = "
            select
            *
            from szny_param t
            where t.p_atpstatus is null and t.p_atpid = '".$parammore."' order by t.p_name desc
            ";
            $Result_param = $Model->query($sql_select_param);
            foreach ($param as $k => &$v) {
                foreach ($Result_param as $sk => $sv) {
                    if ($sv['p_atpid'] == $v['p_atpid']) {
                        $v['aux_selected'] = '是';
                        $selectParam = $v['p_atpid'];
                        break;
                    }
                }
            }
            $this->assign('param',$param);
            $this->assign('selectParam', $selectParam);
        }
        /////////////////////////////////////////////////////////////////////////////////
        $this->display();
    }
    function getMonthNum($date1,$date2){
        $date1_stamp=strtotime($date1);
        $date2_stamp=strtotime($date2);
        list($date_1['y'],$date_1['m'])=explode("-",date('Y-m',$date1_stamp));
        list($date_2['y'],$date_2['m'])=explode("-",date('Y-m',$date2_stamp));
        return abs($date_1['y']-$date_2['y'])*12 +$date_2['m']-$date_1['m'];
    }
    function getDayNum ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);
        return (round(($second2-$second1)/3600/24));
    }
    //详情
    public function getData()
    {
        $start = I('get.start','');
        $end = I('get.end','');
        ////////////////////////////////////////////////
        $ids = I('get.ids','');
        $idarray = explode(',',$ids);
        $endstring = "'".implode("','",$idarray)."'";
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('region');
        $sql_select = "
				select
					t.*
				from szny_region t
				";
        $sql_count = "
				select
					count(1) c
				from szny_region t
				";
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpid in (".$endstring.")");
        $sql_count = $this->buildSql($sql_count, "t.rgn_atpid in (".$endstring.")");
        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.emp_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.emp_name like '%" . $searchcontent . "%'");
        }
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.rgn_name asc";
        }
        //自定义分页
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);
        /*******************************************************************************/
        $select_param_id = I('get.selectParam','');//dump($select_param_id);die();
        $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
        $select_param = $Result_select_param['p_name'];
        /*******************************************************************************/
        foreach ($Result as $k => &$v)
        {
            $res = $this->regionrecursive($v['rgn_atpid']);
            $date = [];
            foreach ($res as $key => $value) {
                $date[] = $value['rgn_atpid'];
            }
            $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
            ///////////////////////////////////////////////////////////////////////
            if (null == $start) {
                $start = date('Y', strtotime('-1 year'));
                $end = date('Y', time());
            }
            ///////////////////////////////////////////////////////////////////////
            $queryparam = json_decode(file_get_contents("php://input"), true);
            $Model_sum = M();
            $sum = strlen($start);
//            dump($sum);die();
            if (4 == $sum) {
                $current_time = $start.'-'.$end;//dump($current_time);
                $sql_select_sum_current_value = "
                select
                    sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt between " . $start . " and " . $end . " and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
                $last_end = $start-1;
                $last_start = $last_end -($end-$start);
                $last_time = $last_start.'-'.$last_end;
                $sql_select_sum_last_value = "
                select
                    sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt between " . $last_start . " and " . $last_end . " and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model_sum->query($sql_select_sum_last_value);
//                dump($Result_sum_current_value);die();
                foreach ($Result_sum_current_value as $sk => $sv) {
                    foreach ($Result_sum_last_value as $slk => $slv){
                        if ('用冷量' == $select_param) {
                            if (null == $sv['d2y_yllaccu'] || '' == $sv['d2y_yllaccu']) {
                                $v[$current_time] = '0 KW';
                            } else {
                                $v[$current_time] = $sv['d2y_yllaccu'] . ' KW';
                            }
                            if (null == $slv['d2y_yllaccu'] || '' == $slv['d2y_yllaccu']){
                                $v[$last_time] = '0 KW';
                            }else{
                                $v[$last_time] = $slv['d2y_yllaccu'] . ' KW';
                            }
                            if (0 == $v['rgn_area']){
                                $v['mam'] = '无';
                            }else{
                                $v['mam'] = round(($sv['d2y_yllaccu']/$v['rgn_area']),2).' KW/m²';
                            }
                        }
                        if ('用暖量' == $select_param) {
                            if (null == $sv['d2y_ynlaccu'] || '' == $sv['d2y_ynlaccu']) {
                                $v[$current_time] = '0KW';
                            } else {
                                $v[$current_time] = $sv['d2y_ynlaccu'] . ' KW';
                            }
                            if (null == $slv['d2y_ynlaccu'] || '' == $slv['d2y_ynlaccu']){
                                $v[$last_time] = '0KW';
                            }else{
                                $v[$last_time] = $slv['d2y_ynlaccu'] . ' KW';
                            }
                            if(0 == $v['rgn_area']){
                                $v['mam'] = '无';
                            }else{
                                $v['mam'] =round(($sv['d2y_ynlaccu']/$v['rgn_area']),2).' KW/m²';
                            }
                        }
                        if ('用水量' == $select_param) {
                            if (null == $sv['d2y_syslaccu'] || '' == $sv['d2y_syslaccu']) {
                                $v[$current_time] = '0t';
                            } else {
                                $v[$current_time] = $sv['d2y_syslaccu'] . ' t';
                            }
                            if (null == $slv['d2y_syslaccu'] || '' == $slv['d2y_syslaccu']) {
                                $v[$last_time] = '0t';
                            }else{
                                $v[$last_time] = $slv['d2y_syslaccu'] . ' t';
                            }
                            if (0 == $v['rgn_area']){
                                $v['mam'] = '无';
                            }else{
                                $v['mam'] =round(($sv['d2y_syslaccu']/$v['rgn_area']),2).' t/m²';
                            }
                        }
                        if ('电量值' == $select_param) {
                            if (null == $sv['d2y_dglaccu'] || '' == $sv['d2y_dglaccu']) {
                                $v[$current_time] = '0 KW';
                            } else {
                                $v[$current_time] = $sv['d2y_dglaccu'] . ' KW';
                            }
                            if (null == $slv['d2y_dglaccu'] || '' == $slv['d2y_dglaccu']) {
                                $v[$last_time] = '0 KW';
                            }else{
                                $v[$last_time] = $slv['d2y_dglaccu'] . ' KW';
                            }
                            if (0 == $v['rgn_area']){
                                $v['mam'] = '无';
                            }else{
                                $v['mam'] =round(($sv['d2y_dglaccu']/$v['rgn_area']),2).' KW/m²';
                            }
                        }
                    }
                }
//            echo $Model->_sql();die();
//                $Count = $Model->query($sql_count);
//                echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '年'));
            } else if (7 == $sum) {
                $Model_sum = M();
                $time = $start.'-'.$end;
                $sql_select_sum_current_value = "
                select
                    sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt between '" . $start . "' and '" . $end . "' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
//                dump($Result_sum_current_value);
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $diff_time_num = $this->getMonthNum($start,$end);
                $last_end =date('Y-m',strtotime("$start -1 months"));
                $last_start=date('Y-m',strtotime("$last_end -".$diff_time_num."months"));
                $last_time = $last_start.'-'.$last_end;
                $sql_select_sum_last_value = "
                select
                    sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt between '".$last_start."' and '".$last_end."' and t.d2m_regionid in (".$endrgn_atpidsstrings.")
                ";
                $Result_sum_last_value = $Model_sum->query($sql_select_sum_last_value);
//                dump($Result_sum_last_value);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $yoy_start = date('Y-m',strtotime("$start -1 year"));
                $yoy_end = date('Y-m',strtotime("$end -1 year"));
                $yoy_time = $yoy_start.'-'.$yoy_end;
                $sql_select_sum_yoy_value = "
                select
                    sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt between '".$yoy_start."' and '".$yoy_end."' and t.d2m_regionid in (".$endrgn_atpidsstrings.")
                ";
                $Result_sum_yoy_value = $Model_sum->query($sql_select_sum_yoy_value);
//                dump($Result_sum_yoy_value);die();
                foreach ($Result_sum_current_value as $sk => &$sv) {
                    foreach ($Result_sum_last_value as $slk => $slv){
                        foreach ($Result_sum_yoy_value as $syk => $syv){
                            if ('用冷量'== $select_param) {
                                if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
                                    $v[$time] = '0 KW';
                                } else {
                                    $v[$time] = $sv['d2m_yllaccu'] . ' KW';
                                }
                                if (null == $slv['d2m_yllaccu'] || '' == $slv['d2m_yllaccu']){
                                    $v[$last_time] = '0 KW';
                                }else{
                                    $v[$last_time] = $slv['d2m_yllaccu'] . ' KW';
                                }
                                if (null == $syv['d2m_yllaccu'] || '' == $syv['d2m_yllaccu']){
                                    $v[$yoy_time] = '0 KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2m_yllaccu'] . ' KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] = round(($sv['d2m_yllaccu']/$v['rgn_area']),2).' KW/m²';
                                }
                            }
                            if ('用暖量'== $select_param) {
                                if (null == $sv['d2m_ynlaccu'] || '' == $sv['d2m_ynlaccu']) {
                                    $v[$time] = '0 KW';
                                } else {
                                    $v[$time] = $sv['d2m_ynlaccu'] . 'KW';
                                }
                                if (null == $slv['d2m_ynlaccu'] || '' == $slv['d2m_ynlaccu']){
                                    $v[$last_time] = '0 KW';
                                }else{
                                    $v[$last_time] = $slv['d2m_ynlaccu'] . 'KW';
                                }
                                if (null == $syv['d2m_ynlaccu'] || '' == $syv['d2m_ynlaccu']){
                                    $v[$yoy_time] = '0 KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2m_ynlaccu'] . 'KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] = round($sv['d2m_dglaccu']/$v['rgn_area'],2).' KW/m²';
                                }
                            }
                            if ('电量值' == $select_param) {
                                if (null == $sv['d2m_dglaccu'] || '' == $sv['d2m_dglaccu']) {
                                    $v[$time] = '0 KW';
                                } else {
                                    $v[$time] = $sv['d2m_dglaccu'] . 'KW';
                                }
                                if (null == $slv['d2m_dglaccu'] || '' == $slv['d2m_dglaccu']){
                                    $v[$last_time] = '0 KW';
                                }else{
                                    $v[$last_time] = $slv['d2m_dglaccu'] . 'KW';
                                }
                                if (null == $syv['d2m_dglaccu'] || '' == $syv['d2m_dglaccu']){
                                    $v[$yoy_time] = '0 KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2m_dglaccu'] . 'KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] =round($sv['d2m_dglaccu']/$v['rgn_area'],2).' KW/m²';
                                }
                            }
                            if ('用水量' == $select_param) {
                                if (null == $sv['d2m_syslaccu'] || '' == $sv['d2m_syslaccu']) {
                                    $v[$time] = '0 t';
                                } else {
                                    $v[$time] = $sv['d2m_syslaccu'] . 't';
                                }
                                if (null == $slv['d2m_syslaccu'] || '' == $slv['d2m_syslaccu']){
                                    $v[$last_time] = '0 t';
                                }else{
                                    $v[$last_time] = $slv['d2m_syslaccu'] . 't';
                                }
                                if (null == $syv['d2m_syslaccu'] || '' == $slv['d2m_syslaccu']){
                                    $v[$yoy_time] = '0 t';
                                }else{
                                    $v[$yoy_time] = $syv['d2m_syslaccu'] . 't';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] =round($sv['d2m_dglaccu']/$v['rgn_area'],2).' t/m²';
                                }
                            }
                        }
                    }
                }
//                $Count = $Model->query($sql_count);//dump($Count);
//                echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '月'));
            } else if (10 == $sum) {
                $Model_sum = M();
                $time = $start.'-'.$end;
                $sql_select_sum_current_value = "
                select
                    t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                where t.d2d_atpstatus is null and t1.rgn_atpstatus is null and t.d2d_dt between '" . $start . "' and '" . $end . "' and t.d2d_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model_sum->query($sql_select_sum_current_value);
//                dump($Result_sum_current_value);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $diff_time_num = $this->getDayNum($start,$end);
                $last_end =date('Y-m-d',strtotime("$start -1 days"));
                $last_start=date('Y-m-d',strtotime("$last_end -".$diff_time_num."days"));
                $last_time = $last_start.'-'.$last_end;
                $sql_select_sum_last_value = "
                select
                    sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                where t.d2d_atpstatus is null and t1.rgn_atpstatus is null and t.d2d_dt between '".$last_start."' and '".$last_end."' and t.d2d_regionid in (".$endrgn_atpidsstrings.")
                ";
                $Result_sum_last_value = $Model_sum->query($sql_select_sum_last_value);
//                dump($Result_sum_last_value);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $yoy_start = date('Y-m-d',strtotime("$start -1 year"));
                $yoy_end = date('Y-m-d',strtotime("$end -1 year"));
                $yoy_time = $yoy_start.'-'.$yoy_end;
                $sql_select_sum_yoy_value = "
                select
                    sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                where t.d2d_atpstatus is null and t1.rgn_atpstatus is null and t.d2d_dt between '".$yoy_start."' and '".$yoy_end."' and t.d2d_regionid in (".$endrgn_atpidsstrings.")
                ";
                $Result_sum_yoy_value = $Model_sum->query($sql_select_sum_yoy_value);
//                dump($Result_sum_yoy_value);die();
                foreach ($Result_sum_current_value as $sk => &$sv) {
                    foreach ($Result_sum_last_value as $slk => $slv){
                        foreach ($Result_sum_yoy_value as $syk => $syv){
                            if ('用冷量'== $select_param) {
                                if (null == $sv['d2d_yllaccu'] || '' == $sv['d2d_yllaccu']) {
                                    $v[$time] = '0 KW';
                                } else {
                                    $v[$time] = $sv['d2d_yllaccu'] . ' KW';

                                }
                                if (null == $slv['d2d_yllaccu'] || '' == $slv['d2d_yllaccu']){
                                    $v[$last_time] = '0 KW';
                                }else{
                                    $v[$last_time] = $slv['d2d_yllaccu'] . ' KW';
                                }
                                if (null == $syv['d2d_yllaccu'] || '' == $syv['d2d_yllaccu']){
                                    $v[$yoy_time] = '0 KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2d_yllaccu'] . ' KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] = round($sv['d2d_yllaccu']/$v['rgn_area'],2).' KW/m²';
                                }
                            }
                            if ('用暖量'== $select_param) {
                                if (null == $sv['d2d_ynlaccu'] || '' == $sv['d2d_ynlaccu']) {
                                    $v[$time] = '0KW';
                                } else {
                                    $v[$time] = $sv['d2d_ynlaccu'] . 'KW';
                                }
                                if (null == $slv['d2d_ynlaccu'] || '' == $slv['d2d_ynlaccu']){
                                    $v[$last_time] = '0KW';
                                }else{
                                    $v[$last_time] = $slv['d2d_ynlaccu'] . 'KW';
                                }
                                if (null == $syv['d2d_ynlaccu'] || '' == $syv['d2d_ynlaccu']){
                                    $v[$yoy_time] = '0KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2d_ynlaccu'] . 'KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] = round($sv['d2d_ynlaccu']/$slv['d2d_ynlaccu'],2).' KW/m²';
                                }
                            }
                            if ('电量值'== $select_param) {
                                if (null == $sv['d2d_dglaccu'] || '' == $sv['d2d_dglaccu']) {
                                    $v[$time] = '0KW';
                                } else {
                                    $v[$time] = $sv['d2d_dglaccu'] . 'KW';
                                }
                                if (null == $slv['d2d_dglaccu'] || '' == $slv['d2d_dglaccu']){
                                    $v[$last_time] = '0KW';
                                }else{
                                    $v[$last_time] = $slv['d2d_dglaccu'] . 'KW';
                                }
                                if (null == $syv['d2d_dglaccu'] || '' == $syv['d2d_dglaccu']){
                                    $v[$yoy_time] = '0KW';
                                }else{
                                    $v[$yoy_time] = $syv['d2d_dglaccu'] . 'KW';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] =round($sv['d2d_dglaccu']/$v['rgn_area'],2).' KW/m²';
                                }
                            }
                            if ('用水量' ==  $select_param) {
                                if (null == $sv['d2d_syslaccu'] || '' == $sv['d2d_syslaccu']) {
                                    $v[$time] = '0 t';
                                } else {
                                    $v[$time] = $sv['d2d_syslaccu'] . ' t';
                                }
                                if (null == $slv['d2d_syslaccu'] || '' == $slv['d2d_syslaccu']){
                                    $v[$last_time] = '0 t';
                                }else{
                                    $v[$last_time] = $slv['d2d_syslaccu'] . ' t';
                                }
                                if (null == $syv['d2d_syslaccu'] || '' == $syv['d2d_syslaccu']){
                                    $v[$yoy_time] = '0 t';
                                }else{
                                    $v[$yoy_time] = $syv['d2d_syslaccu'] . ' t';
                                }
                                if (0 == $v['rgn_area']){
                                    $v['mam'] = '无';
                                }else{
                                    $v['mam'] =round($sv['d2d_syslaccu']/$v['rgn_area'],2).' t/m²';
                                }
                            }
                        }
                    }
                }
            }
        }
//        dump($Result);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}