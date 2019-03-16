<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgItemAnalyzesController extends BaseAuthController
{
    public function index()
    {
        $Model = M();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【分项报表】");
        $rgn_atpid = I('get.rgn_atpid', '');
        $this->assign('rgn_atpid', $rgn_atpid);
        $selsect_param = I('get.param', '');
        if(empty($selsect_param)){
            $sql_list = "select p_atpid from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $mod = $Model->query($sql_list);
            $date = [];
            foreach ($mod as $key => $value){
                $date[] = $value['p_atpid'];
            }
            $selsect_param = implode(',', $date);
        }
        // dump($selsect_param);
        $this->assign('selectparam', $selsect_param);
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
        $parammore = I('get.param','');
        // dump($parammore);
        if (null == $parammore){
            
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v){
                // if ('用冷量' == $v['p_name']){
                    $v['aux_selected'] = '是';
                // }
            }
            $this->assign('param',$param);
            $columns = [];
            $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
            $columns[] =array_push($columns,array('field'=>'ysl','title'=>'用水量'));
            $columns[] =array_push($columns,array('field'=>'ynl','title'=>'用暖量'));
            $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
            unset($columns[1]);
            unset($columns[3]);
            unset($columns[5]);
            unset($columns[7]);
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
                        break;
                    }
                }
            }
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
    }
	//获取所有数据
    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
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
        $param = I('get.param','');
        if (null == $param){
            $sql_select_param = "select * from szny_param t where t.p_atpstatus is null and t.p_name ='用冷量'";
            $data_select = $Model->query($sql_select_param);
            $selectparam = array();
            foreach ($data_select as $k => $v){
                array_push($selectparam,$v['p_atpid']);
            }
            $selectparam = implode(',',$selectparam);
            $selectparam = "'".$selectparam."'";
        }else{
            $selectparamarray = explode(',',$param);
            $selectparam = "'".implode("','",$selectparamarray)."'";
        }
        $sql_select_region = "
        select 
        t.etr_regionid
        from szny_energytyperegion t 
        left join szny_energytype t1 on t.etr_energytypeid = t1.et_atpid
        left join szny_param t2 on t2.p_energytypeid = t1.et_atpid
        where t.etr_atpstatus is null and t1.et_atpstatus is null and t2.p_atpstatus is null
        and t2.p_atpid in (".$selectparam.")
        ";
        $Result_region = $Model ->query($sql_select_region);
        $select_region = [];
        foreach ($Result_region as $k => $v){
            array_push($select_region,$v['etr_regionid']);
        }
        $endrgn_atpidsarray = array_intersect($date,$select_region);
        $endrgn_atpidsstrings = "'". implode("','", $endrgn_atpidsarray)."'" ;
        $start = I('get.start','');
        $end = I('get.end','');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        if(null == $start){
            $start = date('Y',strtotime('-1 year'));
            $end = date('Y',time());
        }
        $select_param_strings = substr($selectparam,1,strlen($selectparam)-2);
        $param_select = explode("','",$select_param_strings);
        $select_param_array = [];
        foreach ($param_select as $v){
            $select_param = "select p_name from szny_param where p_atpid = '$v'";
            $Result_select_param = $Model->query($select_param);
            array_push($select_param_array,$Result_select_param[0]['p_name']);
        }
        $sum = strlen($start);
        if (4 == $sum) {
            $sql_select = "
                select
                    t1.rgn_name,t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    t.d2y_dt,count(1) c
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2y_dt";
            $sql_count = $sql_count . " group by t.d2y_dt";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2y_dt asc";
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
            foreach ($Result as $k => &$v) {
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
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '年'));
        } else if (7 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t1.rgn_name,t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    t.d2m_dt,count(1) c
                from szny_data2month t
                 left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2m_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2m_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2m_dt between '" . $start . "'and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2m_dt between '" . $start . "' and '" . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2m_dt";
            $sql_count = $sql_count . " group by t.d2m_dt";

            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2m_dt desc";
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
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '月'));
        } else if (10 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t1.rgn_name,t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    count(1) c
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2d_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt between '" . $start . "' and' " . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ") ");
            $sql_select = $sql_select . " group by t.d2d_dt";
            $sql_count = $sql_count . " group by t.d2d_dt";

            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2d_dt desc";
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
                        $v['ysl'] = '0KW';
                    }else{
                        $v['ysl'] = $v['d2d_syslaccu'].'KW';
                    }
                }
            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '日'));
        }
    }
}
