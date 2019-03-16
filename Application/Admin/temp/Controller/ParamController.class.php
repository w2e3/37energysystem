<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class ParamController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【统计参数】");
        $this->display();
    }

	public function add()
    {
        $this->getEnergyType();
        $this->getParamCategory();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【统计参数】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('param');
            $data = $Model->where("p_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
                if ($data['p_candel'] != null) {
                    $this->display("candel");
                    die;
                }
            }
        }
        $this->getEnergyType();
        $this->getParamCategory();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【统计参数】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("param");
                foreach ($array as $id) {
                    $data = $Model->where("p_atpid='%s'", array($id))->find();
                    $data['p_atpstatus'] = 'DEL';
                    $data['p_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['p_atplastmodifyuser'] = session('emp_account');
                    $Model->where("p_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【统计参数】 / 【删除】");
    }

    public function submit()
    {
        $Model=M("param");
        $data = $Model->create();

        $tcondition['p_name'] = array('eq',$data['p_name']);
        $tcondition['p_atpstatus'] = array('exp', 'is null');
        $tparamnum = $Model->where($tcondition)->count();
        if($tparamnum!=0)
        {
            echo "1";
            die;
        }

        $condition['p_shortname'] = array('eq',$data['p_shortname']);
        $condition['p_atpstatus'] = array('exp', 'is null');
        $paramnum = $Model->where($condition)->count();

        if (null == $data['p_atpid']) {
            //添加
            if ($paramnum['num'] == '0') {
                $data['p_atpid'] = $this->makeGuid();
                $data['p_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
                $data['p_atpcreateuser'] = session('emp_account');
                $data['p_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
                $data['p_atplastmodifyuser'] = session('emp_account');
                $data['p_atpsort'] = time();
                $Model->add($data);
                $this->addtablefield($data['p_shortname']);
            }else{
                echo "2";
                die;
            }
        } else {
            $param = $Model->where("p_atpid='%s'", array($data['p_atpid']))->find();
            if($param['p_shortname']!=$data['p_shortname'] && $paramnum['num'] != '0')
            {
                echo "2";
                die;
            }
            else{
                $data['p_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                $data['p_atplastmodifyuser'] = session('emp_account');
                $Model->where("p_atpid='%s'", array($data['p_atpid']))->save($data);
                $this->edittablefield($data['p_shortname'],$param['p_shortname']);
            }
        }
    }
    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('param');
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
        $sql_select = $this->buildSql($sql_select, "t.p_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.p_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.et_atpstatus is null");


        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.p_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.p_name like '%" . $searchcontent . "%'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t1.et_name desc,t.p_atplastmodifydatetime desc";
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

    public function getEnergyType()
    {
        $Model = M();
        $sql_select="
            select
                *
            from szny_energytype t
            where t.et_atpstatus is null";
        $Result = $Model->query($sql_select);
//        dump($Result);
        $this->assign('ds_energy',$Result);
    }
    public function getParamCategory()
    {
        $M = M('config');
        $data = $M->where("cfg_key='统计参数类型'")->find();
        $array = explode(',',$data['cfg_value']);
//        dump($array);
        $this->assign('ds_pcategory',$array);
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

    function edittablefield($field,$editfield){
        $Model=M("");
        //年
        //  alter table 表名称 change 字段原名称 字段新名称 字段类型 [是否允许非
        $Model->execute("alter table szny_data2year change d2y_".$editfield."avg d2y_".$field."avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2year change d2y_".$editfield."min d2y_".$field."min INT");
        $Model->execute("alter table szny_data2year change d2y_".$editfield."max d2y_".$field."max INT");
        $Model->execute("alter table szny_data2year change d2y_".$editfield."accu d2y_".$field."accu INT");
        //月
        $Model->execute("alter table szny_data2month change d2m_".$editfield."avg d2m_".$field."avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2month change d2m_".$editfield."min d2m_".$field."min INT");
        $Model->execute("alter table szny_data2month change d2m_".$editfield."max d2m_".$field."max INT");
        $Model->execute("alter table szny_data2month change d2m_".$editfield."accu d2m_".$field."accu INT");
         //日
         $Model->execute("alter table szny_data2day change d2d_".$editfield."avg d2d_".$field."avg DECIMAL(10,2)");
         $Model->execute("alter table szny_data2day change d2d_".$editfield."min d2d_".$field."min INT");
         $Model->execute("alter table szny_data2day change d2d_".$editfield."max d2d_".$field."max INT");
         $Model->execute("alter table szny_data2day change d2d_".$editfield."accu d2d_".$field."accu INT");
         //时
         $Model->execute("alter table szny_data2hour change d2h_".$editfield."avg d2h_".$field."avg DECIMAL(10,2)");
         $Model->execute("alter table szny_data2hour change d2h_".$editfield."min d2h_".$field."min INT");
         $Model->execute("alter table szny_data2hour change d2h_".$editfield."max d2h_".$field."max INT");
         $Model->execute("alter table szny_data2hour change d2h_".$editfield."accu d2h_".$field."accu INT");
         //原始数据
         //$Model->execute(" alter table szny_data change data_".$editfield." data_".$field." DECIMAL(10,2)");
    }
    function addtablefield($field)
    {
        $Model = M("");
        //年
        $Model->execute("alter table szny_data2year add d2y_" . $field . "avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2year add d2y_" . $field . "min INT");
        $Model->execute("alter table szny_data2year add d2y_" . $field . "max INT");
        $Model->execute("alter table szny_data2year add d2y_" . $field . "accu INT");
        //月
        $Model->execute("alter table szny_data2month add d2m_" . $field . "avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2month add d2m_" . $field . "min INT");
        $Model->execute("alter table szny_data2month add d2m_" . $field . "max INT");
        $Model->execute("alter table szny_data2month add d2m_" . $field . "accu INT");
        //日
        $Model->execute("alter table szny_data2day add d2d_" . $field . "avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2day add d2d_" . $field . "min INT");
        $Model->execute("alter table szny_data2day add d2d_" . $field . "max INT");
        $Model->execute("alter table szny_data2day add d2d_" . $field . "accu INT");
        //时
        $Model->execute("alter table szny_data2hour add d2h_" . $field . "avg DECIMAL(10,2)");
        $Model->execute("alter table szny_data2hour add d2h_" . $field . "min INT");
        $Model->execute("alter table szny_data2hour add d2h_" . $field . "max INT");
        $Model->execute("alter table szny_data2hour add d2h_" . $field . "accu INT");
        //原始数据
        // $Model->execute(" alter table szny_data add data_".$field." DECIMAL(10,2)");
    }

}