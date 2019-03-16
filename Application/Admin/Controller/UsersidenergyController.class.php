<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class UsersidenergyController extends BaseAuthController
{
    public function index()
    {   
        $bs=$_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户能源】");
            $page='租户';
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【租户能源】");
            $page='业主';
        }
        
        $start = I('get.start', '');
        $end = I('get.end', '');
        if(null != $start && null != $end){
            $this->assign('start',$start);
            $this->assign('end',$end);
        }else{
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
        }
        $this->assign("page",$page);
        $this->assign("bs",$bs);
        $this->display();
    }
    //获取所有数据
    public function getData(){
        $start = I('get.start','');
        $end = I('get.end','');
        $bs = I('get.bs','');
        $sum = strlen($start);
        $queryparam = json_decode(file_get_contents("php://input"), true);
        if($bs=='zh'){
            $where['us_category'] = '租户';
            $regionid = M('usersideregion')->field("usr_regionid")->join("szny_userside on szny_userside.us_atpid = szny_usersideregion.usr_usersideid")->where($where)->select();
        }elseif($bs=='yz'){
            $where['us_category'] = '业主';
            $regionid = M('usersideregion')->field("usr_regionid")->join("szny_userside on szny_userside.us_atpid = szny_usersideregion.usr_usersideid")->where($where)->select();
        }
        foreach ($regionid as $key => $value){
            $date[] = "'" . $value['usr_regionid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        // dump($endrgn_atpidsstrings);
        $Model = M();
        if (4 == $sum) {
            $sql_select = "
                select
                    t3.us_name,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t 
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2y_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_count = "
                select
                    count(1) c
                from szny_data2year t
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2y_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t2.usr_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t2.usr_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t3.us_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t3.us_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (".$endrgn_atpidsstrings.")");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid in (".$endrgn_atpidsstrings.")");
            if($bs == 'yz'){
                $sql_select = $this->buildSql($sql_select, " t3.us_category  = '业主'");
                $sql_count = $this->buildSql($sql_count, " t3.us_category  = '业主'");
            }elseif($bs == 'zh'){
                $sql_select = $this->buildSql($sql_select, " t3.us_category  = '租户'");
                $sql_count = $this->buildSql($sql_count, " t3.us_category  = '租户'");
            }
            // $sql_select = $this->buildSql($sql_select, "t3.us_category = '租户'");
            // $sql_count = $this->buildSql($sql_count, "t3.us_category = '租户'");
            //快捷搜索
            if (null != $queryparam['search']) {
                $searchcontent = trim($queryparam['search']);
                $sql_select = $sql_select ." and t3.us_name like '%" . $searchcontent . "%'";
                $sql_select = $this->buildSql($sql_select, "t3.us_name like '%" . $searchcontent . "%'");
                $sql_count = $this->buildSql($sql_count, "t3.us_name like '%" . $searchcontent . "%'");
            }
            $sql_select = $sql_select . " group by t3.us_atpid";
            $sql_count = $sql_count . " group by t3.us_atpid";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t3.us_name desc";
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
                $v['time'] = $start.'年 -- '.$end.'年';
                if (null == $v['d2y_yllaccu'] || '' == $v['d2y_yllaccu']){
                    $v['yll'] = '0KW';
                }else{
                    $v['yll'] = $v['d2y_yllaccu'].'KW';
                }
                if (null == $v['d2y_ynlaccu'] || '' == $v['d2y_ynlaccu']){
                    $v['ynl'] = '0KW';
                }else{
                    $v['ynl'] = $v['d2y_ynlaccu'].'KW';
                }
                if (null == $v['d2y_syslaccu'] || '' == $v['d2y_syslaccu']){
                    $v['ysl'] = '0t';
                }else{
                    $v['ysl'] = $v['d2y_syslaccu'].'t';
                }
                if (null == $v['d2y_dglaccu'] || '' == $v['d2y_dglaccu']){
                    $v['dgl'] = '0KW';
                }else{
                    $v['dgl'] = $v['d2y_dglaccu'].'KW';
                }
            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '年'));
        } else if (7 == $sum) {
            $Model = M();
            $sql_select = "
                select
                 t3.us_name,t3.us_status,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t 
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2m_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_count = "
                select
                  count(1) c
                from szny_data2month t 
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2m_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2m_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2m_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t2.usr_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t2.usr_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t3.us_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t3.us_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2m_dt between '" . $start . "'and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2m_dt between '" . $start . "' and '" . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2m_regionid in (".$endrgn_atpidsstrings.")");
            $sql_count = $this->buildSql($sql_count, "t.d2m_regionid in (".$endrgn_atpidsstrings.")");
            if($bs == 'yz'){
                $sql_select = $this->buildSql($sql_select, "t3.us_category  = '业主'");
                $sql_count = $this->buildSql($sql_count, "t3.us_category  = '业主'");
            }elseif($bs == 'zh'){
                $sql_select = $this->buildSql($sql_select, "t3.us_category  = '租户'");
                $sql_count = $this->buildSql($sql_count, "t3.us_category  = '租户'");
            }
            // $sql_select = $this->buildSql($sql_select, "t3.us_category = '租户'");
            // $sql_count = $this->buildSql($sql_count, "t3.us_category = '租户'");

            //快捷搜索
            if (null != $queryparam['search']) {
                $searchcontent = trim($queryparam['search']);
                $sql_select = $sql_select ." and t3.us_name like '%" . $searchcontent . "%'";
                $sql_select = $this->buildSql($sql_select, "t3.us_name like '%" . $searchcontent . "%'");
                $sql_count = $this->buildSql($sql_count, "t3.us_name like '%" . $searchcontent . "%'");
            }
            $sql_select = $sql_select . " group by t3.us_atpid";
            $sql_count = $sql_count . " group by t3.us_atpid";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t3.us_name desc";
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
                $v['time'] = $start.' -- '.$end;
                if (null == $v['d2m_yllaccu'] || '' == $v['d2m_yllaccu']){
                    $v['yll'] = '0KW';
                }else{
                    $v['yll'] = $v['d2m_yllaccu'].'KW';
                }
                if (null == $v['d2m_ynlaccu'] || '' == $v['d2m_ynlaccu']){
                    $v['ynl'] = '0KW';
                }else{
                    $v['ynl'] = $v['d2m_ynlaccu'].'KW';
                }
                if (null == $v['d2m_syslaccu'] || '' == $v['d2m_syslaccu']){
                    $v['dgl'] = '0t';
                }else{
                    $v['dgl'] = $v['d2m_syslaccu'].'t';
                }
                if (null == $v['d2m_dglaccu'] || '' == $v['d2m_dglaccu']){
                    $v['dgl'] = '0KW';
                }else{
                    $v['dgl'] = $v['d2m_dglaccu'].'KW';
                }

            }
            // echo $Model->_sql();die();
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '月'));
        } else if (10 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t3.us_name,t3.us_status,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2d_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_count = "
                select
                    count(1) c
                from szny_data2day t
                left join szny_usersideregion t2 on t2.usr_regionid = t.d2d_regionid
                left join szny_userside t3 on t2.usr_usersideid = t3.us_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2d_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t2.usr_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t2.usr_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t3.us_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t3.us_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt between '" . $start . "' and' " . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid in (".$endrgn_atpidsstrings.")");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid in (".$endrgn_atpidsstrings.")");
            if($bs == 'yz'){
                $sql_select = $this->buildSql($sql_select, "t3.us_category  = '业主'");
                $sql_count = $this->buildSql($sql_count, "t3.us_category  = '业主'");
            }elseif($bs == 'zh'){
                $sql_select = $this->buildSql($sql_select, "t3.us_category  = '租户'");
                $sql_count = $this->buildSql($sql_count, "t3.us_category  = '租户'");
            }
            // $sql_select = $this->buildSql($sql_select, "t3.us_category = '租户'");
            // $sql_count = $this->buildSql($sql_count, "t3.us_category = '租户'");
            //快捷搜索
            if (null != $queryparam['search']) {
                $searchcontent = trim($queryparam['search']);
                $sql_select = $sql_select ." and t3.us_name like '%" . $searchcontent . "%'";
                $sql_select = $this->buildSql($sql_select, "t3.us_name like '%" . $searchcontent . "%'");
                $sql_count = $this->buildSql($sql_count, "t3.us_name like '%" . $searchcontent . "%'");
            }
            $sql_select = $sql_select . " group by t3.us_atpid";
            $sql_count = $sql_count . " group by t3.us_atpid";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t3.us_name desc";
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
                $v['time'] = $start.' -- '.$end;
                if (null == $v['d2d_yllaccu'] || '' == $v['d2d_yllaccu']){
                    $v['yll'] = '0KW';
                }else{
                    $v['yll'] = $v['d2d_yllaccu'].'KW';
                }
                if (null == $v['d2d_ynlaccu'] || '' == $v['d2d_ynlaccu']){
                    $v['ynl'] = '0KW';
                }else{
                    $v['ynl'] = $v['d2d_ynlaccu'].'KW';
                }
                if (null == $v['d2d_syslaccu'] || '' == $v['d2d_syslaccu']){
                    $v['ysl'] = '0t';
                }else{
                    $v['ysl'] = $v['d2d_syslaccu'].'t';
                }
                if (null == $v['d2d_dglaccu'] || '' == $v['d2d_dglaccu']){
                    $v['dgl'] = '0KW';
                }else{
                    $v['dgl'] = $v['d2d_dglaccu'].'KW';
                }

            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '日'));
        }
    }
}