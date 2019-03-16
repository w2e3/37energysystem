<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DatacontrastanalyzeController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据对比】 / 【同比环比】");
        $ids = I("get.ids","");
        $this->assign('ids',$ids);
        /////////////////////////////////////////////////////////////////////
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
            //////////////////////////////////////////////////////////////////
            $sum = strlen($start);
            if ( 4 == $sum){
                $columns = [];
                $columns[] =array('field'=>'本期值','title'=>'本期值');
                $columns[] =array('field'=>'上期值','title'=>'上期值');
                $columns[] =array('field'=>'同比','title'=>'同比');
                $this->assign('columns',$columns);
            }elseif(7 == $sum){
                $columns = [];
                $columns[] =array('field'=>'本期值','title'=>'本期值');
                $columns[] =array('field'=>'上期值','title'=>'上期值');
                $columns[] =array('field'=>'去年同期值','title'=>'去年同期值');
                $columns[] =array('field'=>'同比','title'=>'同比');
                $columns[] =array('field'=>'环比','title'=>'环比');
                $this->assign('columns',$columns);
            }
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
        //////////////////////////////////////////////////////////////////////
            $columns = [];
            $columns[] =array('field'=>'本期值','title'=>'本期值');
            $columns[] =array('field'=>'上期值','title'=>'上期值');
            $columns[] =array('field'=>'同比','title'=>'同比');
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
    //详情
    public function getData(){
        $start = I('get.start','');
        $end = I('get.end','');
        /////////////////////////////////////////////////
        $ids = I('get.ids','');
        $idarray = explode(',',$ids);
        $endstring = "'".implode("','",$idarray)."'";
//        echo $endstring;die();
        $sum = strlen($start);
        if (4 == $sum) {
            $queryparam = json_decode(file_get_contents("php://input"), true);
            $offset = $queryparam['offset'];
            $limit = $queryparam['limit'];
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2y_dt from szny_data2year t where t.d2y_atpstatus is null and t.d2y_dt between '$start' and '$end' group by t.d2y_dt order by t.d2y_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
//        dump($result);
            /*******************************************************************************/
            $select_param_id = I('get.selectParam','');//dump($select_param_id);die();
            $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
            $select_param = $Result_select_param['p_name'];
            /*******************************************************************************/
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
//            dump($Result_sum_current_value);die();
                $last = $time -1;
                $sql_select_sum_last_value = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt = '$last' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model->query($sql_select_sum_last_value);
//            dump($Result_sum_last_value);die();
                foreach ($Result_sum_current_value as $rck => $rcv){
                    foreach ($Result_sum_last_value as $rlk => $rlv){
                        if ('用水量' == $select_param) {
                            $v['category'] = '用水量';
                            if (null == $rcv['d2y_syslaccu'] || '' == $rcv['d2y_syslaccu']) {
                                $v['本期值'] = '0T';
                            }else{
                                $v['本期值'] =$rcv['d2y_syslaccu'].'T';
                            }
                            if (null == $rlv['d2y_syslaccu'] || '' == $rlv['d2y_syslaccu']) {
                                $v['上期值'] = '0T';
                            }else{
                                $v['上期值'] =$rlv['d2y_syslaccu'].'T';
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
//            dump($result);die();
            $Result = array_slice($result,$offset,$limit) ;
            echo json_encode(array('total' => count($result), 'rows' => $Result));
        }elseif (7 == $sum){
            $queryparam = json_decode(file_get_contents("php://input"), true);
            $offset = $queryparam['offset'];
            $limit = $queryparam['limit'];
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by t.rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2m_dt from szny_data2month t where t.d2m_atpstatus is null and t.d2m_dt between '".$start."' and '".$end."' group by t.d2m_dt order by t.d2m_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
//        dump($result);
            /*******************************************************************************/
            $select_param_id = I('get.selectParam','');//dump($select_param_id);die();
            $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
            $select_param = $Result_select_param['p_name'];
            /*******************************************************************************/
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
//            dump($Result_sum_current_value);die();
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
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $sql_select_sum_last_month_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$last_month."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_month_value = $Model->query($sql_select_sum_last_month_value);
//            dump($Result_sum_last_value);die();
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
            ////////////////////////////////////////////////////////////
            $serices_shangqizhi = [];
            $serices_shangqizhi['name'] = '上期值';
            $serices_shangqizhi['stack'] = 2;
            $serices_shangqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_shangqizhi_data,(int)$rv['上期值']);
            }
            $serices_shangqizhi['data'] = $serices_shangqizhi_data;
            ////////////////////////////////////////////////////////////
            $serices_qunianzhi = [];
            $serices_qunianzhi['name'] = '去年同期值';
            $serices_qunianzhi['stack'] = 3;
            $serices_qunianzhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_qunianzhi_data,(int)$rv['去年同期值']);
            }
            $serices_qunianzhi['data'] = $serices_qunianzhi_data;
            /// ////////////////////////////////////////////////////////
            $series = [];
            array_push($series,$serices_benqizhi);
            array_push($series,$serices_shangqizhi);
            array_push($series,$serices_qunianzhi);
            foreach ($result as $k => &$v){
                $v['series'] = $series;
            }
//            dump($result);die();
            $Result = array_slice($result,$offset,$limit) ;
            echo json_encode(array('total' => count($result), 'rows' => $Result));
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