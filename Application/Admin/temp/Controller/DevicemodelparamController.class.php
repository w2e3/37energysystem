<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DevicemodelparamController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【参数配置】");
        $treedatas =[
            [
                'id'=>0,
                'pid'=>null,
                'name'=>'设备',
                'icon'=>$this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/equipment.png",
                'open'=>true,
                'type'=> '总设备',
            ],
        ];
        $Model = M();
        $sql_enenrgytype = "select * from szny_energytype t where t.et_atpstatus is null order by et_name desc";
        $data_enenrgytype = $Model->query($sql_enenrgytype);
        $sql_devicemodel = "
          select
           * 
           from szny_devicemodel t 
           left join szny_energytypemodel t3 on t3.etm_devicemodelid = t.dm_atpid
           left join szny_energytype t1 on t3.etm_energytypeid = t1.et_atpid 
           left join szny_company t2 on t.dm_companyid = t2.cpy_atpid
           where t.dm_atpstatus is null and t1.et_atpstatus is null and t2.cpy_atpstatus is null and t3.etm_atpstatus is null
           group by t.dm_atpid,t1.et_atpid
           order by t2.cpy_name desc
           ";
        $data_devicemodel = $Model->query($sql_devicemodel);//dump($data_devicemodel);
        foreach ($data_enenrgytype as $key_energytype => $value_energytype) {
            $tdata = array();
            $tdata['id'] = $value_energytype['et_atpid'];
            $tdata['pid'] = 0;
            $tdata['name'] = $value_energytype['et_name'];
            if ('电能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/elec.png";
            }elseif('水能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water.png";
            }elseif('冷能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold.png";
            }
            elseif('暖能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold.png";
            }
            else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energy.png";
            }
            $tdata['open'] =true;
            $tdata['type'] = '能源';
            array_push($treedatas, $tdata);
        }
        foreach ($data_devicemodel as $key_devicemodel => $value_devicemodel) {
           // dump($value_devive);//die();
            $tdata = array();
            $tdata['id'] = $value_devicemodel['dm_atpid'];
            $tdata['pid'] = $value_devicemodel['et_atpid'];
            $tdata['name'] = $value_devicemodel['dm_name'];
            if ('电能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
            }elseif('水能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
            }elseif('冷能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }elseif('暖能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
            }
            $tdata['type'] = '设备';
            array_push($treedatas, $tdata);
        }
