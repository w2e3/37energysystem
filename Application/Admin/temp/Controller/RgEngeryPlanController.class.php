<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgEngeryPlanController extends BaseAuthController
{
    public function index(){
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】");
    	$rgn_atpid = I('get.rgn_atpid','');
    	$this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }

    public function add(){
        $rgn_atpid = I('get.rgn_atpid','');
        $this->getRegion($rgn_atpid);
    	$this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】 / 【添加】");
    }
    public function edit(){
        $rgn_atpid = I('get.rgn_atpid','');
        $ep_atpid = I('get.ep_atpid','');
        if ($rgn_atpid){
            $res = $this->regionrecursive($rgn_atpid);
            if ($ep_atpid) {
                $Model = M('energyplan');
                $data_ep = $Model->query("select * from szny_energyplan where ep_atpid = '$ep_atpid'");
                foreach ($res as $rk => &$rv){
                    foreach ($data_ep as $epk => $epv){
                        if ($rv['rgn_atpid'] == $epv['ep_regionid']){
                            $rv['aux_selected'] = '是';
                            break;
                        }
                    }
                }
            }
        }else{
            $Model = M();
            $sql = "select rgn_atpid from szny_region where rgn_category = '园区'";
            $result = $Model->query($sql);
            $res = $this->regionrecursive($result[0]['rgn_atpid']);
            if ($ep_atpid) {
                $Model = M('energyplan');
                $data_ep = $Model->query("select * from szny_energyplan where ep_atpid = '$ep_atpid'");
                foreach ($res as $rk => &$rv){
                    foreach ($data_ep as $epk => $epv){
                        if ($rv['rgn_atpid'] == $epv['ep_regionid']){
                            $rv['aux_selected'] = '是';
                            break;
                        }
                    }
                }
            }
        }
        $this->assign('data',$data_ep[0]);
        $this->assign('region',$res);
        $this->display("add");
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】 / 【编辑】");
    }

    public function del(){
        try {
            $ids = I('post.ids','');
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("energyplan");
                foreach ($array as $id) {
                    $data = $Model->where("ep_atpid='%s'", array($id))->find();
                    $data['ep_atpstatus'] = 'DEL';
                    $data['ep_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['ep_atplastmodifyuser'] = session('emp_account');
                    $Model->where("ep_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】 / 【删除】");
    }

    public function dell(){
        try {
            $ids = I('post.ids','');
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("energyplandetail");
                foreach ($array as $id) {
                    $data = $Model->where("epd_atpid='%s'", array($id))->find();
                    $data['epd_atpstatus'] = 'DEL';
                    $data['epd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['epd_atplastmodifyuser'] = session('emp_account');
                    $Model->where("epd_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】 / 【删除】");
    }

    public function submit(){
       $ep_name = I('post.ep_name','');
       $ep_category = I('post.ep_category','');
       $ep_startdatetime = I('post.ep_startdatetime','');
       $ep_enddatetime = I('post.ep_enddatetime','');
       $ep_regionid = I('post.ep_regionid','');
       $ep_atpid = I('post.ep_atpid','');
       $Model_energyplan = M('energyplan');
       $Model_statrel = M('statrel');
       if('' == $ep_atpid || null == $ep_atpid){
           $Model_energyplan ->startTrans();//启动事务
            $data['ep_atpid'] = $this->makeGuid();
            $data['ep_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['ep_atpcreateuser'] = session('emp_account');
            $data['ep_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['ep_atplastmodifyuser'] = session('emp_account');
            $data['ep_name'] = $ep_name;
            $data['ep_category'] = $ep_category;
            $data['ep_startdatetime'] = $ep_startdatetime;
            $data['ep_enddatetime'] = $ep_enddatetime;
            $data['ep_regionid'] = $ep_regionid;
            //添加
           $Result = $Model_energyplan->add($data);
           if(!$Result){
               $Model_energyplan->rollback();
           }
            /*****************************************/
            $data_sr['sr_atpid'] = $this->makeGuid();
            $data_sr['sr_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data_sr['sr_atpcreateuser'] = session('emp_account');
            $data_sr['sr_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data_sr['sr_atplastmodifyuser'] = session('emp_account');
            $data_sr['sr_energyplanid'] =  $data['ep_atpid'];
            $data_sr['sr_regionid'] = $ep_regionid;
           $resu = $Model_statrel->add($data_sr);
           if(!$resu){
               $Model_energyplan->rollback();
           }
           $Model_energyplan->commit();
       }else{
           $data['ep_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
           $data['ep_atplastmodifyuser'] = session('emp_account');
           $data['ep_name'] = $ep_name;
           $data['ep_category'] = $ep_category;
           $data['ep_startdatetime'] = $ep_startdatetime;
           $data['ep_enddatetime'] = $ep_enddatetime;
           $data['ep_regionid'] = $ep_regionid;
           $Model_energyplan->where("ep_atpid='%s'", array($ep_atpid))->save($data);
       }
   }


    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
    	$queryparam = json_decode(file_get_contents("php://input"), true);
    	$Model = M();
    	$sql_select = "
            select 
            * 
            from szny_energyplan t 
            left join szny_region t1 on t.ep_regionid = t1.rgn_atpid
            ";
    	$sql_count = "
          select 
          count(1) c 
          from szny_energyplan t 
          left join szny_region t1 on t.ep_regionid = t1.rgn_atpid
          ";
    	$sql_select = $this->buildSql($sql_select, "t.ep_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.ep_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpid in (".$endrgn_atpidsstrings.")");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpid in (".$endrgn_atpidsstrings.")");
        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.ep_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.ep_name like '%" . $searchcontent . "%'");
        }

        if (null != $queryparam['ep_name']) {
            $searchcontent = trim($queryparam['ep_name']);
            $sql_select = $this->buildSql($sql_select, "t.ep_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.ep_name like '%" . $searchcontent . "%'");
        }
         //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.ep_atpid desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);;
        $Count = $Model->query($sql_count);
        foreach($Result as $k => &$v){
            $ep_atpid = $v['ep_atpid'];
            $Model = M();
            $select_is_one ="select count(*) c from szny_energyplandetail t where t.epd_atpstatus is null and t.epd_energyplanid = '$ep_atpid'";
            $Result_is_one = $Model->query($select_is_one);
            $v['c'] = $Result_is_one[0]['c'];
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function isHasEnergyPlanDetail(){
        $ep_atpid = I('get.ep_atpid','');
        $Model = M();
        $sql_select ="select count(*) c from szny_energyplandetail t where t.epd_atpstatus is null and t.epd_energyplanid = '$ep_atpid'";
        $Result = $Model->query($sql_select);
        if(0 < $Result[0]['c']){echo 1;}else{echo 0;};
    }


    public function addetail(){
    	$energyplanid = I('get.epd_atpid','');
        $Model = M();
        $sql_select = "select * from szny_energyplandetail where epd_atpid = " ."'" .$energyplanid. "'";
        $data = $Model->query($sql_select);
        $this->ajaxReturn($data[0]);
    }
    public function submitdate(){
    	$Model = M('energyplandetail');
    	$data = $Model->create();
    	if( null == $data['epd_atpid']){
		   //添加
            $data['epd_atpid'] = $this->makeGuid();
            $data['epd_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['epd_atpcreateuser'] = session('emp_account');
            $data['epd_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['epd_atplastmodifyuser'] = session('emp_account');
            $data['epd_energyplanid'] = I('post.epd_energyplanid','');
            $data['epd_requiredvalue'] = I('post.epd_requiredvalue','');
            $Model->add($data);  
            echo "1";  		
    	}else{
           $data['epd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
           $data['epd_atplastmodifyuser'] = session('emp_account');
           $data['epd_atpid'] = I('post.epd_atpid','');
           $data['ep_atpid'] = I('post.epd_category','');
           $data['ep_atpid'] = I('post.epd_energyplanid','');
           $data['epd_requiredvalue'] = I('post.epd_requiredvalue','');
           $Model->where("epd_atpid='%s'", array($data['epd_atpid']))->save($data);
           echo "2";
    	}
    }
    public function submitdatedel(){
        $Model = M('energyplandetail');
        $data = $Model->create();
        if($data['epd_atpid']){
           //删除
            $where['epd_atpid'] = $data['epd_atpid'];
            $data['epd_atpstatus'] = 'DEL';
            $Model->where()->save($data);  
            echo "1";  
        }else{
            echo "2";
        }
    }

    public function view(){
    	$ep_atpid = I('get.ep_atpid');
    	$this->assign('ep_atpid',$ep_atpid);
    	$this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【能源计划】 / 【查看能源详情】");
    }

    public function getEnergyPlanInfo(){
        $ep_atpid = I('get.ep_atpid','');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
          select 
          * 
          from szny_energyplandetail t
          left join szny_energyplan t1
          on t.epd_energyplanid = t1.ep_atpid
          ";
        $sql_count = "
          select 
          count(1) c
          from szny_energyplandetail t
          left join szny_energyplan t1
          on t.epd_energyplanid = t1.ep_atpid
          ";
        $sql_select = $this->buildSql($sql_select,"t.epd_atpstatus is null");
        $sql_count = $this->buildSql($sql_count,"t.epd_atpstatus is null");
        $sql_select = $this->buildSql($sql_select,"t.epd_energyplanid = '$ep_atpid'");
        $sql_count = $this->buildSql($sql_count,"t.epd_energyplanid = '$ep_atpid'");

        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.epd_startdatetime asc";
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
    public function getRegion($rgn_atpid){
        if ($rgn_atpid){
            $res = $this->regionrecursive_orderbyrgn_name($rgn_atpid);
        }else{
            $Model = M();
            $sql = "select rgn_atpid from szny_region where rgn_category = '园区'";
            $result = $Model->query($sql);
            $res = $this->regionrecursive_orderbyrgn_name($result[0]['rgn_atpid']);
        }
        $this->assign('region',$res);
    }

}