<?php
namespace Admin\Controller;
use Think\Controller;
class OriginaldataController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【原始数据管理】");
        $Model = M();
        $sql_select ="
        select 
        * 
        from szny_region t
        left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
        left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
        where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null
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
            $tdata['open'] = true;
            if('园区' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
                $tdata['type'] = '园区';
            }elseif ('楼' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
                $tdata['type'] = '楼';
            }elseif ('座' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
                $tdata['type'] = '座';
            }elseif ('单元' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
                $tdata['type'] = '单元';
            }elseif ('层' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
                $tdata['open'] = false;
                $tdata['type'] = '层';
            }elseif ('设备点' == $value_org['rgn_category']){
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
                $tdata['type'] = '设备点';
            }elseif ('专项能源' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/specialenergy.png";
            }elseif ('制冷机房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
            }elseif ('配电室' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
            }elseif ('充电桩' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
            }elseif ('锅炉房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
            }
            else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
            }
            array_push($treedatas, $tdata);
        }
//        dump($treedatas);
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }
    public function info(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【原始数据管理】 / 【查看】");
        $regionid = I('get.regionid');
        $Model = M();
        //取设备参数
        $colwhere = "";
        if ($regionid) {
            $colwhere="and t3.etr_regionid = '$regionid'";
        }
        $equipmentparameter = $Model->query("
                        select distinct t.dmp_name,t.dmp_shortname from szny_devicemodelparam t
                        left join szny_energytypemodel t1 on t.dmp_devicemodelid = t1.etm_devicemodelid
                        left join szny_energytyperegion t3 on t1.etm_energytypeid = t3.etr_energytypeid
                        where dmp_atpstatus is null $colwhere
                        order by t.dmp_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['dmp_name'];
            $dataarr['value'] = $parval['dmp_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('rgn_atpid',$regionid);
        $this->assign('arr',$arr);
        $this->display();
    }
    public function getInofo(){
        $id= I('get.regionid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        /*  $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
          foreach($Result_tree as $key=>$val){
             $arr .=$val['id'].',';
          }
    */
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data t
                 left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.data_regionid
                ";
        $sql_count = "
                select
                count(1) c
                from szny_data t
                left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.data_regionid";


        $sql_select = $this->buildSql($sql_select, "t.data_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.data_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        if($id){
            $sql_select = $this->buildSql($sql_select, "t.data_atpid='$id'");
            $sql_count = $this->buildSql($sql_count, "t.data_atpid ='$id'");
        }else{
            // $sql_select = $this->buildSql($sql_select, "t.data_regionid in('".$arr."')");
            //  $sql_count = $this->buildSql($sql_count, "t.data_regionid  in('".$arr."')");
        }
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t2.rgn_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t2.rgn_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }

        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.data_atpcreatedatetime asc ";
        }
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }

        $Result = $Model->query($sql_select, $WhereConditionArray);
        //  $this->assign('arr',$arr);
        $Count = $Model->query($sql_count, $WhereConditionArray);

        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));

    }
    public function tableindex()
    {
        $id = I('get.regionid');
        $endtime = $_GET['endtime'];
        $starttime =$_GET['starttime'];
        $Model = M();
        //取设备参数
        $colwhere = "";
        if ($id) {
            $colwhere="and t3.etr_regionid = '$id'";
        }
        $equipmentparameter = $Model->query("
                        select distinct t.dmp_name,t.dmp_shortname from szny_devicemodelparam t
                        left join szny_energytypemodel t1 on t.dmp_devicemodelid = t1.etm_devicemodelid
                        left join szny_energytyperegion t3 on t1.etm_energytypeid = t3.etr_energytypeid
                        where t.dmp_atpstatus is null and t1.etm_atpstatus is null and t3.etr_atpstatus is null $colwhere
                        order by t.dmp_atpcreatedatetime asc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['dmp_name'];
            $dataarr['value'] = $parval['dmp_shortname'];
            array_push($arr, $dataarr);
        }
       $otherFields=['A相电压','B相电压','C相电压','剩余金额','总购电金额','购电次数','基础金额','基础电量剩余'];

        $this->assign('rgn_atpid', $id);
        $this->assign('otherFields', $otherFields);
        $this->assign('endtime',$endtime);
        $this->assign('starttime',$starttime);
        $this->assign('arr', $arr);
        $this->display();
    }
    public function getData()
    {
        $regionid = I('get.regionid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
      /*  $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
        foreach($Result_tree as $key=>$val){
           $arr .=$val['id'].',';
        }
  */
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data t
                 left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.data_regionid
                ";
        $sql_count = "
                select
                count(1) c
                from szny_data t
                left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.data_regionid";


        $sql_select = $this->buildSql($sql_select, "t.data_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.data_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        if($regionid){
            $sql_select = $this->buildSql($sql_select, "t.data_regionid='$regionid'");
            $sql_count = $this->buildSql($sql_count, "t.data_regionid ='$regionid'");
            if (null != $queryparam['search']) {
                $searchcontent = trim($queryparam['search']);
                $sql_select = $this->buildSql($sql_select, "t2.rgn_name like '%s'");
                $sql_count = $this->buildSql($sql_count, "t2.rgn_name like '%s'");
                array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
            }

            if($endtime && $starttime){
                $sql_select = $this->buildSql($sql_select, "t.data_dt>='".$starttime."' and t.data_dt<='".$endtime."'");
                $sql_count = $this->buildSql($sql_count, "t.data_dt>='".$starttime."' and t.data_dt<='".$endtime."'");
            }else{
                $olddata=date("Y-m-d H:i:s",strtotime("-7 day"));
                $sql_select = $this->buildSql($sql_select, "t.data_dt>='".$olddata."'");
                $sql_count = $this->buildSql($sql_count, "t.data_dt>='".$olddata."'");
            }
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.data_dt desc ";
            }
            if (null != $queryparam['limit']) {

                if ('0' == $queryparam['offset']) {
                    $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
                } else {
                    $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
                }
            }

            $Result = $Model->query($sql_select, $WhereConditionArray);
            //  $this->assign('arr',$arr);
            $Count = $Model->query($sql_count, $WhereConditionArray);
        }else{
            $Result=[];
            $Count[0]['c']=0;
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }


}