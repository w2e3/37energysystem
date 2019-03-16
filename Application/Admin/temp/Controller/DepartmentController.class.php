<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DepartmentController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】");
        $Model = M();
        $sql_select ="select * from szny_department where dpm_atpstatus is null order by dpm_name asc";
        $data_org = $Model->query($sql_select);
        $treedatas = array();
        foreach ($data_org as $key_org => $value_org) {
//            dump($value_org);
            $tdata = array();
            $tdata['id'] = $value_org['dpm_atpid'];
            $tdata['pid'] = $value_org['dpm_pdepartmentid'];
            $tdata['name'] = $value_org['dpm_name'];
            $tdata['open'] = true;
            if (null == $value_org['dpm_pdepartmentid']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/department.png";
            }else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/1_department.png";
            }

            $tdata['type'] = '部门';
            array_push($treedatas, $tdata);
        }
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }

	public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】 / 【添加】");
    }
    public function addroot()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】 / 【添加根节点】");
    }
    public function addchild()
    {
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】 / 【添加子节点】");
    }
   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('department');
            $data = $Model->where("dpm_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
            $this->getDepartment();
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
//            $this->_deleteSubNode($ids);
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("department");
                foreach ($array as $id) {
                    $data = $Model->where("dpm_atpid='%s'", array($id))->find();//dump($data);
                    $data['dpm_atpstatus'] = 'DEL';
                    $data['dpm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['dpm_atplastmodifyuser'] = session('emp_account');
                    $Model->where("dpm_atpid='%s'", $id)->save($data);
//                    dump($data['dpm_pregion']);die();
//                    if (null != $data['dpm_pdepartmentid']){
                        $this->_deleteSubNode($id);
//                    }
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【部门管理】 / 【删除】");
    }
    private  function _deleteSubNode($ids){
        $subNodes = array();
        $mod = M("department");
        $array = explode ( ',', $ids );
        foreach ($array as $k){
            $res = $this->_getSubNode($k,$subNodes[$k],$mod);  //dump($res);die();
            if(!empty($res[0])){
                foreach($res as $k => $nid){
                    $data = $mod->where("dpm_atpid='%s'", array($nid))->find();
                    $data['dpm_atpstatus'] = 'DEL';
                    $data['dpm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['dpm_atplastmodifyuser'] = session('emp_account');
                    $mod->where("dpm_atpid='%s'", $nid)->save($data);
                }
            }
        }
        return ;
    }

    private function _getSubNode($id, &$arr,$mod){
        $ret = $mod->where("dpm_pdepartmentid='%s'",$id)->field('dpm_atpid')->select();
        if(!empty($ret[0])){
            foreach ($ret as $k => $node){
                $arr[] = $node['dpm_atpid'];
                $this->_getSubNode($node['dpm_atpid'], $arr, $mod);
            }
        }
        return $arr;
    }


    public function submit(){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Public/uploads/';
        $upload->savePath = '';
        $info = $upload->upload();
    	$Model = M('department');
    	$data = $Model->create();
        if (null == $data['dpm_atpid'])
        {
		   //添加
            $data['dpm_atpid'] = $this->makeGuid();
            $data['dpm_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['dpm_atpcreateuser'] = session('emp_account');
            $data['dpm_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['dpm_atplastmodifyuser'] = session('emp_account');
            $data['dpm_atpsort'] = time();

            //图片地址
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
            //外键
            if (I('post.dpm_pdepartmentid', '') == '') {
                $data['dpm_pdepartmentid'] = null;
            }

            $Model->add($data);
        }else{
            $data['dpm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['dpm_atplastmodifyuser'] = session('emp_account');
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
            //外键
            if (I('post.dpm_pdepartmentid', '') == '') {
                $data['dpm_pdepartmentid'] = null;
            }

        	//修改
            $Model->where("dpm_atpid='%s'", array($data['dpm_atpid']))->save($data);
        }
    }

    /**************************************************************************************/
    private  function _checkSubNode($ids){
        $childs = array();
        $subNodes = array();
        $mod = M("department");
        $array = explode ( ',', $ids );
        foreach ($array as $k){
            $res = $this->_getSubNodeChilds($k,$subNodes[$k],$mod);
            foreach($res as $k => $nid){
                array_push($childs,$nid);
            }
        }
        array_push($childs,$ids);
        return $childs;
    }

    private function _getSubNodeChilds($id, &$arr,$mod){
        $ret = $mod->where("dpm_pdepartmentid='%s'",$id)->field('dpm_atpid')->select();
        if(!empty($ret[0])){
            foreach ($ret as $k => $node){
                $arr[] = $node['dpm_atpid'];
                $this->_getSubNodeChilds($node['dpm_atpid'], $arr, $mod);
            }
        }
        return $arr;
    }
    /**************************************************************************************/

    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					*
				from szny_department t 
				";
		$sql_count = "
				select
					count(1) c
				from szny_department t 
				";
        $sql_select = $this->buildSql($sql_select, "t.dpm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dpm_atpstatus is null");


        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.dpm_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.dpm_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.dpm_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.dpm_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        if (null != $queryparam['dpm_atpid']) {
            $searchcontent = trim($queryparam['dpm_atpid']);
            $rgn_atpids = $this->_checkSubNode($searchcontent);
            $rgn_atpidsstrings = implode("','",$rgn_atpids);
            $endrgn_atpidsstrings = "'".$rgn_atpidsstrings."'";
//            dump($endrgn_atpidsstrings);die();
            $sql_select = $this->buildSql($sql_select, "t.dpm_atpid in (".$endrgn_atpidsstrings.")");
            $sql_count = $this->buildSql($sql_count, "t.dpm_atpid in (".$endrgn_atpidsstrings.")");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.dpm_name desc";
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
/******************************************************************************************/
    public function getDepartment()
    {
        $Model =M();
        $sql_select ="select * from szny_department where dpm_atpstatus is null";
        $data_region = $Model->query($sql_select);
        $this->assign('ds_department',$data_region);
    }
}