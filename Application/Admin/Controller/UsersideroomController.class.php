<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class UsersideroomController extends BaseAuthController
{
    public function index()
    {   
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【房间管理】");
            $page = "租户管理";
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【房间管理】");
            $page = "业主管理";
        }
        $this->assign('id',I("get.id",""));
        $this->assign('bs',I("get.bs",""));
        $this->assign('page',$page);
        $this->display();
    }

    public function add()
    {
        $usersideid = I("get.id","");//dump($usersideid);
        $Mode = M('userside');
        $userside = $Mode->where("us_atpid='%s'", array($usersideid))->find();
        $this->assign('userside',$userside);
        $this->assignTree($usersideid);
        $this->display();
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【房间管理】 / 【添加】");
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【房间管理】 / 【添加】");
        }
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0)
            {
                $Model = M("usersideregion");
                foreach ($array as $id)
                {
//                    $data = $Model->where("usr_atpid='%s'", array($id))->find();dump($data);
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
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【房间管理】 / 【删除】");
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】 / 【房间管理】 / 【删除】");
        }
    }

    public function submit(){
        $Model = M('usersideregion');
        $data = $Model->create();
        $data['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['usr_atplastmodifyuser'] = session('emp_account');
        $userid = $data['usr_usersideid'];
        
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
                $Model->execute("delete from szny_usersideregion where usr_usersideid = '$userid' and usr_regionid = '$mitem'");
                $Model->add($idata);
            }
        }

        // if (null == $data['usr_atpid']){
        //     if (null != $_POST['region']) {
        //         foreach ($_POST['region'] as $mitem) {
        //             $idata = array();
        //             $idata['usr_atpid'] = $this->makeGuid();
        //             $idata['usr_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
        //             $idata['usr_atpcreateuser'] =  session('emp_account');
        //             $idata['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        //             $idata['usr_atplastmodifyuser'] =  session('emp_account');
        //             $idata['usr_atpsort'] =  time();
        //             $idata['usr_regionid'] = $mitem;
        //             $idata['usr_usersideid'] = $data['usr_usersideid'];
        //             $Model->execute("delete from szny_usersideregion where usr_regionid = '$mitem'");
        //             $Model->add($idata);
        //         }
        //     }
        // } else{
        //     $data['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        //     $data['usr_atplastmodifyuser'] = session('emp_account');
        //     if (null != $_POST['region']) {
        //         foreach ($_POST['usr_usersideid'] as $mitem) {
        //             $idata = array();
        //             $idata['usr_atpid'] = $this->makeGuid();
        //             $idata['usr_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
        //             $idata['usr_atpcreateuser'] =  session('emp_account');
        //             $idata['usr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        //             $idata['usr_atplastmodifyuser'] =  session('emp_account');
        //             $idata['usr_regionid'] = $_POST['region'];
        //             $idata['usr_usersideid'] = $data['usr_usersideid'];
        //             $Model->execute("delete from szny_usersideregion where usr_usersideid = '$mitem'");
        //             $Model->add($idata);
                    
        //         }
        //     }
        // }
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

        $sql_select = $this->buildSql($sql_select, "t1.rgn_category != '设备点'");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_category != '设备点'");

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

        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);

        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function assignTree($usersideid)
    {
        $bs = $_GET['bs'];
        $wherecondition = "";
        if($bs=='zh'){
            $wherecondition = " and rgn_floorstatus = '租户专区' ";
        }elseif($bs=='yz'){
            $wherecondition = " and rgn_floorstatus = '业主专区' ";
        }


        $Model = M();
        $sql_select_module = "
            select
                *
            from szny_region t
            where t.rgn_atpstatus is null and  rgn_category != '设备点' $wherecondition
            order by rgn_name asc
            ";
        $treedatas = $Model->query($sql_select_module);

        $sql_select_rolemodule = "
            select
                *
            from szny_usersideregion t
            where t.usr_atpstatus is null and t.usr_usersideid = '$usersideid' ";
        $Result_rolemodule = $Model->query($sql_select_rolemodule);//dump($Result_emprole);

        foreach ($treedatas as $mk => &$mv) {
            foreach ($Result_rolemodule as $rmk => &$rmv) {
                if ($mv['rgn_atpid'] == $rmv['usr_regionid']) {
                    $mv['aux_selected'] = '是';
                    break;
                }
            }
        }
       // var_dump($treedatas);
        $this->assign('treedatas',$treedatas);
    }


}