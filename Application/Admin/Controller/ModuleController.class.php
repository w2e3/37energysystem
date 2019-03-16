<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class ModuleController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【模块管理】");
        $this->display();
    }

	public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【模块管理>>[添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('module');
            $data = $Model->where("module_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【模块管理>>[编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("module");
                foreach ($array as $id) {
                    $data = $Model->where("module_atpid='%s'", array($id))->find();
                    $data['module_atpstatus'] = 'DEL';
                    $data['module_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['module_atplastmodifyuser'] = session('emp_account');
                    $Model->where("module_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【模块管理>>[删除】");
    }

    public function submit(){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Public/uploads/';
        $upload->savePath = '';
        $info = $upload->upload();
    	$Model = M('module');
    	$data = $Model->create();dump($data);
        if (null == $data['module_atpid'])
        {
		   //添加
            $data['module_atpid'] = $this->makeGuid();
            $data['module_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['module_atpcreateuser'] = session('emp_account');
            $data['module_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['module_atplastmodifyuser'] = session('emp_account');

            //图片地址
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }

            $Model->add($data);
        } else
            {
            $data['module_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['module_atplastmodifyuser'] = session('emp_account');
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
        	//修改
            $Model->where("module_atpid='%s'", array($data['module_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					t.*
				from szny_module t 
				";
		$sql_count = "
				select
					count(1) c
				from szny_module t 
				";
        $sql_select = $this->buildSql($sql_select, "t.module_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.module_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.module_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.module_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.module_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.module_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.module_name asc";
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
//        foreach($Result as $k => &$v){
//            $v['module_name'] = substr($v['module_name'],4);
//        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }


}