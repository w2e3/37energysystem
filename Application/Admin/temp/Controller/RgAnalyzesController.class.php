<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgAnalyzesController extends BaseAuthController
{
    public function index(){
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【数据分析】");
        $rgn_atpid = I('get.rgn_atpid', '');
        $this->assign('rgn_atpid', $rgn_atpid);
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
        }
        $parammore = I('get.selectParam','');
        if (null == $parammore){
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v){
                if ('电量值' == $v['p_name']){
                    $v['aux_selected'] = '是';
                    $selectParam = $v['p_atpid'];
                }
            }
            $this->assign('selectParam',$selectParam);
            $this->assign('param',$param);
            $columns = [];
            $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
            unset($columns[1]);
            $this->assign('columns',$columns);
        }else{
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            $parammores =  explode(',',$parammore);
            $endparammorestring = "'".implode("','",$parammores)."'";
            $sql_select_param = "
            select
            *
            from szny_param t
            where t.p_atpstatus is null and t.p_atpid in(".$endparammorestring.")  order by t.p_name desc
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
            $this->assign('selectParam',$selectParam);
            $this->assign('param',$param);
            if(null != is_array($parammores)){
                $columns = [];
                foreach($parammores as $value){
                    $Model = M();
                    $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_atpid =" ."'".$value."'";
                    $data = $Model->query($sql);
                    if($data[0]['p_name'] == '用水量'){
                        $columns[] =array_push($columns,array('field'=>'ysl','title'=>'用水量'));
                    }elseif($data[0]['p_name'] == '用暖量'){
                        $columns[] =array_push($columns,array('field'=>'ynl','title'=>'用暖量'));
                    }elseif($data[0]['p_name'] == '用冷量'){
                        $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
                    }elseif($data[0]['p_name'] == '电量值'){
                        $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
                    }
                }
                foreach($columns as $key =>$value){
                    if(null == is_array($value)){
                        unset($columns[$key]);
                    }
                }
            }
            $this->assign('columns',$columns);
        }
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【园区漫游】 / 【数据分析】");
    }
    public function getData(){
        $rgn_atpid = I('get.rgn_atpid','');
        $selectParam = I('get.selectParam','');
        $start = I('get.start','');
        $end = I('get.end','');
        $Model = M();
        $list = M('region')->where("rgn_atpid='$rgn_atpid'")->find();
        // dump($list);
        if($list['rgn_category']=='设备点'){
            $sql_select_child_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid = '$rgn_atpid'"; 
       }else{
            $sql_select_child_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_pregionid = '$rgn_atpid'";
       }
        // $sql_select_child_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_pregionid = '$rgn_atpid'";
        $Result_select_child_region  = $Model->query($sql_select_child_region);
        $select_child_region_array = [];
        foreach ($Result_select_child_region as $rscrk => $rscrv){
            array_push($select_child_region_array,$rscrv['rgn_atpid']);
        }
        $select_child_region_strings = "'". implode("','",$select_child_region_array)."'";
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model_region = M('region');
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
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpid in (".$select_child_region_strings.")");
        $sql_count = $this->buildSql($sql_count, "t.rgn_atpid in (".$select_child_region_strings.")");
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
        $Result = $Model_region->query($sql_select);
        $Count = $Model_region->query($sql_count);
        $Result_select_param = M('param')->where("p_atpid='%s'", array($selectParam))->find();
        $select_param = $Result_select_param['p_name'];
        
        // if(empty($Result)){
        //     $Result['rgn_atpid'] = $rgn_atpid;
        // }
        // dump($Result);
        foreach ($Result as $k=>&$v){
            $res = $this->regionrecursive($v['rgn_atpid']);
            $date = [];
            foreach ($res as $key => $value) {
                $date[] = $value['rgn_atpid'];
            }
            $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
            $Model_sum = M();
            $sum = strlen($start);
            if (4 == $sum) {
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
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
//                            $v['ysl'] = $sv['d2y_syslaccu'] . 'KW';
                            $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2y_syslaccu']);
                        }
                    }
                    if ('电量值' == $select_param) {
                        $v['name'] = '电量值占比';
                        $v['category'] = '电量值';
                        if (null == $sv['d2y_dglaccu'] || '' == $sv['d2y_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2y_dglaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2y_dglaccu']);
                        }
                    }
                    if ('用冷量' == $select_param) {
                        $v['name'] = '用冷量占比';
                        $v['category'] = '用冷量';
                        if (null == $sv['d2y_yllaccu'] || '' == $sv['d2y_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2y_yllaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2y_yllaccu']);
                        }
                    }
                    if ('用暖量' == $select_param) {
                        $v['name'] = '用暖量占比';
                        $v['category'] = '用暖量';
                        if (null == $sv['d2y_ynlaccu'] || '' == $sv['d2y_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2y_ynlaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2y_ynlaccu']);
                        }
                    }
                }
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['type'] = 'pie';
            }elseif (7 == $sum){
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
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
//                            $v['ysl'] = $sv['d2m_syslaccu'] . 'KW';
                          $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2m_syslaccu']);
                        }
                    }
                    if ('电量值' == $select_param) {
                        $v['name'] = '电量值占比';
                        $v['category'] = '电量值';
                        if (null == $sv['d2m_dglaccu'] || '' == $sv['d2m_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2m_dglaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2m_dglaccu']);
                        }
                    }
                    if ('用冷量' == $select_param) {
                        $v['name'] = '用冷量占比';
                        $v['category'] = '用冷量';
                        if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2m_yllaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2m_yllaccu']);
                        }
                    }
                    if ('用暖量' == $select_param) {
                        $v['name'] = '用暖量占比';
                        $v['category'] = '用暖量';
                        if (null == $sv['d2m_ynlaccu'] || '' == $sv['d2m_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2m_ynlaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2m_ynlaccu']);
                        }
                    }
                }
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['type'] = 'pie';
            }elseif (10 == $sum){
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
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
//                            $v['ysl'] = $sv['d2d_syslaccu'] . 'KW';
                          $v['ysl'] = $sv['d2y_syslaccu'] . 'T';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2d_syslaccu']);
                        }
                    }
                    if ('电量值' == $select_param) {
                        $v['name'] = '电量值占比';
                        $v['category'] = '电量值';
                        if (null == $sv['d2d_dglaccu'] || '' == $sv['d2d_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2d_dglaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2d_dglaccu']);
                        }
                    }
                    if ('用冷量' == $select_param) {
                        $v['name'] = '用冷量占比';
                        $v['category'] = '用冷量';
                        if (null == $sv['d2d_yllaccu'] || '' == $sv['d2d_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2d_yllaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2d_yllaccu']);
                        }
                    }
                    if ('用暖量' == $select_param) {
                        $v['name'] = '用暖量占比';
                        $v['category'] = '用暖量';
                        if (null == $sv['d2d_ynlaccu'] || '' == $sv['d2d_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2d_ynlaccu'] . 'KW';
                            array_push($series_array_data,$v['rgn_name']);
                            array_push($series_array_data,(int)$sv['d2d_ynlaccu']);
                        }
                    }
                }
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['type'] = 'pie';
            }
        }
//        dump($Result);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
}