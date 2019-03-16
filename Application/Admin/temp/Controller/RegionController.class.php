<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RegionController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【园区管理】");
        $this->assign('treedatas',json_encode($this->makeregion()));
        $this->display();
    }

    public function regiontree()
    {
        echo json_encode($this->makeregion());
    }

    public function makeregion()
    {
        $Model = M();
        $sql_select ="
        select
        *
        from szny_region t
        left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
        left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
        where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null and t.rgn_category != '设备点'
        group by t.rgn_atpid
         order by t.rgn_name asc
        ";
        $data_org = $Model->query($sql_select);
//        dump($data_org);
        $treedatas = array();
        foreach ($data_org as $key_org => $value_org) {
            $tdata = array();
            $tdata['id'] = $value_org['rgn_atpid'];
            $tdata['pid'] = $value_org['rgn_pregionid'];
            $tdata['name'] = $value_org['rgn_name'];
//            $tdata['open'] = true;
            if('园区' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
//                $tdata['checked'] = true;
                $tdata['open'] = true;
            }elseif ('楼' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
                if ('2#' == $value_org['rgn_codename']){
                    $tdata['open'] = true;
                }
            }elseif ('座' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
            }elseif ('单元' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
            }elseif ('层' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
                $tdata['open'] = false;
            }elseif ('设备点' == $value_org['rgn_category']){
                $tdata['isHidden '] = true;
                if ('电能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
                }elseif ('水能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
                }elseif ('冷能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                }elseif ('暖能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                }
                else{
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
                }
            }elseif ('专项能源' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/specialenergy.png";
            }elseif ('制冷机房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
            }elseif ('配电室' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
            }elseif ('充电桩' == $value_org['rgn_category']){
            }elseif ('充电桩' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
            }elseif ('锅炉房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
            }
            else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
            }

            $tdata['type'] = '园区';
            array_push($treedatas, $tdata);
        }
        return $treedatas;
    }

    public function addroot()
    {
        $this->getDeviceid();
        $this->getEnergyType();
        $this->getCategory();
        $this->getBuildstatus();
        $this->getFloorstatus();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【园区管理】 / 【添加根节点】");
    }
    public function addchild()
    {
        $this->getDeviceid();
        $this->getEnergyType();
        $this->getCategory();
        $this->getBuildstatus();
        $this->getFloorstatus();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【园区管理】 / 【添加子节点】");
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($id) {
            $Model = M('region');
            $data = $Model->where("rgn_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
            $this->getEnergyType($id);
        }
        $this->getDeviceid();
        $this->getPorg();
        $this->getCategory();
        $this->getBuildstatus();
        $this->getFloorstatus();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【园区管理】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
//            $this->_deleteSubNode($ids);
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("region");
                $Model_energytyperegion = M('energytyperegion');
                foreach ($array as $id) {
                    $data = $Model->where("rgn_atpid='%s'", array($id))->find();
                    $data['rgn_atpstatus'] = 'DEL';
                    $data['rgn_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['rgn_atplastmodifyuser'] = session('emp_account');
                    $Model->where("rgn_atpid='%s'", $id)->save($data);
                    $Model_energytyperegion->execute("update szny_energytyperegion t set t.etr_atpstatus = 'DEL' where t.etr_regionid = '".$data["rgn_atpid"]."'");
//                    dump($data['rgn_pregion']);die();
                    if (null == $data['rgn_pregion']){
                        $this->_deleteSubNode($id);
                    }
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【基础数据管理】 / 【园区管理】 / 【删除】");
    }
    private  function _deleteSubNode($ids){
        $subNodes = array();
        $mod = M("region");
        $Model_energytyperegion = M('energytyperegion');
        $array = explode ( ',', $ids );
        foreach ($array as $k){
            $res = $this->_getSubNode($k,$subNodes[$k],$mod);  //dump($res);die();
            if(!empty($res[0])){
                foreach($res as $k => $nid){
                    $data = $mod->where("rgn_atpid='%s'", array($nid))->find();
                    $data['rgn_atpstatus'] = 'DEL';
                    $data['rgn_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['rgn_atplastmodifyuser'] = session('emp_account');
                    $Model_energytyperegion->execute("update szny_energytyperegion t set t.etr_atpstatus = 'DEL' where t.etr_regionid = '".$data["rgn_atpid"]."'");
                    $mod->where("rgn_atpid='%s'", $nid)->save($data);
                }
            }
        }
        return ;
    }

    private function _getSubNode($id, &$arr,$mod){
        $ret = $mod->where("rgn_pregionid='%s'",$id)->field('rgn_atpid')->select();
        if(!empty($ret[0])){
            foreach ($ret as $k => $node){
                $arr[] = $node['rgn_atpid'];
                $this->_getSubNode($node['rgn_atpid'], $arr, $mod);
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
    	$Model = M('region');
        $Model_energytyperegion = M('energytyperegion');
    	$data = $Model->create();//dump($data);
        $energytype = $energytype = I('post.energytype','');
        if (null == $data['rgn_atpid'])
        {
		   //添加
            $data['rgn_atpid'] = $this->makeGuid();
            $data['rgn_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['rgn_atpcreateuser'] = session('emp_account');
            $data['rgn_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['rgn_atplastmodifyuser'] = session('emp_account');
            $data['rgn_atpsort'] = time();

            //图片地址
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
            //外键
            if (I('post.rgn_pregionid', '') == '') {
                $data['rgn_pregionid'] = null;
            }
            /********************************************************************************************************************/
            $Model_energytyperegion->execute("update szny_energytyperegion t set t.etr_atpstatus = 'DEL' where t.etr_regionid = '".$data["rgn_atpid"]."'");
            if (null != $energytype) {
                foreach ($energytype as $ritem) {
                    $idata = array();
                    $idata['etr_atpid'] = $this->makeGuid();
                    $idata['etr_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etr_atpcreateuser'] =  session('emp_account');
                    $idata['etr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etr_atplastmodifyuser'] =  session('emp_account');
                    $idata['etr_atpsort'] = time();
                    $idata['etr_energytypeid'] = $ritem;
                    $idata['etr_regionid'] = $data['rgn_atpid'];
                    $Model_energytyperegion->add($idata);
                }
            }
            /********************************************************************************************************************/
            $Model->add($data);
        } else
            {
            $data['rgn_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['rgn_atplastmodifyuser'] = session('emp_account');
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
            //外键
            if (I('post.rgn_pregionid', '') == '') {
                $data['rgn_pregionid'] = null;
            }
//            dump($energytype);die();
            /********************************************************************************************************************/
            $Model_energytyperegion->execute("update szny_energytyperegion t set t.etr_atpstatus = 'DEL' where t.etr_regionid = '".$data["rgn_atpid"]."'");
            if (null != $energytype) {
                foreach ($energytype as $ritem) {
                    $idata = array();
                    $idata['etr_atpid'] = $this->makeGuid();
                    $idata['etr_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etr_atpcreateuser'] =  session('emp_account');
                    $idata['etr_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $idata['etr_atplastmodifyuser'] =  session('emp_account');
                    $idata['etr_atpsort'] = time();
                    $idata['etr_energytypeid'] = $ritem;
                    $idata['etr_regionid'] = $data['rgn_atpid'];
                    $Model_energytyperegion->add($idata);
                }
            }
            /********************************************************************************************************************/
        	//修改
            $Model->where("rgn_atpid='%s'", array($data['rgn_atpid']))->save($data);
        }
        if ('设备点' == $data['rgn_category']){echo 'shebeidian';}else{echo 'yuanqu';}
    }
/**************************************************************************************/
    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $Model_energytyperegion = M('energytyperegion');
        $sql_select = "
				select
					*
				from szny_region t
				";
		$sql_count = "
				select
					count(1) c
				from szny_region t
				";
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rgn_atpstatus is null");

        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.rgn_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.rgn_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.rgn_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.rgn_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }


        if (null != $queryparam['rgn_atpid']) {
            $searchcontent = trim($queryparam['rgn_atpid']);
            $Result_tree = $this->regionrecursive($searchcontent);
            $endrgn_atpidsstrings = array();
            foreach ($Result_tree as $k => $v){
                array_push($endrgn_atpidsstrings,$v['rgn_atpid']);
            }
            $endrgn_atpidsstrings = "'".implode("','",$endrgn_atpidsstrings)."'";//dump($endrgn_atpidsstrings);die();
            $sql_select = $this->buildSql($sql_select, "t.rgn_atpid in (".$endrgn_atpidsstrings.")");
            $sql_count = $this->buildSql($sql_count, "t.rgn_atpid in (".$endrgn_atpidsstrings.")");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.rgn_name asc";
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
        /***********************************************************************************/
        $etr_regionid = [];
        foreach ($Result as $k => $v)
        {
            array_push($etr_regionid, $v['rgn_atpid']);
            $v['energytype'] = '';
        }
//        dump($etr_regionid);die();
        $sql_select_rel = "
            select
                *
            from szny_energytyperegion t
            left join szny_energytype t1 on t.etr_energytypeid = t1.et_atpid
            where t.etr_atpstatus is null and t1.et_atpstatus is null and t.etr_regionid in ('" . implode("','", $etr_regionid) . "')
            order by t.etr_regionid , t1.et_name asc ";
        $Result_rel = $Model_energytyperegion->query($sql_select_rel);
//        dump($Result_rel);die();
//        dump($Result_rel);die();
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['rgn_atpid'] == $rmv['etr_regionid']) {
                    if ($v['energytype'] != '') {
                        $v['energytype'] = $v['energytype'] . "," . $rmv['et_name'];
                    } else {
                        $v['energytype'] = $rmv['et_name'];
                    }
                }
            }
        }
//        dump($Result);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
/******************************************************************************************/


    public function getPorg()
    {
        $Model =M();
        $sql_select ="select * from szny_region where rgn_atpstatus is null";
        $data_region = $Model->query($sql_select);
        $this->assign('data_region',$data_region);
    }
    public function getEnergyType($id)
    {
        $Model = M();
        $sql_select = "
        select
        *
        from szny_energytype
        where et_atpstatus is null
        ";
        $Result = $Model->query($sql_select);//dump($Result);
        $sql_select_energytyperegion = "
            select
                *
            from szny_energytyperegion t
            where t.etr_atpstatus is null and t.etr_regionid = '$id'
            ";
        $Result_energytyperegion = $Model->query($sql_select_energytyperegion);
//        dump($Result_energytypemodel);
        foreach ($Result as $rk => &$rv) {
            foreach ($Result_energytyperegion as $erk => &$erv) {
                if ($rv['et_atpid'] == $erv['etr_energytypeid']) {
                    $rv['aux_selected'] = '是';
                    break;
                }
            }
        }
//        dump($Result);
        $this->assign('ds_energytype',$Result);
    }
    public function getDeviceid()
    {
        $Model = M('device');
        $sql_select = "
        select
        *
        from szny_device
        where dev_atpstatus is null
        ";
        $Result = $Model->query($sql_select);//dump($Result);
        $this->assign('ds_device',$Result);
    }

    public function getCategory()
    {
        $M = M('config');
        $data = $M->where("cfg_key='园区类别'")->find();
        $array = explode(',',$data['cfg_value']);
        $this->assign('ds_category',$array);
    }
    public function getBuildstatus()
    {
        $M = M('config');
        $data = $M->where("cfg_key='使用类别'")->find();
        $array = explode(',',$data['cfg_value']);
        $this->assign('ds_buildstatus',$array);
    }
    public function getFloorstatus()
    {
        $M = M('config');
        $data = $M->where("cfg_key='楼宇状态'")->find();
        $array = explode(',',$data['cfg_value']);
        $this->assign('ds_floorstatus',$array);
    }


}