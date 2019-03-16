<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgRepairHistoryController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【园区漫游】 / 【报警维修记录】");
        $rgn_atpid = I("get.rgn_atpid","");
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }


    public function getData()
    {
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $rgn_atpid = I("get.rgn_atpid", "");
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $tregionid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $tregionid);
        $sql_select = "
                select
                t.*,
                t1.emp_account distempaccount,
                t1.emp_name distempname,
                t2.emp_account revempaccount,
                t2.emp_name revempname,
                t3.emp_account empaccount,
                t3.emp_name empname,
                t5.dev_name dev_name,
                t5.dev_acquisition dev_acquisition,
                t6.rgn_name rgn_name
                from szny_repairlog t
                left join szny_emp t1 on t.rl_distempid = t1.emp_atpid
                left join szny_emp t2 on t.rl_revempid = t2.emp_atpid
                left join szny_emp t3 on t.rl_disposeempid = t3.emp_atpid
                left join szny_repairdetail t4 on t.rl_atpid = t4.rd_repairlogid
                left join szny_device t5 on t4.rd_deviceid =  t5.dev_atpid
                left join szny_region t6 on t5.dev_regionid = t6.rgn_atpid 
                ";

        $sql_count = "
                select
                count(1) c
                from szny_repairlog t
                left join szny_emp t1 on t.rl_distempid = t1.emp_atpid
                left join szny_emp t2 on t.rl_revempid = t2.emp_atpid
                left join szny_emp t3 on t.rl_disposeempid = t3.emp_atpid
                left join szny_repairdetail t4 on t.rl_atpid = t4.rd_repairlogid
                left join szny_device t5 on t4.rd_deviceid =  t5.dev_atpid
                left join szny_region t6 on t5.dev_regionid = t6.rgn_atpid 
                        ";

        $sql_select = $this->buildSql($sql_select, "t.rl_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rl_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t6.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_count = $this->buildSql($sql_count, "t6.rgn_atpid in (" . $rgn_atpidlist . ")");
        if (!empty($queryparam['rl_status'])) {
            $sql_select = $this->buildSql($sql_select, "t.rl_status ='" . $queryparam['rl_status'] . "'");
            $sql_count = $this->buildSql($sql_count, "t.rl_status ='" . $queryparam['rl_status'] . "'");
        }
        // 排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.rl_startdatetime desc";
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
        foreach ($Result as $key => $val) {
            $emp = $Model->query("select t.*,t1.emp_name from szny_repairlogassistant t left join szny_emp t1 on t.rla_empid = t1.emp_atpid where t.rla_repairlogid='" . $val['rl_atpid'] . "' and t.rla_atpstatus is null");
            $empname = '';
            foreach ($emp as $empkey => $empval) {
                $empname .= $empval['emp_name'] . ',';;
            }
            $empuser = substr($empname, 0, -1);
            if (empty($empuser)) {
                $empuser = '无';
            }
            $Result[$key]['empuser'] = $empuser;
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function info(){
        $rl_atpid = I('get.id','');
        $Model = M();
        $sql_select = "
                select
                t.*,
                t1.emp_account shouldempaccount,
                t1.emp_name shouldempname,
                t2.emp_account revempaccount,
                t2.emp_name revempname,
                t3.emp_account empaccount,
                t3.emp_name empname,
                t5.dev_name,
                t6.dm_name,
                t5.dev_devicemodelid
                from szny_repairlog t
                left join szny_emp t1 on t.rl_distempid = t1.emp_atpid
                left join szny_emp t2 on t.rl_revempid = t2.emp_atpid
                left join szny_emp t3 on t.rl_disposeempid = t3.emp_atpid
                left join szny_repairdetail t4 on t4.rd_repairlogid = t.rl_atpid
                left join szny_device t5 on t5.dev_atpid = t4.rd_deviceid
                left join szny_devicemodel t6 on t5.dev_devicemodelid = t6.dm_atpid
                ";

        $sql_select = $this->buildSql($sql_select, "t.rl_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.rl_atpid = '$rl_atpid'");
        $Result = $Model->query($sql_select);//dump($Result);
        $this->assign('rl_atpid',$rl_atpid);
        $this->assign('Result',$Result[0]);

        $emp= $Model->query("select t.*,t1.emp_name from szny_repairlogassistant t left join szny_emp t1 on t.rla_empid = t1.emp_atpid where rla_repairlogid='".$rl_atpid."'");
        $empname='';
        foreach($emp as $key=>$val){
            $empname.=$val['emp_name'].',';
        }
        $emp=substr($empname,0,-1);
        if(empty($emp)){
            $emp='无';
        }
        //  $emp['empname']=$empname;
        $data['0']['empuser']=$emp;
        //设备
        $sql_paerselect = "
        select * from szny_partrepairlog t left join szny_part t2 on t.ppl_partid=t2.part_atpid left join szny_repairlog t3 on t3.rl_atpid = t.ppl_repairlogid where t.ppl_atpstatus is null and t.ppl_repairlogid='".$rl_atpid."' order by t.ppl_atpid desc";
        $paerdata = $Model->query($sql_paerselect);
        $sql_callselect = "select * from szny_repairdetail t
                                left join szny_alarmrepair t2 on t2.almp_repairdetailid=t.rd_atpid
                                left join szny_alarm t3 on t3.alm_atpid=t2.almp_alarmid
                                left join szny_repairlog t4 on t4.rl_atpid=t.rd_repairlogid
                                left join szny_emp t5 on t5.emp_atpid=t3.alm_empid
                                where rd_repairlogid='".$rl_atpid."'
                                order by t.rd_atpid desc";
        $calldata = $Model->query($sql_callselect);
        $this->assign('data',$data['0']);
        $this->assign('calldata',$calldata);
        $this->assign('paerdata',$paerdata);
        $this->display();
    }

}