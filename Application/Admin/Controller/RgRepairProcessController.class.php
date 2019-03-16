<?php
namespace Admin\Controller;
use Think\Controller;
class RgRepairProcessController extends BaseController
{
    public function index(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【维修单处理】");
        $this->display();
    }

    public function getData()
    {
        $rgn_atpid = I("get.rgn_atpid", "");
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $tregionid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $tregionid);

        $queryparam = json_decode(file_get_contents("php://input"), true);
        $rols = session('emp_rolss');
        $emp_atpid = session('emp_atpid');
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
                left join szny_region t6 on t5.dev_regionid = t6.rgn_atpid ";

        $sql_select = $this->buildSql($sql_select, "t.rl_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rl_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.rl_status = '待处理'");
        $sql_count = $this->buildSql($sql_count, "t.rl_status = '待处理'");
        $sql_select = $this->buildSql($sql_select, "t6.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_count = $this->buildSql($sql_count, "t6.rgn_atpid in (" . $rgn_atpidlist . ")");

        if(session('role_isadmin')!=true){
            $sql_select = $this->buildSql($sql_select, "t.rl_distempid='$emp_atpid'");
            $sql_count = $this->buildSql($sql_count, "t.rl_distempid = '$emp_atpid'");
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
            $emp = $Model->query("select t.*,t1.emp_name from szny_repairlogassistant t left join szny_emp t1 on t.rla_empid = t1.emp_atpid where rla_repairlogid='" . $val['rl_atpid'] . "'");
            $empname = '';
            foreach ($emp as $empkey => $empval) {
                $empname .= $empval['emp_name'] . ',';;
            }

            $empuser = substr($empname, 0, -1);
            if (empty($empuser)) {
                $empuser = '无';
            }
            //  $emp['empname']=$empname;
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


    public function word(){
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
        $Result = $Model->query($sql_select);
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

    //验证
    function partadd(){
        $data=$_POST;
        $repairlog = M('partrepairlog');
        $condition['ppl_repairlogid']=array('eq',$data['ppl_repairlogid']);
        $condition['ppl_partid']=array('eq',$data['ppl_partid']);
        $condition['ppl_atpstatus']=array('exp','is null');
        $parts=$repairlog->where($condition)->find();
        //判断是否原来存在，是否更新
        if(!empty($parts)){
            // var_dump($data);
            $parts['ppl_outdevicemodel']= $parts['ppl_outdevicemodel']+$data['ppl_outdevicemodel'];
            $parts['ppl_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $parts['ppl_atplastmodifyuser'] = session('emp_account');
            $repairlog->where($condition)->save($parts);
        }else{
            $data['ppl_atpid']= $this->makeGuid();
            $data['ppl_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['ppl_atpcreateuser'] = session('emp_account');
            $data['ppl_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['ppl_atplastmodifyuser'] = session('emp_account');
            $repairlog->add($data);
        }
    }


    //存储数据
    public function partupdateshow(){
        $rl_atpid = I('post.rl_atpid','');
        $ppl_atpid = I('post.ppl_atpid','');
        $where['ppl_repairlogid'] = $rl_atpid;
        if($ppl_atpid){
            $savebj = M('partrepairlog')->join("szny_part on szny_partrepairlog.ppl_partid=szny_part.part_atpid")->find($ppl_atpid);
        }else{
            $savebj = M('partrepairlog')->join("szny_part on szny_partrepairlog.ppl_partid=szny_part.part_atpid")->where($where)->find();
        }
        $this->ajaxReturn($savebj);
    }

    //验证
    public function partupdate(){
        $data=$_POST;
        $repairlog = M('partrepairlog');
        $where['ppl_atpid'] = $data['ppl_atpid'];
        $parts['ppl_outdevicemodel']= $data['ppl_outdevicemodel'];
        $parts['ppl_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
        $parts['ppl_atplastmodifyuser'] = session('emp_account');
        $res = $repairlog->where($where)->save($parts);
    }

    //验证
    function partdel(){
        $id = I('post.ppl_atpid','');
        if($id){
            $where['ppl_atpid'] = $id;
            $data['ppl_atpstatus'] = 'DEL';
            $data['ppl_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['ppl_atplastmodifyuser'] = session('emp_account');
            $del = M("partrepairlog")->where($where)->save($data);
        }
    }




    //验证
    public function handle()
    {
        $rl_atpid = I('get.id','');
        $Model = M();
        //查询维修单
        $sql_select = "select * from szny_repairlog where rl_atpid = "."'".$rl_atpid."'";
        $data = $Model->query($sql_select);
        $this->assign('data',$data[0]);
        //查询配置
        $config=$Model->query("select * from szny_config where cfg_atpid='guidE6DE1C23-A5EA-428C-BE96-CB511D52BB29'");
        $configvalue=explode(',',$config['0']['cfg_value']);
        $this->assign('configvalue',$configvalue);
        //查询配件
        $sql = "select * from szny_part t where t.part_atpstatus is null";
        $part = $Model->query($sql);
        $this->assign('part',$part);
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【维修单处理】");
    }
    //验证
    function getDataPart()
    {
        $ppl_repairlogid = I("get.ppl_repairlogid", "");
        $Model = M();
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $sql_select = "select * from szny_partrepairlog t left join szny_part t2 on t2.part_atpid=t.ppl_partid where t.ppl_repairlogid='" . $ppl_repairlogid . "' and t.ppl_atpstatus is null";
        $sql_count = " select count(1) c from szny_partrepairlog t left join szny_part t2 on t2.part_atpid=t.ppl_partid where t.ppl_repairlogid='" . $ppl_repairlogid . "' and t.ppl_atpstatus is null";
        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.ppl_atpcreatedatetime desc";
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
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
    //验证
    public function handlesubmit(){
        $rl_atpid = I('post.rl_atpid','');
        $rl_disposedate = I('post.rl_disposedate','');
        $rl_disposemethod = I('post.rl_disposemethod','');
        $rl_disposeresult = I('post.rl_disposeresult','');
        $rl_status = I('post.rl_status','');
        $emp_atpid=session('emp_atpid');
        $Model = M();
        $sql_update1 = "
              update szny_repairlog set
              rl_disposemethod =" . "'" .$rl_disposemethod."'" . ",
              rl_disposeresult = "."'" .$rl_disposeresult."'".",
              rl_disposedate = " ."'" .$rl_disposedate. "'" .",
              rl_status = " ."'" .$rl_status. "'" .",
              rl_disposeempid= " ."'" .$emp_atpid. "'" ."
              where rl_atpid = " ."'" .$rl_atpid. "'";
        $res1 = $Model->execute($sql_update1);
        $sql_update2 = "
update szny_alarm set alm_confirmstatus = '已处理'
where alm_atpid in (select
t.almp_alarmid
from szny_alarmrepair t
left join szny_repairdetail t1 on t.almp_repairdetailid = t1.rd_atpid
left join szny_repairlog t2 on t2.rl_atpid = t1.rd_repairlogid
where t2.rl_atpid ='$rl_atpid')";
        $res2 = $Model->execute($sql_update2);
    }


    public function handlepart()
    {
        $rl_atpid = I('get.id','');
        $Model = M();
        //查询维修单
        $sql_select = "select * from szny_repairlog where rl_atpid = "."'".$rl_atpid."'";
        $data = $Model->query($sql_select);
        $this->assign('data',$data[0]);
        //查询配置
        $config=$Model->query("select * from szny_config where cfg_atpid='guidE6DE1C23-A5EA-428C-BE96-CB511D52BB29'");
        $configvalue=explode(',',$config['0']['cfg_value']);
        $this->assign('configvalue',$configvalue);
        //查询配件
        $sql = "select * from szny_part t where t.part_atpstatus is null";
        $part = $Model->query($sql);
        $this->assign('part',$part);
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【维修单处理】");
    }











    public function __repairpeoplesubmitdata(){
        $rl_atpid = I('post.rl_atpid','');
        $rl_disposedate = I('post.rl_disposedate','');
        $rl_disposemethod = I('post.rl_disposemethod','');
        $rl_disposeresult = I('post.rl_disposeresult','');

        $Model = M();
        $sql_update = "
          update szny_repairlog set
          rl_disposemethod =" . "'" .$rl_disposemethod."'" . ",
          rl_disposeresult = "."'" .$rl_disposeresult."'".",
          rl_disposedate = " ."'" .$rl_disposedate. "'" .",
          rl_status = " ."'已处理'" ."
          where rl_atpid = " ."'" .$rl_atpid. "'";
        $res = $Model->execute($sql_update);

        if($res){
            $sql_select = "
              select
              t.almp_alarmid
              from szny_alarmrepair t
              left join szny_repairdetail t1 on t.almp_repairdetailid = t1.rd_atpid
              left join szny_repairlog t2 on t2.rl_atpid = t1.rd_repairlogid
              where t2.rl_atpid = " ."'" .$rl_atpid. "'" ;
            $alarm = $Model->query($sql_select);
            foreach ($alarm as $key => $value) {
                $sql = "
                update szny_alarm set
                alm_confirmstatus = '已处理'
                where alm_atpid = " ."'" .$value['almp_alarmid']. "'";
                $Model->execute($sql);
            }
        }
    }
}