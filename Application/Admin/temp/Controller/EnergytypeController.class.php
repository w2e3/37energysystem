<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class EnergytypeController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【能源类别】");
        $this->display();
    }

	public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【能源类别】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('energytype');
            $data = $Model->where("et_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【能源类别】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("energytype");
                foreach ($array as $id) {
                    $data = $Model->where("et_atpid='%s'", array($id))->find();
                    $data['et_atpstatus'] = 'DEL';
                    $data['et_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['et_atplastmodifyuser'] = session('emp_account');
                    $Model->where("et_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【能源类别】 / 【删除】");
    }

    public function submit(){
    	$Model = M('energytype');
    	$data = $Model->create();//dump($data);

        $tcondition['et_name'] = array('eq',$data['et_name']);
        $tcondition['et_atpstatus'] = array('exp', 'is null');
        $tparamnum = $Model->where($tcondition)->count();
        if($tparamnum!=0)
        {
            echo "1";
            die;
        }


        if (null == $data['et_atpid'])
        {
		   //添加
            $data['et_atpid'] = $this->makeGuid();
            $data['et_code']='GY'.date('YmdHis', time());
            $data['et_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['et_atpcreateuser'] = session('emp_account');
            $data['et_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['et_atplastmodifyuser'] = session('emp_account');
            $data['et_atpsort'] = time();

            $Model->add($data);
        } else
            {
            $data['et_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['et_atplastmodifyuser'] = session('emp_account');

            //修改
            $Model->where("et_atpid='%s'", array($data['et_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('energytype');
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
        $sql_select = $this->buildSql($sql_select, "t.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.et_atpstatus is null");


        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.et_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.et_name like '%" . $searchcontent . "%'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.et_atplastmodifydatetime desc";
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

}