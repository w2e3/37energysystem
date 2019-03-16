<?php
namespace Admin\Controller;
use Think\Controller;
class TwicedataHistoryController extends BaseController
{
    public function index()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【审批中心】 / 【全部数据修改单】");
    }

    public function getData(){
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					t.*,t1.emp_name as startempname,t2.emp_name as agreeempname
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				";
        $sql_count = "
				select
					count(1) c
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				";
        $sql_select = $this->buildSql($sql_select, "t.d2mdf_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2mdf_atpstatus is null");

//        //如果是物业人员只显示自己的维修单
//        if(session()['role_iswy']==true)
//        {
//          $sql_select = $this->buildSql($sql_select, "t.d2mdf_startempid='".session('emp_atpid')."'");
//          $sql_select = $this->buildSql($sql_count, "t.d2mdf_startempid='".session('emp_atpid')."");
//        }

        if (null != $queryparam['search_agreestatus']) {
            $searchcontent = trim($queryparam['search_agreestatus']);
            $sql_select = $this->buildSql($sql_select, "t.d2mdf_agreestatus ='".$searchcontent."'");
            $sql_count = $this->buildSql($sql_count, "t.d2mdf_agreestatus ='".$searchcontent."'");
        }

        //快捷搜索
//        if (null != $queryparam['search']) {
//            $searchcontent = trim($queryparam['search']);
//            $sql_select = $this->buildSql($sql_select, "t.d2mdf_name like '%" . $searchcontent . "%'");
//            $sql_count = $this->buildSql($sql_count, "t.d2mdf_name like '%" . $searchcontent . "%'");
//        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.d2mdf_startdt desc";
        }
        //自定义分页
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);//dump($Result);
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function xiangqing()
    {
        $id = $_GET['d2mdf_atpid'];
        $Model = M();
        $sql_select = "
				select
					t.*,t1.emp_name as startempname,t2.emp_name as agreeempname
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				where t.d2mdf_atpstatus is null and t.d2mdf_atpid ='$id'
				";
        $Result = $Model->query($sql_select);
        $this->assign('data', $Result[0]);
        $this->display();
    }

    public function getXiangqingData(){
        $d2mdf_atpid = $_GET['d2mdf_atpid'];
        $where = "t.d2mdfd_data2modifyid = '$d2mdf_atpid'";
        $Model = M();
        $sql_select = "
                SELECT group_concat(CONCAT(t1.p_name,':',t.d2mdfd_newvalue,' ',t1.p_unit) separator '<br/>') info ,t.*,t2.*
                FROM `szny_data2modifydetail` t
                left join szny_param t1 on t.d2mdfd_paramid = t1.p_atpid
                left join szny_region t2 on t.d2mdfd_regionid = t2.rgn_atpid
                where t.d2mdfd_atpstatus is null and  $where
                group by t.d2mdfd_group
                order by t.d2mdfd_atpsort asc";
//        echo $sql_select;
        $Result = $Model->query($sql_select, $sql_select);
        echo json_encode(array('total' => count($Result), 'rows' => $Result));
    }
}