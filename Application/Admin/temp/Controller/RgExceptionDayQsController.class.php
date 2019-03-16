<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgExceptionDayQsController extends BaseAuthController
{

    public function index(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【日报缺失】");
        $rgn_atpid = I("get.rgn_atpid","");
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }

    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('deviceexception');
        $sql_select = "
                select
                     *
                from szny_deviceexception t
                left join szny_device t1 on t.deve_deviceid = t1.dev_atpid
                left join szny_region t2 on t.deve_regionid = t2.rgn_atpid
                left join szny_emp t3 on t.deve_opempid = t3.emp_atpid
                ";
        $sql_count = "
                select
                    count(1) c
                from szny_deviceexception t
                left join szny_device t1 on t.deve_deviceid = t1.dev_atpid
                left join szny_region t2 on t.deve_regionid = t2.rgn_atpid
                left join szny_emp t3 on t.deve_opempid = t3.emp_atpid
                ";
        $sql_select = $this->buildSql($sql_select, "t.deve_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.deve_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.deve_type  = '日报缺失'");
        $sql_count = $this->buildSql($sql_count, "t.deve_type  = '日报缺失'");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpid in (".$endrgn_atpidsstrings.")");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpid in (".$endrgn_atpidsstrings.")");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t1.dev_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t1.dev_name like '%" . $searchcontent . "%'");
        }

        if (null != $queryparam['devicename']) {
            $searchcontent = trim($queryparam['devicename']);
            $sql_select = $this->buildSql($sql_select, "t1.dev_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t1.dev_name like '%" . $searchcontent . "%'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.deve_dt desc";
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

    public function deal(){
        $deve_atpid = I('get.deve_atpid','');
        $Model = M();
        $sql_select = "select * from szny_emp t where t.emp_atpstatus is null";
        $data = $Model->query($sql_select);
        $this->assign('empdata',$data);
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【日报缺失】 / 【处理时报异常】");
    }

    public function dealsubmit(){
        $Model = M('deviceexception');
        $data = $Model->create();
        $data['deve_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['deve_atplastmodifyuser'] = session('emp_account');
        $data['deve_opempid'] = session('emp_atpid');
        $data['deve_status'] = "已处理";
        $Model->where("deve_atpid='%s'", array($data['deve_atpid']))->save($data);
    }

    public function ignore(){
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【日报缺失】 / 【忽略时报异常】");
    }

    public function ignoresubmit(){
        $Model = M('deviceexception');
        $data = $Model->create();
        $data['deve_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['deve_atplastmodifyuser'] = session('emp_account');
        $data['deve_opempid'] = session('emp_atpid');
        $data['deve_status'] = "已忽略";
        $Model->where("deve_atpid='%s'", array($data['deve_atpid']))->save($data);
    }
}
