<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgRepairAddController extends BaseAuthController
{
    public function index(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【添加维修单】");
        $this->display();
    }

    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value)
        {
            $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $trgn_atpid);
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $sql_select = "
                select
                    t.*,t1.*,count(alm_atpid) alm_count
                from szny_device t 
                left join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                left join szny_alarm t2 on t2.alm_deviceid = t.dev_atpid
                left join szny_emp t3 on t2.alm_empid = t3.emp_atpid";
        $sql_count = "
                select
                    count(t2.alm_atpid) c
               from szny_device t 
                left join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                left join szny_alarm t2 on t2.alm_deviceid = t.dev_atpid
                left join szny_emp t3 on t2.alm_empid = t3.emp_atpid";
        $sql_select = $this->buildSql($sql_select, "t.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.alm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.alm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.alm_confirmstatus = '已确认'");
        $sql_count = $this->buildSql($sql_count, "t2.alm_confirmstatus = '已确认'");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpid in (".$rgn_atpidlist.")");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpid in (".$rgn_atpidlist.")");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t1.rgn_name like '%".$searchcontent."%'");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_name like '%".$searchcontent."%'");
        }
        if (null != $queryparam['dev_name']){
            $dev_name = trim($queryparam['dev_name']);
            $sql_select = $this->buildSql($sql_select,"t.dev_name like '%".$dev_name."%'");
            $sql_count = $this->buildSql($sql_count,"t.dev_name like '%".$dev_name."%'");
        }
        if (null != $queryparam['dev_acquisition']){
            $dev_acquisition = trim($queryparam['dev_acquisition']);
            $sql_select = $this->buildSql($sql_select,"t.dev_acquisition like '%".$dev_acquisition."%'");
            $sql_count = $this->buildSql($sql_count,"t.dev_acquisition like '%".$dev_acquisition."%'");
        }
        $sql_select = $sql_select . " group by t.dev_atpid";
        $sql_count = $sql_count . " group by t.dev_atpid";

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.dev_name desc";
        }
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => count($Count), 'rows' => $Result));
    }

    public function showalarm(){
        $this->display();
    }

    public function getDatashowalarm(){
        $dev_atpid = I('get.dev_atpid','');
        $Model = M();
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
                    *,count(*) c
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
        $sql_select = $this->buildSql($sql_select, "t.alm_deviceid = '".$dev_atpid."' ");
        $sql_count = $this->buildSql($sql_count, "t.alm_deviceid = '".$dev_atpid."' ");
        $sql_select = $sql_select . " order by t.alm_confirmdate asc";
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);

//        foreach ($Result as $key => &$value) {
//            $Result[$key]['rgn_path'] = substr($Result[$key]['rgn_name'],9,2).'号楼'.substr($Result[$key]['rgn_name'],12,2).'层';
//            if(substr($Result[$key]['rgn_name'],9,2) == 'CD'){
//                $Result[$key]['rgn_path'] = 'CD座之间连廊'.substr($Result[$key]['rgn_name'],12,2).'层';
//            }
//            if(substr($Result[$key]['rgn_name'],9,2) == 'FF'){
//                $Result[$key]['rgn_path'] = 'EF座之间连廊'.substr($Result[$key]['rgn_name'],12,2).'层';
//            }
//        }
        $alarmconfig_atpid = [];
        foreach ($Result as $k => $v)
        {
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

}