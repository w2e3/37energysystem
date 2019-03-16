<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class UsersidewatchController extends BaseAuthController
{
    public function index()
    {   
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【表管理】");
            $page = "租户管理";
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【表管理】");
            $page = "业主管理";
        }
        $this->assign('bs',I("get.bs",""));
        $this->assign('id',$_GET['id']);
        $this->assign('page',$page);
        $this->display();
    }

    public function add()
    {
        $usersideid = $_GET['id'];
        $Mode = M();
        $sql_select ="select * from szny_userside where us_atpid = '$usersideid'";
        $userside = $Mode->query($sql_select);
        $this->assign('userside',$userside);
        $this->assignTree($usersideid);
        $this->display();
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【表管理】 / 【添加】");
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【表管理】 / 【添加】");
        }
    }


    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("usersideregion");
                foreach ($array as $id) {
                    $data = $Model->where("usr_atpid='%s'", array($id))->find();
                    $data['usr_atpstatus'] = 'DEL';
                    $data['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['usr_atplastmodifyuser'] = session('emp_account');
                    $Model->where("usr_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【表管理】 / 【删除】");
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【表管理】 / 【删除】");
        }
    }

    public function submit(){
        $Model = M('usersideregion');
        $data = $Model->create();
        $userid = $data['usr_usersideid'];

        $Model = M('usersideregion');
        $data = $Model->create();
        if (null == $data['usr_atpid']){
            if (null != $_POST['region']) {
                foreach ($_POST['region'] as $mitem) {
                    $idata = array();
                    $idata['usr_atpid'] = $this->makeGuid();
                    $idata['usr_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['usr_atpcreateuser'] =  session('emp_account');
                    $idata['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['usr_atplastmodifyuser'] =  session('emp_account');
                    $idata['usr_regionid'] = $mitem;
                    $idata['usr_atpsort'] = time();
                    $idata['usr_usersideid'] = $data['usr_usersideid'];
                    $Model->execute("delete from szny_usersideregion where usr_regionid = '$mitem' and usr_usersideid= '$userid' ");
                    $Model->add($idata);
                }
            }
        }else{
            $data['role_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['role_atplastmodifyuser'] = session('emp_account');
            $Model_rolemodule->execute("update szny_rolemodule t set t.rolemodule_atpstatus = 'DEL' where t.rolemodule_roleid = '".$data["role_atpid"]."'");
            if (null != $_POST['role_module']) {
                foreach ($_POST['role_module'] as $mitem) {
                    $idata = array();
                    $idata['rolemodule_atpid'] = $this->makeGuid();
                    $idata['rolemodule_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atpcreateuser'] =  session('emp_account');
                    $idata['rolemodule_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['rolemodule_atplastmodifyuser'] =  session('emp_account');
                    $idata['rolemodule_moduleid'] = $mitem;
                    $idata['rolemodule_roleid'] = $data['role_atpid'];
                    $Model->execute("delete from szny_usersideregion where usr_regionid = '$mitem' and usr_usersideid= '$userid' ");
                    $Model_rolemodule->add($idata);
                }
            }
        }
    }

    //获取所有数据
    public function getData(){
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
                select
                * 
                from szny_usersideregion t  
                left join szny_region t1 on t.usr_regionid = t1.rgn_atpid
                left join szny_userside t2 on t.usr_usersideid = t2.us_atpid  
                ";
        $sql_count = "
                select
                count(1) c
               from szny_usersideregion t  
                left join szny_region t1 on t.usr_regionid = t1.rgn_atpid
                left join szny_userside t2 on t.usr_usersideid = t2.us_atpid
                ";
        $sql_select = $this->buildSql($sql_select, "t.usr_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.usr_atpstatus is null");

        $sql_select = $this->buildSql($sql_select, "t1.rgn_category = '设备点'");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_category = '设备点'");


        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.usr_usersideid like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.usr_usersideid like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['id']) {
            $searchcontent = trim($queryparam['id']);
            $sql_select = $this->buildSql($sql_select, "t.usr_usersideid like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.usr_usersideid like '%" . $searchcontent . "%'");
        }
        // 排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.usr_usersideid desc";
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

    public function assignTree($usersideid)
    {
        $Model = M();
        $sql_select_room = "
        select 
        t.rgn_atpid
        from szny_region t 
        left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
        left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
        where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$usersideid' and t.rgn_category != '设备点'
        order by t.rgn_name asc
        ";
        $Result_select_room = $Model->query($sql_select_room);
//        dump($Result_select_room);die();
        $data_room = array();
        foreach ($Result_select_room as $rk => $rv){
            $res = $this->regionrecursive($rv['rgn_atpid']);
            foreach ($res as $k => $v){
                if ('设备点' == $v['rgn_category']){
                    array_push($data_room,$v);
                }
            }
        }
       // dump($data_room);
//        die();
        $sql_select_watch = "
            select
                *
            from szny_region t 
            left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
            left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
            where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$usersideid' and t.rgn_category = '设备点'
            order by t.rgn_name asc
            ";
//        $sql_select_watch  = $this->
        $Result_select_watch = $Model->query($sql_select_watch);
       // dump($Result_select_watch);
        foreach ($data_room as $mk => &$mv) {
            foreach ($Result_select_watch as $rmk => &$rmv) {
                if ($mv['rgn_atpid'] == $rmv['rgn_atpid']) {
                    $mv['aux_selected'] = '是';
                    break;
                }
            }
        }
//        die();

        $this->assign('treedatas',$data_room);
    }
}