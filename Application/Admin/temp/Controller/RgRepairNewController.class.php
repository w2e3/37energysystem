<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgRepairNewController extends BaseAuthController
{
    public function index()
    {
        $this->getEmp();
        $this->display();
    }

    public function getEmp(){
        $Model = M();
        $sql = "select * from szny_emp t where t.emp_atpstatus is null and emp_category !='管理员'";
        $emp = $Model->query($sql);
        $this->assign('emp',$emp);
    }

    public function getAlarmData()
    {
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $trgn_atpid);
        $queryparam = json_decode(file_get_contents("php://input"), true);

        $sql_select = "
				select
					*
				from szny_alarm t
				left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
				left join szny_emp t2 on t.alm_empid = t2.emp_atpid
				left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
				";
        $sql_count = "
				select
                    count(*) c
                from szny_alarm t
                left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
				";
        $sql_select = $this->buildSql($sql_select, "t.alm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.alm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.alm_confirmstatus = '已确认'");
        $sql_count = $this->buildSql($sql_count, "t.alm_confirmstatus = '已确认'");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_count = $this->buildSql($sql_count, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t3.rgn_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t3.rgn_name like '%" . $searchcontent . "%'");
        }
//        if (null != $queryparam['rgn_name']) {
//            $searchcontent = trim($queryparam['rgn_name']);
//            $sql_select = $this->buildSql($sql_select, "t3.rgn_name like '%" . $searchcontent . "%'");
//            $sql_count = $this->buildSql($sql_count, "t3.rgn_name like '%" . $searchcontent . "%'");
//        }
        if (null != $queryparam['alm_level']) {
            $searchcontent = trim($queryparam['alm_level']);
            $sql_select = $this->buildSql($sql_select, "t.alm_level like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_level like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['alm_content']) {
            $searchcontent = trim($queryparam['alm_content']);
            $sql_select = $this->buildSql($sql_select, "t.alm_content like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_content like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['alm_category']) {
            $searchcontent = trim($queryparam['alm_category']);
            $sql_select = $this->buildSql($sql_select, "t.alm_category like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_category like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['dev_name']) {
            $searchcontent = trim($queryparam['dev_name']);
            $sql_select = $this->buildSql($sql_select, "t1.dev_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t1.dev_name like '%" . $searchcontent . "%'");
        }
        if (null != $_GET['dev_atpid']) {
            $searchcontent = trim($_GET['dev_atpid']);
            $sql_select = $this->buildSql($sql_select, "t1.dev_atpid like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t1.dev_atpid like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['almp_floor']) {
            $searchcontent = trim($queryparam['almp_floor']);
            $sql_select = $this->buildSql($sql_select, "t4.almp_floor >= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t4.almp_floor >= '" . $searchcontent . "'");
        }
        if (null != $queryparam['almp_upper']) {
            $searchcontent = trim($queryparam['almp_upper']);
            $sql_select = $this->buildSql($sql_select, "t4.almp_upper <= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t4.almp_upper <= '" . $searchcontent . "'");
        }
        if (null != $queryparam['alm_datetime_start']) {
            $searchcontent = trim($queryparam['alm_datetime_start']);
            $sql_select = $this->buildSql($sql_select, "t.alm_datetime >= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t.alm_datetime >= '" . $searchcontent . "'");
        }
        if (null != $queryparam['alm_datetime_end']) {
            $searchcontent = trim($queryparam['alm_datetime_end']);
            $sql_select = $this->buildSql($sql_select, "t.alm_datetime <= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t.alm_datetime <= '" . $searchcontent . "'");
        }
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.alm_datetime asc";
        }
        //自定义分页
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
//        echo $_GET['dev_atpid'];
//        echo $sql_select;
//        die();
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);
        $alarmconfig_atpid = [];
        foreach ($Result as $k => $v) {
            array_push($alarmconfig_atpid, $v['almc_atpid']);
            $v['value_param'] = '';
        }
        $ModelParam = M();
        $sql_selectparam= "
				select
					*
				from szny_alarmparam t
				left join szny_devicemodelparam t1 on t.almp_paramid = t1.dmp_atpid
				where t.almp_atpstatus is null and t1.dmp_atpstatus is null
				and t.almp_alarmid in ('".implode("','",$alarmconfig_atpid)."')
				order by t1.dmp_atpcreatedatetime asc  ";
        $Result_rel = $ModelParam->query($sql_selectparam);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['almc_atpid'] == $rmv['almp_alarmid']) {
                    if ($v['value_param'] != '') {
                        $v['value_param'] = $v['value_param'] . "<br/>" . $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    } else {
                        $v['value_param'] = $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    }
                }
            }
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function submit()
    {
        $dev_atpid = I('post.dev_atpid', '');
        $rl_name = I('post.rl_name', '');
        $rl_startdatetime = I('post.rl_startdatetime', '');
        $rl_describe = I('post.rl_describe', '');
        $rl_plandate = I('post.rl_plandate', '');
        $rl_distempid = I('post.rl_distempid', '');//dump($rl_empid);
        $rla_empid = I('post.rla_empid', '');//dump(dev_atpid);
        //添加维修单
        $repairlog = M('repairlog');
        $rl_atpid = $this->makeGuid();
        $data['rl_atpid'] = $rl_atpid;
        $data['rl_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
        $data['rl_atpcreateuser'] = session('emp_account');
        $data['rl_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
        $data['rl_atplastmodifyuser'] = session('emp_account');
        $data['rl_code'] = $this->makeRepairlogNo();
        $data['rl_name'] = $rl_name;
        $data['rl_describe'] = $rl_describe;
        $data['rl_startdatetime'] = $rl_startdatetime;
        $data['rl_plandate'] = $rl_plandate;
        $data['rl_distempid'] = $rl_distempid;
        $data['rl_status'] = "待接单";
        $repairlog->add($data);
        //添加维修单详情
        $dat['rd_atpid'] = $this->makeGuid();
        $dat['rd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
        $dat['rd_atpcreateuser'] = session('emp_account');
        $dat['rd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
        $dat['rd_atplastmodifyuser'] = session('emp_account');
        $dat['rd_deviceid'] = $dev_atpid;
        $dat['rd_repairlogid'] = $data['rl_atpid'];
        $repairdetail = M('repairdetail');
        $repairdetail->add($dat);
        //添加维修单报警关系
        $Model_alarmrepairm = M("alarmrepair");
        $Model_alarm = M("alarm");
        $result_alarm=I('post.alm_atpid', '');
        for ($i = 0; $i < count($result_alarm); $i++) {
            $dataalarmrepairm = array();
            $dataalarmrepairm['almp_atpid'] = $this->makeGuid();
            $dataalarmrepairm['almp_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
            $dataalarmrepairm['almp_atpcreateuser'] = session('emp_account');
            $dataalarmrepairm['almp_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $dataalarmrepairm['almp_atplastmodifyuser'] = session('emp_account');
            $dataalarmrepairm['almp_repairdetailid'] = $dat['rd_atpid'];
            $dataalarmrepairm['almp_alarmid'] = $result_alarm[$i];
            $Model_alarmrepairm->add($dataalarmrepairm);
            // 更新报警状态
            $alarm['alm_confirmstatus'] = '待接单';
            $alarm['alm_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $alarm['alm_atplastmodifyuser'] = session('emp_account');
            $where['alm_atpid'] = $result_alarm[$i];
            $Model_alarm->where($where)->save($alarm);
        }
        //添加配合人
        foreach ($rla_empid as $val) {
            $Model_repairlogassistant = M("repairlogassistant");
            $datrepairlogassistant['rla_atpid'] = $this->makeGuid();
            $datrepairlogassistant['rla_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
            $datrepairlogassistant['rla_atpcreateuser'] = session('emp_account');
            $datrepairlogassistant['rla_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $datrepairlogassistant['rla_atplastmodifyuser'] = session('emp_account');
            $datrepairlogassistant['rla_empid'] = $val;
            $datrepairlogassistant['rla_repairlogid'] = $data['rl_atpid'];
            $Model_repairlogassistant->add($datrepairlogassistant);
        }
    }
}