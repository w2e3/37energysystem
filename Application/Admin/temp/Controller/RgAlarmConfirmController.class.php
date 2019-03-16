<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgAlarmConfirmController extends BaseAuthController
{
    public function index()
    {
//        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【待确认报警】");
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $trgn_atpid);
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $sql_select = "
                select
                  t3.*,count(t.alm_atpid) alm_count
                from szny_alarm t
                left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
				";
        $sql_select = $this->buildSql($sql_select, "t.alm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.alm_confirmstatus = '待确认'");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_select = $sql_select . " group by t3.rgn_atpid";
        $sql_select = $sql_select . " order by t3.rgn_name asc";
        $Result = $Model->query($sql_select);
//        dump($Result);
        $this->assign('devicealarm',$Result);
        $this->display();
    }

    public function selectdevice()
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
                  t3.*,count(t.alm_atpid) alm_count
                from szny_alarm t
                left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
				";
        $sql_select = $this->buildSql($sql_select, "t.alm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.alm_confirmstatus = '待确认'");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_select = $sql_select . " group by t3.rgn_atpid";
        $sql_select = $sql_select . " order by t3.rgn_name asc";
        $Result = $Model->query($sql_select);
//        dump($Result);
        $this->assign('devicealarm',$Result);
        $this->display();
    }

    public function getData()
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
        $sql_select = $this->buildSql($sql_select, "t.alm_confirmstatus = '待确认'");
        $sql_count = $this->buildSql($sql_count, "t.alm_confirmstatus = '待确认'");
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
        if (null != $queryparam['dev_atpid']) {
            $searchcontent = trim($queryparam['dev_atpid']);
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

    public function deal(){
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【待确认报警】");
    }

    public function dealsubmit(){
        $Model = M('alarm');
        $data = $Model->create();
        $data['alm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['alm_atplastmodifyuser'] = session('emp_account');
        $data['alm_empid'] = session('emp_atpid');
        $data['alm_confirmstatus'] = "已确认";
        $data['alm_confirmdate'] = date('Y-m-d H:i:s', time());
        $Model->where("alm_atpid='%s'", array($data['alm_atpid']))->save($data);
    }

    public function ignore(){
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【待确认报警】");
    }

    public function ignoresubmit(){
        $Model = M('alarm');
        $data = $Model->create();
        $data['deve_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['deve_atplastmodifyuser'] = session('emp_account');
        $data['alm_empid'] = session('emp_atpid');
        $data['alm_confirmstatus'] = "已忽略";
        $data['alm_confirmdate'] = date('Y-m-d H:i:s', time());
        $Model->where("alm_atpid='%s'", array($data['alm_atpid']))->save($data);
    }

}