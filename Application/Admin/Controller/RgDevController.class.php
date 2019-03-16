<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgDevController extends BaseAuthController
{
    public function index(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【设备状态】");
        $rgn_atpid = I("get.rgn_atpid","");
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }
    public function advancedsearch(){
        $rgn_atpid = I("get.rgn_atpid","");
        $Model = M();
        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $sql_select = "
                select rgn_atpid,rgn_name,rgn_category,rgn_pregionid
                from szny_region t
                ";
        $sql_select = $this->buildSql($sql_select, "t.rgn_category='层'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='锅炉房'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='图书馆'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='制冷机房'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='配电室'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='充电桩'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='邮局'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_buildstatus!='活动中心'");
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpid in (".$endrgn_atpidsstrings.")");
        $sql_select = $sql_select . " order by t.rgn_name asc";
        $list = $Model->query($sql_select);
        $this->assign("list",$list);
        $this->display();
    }
    public function getData(){
        $rgn_atpid = I("get.rgn_atpid","");
        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
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
                from szny_device t 
                join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                join szny_devicemodel t2 on t.dev_devicemodelid = t2.dm_atpid
                ";
        $sql_count = "
                select
                    count(1) c
                from szny_device t 
                join szny_region t1 on t.dev_regionid = t1.rgn_atpid
                join szny_devicemodel t2 on t.dev_devicemodelid = t2.dm_atpid
                ";

        $sql_select = $this->buildSql($sql_select, "t.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.dm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.dm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rgn_atpid in (".$endrgn_atpidsstrings.")");
        $sql_count = $this->buildSql($sql_count, "t1.rgn_atpid in (".$endrgn_atpidsstrings.")");
        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t1.rgn_name like '%".$searchcontent."%'");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_name like '%".$searchcontent."%'");
        }
        // dev_regionid:$('#rgn_atpid',parent.document).val()
        if (null != $queryparam['rgn_name'])
        {
            $rgn_name = trim($queryparam['rgn_name']);
            $sql_select = $this->buildSql($sql_select,"t1.rgn_name like '%".$rgn_name."%'");
            $sql_count = $this->buildSql($sql_count,"t1.rgn_name like '%".$rgn_name."%'");
        }
        if (null != $queryparam['dev_name'])
        {
            $dev_name = trim($queryparam['dev_name']);
            $sql_select = $this->buildSql($sql_select,"t.dev_name like '%".$dev_name."%'");
            $sql_count = $this->buildSql($sql_count,"t.dev_name like '%".$dev_name."%'");
        }
        if (null != $queryparam['dev_acquisition']){
            $dev_acquisition = trim($queryparam['dev_acquisition']);
            $sql_select = $this->buildSql($sql_select,"t.dev_acquisition like '%".$dev_acquisition."%'");
            $sql_count = $this->buildSql($sql_count,"t.dev_acquisition like '%".$dev_acquisition."%'");
        }
        if (null != $queryparam['dev_unuploadlegth']){
            $dev_unuploadlegth = trim($queryparam['dev_unuploadlegth']);
            $sql_select = $this->buildSql($sql_select,"t.dev_unuploadlegth like '%".$dev_unuploadlegth."%'");
            $sql_count = $this->buildSql($sql_count,"t.dev_unuploadlegth like '%".$dev_unuploadlegth."%'");
        }
        if (null != $queryparam['dev_lastuploadtime'])
        {
            $dev_lastuploadtime = trim($queryparam['dev_lastuploadtime']);
            $sql_select = $this->buildSql($sql_select,"t.dev_lastuploadtime <= '".$dev_lastuploadtime."'");
            $sql_count = $this->buildSql($sql_count,"t.dev_lastuploadtime <= '".$dev_lastuploadtime."'");
        }
        // $sql_select = $this->buildSql($sql_select, "t1.rgn_atpid in (".$endrgn_atpidsstrings.")");
        if (null != $queryparam['dev_regionid'])
        {
            $Model = M();
            $res1 = $this->regionrecursive($queryparam['dev_regionid']);
            foreach ($res1 as $key1 => $value1)
            {
                $date1[] = "'" . $value1['rgn_atpid'] . "'";
            }
            $endrgn_atpidsstrings1 = implode(',', $date1);
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpid in (".$endrgn_atpidsstrings1.")");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpid in (".$endrgn_atpidsstrings1.")");
        }
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t1.rgn_name asc";
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
        foreach ($Result as $k => &$v){
            //查找楼设备点所在的层
             $pregionid =$Model->query("select rgn_pregionid from szny_region where rgn_atpid='".$v['rgn_pregionid']."'");

                 $Result[$k]['pregionid']=$pregionid[0]['rgn_pregionid'];
            $dev_atpid = $v['dev_atpid'];
            $Model = M('repairdetail');
            $select_is_one = "
            select 
            count(1) c 
            from szny_repairdetail t 
            left join szny_device t1 on t.rd_deviceid = t1.dev_atpid 
            where t.rd_atpstatus is null and t1.dev_atpstatus is null and t1.dev_status = '启用' and t1.dev_atpid = '$dev_atpid'
            ";
            $Result_is_one = $Model->query($select_is_one);
            $v['c'] = $Result_is_one[0]['c'];
        }

        foreach ($Result as $key => &$value) {
           $value['rgn_path'] = substr($value['rgn_name'],0,2).'号楼'.substr($value['rgn_name'],2,2).'层';
            if(substr($value['rgn_name'],9,2) == 'CD'){
                $value['rgn_path'] = 'CD座之间连廊'.substr($value['rgn_name'],12,2).'层';
            }
            if(substr($value['rgn_name'],9,2) == 'FF'){
                $value['rgn_path'] = 'EF座之间连廊'.substr($value['rgn_name'],12,2).'层';
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function dealdev(){
        $dev_atpid = I("get.dev_atpid","");
        $this->assign('dev_atpid',$dev_atpid);
        $rgn_atpid = I("get.rgn_atpid","");
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：$this->ATPLocationName / 【处理记录】");
    }
    public function isHasRepairdetail(){
        $dev_atpid = I('get.dev_atpid','');
        $Model = M('repairdetail');
        $select_is_one = "
            select 
            count(1) c 
            from szny_repairdetail t 
            left join szny_device t1 on t.rd_deviceid = t1.dev_atpid 
            where t.rd_atpstatus is null and t1.dev_atpstatus is null and t1.dev_status = '启用' and t1.dev_atpid = '$dev_atpid'
            ";
        $Result = $Model->query($select_is_one);
        if($Result[0]['c'] > 0){echo "1";}else{ echo "0";}
    }

    public function getRepairDetailData(){
        $dev_atpid = I("get.dev_atpid","");
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
                select
                    *
                from szny_repairlog t 
                left join szny_repairdetail t1 on t1.rd_repairlogid = t.rl_atpid
                left join szny_device t2 on t1.rd_deviceid = t2.dev_atpid
                left join szny_emp t3 on t.rl_empid = t3.emp_atpid
                ";
        $sql_count = "
                select
                    count(1) c
                 from szny_repairlog t 
                left join szny_repairdetail t1 on t1.rd_repairlogid = t.rl_atpid
                left join szny_device t2 on t1.rd_deviceid = t2.dev_atpid
                left join szny_emp t3 on t.rl_empid = t3.emp_atpid
                ";
        $sql_select = $this->buildSql($sql_select, "t.rl_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.rl_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.rd_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.rd_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.dev_atpid = '$dev_atpid'");
        $sql_count = $this->buildSql($sql_count, "t2.dev_atpid = '$dev_atpid'");

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.rl_codename desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);//echo($Model->_sql());die();
        $Count = $Model->query($sql_count);

        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    /***********************************************************************/
    public function checkdev(){
        $dev_atpid = I("get.dev_atpid","");
        $this->assign('dev_atpid',$dev_atpid);
        $rgn_atpid = I("get.rgn_atpid","");
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }
}