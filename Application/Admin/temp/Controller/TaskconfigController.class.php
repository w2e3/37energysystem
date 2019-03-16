<?php
namespace Admin\Controller;
use Think\Controller;
class TaskconfigController extends BaseAuthController {

    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【系统管理】 / 【定时任务配置】");
        $this->display();
    }


    public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【系统管理】 / 【定时任务配置】 / 【添加】");
    }

    public function edit(){
    	$id = $_GET['id'];
        if ($id) {
            $Model = M('taskconfig');
            $data = $Model->where("tc_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【系统管理】 / 【定时任务配置】 / 【删除】");
    }



    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("taskconfig");
                foreach ($array as $id) {
                    $data = $Model->where("tc_atpid='%s'", array($id))->find();
                    $data['tc_atpstatus'] = 'DEL';
                    $data['tc_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['tc_atplastmodifyuser'] = session('emp_account');
                    $Model->where("tc_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【系统管理】 / 【定时任务配置】 / 【编辑】");
    }

    public function submit(){
    	$Model = M('taskconfig');
    	$data = $Model->create();
        if (null == $data['tc_atpid']) {
		   //添加
            $data['tc_atpid'] = $this->makeGuid();
            $data['tc_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
            $data['tc_atpcreateuser'] = session('emp_account');
            $data['tc_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['tc_atplastmodifyuser'] = session('emp_account');
            $data['tc_atpsort'] = time();
            $Model->add($data);

        } else {
        	//修改
            $data['tc_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['tc_atplastmodifyuser'] = session('emp_account');
            $Model->where("tc_atpid='%s'", array($data['tc_atpid']))->save($data);
        }
    }


    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					*
				from szny_taskconfig t ";
		$sql_count = "
				select
					count(1) c
				from szny_taskconfig t ";
        $sql_select = $this->buildSql($sql_select, "t.tc_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.tc_atpstatus is null");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.tc_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.tc_name like '%" . $searchcontent . "%'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.tc_name desc ";
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
        // var_dump($Result);die;
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

   


}