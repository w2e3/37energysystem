<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends BaseAuthController {

    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【字典浏览】");
        $this->display();
    }
    public function sdindex()
    {
      $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【配置水电】");
      $this->display();
    }
    public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【字典浏览】 / 【添加】");
    }

    public function edit(){
    	$id = $_GET['id'];
        if ($id) {
            $Model = M('config');
            $data = $Model->where("cfg_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【字典浏览】 / 【编辑】");
    }



    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("config");
                foreach ($array as $id) {
                    $data = $Model->where("cfg_atpid='%s'", array($id))->find();
                    $data['cfg_atpstatus'] = 'DEL';
                    $data['cfg_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['cfg_atplastmodifyuser'] = session('emp_account');
                    $Model->where("cfg_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【字典浏览】 / 【删除】");
    }

    public function submit(){
    	$Model = M('config');
    	$data = $Model->create();
        if (null == $data['cfg_atpid']) {
		   //添加
            $data['cfg_atpid'] = $this->makeGuid();
            $data['cfg_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
            $data['cfg_atpcreateuser'] = session('emp_account');
            $data['cfg_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['cfg_atplastmodifyuser'] = session('emp_account');
            $data['cfg_atpsort'] = time();
            $Model->add($data);

        } else {
        	//修改
            $data['cfg_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['cfg_atplastmodifyuser'] = session('emp_account');
            $Model->where("cfg_atpid='%s'", array($data['cfg_atpid']))->save($data);
        }
    }


    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
    	 $type=I('get.type',null);
//    	 dump($type);
        $Model = M();
        $sql_select = "
				select
					*
				from szny_config t ";
		$sql_count = "
				select
					count(1) c
				from szny_config t ";
        $sql_select = $this->buildSql($sql_select, "t.cfg_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.cfg_atpstatus is null");
//
        if($type=='sd')
        {
          $sql_select = $this->buildSql($sql_select, "t.cfg_key in ('水价','电价')");
          $sql_count = $this->buildSql($sql_count, "t.cfg_key in ('水价','电价')");

        }
//        var_dump($sql_select);
        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.cfg_key like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.cfg_key like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.cfg_key like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.cfg_key like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.cfg_key asc ";
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
        // var_dump($Result);die;
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

   


}