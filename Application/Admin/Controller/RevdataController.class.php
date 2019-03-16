<?php
namespace Admin\Controller;
use Think\Controller;
class RevdataController extends BaseController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【系统管理】 / 【采集软件管理】");
        $this->display();
    }


    public function add()
    {
        $this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【系统管理】 / 【采集软件管理】 / 【添加】");
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('revdata');
            $data = $Model->where("revd_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【系统管理】 / 【采集软件管理】 / 【编辑】");
    }


    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("revdata");
                foreach ($array as $id) {
                    $data = $Model->where("revd_atpid='%s'", array($id))->find();
                    $data['revd_atpstatus'] = 'DEL';
                    $data['revd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['revd_atplastmodifyuser'] = session('emp_account');
                    $Model->where("revd_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【系统管理】 / 【采集软件管理】 / 【删除】");
    }

    public function submit()
    {
        $Model = M('revdata');
        $data = $Model->create();
        if (null == $data['revd_atpid']) {
            //添加
            $data['revd_atpid'] = $this->makeGuid();
            $data['revd_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
            $data['revd_atpcreateuser'] = session('emp_account');
            $data['revd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['revd_atplastmodifyuser'] = session('emp_account');
            $data['revd_atpsort'] = time();
            $Model->add($data);

        } else {
            //修改
            $data['revd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['revd_atplastmodifyuser'] = session('emp_account');
            $Model->where("revd_atpid='%s'", array($data['revd_atpid']))->save($data);
        }
    }


    public function getData()
    {
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					*
				from szny_revdata t ";
        $sql_count = "
				select
					count(1) c
				from szny_revdata t ";
        $sql_select = $this->buildSql($sql_select, "t.revd_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.revd_atpstatus is null");

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.revd_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.revd_name like '%" . $searchcontent . "%'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.revd_name desc ";
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


    public function sendplc()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('revdata');
            $data = $Model->where("revd_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->getDeviceData();
        $this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【系统管理】 / 【采集软件管理】 / 【命令下发】");
    }

    public function sendplcsubmit()
    {
        $Model = M('revdatamsg');
        $datamsg = array();
        $datamsg['functionId'] = $_POST['functionId'];
        $datamsg['collectionId'] = $_POST['collectionId'];
        $datamsg['frequency'] = $_POST['frequency'];
        $datamsg['serverIP'] = $_POST['serverIP'];
        $datamsg['serverPort'] = $_POST['serverPort'];
        $datamsg['gateIP'] = $_POST['gateIP'];
        $datamsg['maskIP'] = $_POST['maskIP'];
        $datamsg['collectionIP'] = $_POST['collectionIP'];

        $data = array();
        $data['revdm_atpid'] = $this->makeGuid();
        $data['revdm_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
        $data['revdm_atpcreateuser'] = session('emp_account');
        $data['revdm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['revdm_atplastmodifyuser'] = session('emp_account');
        $data['revdm_atpsort'] = time();
        $data['revdm_revdataid'] = $_POST['revd_atpid'];
        $data['revdm_dt'] = date('Y-m-d H:i:s', time());
        $data['revdm_targetip'] = $_POST['revd_ip'];
        $data['revdm_targetport'] = $_POST['revd_port'];
        $data['revdm_msg'] = json_encode($datamsg);
        $data['revdm_retmsg'] = "";
        $data['revdm_status'] = "发送中";
        $Model->add($data);

        $url = "http://" . $_POST['revd_ip'] . ":" . $_POST['revd_port'];
        $result = $this->https_request($url, json_encode($datamsg));
//        发报
//        {
//            "functionId" : "123",
//            "collectionId" : "123",
//            "frequency" : 2,   #说明，单位分钟，为整数
//            "serverIP" : "10.0.0.200",
//            "serverPort" : 5678,
//            "gateIP" : "10.0.0.1",
//            "maskIP" : "255.255.255.0",
//            "collectionIP" : "10.0.0.152"
//        }
//
//        返回
//        {
//            errorNO : 0,
//            errorMsg : "error to modify!",
//            data : {
//            collectionId : "123",
//                functionId : "11",
//                gateIP : "10.0.0.1",
//                maskIP : "255.255.255.0",
//                collectionIP : "10.0.0.152"
//            }
//        }
        if($result!="")
        {
            $data['revdm_status'] = "已应答";
            $data['revdm_retmsg'] = $result;
            $Model->where("revdm_atpid='%s'", array($data['revdm_atpid']))->save($data);
        }
        else
        {
            $data['revdm_status'] = "未应答";
            $data['revdm_retmsg'] = $result;
            $Model->where("revdm_atpid='%s'", array($data['revdm_atpid']))->save($data);
        }
        echo "应答报文:" . $result;
    }

    public function getDeviceData()
    {
        $Model = M();
        $WhereConditionArray = array();
        $sql_select = "
select
	distinct t.dev_acquisition
from szny_device t
where t.dev_status = '启用' and t.dev_atpstatus is null
order by t.dev_acquisition";
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $this->assign('DeviceData', $Result);
    }

    //==================================================================
    //函数名：https_request
    //作者：yuxiang
    //日期：20160831
    //功能：该方法为用户发送post/get请求数据，为公共方法
    //输入参数：
    //返回值：返回请求结果集：xml/json
    // 修改记录：
    //==================================================================
    function https_request($url, $data = null)
    {
        $ch = curl_init();
        $res = curl_setopt($ch, CURLOPT_URL, $url);
//        $res2= curl_setopt ($ch, CURLOPT_PORT,$port);
        //var_dump($res);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result == NULL) {
            return "";
        }
        return $result;
    }

}