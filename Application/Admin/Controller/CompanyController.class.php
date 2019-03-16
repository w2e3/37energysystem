<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class CompanyController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家管理】");
        $this->display();
    }

	public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家管理】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('company');
            $data = $Model->where("cpy_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家管理】 / 【编辑】");
    }


    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("company");
                foreach ($array as $id) {
                    $data = $Model->where("cpy_atpid='%s'", array($id))->find();
                    $data['cpy_atpstatus'] = 'DEL';
                    $data['cpy_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['cpy_atplastmodifyuser'] = session('emp_account');
                    $Model->where("cpy_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【设备管理】 / 【厂家管理】 / 【删除】");
    }


    public function submit(){
    	$Model = M('company');
    	$data = $Model->create();//dump($data);
        if (null == $data['cpy_atpid'])
        {
		   //添加
            $data['cpy_atpid'] = $this->makeGuid();
//            $data['cpy_code']='GY'.date('YmdHis', time());
            $data['cpy_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['cpy_atpcreateuser'] = session('emp_account');
            $data['cpy_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['cpy_atplastmodifyuser'] = session('emp_account');
            $data['cpy_atpsort'] = time();

            $Model->add($data);
        } else
            {
            $data['cpy_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['cpy_atplastmodifyuser'] = session('emp_account');

            //修改
            $Model->where("cpy_atpid='%s'", array($data['cpy_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('company');
        $WhereConditionArray = array();
        $sql_select = "
				select
					t.*
				from szny_company t 
				";
		$sql_count = "
				select
					count(1) c
				from szny_company t 
				";
        $sql_select = $this->buildSql($sql_select, "t.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.cpy_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.cpy_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.cpy_name like '%" . $searchcontent . "%'");
        // }
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.cpy_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.cpy_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.cpy_name desc";
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
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
}