<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DatacontrastitemController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据对比】 / 【分项报表】");
        $ids = I("get.ids","");
        $this->assign('ids',$ids);
        ////////////////////////////////////////////
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
        //////////////////////////////////////////////////
        $parammore = I('get.selectParam','');
        if (null == $parammore){
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v){
                if ('用冷量' == $v['p_name']){
                    $v['aux_selected'] = '是';
                    $selectParam = $v['p_atpid'];
                }
            }
            $this->assign('param',$param);
            $this->assign('selectParam',$selectParam);
            ////////////////////////////////////////////////////////////////////////////////////////////
            $columns = [];
            $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
            unset($columns[1]);
            //        dump($columns);die();
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
            $select_param_array =[];
            foreach ($param as $k => &$v) {
                foreach ($Result_param as $sk => $sv) {
                    if ($sv['p_atpid'] == $v['p_atpid']) {
                        $v['aux_selected'] = '是';
                        array_push($select_param_array,$v['p_atpid']);
                        break;
                    }
                }
            }
//            dump($select_param_array);die();
            $selectParam = implode(',',$select_param_array);
//            dump($selectParam);die();
             $this->assign('param',$param);
            $this->assign('selectParam',$selectParam);
            if(null != is_array($parammores)){
                $columns = [];
                foreach($parammores as $value){
                    $Model = M();
                    $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_atpid =" ."'".$value."'";
                    $data = $Model->query($sql);
                    if($data[0]['p_name'] == '用水量'){
                        $columns[] =array_push($columns,array('field'=>'ysl','title'=>'用水量'));
                    }elseif($data[0]['p_name'] == '电量值'){
                        $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
                    }elseif($data[0]['p_name'] == '用冷量'){
                        $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
                    }elseif($data[0]['p_name'] == '用暖量'){
                        $columns[] =array_push($columns,array('field'=>'ynl','title'=>'用暖量'));
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
    }
    public function getData(){
        $ids = I('get.ids','');
        $start = I('get.start','');
        $end = I('get.end','');
        $selectParam = I('get.selectParam','');
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
        ////////////////////////////////////////////////////////////////////////////////////////////////
        foreach ($Result as $k => &$v)
        {
            $res = $this->regionrecursive($v['rgn_atpid']);
            $date = [];
            foreach ($res as $key => $value) {
                $date[] = $value['rgn_atpid'];
            }
            $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
            ///////////////////////////////////////////////////////////////////////
            $selectparamarray = explode(',',$selectParam);
            $select_param_array = [];
            foreach ($selectparamarray as $value){
                $sql_select_param = "select * from szny_param where p_atpstatus is null and p_atpid = '$value'";
                $Result_select_param = M('param')->query($sql_select_param);
                array_push($select_param_array,$Result_select_param[0]['p_name']);
            }
            ///////////////////////////////////////////////////////////////////////
            if (null == $start) {
                $start = date('Y', strtotime('-1 year'));
                $end = date('Y', time());
            }
            ///////////////////////////////////////////////////////////////////////
            $Model_sum = M();
            $sum = strlen($start);
//            dump($sum);die();
            if (4 == $sum) {
                $sql_select_sum = "
                select
                    sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_dt between '" . $start . "' and '" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
                $Result_sum = $Model_sum->query($sql_select_sum);
//                dump($Result_sum);
//                die();
                $region = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => $sv) {
                    if (in_array('用水量', $select_param_array)) {
                        array_push($region,'用水量');
                        if (null == $sv['d2y_syslaccu'] || '' == $sv['d2y_syslaccu']) {
                            $v['ysl'] = '0t';
                            array_push($series_array_data,0);
                        } else {
                            $v['ysl'] = $sv['d2y_syslaccu'] . 't';
                            array_push($series_array_data,(int)$sv['d2y_syslaccu']);
                        }
                    }
                    if (in_array('电量值', $select_param_array)) {
                        array_push($region,'电量值');
                        if (null == $sv['d2y_dglaccu'] || '' == $sv['d2y_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2y_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_dglaccu']);
                        }
                    }
                    if (in_array('用冷量', $select_param_array)) {
                        array_push($region,'用冷量');
                        if (null == $sv['d2y_yllaccu'] || '' == $sv['d2y_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2y_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_yllaccu']);
                        }
                    }
                    if (in_array('用暖量', $select_param_array)) {
                        array_push($region,'用暖量');
                        if (null == $sv['d2y_ynlaccu'] || '' == $sv['d2y_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2y_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2y_ynlaccu']);
                        }
                    }
                }
                $v['time'] =  implode(",",$region);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            }elseif (7 == $sum){
                $sql_select_sum = "
                select
                    sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_dt between '" . $start . "' and '" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
                $Result_sum = $Model_sum->query($sql_select_sum);
//                dump($Result_sum);
//                die();
                $region = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => $sv) {
                    if (in_array('用水量', $select_param_array)) {
                        array_push($region,'用水量');
                        if (null == $sv['d2m_syslaccu'] || '' == $sv['d2m_syslaccu']) {
                            $v['ysl'] = '0t';
                            array_push($series_array_data,0);
                        } else {
                            $v['ysl'] = $sv['d2m_syslaccu'] . 't';
                            array_push($series_array_data,(int)$sv['d2m_syslaccu']);
                        }
                    }
                    if (in_array('电量值', $select_param_array)) {
                        array_push($region,'电量值');
                        if (null == $sv['d2m_dglaccu'] || '' == $sv['d2m_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2m_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_dglaccu']);
                        }
                    }
                    if (in_array('用冷量', $select_param_array)) {
                        array_push($region,'用冷量');
                        if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2m_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_yllaccu']);
                        }
                    }
                    if (in_array('用暖量', $select_param_array)) {
                        array_push($region,'用暖量');
                        if (null == $sv['d2m_ynlaccu'] || '' == $sv['d2m_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2m_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_ynlaccu']);
                        }
                    }
                }
                $v['time'] =  implode(",",$region);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            }elseif(10 == $sum){
                $sql_select_sum = "
                select
                    sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu ,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
                $Result_sum = $Model_sum->query($sql_select_sum);
//                dump($Result_sum);
//                die();
                $region = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => $sv) {
                    if (in_array('用水量', $select_param_array)) {
                        array_push($region,'用水量');
                        if (null == $sv['d2d_syslaccu'] || '' == $sv['d2d_syslaccu']) {
                            $v['ysl'] = '0t';
                            array_push($series_array_data,0);
                        } else {
                            $v['ysl'] = $sv['d2d_syslaccu'] . 't';
                            array_push($series_array_data,(int)$sv['d2d_syslaccu']);
                        }
                    }
                    if (in_array('电量值', $select_param_array)) {
                        array_push($region,'电量值');
                        if (null == $sv['d2d_dglaccu'] || '' == $sv['d2d_dglaccu']) {
                            $v['dgl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['dgl'] = $sv['d2d_dglaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_dglaccu']);
                        }
                    }
                    if (in_array('用冷量', $select_param_array)) {
                        array_push($region,'用冷量');
                        if (null == $sv['d2d_yllaccu'] || '' == $sv['d2d_yllaccu']) {
                            $v['yll'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['yll'] = $sv['d2d_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_yllaccu']);
                        }
                    }
                    if (in_array('用暖量', $select_param_array)) {
                        array_push($region,'用暖量');
                        if (null == $sv['d2d_ynlaccu'] || '' == $sv['d2d_ynlaccu']) {
                            $v['ynl'] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v['ynl'] = $sv['d2d_ynlaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2d_ynlaccu']);
                        }
                    }
                }
                $v['time'] =  implode(",",$region);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            }
        }
//        dump($Result);die();
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
}