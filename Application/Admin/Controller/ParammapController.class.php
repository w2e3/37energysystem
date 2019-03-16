<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class ParammapController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【参数配置】");
        $this->display();
    }

	public function add()
    {
        $this->getParam();
        $this->getDeviceModelParam();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【参数配置]>>{添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('parammap');
            $data = $Model->where("pm_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->getParam();
        $this->getDeviceModelParam();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【参数配置]>>{编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("parammap");
                foreach ($array as $id) {
                    $data = $Model->where("pm_atpid='%s'", array($id))->find();
                    $data['pm_atpstatus'] = 'DEL';
                    $data['pm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['pm_atplastmodifyuser'] = session('emp_account');
                    $Model->where("pm_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【参数配置]>>{删除】");
    }

    public function submit(){
    	$Model = M('parammap');
    	$data = $Model->create();
        if (null == $data['pm_atpid'])
        {
		   //添加
            $data['pm_atpid'] = $this->makeGuid();
            $data['pm_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['pm_atpcreateuser'] = session('emp_account');
            $data['pm_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['pm_atplastmodifyuser'] = session('emp_account');
            $data['pm_atpsort'] = time();
            //添加
            $Model->add($data);

        } else
            {
            $data['pm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['pm_atplastmodifyuser'] = session('emp_account');

            //修改
            $Model->where("pm_atpid='%s'", array($data['pm_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('param');
        $sql_select = "
				select
					*
				from szny_parammap t 
				left join szny_param t1 on t.pm_paramid = t1.p_atpid
				left join szny_devicemodelparam t2 on t.pm_devicemodelparamid = t2.dmp_atpid
				left join szny_devicemodel t3 on t2.dmp_devicemodelid = t3.dm_atpid
				left join szny_company t4 on t3.dm_companyid = t4.cpy_atpid
				left join szny_energytype t5 on t1.p_energytypeid = t5.et_atpid
				";
		$sql_count = "
				select
					count(1) c
				from szny_parammap t 
				left join szny_param t1 on t.pm_paramid = t1.p_atpid
				left join szny_devicemodelparam t2 on t.pm_devicemodelparamid = t2.dmp_atpid
				left join szny_devicemodel t3 on t2.dmp_devicemodelid = t3.dm_atpid
				left join szny_company t4 on t3.dm_companyid = t4.cpy_atpid
				left join szny_energytype t5 on t1.p_energytypeid = t5.et_atpid
				";
        $sql_select = $this->buildSql($sql_select, "t.pm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.pm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.p_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.p_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.dmp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.dmp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t4.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t4.cpy_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t5.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t5.et_atpstatus is null");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.pm_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.pm_name like '%" . $searchcontent . "%'");
        }
//        $sql_select = $sql_select . " group by t.pm_atpid";
//        $sql_count = $sql_count . " group by t.pm_atpid";
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t4.cpy_name desc,t3.dm_name desc";
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
//        die();
//        echo $sql_count;
        $Count = $Model->query($sql_count);
//        dump($Count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
/************************************************************************************************************/
    public function getParam()
    {
        $Model = M();
        $sql_select="
            select
                *
            from szny_param t
            where t.p_atpstatus is null";
        $Result = $Model->query($sql_select);
        $this->assign('ds_param',$Result);
    }

    public function getDeviceModelParam()
    {
        $Model = M();
        $sql_select="
            select
                *
            from szny_devicemodelparam t
            left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
            left join szny_company t2 on t2.cpy_atpid = t1.dm_companyid
            where t.dmp_atpstatus is null order by t2.cpy_name desc,t1.dm_name ";
        $Result = $Model->query($sql_select);
//        dump($Result);
        $this->assign('ds_devicemodelparam',$Result);
    }
/***********************************************************************/
    public function getInfoParam()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_param t
        left join szny_energytype t1 on t.p_energytypeid = t1.et_atpid
        ";
        $sql_count = "
         select
        count(1) c
        from szny_param t
        left join szny_energytype t1 on t.p_energytypeid = t1.et_atpid
        ";

        $sql_select = $this->buildSql($sql_select,"t.p_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.p_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t1.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t1.et_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.p_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.p_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by p_name asc";
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
    public function getInfodevicemodelparam()
    {
        $id = I("get.id","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select 
        * 
        from szny_devicemodelparam t
        left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
        ";
        $sql_count = "
         select
        count(1) c
        from szny_devicemodelparam t
        left join szny_devicemodel t1 on t.dmp_devicemodelid = t1.dm_atpid
        ";

        $sql_select = $this->buildSql($sql_select,"t.dmp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.dmp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t1.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t1.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.dmp_atpid = '$id'");
        $sql_count = $this->buildSql($sql_count,"t.dmp_atpid = '$id'");

        // //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by dmp_name asc";
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
}