//        dump($treedatas);
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }

	public function add()
    {
        $this->getDevicemodel();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【参数配置】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('devicemodelparam');
            $sql_select = "
            select 
            *
            from szny_devicemodelparam t 
            left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
			left join szny_device t2 on t2.dev_devicemodelid = t1.dm_atpid
			left join szny_region t3 on t2.dev_regionid = t3.rgn_atpid
			where t.dmp_atpstatus is null and t1.dm_atpstatus is null and t2.dev_atpstatus is null and t3.rgn_atpstatus is null and t.dmp_atpid = '$id' 
            ";
            $data = $Model->query($sql_select);
            if ($data) {
                $this->assign('data', $data[0]);
            }
        }
        $this->getDevicemodel();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【参数配置】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("devicemodelparam");
                foreach ($array as $id) {
                    $data = $Model->where("dmp_atpid='%s'", array($id))->find();
                    $data['dmp_atpstatus'] = 'DEL';
                    $data['dmp_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['dmp_atplastmodifyuser'] = session('emp_account');
                    $Model->where("dmp_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【参数配置】 / 【删除】");
    }

    public function submit()
    {
        $dm_atpid = I('post.dm_atpid');
        $Model = M('devicemodelparam');
        $data = $Model->create();
        $dmp_name = $data['dmp_shortname'];

        if (null == $data['dmp_atpid']) {
            $result = $Model->query("select count(*) c from szny_devicemodelparam where dmp_atpstatus is null and dmp_shortname = '$dmp_name' and dmp_devicemodelid = '$dm_atpid'");
            if ($result[0]['c'] > 0) {
                die('不能提交该设备已有的参数字段！');
            }
            $data['dmp_devicemodelid'] = $dm_atpid;
            $data['dmp_atpid'] = $this->makeGuid();
            $data['dmp_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
            $data['dmp_atpcreateuser'] = session('emp_account');
            $data['dmp_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $data['dmp_atplastmodifyuser'] = session('emp_account');
            $data['dmp_atpsort'] = time();
            $this->addfield($data['dmp_shortname']);
            $Model->add($data);
        } else {
            $lastdata = $Model->where("dmp_atpid='%s'", array($data['dmp_atpid']))->find();
            if ($lastdata['dmp_shortname'] != $data['dmp_shortname']) {
                $result = $Model->query("select count(*) c from szny_devicemodelparam where dmp_atpstatus is null and dmp_shortname = '$dmp_name' and dmp_devicemodelid = '$dm_atpid'");
                if ($result[0]['c'] > 0) {
                    die('不能提交该设备已有的参数字段！');
                }
            }
            $result = $Model->query("select * from szny_devicemodelparam where dmp_atpstatus is null and dmp_atpid='" . $data['dmp_atpid'] . "'");
            $data['dmp_devicemodelid'] = $dm_atpid;
            $data['dmp_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['dmp_atplastmodifyuser'] = session('emp_account');
            if ($lastdata['dmp_shortname'] != $data['dmp_shortname']) {
                $this->editfield($data['dmp_shortname'], $result['0']['dmp_shortname']);
            }
            //修改
            $Model->where("dmp_atpid='%s'", array($data['dmp_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('company');
        $sql_select = "
				select
					distinct t.*,t1.*
				from szny_devicemodelparam t 
				left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
				left join szny_energytypemodel t3 on t1.dm_atpid = t3.etm_devicemodelid
				";
		$sql_count = "
				select
					count(distinct t.dmp_atpid) c
				from szny_devicemodelparam t 
				left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
				left join szny_energytypemodel t3 on t1.dm_atpid = t3.etm_devicemodelid
				";
        $sql_select = $this->buildSql($sql_select, "t.dmp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dmp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dm_atpstatus is null");
//        $sql_select = $this->buildSql($sql_select, "t2.etm_atpstatus is null");
//        $sql_count = $this->buildSql($sql_count, "t2.etm_atpstatus is null");
//        $sql_select = $this->buildSql($sql_select, "t3.et_atpstatus is null");
//        $sql_count = $this->buildSql($sql_count, "t3.et_atpstatus is null");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.dmp_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.dmp_name like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['dm_atpid']) {
            $searchcontent = trim($queryparam['dm_atpid']);
            $content = explode(',', $searchcontent);
            if ('设备' == $content[0]) {
                $sql_select = $this->buildSql($sql_select, "t1.dm_atpid like '%" . $content[1] . "%'");
                $sql_count = $this->buildSql($sql_count, "t1.dm_atpid like '%" . $content[1] . "%'");
            } else if ('能源' == $content[0]) {
                $sql_select = $this->buildSql($sql_select, "t3.etm_energytypeid = '$content[1]'");
                $sql_count = $this->buildSql($sql_count, "t3.etm_energytypeid = '$content[1]'");
            }
        }
//        $sql_select = $sql_select . " group by t2.dev_atpid";
//        $sql_count = $sql_count . " group by t2.dev_atpid";

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.dmp_atpcreatedatetime asc";
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
//        echo $sql_select;
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
/***************************************************************************************************************/
    public function getDevicemodel(){
        $Model = M();
        $sql_select="
            select
                *
            from szny_devicemodel t
            where t.dm_atpstatus is null";
        $Result = $Model->query($sql_select);
        $this->assign('ds_devicemodel',$Result);
    }
    public function getInfoDevicemodel()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_devicemodel t
        left join szny_company t1 on t.dm_companyid = t1.cpy_atpid
        ";
        $sql_count = "
         select
        count(1) c
         from szny_devicemodel t
        left join szny_company t1 on t.dm_companyid = t1.cpy_atpid
        ";

        $sql_select = $this->buildSql($sql_select,"t.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t1.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t1.cpy_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.dm_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.dm_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by dm_atpid asc";
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

    public function getInfoRegion()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_region t
        left join szny_energytype t1 on t.rgn_energytypeid = t1.et_atpid
		left join szny_device t2 on t.rgn_deviceid = t2.dev_atpid
        ";
        $sql_count = "
        select
        count(1) c
        from szny_region t
        left join szny_energytype t1 on t.rgn_energytypeid = t1.et_atpid
		left join szny_device t2 on t.rgn_deviceid = t2.dev_atpid
        ";

        $sql_select = $this->buildSql($sql_select,"t.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.rgn_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.rgn_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by rgn_atpid asc";
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

    public function getInfoDevive()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select
		t.*,t1.*,t2.dpm_name dpm_name,t2.dpm_atpid,t3.dpm_atpid dpm_atpid1,t3.dpm_name dpm_usename,t4.*
		from szny_device t 
		left join szny_devicemodel t1 on t.dev_devicemodelid = t1.dm_atpid
		left join szny_department t2 on t.dev_departmentid = t2.dpm_atpid
		left join szny_department t3 on t.dev_usedepartmentid = t3.dpm_atpid
		left join szny_region t4 on t.dev_regionid = t4.rgn_atpid
        ";
        $sql_count = "
       select
		count(1) c
		from szny_device t 
		left join szny_devicemodel t1 on t.dev_devicemodelid = t1.dm_atpid
		left join szny_department t2 on t.dev_departmentid = t2.dpm_atpid
		left join szny_department t3 on t.dev_usedepartmentid = t3.dpm_atpid
		left join szny_region t4 on t.dev_regionid = t4.rgn_atpid
        ";

        $sql_select = $this->buildSql($sql_select, "t.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dev_atpstatus is null");
//        $sql_select = $this->buildSql($sql_select, "t.dev_status = '启用'");
//        $sql_count = $this->buildSql($sql_count, "t.dev_status = '启用'");
        $sql_select = $this->buildSql($sql_select, "t.dev_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count, "t.dev_atpid = '$id'");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.dev_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.dev_name like '%" . $searchcontent . "%'");
        }

        if (null != $queryparam['rgn_atpid']) {
            $searchcontent = trim($queryparam['rgn_atpid']);
            $sql_select = $this->buildSql($sql_select, "t.dev_regionid in (".$searchcontent.")");
            $sql_count = $this->buildSql($sql_count, "t.dev_regionid in (".$searchcontent.")");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.dev_atpid desc";
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
    function editfield($field,$editfield){
        $Model=M("");
        $Model->execute(" alter table szny_data change data_".$editfield." data_".$field." INT");
    }

    function addfield($field){
        $Model=M("");
        $Model->execute("alter table szny_data add data_".$field." INT");
    }
}