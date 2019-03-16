<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DatacontrastrankController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据对比】 / 【排名】");
        $ids = I("get.ids","");
        $this->assign('ids',$ids);
//        //////////////////////////////////
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
            $sum = strlen($start);
            if ( 4 == $sum){
                $Model_columns = M('data2year');
                $sql_select_columns = "select t.d2y_dt from szny_data2year t where t.d2y_dt between '".$start."' and '".$end."' group by t.d2y_dt order by t.d2y_dt desc";
                $Result_column = $Model_columns->query($sql_select_columns);
                $columns = [];
                foreach ($Result_column as $k => $v){
                    array_push($columns,$v['d2y_dt']);
                }
                $this->assign('columns',$columns);
            }elseif(7 == $sum){
                $Model_columns = M('data2month');
                $sql_select_columns = "select t.d2m_dt from szny_data2month t where t.d2m_dt between '".$start."' and '".$end."' group by t.d2m_dt order by t.d2m_dt desc";
                $Result_column = $Model_columns->query($sql_select_columns);
                $columns = [];
                foreach ($Result_column as $k => $v){
                    array_push($columns,$v['d2m_dt']);
                }
//                dump($columns);
                $this->assign('columns',$columns);
            }elseif(10 == $sum){
                $Model_columns = M('data2day');
                $sql_select_columns = "select t.d2d_dt from szny_data2day t where t.d2d_atpstatus is null and t.d2d_dt between '".$start ."' and '".$end ."' group by t.d2d_dt order by t.d2d_dt desc";
                $Result_column = $Model_columns->query($sql_select_columns);
                $columns = [];
                foreach ($Result_column as $k => $v){
                    array_push($columns,$v['d2d_dt']);
                }
//                dump($columns);
                $this->assign('columns',$columns);
            }
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
            //////////////////////////////////////////
            $Model_columns = M('data2year');
            $sql_select_columns = "select t.d2y_dt from szny_data2year t where t.d2y_dt between " . $lyear . " and " . $tyear . " group by t.d2y_dt order by t.d2y_dt desc";
            $Result_column = $Model_columns->query($sql_select_columns);
            $columns = [];
            foreach ($Result_column as $k => $v){
                array_push($columns,$v['d2y_dt']);
            }
            $this->assign('columns',$columns);
        }
        ////////////////////////////////////////////
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
        ////////////////////////////////////////////////////////
        $this->display();
    }
    //详情
    public function getData()
    {
        $ids = I('get.ids','');
        $start = I('get.start','');
        $end = I('get.end','');
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
        $select_param_id = I('get.selectParam','');//dump($select_param_id);
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
                $sql_select_sum = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid 
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_dt between '" . $start . "' and'" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
                $sql_select_sum = $sql_select_sum . " group by t.d2y_dt order by t.d2y_dt desc";
                $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => $sv) {
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
                $v['time'] =  implode(",",$time);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            } else if (7 == $sum) {
                $Model_sum = M();
                $sql_select_sum = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_dt between '" . $start . "'and '" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
                $sql_select_sum = $sql_select_sum . " group by t.d2m_dt";
                $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => &$sv) {
                    if ('用冷量'== $select_param) {
                        $v['category'] = '用冷量';
                        if (null == $sv['d2m_yllaccu'] || '' == $sv['d2m_yllaccu']) {
                            $v[$sv['d2m_dt']] = '0KW';
                            array_push($series_array_data,0);
                        } else {
                            $v[$sv['d2m_dt']] = $sv['d2m_yllaccu'] . 'KW';
                            array_push($series_array_data,(int)$sv['d2m_yllaccu']);
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
                $v['time'] =  implode(",",$time);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            } else if (10 == $sum) {
                $Model_sum = M();
                $sql_select_sum = "
                select
                    t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t1.rgn_atpstatus is null");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
                $sql_select_sum = $this->buildSql($sql_select_sum, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
                $sql_select_sum = $sql_select_sum . " group by t.d2d_dt";
                $Result_sum = $Model_sum->query($sql_select_sum);
                $time = [];
                $series_array = [];
                $series_array['name'] = $v['rgn_name'];
                $series_array_data = [];
                foreach ($Result_sum as $sk => &$sv) {
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
                $v['time'] =  implode(",",$time);
                $series_array['data'] = $series_array_data;
                $v['series'] =$series_array;
                $v['series']['stack'] = $k + 1;
            }
        }
//        dump($Result);die();
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
}