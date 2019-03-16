<?php
namespace Admin\Controller;
use Think\Controller;
class PartController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【库存管理】 / 【备件管理】");
        $this->display();
    }
    public function add(){
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【库存管理】 / 【备件管理】 / 【添加】");
    }

    public function edit(){
        $id = $_GET['id'];
        if ($id) {
            $Model = M("part");
            $data = $Model->where("part_atpid='%s'",array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【库存管理】 / 【备件管理】 / 【编辑】");
    }

    public function submit()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     314572800 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $info   =   $upload->upload();

        $Model = M('part');
        $data = $Model->create();

        if (null == $data['part_atpid']) {
            $data['part_atpid'] = $this->makeGuid();
            $data['part_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
            $data['part_atpcreateuser'] = I('session.u_account', '');
            $data['part_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['part_atplastmodifyuser'] = I('session.u_account', '');
            $data['part_atpsort'] = time();
            if ($info["part_pic"]) {
                $data['part_pic'] = $info["part_pic"]["savepath"] . $info["part_pic"]["savename"];
            }

            $Model->add($data);
        } else {
            $data['part_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['part_atplastmodifyuser'] = I('session.u_account', '');
            if ($info["part_pic"]) {
                $data['part_pic'] = $info["part_pic"]["savepath"] . $info["part_pic"]["savename"];
            }
            $Model->where("part_atpid='%s'", array($data['part_atpid']))->save($data);
        }
    }

    public function del(){
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("part");
                foreach ($array as $id) {
                    $data = $Model->where("part_atpid='%s'",array($id))->find();
                    $data['part_atplastmodifydatetime'] = date('Y-m-d H:i:s',time());
                    $data['part_atplastmodifyuser'] = I('session.u_account','');
                    $data['part_atpstatus'] = 'DEL';
                    $Model->where("part_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail".$e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【库存管理】 / 【备件管理】 / 【删除】");
    }

    public function getData()
    {
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $WhereConditionArray = array();

        $sql_select = "
select
	t.*
from  szny_part t";
        $sql_count = "
select
	count(1) c
from szny_part t";
        $sql_select = $this->buildSql($sql_select, "t.part_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.part_atpstatus is null");

        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.part_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.part_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        if (null != $queryparam['sort']) {
            $sql_select = $sql_select ." order by convert(".$queryparam['sort']." using gbk )" . $queryparam['sortOrder'];
            //  $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by convert(t.part_name using gbk) desc";
        }

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



    public function handle(){
        $id = $_GET['id'];
        if ($id) {
            $Model = M("part");
            $data = $Model->where("part_atpid='%s'",array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【库存管理】 / 【备件管理】 / 【修改数目】");
    }
    public function operationsubmitdata(){
        $Model = M('');
        $Model_part = M('part');
        $part=$Model->query("select * from szny_part where part_atpid='".$_POST['part_atpid']."'");
        if($_POST['operationtype']=='1'){
            if($_POST['part_num']>=$_POST['operationnum']){
                $part['0']['part_num']= $part['0']['part_num']-$_POST['operationnum'];
                $Model_part->where("part_atpid='%s'",array($_POST['part_atpid']))->save($part['0']);
            }else{
                echo "2";
                die;
            }
        }elseif($_POST['operationtype']=='2'){
            $part['0']['part_num']= $part['0']['part_num']+$_POST['operationnum'];
            $Model_part->where("part_atpid='%s'",array($_POST['part_atpid']))->save($part['0']);
        }
    }



}