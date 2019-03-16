<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RoledevicemoduleController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【管辖设备】");
        $treedatas =[
            [
                'id'=>0,
                'pid'=>null,
                'name'=>'设备',
                'icon'=>$this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/equipment.png",
                'open'=>true,
                'type'=> '总设备',
            ],
        ];
        $Model = M();
        $sql_enenrgytype = "select * from szny_energytype t where t.et_atpstatus is null order by et_name desc";
        $data_enenrgytype = $Model->query($sql_enenrgytype);

        $sql_devicemodel = "
          select
           * 
           from szny_devicemodel t 
           left join szny_energytypemodel t3 on t3.etm_devicemodelid = t.dm_atpid
           left join szny_energytype t1 on t3.etm_energytypeid = t1.et_atpid 
           left join szny_company t2 on t.dm_companyid = t2.cpy_atpid
           where t.dm_atpstatus is null and t1.et_atpstatus is null and t2.cpy_atpstatus is null
           order by t2.cpy_name desc
           ";
        $data_devicemodel = $Model->query($sql_devicemodel);//dump($data_devicemodel);
        foreach ($data_enenrgytype as $key_energytype => $value_energytype) {
            $tdata = array();
            $tdata['id'] = $value_energytype['et_atpid'];
            $tdata['pid'] = 0;
            $tdata['name'] = $value_energytype['et_name'];
            if ('电能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/elec.png";
            }elseif('水能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water.png";
            }elseif('冷能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold.png";
            }elseif('暖能' == $tdata['name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold.png";
            }else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energy.png";
            }
            $tdata['open'] =true;
            $tdata['type'] = '能源';
            array_push($treedatas, $tdata);
        }
        foreach ($data_devicemodel as $key_devicemodel => $value_devicemodel) {
            $tdata = array();
            $tdata['id'] = $value_devicemodel['dm_atpid'];
            $tdata['pid'] = $value_devicemodel['et_atpid'];
            $tdata['name'] = $value_devicemodel['dm_name']."【".$value_devicemodel['cpy_name']."】";
            if ('电能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
            }elseif('水能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
            }elseif('冷能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }elseif('暖能' == $value_devicemodel['et_name']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
            }
            $tdata['type'] = '设备';
            array_push($treedatas, $tdata);
        }
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }

	public function add()
    {
        $this->getRole();
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【管辖设备】 / 【添加】");
    }

   public function edit()
    {
        $id = $_GET['id'];//dump($id);
        if ($id) {
            $Model = M('roledevicemodule');
            $sql_select = "
            select 
            * 
            from szny_roledevicemodule t 
            left join szny_role t1 on t.rdm_roleid = t1.role_atpid
            left join szny_devicemodel t2 on t.rdm_devicemodelid = t2.dm_atpid
            where t.rdm_atpstatus is null and t1.role_atpstatus is null and t2.dm_atpstatus is null 
            and t.rdm_atpid = '$id'
            ";
            $data = $Model->query($sql_select);
            if ($data) {
                $this->assign('data', $data[0]);
            }
        }
        $this->getRole();
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【管辖设备】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("roledevicemodule");
                foreach ($array as $id) {
                    $data = $Model->where("rdm_atpid='%s'", array($id))->find();
                    $data['rdm_atpstatus'] = 'DEL';
                    $data['rdm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['rdm_atplastmodifyuser'] = session('emp_account');
                    $Model->where("rdm_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理权限】 / 【管辖设备】 / 【删除】");
    }


    public function submit(){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Public/uploads/';
        $upload->savePath = '';
        $info = $upload->upload();
        $dm_atpid = I('post.dm_atpid');//dump($dm_atpid);
    	$Model = M('roledevicemodule');
    	$data = $Model->create();

        if (null == $data['rdm_atpid'])
        {
            $result = $Model->query("select count(*) c from szny_roledevicemodule where rdm_atpstatus is null and rdm_devicemodelid = '$dm_atpid' and rdm_roleid = '".$data['rdm_roleid']."'");
            if ($result[0]['c'] > 0){ die('不能提交该设备重复的角色！'); }
		   //添加
            $data['rdm_atpid'] = $this->makeGuid();
            $data['rdm_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['rdm_atpcreateuser'] = session('emp_account');
            $data['rdm_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['rdm_atplastmodifyuser'] = session('emp_account');
            $data['rdm_atpsort'] = time();

            //图片地址
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
            $data['rdm_devicemodelid'] = $dm_atpid;
            $Model->add($data);
        } else
            {
            $data['rdm_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['rdm_atplastmodifyuser'] = session('emp_account');
            if ($info["u_photo"]) {
                $data['u_photo'] = $info["u_photo"]["savepath"] . $info["u_photo"]["savename"];
            }
//            $data['rdm_devicemodelid'] = $dm_atpid;
        	//修改
            $Model->where("rdm_atpid='%s'", array($data['rdm_atpid']))->save($data);
        }
    }
    //获取所有数据
    public function getData(){
    	$queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					*
				from szny_roledevicemodule t 
				left join szny_role t1 on t.rdm_roleid = t1.role_atpid
				left join szny_devicemodel t2 on t.rdm_devicemodelid = t2.dm_atpid
				left join szny_company t3 on t2.dm_companyid = t3.cpy_atpid
				left join szny_energytypemodel t4 on t4.etm_devicemodelid = t2.dm_atpid
				 left join szny_energytype t5 on t4.etm_energytypeid = t5.et_atpid
				";
		$sql_count = "
				select
					count(1) c
				from szny_roledevicemodule t 
				left join szny_role t1 on t.rdm_roleid = t1.role_atpid
				left join szny_devicemodel t2 on t.rdm_devicemodelid = t2.dm_atpid
				left join szny_company t3 on t2.dm_companyid = t3.cpy_atpid
				left join szny_energytypemodel t4 on t4.etm_devicemodelid = t2.dm_atpid
				 left join szny_energytype t5 on t4.etm_energytypeid = t5.et_atpid
				";
        $sql_select = $this->buildSql($sql_select, "t.rdm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rdm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.role_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.role_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.cpy_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.cpy_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t4.etm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t4.etm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t5.et_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t5.et_atpstatus is null");
        //快捷搜索
        // if (null != $queryparam['search']) {
        //     $searchcontent = trim($queryparam['search']);
        //     $sql_select = $this->buildSql($sql_select, "t.rdm_name like '%" . $searchcontent . "%'");
        //     $sql_count = $this->buildSql($sql_count, "t.rdm_name like '%" . $searchcontent . "%'");
        // }
        $WhereConditionArray = array();
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.rdm_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t.rdm_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }


        if (null != $queryparam['dm_atpid']) {
            $searchcontent = trim($queryparam['dm_atpid']);
            $content = explode(',',$searchcontent);
            if ('设备' == $content[0]){
                $sql_select = $this->buildSql($sql_select, "t2.dm_atpid = '$content[1]'");
                $sql_count = $this->buildSql($sql_count, "t2.dm_atpid = '$content[1]'");
            }else if('能源'== $content[0]){
                $sql_select = $this->buildSql($sql_select, "t5.et_atpid = '$content[1]'");
                $sql_count = $this->buildSql($sql_count, "t5.et_atpid = '$content[1]'");
            }

        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.rdm_atpid desc";
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
        $Model = M('region');
        $sql_select="
            select
                *
            from szny_region t
            where t.rgn_atpstatus is null";
        $Result_region = $Model->query($sql_select);
        foreach ($Result as $k => &$v){
            $parNodes = array();
            foreach ($Result_region as $key => &$value){
                $rgn_atpid = $v['rgn_atpid'];
                $res =  $this->_getParNodeChilds($rgn_atpid,$parNodes[$key],$Model);
                $value['rgn_allname'] = implode('--',$res);
                $v['rgn_allname'] = $value['rgn_allname'];
            }
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
    private function _getParNodeChilds($id, &$arr,$mod){
        $ret = $mod->where("rgn_atpid='%s'",$id)->field('rgn_pregionid,rgn_name')->select();
        //dump($ret);die();
        if(!empty($ret[0])){
            foreach ($ret as $k => $node){
                $arr[] = $node['rgn_name'];
                $this->_getParNodeChilds($node['rgn_pregionid'], $arr, $mod);
            }
        }
        return array_reverse($arr);
    }
/******************************************************************************************/
    public function isPosition(){
        $rgn_atpid = I('post.rgn_atpid');
        $Model = M('region');
        $select_is_one = "
            select 
            *
            from szny_region t 
            where t.rgn_atpstatus is null and t.rgn_atpid = '$rgn_atpid'
            ";
        $Result = $Model->query($select_is_one);
        if ('位置点' == $Result[0]['rgn_category']){echo "1";}else{echo "0";};
    }
    public function isOne(){
        $rgn_atpid = I('post.rgn_atpid');
        //dump($rgn_atpid);
        $Model = M('region');
        $select_is_one = "
            select 
            count(1) c 
            from szny_device t 
            where t.dev_atpstatus is null and t.dev_regionid = '$rgn_atpid'
            ";
        $Result = $Model->query($select_is_one);
        //dump($Result);
        if($Result[0]['c'] > 0){echo "1";}else{ echo "0";}
    }

    public function getRole()
    {
        $Model = M('role');
        $sql_select = "
        select
        *
        from szny_role
        where role_atpstatus is null
        ";
        $Result = $Model->query($sql_select);
        //dump($Result);
        $this->assign('ds_role',$Result);
    }
}