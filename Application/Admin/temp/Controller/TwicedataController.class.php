<?php
namespace Admin\Controller;
use Think\Controller;
class TwicedataController extends BaseController
{
    public function index()
    {   
        
        
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【二次数据管理】 / 【年数据】");
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
                $tdata['type'] = '层';
                $tdata['open'] = false;
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
        if ($_GET['jump']) {
            $this->redirect("Twicedatah/index");
        }
        $this->display();
    }
    public function edit(){
        $id = I('get.id');
        $Model=M("");
        $sql_select = "
select
  t.*,t2.rgn_name,t1.dev_code
from szny_data2year t
left join szny_device t1 on t1.dev_atpid = t.d2y_deviceid left join  szny_region t2 on t2.rgn_atpid=t.d2y_regionid where d2y_atpid= '".$id."'";
        $data2year=$Model->query($sql_select);
     if(empty($data2year['0']['d2y_atpid'])){
         $sql_select = "
select
  t.*,t2.rgn_name,t1.dev_code
from szny_data2month t
left join szny_device t1 on t1.dev_atpid = t.d2y_deviceid left join  szny_region t2 on t2.rgn_atpid=t.d2y_regionid where d2m_atpid= '".$id."'";
         $data2month=$Model->query($sql_select);
     }

        $this->display();
    }
    public function tableindex(){
        $endtime = $_GET['endtime'];
        $starttime =$_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $colwhere = "";
        if ($rgn_atpid) {
            $colwhere="and t3.etr_regionid = '$rgn_atpid'";
        }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name']."-".$parval['p_unit'];
            $dataarr['value'] = "value_".$parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime',$endtime);
        $this->assign('starttime',$starttime);
        $this->assign('arr',$arr);
        // dump($rgn_atpid);
        // print_r($arr);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }
    public function getData()
    {
        $regionid = I('get.rgn_atpid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
//       $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
//        foreach($Result_tree as $key=>$val){
//            $arr .=$val['id'].',';
//        }
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2year t
                 left join szny_device t1 on t1.dev_atpid=t.d2y_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2y_regionid
                ";

        $sql_count = "
                select
                count(1) c
                from szny_data2year t
                left join szny_device t1 on t1.dev_atpid=t.d2y_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.d2y_regionid";

        $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");

        if($regionid){
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid='$regionid'");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid ='$regionid'");
        }else{
         //   $sql_select = $this->buildSql($sql_select, "t.data_regionid in('".$arr."')");
          //  $sql_count = $this->buildSql($sql_count, "t.data_regionid  in('".$arr."')");
        }

        if($endtime && $starttime){
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt>='".$starttime."' and t.d2y_dt<='".$endtime."'");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt>='".$starttime."' and t.d2y_dt<='".$endtime."'");
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
            $sql_select = $sql_select . " order by t.d2y_atpcreatedatetime desc ";
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


        $sql_select_rel = "
select * from szny_param t where t.p_atpstatus is null
order by t.p_atpsort asc ";
        $Result_rel = $Model->query($sql_select_rel);
//        dump($Result_rel);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ("累计值" == $rmv['p_category']) {
                    $v['value_' . $rmv['p_shortname']] =
                        "累积:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "accu"] . "</font>";
                } else {
                    $v['value_' . $rmv['p_shortname']] =
                        "最小:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "min"] . "</font><br/>" .
                        "最大:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "max"] . "</font><br/>" .
                        "均值:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "avg"] . "</font><br/>";
                }
            }
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}
