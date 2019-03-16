<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DevicemodelController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家设备】");
        $this->display();
    }

	public function add()
    {
        $this->getCompany();
        $this->getEnergyType();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家设备】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('devicemodel');
            $data = $Model->where("dm_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
            $this->getEnergyType($id);
        }

        $this->getCompany();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家设备】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("devicemodel");
                $Model_energytypemodel = M('energytypemodel');
                foreach ($array as $id) {
                    $data = $Model->where("dm_atpid='%s'", array($id))->find();
                    $data['dm_atpstatus'] = 'DEL';
                    $data['dm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['dm_atplastmodifyuser'] = session('emp_account');
                    $url = './Public/uploads/'.$data['dm_picture'];
                    unlink($url);
                    $data['dm_picture'] = null;
                    $Model->where("dm_atpid='%s'", $id)->save($data);
                    $Model_energytypemodel->execute("update szny_energytypemodel t set t.etm_atpstatus = 'DEL' where t.etm_devicemodelid = '".$data["dm_atpid"]."'");
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家设备】 / 【删除】");
    }

    public function submit(){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Public/uploads/';
        $upload->savePath = '';
        $info = $upload->upload();
    	$Model = M('devicemodel');
    	$Model_energytypemodel = M('energytypemodel');
    	$data = $Model->create();
    	$energytype = I('post.energytype','');
        if (null == $data['dm_atpid'])
        {
		   //添加
            $data['dm_atpid'] = $this->makeGuid();
            $data['dm_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['dm_atpcreateuser'] = session('emp_account');
            $data['dm_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['dm_atplastmodifyuser'] = session('emp_account');
            $data['dm_atpsort'] = time();
            if ($info["dm_picture"]) {
                $data['dm_picture'] = $info["dm_picture"]["savepath"] . $info["dm_picture"]["savename"];
            }
            /********************************************************************************************************************/
            $Model_energytypemodel->execute("update szny_energytypemodel t set t.etm_atpstatus = 'DEL' where t.etm_devicemodelid = '".$data["dm_atpid"]."'");
            if (null != $energytype) {
                foreach ($energytype as $ritem) {
                    $idata = array();
                    $idata['etm_atpid'] = $this->makeGuid();
                    $idata['etm_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etm_atpcreateuser'] =  session('emp_account');
                    $idata['etm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etm_atplastmodifyuser'] =  session('emp_account');
                    $idata['etm_atpsort'] = time();
                    $idata['etm_energytypeid'] = $ritem;
                    $idata['etm_devicemodelid'] = $data['dm_atpid'];
                    $Model_energytypemodel->add($idata);
                }
            }
            /********************************************************************************************************************/
            $Model->add($data);
        } else{
//            $picture = $Model->where("dm_atpid='%s'", array($data['dm_atpid']))->field('dm_picture')->find();
//            $url = './Public/uploads/'.$picture['dm_picture'];
//            unlink($url);
            $data['dm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['dm_atplastmodifyuser'] = session('emp_account');
            if ($info["dm_picture"]) {
                $data['dm_picture'] = $info["dm_picture"]["savepath"] . $info["dm_picture"]["savename"];
            }
                /********************************************************************************************************************/
                $Model_energytypemodel->execute("update szny_energytypemodel t set t.etm_atpstatus = 'DEL' where t.etm_devicemodelid = '".$data["dm_atpid"]."'");
                if (null != $energytype) {
                    foreach ($energytype as $ritem) {
                        $idata = array();
                        $idata['etm_atpid'] = $this->makeGuid();
                        $idata['etm_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                        $idata['etm_atpcreateuser'] =  session('emp_account');
                        $idata['etm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                        $idata['etm_atplastmodifyuser'] =  session('emp_account');
                        $idata['etm_atpsort'] = time();
                        $idata['etm_energytypeid'] = $ritem;
                        $idata['etm_devicemodelid'] = $data['dm_atpid'];
                        $Model_energytypemodel->add($idata);
                    }
                }
                /********************************************************************************************************************/
            //修改
            $Model->where("dm_atpid='%s'", array($data['dm_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('company');
        $Model_energytypemodel = M('energytypemodel');
        $WhereConditionArray = array();
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
        $sql_select = $this->buildSql($sql_select, "t.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.cpy_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.dm_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.dm_name like '%" . $searchcontent . "%'");
        // }
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.dm_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.dm_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t1.cpy_name desc,t.dm_name desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $Count = $Model->query($sql_count, $WhereConditionArray);
/***********************************************************************************/
        $etm_devicemodelid = [];
        foreach ($Result as $k => $v)
        {
            array_push($etm_devicemodelid, $v['dm_atpid']);
            $v['energytype'] = '';
        }

        $sql_select_rel = "
            select
                *
            from szny_energytypemodel t
            left join szny_energytype t1 on t.etm_energytypeid = t1.et_atpid
            where t.etm_atpstatus is null and t1.et_atpstatus is null and t.etm_devicemodelid in ('" . implode("','", $etm_devicemodelid) . "')
            order by t.etm_devicemodelid , t1.et_name asc ";
        $Result_rel = $Model_energytypemodel->query($sql_select_rel);
//        dump($Result_rel);die();
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['dm_atpid'] == $rmv['etm_devicemodelid']) {
                    if ($v['energytype'] != '') {
                        $v['energytype'] = $v['energytype'] . "," . $rmv['et_name'];
                    } else {
                        $v['energytype'] = $rmv['et_name'];
                    }
                }
            }
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
/**********************************************************************************************/
    public function getCompany(){
        $Model = M();
        $sql_select="
            select
                *
            from szny_company t
            where t.cpy_atpstatus is null";
        $Result = $Model->query($sql_select);
        $this->assign('ds_company',$Result);
    }

    public function getInfoCompany()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_company t
        ";
        $sql_count = "
         select
        count(1) c
        from szny_company t
        ";

        $sql_select = $this->buildSql($sql_select,"t.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.cpy_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.cpy_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.cpy_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by cpy_name asc";
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

    public function getEnergyType($dm_atpid)
    {
        $Model = M();
        $sql_select="
            select
                *
            from szny_energytype t
            where t.et_atpstatus is null";
        $Result = $Model->query($sql_select);//dump($Result);
        $sql_select_energytypemodel = "
            select
                *
            from szny_energytypemodel t
            where t.etm_atpstatus is null and t.etm_devicemodelid = '$dm_atpid'
            ";
        $Result_energytypemodel = $Model->query($sql_select_energytypemodel);
//        dump($Result_energytypemodel);
        foreach ($Result as $rk => &$rv) {
            foreach ($Result_energytypemodel as $erk => &$erv) {
                if ($rv['et_atpid'] == $erv['etm_energytypeid']) {
                    $rv['aux_selected'] = '是';
                    break;
                }
            }
        }
        $this->assign('ds_energytype',$Result);
    }

    public function getInfoEnergyType()
    {
        $id = I("get.id","");//dump($id);
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_energytype t
        ";
        $sql_count = "
         select
        count(1) c
        from szny_energytype t
        ";

        $sql_select = $this->buildSql($sql_select,"t.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.et_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.et_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.et_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by et_name asc";
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
//        echo ($Model->_sql());
//        dump($Result);
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}